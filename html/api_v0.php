<?php

/*
 * LibreNMS
 *
 * Copyright (c) 2014 Neil Lathwood <https://github.com/laf/ http://www.lathwood.co.uk/fa>
 *
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.  Please see LICENSE.txt at the top level of
 * the source code distribution for details.
 */

$init_modules = array('web', 'alerts');
require realpath(__DIR__ . '/..') . '/includes/init.php';

use LibreNMS\Config;

$app = new \Slim\Slim();

if (Config::get('api.cors.enabled') === true) {
    $corsOptions = array(
        "origin" => Config::get('api.cors.origin'),
        "maxAge" => Config::get('api.cors.maxage'),
        "allowMethods" => Config::get('api.cors.allowmethods'),
        "allowHeaders" => Config::get('api.cors.allowheaders'),
    );
    $cors = new \CorsSlim\CorsSlim($corsOptions);
    $app->add($cors);
}

require $config['install_dir'] . '/html/includes/api_functions.inc.php';
$app->setName('api');

$app->group(
    '/api',
    function () use ($app) {
        $app->group(
            '/v0',
            function () use ($app) {
                $app->get('/bgp', 'authToken', 'list_bgp')->name('list_bgp');
                $app->get('/ospf', 'authToken', 'list_ospf')->name('list_ospf');
                // api/v0/bgp
                $app->get('/oxidized', 'authToken', 'list_oxidized')->name('list_oxidized');
                $app->group(
                    '/devices',
                    function () use ($app) {
                        $app->delete('/:hostname', 'authToken', 'del_device')->name('del_device');
                        // api/v0/devices/$hostname
                        $app->get('/:hostname', 'authToken', 'get_device')->name('get_device');
                        // api/v0/devices/$hostname
                        $app->patch('/:hostname', 'authToken', 'update_device')->name('update_device_field');
                        $app->get('/:hostname/vlans', 'authToken', 'get_vlans')->name('get_vlans');
                        // api/v0/devices/$hostname/vlans
                        $app->get('/:hostname/graphs', 'authToken', 'get_graphs')->name('get_graphs');
                        // api/v0/devices/$hostname/graphs
                        $app->get('/:hostname/health(/:type)(/:sensor_id)', 'authToken', 'list_available_health_graphs')->name('list_available_health_graphs');
                        // api/v0/devices/$hostname/health
                        $app->get('/:hostname/ports', 'authToken', 'get_port_graphs')->name('get_port_graphs');
                        $app->get('/:hostname/ip', 'authToken', 'get_ip_addresses')->name('get_device_ip_addresses');
                        $app->get('/:hostname/port_stack', 'authToken', 'get_port_stack')->name('get_port_stack');
                        // api/v0/devices/$hostname/ports
                        $app->get('/:hostname/components', 'authToken', 'get_components')->name('get_components');
                        $app->post('/:hostname/components/:type', 'authToken', 'add_components')->name('add_components');
                        $app->put('/:hostname/components', 'authToken', 'edit_components')->name('edit_components');
                        $app->delete('/:hostname/components/:component', 'authToken', 'delete_components')->name('delete_components');
                        $app->get('/:hostname/groups', 'authToken', 'get_device_groups')->name('get_device_groups');
                        $app->get('/:hostname/graphs/health/:type(/:sensor_id)', 'authToken', 'get_graph_generic_by_hostname')->name('get_health_graph');
                        $app->get('/:hostname/:type', 'authToken', 'get_graph_generic_by_hostname')->name('get_graph_generic_by_hostname');
                        // api/v0/devices/$hostname/$type
                        $app->get('/:hostname/ports/:ifname', 'authToken', 'get_port_stats_by_port_hostname')->name('get_port_stats_by_port_hostname');
                        // api/v0/devices/$hostname/ports/$ifName
                        $app->get('/:hostname/ports/:ifname/:type', 'authToken', 'get_graph_by_port_hostname')->name('get_graph_by_port_hostname');
                        // api/v0/devices/$hostname/ports/$ifName/$type
                    }
                );
                $app->get('/devices', 'authToken', 'list_devices')->name('list_devices');
                // api/v0/devices
                $app->post('/devices', 'authToken', 'add_device')->name('add_device');
                // api/v0/devices (json data needs to be passed)
                $app->group(
                    '/devicegroups',
                    function () use ($app) {
                        $app->get('/:name', 'authToken', 'get_devices_by_group')->name('get_devices_by_group');
                    }
                );
                $app->get('/devicegroups', 'authToken', 'get_device_groups')->name('get_devicegroups');
                $app->group(
                    '/ports',
                    function () use ($app) {
                        $app->get('/:portid', 'authToken', 'get_port_info')->name('get_port_info');
                        $app->get('/:portid/ip', 'authToken', 'get_ip_addresses')->name('get_port_ip_info');
                    }
                );
                $app->get('/ports', 'authToken', 'get_all_ports')->name('get_all_ports');
                $app->group(
                    '/portgroups',
                    function () use ($app) {
                        $app->get('/multiport/bits/:id', 'authToken', 'get_graph_by_portgroup')->name('get_graph_by_portgroup_multiport_bits');
                        $app->get('/:group', 'authToken', 'get_graph_by_portgroup')->name('get_graph_by_portgroup');
                    }
                );
                $app->group(
                    '/bills',
                    function () use ($app) {
                        $app->get('/:bill_id', 'authToken', 'list_bills')->name('get_bill');
                        // api/v0/bills/$bill_id
                    }
                );
                $app->get('/bills', 'authToken', 'list_bills')->name('list_bills');
                // api/v0/bills
                // /api/v0/alerts
                $app->group(
                    '/alerts',
                    function () use ($app) {
                        $app->get('/:id', 'authToken', 'list_alerts')->name('get_alert');
                        // api/v0/alerts
                        $app->put('/:id', 'authToken', 'ack_alert')->name('ack_alert');
                        // api/v0/alerts/$id (PUT)
                        $app->put('/unmute/:id', 'authToken', 'unmute_alert')->name('unmute_alert');
                        // api/v0/alerts/unmute/$id (PUT)
                    }
                );
                $app->get('/alerts', 'authToken', 'list_alerts')->name('list_alerts');
                // api/v0/alerts
                // /api/v0/rules
                $app->group(
                    '/rules',
                    function () use ($app) {
                        $app->get('/:id', 'authToken', 'list_alert_rules')->name('get_alert_rule');
                        // api/v0/rules/$id
                        $app->delete('/:id', 'authToken', 'delete_rule')->name('delete_rule');
                        // api/v0/rules/$id (DELETE)
                    }
                );
                $app->get('/rules', 'authToken', 'list_alert_rules')->name('list_alert_rules');
                // api/v0/rules
                $app->post('/rules', 'authToken', 'add_edit_rule')->name('add_rule');
                // api/v0/rules (json data needs to be passed)
                $app->put('/rules', 'authToken', 'add_edit_rule')->name('edit_rule');
                // api/v0/rules (json data needs to be passed)
                // Inventory section
                $app->group(
                    '/inventory',
                    function () use ($app) {
                        $app->get('/:hostname', 'authToken', 'get_inventory')->name('get_inventory');
                    }
                );
                // End Inventory
                // Routing section
                $app->group(
                    '/routing',
                    function () use ($app) {
                        $app->group(
                            '/ipsec',
                            function () use ($app) {
                                $app->get('/data/:hostname', 'authToken', 'list_ipsec')->name('list_ipsec');
                            }
                        );
                    }
                );
            // End Routing
                // Resources section
                $app->group(
                    '/resources',
                    function () use ($app) {
                        $app->group(
                            '/ip',
                            function () use ($app) {
                                $app->get('/arp/:ip', 'authToken', 'list_arp')->name('list_arp')->conditions(array('ip' => '[^?]+'));
                            }
                        );
                    }
                );
                // End Resources
                // Service section
                $app->group(
                    '/services',
                    function () use ($app) {
                        $app->get('/:hostname', 'authToken', 'list_services')->name('get_service_for_host');
                    }
                );
                $app->get('/services', 'authToken', 'list_services')->name('list_services');
                // End Service
                $app->group(
                    '/logs',
                    function () use ($app) {
                        $app->get('/eventlog(/:hostname)', 'authToken', 'list_logs')->name('list_eventlog');
                        $app->get('/syslog(/:hostname)', 'authToken', 'list_logs')->name('list_syslog');
                        $app->get('/alertlog(/:hostname)', 'authToken', 'list_logs')->name('list_alertlog');
                        $app->get('/authlog(/:hostname)', 'authToken', 'list_logs')->name('list_authlog');
                    }
                );
            }
        );
        $app->get('/v0', 'authToken', 'show_endpoints');
        // api/v0
    }
);

$app->run();
