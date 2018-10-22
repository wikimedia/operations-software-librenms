<?php

/*
 * LibreNMS Network Management and Monitoring System
 * Copyright (C) 2006-2011, Observium Developers - http://www.observium.org
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * See COPYING for more details.
 */

use LibreNMS\RRD\RrdDefinition;

$snmpdata = snmp_get_multi($device, 'sysUpTime.0 sysLocation.0 sysContact.0 sysName.0 sysObjectID.0', '-OQnUst', 'SNMPv2-MIB:HOST-RESOURCES-MIB:SNMP-FRAMEWORK-MIB');
$poll_device = $snmpdata[0];
$poll_device['sysName'] = strtolower($poll_device['sysName']);

$poll_device['sysDescr'] = snmp_get($device, 'sysDescr.0', '-OvQ', 'SNMPv2-MIB:HOST-RESOURCES-MIB:SNMP-FRAMEWORK-MIB');

if (!empty($agent_data['uptime'])) {
    list($uptime) = explode(' ', $agent_data['uptime']);
    $uptime = round($uptime);
    echo "Using UNIX Agent Uptime ($uptime)\n";
} else {
    $uptime_data = snmp_get_multi($device, 'snmpEngineTime.0 hrSystemUptime.0', '-OQnUst', 'HOST-RESOURCES-MIB:SNMP-FRAMEWORK-MIB');

    $uptime = max(
        round($poll_device['sysUpTime'] / 100),
        $config['os'][$device['os']]['bad_snmpEngineTime'] ? 0 : $uptime_data[0]['snmpEngineTime'],
        $config['os'][$device['os']]['bad_hrSystemUptime'] ? 0 : round($uptime_data[0]['hrSystemUptime'] / 100)
    );
    d_echo("Uptime seconds: $uptime\n");
}

if ($uptime != 0 && $config['os'][$device['os']]['bad_uptime'] !== true) {
    if ($uptime < $device['uptime']) {
        log_event('Device rebooted after ' . formatUptime($device['uptime']) . " -> {$uptime}s", $device, 'reboot', 4, $device['uptime']);
    }

    $tags = array(
        'rrd_def' => RrdDefinition::make()->addDataset('uptime', 'GAUGE', 0),
    );
    data_update($device, 'uptime', $tags, $uptime);

    $graphs['uptime'] = true;

    echo 'Uptime: ' . formatUptime($uptime) . PHP_EOL;

    $update_array['uptime'] = $uptime;
}//end if

$poll_device['sysLocation'] = str_replace('"', '', $poll_device['sysLocation']);

// Remove leading & trailing backslashes added by VyOS/Vyatta/EdgeOS
$poll_device['sysLocation'] = trim($poll_device['sysLocation'], '\\');

// Rewrite sysLocation if there is a mapping array (database too?)
if (!empty($poll_device['sysLocation']) && (is_array($config['location_map']) || is_array($config['location_map_regex']) || is_array($config['location_map_regex_sub']))) {
    $poll_device['sysLocation'] = rewrite_location($poll_device['sysLocation']);
}

$poll_device['sysContact'] = str_replace('"', '', $poll_device['sysContact']);

// Remove leading & trailing backslashes added by VyOS/Vyatta/EdgeOS
$poll_device['sysContact'] = trim($poll_device['sysContact'], '\\');


foreach (array('sysLocation', 'sysContact') as $elem) {
    if ($poll_device[$elem] == 'not set') {
        $poll_device[$elem] = '';
    }
}

// Save results of various polled values to the database
foreach (array('sysContact', 'sysObjectID', 'sysName', 'sysDescr') as $elem) {
    if ($poll_device[$elem] != $device[$elem]) {
        $update_array[$elem] = $poll_device[$elem];
        log_event("$elem -> " . $poll_device[$elem], $device, 'system', 3);
    }
}

if ($poll_device['sysLocation'] && $device['location'] != $poll_device['sysLocation'] && $device['override_sysLocation'] == 0) {
    $update_array['location'] = $poll_device['sysLocation'];
    log_event('Location -> ' . $poll_device['sysLocation'], $device, 'system', 3);
}

if ($config['geoloc']['latlng'] === true) {
    location_to_latlng($device);
}

unset($snmpdata, $uptime_data, $uptime, $tags);
