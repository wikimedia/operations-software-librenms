<?php

use LibreNMS\RRD\RrdDefinition;

$ospf_instance_count  = 0;
$ospf_port_count      = 0;
$ospf_area_count      = 0;
$ospf_neighbour_count = 0;

$ospf_oids_db = array(
    'ospfRouterId',
    'ospfAdminStat',
    'ospfVersionNumber',
    'ospfAreaBdrRtrStatus',
    'ospfASBdrRtrStatus',
    'ospfExternLsaCount',
    'ospfExternLsaCksumSum',
    'ospfTOSSupport',
    'ospfOriginateNewLsas',
    'ospfRxNewLsas',
    'ospfExtLsdbLimit',
    'ospfMulticastExtensions',
    'ospfExitOverflowInterval',
    'ospfDemandExtensions',
);

$ospf_area_oids = array(
    'ospfAuthType',
    'ospfImportAsExtern',
    'ospfSpfRuns',
    'ospfAreaBdrRtrCount',
    'ospfAsBdrRtrCount',
    'ospfAreaLsaCount',
    'ospfAreaLsaCksumSum',
    'ospfAreaSummary',
    'ospfAreaStatus',
);

$ospf_port_oids = array(
    'ospfIfIpAddress',
    'port_id',
    'ospfAddressLessIf',
    'ospfIfAreaId',
    'ospfIfType',
    'ospfIfAdminStat',
    'ospfIfRtrPriority',
    'ospfIfTransitDelay',
    'ospfIfRetransInterval',
    'ospfIfHelloInterval',
    'ospfIfRtrDeadInterval',
    'ospfIfPollInterval',
    'ospfIfState',
    'ospfIfDesignatedRouter',
    'ospfIfBackupDesignatedRouter',
    'ospfIfEvents',
    'ospfIfAuthKey',
    'ospfIfStatus',
    'ospfIfMulticastForwarding',
    'ospfIfDemand',
    'ospfIfAuthType',
);

$ospf_nbr_oids_db  = array(
    'ospfNbrIpAddr',
    'ospfNbrAddressLessIndex',
    'ospfNbrRtrId',
    'ospfNbrOptions',
    'ospfNbrPriority',
    'ospfNbrState',
    'ospfNbrEvents',
    'ospfNbrLsRetransQLen',
    'ospfNbmaNbrStatus',
    'ospfNbmaNbrPermanence',
    'ospfNbrHelloSuppressed',
);

$ospf_nbr_oids_rrd = array();
$ospf_nbr_oids     = array_merge($ospf_nbr_oids_db, $ospf_nbr_oids_rrd);

if (key_exists('vrf_lite_cisco', $device) && ($device['vrf_lite_cisco'] != '')) {
    $vrfs_lite_cisco = $device['vrf_lite_cisco'];
} else {
    $vrfs_lite_cisco = array(array('context_name' => null));
}

foreach ($vrfs_lite_cisco as $vrf_lite) {
    $device['context_name'] = $vrf_lite['context_name'];

    echo 'Processes: ';
    
    // Build array of existing entries
    foreach (dbFetchRows('SELECT * FROM `ospf_instances` WHERE `device_id` = ? AND `context_name` = ?', array($device['device_id'], $device['context_name'])) as $entry) {
        $ospf_instances_db[$entry['ospf_instance_id']][$entry['context_name']] = $entry;
    }

    // Pull data from device
    $ospf_instances_poll = snmpwalk_cache_oid($device, 'OSPF-MIB::ospfGeneralGroup', array(), 'OSPF-MIB');
    foreach ($ospf_instances_poll as $ospf_instance_id => $ospf_entry) {
        // If the entry doesn't already exist in the prebuilt array, insert into the database and put into the array
        if (empty($ospf_instances_db[$ospf_instance_id][$device['context_name']])) {
            $tmp_insert = array(
                    'device_id' => $device['device_id'],
                    'ospf_instance_id' => $ospf_instance_id,
                    'context_name' => $device['context_name'],
            );
            foreach ($ospf_oids_db as $oid_db) {
                $tmp_insert[$oid_db] = $ospf_entry[$oid_db];
            }
            dbInsert($tmp_insert, 'ospf_instances');
            unset($tmp_insert);
            echo '+';
            $entry = dbFetchRow('SELECT * FROM `ospf_instances` WHERE `device_id` = ? AND `ospf_instance_id` = ? AND `context_name` = ?', array($device['device_id'], $ospf_instance_id, $device['context_name']));
            $ospf_instances_db[$ospf_instance_id][$device['context_name']] = $entry;
        }
    }

    d_echo("\nPolled: ");
    d_echo($ospf_instances_poll);
    d_echo('Database: ');
    d_echo($ospf_instances_db);

    // Loop array of entries and update
    if (is_array($ospf_instances_db)) {
        foreach ($ospf_instances_db as $ospf_instance_id => $ospf_instance_db) {
            $ospf_instance_db = array_shift($ospf_instance_db);
            if (is_array($ospf_instances_poll[$ospf_instance_id])) {
                $ospf_instance_poll = $ospf_instances_poll[$ospf_instance_id];
                foreach ($ospf_oids_db as $oid) {
                    // Loop the OIDs
                    if ($ospf_instance_db[$oid] != $ospf_instance_poll[$oid]) {
                        // If data has changed, build a query
                        $ospf_instance_update[$oid] = $ospf_instance_poll[$oid];
                        // log_event("$oid -> ".$this_port[$oid], $device, 'ospf', $port['port_id']); // FIXME
                    }
                }

                if ($ospf_instance_update) {
                    dbUpdate($ospf_instance_update, 'ospf_instances', '`device_id` = ? AND `ospf_instance_id` = ? AND `context_name`=? ', array($device['device_id'], $ospf_instance_id, $device['context_name']));
                    echo 'U';
                    unset($ospf_instance_update);
                } else {
                    echo '.';
                }

                unset($ospf_instance_poll);
                unset($ospf_instance_db);
                $ospf_instance_count++;
            } else {
                dbDelete('ospf_instances', '`device_id` = ? AND `ospf_instance_id` = ? AND `context_name`=? ', array($device['device_id'], $ospf_area_db['ospfAreaId'], $device['context_name']));
            }
        }//end foreach
    }//end if
    unset($ospf_instances_poll);
    unset($ospf_instances_db);

    echo ' Areas: ';

    // Build array of existing entries
    foreach (dbFetchRows('SELECT * FROM `ospf_areas` WHERE `device_id` = ? AND `context_name`= ?', array($device['device_id'], $device['context_name'])) as $entry) {
        $ospf_areas_db[$entry['ospfAreaId']][$entry['context_name']] = $entry;
    }

    // Pull data from device
    $ospf_areas_poll = snmpwalk_cache_oid($device, 'OSPF-MIB::ospfAreaEntry', array(), 'OSPF-MIB');

    foreach ($ospf_areas_poll as $ospf_area_id => $ospf_area) {
        // If the entry doesn't already exist in the prebuilt array, insert into the database and put into the array
        if (empty($ospf_areas_db[$ospf_area_id][$device['context_name']])) {
            $tmp_insert = array('device_id' => $device['device_id'], 'ospfAreaId' => $ospf_area_id, 'context_name' => $device['context_name']);
            foreach ($ospf_area_oids as $oid_db) {
                $tmp_insert[$oid_db] = $ospf_area[$oid_db];
            }
            dbInsert($tmp_insert, 'ospf_areas');
            unset($tmp_insert);
            echo '+';
            $entry = dbFetchRows('SELECT * FROM `ospf_areas` WHERE `device_id` = ? AND `ospfAreaId` = ? AND `context_name` = ?', array($device['device_id'], $ospf_area_id, $device['context_name']));
            $ospf_areas_db[$ospf_area_id][$device['context_name']] = $entry;
        }
    }

    d_echo("\nPolled: ");
    d_echo($ospf_areas_poll);
    d_echo('Database: ');
    d_echo($ospf_areas_db);

    // Loop array of entries and update
    if (is_array($ospf_areas_db)) {
        foreach ($ospf_areas_db as $ospf_area_id => $ospf_area_db) {
            $ospf_area_db = array_shift($ospf_area_db);
            if (is_array($ospf_areas_poll[$ospf_area_id])) {
                $ospf_area_poll = $ospf_areas_poll[$ospf_area_id];
                foreach ($ospf_area_oids as $oid) {
                    // Loop the OIDs
                    if ($ospf_area_db[$oid] != $ospf_area_poll[$oid]) {
                        // If data has changed, build a query
                        $ospf_area_update[$oid] = $ospf_area_poll[$oid];
                        // log_event("$oid -> ".$this_port[$oid], $device, 'interface', $port['port_id']); // FIXME
                    }
                }

                if ($ospf_area_update) {
                    dbUpdate($ospf_area_update, 'ospf_areas', '`device_id` = ? AND `ospfAreaId` = ? AND `context_name` = ?', array($device['device_id'], $ospf_area_id, $device['context_name']));
                    echo 'U';
                    unset($ospf_area_update);
                } else {
                    echo '.';
                }

                unset($ospf_area_poll);
                unset($ospf_area_db);
                $ospf_area_count++;
            } else {
                dbDelete('ospf_ports', '`device_id` = ? AND `ospfIfAreaId` = ? AND `context_name` = ?', array($device['device_id'], $ospf_area_db['ospfAreaId'], $device['context_name']));
            }//end if
        }//end foreach
    }//end if

    unset($ospf_areas_db);
    unset($ospf_areas_poll);


// $ospf_ports = snmpwalk_cache_oid($device, "OSPF-MIB::ospfIfEntry", array(), "OSPF-MIB");
// print_r($ospf_ports);
    echo ' Ports: ';

    // Build array of existing entries
    foreach (dbFetchRows('SELECT * FROM `ospf_ports` WHERE `device_id` = ? AND `context_name` = ?', array($device['device_id'], $device['context_name'])) as $entry) {
        $ospf_ports_db[$entry['ospf_port_id']][$device['context_name']] = $entry;
    }

    // Pull data from device
    $ospf_ports_poll = snmpwalk_cache_oid($device, 'OSPF-MIB::ospfIfEntry', array(), 'OSPF-MIB');

    foreach ($ospf_ports_poll as $ospf_port_id => $ospf_port) {
        // If the entry doesn't already exist in the prebuilt array, insert into the database and put into the array
        if (empty($ospf_ports_db[$ospf_port_id][$device['context_name']])) {
            $tmp_insert = array('device_id' => $device['device_id'], 'ospf_port_id' => $ospf_port_id, 'context_name' => $device['context_name']);
            foreach ($ospf_port_oids as $oid_db) {
                $tmp_insert[$oid_db] = $ospf_port[$oid_db];
            }
            // Set port_id temporarily for mysql strict mode
            $tmp_insert['port_id'] = 0;
            dbInsert($tmp_insert, 'ospf_ports');
            unset($tmp_insert);
            echo '+';
            $ospf_ports_db[$ospf_port_id][$device['context_name']] = dbFetchRow('SELECT * FROM `ospf_ports` WHERE `device_id` = ? AND `ospf_port_id` = ? AND `context_name` = ?', array($device['device_id'], $ospf_port_id, $device['context_name']));
        }
    }

    d_echo("\nPolled: ");
    d_echo($ospf_ports_poll);
    d_echo('Database: ');
    d_echo($ospf_ports_db);

    // Loop array of entries and update
    if (is_array($ospf_ports_db)) {
        foreach ($ospf_ports_db as $ospf_port_id => $ospf_port_db) {
            $ospf_port_db = array_shift($ospf_port_db);
            if (is_array($ospf_ports_poll[$ospf_port_id])) {
                $ospf_port_poll = $ospf_ports_poll[$ospf_port_id];

                if ($ospf_port_poll['ospfAddressLessIf']) {
                    $ospf_port_poll['port_id'] = @dbFetchCell('SELECT `port_id` FROM `ports` WHERE `device_id` = ? AND `ifIndex` = ?', array($device['device_id'], $ospf_port_poll['ospfAddressLessIf']));
                } else {
                    $ospf_port_poll['port_id'] = @dbFetchCell('SELECT A.`port_id` FROM ipv4_addresses AS A, ports AS I WHERE A.ipv4_address = ? AND I.port_id = A.port_id AND I.device_id = ? AND A.context_name = ?', array($ospf_port_poll['ospfIfIpAddress'], $device['device_id'], $device['context_name']));
                }

                foreach ($ospf_port_oids as $oid) {
                    // Loop the OIDs
                    if ($ospf_port_db[$oid] != $ospf_port_poll[$oid]) {
                        // If data has changed, build a query
                        $ospf_port_update[$oid] = $ospf_port_poll[$oid];
                        // log_event("$oid -> ".$this_port[$oid], $device, 'ospf', $port['port_id']); // FIXME
                    }
                }

                if ($ospf_port_update) {
                    dbUpdate($ospf_port_update, 'ospf_ports', '`device_id` = ? AND `ospf_port_id` = ? AND `context_name` = ?', array($device['device_id'], $ospf_port_id, $device['context_name']));
                    echo 'U';
                    unset($ospf_port_update);
                } else {
                    echo '.';
                }

                unset($ospf_port_poll);
                unset($ospf_port_db);
                $ospf_port_count++;
            } else {
                dbDelete('ospf_ports', '`device_id` = ? AND `ospf_port_id` = ? AND `context_name` = ?', array($device['device_id'], $ospf_port_db['ospf_port_id'], $device['context_name']));
                // ("DELETE FROM `ospf_ports` WHERE `device_id` = '".$device['device_id']."' AND `ospf_port_id` = '".$ospf_port_db['ospf_port_id']."'");
                echo '-';
            }//end if
        }//end foreach
    }//end if
    unset($ospf_ports_poll);

    echo ' Neighbours: ';

    // Build array of existing entries
    foreach (dbFetchRows('SELECT * FROM `ospf_nbrs` WHERE `device_id` = ? AND `context_name` = ?', array($device['device_id'], $device['context_name'])) as $nbr_entry) {
        $ospf_nbrs_db[$nbr_entry['ospf_nbr_id']][$device['context_name']] = $nbr_entry;
    }

    // Pull data from device
    $ospf_nbrs_poll = snmpwalk_cache_oid($device, 'OSPF-MIB::ospfNbrEntry', array(), 'OSPF-MIB');

    foreach ($ospf_nbrs_poll as $ospf_nbr_id => $ospf_nbr) {
        // If the entry doesn't already exist in the prebuilt array, insert into the database and put into the array
        if (!isset($ospf_nbrs_db[$ospf_nbr_id][$device['context_name']])) {
            $tmp_insert = array('device_id' => $device['device_id'], 'port_id' => 0, 'ospf_nbr_id' => $ospf_nbr_id, 'context_name' => $device['context_name']);
            foreach ($ospf_nbr_oids_db as $oid_db) {
                $tmp_insert[$oid_db] = $ospf_nbr[$oid_db];
            }
            dbInsert($tmp_insert, 'ospf_nbrs');
            unset($tmp_insert);
            echo '+';
            $entry = dbFetchRow('SELECT * FROM `ospf_nbrs` WHERE `device_id` = ? AND `ospf_nbr_id` = ? AND `context_name` = ?', array($device['device_id'], $ospf_nbr_id,$device['context_name']));
            $ospf_nbrs_db[$ospf_nbr_id][$device['context_name']] = $entry;
        }
    }

    d_echo("\nPolled: ");
    d_echo($ospf_nbrs_poll);
    d_echo('Database: ');
    d_echo($ospf_nbrs_db);

    // Loop array of entries and update
    if (is_array($ospf_nbrs_db)) {
        foreach ($ospf_nbrs_db as $ospf_nbr_id => $ospf_nbr_db) {
            $ospf_nbr_db = array_shift($ospf_nbr_db);
            if (is_array($ospf_nbrs_poll[$ospf_nbr_id])) {
                $ospf_nbr_poll = $ospf_nbrs_poll[$ospf_nbr_id];

                $ospf_nbr_poll['port_id'] = (int)dbFetchCell('SELECT A.`port_id` FROM ipv4_addresses AS A, ospf_nbrs AS I WHERE A.ipv4_address = ? AND I.port_id = A.port_id AND I.device_id = ? AND A.context_name = ?', array($ospf_nbr_poll['ospfNbrIpAddr'], $device['device_id'], $device['context_name']));

                if ($ospf_nbr_db['port_id'] != $ospf_nbr_poll['port_id']) {
                    if (!empty($ospf_nbr_poll['port_id'])) {
                        $ospf_nbr_update = array('port_id' => $ospf_nbr_poll['port_id']);
                    } else {
                        $ospf_nbr_update = array('port_id' => array('NULL'));
                    }
                }

                foreach ($ospf_nbr_oids as $oid) {
                    // Loop the OIDs
                    d_echo($ospf_nbr_db[$oid].'|'.$ospf_nbr_poll[$oid]."\n");

                    if ($ospf_nbr_db[$oid] != $ospf_nbr_poll[$oid]) {
                        // If data has changed, build a query
                        $ospf_nbr_update[$oid] = $ospf_nbr_poll[$oid];
                        // log_event("$oid -> ".$this_nbr[$oid], $device, 'ospf', $nbr['port_id']); // FIXME
                    }
                }

                if ($ospf_nbr_update) {
                    dbUpdate($ospf_nbr_update, 'ospf_nbrs', '`device_id` = ? AND `ospf_nbr_id` = ? AND `context_name` = ?', array($device['device_id'], $ospf_nbr_id, $device['context_name']));
                    echo 'U';
                    unset($ospf_nbr_update);
                } else {
                    echo '.';
                }

                unset($ospf_nbr_poll);
                unset($ospf_nbr_db);
                $ospf_nbr_count++;
            } else {
                dbDelete('ospf_nbrs', '`device_id` = ? AND `ospf_nbr_id` = ? AND `context_name` = ?', array($device['device_id'], $ospf_nbr_db['ospf_nbr_id'], $device['context_name']));
                echo '-';
            }//end if
        }//end foreach
    }//end if
    unset($ospf_nbrs_db);
    unset($ospf_nbrs_poll);
    echo "\n";
}
unset($device['context_name'], $vrfs_lite_cisco, $vrf_lite);
// Create device-wide statistics RRD
$rrd_def = RrdDefinition::make()
    ->addDataset('instances', 'GAUGE', 0, 1000000)
    ->addDataset('areas', 'GAUGE', 0, 1000000)
    ->addDataset('ports', 'GAUGE', 0, 1000000)
    ->addDataset('neighbours', 'GAUGE', 0, 1000000);

$fields = array(
    'instances'   => $ospf_instance_count,
    'areas'       => $ospf_area_count,
    'ports'       => $ospf_port_count,
    'neighbours'  => $ospf_neighbour_count,
);

$tags = compact('rrd_def');
data_update($device, 'ospf-statistics', $tags, $fields);

echo "\n";

unset(
    $ospf_instance_count,
    $ospf_port_count,
    $ospf_area_count,
    $ospf_neighbour_count,
    $ospf_oids_db,
    $ospf_area_oids,
    $ospf_port_oids,
    $ospf_nbr_oids_db,
    $ospf_nbr_oids_rrd,
    $ospf_nbr_oids,
    $rrd_def,
    $fields,
    $tags
);
