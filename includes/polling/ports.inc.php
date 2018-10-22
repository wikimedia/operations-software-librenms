<?php

// Build SNMP Cache Array
use LibreNMS\RRD\RrdDefinition;

$data_oids = array(
    'ifName',
    'ifDescr',
    'ifAlias',
    'ifAdminStatus',
    'ifOperStatus',
    'ifMtu',
    'ifSpeed',
    'ifHighSpeed',
    'ifType',
    'ifPhysAddress',
    'ifPromiscuousMode',
    'ifConnectorPresent',
    'ifDuplex',
    'ifTrunk',
    'ifVlan',
);

$stat_oids = array(
    'ifInErrors',
    'ifOutErrors',
    'ifInUcastPkts',
    'ifOutUcastPkts',
    'ifInNUcastPkts',
    'ifOutNUcastPkts',
    'ifHCInMulticastPkts',
    'ifHCInBroadcastPkts',
    'ifHCOutMulticastPkts',
    'ifHCOutBroadcastPkts',
    'ifInOctets',
    'ifOutOctets',
    'ifHCInOctets',
    'ifHCOutOctets',
    'ifInDiscards',
    'ifOutDiscards',
    'ifInUnknownProtos',
    'ifInBroadcastPkts',
    'ifOutBroadcastPkts',
    'ifInMulticastPkts',
    'ifOutMulticastPkts',
);

$stat_oids_db = array(
    'ifInOctets',
    'ifOutOctets',
    'ifInErrors',
    'ifOutErrors',
    'ifInUcastPkts',
    'ifOutUcastPkts',
);

$stat_oids_db_extended = array(
    'ifInNUcastPkts',
    'ifOutNUcastPkts',
    'ifInDiscards',
    'ifOutDiscards',
    'ifInUnknownProtos',
    'ifInBroadcastPkts',
    'ifOutBroadcastPkts',
    'ifInMulticastPkts',
    'ifOutMulticastPkts',
);

$cisco_oids = array(
    'locIfHardType',
    'locIfInRunts',
    'locIfInGiants',
    'locIfInCRC',
    'locIfInFrame',
    'locIfInOverrun',
    'locIfInIgnored',
    'locIfInAbort',
    'locIfCollisions',
    'locIfInputQueueDrops',
    'locIfOutputQueueDrops',
);

$pagp_oids = array(
    'pagpOperationMode',
);

$pagp_extended_oids = array(
    'pagpPortState',
    'pagpPartnerDeviceId',
    'pagpPartnerLearnMethod',
    'pagpPartnerIfIndex',
    'pagpPartnerGroupIfIndex',
    'pagpPartnerDeviceName',
    'pagpEthcOperationMode',
    'pagpDeviceId',
    'pagpGroupIfIndex',
);

$ifmib_oids = array(
    'ifDescr',
    'ifAdminStatus',
    'ifOperStatus',
    'ifLastChange',
    'ifType',
    'ifPhysAddress',
    'ifMtu',
    'ifInErrors',
    'ifOutErrors',
    'ifInDiscards',
    'ifOutDiscards',
);

$table_base_oids = array(
    'ifName',
    'ifAlias',
    'ifDescr',
    'ifHighSpeed',
    'ifOperStatus',
    'ifAdminStatus',
);

$hc_mappings = array(
    'ifHCInOctets' => 'ifInOctets',
    'ifHCOutOctets' => 'ifOutOctets',
    'ifHCInUcastPkts' => 'ifInUcastPkts',
    'ifHCOutUcastPkts' => 'ifOutUcastPkts',
    'ifHCInBroadcastPkts' => 'ifInBroadcastPkts',
    'ifHCOutBroadcastPkts' => 'ifOutBroadcastPkts',
    'ifHCInMulticastPkts' => 'ifInMulticastPkts',
    'ifHCOutMulticastPkts' => 'ifOutMulticastPkts',
);

$hc_oids = array(
    'ifInMulticastPkts',
    'ifInBroadcastPkts',
    'ifOutMulticastPkts',
    'ifOutBroadcastPkts',
    'ifHCInOctets',
    'ifHCInUcastPkts',
    'ifHCInMulticastPkts',
    'ifHCInBroadcastPkts',
    'ifHCOutOctets',
    'ifHCOutUcastPkts',
    'ifHCOutMulticastPkts',
    'ifHCOutBroadcastPkts',
    'ifPromiscuousMode',
    'ifConnectorPresent',
);

$nonhc_oids = array(
    'ifSpeed',
    'ifInOctets',
    'ifInUcastPkts',
    'ifInUnknownProtos',
    'ifOutOctets',
    'ifOutUcastPkts',
);

$shared_oids = array(
    'ifInErrors',
    'ifOutErrors',
    'ifInNUcastPkts',
    'ifOutNUcastPkts',
    'ifInDiscards',
    'ifOutDiscards',
    'ifPhysAddress',
    'ifLastChange',
    'ifType',
    'ifMtu',
);

echo 'Caching Oids: ';
$port_stats = array();
$data       = array();

if ($device['os'] === 'f5' && (version_compare($device['version'], '11.2.0', '>=') && version_compare($device['version'], '11.7', '<'))) {
    require_once 'ports/f5.inc.php';
} else {
    if ($config['polling']['selected_ports'] === true || $device['attribs']['selected_ports'] == 'true') {
        echo('Select ports polling');
        $lports = dbFetchRows("SELECT * FROM `ports` where `device_id` = ? AND `deleted` = 0 AND `disabled` = 0", array($device['device_id']));
        foreach ($lports as $lport) {
            if (is_port_valid($lport, $device)) {
                $i = $lport['ifIndex'];
                $base_oids = implode(".$i ", $table_base_oids) . ".$i";
                $data = snmp_get_multi($device, $base_oids, '-OQUst', 'IF-MIB', null, $data);
                if ($lport['ifAdminStatus_prev'] === 'down' && $data[$i]['ifAdminStatus'] === 'down') {
                    echo 'port is still admin down';
                } elseif ($lport['ifOperStatus_prev'] === 'down' && $data[$i]['ifOperStatus'] === 'down') {
                    echo 'port is still down';
                } else {
                    echo 'valid';
                    if (is_numeric($data[$i]['ifHighSpeed'])) {
                        $full_oids = array_merge($hc_oids, $shared_oids);
                    } else {
                        $full_oids = array_merge($nonhc_oids, $shared_oids);
                    }
                    $oids = implode(".$i ", $full_oids) . ".$i";
                    unset($full_oids);
                    if (is_array($data[$i])) {
                        $port_stats[$i] = $data[$i];
                    }
                    $port_stats = snmp_get_multi($device, $oids, '-OQUst', 'IF-MIB', null, $port_stats);
                }
            }
        }
        unset($data);
    } else {
        if (!in_array(strtolower($device['hardware']), array_map('strtolower', $config['os'][$device['os']]['bad_ifXEntry']))) {
            $port_stats = snmpwalk_cache_oid($device, 'ifXEntry', $port_stats, 'IF-MIB');
        }
        $hc_test = array_slice($port_stats, 0, 1);
        if ((!isset($hc_test[0]['ifHCInOctets']) && !is_numeric($hc_test[0]['ifHCInOctets'])) ||
            ((!isset($hc_test[0]['ifHighSpeed']) && !is_numeric($hc_test[0]['ifHighSpeed'])))) {
            $port_stats = snmpwalk_cache_oid($device, 'ifEntry', $port_stats, 'IF-MIB', null, '-OQUst');
        } else {
            foreach ($ifmib_oids as $oid) {
                echo "$oid ";
                $port_stats = snmpwalk_cache_oid($device, $oid, $port_stats, 'IF-MIB', null, '-OQUst');
            }
        }
    }
}

if ($device['os'] != 'asa') {
    echo 'dot3StatsDuplexStatus';
    if ($config['enable_ports_poe'] || $config['enable_ports_etherlike']) {
        $port_stats = snmpwalk_cache_oid($device, 'dot3StatsIndex', $port_stats, 'EtherLike-MIB');
    }
    $port_stats = snmpwalk_cache_oid($device, 'dot3StatsDuplexStatus', $port_stats, 'EtherLike-MIB');
}

if ($device['os'] == 'procera') {
    require_once 'ports/procera.inc.php';
}

if ($config['enable_ports_adsl']) {
    $device['adsl_count'] = dbFetchCell("SELECT COUNT(*) FROM `ports` WHERE `device_id` = ? AND `ifType` = 'adsl'", array($device['device_id']));
}

if ($device['adsl_count'] > '0') {
    echo 'ADSL ';
    $port_stats = snmpwalk_cache_oid($device, '.1.3.6.1.2.1.10.94.1.1.1.1', $port_stats, 'ADSL-LINE-MIB');
    $port_stats = snmpwalk_cache_oid($device, '.1.3.6.1.2.1.10.94.1.1.2.1', $port_stats, 'ADSL-LINE-MIB');
    $port_stats = snmpwalk_cache_oid($device, '.1.3.6.1.2.1.10.94.1.1.3.1', $port_stats, 'ADSL-LINE-MIB');
    $port_stats = snmpwalk_cache_oid($device, '.1.3.6.1.2.1.10.94.1.1.4.1', $port_stats, 'ADSL-LINE-MIB');
    $port_stats = snmpwalk_cache_oid($device, '.1.3.6.1.2.1.10.94.1.1.5.1', $port_stats, 'ADSL-LINE-MIB');
    $port_stats = snmpwalk_cache_oid($device, '.1.3.6.1.2.1.10.94.1.1.6.1.1', $port_stats, 'ADSL-LINE-MIB');
    $port_stats = snmpwalk_cache_oid($device, '.1.3.6.1.2.1.10.94.1.1.6.1.2', $port_stats, 'ADSL-LINE-MIB');
    $port_stats = snmpwalk_cache_oid($device, '.1.3.6.1.2.1.10.94.1.1.6.1.3', $port_stats, 'ADSL-LINE-MIB');
    $port_stats = snmpwalk_cache_oid($device, '.1.3.6.1.2.1.10.94.1.1.6.1.4', $port_stats, 'ADSL-LINE-MIB');
    $port_stats = snmpwalk_cache_oid($device, '.1.3.6.1.2.1.10.94.1.1.6.1.5', $port_stats, 'ADSL-LINE-MIB');
    $port_stats = snmpwalk_cache_oid($device, '.1.3.6.1.2.1.10.94.1.1.6.1.6', $port_stats, 'ADSL-LINE-MIB');
    $port_stats = snmpwalk_cache_oid($device, '.1.3.6.1.2.1.10.94.1.1.6.1.7', $port_stats, 'ADSL-LINE-MIB');
    $port_stats = snmpwalk_cache_oid($device, '.1.3.6.1.2.1.10.94.1.1.6.1.8', $port_stats, 'ADSL-LINE-MIB');
    $port_stats = snmpwalk_cache_oid($device, '.1.3.6.1.2.1.10.94.1.1.7.1.1', $port_stats, 'ADSL-LINE-MIB');
    $port_stats = snmpwalk_cache_oid($device, '.1.3.6.1.2.1.10.94.1.1.7.1.2', $port_stats, 'ADSL-LINE-MIB');
    $port_stats = snmpwalk_cache_oid($device, '.1.3.6.1.2.1.10.94.1.1.7.1.3', $port_stats, 'ADSL-LINE-MIB');
    $port_stats = snmpwalk_cache_oid($device, '.1.3.6.1.2.1.10.94.1.1.7.1.4', $port_stats, 'ADSL-LINE-MIB');
    $port_stats = snmpwalk_cache_oid($device, '.1.3.6.1.2.1.10.94.1.1.7.1.5', $port_stats, 'ADSL-LINE-MIB');
    $port_stats = snmpwalk_cache_oid($device, '.1.3.6.1.2.1.10.94.1.1.7.1.6', $port_stats, 'ADSL-LINE-MIB');
    $port_stats = snmpwalk_cache_oid($device, '.1.3.6.1.2.1.10.94.1.1.7.1.7', $port_stats, 'ADSL-LINE-MIB');
}//end if

if ($config['enable_ports_poe']) {
    $port_stats = snmpwalk_cache_oid($device, 'pethPsePortEntry', $port_stats, 'POWER-ETHERNET-MIB');
    $port_stats = snmpwalk_cache_oid($device, 'cpeExtPsePortEntry', $port_stats, 'CISCO-POWER-ETHERNET-EXT-MIB');
}

if ($device['os_group'] == 'cisco' && $device['os'] != 'asa') {
    foreach ($pagp_oids as $oid) {
        $pagp_port_stats = snmpwalk_cache_oid($device, $oid, array(), 'CISCO-PAGP-MIB');
    }
    if (count($pagp_port_stats) > 0) {
        foreach ($pagp_port_stats as $p_index => $p_stats) {
            $port_stats[$p_index]['pagpOperationMode'] = $p_stats['pagpOperationMode'];
        }
        foreach ($pagp_extended_oids as $oid) {
            $port_stats = snmpwalk_cache_oid($device, $oid, $port_stats, 'CISCO-PAGP-MIB');
        }
    }

    // Grab data to put ports into vlans or make them trunks
    // FIXME we probably shouldn't be doing this from the VTP MIB, right?
    $port_stats = snmpwalk_cache_oid($device, 'vmVlan', $port_stats, 'CISCO-VLAN-MEMBERSHIP-MIB');
    $port_stats = snmpwalk_cache_oid($device, 'vlanTrunkPortEncapsulationOperType', $port_stats, 'CISCO-VTP-MIB');
    $port_stats = snmpwalk_cache_oid($device, 'vlanTrunkPortNativeVlan', $port_stats, 'CISCO-VTP-MIB');
} elseif ($device['os'] != 'asa') {
    $port_stats = snmpwalk_cache_oid($device, 'dot1qPvid', $port_stats, 'Q-BRIDGE-MIB');
}//end if

$polled = time();

// End Building SNMP Cache Array
d_echo($port_stats);

// By default libreNMS uses the ifIndex to associate ports on devices with ports discoverd/polled
// before and stored in the database. On Linux boxes this is a problem as ifIndexes may be
// unstable between reboots or (re)configuration of tunnel interfaces (think: GRE/OpenVPN/Tinc/...)
// The port association configuration allows to choose between association via ifIndex, ifName,
// or maybe other means in the future. The default port association mode still is ifIndex for
// compatibility reasons.
$port_association_mode = $config['default_port_association_mode'];
if ($device['port_association_mode']) {
    $port_association_mode = get_port_assoc_mode_name($device['port_association_mode']);
}

// Query known ports and mapping table in order of discovery to make sure
// the latest discoverd/polled port is in the mapping tables.
$ports_mapped = get_ports_mapped($device['device_id'], true);
$ports = $ports_mapped['ports'];

//
// Rename any old RRD files still named after the previous ifIndex based naming schema.
foreach ($ports_mapped['maps']['ifIndex'] as $ifIndex => $port_id) {
    foreach (array ('', '-adsl', '-dot3') as $suffix) {
        $old_rrd_name = "port-$ifIndex$suffix";
        $new_rrd_name = getPortRrdName($port_id, ltrim($suffix, '-'));

        rrd_file_rename($device, $old_rrd_name, $new_rrd_name);
    }
}


$ports_found = array ();
// New interface detection
foreach ($port_stats as $ifIndex => $port) {
    // Store ifIndex in port entry and prefetch ifName as we'll need it multiple times
    $port['ifIndex'] = $ifIndex;
    $ifName = $port['ifName'];

    // Get port_id according to port_association_mode used for this device
    $port_id = get_port_id($ports_mapped, $port, $port_association_mode);

    if (is_port_valid($port, $device)) {
        echo 'valid';

        // Port newly discovered?
        if (! $ports[$port_id]) {
            /**
              * When using the ifName or ifDescr as means to map discovered ports to
              * known ports in the DB (think of port association mode) it's possible
              * that we're facing the problem that the ifName or ifDescr polled from
              * the device is unset or an empty string (like when querying some ubnt
              * devices...). If this happends we have no way to map this port to any
              * port found in the database. As reported this situation may occur for
              * the time of one poll and might resolve automagically before the next
              * poller run happens. Without this special case this would lead to new
              * ports added to the database each time this situation occurs. To give
              * the user the choice between »a lot of new ports« and »some poll runs
              * are missed but ports stay stable« the 'ignore_unmapable_port' option
              * has been added to configure this behaviour. To skip the port in this
              * loop is sufficient as the next loop is looping only over ports found
              * in the database and "maps back". As we did not add a new port to the
              * DB here, there's no port to be mapped to.
              *
              * I'm using the in_array() check here, as I'm not sure if an "ifIndex"
              * can be legally set to 0, which would yield True when checking if the
              * value is empty().
              */
            if ($config['ignore_unmapable_port'] === true and in_array($port[$port_association_mode], array ('', null))) {
                continue;
            }

            $port_id         = dbInsert(array('device_id' => $device['device_id'], 'ifIndex' => $ifIndex, 'ifName' => $ifName), 'ports');
            dbInsert(array('port_id' => $port_id), 'ports_statistics');
            $ports[$port_id] = dbFetchRow('SELECT * FROM `ports` WHERE `port_id` = ?', array($port_id));
            echo 'Adding: '.$ifName.'('.$ifIndex.')('.$port_id.')';
            // print_r($ports);
        } // Port re-discovered after previous deletion?
        elseif ($ports[$port_id]['deleted'] == 1) {
            dbUpdate(array('deleted' => '0'), 'ports', '`port_id` = ?', array($port_id));
            $ports[$port_id]['deleted'] = '0';
        }
        if ($ports[$port_id]['ports_statistics_port_id'] === null) {
            // in case the port was created before we created the table
            dbInsert(array('port_id' => $port_id), 'ports_statistics');
        }

        /** Assure stable bidirectional port mapping between DB and polled data
          *
          * Store the *current* ifIndex in the port info array containing all port information
          * fetched from the database, as this is the only means we have to map ports_stats we
          * just polled from the device to a port in $ports. All code below an includeed below
          * will and has to map a port using it's ifIndex.
          */
        $ports[$port_id]['ifIndex'] = $ifIndex;
        $port_stats[$ifIndex]['port_id'] = $port_id;

    /* Build a list of all ports, identified by their port_id, found within this poller run. */
        $ports_found[] = $port_id;
    } // Port vanished (mark as deleted)
    else {
        if ($ports[$port_id]['deleted'] != '1') {
            dbUpdate(array('deleted' => '1'), 'ports', '`port_id` = ?', array($port_id));
            $ports[$port_id]['deleted'] = '1';
        }
    }
} // End new interface detection


echo "\n";
// Loop ports in the DB and update where necessary
foreach ($ports as $port) {
    $port_id = $port['port_id'];
    $ifIndex = $port['ifIndex'];

    $port_info_string = 'Port ' . $port['ifName'] . ': ' . $port['ifDescr'] . " ($ifIndex / #$port_id) ";

    /* We don't care for disabled ports, go on */
    if ($port['disabled'] == 1) {
        echo "$port_info_string disabled.\n";
        continue;
    }

    /**
     * If this port did not show up in $port_stats before it has been deleted
     * since the last poller run. Mark it deleted in the database and go on.
     */
    if (! in_array($port_id, $ports_found)) {
        if ($port['deleted'] != '1') {
            dbUpdate(array('deleted' => '1'), 'ports', '`device_id` = ? AND `port_id` = ?', array($device['device_id'], $port_id));
            echo "$port_info_string deleted.\n";
        }
        continue;
    }

    echo $port_info_string;
    if ($port_stats[$ifIndex]) {
        // Check to make sure Port data is cached.
        $this_port = &$port_stats[$ifIndex];

        if ($device['os'] == 'vmware' && preg_match('/Device ([a-z0-9]+) at .*/', $this_port['ifDescr'], $matches)) {
            $this_port['ifDescr'] = $matches[1];
        }

        $polled_period = ($polled - $port['poll_time']);

        $port['update'] = array();
        $port['update_extended'] = array();
        $port['state']  = array();

        if ($config['slow_statistics'] == true) {
            $port['update']['poll_time']   = $polled;
            $port['update']['poll_prev']   = $port['poll_time'];
            $port['update']['poll_period'] = $polled_period;
        }

        if ($device['os'] === 'airos-af' && $port['ifAlias'] === 'eth0') {
            $airos_stats = snmpwalk_cache_oid($device, '.1.3.6.1.4.1.41112.1.3.3.1', array(), 'UBNT-AirFIBER-MIB');
            $this_port['ifInOctets'] = $airos_stats[1]['rxOctetsOK'];
            $this_port['ifOutOctets'] = $airos_stats[1]['txOctetsOK'];
            $this_port['ifInErrors'] = $airos_stats[1]['rxErroredFrames'];
            $this_port['ifOutErrors'] = $airos_stats[1]['txErroredFrames'];
            $this_port['ifInBroadcastPkts'] = $airos_stats[1]['rxValidBroadcastFrames'];
            $this_port['ifOutBroadcastPkts'] = $airos_stats[1]['txValidBroadcastFrames'];
            $this_port['ifInMulticastPkts'] = $airos_stats[1]['rxValidMulticastFrames'];
            $this_port['ifOutMulticastPkts'] = $airos_stats[1]['txValidMulticastFrames'];
            $this_port['ifInUcastPkts'] = $airos_stats[1]['rxValidUnicastFrames'];
            $this_port['ifOutUcastPkts'] = $airos_stats[1]['txValidUnicastFrames'];
            $ports['update']['ifInOctets'] = $airos_stats[1]['rxOctetsOK'];
            $ports['update']['ifOutOctets'] = $airos_stats[1]['txOctetsOK'];
            $ports['update']['ifInErrors'] = $airos_stats[1]['rxErroredFrames'];
            $ports['update']['ifOutErrors'] = $airos_stats[1]['txErroredFrames'];
            $ports['update']['ifInBroadcastPkts'] = $airos_stats[1]['rxValidBroadcastFrames'];
            $ports['update']['ifOutBroadcastPkts'] = $airos_stats[1]['txValidBroadcastFrames'];
            $ports['update']['ifInMulticastPkts'] = $airos_stats[1]['rxValidMulticastFrames'];
            $ports['update']['ifOutMulticastPkts'] = $airos_stats[1]['txValidMulticastFrames'];
            $ports['update']['ifInUcastPkts'] = $airos_stats[1]['rxValidUnicastFrames'];
            $ports['update']['ifOutUcastPkts'] = $airos_stats[1]['txValidUnicastFrames'];
        }

        // rewrite the ifPhysAddress
        if (strpos($this_port['ifPhysAddress'], ':')) {
            list($a_a, $a_b, $a_c, $a_d, $a_e, $a_f) = explode(':', $this_port['ifPhysAddress']);
            $this_port['ifPhysAddress']              = zeropad($a_a).zeropad($a_b).zeropad($a_c).zeropad($a_d).zeropad($a_e).zeropad($a_f);
        }

        // use HC values if they are available
        foreach ($hc_mappings as $hc_oid => $if_oid) {
            if (isset($this_port[$hc_oid]) && $this_port[$hc_oid]) {
                d_echo("$hc_oid ");
                $this_port[$if_oid] = $this_port[$hc_oid];
            } else {
                d_echo("$if_oid ");
            }
        }

        if (isset($this_port['ifHighSpeed']) && is_numeric($this_port['ifHighSpeed'])) {
            d_echo('ifHighSpeed ');
            $this_port['ifSpeed'] = ($this_port['ifHighSpeed'] * 1000000);
        } elseif (isset($this_port['ifSpeed']) && is_numeric($this_port['ifSpeed'])) {
            d_echo('ifSpeed ');
        } else {
            d_echo('No ifSpeed ');
            $this_port['ifSpeed'] = 0;
        }

        // Overwrite ifDuplex with dot3StatsDuplexStatus if it exists
        if (isset($this_port['dot3StatsDuplexStatus'])) {
            echo 'dot3Duplex ';
            $this_port['ifDuplex'] = $this_port['dot3StatsDuplexStatus'];
        }

        // update ifLastChange. only in the db, not rrd
        if (isset($this_port['ifLastChange']) && is_numeric($this_port['ifLastChange'])) {
            $port['update']['ifLastChange'] = $this_port['ifLastChange'];
        } elseif ($port['ifLastChange'] != 0) {
            $port['update']['ifLastChange'] = 0;  // no data, so use the same as device uptime
        }

        // Set VLAN and Trunk from Cisco
        if (isset($this_port['vlanTrunkPortEncapsulationOperType']) && $this_port['vlanTrunkPortEncapsulationOperType'] != 'notApplicable') {
            $this_port['ifTrunk'] = $this_port['vlanTrunkPortEncapsulationOperType'];
            if (isset($this_port['vlanTrunkPortNativeVlan'])) {
                $this_port['ifVlan'] = $this_port['vlanTrunkPortNativeVlan'];
            }
        }

        if (isset($this_port['vmVlan'])) {
            $this_port['ifVlan'] = $this_port['vmVlan'];
        }

        // Set VLAN and Trunk from Q-BRIDGE-MIB
        if (!isset($this_port['ifVlan']) && isset($this_port['dot1qPvid'])) {
            $this_port['ifVlan'] = $this_port['dot1qPvid'];
        }

        // FIXME use $q_bridge_mib[$this_port['ifIndex']] to see if it is a trunk (>1 array count)
        echo 'VLAN == '.$this_port['ifVlan'];

        // When devices do not provide ifDescr data, populate with ifName data if available
        if ($this_port['ifDescr'] == '' || $this_port['ifDescr'] == null) {
            $this_port['ifDescr'] = $this_port['ifName'];
            d_echo('Using ifName as ifDescr');
        }

        // When devices do not provide ifAlias data, populate with ifDescr data if configured
        if ($this_port['ifAlias'] == '' || $this_port['ifAlias'] == null) {
            $this_port['ifAlias'] = $this_port['ifDescr'];
            d_echo('Using ifDescr as ifAlias');
        }

        if ($this_port['ifName'] == '' || $this_port['ifName'] == null) {
            $this_port['ifName'] = $this_port['ifDescr'];
            d_echo('Using ifDescr as ifName');
        }

        // Update IF-MIB data
        $tune_port = false;
        foreach ($data_oids as $oid) {
            if ($oid == 'ifAlias') {
                if ($attribs['ifName:'.$port['ifName']]) {
                    $this_port['ifAlias'] = $port['ifAlias'];
                }
            }
            if ($oid == 'ifSpeed' || $oid == 'ifHighSpeed') {
                if ($attribs['ifSpeed:'.$port['ifName']]) {
                    $this_port[$oid] = $port[$oid];
                }
            }

            if ($port[$oid] != $this_port[$oid] && !isset($this_port[$oid])) {
                $port['update'][$oid] = array('NULL');
                log_event($oid . ': ' . $port[$oid] . ' -> NULL', $device, 'interface', 4, $port['port_id']);
                if ($debug) {
                    d_echo($oid.': '.$port[$oid].' -> NULL ');
                } else {
                    echo $oid.' ';
                }
            } elseif ($port[$oid] != $this_port[$oid]) {
                // if the value is different, update it

                // rrdtune if needed
                $port_tune = $attribs['ifName_tune:'.$port['ifName']];
                $device_tune = $attribs['override_rrdtool_tune'];
                if ($port_tune == "true" ||
                    ($device_tune == "true" && $port_tune != 'false') ||
                    ($config['rrdtool_tune'] == "true" && $port_tune != 'false' && $device_tune != 'false')) {
                    if ($oid == 'ifSpeed') {
                        $tune_port = true;
                    }
                }

                // set the update data
                $port['update'][$oid] = $this_port[$oid];

                // store the previous values for alerting
                if ($oid == 'ifOperStatus' || $oid == 'ifAdminStatus') {
                    $port['update'][$oid.'_prev'] = $port[$oid];
                }

                log_event($oid . ': ' . $port[$oid] . ' -> ' . $this_port[$oid], $device, 'interface', 3, $port['port_id']);
                if ($debug) {
                    d_echo($oid.': '.$port[$oid].' -> '.$this_port[$oid].' ');
                } else {
                    echo $oid.' ';
                }
            } else {
                if ($oid == 'ifOperStatus' || $oid == 'ifAdminStatus') {
                    if ($port[$oid.'_prev'] == null) {
                        $port['update'][$oid.'_prev'] = $this_port[$oid];
                    }
                }
            }
        }//end foreach

        // Parse description (usually ifAlias) if config option set
        if (isset($config['port_descr_parser']) && is_file($config['install_dir'].'/'.$config['port_descr_parser'])) {
            $port_attribs = array(
                'type',
                'descr',
                'circuit',
                'speed',
                'notes',
            );

            include $config['install_dir'].'/'.$config['port_descr_parser'];

            foreach ($port_attribs as $attrib) {
                $attrib_key = 'port_descr_'.$attrib;
                if ($port_ifAlias[$attrib] != $port[$attrib_key]) {
                    if (!isset($port_ifAlias[$attrib])) {
                        $port_ifAlias[$attrib] = array('NULL');
                        $log_port              = 'NULL';
                    } else {
                        $log_port = $port_ifAlias[$attrib];
                    }

                    $port['update'][$attrib_key] = $port_ifAlias[$attrib];
                    log_event($attrib . ': ' . $port[$attrib_key] . ' -> ' . $log_port, $device, 'interface', 3, $port['port_id']);
                    unset($log_port);
                }
            }
        }//end if

        // End parse ifAlias
        // Update IF-MIB metrics
        $_stat_oids = array_merge($stat_oids_db, $stat_oids_db_extended);
        foreach ($_stat_oids as $oid) {
            $port_update = 'update';
            $extended_metric = !in_array($oid, $stat_oids_db, true);
            if ($extended_metric) {
                $port_update = 'update_extended';
            }

            if ($config['slow_statistics'] == true) {
                $port[$port_update][$oid]         = set_numeric($this_port[$oid]);
                $port[$port_update][$oid.'_prev'] = set_numeric($port[$oid]);
            }

            $oid_prev = $oid.'_prev';
            if (isset($port[$oid])) {
                $oid_diff = ($this_port[$oid] - $port[$oid]);
                $oid_rate = ($oid_diff / $polled_period);
                if ($oid_rate < 0) {
                    $oid_rate = '0';
                    echo "negative $oid";
                }

                $port['stats'][$oid.'_rate'] = $oid_rate;
                $port['stats'][$oid.'_diff'] = $oid_diff;

                if ($config['slow_statistics'] == true) {
                    $port[$port_update][$oid.'_rate']  = $oid_rate;
                    $port[$port_update][$oid.'_delta'] = $oid_diff;
                }

                d_echo("\n $oid ($oid_diff B) $oid_rate Bps $polled_period secs\n");
            }//end if
        }//end foreach

        if ($config['debug_port'][$port['port_id']]) {
            $port_debug  = $port['port_id'].'|'.$polled.'|'.$polled_period.'|'.$this_port['ifHCInOctets'].'|'.$this_port['ifHCOutOctets'];
            $port_debug .= '|'.$port['stats']['ifInOctets_rate'].'|'.$port['stats']['ifOutOctets_rate']."\n";
            file_put_contents('/tmp/port_debug.txt', $port_debug, FILE_APPEND);
            echo 'Wrote port debugging data';
        }

        $port['stats']['ifInBits_rate']  = round(($port['stats']['ifInOctets_rate'] * 8));
        $port['stats']['ifOutBits_rate'] = round(($port['stats']['ifOutOctets_rate'] * 8));

        // If we have a valid ifSpeed we should populate the stats for checking.
        if (is_numeric($this_port['ifSpeed'])) {
            $port['stats']['ifInBits_perc']  = round(($port['stats']['ifInBits_rate'] / $this_port['ifSpeed'] * 100));
            $port['stats']['ifOutBits_perc'] = round(($port['stats']['ifOutBits_rate'] / $this_port['ifSpeed'] * 100));
        }

        echo 'bps('.formatRates($port['stats']['ifInBits_rate']).'/'.formatRates($port['stats']['ifOutBits_rate']).')';
        echo 'bytes('.formatStorage($port['stats']['ifInOctets_diff']).'/'.formatStorage($port['stats']['ifOutOctets_diff']).')';
        echo 'pkts('.format_si($port['stats']['ifInUcastPkts_rate']).'pps/'.format_si($port['stats']['ifOutUcastPkts_rate']).'pps)';

        // Port utilisation % threshold alerting. // FIXME allow setting threshold per-port. probably 90% of ports we don't care about.
        if ($config['alerts']['port_util_alert'] && $port['ignore'] == '0') {
            // Check for port saturation of $config['alerts']['port_util_perc'] or higher.  Alert if we see this.
            // Check both inbound and outbound rates
            $saturation_threshold = ($this_port['ifSpeed'] * ( $config['alerts']['port_util_perc'] / 100 ));
            echo 'IN: '.$port['stats']['ifInBits_rate'].' OUT: '.$port['stats']['ifOutBits_rate'].' THRESH: '.$saturation_threshold;
            if (($port['stats']['ifInBits_rate'] >= $saturation_threshold || $port['stats']['ifOutBits_rate'] >= $saturation_threshold) && $saturation_threshold > 0) {
                log_event('Port reached saturation threshold: ' . formatRates($port['stats']['ifInBits_rate']) . '/' . formatRates($port['stats']['ifOutBits_rate']) . ' - ifspeed: ' . formatRates($this_port['stats']['ifSpeed']), $device, 'interface', 4, $port['port_id']);
            }
        }

        // Update data stores
        $rrd_name = getPortRrdName($port_id);
        $rrdfile = rrd_name($device['hostname'], $rrd_name);
        $rrd_def = RrdDefinition::make()
            ->addDataset('INOCTETS', 'DERIVE', 0, 12500000000)
            ->addDataset('OUTOCTETS', 'DERIVE', 0, 12500000000)
            ->addDataset('INERRORS', 'DERIVE', 0, 12500000000)
            ->addDataset('OUTERRORS', 'DERIVE', 0, 12500000000)
            ->addDataset('INUCASTPKTS', 'DERIVE', 0, 12500000000)
            ->addDataset('OUTUCASTPKTS', 'DERIVE', 0, 12500000000)
            ->addDataset('INNUCASTPKTS', 'DERIVE', 0, 12500000000)
            ->addDataset('OUTNUCASTPKTS', 'DERIVE', 0, 12500000000)
            ->addDataset('INDISCARDS', 'DERIVE', 0, 12500000000)
            ->addDataset('OUTDISCARDS', 'DERIVE', 0, 12500000000)
            ->addDataset('INUNKNOWNPROTOS', 'DERIVE', 0, 12500000000)
            ->addDataset('INBROADCASTPKTS', 'DERIVE', 0, 12500000000)
            ->addDataset('OUTBROADCASTPKTS', 'DERIVE', 0, 12500000000)
            ->addDataset('INMULTICASTPKTS', 'DERIVE', 0, 12500000000)
            ->addDataset('OUTMULTICASTPKTS', 'DERIVE', 0, 12500000000);

        $fields = array(
            'INOCTETS'         => $this_port['ifInOctets'],
            'OUTOCTETS'        => $this_port['ifOutOctets'],
            'INERRORS'         => $this_port['ifInErrors'],
            'OUTERRORS'        => $this_port['ifOutErrors'],
            'INUCASTPKTS'      => $this_port['ifInUcastPkts'],
            'OUTUCASTPKTS'     => $this_port['ifOutUcastPkts'],
            'INNUCASTPKTS'     => $this_port['ifInNUcastPkts'],
            'OUTNUCASTPKTS'    => $this_port['ifOutNUcastPkts'],
            'INDISCARDS'       => $this_port['ifInDiscards'],
            'OUTDISCARDS'      => $this_port['ifOutDiscards'],
            'INUNKNOWNPROTOS'  => $this_port['ifInUnknownProtos'],
            'INBROADCASTPKTS'  => $this_port['ifInBroadcastPkts'],
            'OUTBROADCASTPKTS' => $this_port['ifOutBroadcastPkts'],
            'INMULTICASTPKTS'  => $this_port['ifInMulticastPkts'],
            'OUTMULTICASTPKTS' => $this_port['ifOutMulticastPkts'],
        );

        if ($tune_port === true) {
            rrdtool_tune('port', $rrdfile, $this_port['ifSpeed']);
        }

        $port_descr_type = $port['port_descr_type'];
        $ifName = $port['ifName'];
        $tags = compact('ifName', 'port_descr_type', 'rrd_name', 'rrd_def');
        rrdtool_data_update($device, 'ports', $tags, $fields);

        $fields['ifInUcastPkts_rate'] = $port['ifInUcastPkts_rate'];
        $fields['ifOutUcastPkts_rate'] = $port['ifOutUcastPkts_rate'];
        $fields['ifInErrors_rate'] = $port['ifInErrors_rate'];
        $fields['ifOutErrors_rate'] = $port['ifOutErrors_rate'];
        $fields['ifInOctets_rate'] = $port['ifInOctets_rate'];
        $fields['ifOutOctets_rate'] = $port['ifOutOctets_rate'];

        influx_update($device, 'ports', rrd_array_filter($tags), $fields);
        graphite_update($device, 'ports|' . $ifName, $tags, $fields);
        opentsdb_update($device, 'port', array('ifName' => $this_port['ifName'], 'ifIndex' => getPortRrdName($port_id)), $fields);

        // End Update IF-MIB
        // Update PAgP
        if ($this_port['pagpOperationMode'] || $port['pagpOperationMode']) {
            foreach ($pagp_oids as $oid) {
                // Loop the OIDs
                if ($this_port[$oid] != $port[$oid]) {
                    // If data has changed, build a query
                    $port['update'][$oid] = $this_port[$oid];
                    echo 'PAgP ';
                    log_event("$oid -> " . $this_port[$oid], $device, 'interface', 3, $port['port_id']);
                }
            }
        }

        // End Update PAgP
        // Do EtherLike-MIB
        if ($config['enable_ports_etherlike']) {
            include 'ports/port-etherlike.inc.php';
        }

        // Do ADSL MIB
        if ($config['enable_ports_adsl']) {
            include 'ports/port-adsl.inc.php';
        }

        // Do PoE MIBs
        if ($config['enable_ports_poe']) {
            include 'ports/port-poe.inc.php';
        }

        foreach ($port['update'] as $key => $val_check) {
            if (!isset($val_check)) {
                unset($port['update'][$key]);
            }
        }

        // Update Database
        if (count($port['update'])) {
            $updated = dbUpdate($port['update'], 'ports', '`port_id` = ?', array($port_id));
            // do we want to do something else with this?
            $updated += dbUpdate($port['update_extended'], 'ports_statistics', '`port_id` = ?', array($port_id));
            d_echo("$updated updated");
        }
        // End Update Database
    }

    echo "\n";

    // Clear Per-Port Variables Here
    unset($this_port, $port);
} //end port update

// Clear Variables Here
unset($port_stats, $ports_found, $data_oids, $stat_oids, $stat_oids_db, $stat_oids_db_extended, $cisco_oids, $pagp_oids, $ifmib_oids, $hc_test, $ports_mapped, $ports, $_stat_oids, $rrd_def);
