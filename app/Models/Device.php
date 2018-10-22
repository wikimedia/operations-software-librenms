<?php

namespace App\Models;

use DB;
use Fico7489\Laravel\Pivot\Traits\PivotEventTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Query\JoinClause;
use LibreNMS\Exceptions\InvalidIpException;
use LibreNMS\Util\IP;
use LibreNMS\Util\IPv4;
use LibreNMS\Util\IPv6;

class Device extends BaseModel
{
    use PivotEventTrait;

    public $timestamps = false;
    protected $primaryKey = 'device_id';
    protected $fillable = ['hostname', 'ip', 'status', 'status_reason'];
    protected $casts = ['status' => 'boolean'];

    /**
     * Initialize this class
     */
    public static function boot()
    {
        parent::boot();

        static::deleting(function (Device $device) {
            // delete related data
            $device->ports()->delete();
            $device->syslogs()->delete();
            $device->eventlogs()->delete();

            // handle device dependency updates
            $device->children->each->updateMaxDepth($device->device_id);
        });

        // handle device dependency updates
        static::updated(function (Device $device) {
            if ($device->isDirty('max_depth')) {
                $device->children->each->updateMaxDepth();
            }
        });

        static::pivotAttached(function (Device $device, $relationName, $pivotIds, $pivotIdsAttributes) {
            if ($relationName == 'parents') {
                // a parent attached to this device

                // update the parent's max depth incase it used to be standalone
                Device::whereIn('device_id', $pivotIds)->get()->each->validateStandalone();

                // make sure this device's max depth is updated
                $device->updateMaxDepth();
            } elseif ($relationName == 'children') {
                // a child device attached to this device

                // if this device used to be standalone, we need to udpate max depth
                $device->validateStandalone();

                // make sure the child's max depth is updated
                Device::whereIn('device_id', $pivotIds)->get()->each->updateMaxDepth();
            }
        });

        static::pivotDetached(function (Device $device, $relationName, $pivotIds) {
            if ($relationName == 'parents') {
                // this device detached from a parent

                // update this devices max depth
                $device->updateMaxDepth();

                // parent may now be standalone, update old parent
                Device::whereIn('device_id', $pivotIds)->get()->each->validateStandalone();
            } elseif ($relationName == 'children') {
                // a child device detached from this device

                // update the detached child's max_depth
                Device::whereIn('device_id', $pivotIds)->get()->each->updateMaxDepth();

                // this device may be standalone, update it
                $device->validateStandalone();
            }
        });
    }

    // ---- Helper Functions ----

    public static function findByHostname($hostname)
    {
        return static::where('hostname', $hostname)->first();
    }

    public static function findByIp($ip)
    {
        if (!IP::isValid($ip)) {
            return null;
        }

        $device = static::where('hostname', $ip)->orWhere('ip', inet_pton($ip))->first();

        if ($device) {
            return $device;
        }

        try {
            $ipv4 = new IPv4($ip);
            $port = Ipv4Address::where('ipv4_address', (string) $ipv4)
                ->with('port', 'port.device')
                ->firstOrFail()->port;
            if ($port) {
                return $port->device;
            }
        } catch (InvalidIpException $e) {
            //
        } catch (ModelNotFoundException $e) {
            //
        }

        try {
            $ipv6 = new IPv6($ip);
            $port = Ipv6Address::where('ipv6_address', $ipv6->uncompressed())
                ->with(['port', 'port.device'])
                ->firstOrFail()->port;
            if ($port) {
                return $port->device;
            }
        } catch (InvalidIpException $e) {
            //
        } catch (ModelNotFoundException $e) {
            //
        }

        return null;
    }

    /**
     * Get the display name of this device (hostname) unless force_ip_to_sysname is set
     * and hostname is an IP and sysName is set
     *
     * @return string
     */
    public function displayName()
    {
        if (\LibreNMS\Config::get('force_ip_to_sysname') && $this->sysName && IP::isValid($this->hostname)) {
            return $this->sysName;
        }

        return $this->hostname;
    }

    /**
     * Get the shortened display name of this device.
     * Length is always overridden by shorthost_target_length.
     *
     * @param int $length length to shorten to, will not break up words so may be longer
     * @return string
     */
    public function shortDisplayName($length = 12)
    {
        $name = $this->displayName();

        // IP addresses should not be shortened
        if (IP::isValid($name)) {
            return $name;
        }

        $length = \LibreNMS\Config::get('shorthost_target_length', $length);
        if ($length < strlen($name)) {
            $take = substr_count($name, '.', 0, $length) + 1;
            return implode('.', array_slice(explode('.', $name), 0, $take));
        }

        return $name;
    }

    /**
     * Check if user can access this device.
     *
     * @param User $user
     * @return bool
     */
    public function canAccess($user)
    {
        if (!$user) {
            return false;
        }

        if ($user->hasGlobalRead()) {
            return true;
        }

        return DB::table('devices_perms')
            ->where('user_id', $user->user_id)
            ->where('device_id', $this->device_id)->exists();
    }

    public function formatUptime($short = false)
    {
        $result = '';
        $interval = $this->uptime;
        $data = [
            'years' => 31536000,
            'days' => 86400,
            'hours' => 3600,
            'minutes' => 60,
            'seconds' => 1,
        ];

        foreach ($data as $k => $v) {
            if ($interval >= $v) {
                $diff = floor($interval / $v);

                $result .= " $diff";
                if ($short) {
                    $result .= substr($k, 0, 1);
                } elseif ($diff > 1) {
                    $result .= $k;
                } else {
                    $result .= substr($k, 0, -1);
                }

                $interval -= $v * $diff;
            }
        }

        return $result;
    }

    /**
     * @return string
     */
    public function logo()
    {
        $base_name = pathinfo($this->icon, PATHINFO_FILENAME);
        $options = [
            "images/logos/$base_name.svg",
            "images/logos/$base_name.png",
            "images/os/$base_name.svg",
            "images/os/$base_name.png",
        ];

        foreach ($options as $file) {
            if (is_file(public_path()."/$file")) {
                return asset($file);
            }
        }

        return asset('images/os/generic.svg');
    }

    /**
     * Update the max_depth field based on parents
     * Performs SQL query, so make sure all parents are saved first
     *
     * @param int $exclude exclude a device_id from being considered (used for deleting)
     */
    public function updateMaxDepth($exclude = null)
    {
        // optimize for memory instead of time
        $query = $this->parents()->getQuery();
        if (!is_null($exclude)) {
            $query->where('device_id', '!=', $exclude);
        }

        $count = $query->count();
        if ($count === 0) {
            if ($this->children()->count() === 0) {
                $this->max_depth = 0; // no children or parents
            } else {
                $this->max_depth = 1; // has children
            }
        } else {
            $parents_max_depth = $query->max('max_depth');
            $this->max_depth = $parents_max_depth + 1;
        }

        $this->save();
    }

    /**
     * Device dependency check to see if this node is standalone or not.
     * Standalone is a special case where the device has no parents or children and is denoted by a max_depth of 0
     *
     * Only checks on root nodes (where max_depth is 1 or 0)
     *
     */
    public function validateStandalone()
    {
        if ($this->max_depth === 0 && $this->children()->count() > 0) {
            $this->max_depth = 1;  // has children
        } elseif ($this->max_depth === 1 && $this->parents()->count() === 0) {
            $this->max_depth = 0;  // no children or parents
        }

        $this->save();
    }

    /**
     * @return string
     */
    public function statusColour()
    {
        $status = $this->status;
        $ignore = $this->ignore;
        $disabled = $this->disabled;
        if ($disabled == 1) {
            return 'teal';
        } elseif ($ignore == 1) {
            return 'yellow';
        } elseif ($status == 0) {
            return 'danger';
        } else {
            return 'success';
        }
    }

    // ---- Accessors/Mutators ----

    public function getIconAttribute($icon)
    {
        if (isset($icon)) {
            return "images/os/$icon";
        }
        return 'images/os/generic.svg';
    }
    public function getIpAttribute($ip)
    {
        if (empty($ip)) {
            return null;
        }
        // @ suppresses warning, inet_ntop() returns false if it fails
        return @inet_ntop($ip) ?: null;
    }

    public function setIpAttribute($ip)
    {
        $this->attributes['ip'] = inet_pton($ip);
    }

    public function setStatusAttribute($status)
    {
        $this->attributes['status'] = (int)$status;
    }

    // ---- Query scopes ----

    public function scopeIsUp($query)
    {
        return $query->where([
            ['status', '=', 1],
            ['ignore', '=', 0],
            ['disabled', '=', 0]
        ]);
    }

    public function scopeIsActive($query)
    {
        return $query->where([
            ['ignore', '=', 0],
            ['disabled', '=', 0]
        ]);
    }

    public function scopeIsDown($query)
    {
        return $query->where([
            ['status', '=', 0],
            ['ignore', '=', 0],
            ['disabled', '=', 0]
        ]);
    }

    public function scopeIsIgnored($query)
    {
        return $query->where([
            ['ignore', '=', 1],
            ['disabled', '=', 0]
        ]);
    }

    public function scopeNotIgnored($query)
    {
        return $query->where([
            ['ignore', '=', 0]
        ]);
    }

    public function scopeIsDisabled($query)
    {
        return $query->where([
            ['disabled', '=', 1]
        ]);
    }

    public function scopeCanPing(Builder $query)
    {
        return $query->where('disabled', 0)
            ->leftJoin('devices_attribs', function (JoinClause $query) {
                $query->on('devices.device_id', 'devices_attribs.device_id')
                    ->where('devices_attribs.attrib_type', 'override_icmp_disable');
            })
            ->where(function (Builder $query) {
                $query->whereNull('devices_attribs.attrib_value')
                    ->orWhere('devices_attribs.attrib_value', '!=', 'true');
            });
    }

    public function scopeHasAccess($query, User $user)
    {
        return $this->hasDeviceAccess($query, $user);
    }

    // ---- Define Relationships ----

    public function alerts()
    {
        return $this->hasMany('App\Models\Alert', 'device_id');
    }

    public function applications()
    {
        return $this->hasMany('App\Models\Application', 'device_id');
    }

    public function bgppeers()
    {
        return $this->hasMany('App\Models\BgpPeer', 'device_id');
    }

    public function cefSwitching()
    {
        return $this->hasMany('App\Models\CefSwitching', 'device_id');
    }

    public function children()
    {
        return $this->belongsToMany('App\Models\Device', 'device_relationships', 'parent_device_id', 'child_device_id');
    }

    public function components()
    {
        return $this->hasMany('App\Models\Component', 'device_id');
    }

    public function eventlogs()
    {
        return $this->hasMany('App\Models\General\Eventlog', 'host', 'device_id');
    }

    public function groups()
    {
        return $this->belongsToMany('App\Models\DeviceGroup', 'device_group_device', 'device_id', 'device_group_id');
    }

    public function ospfInstances()
    {
        return $this->hasMany('App\Models\OspfInstance', 'device_id');
    }

    public function packages()
    {
        return $this->hasMany('App\Models\Package', 'device_id', 'device_id');
    }

    public function parents()
    {
        return $this->belongsToMany('App\Models\Device', 'device_relationships', 'child_device_id', 'parent_device_id');
    }

    public function perf()
    {
        return $this->hasMany('App\Models\DevicePerf', 'device_id');
    }

    public function ports()
    {
        return $this->hasMany('App\Models\Port', 'device_id', 'device_id');
    }

    public function processors()
    {
        return $this->hasMany('App\Models\Processor', 'device_id');
    }

    public function rules()
    {
        return $this->belongsToMany('App\Models\AlertRule', 'alert_device_map', 'device_id', 'rule_id');
    }

    public function sensors()
    {
        return $this->hasMany('App\Models\Sensor', 'device_id');
    }

    public function services()
    {
        return $this->hasMany('App\Models\Service', 'device_id');
    }

    public function storage()
    {
        return $this->hasMany('App\Models\Storage', 'device_id');
    }

    public function mempools()
    {
        return $this->hasMany('App\Models\Mempool', 'device_id');
    }

    public function syslogs()
    {
        return $this->hasMany('App\Models\General\Syslog', 'device_id', 'device_id');
    }

    public function users()
    {
        // FIXME does not include global read
        return $this->belongsToMany('App\Models\User', 'devices_perms', 'device_id', 'user_id');
    }

    public function vrfs()
    {
        return $this->hasMany('App\Models\Vrf', 'device_id');
    }
}
