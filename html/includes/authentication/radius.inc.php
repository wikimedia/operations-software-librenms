<?php

use Dapphp\Radius\Radius;
use LibreNMS\Exceptions\AuthenticationException;
use Phpass\PasswordHash;

function init_auth()
{
    /** @var Radius $radius */
    global $radius, $config;

    $radius = new Radius($config['radius']['hostname'], $config['radius']['secret'], $config['radius']['suffix'], $config['radius']['timeout'], $config['radius']['port']);
}

function authenticate($username, $password)
{
    global $radius, $debug;

    if (empty($username)) {
        throw new AuthenticationException('Username is required');
    }

    if ($debug) {
        $radius->setDebug(true);
    }

    if ($radius->accessRequest($username, $password) === true) {
        adduser($username, $password);
        return true;
    }

    throw new AuthenticationException();
}

function reauthenticate($sess_id, $token)
{
    return false;
}


function passwordscanchange()
{
    // not supported so return 0
    return 0;
}


function changepassword()
{
    // not supported so return 0
    return 0;
}


function auth_usermanagement()
{
    // not supported so return 0
    return 1;
}


function adduser($username, $password, $level = 1, $email = '', $realname = '', $can_modify_passwd = 0, $description = '')
{
    // Check to see if user is already added in the database
    global $config;
    if (!user_exists($username)) {
        $hasher    = new PasswordHash(8, false);
        $encrypted = $hasher->HashPassword($password);
        if ($config['radius']['default_level'] > 0) {
            $level = $config['radius']['default_level'];
        }
        $userid = dbInsert(array('username' => $username, 'password' => $encrypted, 'realname' => $realname, 'email' => $email, 'descr' => $description, 'level' => $level, 'can_modify_passwd' => $can_modify_passwd), 'users');
        if ($userid == false) {
            return false;
        } else {
            foreach (dbFetchRows('select notifications.* from notifications where not exists( select 1 from notifications_attribs where notifications.notifications_id = notifications_attribs.notifications_id and notifications_attribs.user_id = ?) order by notifications.notifications_id desc', array($userid)) as $notif) {
                dbInsert(array('notifications_id'=>$notif['notifications_id'],'user_id'=>$userid,'key'=>'read','value'=>1), 'notifications_attribs');
            }
        }
        return $userid;
    } else {
        return false;
    }
}

function user_exists($username)
{
    return dbFetchCell('SELECT COUNT(*) FROM users WHERE username = ?', array($username), true);
}


function get_userlevel($username)
{
    return dbFetchCell('SELECT `level` FROM `users` WHERE `username` = ?', array($username), true);
}


function get_userid($username)
{
    return dbFetchCell('SELECT `user_id` FROM `users` WHERE `username` = ?', array($username), true);
}


function deluser($userid)
{
    dbDelete('bill_perms', '`user_id` =  ?', array($userid));
    dbDelete('devices_perms', '`user_id` =  ?', array($userid));
    dbDelete('ports_perms', '`user_id` =  ?', array($userid));
    dbDelete('users_prefs', '`user_id` =  ?', array($userid));
    dbDelete('users', '`user_id` =  ?', array($userid));
    return dbDelete('users', '`user_id` =  ?', array($userid));
}


function get_userlist()
{
    return dbFetchRows('SELECT * FROM `users`');
}


function can_update_users()
{
    // supported so return 1
    return 1;
}


function get_user($user_id)
{
    return dbFetchRow('SELECT * FROM `users` WHERE `user_id` = ?', array($user_id), true);
}


function update_user($user_id, $realname, $level, $can_modify_passwd, $email)
{
    dbUpdate(array('realname' => $realname, 'level' => $level, 'can_modify_passwd' => $can_modify_passwd, 'email' => $email), 'users', '`user_id` = ?', array($user_id));
}
