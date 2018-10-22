<?php

use LibreNMS\RRD\RrdDefinition;

$version = trim(snmp_get($device, '1.3.6.1.4.1.14988.1.1.4.4.0', '-OQv', '', ''), '"');
if (strstr($poll_device['sysDescr'], 'RouterOS')) {
    $hardware = substr($poll_device['sysDescr'], 9);
}

$features = 'Level '.trim(snmp_get($device, '1.3.6.1.4.1.14988.1.1.4.3.0', '-OQv', '', ''), '"');
$serial = trim(snmp_get($device, '1.3.6.1.4.1.14988.1.1.7.3.0', '-OQv', '', ''), '"');


$leases = snmp_get($device, 'mtxrDHCPLeaseCount.0', '-OQv', 'MIKROTIK-MIB');

if (is_numeric($leases)) {
    $rrd_def = RrdDefinition::make()->addDataset('leases', 'GAUGE', 0);

    $fields = array(
        'leases' => $leases,
    );

    $tags = compact('rrd_def');
    data_update($device, 'routeros_leases', $tags, $fields);
    $graphs['routeros_leases'] = true;
}

unset($leases);
