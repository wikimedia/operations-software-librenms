<?php

use LibreNMS\RRD\RrdDefinition;

function bulk_sensor_snmpget($device, $sensors)
{
    $oid_per_pdu = get_device_oid_limit($device);
    $sensors = array_chunk($sensors, $oid_per_pdu);
    $cache = array();
    foreach ($sensors as $chunk) {
        $oids = array_map(function ($data) {
            return $data['sensor_oid'];
        }, $chunk);
        $oids = implode(' ', $oids);
        $multi_response = snmp_get_multi_oid($device, $oids, '-OUQnt');
        $cache = array_merge($cache, $multi_response);
    }
    return $cache;
}

/**
 * @param $device
 * @param string $type type/class of sensor
 * @return array
 */
function sensor_precache($device, $type)
{
    $sensor_cache = array();
    if (file_exists('includes/polling/sensors/pre-cache/'. $device['os'] .'.inc.php')) {
        include 'includes/polling/sensors/pre-cache/'. $device['os'] .'.inc.php';
    }
    return $sensor_cache;
}

function poll_sensor($device, $class)
{
    global $config, $memcache, $agent_sensors;

    $sensors = array();
    $misc_sensors = array();
    $all_sensors = array();

    foreach (dbFetchRows("SELECT * FROM `sensors` WHERE `sensor_class` = ? AND `device_id` = ?", array($class, $device['device_id'])) as $sensor) {
        if ($sensor['poller_type'] == 'agent') {
            // Agent sensors are polled in the unix-agent
        } elseif ($sensor['poller_type'] == 'ipmi') {
            $misc_sensors[] = $sensor;
        } else {
            $sensors[] = $sensor;
        }
    }

    $snmp_data = bulk_sensor_snmpget($device, $sensors);

    $sensor_cache = sensor_precache($device, $class);

    foreach ($sensors as $sensor) {
        echo 'Checking (' . $sensor['poller_type'] . ") $class " . $sensor['sensor_descr'] . '... '.PHP_EOL;

        if ($sensor['poller_type'] == 'snmp') {
            $mibdir = null;

            $sensor_value = trim(str_replace('"', '', $snmp_data[$sensor['sensor_oid']]));

            if (file_exists('includes/polling/sensors/'. $class .'/'. $device['os'] .'.inc.php')) {
                require 'includes/polling/sensors/'. $class .'/'. $device['os'] .'.inc.php';
            }

            if (isset($sensor['user_func']) && function_exists($sensor['user_func'])) {
                $sensor_value = $sensor['user_func']($sensor_value);
            }

            if ($class == 'temperature') {
                preg_match('/[\d\.\-]+/', $sensor_value, $temp_response);
                if (!empty($temp_response[0])) {
                    $sensor_value = $temp_response[0];
                }
            } elseif ($class == 'state') {
                if (!is_numeric($sensor_value)) {
                    $state_value = dbFetchCell(
                        'SELECT `state_value` 
                        FROM `state_translations` LEFT JOIN `sensors_to_state_indexes` 
                        ON `state_translations`.`state_index_id` = `sensors_to_state_indexes`.`state_index_id` 
                        WHERE `sensors_to_state_indexes`.`sensor_id` = ? 
                        AND `state_translations`.`state_descr` LIKE ?',
                        array($sensor['sensor_id'], $sensor_value)
                    );
                    d_echo('State value of ' . $sensor_value . ' is ' . $state_value . "\n");
                    if (is_numeric($state_value)) {
                        $sensor_value = $state_value;
                    }
                }
            }//end if
            unset($mib);
            unset($mibdir);
            $sensor['new_value'] = $sensor_value;
            $all_sensors[] = $sensor;
        }
    }

    foreach ($misc_sensors as $sensor) {
        if ($sensor['poller_type'] == 'agent') {
            if (isset($agent_sensors)) {
                $sensor_value = $agent_sensors[$class][$sensor['sensor_type']][$sensor['sensor_index']]['current'];
                $sensor['new_value'] = $sensor_value;
                $all_sensors[] = $sensor;
            } else {
                echo "no agent data!\n";
                continue;
            }
        } elseif ($sensor['poller_type'] == 'ipmi') {
            echo " already polled.\n";
            // ipmi should probably move here from the ipmi poller file (FIXME)
            continue;
        } else {
            echo "unknown poller type!\n";
            continue;
        }//end if
    }
    record_sensor_data($device, $all_sensors);
}//end poll_sensor()

/**
 * @param $device
 * @param $all_sensors
 */
function record_sensor_data($device, $all_sensors)
{
    $supported_sensors = array(
        'current'     => 'A',
        'frequency'   => 'Hz',
        'runtime'     => 'Min',
        'humidity'    => '%',
        'fanspeed'    => 'rpm',
        'power'       => 'W',
        'voltage'     => 'V',
        'temperature' => 'C',
        'dbm'         => 'dBm',
        'charge'      => '%',
        'load'        => '%',
        'state'       => '#',
        'signal'      => 'dBm',
        'airflow'     => 'cfm',
        'snr'         => 'SNR',
        'pressure'    => 'kPa',
        'cooling'     => 'W',
    );

    foreach ($all_sensors as $sensor) {
        $class             = ucfirst($sensor['sensor_class']);
        $unit              = $supported_sensors[$class];
        $sensor_value      = $sensor['new_value'];
        $prev_sensor_value = $sensor['sensor_current'];

        if ($sensor_value == -32768) {
            echo 'Invalid (-32768) ';
            $sensor_value = 0;
        }

        if ($sensor['sensor_divisor'] && $sensor_value !== 0) {
            $sensor_value = ($sensor_value / $sensor['sensor_divisor']);
        }

        if ($sensor['sensor_multiplier']) {
            $sensor_value = ($sensor_value * $sensor['sensor_multiplier']);
        }

        $rrd_name = get_sensor_rrd_name($device, $sensor);
        $rrd_def = RrdDefinition::make()->addDataset('sensor', 'GAUGE', -20000, 20000);

        echo "$sensor_value $unit\n";

        $fields = array(
            'sensor' => $sensor_value,
        );

        $tags = array(
            'sensor_class' => $sensor['sensor_class'],
            'sensor_type' => $sensor['sensor_type'],
            'sensor_descr' => $sensor['sensor_descr'],
            'sensor_index' => $sensor['sensor_index'],
            'rrd_name' => $rrd_name,
            'rrd_def' => $rrd_def
        );
        data_update($device, 'sensor', $tags, $fields);

        // FIXME also warn when crossing WARN level!
        if ($sensor['sensor_limit_low'] != '' && $prev_sensor_value > $sensor['sensor_limit_low'] && $sensor_value < $sensor['sensor_limit_low'] && $sensor['sensor_alert'] == 1) {
            echo 'Alerting for '.$device['hostname'].' '.$sensor['sensor_descr']."\n";
            log_event("$class {$sensor['sensor_descr']} under threshold: $sensor_value $unit (< {$sensor['sensor_limit_low']} $unit)", $device, $class, 4, $sensor['sensor_id']);
        } elseif ($sensor['sensor_limit'] != '' && $prev_sensor_value < $sensor['sensor_limit'] && $sensor_value > $sensor['sensor_limit'] && $sensor['sensor_alert'] == 1) {
            echo 'Alerting for '.$device['hostname'].' '.$sensor['sensor_descr']."\n";
            log_event("$class {$sensor['sensor_descr']} above threshold: $sensor_value $unit (> {$sensor['sensor_limit']} $unit)", $device, $class, 4, $sensor['sensor_id']);
        }
        if ($sensor['sensor_class'] == 'state' && $prev_sensor_value != $sensor_value) {
            $trans = array_column(
                dbFetchRows(
                    "SELECT `state_translations`.`state_value`, `state_translations`.`state_descr` FROM `sensors_to_state_indexes` LEFT JOIN `state_translations` USING (`state_index_id`) WHERE `sensors_to_state_indexes`.`sensor_id`=? AND `state_translations`.`state_value` IN ($sensor_value,$prev_sensor_value)",
                    array($sensor['sensor_id'])
                ),
                'state_descr',
                'state_value'
            );

            log_event("$class sensor {$sensor['sensor_descr']} has changed from {$trans[$prev_sensor_value]} ($prev_sensor_value) to {$trans[$sensor_value]} ($sensor_value)", $device, $class, 3, $sensor['sensor_id']);
        }
        dbUpdate(array('sensor_current' => $sensor_value, 'sensor_prev' => $prev_sensor_value, 'lastupdate' => array('NOW()')), 'sensors', "`sensor_class` = ? AND `sensor_id` = ?", array($class,$sensor['sensor_id']));
    }
}

function poll_device($device, $options)
{
    global $config, $device;

    $attribs = get_dev_attribs($device['device_id']);
    $device['attribs'] = $attribs;

    load_os($device);

    $device['snmp_max_repeaters'] = $attribs['snmp_max_repeaters'];
    $device['snmp_max_oid'] = $attribs['snmp_max_oid'];

    unset($array);
    $device_start = microtime(true);
    // Start counting device poll time
    echo 'Hostname: ' . $device['hostname'] . PHP_EOL;
    echo 'Device ID: ' . $device['device_id'] . PHP_EOL;
    echo 'OS: ' . $device['os'];
    $ip = dnslookup($device);
    $db_ip = inet_pton($ip);

    if (!empty($db_ip) && inet6_ntop($db_ip) != inet6_ntop($device['ip'])) {
        log_event('Device IP changed to ' . $ip, $device, 'system', 3);
        dbUpdate(array('ip' => $db_ip), 'devices', 'device_id=?', array($device['device_id']));
    }

    if ($config['os'][$device['os']]['group']) {
        $device['os_group'] = $config['os'][$device['os']]['group'];
        echo ' ('.$device['os_group'].')';
    }

    echo PHP_EOL.PHP_EOL;

    unset($poll_update);
    unset($poll_update_query);
    unset($poll_separator);
    $poll_update_array = array();
    $update_array = array();

    $host_rrd = rrd_name($device['hostname'], '', '');
    if ($config['norrd'] !== true && !is_dir($host_rrd)) {
        mkdir($host_rrd);
        echo "Created directory : $host_rrd\n";
    }

    $response = device_is_up($device, true);

    if ($response['status'] == '1') {
        $graphs    = array();
        $oldgraphs = array();

        $force_module = false;
        if (!$device['snmp_disable']) {
            // we always want the core module to be included
            include 'includes/polling/core.inc.php';

            if ($options['m']) {
                $config['poller_modules'] = array();
                foreach (explode(',', $options['m']) as $module) {
                    if (is_file('includes/polling/'.$module.'.inc.php')) {
                        $config['poller_modules'][$module] = 1;
                        $force_module = true;
                    }
                }
            }
        } else {
            $config['poller_modules'] = array();
        }
        foreach ($config['poller_modules'] as $module => $module_status) {
            $os_module_status = $config['os'][$device['os']]['poller_modules'][$module];
            d_echo("Modules status: Global" . (isset($module_status) ? ($module_status ? '+ ' : '- ') : '  '));
            d_echo("OS" . (isset($os_module_status) ? ($os_module_status ? '+ ' : '- ') : '  '));
            d_echo("Device" . (isset($attribs['poll_' . $module]) ? ($attribs['poll_' . $module] ? '+ ' : '- ') : '  '));
            if ($force_module === true ||
                $attribs['poll_'.$module] ||
                ($os_module_status && !isset($attribs['poll_'.$module])) ||
                ($module_status && !isset($os_module_status) && !isset($attribs['poll_' . $module]))) {
                $start_memory = memory_get_usage();
                $module_start = microtime(true);
                echo "\n#### Load poller module $module ####\n";
                include "includes/polling/$module.inc.php";
                $module_time = microtime(true) - $module_start;
                $module_mem  = (memory_get_usage() - $start_memory);
                printf("\n>> Runtime for poller module '%s': %.4f seconds with %s bytes\n", $module, $module_time, $module_mem);
                echo "#### Unload poller module $module ####\n\n";

                // save per-module poller stats
                $tags = array(
                    'module'      => $module,
                    'rrd_def'     => RrdDefinition::make()->addDataset('poller', 'GAUGE', 0),
                    'rrd_name'    => array('poller-perf', $module),
                );
                $fields = array(
                    'poller' => $module_time,
                );
                data_update($device, 'poller-perf', $tags, $fields);

                // remove old rrd
                $oldrrd = rrd_name($device['hostname'], array('poller', $module, 'perf'));
                if (is_file($oldrrd)) {
                    unlink($oldrrd);
                }
                unset($tags, $fields, $oldrrd);
            } elseif (isset($attribs['poll_'.$module]) && $attribs['poll_'.$module] == '0') {
                echo "Module [ $module ] disabled on host.\n\n";
            } elseif (isset($os_module_status) && $os_module_status == '0') {
                echo "Module [ $module ] disabled on os.\n\n";
            } else {
                echo "Module [ $module ] disabled globally.\n\n";
            }
        }

        // Update device_groups
        UpdateGroupsForDevice($device['device_id']);

        if (!isset($options['m'])) {
            // FIXME EVENTLOGGING -- MAKE IT SO WE DO THIS PER-MODULE?
            // This code cycles through the graphs already known in the database and the ones we've defined as being polled here
            // If there any don't match, they're added/deleted from the database.
            // Ideally we should hold graphs for xx days/weeks/polls so that we don't needlessly hide information.
            foreach (dbFetch('SELECT `graph` FROM `device_graphs` WHERE `device_id` = ?', array($device['device_id'])) as $graph) {
                if (isset($graphs[$graph['graph']])) {
                    $oldgraphs[$graph['graph']] = true;
                } else {
                    dbDelete('device_graphs', '`device_id` = ? AND `graph` = ?', array($device['device_id'], $graph['graph']));
                }
            }

            foreach ($graphs as $graph => $value) {
                if (!isset($oldgraphs[$graph])) {
                    echo '+';
                    dbInsert(array('device_id' => $device['device_id'], 'graph' => $graph), 'device_graphs');
                }

                echo $graph.' ';
            }
        }//end if

        // Ping response
        if (can_ping_device($attribs) === true  &&  !empty($response['ping_time'])) {
            $tags = array(
                'rrd_def' => RrdDefinition::make()->addDataset('ping', 'GAUGE', 0, 65535),
            );
            $fields = array(
                'ping' => $response['ping_time'],
            );

            $update_array['last_ping']             = array('NOW()');
            $update_array['last_ping_timetaken']   = $response['ping_time'];

            data_update($device, 'ping-perf', $tags, $fields);
        }

        $device_time  = round(microtime(true) - $device_start, 3);

        // Poller performance
        if (!empty($device_time)) {
            $tags = array(
                'rrd_def' => RrdDefinition::make()->addDataset('poller', 'GAUGE', 0),
                'module'  => 'ALL',
            );
            $fields = array(
                'poller' => $device_time,
            );

            data_update($device, 'poller-perf', $tags, $fields);
        }

        $update_array['last_polled']           = array('NOW()');
        $update_array['last_polled_timetaken'] = $device_time;

        // echo("$device_end - $device_start; $device_time $device_run");
        echo "Polled in $device_time seconds\n";

        // check if the poll took to long and log an event
        if ($device_time > $config['rrd']['step']) {
            log_event("Polling took longer than " . round($config['rrd']['step'] / 60, 2) .
                ' minutes!  This will cause gaps in graphs.', $device, 'system', 5);
        }

        d_echo('Updating '.$device['hostname']."\n");

        $updated = dbUpdate($update_array, 'devices', '`device_id` = ?', array($device['device_id']));
        if ($updated) {
            echo "UPDATED!\n";
        }

        unset($storage_cache);
        // Clear cache of hrStorage ** MAYBE FIXME? **
        unset($cache);
        // Clear cache (unify all things here?)
    }//end if
}//end poll_device()

/**
 * if no rrd_name parameter is passed, the MIB name is used as the rrd_file_name
 */
function poll_mib_def($device, $mib_name_table, $mib_subdir, $mib_oids, $mib_graphs, &$graphs, $rrd_name = null)
{
    echo "This is poll_mib_def Processing\n";
    $mib = null;

    list($mib, $file) = explode(':', $mib_name_table, 2);

    if (is_null($rrd_name)) {
        if (str_contains($mib_name_table, 'UBNT', true)) {
            $rrd_name = strtolower($mib);
        } else {
            $rrd_name = strtolower($file);
        }
    }

    $rrd_def = new RrdDefinition();
    $oidglist  = array();
    $oidnamelist = array();
    foreach ($mib_oids as $oid => $param) {
        $oidindex  = $param[0];
        $oiddsname = $param[1];
        $oiddsdesc = $param[2];
        $oiddstype = $param[3];
        $oiddsopts = $param[4];

        if (empty($oiddsopts)) {
            $rrd_def->addDataset($oiddsname, $oiddstype, null, 100000000000);
        } else {
            $min = array_key_exists('min', $oiddsopts) ? $oiddsopts['min'] : null;
            $max = array_key_exists('max', $oiddsopts) ? $oiddsopts['max'] : null;
            $heartbeat = array_key_exists('heartbeat', $oiddsopts) ? $oiddsopts['heartbeat'] : null;
            $rrd_def->addDataset($oiddsname, $oiddstype, $min, $max, $heartbeat);
        }

        if ($oidindex != '') {
            $fulloid = $oid.'.'.$oidindex;
        } else {
            $fulloid = $oid;
        }

        // Add to oid GET list
        $oidglist[] = $fulloid;
        $oidnamelist[] = $oiddsname;
    }//end foreach

    // Implde for LibreNMS Version
    $oidilist = implode(' ', $oidglist);

    $snmpdata = snmp_get_multi($device, $oidilist, '-OQUs', $mib);
    if (isset($GLOBALS['exec_status']['exitcode']) && $GLOBALS['exec_status']['exitcode'] !== 0) {
        print_debug('  ERROR, bad snmp response');
        return false;
    }

    $oid_count = 0;
    $fields = array();
    foreach ($oidglist as $fulloid) {
        list($splitoid, $splitindex) = explode('.', $fulloid, 2);
        $val = $snmpdata[$splitindex][$splitoid];
        if (is_numeric($val)) {
            $fields[$oidnamelist[$oid_count]] = $val;
        } elseif (preg_match("/^\"(.*)\"$/", $val, $number) && is_numeric($number[1])) {
            $fields[$oidnamelist[$oid_count]] = $number[1];
        } else {
            $fields[$oidnamelist[$oid_count]] = 'U';
        }
        $oid_count++;
    }

    $tags = compact('rrd_def');
    data_update($device, $rrd_name, $tags, $fields);

    foreach ($mib_graphs as $graphtoenable) {
        $graphs[$graphtoenable] = true;
    }

    return true;
}//end poll_mib_def()


function get_main_serial($device)
{
    if ($device['os_group'] == 'cisco') {
        $serial_output = snmp_get_multi($device, 'entPhysicalSerialNum.1 entPhysicalSerialNum.1001', '-OQUs', 'ENTITY-MIB:OLD-CISCO-CHASSIS-MIB');
        if (!empty($serial_output[1]['entPhysicalSerialNum'])) {
            return $serial_output[1]['entPhysicalSerialNum'];
        } elseif (!empty($serial_output[1000]['entPhysicalSerialNum'])) {
            return $serial_output[1000]['entPhysicalSerialNum'];
        } elseif (!empty($serial_output[1001]['entPhysicalSerialNum'])) {
            return $serial_output[1001]['entPhysicalSerialNum'];
        }
    }
}//end get_main_serial()


function location_to_latlng($device)
{
    global $config;
    if (function_check('curl_version') !== true) {
        d_echo("Curl support for PHP not enabled\n");
        return false;
    }
    $bad_loc = false;
    $device_location = $device['location'];
    if (!empty($device_location)) {
        $new_device_location = preg_replace("/ /", "+", $device_location);
        $new_device_location = preg_replace('/[^A-Za-z0-9\-\+]/', '', $new_device_location); // Removes special chars.
        // We have a location string for the device.
        $loc = parse_location($device_location);
        if (!is_array($loc)) {
            $loc = dbFetchRow("SELECT `lat`,`lng` FROM `locations` WHERE `location`=? LIMIT 1", array($device_location));
        }
        if (is_array($loc) === false) {
            // Grab data from which ever Geocode service we use.
            switch ($config['geoloc']['engine']) {
                case "google":
                default:
                    d_echo("Google geocode engine being used\n");
                    $api_key = ($config['geoloc']['api_key']);
                    if (!empty($api_key)) {
                        d_echo("Use Google API key: $api_key\n");
                        $api_url = "https://maps.googleapis.com/maps/api/geocode/json?address=$new_device_location&key=$api_key";
                    } else {
                        $api_url = "https://maps.googleapis.com/maps/api/geocode/json?address=$new_device_location";
                    }
                    break;
            }
            $curl_init = curl_init($api_url);
            set_curl_proxy($curl_init);
            curl_setopt($curl_init, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_init, CURLOPT_TIMEOUT, 2);
            curl_setopt($curl_init, CURLOPT_TIMEOUT_MS, 2000);
            curl_setopt($curl_init, CURLOPT_CONNECTTIMEOUT, 5);
            $data = json_decode(curl_exec($curl_init), true);
            // Parse the data from the specific Geocode services.
            switch ($config['geoloc']['engine']) {
                case "google":
                default:
                    if ($data['status'] == 'OK') {
                        $loc = $data['results'][0]['geometry']['location'];
                    } else {
                        $bad_loc = true;
                    }
                    break;
            }
            if ($bad_loc === true) {
                d_echo("Bad lat / lng received\n");
            } else {
                $loc['timestamp'] = array('NOW()');
                $loc['location'] = $device_location;
                if (dbInsert($loc, 'locations')) {
                    d_echo("Device lat/lng created\n");
                } else {
                    d_echo("Device lat/lng could not be created\n");
                }
            }
        } else {
            d_echo("Using cached lat/lng from other device\n");
        }
    }
}// end location_to_latlng()

/**
 * Update the application status and output in the database.
 *
 * @param array $app app from the db, including app_id
 * @param string $response This should be the full output
 * @param string $current This is the current value we store in rrd for graphing
 */
function update_application($app, $response, $current = '')
{
    if (!is_numeric($app['app_id'])) {
        d_echo('$app does not contain app_id, could not update');
        return;
    }

    $data = array(
        'app_state'  => 'UNKNOWN',
        'app_status' => $current,
        'timestamp'  => array('NOW()'),
    );

    if ($response != '' && $response !== false) {
        if (str_contains($response, array(
            'Traceback (most recent call last):',
        ))) {
            $data['app_state'] = 'ERROR';
        } else {
            $data['app_state'] = 'OK';
        }
    }

    if ($data['app_state'] != $app['app_state']) {
        $data['app_state_prev'] = $app['app_state'];
    }
    dbUpdate($data, 'applications', '`app_id` = ?', array($app['app_id']));
}

function convert_to_celsius($value)
{
    $value = ($value - 32) / 1.8;
    return sprintf('%.02f', $value);
}
