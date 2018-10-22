<?php
/*
 * Copyright (C) 2015 Daniel Preussker <f0o@devilcode.org>
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
 */

/**
 * Device-Grouping
 * @author Daniel Preussker <f0o@devilcode.org>
 * @author Tony Murray <murrayotony@gmail.com>
 * @copyright 2016 f0o, murrant, LibreNMS
 * @license GPL
 * @package LibreNMS
 * @subpackage Devices
 */

/**
 * Add a new device group
 * @param $pattern
 * @param $name
 * @param $desc
 * @return int|string
 */
function AddDeviceGroup($name, $desc, $pattern)
{
    $group_id = dbInsert(array('name' => $name, 'desc' => $desc, 'pattern' => $pattern), 'device_groups');
    if ($group_id) {
        UpdateDeviceGroup($group_id);
    }
    return $group_id;
}

/**
 * Update a device group
 * @param $group_id
 * @param $pattern
 * @param $name
 * @param $desc
 * @return bool
 */
function EditDeviceGroup($group_id, $name = null, $desc = null, $pattern = null)
{
    $vars = array();
    if (!is_null($name)) {
        $vars['name'] = $name;
    }
    if (!is_null($desc)) {
        $vars['desc'] = $desc;
    }
    if (!is_null($pattern)) {
        $vars['pattern'] = $pattern;
    }

    $success = dbUpdate($vars, 'device_groups', 'id=?', array($group_id)) >= 0;

    if ($success) {
        UpdateDeviceGroup($group_id);
    }
    return $success;
}

/**
 * Generate SQL from Group-Pattern
 * @param string $pattern Pattern to generate SQL for
 * @param string $search What to searchid for
 * @param int $extra
 * @return string sql to perform the search
 */
function GenGroupSQL($pattern, $search = '', $extra = 0)
{
    $pattern = RunGroupMacros($pattern);
    if ($pattern === false) {
        return false;
    }

    if (starts_with($pattern, '%')) {
        // v1 pattern
        $tables = array();
        $words = explode(' ', $pattern);
        foreach ($words as $word) {
            if (starts_with($word, '%') && str_contains($word, '.')) {
                list($table, $column) = explode('.', $word, 2);
                $table = str_replace('%', '', $table);
                $tables[] = mres(str_replace('(', '', $table));
                $pattern = str_replace($word, $table . '.' . $column, $pattern);
            }
        }
        $tables = array_keys(array_flip($tables));
    } else {
        // v2 pattern
        $tables = getTablesFromPattern($pattern);
    }

    $pattern = rtrim($pattern, '&|');

    if ($tables[0] != 'devices' && dbFetchCell('SELECT 1 FROM information_schema.COLUMNS WHERE TABLE_NAME = ? && COLUMN_NAME = ?', array($tables[0],'device_id')) != 1) {
        //Our first table has no valid glue, prepend the 'devices' table to it!
        array_unshift($tables, 'devices');
    }
    $x = sizeof($tables)-1;
    $i = 0;
    $join = "";
    while ($i < $x) {
        if (isset($tables[$i+1])) {
            $gtmp = ResolveGlues(array($tables[$i+1]), 'device_id');
            if ($gtmp === false) {
                //Cannot resolve glue-chain. Rule is invalid.
                return false;
            }
            $last = "";
            $qry = "";
            foreach ($gtmp as $glue) {
                if (empty($last)) {
                    list($tmp,$last) = explode('.', $glue);
                    $qry .= $glue.' = ';
                } else {
                    list($tmp,$new) = explode('.', $glue);
                    $qry .= $tmp.'.'.$last.' && '.$tmp.'.'.$new.' = ';
                    $last = $new;
                }
                if (!in_array($tmp, $tables)) {
                    $tables[] = $tmp;
                }
            }
            $join .= "( ".$qry.$tables[0].".device_id ) && ";
        }
        $i++;
    }
    if ($extra === 1) {
        $sql_extra = ",`devices`.*";
    }
    if (!empty($search)) {
        $search = str_replace("(", "", $tables[0]).'.'.$search. ' AND';
    }
    if (!empty($join)) {
        $join = '('.rtrim($join, '& ').') &&';
    }
    $sql = 'SELECT DISTINCT('.str_replace('(', '', $tables[0]).'.device_id)'.$sql_extra.' FROM '.implode(',', $tables).' WHERE '.$join.' '.$search.' ('.str_replace(array('%', '@', '!~', '~'), array('', '.*', 'NOT REGEXP', 'REGEXP'), $pattern).')';
    return $sql;
}//end GenGroupSQL()


/**
 * Extract an array of tables in a pattern
 *
 * @param string $pattern
 * @return array
 */
function getTablesFromPattern($pattern)
{
    preg_match_all('/[A-Za-z_]+(?=\.[A-Za-z_]+ )/', $pattern, $tables);
    if (is_null($tables)) {
        return array();
    }
    return array_keys(array_flip($tables[0])); // unique tables only
}

/**
 * Run the group queries again to get fresh list of devices for this group
 * @param integer $group_id Group-ID
 * @return string
 */
function QueryDevicesFromGroup($group_id)
{
    $group = dbFetchRow('SELECT pattern,params FROM device_groups WHERE id = ?', array($group_id));
    $pattern = rtrim($group['pattern'], '&|');
    $params = (array)json_decode($group['params']);
    if (!empty($pattern)) {
        $result = dbFetchColumn(GenGroupSQL($pattern), $params);
        return $result;
    }

    return false;
}//end QueryDevicesFromGroup()

/**
 * Get an array of all the device ids belonging to this group_id
 * @param $group_id
 * @param bool $nested Return an array of arrays containing 'device_id'. (for API compatibility)
 * @param string $full Return all fields from devices_id
 * @return array
 */
function GetDevicesFromGroup($group_id, $nested = false, $full = '')
{
    if ($full) {
        $query = 'SELECT `device_groups`.`name`, `devices`.* FROM `device_groups` INNER JOIN `device_group_device` ON `device_groups`.`id` = `device_group_device`.`device_group_id` INNER JOIN `devices` ON `device_group_device`.`device_id` = `devices`.`device_id` WHERE `device_groups`.`id` = ?';
    } else {
        $query = 'SELECT `device_id` FROM `device_group_device` WHERE `device_group_id` = ? ';
    }
    if ($nested) {
        return dbFetchRows($query, array($group_id));
    } else {
        return dbFetchColumn($query, array($group_id));
    }
}//end GetDevicesFromGroup()

/**
 * Get all Device-Groups
 * @return array
 */
function GetDeviceGroups()
{
    return dbFetchRows('SELECT * FROM device_groups ORDER BY name');
}//end GetDeviceGroups()

/**
 * Run the group queries again to get fresh list of groups for this device
 * @param integer $device_id Device-ID
 * @param int $extra Return extra info about the groups (name, desc, pattern)
 * @return array
 */
function QueryGroupsFromDevice($device_id, $extra = 0)
{
    $ret = array();
    foreach (GetDeviceGroups() as $group) {
        $params = (array)json_decode($group['params']);
        array_unshift($params, $device_id);
        if (dbFetchCell(GenGroupSQL($group['pattern'], 'device_id=?', $extra).' LIMIT 1', $params) == $device_id) {
            if ($extra === 0) {
                $ret[] = $group['id'];
            } else {
                $ret[] = $group;
            }
        }
    }

    return $ret;
}//end QueryGroupsFromDevice()

/**
 * Get the Device Group IDs of a Device from the database
 * @param $device_id
 * @param int $extra Return extra info about the groups (name, desc, pattern)
 * @return array
 */
function GetGroupsFromDevice($device_id, $extra = 0)
{
    $ret = array();
    if ($extra === 0) {
        $ret = dbFetchColumn('SELECT `device_group_id` FROM `device_group_device` WHERE `device_id`=?', array($device_id));
    } else {
        $ret = dbFetchRows('SELECT `device_groups`.* FROM `device_group_device` LEFT JOIN `device_groups` ON `device_group_device`.`device_group_id`=`device_groups`.`id` WHERE `device_group_device`.`device_id`=?', array($device_id));
    }
    return $ret;
}//end GetGroupsFromDeviceDB()

/**
 * Process Macros
 * @param string $rule Rule to process
 * @param int $x Recursion-Anchor
 * @return string|boolean
 */
function RunGroupMacros($rule, $x = 1)
{
    global $config;
    krsort($config['alert']['macros']['group']);
    foreach ($config['alert']['macros']['group'] as $macro => $value) {
        if (!strstr($macro, " ")) {
            $rule = str_replace('%macros.'.$macro, '('.$value.')', $rule);
        }
    }
    if (strstr($rule, "%macros")) {
        if (++$x < 30) {
            $rule = RunGroupMacros($rule, $x);
        } else {
            return false;
        }
    }
    return $rule;
}//end RunGroupMacros()


/**
 * Update device-group relationship for the given device id
 * @param $device_id
 */
function UpdateGroupsForDevice($device_id)
{
    d_echo("### Start Device Groups ###\n");
    $queried_groups = QueryGroupsFromDevice($device_id);
    $db_groups = GetGroupsFromDevice($device_id);

    // compare the arrays to get the added and removed groups
    $added_groups = array_diff($queried_groups, $db_groups);
    $removed_groups = array_diff($db_groups, $queried_groups);

    d_echo("Groups Added: ".implode(',', $added_groups).PHP_EOL);
    d_echo("Groups Removed: ".implode(',', $removed_groups).PHP_EOL);

    // insert new groups
    $insert = array();
    foreach ($added_groups as $group_id) {
        $insert[] = array('device_id' => $device_id, 'device_group_id' => $group_id);
    }
    if (!empty($insert)) {
        dbBulkInsert($insert, 'device_group_device');
    }

    // remove old groups
    if (!empty($removed_groups)) {
        dbDelete('device_group_device', '`device_id`=? AND `device_group_id` IN (?)', array($device_id, array(implode(',', $removed_groups))));
    }
    d_echo("### End Device Groups ###\n");
}

/**
 * Update the device-group relationship for the given group id
 * @param $group_id
 */
function UpdateDeviceGroup($group_id)
{
    $queried_devices = QueryDevicesFromGroup($group_id);
    $db_devices = GetDevicesFromGroup($group_id);

    // compare the arrays to get the added and removed devices
    $added_devices = array_diff($queried_devices, $db_devices);
    $removed_devices = array_diff($db_devices, $queried_devices);

    // insert new devices
    $insert = array();
    foreach ($added_devices as $device_id) {
        $insert[] = array('device_id' => $device_id, 'device_group_id' => $group_id);
    }
    if (!empty($insert)) {
        dbBulkInsert($insert, 'device_group_device');
    }

    // remove old devices
    if (!empty($removed_devices)) {
        dbDelete('device_group_device', '`device_group_id`=? AND `device_id` IN (?)', array($group_id, array(implode(',', $removed_devices))));
    }
}

/**
 * Fill in params into the pattern, replacing placeholders (?)
 * If $params is empty or null, just returns $pattern
 *
 * @return string
 */
function formatDeviceGroupPattern($pattern, $params)
{
    // fill in parameters
    foreach ((array)$params as $value) {
        if (!is_numeric($value) && !starts_with($value, "'")) {
            $value = "'".$value."'";
        }
        $pattern = preg_replace('/\?/', $value, $pattern, 1);
    }

    return $pattern;
}
