<?php

unset($vars['page']);

// Setup here

if ($_SESSION['widescreen']) {
    $graph_width=1700;
    $thumb_width=180;
} else {
    $graph_width=1075;
    $thumb_width=113;
}

if (!is_numeric($vars['from'])) {
    $vars['from'] = $config['time']['day'];
}
if (!is_numeric($vars['to'])) {
    $vars['to']   = $config['time']['now'];
}

preg_match('/^(?P<type>[A-Za-z0-9]+)_(?P<subtype>.+)/', $vars['type'], $graphtype);

$type = $graphtype['type'];
$subtype = $graphtype['subtype'];
$id = $vars['id'];

if (is_numeric($vars['device'])) {
    $device = device_by_id_cache($vars['device']);
} elseif (!empty($vars['device'])) {
    $device = device_by_name($vars['device']);
}

if (is_file("includes/graphs/".$type."/auth.inc.php")) {
    require "includes/graphs/".$type."/auth.inc.php";
}

if (!$auth) {
    require 'includes/error-no-perm.inc.php';
} else {
    if (isset($config['graph_types'][$type][$subtype]['descr'])) {
        $title .= " :: " . $config['graph_types'][$type][$subtype]['descr'];
    } else {
        $title .= " :: " . ucfirst($subtype);
    }

    $graph_array = $vars;
    $graph_array['height'] = "60";
    $graph_array['width'] = $thumb_width;
    $graph_array['legend'] = "no";
    $graph_array['to'] = $config['time']['now'];

    print_optionbar_start();
    echo $title;

    // FIXME allow switching between types for sensor and wireless also restrict types to ones that have data
    if ($type != 'sensor') {
        echo '<div style="float: right;"><form action="">';
        echo "<select name='type' id='type' onchange=\"window.open(this.options[this.selectedIndex].value,'_top')\" >";

        foreach (get_graph_subtypes($type, $device) as $avail_type) {
            echo "<option value='" . generate_url($vars, array('type' => $type . "_" . $avail_type, 'page' => "graphs")) . "'";
            if ($avail_type == $subtype) {
                echo(" selected");
            }
            $display_type = is_mib_graph($type, $avail_type) ? $avail_type : nicecase($avail_type);
            echo ">$display_type</option>";
        }
        echo '</select></form></div>';
    }

    print_optionbar_end();

    print_optionbar_start();

    $thumb_array = $config['graphs']['row']['normal'];

    echo '<table width=100% class="thumbnail_graph_table"><tr>';

    foreach ($thumb_array as $period => $text) {
        $graph_array['from']   = $config['time'][$period];

        $link_array = $vars;
        $link_array['from'] = $graph_array['from'];
        $link_array['to'] = $graph_array['to'];
        $link_array['page'] = "graphs";
        $link = generate_url($link_array);

        echo('<td align=center>');
        echo('<b>'.$text.'</b><br>');
        echo('<a href="'.$link.'">');
        echo generate_lazy_graph_tag($graph_array);
        echo('</a>');
        echo('</td>');
    }

    echo('</tr></table>');

    $graph_array = $vars;
    $graph_array['height'] = $config['webui']['min_graph_height'];
    $graph_array['width']  = $graph_width;

    if ($_SESSION['screen_width']) {
        if ($_SESSION['screen_width'] > 800) {
            $graph_array['width'] = ($_SESSION['screen_width'] - ($_SESSION['screen_width']/10));
        } else {
            $graph_array['width'] = ($_SESSION['screen_width'] - ($_SESSION['screen_width']/4));
        }
    }

    if ($_SESSION['screen_height']) {
        if ($_SESSION['screen_height'] > 960) {
            $graph_array['height'] = ($_SESSION['screen_height'] - ($_SESSION['screen_height']/2));
        } else {
            $graph_array['height'] = max($graph_array['height'], ($_SESSION['screen_height'] - ($_SESSION['screen_height']/1.5)));
        }
    }

    echo("<hr />");

    include_once 'includes/print-date-selector.inc.php';

    echo ('<div style="padding-top: 5px";></div>');
    echo('<center>');
    if ($vars['legend'] == "no") {
        echo(generate_link("Show Legend", $vars, array('page' => "graphs", 'legend' => null)));
    } else {
        echo(generate_link("Hide Legend", $vars, array('page' => "graphs", 'legend' => "no")));
    }

    // FIXME : do this properly
    #  if ($type == "port" && $subtype == "bits")
    #  {
    echo(' | ');
    if ($vars['previous'] == "yes") {
        echo(generate_link("Hide Previous", $vars, array('page' => "graphs", 'previous' => null)));
    } else {
        echo(generate_link("Show Previous", $vars, array('page' => "graphs", 'previous' => "yes")));
    }
    #  }

    echo(' | ');
    if ($vars['showcommand'] == "yes") {
        echo(generate_link("Hide RRD Command", $vars, array('page' => "graphs", 'showcommand' => null)));
    } else {
        echo(generate_link("Show RRD Command", $vars, array('page' => "graphs", 'showcommand' => "yes")));
    }
    echo('</center>');

    print_optionbar_end();

    echo generate_graph_js_state($graph_array);

    echo('<div style="width: '.$graph_array['width'].'; margin: auto;"><center>');
    echo generate_lazy_graph_tag($graph_array);
    echo("</center></div>");

    if (isset($config['graph_descr'][$vars['type']])) {
        print_optionbar_start();
        echo('<div style="float: left; width: 30px;">
            <div style="margin: auto auto;">
            <i class="fa fa-info-circle fa-lg icon-theme" aria-hidden="true"></i>
            </div>
            </div>');
        echo($config['graph_descr'][$vars['type']]);
        print_optionbar_end();
    }

    if ($vars['showcommand']) {
        $_GET = $graph_array;
        $command_only = 1;

        require 'includes/graphs/graph.inc.php';
    }
}
