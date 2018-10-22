<?php

$pagetitle[] = 'Deleted ports';

if ($vars['purge'] == 'all') {
    foreach (dbFetchRows("SELECT * FROM `ports` AS P, `devices` as D WHERE P.`deleted` = '1' AND D.device_id = P.device_id") as $interface) {
        $interface = cleanPort($interface);
        if (port_permitted($interface['port_id'], $interface['device_id'])) {
            delete_port($interface['port_id']);
            echo '<div class=infobox>Deleted '.generate_device_link($interface).' - '.generate_port_link($interface).'</div>';
        }
    }
} elseif ($vars['purge']) {
    $interface = dbFetchRow('SELECT * from `ports` AS P, `devices` AS D WHERE `port_id` = ? AND D.device_id = P.device_id', array($vars['purge']));
    $interface = cleanPort($interface);
    if (port_permitted($interface['port_id'], $interface['device_id'])) {
        delete_port($interface['port_id']);
    }

    echo '<div class=infobox>Deleted '.generate_device_link($interface).' - '.generate_port_link($interface).'</div>';
}

echo '<table class="table table-hover table-condensed">';
echo "<tr><td>Device</td><td>Port</td><td></td><td><a href='deleted-ports/purge=all/'><i class='fa fa-times'></i> Purge All</a></td></tr>";

foreach (dbFetchRows("SELECT * FROM `ports` AS P, `devices` as D WHERE P.`deleted` = '1' AND D.device_id = P.device_id", array(), true) as $interface) {
    $interface = cleanPort($interface, $interface);
    if (port_permitted($interface['port_id'], $interface['device_id'])) {
        echo '<tr class=list>';
        echo '<td width=250>'.generate_device_link($interface).'</td>';
        echo '<td width=250>'.generate_port_link($interface).'</td>';
        echo '<td></td>';
        echo "<td width=100><a href='deleted-ports/purge=".$interface['port_id']."/'><i class='fa fa-times'></i> Purge</a></td>";
    }
}

echo '</table>';
