source: Support/SNMP-Configuration-Examples.md

# SNMP configuration examples

Table of Content:
- [Devices](#devices)
    - [Cisco](#cisco)
        - [Adaptive Security Appliance (ASA)](#adaptive-security-appliance-asa)
        - [IOS / IOS XE](#ios--ios-xe)
        - [NX-OS](#nx-os)
        - [Wireless LAN Controller (WLC)](#wireless-lan-controller-wlc)
    - [HPE 3PAR](#hpe3par)
        - [Inform OS 3.2.x](#inform-os-32x)
    - [Infoblox](#infoblox)
        - [NIOS 7.x+](#nios-7x)
    - [Juniper](#juniper)
        - [Junos OS](#junos-os)
    - [Mikrotik](#mikrotik)
        - [RouterOS 6.x](#routeros-6x)
    - [Palo Alto](#palo-alto)
        - [PANOS 6.x/7.x](#panos-6x7x)
    - [VMware](#vmware)
        - [ESX/ESXi 5.x/6.x](#esxesxi-5x6x)
        - [VCenter 6.x](#vcenter-6x)
- [Operating systems](#operating-systems)
    - [Linux (snmpd v2)](#linux-snmpd)
    - [Linux (snmpd v3)](#linux-snmpd-v3)
    - [Windows Server 2008 R2](#windows-server-2008-r2)
    - [Windows Server 2012 R2 and 2016](#windows-server-2012-r2-and-2016)
    - [Mac OSX](#Mac-OSX)

## Devices

### Cisco
#### Adaptive Security Appliance (ASA)

ASDM

1. Launch ASDM and connect to your device
2. Go to Configuration > Management Access > SNMP
3. Add your community string
4. Add in the "SNMP Host Access List" section your LibreNMS server IP address
5. Click Apply and Save

CLI 

```
# SNMPv2c

snmp-server community <YOUR-COMMUNITY>
snmp-server contact <YOUR-CONTACT>
snmp-server location <YOUR-LOCATION>
snmp-server host <INTERFACE> <LIBRENMS-IP> poll community <YOUR-COMMUNITY> version 2c

# SNMPv3

snmp-server group <GROUP-NAME> v3 priv
snmp-server user <USER-NAME> <GROUP-NAME> v3 auth sha <AUTH-PASSWORD> priv aes 128 <PRIV-PASSWORD>
snmp-server contact <YOUR-CONTACT>
snmp-server location <YOUR-LOCATION>
snmp-server host <INTERFACE> <LIBRENMS-IP> poll version 3 <USER-NAME>
```

#### IOS / IOS XE

```
# SNMPv2c
 
snmp-server community <YOUR-COMMUNITY> RO
snmp-server contact <YOUR-CONTACT>
snmp-server location <YOUR-LOCATION>

# SNMPv3

snmp-server group <GROUP-NAME> v3 priv
snmp-server user <USER-NAME> <GROUP-NAME> v3 auth sha <AUTH-PASSWORD> priv aes 128 <PRIV-PASSWORD>
snmp-server contact <YOUR-CONTACT>
snmp-server location <YOUR-LOCATION>

# Note: The following is also required if using SNMPv3 and you want to populate the FDB table.

snmp-server group <GROUP-NAME> v3 priv context vlan- match prefix 
```

#### NX-OS

```
# SNMPv2c

snmp-server community <YOUR-COMMUNITY> RO
snmp-server contact <YOUR-CONTACT>
snmp-server location <YOUR-LOCATION>

# SNMPv3

snmp-server user <USER-NAME> <GROUP-NAME> v3 auth sha <AUTH-PASSWORD> priv aes 128 <PRIV-PASSWORD>
snmp-server contact <YOUR-CONTACT>
snmp-server location <YOUR-LOCATION>
```

#### Wireless LAN Controller (WLC)
1. Access the web admin page and log in
2. If you are running version 8.1 and later, on the new dashboard click "Advanced"
3. Go to management Tab
4. On SNMP sub-menu, select "Communities"
5. Click "New..."
6. Add your community name and leave IP addresses empty
7. Click Apply and Save

### HPE 3PAR
#### Inform OS 3.2.x
- Access the CLI
- Add an SNMP Manager with your LibreNMS IP address:
```
addsnmpmgr <librenms ip>
```
- Add your SNMP community:
```
setsnmppw <community>
```

### Infoblox
#### NIOS 7.x+
1. Access the web admin page and log in
2. Go to Grid tab > Grid Manager
3. In the right menu select "Grid properties"
4. Select "SNMP" menu
5. Click "Enable SNMPv1/SNMPv2 Queries"
6. Add your community
7. Click Save & Close

### Juniper
#### Junos OS
for SNMPv1/v2c
```
set snmp description description
set snmp location location
set snmp contact contact
set snmp community YOUR-COMMUNITY authorization read-only
```
for SNMPv3 (authPriv):
```
set snmp v3 usm local-engine user authpriv authentication-sha authentication-password YOUR_AUTH_SECRET
set snmp v3 usm local-engine user authpriv privacy-aes128 privacy-password YOUR_PRIV_SECRET
set snmp v3 vacm security-to-group security-model usm security-name authpriv group mysnmpv3
set snmp v3 vacm access group mysnmpv3 default-context-prefix security-model any security-level authentication read-view mysnmpv3view
set snmp v3 vacm access group mysnmpv3 default-context-prefix security-model any security-level privacy read-view mysnmpv3view
set snmp view mysnmpv3view oid iso include
```


### Mikrotik
#### RouterOS 6.x
```
#Terminal SNMP v2 Configuration
/snmp community
set [ find default=yes ] read-access=no
add addresses=<SRC IP/NETWORK> name=<COMMUNITY>
/snmp
set contact="<NAME>" enabled=yes engine-id=<ENGINE ID> location="<LOCALTION>"
```

### Palo Alto
#### PANOS 6.x/7.x
1. Access the web admin page and log in
2. Go to Device tab > Setup
3. Go to the sub-tab "Operations"
4. Click "SNMP Setup"	
5. Enter your SNMP community and then click "OK"
6. Click Apply

Note that you need to allow SNMP on the needed interfaces. To do that you need to create a network "Interface Mgmt" profile for standard interface and allow SNMP under "Device > Management > Management Interface Settings" for out of band management interface.

One may also configure SNMP from the command line, which is useful when you need to configure more than one firewall for SNMP monitoring. Log into the firewall(s) via ssh, and perform these commands for basic SNMPv3 configuration:
```
username@devicename> configure
username@devicename# set deviceconfig system service disable-snmp no
username@devicename# set deviceconfig system snmp-setting access-setting version v3 views pa view iso oid 1.3.6.1
username@devicename# set deviceconfig system snmp-setting access-setting version v3 views pa view iso option include
username@devicename# set deviceconfig system snmp-setting access-setting version v3 views pa view iso mask 0xf0
username@devicename# set deviceconfig system snmp-setting access-setting version v3 users authpriv authpwd YOUR_AUTH_SECRET
username@devicename# set deviceconfig system snmp-setting access-setting version v3 users authpriv privpwd YOUR_PRIV_SECRET
username@devicename# set deviceconfig system snmp-setting access-setting version v3 users authpriv view pa
username@devicename# set deviceconfig system snmp-setting snmp-system location "Yourcity, Yourcountry [60.4,5.31]"
username@devicename# set deviceconfig system snmp-setting snmp-system contact noc@your.org
username@devicename# commit
username@devicename# exit
```



### VMware
#### ESX/ESXi 5.x/6.x

Log on to your ESX server by means of ssh. You may have to enable the ssh service in the GUI first.
From the CLI, execute the following commands:
```
esxcli system snmp set --authentication SHA1
esxcli system snmp set --privacy AES128
esxcli system snmp hash --auth-hash YOUR_AUTH_SECRET --priv-hash YOUR_PRIV_SECRET --raw-secret
```
This command produces output like this
```
   Authhash: f3d8982fc28e8d1346c26eee49eb2c4a5950c934
   Privhash: 0596ab30b315576a4e9f7d7bde65bf49b749e335
```
Now define a SNMPv3 user:
```
esxcli system snmp set --users authpriv/f3d8982fc28e8d1346c26eee49eb2c4a5950c934/0596ab30b315576a4e9f7d7bde65bf49b749e335/priv
esxcli system snmp set -L "Yourcity, Yourcountry [60.4,5.3]"
esxcli system snmp set -C noc@your.org
esxcli system snmp set --enable true
```

>Note: In case of snmp timouts, disable the firewall with `esxcli network firewall set --enabled false`  
>If snmp timeouts still occur with firewall disabled, migrate VMs if needed and reboot ESXi host.

#### VCenter 6.x

Log on to your ESX server by means of ssh. You may have to enable the ssh service in the GUI first.
From the CLI, execute the following commands:
```
snmp.set --authentication SHA1
snmp.set --privacy AES128
snmp.hash --auth_hash YOUR_AUTH_SECRET --priv_hash YOUR_PRIV_SECRET --raw_secret true
```
This command produces output like this
```
   Privhash: 0596ab30b315576a4e9f7d7bde65bf49b749e335
   Authhash: f3d8982fc28e8d1346c26eee49eb2c4a5950c934
```
Now define a SNMPv3 user:
```
snmp.set --users authpriv/f3d8982fc28e8d1346c26eee49eb2c4a5950c934/0596ab30b315576a4e9f7d7bde65bf49b749e335/priv
snmp.enable
```


## Operating systems
### Linux (snmpd v2)

Replace your snmpd.conf file by the example below and edit it with appropriate community in "RANDOMSTRINGGOESHERE".

```
vi /etc/snmp/snmpd.conf
```

```
# Change RANDOMSTRINGGOESHERE to your preferred SNMP community string
com2sec readonly  default         RANDOMSTRINGGOESHERE

group MyROGroup v2c        readonly
view all    included  .1                               80
access MyROGroup ""      any       noauth    exact  all    none   none

syslocation Rack, Room, Building, City, Country [GPSX,Y]
syscontact Your Name <your@email.address>

#Distro Detection
extend .1.3.6.1.4.1.2021.7890.1 distro /usr/bin/distro

#Hardware Detection (uncomment to enable)
#extend .1.3.6.1.4.1.2021.7890.2 hardware '/bin/cat /sys/devices/virtual/dmi/id/product_name'
#extend .1.3.6.1.4.1.2021.7890.3 manufacturer '/bin/cat /sys/devices/virtual/dmi/id/sys_vendor'
#extend .1.3.6.1.4.1.2021.7890.4 serial '/bin/cat /sys/devices/virtual/dmi/id/product_serial'
```

**NOTE**: On some systems the snmpd is running as its own user, which means it can't read `/sys/devices/virtual/dmi/id/product_serial` which is mode 0400. One solution is to `chmod 444 /sys/devices/virtual/dmi/id/product_serial` in `/etc/rc.local` or equivalent.

The LibreNMS server include a copy of this example here:

```
/opt/librenms/snmpd.conf.example
```

The binary /usr/bin/distro must be copied from the original source repository:

```
curl -o /usr/bin/distro https://raw.githubusercontent.com/librenms/librenms-agent/master/snmp/distro
chmod +x /usr/bin/distro
```

### Linux (snmpd v3)

Go to /etc/snmp/snmpd.conf

Open the file in vi or nano /etc/snmp/snmpd.conf and add the following line to create SNMPV3 User (replace username and passwords with your own):

```
createUser authPrivUser MD5 "authPassword" DES "privPassword"
```

Make sure the agent listens to all interfaces by adding the following line inside snmpd.conf:

```
agentAddress udp:161,udp6:[::1]:161
```

This line simply means listen to connections across all interfaces IPv4 and IPv6 respectively

Uncomment and change the following line to give read access to the username created above (rouser is what LibreNMS uses) :

```
#rouser authPrivUser priv
```

Change the following details inside snmpd.conf

```
syslocation Rack, Room, Building, City, Country [GPSX,Y]
syscontact Your Name <your@email.address>
```

Save and exit the file

#### Restart the snmpd service:

##### CentOS 6 / Red hat 6
```
service snmpd restart
```
##### CentOS 7 / Red hat 7
```
systemctl restart snmpd
```
##### Ubuntu
```
service snmpd restart
```

### Windows Server 2008 R2
1. Log in to your Windows Server 2008 R2
2. Start "Server Manager" under "Administrative Tools"
3. Click "Features" and then click "Add Feature"
5. Check (if not checked) "SNMP Service", click "Next" until "Install"
6. Start "Services" under "Administrative Tools"
7. Edit "SNMP Service" properties
8. Go to the security tab
9. In "Accepted community name" click "Add" to add your community string and permission
10. In "Accept SNMP packets from these hosts" click "Add" and add your LibreNMS server IP address
11. Validate change by clicking "Apply"

### Windows Server 2012 R2 and 2016
1. Log in to your Windows Server 2012 R2
2. Start "Server Manager" under "Administrative Tools"
3. Click "Manage" and then "Add Roles and Features"
4. Continue by pressing "Next" to the "Features" menu
5. Install (if not installed) "SNMP Service"
6. Start "Services" under "Administrative Tools"
7. Edit "SNMP Service" properties
8. Go to the security tab
9. In "Accepted community name" click "Add" to add your community string and permission
10. In "Accept SNMP packets from these hosts" click "Add" and add your LibreNMS server IP address
11. Validate change by clicking "Apply"

### Mac OSX
Step 1: ```sudo nano /etc/snmp/snmpd.conf```
```bash
#Allow read-access with the following SNMP Community String:
rocommunity public

# all other settings are optional but recommended.

# Location of the device
syslocation data centre A

# Human Contact for the device
syscontact SysAdmin

# System Name of the device
sysName SystemName

# the system OID for this device. This is optional but recommended,
# to identify this as a MAC OS system.
sysobjectid 1.3.6.1.4.1.8072.3.2.16
```
Step 2: 
``` bash 
sudo launchctl load -w /System/Library/LaunchDaemons/org.net-snmp.snmpd.plist
```
