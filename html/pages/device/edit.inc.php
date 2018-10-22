<?php

$no_refresh = true;
$config['memcached']['enable'] = false;

$link_array = array('page'    => 'device',
    'device'  => $device['device_id'],
    'tab' => 'edit');

if ($_SESSION['userlevel'] < '7') {
    print_error("Insufficient Privileges");
} else {
    $panes['device']   = 'Device Settings';
    $panes['snmp']     = 'SNMP';
    if (!$device['snmp_disable']) {
        $panes['ports']    = 'Port Settings';
    }

    if (count($config['os'][$device['os']]['icons'])) {
        $panes['icon']  = 'Icon';
    }

    if (!$device['snmp_disable']) {
        $panes['apps']     = 'Applications';
    }
    $panes['alerts']   = 'Alert Settings';
    $panes['alert-rules'] = 'Alert Rules';
    if (!$device['snmp_disable']) {
        $panes['modules']  = 'Modules';
    }

    if ($config['show_services']) {
        $panes['services'] = 'Services';
    }

    $panes['ipmi']     = 'IPMI';

    if (dbFetchCell("SELECT COUNT(*) FROM `sensors` WHERE `device_id` = ? AND `sensor_deleted`='0' LIMIT 1", array($device['device_id'])) > 0) {
        $panes['health'] = 'Health';
    }

    if (dbFetchCell("SELECT COUNT(*) FROM `wireless_sensors` WHERE `device_id` = ? AND `sensor_deleted`='0' LIMIT 1", array($device['device_id'])) > 0) {
        $panes['wireless-sensors'] = 'Wireless Sensors';
    }

    if (!$device['snmp_disable']) {
        $panes['storage']  = 'Storage';
        $panes['processors']  = 'Processors';
        $panes['mempools']  = 'Memory';
    }
    $panes['misc']     = 'Misc';

    $panes['component'] = 'Components';

    print_optionbar_start();

    unset($sep);
    foreach ($panes as $type => $text) {
        if (!isset($vars['section'])) {
            $vars['section'] = $type;
        }
        echo($sep);
        if ($vars['section'] == $type) {
            echo("<span class='pagemenu-selected'>");
        } else {
        }

        echo(generate_link($text, $link_array, array('section'=>$type)));

        if ($vars['section'] == $type) {
            echo("</span>");
        }
        $sep = " | ";
    }

    print_optionbar_end();

    if (is_file("pages/device/edit/".mres($vars['section']).".inc.php")) {
        require "pages/device/edit/".mres($vars['section']).".inc.php";
    }
}

$pagetitle[] = "Settings";
