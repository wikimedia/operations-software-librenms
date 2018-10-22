<?php

$graphs['apache']    = array(
    'bits',
    'hits',
    'scoreboard',
    'cpu',
);

$graphs['drbd']      = array(
    'disk_bits',
    'network_bits',
    'queue',
    'unsynced',
);

$graphs['mysql']     = array(
    'network_traffic',
    'connections',
    'command_counters',
    'select_types',
);

$graphs['memcached'] = array(
    'bits',
    'commands',
    'data',
    'items',
);

$graphs['nginx']     = array(
    'connections',
    'req',
);

$graphs['postfix'] = array(
    'messages',
    'qstats',
    'bytes',
    'sr',
    'deferral',
    'rejects',
);

$graphs['powerdns-recursor'] = array(
    'questions',
    'answers',
    'cache_performance',
    'outqueries'
);

$graphs['rrdcached'] = array(
    'queue_length',
    'events',
    'tree',
    'journal'
);

$graphs['bind']      = array('queries');

$graphs['tinydns']   = array(
    'queries',
    'errors',
    'dnssec',
    'other',
);

$graphs['postgres'] = array(
    'backends',
    'cr',
    'rows',
    'hr',
    'index',
    'sequential'
);

$graphs['powerdns'] = array(
    'latency',
    'fail',
    'packetcache',
    'querycache',
    'recursing',
    'queries',
    'queries_udp',
);

$graphs['ntp-client'] = array(
    'stats',
    'freq',
);

$graphs['ntp-server'] = array(
    'stats',
    'freq',
    'stratum',
    'buffer',
    'bits',
    'packets',
    'uptime',
);

$graphs['nfs-v3-stats'] = array(
    'stats',
    'io',
    'fh',
    'rc',
    'ra',
    'net',
    'rpc',
);

$graphs['nfs-server'] = array(
    'io',
    'net_tcp_conns',
    'rpc',
);

$graphs['os-updates'] = array(
    'packages',
);

$graphs['dhcp-stats'] = array(
     'stats',
);

$graphs['fail2ban'] = array(
    'banned',
);

$graphs['freeswitch'] = array(
    'peak',
    'calls',
    'channels',
    'callsIn',
    'callsOut',
);

$graphs['ups-nut'] = array(
    'remaining',
    'load',
    'voltage_battery',
    'charge',
    'voltage_input',
);

$graphs['ups-apcups'] = array(
    'remaining',
    'load',
    'voltage_battery',
    'charge',
    'voltage_input',
);

$graphs['gpsd'] = array(
    'satellites',
    'dop',
    'mode',
);

$graphs['exim-stats'] = array(
    'frozen',
    'queue'
);

$graphs['php-fpm'] = array(
    'stats'
);

$graphs['nvidia'] = array(
    'sm',
    'mem',
    'enc',
    'dec',
    'rxpci',
    'txpci',
    'fb',
    'bar1',
    'mclk',
    'pclk',
    'pwr',
    'temp',
    'pviol',
    'tviol',
    'sbecc',
    'dbecc',
);

$graphs['squid'] = array(
    'memory',
    'clients',
    'cpuusage',
    'objcount',
    'filedescr',
    'httpbw',
    'http',
    'server',
    'serverbw',
    'reqhit',
    'bytehit',
    'sysnumread',
    'pagefaults',
    'cputime',
);

$graphs['opengridscheduler'] = array(
    'ogs'
);

$graphs['fbsd-nfs-server'] = array(
    'stats',
    'cache',
    'gathering',
);

$graphs['fbsd-nfs-client'] = array(
    'stats',
    'cache',
    'rpc',
);

$graphs['unbound'] = array(
    'queries',
    'cache',
);

$graphs['bind']      = array(
    'incoming',
    'outgoing',
    'rr_positive',
    'rr_negative',
    'rtt',
    'resolver_failure',
    'resolver_qrs',
    'resolver_naf',
    'server_received',
    'server_results',
    'server_issues',
    'cache_hm',
    'adb_in',
    'sockets_active',
    'sockets_errors',
);

$graphs['smart'] = array(
    'id5',
    'id10',
    'id173',
    'id183',
    'id184',
    'id187',
    'id188',
    'id190',
    'id194',
    'id196',
    'id197',
    'id198',
    'id199',
    'id231',
    'id233',
);

$graphs['sdfsinfo'] = array(
    'volume',
    'blocks',
    'rates',
);

$graphs['pi-hole'] = array(
    'query_types',
    'destinations',
    'query_results',
    'block_percent',
    'blocklist',
);

print_optionbar_start();

echo "<span style='font-weight: bold;'>Apps</span> &#187; ";

unset($sep);

$link_array = array(
    'page'   => 'device',
    'device' => $device['device_id'],
    'tab'    => 'apps',
);

foreach ($app_list as $app) {
    echo $sep;

    if ($vars['app'] == $app['app_type']) {
        echo "<span class='pagemenu-selected'>";
    }

    echo generate_link(nicecase($app['app_type']), array('page' => 'apps', 'app' => $app['app_type']));
    if ($vars['app'] == $app['app_type']) {
        echo '</span>';
    }

    $sep = ' | ';
}

print_optionbar_end();

if ($vars['app']) {
    if (is_file('pages/apps/'.mres($vars['app']).'.inc.php')) {
        include 'pages/apps/'.mres($vars['app']).'.inc.php';
    } else {
        include 'pages/apps/default.inc.php';
    }
} else {
    include 'pages/apps/overview.inc.php';
}

$pagetitle[] = 'Apps';
