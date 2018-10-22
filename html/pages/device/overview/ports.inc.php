<?php

if ($ports['total']) {
    echo '<div class="container-fluid">';
    echo '<div class="row">
          <div class="col-md-12">
            <div class="panel panel-default panel-condensed">
              <div class="panel-heading">
              <i class="fa fa-road fa-lg icon-theme" aria-hidden="true"></i><strong> Overall Traffic</strong>
            </div>
            <table class="table table-hover table-condensed table-striped">';

    if ($_SESSION['screen_width']) {
        if ($_SESSION['screen_width'] > 970) {
            $graph_array['width'] = round(($_SESSION['screen_width'] - 390 )/2, 0);
            $graph_array['height'] = round($graph_array['width'] /3);
            $graph_array['lazy_w'] = $graph_array['width'] + 80;
        } else {
            $graph_array['width'] = $_SESSION['screen_width'] - 190;
            $graph_array['height'] = round($graph_array['width'] /3);
            $graph_array['lazy_w'] = $graph_array['width'] + 80;
        }
    }

    $graph_array['to']     = $config['time']['now'];
    $graph_array['device'] = $device['device_id'];
    $graph_array['type']   = 'device_bits';
    $graph_array['from']   = $config['time']['day'];
    $graph_array['legend'] = 'no';
    $graph = generate_lazy_graph_tag($graph_array);

    #Generate tooltip
    $graph_array['width'] = 210;
    $graph_array['height'] = 100;
    $link_array         = $graph_array;
    $link_array['page'] = 'graphs';
    unset($link_array['height'], $link_array['width']);
    $link = generate_url($link_array);

    $graph_array['width'] = '210';
    $overlib_content      = generate_overlib_content($graph_array, $device['hostname'].' - Device Traffic');

    echo '<tr>
          <td colspan="4">';
    echo overlib_link($link, $graph, $overlib_content, null);
    echo '  </td>
        </tr>';

    echo '
    <tr>
      <td><i class="fa fa-link fa-lg" style="color:black" aria-hidden="true"></i> '.$ports['total'].'</td>
      <td><i class="fa fa-link fa-lg interface-upup" aria-hidden="true"></i> '.$ports['up'].'</td>
      <td><i class="fa fa-link fa-lg interface-updown" aria-hidden="true"></i> '.$ports['down'].'</td>
      <td><i class="fa fa-link fa-lg interface-admindown" aria-hidden="true"></i> '.$ports['disabled'].'</td>
    </tr>';

    echo '<tr>
          <td colspan="4">';

    $ifsep = '';

    foreach (dbFetchRows("SELECT * FROM `ports` WHERE device_id = ? AND `deleted` != '1'", array($device['device_id'])) as $data) {
        $data = cleanPort($data);
        $data = array_merge($data, $device);
        echo "$ifsep".generate_port_link($data, makeshortif(strtolower($data['label'])));
        $ifsep = ', ';
    }

    unset($ifsep);
    echo '  </td>';
    echo '</tr>';
    echo '</table>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}//end if
