## 1.33
*(2017-10-29)*

#### Features
* Support for up/down detection of ping only devices.
* Improve Device Neighbour WebUI ([#7487](https://github.com/librenms/librenms/issues/7487))
* Configurable 95th percentile ([#7442](https://github.com/librenms/librenms/issues/7442))
* Added AD support nested groups (resubmit #7175) ([#7259](https://github.com/librenms/librenms/pull/7259))
* Added configurable 95th percentile for graphs ([#7442](https://github.com/librenms/librenms/pull/7442))
* Added  sysname as filtering group for oxidized ([#7485](https://github.com/librenms/librenms/pull/7485))
* CDP matching incorrect ports ([#7491](https://github.com/librenms/librenms/pull/7491))
* Issue warning notification if php version is less than 5.6.4 ([#7418](https://github.com/librenms/librenms/pull/7418))
* Added Web validation support ([#7474](https://github.com/librenms/librenms/pull/7474))
* Support for up/down detection of ping only devices ([#7323](https://github.com/librenms/librenms/pull/7323))

#### Bugfixes
* rfc1628 state sensor translations ([#7416](https://github.com/librenms/librenms/pull/7416))
* snmpwalk_group tables not using entries ([#7427](https://github.com/librenms/librenms/pull/7427))
* Improve accuracy of is_valid_hostname() ([#7435](https://github.com/librenms/librenms/pull/7435))
* snmp_get_multi returns no data if the oid doesn't contain a period ([#7456](https://github.com/librenms/librenms/pull/7456))
* Fixed clickatell alert transport ([#7446](https://github.com/librenms/librenms/pull/7446))
* Escape sql credentials during install ([#7494](https://github.com/librenms/librenms/pull/7494))
* Fixed OEM ipmi sensors that returns unreadable values ([#7518](https://github.com/librenms/librenms/pull/7518))
* Fixed ospf polling not removing stale data ([#7503](https://github.com/librenms/librenms/pull/7503))
* LLDP discovery change local port resolution ([#7443](https://github.com/librenms/librenms/pull/7443))

#### Documentation
* Include Freeswitch in applications doc ([#7556](https://github.com/librenms/librenms/issues/7556))
* Added more example hardware ([#7542](https://github.com/librenms/librenms/issues/7542))
* Update syslog docs to prevent dates in the future/past ([#7519](https://github.com/librenms/librenms/issues/7519))
* Alerts glues ([#7480](https://github.com/librenms/librenms/issues/7480))
* Improve CentOS 7 and Ubuntu 16 rrdcached installation instructions ([#7473](https://github.com/librenms/librenms/issues/7473))
* Re-organize install docs ([#7424](https://github.com/librenms/librenms/pull/7424))
* Added HipChat V2 WebUI Config Example ([#7486](https://github.com/librenms/librenms/pull/7486))
* Alert rules, added in the alert rules videos ([#7512](https://github.com/librenms/librenms/pull/7512))
* Updated references for ##librenms to discord ([#7523](https://github.com/librenms/librenms/pull/7523))
* Document discovery and poller module enable/disable support ([#7505](https://github.com/librenms/librenms/pull/7505))
* OpenManage including info for windows ([#7534](https://github.com/librenms/librenms/pull/7534))
* Added SSL config for CentOS 7 with Apache ([#7529](https://github.com/librenms/librenms/pull/7529))
* Added Dynamic Configuration UI for Network-Map.md ([#7540](https://github.com/librenms/librenms/pull/7540))
* New doc for weathermap ([#7536](https://github.com/librenms/librenms/pull/7536))

#### Devices
* Always allow empty ifDescr on fortigate ([#7547](https://github.com/librenms/librenms/issues/7547))
* Added temperature sensor to datacom switches. ([#7522](https://github.com/librenms/librenms/issues/7522))
* Added more Procera interfaces ([#7422](https://github.com/librenms/librenms/issues/7422))
* Added firewall graphs for Palo Alto Networks firewall ([#7483](https://github.com/librenms/librenms/issues/7483))
* Added support for Alcoma wireless devices ([#7476](https://github.com/librenms/librenms/issues/7476))
* Added detection for SmartOptics T-Series devices ([#7433](https://github.com/librenms/librenms/issues/7433))
* Added more support for Avocent devices ([#7444](https://github.com/librenms/librenms/issues/7444))
* Added Dlink dap2660 add processors and mempools ([#7428](https://github.com/librenms/librenms/issues/7428))
* Added additional zywall-usg support ([#7405](https://github.com/librenms/librenms/pull/7405))
* Added Dlink dap2660 processors and mempools ([#7428](https://github.com/librenms/librenms/pull/7428))
* Added technicolor TG650S and TG670S ([#7420](https://github.com/librenms/librenms/pull/7420))
* Added support for alternate Equallogic SNMP sysObjectId ([#7394](https://github.com/librenms/librenms/pull/7394))
* Added zyxelnwa storage, mempools and wireless metrics ([#7441](https://github.com/librenms/librenms/pull/7441))
* Added Storage, Memory pools, new status (Array Controller, Logical Drive) for HP ILO4 ([#7436](https://github.com/librenms/librenms/pull/7436))
* Added Support for ApsoluteOS / Defense Pro Hw ([#7440](https://github.com/librenms/librenms/pull/7440))
* Added support for Huawei OceanStor devices ([#7445](https://github.com/librenms/librenms/pull/7445))
* Added detection for Racom OS RAy (#[7466](https://github.com/librenms/librenms/pull/7466)) 
* Improved Zhone MXK Discovery ([#7488](https://github.com/librenms/librenms/pull/7488))
* Added support for EATON-ATS devices ([#7448](https://github.com/librenms/librenms/pull/7448))
* Added support for Alcoma devices ([#7476](https://github.com/librenms/librenms/pull/7476))
* Added support for zywall usg vpn state and flash usage ([#7500](https://github.com/librenms/librenms/pull/7500))
* Added Brocade IronWare interface dBm sensor support ([#7434](https://github.com/librenms/librenms/pull/7434))
* Added Unifi AC HD detection ([#7516](https://github.com/librenms/librenms/pull/7516))
* Added initial detection for netmodule NB1600 ([#7514](https://github.com/librenms/librenms/pull/7514))
* Added support for new Fiberhome OLT Models ([#7499](https://github.com/librenms/librenms/pull/7499))
* Added support for logmaster(ups vendors) os/devices ([#7524](https://github.com/librenms/librenms/pull/7524))
* Added poller modules to ceraos ([#7470](https://github.com/librenms/librenms/pull/7470))
* Added more detection for IgniteNet FusionSwitch ([#7384](https://github.com/librenms/librenms/pull/7384))
* Added Mitel Standard Linux OS Support ([#7513](https://github.com/librenms/librenms/pull/7513))
* Updated Cisco WAP detection and merged in ciscosmblinux OS ([#7447](https://github.com/librenms/librenms/pull/7447))
* Added detection for Proxmox ([#7543](https://github.com/librenms/librenms/pull/7543)) 

#### Alerting
* Added alert rules for RFC1628 UPS to the collection ([#7415](https://github.com/librenms/librenms/pull/7415))
* Added HP iLo and OS-updates rules to the collection ([#7423](https://github.com/librenms/librenms/pull/7423))
* Added more simple rules for the alert collection ([#7430](https://github.com/librenms/librenms/pull/7430))

#### Refactor
* Discovery protocols re-write ([#7380](https://github.com/librenms/librenms/pull/7380))

#### WebUI
* Show only authorized services in availability map ([#7498](https://github.com/librenms/librenms/issues/7498))
* Allow user to display ok/warning/critical alerts only ([#7484](https://github.com/librenms/librenms/issues/7484))

#### Security
* Stop accepting other variables in install that we do not use ([#7511](https://github.com/librenms/librenms/pull/7511))

---

source: General/Changelog.md
## 1.32
*(2017-10-01)*

#### Features
* Added more rules to the collection of alert rules ([#7363](https://github.com/librenms/librenms/issues/763))
* Allow ignore_mount, ignore_mount_string, ignore_mount_regex per OS ([#7304](https://github.com/librenms/librenms/issues/7304))
* Added script to generate config for new OS ([#7161](https://github.com/librenms/librenms/issues/7161))
* Added Syslog hook for ASA support ([#7268](https://github.com/librenms/librenms/issues/7268))

#### Bugfixes
* If session save path is "", php will use /tmp ([#7359](https://github.com/librenms/librenms/issues/7359))
* rfc1628 runtime - allow os quirks ([#7340](https://github.com/librenms/librenms/issues/7340))
* Small error when checking ios for wireless rssi ([#7300](https://github.com/librenms/librenms/issues/7300))
* Use Netscaler vserver full names ([#7279](https://github.com/librenms/librenms/issues/7279))
* Slower hardware can hit the schema update response timeout ([#7296](https://github.com/librenms/librenms/issues/7296))
* Do not issue non-master warning if on the release update channel ([#7297](https://github.com/librenms/librenms/issues/7297))
* Fixed quotes breaking powerdns app data ([#7111](https://github.com/librenms/librenms/issues/7111))
* Updated graph_types table so graph_subtype has no default value ([#7285](https://github.com/librenms/librenms/issues/7285))
* Fixed IPv6 host renaming ([#7275](https://github.com/librenms/librenms/issues/7275))
* Fixed Comware Processor Discovery && Hardware Info ([#7206](https://github.com/librenms/librenms/issues/7206))
* Added Extreme OS mapping to 'gen_rancid' ([#7261](https://github.com/librenms/librenms/issues/7261))
* Reverted previous active directory changes [#7254](https://github.com/librenms/librenms/issues/7254) ([#7257](https://github.com/librenms/librenms/issues/7257))
* Fixed Avtech sensor discovery ([#7244](https://github.com/librenms/librenms/issues/7244))
* Corrected variable for timeout messages in unix-agent.inc.php ([#7246](https://github.com/librenms/librenms/issues/7246))
* Update notification for users with updates disabled ([#7253](https://github.com/librenms/librenms/issues/7253))
* Fixed the empty() vlan detection check ([#7241](https://github.com/librenms/librenms/issues/7241))
* Re-added changes for [#6959](https://github.com/librenms/librenms/issues/6959) removed by accident in [#7128](https://github.com/librenms/librenms/issues/7128) ([#7240](https://github.com/librenms/librenms/issues/7240))
* Issues with Geist Watchdog sensors
* Issues with Geist Watchdog miss-named variable in sensor pre-caching internal humidity and temperature was discovered twice humidity was mis-spelled in yaml discovery temperature and current had incorrect divisor in yaml

#### Documentation
* Added new faq Why would alert un-mute itself? ([#7403](https://github.com/librenms/librenms/issues/7403))
* Added performance suggestion for 1min polling documentation
* Updated Distributed poller doc as rrdcached needs -R to work properly ([#7393](https://github.com/librenms/librenms/issues/7393))
* Updated docs to include installing xml php modules + updated validate ([#7349](https://github.com/librenms/librenms/issues/7349))
* Reorganize authentication documentation ([#7329](https://github.com/librenms/librenms/issues/7329))
* Update RRDCached.md to clarify version for client/server ([#7320](https://github.com/librenms/librenms/issues/7320))
* Elaborated on permission issues with dmidecode for snmp ([#7288](https://github.com/librenms/librenms/issues/7288))
* Update Distributed-Poller.md to remove distributed_poller_host
* Added debug to services.md ([#7238](https://github.com/librenms/librenms/issues/7238))
* Fixed API-Docs Link in webui ([#7242](https://github.com/librenms/librenms/issues/7242))
* Updated Services.md include chmod +x ([#7230](https://github.com/librenms/librenms/issues/7230))

#### Refactoring
* Rewrite is_valid_port() ([#7360](https://github.com/librenms/librenms/issues/7360))
* rfc1628 sensor tidy up ([#7341](https://github.com/librenms/librenms/issues/7341))
* Added detection of vlan name changes ([#7348](https://github.com/librenms/librenms/issues/7348))
* Rewrite is_valid_port() ([#7337](https://github.com/librenms/librenms/issues/7337))
* Use the Config class includes/discovery ([#7299](https://github.com/librenms/librenms/issues/7299))
* Updated ldap auth to allow configurable uidnumber field ([#7302](https://github.com/librenms/librenms/issues/7302))
* Improve yaml state discovery ([#7221](https://github.com/librenms/librenms/issues/7221))
* Added IOS-XR Bundle-Ether shortened/corrected forms ([#7283](https://github.com/librenms/librenms/issues/7283))

#### Devices
* Added basic detection for  hanwha techwin devices ([#7397](https://github.com/librenms/librenms/issues/7397))
* Added sensor detection for APC In Row RD devices ([#7385](https://github.com/librenms/librenms/issues/7385))
* Added better hardware and version identification for SAF ([#7378](https://github.com/librenms/librenms/issues/7378))
* Added basic os for EricssonLG ES switches ([#7289](https://github.com/librenms/librenms/issues/7289))
* Updated Engenius OS detection ([#7365](https://github.com/librenms/librenms/issues/7365))
* Added detection for DPS Telecom NetGuardian ([#7326](https://github.com/librenms/librenms/issues/7326))
* Added support for Alpha FXM UPS devices ([#7324](https://github.com/librenms/librenms/issues/7324))
* Added detection for IgniteNet FusionSwitch devices
* Added support for A10 ACOS devices ([#7327](https://github.com/librenms/librenms/issues/7327))
* Added more detection for Cisco SB devices
* Added support for routeros to pull UPS info
* Added additional detection for Cisco small business switches ([#7317](https://github.com/librenms/librenms/issues/7317))
* Added sensor support for Himoinsa Gensets ([#7315](https://github.com/librenms/librenms/issues/7315))
* Added support for SmartOptics M-Series ([#7314](https://github.com/librenms/librenms/issues/7314))
* Added DHCP Leases Graph for Mikrotik ([#7333](https://github.com/librenms/librenms/issues/7333))
* Added support for Toshiba RemotEye4 devices ([#7312](https://github.com/librenms/librenms/issues/7312))
* Added additional Quanta detection ([#7316](https://github.com/librenms/librenms/issues/7316))
* Added additional detection for Calix devices ([#7325](https://github.com/librenms/librenms/issues/7325))
* Added detection for Himoinsa Gensets ([#7295](https://github.com/librenms/librenms/issues/7295))
* Added detection for ServerChecks ([#7308](https://github.com/librenms/librenms/issues/7308))
* Added support for Saf Integra Access points ([#7292](https://github.com/librenms/librenms/issues/7292))
* Added basic Open-E detection ([#7301](https://github.com/librenms/librenms/issues/7301))
* Updated Arista entity-physical support to use high/low values from device ([#7156](https://github.com/librenms/librenms/issues/7156))
* Added support for Mimosa A5 ([#7287](https://github.com/librenms/librenms/issues/7287))
* Updated state sensor code for Netonix
* Added support for Radware / AlteonOS OS/Mem/Proc ([#7220](https://github.com/librenms/librenms/issues/7220))
* Added support for DragonWave Horizon ([#7264](https://github.com/librenms/librenms/issues/7264))

#### WebUI
* Updated alert rule collection to be table ([#7371](https://github.com/librenms/librenms/issues/7371))
* Show how long a device has been down if it is down ([#7336](https://github.com/librenms/librenms/issues/7336))
* Makes the .availability-label border-radius fit in with the border a bit better
* Added device description to overview page ([#7328](https://github.com/librenms/librenms/issues/7328))
* Greatly reduces application memory leak for dashboard ([#7215](https://github.com/librenms/librenms/issues/7215))

#### API
* Added ability to supports CORS for API ([#7357](https://github.com/librenms/librenms/issues/7357))
* Added simple OSPF API route ([#7298](https://github.com/librenms/librenms/pull/7298))

---

## 1.31
*(2017-08-26)*

#### Features
* Notify about failed updates, block detectable bad updates ([#7188](https://github.com/librenms/librenms/issues/7188))
* Improve install process ([#7223](https://github.com/librenms/librenms/issues/7223))
* Active Directory user in nested groups ([#7175](https://github.com/librenms/librenms/issues/7175))
* sysV init script for the IRC bot ([#7170](https://github.com/librenms/librenms/issues/7170))
* Create librenms-irc.service ([#7087](https://github.com/librenms/librenms/issues/7087))
* Forced OS Cache rebuild for unit tests ([#7163](https://github.com/librenms/librenms/issues/7163))
* New IP parsing classes.  Removes usage of Pear Net_IPv4 and Net_IPv6. ([#7106](https://github.com/librenms/librenms/issues/7106))
* Added support to cisco sensors to link them to ports + macro/docs for alerting ([#6959](https://github.com/librenms/librenms/issues/6959))
* snmp exec support ([#7126](https://github.com/librenms/librenms/issues/7126))

#### Bugfixes
* Updated dump_db_schema() to use default 0 if available ([#7225](https://github.com/librenms/librenms/issues/7225))
* Comware dBm Limits && Comware Sensor Descr ([#7216](https://github.com/librenms/librenms/issues/7216))
* Update gen_rancid.php to the correct arista os name ([#7214](https://github.com/librenms/librenms/issues/7214))
* Use Correct Comware dBm Limits ([#7207](https://github.com/librenms/librenms/issues/7207))
* Correct memory calculation for screenos ([#7191](https://github.com/librenms/librenms/issues/7191))
* Cambium ePMP CPU reporting fix ([#7182](https://github.com/librenms/librenms/issues/7182))
* Send zero for fields without values for graphite ([#7176](https://github.com/librenms/librenms/issues/7176))
* Sanitize metric name before sending via graphite ([#7173](https://github.com/librenms/librenms/issues/7173))
* Fixed dump_db_schema / validate to work with newer versions of MariaDB ([#7162](https://github.com/librenms/librenms/issues/7162))
* Escape sensor_descr_fixed in dBm sensors graph ([#7146](https://github.com/librenms/librenms/issues/7146))
* Fixed issue with column size of ifTrunk ([#7125](https://github.com/librenms/librenms/issues/7125))
* Bug in ipv62snmp function ([#7135](https://github.com/librenms/librenms/issues/7135))
* Fixed Raspberry Pi sensors ([#7131](https://github.com/librenms/librenms/issues/7131))
* Check session directory is writable before install.php ([#7103](https://github.com/librenms/librenms/issues/7103))
* Raritan CPU temperature discovery ([#7130](https://github.com/librenms/librenms/issues/7130))
* Strip " and / from snmpwalk_cache_oid() ([#7063](https://github.com/librenms/librenms/issues/7063))
* Fixed Raspberry Pi sensors support ([#7068](https://github.com/librenms/librenms/issues/7068))
* Added missing get_group_list() to ldap-authorization auth method ([#7102](https://github.com/librenms/librenms/issues/7102))
* Service warning/critical alert rules ([#7105](https://github.com/librenms/librenms/issues/7105))
* Added device status reason to up messages. ([#7085](https://github.com/librenms/librenms/issues/7085))
* Fix string quoting in snmp trim ([#7120](https://github.com/librenms/librenms/issues/7120))
* Fix missed call to removed is_ip function ([#7132](https://github.com/librenms/librenms/issues/7132))
* fix bugs introduced to address-search ([#7138](https://github.com/librenms/librenms/issues/7138))
* Update avaya-ers.inc.php ([#7139](https://github.com/librenms/librenms/issues/7138))
* Fix RPI frequency/voltage sensors ([#7144](https://github.com/librenms/librenms/issues/7144))
* Attempt to fix repeated sql issue we come across ([#7123](https://github.com/librenms/librenms/issues/7123))
* multiple fixes under agentStpSwitchConfigGroup in EdgeSwitch-SWITCHIN ([#7180](https://github.com/librenms/librenms/issues/7180))
* Fixed typo Predicated -> Predicted (2 instances) ([#7222](https://github.com/librenms/librenms/issues/7222))

#### Documentation
* Updated index page for new alerting structure ([#7226](https://github.com/librenms/librenms/issues/7226))
* Updated some old links for alerting ([#7211](https://github.com/librenms/librenms/issues/7211))
* Updated CentOS 7 + Nginx install docs ([#7209](https://github.com/librenms/librenms/issues/7209))
* Update CentOS 7 + Nginx install docs to set SCRIPT_FILENAME ([#7200](https://github.com/librenms/librenms/issues/7200))
* Update Component.md  ([#7196](https://github.com/librenms/librenms/issues/7196))
* Update Two-Factor-Auth formatting ([#7194](https://github.com/librenms/librenms/issues/7194))
* Update IRC-Bot for systemd use  ([#7084](https://github.com/librenms/librenms/issues/7084))
* Updated API docs formatting ([#7187](https://github.com/librenms/librenms/issues/7187))
* Updated alerting docs / formatting ([#7185](https://github.com/librenms/librenms/issues/7185))
* Swap mdx_del_ins with pymdownx.tilde ([#7186](https://github.com/librenms/librenms/issues/7186))
* Centralised the Metric storage docs ([#7109](https://github.com/librenms/librenms/issues/7109))
* Allow host renames with selinux enforcing for CentOS installs ([#7136](https://github.com/librenms/librenms/issues/7136))
* Update Using-Git.md ([#7178](https://github.com/librenms/librenms/issues/7178))

#### Refactoring
* Use anonymous functions for debug error_handler and shutdown_function in index.php ([#7219](https://github.com/librenms/librenms/issues/7219))
* Updated validate.php to only warn users the install is out of date if > 24 hours ([#7208](https://github.com/librenms/librenms/issues/7208))
* Udated edgecos OS polling ([#7149](https://github.com/librenms/librenms/issues/7149))
* Ability to edit default alert template ([#7121](https://github.com/librenms/librenms/issues/7121))
* Replace escapeshellcmd with Purifier in service checks ([#7118](https://github.com/librenms/librenms/issues/7118))
* Use ifName if ifDescr is blank [#7079](https://github.com/librenms/librenms/issues/7079)

#### Devices
* Stop discoverying frequencies on Raritan devices that do not exist + added voltage ([#7195](https://github.com/librenms/librenms/issues/7195))
* Added FDB and ARP support for edgeswitch devices ([#7199](https://github.com/librenms/librenms/issues/7199))
* Added additional sensor support for Sentry4 devices ([#7198](https://github.com/librenms/librenms/issues/7198))
* Added additional vlan support for Juniper devices ([#7203](https://github.com/librenms/librenms/issues/7203))
* Added Kemp LoadMaster Version Info ([#7205](https://github.com/librenms/librenms/issues/7205))
* Updated fans/temp detection for Brocade VDX devices([#7183](https://github.com/librenms/librenms/issues/7183))
* Added further sensor support for Geist Watchdog ([#7143](https://github.com/librenms/librenms/issues/7143))
* Added detection for Hitachi Data Systems SAN ([#7160](https://github.com/librenms/librenms/issues/7160))
* Udated edgecos OS polling to include more models
* Updated AKCP sensorProbe detection ([#7152](https://github.com/librenms/librenms/issues/7152))
* Added additional sensor support for Cisco ONS ([#7096](https://github.com/librenms/librenms/issues/7096))
* Added RSSI Support for Cisco IOS wireless devices ([#7147](https://github.com/librenms/librenms/issues/7147))
* Added support for Gude ETS devices ([#7145](https://github.com/librenms/librenms/issues/7145))
* Added support for Trango Apex Lynx OS ([#7142](https://github.com/librenms/librenms/issues/7142))
* Added dry contact state support for AKCP devices ([#7124](https://github.com/librenms/librenms/issues/7124))
* Added fan and temp sensor state discovery Avaya ERS ([#7134](https://github.com/librenms/librenms/issues/7134))
* Added support for Emerson energy systems ([#7128](https://github.com/librenms/librenms/issues/7128))
* Added detection for Alteon OS ([#7088](https://github.com/librenms/librenms/issues/7088))
* Added additional sensors for Microsemi PowerDsine PoE Switches ([#7114](https://github.com/librenms/librenms/issues/7114))
* Added detection for NEC Univerge devices ([#7108](https://github.com/librenms/librenms/pull/7108))
* Added VLAN discovery support for Avaya ERS devices ([#7098](https://github.com/librenms/librenms/pull/7098)) 
* Added ROS support for state sensors and system temps
* Removed check for switch model or firmware version for Avaya ERS switches
* Updated QNAP to include CPU temps ([#7110](https://github.com/librenms/librenms/pull/7110))
* Added basic VLAN disco support for Avaya-ERS switches ([#7098](https://github.com/librenms/librenms/pull/7098))
* Update ees.yaml to use correct overview graphs ([#7137](https://github.com/librenms/librenms/pull/7137))
* Update edgecos OS polling to include more models ([#7153](https://github.com/librenms/librenms/pull/7153))
* Added Raspbian Logo ([#7201](https://github.com/librenms/librenms/pull/7201))

#### WebUI
* Added ability for users to configure selectable times for graphs  ([#7193](https://github.com/librenms/librenms/issues/7193))
* Updated pi-hole graphs for better grouping ([#7179](https://github.com/librenms/librenms/issues/7179))
* Removed ability to use OR for generating rules ([#7150](https://github.com/librenms/librenms/issues/7150))
* Update avaya-ers to use ifName for displaying ([#7113](https://github.com/librenms/librenms/issues/7113))

#### Security
* Security Patch to deal with reported vulnerabilties ([#7164](https://github.com/librenms/librenms/issues/7164))

---

## 1.30
*(2017-07-27)*

#### Features
* Added script to test alerts ([#7050](https://github.com/librenms/librenms/issues/7050))
* Config helper to simplify config access ([#7066](https://github.com/librenms/librenms/issues/7066))
* Add timeout to AD auth, default is 5s ([#6967](https://github.com/librenms/librenms/issues/6967))
* Ignore web server log files ownership in validate ([#6943](https://github.com/librenms/librenms/issues/6943))
* Added new parallel snmp-scan.py to replace snmp-scan.php ([#6889](https://github.com/librenms/librenms/issues/6889))
* Add a new locking framework that uses flock. ([#6858](https://github.com/librenms/librenms/issues/6858))
* Support fdb table on generic devices ([#6902](https://github.com/librenms/librenms/issues/6902))
* Added support for sensors to be discovered from yaml ([#6859](https://github.com/librenms/librenms/issues/6859))
* Improved install experience ([#6915](https://github.com/librenms/librenms/pull/6915))
* Updated validate to detect lower case tables + added support for checking mariadb 10.2 timestamps ([#6928](https://github.com/librenms/librenms/pull/6928))
* Added support for sending metrics to OpenTSDB ([#7022](https://github.com/librenms/librenms/pull/7022))
* Further improvements and detection added to validate ([#6973](https://github.com/librenms/librenms/pull/6973))
* Added JIRA transport for alerts ([#7040](https://github.com/librenms/librenms/pull/7040))
* Log event if device polling takes too long ([#7065](https://github.com/librenms/librenms/pull/7065))

#### Bugfixes
* Allow discovery of IAP radios on Aruba Virtual Controller
* Netbotz state sensors using wrong value ([#7027](https://github.com/librenms/librenms/issues/7027))
* Fixed Rittal LCP sensor divisors ([#7014](https://github.com/librenms/librenms/issues/7014))
* Set event type alert for alert log entries ([#7013](https://github.com/librenms/librenms/issues/7013))
* Fixed netman voltage and load divisor values ([#6905](https://github.com/librenms/librenms/issues/6905))
* Fixed the index for sentry3 current + updated mibs ([#6911](https://github.com/librenms/librenms/issues/6911))
* Fixed checks for $entPhysicalIndex/$hrDeviceIndex being numeric ([#6907](https://github.com/librenms/librenms/issues/6907))
* Fixed perf_times cleanup so it actually runs ([#6908](https://github.com/librenms/librenms/issues/6908))
* Updated sed commands to allow rrdstep.php to be used to increase and decrease values ([#6941](https://github.com/librenms/librenms/pull/6941))
* Fixed FabOS state sensors ([#6947](https://github.com/librenms/librenms/pull/6947))
* Fixed FDB tables multiple IPs and IPs from other devices adding extra rows ([#6930](https://github.com/librenms/librenms/pull/6930))
* Fixed bug get_graph_by_port_hostname() only searching hostnames ([#6936](https://github.com/librenms/librenms/pull/6936))
* Include state descriptions in eventlog ([#6977](https://github.com/librenms/librenms/pull/6977))
* Eltek Valere initial detection ([#6979](https://github.com/librenms/librenms/pull/6979))
* Fixed all mib errors in base mib directory ([#7002](https://github.com/librenms/librenms/pull/7002))
* Show fatal config.php errors on the web page. ([#7023](https://github.com/librenms/librenms/pull/7023))
* Define standard ups-mib divisors properly ([#6942](https://github.com/librenms/librenms/pull/6942))
* When force adding, use the provided snmp details rather than from $config ([#7004](https://github.com/librenms/librenms/pull/7004))
* Change .htaccess to compensate for Apache bug ([#6971](https://github.com/librenms/librenms/pull/6971))
* Use the correct high/high warn thresholds for junos dbm sensors ([#7056](https://github.com/librenms/librenms/pull/7056))
* Stop loading all oses when we have no db connection ([#7003](https://github.com/librenms/librenms/pull/7003))
* Restore old junos version code as a fallback ([#6945](https://github.com/librenms/librenms/pull/6945))

#### Documentation
* Updated SNMP configuration Documentation  ([#7017](https://github.com/librenms/librenms/issues/7017))
* A couple of small fixes to the dynamic sensor docs ([#6922](https://github.com/librenms/librenms/issues/6922))
* Update Rancid Integration

#### Refactoring
* Use the new locks for schema updates ([#6931](https://github.com/librenms/librenms/issues/6931))
* Finish logic and definition separation for auth ([#6883](https://github.com/librenms/librenms/pull/6883))
* Added ability specify options for sensors yaml discovery ([#6985](https://github.com/librenms/librenms/pull/6985))
* Return more descriptive error when adding duplicate devices on sysName ([#7019](https://github.com/librenms/librenms/pull/7019))

#### Devices
* Added additional PBN detection
* Added more support for APC sensors ([#7039](https://github.com/librenms/librenms/issues/7039))
* Added sensors for Mikrotik using mtxrOpticalTable + updated MIB ([#7037](https://github.com/librenms/librenms/issues/7037))
* Added additional sensors support for HP ILO4 ([#7053](https://github.com/librenms/librenms/issues/7053))
* Added wireless sensors for SAF Tehnika ([#6975](https://github.com/librenms/librenms/issues/6975))
* Added Calix AXOS/E5-16F Detection ([#6926](https://github.com/librenms/librenms/issues/6926))
* Added more sensor support for raritan devices ([#6929](https://github.com/librenms/librenms/issues/6929))
* Added ExtremeWireless support ([#6819](https://github.com/librenms/librenms/pull/6819))
* Added Rittal LCP Liquid Cooling Package ([#6626](https://github.com/librenms/librenms/pull/6626))
* Added Detect for Toshiba Tec e-Studio printers ([#6984](https://github.com/librenms/librenms/pull/6984))
* Added Valere system sensors and os detection ([#6981](https://github.com/librenms/librenms/pull/6981))
* Added Savin printer support ([#6982](https://github.com/librenms/librenms/pull/6982))
* Added sensor support for APC IRRP 100/500 devices ([#7024](https://github.com/librenms/librenms/pull/7024))
* Added additional sensors for APC IRRP100 Air Conditionner series ([#7006](https://github.com/librenms/librenms/pull/7006))
* Added detection for Gestetner printers ([#7038](https://github.com/librenms/librenms/pull/7038))
* Added FDB support for IOS-XE devices ([#7044](https://github.com/librenms/librenms/pull/7044))
* Added detection for Siemens Ruggedcom Switches ([#7052](https://github.com/librenms/librenms/pull/7052))
* Added CiscoSB Port Suspended Status Info ([#7064](https://github.com/librenms/librenms/issues/7064))
* Added CiscoSB DOM Support ([#7072](https://github.com/librenms/librenms/pull/7072))
* Added support for temp and processor discovery on Avaya ERS3500 ([#7070](https://github.com/librenms/librenms/pull/7070))
* Added detection for TSC Barcode printer ([#7074](https://github.com/librenms/librenms/pull/7074))
* Added state sensor for HPE MSL ([#7058](https://github.com/librenms/librenms/pull/7058))
* Added PBN AIMA3000 detection ([#7083](https://github.com/librenms/librenms/pull/7083))
* Updated UBNT Airos type to wireless ([#6867](https://github.com/librenms/librenms/issues/6867))
* Updated IOS-XE detection for 3000 series devices (like 3850) ([#6983](https://github.com/librenms/librenms/issues/6983))
* Updated JunOS os polling to detect version correctly ([#6904](https://github.com/librenms/librenms/issues/6904))
* Updated Radwin detection ([#6918](https://github.com/librenms/librenms/issues/6918))
* Updated Gamatronic ups use sysObjectID for os discovery ([#6940](https://github.com/librenms/librenms/pull/6940))
* Updated HPE MSM Support ([#7026](https://github.com/librenms/librenms/pull/7026))
* Updated powerwalker sensor discovery to use custom mib ([#7020](https://github.com/librenms/librenms/pull/7020))
* Updated Cisco IOS XE Version Parsing ([#7073](https://github.com/librenms/librenms/pull/7073))

#### WebUI
* Facelift for alert templates, also added bootgrid ([#7041](https://github.com/librenms/librenms/issues/7041))
* Set correct button text when editing an alert template ([#6916](https://github.com/librenms/librenms/issues/6916))
* Minor visual changes in schedule maintenance window and its modal ([#6934](https://github.com/librenms/librenms/pull/6934))
* Fixed issues with http-auth when the guest user is created before the intended user ([#7000](https://github.com/librenms/librenms/pull/7000))
* Delhost: Added an empty option for device selection, and a minor db performance fix ([#7018](https://github.com/librenms/librenms/pull/7018))
* Loading speed improvement when viewing syslogs for specific device ([#7062](https://github.com/librenms/librenms/pull/7062))

#### Security
* Enable support for secure cookies ([#6868](https://github.com/librenms/librenms/issues/6868))

#### API
* Added api routes for eventlog, syslog, alertlog, authlog ([#7071](https://github.com/librenms/librenms/pull/7071))

---

## 1.29
*(2017-06-24)*

#### Features
* New snmpwalk_group() function ([#6865](https://github.com/librenms/librenms/issues/6865))
* Added support for passing state to alert templates test 
* Added option to specify transport when testing a template ([#6755](https://github.com/librenms/librenms/issues/6755))
* Added support to use IP addresses for NfSen filenames ([#6824](https://github.com/librenms/librenms/issues/6824))
* Added pi-hole application support ([#6782](https://github.com/librenms/librenms/issues/6782))
* Added some more coloring and make it easier to colorize messages for irc bot ([#6759](https://github.com/librenms/librenms/issues/6759))
* Added syslog auth failure to alert_rules.json ([#6847](https://github.com/librenms/librenms/issues/6847))
* Added support to use IP addresses for NfSen filenames ([#6824](https://github.com/librenms/librenms/issues/6824))
* Added Irc host authentication ([#6757](https://github.com/librenms/librenms/issues/6757))
* Added Syslog hooks for Oxidized integration (and more) ([#6785](https://github.com/librenms/librenms/issues/6785))

#### Bugfixes
* config_to_json.php does not pull in database configuration settings ([#6884](https://github.com/librenms/librenms/issues/6884))
* Updated sysObjectId column in devices table to varchar(128) ([#6832](https://github.com/librenms/librenms/issues/6832))
* Strip " from rPi temp sensor discovery ([#6815](https://github.com/librenms/librenms/issues/6815))
* Check for ifHCInOctets and ifHighSpeed before falling back to if… ([#6777](https://github.com/librenms/librenms/issues/6777))
* Updated Raspberry Pi Temp sensor discovery ([#6804](https://github.com/librenms/librenms/issues/6804))
* Fix bad Cisco dBm discovery on some IOS versions ([#6789](https://github.com/librenms/librenms/issues/6789))
* Ircbot - reformatted strikethrough for recovered alerts ([#6756](https://github.com/librenms/librenms/issues/6756))
* Ensure rrdtool web settings aren't overwrote by defaults ([#6698](https://github.com/librenms/librenms/issues/6698))
* Add column title under device bgp tab ([#6747](https://github.com/librenms/librenms/issues/6747))
* Custom config.php os settings ([#6850](https://github.com/librenms/librenms/issues/6850))
* Fix for syslog-messages from zywall (USG series) ([#6838](https://github.com/librenms/librenms/issues/6838))

#### Documentation
* Reorganised alerting docs + added some clarifications ([#6869](https://github.com/librenms/librenms/issues/6869))
* Update Ubuntu and CentOS nginx install doc with a better nginx config ([#6836](https://github.com/librenms/librenms/issues/6836))
* Added note to configure mod_status for Apache application ([#6810](https://github.com/librenms/librenms/issues/6810))
* Updated ask people to contribute documentation ([#6739](https://github.com/librenms/librenms/issues/6739))
* Reorganize auto-discovery docs and add a little info ([#6875](https://github.com/librenms/librenms/issues/6875))

#### Devices
* Added support for Radwin 5000 Series ([#6876](https://github.com/librenms/librenms/issues/6876))
* Added support for Chatsworth PDU (legacy old pdus not sure model number) ([#6833](https://github.com/librenms/librenms/issues/6833))
* Added detection for Microsemi PowerDsine PoE Midspans ([#6843](https://github.com/librenms/librenms/issues/6843))
* Added additional sensors to Axis camera ([#6827](https://github.com/librenms/librenms/issues/6827))
* Added Quanta lb6m device support ([#6816](https://github.com/librenms/librenms/issues/6816))
* Added hardware and version from AirOS 8.x ([#6802](https://github.com/librenms/librenms/issues/6802))
* Added support for processor and memory for 3com devices ([#6823](https://github.com/librenms/librenms/issues/6823))
* Added state sensors to HP Procurve ([#6814](https://github.com/librenms/librenms/issues/6814))
* Added detection for Atal Ethernetprobe ([#6778](https://github.com/librenms/librenms/issues/6778))
* Updated vmware vcsa hardware/version detection  ([#6783](https://github.com/librenms/librenms/issues/6783))
* Added C.H.I.P. power monitor ([#6763](https://github.com/librenms/librenms/issues/6763))
* Updated cisco-iospri to check for numeric + named ifType and included new cisco mibs ([#6776](https://github.com/librenms/librenms/issues/6776))
* Added detection for Arris C4c ([#6662](https://github.com/librenms/librenms/issues/6662))
* Added Current Connections Graph for Cisco WSA ([#6734](https://github.com/librenms/librenms/issues/6734))
* Added detection for AXIS Audio Appliances ([#6830](https://github.com/librenms/librenms/issues/6830))
* Added basic support for CradlePoint WiPipe Cellular Broadband Routers ([#6695](https://github.com/librenms/librenms/issues/6695))
* Added Avaya VSP Temperature Support ([#6692](https://github.com/librenms/librenms/issues/6692))
* Added support for ADVA FSP150CC and FSP3000R7 Series ([#6696](https://github.com/librenms/librenms/issues/6696))
* Updated Oracle ILOM detection ([#6779](https://github.com/librenms/librenms/issues/6779))
* Added Cisco ASR, Nexus, etc. PSU State sensor ([#6790](https://github.com/librenms/librenms/issues/6790))
* Updated Cisco NX-OS detection ([#6796](https://github.com/librenms/librenms/issues/6796))
* Added more detection for Bintec smart devices ([#6780](https://github.com/librenms/librenms/issues/6780))
* Added support for Schneider PowerLogic ([#6809](https://github.com/librenms/librenms/issues/6809))
* Updated Cisco Unified CM detection and renamed to ucos ([#6813](https://github.com/librenms/librenms/issues/6813))
* Added basic Support for Benu OS ([#6857](https://github.com/librenms/librenms/issues/6857))

#### WebUI
* Added "system name" for the "Services list" ([#6873](https://github.com/librenms/librenms/issues/6873))
* Allow editing and deleting of lapsed alert schedules ([#6878](https://github.com/librenms/librenms/issues/6878))
* Add bootgrid for authlog page, and fix poll-log searchbar layout on smaller screens ([#6805](https://github.com/librenms/librenms/issues/6805))
* Updated all tables to have the same set number of items showing ([#6798](https://github.com/librenms/librenms/issues/6798))
* Allow iframe in notes widget ([#6773](https://github.com/librenms/librenms/issues/6773))
* Load google maps js library only if globe map widget is used
* Added service alert rules ([#6772](https://github.com/librenms/librenms/issues/6772))
* Added syslog auth failure to alert_rules.json ([#6847](https://github.com/librenms/librenms/issues/6847))
* Fixed dashboard slowness with offline browser ([#6718](https://github.com/librenms/librenms/issues/6718))
* Update graphs to use safer RRD check ([#6781](https://github.com/librenms/librenms/issues/6781))
* Populate a sorted device list ([#6781](https://github.com/librenms/librenms/issues/6781))

#### Alerts
* Added elasticsearch transport and docs ([#6797](https://github.com/librenms/librenms/issues/6797))
* Update irc transport to use templates ([#6758](https://github.com/librenms/librenms/issues/6758))

#### API
* Added search by os to list_devices ([#6861](https://github.com/librenms/librenms/issues/6861))

#### Refactor
* Discovery code cleanups ([#6856](https://github.com/librenms/librenms/issues/6856))

---

## 1.28
*(2017-05-28)*

#### Features
* Update Juniper MSS Support ([#6565](https://github.com/librenms/librenms/issues/6565))
* Added ability to whitelist ifDescr values from being ignored with good_if ([#6584](https://github.com/librenms/librenms/issues/6584))
* Added additional Unbound chart for query cache info ([#6574](https://github.com/librenms/librenms/issues/6574))
* Wireless Sensors Overhaul ([#6471](https://github.com/librenms/librenms/pull/6471))
* Updated BIND application ([#6218](https://github.com/librenms/librenms/issues/6218))
* Added script (scripts/test-template.php) to test alert templates ([#6631](https://github.com/librenms/librenms/issues/6631))
* Improve Juniper MSS Support ([#6565](https://github.com/librenms/librenms/issues/6565))

#### Bugfixes
* Added dell to mib_dir for windows / linux ([#6726](https://github.com/librenms/librenms/issues/6726))
* Fix marking invalid ports as deleted in discovery ([#6665](https://github.com/librenms/librenms/issues/6665))
* Improve authentication load time and security ([#6615](https://github.com/librenms/librenms/issues/6615))
* Page/graph load speed: part 1 ([#6611](https://github.com/librenms/librenms/issues/6611))
* Fixed radius debug mode ([#6623](https://github.com/librenms/librenms/issues/6623))
* Actives PRI calls on Cisco can be an array ([#6607](https://github.com/librenms/librenms/issues/6607))
* MySQL app graphs with rrdcached ([#6608](https://github.com/librenms/librenms/issues/6608))
* Fix issue with wireless sensors when there are too many oids ([#6578](https://github.com/librenms/librenms/issues/6578))
* Fix GE UPS voltage factor ([#6558](https://github.com/librenms/librenms/issues/6558))
* Try to fix load for eaton-mgeups ([#6566](https://github.com/librenms/librenms/issues/6566))
* Validate prefer capabilities over suid for fping ([#6644](https://github.com/librenms/librenms/issues/6644))
* When force adding devices with v3, actually store the details ([#6691](https://github.com/librenms/librenms/issues/6691))
* Fixed uptime detection ([#6705](https://github.com/librenms/librenms/issues/6705))

#### Documentation
* Create code of conduct page ([#6640](https://github.com/librenms/librenms/issues/6640))
* Add all current wireless types. ([#6603](https://github.com/librenms/librenms/issues/6603))
* Added seconds is the time unit. ([#6589](https://github.com/librenms/librenms/issues/6589))

#### Refactoring
* Added lock support to ./discovery.php -h new to prevent overlap ([#6568](https://github.com/librenms/librenms/issues/6568))
* OS discovery tests are now dynamic ([#6555](https://github.com/librenms/librenms/issues/6555))
* DB Updates will now file level lock to stop duplicate updates ([#6469](https://github.com/librenms/librenms/issues/6469))
* Increased speed of loading syslog pages ([#6433](https://github.com/librenms/librenms/issues/6433))
* Moved default alert rules into the collection ([#6621](https://github.com/librenms/librenms/issues/6621))
* Modest speedup to database config population ([#6636](https://github.com/librenms/librenms/issues/6636))
* Pretty mysql for alerts breaks regex rules ([#6614](https://github.com/librenms/librenms/issues/6614))
* Updated vlan discovery to support JunOS ([#6597](https://github.com/librenms/librenms/issues/6597))

#### Devices
* Added Wireless Support For Cisco IOS-XE([#6724](https://github.com/librenms/librenms/pull/6724))
* Improve Aerohive Support ([#6721](https://github.com/librenms/librenms/issues/6721))
* Added support for Halon Gateway ([#6716](https://github.com/librenms/librenms/issues/6716))
* Added basic HPE OpenVMS detection ([#6706](https://github.com/librenms/librenms/issues/6706))
* Added additional sensor state sysCmSyncStatusId for F5
* Added more health information for APC units ([#6619](https://github.com/librenms/librenms/issues/6619))
* Updated Lancom LCOS detection ([#6651](https://github.com/librenms/librenms/issues/6651))
* Added 3 Phase APC UPS Support [#2733](https://github.com/librenms/librenms/issues/2733) & [#5504](https://github.com/librenms/librenms/issues/5504) ([#5558](https://github.com/librenms/librenms/issues/5558))
* Added FWSM recognition to PIX OS ([#6569](https://github.com/librenms/librenms/issues/6569))
* Aruba Instant AP wireless sensor support (Freq, NoiseFloor, Power, Util) ([#6564](https://github.com/librenms/librenms/issues/6564))
* Added CPU and Memory pool for BDCom Switchs ([#6523](https://github.com/librenms/librenms/issues/6523))
* Added support for Aruba ClearPass devices ([#6528](https://github.com/librenms/librenms/issues/6528))
* Added support for Cisco's AsyncOS ([#6545](https://github.com/librenms/librenms/issues/6545))
* Added support for AKCP SecurityProbe ([#6550](https://github.com/librenms/librenms/issues/6550))
* Added support for GE UPS (#6549) ([#6553](https://github.com/librenms/librenms/issues/6553))
* Improve Extremeware and XOS detection ([#6554](https://github.com/librenms/librenms/issues/6554))
* Added more sensors for Exalt ExtendAir devices ([#6531](https://github.com/librenms/librenms/issues/6531))
* Added support for Terra sti410C ([#6598](https://github.com/librenms/librenms/issues/6598))
* Make TiMOS detection more generic, rebrand to Nokia ([#6645](https://github.com/librenms/librenms/issues/6645))
* Added HPE RT3000 UPS support ([#6638](https://github.com/librenms/librenms/issues/6638))
* Added Enhance Barracuda NG Firewall Detection ([#6658](https://github.com/librenms/librenms/issues/6658))
* Added support for Geist PDU ([#6646](https://github.com/librenms/librenms/issues/6646))
* Improved Lancom LCOS detection, added LCOS-MIB ([#6651](https://github.com/librenms/librenms/issues/6651))
* Added Basic Cisco SCE Support ([#6666](https://github.com/librenms/librenms/issues/6666))
* Added support for MRV OptiDriver Optical Transport Platform ([#6656](https://github.com/librenms/librenms/issues/6656))
* Update comware version and serial number polling ([#6686](https://github.com/librenms/librenms/issues/6686))
* Added TiMOS temperature and power supply state sensors ([#6657](https://github.com/librenms/librenms/issues/6657))
* Added state support FAN and Power Supply for Avaya VSP ([#6693](https://github.com/librenms/librenms/issues/6693))
* Added detection for Cisco EPC devices ([#6690](https://github.com/librenms/librenms/issues/6690))
* Added Wireless Support For Cisco IOS-XE ([#6724](https://github.com/librenms/librenms/issues/6724))

#### WebUI
* Make login form more mobile-friendly ([#6707](https://github.com/librenms/librenms/issues/6707))
* Updated link to peeringdb to use asn ([#6625](https://github.com/librenms/librenms/issues/6625))
* Disabled settings button for Shared (read) dashboards if you are not the owner ([#6596](https://github.com/librenms/librenms/issues/6596))
* Split apart max and min sensor limits, allows sorting ([#6592](https://github.com/librenms/librenms/issues/6592))
* Load device list for dropdowns using Ajax ([#6557](https://github.com/librenms/librenms/issues/6557))
* Updated remaining display options where we do not show sysName if hostname is IP ([#6585](https://github.com/librenms/librenms/issues/6585))

#### Security
* Remove possibility of xss in Oxidized and RIPE searches ([#6595](https://github.com/librenms/librenms/issues/6595))

#### Alerting
* Added option to enable/disable option for sending alerts to normal users ([#6590](https://github.com/librenms/librenms/issues/6590))
* Added HipChat v2 API + Color Changes ([#6669](https://github.com/librenms/librenms/issues/6669))

---

## 1.27
*(2017-04-29)*

#### Features
* Added sdfsinfo application support ([#6494](https://github.com/librenms/librenms/issues/6494))
* Allow _except suffix in yaml os discovery ([#6444](https://github.com/librenms/librenms/issues/6444))
* Added check_mssql_health.inc.php for service checks ([#6415](https://github.com/librenms/librenms/issues/6415))
* Added rrdtool version check to compare installed version with defined version ([#6381](https://github.com/librenms/librenms/issues/6381))
* Added ability to validate database schema ([#6303](https://github.com/librenms/librenms/issues/6303))
* Support powerdns-recursor SNMP extend ([#6290](https://github.com/librenms/librenms/issues/6290))
* Added cisco-vpdn to poller modules ([#6300](https://github.com/librenms/librenms/issues/6300))
* Support non-standard unix socket ([#5724](https://github.com/librenms/librenms/issues/5724))
* Added multi DB support to the Postgres app ([#6222](https://github.com/librenms/librenms/issues/6222))
* Added opengridscheduler job tracker ([#6419](https://github.com/librenms/librenms/issues/6419))
* Added location map regex replace pattern only ([#6485](https://github.com/librenms/librenms/issues/6485))
* Added nfs-server application ([#6320](https://github.com/librenms/librenms/issues/6320))
* Added support for Active Directory bind user ([#6255](https://github.com/librenms/librenms/pull/6255))

#### Bugfixes
* Actually reload oxidized when we should not when we think we should ([#6515](https://github.com/librenms/librenms/issues/6515))
* Don't run ipmitool without knowing a type  ([#6504](https://github.com/librenms/librenms/issues/6504))
* Updated ipv4/ipv6 discovery to exclude IPs with invalid port_ids ([#6495](https://github.com/librenms/librenms/issues/6495))
* Updated enterasys mempools disco/polling to support multiple ram devices ([#6458](https://github.com/librenms/librenms/issues/6458))
* Service filenames are snipped when longer than 16 characters ([#6459](https://github.com/librenms/librenms/issues/6459))
* Updated use of ifNameDescr() to cleanPort() ([#6454](https://github.com/librenms/librenms/issues/6454))
* Allow line returns in snmprec files with the 4x data type ([#6443](https://github.com/librenms/librenms/issues/6443))
* Update Shebangs and daily.sh for FreeBSD compatibility ([#6413](https://github.com/librenms/librenms/issues/6413))
* Cisco Entity Sensor Threshold's returns 0 ([#6440](https://github.com/librenms/librenms/issues/6440))
* Updated enterasys proc discovery by setting correct index ([#6422](https://github.com/librenms/librenms/issues/6422))
* Allow unit tests without a sql server ([#6398](https://github.com/librenms/librenms/issues/6398))
* Fix broken mysql application polling ([#6317](https://github.com/librenms/librenms/issues/6317))
* Move user preferences dashboard and twofactor out of users table ([#6286](https://github.com/librenms/librenms/issues/6286))
* Fixed CPU/Mem polling for Cyberoam-UTM devices ([#6315](https://github.com/librenms/librenms/issues/6315))
* Fixed F5 ports not using hc counters ([#6294](https://github.com/librenms/librenms/issues/6294))
* Added semicolons in build.sql schema file ([#6284](https://github.com/librenms/librenms/issues/6284))
* Fixed height of widget boxes ([#6282](https://github.com/librenms/librenms/issues/6282))
* Update applications poller to use numeric oid instead of nsExtendOutputFull ([#6277](https://github.com/librenms/librenms/issues/6277))
* Compare existing device ip to host lookup like for like ([#6316](https://github.com/librenms/librenms/issues/6316))
* Fix whitespace display on RRDTool Command ([#6345](https://github.com/librenms/librenms/issues/6345))
* Vlan port mappings not removed ([#6423](https://github.com/librenms/librenms/issues/6423))
* Fix alerts not honouring interval over 5m ([#6438](https://github.com/librenms/librenms/issues/6438))
* Improve CiscoSB polling time ([#6447](https://github.com/librenms/librenms/issues/6447))
* Updated cisco and juniper component macros to exclude disabled sensors ([#6493](https://github.com/librenms/librenms/issues/64649393))
* Added more safety checking into create_state_index() ([#6516](https://github.com/librenms/librenms/issues/6516))
* Fixed inconsistent device discovery ([#6518](https://github.com/librenms/librenms/issues/6518))
* Fixed notifications by email to Active Directory admins ([#6134](https://github.com/librenms/librenms/issues/6134))
* Fixed API token for Active Directory admins ([#6255](https://github.com/librenms/librenms/issues/6255))

#### Documentation
* Added FAQ on what disabled/ignored means for devices
* Updated install docs + perf to support compressing file types and using http/2 ([#6466](https://github.com/librenms/librenms/issues/6466))
* Update install docs to remove deprecated GRANT usage
* Update to remove the old method of signing the CLA ([#6479](https://github.com/librenms/librenms/issues/6479))
* Updated Support-New-OS doc to provide clearer information ([#6492](https://github.com/librenms/librenms/issues/6492))

#### Refactoring
* Use sysDescr to simplify the vyatta detection ([#6455](https://github.com/librenms/librenms/issues/6455))
* Move siklu os detection to yaml ([#6431](https://github.com/librenms/librenms/issues/6431))
* Move rfc1628_compat into os yaml ([#6424](https://github.com/librenms/librenms/issues/6424))
* Move Engenius discovery to yaml ([#6428](https://github.com/librenms/librenms/issues/6428))
* Move cometsystem-p85xx ([#6427](https://github.com/librenms/librenms/issues/6427))
* Update some snmpwalks for ports polling to improve speed ([#6341](https://github.com/librenms/librenms/issues/6341))
* Moved ifLabel -> cleanPort and updated the usage ([#6288](https://github.com/librenms/librenms/issues/6288))
* Update ucd-diskio discovery to use index + descr as unique identifies [#4670](https://github.com/librenms/librenms/issues/4670) ([#6270](https://github.com/librenms/librenms/issues/6270))
* Changed MGE UPS to APC UPS (mgeups -> apc) ([#6260](https://github.com/librenms/librenms/issues/6260))
* Change Cisco UCM category from tele to collaboration ([#6297](https://github.com/librenms/librenms/issues/6297))
* Move aos discovery to yaml ([#6425](https://github.com/librenms/librenms/issues/6425))
* Move the rest of avaya os detection to yaml ([#6426](https://github.com/librenms/librenms/issues/6426))
* Move cometsystem-p85xx to yaml ([#6427](https://github.com/librenms/librenms/issues/6427))
* Move Engenius discovery to yaml ([#6428](https://github.com/librenms/librenms/issues/6428))
* Added 'Video' device group and moved Axis cameras to this group' ([#6397](https://github.com/librenms/librenms/issues/6397))
* Remove unecessary OS checks in proc / mem polling ([#6414](https://github.com/librenms/librenms/issues/6414))
* Only run pre-cache for the current OS ([#6453](https://github.com/librenms/librenms/issues/6453))
* Move ios detection to yaml using new sysDescr_except ([#6460](https://github.com/librenms/librenms/issues/6460))
* Eaton/MGE UPS reorganization ([#6388](https://github.com/librenms/librenms/issues/6388))

#### Devices
* Added more health sensors for c&c power commanders ([#6517](https://github.com/librenms/librenms/issues/6517))
* Added support for Tycon Systems TPDIN units ([#6506](https://github.com/librenms/librenms/issues/6506))
* Added basic detection for Packetflux SiteMonitor ([#6498](https://github.com/librenms/librenms/issues/6498))
* Added detection for Ericsson UPC devices ([#6472](https://github.com/librenms/librenms/issues/6472))
* Added basic detection for Geist Watchdog ([#6467](https://github.com/librenms/librenms/issues/6467))
* Added support for enLogic PDUs ([#6464](https://github.com/librenms/librenms/issues/6464))
* Added support for Eltex OLT devices ([#6457](https://github.com/librenms/librenms/issues/6457))
* Added Etherwan managed switches ([#6488](https://github.com/librenms/librenms/issues/6488))
* Added signal sensor for opengear devices ([#6401](https://github.com/librenms/librenms/issues/6401))
* Added support for Teradici PCoIP card ([#6347](https://github.com/librenms/librenms/issues/6347))
* Added basic support for Omnitron iConverters ([#6336](https://github.com/librenms/librenms/issues/6336))
* Added support for AvediaStream Encoder ([#6306](https://github.com/librenms/librenms/issues/6306))
* Added ArubaOS PowerConnect detection ([#6463](https://github.com/librenms/librenms/issues/6463))
* Added HPE iPDU detection ([#6334](https://github.com/librenms/librenms/issues/6334))
* Moved dnos health disco to powerconnect ([#6331](https://github.com/librenms/librenms/issues/6331))
* Added Nokia (Alcatel-Lucent) SAS-Sx 7210 support ([#6344](https://github.com/librenms/librenms/issues/6344))
* Added Opengear ACM7008 detection ([#6349](https://github.com/librenms/librenms/issues/6349))
* Added detection fro Juniper MSS ([#6335](https://github.com/librenms/librenms/issues/6335))
* Added sensors + additional info for HPE iPDU ([#6382](https://github.com/librenms/librenms/issues/6382))
* Added Basic Ciena (Cyan) Z-Series detection ([#6385](https://github.com/librenms/librenms/issues/6385))
* Added Coriant Network Hardware Page. ([#6187](https://github.com/librenms/librenms/issues/6187))
* Added support for Vanguard ApplicationsWare ([#6387](https://github.com/librenms/librenms/issues/6387))
* Added ICT Digital Power Supply support ([#6369](https://github.com/librenms/librenms/issues/6369))
* Added ICT DC Distribution Panel support ([#6379](https://github.com/librenms/librenms/issues/6379))
* Added more detection for Comware ([#6386](https://github.com/librenms/librenms/issues/6386))
* Added Multi-lane optics on Juniper equipment ([#6377](https://github.com/librenms/librenms/issues/6377))
* Added detection and sensor support for EMC OneFS v8 ([#6416](https://github.com/librenms/librenms/issues/6416))
* Added detection for IgniteNet HeliOS ([#6417](https://github.com/librenms/librenms/issues/6417))
* Added basic detection for Tandberg Magnum tape units ([#6421](https://github.com/librenms/librenms/issues/6421))
* Added detection for Ciena packet switches ([#6462](https://github.com/librenms/librenms/issues/6462))
* Added Cisco SG355-10P support ([#6477](https://github.com/librenms/librenms/issues/6477))
* Added mem/cpu support for TiMOS ([#6483](https://github.com/librenms/librenms/issues/6483))
* Added support for C&C Commander Plus units ([#6478](https://github.com/librenms/librenms/issues/6478))
* Added Equallogic add disk status ([#6497](https://github.com/librenms/librenms/issues/6497))

#### WebUI
* Updated bgp table to use bootstrap properly ([#6406](https://github.com/librenms/librenms/issues/6406))
* Update poller_modules_perf to not show OS disabled module graphs ([#6276](https://github.com/librenms/librenms/issues/6276))
* Select the correct dashboard when there are no defaults. ([#6339](https://github.com/librenms/librenms/issues/6339))
* Fix redirect on login for instances behind reverse proxies ([#6371](https://github.com/librenms/librenms/issues/6371))
* Fixed the display date for the current version ([#6474](https://github.com/librenms/librenms/issues/6474))

#### API
* Allow cidr network searches of the ARP table ([#6378](https://github.com/librenms/librenms/issues/6378))

---

## 1.26
*(2017-03-25)*

#### Features
* Added syslog alert transport ([#6246](https://github.com/librenms/librenms/issues/6246))
* Send collected data to graphite server ([#6201](https://github.com/librenms/librenms/issues/6201))
* Added SMART application support ([#6181](https://github.com/librenms/librenms/issues/6181))
* Peeringdb integration to show the Exchanges and peers for your AS' ([#6178](https://github.com/librenms/librenms/issues/6178))
* Added support for sending alerts to Telegram [#2114](https://github.com/librenms/librenms/issues/2114) ([#6202](https://github.com/librenms/librenms/issues/6202))
* Added pbin.sh to upload text to p.libren.ms ([#6175](https://github.com/librenms/librenms/issues/6175))
* Added better BGP support for Arista ([#6046](https://github.com/librenms/librenms/issues/6046))
* Added rrd step conversion script ([#6081](https://github.com/librenms/librenms/issues/6081))
* Store the username in eventlog for any entries created through the Webui ([#6032](https://github.com/librenms/librenms/issues/6032))
* Added Nvidia GPU  application support ([#6024](https://github.com/librenms/librenms/issues/6024))
* Added Squid application support ([#6011](https://github.com/librenms/librenms/issues/6011))
* Added FreeBSD NFS Client/Server application support ([#6008](https://github.com/librenms/librenms/issues/6008))
* Added get_disks function ([#6058](https://github.com/librenms/librenms/issues/6058))
* Updated Nfsen integration support ([#6003](https://github.com/librenms/librenms/issues/6003))
* Added Basic Oxidized Node List ([#6017](https://github.com/librenms/librenms/issues/6017))
* Added support for dynamic interfaces in ifAlias script ([#6005](https://github.com/librenms/librenms/issues/6005))
* Added support Postfix application ([#6002](https://github.com/librenms/librenms/pull/6002))
* Added Postgres application support ([#6004](https://github.com/librenms/librenms/pull/6004))
* Added ability to show links to fixes for validate ([#6054](https://github.com/librenms/librenms/pull/6054))
* Added FreeBSD NFS Client/Server application support ([#6008](https://github.com/librenms/librenms/pull/6008))
* Added Squid application support ([#6011](https://github.com/librenms/librenms/pull/6011))
* Added Nvidia GPU application support ([#6024](https://github.com/librenms/librenms/pull/6024))
* Added app_state support for applications #5068 ([#6061](https://github.com/librenms/librenms/pull/6061))
* Send default mail when no email destinations found ([#6165](https://github.com/librenms/librenms/pull/6165))
* Added new alert rules to collection ([#6166](https://github.com/librenms/librenms/pull/6166))
* Added SMART app support ([#6181](https://github.com/librenms/librenms/pull/6181))
* Added Application discovery ([#6143](https://github.com/librenms/librenms/pull/6143))
* Added syslog alert transport and docs ([#6246](https://github.com/librenms/librenms/pull/6246))

#### Bugfixes
* Clear out stale alerts ([#6268](https://github.com/librenms/librenms/issues/6268))
* Remove min value for ntp* graphs [#6240](https://github.com/librenms/librenms/issues/6240)
* Alerts that worsen or get better will now record updated info [#4323](https://github.com/librenms/librenms/issues/4323) ([#6203](https://github.com/librenms/librenms/issues/6203))
* Do not show overview graphs when user only has port permissions for device ([#6230](https://github.com/librenms/librenms/issues/6230))
* Yaml files for edgeos and edgeswitch ([#6208](https://github.com/librenms/librenms/issues/6208))
* Fix Liebert humidity and temp sensors [#6196](https://github.com/librenms/librenms/issues/6196) ([#6198](https://github.com/librenms/librenms/issues/6198))
* Graphs $auth check was too strict ([#6195](https://github.com/librenms/librenms/issues/6195))
* Alter the database to set the proper character set and collation ([#6189](https://github.com/librenms/librenms/issues/6189))
* Wrong NetBotz file location ([#6188](https://github.com/librenms/librenms/issues/6188))
* Change rfc1628 'state' (est. runtime and on battery) to runtime ([#6158](https://github.com/librenms/librenms/issues/6158))
* Fix the displaying of alert info for historical alerts [#6092](https://github.com/librenms/librenms/issues/6092) ([#6107](https://github.com/librenms/librenms/issues/6107))
* Record actual sensor value for unix-agent hddtemp [#5904](https://github.com/librenms/librenms/issues/5904) ([#6089](https://github.com/librenms/librenms/issues/6089))
* Ping perf is in milliseconds, not seconds ([#6140](https://github.com/librenms/librenms/issues/6140))
* SVG scaling issues in Internet Explorer ([#6021](https://github.com/librenms/librenms/issues/6021))
* Old / duplicate sensors would never be removed, this is fixed by setting the $type correctly [#6044](https://github.com/librenms/librenms/issues/6044) ([#6079](https://github.com/librenms/librenms/issues/6079))
* Refactor ipoman cache code to use pre-cache in sensors [#5881](https://github.com/librenms/librenms/issues/5881) ([#5983](https://github.com/librenms/librenms/issues/5983))
* Fixed the previous graphs for diskio/bits [#6077](https://github.com/librenms/librenms/issues/6077) ([#6083](https://github.com/librenms/librenms/issues/6083))
* Update OSTicket transport to use the from email address [#5739](https://github.com/librenms/librenms/issues/5739) ([#5927](https://github.com/librenms/librenms/issues/5927))
* Do not try and only include files once when they are needed again! ([#5881](https://github.com/librenms/librenms/issues/5881))
* Correct the use of GetContacts() #5012 ([#6059](https://github.com/librenms/librenms/pull/6059))
* Netonix: properly set default fanspeed limits ([#6144](https://github.com/librenms/librenms/pull/6144))
* Fix Generex load sensor divisor ([#6155](https://github.com/librenms/librenms/pull/6155))
* Sensors not being removed from database ([#6169](https://github.com/librenms/librenms/pull/6169))
* Updated http-auth to work with nginx http auth #6102 ([#6174](https://github.com/librenms/librenms/pull/6174))
* Change rfc1628 'state' (est. runtime and on battery) to runtime ([#6158](https://github.com/librenms/librenms/pull/6158))

#### Documentation
* Renamed the mysql extend script to just mysql ([#6126](https://github.com/librenms/librenms/issues/6126))

#### Refactoring
* Move some DNOS detection to PowerConnect [#6150](https://github.com/librenms/librenms/issues/6150) ([#6206](https://github.com/librenms/librenms/issues/6206))
* Rename check_domain_expire.inc.php to check_domain.inc.php ([#6238](https://github.com/librenms/librenms/issues/6238))
* Further speed improvements to port poller ([#6037](https://github.com/librenms/librenms/issues/6037))

#### Devices
* Added Rx levels on Ubiquiti Airfibre ([#6160](https://github.com/librenms/librenms/issues/6160))
* Added detection for Hirschmann Railswitch [#6161](https://github.com/librenms/librenms/issues/6161) ([#6207](https://github.com/librenms/librenms/issues/6207))
* Support for Netscaler SDX appliances ([#6249](https://github.com/librenms/librenms/issues/6249))
* Added discovery of Cyclades ACS ([#6234](https://github.com/librenms/librenms/issues/6234))
* Added additional sensors for Liebert / Vertiv [#5369](https://github.com/librenms/librenms/issues/5369) ([#6123](https://github.com/librenms/librenms/issues/6123))
* Added state detection for Dell TL4k [#2752](https://github.com/librenms/librenms/issues/2752)
* Added support for Cyberpower PDU ([#6013](https://github.com/librenms/librenms/issues/6013))
* Added support for Digipower PDU ([#6014](https://github.com/librenms/librenms/issues/6014))
* Basic Lantronix UDS support ([#6042](https://github.com/librenms/librenms/issues/6042))
* Added detection for more Dell switches ([#6048](https://github.com/librenms/librenms/issues/6048))
* Added HPE Comware Processor Discovery ([#6029](https://github.com/librenms/librenms/issues/6029))
* Added Basic FortiWLC Support ([#6016](https://github.com/librenms/librenms/issues/6016))
* Added support for F5 Traffic Management Module mempool ([#6076](https://github.com/librenms/librenms/pull/6076))
* Added new Planet switch ([#6085](https://github.com/librenms/librenms/pull/6085))
* Added state detection for Dell TL4k ([#6094](https://github.com/librenms/librenms/pull/6094))
* Added extrahop detection ([#6097](https://github.com/librenms/librenms/pull/6097))
* Updated 3com switch detection ([#6114](https://github.com/librenms/librenms/pull/6114))
* Improved APC NetBotz Support ([#6157](https://github.com/librenms/librenms/pull/6157))
* Added state support for HP servers #5113 ([#6124](https://github.com/librenms/librenms/pull/6124))
* Added Coriant support ([#6026](https://github.com/librenms/librenms/pull/6026))
* Basic Zebra Print Server detection ([#6162](https://github.com/librenms/librenms/pull/6162))
* Added state sensor support for RFC1628 UPS ([#6153](https://github.com/librenms/librenms/pull/6153))
* Added APC NetBotz State Sensor Support ([#6167](https://github.com/librenms/librenms/pull/6167))
* Updated Sonus SBC os detection #6241 ([#6243](https://github.com/librenms/librenms/pull/6243))
* Added discovery of Cyclades ACS 6000 ([#6234](https://github.com/librenms/librenms/pull/6234))

#### WebUI
* Do not show disabled devices in alerts list as they stale [#6213](https://github.com/librenms/librenms/issues/6213) ([#6263](https://github.com/librenms/librenms/issues/6263))
* Create correct link for BGP peers [#5958](https://github.com/librenms/librenms/issues/5958)
* Update device overview to not show hostname when certain conditions match [#5984](https://github.com/librenms/librenms/issues/5984) ([#6091](https://github.com/librenms/librenms/issues/6091))
* Display sysnames/hostnames instead of ip addresses [#4155](https://github.com/librenms/librenms/issues/4155)
* Fix BGP Icon for global search [#6031](https://github.com/librenms/librenms/issues/6031)
* Generex: more helpful overview graphs ([#6154](https://github.com/librenms/librenms/issues/6154))
* Added ability to set warning percentage for CPU and mempools ([#5901](https://github.com/librenms/librenms/pull/5901))
* Stop autorefresh on bill edit page #6182 ([#6193](https://github.com/librenms/librenms/pull/6193))
* Allow remember_token to be null ([#6231](https://github.com/librenms/librenms/pull/6231))
* Set the from / to for graphs in the devices list #6262 ([#6264](https://github.com/librenms/librenms/pull/6264))

#### Security
* Stop multiport_bits_separate graphs for showing regardless of auth [#6101](https://github.com/librenms/librenms/issues/6101) ([#6109](https://github.com/librenms/librenms/issues/6109))

#### API
* Expose ports in API requests for bills ([#6069](https://github.com/librenms/librenms/issues/6069))
* Added new route for multiport bit graphs + asn list_bgp filter ([#6129](https://github.com/librenms/librenms/issues/6129))

---

## 1.25
*(2017-02-26)*

#### Features
* Add fail2ban application support ([#5924](https://github.com/librenms/librenms/issues/5924))
* Add additional service checks ([#5941](https://github.com/librenms/librenms/issues/5941))
* Added phpunit db setup tests ([#5594](https://github.com/librenms/librenms/issues/5594))
* Updated rrdcached stats app to support Fedora/Centos ([#5768](https://github.com/librenms/librenms/issues/5768))
* Added Cisco Spark Transport [#3182](https://github.com/librenms/librenms/issues/3182)
* Rancid config file generator ([#5689](https://github.com/librenms/librenms/issues/5689))
* Added Rocket.Chat transport [#5427](https://github.com/librenms/librenms/issues/5427)
* Added SMSEagle transport [#5989](https://github.com/librenms/librenms/pull/5989)
* Added generic hardware rewrite function
* Collect sysDescr and sysObjectID for stats to improve os detection ([#5510](https://github.com/librenms/librenms/issues/5510))
* Update Debian's guestId for VMware ([#5669](https://github.com/librenms/librenms/issues/5669))
* Allow customisation of rrd step/heartbeat when creating new rrd files ([#5947](https://github.com/librenms/librenms/pull/5947))
* Added ability to output graphs as svg ([#5959](https://github.com/librenms/librenms/pull/5959)) 
* Improve ports polling when ports are still down or marked deleted ([#5805](https://github.com/librenms/librenms/pull/5805)) 

#### Bugfixes
* Syslog, pull out pam program source ([#5942](https://github.com/librenms/librenms/issues/5942))
* Load wifi module for sub10 OS ([#5963](https://github.com/librenms/librenms/issues/5963))
* Show sysName on network map when ip_to_sysname enabled ([#5962](https://github.com/librenms/librenms/issues/5962))
* Exim queue graph ([#5945](https://github.com/librenms/librenms/issues/5945))
* Updated qnap sensor code to be more generic [#5910](https://github.com/librenms/librenms/issues/5910) ([#5925](https://github.com/librenms/librenms/issues/5925))
* Remove the non-functional buttons for non-admins in devices/services ([#5856](https://github.com/librenms/librenms/issues/5856))
* Various variables will all be updated if they are blank [#5811](https://github.com/librenms/librenms/issues/5811) ([#5836](https://github.com/librenms/librenms/issues/5836))
* Patch generic_multi graph to fix legend overflow [#5766](https://github.com/librenms/librenms/issues/5766)
* Update lmsensors temp sensors to support 0c values so they do not get removed [#5363](https://github.com/librenms/librenms/issues/5363) ([#5823](https://github.com/librenms/librenms/issues/5823))
* Update macros with / in to have spaces ([#5741](https://github.com/librenms/librenms/issues/5741))
* Added the service parameter to checks that were missing it ([#5753](https://github.com/librenms/librenms/issues/5753))
* Ignore ports where we only have two entries in the array, this signals bad data [#1366](https://github.com/librenms/librenms/issues/1366) ([#5722](https://github.com/librenms/librenms/issues/5722))
* Fixed system temperature from ipmi descr including a space at the end
* Incorrect hostname in the mouse-over of the services in the availability-map [#5734](https://github.com/librenms/librenms/issues/5734)
* Mono theme panel headers black ([#5705](https://github.com/librenms/librenms/issues/5705))
* Make about page toggle look better for zoomed in browsers [#5219](https://github.com/librenms/librenms/issues/5219) ([#5680](https://github.com/librenms/librenms/issues/5680))
* Ignore toners with values -2 which is unknown [#5637](https://github.com/librenms/librenms/issues/5637) ([#5654](https://github.com/librenms/librenms/issues/5654))
* Check lat/lng are numeric rather than !empty [#5585](https://github.com/librenms/librenms/issues/5585) ([#5657](https://github.com/librenms/librenms/issues/5657))
* Fix device edit health update icons ([#5996](https://github.com/librenms/librenms/issues/5996))
* Service module has conflicted configuration files ([#5903](https://github.com/librenms/librenms/issues/5903))
* addhost.php throw proper exception when database add fails ([#5972](https://github.com/librenms/librenms/pull/5972))
* Fix snmpbulkwalk in ifAlias script ([#5547](https://github.com/librenms/librenms/pull/5688))
* Arista watts to dbm conversion ([#5773](https://github.com/librenms/librenms/pull/5773))
* Poll DCN stats using OIDS ([#5785](https://github.com/librenms/librenms/issues/5785))
* Updated qnap sensor code to be more generic ([#5229](https://github.com/librenms/librenms/issues/5229))

#### Documentation
* Update Applications to use correct link for exim-stats ([#5876](https://github.com/librenms/librenms/issues/5876))
* Added info on using munin scripts [#2916](https://github.com/librenms/librenms/issues/2916) ([#5871](https://github.com/librenms/librenms/issues/5871))
* Configuring  SNMPv3 on Linux
* Updated example for using bad_if_regexp [#1878](https://github.com/librenms/librenms/issues/1878) ([#5825](https://github.com/librenms/librenms/issues/5825))
* Update Oxidized integration to show example of SELinux setup
* Update Graylog docs to clarify ssl and hostname use

#### Refactoring
* Centralise device up/down check and use in disco [#5862](https://github.com/librenms/librenms/issues/5862) ([#5897](https://github.com/librenms/librenms/issues/5897))
* Convert Hikvision discovery to yaml ([#5781](https://github.com/librenms/librenms/issues/5781))
* Various Code Cleanup ([#5777](https://github.com/librenms/librenms/issues/5777))
* Updated storing of sensors data to be used in unix-agent [#5904](https://github.com/librenms/librenms/issues/5904)
* Refactor sensor discovery ([#5550](https://github.com/librenms/librenms/pull/5550))

#### Devices
* Add Eaton UPS Charge Sensor ([#6001](https://github.com/librenms/librenms/issues/6001))
* Added CPU and memory for Entera devices [#5974](https://github.com/librenms/librenms/issues/5974)
* Added SEOS CPU discovery [#5917](https://github.com/librenms/librenms/issues/5917)
* Added further detection for CiscoSB (ex Linksys) devices ([#5922](https://github.com/librenms/librenms/issues/5922))
* Updated ibmnos support for Lenovo branded devices [#5894](https://github.com/librenms/librenms/issues/5894) ([#5920](https://github.com/librenms/librenms/issues/5920))
* Initial discovery for Vubiq Haulpass V60s[#5745](https://github.com/librenms/librenms/issues/5745)
* Added further QNAP Turbo NAS detection [#5229](https://github.com/librenms/librenms/issues/5229) ([#5804](https://github.com/librenms/librenms/issues/5804))
* Added support for Fujitsu NAS devices [#5309](https://github.com/librenms/librenms/issues/5309) ([#5816](https://github.com/librenms/librenms/issues/5816))
* Added proc, mem and sensor support for FabricOS [#5295](https://github.com/librenms/librenms/issues/5295) ([#5815](https://github.com/librenms/librenms/issues/5815))
* Added further support for Zynos / Zyxell devices [#5292](https://github.com/librenms/librenms/issues/5292) ([#5814](https://github.com/librenms/librenms/issues/5814))
* Added more Netgear detection [#5789](https://github.com/librenms/librenms/issues/5789)
* Updated DCN serial/hardware/version detection [#5785](https://github.com/librenms/librenms/issues/5785)
* Add F5 Hardware and S/N detection ([#5797](https://github.com/librenms/librenms/issues/5797))
* Improved Xerox discovery ([#5780](https://github.com/librenms/librenms/issues/5780))
* Improved Mikrotik RouterOS and SwOS detection ([#5772](https://github.com/librenms/librenms/issues/5772))
* Improved Pulse Secure detection ([#5770](https://github.com/librenms/librenms/issues/5770))
* Improved Lancom device detection ([#5758](https://github.com/librenms/librenms/issues/5758))
* improved Brocade Network OS detection ([#5756](https://github.com/librenms/librenms/issues/5756))
* improved Dell PowerConnect discovery ([#5761](https://github.com/librenms/librenms/issues/5761))
* Improved HPE Procurve/OfficeConnect discovery ([#5763](https://github.com/librenms/librenms/issues/5763))
* Improved Zyxel IES detection ([#5751](https://github.com/librenms/librenms/issues/5751))
* Improved Fortinet Fortiswitch detection ([#5747](https://github.com/librenms/librenms/issues/5747))
* Improved Brocade Fabric OS detection ([#5746](https://github.com/librenms/librenms/issues/5746))
* Added support for HPE ILO 4 ([#5726](https://github.com/librenms/librenms/issues/5726))
* Added serial, model and version support for HPE MSL ([#5667](https://github.com/librenms/librenms/issues/5667))
* Added support for Kemp Loadbalancers ([#5668](https://github.com/librenms/librenms/issues/5668))
* Additional TPLink JetStream support ([#5909](https://github.com/librenms/librenms/issues/5909))
* Additional detection for Dasan devices ([#5711](https://github.com/librenms/librenms/issue/5711))
* Added initial support for Meinberg LANTIME OS v6 ([#5719](https://github.com/librenms/librenms/pull/5719))
* Added support for Zyxel XS ([#5730](https://github.com/librenms/librenms/issues/5730))
* Added support for Exterity AvediaPlayer ([#5732](https://github.com/librenms/librenms/pull/5732))
* Added detection for OpenGear ([#5744](https://github.com/librenms/librenms/pull/5744))
* Improved support for TiMOS (Alcatel-Lucent) switches ([#5533](https://github.com/librenms/librenms/issues/5533))
* Improved Raritan detection ([#5771](https://github.com/librenms/librenms/pull/5771))
* Added Kyocera Mita support ([#5782](https://github.com/librenms/librenms/pull/5782))
* Added detection for Toshiba TEC printer's ([#5792](https://github.com/librenms/librenms/pull/5792)) 
* Added support for Cyberoam UTM devices ([#5542](https://github.com/librenms/librenms/issues/5542))
* Improved hardware detection for Xerox ([#5831](https://github.com/librenms/librenms/pull/5831))
* Added further sensor support for APC units ([#2732](https://github.com/librenms/librenms/issues/2732))
* Added detction for Mellanox i5035 infiniband switch ([#5887](https://github.com/librenms/librenms/pull/5887))
* Added detection for Powerconnect M8024-k ([#5905](https://github.com/librenms/librenms/issues/5905))
* Added detection for HPE MSA storage ([#5907](https://github.com/librenms/librenms/pull/5907))

#### WebUI
* Update services pages
* New Cumulus Logo ([#5954](https://github.com/librenms/librenms/issues/5954))
* Added link to APs for alert details [#5878](https://github.com/librenms/librenms/issues/5878) ([#5898](https://github.com/librenms/librenms/issues/5898))
* Set the device logo and cell to have a max width ([#5700](https://github.com/librenms/librenms/issues/5700))
* New eventlog severity classification ([#5830](https://github.com/librenms/librenms/issues/5830))
* Update Zyxel image (os/logos to .svg) ([#5855](https://github.com/librenms/librenms/issues/5855))
* Remove the non-functional buttons for non-admins in services ([#5833](https://github.com/librenms/librenms/issues/5833))
* Remove the ability to activate statistics for non-admins ([#5829](https://github.com/librenms/librenms/issues/5829))
* Add SVG logo/os icon for Generex UPS ([#5827](https://github.com/librenms/librenms/issues/5827))
* urldecode device notes [#5110](https://github.com/librenms/librenms/issues/5110) ([#5824](https://github.com/librenms/librenms/issues/5824))
* Replace Ntp with NTP in Apps menu ([#5791](https://github.com/librenms/librenms/issues/5791))
* Adding text logo to HPE logo ([#5728](https://github.com/librenms/librenms/issues/5728))
* Only show sysName once if force_ip_to_sysname is enabled [#5600](https://github.com/librenms/librenms/issues/5600) ([#5656](https://github.com/librenms/librenms/issues/5656))
* Add $config['title_image'] in doc and use it also for login screen ([#5683](https://github.com/librenms/librenms/issues/5683))
* Update create bill link to list bill or list bills depending on if port exists in bills [#5616](https://github.com/librenms/librenms/issues/5616) ([#5653](https://github.com/librenms/librenms/issues/5653))
* Remove ifIndex for ports list but add debug button to show port info ([#5679](https://github.com/librenms/librenms/pull/5679))

#### API
* Added the ability to list devices by location in the api ([#5693](https://github.com/librenms/librenms/issues/5693))
* IP and Port API additions ([#5784](https://github.com/librenms/librenms/pull/5784))
* Limit get_graph_by_port_hostname() to one port and exclude deleted ([#5936](https://github.com/librenms/librenms/pull/5936))
---

## 1.24
*(2017-01-28)*

#### Features
* Basic Draytek Support ([#5625](https://github.com/librenms/librenms/issues/5625))
* Added additional information to Radwin discovery. ([#5591](https://github.com/librenms/librenms/issues/5591))
* Added Serial number support for Mikrotik Devices ([#5590](https://github.com/librenms/librenms/issues/5590))
* Support large vendor logos ([#5573](https://github.com/librenms/librenms/issues/5573))
* Added pre-commit git script to support failing fast
* Added basic recurring maintenance for alerts [#4480](https://github.com/librenms/librenms/issues/4480)
* Added check for if git executable ([#5444](https://github.com/librenms/librenms/issues/5444))
* Oxidized basic config search ([#5333](https://github.com/librenms/librenms/issues/5333))
* Add support for SVG images ([#5275](https://github.com/librenms/librenms/issues/5275))
* Add mysql failed query logging + fixed queries that break ONLY_FULL_GROUP_BY ([#5327](https://github.com/librenms/librenms/issues/5327))

#### Bugfixes
* Logo scalling to support squarish logos ([#5647](https://github.com/librenms/librenms/issues/5647))
* top-devices widget now will honour for ip to sysName config [#5388](https://github.com/librenms/librenms/issues/5388) ([#5643](https://github.com/librenms/librenms/issues/5643))
* Remove duplicate hostnames in arp search box [#5631](https://github.com/librenms/librenms/issues/5631) ([#5641](https://github.com/librenms/librenms/issues/5641))
* Alert templates designer now fixed [#5636](https://github.com/librenms/librenms/issues/5636) ([#5638](https://github.com/librenms/librenms/issues/5638))
* Update ifAlias script to deal with GRE interfaces ([#5546](https://github.com/librenms/librenms/issues/5546))
* Allow invalid hostnames during discovery when discovery_by_ip enabled [#5525](https://github.com/librenms/librenms/issues/5525)
* Stop creating dashboards when user has a default that no longer exists [#5610](https://github.com/librenms/librenms/issues/5610) ([#5613](https://github.com/librenms/librenms/issues/5613))
* Fix Riverbed optimization polling ([#5622](https://github.com/librenms/librenms/issues/5622))
* Html purify init wasn't done always when it was used ([#5626](https://github.com/librenms/librenms/issues/5626))
* Fixed FreeNAS detection [#5518](https://github.com/librenms/librenms/issues/5518) ([#5608](https://github.com/librenms/librenms/issues/5608))
* Add extra check to Junos DOM discovery ([#5582](https://github.com/librenms/librenms/issues/5582))
* HTML Purifier would create tmp caches within the vendor folder, moved to users tmp dir [#5561](https://github.com/librenms/librenms/issues/5561) ([#5596](https://github.com/librenms/librenms/issues/5596))
* PHP 7.1 function usages with too few parameters ([#5588](https://github.com/librenms/librenms/issues/5588))
* Fixed graphs for services not working ([#5569](https://github.com/librenms/librenms/issues/5569))
* Fix broken netstats ip forward polling ([#5575](https://github.com/librenms/librenms/issues/5575))
* Support hosts added by ipv6 without DNS [#5567](https://github.com/librenms/librenms/issues/5567)
* Changing device type now is persistant ([#5529](https://github.com/librenms/librenms/issues/5529))
* Fixed JunOS bgpPeers_cbgp mistakenly removed + better support for mysql strict mode [#5531](https://github.com/librenms/librenms/issues/5531) ([#5536](https://github.com/librenms/librenms/issues/5536))
* Allow overlib_link to accept a null class [#5522](https://github.com/librenms/librenms/issues/5522)
* Stop flattening config options added in config.php  ([#5493](https://github.com/librenms/librenms/issues/5493))
* Stop flattening config options added in config.php ([#5491](https://github.com/librenms/librenms/issues/5491))
* ospf polling, revert set_numeric use ([#5480](https://github.com/librenms/librenms/issues/5480))
* Updated prestiage detection [#5453](https://github.com/librenms/librenms/issues/5453) ([#5470](https://github.com/librenms/librenms/issues/5470))
* Validate suid is set for fping ([#5474](https://github.com/librenms/librenms/issues/5474))
* Add missing ups-apcups application poller [#5428](https://github.com/librenms/librenms/issues/5428)
* Linux detect by oid too ([#5439](https://github.com/librenms/librenms/issues/5439))
* APC -1 Humidity Sensor Value [#5325](https://github.com/librenms/librenms/issues/5325) ([#5375](https://github.com/librenms/librenms/issues/5375))
* Fix sql errors due to incorrect cef table name [#5362](https://github.com/librenms/librenms/issues/5362)
* Detection blank or unknown device types and update [#5412](https://github.com/librenms/librenms/issues/5412) ([#5414](https://github.com/librenms/librenms/issues/5414))
* Unifi switch detection ([#5407](https://github.com/librenms/librenms/issues/5407))
* Detect device type changes and update [#5271](https://github.com/librenms/librenms/issues/5271) ([#5390](https://github.com/librenms/librenms/issues/5390))
* Typo in IBM icon definition ([#5395](https://github.com/librenms/librenms/issues/5395))
* Don't support unifi clients that don't report data ([#5383](https://github.com/librenms/librenms/issues/5383))
* Fix Oxidized Config Search Output ([#5382](https://github.com/librenms/librenms/issues/5382))
* Added support for autotls in mail transport [#5314](https://github.com/librenms/librenms/issues/5314)
* validate mysql queries ([#5365](https://github.com/librenms/librenms/issues/5365))
* OS type and group not being set ([#5357](https://github.com/librenms/librenms/issues/5357))
* Stop logging when a vm no longer is on the host being polled ([#5346](https://github.com/librenms/librenms/issues/5346))
* Dark/mono logo was incorrect ([#5342](https://github.com/librenms/librenms/issues/5342))
* Specify specific mkdocs version ([#5339](https://github.com/librenms/librenms/issues/5339))
* Correct icon for ciscosb ([#5331](https://github.com/librenms/librenms/issues/5331))
* Correction on addHost function to handle the force_add parameter in api ([#5329](https://github.com/librenms/librenms/issues/5329))
* Mikrotik cpu detection ([#5306](https://github.com/librenms/librenms/issues/5306))
* Do not use generic icon by default ([#5303](https://github.com/librenms/librenms/issues/5303))
* Update jpgraph source file to remove check for imageantialias() [#5282](https://github.com/librenms/librenms/issues/5282) ([#5284](https://github.com/librenms/librenms/issues/5284))
* APC PDU2 Voltage Discovery ([#5276](https://github.com/librenms/librenms/issues/5276))
* Empty mac adds an entry to the arp table ([#5270](https://github.com/librenms/librenms/issues/5270))
* Restrict inventory api calls to the device requested ([#5267](https://github.com/librenms/librenms/issues/5267))

#### Documentation
* Mikrotik SNMP configuration example ([#5628](https://github.com/librenms/librenms/issues/5628))
* Add logrotate config and update install docs ([#5520](https://github.com/librenms/librenms/issues/5520))
* Added an example hardware doc for people to show what they have ([#5532](https://github.com/librenms/librenms/issues/5532))
* Added faq info on realStorageUnits ([#5513](https://github.com/librenms/librenms/issues/5513))
* Update Installation-Ubuntu-1604-Nginx.md to remove default nginx site config
* Updated RRDCached doc for Debain Jessie installation ([#5380](https://github.com/librenms/librenms/issues/5380))
* Updated os update application
* Added more info in to the github issue template ([#5370](https://github.com/librenms/librenms/issues/5370))
* Update Installation-Ubuntu-1604-Nginx.md to correct snmpd.conf location
* Update installation documentation on Ubuntu 16.x and CentOS 7 to use systemd ([#5324](https://github.com/librenms/librenms/issues/5324))
* Update Centos 7 nginx install steps ([#5316](https://github.com/librenms/librenms/issues/5316))
* Added section on smokeping and rrdcached use

#### Refactoring
* Update collectd functions.php to use non-conflict rrd_info function [#5478](https://github.com/librenms/librenms/issues/5478) ([#5642](https://github.com/librenms/librenms/issues/5642))
* Updated some default disco/poller modules to be disabled/enabled ([#5564](https://github.com/librenms/librenms/issues/5564))
* Added config option for database port ([#5517](https://github.com/librenms/librenms/issues/5517))
* Move HTMLPurifier init to init.php so we only create one object. ([#5601](https://github.com/librenms/librenms/issues/5601))
* Disable unused Cisco WAAS modules ([#5574](https://github.com/librenms/librenms/issues/5574))
* Some more os definition changes ([#5527](https://github.com/librenms/librenms/issues/5527))
* Changed Redback to SEOS, and added logo and temperature discovery [#5181](https://github.com/librenms/librenms/issues/5181)
* Move some os from linux and freebsd discovery files to yaml ([#5429](https://github.com/librenms/librenms/issues/5429))
* MySQL strict and query fixes ([#5338](https://github.com/librenms/librenms/issues/5338))
* Sophos discovery to yaml ([#5416](https://github.com/librenms/librenms/issues/5416))
* Move include based discovery after yaml discovery ([#5401](https://github.com/librenms/librenms/issues/5401))
* Moved simple os discovery into yaml config ([#5313](https://github.com/librenms/librenms/issues/5313))
* Move mib based polling into yaml config files ([#5234](https://github.com/librenms/librenms/issues/5234))
* Use Composer to manage php dependencies ([#5216](https://github.com/librenms/librenms/issues/5216))

#### Devices
* Added further support for Canon printers [#5637](https://github.com/librenms/librenms/issues/5637) ([#5650](https://github.com/librenms/librenms/issues/5650))
* Updated generex ups support [#5634](https://github.com/librenms/librenms/issues/5634) ([#5640](https://github.com/librenms/librenms/issues/5640))
* Added detection for Exinda [#5297](https://github.com/librenms/librenms/issues/5297) ([#5605](https://github.com/librenms/librenms/issues/5605))
* Added additional sensor support for PowerWalker devices [#5080](https://github.com/librenms/librenms/issues/5080) ([#5552](https://github.com/librenms/librenms/issues/5552))
* Added support for Brocade 200E ([#5617](https://github.com/librenms/librenms/issues/5617))
* Improve CiscoSB detection [#5511](https://github.com/librenms/librenms/issues/5511)
* Added further detection for DCN devices [#5519](https://github.com/librenms/librenms/issues/5519) ([#5609](https://github.com/librenms/librenms/issues/5609))
* Added support for Zhone MXK devices [#5554](https://github.com/librenms/librenms/issues/5554) ([#5611](https://github.com/librenms/librenms/issues/5611))
* Added more detection for Procurve devices [#5422](https://github.com/librenms/librenms/issues/5422) ([#5607](https://github.com/librenms/librenms/issues/5607))
* Updated detection for Dasan NOS devices [#5359](https://github.com/librenms/librenms/issues/5359) ([#5606](https://github.com/librenms/librenms/issues/5606))
* Added support MGEUPS EX2200 [#3364](https://github.com/librenms/librenms/issues/3364) ([#5602](https://github.com/librenms/librenms/issues/5602))
* Improve Cisco ISE detection ([#5578](https://github.com/librenms/librenms/issues/5578))
* Updated akcp discovery definition [#5396](https://github.com/librenms/librenms/issues/5396) ([#5501](https://github.com/librenms/librenms/issues/5501))
* Add detection for radwin devices
* Update zywall and zyxelnwa detection [#5343](https://github.com/librenms/librenms/issues/5343)
* Added support for Ericsson ES devices [#5195](https://github.com/librenms/librenms/issues/5195) ([#5479](https://github.com/librenms/librenms/issues/5479))
* Add support for DocuPrint M225 ([#5484](https://github.com/librenms/librenms/issues/5484))
* Added Dell B5460dn and B3460dn printer support ([#5482](https://github.com/librenms/librenms/issues/5482))
* Added signal support for RouterOS ([#5498](https://github.com/librenms/librenms/issues/5498))
* Added additional sensor support for Huawei VRP [#4279](https://github.com/librenms/librenms/issues/4279)
* Added loadbalancer information from F5 LTM ([#5205](https://github.com/librenms/librenms/issues/5205))
* APC Environmental monitoring units [#5140](https://github.com/librenms/librenms/issues/5140)
* Add support for KTI switches ([#5413](https://github.com/librenms/librenms/issues/5413))
* Detect all CTC Union devices ([#5489](https://github.com/librenms/librenms/issues/5489))
* Add addition riverbed information [#5170](https://github.com/librenms/librenms/issues/5170)
* Added support for CTC Union devices ([#5402](https://github.com/librenms/librenms/issues/5402))
* Add wifi clients for Deliberant DLB APC Button, DLB APC Button AF and DLB APC 2mi [#5456](https://github.com/librenms/librenms/issues/5456)
* Added Tomato and AsusWRT-Merlin OS [#5254](https://github.com/librenms/librenms/issues/5254) ([#5398](https://github.com/librenms/librenms/issues/5398))
* Detect Fiberhome AN5516-04B
* Improve Checkpoint Discovery ([#5334](https://github.com/librenms/librenms/issues/5334))
* APC in-row coolers
* Added additional detection for Dell UPS ([#5322](https://github.com/librenms/librenms/issues/5322))
* added more support for dasan-nos ([#5298](https://github.com/librenms/librenms/issues/5298))
* Added support for Dasan NOS [#5179](https://github.com/librenms/librenms/issues/5179) + disco change ([#5255](https://github.com/librenms/librenms/issues/5255))
* Edge core OS ECS3510-52T ([#5286](https://github.com/librenms/librenms/issues/5286))
* Basic Dell UPS Support [#5258](https://github.com/librenms/librenms/issues/5258)
* Basic Fujitsu DX Support [#5260](https://github.com/librenms/librenms/issues/5260)

#### WebUI
* Final Font Awesome conversion ([#5652](https://github.com/librenms/librenms/issues/5652))
* Added ?ver=X to LibreNMS style sheets so we can force refreshes in future ([#5651](https://github.com/librenms/librenms/issues/5651))
* New generic os SVG icon ([#5645](https://github.com/librenms/librenms/issues/5645))
* New LibreNMS logo assets ([#5629](https://github.com/librenms/librenms/issues/5629))
* Center device icons.  Keep device actions at two rows ([#5627](https://github.com/librenms/librenms/issues/5627))
* Additional Font Awesome icons ([#5572](https://github.com/librenms/librenms/issues/5572))
* Allows one to view a map of the SNMP location set for a device ([#5495](https://github.com/librenms/librenms/issues/5495))
* Update health menu icons
* Updated icons to use Font Awesome ([#5468](https://github.com/librenms/librenms/issues/5468))
* Allow billing to use un-auth graphs ([#5449](https://github.com/librenms/librenms/issues/5449))
* Update Font Awesome to 4.7.0 ([#5476](https://github.com/librenms/librenms/issues/5476))
* Update add/edit user page to use their instead of his [#5457](https://github.com/librenms/librenms/issues/5457) ([#5460](https://github.com/librenms/librenms/issues/5460))
* Fix Ports Table AdminDown Search ([#5426](https://github.com/librenms/librenms/issues/5426))
* Disabled editing device notes for non-admin users ([#5341](https://github.com/librenms/librenms/issues/5341))
* Small Best Practice Fixes

---

## 1.23
*(2017-01-01)*

#### Features
* Add nagios check_procs support ([#5214](https://github.com/librenms/librenms/issues/5214))
* Added support for sending email notifications to default_contact if updating fails ([#5026](https://github.com/librenms/librenms/issues/5026))
* Enable override of $config values set in includes/definitions.inc.php ([#5096](https://github.com/librenms/librenms/issues/5096))
* Add APC UPS battery replacement status [#5088](https://github.com/librenms/librenms/issues/5088)

#### Bugfixes
* APC PDU2 Voltage Discovery ([#5276](https://github.com/librenms/librenms/issues/5276))
* Empty mac adds an entry to the arp table ([#5270](https://github.com/librenms/librenms/issues/5270))
* Restrict inventory api calls to the device requested ([#5267](https://github.com/librenms/librenms/issues/5267))
* Update any IP fields using inet6_ntop()  [#5207](https://github.com/librenms/librenms/issues/5207)
* Fixed passing of data to load_all_os() function ([#5235](https://github.com/librenms/librenms/issues/5235))
* Support columns filter in get_port_stats_by_port_hostname api call ([#5230](https://github.com/librenms/librenms/issues/5230))
* Restore usage of -i -n in polling ([#5228](https://github.com/librenms/librenms/issues/5228))
* Empty routing menu where only CEF is present ([#5225](https://github.com/librenms/librenms/issues/5225))
* Added service params for check_smtp ([#5223](https://github.com/librenms/librenms/issues/5223))
* Misc warning fixes in mib polling ([#5222](https://github.com/librenms/librenms/issues/5222))
* Added service params for check_imap ([#5213](https://github.com/librenms/librenms/issues/5213))
* Execute commands using the numeric conventions of the C locale. ([#5192](https://github.com/librenms/librenms/issues/5192))
* Remove usage of -CI, it is not allowed for snmpbulkwalk [#5164](https://github.com/librenms/librenms/issues/5164)
* Update F5 fanspeed discovery ([#5200](https://github.com/librenms/librenms/issues/5200))
* Fix state_indexes for state overview sensors ([#5191](https://github.com/librenms/librenms/issues/5191))
* Better Cisco hardware formatting ([#5184](https://github.com/librenms/librenms/issues/5184))
* Cisco hardware name detection ([#5167](https://github.com/librenms/librenms/issues/5167))
* Changed sql query for state sensors on device overview page to ignore null sensor_id ([#5180](https://github.com/librenms/librenms/issues/5180))
* daily.sh install path ([#5152](https://github.com/librenms/librenms/issues/5152))
* Cleanup printing ifAlias ([#4874](https://github.com/librenms/librenms/issues/4874))
* Fixed broken http-auth auth module [#5053](https://github.com/librenms/librenms/issues/5053) ([#5146](https://github.com/librenms/librenms/issues/5146))
* Fix get_port_stats_by_port_hostname() to only return non-deleted ports [#5131](https://github.com/librenms/librenms/issues/5131)
* Stop openbsd using snmpEngineTime ([#5111](https://github.com/librenms/librenms/issues/5111))
* Update raspberrypi sensor discover to check for sensor data ([#5114](https://github.com/librenms/librenms/issues/5114))
* Add check for differently named Cisco Power sensor ([#5119](https://github.com/librenms/librenms/issues/5119))
* Ability to detect Cisco ASA version when polling a security context ([#5098](https://github.com/librenms/librenms/issues/5098))
* Fixed setting userlevel for  LDAP auth [#5090](https://github.com/librenms/librenms/issues/5090)
* Arp-table uses array_column() breaking discovery on php <=5.4 ([#5099](https://github.com/librenms/librenms/issues/5099))
* Allow html but not script, head and html tags in notes widget [#4898](https://github.com/librenms/librenms/issues/4898) ([#5006](https://github.com/librenms/librenms/issues/5006))

#### Documentation
* Updated rrdcached docs to include Ubuntu 16.x ([#5263](https://github.com/librenms/librenms/issues/5263))
* Updated Oxidized.md ([#5224](https://github.com/librenms/librenms/issues/5224))
* Removed mailing list in various places + small improvements to docs ([#5154](https://github.com/librenms/librenms/issues/5154))
* Added Remote monitoring using tinc VPN ([#5122](https://github.com/librenms/librenms/issues/5122))
* Added documentation on securing rrdcached. ([#5093](https://github.com/librenms/librenms/issues/5093))
* Adding how to configure HPE 3PAR to documentation ([#5087](https://github.com/librenms/librenms/issues/5087))
* Fixed example timezones ([#5083](https://github.com/librenms/librenms/issues/5083))

#### Refactoring
* Removed and moved more mibs ([#5232](https://github.com/librenms/librenms/issues/5232))
* Move OS definitions into yaml files ([#5189](https://github.com/librenms/librenms/issues/5189))
* Updated Ups nut support
* Mibs E-G ([#5190](https://github.com/librenms/librenms/issues/5190))
* Moved / deleted mibs A-D ([#5173](https://github.com/librenms/librenms/issues/5173))
* Updated location of mibs starting with S ([#5142](https://github.com/librenms/librenms/issues/5142))
* Update some devices to disable poller/disco modules by default ([#5010](https://github.com/librenms/librenms/issues/5010))
* More Cisco ASA Polling Performance Improvements ([#5104](https://github.com/librenms/librenms/issues/5104))
* Moved mibs T-U (or removed) where possible ([#5013](https://github.com/librenms/librenms/issues/5013))

#### Devices
* Lancom wireless devices ([#5237](https://github.com/librenms/librenms/issues/5237))
* Added additional detection for Cisco WAP 321 [#5172](https://github.com/librenms/librenms/issues/5172) ([#5248](https://github.com/librenms/librenms/issues/5248))
* Added support for TPLink JetStream [#5194](https://github.com/librenms/librenms/issues/5194) ([#5249](https://github.com/librenms/librenms/issues/5249))
* Added HPE MSL support [#5072](https://github.com/librenms/librenms/issues/5072) ([#5239](https://github.com/librenms/librenms/issues/5239))
* Added support for DCN switches [#5031](https://github.com/librenms/librenms/issues/5031) ([#5238](https://github.com/librenms/librenms/issues/5238))
* Added support for Cisco APIC devices ([#5236](https://github.com/librenms/librenms/issues/5236))
* Zyxel ZyWALL Improvement [#5185](https://github.com/librenms/librenms/issues/5185)
* Added CPU detection for Zyxel GS2200-24 ([#5218](https://github.com/librenms/librenms/issues/5218))
* removed all references to 'multimatics' and instead added generex OS
* Added additional support for F5 BigIP LTM objects
* Added additional support for Synology dsm ([#5145](https://github.com/librenms/librenms/issues/5145))
* Add OS Detection support for Alcatel-Lucent/Nokia ESS 7450 Ethernet service switch [#5187](https://github.com/librenms/librenms/issues/5187)
* Added Bluecoat ProxySG Support ([#5165](https://github.com/librenms/librenms/issues/5165))
* Added support for Arris CMTS ([#5143](https://github.com/librenms/librenms/issues/5143))
* Added os Discovery for Brocade NOS V4.X and below. ([#5158](https://github.com/librenms/librenms/issues/5158))
* Added support for Mirth OS [#2639](https://github.com/librenms/librenms/issues/2639)
* Juniper SA support [#4328](https://github.com/librenms/librenms/issues/4328)
* Added support for Zyxel MES3528 ([#5120](https://github.com/librenms/librenms/issues/5120))
* Add more Edge core switches
* Add support for Ubiquiti EdgePoint Switch models ([#5079](https://github.com/librenms/librenms/issues/5079))

#### WebUI
* Standardised all rowCount parameters for tables ([#5067](https://github.com/librenms/librenms/issues/5067))

#### Security
* Update PHPMailer to version 5.2.19 ([#5253](https://github.com/librenms/librenms/issues/5253))

---

## v1.22.01
*(2016-11-30)*

#### Bugfixes
* arp-table uses array_column() breaking discovery on php <=5.4 ([#5099](https://github.com/librenms/librenms/issues/5099))

---

## v1.22
*(2016-11-25)*

#### Features
* validate list devices that have not been polled in the last 5 minutes or took more than 5 minutes to poll ([#5037](https://github.com/librenms/librenms/issues/5037))
* Add Microsoft Teams Alert Transport ([#5023](https://github.com/librenms/librenms/issues/5023))
* Added formatted uptime value for alert templates [#4983](https://github.com/librenms/librenms/issues/4983)
* Adds support for enabling / disabling modules per OS ([#4963](https://github.com/librenms/librenms/issues/4963))
* Improve Dell OpenManage Discovery ([#4957](https://github.com/librenms/librenms/issues/4957))
* Added the option to select alert rules from a collection

#### Bugfixes
* use password type for SMTP Auth [#5051](https://github.com/librenms/librenms/issues/5051)
* Added alert init module to ajax_form [#5058](https://github.com/librenms/librenms/issues/5058)
* eventlog type variable collision ([#5046](https://github.com/librenms/librenms/issues/5046))
* Fixed loaded modules for ajax search ([#5043](https://github.com/librenms/librenms/issues/5043))
* timos6-7 snmprec file error ([#5035](https://github.com/librenms/librenms/issues/5035))
* Strip out " returned from Proxmox application [#4908](https://github.com/librenms/librenms/issues/4908) ([#5003](https://github.com/librenms/librenms/issues/5003))
* Used correct variable for displaying total email count in alert capture ([#5022](https://github.com/librenms/librenms/issues/5022))
* Cisco ASA Sensor Discovery, use correct variable ([#5021](https://github.com/librenms/librenms/issues/5021))
* Stop service modal form disabling services for read-only admin ([#4994](https://github.com/librenms/librenms/issues/4994))
* dbUpdate calls now check if it is 0 or above ([#4996](https://github.com/librenms/librenms/issues/4996))
* Links on devices graphs page to take users straight to specific graph page ([#5001](https://github.com/librenms/librenms/issues/5001))
* Fixed poweralert discovery, check is now case insensitive ([#5000](https://github.com/librenms/librenms/issues/5000))
* Daily.sh log_dir failed when install_dir and log_dir were not set ([#4992](https://github.com/librenms/librenms/issues/4992))
* Merge pull request [#4939](https://github.com/librenms/librenms/issues/4939) from laf/issue-4937
* Remove service type from uniform display ([#4974](https://github.com/librenms/librenms/issues/4974))
* Fixed check for VRFs, so this runs on routers without any VRFs defined ([#4972](https://github.com/librenms/librenms/issues/4972))
* Api rate percent calculation incorrect ([#4956](https://github.com/librenms/librenms/issues/4956))
* Corrects path to proxmox script in docs ([#4949](https://github.com/librenms/librenms/issues/4949))
* Update debug output in service check ([#4933](https://github.com/librenms/librenms/issues/4933))
* Fujitsu PRIMERGY 10Gbe switches are now detected correctly ([#4923](https://github.com/librenms/librenms/issues/4923))
* Toner graphs with invalid chars
* Updated syslog table to use display() for msg output ([#4859](https://github.com/librenms/librenms/issues/4859))
* Added support for https links in alerts procedure url ([#4872](https://github.com/librenms/librenms/issues/4872))
* Updated check to use != in daily.sh ([#4916](https://github.com/librenms/librenms/issues/4916))
* Remove escape characters for services form / display [#4891](https://github.com/librenms/librenms/issues/4891)
* Only update components if data exists in cimc entity-physical discovery [#4902](https://github.com/librenms/librenms/issues/4902)
* Renamed hp3par os polling file to informos ([#4861](https://github.com/librenms/librenms/issues/4861))
* Updated Cisco ASA state sensors descr to be a bit more verbose

#### Documentation
* Added FAQ on why EdgeRouters might not be detected ([#4985](https://github.com/librenms/librenms/issues/4985))
* Update freenode links ([#4935](https://github.com/librenms/librenms/issues/4935))
* Issue template to ask people to use irc / community for creating issues

#### Refactoring
* Rewrite arp-table discovery ([#5048](https://github.com/librenms/librenms/issues/5048))
* Collection and output of db and snmp stats ([#5049](https://github.com/librenms/librenms/issues/5049))
* Disable modules for pbn-cp and multimatic os
* Centralize includes and initialization ([#4991](https://github.com/librenms/librenms/issues/4991))
* Remove inappropriate usages of truncate() ([#5028](https://github.com/librenms/librenms/issues/5028))
* Watchguard Fireware cleanup ([#5015](https://github.com/librenms/librenms/issues/5015))
* Tidy up mibs V-Z ([#4979](https://github.com/librenms/librenms/issues/4979))
* Limit perf array index length to 19 characters due to limitation in ds-name rrdtool ([#4731](https://github.com/librenms/librenms/issues/4731))
* Daily.sh updated ([#4920](https://github.com/librenms/librenms/issues/4920))
* Default to only using mysqli ([#4915](https://github.com/librenms/librenms/issues/4915))
* Start of cleaning up mibs
* Update wifi clients polling to support more than 2 radios ([#4913](https://github.com/librenms/librenms/issues/4913))
* Refactored and added support for $config['log_dir'] to daily.sh
* Improve Cisco ASA Polling Performance ([#4999](https://github.com/librenms/librenms/issues/4999))

#### Devices
* Updated edge-core to edgecos and added further detection ([#5024](https://github.com/librenms/librenms/issues/5024))
* Added basic support for Ceragon devices
* Added support for Dell PowerConnect 6024
* Added PBN-CP devices.
* Added support for Edgerouter devices [#4936](https://github.com/librenms/librenms/issues/4936)
* Added support for Dell Remote consoles [#4881](https://github.com/librenms/librenms/issues/4881)
* Added support for FortiSwitch [#4852](https://github.com/librenms/librenms/issues/4852) ([#4858](https://github.com/librenms/librenms/issues/4858))

#### WebUI
* Availability map compact view, use square tiles instead of rectangles ([#5038](https://github.com/librenms/librenms/issues/5038))
* Add link to recently added device ([#5032](https://github.com/librenms/librenms/issues/5032))
* Do not show Config tab for devices set to be excluded from oxidized [#4592](https://github.com/librenms/librenms/issues/4592) ([#5029](https://github.com/librenms/librenms/issues/5029))
* Update Availability-Map Widget to use sysName when IPs used and config enabled ([#4968](https://github.com/librenms/librenms/issues/4968))
* Added support for skipping snmp check on edit snmp page for devices ([#4896](https://github.com/librenms/librenms/issues/4896))
* Update wifi_clients graph ([#4846](https://github.com/librenms/librenms/issues/4846))
* Further decouple the avail-map page from the widget ([#4887](https://github.com/librenms/librenms/issues/4887))

---

## v1.21
*(2016-10-30)*

#### Features
* Added support for global max repeaters for snmp ([#4880](https://github.com/librenms/librenms/issues/4880))
* Added custom css and include directories which are ignored by git ([#4871](https://github.com/librenms/librenms/issues/4871))
* Add an option for ad authentication to have a default level ([#4801](https://github.com/librenms/librenms/issues/4801))
* Add ping and RxLevel for SAF devices ([#4840](https://github.com/librenms/librenms/issues/4840))
* Added ability to exclude devices from xDP disco based on sysdescr, sysname or platform
* Add Extra Mimosa Discovery ([#4831](https://github.com/librenms/librenms/issues/4831))
* Add support for NX-OS fan status ([#4824](https://github.com/librenms/librenms/issues/4824))
* Add osTicket Alert Transport ([#4791](https://github.com/librenms/librenms/issues/4791))
* Add SonicWALL Sessions [#1686](https://github.com/librenms/librenms/issues/1686)
* Updated libvirt-vminfo to support oVirt
* Enhance Unifi Wireless Client count for multiple VAPs ([#4794](https://github.com/librenms/librenms/issues/4794))
* Added CEF Display page ([#3978](https://github.com/librenms/librenms/issues/3978))
* Added CPU detection for Synology DSM [#2081](https://github.com/librenms/librenms/issues/2081) ([#4756](https://github.com/librenms/librenms/issues/4756))
* Added CPU detection for Synology DSM [#2081](https://github.com/librenms/librenms/issues/2081)
* Stop displaying sensitive info in the settings page ([#4724](https://github.com/librenms/librenms/issues/4724))
* Added Cisco Integrated Management Console inventory and sensor support [#4454](https://github.com/librenms/librenms/issues/4454)
* Added support for show faults array in recovery alerts ([#4708](https://github.com/librenms/librenms/issues/4708))
* Add description and notes to be used in alerts templates ([#4706](https://github.com/librenms/librenms/issues/4706))
* validate.php: check poller and discovery status ([#4663](https://github.com/librenms/librenms/issues/4663))
* Added GlobalProtect sessions to PANOS

#### Bugfixes
* Replace \\\\l with \l on GPRINT lines ([#4882](https://github.com/librenms/librenms/issues/4882))
* fix missing config entries on global settings page [#4884](https://github.com/librenms/librenms/issues/4884)
* Fix the detection of NX-OS fan names ([#4864](https://github.com/librenms/librenms/issues/4864))
* API call to services only returned first one
* Change the wording for the create default rules button
* incomplete polling on aruba controllers
* Fixed wifi clients not reporting when value 0
* ZyWALL Fixes for OS and mem polling [#1652](https://github.com/librenms/librenms/issues/1652)
* Fix irc bot user level ([#4833](https://github.com/librenms/librenms/issues/4833))
* Updated min/max values for ubnt graphs ([#4811](https://github.com/librenms/librenms/issues/4811))
* Fix Riverbed temperature discovery ([#4832](https://github.com/librenms/librenms/issues/4832))
* only poll cipsec for cisco devices. ([#4819](https://github.com/librenms/librenms/issues/4819))
* Zywall Fixes [#1652](https://github.com/librenms/librenms/issues/1652)
* do not show fail if running as the librenms user + slightly less false positives ([#4821](https://github.com/librenms/librenms/issues/4821))
* Do not create rrd folder when -r is specified for poller ([#4812](https://github.com/librenms/librenms/issues/4812))
* Delete all port_id references [#4684](https://github.com/librenms/librenms/issues/4684)
* Used dos2unix on all mibs to prevent .index issue ([#4803](https://github.com/librenms/librenms/issues/4803))
* availability map multiple instances ([#4773](https://github.com/librenms/librenms/issues/4773))
* top widget multiple instances ([#4757](https://github.com/librenms/librenms/issues/4757))
* Updated bin/bash to use env in cronic script ([#4752](https://github.com/librenms/librenms/issues/4752))
* skip ip_exists function when we force add ([#4738](https://github.com/librenms/librenms/issues/4738))
* Stopped showing sub menus when empty [#4713](https://github.com/librenms/librenms/issues/4713)
* Samsun ML typo, remove need for hex_string translation ([#4788](https://github.com/librenms/librenms/issues/4788))
* apc load, runtime and current sensors ([#4780](https://github.com/librenms/librenms/issues/4780))
* Prevent accidental anonymous binds ([#4784](https://github.com/librenms/librenms/issues/4784))
* Update brocade fanspeed description
* qnap temperature sensors [#4586](https://github.com/librenms/librenms/issues/4586)
* Stop displaying sensitive info in the settings page ([#4724](https://github.com/librenms/librenms/issues/4724))
* Ignore meraki bad_uptime [#4691](https://github.com/librenms/librenms/issues/4691)
* Fixed trying to map devices to alert rules
* Re-enable the edit device groups button ([#4726](https://github.com/librenms/librenms/issues/4726))
* Raise version size for packages table to 255 char  ([#4656](https://github.com/librenms/librenms/issues/4656))
* Adjusted padding based on screen width to fit all icons ([#4711](https://github.com/librenms/librenms/issues/4711))
* fixed count test for cisco-otv poller module ([#4714](https://github.com/librenms/librenms/issues/4714))
* Fall back to ipNetToMediaPhysAddress when ipNetToPhysicalPhysAddress not available [#4559](https://github.com/librenms/librenms/issues/4559)
* ipmi poller, run with USER rights and surround username and password with '' [#4710](https://github.com/librenms/librenms/issues/4710)
* Wrapped ipmi user / pass in quotes [#4686](https://github.com/librenms/librenms/issues/4686) and [#4702](https://github.com/librenms/librenms/issues/4702)
* Use snmpv3 username even when NoAuthNoPriv is selected [#4677](https://github.com/librenms/librenms/issues/4677)

#### Documentation
* homepage headers: vertical align, match color, add spacing ([#4870](https://github.com/librenms/librenms/issues/4870))
* Added FAQ on moving install to another server
* Updated index page to make it look more attractive ([#4855](https://github.com/librenms/librenms/issues/4855))
* Adding setup of distro script for Linux (snmpd) configuration
* Added doc on security and vulnerabilities
* Update Graylog.md ([#4717](https://github.com/librenms/librenms/issues/4717))

#### Refactoring
* populate native vlans in the ports_vlan table for cisco devices too ([#4805](https://github.com/librenms/librenms/issues/4805))
* Small poller improvements, removes unecessary queries / execs ([#4741](https://github.com/librenms/librenms/issues/4741))
* Cleanup poller include files ([#4751](https://github.com/librenms/librenms/issues/4751))
* Update alert rules to generate sql query and store in db ([#4748](https://github.com/librenms/librenms/issues/4748))
* toner support ([#4795](https://github.com/librenms/librenms/issues/4795))
* Updated and added more options for http proxy support ([#4718](https://github.com/librenms/librenms/issues/4718))
* small fixes for cisco-voice code ([#4719](https://github.com/librenms/librenms/issues/4719))
* Improve sensors polling for performance increase ([#4725](https://github.com/librenms/librenms/issues/4725))
* Improve sensors polling for performance increase
* Rewrite for qnap fanspeeds ([#4590](https://github.com/librenms/librenms/issues/4590))
* edituser page to allow user selection of a default dashboard ([#4551](https://github.com/librenms/librenms/issues/4551))
* snmp cleanup ([#4683](https://github.com/librenms/librenms/issues/4683))

#### Devices
* Added support for Megatec NetAgent II
* Add UniFi Wireless MIB polling for Capacity [#4266](https://github.com/librenms/librenms/issues/4266)
* Added support for Sinetica UPS ¢4613
* Added additional support for Synology DSM devices [#2738](https://github.com/librenms/librenms/issues/2738)
* Add additional F5 sensor support ([#4642](https://github.com/librenms/librenms/issues/4642))
* Added Unifi Wireless Client statistics [#4772](https://github.com/librenms/librenms/issues/4772)
* Additional support for Hikvision products
* More dnos additions [#4745](https://github.com/librenms/librenms/issues/4745) ([#4749](https://github.com/librenms/librenms/issues/4749))
* Additional support for Hikvision products ([#4750](https://github.com/librenms/librenms/issues/4750))
* Add support for Moxa [#4733](https://github.com/librenms/librenms/issues/4733)
* Add additional features to SAF Tehnika ([#4666](https://github.com/librenms/librenms/issues/4666))
* Add support for more Pulse Secure devices [#4680](https://github.com/librenms/librenms/issues/4680)
* Add support for more DNOS devices [#4627](https://github.com/librenms/librenms/issues/4627)
* Added support for Sinetica UPS
* Add support for Mimosa Wireless [#4676](https://github.com/librenms/librenms/issues/4676)
* Add support for Mimosa Wireless [#4676](https://github.com/librenms/librenms/issues/4676)

#### WebUI
* Allow users to set their default dashboard from preferences page
* Updated devices view ([#4700](https://github.com/librenms/librenms/issues/4700))
* Disable page refresh on the search pages.  Users can manually hit the refresh on the grid. ([#4787](https://github.com/librenms/librenms/issues/4787))
* Display vlans for all devices. [#4349](https://github.com/librenms/librenms/issues/4349), [#3059](https://github.com/librenms/librenms/issues/3059)
* Added sorting and poller time support to top-devices widget [#4668](https://github.com/librenms/librenms/issues/4668)

---

## Release: 201609
*September 2016*

#### Features
* Added alerts output to capture system ([#4574](https://github.com/librenms/librenms/issues/4574))
* Add support for ups-apcups via snmp
* Add snmpsim to Travis automated testing. Update to check new setting for true and isset
* use snmpsim for testing fallback feature so we don't have to run snmpsim on devel computers, should be adequate for now ./scripts/pre-commit.php -u -snmpsim will start an snmpsimd.py process automatically
* Improved readability for snmp debug output
* Add last changed, connected, and mtu to all ports data
* Add temp & state sensors to Riverbed
* Added support for all OS tests
* Added Runtime support for APC ups 
* Capture device troubleshooting info (discovery, poller, snmpwalk)
* Add temp & state sensors to Riverbed
* Add more state sensors to Dell iDrac
* Allow scripts to be run from any working directory ([#4437](https://github.com/librenms/librenms/issues/4437))
* New app: ups-nut ([#4386](https://github.com/librenms/librenms/issues/4386))
* Added new discovery-wrapper.py script to replicate poller-wrapper.py ([#4351](https://github.com/librenms/librenms/issues/4351))
* Extended graphing for sla - icmp-jitter [#4341](https://github.com/librenms/librenms/issues/4341)
* Added Cisco Stackwise Support [#4301](https://github.com/librenms/librenms/issues/4301)
* Add Cisco WAAS Optimized TCP Connections Graph ([#4645](https://github.com/librenms/librenms/issues/4645))

#### Bugfixes
* Toner nrg os capacity ([#4177](https://github.com/librenms/librenms/issues/4177))
* Fixed swos detection [#4533](https://github.com/librenms/librenms/issues/4533)
* Updated edit snmp to set default poller_group ([#4694](https://github.com/librenms/librenms/issues/4694))
* Fixed SQL query for bgpPeers check to remove stale sessions ([#4697](https://github.com/librenms/librenms/issues/4697))
* Netonix version display ([#4672](https://github.com/librenms/librenms/issues/4672))
* FreeBSD variants ([#4661](https://github.com/librenms/librenms/issues/4661))
* unix-agent handling of reported time values from check_mk [#4652](https://github.com/librenms/librenms/issues/4652)
* Add checks for devices with no uptime over snmp [#4587](https://github.com/librenms/librenms/issues/4587)
* stop qnap discovery from running for every device
* Fixed the old port rrd migration code to work with new rrdtool functions ([#4616](https://github.com/librenms/librenms/issues/4616))
* Run cleanup for ipmi sensor discovery ([#4582](https://github.com/librenms/librenms/issues/4582))
* Numerous availability-map bug fixes
* AD auth stop alerts being generated
* Possible additional fix for non-terminating rrdtool processes.
* AD auth stop alerts being generated
* APC runtime graph missing in device>health>overview
* LibreNMS/Proc improvements Should fix sending rrdtool the quit command without a newline at the end. (not sure if this is an issue)
* Port ifLastChange polling now usable ([#4541](https://github.com/librenms/librenms/issues/4541))
* brother toner levels ([#4526](https://github.com/librenms/librenms/issues/4526))
* poweralert ups divisor
* Update Fortinet Logo
* Change CiscoSB devices to use ifEntry
* Disable refreshing on window resize when $no_refresh is set.
* Fix quota bills showing 0/0 for in/out ([#4462](https://github.com/librenms/librenms/issues/4462))
* This removes stale entries in the mac_ipv4 table ([#4444](https://github.com/librenms/librenms/issues/4444))
* Swos os discovery fixes [#3593](https://github.com/librenms/librenms/issues/3593)
* Vyos discovery fix [#4486](https://github.com/librenms/librenms/issues/4486)
* Toner descr that contain invalid characters [#4464](https://github.com/librenms/librenms/issues/4464)
* Alert statics not showing data
* Ubnt bad edgeswitch uptime [#4470](https://github.com/librenms/librenms/issues/4470)
* New installs would have multiple entries in dbSchema table ([#4460](https://github.com/librenms/librenms/issues/4460))
* Force add now ignores all snmp queries
* Clean up errors in the webui ([#4438](https://github.com/librenms/librenms/issues/4438))
* Reduce mib graph queries ([#4439](https://github.com/librenms/librenms/issues/4439))
* Ports page includes disabled, ignored, and deleted ports ([#4419](https://github.com/librenms/librenms/issues/4419))
* RRDTool call was always being done to check for local files ([#4427](https://github.com/librenms/librenms/issues/4427))
* MikroTik OS detection [#3593](https://github.com/librenms/librenms/issues/3593)
* Added cisco886Va to bad_ifXEntry for cisco os ([#4374](https://github.com/librenms/librenms/issues/4374))
* Stop irc bot crashing on .reload [#4353](https://github.com/librenms/librenms/issues/4353)
* Quanta blade switches are now being correctly detected as Quanta switches ([#4358](https://github.com/librenms/librenms/issues/4358))
* Added options to make temperature graphs display y-axis correctly [#4350](https://github.com/librenms/librenms/issues/4350)
* Added options to make voltage graphs display y-axis correctly [#4326](https://github.com/librenms/librenms/issues/4326)
* Calling rrdtool_pipe_open() instead of rrdtool_initialize(); ([#4343](https://github.com/librenms/librenms/issues/4343))
* Enterasys use ifname for port names [#3263](https://github.com/librenms/librenms/issues/3263)
* Ricoh/nrg toner levels [#4177](https://github.com/librenms/librenms/issues/4177)
* Availability map device box reverted to original size, fixes for device groups ([#4334](https://github.com/librenms/librenms/issues/4334))
* Remove Cisco remote access stats graph transparency ([#4331](https://github.com/librenms/librenms/issues/4331))
* Cisco remote access stats bugfix [#4293](https://github.com/librenms/librenms/issues/4293) ([#4309](https://github.com/librenms/librenms/issues/4309))
* Added ability to force devices to use ifEntry instead of ifXEntry ([#4100](https://github.com/librenms/librenms/issues/4100))
* Don’t add Cisco VSS sensors if VSS is not running [#4111](https://github.com/librenms/librenms/issues/4111)
* Always validate the default dashboard_id to make sure it still exists
* NRG Toner detection [#4250](https://github.com/librenms/librenms/issues/4250)
* Missing variable in services api call
* Added influxdb options to check-services.php

#### Documentation
* Include PHP Install instructions for MySQL app
* Added FAQ for why interfaces are missing from overall traffic graphs ([#4696](https://github.com/librenms/librenms/issues/4696))
* Updated Applications to clarify apache setup
* Update apache applications to detail testing and additional requirements.md
* Updated release doc with more information on stable / dev branches
* Corrected the rsyslog documentation to be compatible with logrotate
* Fixed centos snmp path
* Updated to include info on how to use git hook to validate code ([#4484](https://github.com/librenms/librenms/issues/4484))
* Added info on how to perform unit testing
* Added faq to explain why devices show as warning ([#4449](https://github.com/librenms/librenms/issues/4449))
* Standardize snmp extend script location to /etc/snmp/ ([#4418](https://github.com/librenms/librenms/issues/4418))
* Added NFSen docs + update general config docs ([#4412](https://github.com/librenms/librenms/issues/4412))
* Clarify install docs to run validate as root [#4286](https://github.com/librenms/librenms/issues/4286) 
* Added example to alerting doc for using variables of similar name [#4264](https://github.com/librenms/librenms/issues/4264)
* Added docs + file changes to support creating new releases/changelog
* Update snmpd setup in Installation-Ubuntu-1604 docs [#4243](https://github.com/librenms/librenms/issues/4243)

#### Refactoring
* Centralize MIB include directory specification ([#4603](https://github.com/librenms/librenms/issues/4603))
* OS discovery files (a-z)
* F5 device discovery cleanup + test unit
* Remove external uses of GenGroupSQL()
* consolidate snmpcmd generation
* consolidate snmpcmd generation I needed to generate an snmpcmd for an upcoming PR, so I figured I'd save a little code duplication.
* Refactored new helper functions for case sensitivity [#4283](https://github.com/librenms/librenms/issues/4283) 
* Final PSR2 cleanup
* Moved IRCBot class to LibreNMS namespace [#4246](https://github.com/librenms/librenms/issues/4246) 
* Update code in /includes to be psr2 compliant [#4220](https://github.com/librenms/librenms/issues/4220)

#### Devices
* Samsung Printer Discovery [#4251](https://github.com/librenms/librenms/issues/4251) ([#4258](https://github.com/librenms/librenms/issues/4258))
* HP 1820 Discovery [#3933](https://github.com/librenms/librenms/issues/3933) ([#4259](https://github.com/librenms/librenms/issues/4259))
* Added support for Cisco Callmanager
* Edge Core ES3528M - base support
* Added support for Cisco IPS ([#4561](https://github.com/librenms/librenms/issues/4561))
* Added MGE detection
* Netonix switch data collection update
* Eaton PowerXpert
* Added Datacom Dbm Support
* Updated Edgerouter lite detection
* Added support for Cisco Callmanager
* Procurve 5400R series [#4375](https://github.com/librenms/librenms/issues/4375)
* hp online admin cpu and mem [#4327](https://github.com/librenms/librenms/issues/4327)
* Added support for Foundry Networks [#4311](https://github.com/librenms/librenms/issues/4311)
* Added Cisco Stackwise Support [#4301](https://github.com/librenms/librenms/issues/4301)
* Added support for PLANET Networking & Communication switches ([#4308](https://github.com/librenms/librenms/issues/4308))
* Added support for Fujitsu Primergy switches [#4277](https://github.com/librenms/librenms/issues/4277) ([#4280](https://github.com/librenms/librenms/issues/4280))
* Added support for Lanier printers [#4267](https://github.com/librenms/librenms/issues/4267) 
* Added Temp and State support for EdgeSwitch OS [#4265](https://github.com/librenms/librenms/issues/4265) 
* Added support for DDN Storage [#2737](https://github.com/librenms/librenms/issues/2737) ([#4261](https://github.com/librenms/librenms/issues/4261))
* Improved support for UBNT EdgeSwitch OS [#4249](https://github.com/librenms/librenms/issues/4249)
* Improved support for Avaya VSP [#4237](https://github.com/librenms/librenms/issues/4237)
* Added support for macOS Sierra ([#4557](https://github.com/librenms/librenms/issues/4557))
* Improve BDCOM detection ([#4329](https://github.com/librenms/librenms/issues/4329))

#### WebUI
* top devices enhancement [#4447](https://github.com/librenms/librenms/issues/4447)
* Individual devices now use bootgrid syslog ([#4584](https://github.com/librenms/librenms/issues/4584))
* added amazon server icon
* Update all glyphicon to font awesome
* Relocate Alerts menu
* Updated force add option for addhost.php to be present in all instances ([#4428](https://github.com/librenms/librenms/issues/4428))
* Add check to display make bill on port page only if billing is enabled ([#4361](https://github.com/librenms/librenms/issues/4361))
* Added Pagination and server side search via Ajax to NTP ([#4330](https://github.com/librenms/librenms/issues/4330))

---

### August 2016

#### Bug fixes
  - WebUI
    - Fix Infoblox dhcp messages graph ([PR3898](https://github.com/librenms/librenms/pull/3898))
    - Fix version_info output in Safari ([PR3914](https://github.com/librenms/librenms/pull/3914))
    - Added missing apps to Application page ([PR3964](https://github.com/librenms/librenms/pull/3964))
  - Discovery / Polling
    - Clear our stale IPSEC sessions from the DB ([PR3904](https://github.com/librenms/librenms/pull/3904))
    - Fixed some InfluxDB bugs in check-services and ports ([PR4031](https://github.com/librenms/librenms/pull/4031))
    - Fixed Promox and Ceph rrd's ([PR4038](https://github.com/librenms/librenms/pull/4038), [PR4037](https://github.com/librenms/librenms/pull/4037), [PR4047](https://github.com/librenms/librenms/pull/4047), [PR4041](https://github.com/librenms/librenms/pull/4041))
    - Fixed LLDP Remote port in discovery-protocols module ([PR4070](https://github.com/librenms/librenms/pull/4070))
  - Billing
    - Check if ifSpeed is returned for calculating billing ([PR3921](https://github.com/librenms/librenms/pull/3921))
  - Applications
    - NFS-V3 stats fixed ([PR3963](https://github.com/librenms/librenms/pull/3963))
  - Misc
    - Dell Equallogic storage fix ([PR3956](https://github.com/librenms/librenms/pull/3956))
    - Fix syslog bug where entries would log to the wrong device ([PR3996](https://github.com/librenms/librenms/pull/3996))

#### Improvements
  - Added / improved detection for:
    - Cisco WAAS / WAVE ([PR3899](https://github.com/librenms/librenms/pull/3899))
    - Maipu MyPower ([PR3909](https://github.com/librenms/librenms/pull/3909))
    - TPLink Switches ([PR3919](https://github.com/librenms/librenms/pull/3919))
    - Dell N3024 ([PR3941](https://github.com/librenms/librenms/pull/3941))
    - Cisco FXOS ([PR3943](https://github.com/librenms/librenms/pull/3943))
    - Brocade FABOS ([PR3959](https://github.com/librenms/librenms/pull/3959), [PR3988](https://github.com/librenms/librenms/pull/3988))
    - JunOS ([PR3976](https://github.com/librenms/librenms/pull/3976))
    - Dell PowerConnect ([PR3998](https://github.com/librenms/librenms/pull/3998), [PR4007](https://github.com/librenms/librenms/pull/4007))
    - Comware ([PR3967](https://github.com/librenms/librenms/pull/3967))
    - Calix E5 ([PR3864](https://github.com/librenms/librenms/pull/3864))
    - Raisecom ([PR3992](https://github.com/librenms/librenms/pull/3864))
    - Cisco ISE ([PR4063](https://github.com/librenms/librenms/pull/4063))
    - Acano ([PR4064](https://github.com/librenms/librenms/pull/4064))
    - McAfee SIEM Nitro ([PR4066](https://github.com/librenms/librenms/pull/4064))
    - HP Bladesystem C3000/C7000 OA ([PR4035](https://github.com/librenms/librenms/pull/4035))
    - Cisco VCS (Expressway) ([PR4086](https://github.com/librenms/librenms/pull/4086))
    - Cisco Telepresence Conductor ([PR4087](https://github.com/librenms/librenms/pull/4087))
    - Avaya VSP ([PR4048](https://github.com/librenms/librenms/pull/4048))
    - Cisco/Tandberg Video Conferencing ([PR4065](https://github.com/librenms/librenms/pull/4065))
    - Cisco Prime Infrastructure ([PR4088](https://github.com/librenms/librenms/pull/4088))
    - HWGroup STE2 ([PR4116](https://github.com/librenms/librenms/pull/4116))
    - HP 2530 Procurve / Arube ([PR4119](https://github.com/librenms/librenms/pull/4119))
    - Brother Printers ([PR4141](https://github.com/librenms/librenms/pull/4141))
    - Hytera Repeater ([PR4163](https://github.com/librenms/librenms/pull/4163))
    - Sonus ([PR4176](https://github.com/librenms/librenms/pull/4176))
    - Freeswitch ([PR4203](https://github.com/librenms/librenms/pull/4203))
  - WebUI
    - Improved OSPF display ([PR3908](https://github.com/librenms/librenms/pull/3908))
    - Improved Apps overview page ([PR3954](https://github.com/librenms/librenms/pull/3954))
    - Improved Syslog page ([PR3955](https://github.com/librenms/librenms/pull/3955), [PR3971](https://github.com/librenms/librenms/pull/3971))
    - Rewrite availability map ([PR4043](https://github.com/librenms/librenms/pull/4043))
    - Add predicted usage to billing overview ([PR4049](https://github.com/librenms/librenms/pull/4049))
  - API
    - Added services calls to API ([PR4215](https://github.com/librenms/librenms/pull/4215))
  - Discovery / Polling
    - Added CPU detection for Dell PowerConnect 8024F ([PR3966](https://github.com/librenms/librenms/pull/3966))
    - Cisco VSS state discovery ([PR3977](https://github.com/librenms/librenms/pull/3977))
    - Refactor of BGP Discovery and Polling (mainly JunOS) ([PR3938](https://github.com/librenms/librenms/pull/3938))
    - Added Sensors for Brocade NOS ([PR3969](https://github.com/librenms/librenms/pull/3969))
    - Cisco ASA HA States ([PR4012](https://github.com/librenms/librenms/pull/4012))
    - Improved IPSLA Support ([PR4006](https://github.com/librenms/librenms/pull/4006))
    - Added support for CISCO-NTP-MIB ([PR4005](https://github.com/librenms/librenms/pull/4005))
    - Improved toner support for Ricoh devices ([PR4180](https://github.com/librenms/librenms/pull/4180))
  - Documentation
    - New doc site live http://docs.librenms.org/
    - Added rsyslog 5 example to syslog docs ([PR3912](https://github.com/librenms/librenms/pull/3912))
    - Application doc updates ([PR3928](https://github.com/librenms/librenms/pull/3928))
  - Applications
    - App OS Updates support ([PR3935](https://github.com/librenms/librenms/pull/3935))
    - PowerDNS Recursor improvements ([PR3932](https://github.com/librenms/librenms/pull/3932))
    - Add DHCP Stats support ([PR3970](https://github.com/librenms/librenms/pull/3970))
    - Added snmp support to Memcached ([PR3949](https://github.com/librenms/librenms/pull/3949))
    - Added Unbound support ([PR4074](https://github.com/librenms/librenms/pull/4074))
    - Added snmp support to Proxmox ([PR4052](https://github.com/librenms/librenms/pull/4052))
    - Added Raspberry Pi Sensor support ([PR4057](https://github.com/librenms/librenms/pull/4057))
    - Updated NTPD support ([PR4077](https://github.com/librenms/librenms/pull/4077))
  - Misc
    - Added cleanup of old RRD files to daily.sh ([PR3907](https://github.com/librenms/librenms/pull/3907))
    - Refactored addHost event logs ([PR3929](https://github.com/librenms/librenms/pull/3929), [PR3997](https://github.com/librenms/librenms/pull/3997))
    - Refactored RRD Functions ([PR3800](https://github.com/librenms/librenms/pull/3800), [PR4081](https://github.com/librenms/librenms/pull/4081))
    - Added support for nets-exclude in snmp-scan ([PR4000](https://github.com/librenms/librenms/pull/4045))
    - Refactored files in html (Libraries and PSR2 style ([PR4071](https://github.com/librenms/librenms/pull/4071), [PR4101](https://github.com/librenms/librenms/pull/4101), [PR4117](https://github.com/librenms/librenms/pull/4117))
    - Various IRC updates and fixes ([PR4200](https://github.com/librenms/librenms/pull/4200), [PR4204](https://github.com/librenms/librenms/pull/4204), [PR4201](https://github.com/librenms/librenms/pull/4201))

### July 2016

#### Bug fixes
  - API
    - Stop outputting vrf lite and IP info when device doesn't exist ([PR3785](https://github.com/librenms/librenms/pull/3785))
  - WebUI
    - Added force refresh for generic image widget ([PR3817](https://github.com/librenms/librenms/pull/3817))
    - Fixed NFSen tab not showing in all cases ([PR3857](https://github.com/librenms/librenms/pull/3857))
  - Discovery / Polling
    - Fixed incorrect IBM-AMM thresholds ([PR3866](https://github.com/librenms/librenms/pull/3866))
    - Fixed Pulse OS whitespace in polling ([PR3883](https://github.com/librenms/librenms/pull/3883))
  - Misc
    - Fixed device group search ([PR3788](https://github.com/librenms/librenms/pull/3788))
    - Fixed sporadic device delete ([PR3805](https://github.com/librenms/librenms/pull/3805))
    - Retry creation of two tables ([PR3848](https://github.com/librenms/librenms/pull/3848))

#### Improvements
  - Added / improved detection for:
    - Telco systems ([PR3773](https://github.com/librenms/librenms/pull/3773), [PR3804](https://github.com/librenms/librenms/pull/3804))
    - Cisco ACS ([PR3786](https://github.com/librenms/librenms/pull/3786))
    - Adtran AOS ([PR3787](https://github.com/librenms/librenms/pull/3787), [PR3799](https://github.com/librenms/librenms/pull/3799))
    - Lantronix SLC ([PR3797](https://github.com/librenms/librenms/pull/3797))
    - PBN Sensor support ([PR3820](https://github.com/librenms/librenms/pull/3820))
    - Ironware VRF discovery ([PR3827](https://github.com/librenms/librenms/pull/3827))
    - Comware sensors discovery ([PR3881](https://github.com/librenms/librenms/pull/3881), [PR3889](https://github.com/librenms/librenms/pull/3889), [PR3896](https://github.com/librenms/librenms/pull/3896))
    - Brocade VDX detection ([PR3888](https://github.com/librenms/librenms/pull/3888))
    - Checkpoint GAiA ([PR3890](https://github.com/librenms/librenms/pull/3890))
    - Cisco ASA-X Hardware detection ([PR3897](https://github.com/librenms/librenms/pull/3897))
  - WebUI
    - Added sysName to global search if != hostname ([PR3815](https://github.com/librenms/librenms/pull/3815))
    - Improved look of device SLA panel ([PR3831](https://github.com/librenms/librenms/pull/3831))
    - Added more colours to Cisco CBQOS graphs ([PR3842](https://github.com/librenms/librenms/pull/3842))
    - Improved look of Cisco IPSEC Tunnels page ([PR3874](https://github.com/librenms/librenms/pull/3874))
  - Discovery / Polling
    - Added ability to set Max repeaters per device ([PR3781](https://github.com/librenms/librenms/pull/3781))
  - Applications
    - Moved all application scripts to librenms/librenms-agent repo ([PR3865](https://github.com/librenms/librenms/pull/3865), [PR3886](https://github.com/librenms/librenms/pull/3886))
    - Added NFS stats ([PR3792](https://github.com/librenms/librenms/pull/3792), [PR3853](https://github.com/librenms/librenms/pull/3853))
    - Added PowerDNS Recursor ([PR3869](https://github.com/librenms/librenms/pull/3869))
  - Alerting
    - Updated format for Slack alerts ([PR3852](https://github.com/librenms/librenms/pull/3852))
    - Added support for multiple emails in sysContact and users table ([PR3885](https://github.com/librenms/librenms/pull/3885))
    - Added ability to use uptime in alert templates ([PR3893](https://github.com/librenms/librenms/pull/3893))
  - Misc
    - Added date to git version info ([PR3782](https://github.com/librenms/librenms/pull/3782))
    - Added logging of versions when upgrading ([PR3807](https://github.com/librenms/librenms/pull/3807))
    - Added ability to lookup device from IP for syslog ([PR3812](https://github.com/librenms/librenms/pull/3812))
    - Updated component system ([PR3821](https://github.com/librenms/librenms/pull/3821))
    - Improvements to validate script ([PR3840](https://github.com/librenms/librenms/pull/3840), [PR3868](https://github.com/librenms/librenms/pull/3868))

### June 2016

#### Bug fixes
  - WebUI:
    - Rename $ds to $ldap_connection for auth modules ([PR3596](https://github.com/librenms/librenms/pull/3596))
    - Fix the display of custom snmp ports ([PR3646](https://github.com/librenms/librenms/pull/3646))
    - Fix bugs in Create new / edit alert templates ([PR3651](https://github.com/librenms/librenms/pull/3651))
    - Fixed ajax_ calls for use with base_url ([PR3661](https://github.com/librenms/librenms/pull/3661))
    - Updated old frontpage to use new services format ([PR3691](https://github.com/librenms/librenms/pull/3691))
    - Order alerts by state to indicate which alerts are open ([PR3692](https://github.com/librenms/librenms/pull/3692))
    - Fixed maintenance windows showing as lapsed ([PR3704](https://github.com/librenms/librenms/pull/3704))
    - Removed duplicated dbInsert from dashboard creation ([PR3761](https://github.com/librenms/librenms/pull/3761))
    - Fixed 95th for graphs ([PR3762](https://github.com/librenms/librenms/pull/3762))
  - Polling / Discovery:
    - Updated Poweralert divisor to 10 for sensors ([PR3645](https://github.com/librenms/librenms/pull/3645))
    - Fixed NX-OS version polling ([PR3688](https://github.com/librenms/librenms/pull/3688))
    - Fixed STP log spam from Mikrotik device ([PR3689](https://github.com/librenms/librenms/pull/3689))
    - Removed " from ZyWall version number ([PR3693](https://github.com/librenms/librenms/pull/3693))
    - Updated register_mib to use d_echo ([PR3739](https://github.com/librenms/librenms/pull/3739))
    - Fixed invalid SQL for BGP Discovery ([PR3742](https://github.com/librenms/librenms/pull/3742))
  - Alerting:
    - Unacknowledged alerts will now continue to send alerts ([PR3667](https://github.com/librenms/librenms/pull/3667))
  - Misc:
    - Fix smokeping path in gen_smokeping ([PR3577](https://github.com/librenms/librenms/pull/3577))
    - Fix full include path in includes/polling/functions.inc.php ([PR3614](https://github.com/librenms/librenms/pull/3614))
    - Added port_id to tune_port.php query ([PR3753](https://github.com/librenms/librenms/pull/3753))
    - Updated port schema to support > 17.1 Gbs for _rate values ([PR3754](https://github.com/librenms/librenms/pull/3754))

#### Improvements
  - Added / improved detection for:
    - HPE 3Par ([PR3578](https://github.com/librenms/librenms/pull/3578))
    - Buffalo TeraStation ([PR3587](https://github.com/librenms/librenms/pull/3587))
    - Samsung C printers ([PR3598](https://github.com/librenms/librenms/pull/3598))
    - Roomalert3e ([PR3599](https://github.com/librenms/librenms/pull/3599))
    - Avtech Switches ([PR3611](https://github.com/librenms/librenms/pull/3611))
    - IBM Bladecenter switches ([PR3623](https://github.com/librenms/librenms/pull/3623))
    - HWg support ([PR3624](https://github.com/librenms/librenms/pull/3624))
    - IBM IMM ([PR3625](https://github.com/librenms/librenms/pull/3625))
    - ServerTech Sentry4 PDUs ([PR3659](https://github.com/librenms/librenms/pull/3659))
    - SwOS ([PR3662](https://github.com/librenms/librenms/pull/3662))
    - Sophos (R3678, [PR3679](https://github.com/librenms/librenms/pull/3679), [PR3736](https://github.com/librenms/librenms/pull/3736))
    - OSX El Capitan ([PR3690](https://github.com/librenms/librenms/pull/3690))
    - DNOS ([PR3703](https://github.com/librenms/librenms/pull/3703), [PR3730](https://github.com/librenms/librenms/pull/3730))
    - Cisco SB SG200 ([PR3705](https://github.com/librenms/librenms/pull/3705))
    - EMC FlareOS ([PR3712](https://github.com/librenms/librenms/pull/3712))
    - Enhance Brocade Fabric OS ([PR3712](https://github.com/librenms/librenms/pull/3712))
    - Huawei SmartAX ([PR3737](https://github.com/librenms/librenms/pull/3737))
  - Polling / Discovery:
    - Use lsb_release in distro script ([PR3580](https://github.com/librenms/librenms/pull/3580))
    - Allow lmsensors fanspeeds of 0 to be discovered ([PR3616](https://github.com/librenms/librenms/pull/3616))
    - Added support for rrdcached application monitoring ([PR3627](https://github.com/librenms/librenms/pull/3627))
    - Improve the output of polling/debug to make it easier to see modules ([PR3694](https://github.com/librenms/librenms/pull/3694))
  - WebUI:
    - Resolve some reported security issues ([PR3586](https://github.com/librenms/librenms/pull/3586)) With thanks to https://twitter.com/wireghoul
    - Order apps list alphabetically ([PR3600](https://github.com/librenms/librenms/pull/3600))
    - Network map improvements ([PR3602](https://github.com/librenms/librenms/pull/3602))
    - Added support for varying hostname formats in Oxidized integration ([PR3617](https://github.com/librenms/librenms/pull/3617))
    - Added device hw/location on hover in alerts table ([PR3621](https://github.com/librenms/librenms/pull/3621))
    - Updated unpolled notification to link directly to those devices ([PR3696](https://github.com/librenms/librenms/pull/3696))
    - Added ability to search via IP for Graylog integration ([PR3697](https://github.com/librenms/librenms/pull/3697))
    - Optimised network map SQL ([PR3715](https://github.com/librenms/librenms/pull/3715))
    - Added support for wildcards in custom graph groups ([PR3722](https://github.com/librenms/librenms/pull/3722))
    - Added ability to override ifSpeed for ports ([PR3752](https://github.com/librenms/librenms/pull/3752))
    - Added sysName to global search ([PR3757](https://github.com/librenms/librenms/pull/3757))
  - Alerting:
    - Added ability to use location in alert templates ([PR3652](https://github.com/librenms/librenms/pull/3652))
  - Documentation:
    - Added docs on Auto discovery ([PR3671](https://github.com/librenms/librenms/pull/3671))
    - Updated InfluxDB docs ([PR3673](https://github.com/librenms/librenms/pull/3673))
    - Updated distributed polling docs ([PR3675](https://github.com/librenms/librenms/pull/3675))
    - Updated FAQs ([PR3677](https://github.com/librenms/librenms/pull/3677))
  - Misc:
    - Added pivot table for device groups ready for V2 ([PR3589](https://github.com/librenms/librenms/pull/3589))
    - Added device_id column to eventlog ([PR3682](https://github.com/librenms/librenms/pull/3682))
    - Cleanup sensors and related tables + added constraints ([PR3745](https://github.com/librenms/librenms/pull/3745))

### May 2016

#### Bug fixes
  - WebUI:
    - Fixed broken performance charts using VisJS ([PR3479](https://github.com/librenms/librenms/pull/3479))
    - Fixed include path to file in create alert item ([PR3480](https://github.com/librenms/librenms/pull/3480))
    - Updated services box on front page to utilise the new services ([PR3481](https://github.com/librenms/librenms/pull/3481))
    - Potential fix for intermittent logouts ([PR3372](https://github.com/librenms/librenms/pull/3372))
    - Updated sensors hostname to use correct variable ([PR3485](https://github.com/librenms/librenms/pull/3485))
  - Polling / Discovery:
    - Only poll AirMAX if device supports the MIB ([PR3486](https://github.com/librenms/librenms/pull/3486))
  - Alerting:
    - Don't alert unless the sensor value surpasses the threshold ([PR3507](https://github.com/librenms/librenms/pull/3507))

#### Improvements
  - Added / improved detection for:
    - Microsemo timing devices ([PR3453](https://github.com/librenms/librenms/pull/3453))
    - Bintec smart routers ([PR3454](https://github.com/librenms/librenms/pull/3454))
    - PoweWalker support ([PR3456](https://github.com/librenms/librenms/pull/3456))
    - BDCom support ([PR3459](https://github.com/librenms/librenms/pull/3459))
    - Cisco WAPs ([PR3460](https://github.com/librenms/librenms/pull/3460))
    - EMC Data domain ([PR3461](https://github.com/librenms/librenms/pull/3461))
    - Xerox support ([PR3462](https://github.com/librenms/librenms/pull/3462))
    - Calix support ([PR3463](https://github.com/librenms/librenms/pull/3463))
    - Isilon OneFS ([PR3482](https://github.com/librenms/librenms/pull/3482))
    - Ricoh printers ([PR3483](https://github.com/librenms/librenms/pull/3483))
    - HP Virtual Connect ([PR3487](https://github.com/librenms/librenms/pull/3487))
    - Equallogic arrays + Dell servers ([PR3519](https://github.com/librenms/librenms/pull/3519))
    - Alcatel-Lucent SR + SAR ([PR3535](https://github.com/librenms/librenms/pull/3535), [PR3553](https://github.com/librenms/librenms/pull/3553))
    - Xirrus Wireless Access Points ([PR3543](https://github.com/librenms/librenms/pull/3543))
  - Polling / Discovery:
    - Add config option to stop devices with duplicate sysName's being added ([PR3473](https://github.com/librenms/librenms/pull/3473))
    - Enable discovery support of CDP neighbours by IP ([PR3561](https://github.com/librenms/librenms/pull/3561))
  - Alerting:
    - Added ability to use sysName in templates ([PR3470](https://github.com/librenms/librenms/pull/3470))
    - Send Slack alerts as pure JSON ([PR3522](https://github.com/librenms/librenms/pull/3522))
    - Apply colour to HipChat messages ([PR3539](https://github.com/librenms/librenms/pull/3539))
  - WebUI:
    - Added ability to filter alerts by state ([PR3471](https://github.com/librenms/librenms/pull/3471))
    - Added support for using local openstreet map tiles ([PR3472](https://github.com/librenms/librenms/pull/3472))
    - Added ability to show services on availability map ([PR3496](https://github.com/librenms/librenms/pull/3496))
    - Added combined auth module for http auth and AD auth ([PR3531](https://github.com/librenms/librenms/pull/3531))
    - List services alphabetically ([PR3538](https://github.com/librenms/librenms/pull/3538))
    - Added support for scrollable widgets ([PR3565](https://github.com/librenms/librenms/pull/3565))
  - Graphs:
    - Added Hit/Misses for memcached graphs ([PR3499](https://github.com/librenms/librenms/pull/3499))
  - API:
    - Update get_graph_generic_by_hostname to use device_id as well ([PR3494](https://github.com/librenms/librenms/pull/3494))
  - Docs:
    - Added configuration for SNMP Proxy support ([PR3528](https://github.com/librenms/librenms/pull/3528))
  - Misc:
    - Added purge for alert log ([PR3469](https://github.com/librenms/librenms/pull/3469))

### April 2016

#### Bug fixes
  - Discovery / Polling:
    - Fix poweralert OS detection ([PR3414](https://github.com/librenms/librenms/pull/3414))
  - WebUI:
    - Fixed headers for varying ajax calls ([PR3432](https://github.com/librenms/librenms/pull/3432), [PR3433](https://github.com/librenms/librenms/pull/3433), [PR3434](https://github.com/librenms/librenms/pull/3434), [PR3435](https://github.com/librenms/librenms/pull/3435))
  - Misc:
    - Update syslog to support incorrect time ([PR3348](https://github.com/librenms/librenms/pull/3348))
    - Fixed InfluxDB to send data as int/float ([PR3354](https://github.com/librenms/librenms/pull/3354))
    - Small bug fixes to the services update ([PR3366](https://github.com/librenms/librenms/pull/3366), [PR3396](https://github.com/librenms/librenms/pull/3396), [PR3425](https://github.com/librenms/librenms/pull/3425), [PR3426](https://github.com/librenms/librenms/pull/3426), [PR3427](https://github.com/librenms/librenms/pull/3427))
    - Fix bug with obtaining data for new bills in some scenarios ([PR3404](https://github.com/librenms/librenms/pull/3404))
    - Improved PHP 7 support ([PR3417](https://github.com/librenms/librenms/pull/3417))
    - Fix urls within billing section for sub dir support ([PR3442](https://github.com/librenms/librenms/pull/3442))

#### Improvements
  - WebUI:
    - Update rancid file detection ([PR3341](https://github.com/librenms/librenms/pull/3341))
    - Make graphs in widgets clickable ([PR3355](https://github.com/librenms/librenms/pull/3355))
    - Add config option to set the typeahead results ([PR3363](https://github.com/librenms/librenms/pull/3363))
    - Add config option to set min graph height ([PR3410](https://github.com/librenms/librenms/pull/3410))
  - Discovery / Polling:
    - Updated Infoblox mibs and logo ([PR3340](https://github.com/librenms/librenms/pull/3340))
    - Updated arp discovery to support vrf lite ([PR3359](https://github.com/librenms/librenms/pull/3359))
    - Added RSSI and MNC for Cisco WWAN routers ([PR3371](https://github.com/librenms/librenms/pull/3371))
    - Updated DNOS and added CPU, Memory and Temp ([PR3391](https://github.com/librenms/librenms/pull/3391), [PR3393](https://github.com/librenms/librenms/pull/3393), [PR3395](https://github.com/librenms/librenms/pull/3395))
    - Added PoE state support for Netonix devices ([PR3416](https://github.com/librenms/librenms/pull/3416))
    - Added ability to exclude ports via ifName and ifAlias regex ([PR3439](https://github.com/librenms/librenms/pull/3439))
  - Added detection for:
    - Viprenet routers ([PR3365](https://github.com/librenms/librenms/pull/3365))
    - FreeBSD via distro script ([PR3399](https://github.com/librenms/librenms/pull/3399))
  - Documentation:
    - Updated nginx install docs ([PR3397](https://github.com/librenms/librenms/pull/3397))
    - Added FAQ on renaming hosts ([PR3444](https://github.com/librenms/librenms/pull/3444))
  - API:
    - Added call for IPsec tunnels ([PR3411](https://github.com/librenms/librenms/pull/3411))
  - Misc:
    - Added check_mk FreeBSD agent support ([PR3406](https://github.com/librenms/librenms/pull/3406))
    - Added suggestion to fix files not owned by correct user to validate.php ([PR3415](https://github.com/librenms/librenms/pull/3415))
    - Added detection for missing timezone to validate.php ([PR3428](https://github.com/librenms/librenms/pull/3428))
    - Added detection for install_dir config and local git repo issues to validate.php ([PR3440](https://github.com/librenms/librenms/pull/3440))

### March 2016

#### Bug fixes
  - WebUI:
    - Skip authentication check in graph.php if unauth graphs is enabled ([PR3019](https://github.com/librenms/librenms/pull/3019))
    - Stop double escaping notes for devices ([PR3149](https://github.com/librenms/librenms/pull/3149))
    - Corrected aggregate graph on smokeping page ([PR3177](https://github.com/librenms/librenms/pull/3177))
    - Fix non-admin syslog queries ([PR3191](https://github.com/librenms/librenms/pull/3191))
    - Fix services SQL ([PR3205](https://github.com/librenms/librenms/pull/3205))
  - Discovery / Polling:
    - Revert arp discovery to pre-vrf lite support ([PR3126](https://github.com/librenms/librenms/pull/3126))
    - Fix IOS-XR DBM sensors ([PR3291](https://github.com/librenms/librenms/pull/3291))
  - Alerting:
    - Fix alert failure response from transports ([PR3283](https://github.com/librenms/librenms/pull/3283))
  - Misc:
    - Fix data in bills if counters doesn't change ([PR3132](https://github.com/librenms/librenms/pull/3132))
    - Improve performance of billing poller ([PR3129](https://github.com/librenms/librenms/pull/3129))
    - Fix API tokens when using LDAP auth ([PR3178](https://github.com/librenms/librenms/pull/3178))
    - Import notifications with original datetime ([PR3200](https://github.com/librenms/librenms/pull/3200))
    - Add sysName for top-interfaces widget ([PR3201](https://github.com/librenms/librenms/pull/3201))
    - Fix Cisco syslog parsing when logging timestamp enabled ([PR3203](https://github.com/librenms/librenms/pull/3203))

#### Improvements
  - WebUI:
    - Added ability to show device group specific maps ([PR3018](https://github.com/librenms/librenms/pull/3018))
    - Updated Billing UI ([PR3194](https://github.com/librenms/librenms/pull/3194), [PR3195](https://github.com/librenms/librenms/pull/3195), [PR3216](https://github.com/librenms/librenms/pull/3216), [PR3239](https://github.com/librenms/librenms/pull/3239), [PR3240](https://github.com/librenms/librenms/pull/3240))
    - Added Juniper
    - Added config option for HTML emails in mail transport ([PR3221](https://github.com/librenms/librenms/pull/3221))
  - Discovery / Polling:
    - Added Juniper state support ([PR3121](https://github.com/librenms/librenms/pull/3121))
    - Added Ironware state support ([PR3160](https://github.com/librenms/librenms/pull/3160))
    - Check sysObjectID before detecting ILO temp sensors ([PR3204](https://github.com/librenms/librenms/pull/3204))
    - Improved Avtech support ([PR3207](https://github.com/librenms/librenms/pull/3207))
    - Improved Dell NOS detection ([PR3213](https://github.com/librenms/librenms/pull/3213))
    - Added Juniper alarm state monitoring ([PR3226](https://github.com/librenms/librenms/pull/3226))
    - Updated Drac state support ([PR3228](https://github.com/librenms/librenms/pull/3228))
    - Improved serial # detection for Brocade Ironware devices ([PR3292](https://github.com/librenms/librenms/pull/3292))
  - Added detection for:
    - Develop Ineo printers ([PR3224](https://github.com/librenms/librenms/pull/3224))
    - Cumulus Linux ([PR3237](https://github.com/librenms/librenms/pull/3237))
    - Deliberant WiFi ([PR3246](https://github.com/librenms/librenms/pull/3246))
    - Juniper EX2500 ([PR3254](https://github.com/librenms/librenms/pull/3254))
    - Cambium devices ([PR3279](https://github.com/librenms/librenms/pull/3279))
  - Alerting:
    - Added Canopsis alerting transport ([PR3299](https://github.com/librenms/librenms/pull/3299))
  - Misc:
    - Improved syslog support ([PR3171](https://github.com/librenms/librenms/pull/3171), [PR3172](https://github.com/librenms/librenms/pull/3172), [PR3173](https://github.com/librenms/librenms/pull/3173))
    - Added Nginx install docs for Debian/Ubuntu ([PR3301](https://github.com/librenms/librenms/pull/3301))
    - Updated InfluxDB php module ([PR3302](https://github.com/librenms/librenms/pull/3302))
    - Updated Component API ([PR3304](https://github.com/librenms/librenms/pull/3304))

### February 2016

#### Bug fixes
  - Discovery / Polling:
    - Quote snmp v2c community ([PR2927](https://github.com/librenms/librenms/pull/2927))
    - For entity-sensor, changed variable name again ([PR2948](https://github.com/librenms/librenms/pull/2948))
    - Fix some issues with/introduced by port association mode configuration ([PR2923](https://github.com/librenms/librenms/pull/2923))
    - Deal with 0 value sensors better ([PR2972](https://github.com/librenms/librenms/pull/2972), [PR2973](https://github.com/librenms/librenms/pull/2973))
    - Reverted Fortigate CPU change from Dec 2015 ([PR2990](https://github.com/librenms/librenms/pull/2990))
    - Reverted bgp code from vrf lite support ([PR3010](https://github.com/librenms/librenms/pull/3010), [PR3011](https://github.com/librenms/librenms/pull/3011), [PR3028](https://github.com/librenms/librenms/pull/3028), [PR3050](https://github.com/librenms/librenms/pull/3050))
    - Add icon to database ([PR3076](https://github.com/librenms/librenms/pull/3076))
    - Discovery updated to check for distributed polling group ([PR3086](https://github.com/librenms/librenms/pull/3086))
  - WebUI:
    - Fix ceph graps ([PR2909](https://github.com/librenms/librenms/pull/2909), [PR2942](https://github.com/librenms/librenms/pull/2942))
    - BGP Overlib ([PR2915](https://github.com/librenms/librenms/pull/2915))
    - Added `application/json` headers where json is returned ([PR2936](https://github.com/librenms/librenms/pull/2936), [PR2961](https://github.com/librenms/librenms/pull/2961))
    - Stop realtime graph page from auto refreshing ([PR2939](https://github.com/librenms/librenms/pull/2939))
    - Updated parsing of alert rules to allow `|` ([PR2917](https://github.com/librenms/librenms/pull/2917))
    - Fix IP Display ([PR2951](https://github.com/librenms/librenms/pull/2951))
    - Added missing from email config option ([PR2986](https://github.com/librenms/librenms/pull/2986))
    - Ignore devices that do not provide an uptime statistic ([PR3009](https://github.com/librenms/librenms/pull/3009))
    - Added unique id for alert widget ([PR3034](https://github.com/librenms/librenms/pull/3034))
  - Misc:
    - Updated `device_by_id_cache()` to convert IP column ([PR2940](https://github.com/librenms/librenms/pull/2940))
    - Fixed auto updating if not enabled ([PR3063](https://github.com/librenms/librenms/pull/3063))
  - Documentation:
    - Removed devloping doc as none of the info is current ([PR2911](https://github.com/librenms/librenms/pull/2911))

#### Improvements
  - WebUI:
    - Merged device option links to dropdown ([PR2955](https://github.com/librenms/librenms/pull/2955))
    - Added ability to configure # results for global search ([PR2957](https://github.com/librenms/librenms/pull/2957))
    - Added ability to show / hide line numbers for config for devices ([PR2988](https://github.com/librenms/librenms/pull/2988))
    - Added support for showing diff for Oxidized configs ([PR2994](https://github.com/librenms/librenms/pull/2994))
    - Updated visjs to 4.14.0 ([PR3031](https://github.com/librenms/librenms/pull/3031))
    - Updated apps layout to use panels ([PR3117](https://github.com/librenms/librenms/pull/3117))
  - Discovery / Polling:
    - Added VRF Lite support ([PR2820](https://github.com/librenms/librenms/pull/2820))
    - Added ability to ignore device sensors from entity mib ([PR2862](https://github.com/librenms/librenms/pull/2862))
    - Added `ifOperStatus_prev` and `ifAdminStatus_prev` values to db ([PR2912](https://github.com/librenms/librenms/pull/2912))
    - Improved bgpPolling efficiency ([PR2967](https://github.com/librenms/librenms/pull/2967))
    - Use raw timeticks for uptime ([PR3021](https://github.com/librenms/librenms/pull/3021))
    - Introduced state monitoring ([PR3102](https://github.com/librenms/librenms/pull/3102))
  - Added detection for:
    - Dell Networking N2048 ([PR2949](https://github.com/librenms/librenms/pull/2949))
    - Calix E7 devices ([PR2958](https://github.com/librenms/librenms/pull/2958))
    - Improved support for Netonix ([PR2959](https://github.com/librenms/librenms/pull/2959))
    - Improved detection for Windows 10 ([PR2962](https://github.com/librenms/librenms/pull/2962))
    - Improved support for FortiOS ([PR2991](https://github.com/librenms/librenms/pull/2991))
    - Barracuda Spam firewall support ([PR2998](https://github.com/librenms/librenms/pull/2998))
    - Improved sysDescr parsing for Unifi Switches ([PR3020](https://github.com/librenms/librenms/pull/3020))
    - Canon iR ([PR3045](https://github.com/librenms/librenms/pull/3045))
    - Cisco SF500 ([PR3057](https://github.com/librenms/librenms/pull/3057))
    - Eaton UPS ([PR3066](https://github.com/librenms/librenms/pull/3066), [PR3067](https://github.com/librenms/librenms/pull/3067), [PR3070](https://github.com/librenms/librenms/pull/3070), [PR3071](https://github.com/librenms/librenms/pull/3071))
    - ServerIron / ServerIron ADX ([PR3074](https://github.com/librenms/librenms/pull/3074))
    - Additional Qnap sensors ([PR3088](https://github.com/librenms/librenms/pull/3088), [PR3089](https://github.com/librenms/librenms/pull/3089))
    - Avtech environment sensors ([PR3091](https://github.com/librenms/librenms/pull/3091))
  - Misc:
    - Added check for rrd vadility ([PR2908](https://github.com/librenms/librenms/pull/2908))
    - Add systemd unit file for the python poller service ([PR2913](https://github.com/librenms/librenms/pull/2913))
    - Added more detection to validate for bad installs ([PR2985](https://github.com/librenms/librenms/pull/2985))
    - Syslog cleanup ([PR3036](https://github.com/librenms/librenms/pull/3036), [PR3093](https://github.com/librenms/librenms/pull/3093), [PR3099](https://github.com/librenms/librenms/pull/3099))
  - Documentation:
    -  Added description of AD configuration options ([PR2910](https://github.com/librenms/librenms/pull/2910))
    -  Add description to mibbases polling ([PR2919](https://github.com/librenms/librenms/pull/2919))

### January 2016

#### Bug fixes
  - Discovery / Polling:
    - Ignore HC Broadcast and Multicast counters for Cisco SB ([PR2552](https://github.com/librenms/librenms/pull/2552))
    - Fix Cisco temperature discovery ([PR2765](https://github.com/librenms/librenms/pull/2765))
  - WebUI:
    - Fix ajax_search.php returning null instead of [] ([PR2695](https://github.com/librenms/librenms/pull/2695))
    - Fix notification links ([PR2721](https://github.com/librenms/librenms/pull/2721))
    - Fix wrong suggestion to install PEAR in Web installer ([PR2727](https://github.com/librenms/librenms/pull/2727))
    - Fixed mysqli support for Web installer ([PR2730](https://github.com/librenms/librenms/pull/2730))
  - Misc:
    - Fix deleting device_perf entries ([PR2755](https://github.com/librenms/librenms/pull/2755))
    - Fix for schema updates to device table when poller is running ([PR2825](https://github.com/librenms/librenms/pull/2825))

#### Improvements
  - WebUI:
    - Converted arp pages to use bootgrid ([PR2669](https://github.com/librenms/librenms/pull/2669))
    - Updated VMWare listing page ([PR2684](https://github.com/librenms/librenms/pull/2684))
    - Updated typeahead.js ([PR2698](https://github.com/librenms/librenms/pull/2698))
    - Added ability to set notes for ports ([PR2688](https://github.com/librenms/librenms/pull/2688))
    - Use browser width to scale CPU and Bandwidth graphs ([PR2537](https://github.com/librenms/librenms/pull/2537), [PR2633](https://github.com/librenms/librenms/pull/2633))
    - Removed onClick from ports list ([PR2744](https://github.com/librenms/librenms/pull/2744))
    - Added support for showing sysName when hostname is IP ([PR2796](https://github.com/librenms/librenms/pull/2796))
    - Updated rancid support for different hostnames ([PR2807](https://github.com/librenms/librenms/pull/2807))
    - Added combined HTTP Auth and LDAP Auth authentication module ([PR2835](https://github.com/librenms/librenms/pull/2835))
    - Added ability to filter alerts using widgets ([PR2834](https://github.com/librenms/librenms/pull/2834))
  - Discovery / Polling:
    - Print runtime info per poller/discovery modules ([PR2713](https://github.com/librenms/librenms/pull/2713))
    - Improved polling/discovery vmware module performance ([PR2696](https://github.com/librenms/librenms/pull/2696))
    - Added STP/RSTP support ([PR2690](https://github.com/librenms/librenms/pull/2690))
    - Moved system poller module to core module ([PR2637](https://github.com/librenms/librenms/pull/2637))
    - Added lookup of IP for devices with hostname ([PR2798](https://github.com/librenms/librenms/pull/2798))
    - Centralised sensors module file structure ([PR2794](https://github.com/librenms/librenms/pull/2794))
    - Graph poller module run times ([PR2849](https://github.com/librenms/librenms/pull/2849))
    - Updated vlan support using IEEE8021-Q-BRIDGE-MIB ([PR2851](https://github.com/librenms/librenms/pull/2851))
  - Added detection for:
    - Added support for Samsung printers ([PR2680](https://github.com/librenms/librenms/pull/2680))
    - Added support for Canon printers ([PR2687](https://github.com/librenms/librenms/pull/2687))
    - Added support for Sub10 support ([PR2469](https://github.com/librenms/librenms/pull/2469))
    - Added support for Zyxel GS range ([PR2729](https://github.com/librenms/librenms/pull/2729))
    - Added support for HWGroup Poseidon ([PR2742](https://github.com/librenms/librenms/pull/2742))
    - Added support for Samsung SCX printers ([PR2760](https://github.com/librenms/librenms/pull/2760))
    - Added additional support for HP MSM ([PR2766](https://github.com/librenms/librenms/pull/2766), [PR2768](https://github.com/librenms/librenms/pull/2768))
    - Added additional support for Cisco ASA and RouterOS ([PR2784](https://github.com/librenms/librenms/pull/2784))
    - Added support for Lenovo EMC NAS ([PR2795](https://github.com/librenms/librenms/pull/2795))
    - Added support for Infoblox ([PR2801](https://github.com/librenms/librenms/pull/2801))
  - API:
    - Added support for Oxidized groups ([PR2745](https://github.com/librenms/librenms/pull/2745))
  - Misc:
    - Added option to specify Smokeping ping value ([PR2676](https://github.com/librenms/librenms/pull/2676))
    - Added backend support for InfluxDB ([PR2208](https://github.com/librenms/librenms/pull/2208))
    - Alpha2 release of MIB Polling released ([PR2536](https://github.com/librenms/librenms/pull/2536), [PR2763](https://github.com/librenms/librenms/pull/2763))
    - Centralised version info ([PR2697](https://github.com/librenms/librenms/pull/2697))
    - Added username support for libvirt over SSH ([PR2728](https://github.com/librenms/librenms/pull/2728))
    - Added Oxidized reload call when adding device ([PR2792](https://github.com/librenms/librenms/pull/2792))
    - Added components system to centralize data in MySQL ([PR2623](https://github.com/librenms/librenms/pull/2623))

### December 2015

#### Bug fixes
  - WebUI:
    - Fixed regex for negative lat/lng coords ([PR2524](https://github.com/librenms/librenms/pull/2524))
    - Fixed map page looping due to device connected to itself ([PR2545](https://github.com/librenms/librenms/pull/2545))
    - Fixed PATH_INFO for nginx ([PR2551](https://github.com/librenms/librenms/pull/2551))
    - urlencode the custom port types ([PR2597](https://github.com/librenms/librenms/pull/2597))
    - Stop non-admin users from being able to get to settings pages ([PR2627](https://github.com/librenms/librenms/pull/2627))
    - Fix JpGraph php version compare ([PR2631](https://github.com/librenms/librenms/pull/2631))
  - Discovery / Polling:
    - Pointed snmp calls for Huawei to correct MIB folder ([PR2541](https://github.com/librenms/librenms/pull/2541))
    - Fixed Ceph unix-agent support. ([PR2588](https://github.com/librenms/librenms/pull/2588))
    - Moved memory graphs from storage to memory polling ([PR2616](https://github.com/librenms/librenms/pull/2616))
    - Mask alert_log mysql output when debug is enabled to stop console crashes ([PR2618](https://github.com/librenms/librenms/pull/2618))
    - Stop Quanta devices being detected as Ubiquiti ([PR2632](https://github.com/librenms/librenms/pull/2632))
    - Fix MySQL unix-agent graphs ([PR2645](https://github.com/librenms/librenms/pull/2645))
    - Added MTA-MIB and NETWORK-SERVICES-MIB to stop warnings printed in poller debug ([PR2653](https://github.com/librenms/librenms/pull/2653))
  - Services:
    - Fix SSL check for PHP 7 ([PR2647](https://github.com/librenms/librenms/pull/2647))
  - Alerting:
    - Fix glue-expansion for alerts ([PR2522](https://github.com/librenms/librenms/pull/2522))
    - Fix HipChat transport ([PR2586](https://github.com/librenms/librenms/pull/2586))
  - Documentation:
    - Removed duplicate mysql-client install from Debian/Ubuntu install docs ([PR2543](https://github.com/librenms/librenms/pull/2543))
  - Misc:
    - Update daily.sh to ignore issues writing to log file ([PR2595](https://github.com/librenms/librenms/pull/2595))

#### Improvements
  - WebUI:
    - Converted sensors page to use bootgrid ([PR2531](https://github.com/librenms/librenms/pull/2531))
    - Added new widgets for dashboard. Notes ([PR2582](https://github.com/librenms/librenms/pull/2582)), Generic image ([PR2617](https://github.com/librenms/librenms/pull/2617))
    - Added config option to disable lazy loading of images ([PR2589](https://github.com/librenms/librenms/pull/2589))
    - Visual update to Navbar. ([PR2593](https://github.com/librenms/librenms/pull/2593))
    - Update alert rules to show actual alert rule ID ([PR2603](https://github.com/librenms/librenms/pull/2603))
    - Initial support added for per user default dashboard ([PR2620](https://github.com/librenms/librenms/pull/2620))
    - Updated Worldmap to show clusters in red if one device is down ([PR2621](https://github.com/librenms/librenms/pull/2621))
    - Cleaned up Billing pages ([PR2671](https://github.com/librenms/librenms/pull/2671))
  - Discovery / Polling
    - Added traffic bits as default for Cambium devices ([PR2525](https://github.com/librenms/librenms/pull/2525))
    - Overwrite eth0 port data from UniFi MIBs for AirFibre devices ([PR2544](https://github.com/librenms/librenms/pull/2544))
    - Added lastupdate column to sensors table for use with alerts ([PR2590](https://github.com/librenms/librenms/pull/2590),[PR2592](https://github.com/librenms/librenms/pull/2592))
    - Updated auto discovery via lldp to check for devices that use mac address in lldpRemPortId ([PR2591](https://github.com/librenms/librenms/pull/2591))
    - Updated auto discovery via lldp with absent lldpRemSysName ([PR2619](https://github.com/librenms/librenms/pull/2619))
  - API:
    - Added ability to filter devices by type and os for Oxidized API call ([PR2539](https://github.com/librenms/librenms/pull/2539))
    - Added ability to update device information ([PR2585](https://github.com/librenms/librenms/pull/2585))
    - Added support for returning device groups ([PR2611](https://github.com/librenms/librenms/pull/2611))
    - Added ability to select port graphs based on ifDescr ([PR2648](https://github.com/librenms/librenms/pull/2648))
  - Documentation:
    - Improved alerting docs explaining more options ([PR2560](https://github.com/librenms/librenms/pull/2560))
    - Added Docs for Ubuntu/Debian Smokeping integration ([PR2610](https://github.com/librenms/librenms/pull/2610))
  - Added detection for:
    - Updated Netonix switch MIBs ([PR2523](https://github.com/librenms/librenms/pull/2523))
    - Updated Fotinet MIBs ([PR2529](https://github.com/librenms/librenms/pull/2529), [PR2534](https://github.com/librenms/librenms/pull/2534))
    - Cisco SG500 ([PR2609](https://github.com/librenms/librenms/pull/2609))
    - Updated processor support for Fortigate ([PR2613](https://github.com/librenms/librenms/pull/2613))
    - Added CPU / Memory support for PBN ([PR2672](https://github.com/librenms/librenms/pull/2672))
  - Misc:
    - Updated validation to check for php extension and classes required ([PR2602](https://github.com/librenms/librenms/pull/2602))
    - Added Radius Authentication support ([PR2615](https://github.com/librenms/librenms/pull/2615))
    - Removed distinct() from alerts query to use indexes ([PR2649](https://github.com/librenms/librenms/pull/2649))

### November 2015

#### Bug fixes
  - WebUI:
    - getRates should return in and out average rates ([PR2375](https://github.com/librenms/librenms/pull/2375))
    - Fix 95th percent lines in negative range ([PR2405](https://github.com/librenms/librenms/pull/2405))
    - Fix percentage bar for billing pages ([PR2419](https://github.com/librenms/librenms/pull/2419))
    - Use HC counters first in realtime graphs ([PR2420](https://github.com/librenms/librenms/pull/2420))
    - Fix netcmd.php URI for sub dir installations ([PR2428](https://github.com/librenms/librenms/pull/2428))
    - Fixed Oxidized fetch config with groups ([PR2501](https://github.com/librenms/librenms/pull/2501))
    - Fixed background colour to white for some graphs ([PR2516](https://github.com/librenms/librenms/pull/2516))
    - Added missing Service description on services page ([PR2679](https://github.com/librenms/librenms/pull/2679))
  - API:
    - Added missing quotes for MySQL queries ([PR2382](https://github.com/librenms/librenms/pull/2382))
  - Discovery / Polling:
    - Specified MIB used when polling ntpd-server ([PR2418](https://github.com/librenms/librenms/pull/2418))
    - Added missing fields when inserting data into applications table ([PR2445](https://github.com/librenms/librenms/pull/2445))
    - Fix auto-discovery failing ([PR2457](https://github.com/librenms/librenms/pull/2457))
    - Juniper hardware inventory fix ([PR2466](https://github.com/librenms/librenms/pull/2466))
    - Fix discovery of Cisco PIX running PixOS 8.0 ([PR2480](https://github.com/librenms/librenms/pull/2480))
    - Fix bug in Proxmox support if only one VM was detected ([PR2490](https://github.com/librenms/librenms/pull/2490), [PR2547](https://github.com/librenms/librenms/pull/2547))
  - Alerting:
    - Strip && and || from query for device-groups ([PR2476](https://github.com/librenms/librenms/pull/2476))
    - Fix transports being triggered when empty keys set ([PR2491](https://github.com/librenms/librenms/pull/2491))
  Misc:
    - Updated device_traffic_descr config to stop graphs failing ([PR2386](https://github.com/librenms/librenms/pull/2386))

#### Improvements
  - WebUI:
    - Status column now sortable for /devices/ ([PR2397](https://github.com/librenms/librenms/pull/2397))
    - Update Gridster library to be responsive ([PR2414](https://github.com/librenms/librenms/pull/2414))
    - Improved rrdtool 1.4/1.5 compatibility ([PR2430](https://github.com/librenms/librenms/pull/2430))
    - Use event_id in query for Eventlog ([PR2437](https://github.com/librenms/librenms/pull/2437))
    - Add graph selector to devices overview ([PR2438](https://github.com/librenms/librenms/pull/2438))
    - Improved Navbar for varying screen sizes ([PR2450](https://github.com/librenms/librenms/pull/2450))
    - Added RIPE NCC API support for lookups ([PR2455](https://github.com/librenms/librenms/pull/2455), [PR2474](https://github.com/librenms/librenms/pull/2474))
    - Improved ports page for device with large number of neighbours ([PR2460](https://github.com/librenms/librenms/pull/2460))
    - Merged all CPU graphs into one on overview page ([PR2470](https://github.com/librenms/librenms/pull/2470))
    - Added support for sorting by traffic on device port page ([PR2508](https://github.com/librenms/librenms/pull/2508))
    - Added support for dynamic graph sizes based on browser size ([PR2510](https://github.com/librenms/librenms/pull/2510))
    - Made device location clickable in device header ([PR2515](https://github.com/librenms/librenms/pull/2515))
    - Visual improvements to bills page ([PR2519](https://github.com/librenms/librenms/pull/2519))
  - Discovery / Polling:
    - Updated Cisco SB discovery ([PR2396](https://github.com/librenms/librenms/pull/2396))
    - Added Ceph support via Applications ([PR2412](https://github.com/librenms/librenms/pull/2412))
    - Added support for per device unix-agent port ([PR2439](https://github.com/librenms/librenms/pull/2439))
    - Added ability to select up/down devices on worldmap ([PR2441](https://github.com/librenms/librenms/pull/2441))
    - Allow powerdns app to be set for Unix Agent ([PR2489](https://github.com/librenms/librenms/pull/2489))
    - Added SLES detection to distro script ([PR2502](https://github.com/librenms/librenms/pull/2502))
  - Added detection for:
    - Added CPU + Memory usage for Ubiquiti UniFi ([PR2421](https://github.com/librenms/librenms/pull/2421))
    - Added support for LigoWave Infinity AP's ([PR2456](https://github.com/librenms/librenms/pull/2456))
  - Alerting:
    - Added ability to globally disable sending alerts ([PR2385](https://github.com/librenms/librenms/pull/2385))
    - Added support for Clickatell, PlaySMS and VictorOps ([PR24104](https://github.com/librenms/librenms/pull/24104), [PR2443](https://github.com/librenms/librenms/pull/2443))
  - Documentation:
    - Improved CentOS install docs ([PR2462](https://github.com/librenms/librenms/pull/2462))
    - Improved Proxmox setup docs ([PR2483](https://github.com/librenms/librenms/pull/2483))
  - Misc:
    - Provide InnoDB config for buffer size issues ([PR2401](https://github.com/librenms/librenms/pull/2401))
    - Added AD Authentication support ([PR2411](https://github.com/librenms/librenms/pull/2411), [PR2425](https://github.com/librenms/librenms/pull/2425), [PR2432](https://github.com/librenms/librenms/pull/2432), [PR2434](https://github.com/librenms/librenms/pull/2434))
    - Added Features document ([PR2436](https://github.com/librenms/librenms/pull/2436), [PR2511](https://github.com/librenms/librenms/pull/2511), [PR2513](https://github.com/librenms/librenms/pull/2513))
    - Centralised innodb buffer check and added to validate ([PR2482](https://github.com/librenms/librenms/pull/2482))
    - Updated and improved daily.sh ([PR2487](https://github.com/librenms/librenms/pull/2487))


### October 2015

#### Bug fixes
  - Discovery / Polling:
    - Check file exists via rrdcached before creating new files on 1.5 ([PR2041](https://github.com/librenms/librenms/pull/2041))
    - Fix Riverbed discovery ([PR2133](https://github.com/librenms/librenms/pull/2133))
    - Fixes issue where snmp_get would not return the value 0 ([PR2134](https://github.com/librenms/librenms/pull/2134))
    - Fixed powerdns snmp checks ([PR2176](https://github.com/librenms/librenms/pull/2176))
    - De-dupe checks for hostname when adding hosts ([PR2189](https://github.com/librenms/librenms/pull/2189))
  - WebUI:
    - Soft fail if PHP Pear not installed ([PR2036](https://github.com/librenms/librenms/pull/2036))
    - Escape quotes for ifAlias in overlib calls ([PR2072](https://github.com/librenms/librenms/pull/2072))
    - Fix table name for access points ([PR2075](https://github.com/librenms/librenms/pull/2075))
    - Removed STACK text in graphs ([PR2097](https://github.com/librenms/librenms/pull/2097))
    - Enable multiple ifDescr overrides to be done per device ([PR2099](https://github.com/librenms/librenms/pull/2099))
    - Removed ping + performance graphs and tab if skip ping check ([PR2175](https://github.com/librenms/librenms/pull/2175))
    - Fixed services -> Alerts menu link + page ([PR2173](https://github.com/librenms/librenms/pull/2173))
    - Fix percent bar also for quota bills ([PR2198](https://github.com/librenms/librenms/pull/2198))
    - Fix new Bill ([PR2199](https://github.com/librenms/librenms/pull/2199))
    - Change default solver to hierarchicalRepulsion in vis.js ([PR2202](https://github.com/librenms/librenms/pull/2202))
    - Fix: setting user port permissions fails ([PR2203](https://github.com/librenms/librenms/pull/2203))
    - Updated devices Graphs links to use non-static time references ([PR2211](https://github.com/librenms/librenms/pull/2211))
    - Removed ignored,deleted and disabled ports from query ([PR2213](https://github.com/librenms/librenms/pull/2213))
  - API:
    - Fixed API call for alert states ([PR2076](https://github.com/librenms/librenms/pull/2076))
    - Fixed nginx rewrite for api ([PR2112](https://github.com/librenms/librenms/pull/2112))
    - Change on the add_edit_rule to modify a rule without modify the name ([PR2159](https://github.com/librenms/librenms/pull/2159))
    - Fixed list_bills function when using :bill_id ([PR2212](https://github.com/librenms/librenms/pull/2212))

#### Improvements
  - WebUI:
    - Updated Bootstrap to 3.3.5 ([PR2015](https://github.com/librenms/librenms/pull/2015))
    - Added billing graphs to graphs widget ([PR2027](https://github.com/librenms/librenms/pull/2027))
    - Lock widgets by default so they can't be moved ([PR2042](https://github.com/librenms/librenms/pull/2042))
    - Moved Device Groups menu ([PR2049](https://github.com/librenms/librenms/pull/2049))
    - Show Config tab only if device isn't excluded from oxidized ([PR2118](https://github.com/librenms/librenms/pull/2118))
    - Simplify adding config options to WebUI ([PR2120](https://github.com/librenms/librenms/pull/2120))
    - Move red map markers to foreground ([PR2127](https://github.com/librenms/librenms/pull/2127))
    - Styled the two factor auth token prompt ([PR2151](https://github.com/librenms/librenms/pull/2151))
    - Update Font Awesome ([PR2167](https://github.com/librenms/librenms/pull/2167))
    - Allow user to influence when devices are grouped on world map ([PR2170](https://github.com/librenms/librenms/pull/2170))
    - Centralised the date selector for graphs for re-use ([PR2183](https://github.com/librenms/librenms/pull/2183))
    - Don't show dashboard settings if `/bare=yes/` ([PR2364](https://github.com/librenms/librenms/pull/2364))
  - API:
    - Added unmute alert function to API ([PR2082](https://github.com/librenms/librenms/pull/2082))
  - Discovery / Polling:
    - Added additional support for some UPS' based on Multimatic cards ([PR2046](https://github.com/librenms/librenms/pull/2046))
    - Improved WatchGuard OS detection ([PR2048](https://github.com/librenms/librenms/pull/2048))
    - Treat Dell branded Wifi controllers as ArubaOS ([PR2065](https://github.com/librenms/librenms/pull/2065))
    - Added discovery option for OS or Device type ([PR2088](https://github.com/librenms/librenms/pull/2088))
    - Updated pfSense to firewall type ([PR2096](https://github.com/librenms/librenms/pull/2096))
    - Added ability to turn off icmp checks globally or per device ([PR2131](https://github.com/librenms/librenms/pull/2131))
    - Reformat check a bit to make it easier for adding additional oids in ([PR2135](https://github.com/librenms/librenms/pull/2135))
    - Updated to disable auto-discovery by ip ([PR2182](https://github.com/librenms/librenms/pull/2182))
    - Updated to use env in distro script ([PR2204](https://github.com/librenms/librenms/pull/2204))
  - Added detection for:
    - Pulse Secure OS ([PR2053](https://github.com/librenms/librenms/pull/2053))
    - Riverbed Steelhead support ([PR2107](https://github.com/librenms/librenms/pull/2107))
    - OpenBSD sensors ([PR2113](https://github.com/librenms/librenms/pull/2113))
    - Additional comware detection ([PR2162](https://github.com/librenms/librenms/pull/2162))
    - Version from Synology MIB ([PR2163](https://github.com/librenms/librenms/pull/2163))
    - VCSA as VMWare ([PR2185](https://github.com/librenms/librenms/pull/2185))
    - SAF Lumina radios ([PR2361](https://github.com/librenms/librenms/pull/2361))
    - TP-Link detection ([PR2362](https://github.com/librenms/librenms/pull/2362))
  - Documentation:
    - Improved RHEL/CentOS install docs ([PR2043](https://github.com/librenms/librenms/pull/2043))
    - Update Varnish Docs ([PR2116](https://github.com/librenms/librenms/pull/2116), [PR2126](https://github.com/librenms/librenms/pull/2126))
    - Added passworded channels for the IRC-Bot ([PR2122](https://github.com/librenms/librenms/pull/2122))
    - Updated Two-Factor-Auth.md RE: Google Authenticator ([PR2146](https://github.com/librenms/librenms/pull/2146))
  - General:
    - Added colour support to IRC bot ([PR2059](https://github.com/librenms/librenms/pull/2059))
    - Fixed IRC bot reconnect if socket dies ([PR2061](https://github.com/librenms/librenms/pull/2061))
    - Updated default crons ([PR2177](https://github.com/librenms/librenms/pull/2177))
  - Reverts:
    - "Removed what appears to be unnecessary STACK text" ([PR2128](https://github.com/librenms/librenms/pull/2128))

### September 2015

#### Bug fixes
  - Alerting:
    - Process followups if there are changes ([PR1817](https://github.com/librenms/librenms/pull/1817))
    - Typo in alert_window setting ([PR1841](https://github.com/librenms/librenms/pull/1841))
    - Issue alert-trigger as test object ([PR1850](https://github.com/librenms/librenms/pull/1850))
  - WebUI:
    - Fix permissions for World-map widget ([PR1866](https://github.com/librenms/librenms/pull/1866))
    - Clean up Global / World Map name mixup ([PR1874](https://github.com/librenms/librenms/pull/1874))
    - Removed required flag for community when adding new hosts ([PR1961](https://github.com/librenms/librenms/pull/1961))
    - Stop duplicate devices showing in map ([PR1963](https://github.com/librenms/librenms/pull/1963))
    - Fix adduser bug storing users real name ([PR1990](https://github.com/librenms/librenms/pull/1990))
    - Stop alerts top-menu being clickable ([PR1995](https://github.com/librenms/librenms/pull/1995))
  - Services:
    - Honour IP field for DNS checks ([PR1933](https://github.com/librenms/librenms/pull/1933))
  - Discovery / Poller:
    - Fix Huawei VRP os detection ([PR1931](https://github.com/librenms/librenms/pull/1931))
    - Set empty processor descr for *nix processors ([PR1951](https://github.com/librenms/librenms/pull/1951))
    - Ensure udp6/tcp6 snmp devices use fping6 ([PR1959](https://github.com/librenms/librenms/pull/1959))
    - Fix RRD creation parameters ([PR2010](https://github.com/librenms/librenms/pull/2010))
  - General:
    - Remove 'sh' from cronjob ([PR1818](https://github.com/librenms/librenms/pull/1818))
    - Remove MySQL Locks ([PR1822](https://github.com/librenms/librenms/pull/1822),[PR1826](https://github.com/librenms/librenms/pull/1826),[PR1829](https://github.com/librenms/librenms/pull/1829),[PR1836](https://github.com/librenms/librenms/pull/1836))
    - Change DB config options to use single quotes to allow $ ([PR1948](https://github.com/librenms/librenms/pull/1948))

#### Improvements
  - WebUI:
    - Ability to edit ifAlias ([PR1811](https://github.com/librenms/librenms/pull/1811))
    - Honour Mouseout/Mouseleave on map widget ([PR1814](https://github.com/librenms/librenms/pull/1814))
    - Make syslog/eventlog responsive ([PR1816](https://github.com/librenms/librenms/pull/1816))
    - Reformat Proxmox UI ([PR1825](https://github.com/librenms/librenms/pull/1825),[PR1827](https://github.com/librenms/librenms/pull/1827))
    - Misc Changes ([PR1828](https://github.com/librenms/librenms/pull/1828),[PR1830](https://github.com/librenms/librenms/pull/1830),[PR1875](https://github.com/librenms/librenms/pull/1875),[PR1885](https://github.com/librenms/librenms/pull/1885),[PR1886](https://github.com/librenms/librenms/pull/1886),[PR1887](https://github.com/librenms/librenms/pull/1887),[PR1891](https://github.com/librenms/librenms/pull/1891),[PR1896](https://github.com/librenms/librenms/pull/1896),[PR1901](https://github.com/librenms/librenms/pull/1901),[PR1913](https://github.com/librenms/librenms/pull/1913),[PR1944](https://github.com/librenms/librenms/pull/1944))
    - Added support for Oxidized versioning ([PR1842](https://github.com/librenms/librenms/pull/1842))
    - Added graph widget + settings for widgets ([PR1835](https://github.com/librenms/librenms/pull/1835),[PR1861](https://github.com/librenms/librenms/pull/1861),[PR1968](https://github.com/librenms/librenms/pull/1968))
    - Added Support for multiple dashboards ([PR1869](https://github.com/librenms/librenms/pull/1869))
    - Added settings page for Worldmap widget ([PR1872](https://github.com/librenms/librenms/pull/1872))
    - Added uptime to availability widget ([PR1881](https://github.com/librenms/librenms/pull/1881))
    - Added top devices and ports widgets ([PR1903](https://github.com/librenms/librenms/pull/1903))
    - Added support for saving notes for devices ([PR1927](https://github.com/librenms/librenms/pull/1927))
    - Added fullscreen mobile support ([PR2022](https://github.com/librenms/librenms/pull/2022))
  - Added detection for:
    - FortiOS ([PR1815](https://github.com/librenms/librenms/pull/1815))
    - HP MSM ([PR1953](https://github.com/librenms/librenms/pull/1953))
  - Discovery / Poller:
    - Added Proxmox support ([PR1789](https://github.com/librenms/librenms/pull/1789))
    - Added CPU/Mem support for SonicWALL ([PR1957](https://github.com/librenms/librenms/pull/1957))
    - Updated distro script to support Arch Linux + fall back to lsb-release ([PR1978](https://github.com/librenms/librenms/pull/1978))
  - Documentation:
    - Add varnish docs ([PR1809](https://github.com/librenms/librenms/pull/1809))
    - Added CentOS 7 RRCached docs ([PR1893](https://github.com/librenms/librenms/pull/1893))
    - Improved description of fping options ([PR1952](https://github.com/librenms/librenms/pull/1952))
  - Alerting:
    - Added RegEx support for alert rules and device groups ([PR1998](https://github.com/librenms/librenms/pull/1998))
  - General:
    - Make installer more responsive ([PR1832](https://github.com/librenms/librenms/pull/1832))
    - Update fping millisec option to 200 default ([PR1833](https://github.com/librenms/librenms/pull/1833))
    - Reduced cleanup of device_perf ([PR1837](https://github.com/librenms/librenms/pull/1837))
    - Added support for negative values in munin-plugins ([PR1907](https://github.com/librenms/librenms/pull/1907))
    - Added default librenms user to config for use in validate.php ([PR1956](https://github.com/librenms/librenms/pull/1956))
    - Added working memcache support ([PR2007](https://github.com/librenms/librenms/pull/2007))

### August 2015

#### Bug fixes
  - WebUI:
    - Fix web_mouseover not honoured on All Devices page ([PR1592](https://github.com/librenms/librenms/pull/1592))
    - Fixed bug with edit/create alert template to clear out previous values ([PR1636](https://github.com/librenms/librenms/pull/1636))
    - Initialise $port_count in devices list ([PR1640](https://github.com/librenms/librenms/pull/1640))
    - Fixed Web installer due to code tidying update ([PR1644](https://github.com/librenms/librenms/pull/1644))
    - Updated gridster variable names to make unique ([PR1646](https://github.com/librenms/librenms/pull/1646))
    - Fixed issues with displaying devices with ' in location ([PR1655](https://github.com/librenms/librenms/pull/1655))
    - Fixes updating snmpv3 details in webui ([PR1727](https://github.com/librenms/librenms/pull/1727))
    - Check for user perms before listing neighbour ports ([PR1749](https://github.com/librenms/librenms/pull/1749))
    - Fixed Test-Transport button ([PR1772](https://github.com/librenms/librenms/pull/1772))
  - DB:
    - Added proper indexes on device_perf table ([PR1621](https://github.com/librenms/librenms/pull/1621))
    - Fixed multiple mysql strict issues ([PR1638](https://github.com/librenms/librenms/pull/1638), [PR1659](https://github.com/librenms/librenms/pull/1659))
    - Convert bgpPeerRemoteAs to bigint ([PR1691](https://github.com/librenms/librenms/pull/1691))
  - Discovery / Poller:
    - Fixed Synology system temps ([PR1649](https://github.com/librenms/librenms/pull/1649))
    - Fixed discovery-arp not running since code formatting update ([PR1671](https://github.com/librenms/librenms/pull/1671))
    - Correct the DSM upgrade OID ([PR1696](https://github.com/librenms/librenms/pull/1696))
    - Fix MySQL agent host variable usage ([PR1710](https://github.com/librenms/librenms/pull/1710))
    - Pass snmp-auth parameters enclosed by single-quotes ([PR1730](https://github.com/librenms/librenms/pull/1730))
    - Revert change which skips over down ports ([PR1742](https://github.com/librenms/librenms/pull/1742))
    - Stop PoE polling for each port ([PR1747](https://github.com/librenms/librenms/pull/1747))
    - Use ifHighSpeed if ifSpeed equals 0 ([PR1750](https://github.com/librenms/librenms/pull/1750))
    - Keep PHP Backwards compatibility ([PR1766](https://github.com/librenms/librenms/pull/1766))
    - False identification of Zyxel as Cisco ([PR1776](https://github.com/librenms/librenms/pull/1776))
    - Fix MySQL statement in poller-service.py ([PR1794](https://github.com/librenms/librenms/pull/1794))
    - Fix upstart script for poller-service.py ([PR1812](https://github.com/librenms/librenms/pull/1812))
  - General:
    - Fixed path to defaults.inc.php in config.php.default ([PR1673](https://github.com/librenms/librenms/pull/1673))
    - Strip '::ffff:' from syslog input ([PR1734](https://github.com/librenms/librenms/pull/1734))
    - Fix RRA ([PR1791](https://github.com/librenms/librenms/pull/1791))

#### Improvements
  - WebUI Updates:
    - Added support for Google API key in Geo coding ([PR1594](https://github.com/librenms/librenms/pull/1594))
    - Added ability to updated storage % warning ([PR1613](https://github.com/librenms/librenms/pull/1613))
    - Updated eventlog page to allow filtering by type ([PR1623](https://github.com/librenms/librenms/pull/1623))
    - Hide logo and plugins text on smaller windows ([PR1624](https://github.com/librenms/librenms/pull/1624))
    - Added poller group name to poller groups table ([PR1634](https://github.com/librenms/librenms/pull/1634))
    - Updated Customers page to use Bootgrid ([PR1658](https://github.com/librenms/librenms/pull/1658))
    - Added basic Graylog integration support ([PR1665](https://github.com/librenms/librenms/pull/1665))
    - Added support for running under sub-directory ([PR1667](https://github.com/librenms/librenms/pull/1667))
    - Updated vis.js to latest version ([PR1708](https://github.com/librenms/librenms/pull/1708))
    - Added border on availability map ([PR1713](https://github.com/librenms/librenms/pull/1713))
    - Make new dashboard the default ([PR1719](https://github.com/librenms/librenms/pull/1719))
    - Rearrange about page ([PR1735](https://github.com/librenms/librenms/pull/1735),[PR1743](https://github.com/librenms/librenms/pull/1743))
    - Center/Cleanup graphs ([PR1736](https://github.com/librenms/librenms/pull/1736))
    - Added Hover-Effect on devices table ([PR1738](https://github.com/librenms/librenms/pull/1738))
    - Show Test-Transport result ([PR1777](https://github.com/librenms/librenms/pull/1777))
    - Add arrows to the network map ([PR1787](https://github.com/librenms/librenms/pull/1787))
    - Add errored ports to summary widget ([PR1788](https://github.com/librenms/librenms/pull/1788))
    - Show message if no Device-Groups exist ([PR1796](https://github.com/librenms/librenms/pull/1796))
    - Misc UI fixes (Titles, Headers, ...) ([PR1797](https://github.com/librenms/librenms/pull/1797),[PR1798](https://github.com/librenms/librenms/pull/1798),[PR1800](https://github.com/librenms/librenms/pull/1800),[PR1801](https://github.com/librenms/librenms/pull/1801),[PR1802](https://github.com/librenms/librenms/pull/1802),[PR1803](https://github.com/librenms/librenms/pull/1803),[PR1804](https://github.com/librenms/librenms/pull/1804),[PR1805](https://github.com/librenms/librenms/pull/1805))
    - Move packages to overview dropdown ([PR1810](https://github.com/librenms/librenms/pull/1810))
  - API Updates:
    - Improved billing support in API ([PR1599](https://github.com/librenms/librenms/pull/1599))
    - Extended support for list devices to support mac/ipv4 and ipv6 filtering ([PR1744](https://github.com/librenms/librenms/pull/1744))
  - Added detection for:
    - Perle Media convertors ([PR1607](https://github.com/librenms/librenms/pull/1607))
    - Mac OSX 10 ([PR1774](https://github.com/librenms/librenms/pull/1774))
  - Improved detection for:
    - Windows devices ([PR1639](https://github.com/librenms/librenms/pull/1639))
    - Zywall CPU, Version and Memory ([PR1660](https://github.com/librenms/librenms/pull/1660),[PR1784](https://github.com/librenms/librenms/pull/1784))
    - Added LLDP support for PBN devices ([PR1705](https://github.com/librenms/librenms/pull/1705))
    - Netgear GS110TP ([PR1751](https://github.com/librenms/librenms/pull/1751))
  - Additional Sensors:
    - Added Compressor state for PCOWEB ([PR1600](https://github.com/librenms/librenms/pull/1600))
    - Added dbm support for IOS-XR ([PR1661](https://github.com/librenms/librenms/pull/1661))
    - Added temperature support for DNOS ([PR1782](https://github.com/librenms/librenms/pull/1782))
  - Discovery / Poller:
    - Updated autodiscovery function to log new type ([PR1623](https://github.com/librenms/librenms/pull/1623))
    - Improve application polling ([PR1724](https://github.com/librenms/librenms/pull/1724))
    - Improve debug output ([PR1756](https://github.com/librenms/librenms/pull/1756))
  - DB:
    - Added MySQLi support ([PR1647](https://github.com/librenms/librenms/pull/1647))
  - Documentation:
    - Added docs on MySQL strict mode ([PR1635](https://github.com/librenms/librenms/pull/1635))
    - Updated billing docs to use librenms user in cron ([PR1676](https://github.com/librenms/librenms/pull/1676))
    - Updated LDAP docs to indicate php-ldap module needs installing ([PR1716](https://github.com/librenms/librenms/pull/1716))
    - Typo/Spellchecks ([PR1731](https://github.com/librenms/librenms/pull/1731),[PR1806](https://github.com/librenms/librenms/pull/1806))
    - Improved Alerting and Device-Groups ([PR1781](https://github.com/librenms/librenms/pull/1781))
  - Alerting:
    - Reformatted eventlog message to show state for alerts ([PR1685](https://github.com/librenms/librenms/pull/1685))
    - Add basic Pushbullet transport ([PR1721](https://github.com/librenms/librenms/pull/1721))
    - Allow custom titles ([PR1807](https://github.com/librenms/librenms/pull/1807))
  - General:
    - Added more debugging and checks to discovery-protocols ([PR1590](https://github.com/librenms/librenms/pull/1590))
    - Cleanup debug statements ([PR1725](https://github.com/librenms/librenms/pull/1725),[PR1737](https://github.com/librenms/librenms/pull/1737))

### July 2015

#### Bug fixes
  - WebUI:
    - Fixed API not functioning. ([PR1367](https://github.com/librenms/librenms/pull/1367))
    - Fixed API not storing alert rule names ([PR1372](https://github.com/librenms/librenms/pull/1372))
    - Fixed datetimepicker use ([PR1376](https://github.com/librenms/librenms/pull/1376))
    - Added 'running' status for BGP peers as up ([PR1412](https://github.com/librenms/librenms/pull/1412))
    - Fixed the remove search link in devices ([PR1413](https://github.com/librenms/librenms/pull/1413))
    - Fixed clicking anywhere in a search result will now take you to where you want ([PR1472](https://github.com/librenms/librenms/pull/1472))
    - Fixed inventory page not displaying results ([PR1488](https://github.com/librenms/librenms/pull/1488))
    - Fixed buggy alert templating in WebUI ([PR1527](https://github.com/librenms/librenms/pull/1527))
    - Fixed bug in creating api tokens in Firefox ([PR1530](https://github.com/librenms/librenms/pull/1530))
  - Discovery / Poller:
    - Do not allow master to rejoin itself. ([PR1377](https://github.com/librenms/librenms/pull/1377))
    - Fixed poller group query in discovery ([PR1433](https://github.com/librenms/librenms/pull/1433))
    - Fixed ARMv5 detection ([PR1522](https://github.com/librenms/librenms/pull/1522))
    - Fixed pfSense detection ([PR1567](https://github.com/librenms/librenms/pull/1567))
  - Sensors:
    - Fixed bug in EqualLogic sensors ([PR1513](https://github.com/librenms/librenms/pull/1513))
    - Fixed bug in DRAC voltage sensor ([PR1521](https://github.com/librenms/librenms/pull/1521))
    - Fixed bug in APC bank detection ([PR1560](https://github.com/librenms/librenms/pull/1560))
  - Documentation:
    - Fixed Nginx config file ([PR1389](https://github.com/librenms/librenms/pull/1389))
  - General:
    - Fixed a number of permission issues ([PR1411](https://github.com/librenms/librenms/pull/1411))

#### Improvements
  - Added detection for:
    - Meraki ([PR1402](https://github.com/librenms/librenms/pull/1402))
    - Brocade ([PR1404](https://github.com/librenms/librenms/pull/1404))
    - Dell iDrac ([PR1419](https://github.com/librenms/librenms/pull/1419),[PR1420](https://github.com/librenms/librenms/pull/1420),[PR1423](https://github.com/librenms/librenms/pull/1423),[PR1427](https://github.com/librenms/librenms/pull/1427))
    - Dell Networking OS ([PR1474](https://github.com/librenms/librenms/pull/1474))
    - Netonix ([PR1476](https://github.com/librenms/librenms/pull/1476))
    - IBM Tape Library ([PR1519](https://github.com/librenms/librenms/pull/1519),[PR1550](https://github.com/librenms/librenms/pull/1550))
    - Aerohive ([PR1546](https://github.com/librenms/librenms/pull/1546))
    - Cisco Voice Gateways ([PR1565](https://github.com/librenms/librenms/pull/1565))
  - Improved detection for:
    - RouterOS RB260GS ([PR1545](https://github.com/librenms/librenms/pull/1545))
    - Dell PowerConnect ([PR1452](https://github.com/librenms/librenms/pull/1452),[PR1517](https://github.com/librenms/librenms/pull/1517))
    - Brocade ([PR1548](https://github.com/librenms/librenms/pull/1548))
    - Rielo UPS ([PR1381](https://github.com/librenms/librenms/pull/1381))
    - Cisco IPSLAs ([PR1586](https://github.com/librenms/librenms/pull/1586))
  - Additional Sensors:
    - Added power, temperature and fan speed support for XOS ([PR1493](https://github.com/librenms/librenms/pull/1493),[PR1494](https://github.com/librenms/librenms/pull/1494),[PR1496](https://github.com/librenms/librenms/pull/1496))
  - WebUI Updates:
    - Added missing load and state icons ([PR1392](https://github.com/librenms/librenms/pull/1392))
    - Added ability to update users passwords in WebUI ([PR1440](https://github.com/librenms/librenms/pull/1440))
    - Default to two days performance data being shown ([PR1442](https://github.com/librenms/librenms/pull/1442))
    - Improved sensors page for mobile view ([PR1454](https://github.com/librenms/librenms/pull/1454))
    - Improvements to network map ([PR1455](https://github.com/librenms/librenms/pull/1455),[PR1470](https://github.com/librenms/librenms/pull/1470),[PR1486](https://github.com/librenms/librenms/pull/1486),[PR1528](https://github.com/librenms/librenms/pull/1528),[PR1557](https://github.com/librenms/librenms/pull/1557))
    - Added availability map ([PR1464](https://github.com/librenms/librenms/pull/1464))
    - Updated edit ports page to use Bootstrap ([PR1498](https://github.com/librenms/librenms/pull/1498))
    - Added new World Map and support for lat/lng lookup ([PR1501](https://github.com/librenms/librenms/pull/1501),[PR1552](https://github.com/librenms/librenms/pull/1552))
    - Added sysName to overview page for device ([PR1520](https://github.com/librenms/librenms/pull/1520))
    - Added New Overview dashboard uilising Widgets ([PR1523](https://github.com/librenms/librenms/pull/1523),[PR1580](https://github.com/librenms/librenms/pull/1580))
    - Added new config option to disable Device groups ([PR1569](https://github.com/librenms/librenms/pull/1569))
  - Discovery / Poller Updates:
    - Updated discovery of IP based devices ([PR1406](https://github.com/librenms/librenms/pull/1406))
    - Added using cronic for poller-wrapper.py to allow cron to send emails ([PR1408](https://github.com/librenms/librenms/pull/1408),[PR1531](https://github.com/librenms/librenms/pull/1531))
    - Updated Cisco MIBs to latest versions ([PR1436](https://github.com/librenms/librenms/pull/1436))
    - Improve performance of unix-agent processes DB code ([PR1447](https://github.com/librenms/librenms/pull/1447),[PR1460](https://github.com/librenms/librenms/pull/1460))
    - Added BGP discovery code ([PR1414](https://github.com/librenms/librenms/pull/1414))
    - Use snmpEngineTime as a fallback to uptime ([PR1477](https://github.com/librenms/librenms/pull/1477))
    - Added fallback support for devices not reporting ifAlias ([PR1479](https://github.com/librenms/librenms/pull/1479))
    - Git pull and schema updates will now pause if InnoDB buffers overused ([PR1563](https://github.com/librenms/librenms/pull/1563))
  - Documentation:
    - Updated Unix-Agent docs to use LibreNMS repo for scripts ([PR1568](https://github.com/librenms/librenms/pull/1568),[PR1570](https://github.com/librenms/librenms/pull/1570),[PR1573](https://github.com/librenms/librenms/pull/1573))
    - Added info on using MariaDB ([PR1585](https://github.com/librenms/librenms/pull/1585))
  - Alerting:
    - Added Boxcar (www.boxcar.io) transport for alerting ([PR1481](https://github.com/librenms/librenms/pull/1481))
    - Removed old alerting code ([PR1581](https://github.com/librenms/librenms/pull/1581))
  - General:
    - Code cleanup and formatting ([PR1415](https://github.com/librenms/librenms/pull/1415),[PR1416](https://github.com/librenms/librenms/pull/1416),[PR1431](https://github.com/librenms/librenms/pull/1431),[PR1434](https://github.com/librenms/librenms/pull/1434),[PR1439](https://github.com/librenms/librenms/pull/1439),[PR1444](https://github.com/librenms/librenms/pull/1444),[PR1450](https://github.com/librenms/librenms/pull/1450))
    - Added support for CollectD flush ([PR1463](https://github.com/librenms/librenms/pull/1463))
    - Added support for LDAP pure DN member groups ([PR1516](https://github.com/librenms/librenms/pull/1516))
    - Updated validate.php to check for distributed poller setup issues ([PR1526](https://github.com/librenms/librenms/pull/1526))
    - Improved service check support ([PR1385](https://github.com/librenms/librenms/pull/1385),[PR1386](https://github.com/librenms/librenms/pull/1386),[PR1387](https://github.com/librenms/librenms/pull/1387),[PR1388](https://github.com/librenms/librenms/pull/1388))
    - Added SNMP Scanner to discover devices within subnets and docs ([PR1577](https://github.com/librenms/librenms/pull/1577))

### June 2015

#### Bug fixes
  - Fixed services list SQL issue ([PR1181](https://github.com/librenms/librenms/pull/1181))
  - Fixed negative values for storage when volume is > 2TB ([PR1185](https://github.com/librenms/librenms/pull/1185))
  - Fixed visual display for input fields on /syslog/ ([PR1193](https://github.com/librenms/librenms/pull/1193))
  - Fixed fatal php issue in shoutcast.php ([PR1203](https://github.com/librenms/librenms/pull/1203))
  - Fixed percent bars in /bills/ ([PR1208](https://github.com/librenms/librenms/pull/1208))
  - Fixed item count in memory and storage pages ([PR1210](https://github.com/librenms/librenms/pull/1210))
  - Fixed syslog not loading ([PR1219](https://github.com/librenms/librenms/pull/1219))
  - Fixed fatal on reload in IRC bot ([PR1218](https://github.com/librenms/librenms/pull/1218))
  - Alter Windows CPU description when unknown ([PR1226](https://github.com/librenms/librenms/pull/1226))
  - Fixed rfc1628 current calculation ([PR1256](https://github.com/librenms/librenms/pull/1256))
  - Fixed alert mapping not working ([PR1280](https://github.com/librenms/librenms/pull/1280))
  - Fixed legend ifLabels ([PR1296](https://github.com/librenms/librenms/pull/1296))
  - Fixed bug causing map to not load when stale link data was present ([PR1297](https://github.com/librenms/librenms/pull/1297))
  - Fixed javascript issue preventing removal of alert rules ([PR1312](https://github.com/librenms/librenms/pull/1312))
  - Fixed removal of IPs before ports are deleted ([PR1329](https://github.com/librenms/librenms/pull/1329))
  - Fixed JS issue when removing ports from bills ([PR1330](https://github.com/librenms/librenms/pull/1330))
  - Fixed adding --daemon a second time to collectd Graphs ([PR1342](https://github.com/librenms/librenms/pull/1342))
  - Fixed CollectD DS names ([PR1347](https://github.com/librenms/librenms/pull/1347),[PR1349](https://github.com/librenms/librenms/pull/1349),[PR1368](https://github.com/librenms/librenms/pull/1368))
  - Fixed graphing issues when rrd contains special chars ([PR1350](https://github.com/librenms/librenms/pull/1350))
  - Fixed regex for device groups ([PR1359](https://github.com/librenms/librenms/pull/1359))
  - Added HOST-RESOURCES-MIB into Synology detection (RP1360)
  - Fix health page graphs showing the first graph for all ([PR1363](https://github.com/librenms/librenms/pull/1363))

#### Improvements
  - Updated Syslog docs to include syslog-ng 3.5.1 updates ([PR1171](https://github.com/librenms/librenms/pull/1171))
  - Added Pushover Transport ([PR1180](https://github.com/librenms/librenms/pull/1180), [PR1191](https://github.com/librenms/librenms/pull/1191))
  - Converted processors and memory table to bootgrid ([PR1188](https://github.com/librenms/librenms/pull/1188), [PR1192](https://github.com/librenms/librenms/pull/1192))
  - Issued alerts and transport now logged to eventlog ([PR1194](https://github.com/librenms/librenms/pull/1194))
  - Added basic support for Enterasys devices ([PR1211](https://github.com/librenms/librenms/pull/1211))
  - Added dynamic config to configure alerting ([PR1153](https://github.com/librenms/librenms/pull/1153))
  - Added basic support for Multimatic USV ([PR1215](https://github.com/librenms/librenms/pull/1215))
  - Disabled and ignored ports no longer show by default on /ports/ ([PR1228](https://github.com/librenms/librenms/pull/1228),[PR1301](https://github.com/librenms/librenms/pull/1301))
  - Added additional graphs to menu on devices page ([PR1229](https://github.com/librenms/librenms/pull/1229))
  - Added Docs on configuring Globe front page ([PR1231](https://github.com/librenms/librenms/pull/1231))
  - Added robots.txt to html folder to disallow indexing ([PR1234](https://github.com/librenms/librenms/pull/1234))
  - Added additional support for Synology units ([PR1235](https://github.com/librenms/librenms/pull/1235),[PR1244](https://github.com/librenms/librenms/pull/1244),[PR1269](https://github.com/librenms/librenms/pull/1269))
  - Added IP check to autodiscovery code ([PR1248](https://github.com/librenms/librenms/pull/1248))
  - Updated HP ProCurve detection ([PR1249](https://github.com/librenms/librenms/pull/1249))
  - Added basic detection for Alcatel-Lucent OmniSwitch ([PR1253](https://github.com/librenms/librenms/pull/1253), [PR1282](https://github.com/librenms/librenms/pull/1282))
  - Added additional metrics for rfc1628 UPS ([PR1258](https://github.com/librenms/librenms/pull/1258), [PR1268](https://github.com/librenms/librenms/pull/1268))
  - Allow multiple discovery modules to be specified on command line ([PR1263](https://github.com/librenms/librenms/pull/1263))
  - Updated docs on using libvirt ([PR1264](https://github.com/librenms/librenms/pull/1264))
  - Updated Ruckus detection ([PR1267](https://github.com/librenms/librenms/pull/1267))
  - Initial release of MIB based polling ([PR1273](https://github.com/librenms/librenms/pull/1273))
  - Added support for CISCO-BGP4-MIB ([PR1184](https://github.com/librenms/librenms/pull/1184))
  - Added support for Dell EqualLogic units ([PR1283](https://github.com/librenms/librenms/pull/1283),[PR1309](https://github.com/librenms/librenms/pull/1309))
  - Added logging of success/ failure for alert transports ([PR1286](https://github.com/librenms/librenms/pull/1286))
  - Updated VyOS detection ([PR1299](https://github.com/librenms/librenms/pull/1299))
  - Added primary serial number detection for Cisco units ([PR1300](https://github.com/librenms/librenms/pull/1300))
  - Added support for specifying MySQL port number in config.php ([PR1302](https://github.com/librenms/librenms/pull/1302))
  - Updated alert subject to use rule name not ID ([PR1310](https://github.com/librenms/librenms/pull/1310))
  - Added macro %macros.sensor ([PR1311](https://github.com/librenms/librenms/pull/1311))
  - Added WebUI support for Pushover ([PR1313](https://github.com/librenms/librenms/pull/1313))
  - Updated path check for Oxidized config ([PR1316](https://github.com/librenms/librenms/pull/1316))
  - Added Multimatic UPS to rfc1628 detection ([PR1317](https://github.com/librenms/librenms/pull/1317))
  - Added timeout for Unix agent ([PR1319](https://github.com/librenms/librenms/pull/1319))
  - Added support for a poller to use more than one poller group ([PR1323](https://github.com/librenms/librenms/pull/1323))
  - Added ability to use Plugins on device overview page ([PR1325](https://github.com/librenms/librenms/pull/1325))
  - Added latency loss/avg/max/min results to DB and Graph ([PR1326](https://github.com/librenms/librenms/pull/1326))
  - Added recording of device down (snmp/icmp) ([PR1326](https://github.com/librenms/librenms/pull/1326))
  - Added debugging output for when invalid SNMPv3 options used ([PR1331](https://github.com/librenms/librenms/pull/1331))
  - Added load and state output to device overview page ([PR1333](https://github.com/librenms/librenms/pull/1333))
  - Added load sensors to RFC1628 Devices ([PR1336](https://github.com/librenms/librenms/pull/1336))
  - Added support for WebPower Pro II UPS Cards ([PR1338](https://github.com/librenms/librenms/pull/1338))
  - No longer rewrite server-status in .htaccess ([PR1339](https://github.com/librenms/librenms/pull/1339))
  - Added docs for setting up Service extensions ([PR1354](https://github.com/librenms/librenms/pull/1354))
  - Added additional info from pfsense devices ([PR1356](https://github.com/librenms/librenms/pull/1356))

### May 2015

#### Bug fixes
  - Updated nested addHosts to use variables passed ([PR889](https://github.com/librenms/librenms/pull/889))
  - Fixed map drawing issue ([PR907](https://github.com/librenms/librenms/pull/907))
  - Fixed sensors issue where APC load sensors overwrote current ([PR912](https://github.com/librenms/librenms/pull/912))
  - Fixed devices location filtering ([PR917](https://github.com/librenms/librenms/pull/917), [PR921](https://github.com/librenms/librenms/pull/921))
  - Minor fix to rrdcached_dir handling ([PR940](https://github.com/librenms/librenms/pull/940))
  - Now set defaults for AddHost on XDP discovery ([PR941](https://github.com/librenms/librenms/pull/941))
  - Fix web installer to generate config correctly if possible ([PR954](https://github.com/librenms/librenms/pull/954))
  - Fix inverse option for graphs ([PR955](https://github.com/librenms/librenms/pull/955))
  - Fix ifAlias parsing ([PR960](https://github.com/librenms/librenms/pull/960))
  - Rewrote rrdtool_escape to fix graph formatting issues ([PR961](https://github.com/librenms/librenms/pull/961), [PR965](https://github.com/librenms/librenms/pull/965))
  - Updated ports check to include ifAdminStatus ([PR962](https://github.com/librenms/librenms/pull/962))
  - Fixed custom sensors high / low being overwritten on discovery ([PR977](https://github.com/librenms/librenms/pull/977))
  - Fixed APC powerbar phase limit discovery ([PR981](https://github.com/librenms/librenms/pull/981))
  - Fix for 4 digit cpu% for Datacom ([PR984](https://github.com/librenms/librenms/pull/984))
  - Fix SQL query for restricted users in /devices/ ([PR990](https://github.com/librenms/librenms/pull/990))
  - Fix for post-formatting time-macros ([PR1006](https://github.com/librenms/librenms/pull/1006))
  - Honour disabling alerts for hosts ([PR1051](https://github.com/librenms/librenms/pull/1051))
  - Make OSPF and ARP discovery independent xDP ([PR1053](https://github.com/librenms/librenms/pull/1053))
  - Fixed ospf_nbrs lookup to use device_id ([PR1088](https://github.com/librenms/librenms/pull/1088))
  - Removed trailing / from some urls ([PR1089](https://github.com/librenms/librenms/pull/1089) / [PR1100](https://github.com/librenms/librenms/pull/1100))
  - Fix to device search for Device type and location ([PR1101](https://github.com/librenms/librenms/pull/1101))
  - Stop non-device boxes on overview appearing when device is down ([PR1106](https://github.com/librenms/librenms/pull/1106))
  - Fixed nfsen directory checks ([PR1123](https://github.com/librenms/librenms/pull/1123))
  - Removed lower limit for sensor graphs so negative values show ([PR1124](https://github.com/librenms/librenms/pull/1124))
  - Added fallback for poller_group if empty when adding devices ([PR1126](https://github.com/librenms/librenms/pull/1126))
  - Fixed processor graphs tooltips ([PR1127](https://github.com/librenms/librenms/pull/1127))
  - Fixed /poll-log/ count ([PR1130](https://github.com/librenms/librenms/pull/1130))
  - Fixed ARP search graph type reference ([PR1131](https://github.com/librenms/librenms/pull/1131))
  - Fixed showing state=X in device list ([PR1144](https://github.com/librenms/librenms/pull/1144))
  - Removed ability for demo user to delete users ([PR1151](https://github.com/librenms/librenms/pull/1151))
  - Fixed user / port perms for top X front page boxes ([PR1156](https://github.com/librenms/librenms/pull/1156))
  - Fixed truncating UTF-8 strings ([PR1166](https://github.com/librenms/librenms/pull/1166))
  - Fixed attaching templates due to JS issue ([PR1167](https://github.com/librenms/librenms/pull/1167))

#### Improvements
  - Added loading bar to top nav ([PR893](https://github.com/librenms/librenms/pull/893))
  - Added load and current for APC units ([PR888](https://github.com/librenms/librenms/pull/888))
  - Improved web installer ([PR887](https://github.com/librenms/librenms/pull/887))
  - Updated alerts status box ([PR875](https://github.com/librenms/librenms/pull/875))
  - Updated syslog page ([PR862](https://github.com/librenms/librenms/pull/862))
  - Added temperature polling for IBM Flexsystem ([PR894](https://github.com/librenms/librenms/pull/894))
  - Updated typeahead libraries and relevant forms ([PR882](https://github.com/librenms/librenms/pull/882))
  - Added docs showing configuration options and how to use them ([PR910](https://github.com/librenms/librenms/pull/910))
  - Added docs on discovery / poller and how to debug ([PR911](https://github.com/librenms/librenms/pull/911))
  - Updated docs for MySQL / Nginx / Bind use in Unix agent ([PR916](https://github.com/librenms/librenms/pull/916))
  - Update development docs ([PR919](https://github.com/librenms/librenms/pull/919))
  - Updated install docs to advise about whitespace in config.php ([PR920](https://github.com/librenms/librenms/pull/920))
  - Added docs on authentication modules ([PR922](https://github.com/librenms/librenms/pull/922))
  - Added support for Oxidized config archival ([PR927](https://github.com/librenms/librenms/pull/927))
  - Added API to feed devices to Oxidized ([PR928](https://github.com/librenms/librenms/pull/928))
  - Added support for per OS bad_iftype, bad_if and bad_if_regexp ([PR930](https://github.com/librenms/librenms/pull/930))
  - Enable alerting on tables with relative / indirect glues ([PR932](https://github.com/librenms/librenms/pull/932))
  - Added bills support in rulesuggest and alert system ([PR934](https://github.com/librenms/librenms/pull/934))
  - Added detection for Sentry Smart CDU ([PR938](https://github.com/librenms/librenms/pull/938))
  - Added basic detection for Netgear devices ([PR942](https://github.com/librenms/librenms/pull/942))
  - addhost.php now uses distributed_poller_group config if set ([PR944](https://github.com/librenms/librenms/pull/944))
  - Added port rewrite function ([PR946](https://github.com/librenms/librenms/pull/946))
  - Added basic detection for Ubiquiti Edgeswitch ([PR947](https://github.com/librenms/librenms/pull/947))
  - Added support for retrieving email address from LDAP ([PR949](https://github.com/librenms/librenms/pull/949))
  - Updated JunOS logo ([PR952](https://github.com/librenms/librenms/pull/952))
  - Add aggregates on multi_bits_separate graphs ([PR956](https://github.com/librenms/librenms/pull/956))
  - Fix port name issue for recent snmp versions on Linux ([PR957](https://github.com/librenms/librenms/pull/957))
  - Added support for quick access to devices via url ([PR958](https://github.com/librenms/librenms/pull/958))
  - Added work around for PHP creating zombie processes on certain distros ([PR959](https://github.com/librenms/librenms/pull/959))
  - Added detection support for NetApp + disks + temperature ([PR967](https://github.com/librenms/librenms/pull/967), [PR971](https://github.com/librenms/librenms/pull/971))
  - Define defaults for graphs ([PR968](https://github.com/librenms/librenms/pull/968))
  - Added docs for migrating from Observium ([PR974](https://github.com/librenms/librenms/pull/974))
  - Added iLo temperature support ([PR982](https://github.com/librenms/librenms/pull/982))
  - Added disk temperature for Synology DSM ([PR986](https://github.com/librenms/librenms/pull/986))
  - Added ICMP, TLS/SSL and Domain expiry service checks ([PR987](https://github.com/librenms/librenms/pull/987), [PR1040](https://github.com/librenms/librenms/pull/1040), [PR1041](https://github.com/librenms/librenms/pull/1041))
  - Added IPMI detection ([PR988](https://github.com/librenms/librenms/pull/988))
  - Mikrotik MIB update ([PR991](https://github.com/librenms/librenms/pull/991))
  - Set better timeperiod for caching graphs ([PR992](https://github.com/librenms/librenms/pull/992))
  - Added config option to disable port relationship in ports list ([PR996](https://github.com/librenms/librenms/pull/996))
  - Added support for custom customer description parse ([PR998](https://github.com/librenms/librenms/pull/998))
  - Added hardware and MySQL version stats to callback ([PR999](https://github.com/librenms/librenms/pull/999))
  - Added support for alerting to PagerDuty ([PR1004](https://github.com/librenms/librenms/pull/1004))
  - Now send ack notifications for alerts that are acked ([PR1008](https://github.com/librenms/librenms/pull/1008))
  - Updated contributing docs and added placeholder ([PR1024](https://github.com/librenms/librenms/pull/1024), [PR1025](https://github.com/librenms/librenms/pull/1025))
  - Updated globe.php overview page with updated map support ([PR1029](https://github.com/librenms/librenms/pull/1029))
  - Converted storage page to use Bootgrid ([PR1030](https://github.com/librenms/librenms/pull/1030))
  - Added basic FibreHome detection ([PR1031](https://github.com/librenms/librenms/pull/1031))
  - Show details of alerts in alert log ([PR1043](https://github.com/librenms/librenms/pull/1043))
  - Allow a user-defined windows to add tolerance for alerting ([PR1044](https://github.com/librenms/librenms/pull/1044))
  - Added inlet support for Raritan PX iPDU ([PR1045](https://github.com/librenms/librenms/pull/1045))
  - Updated MIBS for Cisco SB ([PR1058](https://github.com/librenms/librenms/pull/1058))
  - Added error checking for build-base on install ([PR1059](https://github.com/librenms/librenms/pull/1059))
  - Added fan and raid state for Dell OpenManage ([PR1062](https://github.com/librenms/librenms/pull/1062))
  - Updated MIBS for Ruckus ZoneDirectors ([PR1067](https://github.com/librenms/librenms/pull/1067))
  - Added check for ./rename.php ([PR1069](https://github.com/librenms/librenms/pull/1069))
  - Added install instructions to use librenms user ([PR1071](https://github.com/librenms/librenms/pull/1071))
  - Honour sysContact over riding for alerts ([PR1073](https://github.com/librenms/librenms/pull/1073))
  - Added services page for adding/deleting and editing services ([PR1076](https://github.com/librenms/librenms/pull/1076))
  - Added more support for Mikrotik devices ([PR1080](https://github.com/librenms/librenms/pull/1080))
  - Added better detection for Cisco ASA 5585-SSP40 ([PR1082](https://github.com/librenms/librenms/pull/1082))
  - Added CPU dataplane support for JunOS ([PR1086](https://github.com/librenms/librenms/pull/1086))
  - Removed requirement for hostnames on add device ([PR1087](https://github.com/librenms/librenms/pull/1087))
  - Added config option to exclude sysContact from alerts ([PR1093](https://github.com/librenms/librenms/pull/1093))
  - Added config option to regenerate contacts on alerts ([PR1109](https://github.com/librenms/librenms/pull/1109))
  - Added validation tool to help fault find issues with installs ([PR1112](https://github.com/librenms/librenms/pull/1112))
  - Added CPU support for EdgeOS ([PR1114](https://github.com/librenms/librenms/pull/1114))
  - Added ability to customise transit/peering/core descriptions ([PR1125](https://github.com/librenms/librenms/pull/1125))
  - Show ifName in ARP search if devices are set to use this ([PR1133](https://github.com/librenms/librenms/pull/1133))
  - Added FibreHome CPU and Mempool support ([PR1134](https://github.com/librenms/librenms/pull/1134))
  - Added config options for region and resolution on globe map ([PR1137](https://github.com/librenms/librenms/pull/1137))
  - Added RRDCached example docs ([PR1148](https://github.com/librenms/librenms/pull/1148))
  - Updated support for additional NetBotz models ([PR1152](https://github.com/librenms/librenms/pull/1152))
  - Updated /iftype/ page to include speed/circuit/notes ([PR1155](https://github.com/librenms/librenms/pull/1155))
  - Added detection for PowerConnect 55XX devices ([PR1165](https://github.com/librenms/librenms/pull/1165))

### Apr 2015

####Bug fixes
  - Fixed ack of worse/better alerts ([PR720](https://github.com/librenms/librenms/pull/720))
  - Fixed ORIG_PATH_INFO warnings ([PR727](https://github.com/librenms/librenms/pull/727))
  - Added missing CPU id for Cisco SB ([PR744](https://github.com/librenms/librenms/pull/744))
  - Changed Processors table name to lower case in processors discovery ([PR751](https://github.com/librenms/librenms/pull/751))
  - Fixed alerts path issue ([PR756](https://github.com/librenms/librenms/pull/756), [PR760](https://github.com/librenms/librenms/pull/760))
  - Suppress further port alerts when interface goes down ([PR745](https://github.com/librenms/librenms/pull/745))
  - Fixed login so redirects via 303 when POST data sent ([PR775](https://github.com/librenms/librenms/pull/775))
  - Fixed missing link to errored or ignored ports ([PR787](https://github.com/librenms/librenms/pull/787))
  - Updated alert log query for performance improvements ([PR783](https://github.com/librenms/librenms/pull/783))
  - Honour alert_rules.disabled field ([PR784](https://github.com/librenms/librenms/pull/784))
  - Stop page debug if user not logged in ([PR785](https://github.com/librenms/librenms/pull/785))
  - Added text filtering for new tables ([PR797](https://github.com/librenms/librenms/pull/797))
  - Fixed VMWare VM detection + hardware / serial support ([PR799](https://github.com/librenms/librenms/pull/799))
  - Fix links from /health/processor ([PR810](https://github.com/librenms/librenms/pull/810))
  - Hide divider if no plugins installed ([PR811](https://github.com/librenms/librenms/pull/811))
  - Added Nginx fix for using debug option ([PR823](https://github.com/librenms/librenms/pull/823))
  - Bug fixes for device groups SQL ([PR840](https://github.com/librenms/librenms/pull/840))
  - Fixed path issue when using rrdcached ([PR839](https://github.com/librenms/librenms/pull/839))
  - Fixed JS issues when deleting alert maps / poller groups / device groups ([PR846](https://github.com/librenms/librenms/pull/846),[PR848](https://github.com/librenms/librenms/pull/848),[PR877](https://github.com/librenms/librenms/pull/877))
  - Fixed links and popover for /health/metric=storage/ ([PR847](https://github.com/librenms/librenms/pull/847))
  - Fixed lots of user permission issues ([PR855](https://github.com/librenms/librenms/pull/855))
  - Fixed search ip / arp / mac pages ([PR845](https://github.com/librenms/librenms/pull/845))
  - Added missing charge icon ([PR878](https://github.com/librenms/librenms/pull/878))

####Improvements
  - New theme support added (light,dark and mono) ([PR682](https://github.com/librenms/librenms/pull/682),[PR683](https://github.com/librenms/librenms/pull/683),[PR701](https://github.com/librenms/librenms/pull/701))
  - Tables being converted to Jquery Bootgrid ([PR693](https://github.com/librenms/librenms/pull/693),[PR706](https://github.com/librenms/librenms/pull/706),[PR716](https://github.com/librenms/librenms/pull/716))
  - Detect Cisco ASA Hardware and OS Version ([PR708](https://github.com/librenms/librenms/pull/708))
  - Update LDAP support ([PR707](https://github.com/librenms/librenms/pull/707))
  - Updated APC powernet MIB ([PR713](https://github.com/librenms/librenms/pull/713))
  - Update to Foritgate support ([PR709](https://github.com/librenms/librenms/pull/709))
  - Added support for UBNT AirOS and AirFibre ([PR721](https://github.com/librenms/librenms/pull/721),[PR730](https://github.com/librenms/librenms/pull/730),[PR731](https://github.com/librenms/librenms/pull/731))
  - Added support device groups + alerts to be mapped to devices or groups ([PR722](https://github.com/librenms/librenms/pull/722))
  - Added basic Cambium support ([PR738](https://github.com/librenms/librenms/pull/738))
  - Added basic F5 support ([PR670](https://github.com/librenms/librenms/pull/670))
  - Shorten interface names on map ([PR752](https://github.com/librenms/librenms/pull/752))
  - Added PowerCode support ([PR762](https://github.com/librenms/librenms/pull/762))
  - Added Autodiscovery via OSPF ([PR772](https://github.com/librenms/librenms/pull/772))
  - Added visual graph of alert log ([PR777](https://github.com/librenms/librenms/pull/777), [PR809](https://github.com/librenms/librenms/pull/809))
  - Added Callback system to send anonymous stats ([PR768](https://github.com/librenms/librenms/pull/768))
  - More tables converted to use bootgrid ([PR729](https://github.com/librenms/librenms/pull/729), [PR761](https://github.com/librenms/librenms/pull/761))
  - New Global Cache to store common queries added ([PR780](https://github.com/librenms/librenms/pull/780))
  - Added proxy support for submitting stats ([PR791](https://github.com/librenms/librenms/pull/791))
  - Minor APC Polling change ([PR800](https://github.com/librenms/librenms/pull/800))
  - Updated to HP switch detection ([PR802](https://github.com/librenms/librenms/pull/802))
  - Added Datacom basic detection ([PR816](https://github.com/librenms/librenms/pull/816))
  - Updated Cisco detection ([PR815](https://github.com/librenms/librenms/pull/815))
  - Added CSV export system + ability to export ports ([PR818](https://github.com/librenms/librenms/pull/818))
  - Added basic detection for PacketLogic devices ([PR773](https://github.com/librenms/librenms/pull/773))
  - Added fallback support for IBM switches for Serial / Version ([PR822](https://github.com/librenms/librenms/pull/822))
  - Added Juniper Inventory support ([PR825](https://github.com/librenms/librenms/pull/825))
  - Sharpen graphs produced ([PR826](https://github.com/librenms/librenms/pull/826))
  - Updated map to show device overview graphs and port graphs ([PR826](https://github.com/librenms/librenms/pull/826))
  - Added hostname to API call for list_alerts ([PR834](https://github.com/librenms/librenms/pull/834))
  - Added ability to schedule maintenance ([PR835](https://github.com/librenms/librenms/pull/835),[PR841](https://github.com/librenms/librenms/pull/841))
  - Added ability to expand alert triggers for more details ([PR857](https://github.com/librenms/librenms/pull/857))
  - Added support for XTM/FBX Watchguard devices ([PR849](https://github.com/librenms/librenms/pull/849))
  - Updated Juniper MIBS and hardware rewrite ([PR838](https://github.com/librenms/librenms/pull/838))
  - Updated OpenBSD detection ([PR860](https://github.com/librenms/librenms/pull/860))
  - Added Macro support for alerting system ([PR863](https://github.com/librenms/librenms/pull/863))
  - Added support for tcp connections on rrdcached ([PR866](https://github.com/librenms/librenms/pull/866))
  - Added config option to enable / disable mouseover graphs ([PR873](https://github.com/librenms/librenms/pull/873))
  - General cleanup of files / folders permissions ([PR874](https://github.com/librenms/librenms/pull/874))
  - Added window size detection for map ([PR884](https://github.com/librenms/librenms/pull/884))
  - Added text to let users know refresh is disabled ([PR883](https://github.com/librenms/librenms/pull/883))

### Mar 2015

####Bug fixes
  - Updates to alert rules split ([PR550](https://github.com/librenms/librenms/pull/550))
  - Updated get_graphs() for API to resolve graph names ([PR613](https://github.com/librenms/librenms/pull/613))
  - Fixed use of REMOTE_ADDR to use X_FORWARDED_FOR if available ([PR620](https://github.com/librenms/librenms/pull/620))
  - Added yocto support from entPhySensorScale ([PR632](https://github.com/librenms/librenms/pull/632))
  - Eventlog search fixed ([PR644](https://github.com/librenms/librenms/pull/644))
  - Added missing OS discovery to default list ([PR660](https://github.com/librenms/librenms/pull/660))
  - Fixed logging issue when description of a port was removed ([PR673](https://github.com/librenms/librenms/pull/673))
  - Fixed logging issue when ports changed status ([PR675](https://github.com/librenms/librenms/pull/675))
  - Shortened interface names for graph display ([PR676](https://github.com/librenms/librenms/pull/676))

####Improvements
  - Visual updates to alert logs ([PR541](https://github.com/librenms/librenms/pull/541))
  - Added temperature support for APC AC units ([PR545](https://github.com/librenms/librenms/pull/545))
  - Added ability to pause and resume page refresh ([PR557](https://github.com/librenms/librenms/pull/557))
  - Added polling support for NXOS ([PR562](https://github.com/librenms/librenms/pull/562))
  - Added discovery support for 3Com switches ([PR568](https://github.com/librenms/librenms/pull/568))
  - Updated Comware support ([PR583](https://github.com/librenms/librenms/pull/583))
  - Added new logo ([PR584](https://github.com/librenms/librenms/pull/584))
  - Added dynamic removal of device data when removing device ([PR592](https://github.com/librenms/librenms/pull/592))
  - Updated alerting to use fifo ([PR607](https://github.com/librenms/librenms/pull/607))
  - Added distributed poller support ([PR609](https://github.com/librenms/librenms/pull/609) and [PR610](https://github.com/librenms/librenms/pull/610))
  - Added PowerConnect 55xx ([PR635](https://github.com/librenms/librenms/pull/635))
  - Added inventory API endpoint ([PR640](https://github.com/librenms/librenms/pull/640))
  - Added serial number detection for ASA firewalls ([PR642](https://github.com/librenms/librenms/pull/642))
  - Added missing MKTree library for inventory support ([PR646](https://github.com/librenms/librenms/pull/646))
  - Added support for exporting Alert logs to PDF ([PR653](https://github.com/librenms/librenms/pull/653))
  - Added basic Ubiquiti support ([PR659](https://github.com/librenms/librenms/pull/659))
  - Numerous docs update ([PR662](https://github.com/librenms/librenms/pull/662), [PR663](https://github.com/librenms/librenms/pull/663), [PR677](https://github.com/librenms/librenms/pull/677), [PR694](https://github.com/librenms/librenms/pull/694))
  - Added Polling information page ([PR664](https://github.com/librenms/librenms/pull/664))
  - Added HipChat notification support ([PR669](https://github.com/librenms/librenms/pull/669))
  - Implemented Jquery Bootgrid support ([PR671](https://github.com/librenms/librenms/pull/671))
  - Added new map to show xDP discovered links and devices ([PR679](https://github.com/librenms/librenms/pull/679) + [PR680](https://github.com/librenms/librenms/pull/680))

###Feb 2015

####Bug fixes
 - Removed header redirect causing page load delays ([PR436](https://github.com/librenms/librenms/pull/436))
 - Fixed stale alerting data ([PR475](https://github.com/librenms/librenms/pull/475))
 - Fixed api call for port stats to use device_id / hostname ([PR478](https://github.com/librenms/librenms/pull/478))
 - Work started on ensuring MySQL strict mode is supported ([PR521](https://github.com/librenms/librenms/pull/521))

####Improvements
 - Added support for Cisco Wireless Controllers ([PR422](https://github.com/librenms/librenms/pull/422))
 - Updated IRC Bot to support alerting system ([PR434](https://github.com/librenms/librenms/pull/434))
 - Added new message box to alert when a device hasn't polled for 15 minutes or more ([PR435](https://github.com/librenms/librenms/pull/435))
 - Added quick links on device list page to quickly access common pages ([PR440](https://github.com/librenms/librenms/pull/440))
 - Alerting docs updated to cover new features ([PR446](https://github.com/librenms/librenms/pull/446))
 - IBM NOS Support added ([PR454](https://github.com/librenms/librenms/pull/454))
 - Added basic Barracuda Loadbalancer support ([PR456](https://github.com/librenms/librenms/pull/456))
 - Small change to the search results to add port desc / alias ([PR457](https://github.com/librenms/librenms/pull/457))
 - Added Device sub menu to access devices category directly ([PR465](https://github.com/librenms/librenms/pull/465))
 - Added basic Ruckus Wireless support ([PR466](https://github.com/librenms/librenms/pull/466))
 - Added support for a demo user ([PR471](https://github.com/librenms/librenms/pull/471))
 - Many small visual updates
 - Added additional support for Cisco SB devices ([PR487](https://github.com/librenms/librenms/pull/487))
 - Added support to default home page for printing alerts ([PR488](https://github.com/librenms/librenms/pull/488))
 - Tidied up Alert menubar into sub menu ([PR489](https://github.com/librenms/librenms/pull/489))
 - Added historical alerts page ([PR495](https://github.com/librenms/librenms/pull/495))
 - Added battery charge monitoring for ([PR519](https://github.com/librenms/librenms/pull/519))
 - Added Slack support for alert system ([PR525](https://github.com/librenms/librenms/pull/525))
 - Added new debug for php / sql option to page footer ([PR484](https://github.com/librenms/librenms/pull/484))

###Jan 2015

####Bug fixes
 - Reverted chmod to make poller.php executable again ([PR394](https://github.com/librenms/librenms/pull/394))
 - Fixed duplicate port listing ([PR396](https://github.com/librenms/librenms/pull/396))
 - Fixed create bill from port page ([PR404](https://github.com/librenms/librenms/pull/404))
 - Fixed autodiscovery to use $config['mydomain'] correctly ([PR423](https://github.com/librenms/librenms/pull/423))
 - Fixed mute bug for alerts ([PR428](https://github.com/librenms/librenms/pull/428))

####Improvements
 - Updated login page visually ([PR391](https://github.com/librenms/librenms/pull/391))
 - Added Hikvision support ([PR393](https://github.com/librenms/librenms/pull/393))
 - Added ability to search for packages using unix agent ([PR395](https://github.com/librenms/librenms/pull/395))
 - Updated ifAlias support for varying distributions ([PR398](https://github.com/librenms/librenms/pull/398))
 - Updated visually Global Settings page ([PR401](https://github.com/librenms/librenms/pull/401))
 - Added missing default nginx graphs ([PR403](https://github.com/librenms/librenms/pull/403))
 - Updated check_mk_agent to latest git version ([PR409](https://github.com/librenms/librenms/pull/409))
 - Added support for recording process list with unix agent ([PR410](https://github.com/librenms/librenms/pull/410))
 - Added support for named/bind9/TinyDNS application using unix agent ([PR413](https://github.com/librenms/librenms/pull/413), [PR416](https://github.com/librenms/librenms/pull/416))
 - About page tidied up ([PR414](https://github.com/librenms/librenms/pull/414), [PR425](https://github.com/librenms/librenms/pull/425))
 - Updated progress bars to use bootstrap ([PR42](https://github.com/librenms/librenms/pull/42))
 - Updated install docs to cover CentOS7 ([PR424](https://github.com/librenms/librenms/pull/424))
 - Alerting system updated with more features ([PR429](https://github.com/librenms/librenms/pull/429), [PR430](https://github.com/librenms/librenms/pull/430))

###Dec 2014

####Bug fixes
 - Fixed Global Search box bootstrap ([PR357](https://github.com/librenms/librenms/pull/357))
 - Fixed display issues when calculating CDR in billing system ([PR359](https://github.com/librenms/librenms/pull/359))
 - Fixed API route order to resolve get_port_graphs working ([PR364](https://github.com/librenms/librenms/pull/364))

####Improvements
 - Added new API route to retrieve list of graphs for a device ([PR355](https://github.com/librenms/librenms/pull/355))
 - Added new API route to retrieve list of port for a device ([PR356](https://github.com/librenms/librenms/pull/356))
 - Added new API route to retrieve billing info ([PR360](https://github.com/librenms/librenms/pull/360))
 - Added alerting system ([PR370](https://github.com/librenms/librenms/pull/370), [PR369](https://github.com/librenms/librenms/pull/369), [PR367](https://github.com/librenms/librenms/pull/367))
 - Added dbSchema version to about page ([PR377](https://github.com/librenms/librenms/pull/377))
 - Added git log link to about page ([PR378](https://github.com/librenms/librenms/pull/378))
 - Added Two factor authentication ([PR383](https://github.com/librenms/librenms/pull/383))

###Nov 2014

####Bug fixes
 - Updated Alcatel-Lucent OmniSwitch detection ([PR340](https://github.com/librenms/librenms/pull/340))
 - Added fix for DLink port detection ([PR347](https://github.com/librenms/librenms/pull/347))
 - Fixed BGP session count ([PR334](https://github.com/librenms/librenms/pull/334))
 - Fixed errors with BGP polling and storing data in RRD ([PR346](https://github.com/librenms/librenms/pull/346))

####Improvements
 - Added option to clean old perf_times table entries ([PR343](https://github.com/librenms/librenms/pull/343))
 - Added nginx+php-fpm instructions ([PR345](https://github.com/librenms/librenms/pull/345))
 - Added BGP route to API ([PR335](https://github.com/librenms/librenms/pull/335))
 - Updated check_mk to new version + removed Observium branding ([PR311](https://github.com/librenms/librenms/pull/311))
 - Updated Edit SNMP settings page for device to only show relevant SNMP options ([PR317](https://github.com/librenms/librenms/pull/317))
 - Eventlog page now uses paged results ([PR336](https://github.com/librenms/librenms/pull/336))
 - Added new API route to show peering, transit and core graphs ([PR349](https://github.com/librenms/librenms/pull/349))
 - Added VyOS and EdgeOS detection ([PR351](https://github.com/librenms/librenms/pull/351) / [PR352](https://github.com/librenms/librenms/pull/352))
 - Documentation style and markdown updates ([PR353](https://github.com/librenms/librenms/pull/353))

###Oct 2014

####Bug fixes
 - Fixed displaying device image in device list ([PR296](https://github.com/librenms/librenms/pull/296))
 - Fixed placement of popups ([PR297](https://github.com/librenms/librenms/pull/297))
 - Updated authToken response code in API to 401 ([PR310](https://github.com/librenms/librenms/pull/310))
 - Removed trailing / from v0 part of API url ([PR312](https://github.com/librenms/librenms/pull/312))
 - Added correct response code for API call get_vlans ([PR313](https://github.com/librenms/librenms/pull/313))
 - Updated yearly graphs to fix year variable being passed ([PR316](https://github.com/librenms/librenms/pull/316))
 - Updated transport list to be generated from $config ([PR318](https://github.com/librenms/librenms/pull/318))
 - Moved addhost button on add host page as it was hidden ([PR319](https://github.com/librenms/librenms/pull/319))
 - Added stripslashes to hrdevice page ([PR321](https://github.com/librenms/librenms/pull/321))
 - Fixed web installer issue due to variable name change ([PR325](https://github.com/librenms/librenms/pull/325))
 - Updated disabled field in api tokens ([PR327](https://github.com/librenms/librenms/pull/327))
 - Fixed daily.sh not running from outside install directory (cron) ([PR328](https://github.com/librenms/librenms/pull/328))
 - Removed --no-edit from daily.php git pull ([PR309](https://github.com/librenms/librenms/pull/309))

####Improvements
 - Added ability to create api tokens ([PR294](https://github.com/librenms/librenms/pull/294))
 - Added icmp and poller graphs for devices ([PR295](https://github.com/librenms/librenms/pull/295))
 - Added urldecode/urlencode support for interface names in API ([PR298](https://github.com/librenms/librenms/pull/298))
 - Added new library to support on screen notifications ([PR300](https://github.com/librenms/librenms/pull/300))
 - Added authlog purge function and improved efficiency in clearing syslog table ([PR301](https://github.com/librenms/librenms/pull/301))
 - Updated addhost page to show relevant snmp options ([PR303](https://github.com/librenms/librenms/pull/303))
 - Added limit $config for front page boxes ([PR305](https://github.com/librenms/librenms/pull/305))
 - Updated http-auth adding user to check if user already exists ([PR307](https://github.com/librenms/librenms/pull/307))
 - Added names to all API routes ([PR314](https://github.com/librenms/librenms/pull/314))
 - Added route to call list of API endpoints ([PR315](https://github.com/librenms/librenms/pull/315))
 - Added options to $config to specify fping retry and timeout ([PR323](https://github.com/librenms/librenms/pull/323))
 - Added icmp / snmp to device down alerts for debugging ([PR324](https://github.com/librenms/librenms/pull/324))
 - Added function to page results for large result pages ([PR333](https://github.com/librenms/librenms/pull/333))

###Sep 2014

####Bug fixes
 - Updated vtpversion check to fix vlan discovery issues ([PR289](https://github.com/librenms/librenms/pull/289))
 - Fixed mac address change false positives ([PR292](https://github.com/librenms/librenms/pull/292))

####Improvements
 - Hide snmp passwords on edit snmp form ([PR290](https://github.com/librenms/librenms/pull/290))
 - Updates to API ([PR291](https://github.com/librenms/librenms/pull/291))

###Aug 2014

####Bug fixes
 - Disk % not showing in health view ([PR284](https://github.com/librenms/librenms/pull/284))
 - Fixed layout issue for ports list ([PR286](https://github.com/librenms/librenms/pull/286))
 - Removed session regeneration ([PR287](https://github.com/librenms/librenms/pull/287))
 - Updated edit button on edit user screen ([PR288](https://github.com/librenms/librenms/pull/288))

####Improvements
 - Added email field for add user form ([PR278](https://github.com/librenms/librenms/pull/278))
 - V0 of API release ([PR282](https://github.com/librenms/librenms/pull/282))

###Jul 2014

####Bug fixes
 - Fixed RRD creation using MAX twice ([PR266](https://github.com/librenms/librenms/pull/266))
 - Fixed variables leaking in poller run ([PR267](https://github.com/librenms/librenms/pull/267))
 - Fixed links to health graphs ([PR271](https://github.com/librenms/librenms/pull/271))
 - Fixed install docs to remove duplicate snmpd on install ([PR276](https://github.com/librenms/librenms/pull/276))

####Improvements
 - Added support for Cisco ASA connection graphs ([PR268](https://github.com/librenms/librenms/pull/268))
 - Updated delete device page ([PR270](https://github.com/librenms/librenms/pull/270))

###Jun 2014

####Bug fixes
 - Fixed a couple of DB queries ([PR222](https://github.com/librenms/librenms/pull/222))
 - Fixes to make interface more mobile friendly ([PR227](https://github.com/librenms/librenms/pull/227))
 - Fixed link to device on overview apps page ([PR228](https://github.com/librenms/librenms/pull/228))
 - Fixed missing backticks on SQL queries ([PR253](https://github.com/librenms/librenms/pull/253) / [PR254](https://github.com/librenms/librenms/pull/254))
 - Fixed user permissions page ([PR265](https://github.com/librenms/librenms/pull/265))

####Improvements
 - Updated index page ([PR224](https://github.com/librenms/librenms/pull/224))
 - Updated global search visually ([PR223](https://github.com/librenms/librenms/pull/223))
 - Added contributors agreement ([PR225](https://github.com/librenms/librenms/pull/225))
 - Added ability to update health values ([PR226](https://github.com/librenms/librenms/pull/226))
 - Tidied up search box on devices list page ([PR229](https://github.com/librenms/librenms/pull/229))
 - Updated port search box and port table list ([PR230](https://github.com/librenms/librenms/pull/230))
 - Removed some unused javascript libraries ([PR231](https://github.com/librenms/librenms/pull/231))
 - Updated year and column for vertical status summary ([PR232](https://github.com/librenms/librenms/pull/232))
 - Tidied up the delete user page ([PR235](https://github.com/librenms/librenms/pull/235))
 - Added snmp port to $config ([PR237](https://github.com/librenms/librenms/pull/237))
 - Added documentation for lighttpd ([PR238](https://github.com/librenms/librenms/pull/238))
 - Updated all device edit pages ([PR239](https://github.com/librenms/librenms/pull/239))
 - Added IPv6 only host support ([PR241](https://github.com/librenms/librenms/pull/241))
 - Added public status page ([PR246](https://github.com/librenms/librenms/pull/246))
 - Added validate_device_id function ([PR257](https://github.com/librenms/librenms/pull/257))
 - Added auto detect of install location ([PR259](https://github.com/librenms/librenms/pull/259))

###Mar 2014

####Bug fixes
 - Removed link to pdf in billing history ([PR146](https://github.com/librenms/librenms/pull/146))
 - librenms logs now saved in correct location ([PR163](https://github.com/librenms/librenms/pull/163))
 - Updated pfsense detection ([PR182](https://github.com/librenms/librenms/pull/182))
 - Fixed health page mini cpu ([PR195](https://github.com/librenms/librenms/pull/195))
 - Updated install docs to include php5-json ([PR196](https://github.com/librenms/librenms/pull/196))
 - Fixed Dlink interface names ([PR200](https://github.com/librenms/librenms/pull/200) / [PR203](https://github.com/librenms/librenms/pull/203))
 - Stop shortening IP in shorthost function ([PR210](https://github.com/librenms/librenms/pull/210))
 - Fixed status box overlapping ([PR211](https://github.com/librenms/librenms/pull/211))
 - Fixed top port overlay issue ([PR212](https://github.com/librenms/librenms/pull/212))
 - Updated docs and daily.sh to update DB schemas ([PR215](https://github.com/librenms/librenms/pull/215))
 - Updated hardware detection for RouterOS ([PR217](https://github.com/librenms/librenms/pull/217))
 - Restore _GET variables for logging in ([PR218](https://github.com/librenms/librenms/pull/218))

####Improvements
 - Updated inventory page to use bootstrap ([PR141](https://github.com/librenms/librenms/pull/141))
 - Updated mac / arp pages to use bootstrap ([PR147](https://github.com/librenms/librenms/pull/147))
 - Updated devices page to use bootstrap ([PR149](https://github.com/librenms/librenms/pull/149))
 - Updated delete host page to use bootstrap ([PR151](https://github.com/librenms/librenms/pull/151))
 - Updated print_error function to use bootstrap ([PR153](https://github.com/librenms/librenms/pull/153))
 - Updated install docs for Apache 2.3 > ([PR161](https://github.com/librenms/librenms/pull/161))
 - Upgraded PHPMailer ([PR169](https://github.com/librenms/librenms/pull/169))
 - Added send_mail function using PHPMailer ([PR170](https://github.com/librenms/librenms/pull/170))
 - Added new and awesome IRC Bot ([PR171](https://github.com/librenms/librenms/pull/171))
 - Added Gentoo detection and logo ([PR174](https://github.com/librenms/librenms/pull/174) / [PR179](https://github.com/librenms/librenms/pull/179))
 - Added Engenius detection ([PR186](https://github.com/librenms/librenms/pull/186))
 - Updated edit user to enable editing ([PR187](https://github.com/librenms/librenms/pull/187))
 - Added EAP600 engenius support ([PR188](https://github.com/librenms/librenms/pull/188))
 - Added Plugin system ([PR189](https://github.com/librenms/librenms/pull/189))
 - MySQL calls updated to use dbFacile ([PR190](https://github.com/librenms/librenms/pull/190))
 - Added support for Dlink devices ([PR193](https://github.com/librenms/librenms/pull/193))
 - Added Windows 2012 polling support ([PR201](https://github.com/librenms/librenms/pull/201))
 - Added purge options for syslog / eventlog ([PR204](https://github.com/librenms/librenms/pull/204))
 - Added BGP to global search box ([PR205](https://github.com/librenms/librenms/pull/205))

###Feb 2014

####Bug fixes
 - Set poller-wrapper.py to be executable ([PR89](https://github.com/librenms/librenms/pull/89))
 - Fix device/port down boxes ([PR99](https://github.com/librenms/librenms/pull/99))
 - Ports set to be ignored honoured for threshold alerts ([PR104](https://github.com/librenms/librenms/pull/104))
 - Added PasswordHash.php to adduser.php ([PR119](https://github.com/librenms/librenms/pull/119))
 - build-base.php update to run DB updates ([PR128](https://github.com/librenms/librenms/pull/128))

####Improvements
 - Added web based installer ([PR75](https://github.com/librenms/librenms/pull/75))
 - Updated login page design ([PR78](https://github.com/librenms/librenms/pull/78))
 - Ability to enable / disable topX boxes ([PR100](https://github.com/librenms/librenms/pull/100))
 - Added PHPPass support for MySQL auth logins ([PR101](https://github.com/librenms/librenms/pull/101))
 - Updated to Bootstrap 3.1 ([PR106](https://github.com/librenms/librenms/pull/106))
 - index.php tidied up ([PR107](https://github.com/librenms/librenms/pull/107))
 - Updated device overview page design ([PR113](https://github.com/librenms/librenms/pull/113))
 - Updated print_optionbar* to use bootstrap ([PR115](https://github.com/librenms/librenms/pull/115))
 - Updated device/port/services box to use bootstrap ([PR117](https://github.com/librenms/librenms/pull/117))
 - Updated eventlog / syslog to use bootstrap ([PR132](https://github.com/librenms/librenms/pull/132) / [PR134](https://github.com/librenms/librenms/pull/134))

###Jan 2014

####Bug fixes
 - Moved location redirect for logout ([PR55](https://github.com/librenms/librenms/pull/55))
 - Remove debug statements from process_syslog ([PR57](https://github.com/librenms/librenms/pull/57))
 - Stop print-syslog.inc.php from shortening hostnames ([PR62](https://github.com/librenms/librenms/pull/62))
 - Moved some variables from defaults.inc.php to definitions.inc.php ([PR66](https://github.com/librenms/librenms/pull/66))
 - Fixed title being set correctly ([PR73](https://github.com/librenms/librenms/pull/73))
 - Added documentation to enable billing module ([PR74](https://github.com/librenms/librenms/pull/74))

####Improvements
 - Deleting devices now asks for confirmation ([PR53](https://github.com/librenms/librenms/pull/53))
 - Added ARP discovered device name and IP to eventlog ([PR54](https://github.com/librenms/librenms/pull/54))
 - Initial updated design release ([PR59](https://github.com/librenms/librenms/pull/59))
 - Added ifAlias script ([PR70](https://github.com/librenms/librenms/pull/70))
 - Added console ui ([PR72](https://github.com/librenms/librenms/pull/72))

###Nov 2013

####Bug fixes
 - Updates to fix arp discovery

####Improvements
 - Added poller-wrapper (f8debf4)
 - Documentation####Improvements and additions
 - Added auto update feature
 - Visual updates
 - License tidy up started

###Oct 2013

 - Initial release
