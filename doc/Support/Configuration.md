source: Support/Configuration.md
The options shown below also contain the default values.

If you would like to alter any of these then please add your config option to `config.php`.

### Directories

```php
$config['install_dir'] = "/opt/librenms";
```
Set the installation directory (defaults to /opt/librenms), if you clone the GitHub branch to another location ensure you alter this.

```php
$config['temp_dir'] = "/tmp";
```
The temporary directory is where images and other temporary files are created on your filesystem.

```php
$config['log_dir'] = "/opt/librenms/logs";
```
Log files created by LibreNMS will be stored within this directory.

### Database config

These are the configuration options you will need to use to specify to get started.

```php
$config['db_host'] = '127.0.0.1';
$config['db_port'] = 3306;
$config['db_user'] = '';
$config['db_pass'] = '';
$config['db_name'] = '';
```

If you use a unix socket, you can specify it with these options:
```php
$config['db_host']   = NULL;
$config['db_port']   = NULL;
$config['db_socket'] = '/run/mysqld/mysqld.sock';
```

### Programs

A lot of these are self explanatory so no further information may be provided. Any extensions that have dedicated 
documentation page will be linked to rather than having the config provided.

#### RRDTool

> You can configure these options within the WebUI now, please avoid setting these options within config.php

> Settings -> External Settings -> RRDTool Setup

```php
$config['rrdtool'] = "/usr/bin/rrdtool";
```

Please see [1 Minute polling](1-Minute-Polling.md) for information on configuring your install to record data more frequently.

#### fping
```php
$config['fping']            = "/usr/bin/fping";
$config['fping6']           = "fping6";
$config['fping_options']['retries'] = 3;
$config['fping_options']['timeout'] = 500;
$config['fping_options']['count'] = 3;
$config['fping_options']['millisec'] = 200;
```
`fping` configuration options:

* `retries` (`fping` parameter `-r`): Number of times an attempt at pinging a target will be made, not including the first try.
* `timeout` (`fping` parameter `-t`): Amount of time that fping waits for a response to its first request (in milliseconds).
* `count` (`fping` parameter `-c`): Number of request packets to send to each target.
* `millisec` (`fping` parameter `-p`): Time in milliseconds that fping waits between successive packets to an individual target.

You can disable the fping / icmp check that is done for a device to be determined to be up on a global or per device basis.
**We don't advice disabling the fping / icmp check unless you know the impact, at worst if you have a large number of devices down
then it's possible that the poller would no longer complete in 5 minutes due to waiting for snmp to timeout.**

Globally disable fping / icmp check:
```php
$config['icmp_check'] = false;
```

If you would like to do this on a per device basis then you can do so under Device -> Edit -> Misc -> Disable ICMP Test? On

#### SNMP

```php
$config['snmpwalk']         = "/usr/bin/snmpwalk";
$config['snmpget']          = "/usr/bin/snmpget";
$config['snmpbulkwalk']     = "/usr/bin/snmpbulkwalk";
```
SNMP program locations.

```php
$config['whois']            = "/usr/bin/whois";
$config['ping']             = "/bin/ping";
$config['mtr']              = "/usr/bin/mtr";
$config['nmap']             = "/usr/bin/nmap";
$config['nagios_plugins']   = "/usr/lib/nagios/plugins";
$config['ipmitool']         = "/usr/bin/ipmitool";
$config['virsh']            = "/usr/bin/virsh";
$config['dot']              = "/usr/bin/dot";
$config['unflatten']        = "/usr/bin/unflatten";
$config['neato']            = "/usr/bin/neato";
$config['sfdp']             = "/usr/bin/sfdp";
```

### Proxy support

For alerting and the callback functionality, we support the use of a http proxy setting. 
These can be any one of the following:

```php
$config['callback_proxy'] = 'proxy.domain.com';
$config['http_proxy']     = 'proxy.domain.com';
```

We can also make use of one of these environment variables which can be set in `/etc/environment`:

```bash
http_proxy=proxy.domain.com
https_proxy=proxy.domain.com
```

### Memcached

[Memcached](../Extensions/Memcached.md)

### RRDCached

[RRDCached](../Extensions/RRDCached.md)

### WebUI Settings

```php
$config['base_url'] = "http://demo.librenms.org";
```
LibreNMS will attempt to detect the URL you are using but you can override that here.

```php
$config['site_style']       = "light";
```
Currently we have a number of styles which can be set which will alter the navigation bar look. dark, light and mono with light being the default.

```php
$config['webui']['custom_css'][]       = "css/custom/styles.css";
```
You can override a large number of visual elements by creating your own css stylesheet and referencing it here, place any custom css files into 
`html/css/custom` so they will be ignored by auto updates. You can specify as many css files as you like, the order they are within your config 
will be the order they are loaded in the browser.

```php
$config['title_image'] = "images/custom/yourlogo.png";
```
You can override the default logo with yours, place any custom images files into `html/images/custom` so they will be ignored by auto updates.

```php
$config['page_refresh']     = "300";
```
Set how often pages are refreshed in seconds. The default is every 5 minutes. Some pages don't refresh at all by design.

```php
$config['front_page']       = "pages/front/default.php";
$config['front_page_settings']['top']['ports'] = 10;
$config['front_page_settings']['top']['devices'] = 10;
$config['front_page_down_box_limit'] = 10;
$config['vertical_summary'] = 0; // Enable to use vertical summary on front page instead of horizontal
$config['top_ports']        = 1; // This enables the top X ports box
$config['top_devices']      = 1; // This enables the top X devices box
```
A number of home pages are provided within the install and can be found in html/pages/front/. You can change the default by
setting `front_page`. The other options are used to alter the look of those pages that support it (default.php supports these options).

```php
// This option exists in the web UI, edit it under Global Settings -> webui
$config['webui']['default_dashboard_id'] = 0;
```
Allows the specification of a global default dashboard page for any user who
has not set one in their user preferences.  Should be set to dashboard_id of an
existing dashboard that is shared or shared(read).  Otherwise, the system will
automatically create each user an empty dashboard called `Default` on their
first login.

```php
$config['login_message']    = "Unauthorised access or use shall render the user liable to criminal and/or civil prosecution.";
```
This is the default message on the login page displayed to users.

```php
$config['public_status']    = false;
```
If this is set to true then an overview will be shown on the login page of devices and the status.

```php
$config['show_locations']          = 1;  # Enable Locations on menu
$config['show_locations_dropdown'] = 1;  # Enable Locations dropdown on menu
$config['show_services']           = 0;  # Enable Services on menu
$config['int_customers']           = 1;  # Enable Customer Port Parsing
$config['summary_errors']          = 0;  # Show Errored ports in summary boxes on the dashboard
$config['customers_descr']         = 'cust'; // The description to look for in ifDescr. Can be an array as well array('cust','cid');
$config['transit_descr']           = 'transit'; // Add custom transit descriptions (can be an array)
$config['peering_descr']           = 'peering'; // Add custom peering descriptions (can be an array)
$config['core_descr']              = 'core'; // Add custom core descriptions (can be an array)
$config['custom_descr']            = ''; // Add custom interface descriptions (can be an array)
$config['int_transit']             = 1;  # Enable Transit Types
$config['int_peering']             = 1;  # Enable Peering Types
$config['int_core']                = 1;  # Enable Core Port Types
$config['int_l2tp']                = 0;  # Enable L2TP Port Types
```
Enable / disable certain menus from being shown in the WebUI.

You are able to adjust the number and time frames of the quick select time options for graphs and the mini graphs shown per row.

Quick select:
```php
$config['graphs']['mini']['normal'] = array(
    'day' => '24 Hours',
    'week' => 'One Week',
    'month' => 'One Month',
    'year' => 'One Year',
);
$config['graphs']['mini']['widescreen'] = array(
    'sixhour' => '6 Hours',
    'day' => '24 Hours',
    'twoday' => '48 Hours',
    'week' => 'One Week',
    'twoweek' => 'Two Weeks',
    'month' => 'One Month',
    'twomonth' => 'Two Months',
    'year' => 'One Year',
    'twoyear' => 'Two Years',
);
```

Mini graphs:
```php
$config['graphs']['row']['normal'] = array(
    'sixhour' => '6 Hours',
    'day' => '24 Hours',
    'twoday' => '48 Hours',
    'week' => 'One Week',
    'twoweek' => 'Two Weeks',
    'month' => 'One Month',
    'twomonth' => 'Two Months',
    'year' => 'One Year',
    'twoyear' => 'Two Years',
);
```

```php
$config['web_mouseover']      = true;
```
You can disable the mouseover popover for mini graphs by setting this to false.

```php
$config['enable_lazy_load'] = true;
```
You can disable image lazy loading by setting this to false.

```php
$config['show_overview_tab'] = true;
```
Enable or disable the overview tab for a device.

```php
$config['overview_show_sysDescr'] = true;
```
Enable or disable the sysDescr output for a device.

```php
$config['force_ip_to_sysname'] = false;
```
When using IP addresses as a hostname you can instead represent the devices on the WebUI by its SNMP sysName resulting in an easier to read overview of your network. This would apply on networks where you don't have DNS records for most of your devices.

```php
$config['device_traffic_iftype'][] = '/loopback/';
```
Interface types that aren't graphed in the WebUI. The default array contains more items, please see includes/defaults.inc.php for the full list.

```php
$config['enable_clear_discovery'] = 1;
```
Administrators are able to clear the last discovered time of a device which will force a full discovery run within the configured 5 minute cron window.

```php
$config['enable_footer'] = 1;
```
Disable the footer of the WebUI by setting `enable_footer` to 0.

You can enable the old style network map (only available for individual devices with links discovered via xDP) by setting:
```php
$config['gui']['network-map']['style'] = 'old';
```

```php
$config['percentile_value'] = X;
```
Show the `X`th percentile in the graph instead of the default 95th percentile.

### Add host settings
The following setting controls how hosts are added.  If a host is added as an ip address it is checked to ensure the ip is not already present.  If the ip is present the host is not added.
If host is added by hostname this check is not performed.  If the setting is true hostnames are resolved and the check is also performed.  This helps prevents accidental duplicate hosts.
```php
$config['addhost_alwayscheckip']   = false; #true - check for duplicate ips even when adding host by name.
                                            #false- only check when adding host by ip.
```

By default we allow hosts to be added with duplicate sysName's, you can disable this with the following config:

```php
$config['allow_duplicate_sysName'] = false;
```

### Global poller and discovery modules
Generally, it is a better to set these [per OS](../Developing/os/Settings.md#poller-and-discovery-modules) or device.

```php
$config['discovery_modules]['arp-table'] = 1;
$config['poller_modules]['bgp-peers'] = 0;
```

### SNMP Settings

```php
$config['snmp']['timeout'] = 1;            # timeout in seconds
$config['snmp']['retries'] = 5;            # how many times to retry the query
$config['snmp']['transports'] = array('udp', 'udp6', 'tcp', 'tcp6');
$config['snmp']['version'] = "v2c";         # Default version to use
$config['snmp']['port'] = 161;
```
Default SNMP options including retry and timeout settings and also default version and port.

```php
$config['snmp']['community'][0] = "public";
```
The default v1/v2c snmp community to use, you can expand this array with `[1]`, `[2]`, `[3]`, etc.

```php
$config['snmp']['v3'][0]['authlevel'] = "noAuthNoPriv";  # noAuthNoPriv | authNoPriv | authPriv
$config['snmp']['v3'][0]['authname'] = "root";           # User Name (required even for noAuthNoPriv)
$config['snmp']['v3'][0]['authpass'] = "";               # Auth Passphrase
$config['snmp']['v3'][0]['authalgo'] = "MD5";            # MD5 | SHA
$config['snmp']['v3'][0]['cryptopass'] = "";             # Privacy (Encryption) Passphrase
$config['snmp']['v3'][0]['cryptoalgo'] = "AES";          # AES | DES
```
The default v3 snmp details to use, you can expand this array with `[1]`, `[2]`, `[3]`, etc.

### Auto discovery settings

[Auto-Discovery](../Extensions/Auto-Discovery.md)

### Email configuration

> You can configure these options within the WebUI now, please avoid setting these options within config.php

```php
$config['email_backend']              = 'mail';
$config['email_from']                 = NULL;
$config['email_user']                 = $config['project_id'];
$config['email_sendmail_path']        = '/usr/sbin/sendmail';
$config['email_smtp_host']            = 'localhost';
$config['email_smtp_port']            = 25;
$config['email_smtp_timeout']         = 10;
$config['email_smtp_secure']          = NULL;
$config['email_smtp_auth']            = false;
$config['email_smtp_username']        = NULL;
$config['email_smtp_password']        = NULL;
```
What type of mail transport to use for delivering emails. Valid options for `email_backend` are mail, sendmail or smtp.
The varying options after that are to support the different transports.

### Alerting

[Alerting](../Alerting/index.md)

### Billing

[Billing](../Extensions/Billing-Module.md)

### Global module support

```php
$config['enable_bgp']                   = 1; # Enable BGP session collection and display
$config['enable_syslog']                = 0; # Enable Syslog
$config['enable_inventory']             = 1; # Enable Inventory
$config['enable_pseudowires']           = 1; # Enable Pseudowires
$config['enable_vrfs']                  = 1; # Enable VRFs
$config['enable_sla']                   = 0; # Enable Cisco SLA collection and display
```

### Port extensions

[Port-Description-Parser](../Extensions/Port-Description-Parser.md)

```php
$config['enable_ports_etherlike']       = 0;
$config['enable_ports_junoseatmvp']     = 0;
$config['enable_ports_adsl']            = 1;
$config['enable_ports_poe']             = 0;
```
Enable / disable additional port statistics.

### External integration

#### Rancid

```php
$config['rancid_configs'][]             = '/var/lib/rancid/network/configs/';
$config['rancid_ignorecomments']        = 0;
```
Rancid configuration, `rancid_configs` is an array containing all of the locations of your rancid files.
Setting `rancid_ignorecomments` will disable showing lines that start with #

#### Oxidized

[Oxidized](../Extensions/Oxidized.md)

#### CollectD
```php
$config['collectd_dir']                 = '/var/lib/collectd/rrd';
```
Specify the location of the collectd rrd files.

```php
$config['collectd_sock']                 = 'unix:///var/run/collectd.sock';
```
Specify the location of the collectd unix socket. Using a socket allows the collectd graphs to be flushed to disk before being drawn. Be sure that your web server has permissions to write to this socket.

#### Smokeping

[Smokeping](../Extensions/Smokeping.md)

#### NFSen

[NFSen](../Extensions/NFSen.md)

### Location mapping

Exact Matching:
```php
$config['location_map']['Under the Sink'] = "Under The Sink, The Office, London, UK";
```
Regex Matching:
```php
$config['location_map_regex']['/Sink/'] = "Under The Sink, The Office, London, UK";
```
Regex Match Substitution:
```php
$config['location_map_regex_sub']['/Sink/'] = "Under The Sink, The Office, London, UK [lat, long]";
```
If you have an SNMP SysLocation of "Rack10,Rm-314,Sink", Regex Match Substition yields "Rack10,Rm-314,Under The Sink, The Office, London, UK [lat, long]". This allows you to keep the SysLocation string short and keeps Rack/Room/Building information intact after the substitution.

The above are examples, these will rewrite device snmp locations so you don't need to configure full location within snmp.

### Interfaces to be ignored

Examples:

```php
$config['bad_if'][] = "voip-null";
$config['bad_iftype'][] = "voiceEncap";
$config['bad_if_regexp'][] = '/^lo[0-9].*/';    // loopback
```
Numerous defaults exist for this array already (see includes/defaults.inc.php for the full list). You can expand this list
by continuing the array.

`bad_if` is matched against the ifDescr value.

`bad_iftype` is matched against the ifType value.

`bad_if_regexp` is matched against the ifDescr value as a regular expression.

`bad_ifname_regexp` is matched against the ifName value as a regular expression.

`bad_ifalias_regexp` is matched against the ifAlias value as a regular expression.

### Interfaces that shouldn't be ignored

Examples:

```php
$config['good_if'][] = 'FastEthernet';
$config['os']['ios']['good_if'][] = 'FastEthernet';
```

`good_if` is matched against ifDescr value. This can be a bad_if value as well which would stop that port from being ignored. 
I.e If bad_if and good_if both contained FastEthernet then ports with this value in the ifDescr will be valid.

### Interfaces to be rewritten

```php
$config['rewrite_if']['cpu'] = 'Management Interface';
$config['rewrite_if_regexp']['/cpu /'] = 'Management ';
```
Entries defined in `rewrite_if` are being replaced completely.
Entries defined in `rewrite_if_regexp` only replace the match.
Matches are compared case-insensitive.

### Entity sensors to be ignored

Some devices register bogus sensors as they are returned via SNMP but either don't exist or just don't return data.
This allows you to ignore those based on the descr field in the database. You can either ignore globally or on a per 
os basis.

```php
$config['bad_entity_sensor_regex'][] = '/Physical id [0-9]+/';
$config['os']['cisco']['bad_entity_sensor_regex'] = '/Physical id [0-9]+/';
```

### Storage configuration

```php
$config['ignore_mount_removable']  = 1;
$config['ignore_mount_network']    = 1;
$config['ignore_mount_optical']    = 1;

$config['ignore_mount'][] = "/kern";
$config['ignore_mount'][] = "/mnt/cdrom";
$config['ignore_mount'][] = "/proc";
$config['ignore_mount'][] = "/dev";

$config['ignore_mount_string'][] = "packages";
$config['ignore_mount_string'][] = "devfs";
$config['ignore_mount_string'][] = "procfs";
$config['ignore_mount_string'][] = "UMA";
$config['ignore_mount_string'][] = "MALLOC";

$config['ignore_mount_regexp'][] = "/on: \/packages/";
$config['ignore_mount_regexp'][] = "/on: \/dev/";
$config['ignore_mount_regexp'][] = "/on: \/proc/";
$config['ignore_mount_regexp'][] = "/on: \/junos^/";
$config['ignore_mount_regexp'][] = "/on: \/junos\/dev/";
$config['ignore_mount_regexp'][] = "/on: \/jail\/dev/";
$config['ignore_mount_regexp'][] = "/^(dev|proc)fs/";
$config['ignore_mount_regexp'][] = "/^\/dev\/md0/";
$config['ignore_mount_regexp'][] = "/^\/var\/dhcpd\/dev,/";
$config['ignore_mount_regexp'][] = "/UMA/";
```
Mounted storage / mount points to ignore in discovery and polling.

### IRC Bot

[IRC Bot](../Extensions/IRC-Bot.md)

### Authentication

[Authentication](../Extensions/Authentication.md)

### Cleanup options

These options rely on daily.sh running from cron as per the installation instructions.

```php
$config['syslog_purge']                                   = 30;
$config['eventlog_purge']                                 = 30;
$config['authlog_purge']                                  = 30;
$config['perf_times_purge']                               = 30;
$config['device_perf_purge']                              = 7;
$config['rrd_purge']                                      = 90;// Not set by default
```
These options will ensure data within LibreNMS over X days old is automatically purged. You can alter these individually,
values are in days.

> NOTE: Please be aware that `$config['rrd_purge']` is _NOT_ set by default. This option will remove any old data within 
the rrd directory automatically - only enable this if you are comfortable with that happening.

### Syslog options

[Syslog](../Extensions/Syslog.md)

### Virtualization

```php
$config['enable_libvirt'] = 1;
$config['libvirt_protocols']    = array("qemu+ssh","xen+ssh");
$config['libvirt_username'] = 'root';
```
Enable this to switch on support for libvirt along with `libvirt_protocols`
to indicate how you connect to libvirt.  You also need to:

 1. Generate a non-password-protected ssh key for use by LibreNMS, as the
    user which runs polling & discovery (usually `librenms`).
 2. On each VM host you wish to monitor:
   - Configure public key authentication from your LibreNMS server/poller by
     adding the librenms public key to `~root/.ssh/authorized_keys`.
   - (xen+ssh only) Enable libvirtd to gather data from xend by setting
     `(xend-unix-server yes)` in `/etc/xen/xend-config.sxp` and
     restarting xend and libvirtd.

To test your setup, run `virsh -c qemu+ssh://vmhost/system list` or
`virsh -c xen+ssh://vmhost list` as your librenms polling user.

### BGP Support

```php
$config['astext']['65332'] = "Cymru FullBogon Feed";
```
You can use this array to rewrite the description of ASes that you have discovered.

### Auto updates

[Updating](../General/Updating.md)

### IPMI
Setup the types of IPMI protocols to test a host for and in what order. Don't forget to install ipmitool on the monitoring host.

```php
$config['ipmi']['type'] = array();
$config['ipmi']['type'][] = "lanplus";
$config['ipmi']['type'][] = "lan";
$config['ipmi']['type'][] = "imb";
$config['ipmi']['type'][] = "open";
```

### Distributed poller settings

[Distributed Poller](../Extensions/Distributed-Poller.md)

## API Settings

### CORS Support

https://developer.mozilla.org/en-US/docs/Web/HTTP/Access_control_CORS

CORS support for the API is disabled by default. Below you will find the standard options,
all of which you can configure.
 
```php
$config['api']['cors']['enabled'] = false;
$config['api']['cors']['origin'] = '*';
$config['api']['cors']['maxage'] = '86400';
$config['api']['cors']['allowmethods'] = array('POST', 'GET', 'PUT', 'DELETE', 'PATCH');
$config['api']['cors']['allowheaders'] = array('Origin', 'X-Requested-With', 'Content-Type', 'Accept', 'X-Auth-Token');
```
