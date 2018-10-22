source: Extensions/Syslog.md
# Setting up syslog support

This document will explain how to send syslog data to LibreNMS.
Please also refer to the file Graylog.md for an alternate way of integrating syslog with LibreNMS.

### Syslog server installation

#### syslog-ng

For Debian / Ubuntu:
```ssh
apt-get install syslog-ng
```

For CentOS / RedHat
```ssh
yum install syslog-ng
```

Once syslog-ng is installed, edit the relevant config file (most likely /etc/syslog-ng/syslog-ng.conf) and paste the following:

```bash
@version:3.5
@include "scl.conf"

# syslog-ng configuration file.
#
# This should behave pretty much like the original syslog on RedHat. But
# it could be configured a lot smarter.
#
# See syslog-ng(8) and syslog-ng.conf(5) for more information.
#
# Note: it also sources additional configuration files (*.conf)
#       located in /etc/syslog-ng/conf.d/

options {
        chain_hostnames(off);
        flush_lines(0);
        use_dns(no);
        use_fqdn(no);
        owner("root");
        group("adm");
        perm(0640);
        stats_freq(0);
        bad_hostname("^gconfd$");
};

 
source s_sys {
    system();
    internal();
 
};

source s_net {
        tcp(port(514) flags(syslog-protocol));
        udp(port(514) flags(syslog-protocol));
};
 

########################
# Destinations
########################
destination d_librenms {
        program("/opt/librenms/syslog.php" template ("$HOST||$FACILITY||$PRIORITY||$LEVEL||$TAG||$R_YEAR-$R_MONTH-$R_DAY $R_HOUR:$R_MIN:$R_SEC||$MSG||$PROGRAM\n") template-escape(yes));
};

filter f_kernel     { facility(kern); };
filter f_default    { level(info..emerg) and
                        not (facility(mail)
                        or facility(authpriv)
                        or facility(cron)); };
filter f_auth       { facility(authpriv); };
filter f_mail       { facility(mail); };
filter f_emergency  { level(emerg); };
filter f_news       { facility(uucp) or
                        (facility(news)
                        and level(crit..emerg)); };
filter f_boot   { facility(local7); };
filter f_cron   { facility(cron); };

########################
# Log paths
########################
log {
        source(s_net);
        source(s_sys);
        destination(d_librenms);
};

# Source additional configuration files (.conf extension only)
@include "/etc/syslog-ng/conf.d/*.conf"


# vim:ft=syslog-ng:ai:si:ts=4:sw=4:et:
```

Next start syslog-ng:

```ssh
service syslog-ng restart
```

Add the following to your LibreNMS `config.php` file to enable the Syslog extension:

```ssh
$config['enable_syslog'] = 1;
```

#### rsyslog

If you prefer rsyslog, here are some hints on how to get it working.

Add the following to your rsyslog config somewhere (could be at the top of the file in the step below, could be in `rsyslog.conf` if you are using remote logs for something else on this host)

```ssh
# Listen for syslog messages on UDP:514
$ModLoad imudp
$UDPServerRun 514
```

Create a file called something like `/etc/rsyslog.d/30-librenms.conf` containing:

```ssh
# Feed syslog messages to librenms
$ModLoad omprog

$template librenms,"%fromhost%||%syslogfacility%||%syslogpriority%||%syslogseverity%||%syslogtag%||%$year%-%$month%-%$day% %timegenerated:8:25%||%msg%||%programname%\n"

*.* action(type="omprog" binary="/opt/librenms/syslog.php" template="librenms")

& stop

```

Ancient versions of rsyslog may require different syntax.

This is an example for rsyslog 5 (default on Debian 7):
```bash
# Feed syslog messages to librenms
$ModLoad omprog
$template librenms,"%FROMHOST%||%syslogfacility-text%||%syslogpriority-text%||%syslogseverity%||%syslogtag%||%$YEAR%-%$MONTH%-%$DAY% %timegenerated:8:25%||%msg%||%programname%\n"

$ActionOMProgBinary /opt/librenms/syslog.php
*.* :omprog:;librenms
```

If your rsyslog server is recieving messages relayed by another syslog server, you may try replacing `%fromhost%` with `%hostname%`, since `fromhost` is the host the message was received from, not the host that generated the message.  The `fromhost` property is preferred as it avoids problems caused by devices sending incorrect hostnames in syslog messages.

Add the following to your LibreNMS `config.php` file to enable the Syslog extension:

```ssh
$config['enable_syslog'] = 1;
```
#### Syslog Clean Up 
Can be set inside of  `config.php`
```php
$config['syslog_purge'] = 30;
```
The cleanup is run by daily.sh and any entries over X days old are automatically purged. Values are in days.
See here for more Clean Up Options [Link](https://docs.librenms.org/#Support/Configuration/#cleanup-options)

### Client configuration

Below are sample configurations for a variety of clients. You should understand the config before using it as you may want to make some slight changes.
Further configuration hints may be found in the file Graylog.md.

Replace librenms.ip with IP or hostname of your LibreNMS install.

Replace any variables in <brackets> with the relevant information.

#### syslog
```config
*.*     @librenms.ip
```

#### rsyslog
```config
*.* @librenms.ip:514
```

#### Cisco ASA
```config
logging enable
logging timestamp
logging buffer-size 200000
logging buffered debugging
logging trap notifications
logging host <outside interface name> librenms.ip
```

#### Cisco IOS
```config
logging trap debugging
logging facility local6
logging librenms.ip
```

#### Cisco NXOS
```config
logging server librenms.ip 5 use-vrf default facility local6
```

#### Juniper Junos
```config
set system syslog host librenms.ip authorization any
set system syslog host librenms.ip daemon any
set system syslog host librenms.ip kernel any
set system syslog host librenms.ip user any
set system syslog host librenms.ip change-log any
set system syslog host librenms.ip source-address <management ip>
set system syslog host librenms.ip exclude-hostname
set system syslog time-format
```

#### Allied Telesis Alliedware Plus
```config
log date-format iso // Required so syslog-ng/LibreNMS can correctly interpret the log message formatting.
log host x.x.x.x
log host x.x.x.x level <errors> // Required. A log-level must be specified for syslog messages to send. 
log host x.x.x.x level notices program imish // Useful for seeing all commands executed by users.
log host x.x.x.x level notices program imi // Required for Oxidized Syslog hook log message.  
log host source <eth0>
```


If you have permitted udp and tcp 514 through any firewall then that should be all you need. Logs should start appearing and displayed within the LibreNMS web UI.

### Windows

By Default windows has no native way to send logs to a remote syslog server.

Using this how to you can download Datagram-Syslog Agent to send logs to a remote syslog server (LibreNMS). 

#### Note 
keep in mind you can use any agent or program to send the logs. We are just using this Datagram-Syslog Agent for this example.

[Link to How to](http://techgenix.com/configuring-syslog-agent-windows-server-2012/)

You will need to download and install "Datagram-Syslog Agent" for this how to
[Link to Download](http://download.cnet.com/Datagram-SyslogAgent/3001-2085_4-10370938.html)


### External hooks

Trigger external scripts based on specific syslog patterns being matched with syslog hooks. Add the following to your LibreNMS `config.php` to enable hooks:

```ssh
$config['enable_syslog_hooks'] = 1;
```

The below are some example hooks to call an external script in the event of a configuration change on Cisco ASA, IOS, NX-OS and IOS-XR devices. Add to your `config.php` file to enable.

#### Cisco ASA
```ssh
$config['os']['asa']['syslog_hook'][] = Array('regex' => '/%ASA-(config-)?5-111005/', 'script' => '/opt/librenms/scripts/syslog-notify-oxidized.php');
```

#### Cisco IOS
```ssh
$config['os']['ios']['syslog_hook'][] = Array('regex' => '/%SYS-(SW[0-9]+-)?5-CONFIG_I/', 'script' => '/opt/librenms/scripts/syslog-notify-oxidized.php');
```

#### Cisco NXOS
```ssh
$config['os']['nxos']['syslog_hook'][] = Array('regex' => '/%VSHD-5-VSHD_SYSLOG_CONFIG_I/', 'script' => '/opt/librenms/scripts/syslog-notify-oxidized.php');
```

#### Cisco IOSXR
```ssh
$config['os']['iosxr']['syslog_hook'][] = Array('regex' => '/%GBL-CONFIG-6-DB_COMMIT/', 'script' => '/opt/librenms/scripts/syslog-notify-oxidized.php');
```

#### Juniper Junos
```ssh
$config['os']['junos']['syslog_hook'][] = Array('regex' => '/%UI_COMMIT:/', 'script' => '/opt/librenms/scripts/syslog-notify-oxidized.php');
```

#### Allied Telesis Alliedware Plus
**Note:** At least software version 5.4.8-2.1 is required. ```log host x.x.x.x level notices program imi``` may also be required depending on configuration. This is to ensure the syslog hook log message gets sent to the syslog server. 

```ssh
$config['os']['awplus']['syslog_hook'][] = Array('regex' => '/IMI.+.Startup-config saved on/', 'script' => '/opt/librenms/scripts/syslog-notify-oxidized.php');
```

