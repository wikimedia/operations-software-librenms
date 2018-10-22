<?php

$oid = $mempool['mempool_index'];

// FIXME snmp_get
$pool_cmd  = $config['snmpget'].' -M '.$config['mibdir'].' -m CISCO-ENHANCED-MEMPOOL-MIB -O Uqnv '.snmp_gen_auth($device).' '.$device['hostname'].':'.$device['port'];
$pool_cmd .= " cempMemPoolUsed.$oid cempMemPoolFree.$oid cempMemPoolLargestFree.$oid";
$pool_cmd .= " | cut -f 1 -d ' '";

d_echo("SNMP [ $pool_cmd ]\n");

$pool = shell_exec($pool_cmd);

list($mempool['used'], $mempool['free'], $mempool['largestfree']) = explode("\n", $pool);
$mempool['total'] = ($mempool['used'] + $mempool['free']);
