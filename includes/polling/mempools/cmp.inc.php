<?php

$oid = $mempool['mempool_index'];

// FIXME snmp_get
$pool_cmd  = $config['snmpget'].' -M '.$config['mibdir'].' -m CISCO-MEMORY-POOL-MIB -O Uqnv '.snmp_gen_auth($device).' '.$device['hostname'].':'.$device['port'];
$pool_cmd .= " ciscoMemoryPoolUsed.$oid ciscoMemoryPoolFree.$oid ciscoMemoryPoolLargestFree.$oid";
$pool_cmd .= " | cut -f 1 -d ' '";

d_echo("$pool_cmd");

$pool = shell_exec($pool_cmd);

list($mempool['used'], $mempool['free'], $mempool['largestfree']) = explode("\n", $pool);
$mempool['total'] = ($mempool['used'] + $mempool['free']);
