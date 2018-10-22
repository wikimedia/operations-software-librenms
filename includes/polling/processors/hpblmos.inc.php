<?php
/*
 * LibreNMS HP Blade OA CPU information module
 *
 * Copyright (c) 2016 Cercel Valentin (crc@nuamchefazi.ro)
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.  Please see LICENSE.txt at the top level of
 * the source code distribution for details.
 */

$idle = snmp_get($device, '.1.3.6.1.4.1.2021.11.11.0', '-Ovqn');
$usage = 100 - $idle;
$proc = $usage;
