<?php
/*
 * LibreNMS
 *
 * Copyright (c) 2017 Søren Friis Rosiak <sorenrosiak@gmail.com>
 * Copyright (c) 2017 Tony Murray <murraytony@gmail.com>
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.  Please see LICENSE.txt at the top level of
 * the source code distribution for details.
 */

if ($device['os'] == 'comware') {
    echo 'HPE Comware ';
    $entity_data = snmpwalk_cache_oid($device, 'entPhysicalName', array(), 'ENTITY-MIB');
    $procdata = snmpwalk_cache_oid($device, 'hh3cEntityExtCpuUsage', array(), 'HH3C-ENTITY-EXT-MIB');

    foreach ($entity_data as $entity => $value) {
        if (str_contains($value['entPhysicalName'], array('Board', 'MPU', 'RPU')) && !str_contains($value['entPhysicalName'], array('Fixed SubCard on Board'))) {
            if (isset($procdata[$entity]['hh3cEntityExtCpuUsage'])) {
                $cur_oid = ".1.3.6.1.4.1.25506.2.6.1.1.1.1.6.$entity";
                $cur_value = $procdata[$entity]['hh3cEntityExtCpuUsage'];
                $descr = $value['entPhysicalName'];
                discover_processor($valid['processor'], $device, $cur_oid, $entity, 'comware', $descr, '1', $cur_value);
            }
        }
    }
}
