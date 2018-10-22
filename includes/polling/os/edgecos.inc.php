<?php

if (starts_with($poll_device['sysObjectID'], 'enterprises.259.6.')) {
    $tmp_mib = 'ES3528MO-MIB';
} elseif (starts_with($poll_device['sysObjectID'], 'enterprises.259.10.1.22.')) {
    $tmp_mib = 'ES3528MV2-MIB';
} elseif (starts_with($poll_device['sysObjectID'], 'enterprises.259.10.1.24.')) {
    $tmp_mib = 'ECS4510-MIB';
} elseif (starts_with($poll_device['sysObjectID'], 'enterprises.259.10.1.42.')) {
    $tmp_mib = 'ECS4210-MIB';
} elseif (starts_with($poll_device['sysObjectID'], 'enterprises.259.10.1.27.')) {
    $tmp_mib = 'ECS3510-MIB';
} elseif (starts_with($poll_device['sysObjectID'], 'enterprises.259.10.')) {
    $tmp_mib = 'ECS4120-MIB';
}

$tmp_edgecos = snmp_get_multi($device, 'swOpCodeVer.1 swProdName.0 swSerialNumber.1 swHardwareVer.1', '-OQUs', $tmp_mib);

$version  = trim($tmp_edgecos[1]['swHardwareVer'], '"') . ' ' . trim($tmp_edgecos[1]['swOpCodeVer'], '"');
$hardware = trim($tmp_edgecos[0]['swProdName'], '"');
$serial   = trim($tmp_edgecos[1]['swSerialNumber'], '"');
