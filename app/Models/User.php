<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use LibreNMS\Authentication\LegacyAuth;

class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'user_id';
    protected $fillable = ['realname', 'username', 'email', 'level', 'descr', 'can_modify_passwd', 'auth_type', 'auth_id'];
    protected $hidden = ['password', 'remember_token', 'pivot'];
    protected $attributes = [ // default values
        'descr' => '',
        'realname' => '',
        'email' => '',
        'can_modify_passwd' => 0,
    ];

    // ---- Helper Functions ----

    /**
     * Test if this user has global read access
     * these users have a level of 5, 10 or 11 (demo).
     *
     * @return boolean
     */
    public function hasGlobalRead()
    {
        return $this->isAdmin() || $this->level == 5;
    }

    /**
     * Test if this user has global admin access
     * these users have a level of 10 or 11 (demo).
     *
     * @return boolean
     */
    public function hasGlobalAdmin()
    {
        return $this->level >= 10;
    }

    /**
     * Test if the User is an admin.
     *
     * @return boolean
     */
    public function isAdmin()
    {
        return $this->level == 10;
    }

    /**
     * Test if this user is the demo user
     *
     * @return bool
     */
    public function isDemo()
    {
        return $this->level == 11;
    }

    /**
     * Check if this user has access to a device
     *
     * @param Device|int $device can be a device Model or device id
     * @return bool
     */
    public function canAccessDevice($device)
    {
        return $this->hasGlobalRead() || $this->devices->contains($device);
    }

    // ---- Query scopes ----

    /**
     * This restricts the query to only users that match the current auth method
     * It is not needed when using user_id, but should be used for username and auth_id
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeThisAuth($query)
    {
        // find user including ones where we might not know the auth type
        $type = LegacyAuth::getType();

        return $query->where(function ($query) use ($type) {
            $query->where('auth_type', $type)
                ->orWhereNull('auth_type')
                ->orWhere('auth_type', '');
        });
    }

    // ---- Define Relationships ----

    public function devices()
    {
        if ($this->hasGlobalRead()) {
//            $instance = $this->newRelatedInstance('App\Models\Device');
//            return new HasAll($instance);
            return Device::query();
        } else {
            return $this->belongsToMany('App\Models\Device', 'devices_perms', 'user_id', 'device_id');
        }
    }

    public function ports()
    {
        if ($this->hasGlobalRead()) {
            return Port::query();
        } else {
            //FIXME we should return all ports for a device if the user has been given access to the whole device.
            return $this->belongsToMany('App\Models\Port', 'ports_perms', 'user_id', 'port_id');
        }
    }

    public function dashboards()
    {
        return $this->hasMany('App\Models\Dashboard', 'user_id');
    }

    public function preferences()
    {
        return $this->hasMany('App\Models\UserPref', 'user_id');
    }

    public function widgets()
    {
        return $this->hasMany('App\Models\UserWidget', 'user_id');
    }
}
