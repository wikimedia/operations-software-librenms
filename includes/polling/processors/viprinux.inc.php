<?php
echo 'Viprinet CPU Usage';

$usage = str_replace('"', "", snmp_get($device, 'VIPRINET-MIB::vpnRouterCPULoad.0', '-OvQ'));
if (is_numeric($usage)) {
    $proc = ($usage * 100);
}
