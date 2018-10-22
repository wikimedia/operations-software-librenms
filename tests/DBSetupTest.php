<?php
/**
 * DBSetup.php
 *
 * -Description-
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
 * @copyright  2017 Neil Lathwood
 * @author     Neil Lathwood <librenms+n@laf.io>
 */

namespace LibreNMS\Tests;

use PHPUnit_Framework_ExpectationFailedException as PHPUnitException;

class DBSetupTest extends DBTestCase
{
    public function testSetupDB()
    {
        global $schema;
        foreach ($schema as $output) {
            if (preg_match('/([1-9]+) errors/', $output) || preg_match('/Cannot execute query/', $output)) {
                throw new PHPUnitException("Errors loading DB Schema: " . $output);
            }
        }
    }

    public function testSchemaFiles()
    {
        global $config;
        $files = glob($config['install_dir'].'/sql-schema/*.sql');

        foreach ($files as $file) {
            $content = file_get_contents($file);

            foreach (explode("\n", $content) as $line) {
                // skip comments and empty lines
                if (empty($line) || starts_with($line, array('#', '--'))) {
                    continue;
                }

                // each line must end with ;, prevents multiline and makes sql easy to run by hand
                // Warning may include whitespace such as space and \r
                if (!ends_with($line, ';')) {
                    throw new PHPUnitException("Each line must end with a semicolin (;)\n$file: $line");
                }

                // cannot assume user use the librenms database name
                if (str_contains($line, 'librenms')) {
                    throw new PHPUnitException("Do not include the database name in schema files\n$file: $line");
                }
            }
        }
    }

    public function testSchema()
    {
        $schema = get_db_schema();
        $this->assertGreaterThan(0, $schema, "Database has no schema!");
        $this->assertTrue(db_schema_is_current(), "Schema not fully up-to-date, at $schema");
    }

    public function testCheckDBCollation()
    {
        global $config;

        $collation = dbFetchRows("SELECT DEFAULT_CHARACTER_SET_NAME, DEFAULT_COLLATION_NAME FROM information_schema.SCHEMATA S WHERE schema_name = '" . $config['db_name'] . "' AND  ( DEFAULT_CHARACTER_SET_NAME != 'utf8' OR DEFAULT_COLLATION_NAME != 'utf8_unicode_ci')");
        if (isset($collation[0])) {
            $error = implode(' ', $collation[0]);
        } else {
            $error = '';
        }
        $this->assertEmpty($collation, 'Wrong Database Collation or Character set: ' . $error);
    }

    public function testCheckTableCollation()
    {
        global $config;

        $collation = dbFetchRows("SELECT T.TABLE_NAME, C.CHARACTER_SET_NAME, C.COLLATION_NAME FROM information_schema.TABLES AS T, information_schema.COLLATION_CHARACTER_SET_APPLICABILITY AS C WHERE C.collation_name = T.table_collation AND T.table_schema = '" . $config['db_name'] . "' AND  ( C.CHARACTER_SET_NAME != 'utf8' OR C.COLLATION_NAME != 'utf8_unicode_ci' );");
        $error = '';
        foreach ($collation as $id => $data) {
            $error .= implode(' ', $data) . PHP_EOL;
        }
        $this->assertEmpty($collation, 'Wrong Table Collation or Character set: ' . $error);
    }

    public function testCheckColumnCollation()
    {
        global $config;

        $collation = dbFetchRows("SELECT TABLE_NAME, COLUMN_NAME, CHARACTER_SET_NAME, COLLATION_NAME FROM information_schema.COLUMNS  WHERE TABLE_SCHEMA = '" . $config['db_name'] . "'  AND  ( CHARACTER_SET_NAME != 'utf8' OR COLLATION_NAME != 'utf8_unicode_ci' );");
        $error = '';
        foreach ($collation as $id => $data) {
            $error .= implode(' ', $data) . PHP_EOL;
        }
        $this->assertEmpty($collation, 'Wrong Column Collation or Character set: ' . $error);
    }

    public function testSqlMode()
    {
        global $sql_mode;
        $this->assertNotNull($sql_mode, 'Query to save SQL Mode in bootstrap.php failed');

        // sql_mode can only be set by users with access
        $access = array(
            'GRANT ALL PRIVILEGES ON *.*',
            'SUPER'
        );

        if (str_contains(join(PHP_EOL, dbFetchColumn('SHOW GRANTS')), $access)) {
            $this->assertEquals(
                array('ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION'),
                dbFetchColumn("SELECT @@global.sql_mode")
            );
        }
    }

    public function testValidateSchema()
    {
        if (is_file('misc/db_schema.yaml')) {
            $master_schema = \Symfony\Component\Yaml\Yaml::parse(
                file_get_contents('misc/db_schema.yaml')
            );

            $current_schema = dump_db_schema();

            $message = "Schema does not match the excpected schema defined by misc/db_schema.yaml\n";
            $message .= "If you have changed the schema, make sure you update it with ./scripts/build-schema.php\n";

            $this->assertEquals($master_schema, $current_schema, $message);
        }
    }
}
