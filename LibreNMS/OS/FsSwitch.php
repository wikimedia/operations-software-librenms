<?php
/**
 * Fs-switch.php
 *
 * -Description-
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
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 *
 * @link       https://www.librenms.org
 *
 * @copyright  2019 PipoCanaja
 * @author     PipoCanaja <pipocanaja@gmail.com>
 */

namespace LibreNMS\OS;

use LibreNMS\Device\Processor;
use LibreNMS\Interfaces\Discovery\ProcessorDiscovery;
use LibreNMS\OS;

class FsSwitch extends OS implements ProcessorDiscovery
{
    /**
     * Discover processors.
     * Returns an array of LibreNMS\Device\Processor objects that have been discovered
     *
     * @return array Processors
     */
    public function discoverProcessors()
    {
        $processors = [];

        // Get the number of CPUs
        $num_cpus_data = snmpwalk_cache_oid($this->getDeviceArray(), 'ssCpuNumCpus', [], 'UCD-SNMP-MIB');
        $num_cpus = isset($num_cpus_data[0]['ssCpuNumCpus']) ? $num_cpus_data[0]['ssCpuNumCpus'] : 1;

        // Get the tick rate dynamically - default to 100 if not available
        $tick_rate_data = snmpwalk_cache_oid($this->getDeviceArray(), 'sysClkRate', [], 'HOST-RESOURCES-MIB');
        $ticks_per_second = isset($tick_rate_data[0]['sysClkRate']) ? $tick_rate_data[0]['sysClkRate'] : 100;

        // Tests OID from SWITCH MIB.
        $processors_data = snmpwalk_cache_oid($this->getDeviceArray(), 'ssCpuRawIdle', [], 'SWITCH', 'fs');

        foreach ($processors_data as $index => $entry) {
            // Calculate total ticks for all CPUs
            $total_ticks = $num_cpus * $ticks_per_second;
            $idle_percentage = ($entry['ssCpuRawIdle'] / $total_ticks) * 100;

            $processors[] = Processor::discover(
                'fs-SWITCHMIB',
                $this->getDeviceId(),
                '.1.3.6.1.4.1.27975.1.2.11.' . $index,
                $index,
                'CPU',
                -1,
                100 - $idle_percentage
            );
        }

        return $processors;
    }
}
