<?php
/**
 * Menu.php
 *
 * Builds data for LibreNMS menu
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
 * @copyright  2018 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

namespace App\Http\ViewComposers;

use App\Models\AlertRule;
use App\Models\Application;
use App\Models\BgpPeer;
use App\Models\CefSwitching;
use App\Models\Component;
use App\Models\Device;
use App\Models\DeviceGroup;
use App\Models\Notification;
use App\Models\OspfInstance;
use App\Models\Package;
use App\Models\Port;
use App\Models\Pseudowire;
use App\Models\Sensor;
use App\Models\Service;
use App\Models\User;
use App\Models\Vrf;
use App\Models\WirelessSensor;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use LibreNMS\Config;

class MenuComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $vars = [];
        /** @var User $user */
        $user = Auth::user();

        $vars['navbar'] = in_array(Config::get('site_style'), ['mono', 'dark']) ? 'navbar-inverse' : '';

        $vars['project_name'] = Config::get('project_name', 'LibreNMS');
        $vars['title_image'] = asset(Config::get('title_image', 'images/librenms_logo_light.svg'));

        // Device menu
        $vars['device_groups'] = DeviceGroup::hasAccess($user)->select('device_groups.id', 'name', 'desc')->get();
        $vars['package_count'] = Package::hasAccess($user)->count();

        $vars['device_types'] = Device::hasAccess($user)->select('type')->distinct()->get()->pluck('type')->filter();

        if (Config::get('show_locations') && Config::get('show_locations_dropdown')) {
            $vars['locations'] = Device::hasAccess($user)->select('location')->distinct()->get()->pluck('location')->filter();
        } else {
            $vars['locations'] = [];
        }

        // Service menu
        if (Config::get('show_services')) {
            $vars['service_status'] = Service::hasAccess($user)->groupBy('service_status')
                ->select('service_status', DB::raw('count(*) as count'))
                ->whereIn('service_status', [1, 2])
                ->get()
                ->keyBy('service_status');

            $warning = $vars['service_status']->get(1);
            $vars['service_warning'] = $warning ? $warning->count : 0;
            $critical = $vars['service_status']->get(2);
            $vars['service_critical'] = $critical ? $critical->count : 0;
        }

        // Port menu
        $vars['port_counts'] = [
            'count' => Port::hasAccess($user)->count(),
            'up' => Port::hasAccess($user)->isUp()->count(),
            'down' => Port::hasAccess($user)->isDown()->count(),
            'shutdown' => Port::hasAccess($user)->isDisabled()->count(),
            'errored' => Port::hasAccess($user)->hasErrors()->count(),
            'ignored' => Port::hasAccess($user)->isIgnored()->count(),
            'deleted' => Port::hasAccess($user)->isDeleted()->count(),
            'pseudowire' => Config::get('enable_pseudowires') ? Pseudowire::hasAccess($user)->count() : 0,
            'alerted' => 0, // not actually supported on old...
        ];

        // Sensor menu
        $sensor_menu = [];
        $sensor_classes = Sensor::hasAccess($user)->select('sensor_class')->groupBy('sensor_class')->orderBy('sensor_class')->get();

        foreach ($sensor_classes as $sensor_model) {
            /** @var Sensor $sensor_model */
            $class = $sensor_model->sensor_class;
            if (in_array($class, ['fanspeed', 'humidity', 'temperature', 'signal'])) {
                // First group
                $group = 0;
            } elseif (in_array($class, ['current', 'frequency', 'power', 'voltage'])) {
                // Second group
                $group = 1;
            } else {
                // anything else
                $group = 2;
            }

            $sensor_menu[$group][] = $sensor_model;
        }
        $vars['sensor_menu'] = $sensor_menu;

        // Wireless menu
        $wireless_menu_order = array_keys(\LibreNMS\Device\WirelessSensor::getTypes());
        $vars['wireless_menu'] = WirelessSensor::hasAccess($user)->select('sensor_class')
            ->groupBy('sensor_class')
            ->get()
            ->sortBy(function ($wireless_sensor) use ($wireless_menu_order) {
                $pos = array_search($wireless_sensor->sensor_class, $wireless_menu_order);
                return $pos === false ? 100 : $pos; // unknown at bottom
            });

        // Application menu
        $vars['app_menu'] = Application::hasAccess($user)
            ->select('app_type', 'app_instance')
            ->groupBy('app_type', 'app_instance')
            ->orderBy('app_type')
            ->get()
            ->groupBy('app_type');

        // Routing menu
        // FIXME queries use relationships to user
        $routing_menu = [];
        if ($user->hasGlobalRead()) {
            if (Vrf::hasAccess($user)->count()) {
                $routing_menu[] = [
                    [
                        'url' => 'vrf',
                        'icon' => 'arrows',
                        'text' => 'VRFs',
                    ]
                ];
            }

            if (OspfInstance::hasAccess($user)->count()) {
                $routing_menu[] = [
                    [
                        'url' => 'ospf',
                        'icon' => 'circle-o-notch fa-rotate-180',
                        'text' => 'OSPF Devices',
                    ]
                ];
            }

            if (Component::hasAccess($user)->where('type', 'Cisco-OTV')->count()) {
                $routing_menu[] = [
                    [
                        'url' => 'cisco-otv',
                        'icon' => 'exchange',
                        'text' => 'Cisco OTV',
                    ]
                ];
            }

            if (BgpPeer::hasAccess($user)->count()) {
                $vars['show_peeringdb'] = Config::get('peeringdb.enabled', false);
                $vars['bgp_alerts'] = BgpPeer::hasAccess($user)->inAlarm()->count();
                $routing_menu[] = [
                    [
                        'url' => 'bgp/type=all/graph=NULL',
                        'icon' => 'circle-o',
                        'text' => 'BGP All Sessions',
                    ],
                    [
                        'url' => 'bgp/type=external/graph=NULL',
                        'icon' => 'external-link',
                        'text' => 'BGP External',
                    ],
                    [
                        'url' => 'bgp/type=internal/graph=NULL',
                        'icon' => 'external-link fa-rotate-180',
                        'text' => 'BGP Internal',
                    ],
                ];
            } else {
                $vars['show_peeringdb'] = false;
                $vars['bgp_alerts'] = [];
            }

            if (CefSwitching::hasAccess($user)->count()) {
                $routing_menu[] = [
                    [
                        'url' => 'cef',
                        'icon' => 'exchange',
                        'text' => 'Cisco CEF',
                    ]
                ];
            }
        }
        $vars['routing_menu'] = $routing_menu;

        // Alert menu
        $alert_status = AlertRule::select('severity')
            ->isActive()
            ->hasAccess($user)
            ->groupBy('severity')
            ->pluck('severity');

        if ($alert_status->contains('critical')) {
            $vars['alert_menu_class'] = 'danger';
        } elseif ($alert_status->contains('warning')) {
            $vars['alert_menu_class'] = 'warning';
        } else {
            $vars['alert_menu_class'] = 'success';
        }

        // User menu
        $vars['notification_count'] = Notification::isSticky()
            ->orWhere(function ($query) use ($user) {
                $query->isUnread($user);
            })->count();

        // Search bar
        $vars['typeahead_limit'] = \LibreNMS\Config::get('webui.global_search_result_limit');

        $view->with($vars);
    }
}
