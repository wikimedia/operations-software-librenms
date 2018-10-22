<?php

$where = 1;
$param = array();

$sql = ' FROM `devices`';

if (is_admin() === false && is_read() === false) {
    $sql .= ' LEFT JOIN `devices_perms` AS `DP` ON `devices`.`device_id` = `DP`.`device_id`';
    $where .= ' AND `DP`.`user_id`=?';
    $param[] = $_SESSION['user_id'];
}

if (!empty($_POST['location'])) {
    $sql .= " LEFT JOIN `devices_attribs` AS `DB` ON `DB`.`device_id`=`devices`.`device_id` AND `DB`.`attrib_type`='override_sysLocation_bool' AND `DB`.`attrib_value`='1' LEFT JOIN `devices_attribs` AS `DA` ON `devices`.`device_id`=`DA`.`device_id`";
}

$sql .= " WHERE $where ";

if (!empty($_POST['hostname'])) {
    $sql .= ' AND hostname LIKE ?';
    $param[] = '%' . $_POST['hostname'] . '%';
}

if (!empty($_POST['os'])) {
    $sql .= ' AND os = ?';
    $param[] = $_POST['os'];
}

if (!empty($_POST['version'])) {
    $sql .= ' AND version = ?';
    $param[] = $_POST['version'];
}

if (!empty($_POST['hardware'])) {
    $sql .= ' AND hardware = ?';
    $param[] = $_POST['hardware'];
}

if (!empty($_POST['features'])) {
    $sql .= ' AND features = ?';
    $param[] = $_POST['features'];
}

if (!empty($_POST['type'])) {
    if ($_POST['type'] == 'generic') {
        $sql .= " AND ( type = ? OR type = '')";
        $param[] = $_POST['type'];
    } else {
        $sql .= ' AND type = ?';
        $param[] = $_POST['type'];
    }
}

if (!empty($_POST['state'])) {
    $sql .= ' AND status= ?';
    if (is_numeric($_POST['state'])) {
        $param[] = $_POST['state'];
    } else {
        $param[] = str_replace(array('up', 'down'), array(1, 0), $_POST['state']);
    }
}

if (!empty($_POST['disabled'])) {
    $sql .= ' AND disabled= ?';
    $param[] = $_POST['disabled'];
}

if (!empty($_POST['ignore'])) {
    $sql .= ' AND `ignore`= ?';
    $param[] = $_POST['ignore'];
}

if (!empty($_POST['location']) && $_POST['location'] == 'Unset') {
    $location_filter = '';
}

if (!empty($_POST['location'])) {
    $sql .= " AND `location` = ?";
    $param[] = $_POST['location'];
}

if (!empty($_POST['group'])) {
    include_once '../includes/device-groups.inc.php';
    $sql .= ' AND ( ';
    foreach (GetDevicesFromGroup($_POST['group']) as $dev) {
        $sql .= '`devices`.`device_id` = ? OR ';
        $param[] = $dev;
    }

    $sql = substr($sql, 0, (strlen($sql) - 3));
    $sql .= ' )';
}

$count_sql = "SELECT COUNT(`devices`.`device_id`) $sql";

$total = dbFetchCell($count_sql, $param);
if (empty($total)) {
    $total = 0;
}

if (!isset($sort) || empty($sort)) {
    $sort = '`hostname` DESC';
}

$sql .= " ORDER BY $sort";

if (isset($current)) {
    $limit_low = (($current * $rowCount) - ($rowCount));
    $limit_high = $rowCount;
}

if ($rowCount != -1) {
    $sql .= " LIMIT $limit_low,$limit_high";
}

$sql = "SELECT DISTINCT(`devices`.`device_id`),`devices`.* $sql";

if (!isset($_POST['format'])) {
    $_POST['format'] = 'list_detail';
}

list($format, $subformat) = explode('_', $_POST['format']);

foreach (dbFetchRows($sql, $param) as $device) {
    if (isset($bg) && $bg == $list_colour_b) {
        $bg = $list_colour_a;
    } else {
        $bg = $list_colour_b;
    }

    if ($device['status'] == '0') {
        $extra = 'danger';
        $msg = $device['status_reason'];
    } else {
        $extra = 'success';
        $msg = 'up';
    }

    if ($device['ignore'] == '1') {
        $extra = 'default';
        $msg = 'ignored';
        if ($device['status'] == '1') {
            $extra = 'warning';
            $msg = 'ignored';
        }
    }

    if ($device['disabled'] == '1') {
        $extra = 'default';
        $msg = 'disabled';
    }

    $type = strtolower($device['os']);

    $image = getIconTag($device);

    if ($device['os'] == 'ios') {
        formatCiscoHardware($device, true);
    }

    $device['os_text'] = $config['os'][$device['os']]['text'];
    $port_count = dbFetchCell('SELECT COUNT(*) FROM `ports` WHERE `device_id` = ?', array($device['device_id']));
    $sensor_count = dbFetchCell('SELECT COUNT(*) FROM `sensors` WHERE `device_id` = ?', array($device['device_id']));
    $wireless_count = dbFetchCell('SELECT COUNT(*) FROM `wireless_sensors` WHERE `device_id` = ?', array($device['device_id']));

    $actions = '
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-1"><a href="' . generate_device_url($device) . '"> <i class="fa fa-id-card fa-lg icon-theme" title="View device"></i></a></div>
                <div class="col-xs-1"><a href="' . generate_device_url($device, array('tab' => 'alerts')) . '"> <i class="fa fa-exclamation-circle fa-lg icon-theme" title="View alerts"></i></a></div>
    ';

    if ($_SESSION['userlevel'] >= '7') {
        $actions .= '<div class="col-xs-1"><a href="' . generate_device_url($device, array('tab' => 'edit')) . '"> <i class="fa fa-pencil fa-lg icon-theme" title="Edit device"></i></a></div>';
    }

    if ($subformat == 'detail') {
        $actions .= '</div><div class="row">';
    }

    $actions .= '
                <div class="col-xs-1"><a href="telnet://' . $device['hostname'] . '"><i class="fa fa-terminal fa-lg icon-theme" title="Telnet to ' . $device['hostname'] . '"></i></a></div>
                <div class="col-xs-1"><a href="ssh://' . $device['hostname'] . '"><i class="fa fa-lock fa-lg icon-theme" title="SSH to ' . $device['hostname'] . '"></i></a></div>
                <div class="col-xs-1"><a href="https://' . $device['hostname'] . '" target="_blank" rel="noopener"><i class="fa fa-globe fa-lg icon-theme" title="Launch browser https://' . $device['hostname'] . '"></i></a></div>
            </div>
        </div>
    ';
    $hostname = generate_device_link($device);

    if (extension_loaded('mbstring')) {
        $location = mb_substr($device['location'], 0, 32, 'utf8');
    } else {
        $location = substr($device['location'], 0, 32);
    }

    if ($subformat == 'detail') {
        $platform = $device['hardware'] . '<br>' . $device['features'];
        $os = $device['os_text'] . '<br>' . $device['version'];
        $device['ip'] = inet6_ntop($device['ip']);
        $uptime = formatUptime($device['uptime'], 'short');
        if (format_hostname($device) !== $device['sysName']) {
            $hostname .= '<br />' . $device['sysName'];
        } elseif ($device['hostname'] !== $device['ip']) {
            $hostname .= '<br />' . $device['hostname'];
        }

        $metrics = array();
        if ($port_count) {
            $port_widget = '<a href="' . generate_device_url($device, array('tab' => 'ports')) . '">';
            $port_widget .= '<span><i class="fa fa-link fa-lg icon-theme"></i> ' . $port_count;
            $port_widget .= '</span></a> ';
            $metrics[] = $port_widget;
        }

        if ($sensor_count) {
            $sensor_widget = '<a href="' . generate_device_url($device, array('tab' => 'health')) . '">';
            $sensor_widget .= '<span><i class="fa fa-dashboard fa-lg icon-theme"></i> ' . $sensor_count;
            $sensor_widget .= '</span></a> ';
            $metrics[] = $sensor_widget;
        }

        if ($wireless_count) {
            $wireless_widget = '<a href="' . generate_device_url($device, array('tab' => 'wireless')) . '">';
            $wireless_widget .= '<span><i class="fa fa-wifi fa-lg icon-theme"></i> ' . $wireless_count;
            $wireless_widget .= '</span></a> ';
            $metrics[] = $wireless_widget;
        }

        $col_port = '<div class="device-table-metrics">';
        $col_port .= implode(count($metrics) == 2 ? '<br />' : '', $metrics);
        $col_port .= '</div>';
    } else {
        $platform = $device['hardware'];
        $os = $device['os_text'] . ' ' . $device['version'];
        $uptime = formatUptime($device['uptime'], 'short');
        $col_port = '';
    }

    $response[] = array(
        'extra' => $extra,
        'msg' => $msg,
        'list_type' => $subformat,
        'icon' => $image,
        'hostname' => $hostname,
        'ports' => $col_port,
        'hardware' => $platform,
        'os' => $os,
        'uptime' => $uptime,
        'location' => $location,
        'actions' => $actions,
    );
}//end foreach

$output = array(
    'current' => $current,
    'rowCount' => $rowCount,
    'rows' => $response,
    'total' => $total,
);
echo _json_encode($output);
