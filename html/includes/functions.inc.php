<?php

/**
 * LibreNMS
 *
 *   This file is part of LibreNMS
 *
 * @package    librenms
 * @subpackage functions
 * @author     LibreNMS Contributors <librenms-project@google.groups.com>
 * @copyright  (C) 2006 - 2012 Adam Armstrong (as Observium)
 * @copyright  (C) 2013 LibreNMS Group
 */

/**
 * Compare $t with the value of $vars[$v], if that exists
 * @param string $v Name of the var to test
 * @param string $t Value to compare $vars[$v] to
 * @return boolean true, if values are the same, false if $vars[$v] is unset or values differ
 */
function var_eq($v, $t)
{
    global $vars;
    if (isset($vars[$v]) && $vars[$v] == $t) {
        return true;
    }

    return false;
}

/**
 * Get the value of $vars[$v], if it exists
 * @param string $v Name of the var to get
 * @return string|boolean The value of $vars[$v] if it exists, false if it does not exist
 */
function var_get($v)
{
    global $vars;
    if (isset($vars[$v])) {
        return $vars[$v];
    }

    return false;
}


function data_uri($file, $mime)
{
    $contents = file_get_contents($file);
    $base64   = base64_encode($contents);
    return ('data:'.$mime.';base64,'.$base64);
}//end data_uri()


function nicecase($item)
{
    switch ($item) {
        case 'dbm':
            return 'dBm';

        case 'mysql':
            return ' MySQL';

        case 'powerdns':
            return 'PowerDNS';

        case 'bind':
            return 'BIND';

        case 'nfs-stats':
            return 'NFS Stats';

        case 'nfs-v3-stats':
            return 'NFS v3 Stats';

        case 'nfs-server':
            return 'NFS Server';

        case 'ntp':
            return 'NTP';

        case 'ntp-client':
            return 'NTP Client';

        case 'ntp-server':
            return 'NTP Server';

        case 'os-updates':
            return 'OS Updates';

        case 'powerdns-recursor':
            return 'PowerDNS Recursor';

        case 'dhcp-stats':
            return 'DHCP Stats';

        case 'ups-nut':
            return 'UPS nut';

        case 'ups-apcups':
            return 'UPS apcups';

        case 'gpsd':
            return 'GPSD';

        case 'exim-stats':
            return 'EXIM Stats';

        case 'fbsd-nfs-client':
            return 'FreeBSD NFS Client';

        case 'fbsd-nfs-server':
            return 'FreeBSD NFS Server';

        case 'php-fpm':
            return 'PHP-FPM';

        case 'opengridscheduler':
            return 'Open Grid Scheduler';

        case 'sdfsinfo':
            return 'SDFS info';

        case 'pi-hole':
            return 'Pi-hole';

        default:
            return ucfirst($item);
    }
}//end nicecase()


function toner2colour($descr, $percent)
{
    $colour = get_percentage_colours(100 - $percent);

    if (substr($descr, -1) == 'C' || stripos($descr, 'cyan') !== false) {
        $colour['left']  = '55D6D3';
        $colour['right'] = '33B4B1';
    }

    if (substr($descr, -1) == 'M' || stripos($descr, 'magenta') !== false) {
        $colour['left']  = 'F24AC8';
        $colour['right'] = 'D028A6';
    }

    if (substr($descr, -1) == 'Y' || stripos($descr, 'yellow') !== false
        || stripos($descr, 'giallo') !== false
        || stripos($descr, 'gul') !== false
    ) {
        $colour['left']  = 'FFF200';
        $colour['right'] = 'DDD000';
    }

    if (substr($descr, -1) == 'K' || stripos($descr, 'black') !== false
        || stripos($descr, 'nero') !== false
    ) {
        $colour['left']  = '000000';
        $colour['right'] = '222222';
    }

    return $colour;
}//end toner2colour()


/**
 * Find all links in some text and turn them into html links.
 *
 * @param string $text
 * @return string
 */
function linkify($text)
{
    $regex = "/(http|https|ftp|ftps):\/\/[a-z0-9\-.]+\.[a-z]{2,5}(\/\S*)?/i";

    return preg_replace($regex, '<a href="$0">$0</a>', $text);
}


function generate_link($text, $vars, $new_vars = array())
{
    return '<a href="'.generate_url($vars, $new_vars).'">'.$text.'</a>';
}//end generate_link()


function generate_url($vars, $new_vars = array())
{
    $vars = array_merge($vars, $new_vars);

    $url = $vars['page'].'/';
    unset($vars['page']);

    foreach ($vars as $var => $value) {
        if ($value == '0' || $value != '' && strstr($var, 'opt') === false && is_numeric($var) === false) {
            $url .= $var.'='.urlencode($value).'/';
        }
    }

    return ($url);
}//end generate_url()


function escape_quotes($text)
{
    return str_replace('"', "\'", str_replace("'", "\'", $text));
}//end escape_quotes()


function generate_overlib_content($graph_array, $text)
{
    global $config;

    $overlib_content = '<div class=overlib><span class=overlib-text>'.$text.'</span><br />';
    foreach (array('day', 'week', 'month', 'year') as $period) {
        $graph_array['from'] = $config['time'][$period];
        $overlib_content    .= escape_quotes(generate_graph_tag($graph_array));
    }

    $overlib_content .= '</div>';

    return $overlib_content;
}//end generate_overlib_content()


function get_percentage_colours($percentage, $component_perc_warn = null)
{
    $perc_warn = '75';

    if (isset($component_perc_warn)) {
        $perc_warn = round($component_perc_warn, 0);
    }

    $background = array();
    if ($percentage > $perc_warn) {
        $background['left']  = 'c4323f';
        $background['right'] = 'C96A73';
    } elseif ($percentage > '75') {
        $background['left']  = 'bf5d5b';
        $background['right'] = 'd39392';
    } elseif ($percentage > '50') {
        $background['left']  = 'bf875b';
        $background['right'] = 'd3ae92';
    } elseif ($percentage > '25') {
        $background['left']  = '5b93bf';
        $background['right'] = '92b7d3';
    } else {
        $background['left']  = '9abf5b';
        $background['right'] = 'bbd392';
    }

    return ($background);
}//end get_percentage_colours()


function generate_minigraph_image($device, $start, $end, $type, $legend = 'no', $width = 275, $height = 100, $sep = '&amp;', $class = 'minigraph-image', $absolute_size = 0)
{
    return '<img class="'.$class.'" width="'.$width.'" height="'.$height.'" src="graph.php?'.implode($sep, array('device='.$device['device_id'], "from=$start", "to=$end", "width=$width", "height=$height", "type=$type", "legend=$legend", "absolute=$absolute_size")).'">';
}//end generate_minigraph_image()


function generate_device_url($device, $vars = array())
{
    return generate_url(array('page' => 'device', 'device' => $device['device_id']), $vars);
}//end generate_device_url()


function generate_device_link($device, $text = null, $vars = array(), $start = 0, $end = 0, $escape_text = 1, $overlib = 1)
{
    global $config;

    if (!$start) {
        $start = $config['time']['day'];
    }

    if (!$end) {
        $end = $config['time']['now'];
    }

    $class = devclass($device);
    if (!$text) {
        $text = $device['hostname'];
    }

    $text = format_hostname($device, $text);

    if ($device['snmp_disable']) {
        $graphs = $config['os']['ping']['over'];
    } elseif (isset($config['os'][$device['os']]['over'])) {
        $graphs = $config['os'][$device['os']]['over'];
    } elseif (isset($device['os_group']) && isset($config['os'][$device['os_group']]['over'])) {
        $graphs = $config['os'][$device['os_group']]['over'];
    } else {
        $graphs = $config['os']['default']['over'];
    }

    $url = generate_device_url($device, $vars);

    // beginning of overlib box contains large hostname followed by hardware & OS details
    $contents = '<div><span class="list-large">'.$device['hostname'].'</span>';
    if ($device['hardware']) {
        $contents .= ' - '.$device['hardware'];
    }

    if ($device['os']) {
        $contents .= ' - '.mres($config['os'][$device['os']]['text']);
    }

    if ($device['version']) {
        $contents .= ' '.mres($device['version']);
    }

    if ($device['features']) {
        $contents .= ' ('.mres($device['features']).')';
    }

    if (isset($device['location'])) {
        $contents .= ' - '.htmlentities($device['location']);
    }

    $contents .= '</div>';

    foreach ($graphs as $entry) {
        $graph         = $entry['graph'];
        $graphhead = $entry['text'];
        $contents .= '<div class="overlib-box">';
        $contents .= '<span class="overlib-title">'.$graphhead.'</span><br />';
        $contents .= generate_minigraph_image($device, $start, $end, $graph);
        $contents .= generate_minigraph_image($device, $config['time']['week'], $end, $graph);
        $contents .= '</div>';
    }

    if ($escape_text) {
        $text = htmlentities($text);
    }

    if ($overlib == 0) {
        $link = $contents;
    } else {
        $link = overlib_link($url, $text, escape_quotes($contents), $class);
    }

    if (device_permitted($device['device_id'])) {
        return $link;
    } else {
        return $device['hostname'];
    }
}//end generate_device_link()


function overlib_link($url, $text, $contents, $class = null)
{
    global $config;

    $contents = "<div style=\'background-color: #FFFFFF;\'>".$contents.'</div>';
    $contents = str_replace('"', "\'", $contents);
    if ($class === null) {
        $output   = '<a href="'.$url.'"';
    } else {
        $output   = '<a class="'.$class.'" href="'.$url.'"';
    }

    if ($config['web_mouseover'] === false) {
        $output .= '>';
    } else {
        $output .= " onmouseover=\"return overlib('".$contents."'".$config['overlib_defaults'].",WRAP,HAUTO,VAUTO); \" onmouseout=\"return nd();\">";
    }

    $output .= $text.'</a>';

    return $output;
}//end overlib_link()


function generate_graph_popup($graph_array)
{
    global $config;

    // Take $graph_array and print day,week,month,year graps in overlib, hovered over graph
    $original_from = $graph_array['from'];

    $graph                 = generate_graph_tag($graph_array);
    $content               = '<div class=list-large>'.$graph_array['popup_title'].'</div>';
    $content              .= "<div style=\'width: 850px\'>";
    $graph_array['legend'] = 'yes';
    $graph_array['height'] = '100';
    $graph_array['width']  = '340';
    $graph_array['from']   = $config['time']['day'];
    $content              .= generate_graph_tag($graph_array);
    $graph_array['from']   = $config['time']['week'];
    $content              .= generate_graph_tag($graph_array);
    $graph_array['from']   = $config['time']['month'];
    $content              .= generate_graph_tag($graph_array);
    $graph_array['from']   = $config['time']['year'];
    $content              .= generate_graph_tag($graph_array);
    $content              .= '</div>';

    $graph_array['from'] = $original_from;

    $graph_array['link'] = generate_url($graph_array, array('page' => 'graphs', 'height' => null, 'width' => null, 'bg' => null));

    // $graph_array['link'] = "graphs/type=" . $graph_array['type'] . "/id=" . $graph_array['id'];
    return overlib_link($graph_array['link'], $graph, $content, null);
}//end generate_graph_popup()


function print_graph_popup($graph_array)
{
    echo generate_graph_popup($graph_array);
}//end print_graph_popup()


function permissions_cache($user_id)
{
    $permissions = array();
    foreach (dbFetchRows("SELECT * FROM devices_perms WHERE user_id = '".$user_id."'") as $device) {
        $permissions['device'][$device['device_id']] = 1;
    }

    foreach (dbFetchRows("SELECT * FROM ports_perms WHERE user_id = '".$user_id."'") as $port) {
        $permissions['port'][$port['port_id']] = 1;
    }

    foreach (dbFetchRows("SELECT * FROM bill_perms WHERE user_id = '".$user_id."'") as $bill) {
        $permissions['bill'][$bill['bill_id']] = 1;
    }

    return $permissions;
}//end permissions_cache()


function bill_permitted($bill_id)
{
    global $permissions;

    if ($_SESSION['userlevel'] >= '5') {
        $allowed = true;
    } elseif ($permissions['bill'][$bill_id]) {
        $allowed = true;
    } else {
        $allowed = false;
    }

    return $allowed;
}//end bill_permitted()


function port_permitted($port_id, $device_id = null)
{
    global $permissions;

    if (!is_numeric($device_id)) {
        $device_id = get_device_id_by_port_id($port_id);
    }

    if ($_SESSION['userlevel'] >= '5') {
        $allowed = true;
    } elseif (device_permitted($device_id)) {
        $allowed = true;
    } elseif ($permissions['port'][$port_id]) {
        $allowed = true;
    } else {
        $allowed = false;
    }

    return $allowed;
}//end port_permitted()


function application_permitted($app_id, $device_id = null)
{
    global $permissions;

    if (is_numeric($app_id)) {
        if (!$device_id) {
            $device_id = get_device_id_by_app_id($app_id);
        }

        if ($_SESSION['userlevel'] >= '5') {
            $allowed = true;
        } elseif (device_permitted($device_id)) {
            $allowed = true;
        } elseif ($permissions['application'][$app_id]) {
            $allowed = true;
        } else {
            $allowed = false;
        }
    } else {
        $allowed = false;
    }

    return $allowed;
}//end application_permitted()


function device_permitted($device_id)
{
    global $permissions;

    if ($_SESSION['userlevel'] >= '5') {
        $allowed = true;
    } elseif ($permissions['device'][$device_id]) {
        $allowed = true;
    } else {
        $allowed = false;
    }

    return $allowed;
}//end device_permitted()


function print_graph_tag($args)
{
    echo generate_graph_tag($args);
}//end print_graph_tag()


function generate_graph_tag($args)
{
    $urlargs = array();
    foreach ($args as $key => $arg) {
        $urlargs[] = $key.'='.urlencode($arg);
    }

    return '<img src="graph.php?'.implode('&amp;', $urlargs).'" border="0" />';
}//end generate_graph_tag()

function generate_lazy_graph_tag($args)
{
    global $config;
    $urlargs = array();
    $w = 0;
    $h = 0;
    foreach ($args as $key => $arg) {
        switch (strtolower($key)) {
            case 'width':
                $w = $arg;
                break;
            case 'height':
                $h = $arg;
                break;
            case 'lazy_w':
                $lazy_w = $arg;
                break;
        }
        $urlargs[] = $key."=".urlencode($arg);
    }

    if (isset($lazy_w)) {
        $w=$lazy_w;
    }

    if ($config['enable_lazy_load'] === true) {
        return '<img class="lazy img-responsive" data-original="graph.php?' . implode('&amp;', $urlargs).'" border="0" />';
    } else {
        return '<img class="img-responsive" src="graph.php?' . implode('&amp;', $urlargs).'" border="0" />';
    }
}//end generate_lazy_graph_tag()


function generate_graph_js_state($args)
{
    // we are going to assume we know roughly what the graph url looks like here.
    // TODO: Add sensible defaults
    $from   = (is_numeric($args['from']) ? $args['from'] : 0);
    $to     = (is_numeric($args['to']) ? $args['to'] : 0);
    $width  = (is_numeric($args['width']) ? $args['width'] : 0);
    $height = (is_numeric($args['height']) ? $args['height'] : 0);
    $legend = str_replace("'", '', $args['legend']);

    $state = <<<STATE
<script type="text/javascript" language="JavaScript">
document.graphFrom = $from;
document.graphTo = $to;
document.graphWidth = $width;
document.graphHeight = $height;
document.graphLegend = '$legend';
</script>
STATE;

    return $state;
}//end generate_graph_js_state()


function print_percentage_bar($width, $height, $percent, $left_text, $left_colour, $left_background, $right_text, $right_colour, $right_background)
{
    if ($percent > '100') {
        $size_percent = '100';
    } else {
        $size_percent = $percent;
    }

    $output = '
        <div class="container" style="width:'.$width.'px; height:'.$height.'px;">
        <div class="progress" style="min-width: 2em; background-color:#'.$right_background.'; height:'.$height.'px;">
        <div class="progress-bar" role="progressbar" aria-valuenow="'.$size_percent.'" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em; width:'.$size_percent.'%; background-color: #'.$left_background.';">
        </div>
        </div>
        <b class="pull-left" style="padding-left: 4px; height: '.$height.'px;margin-top:-'.($height * 2).'px; color:#'.$left_colour.';">'.$left_text.'</b>
        <b class="pull-right" style="padding-right: 4px; height: '.$height.'px;margin-top:-'.($height * 2).'px; color:#'.$right_colour.';">'.$right_text.'</b>
        </div>
        ';

    return $output;
}//end print_percentage_bar()


function generate_entity_link($type, $entity, $text = null, $graph_type = null)
{
    global $config, $entity_cache;

    if (is_numeric($entity)) {
        $entity = get_entity_by_id_cache($type, $entity);
    }

    switch ($type) {
        case 'port':
            $link = generate_port_link($entity, $text, $graph_type);
            break;

        case 'storage':
            if (empty($text)) {
                $text = $entity['storage_descr'];
            }

            $link = generate_link($text, array('page' => 'device', 'device' => $entity['device_id'], 'tab' => 'health', 'metric' => 'storage'));
            break;

        default:
            $link = $entity[$type.'_id'];
    }

    return ($link);
}//end generate_entity_link()


function generate_port_link($port, $text = null, $type = null, $overlib = 1, $single_graph = 0)
{
    global $config;

    $graph_array = array();

    if (!$text) {
        $text = fixifName($port['label']);
    }

    if ($type) {
        $port['graph_type'] = $type;
    }

    if (!isset($port['graph_type'])) {
        $port['graph_type'] = 'port_bits';
    }

    $class = ifclass($port['ifOperStatus'], $port['ifAdminStatus']);

    if (!isset($port['hostname'])) {
        $port = array_merge($port, device_by_id_cache($port['device_id']));
    }

    $content = '<div class=list-large>'.$port['hostname'].' - '.fixifName(addslashes(display($port['label']))).'</div>';
    if ($port['ifAlias']) {
        $content .= addslashes(display($port['ifAlias'])).'<br />';
    }

    $content              .= "<div style=\'width: 850px\'>";
    $graph_array['type']   = $port['graph_type'];
    $graph_array['legend'] = 'yes';
    $graph_array['height'] = '100';
    $graph_array['width']  = '340';
    $graph_array['to']     = $config['time']['now'];
    $graph_array['from']   = $config['time']['day'];
    $graph_array['id']     = $port['port_id'];
    $content              .= generate_graph_tag($graph_array);
    if ($single_graph == 0) {
        $graph_array['from'] = $config['time']['week'];
        $content            .= generate_graph_tag($graph_array);
        $graph_array['from'] = $config['time']['month'];
        $content            .= generate_graph_tag($graph_array);
        $graph_array['from'] = $config['time']['year'];
        $content            .= generate_graph_tag($graph_array);
    }

    $content .= '</div>';

    $url = generate_port_url($port);

    if ($overlib == 0) {
        return $content;
    } elseif (port_permitted($port['port_id'], $port['device_id'])) {
        return overlib_link($url, $text, $content, $class);
    } else {
        return fixifName($text);
    }
}//end generate_port_link()


function generate_port_url($port, $vars = array())
{
    return generate_url(array('page' => 'device', 'device' => $port['device_id'], 'tab' => 'port', 'port' => $port['port_id']), $vars);
}//end generate_port_url()


function generate_peer_url($peer, $vars = array())
{
    return generate_url(array('page' => 'device', 'device' => $peer['device_id'], 'tab' => 'routing', 'proto' => 'bgp'), $vars);
}//end generate_peer_url()


function generate_bill_url($bill, $vars = array())
{
    return generate_url(array('page' => 'bill', 'bill_id' => $bill['bill_id']), $vars);
}//end generate_bill_url()


function generate_port_image($args)
{
    if (!$args['bg']) {
        $args['bg'] = 'FFFFFF00';
    }

    return "<img src='graph.php?type=".$args['graph_type'].'&amp;id='.$args['port_id'].'&amp;from='.$args['from'].'&amp;to='.$args['to'].'&amp;width='.$args['width'].'&amp;height='.$args['height'].'&amp;bg='.$args['bg']."'>";
}//end generate_port_image()


function generate_port_thumbnail($port)
{
    global $config;
    $port['graph_type'] = 'port_bits';
    $port['from']       = $config['time']['day'];
    $port['to']         = $config['time']['now'];
    $port['width']      = 150;
    $port['height']     = 21;
    return generate_port_image($port);
}//end generate_port_thumbnail()


function print_port_thumbnail($args)
{
    echo generate_port_link($args, generate_port_image($args));
}//end print_port_thumbnail()


function print_optionbar_start($height = 0, $width = 0, $marginbottom = 5)
{
    echo '
        <div class="well well-sm">
        ';
}//end print_optionbar_start()


function print_optionbar_end()
{
    echo '  </div>';
}//end print_optionbar_end()


function overlibprint($text)
{
    return "onmouseover=\"return overlib('".$text."');\" onmouseout=\"return nd();\"";
}//end overlibprint()


function humanmedia($media)
{
    global $rewrite_iftype;
    array_preg_replace($rewrite_iftype, $media);
    return $media;
}//end humanmedia()


function humanspeed($speed)
{
    $speed = formatRates($speed);
    if ($speed == '') {
        $speed = '-';
    }

    return $speed;
}//end humanspeed()


function devclass($device)
{
    if (isset($device['status']) && $device['status'] == '0') {
        $class = 'list-device-down';
    } else {
        $class = 'list-device';
    }

    if (isset($device['ignore']) && $device['ignore'] == '1') {
        $class = 'list-device-ignored';
        if (isset($device['status']) && $device['status'] == '1') {
            $class = 'list-device-ignored-up';
        }
    }

    if (isset($device['disabled']) && $device['disabled'] == '1') {
        $class = 'list-device-disabled';
    }

    return $class;
}//end devclass()


function getlocations()
{
    $locations           = array();

    // Fetch regular locations
    if ($_SESSION['userlevel'] >= '5') {
        $rows = dbFetchRows('SELECT location FROM devices AS D GROUP BY location ORDER BY location');
    } else {
        $rows = dbFetchRows('SELECT location FROM devices AS D, devices_perms AS P WHERE D.device_id = P.device_id AND P.user_id = ? GROUP BY location ORDER BY location', array($_SESSION['user_id']));
    }

    foreach ($rows as $row) {
        // Only add it as a location if it wasn't overridden (and not already there)
        if ($row['location'] != '') {
            if (!in_array($row['location'], $locations)) {
                $locations[] = $row['location'];
            }
        }
    }

    sort($locations);
    return $locations;
}//end getlocations()


function foldersize($path)
{
    $total_size  = 0;
    $files       = scandir($path);
    $total_files = 0;

    foreach ($files as $t) {
        if (is_dir(rtrim($path, '/').'/'.$t)) {
            if ($t <> '.' && $t <> '..') {
                $size        = foldersize(rtrim($path, '/').'/'.$t);
                $total_size += $size;
            }
        } else {
            $size        = filesize(rtrim($path, '/').'/'.$t);
            $total_size += $size;
            $total_files++;
        }
    }

    return array(
        $total_size,
        $total_files,
    );
}//end foldersize()


function generate_ap_link($args, $text = null, $type = null)
{
    global $config;

    $args = cleanPort($args);
    if (!$text) {
        $text = fixIfName($args['label']);
    }

    if ($type) {
        $args['graph_type'] = $type;
    }

    if (!isset($args['graph_type'])) {
        $args['graph_type'] = 'port_bits';
    }

    if (!isset($args['hostname'])) {
        $args = array_merge($args, device_by_id_cache($args['device_id']));
    }

    $content = '<div class=list-large>'.$args['text'].' - '.fixifName($args['label']).'</div>';
    if ($args['ifAlias']) {
        $content .= display($args['ifAlias']).'<br />';
    }

    $content              .= "<div style=\'width: 850px\'>";
    $graph_array           = array();
    $graph_array['type']   = $args['graph_type'];
    $graph_array['legend'] = 'yes';
    $graph_array['height'] = '100';
    $graph_array['width']  = '340';
    $graph_array['to']     = $config['time']['now'];
    $graph_array['from']   = $config['time']['day'];
    $graph_array['id']     = $args['accesspoint_id'];
    $content              .= generate_graph_tag($graph_array);
    $graph_array['from']   = $config['time']['week'];
    $content              .= generate_graph_tag($graph_array);
    $graph_array['from']   = $config['time']['month'];
    $content              .= generate_graph_tag($graph_array);
    $graph_array['from']   = $config['time']['year'];
    $content              .= generate_graph_tag($graph_array);
    $content              .= '</div>';

    $url = generate_ap_url($args);
    if (port_permitted($args['interface_id'], $args['device_id'])) {
        return overlib_link($url, $text, $content, null);
    } else {
        return fixifName($text);
    }
}//end generate_ap_link()


function generate_ap_url($ap, $vars = array())
{
    return generate_url(array('page' => 'device', 'device' => $ap['device_id'], 'tab' => 'accesspoint', 'ap' => $ap['accesspoint_id']), $vars);
}//end generate_ap_url()

function report_this_text($message)
{
    global $config;
    return $message.'\nPlease report this to the '.$config['project_name'].' developers at '.$config['project_issues'].'\n';
}//end report_this_text()


// Find all the files in the given directory that match the pattern


function get_matching_files($dir, $match = '/\.php$/')
{
    global $config;

    $list = array();
    if ($handle = opendir($dir)) {
        while (false !== ($file = readdir($handle))) {
            if ($file != '.' && $file != '..' && preg_match($match, $file) === 1) {
                $list[] = $file;
            }
        }

        closedir($handle);
    }

    return $list;
}//end get_matching_files()


// Include all the files in the given directory that match the pattern


function include_matching_files($dir, $match = '/\.php$/')
{
    foreach (get_matching_files($dir, $match) as $file) {
        include_once $file;
    }
}//end include_matching_files()


function generate_pagination($count, $limit, $page, $links = 2)
{
    $end_page   = ceil($count / $limit);
    $start      = (($page - $links) > 0) ? ($page - $links) : 1;
    $end        = (($page + $links) < $end_page) ? ($page + $links) : $end_page;
    $return     = '<ul class="pagination">';
    $link_class = ($page == 1) ? 'disabled' : '';
    $return    .= "<li><a href='' onClick='changePage(1,event);'>&laquo;</a></li>";
    $return    .= "<li class='$link_class'><a href='' onClick='changePage($page - 1,event);'>&lt;</a></li>";

    if ($start > 1) {
        $return .= "<li><a href='' onClick='changePage(1,event);'>1</a></li>";
        $return .= "<li class='disabled'><span>...</span></li>";
    }

    for ($x = $start; $x <= $end; $x++) {
        $link_class = ($page == $x) ? 'active' : '';
        $return    .= "<li class='$link_class'><a href='' onClick='changePage($x,event);'>$x </a></li>";
    }

    if ($end < $end_page) {
        $return .= "<li class='disabled'><span>...</span></li>";
        $return .= "<li><a href='' onClick='changePage($end_page,event);'>$end_page</a></li>";
    }

    $link_class = ($page == $end_page) ? 'disabled' : '';
    $return    .= "<li class='$link_class'><a href='' onClick='changePage($page + 1,event);'>&gt;</a></li>";
    $return    .= "<li class='$link_class'><a href='' onClick='changePage($end_page,event);'>&raquo;</a></li>";
    $return    .= '</ul>';
    return ($return);
}//end generate_pagination()


function is_admin()
{
    if ($_SESSION['userlevel'] >= '10') {
        $allowed = true;
    } else {
        $allowed = false;
    }

    return $allowed;
}//end is_admin()


function is_read()
{
    if ($_SESSION['userlevel'] == '5') {
        $allowed = true;
    } else {
        $allowed = false;
    }

    return $allowed;
}//end is_read()

function is_demo_user()
{

    if ($_SESSION['userlevel'] == 11) {
        return true;
    } else {
        return false;
    }
}// end is_demo_user();

function is_normal_user()
{

    if (is_admin() === false && is_read() === false && is_demo_user() === false) {
        return true;
    } else {
        return false;
    }
}// end is_normal_user()

function demo_account()
{
    print_error("You are logged in as a demo account, this page isn't accessible to you");
}//end demo_account()


function get_client_ip()
{
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $client_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $client_ip = $_SERVER['REMOTE_ADDR'];
    }

    return $client_ip;
}//end get_client_ip()

/**
 * @param $string
 * @param int $max
 * @return string
 */
function shorten_text($string, $max = 30)
{
    if (strlen($string) > 50) {
        return substr($string, 0, $max) . "...";
    } else {
        return $string;
    }
}

function shorten_interface_type($string)
{
    return str_ireplace(
        array(
            'FastEthernet',
            'TenGigabitEthernet',
            'GigabitEthernet',
            'Port-Channel',
            'Ethernet',
            'Bundle-Ether',
        ),
        array(
            'Fa',
            'Te',
            'Gi',
            'Po',
            'Eth',
            'BE',
        ),
        $string
    );
}//end shorten_interface_type()


function clean_bootgrid($string)
{
    $output = str_replace(array("\r", "\n"), '', $string);
    $output = addslashes($output);
    return $output;
}//end clean_bootgrid()


function get_config_by_group($group)
{
    $group = array($group);
    $items = array();
    foreach (dbFetchRows("SELECT * FROM `config` WHERE `config_group` = '?'", array($group)) as $config_item) {
        $val = $config_item['config_value'];
        if (filter_var($val, FILTER_VALIDATE_INT)) {
            $val = (int) $val;
        } elseif (filter_var($val, FILTER_VALIDATE_FLOAT)) {
            $val = (float) $val;
        } elseif (filter_var($val, FILTER_VALIDATE_BOOLEAN)) {
            $val = (boolean) $val;
        }

        if ($val === true) {
            $config_item += array('config_checked' => 'checked');
        }

        $items[$config_item['config_name']] = $config_item;
    }

    return $items;
}//end get_config_by_group()


function get_config_like_name($name)
{
    $name  = array($name);
    $items = array();
    foreach (dbFetchRows("SELECT * FROM `config` WHERE `config_name` LIKE '%?%'", array($name)) as $config_item) {
        $items[$config_item['config_id']] = $config_item;
    }

    return $items;
}//end get_config_like_name()


function get_config_by_name($name)
{
    $config_item = dbFetchRow('SELECT * FROM `config` WHERE `config_name` = ?', array($name));
    return $config_item;
}//end get_config_by_name()


function set_config_name($name, $config_value)
{
    return dbUpdate(array('config_value' => $config_value), 'config', '`config_name`=?', array($name));
}//end set_config_name()


function get_url()
{
    // http://stackoverflow.com/questions/2820723/how-to-get-base-url-with-php
    // http://stackoverflow.com/users/184600/ma%C4%8Dek
    return sprintf(
        '%s://%s%s',
        isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
        $_SERVER['SERVER_NAME'],
        $_SERVER['REQUEST_URI']
    );
}//end get_url()


function alert_details($details)
{
    if (!is_array($details)) {
        $details = json_decode(gzuncompress($details), true);
    }

    $fault_detail = '';
    foreach ($details['rule'] as $o => $tmp_alerts) {
        $fallback      = true;
        $fault_detail .= '#'.($o + 1).':&nbsp;';
        if ($tmp_alerts['bill_id']) {
            $fault_detail .= '<a href="'.generate_bill_url($tmp_alerts).'">'.$tmp_alerts['bill_name'].'</a>;&nbsp;';
            $fallback      = false;
        }

        if ($tmp_alerts['port_id']) {
            $tmp_alerts = cleanPort($tmp_alerts);
            $fault_detail .= generate_port_link($tmp_alerts).';&nbsp;';
            $fallback      = false;
        }

        if ($tmp_alerts['accesspoint_id']) {
            $fault_detail .= generate_ap_link($tmp_alerts, $tmp_alerts['name']) . ';&nbsp;';
            $fallback      = false;
        }

        if ($tmp_alerts['type'] && $tmp_alerts['label']) {
            if ($tmp_alerts['error'] == "") {
                $fault_detail .= ' '.$tmp_alerts['type'].' - '.$tmp_alerts['label'].';&nbsp;';
            } else {
                $fault_detail .= ' '.$tmp_alerts['type'].' - '.$tmp_alerts['label'].' - '.$tmp_alerts['error'].';&nbsp;';
            }
            $fallback      = false;
        }

        if ($fallback === true) {
            foreach ($tmp_alerts as $k => $v) {
                if (!empty($v) && $k != 'device_id' && (stristr($k, 'id') || stristr($k, 'desc') || stristr($k, 'msg')) && substr_count($k, '_') <= 1) {
                    $fault_detail .= "$k => '$v', ";
                }
            }

            $fault_detail = rtrim($fault_detail, ', ');
        }

        $fault_detail .= '<br>';
    }//end foreach

    return $fault_detail;
}//end alert_details()

function dynamic_override_config($type, $name, $device)
{
    $attrib_val = get_dev_attrib($device, $name);
    if ($attrib_val == 'true') {
        $checked = 'checked';
    } else {
        $checked = '';
    }
    if ($type == 'checkbox') {
        return '<input type="checkbox" id="override_config" name="override_config" data-attrib="'.$name.'" data-device_id="'.$device['device_id'].'" data-size="small" '.$checked.'>';
    } elseif ($type == 'text') {
        return '<input type="text" id="override_config_text" name="override_config_text" data-attrib="'.$name.'" data-device_id="'.$device['device_id'].'" value="'.$attrib_val.'">';
    }
}//end dynamic_override_config()

function generate_dynamic_config_panel($title, $config_groups, $items = array(), $transport = '', $end_panel = true)
{
    $anchor = md5($title);
    $output = '
<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#'.$anchor.'"><i class="fa fa-caret-down"></i> '.$title.'</a>
    ';
    if (!empty($transport)) {
        $output .= '<button name="test-alert" id="test-alert" type="button" data-transport="'.$transport.'" class="btn btn-primary btn-xs pull-right">Test transport</button>';
    }
    $output .= '
        </h4>
    </div>
    <div id="'.$anchor.'" class="panel-collapse collapse">
        <div class="panel-body">
    ';

    if (!empty($items)) {
        foreach ($items as $item) {
            $output .= '
            <div class="form-group has-feedback">
                <label for="'.$item['name'].'"" class="col-sm-4 control-label">'.$item['descr'].' </label>
                <div data-toggle="tooltip" title="'.$config_groups[$item['name']]['config_descr'].'" class="toolTip fa fa-fw fa-lg fa-question-circle"></div>
                <div class="col-sm-4">
            ';
            if ($item['type'] == 'checkbox') {
                $output .= '<input id="'.$item['name'].'" type="checkbox" name="global-config-check" '.$config_groups[$item['name']]['config_checked'].' data-on-text="Yes" data-off-text="No" data-size="small" data-config_id="'.$config_groups[$item['name']]['config_id'].'">';
            } elseif ($item['type'] == 'text') {
                $output .= '
                <input id="'.$item['name'].'" class="form-control" type="text" name="global-config-input" value="'.$config_groups[$item['name']]['config_value'].'" data-config_id="'.$config_groups[$item['name']]['config_id'].'">
                <span class="form-control-feedback"><i class="fa" aria-hidden="true"></i></span>
                ';
            } elseif ($item['type'] == 'password') {
                $output .= '
                <input id="'.$item['name'].'" class="form-control" type="password" name="global-config-input" value="'.$config_groups[$item['name']]['config_value'].'" data-config_id="'.$config_groups[$item['name']]['config_id'].'">
                <span class="form-control-feedback"><i class="fa" aria-hidden="true"></i></span>
                ';
            } elseif ($item['type'] == 'numeric') {
                $output .= '
                <input id="'.$item['name'].'" class="form-control" onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57" type="text" name="global-config-input" value="'.$config_groups[$item['name']]['config_value'].'" data-config_id="'.$config_groups[$item['name']]['config_id'].'">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                ';
            } elseif ($item['type'] == 'select') {
                $output .= '
                <select id="'.$config_groups[$item['name']]['name'].'" class="form-control" name="global-config-select" data-config_id="'.$config_groups[$item['name']]['config_id'].'">
                ';
                if (!empty($item['options'])) {
                    foreach ($item['options'] as $option) {
                        if (gettype($option) == 'string') {
                            /* for backwards-compatibility */
                            $tmp_opt = $option;
                            $option = array(
                                'value' => $tmp_opt,
                                'description' => $tmp_opt,
                            );
                        }
                        $output .= '<option value="'.$option['value'].'"';
                        if ($option['value'] == $config_groups[$item['name']]['config_value']) {
                            $output .= ' selected';
                        }
                        $output .= '>'.$option['description'].'</option>';
                    }
                }
                $output .='
                </select>
                <span class="form-control-feedback"><i class="fa" aria-hidden="true"></i></span>
                ';
            }
            $output .= '
                </div>
            </div>
            ';
        }
    }

    if ($end_panel === true) {
        $output .= '
        </div>
    </div>
</div>
        ';
    }
    return $output;
}//end generate_dynamic_config_panel()

function get_ripe_api_whois_data_json($ripe_data_param, $ripe_query_param)
{
    $ripe_whois_url = 'https://stat.ripe.net/data/'. $ripe_data_param . '/data.json?resource=' . $ripe_query_param;
    return json_decode(file_get_contents($ripe_whois_url), true);
}//end get_ripe_api_whois_data_json()

/**
 * Return the rows from 'ports' for all ports of a certain type as parsed by port_descr_parser.
 * One or an array of strings can be provided as an argument; if an array is passed, all ports matching
 * any of the types in the array are returned.
 * @param $types mixed String or strings matching 'port_descr_type's.
 * @return array Rows from the ports table for matching ports.
 */
function get_ports_from_type($given_types)
{
    global $config;

    # Make the arg an array if it isn't, so subsequent steps only have to handle arrays.
    if (!is_array($given_types)) {
        $given_types = array($given_types);
    }

    # Check the config for a '_descr' entry for each argument. This is how a 'custom_descr' entry can
    #  be key/valued to some other string that's actually searched for in the DB. Merge or append the
    #  configured value if it's an array or a string. Or append the argument itself if there's no matching
    #  entry in config.
    $search_types = array();
    foreach ($given_types as $type) {
        if (isset($config[$type.'_descr']) === true) {
            if (is_array($config[$type.'_descr']) === true) {
                $search_types = array_merge($search_types, $config[$type.'_descr']);
            } else {
                $search_types[] = $config[$type.'_descr'];
            }
        } else {
            $search_types[] = $type;
        }
    }

    # Using the full list of strings to search the DB for, build the 'where' portion of a query that
    #  compares 'port_descr_type' with entry in the list. Also, since '@' is the convential wildcard,
    #  replace it with '%' so it functions as a wildcard in the SQL query.
    $type_where = ' (';
    $or = '';
    $type_param = array();

    foreach ($search_types as $type) {
        if (!empty($type)) {
            $type            = strtr($type, '@', '%');
            $type_where     .= " $or `port_descr_type` LIKE ?";
            $or              = 'OR';
            $type_param[]    = $type;
        }
    }
    $type_where  .= ') ';

    # Run the query with the generated 'where' and necessary parameters, and send it back.
    $ports = dbFetchRows("SELECT * FROM `ports` as I, `devices` AS D WHERE $type_where AND I.device_id = D.device_id ORDER BY I.ifAlias", $type_param);
    return $ports;
}

/**
 * @param $filename
 * @param $content
 */
function file_download($filename, $content)
{
    $length = strlen($content);
    header('Content-Description: File Transfer');
    header('Content-Type: text/plain');
    header("Content-Disposition: attachment; filename=$filename");
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: ' . $length);
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Expires: 0');
    header('Pragma: public');
    echo $content;
}

function get_rules_from_json()
{
    global $config;
    return json_decode(file_get_contents($config['install_dir'] . '/misc/alert_rules.json'), true);
}

function search_oxidized_config($search_in_conf_textbox)
{
    global $config;
    $oxidized_search_url = $config['oxidized']['url'] . '/nodes/conf_search?format=json';
    $postdata = http_build_query(
        array(
            'search_in_conf_textbox' => $search_in_conf_textbox,
        )
    );
    $opts = array('http' =>
        array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => $postdata
        )
    );
    $context  = stream_context_create($opts);
    return json_decode(file_get_contents($oxidized_search_url, false, $context), true);
}

/**
 * @param $data
 * @return bool|mixed
 */
function array_to_htmljson($data)
{
    if (is_array($data)) {
        $data = htmlentities(json_encode($data));
        return str_replace(',', ',<br />', $data);
    } else {
        return false;
    }
}

/**
 * @param int $eventlog_severity
 * @return string $eventlog_severity_icon
 */
function eventlog_severity($eventlog_severity)
{
    switch ($eventlog_severity) {
        case 1:
            return "severity-ok"; //OK
        case 2:
            return "severity-info"; //Informational
        case 3:
            return "severity-notice"; //Notice
        case 4:
            return "severity-warning"; //Warning
        case 5:
            return "severity-critical"; //Critical
        default:
            return "severity-unknown"; //Unknown
    }
} // end eventlog_severity

/**
 *
 */
function set_image_type()
{
    return header('Content-type: ' . get_image_type());
}

function get_image_type()
{
    global $config;

    if ($config['webui']['graph_type'] === 'svg') {
        return 'image/svg+xml';
    } else {
        return 'image/png';
    }
}

function get_oxidized_nodes_list()
{
    global $config;

    $context = stream_context_create(array(
        'http' => array(
            'header' => "Accept: application/json",
        )
    ));

    $data = json_decode(file_get_contents($config['oxidized']['url'] . '/nodes?format=json', false, $context), true);

    foreach ($data as $object) {
        $device = device_by_name($object['name']);
        $fa_color = $object['status'] == 'success' ? 'success' : 'danger';
        echo "
        <tr>
        <td>
        " . generate_device_link($device) . "
        </td>
        <td>
        <i class='fa fa-square text-" . $fa_color . "'></i>
        </td>
        <td>
        " . $object['time'] . "
        </td>
        <td>
        " . $object['model'] . "
        </td>
        <td>
        " . $object['group'] . "
        </td>
        </tr>";
    }
}

// fetches disks for a system
function get_disks($device)
{
    return dbFetchRows('SELECT * FROM `ucd_diskio` WHERE device_id = ? ORDER BY diskio_descr', array($device));
}

/**
 * Get the fail2ban jails for a device... just requires the device ID
 * an empty return means either no jails or fail2ban is not in use
 * @param $device_id
 * @return array
 */
function get_fail2ban_jails($device_id)
{
    $options=array(
        'filter' => array(
            'type' => array('=', 'fail2ban'),
        ),
    );

    $component=new LibreNMS\Component();
    $f2bc=$component->getComponents($device_id, $options);

    if (isset($f2bc[$device_id])) {
        $id = $component->getFirstComponentID($f2bc, $device_id);
        return json_decode($f2bc[$device_id][$id]['jails']);
    }

    return array();
}

/**
 * Get the Postgres databases for a device... just requires the device ID
 * an empty return means Postres is not in use
 * @param $device_id
 * @return array
 */
function get_postgres_databases($device_id)
{
    $options=array(
        'filter' => array(
             'type' => array('=', 'postgres'),
        ),
    );

    $component=new LibreNMS\Component();
    $pgc=$component->getComponents($device_id, $options);

    if (isset($pgc[$device_id])) {
        $id = $component->getFirstComponentID($pgc, $device_id);
        return json_decode($pgc[$device_id][$id]['databases']);
    }

    return array();
}

// takes the device array and app_id
function get_disks_with_smart($device, $app_id)
{
    $all_disks=get_disks($device['device_id']);
    $disks=array();
    $all_disks_int=0;
    while (isset($all_disks[$all_disks_int])) {
        $disk=$all_disks[$all_disks_int]['diskio_descr'];
        $rrd_filename = rrd_name($device['hostname'], array('app', 'smart', $app_id, $disk));
        if (rrdtool_check_rrd_exists($rrd_filename)) {
            $disks[]=$disk;
        }
        $all_disks_int++;
    }
    return $disks;
}

/**
 * Gets all dashboards the user can access
 * adds in the keys:
 *   username - the username of the owner of each dashboard
 *   default - the default dashboard for the logged in user
 *
 * @param int $user_id optionally get list for another user
 * @return array list of dashboards
 */
function get_dashboards($user_id = null)
{
    $default = get_user_pref('dashboard');
    $dashboards = dbFetchRows(
        "SELECT * FROM `dashboards` WHERE dashboards.access > 0 || dashboards.user_id = ?",
        array(is_null($user_id) ? $_SESSION['user_id'] : $user_id)
    );

    $usernames = array(
        $_SESSION['user_id'] => $_SESSION['username']
    );

    $result = array();
    foreach ($dashboards as $dashboard) {
        $duid = $dashboard['user_id'];
        if (!isset($usernames[$duid])) {
            $user = get_user($duid);
            $usernames[$duid] = $user['username'];
        }

        $dashboard['username'] = $usernames[$duid];
        $dashboard['default'] = $dashboard['dashboard_id'] == $default;

        $result[$dashboard['dashboard_id']] = $dashboard;
    }

    return $result;
}

/**
 * Generate javascript to fill in a select box from an ajax list
 *
 * @param string $list_type type of list look in html/includes/list/
 * @param string $selector jquery selector for the target select element
 * @param int $selected the id of the item to mark as selected
 * @return string the javascript (not including <script> tags)
 */
function generate_fill_select_js($list_type, $selector, $selected = null)
{
    return '$(document).ready(function() {
    $select = $("' . $selector . '")
    $.getJSON(\'ajax_list.php?id=' . $list_type . '\', function(data){
        $.each(data, function(index,item) {
            if (item.id == "' . $selected . '") {
                $select.append("<option value=" + item.id + " selected>" + item.value + "</option>");
            } else {
                $select.append("<option value=" + item.id + ">" + item.value + "</option>");
            }
        });
    });
});';
}
