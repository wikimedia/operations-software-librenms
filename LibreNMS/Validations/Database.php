<?php
/**
 * Database.php
 *
 * Checks the database for errors
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package    LibreNMS
 * @link       http://librenms.org
 * @copyright  2017 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

namespace LibreNMS\Validations;

use LibreNMS\Config;
use LibreNMS\Interfaces\ValidationGroup;
use LibreNMS\ValidationResult;
use LibreNMS\Validator;
use Symfony\Component\Yaml\Yaml;

class Database implements ValidationGroup
{
    public function validate(Validator $validator)
    {
        if (!dbIsConnected()) {
            return;
        }

        $this->checkMode($validator);

        // check database schema version
        $current = get_db_schema();

        $schemas = get_schema_list();
        end($schemas);
        $latest = key($schemas);

        if ($current < $latest) {
            $validator->fail(
                "Your database schema ($current) is older than the latest ($latest).",
                "Manually run ./daily.sh, and check for any errors."
            );
            return;
        } elseif ($current > $latest) {
            $validator->warn("Your schema ($current) is newer than than expected ($latest).  If you just switch to the stable release from the daily release, your database is in between releases and this will be resolved with the next release.");
        }

        $this->checkCollation($validator);
        $this->checkSchema($validator);
    }

    private function checkMode(Validator $validator)
    {
        // Test for MySQL Strict mode
        $strict_mode = dbFetchCell("SELECT @@global.sql_mode");
        if (str_contains($strict_mode, 'STRICT_TRANS_TABLES')) {
            //FIXME - Come back to this once other MySQL modes are fixed
            //$valid->fail('You have MySQL STRICT_TRANS_TABLES enabled, please disable this until full support has been added: https://dev.mysql.com/doc/refman/5.0/en/sql-mode.html');
        }

        // Test for lower case table name support
        $lc_mode = dbFetchCell("SELECT @@global.lower_case_table_names");
        if ($lc_mode != 0) {
            $validator->fail(
                'You have lower_case_table_names set to 1 or true in mysql config.',
                'Set lower_case_table_names=0 in your mysql config file in the [mysqld] section.'
            );
        }

        if (empty($strict_mode) === false) {
            $validator->fail(
                "You have not set sql_mode='' in your mysql config.",
                "Set sql-mode='' in your mysql config file in the [mysqld] section."
            );
        }
    }

    private function checkCollation(Validator $validator)
    {
        // Test for correct character set and collation
        $db_collation_sql = "SELECT DEFAULT_CHARACTER_SET_NAME, DEFAULT_COLLATION_NAME 
            FROM information_schema.SCHEMATA S 
            WHERE schema_name = '" . Config::get('db_name') .
            "' AND  ( DEFAULT_CHARACTER_SET_NAME != 'utf8' OR DEFAULT_COLLATION_NAME != 'utf8_unicode_ci')";
        $collation = dbFetchRows($db_collation_sql);
        if (empty($collation) !== true) {
            $validator->fail(
                'MySQL Database collation is wrong: ' . implode(' ', $collation[0]),
                'Check https://t.libren.ms/-zdwk for info on how to fix.'
            );
        }

        $table_collation_sql = "SELECT T.TABLE_NAME, C.CHARACTER_SET_NAME, C.COLLATION_NAME 
            FROM information_schema.TABLES AS T, information_schema.COLLATION_CHARACTER_SET_APPLICABILITY AS C 
            WHERE C.collation_name = T.table_collation AND T.table_schema = '" . Config::get('db_name') .
            "' AND  ( C.CHARACTER_SET_NAME != 'utf8' OR C.COLLATION_NAME != 'utf8_unicode_ci' );";
        $collation_tables = dbFetchRows($table_collation_sql);
        if (empty($collation_tables) !== true) {
            $result = ValidationResult::fail('MySQL tables collation is wrong: ')
                ->setFix('Check http://bit.ly/2lAG9H8 for info on how to fix.')
                ->setList('Tables', $collation_tables);
            $validator->result($result);
        }

        $column_collation_sql = "SELECT TABLE_NAME, COLUMN_NAME, CHARACTER_SET_NAME, COLLATION_NAME 
FROM information_schema.COLUMNS  WHERE TABLE_SCHEMA = '" . Config::get('db_name') .
            "'  AND  ( CHARACTER_SET_NAME != 'utf8' OR COLLATION_NAME != 'utf8_unicode_ci' );";
        $collation_columns = dbFetchRows($column_collation_sql);
        if (empty($collation_columns) !== true) {
            $result = ValidationResult::fail('MySQL column collation is wrong: ')
                ->setFix('Check https://t.libren.ms/-zdwk for info on how to fix.')
                ->setList('Columns', $collation_columns);
            $validator->result($result);
        }
    }

    private function checkSchema(Validator $validator)
    {
        $schema_file = Config::get('install_dir') . '/misc/db_schema.yaml';

        if (!is_file($schema_file)) {
            $validator->warn("We haven't detected the db_schema.yaml file");
            return;
        }

        $master_schema = Yaml::parse(file_get_contents($schema_file));
        $current_schema = dump_db_schema();
        $schema_update = array();

        foreach ((array)$master_schema as $table => $data) {
            if (empty($current_schema[$table])) {
                $validator->fail("Database: missing table ($table)");
                $schema_update[] = $this->addTableSql($table, $data);
            } else {
                $current_columns = array_reduce($current_schema[$table]['Columns'], function ($array, $item) {
                    $array[$item['Field']] = $item;
                    return $array;
                }, array());

                foreach ($data['Columns'] as $index => $cdata) {
                    $column = $cdata['Field'];
                    if (empty($current_columns[$column])) {
                        $validator->fail("Database: missing column ($table/$column)");
                        $schema_update[] = $this->addColumnSql($table, $cdata, $data['Columns'][$index - 1]['Field']);
                    } elseif ($cdata !== $current_columns[$column]) {
                        $validator->fail("Database: incorrect column ($table/$column)");
                        $schema_update[] = $this->updateTableSql($table, $column, $cdata);
                    }

                    unset($current_columns[$column]); // remove checked columns
                }

                foreach ($current_columns as $column => $_unused) {
                    $validator->fail("Database: extra column ($table/$column)");
                    $schema_update[] = $this->dropColumnSql($table, $column);
                }

                if (isset($data['Indexes'])) {
                    foreach ($data['Indexes'] as $name => $index) {
                        if (empty($current_schema[$table]['Indexes'][$name])) {
                            $validator->fail("Database: missing index ($table/$name)");
                            $schema_update[] = $this->addIndexSql($table, $index);
                        } elseif ($index != $current_schema[$table]['Indexes'][$name]) {
                            $validator->fail("Database: incorrect index ($table/$name)");
                            $schema_update[] = $this->updateIndexSql($table, $name, $index);
                        }

                        unset($current_schema[$table]['Indexes'][$name]);
                    }
                }

                if (isset($current_schema[$table]['Indexes'])) {
                    foreach ($current_schema[$table]['Indexes'] as $name => $_unused) {
                        $validator->fail("Database: extra index ($table/$name)");
                        $schema_update[] = $this->dropIndexSql($table, $name);
                    }
                }
            }

            unset($current_schema[$table]); // remove checked tables
        }

        foreach ($current_schema as $table => $data) {
            $validator->fail("Database: extra table ($table)");
            $schema_update[] = $this->dropTableSql($table);
        }

        if (empty($schema_update)) {
            $validator->ok('Database schema correct');
        } else {
            $result = ValidationResult::fail("We have detected that your database schema may be wrong, please report the following to us on IRC or the community site (https://t.libren.ms/5gscd):")
                ->setFix('Run the following SQL statements to fix.')
                ->setList('SQL Statements', $schema_update);
            $validator->result($result);
        }
    }

    private function addTableSql($table, $table_schema)
    {
        $columns = array_map(array($this, 'columnToSql'), $table_schema['Columns']);
        $indexes = array_map(array($this, 'indexToSql'), $table_schema['Indexes']);

        $def = implode(', ', array_merge(array_values($columns), array_values($indexes)));

        return "CREATE TABLE `$table` ($def);";
    }

    private function addColumnSql($table, $schema, $previous_column)
    {
        $sql = "ALTER TABLE `$table` ADD " . $this->columnToSql($schema);
        if (!empty($previous_column)) {
            $sql .= " AFTER `$previous_column`";
        }
        return $sql . ';';
    }

    private function updateTableSql($table, $column, $column_schema)
    {
        return "ALTER TABLE `$table` CHANGE `$column` " . $this->columnToSql($column_schema) . ';';
    }

    private function dropColumnSql($table, $column)
    {
        return "ALTER TABLE `$table` DROP `$column`;";
    }

    private function addIndexSql($table, $index_schema)
    {
        return "ALTER TABLE `$table` ADD " . $this->indexToSql($index_schema) . ';';
    }

    private function updateIndexSql($table, $name, $index_schema)
    {
        return "ALTER TABLE `$table` DROP INDEX `$name`, " . $this->indexToSql($index_schema) . ';';
    }

    private function dropIndexSql($table, $name)
    {
        return "ALTER TABLE `$table` DROP INDEX `$name`;";
    }

    private function dropTableSql($table)
    {
        return "DROP TABLE `$table`;";
    }

    /**
     * Generate an SQL segment to create the column based on data from dump_db_schema()
     *
     * @param array $column_data The array of data for the column
     * @return string sql fragment, for example: "`ix_id` int(10) unsigned NOT NULL"
     */
    private function columnToSql($column_data)
    {
        if ($column_data['Extra'] == 'on update current_timestamp()') {
            $extra = 'on update CURRENT_TIMESTAMP';
        } else {
            $extra = $column_data['Extra'];
        }

        $null = $column_data['Null'] ? 'NULL' : 'NOT NULL';

        if (!isset($column_data['Default'])) {
            $default = '';
        } elseif ($column_data['Default'] === 'CURRENT_TIMESTAMP') {
            $default = 'DEFAULT CURRENT_TIMESTAMP';
        } elseif ($column_data['Default'] == 'NULL') {
            $default = 'DEFAULT NULL';
        } else {
            $default = "DEFAULT '${column_data['Default']}'";
        }

        return trim("`${column_data['Field']}` ${column_data['Type']} $null $default $extra");
    }

    /**
     * Generate an SQL segment to create the index based on data from dump_db_schema()
     *
     * @param array $index_data The array of data for the index
     * @return string sql fragment, for example: "PRIMARY KEY (`device_id`)"
     */
    private function indexToSql($index_data)
    {
        if ($index_data['Name'] == 'PRIMARY') {
            $index = 'PRIMARY KEY (%s)';
        } elseif ($index_data['Unique']) {
            $index = "UNIQUE `{$index_data['Name']}` (%s)";
        } else {
            $index = "INDEX `{$index_data['Name']}` (%s)";
        }

        $columns = implode(',', array_map(function ($col) {
            return "`$col`";
        }, $index_data['Columns']));

        return sprintf($index, $columns);
    }

    /**
     * Returns if this test should be run by default or not.
     *
     * @return bool
     */
    public function isDefault()
    {
        return true;
    }
}
