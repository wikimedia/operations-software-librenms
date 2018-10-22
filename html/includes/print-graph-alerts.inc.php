<?php
/*
 * LibreNMS
 *
 * Copyright (c) 2015 Søren Friis Rosiak <sorenrosiak@gmail.com>
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.  Please see LICENSE.txt at the top level of
 * the source code distribution for details.
 */

$pagetitle[] = "Alert Stats";

$sql = "";
if (isset($device['device_id']) && $device['device_id'] > 0) {
    $sql = " AND alert_log.device_id=?";
    $param = array(
        $device['device_id']
    );
}

if ($_SESSION['userlevel'] >= '5') {
    $query = "SELECT DATE_FORMAT(time_logged, '".$config['alert_graph_date_format']."') Date, COUNT(alert_log.rule_id) totalCount, alert_rules.severity Severity FROM alert_log,alert_rules WHERE alert_log.rule_id=alert_rules.id AND `alert_log`.`state` != 0 $sql GROUP BY DATE_FORMAT(time_logged, '".$config['alert_graph_date_format']."'),alert_rules.severity";
}

if ($_SESSION['userlevel'] < '5') {
    $query = "SELECT DATE_FORMAT(time_logged, '".$config['alert_graph_date_format']."') Date, COUNT(alert_log.device_id) totalCount, alert_rules.severity Severity FROM alert_log,alert_rules,devices_perms WHERE alert_log.rule_id=alert_rules.id AND `alert_log`.`state` != 0 $sql AND alert_log.device_id = devices_perms.device_id AND devices_perms.user_id = " . $_SESSION['user_id'] . " GROUP BY DATE_FORMAT(time_logged, '".$config['alert_graph_date_format']."'),alert_rules.severity";
}

?>
<script src="js/vis.min.js"></script>
<div id="visualization"></div>
<script type="text/javascript">

    var container = document.getElementById('visualization');
    <?php
    $groups = array();
    $max_count = 0;

    foreach (dbFetchRows($query, $param) as $return_value) {
        $date = $return_value['Date'];
        $count = $return_value['totalCount'];
        if ($count > $max_count) {
            $max_count = $count;
        }

        $severity = $return_value['Severity'];
        $data[] = array(
        'x' => $date,
        'y' => $count,
        'group' => $severity
            );
        if (!in_array($severity, $groups)) {
            array_push($groups, $severity);
        }
    }

    $graph_data = _json_encode($data);
?>
    var groups = new vis.DataSet();
<?php

foreach ($groups as $group) {
    echo "groups.add({id: '$group', content: '$group' })\n";
}

?>

    var items =
        <?php
        echo $graph_data; ?>
    ;
    var dataset = new vis.DataSet(items);
    var options = {
        style:'bar',
        barChart: { width:50, align:'right', sideBySide:true}, // align: left, center, right
        drawPoints: false,
        legend: {left:{position:"bottom-left"}},
        dataAxis: {
            icons:true,
            showMajorLabels: true,
            showMinorLabels: true,
        },
        zoomMin: 86400, //24hrs
        zoomMax: <?php
        $first_date = reset($data);
        $last_date = end($data);
        $milisec_diff = abs(strtotime($first_date["x"]) - strtotime($last_date["x"])) * 1000;
        echo $milisec_diff;
?>,
        orientation:'top'
    };
    var graph2d = new vis.Graph2d(container, items, groups, options);

</script>
