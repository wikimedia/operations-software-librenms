<?php
/**
 * vrp.inc.php
 *
 * LibreNMS sensor pre-cache discovery module for VRP
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package    LibreNMS
 * @link       http://librenms.org
 * @copyright  2016 Neil Lathwood
 * @author     Neil Lathwood <neil@lathwood.co.uk>
 */

echo 'hwEntityStateEntry ';
$pre_cache['vrp_oids'] = snmpwalk_cache_index($device, '.1.3.6.1.4.1.2011.5.25.31.1.1.1.1', array(), 'HUAWEI-ENTITY-EXTENT-MIB');

echo 'hwOpticalModuleInfoEntry ';
$pre_cache['vrp_oids'] = snmpwalk_cache_index($device, '.1.3.6.1.4.1.2011.5.25.31.1.1.3.1', $pre_cache['vrp_oids'], 'HUAWEI-ENTITY-EXTENT-MIB');

echo 'entPhysicalName ';
$pre_cache['vrp_oids'] = snmpwalk_cache_index($device, '.1.3.6.1.2.1.47.1.1.1.1.7', $pre_cache['vrp_oids'], 'HUAWEI-ENTITY-EXTENT-MIB');
