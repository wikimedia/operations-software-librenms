source: Extensions/Applications.md
## Introduction

You can use Application support to graph performance statistics of many applications.

Different applications support a variety of ways to collect data: 1) by direct connection to the application, 2) snmpd extend, or 3) [the agent](Agent-Setup.md). The monitoring of applications could be added before or after the hosts have been added to LibreNMS.

If multiple methods of collection are listed you only need to enable one.

### SNMP Extend

When using the snmp extend method, the application discovery module will pick up which applications you have set up for monitoring automatically, even if the device is already in LibreNMS. The application discovery module is enabled by default for most \*nix operating systems, but in some cases you will need to manually enable the application discovery module. 

### Enable the application discovery module

1. Edit the device for which you want to add this support
2. Click on the *Modules* tab and enable the `applications` module.
3. This will be automatically saved, and you should get a green confirmation pop-up message.

![Enable-application-module](/img/Enable_application_module.png)

After you have enabled the application module, it would be wise to then also enable which applications you want to monitor, in the rare case where LibreNMS does not automatically detect it.

**Note**: Only do this if an application was not auto-discovered by LibreNMS during discovery and polling.

### Enable the application(s) to be discovered

1. Go to the device you have just enabled the application module for.
2. Click on the *Applications* tab and select the applications you want to monitor.
3. This will also be automatically saved, and you should get a green confirmation pop-up message.

![Enable-applications](/img/Enable_applications.png)

### Agent

The unix-agent does not have a discovery module, only a poller module. That poller module is always disabled by default. It needs to be manually enabled if using the agent. Some applications will be automatically enabled by the unix-agent poller module. It is better to ensure that your application is enabled for monitoring. You can check by following the steps under the `SNMP Extend` heading.

1. [Apache](#apache) - SNMP extend, Agent
1. [Asterisk](#asterisk) - SNMP extend
1. [BIND9/named](#bind9-aka-named) - SNMP extend, Agent
1. [C.H.I.P.](#chip) - SNMP extend
1. [DHCP Stats](#dhcp-stats) - SNMP extend
1. [Entropy](#entropy) - SNMP extend
1. [EXIM Stats](#exim-stats) - SNMP extend
1. [Fail2ban](#fail2ban) - SNMP extend
1. [FreeBSD NFS Client](#freebsd-nfs-client) - SNMP extend
1. [FreeBSD NFS Server](#freebsd-nfs-server) - SNMP extend
1. [FreeRADIUS](#freeradius) - SNMP extend, Agent
1. [Freeswitch](#freeswitch) - SNMP extend, Agent
1. [GPSD](#gpsd) - Agent
1. [Mailscanner](#mailscanner) - SNMP extend
1. [Memcached](#memcached) - SNMP extend
1. [Munin](#munin) - Agent
1. [MySQL](#mysql) - SNMP extend, Agent
1. [NGINX](#nginx) - SNMP extend, Agent
1. [NFS Server](#nfs-server) - SNMP extend
1. [NTP Client](#ntp-client) - SNMP extend
1. [NTP Server/NTPD](#ntp-server-aka-ntpd) - SNMP extend
1. [Nvidia GPU](#nvidia-gpu) - SNMP extend
1. [Open Grid Scheduler](#opengridscheduler) - SNMP extend
1. [OS Updates](#os-updates) - SNMP extend
1. [PHP-FPM](#php-fpm) - SNMP extend
1. [Pi-hole](#pi-hole) - SNMP extend
1. [Postfix](#postfix) - SNMP extend
1. [Postgres](#postgres) - SNMP extend
1. [PowerDNS](#powerdns) - Agent
1. [PowerDNS Recursor](#powerdns-recursor) - Direct, SNMP extend, Agent
1. [PowerDNS dnsdist](#powerdns-dnsdist) - SNMP extend
1. [Proxmox](#proxmox) - SNMP extend
1. [Raspberry PI](#raspberry-pi) - SNMP extend
1. [SDFS info](#sdfs-info) - SNMP extend
1. [SMART](#smart) - SNMP extend
1. [Squid](#squid) - SNMP proxy
1. [TinyDNS/djbdns](#tinydns-aka-djbdns) - Agent
1. [Unbound](#unbound) - SNMP extend, Agent
1. [UPS-nut](#ups-nut) - SNMP extend
1. [UPS-apcups](#ups-apcups) - SNMP extend
1. [ZFS](#zfs) - SNMP extend

### Apache
Either use SNMP extend or use the agent.

Note that you need to install and configure the Apache [mod_status](https://httpd.apache.org/docs/2.4/en/mod/mod_status.html) module before trying the script.

##### SNMP Extend
1. Download the script onto the desired host (the host must be added to LibreNMS devices)
```
wget https://raw.githubusercontent.com/librenms/librenms-agent/master/snmp/apache-stats.py -O /etc/snmp/apache-stats.py
```

2. Make the script executable (chmod +x /etc/snmp/apache-stats.py)

3. Verify it is working by running /etc/snmp/apache-stats.py
In some cases urlgrabber and pycurl needs to be installed, in Debian this can be achieved by: 
```
apt-get install python-urlgrabber python-pycurl
``` 
Make sure to remove /tmp/apache-snmp afterwards.

4. Edit your snmpd.conf file (usually /etc/snmp/snmpd.conf) and add:
```
extend apache /etc/snmp/apache-stats.py
```

5. Restart snmpd on your host

6. Test by running
```
snmpwalk <various options depending on your setup> localhost NET-SNMP-EXTEND-MIB::nsExtendOutput2Table
```

##### Agent
[Install the agent](Agent-Setup.md) on this device if it isn't already and copy the `apache` script to `/usr/lib/check_mk_agent/local/`

1. Verify it is working by running /usr/lib/check_mk_agent/local/apache
(If you get error like "Can't locate LWP/Simple.pm". libwww-perl needs to be installed: apt-get install libwww-perl)
2. On the device page in Librenms, edit your host and check the `Apache` under the Applications tab.

### Asterisk
A small shell script that reports various Asterisk call status.

##### SNMP Extend
1. Copy the [asterisk script](https://github.com/librenms/librenms-agent/blob/master/snmp/asterisk) to `/etc/snmp/` on your asterisk server.

2. Run `chmod +x /etc/snmp/asterisk`

3. Configure `ASCLI` in the script.

4. Verify it is working by running `/etc/snmp/asterisk`

5. Edit your snmpd.conf file (usually `/etc/snmp/snmpd.conf`) and add:
```
extend asterisk /etc/snmp/asterisk
```

6. Restart snmpd on your host

The application should be auto-discovered as described at the top of the page. If it is not, please follow the steps set out under `SNMP Extend` heading top of page.

### BIND9 aka named

1: Create stats file with appropriate permissions:
```shell
~$ touch /var/run/named/stats
~$ chown bind:bind /var/run/named/stats
```
Change `user:group` to the user and group that's running bind/named.

2: Bind/named configuration:
```text
options {
	...
	statistics-file "/var/run/named/stats";
	zone-statistics yes;
	...
};
```

3: Restart your bind9/named after changing the configuration.

4: Verify that everything works by executing `rndc stats && cat /var/run/named/stats`. In case you get a `Permission Denied` error, make sure you changed the ownership correctly.

5: Also be aware that this file is appended to each time `rndc stats` is called. Given this it is suggested you setup file rotation for it. Alternatively you can also set zero_stats to 1 in the config.

6: The script for this also requires the Perl module `File::ReadBackwards`. 
```
FreeBSD       => p5-File-ReadBackwards
CentOS/RedHat => perl-File-ReadBackwards
Debian/Ubuntu => libfile-readbackwards-perl
```
If it is not available, it can be installed by `cpan -i File::ReadBackwards`.

7: You may possibly need to configure the agent/extend script as well.

The config file's path defaults to the same path as the script, but with .config appended. So if the script is located at `/etc/snmp/bind`, the config file will be `/etc/snmp/bind.config`. Alternatively you can also specify a config via `-c $file`.

Anything starting with a # is comment. The format for variables are $variable=$value. Empty lines are ignored. Spaces and tabs at either the start or end of a line are ignored.

Content of an example /etc/snmp/bind.config . Please edit with your own settings.
```
rndc = The path to rndc. Default: /usr/bin/env rndc
call_rndc = A 0/1 boolean on whether or not to call rndc stats. Suggest to set to 0 if using netdata. Default: 1
stats_file = The path to the named stats file. Default: /var/run/named/stats
agent = A 0/1 boolean for if this is being used as a LibreNMS agent or not. Default: 0
zero_stats = A 0/1 boolean for if the stats file should be zeroed first. Default: 0 (1 if guessed)
```

If you want to guess at the configuration, call the script with `-g` and it will print out what it thinks
it should be.

##### SNMP Extend

1: Copy the bind shell script, to the desired host.
```
wget https://github.com/librenms/librenms-agent/raw/master/snmp/bind -O /etc/snmp/bind
```

2: Make the script executable 
```
chmod +x /etc/snmp/bind
```

3: Edit your snmpd.conf file and add:
```
extend bind /etc/snmp/bind
```

4: Restart snmpd on the host in question.

The application should be auto-discovered as described at the top of the page. If it is not, please follow the steps set out under `SNMP Extend` heading top of page.

##### Agent

1: [Install the agent](Agent-Setup.md) on this device if it isn't already and copy the script to `/usr/lib/check_mk_agent/local/bind` via `wget https://raw.githubusercontent.com/librenms/librenms-agent/master/snmp/bind -O /usr/lib/check_mk_agent/local/bind`

2: Run `chmod +x /usr/lib/check_mk_agent/local/bind`

3: Set the variable 'agent' to '1' in the config.

### C.H.I.P

C.H.I.P. is a $9 R8 based tiny computer ideal for small projects.  
Further details: https://getchip.com/pages/chip

#### SNMP Extend
1. Copy the shell script to the desired host.
```
wget https://raw.githubusercontent.com/librenms/librenms-agent/master/snmp/chip.sh -O /etc/snmp/power-stat.sh
```

2. Run `chmod +x /etc/snmp/power-stat.sh`

3. Edit your snmpd.conf file (usually /etc/snmp/snmpd.conf) and add:
```
extend power-stat /etc/snmp/power-stat.sh
```
4. Restart snmpd on your host

The application should be auto-discovered as described at the top of the page. If it is not, please follow the steps set out under `SNMP Extend` heading top of page.

### DHCP Stats
A small shell script that reports current DHCP leases stats.

##### SNMP Extend
1. Copy the shell script to the desired host.
```
wget https://github.com/librenms/librenms-agent/raw/master/snmp/dhcp-status.sh -O /etc/snmp/dhcp-status.sh
```

2. Run `chmod +x /etc/snmp/dhcp-status.sh`

3. Edit your snmpd.conf file (usually /etc/snmp/snmpd.conf) and add:
```
extend dhcpstats /etc/snmp/dhcp-status.sh
```

4. Restart snmpd on your host

The application should be auto-discovered as described at the top of the page. If it is not, please follow the steps set out under `SNMP Extend` heading top of page.


### Entropy
A small shell script that checks your system's available random entropy.

##### SNMP Extend
1. Download the script onto the desired host.
```
wget https://raw.githubusercontent.com/librenms/librenms-agent/master/snmp/entropy.sh -O /etc/snmp/entropy.sh
```

2. Run `chmod +x /etc/snmp/entropy.sh`

3. Edit your snmpd.conf file (usually /etc/snmp/snmpd.conf) and add:
```
extend entropy /etc/snmp/entropy.sh
```

4. Restart snmpd on your host

The application should be auto-discovered as described at the top of the page. If it is not, please follow the steps set out under `SNMP Extend` heading top of page.


### EXIM Stats
SNMP extend script to get your exim stats data into your host.

##### SNMP Extend
1. Download the script onto the desired host.
```
wget https://raw.githubusercontent.com/librenms/librenms-agent/master/snmp/exim-stats.sh -O /etc/snmp/exim-stats.sh
```
2. Run `chmod +x /etc/snmp/exim-stats.sh`

3. Edit your snmpd.conf file (usually `/etc/snmp/snmpd.conf`) and add:
```
extend exim-stats /etc/snmp/exim-stats.sh
```

4. If you are using sudo edit your sudo users (usually `visudo`) and add at the bottom:
```
snmp ALL=(ALL) NOPASSWD: /etc/snmp/exim-stats.sh, /usr/bin/exim*
```

5. Restart snmpd on your host

The application should be auto-discovered as described at the top of the page. If it is not, please follow the steps set out under `SNMP Extend` heading top of page.


### Fail2ban
#### SNMP Extend
1: Copy the shell script, fail2ban, to the desired host. 
```
wget https://github.com/librenms/librenms-agent/raw/master/snmp/fail2ban -O /etc/snmp/fail2ban
```

2: Run `chmod +x /etc/snmp/fail2ban`

3: Edit your snmpd.conf file (usually /etc/snmp/snmpd.conf) and add:
```
extend fail2ban /etc/snmp/fail2ban
```

If you want to use the cache, it is as below, by using the -c switch.
```
extend fail2ban /etc/snmp/fail2ban -c
```

If you want to use the cache and update it if needed, this can by using the -c and -U switches.
```
extend fail2ban /etc/snmp/fail2ban -c -U
```

If you need to specify a custom location for the fail2ban-client, that can be done via the -f switch.

If not specified, "/usr/bin/env fail2ban-client" is used.

```
extend fail2ban /etc/snmp/fail2ban -f /foo/bin/fail2ban-client
```

5: Restart snmpd on your host

6: If you wish to use caching, add the following to /etc/crontab and restart cron. 
```
*/3    *    *    *    *    root    /etc/snmp/fail2ban -u 
```

7: Restart or reload cron on your system.

If you have more than a few jails configured, you may need to use caching as each jail needs to be polled and fail2ban-client can't do so in a timely manner for than a few. This can result in failure of other SNMP information being polled.

For additional details of the switches, please see the POD in the script it self at the top.

### FreeBSD NFS Client
#### SNMP Extend
1: Copy the shell script, fbsdnfsserver, to the desired host. `wget https://github.com/librenms/librenms-agent/raw/master/snmp/fbsdnfsclient -O /etc/snmp/fbsdnfsclient`

2: Run `chmod +x /etc/snmp/fbsdnfsclient`

3: Edit your snmpd.conf file and add:
```
extend fbsdnfsclient /etc/snmp/fbsdnfsclient
```

4: Restart snmpd on your host

The application should be auto-discovered as described at the top of the page. If it is not, please follow the steps set out under `SNMP Extend` heading top of page.

### FreeBSD NFS Server
#### SNMP Extend
1: Copy the shell script, fbsdnfsserver, to the desired host. `wget https://github.com/librenms/librenms-agent/raw/master/snmp/fbsdnfsserver -O /etc/snmp/fbsdnfsserver`

2: Run `chmod +x /etc/snmp/fbsdnfsserver`

3: Edit your snmpd.conf file and add:
```
extend fbsdnfsserver /etc/snmp/fbsdnfsserver
```

4: Restart snmpd on your host

The application should be auto-discovered as described at the top of the page. If it is not, please follow the steps set out under `SNMP Extend` heading top of page.

### FreeRADIUS
The FreeRADIUS application extension requires that status_server be enabled in your FreeRADIUS config.  For more information see: https://wiki.freeradius.org/config/Status

You should note that status requests increment the FreeRADIUS request stats.  So LibreNMS polls will ultimately be reflected in your stats/charts.

1: Go to your FreeRADIUS configuration directory (usually /etc/raddb or /etc/freeradius).

2: `cd sites-enabled`

3: `ln -s ../sites-available/status status`

4: Restart FreeRADIUS.

5: You should be able to test with the radclient as follows...
```
echo "Message-Authenticator = 0x00, FreeRADIUS-Statistics-Type = 31, Response-Packet-Type = Access-Accept" | \
radclient -x localhost:18121 status adminsecret
```
Note that adminsecret is the default secret key in status_server.  Change if you've modified this.

##### SNMP Extend

1: Copy the freeradius shell script, to the desired host.
```
wget https://raw.githubusercontent.com/librenms/librenms-agent/master/snmp/freeradius.sh -O /etc/snmp/freeradius.sh
```

2: Run `chmod +x /etc/snmp/freeradius.sh`

3: If you've made any changes to the FreeRADIUS status_server config (secret key, port, etc.) edit freeradius.sh and adjust the config variable accordingly.

4: Edit your snmpd.conf file and add:
```
extend freeradius /etc/snmp/freeradius.sh
```

5: Restart snmpd on the host in question.

The application should be auto-discovered as described at the top of the page. If it is not, please follow the steps set out under `SNMP Extend` heading top of page.

##### Agent

1: [Install the agent](Agent-Setup.md) on this device if it isn't already and copy the script to `/usr/lib/check_mk_agent/local/freeradius.sh` via `wget https://raw.githubusercontent.com/librenms/librenms-agent/master/snmp/freeradius.sh -O /usr/lib/check_mk_agent/local/freeradius.sh`

2: Run `chmod +x /usr/lib/check_mk_agent/local/freeradius.sh`

3: If you've made any changes to the FreeRADIUS status_server config (secret key, port, etc.) edit freeradius.sh and adjust the config variable accordingly.

4: Edit the freeradius.sh script and set the variable 'AGENT' to '1' in the config.


### Freeswitch
A small shell script that reports various Freeswitch call status.

##### Agent
1. [Install the agent](Agent-Setup.md) on your Freeswitch server if it isn't already

2. Copy the [freeswitch script](https://github.com/librenms/librenms-agent/blob/master/agent-local/freeswitch) to `/usr/lib/check_mk_agent/local/`

3. Configure `FSCLI` in the script. You may also have to create an `/etc/fs_cli.conf` file if your `fs_cli` command requires authentication.

4. Verify it is working by running `/usr/lib/check_mk_agent/local/freeswitch`

##### SNMP Extend
1. Copy the [freeswitch script](https://github.com/librenms/librenms-agent/blob/master/agent-local/freeswitch) to `/etc/snmp/` on your Freeswitch server.

2. Run `chmod +x /etc/snmp/freeswitch`

3. Configure `FSCLI` in the script. You may also have to create an `/etc/fs_cli.conf` file if your `fs_cli` command requires authentication.

4. Verify it is working by running `/etc/snmp/freeswitch`

5. Edit your snmpd.conf file (usually `/etc/snmp/snmpd.conf`) and add:
```
extend freeswitch /etc/snmp/freeswitch
```

6. Restart snmpd on your host

The application should be auto-discovered as described at the top of the page. If it is not, please follow the steps set out under `SNMP Extend` heading top of page.

### GPSD
A small shell script that reports GPSD status.

##### Agent
[Install the agent](Agent-Setup.md) on this device if it isn't already and copy the `gpsd` script to `/usr/lib/check_mk_agent/local/`

You may need to configure `$server` or `$port`.

Verify it is working by running `/usr/lib/check_mk_agent/local/gpsd`


### Mailscanner
##### SNMP Extend
1. Download the script onto the desired host.
```
wget https://raw.githubusercontent.com/librenms/librenms-agent/master/snmp/mailscanner.php -O /etc/snmp/mailscanner.php
```

2. Run `chmod +x /etc/snmp/mailscanner.php`

3. Edit your snmpd.conf file (usually /etc/snmp/snmpd.conf) and add:
```
extend mailscanner /etc/snmp/mailscanner.php
```

4. Restart snmpd on your host

The application should be auto-discovered as described at the top of the page. If it is not, please follow the steps set out under `SNMP Extend` heading top of page.

### Memcached
##### SNMP Extend
1. Copy the [memcached script](https://github.com/librenms/librenms-agent/blob/master/agent-local/memcached) to `/etc/snmp/` on your remote server.
```
wget https://raw.githubusercontent.com/librenms/librenms-agent/master/agent-local/memcached -O /etc/snmp/memcached
```

2. Make the script executable: `chmod +x /etc/snmp/memcached`

3. Edit your snmpd.conf file (usually `/etc/snmp/snmpd.conf`) and add:
```
extend memcached /etc/snmp/memcached
```

4. Restart snmpd on your host

The application should be auto-discovered as described at the top of the page. If it is not, please follow the steps set out under `SNMP Extend` heading top of page.

### Munin
#### Agent
1. Install the script to your agent: `wget https://raw.githubusercontent.com/librenms/librenms-agent/master/agent-local/munin -O /usr/lib/check_mk_agent/local/munin`
2. Make the script executable (`chmod +x /usr/lib/check_mk_agent/local/munin`)
3. Create the munin scripts dir: `mkdir -p /usr/share/munin/munin-scripts`
4. Install your munin scripts into the above directory.

To create your own custom munin scripts, please see this example:

```
#!/bin/bash
if [ "$1" = "config" ]; then
    echo 'graph_title Some title'
    echo 'graph_args --base 1000 -l 0' #not required
    echo 'graph_vlabel Some label'
    echo 'graph_scale no' #not required, can be yes/no
    echo 'graph_category system' #Choose something meaningful, can be anything
    echo 'graph_info This graph shows something awesome.' #Short desc
    echo 'foobar.label Label for your unit' # Repeat these two lines as much as you like
    echo 'foobar.info Desc for your unit.'
    exit 0
fi
echo -n "foobar.value " $(date +%s) #Populate a value, here unix-timestamp
```


### MySQL
#### Agent
[Install the agent](Agent-Setup.md) on this device if it isn't already and copy the `mysql` script to `/usr/lib/check_mk_agent/local/`

The MySQL script requires PHP-CLI and the PHP MySQL extension, so please verify those are installed.

CentOS (May vary based on PHP version)
```
yum install php-cli php-mysql
```

Debian (May vary based on PHP version)
```
apt-get install php5-cli php5-mysql
```

Unlike most other scripts, the MySQL script requires a configuration file `mysql.cnf` in the same directory as the extend or agent script with following content:

```php
<?php
$mysql_user = 'root';
$mysql_pass = 'toor';
$mysql_host = 'localhost';
$mysql_port = 3306;
```

Verify it is working by running `/usr/lib/check_mk_agent/local/mysql`

#### SNMP extend
1: Copy the mysql script to the desired host. `wget https://github.com/librenms/librenms-agent/raw/master/snmp/mysql -O /etc/snmp/mysql `

2: Run `chmod +x /etc/snmp/mysql`

3: Unlike most other scripts, the MySQL script requires a configuration file `mysql.cnf` in `/etc/snmp/` with following content:
```php
<?php
$mysql_user = 'root';
$mysql_pass = 'toor';
$mysql_host = 'localhost';
$mysql_port = 3306;
```

4: Edit your snmpd.conf file and add:
```
extend mysql /etc/snmp/mysql
```

5: Restart snmpd.

6: Install the PHP CLI language and your MySQL module of choice for PHP.

The application should be auto-discovered as described at the top of the page. If it is not, please follow the steps set out under `SNMP Extend` heading top of page.

### NGINX
NGINX is a free, open-source, high-performance HTTP server: https://www.nginx.org/

It's required to have the following directive in your nginx configuration responsible for the localhost server:

```text
location /nginx-status {
    stub_status on;
    access_log   off;
    allow 127.0.0.1;
    deny all;
}
```

##### SNMP Extend
1. Download the script onto the desired host.
```
wget https://raw.githubusercontent.com/librenms/librenms-agent/master/snmp/nginx-stats -O /etc/snmp/nginx-stats
```

2. Run `chmod +x /etc/snmp/nginx-stats`

3. Edit your snmpd.conf file (usually /etc/snmp/snmpd.conf) and add:
```
extend nginx /etc/snmp/nginx-stats
```
4. Restart snmpd on your host

The application should be auto-discovered as described at the top of the page. If it is not, please follow the steps set out under `SNMP Extend` heading top of page.

##### Agent
[Install the agent](Agent-Setup.md) on this device if it isn't already and copy the `nginx` script to `/usr/lib/check_mk_agent/local/`

### NFS Server
Export the NFS stats from as server.

##### SNMP Extend
1. Edit your snmpd.conf file (usually /etc/snmp/snmpd.conf) and add :
```
extend nfs-server /bin/cat /proc/net/rpc/nfsd
```
note : find out where cat is located using : `which cat`

2. reload snmpd service to activate the configuration

### NTP Client
A shell script that gets stats from ntp client.

##### SNMP Extend
1. Download the script onto the desired host.
```
wget https://raw.githubusercontent.com/librenms/librenms-agent/master/snmp/ntp-client.sh -O /etc/snmp/ntp-client.sh
```

2. Run `chmod +x /etc/snmp/ntp-client.sh`

3. Edit your snmpd.conf file (usually /etc/snmp/snmpd.conf) and add:
```
extend ntp-client /etc/snmp/ntp-client.sh
```

4. Restart snmpd on your host

The application should be auto-discovered as described at the top of the page. If it is not, please follow the steps set out under `SNMP Extend` heading top of page.

### NTP Server aka NTPD
A shell script that gets stats from ntp server (ntpd).

##### SNMP Extend
1. Download the script onto the desired host.
```
wget https://raw.githubusercontent.com/librenms/librenms-agent/master/snmp/ntp-server.sh -O /etc/snmp/ntp-server.sh
```

2. Run `chmod +x /etc/snmp/ntp-server.sh`

3. Edit your snmpd.conf file (usually /etc/snmp/snmpd.conf) and add:
```
extend ntp-server /etc/snmp/ntp-server.sh
```
4. Restart snmpd on your host

The application should be auto-discovered as described at the top of the page. If it is not, please follow the steps set out under `SNMP Extend` heading top of page.

### Nvidia GPU
##### SNMP Extend
1: Copy the shell script, nvidia, to the desired host. `wget https://github.com/librenms/librenms-agent/raw/master/snmp/nvidia -O /etc/snmp/nvidia`

2: Run `chmod +x /etc/snmp/nvidia`

3: Edit your snmpd.conf file and add:
```
extend nvidia /etc/snmp/nvidia
```

5: Restart snmpd on your host.

6: Verify you have nvidia-smi installed, which it generally should be if you have the driver from Nvida installed.

The GPU numbering on the graphs will correspond to how the nvidia-smi sees them as being.

For questions about what the various values are/mean, please see the nvidia-smi man file under the section covering dmon.

### Open Grid Scheduler
Shell script to track the OGS/GE jobs running on clusters.

#### SNMP Extend
1. Download the script onto the desired host.
```
wget https://raw.githubusercontent.com/librenms/librenms-agent/master/agent-local/rocks.sh -O /etc/snmp/rocks.sh
```

2. Run `chmod +x /etc/snmp/rocks.sh`

3. Edit your snmpd.conf file (usually /etc/snmp/snmpd.conf) and add:
```
extend ogs /etc/snmp/rocks.sh
```
4. Restart snmpd.

The application should be auto-discovered as described at the top of the page. If it is not, please follow the steps set out under `SNMP Extend` heading top of page.

### OS Updates
A small shell script that checks your system package manager for any available updates. Supports apt-get/pacman/yum/zypper package managers).

For pacman users automatically refreshing the database, it is recommended you use an alternative database location `--dbpath=/var/lib/pacman/checkupdate`

##### SNMP Extend
1. Download the script onto the desired host.
```
wget https://raw.githubusercontent.com/librenms/librenms-agent/master/snmp/os-updates.sh -O /etc/snmp/os-updates.sh
```

2. Run `chmod +x /etc/snmp/os-updates.sh`

3. Edit your snmpd.conf file (usually /etc/snmp/snmpd.conf) and add:
```
extend osupdate /etc/snmp/os-updates.sh
```

4. Restart snmpd on your host

_Note_: apt-get depends on an updated package index. There are several ways to have your system run `apt-get update` automatically. The easiest is to create `/etc/apt/apt.conf.d/10periodic` and pasting the following in it: `APT::Periodic::Update-Package-Lists "1";`.
If you have apticron, cron-apt or apt-listchanges installed and configured, chances are that packages are already updated periodically.

The application should be auto-discovered as described at the top of the page. If it is not, please follow the steps set out under `SNMP Extend` heading top of page.

### PHP-FPM
#### SNMP Extend
1. Copy the shell script, phpfpm-sp, to the desired host. `wget https://github.com/librenms/librenms-agent/raw/master/snmp/phpfpm-sp -O /etc/snmp/phpfpm-sp`

2. Run `chmod +x /etc/snmp/phpfpm-sp`

3. Edit your snmpd.conf file (usually /etc/snmp/snmpd.conf) and add:
```
extend phpfpmsp /etc/snmp/phpfpm-sp
```
5. Edit /etc/snmp/phpfpm-sp to include the status URL for the PHP-FPM pool you are monitoring.

6. Restart snmpd on your host

It is worth noting that this only monitors a single pool. If you want to monitor multiple pools, this won't do it.

The application should be auto-discovered as described at the top of the page. If it is not, please follow the steps set out under `SNMP Extend` heading top of page.

### Pi-hole
#### SNMP Extend

1: Copy the shell script, pi-hole, to the desired host. `wget https://github.com/librenms/librenms-agent/raw/master/snmp/pi-hole -O /etc/snmp/pi-hole`

2: Run `chmod +x /etc/snmp/pi-hole`

3: Edit your snmpd.conf file and add:
```
extend pi-hole /etc/snmp/pi-hole
```

4: To get all data you must get your API auth token from Pi-hole server and change the API_AUTH_KEY entry inside the snmp script.

5: Restard snmpd.

The application should be auto-discovered as described at the top of the page. If it is not, please follow the steps set out under `SNMP Extend` heading top of page.


### Postfix
#### SNMP Extend

1: Copy the shell script, postfix-queues, to the desired host. `wget https://github.com/librenms/librenms-agent/raw/master/snmp/postfix-queues -O /etc/snmp/postfix-queues`

2: Copy the Perl script, postfixdetailed, to the desired host. `wget https://github.com/librenms/librenms-agent/raw/master/snmp/postfixdetailed -O /etc/snmp/postfixdetailed`

3: Make both scripts executable. Run `chmod +x /etc/snmp/postfixdetailed /etc/snmp/postfix-queues`

4: Edit your snmpd.conf file and add:
```
extend mailq /etc/snmp/postfix-queues
extend postfixdetailed /etc/snmp/postfixdetailed
```

5: Restart snmpd.

6: Install pflogsumm for your OS.

7: Make sure the cache file in /etc/snmp/postfixdetailed is some place that snmpd can write too. This file is used for tracking changes between various values between each time it is called by snmpd. Also make sure the path for pflogsumm is correct.

8: Run /etc/snmp/postfixdetailed to create the initial cache file so you don't end up with some crazy initial starting value.
Please note that each time /etc/snmp/postfixdetailed is ran, the cache file is updated, so if this happens in between LibreNMS doing it then the values will be thrown off for that polling period.

The application should be auto-discovered as described at the top of the page. If it is not, please follow the steps set out under `SNMP Extend` heading top of page.

> NOTE: If using RHEL for your postfix server, qshape must be installed manually as it is not officially supported. CentOs 6 rpms seem to work without issues.

### Postgres
#### SNMP Extend
1: Copy the shell script, postgres, to the desired host. `wget https://github.com/librenms/librenms-agent/raw/master/snmp/postgres -O /etc/snmp/postgres`

2: Run `chmod +x /etc/snmp/postgres`

3: Edit your snmpd.conf file and add:
```
extend postgres /etc/snmp/postgres
```

4: Restart snmpd on your host

5: Install the Nagios check check_postgres.pl on your system.

6: Verify the path to check_postgres.pl in /etc/snmp/postgres is correct.

7: If you wish it to ignore the database postgres for totalling up the stats, set ignorePG to 1(the default) in /etc/snmp/postgres. If you are using netdata or the like, you may wish to set this or otherwise that total will be very skewed on systems with light or moderate usage.

The application should be auto-discovered as described at the top of the page. If it is not, please follow the steps set out under `SNMP Extend` heading top of page.

### PowerDNS
An authoritative DNS server: https://www.powerdns.com/auth.html
#### SNMP Extend

##### Agent
[Install the agent](Agent-Setup.md) on this device if it isn't already and copy the `powerdns` script to `/usr/lib/check_mk_agent/local/`


### PowerDNS Recursor
A recursive DNS server: https://www.powerdns.com/recursor.html

#### Direct
The LibreNMS polling host must be able to connect to port 8082 on the monitored device.
The web-server must be enabled, see the Recursor docs: https://doc.powerdns.com/md/recursor/settings/#webserver

##### Variables
`$config['apps']['powerdns-recursor']['api-key']` required, this is defined in the Recursor config
`$config['apps']['powerdns-recursor']['port']` numeric, defines the port to connect to PowerDNS Recursor on.  The default is 8082
`$config['apps']['powerdns-recursor']['https']` true or false, defaults to use http.

#### SNMP Extend
1: Copy the shell script, powerdns-recursor, to the desired host. `wget https://github.com/librenms/librenms-agent/raw/master/snmp/powerdns-recursor -O /etc/snmp/powerdns-recursor`

2: Run `chmod +x /etc/snmp/powerdns-recursor`

3: Edit your snmpd.conf file and add:
```
extend powerdns-recursor /etc/snmp/powerdns-recursor
```

4: Restart snmpd on your host

The application should be auto-discovered as described at the top of the page. If it is not, please follow the steps set out under `SNMP Extend` heading top of page.

##### Agent
[Install the agent](Agent-Setup.md) on this device if it isn't already and copy the `powerdns-recursor` script to `/usr/lib/check_mk_agent/local/`

This script uses `rec_control get-all` to collect stats.

### PowerDNS-dnsdist

###### SNMP Extend
1. Copy the BASH script to the desired host.
```
wget https://github.com/librenms/librenms-agent/raw/master/snmp/powerdns-dnsdist -O /etc/snmp/powerdns-dnsdist   
```

2. Make the script executable (chmod +x /etc/snmp/powerdns-dnsdist)

3. Edit your snmpd.conf file (usually /etc/snmp/snmpd.conf) and add:
```
extend powerdns-dnsdist /etc/snmp/powerdns-dnsdist
```

4. Restart snmpd on your host.

The application should be auto-discovered as described at the top of the page. If it is not, please follow the steps set out under `SNMP Extend` heading top of page.

### Proxmox
1. For Proxmox 4.4+ install the libpve-apiclient-perl package
`apt install libpve-apiclient-perl`

2. Download the script onto the desired host (the host must be added to LibreNMS devices)
`wget https://raw.githubusercontent.com/librenms/librenms-agent/master/agent-local/proxmox -O /usr/local/bin/proxmox`

3. Run `chmod +x /usr/local/bin/proxmox`

4. Edit your snmpd.conf file (usually `/etc/snmp/snmpd.conf`) and add:
`extend proxmox /usr/local/bin/proxmox`

5. Note: if your snmpd doesn't run as root, you might have to invoke the script using sudo and modify the "extend" line
```
extend proxmox /usr/bin/sudo /usr/local/bin/proxmox 
```

after, edit your sudo users (usually `visudo`) and add at the bottom:
```
snmp ALL=(ALL) NOPASSWD: /usr/local/bin/proxmox
```

6. Restart snmpd on your host


### Raspberry PI
SNMP extend script to get your PI data into your host.

##### SNMP Extend
1. Download the script onto the desired host.
`wget https://raw.githubusercontent.com/librenms/librenms-agent/master/snmp/raspberry.sh -O /etc/snmp/raspberry.sh`

2. Make the script executable: `chmod +x /etc/snmp/raspberry.sh`

3. Edit your snmpd.conf file (usually `/etc/snmp/snmpd.conf`) and add:
```
extend raspberry /etc/snmp/raspberry.sh
```

4. Edit your sudo users (usually `visudo`) and add at the bottom:
```
snmp ALL=(ALL) NOPASSWD: /etc/snmp/raspberry.sh, /usr/bin/vcgencmd*
```

**Note:** If you are using Raspian, the default user is `Debian-snmp`. Change `snmp` above to `Debian-snmp`. You can verify the user snmpd is using with `ps aux | grep snmpd` 

5. Restart snmpd on PI host


### SMART
#### SNMP Extend
1: Copy the Perl script, smart, to the desired host. `wget https://github.com/librenms/librenms-agent/raw/master/snmp/smart -O /etc/snmp/smart`

2: Run `chmod +x /etc/snmp/smart`

3: Edit your snmpd.conf file and add:
```
extend smart /etc/snmp/smart
```

4: You will also need to create the config file, which defaults to the same path as the script, but with .config appended. So if the script is located at /etc/snmp/smart, the config file will be /etc/snmp/smart.config. Alternatively you can also specific a config via -c.

Anything starting with a # is comment. The format for variables is $variable=$value. Empty lines are ignored. Spaces and tabes at either the start or end of a line are ignored. Any line with out a = or # are treated as a disk.
```
#This is a comment
cache=/var/cache/smart
smartctl=/usr/bin/env smartctl
useSN=1
ada0
ada1
```

The variables are as below.
```
cache = The path to the cache file to use. Default: /var/cache/smart
smartctl = The path to use for smartctl. Default: /usr/bin/env smartctl
useSN = If set to 1, it will use the disks SN for reporting instead of the device name.
        1 is the default. 0 will use the device name.
```

If you want to guess at the configuration, call it with -g and it will print out what it thinks
it should be. This will result in a usable config, but may miss some less common disk devices.

5: Restart snmpd on your host

If you have a large number of more than one or two disks on a system, you should consider adding this to cron. Also make sure the cache file is some place it can be written to.
```
 */3 * * * * /etc/snmp/smart -u
```

6. If your snmp agent runs as user "snmp", edit your sudo users (usually `visudo`) and add at the bottom:
```
snmp ALL=(ALL) NOPASSWD: /etc/snmp/smart, /usr/sbin/smartctl
```
and modify your snmpd.conf file accordingly:
```
extend smart /usr/bin/sudo /etc/snmp/smart
``` 
The application should be auto-discovered as described at the top of the page. If it is not, please follow the steps set out under `SNMP Extend` heading top of page.

If you set useSN to 1, it is worth noting that you will loose history(not able to access it from the web interface) for that device each time you change it. You will also need to run camcontrol or the like on said server to figure out what device actually corresponds with that serial number.

Also if the system you are using uses non-static device naming based on bus information, it may be worthwhile just using the SN as the device ID is going to be irrelevant in that case.

### Squid

#### SNMP Proxy

1: Enable SNMP for Squid like below, if you have not already, and restart it.

```
acl snmppublic snmp_community public
snmp_port 3401
snmp_access allow snmppublic localhost
snmp_access deny all
```

2: Restart squid on your host.

3: Edit your snmpd.conf file and add, making sure you have the same community, host, and port as above:
```
proxy -v 2c -c public 127.0.0.1:3401 1.3.6.1.4.1.3495
```

For more advanced information on Squid and SNMP or setting up proxying for net-snmp, please see the links below.

http://wiki.squid-cache.org/Features/Snmp
http://www.net-snmp.org/wiki/index.php/Snmpd_proxy

### TinyDNS aka  djbdns

##### Agent
[Install the agent](Agent-Setup.md) on this device if it isn't already and copy the `tinydns` script to `/usr/lib/check_mk_agent/local/`

_Note_: We assume that you use DJB's [Daemontools](http://cr.yp.to/daemontools.html) to start/stop tinydns.
And that your tinydns instance is located in `/service/dns`, adjust this path if necessary.

1. Replace your _log_'s `run` file, typically located in `/service/dns/log/run` with:
```shell
#!/bin/sh
exec setuidgid dnslog tinystats ./main/tinystats/ multilog t n3 s250000 ./main/
```

2. Create tinystats directory and chown:
```shell
mkdir /service/dns/log/main/tinystats
chown dnslog:nofiles /service/dns/log/main/tinystats
```

3. Restart TinyDNS and Daemontools: `/etc/init.d/svscan restart`
   _Note_: Some say `svc -t /service/dns` is enough, on my install (Gentoo) it doesn't rehook the logging and I'm forced to restart it entirely.

### Unbound

Unbound configuration:

```text
# Enable extended statistics.
server:
        extended-statistics: yes
        statistics-cumulative: yes

remote-control:
        control-enable: yes
        control-interface: 127.0.0.1

```

Restart your unbound after changing the configuration, verify it is working by running `unbound-control stats`.

##### Option 1: SNMP Extend (Preferred and easiest method)

1: Copy the shell script, unbound, to the desired host. `wget https://github.com/librenms/librenms-agent/raw/master/snmp/unbound -O /etc/snmp/unbound`

2: Run `chmod +x /etc/snmp/unbound`

3: Edit your snmpd.conf file and add:
```
extend unbound /etc/snmp/unbound
```

4: Restart snmpd.

The application should be auto-discovered as described at the top of the page. If it is not, please follow the steps set out under `SNMP Extend` heading top of page.

##### Option 2: Agent
[Install the agent](#agent-setup) on this device if it isn't already and copy the `unbound.sh` script to `/usr/lib/check_mk_agent/local/`

### UPS-nut
A small shell script that exports nut ups status.

##### SNMP Extend
1. Copy the [ups nut](https://github.com/librenms/librenms-agent/blob/master/snmp/ups-nut.sh) to `/etc/snmp/` on your host.

2. Make the script executable (chmod +x /etc/snmp/ups-nut.sh)

3. Edit your snmpd.conf file (usually /etc/snmp/snmpd.conf) and add:
```
extend ups-nut /etc/snmp/ups-nut.sh
```

4. Restart snmpd on your host

The application should be auto-discovered as described at the top of the page. If it is not, please follow the steps set out under `SNMP Extend` heading top of page.

### UPS-apcups
A small shell script that exports apcacess ups status.

##### SNMP Extend
1. Copy the [ups apcups](https://github.com/librenms/librenms-agent/blob/master/snmp/ups-apcups.sh) to `/etc/snmp/` on your host.

2. Run `chmod +x /etc/snmp/ups-apcups.sh`

3. Edit your snmpd.conf file (usually /etc/snmp/snmpd.conf) and add:
```
extend ups-apcups /etc/snmp/ups-apcups.sh
```

4. Restart snmpd on your host

The application should be auto-discovered as described at the top of the page. If it is not, please follow the steps set out under `SNMP Extend` heading top of page.


### SDFS info
A small shell script that exportfs SDFS volume info.

###### SNMP Extend
1. Download the script onto the desired host (the host must be added to LibreNMS devices)
```
wget https://raw.githubusercontent.com/librenms/librenms-agent/master/snmp/sdfsinfo -O /etc/snmp/sdfsinfo
```

2. Make the script executable (chmod +x /etc/snmp/sdfsinfo)

3. Edit your snmpd.conf file (usually /etc/snmp/snmpd.conf) and add:
```
extend sdfsinfo /etc/snmp/sdfsinfo
```

4. Restart snmpd on your host

The application should be auto-discovered as described at the top of the page. If it is not, please follow the steps set out under `SNMP Extend` heading top of page.

### ZFS

##### SNMP Extend

The installation steps are:

1. Copy the polling script to the desired host (the host must be added to LibreNMS devices)
2. Make the script executable
3. Edit snmpd.conf to include ZFS stats

###### FreeBSD
```
wget https://github.com/librenms/librenms-agent/raw/master/snmp/zfs-freebsd -O /etc/snmp/zfs-freebsd
chmod +x /etc/snmp/zfs-freebsd
echo "extend zfs /etc/snmp/zfs-freebsd" >> /etc/snmp/snmpd.conf
```

###### Linux
```
wget https://github.com/librenms/librenms-agent/raw/master/snmp/zfs-linux -O /etc/snmp/zfs-linux
chmod +x /etc/snmp/zfs-linux
echo "extend zfs /etc/snmp/zfs-linux" >> /etc/snmp/snmpd.conf
```

Now restart snmpd and you're all set.
