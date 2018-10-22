source: Extensions/Authentication.md
# Authentication modules

LibreNMS supports multiple authentication modules along with [Two Factor Auth](http://docs.librenms.org/Extensions/Two-Factor-Auth/).
Here we will provide configuration details for these modules.

### Available authentication modules

- MySQL: [mysql](#mysql-authentication)

- Active Directory: [active_directory](#active-directory-authentication)

- LDAP: [ldap](#ldap-authentication)

- Radius: [radius](#radius-authentication)

- HTTP Auth: [http-auth](#http-authentication), [ad_authorization](#http-authentication-ad-authorization), [ldap_authorization](#http-authentication-ldap-authorization)

### Enable authentication module

To enable a particular authentication module you need to set this up in config.php.

```php
$config['auth_mechanism'] = "mysql";
```

### User levels

- 1: Normal User. You will need to assign device / port permissions for users at this level.

- 5: Global Read.

- 10: This is a global read/write admin account

- 11: Demo Account. Provides full read/write with certain restrictions (i.e can't delete devices).

### Note for SELinux users
When using SELinux on the LibreNMS server, you need to allow Apache (httpd) to connect LDAP/Active Directory server, this is disabled by default. You can use SELinux Booleans to allow network access to LDAP resources with this command:

```shell
setsebool -P httpd_can_connect_ldap=1
```

### Testing authentication
You can test authentication with this script:
```shell
./scripts/auth_test.php
```
Enable debug output to troubleshoot issues


# MySQL Authentication

Config option: `mysql`

This is default option with LibreNMS so you should have already have the configuration setup.

```php
$config['db_host'] = "HOSTNAME";
$config['db_user'] = "DBUSER";
$config['db_pass'] = "DBPASS";
$config['db_name'] = "DBNAME";
```


# Active Directory Authentication

Config option: `active_directory`

Install __php_ldap__  or __php7.0-ldap__, making sure to install the same version as PHP.

If you have issues with secure LDAP try setting `$config['auth_ad_check_certificates']` to `0`, this will ignore certificate errors.

### Require actual membership of the configured groups

If you set `$config['auth_ad_require_groupmembership']` to 1, the authenticated user has to be a member of the specific group.
Otherwise all users can authenticate, and will be either level 0 or you may set `$config['auth_ad_global_read']` to 1 and all users will have read only access unless otherwise specified.

#### Old account cleanup
Cleanup of old accounts is done by checking the authlog. You will need to set the number of days when old accounts will be purged AUTOMATICALLY by daily.sh.

> Please ensure that you set the $config['authlog_purge'] value to be greater than $config['active_directory']['users_purge'] otherwise old users won't be removed.

### Sample configuration

```
$config['auth_mechanism'] = "active_directory";
$config['auth_ad_url']                     = "ldaps://<your-domain.controll.er>";  // you can add multiple servers, separated by a space
$config['auth_ad_domain']                  = "<your-domain.com>";
$config['auth_ad_base_dn']                 = "<dc=your-domain,dc=com>";  // groups and users must be under this dn
$config['auth_ad_check_certificates']      = true;  // require a valid ssl certificate
$config['auth_ad_binduser']                = 'examplebinduser';
$config['auth_ad_bindpassword']            = 'examplepassword';
$config['auth_ad_timeout']                 = 5; // time to wait before giving up (or trying the next server)
$config['auth_ad_debug']                   = false; // enable for verbose debug messages
$config['active_directory']['users_purge'] = 30;    // purge users who haven't logged in for 30 days.
$config['auth_ad_require_groupmembership'] = false; // require users to be members of a group listed below
$config['auth_ad_groups']['<ad-admingroup>']['level'] = 10;
$config['auth_ad_groups']['<ad-usergroup>']['level']  = 7;
```

Replace `<ad-admingroup>` with your Active Directory admin-user group and `<ad-usergroup>` with your standard user group.
It is __highly suggested__ to create a bind user, otherwise "remember me", alerting users, and the API will not work.

### Active Directory redundancy

You can set two Active Directory servers by editing the `$config['auth_ad_url']` like this example:

```
$config['auth_ad_url'] = "ldaps://dc1.example.com ldaps://dc2.example.com";
```

### Active Directory LDAP filters

You can add an LDAP filter to be ANDed with the builtin user filter (`(sAMAccountName=$username)`).

The defaults are:

```
$config['auth_ad_user_filter'] = "(objectclass=user)";
$config['auth_ad_group_filter'] = "(objectclass=group)";
```

This yields `(&(objectclass=user)(sAMAccountName=$username))` for the user filter and `(&(objectclass=group)(sAMAccountName=$group))` for the group filter.


# LDAP Authentication

Config option: `ldap`

Install __php_ldap__  or __php7.0-ldap__, making sure to install the same version as PHP.

```php
$config['auth_ldap_version'] = 3; # v2 or v3
$config['auth_ldap_server'] = "ldap.example.com";
$config['auth_ldap_port']   = 389;
$config['auth_ldap_prefix'] = "uid=";
$config['auth_ldap_suffix'] = ",ou=People,dc=example,dc=com";
$config['auth_ldap_group']  = "cn=groupname,ou=groups,dc=example,dc=com";
$config['auth_ldap_groupbase'] = "ou=group,dc=example,dc=com";
$config['auth_ldap_groups']['admin']['level'] = 10;
$config['auth_ldap_groups']['pfy']['level'] = 7;
$config['auth_ldap_groups']['support']['level'] = 1;
$config['auth_ldap_groupmemberattr'] = "memberUid";
$config['auth_ldap_uid_attribute'] = 'uidnumber';
```

Typically auth_ldap_suffix, auth_ldap_group, auth_ldap_groupbase, auth_ldap_groups are what's required to be configured.

### LDAP server redundancy

You can set two LDAP servers by editing the `$config['auth_ldap_server']` like this example:

```
$config['auth_ldap_server'] = "ldaps://dir1.example.com ldaps://dir2.example.com";
```

An example config setup for use with Jumpcloud LDAP as a service is:

```php
$config['auth_mechanism'] = "ldap";
unset($config['auth_ldap_group']);
unset($config['auth_ldap_groups']);
$config['auth_ldap_groups']['librenms']['level'] = 10;
$config['auth_ldap_version'] = 3;
$config['auth_ldap_server'] = "ldap.jumpcloud.com";
$config['auth_ldap_port'] = 389;
$config['auth_ldap_prefix'] = "uid=";
$config['auth_ldap_suffix'] = ",ou=Users,o={id},dc=jumpcloud,dc=com";
$config['auth_ldap_groupbase'] = "cn=librenms,ou=Users,o={id},dc=jumpcloud,dc=com";
$config['auth_ldap_groupmemberattr'] = "memberUid";
```

Replace {id} with the unique ID provided by Jumpcloud.


# Radius Authentication

Please note that a mysql user is created for each user the logs in successfully. User level 1 is assigned to those accounts so you will then need to assign the relevant permissions unless you set `$config['radius']['userlevel']` to be something other than 1.

```php
$config['radius']['hostname']   = 'localhost';
$config['radius']['port']       = '1812';
$config['radius']['secret']     = 'testing123';
$config['radius']['timeout']    = 3;
$config['radius']['users_purge'] = 14;//Purge users who haven't logged in for 14 days.
$config['radius']['default_level'] = 1;//Set the default user level when automatically creating a user.
```

#### Old account cleanup
Cleanup of old accounts is done by checking the authlog. You will need to set the number of days when old accounts will be purged AUTOMATICALLY by daily.sh.

> Please ensure that you set the $config['authlog_purge'] value to be greater than $config['radius']['users_purge'] otherwise old users won't be removed.


# HTTP Authentication

Config option: `http-auth`

LibreNMS will expect the user to have authenticated via your webservice already. At this stage it will need to assign a
userlevel for that user which is done in one of two ways:

- A user exists in MySQL still where the usernames match up.

- A global guest user (which still needs to be added into MySQL:
```php
$config['http_auth_guest'] = "guest";
```
This will then assign the userlevel for guest to all authenticated users.


## HTTP Authentication / AD Authorization

Config option: `ad-authorization`

This module is a combination of ___http-auth___ and ___active_directory___

LibreNMS will expect the user to have authenticated via your webservice already (e.g. using Kerberos Authentication in Apache) but will use Active Directory lookups to determine and assign the userlevel of a user.
The userlevel will be calculated by using AD group membership information as the ___active_directory___ module does.

The configuration is the same as for the ___active_directory___ module with two extra, optional options: auth_ad_binduser and auth_ad_bindpassword.
These should be set to a AD user with read capabilities in your AD Domain in order to be able to perform searches. 
If these options are omitted, the module will attempt an anonymous bind (which then of course must be allowed by your Active Directory server(s)).

There is also one extra option for controlling user information caching: auth_ldap_cache_ttl.
This option allows to control how long user information (user_exists, userid, userlevel) are cached within the PHP Session.
The default value is 300 seconds.
To disable this caching (highly discourage) set this option to 0.

```php
$config['auth_ad_binduser']     = "ad_binduser";
$config['auth_ad_bindpassword'] = "ad_bindpassword";
$config['auth_ldap_cache_ttl']  = 300;
```


## HTTP Authentication / LDAP Authorization

Config option: `ldap-authorization`

This module is a combination of ___http-auth___ and ___ldap___

LibreNMS will expect the user to have authenticated via your webservice already (e.g. using Kerberos Authentication in Apache) but will use LDAP to determine and assign the userlevel of a user.
The userlevel will be calculated by using LDAP group membership information as the ___ldap___ module does.

The configuration is the same as for the ___ldap___ module with one extra option: auth_ldap_cache_ttl.
This option allows to control how long user information (user_exists, userid, userlevel) are cached within the PHP Session.
The default value is 300 seconds.
To disabled this caching (highly discourage) set this option to 0.

```php
$config['auth_ldap_cache_ttl'] = 300;
```
