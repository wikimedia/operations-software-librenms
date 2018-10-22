<?php

use LibreNMS\Config;
use LibreNMS\Util\IP;

global $link_exists;

if ($device['os'] == 'ironware' && Config::get('autodiscovery.xdp') === true) {
    echo ' Brocade FDP: ';
    $fdp_array = snmpwalk_group($device, 'snFdpCacheEntry', 'FOUNDRY-SN-SWITCH-GROUP-MIB', 2);

    foreach ($fdp_array as $key => $fdp_if_array) {
        $interface = get_port_by_ifIndex($device['device_id'], $key);
        d_echo($fdp_if_array);

        foreach ($fdp_if_array as $entry_key => $fdp) {
            $remote_device_id = find_device_id($fdp['snFdpCacheDeviceId']);

            if (!$remote_device_id &&
                !can_skip_discovery($fdp['snFdpCacheDeviceId'], $fdp['snFdpCacheVersion'])
            ) {
                $remote_device_id = discover_new_device($fdp['snFdpCacheDeviceId'], $device, 'FDP', $interface);
            }

            $remote_port_id = find_port_id($fdp['snFdpCacheDevicePort'], '', $remote_device_id);
            discover_link(
                $interface['port_id'],
                $fdp['snFdpCacheVendorId'],
                $remote_port_id,
                $fdp['snFdpCacheDeviceId'],
                $fdp['snFdpCacheDevicePort'],
                $fdp['snFdpCachePlatform'],
                $fdp['snFdpCacheVersion'],
                $device['device_id'],
                $remote_device_id
            );
        }
    }//end foreach
    echo PHP_EOL;
}//end if

echo ' CISCO-CDP-MIB: ';
if (Config::get('autodiscovery.xdp') === true) {
    $cdp_array = snmpwalk_group($device, 'cdpCache', 'CISCO-CDP-MIB', 2);

    foreach ($cdp_array as $key => $cdp_if_array) {
        $interface = get_port_by_ifIndex($device['device_id'], $key);

        foreach ($cdp_if_array as $entry_key => $cdp) {
            d_echo($cdp);

            $cdp_ip = IP::fromHexString($cdp['cdpCacheAddress'], true);
            $remote_device_id = find_device_id($cdp['cdpCacheDeviceId'], $cdp_ip);

            if (!$remote_device_id &&
                !can_skip_discovery($cdp['cdpCacheDeviceId'], $cdp['cdpCacheVersion'], $cdp['cdpCachePlatform'])
            ) {
                $remote_device_id = discover_new_device($cdp['cdpCacheDeviceId'], $device, 'CDP', $interface);

                if (!$remote_device_id && Config::get('discovery_by_ip', false)) {
                    $remote_device_id = discover_new_device($cdp_ip, $device, 'CDP', $interface);
                }
            }

            if ($interface['port_id'] && $cdp['cdpCacheDeviceId'] && $cdp['cdpCacheDevicePort']) {
                $remote_port_id = find_port_id($cdp['cdpCacheDevicePort'], '', $remote_device_id);
                discover_link(
                    $interface['port_id'],
                    'cdp',
                    $remote_port_id,
                    $cdp['cdpCacheDeviceId'],
                    $cdp['cdpCacheDevicePort'],
                    $cdp['cdpCachePlatform'],
                    $cdp['cdpCacheVersion'],
                    $device['device_id'],
                    $remote_device_id
                );
            }
        }//end foreach
    }//end foreach
    echo PHP_EOL;
}//end if

if (($device['os'] == 'routeros') && Config::get('autodiscovery.xdp') === true) {
    echo ' LLDP-MIB: ';
    $lldp_array  = snmpwalk_group($device, 'lldpRemEntry', 'LLDP-MIB', 3);
    if (!empty($lldp_array)) {
        $lldp_ports = snmpwalk_group($device, 'mtxrInterfaceStatsName', 'MIKROTIK-MIB');
        $lldp_ports_num = snmpwalk_group($device, 'mtxrNeighborInterfaceID', 'MIKROTIK-MIB');
    

        foreach ($lldp_array as $key => $lldp) {
            $local_port_ifName = $lldp_ports[$lldp_ports_num[$key]['mtxrNeighborInterfaceID']]['mtxrInterfaceStatsName'];
            $local_port_id = find_port_id($local_port_ifName, null, $device['device_id']);
            $interface = get_port_by_id($local_port_id);
            if ($lldp['lldpRemPortIdSubtype'] == 3) { // 3 = macaddress
                $remote_port_mac = str_replace(array(' ', ':', '-'), '', strtolower($lldp['lldpRemPortId']));
            }

            $remote_device_id = find_device_id($lldp['lldpRemSysName'], $lldp['lldpRemManAddr'], $remote_port_mac);

            if (!$remote_device_id &&
                is_valid_hostname($lldp['lldpRemSysName']) &&
                !can_skip_discovery($lldp['lldpRemSysName'], $lldp['lldpRemSysDesc'])) {
                $remote_device_id = discover_new_device($lldp['lldpRemSysName'], $device, 'LLDP', $interface);
            }

            if ($interface['port_id'] && $lldp['lldpRemSysName'] && $lldp['lldpRemPortId']) {
                $remote_port_id = find_port_id($lldp['lldpRemPortDesc'], $lldp['lldpRemPortId'], $remote_device_id);
                discover_link(
                    $interface['port_id'],
                    'lldp',
                    $remote_port_id,
                    $lldp['lldpRemSysName'],
                    $lldp['lldpRemPortId'],
                    null,
                    $lldp['lldpRemSysDesc'],
                    $device['device_id'],
                    $remote_device_id
                );
            }
        }//end foreach
    }
    echo PHP_EOL;
} elseif (($device['os'] == 'pbn' || $device['os'] == 'bdcom') && Config::get('autodiscovery.xdp') === true) {
    echo ' NMS-LLDP-MIB: ';
    $lldp_array  = snmpwalk_group($device, 'lldpRemoteSystemsData', 'NMS-LLDP-MIB');

    foreach ($lldp_array as $key => $lldp) {
        d_echo($lldp);
        $interface = get_port_by_ifIndex($device['device_id'], $lldp['lldpRemLocalPortNum']);
        $remote_device_id = find_device_id($lldp['lldpRemSysName']);

        if (!$remote_device_id &&
            is_valid_hostname($lldp['lldpRemSysName']) &&
            !can_skip_discovery($lldp['lldpRemSysName'], $lldp['lldpRemSysDesc'])
        ) {
            $remote_device_id = discover_new_device($lldp['lldpRemSysName'], $device, 'LLDP', $interface);
        }

        if ($interface['port_id'] && $lldp['lldpRemSysName'] && $lldp['lldpRemPortId']) {
            $remote_port_id = find_port_id($lldp['lldpRemPortDesc'], $lldp['lldpRemPortId'], $remote_device_id);
            discover_link(
                $interface['port_id'],
                'lldp',
                $remote_port_id,
                $lldp['lldpRemSysName'],
                $lldp['lldpRemPortId'],
                null,
                $lldp['lldpRemSysDesc'],
                $device['device_id'],
                $remote_device_id
            );
        }
    }//end foreach
    echo PHP_EOL;
} elseif (Config::get('autodiscovery.xdp') === true) {
    echo ' LLDP-MIB: ';
    $lldp_array  = snmpwalk_group($device, 'lldpRemTable', 'LLDP-MIB', 3);
    if (!empty($lldp_array)) {
        $dot1d_array = snmpwalk_group($device, 'dot1dBasePortIfIndex', 'BRIDGE-MIB');
        $lldp_ports = snmpwalk_group($device, 'lldpLocPortId', 'LLDP-MIB');
    }

    foreach ($lldp_array as $key => $lldp_if_array) {
        foreach ($lldp_if_array as $entry_key => $lldp_instance) {
            if (is_numeric($dot1d_array[$entry_key]['dot1dBasePortIfIndex'])) {
                $ifIndex = $dot1d_array[$entry_key]['dot1dBasePortIfIndex'];
            } else {
                $ifIndex = $entry_key;
            }

            $local_port_id = find_port_id($lldp_ports[$entry_key]['lldpLocPortId'], $ifIndex, $device['device_id']);
            $interface = get_port_by_id($local_port_id);

            d_echo($lldp_instance);

            foreach ($lldp_instance as $entry_instance => $lldp) {
                // normalize MAC address if present
                $remote_port_mac = '';
                if ($lldp['lldpRemPortIdSubtype'] == 3) { // 3 = macaddress
                    $remote_port_mac = str_replace(array(' ', ':', '-'), '', strtolower($lldp['lldpRemPortId']));
                }

                $remote_device_id = find_device_id($lldp['lldpRemSysName'], $lldp['lldpRemManAddr'], $remote_port_mac);

                // add device if configured to do so
                if (!$remote_device_id && !can_skip_discovery($lldp['lldpRemSysName'], $lldp['lldpRemSysDesc'])) {
                    $remote_device_id = discover_new_device($lldp['lldpRemSysName'], $device, 'LLDP', $interface);

                    if (!$remote_device_id && Config::get('discovery_by_ip', false)) {
                        $ptopo_array = snmpwalk_group($device, 'ptopoConnEntry', 'PTOPO-MIB');
                        d_echo($ptopo_array);
                        foreach ($ptopo_array as $ptopo) {
                            if (strcmp(trim($ptopo['ptopoConnRemoteChassis']), trim($lldp['lldpRemChassisId'])) == 0) {
                                $ip = IP::fromHexString($ptopo['ptopoConnAgentNetAddr'], true);
                                $remote_device_id = discover_new_device($ip, $device, 'LLDP', $interface);
                                break;
                            }
                        }
                        unset($ptopo_array);
                    }
                }

                $remote_device = device_by_id_cache($remote_device_id);
                if ($remote_device['os'] == 'calix') {
                    $lldp['lldpRemPortId'] = 'EthPort ' . $lldp['lldpRemPortId'];
                }

                $remote_port_id = find_port_id(
                    $lldp['lldpRemPortDesc'],
                    $lldp['lldpRemPortId'],
                    $remote_device_id,
                    $remote_port_mac
                );

                if (empty($lldp['lldpRemSysName'])) {
                    $lldp['lldpRemSysName'] = $remote_device['sysName'] ?: $remote_device['hostname'];
                }

                if ($interface['port_id'] && $lldp['lldpRemSysName'] && $lldp['lldpRemPortId']) {
                    discover_link(
                        $interface['port_id'],
                        'lldp',
                        $remote_port_id,
                        $lldp['lldpRemSysName'],
                        $lldp['lldpRemPortId'],
                        null,
                        $lldp['lldpRemSysDesc'],
                        $device['device_id'],
                        $remote_device_id
                    );
                }
            }//end foreach
        }//end foreach
    }//end foreach

    unset(
        $dot1d_array
    );
    echo PHP_EOL;
}//end elseif

if (Config::get('autodiscovery.ospf') === true) {
    echo ' OSPF Discovery: ';
    $sql = 'SELECT DISTINCT(`ospfNbrIpAddr`),`device_id` FROM `ospf_nbrs` WHERE `device_id`=?';
    foreach (dbFetchRows($sql, array($device['device_id'])) as $nbr) {
        try {
            $ip = IP::parse($nbr['ospfNbrIpAddr']);

            if ($ip->inNetworks(Config::get('autodiscovery.nets-exclude'))) {
                echo 'x';
                continue;
            }

            if (!$ip->inNetworks(Config::get('nets'))) {
                echo 'i';
                continue;
            }

            $name = gethostbyaddr($ip);
            $remote_device_id = discover_new_device($name, $device, 'OSPF');
        } catch (\LibreNMS\Exceptions\InvalidIpException $e) {
            //
        }
    }
    echo PHP_EOL;
}

d_echo($link_exists);

$sql = "SELECT * FROM `links` AS L, `ports` AS I WHERE L.local_port_id = I.port_id AND I.device_id = ?";
foreach (dbFetchRows($sql, array($device['device_id'])) as $test) {
    $local_port_id   = $test['local_port_id'];
    $remote_hostname = $test['remote_hostname'];
    $remote_port     = $test['remote_port'];
    d_echo("$local_port_id -> $remote_hostname -> $remote_port \n");

    if (!$link_exists[$local_port_id][$remote_hostname][$remote_port]) {
        echo '-';
        $rows = dbDelete('links', '`id` = ?', array($test['id']));
        d_echo("$rows deleted ");
    }
}

// remove orphaned links
$deleted = (int)dbDeleteOrphans('links', array('devices.device_id.local_device_id'));
echo str_repeat('-', $deleted);
d_echo(" $deleted orphaned links deleted\n");

unset(
    $link_exists,
    $sql,
    $fdp_array,
    $cdp_array,
    $lldp_array,
    $deleted
);
