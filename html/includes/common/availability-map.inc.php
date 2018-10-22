<?php
/*
 * LibreNMS
 *
 * Copyright (c) 2015 Søren Friis Rosiak <sorenrosiak@gmail.com>
 * Copyright (c) 2016 Jens Langhammer <jens@beryju.org>
 * Copyright (c) 2016 Cercel Valentin <crc@nuamchefazi.ro>
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.  Please see LICENSE.txt at the top level of
 * the source code distribution for details.
 */

if (isset($widget_settings['mode_select']) && $widget_settings['mode_select'] !== '') {
    $mode = $widget_settings['mode_select'];
} elseif (isset($_SESSION["map_view"]) && is_numeric($_SESSION["map_view"])) {
    $mode = $_SESSION["map_view"];
} else {
    $mode = 0;
}

$select_modes = array(
    '0' => 'only devices',
    '1' => 'only services',
    '2' => 'devices and services',
);

if ($config['webui']['availability_map_compact'] == 1) {
    $compact_tile = $widget_settings['tile_size'];
}

$show_disabled_ignored = $widget_settings['show_disabled_and_ignored'];

if (defined('SHOW_SETTINGS')) {
    $common_output[] = '
    <form class="form" onsubmit="widget_settings(this); return false;">
        <div class="form-group">
            <div class="col-sm-4">
                <label for="title" class="control-label availability-map-widget-header">Widget title</label>
            </div>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="title" placeholder="Custom title for widget" value="'.htmlspecialchars($widget_settings['title']).'">
            </div>
        </div>';

    if ($config['webui']['availability_map_compact'] === false) {
        $common_output[] = '
    <div class="form-group">
        <div class="col-sm-4">
            <label for="color_only_select" class="control-label availability-map-widget-header">Uniform Tiles</label>
        </div>
        <div class="col-sm-6">
            <select class="form-control" name="color_only_select">
                <option value="1"' . ($widget_settings['color_only_select'] == 1 ? ' selected' : '')  . ' >yes</option>
                <option value="0"' . ($widget_settings['color_only_select'] == 1 ? '' : ' selected')  . ' >no</option>
            </select>
        </div>
    </div>
';
    }

    if ($config['webui']['availability_map_compact'] == 1) {
        $common_output[] = '
        <div class="form-group">
            <div class="col-sm-4">
                <label for="tile_size" class="control-label availability-map-widget-header">Tile size</label>
            </div>      
            <div class="col-sm-6">
                <input type="text" class="form-control" name="tile_size" value="'.$compact_tile.'">
            </div>
        </div>';
    }

    if ($show_disabled_ignored == 1) {
        $selected_yes = 'selected';
        $selected_no = '';
    } else {
        $selected_yes = '';
        $selected_no = 'selected';
    }

    $common_output[] = '
    <div class="form-group">
        <div class="col-sm-4">
            <label for="show_disabled_and_ignored" class="control-label availability-map-widget-header">Disabled/ignored</label>
        </div>
        <div class="col-sm-6">
            <select class="form-control" name="show_disabled_and_ignored">
                <option value="1" '.$selected_yes.'>yes</option>
                <option value="0" '.$selected_no.'>no</option>
            </select>
        </div>
    </div>';

    $common_output[] = '
    <div class ="form-group">
        <div class="col-sm-4">
            <label for="mode_select" class="control-lable availability-map-widget-header">Mode</label>
        </div>
        <div class="col-sm-6">
            <select name="mode_select" class="form-control">';

    if ($config['show_services'] == 0) {
        $common_output[] = '<option value="0" selected>only devices</option>';
    } else {
        foreach ($select_modes as $mode_select => $option) {
            if ($mode_select == $widget_settings["mode_select"]) {
                $selected = 'selected';
            } else {
                $selected = '';
            }
            $common_output[] = '<option value="' . $mode_select . '" ' . $selected . '>' . $option . '</option>';
        }
    }
    $common_output[] = '
            </select>
        </div>
    </div>';

    if ($config['webui']['availability_map_compact'] == 1) {
        $common_outputp[] = '
        <div class="form-group">
            <div class="col-sm-4">
                <label for="tile_size" class="control-label availability-map-widget-header">Tile width</label>
            </div>
            <div class="col-sm-6">
                <input class="form-control" type="text" onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57" name="tile_size" placeholder="Tile side in px" value="'.$compact_tile.'">
            </div>
        </div>
        ';
    }


    $common_output[] = '
        <br style="clear:both;">
        <div class="form-group">
            <div class="col-sm-2">
                <button type="submit" class="btn btn-default">Set</button>
            </div>
        </div>
    </form>';
} else {
    require_once 'includes/object-cache.inc.php';

    $host_up_count = 0;
    $host_warn_count = 0;
    $host_down_count = 0;
    $host_ignored_count = 0;
    $host_disabled_count = 0;
    $service_up_count = 0;
    $service_warn_count = 0;
    $service_down_count = 0;
    $service_ignored_count = 0;
    $service_disabled_count = 0;

    if ($config['webui']['availability_map_sort_status'] == 1) {
        $deviceOrderBy = 'status';
        $serviceOrderBy = '`S`.`service_status` DESC';
    } else {
        $deviceOrderBy = 'hostname';
        $serviceOrderBy = '`D`.`hostname`';
    }

    if ($mode == 0 || $mode == 2) {
        // Only show devices if mode is 0 or 2 (Only Devices or both)
        if ($config['webui']['availability_map_use_device_groups'] != 0) {
            $device_group = 'SELECT `D`.`device_id` FROM `device_group_device` AS `D` WHERE `device_group_id` = ?';
            $param = array($_SESSION['group_view']);
            $devices = dbFetchRows($device_group, $param);
            foreach ($devices as $in_dev) {
                $in_devices[] = $in_dev['device_id'];
            }
            $in_devices = implode(',', $in_devices);
        }

        $sql = 'SELECT `D`.`hostname`, `D`.`sysName`, `D`.`device_id`, `D`.`status`, `D`.`uptime`, `D`.`os`, `D`.`icon`, `D`.`ignore`, `D`.`disabled` FROM `devices` AS `D`';

        if (is_normal_user() === true) {
            $sql .= ' , `devices_perms` AS P WHERE D.`device_id` = P.`device_id` AND P.`user_id` = ? AND ';
            $param = array(
                $_SESSION['user_id']
            );
        } else {
            $sql .= ' WHERE ';
        }

        if ($show_disabled_ignored != 1) {
            $sql .= '`D`.`ignore` = 0 AND `D`.`disabled` = 0 ';
        } else {
            $sql .= '(`D`.`status` IN (0,1,2) OR `D`.`ignore` = 1 OR `D`.`disabled` = 1)';
        }

        if ($config['webui']['availability_map_use_device_groups'] != 0 && isset($in_devices)) {
            $sql .= " AND `D`.`device_id` IN ($in_devices)";
        }

        $sql .= " ORDER BY `".$deviceOrderBy."`";

        $temp_output = array();

        foreach (dbFetchRows($sql, $param) as $device) {
            if ($device['disabled'] == '1') {
                $deviceState = "disabled";
                $deviceLabel = "blackbg";
                $host_disabled_count++;
            } elseif ($device['ignore'] == '1') {
                $deviceState = "ignored";
                $deviceLabel = "label-default";
                $host_ignored_count++;
            } elseif ($device['status'] == '1') {
                if (($device['uptime'] < $config['uptime_warning']) && ($device['uptime'] != 0)) {
                    $deviceState = 'warn';
                    $deviceLabel = 'label-warning';
                    $deviceLabelOld = 'availability-map-oldview-box-warn';
                    $host_warn_count++;
                } else {
                    $deviceState = 'up';
                    $deviceLabel = 'label-success';
                    $deviceLabelOld = 'availability-map-oldview-box-up';
                    $host_up_count++;
                }
            } else {
                $deviceState = 'down';
                $deviceLabel = 'label-danger';
                $deviceLabelOld = 'availability-map-oldview-box-down';
                $host_down_count++;
            }
            $device_system_name = format_hostname($device);

            if ($config['webui']['availability_map_compact'] == 0) {
                if ($directpage == "yes") {
                    $deviceIcon = getIconTag($device);
                    $temp_output[] = '
                    <a href="' .generate_device_url($device). '" title="' . $device_system_name . " - " . formatUptime($device['uptime']) . '">
                    <div class="device-availability ' . $deviceState . '" style="width:' . $config['webui']['availability_map_box_size'] . 'px;">
                        <span class="availability-label label ' . $deviceLabel . ' label-font-border">' . $deviceState . '</span>
                        <span class="device-icon">' . $deviceIcon . '</span><br>
                        <span class="small">' . shorthost($device_system_name) . '</span>
                    </div>
                    </a>';
                } else {
                    if ($widget_settings['color_only_select'] == 1) {
                        $deviceState = ' ';
                        $deviceLabel .= ' widget-availability-fixed';
                    }
                    $temp_output[] = '
                    <a href="' .generate_device_url($device). '" title="' . $device_system_name . " - " . formatUptime($device['uptime']) . '">
                        <span class="label ' . $deviceLabel . ' widget-availability label-font-border">' . $deviceState . '</span>
                    </a>';
                }
            } else {
                $temp_output[] = "<a href='" . generate_device_url($device) . "' title='" . $device_system_name . ' - ' . formatUptime($device['uptime']) . "'><div class='" . $deviceLabelOld . "' style='width:${compact_tile}px;height:${compact_tile}px;'></div></a>";
            }
        }
    }

    if (($mode == 1 || $mode == 2) && ($config['show_services'] != 0)) {
        if (is_normal_user() === false) {
            $service_query = 'select `S`.`service_type`, `S`.`service_id`, `S`.`service_desc`, `S`.`service_status`, `D`.`hostname`, `D`.`sysName`, `D`.`device_id`, `D`.`os`, `D`.`icon` from services S, devices D where `S`.`device_id` = `D`.`device_id` ORDER BY '.$serviceOrderBy.';';
            $service_par = array();
        } else {
            $service_query = 'select `S`.`service_type`, `S`.`service_id`, `S`.`service_desc`, `S`.`service_status`, `D`.`hostname`, `D`.`sysName`, `D`.`device_id`, `D`.`os`, `D`.`icon` from services S, devices D, devices_perms P where `S`.`device_id` = `D`.`device_id` AND D.device_id = P.device_id AND P.user_id = ? ORDER BY '.$serviceOrderBy.';';
            $service_par = array($_SESSION['user_id']);
        }
        $services = dbFetchRows($service_query, $service_par);
        if (count($services) > 0) {
            foreach ($services as $service) {
                if ($service['service_status'] == '0') {
                    $serviceLabel = "label-success";
                    $serviceLabelOld = 'availability-map-oldview-box-up';
                    $serviceState = "up";
                    $service_up_count++;
                } elseif ($service['service_status'] == '1') {
                    $serviceLabel = "label-warning";
                    $serviceLabelOld = 'availability-map-oldview-box-warn';
                    $serviceState = "warn";
                    $service_warn_count++;
                } else {
                    $serviceLabel = "label-danger";
                    $serviceLabelOld = 'availability-map-oldview-box-down';
                    $serviceState = "down";
                    $service_down_count++;
                }
                $service_system_name = format_hostname($service);

                if ($config['webui']['availability_map_compact'] == 0) {
                    if ($directpage == "yes") {
                        $deviceIcon = getIconTag($service);
                        $temp_output[] = '
                        <a href="' . generate_url(array('page' => 'device', 'tab' => 'services', 'device' => $service['device_id'])) . '" title="' . $service_system_name . " - " . $service['service_type'] . " - " . $service['service_desc'] . '">
                            <div class="service-availability ' . $serviceState . '" style="width:' . $config['webui']['availability_map_box_size'] . 'px;">
                                <span class="service-name-label label ' . $serviceLabel . ' label-font-border">' . $service["service_type"] . '</span>
                                <span class="availability-label label ' . $serviceLabel . ' label-font-border">' . $serviceState . '</span>
                                <span class="device-icon">' . $deviceIcon . '</span><br>
                                <span class="small">' . shorthost($service_system_name) . '</span>
                            </div>
                        </a>';
                    } else {
                        $serviceText = $service['service_type'] . ' - ' . $serviceState;
                        if ($widget_settings['color_only_select'] == 1) {
                            $serviceText = ' ';
                            $serviceLabel .= ' widget-availability-fixed';
                        }
                        $temp_output[] = '
                        <a href="' . generate_url(array('page' => 'device', 'tab' => 'services', 'device' => $service['device_id'])) . '" title="' . shorthost($service_system_name) . " - " . $service['service_type'] . " - " . $service['service_desc'] . '">
                            <span class="label ' . $serviceLabel . ' widget-availability label-font-border">' . $serviceText . '</span>
                        </a>';
                    }
                } else {
                    $temp_output[] = "<a href='" . generate_url(array('page' => 'device', 'tab' => 'services', 'device' => $service['device_id'])) . "' title='${service_system_name} - ${service['service_type']} - ${service['service_desc']}'><div class='" . $serviceLabelOld . "' style='width:${compact_tile}px;height:${compact_tile}px;'></div></a>";
                }
            }
        } else {
            $temp_output [] = '';
        }
    }

    if ($directpage == "yes") {
        $temp_header[] = '
        <div class="page-availability-title-left">
            <span class="page-availability-title">Availability map for</span>
            <select id="mode" class="page-availability-report-select" name="mode">';

        if ($config['show_services'] == 0) {
            $temp_header[] = '<option value="0" selected>only devices</option>';
        } else {
            foreach ($select_modes as $mode_select => $option) {
                if ($mode_select == $mode) {
                    $selected = 'selected';
                } else {
                    $selected = '';
                }
                $temp_header[] = '<option value="' . $mode_select . '" ' . $selected . '>' . $option . '</option>';
            }
        }

        $temp_header[] =
            '</select>
        </div>
        <div class="page-availability-title-right">';

        if (($config['webui']['availability_map_use_device_groups'] != 0) && ($mode == 0 || $mode == 2)) {
            $sql = 'SELECT `G`.`id`, `G`.`name` FROM `device_groups` AS `G`';
            $dev_groups = dbFetchRows($sql);

            if ($_SESSION['group_view'] == 0) {
                $selected = 'selected';
            } else {
                $selected = '';
            }

            $temp_header[] = '
            <span class="page-availability-title">Device group</span>
            <select id="group" class="page-availability-report-select" name="group">
                <option value="0" ' . $selected . '>show all devices</option>';

            foreach ($dev_groups as $dev_group) {
                if ($_SESSION['group_view'] == $dev_group['id']) {
                    $selected = 'selected';
                } else {
                    $selected = '';
                }
                $temp_header[] = '<option value="' . $dev_group['id'] . '" ' . $selected . '>' . $dev_group['name'] . '</option>';
            }
            $temp_header[] = '</select>';
        }
    }

    if ($directpage == "yes") {
        $deviceClass = 'page-availability-report-host';
        $serviceClass = 'page-availability-report-host';
    } else {
        $deviceClass = 'widget-availability-host';
        $serviceClass = 'widget-availability-service';
    }

    if ($show_disabled_ignored == 1) {
        $disabled_ignored_header = '
            <span class="label label-default label-font-border label-border">ignored: '.$host_ignored_count.'</span>
            <span class="label blackbg label-font-border label-border">disabled: '.$host_disabled_count.'</span>';
    }

    if ($mode == 0 || $mode == 2) {
        $temp_header[] = '
            <div class="' . $deviceClass . '">
                <span>Total hosts</span>
                <span class="label label-success label-font-border label-border">up: '.$host_up_count.'</span>
                <span class="label label-warning label-font-border label-border">warn: '.$host_warn_count.'</span>
                <span class="label label-danger label-font-border label-border">down: '.$host_down_count.'</span>
                '.$disabled_ignored_header.'
            </div>';
    }

    if (($mode == 1 || $mode == 2) && ($config['show_services'] != 0)) {
        $temp_header[] = '
            <div class="' . $serviceClass . '">
                <span>Total services</span>
                <span class="label label-success label-font-border label-border">up: '.$service_up_count.'</span>
                <span class="label label-warning label-font-border label-border">warn: '.$service_warn_count.'</span>
                <span class="label label-danger label-font-border label-border">down: '.$service_down_count.'</span>
            </div>';
    }

    $temp_header[] = '</div>';
    $temp_header[] = '<br style="clear:both;">';

    $common_output = array_merge($temp_header, $temp_output);
}
