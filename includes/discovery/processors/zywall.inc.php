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

if ($device['os'] == 'zywall') {
    echo 'Zywall Processors: ';
    $descr = 'Processor';
    $oid = '.1.3.6.1.4.1.890.1.6.22.1.1.0';
    $usage = snmp_get($device, $oid, '-OQUvs');
    if (is_numeric($usage)) {
        discover_processor($valid['processor'], $device, $oid, '0', 'zywall', $descr, 1, $usage, null, null);
    }
}
