<?php


function rewrite_location($location)
{
    // FIXME -- also check the database for rewrites?
    global $config, $debug;

    if (is_array($config['location_map_regex'])) {
        foreach ($config['location_map_regex'] as $reg => $val) {
            if (preg_match($reg, $location)) {
                $location = $val;
                break;
            }
        }
    }

    if (is_array($config['location_map_regex_sub'])) {
        foreach ($config['location_map_regex_sub'] as $reg => $val) {
            if (preg_match($reg, $location)) {
                $location = preg_replace($reg, $val, $location);
                break;
            }
        }
    }

    if (isset($config['location_map'][$location])) {
        $location = $config['location_map'][$location];
    }

    return $location;
}


function formatMac($mac)
{
    $mac = preg_replace('/(..)(..)(..)(..)(..)(..)/', '\\1:\\2:\\3:\\4:\\5:\\6', $mac);

    return $mac;
}


function rewrite_entity_descr($descr)
{
    $descr = str_replace('Distributed Forwarding Card', 'DFC', $descr);
    $descr = preg_replace('/7600 Series SPA Interface Processor-/', '7600 SIP-', $descr);
    $descr = preg_replace('/Rev\.\ [0-9\.]+\ /', '', $descr);
    $descr = preg_replace('/12000 Series Performance Route Processor/', '12000 PRP', $descr);
    $descr = preg_replace('/^12000/', '', $descr);
    $descr = preg_replace('/Gigabit Ethernet/', 'GigE', $descr);
    $descr = preg_replace('/^ASR1000\ /', '', $descr);
    $descr = str_replace('Routing Processor', 'RP', $descr);
    $descr = str_replace('Route Processor', 'RP', $descr);
    $descr = str_replace('Switching Processor', 'SP', $descr);
    $descr = str_replace('Sub-Module', 'Module ', $descr);
    $descr = str_replace('DFC Card', 'DFC', $descr);
    $descr = str_replace('Centralized Forwarding Card', 'CFC', $descr);
    $descr = str_replace('Power Supply Module', 'PSU ', $descr);
    $descr = str_replace('/Voltage Sensor/', 'Voltage', $descr);
    $descr = str_replace('Sensor', '', $descr);
    $descr = preg_replace('/^temperatures /', '', $descr);
    $descr = preg_replace('/^voltages /', '', $descr);

    return $descr;
}


/**
 * Clean port values for html display
 * Add label to the port array (usually one of ifAlias, ifName, ifDescr)
 *
 * @param array $interface
 * @param null|array $device
 * @return mixed
 */
function cleanPort($interface, $device = null)
{
    global $config;

    $interface['ifAlias'] = display($interface['ifAlias']);
    $interface['ifName']  = display($interface['ifName']);
    $interface['ifDescr'] = display($interface['ifDescr']);

    if (!$device) {
        $device = device_by_id_cache($interface['device_id']);
    }

    $os = strtolower($device['os']);

    if (isset($config['os'][$os]['ifname'])) {
        $interface['label'] = $interface['ifName'];

        if ($interface['ifName'] == '') {
            $interface['label'] = $interface['ifDescr'];
        }
    } elseif (isset($config['os'][$os]['ifalias'])) {
        $interface['label'] = $interface['ifAlias'];
    } else {
        $interface['label'] = $interface['ifDescr'];
        if (isset($config['os'][$os]['ifindex'])) {
            $interface['label'] = $interface['label'].' '.$interface['ifIndex'];
        }
    }

    if ($device['os'] == 'speedtouch') {
        list($interface['label']) = explode('thomson', $interface['label']);
    }

    if (is_array($config['rewrite_if'])) {
        foreach ($config['rewrite_if'] as $src => $val) {
            if (stristr($interface['label'], $src)) {
                $interface['label'] = $val;
            }
        }
    }

    if (is_array($config['rewrite_if_regexp'])) {
        foreach ($config['rewrite_if_regexp'] as $reg => $val) {
            if (preg_match($reg.'i', $interface['label'])) {
                $interface['label'] = preg_replace($reg.'i', $val, $interface['label']);
            }
        }
    }

    return $interface;
}

function translate_ifOperStatus($ifOperStatus)
{
    $translate_ifOperStatus = array(
        '1' => 'up',
        '2' => 'down',
        '3' => 'testing',
        '4' => 'unknown',
        '5' => 'dormant',
        '6' => 'notPresent',
        '7' => 'lowerLayerDown',
    );

    if (isset($translate_ifOperStatus[$ifOperStatus])) {
        $ifOperStatus = $translate_ifOperStatus[$ifOperStatus];
    }

    return $ifOperStatus;
}


function translate_ifAdminStatus($ifAdminStatus)
{
    $translate_ifAdminStatus = array(
        '1' => 'up',
        '2' => 'down',
        '3' => 'testing',
    );

    if (isset($translate_ifAdminStatus[$ifAdminStatus])) {
        $ifAdminStatus = $translate_ifAdminStatus[$ifAdminStatus];
    }

    return $ifAdminStatus;
}


// Specific rewrite functions

function makeshortif($if)
{
    $rewrite_shortif = array(
        'tengigabitethernet'  => 'Te',
        'ten-gigabitethernet' => 'Te',
        'tengige'             => 'Te',
        'gigabitethernet'     => 'Gi',
        'fastethernet'        => 'Fa',
        'ethernet'            => 'Et',
        'serial'              => 'Se',
        'pos'                 => 'Pos',
        'port-channel'        => 'Po',
        'atm'                 => 'Atm',
        'null'                => 'Null',
        'loopback'            => 'Lo',
        'dialer'              => 'Di',
        'vlan'                => 'Vlan',
        'tunnel'              => 'Tunnel',
        'serviceinstance'     => 'SI',
        'dwdm'                => 'DWDM',
        'bundle-ether'        => 'BE',
    );

    $if = fixifName($if);
    $if = strtolower($if);
    $if = array_str_replace($rewrite_shortif, $if);
    return $if;
}


function rewrite_ios_features($features)
{
    $rewrite_ios_features = array(
        'PK9S'                => 'IP w/SSH LAN Only',
        'LANBASEK9'           => 'Lan Base Crypto',
        'LANBASE'             => 'Lan Base',
        'ADVENTERPRISEK9_IVS' => 'Advanced Enterprise Crypto Voice',
        'ADVENTERPRISEK9'     => 'Advanced Enterprise Crypto',
        'ADVSECURITYK9'       => 'Advanced Security Crypto',
        'K91P'                => 'Provider Crypto',
        'K4P'                 => 'Provider Crypto',
        'ADVIPSERVICESK9'     => 'Adv IP Services Crypto',
        'ADVIPSERVICES'       => 'Adv IP Services',
        'IK9P'                => 'IP Plus Crypto',
        'K9O3SY7'             => 'IP ADSL FW IDS Plus IPSEC 3DES',
        'SPSERVICESK9'        => 'SP Services Crypto',
        'PK9SV'               => 'IP MPLS/IPV6 W/SSH + BGP',
        'IS'                  => 'IP Plus',
        'IPSERVICESK9'        => 'IP Services Crypto',
        'BROADBAND'           => 'Broadband',
        'IPBASE'              => 'IP Base',
        'IPSERVICE'           => 'IP Services',
        'P'                   => 'Service Provider',
        'P11'                 => 'Broadband Router',
        'G4P5'                => 'NRP',
        'JK9S'                => 'Enterprise Plus Crypto',
        'IK9S'                => 'IP Plus Crypto',
        'JK'                  => 'Enterprise Plus',
        'I6Q4L2'              => 'Layer 2',
        'I6K2L2Q4'            => 'Layer 2 Crypto',
        'C3H2S'               => 'Layer 2 SI/EI',
        '_WAN'                => ' + WAN',
    );

    $type = array_preg_replace($rewrite_ios_features, $features);

    return ($features);
}


function rewrite_fortinet_hardware($hardware)
{
    $rewrite_fortinet_hardware = array(
        '.1.3.6.1.4.1.12356.102.1.1000'  => 'FortiAnalyzer 100',
        '.1.3.6.1.4.1.12356.102.1.10002' => 'FortiAnalyzer 1000B',
        '.1.3.6.1.4.1.12356.102.1.1001'  => 'FortiAnalyzer 100A',
        '.1.3.6.1.4.1.12356.102.1.1002'  => 'FortiAnalyzer 100B',
        '.1.3.6.1.4.1.12356.102.1.20000' => 'FortiAnalyzer 2000',
        '.1.3.6.1.4.1.12356.102.1.20001' => 'FortiAnalyzer 2000A',
        '.1.3.6.1.4.1.12356.102.1.4000'  => 'FortiAnalyzer 400',
        '.1.3.6.1.4.1.12356.102.1.40000' => 'FortiAnalyzer 4000',
        '.1.3.6.1.4.1.12356.102.1.40001' => 'FortiAnalyzer 4000A',
        '.1.3.6.1.4.1.12356.102.1.4002'  => 'FortiAnalyzer 400B',
        '.1.3.6.1.4.1.12356.102.1.8000'  => 'FortiAnalyzer 800',
        '.1.3.6.1.4.1.12356.102.1.8002'  => 'FortiAnalyzer 800B',
        '.1.3.6.1.4.1.12356.101.1.1000'  => 'FortiGate 100',
        '.1.3.6.1.4.1.12356.101.1.10000' => 'FortiGate 1000',
        '.1.3.6.1.4.1.12356.101.1.10001' => 'FortiGate 1000A',
        '.1.3.6.1.4.1.12356.101.1.10002' => 'FortiGate 1000AFA2',
        '.1.3.6.1.4.1.12356.101.1.10003' => 'FortiGate 1000ALENC',
        '.1.3.6.1.4.1.12356.101.1.1001'  => 'FortiGate 100A',
        '.1.3.6.1.4.1.12356.101.1.1002'  => 'FortiGate 110C',
        '.1.3.6.1.4.1.12356.101.1.1003'  => 'FortiGate 111C',
        '.1.3.6.1.4.1.12356.101.1.2000'  => 'FortiGate 200',
        '.1.3.6.1.4.1.12356.101.1.20000' => 'FortiGate 2000',
        '.1.3.6.1.4.1.12356.101.1.2001'  => 'FortiGate 200A',
        '.1.3.6.1.4.1.12356.101.1.2002'  => 'FortiGate 224B',
        '.1.3.6.1.4.1.12356.101.1.2003'  => 'FortiGate 200A',
        '.1.3.6.1.4.1.12356.101.1.3000'  => 'FortiGate 300',
        '.1.3.6.1.4.1.12356.101.1.30000' => 'FortiGate 3000',
        '.1.3.6.1.4.1.12356.101.1.3001'  => 'FortiGate 300A',
        '.1.3.6.1.4.1.12356.101.1.30160' => 'FortiGate 3016B',
        '.1.3.6.1.4.1.12356.101.1.302'   => 'FortiGate 30B',
        '.1.3.6.1.4.1.12356.101.1.3002'  => 'FortiGate 310B',
        '.1.3.6.1.4.1.12356.101.1.36000' => 'FortiGate 3600',
        '.1.3.6.1.4.1.12356.101.1.36003' => 'FortiGate 3600A',
        '.1.3.6.1.4.1.12356.101.1.38100' => 'FortiGate 3810A',
        '.1.3.6.1.4.1.12356.101.1.4000'  => 'FortiGate 400',
        '.1.3.6.1.4.1.12356.101.1.40000' => 'FortiGate 4000',
        '.1.3.6.1.4.1.12356.101.1.4001'  => 'FortiGate 400A',
        '.1.3.6.1.4.1.12356.101.1.5000'  => 'FortiGate 500',
        '.1.3.6.1.4.1.12356.101.1.50000' => 'FortiGate 5000',
        '.1.3.6.1.4.1.12356.101.1.50010' => 'FortiGate 5001',
        '.1.3.6.1.4.1.12356.101.1.50011' => 'FortiGate 5001A',
        '.1.3.6.1.4.1.12356.101.1.50012' => 'FortiGate 5001FA2',
        '.1.3.6.1.4.1.12356.101.1.50021' => 'FortiGate 5002A',
        '.1.3.6.1.4.1.12356.101.1.50001' => 'FortiGate 5002FB2',
        '.1.3.6.1.4.1.12356.101.1.50040' => 'FortiGate 5004',
        '.1.3.6.1.4.1.12356.101.1.50050' => 'FortiGate 5005',
        '.1.3.6.1.4.1.12356.101.1.50051' => 'FortiGate 5005FA2',
        '.1.3.6.1.4.1.12356.101.1.5001'  => 'FortiGate 500A',
        '.1.3.6.1.4.1.12356.101.1.500'   => 'FortiGate 50A',
        '.1.3.6.1.4.1.12356.101.1.501'   => 'FortiGate 50AM',
        '.1.3.6.1.4.1.12356.101.1.502'   => 'FortiGate 50B',
        '.1.3.6.1.4.1.12356.101.1.504'   => 'FortiGate 51B',
        '.1.3.6.1.4.1.12356.101.1.600'   => 'FortiGate 60',
        '.1.3.6.1.4.1.12356.101.1.6201'  => 'FortiGate 600D',
        '.1.3.6.1.4.1.12356.101.1.602'   => 'FortiGate 60ADSL',
        '.1.3.6.1.4.1.12356.101.1.603'   => 'FortiGate 60B',
        '.1.3.6.1.4.1.12356.101.1.601'   => 'FortiGate 60M',
        '.1.3.6.1.4.1.12356.101.1.6200'  => 'FortiGate 620B',
        '.1.3.6.1.4.1.12356.101.1.8000'  => 'FortiGate 800',
        '.1.3.6.1.4.1.12356.101.1.8001'  => 'FortiGate 800F',
        '.1.3.6.1.4.1.12356.101.1.800'   => 'FortiGate 80C',
        '.1.3.6.1.4.1.12356.1688'        => 'FortiMail 2000A',
        '.1.3.6.1.4.1.12356.103.1.1000'  => 'FortiManager 100',
        '.1.3.6.1.4.1.12356.103.1.20000' => 'FortiManager 2000XL',
        '.1.3.6.1.4.1.12356.103.1.3004'  => 'FortiManager 300D',
        '.1.3.6.1.4.1.12356.103.1.30000' => 'FortiManager 3000',
        '.1.3.6.1.4.1.12356.103.1.30002' => 'FortiManager 3000B',
        '.1.3.6.1.4.1.12356.103.1.4000'  => 'FortiManager 400',
        '.1.3.6.1.4.1.12356.103.1.4001'  => 'FortiManager 400A',
        '.1.3.6.1.4.1.12356.106.1.50030' => 'FortiSwitch 5003A',
        '.1.3.6.1.4.1.12356.101.1.510'   => 'FortiWiFi 50B',
        '.1.3.6.1.4.1.12356.101.1.610'   => 'FortiWiFi 60',
        '.1.3.6.1.4.1.12356.101.1.611'   => 'FortiWiFi 60A',
        '.1.3.6.1.4.1.12356.101.1.612'   => 'FortiWiFi 60AM',
        '.1.3.6.1.4.1.12356.101.1.613'   => 'FortiWiFi 60B',
    );


    $hardware = $rewrite_fortinet_hardware[$hardware];

    return ($hardware);
}


function rewrite_extreme_hardware($hardware)
{
    $rewrite_extreme_hardware = array(
        '.1.3.6.1.4.1.1916.2.26'  => 'Alpine 3802',
        '.1.3.6.1.4.1.1916.2.20'  => 'Alpine 3804',
        '.1.3.6.1.4.1.1916.2.17'  => 'Alpine 3808',
        '.1.3.6.1.4.1.1916.2.86'  => 'Altitude 300',
        '.1.3.6.1.4.1.1916.2.75'  => 'Altitude 350',
        '.1.3.6.1.4.1.1916.2.56'  => 'BlackDiamond 10808',
        '.1.3.6.1.4.1.1916.2.85'  => 'BlackDiamond 12802',
        '.1.3.6.1.4.1.1916.2.77'  => 'BlackDiamond 12804',
        '.1.3.6.1.4.1.1916.2.8'   => 'BlackDiamond 6800',
        '.1.3.6.1.4.1.1916.2.27'  => 'BlackDiamond 6804',
        '.1.3.6.1.4.1.1916.2.11'  => 'BlackDiamond 6808',
        '.1.3.6.1.4.1.1916.2.24'  => 'BlackDiamond 6816',
        '.1.3.6.1.4.1.1916.2.74'  => 'BlackDiamond 8806',
        '.1.3.6.1.4.1.1916.2.62'  => 'BlackDiamond 8810',
        '.1.3.6.1.4.1.1916.2.23'  => 'EnetSwitch 24Port',
        '.1.3.6.1.4.1.1916.2.83'  => 'Sentriant CE150',
        '.1.3.6.1.4.1.1916.2.58'  => 'Summit 400-48t',
        '.1.3.6.1.4.1.1916.2.71'  => 'Summit X450a-24t',
        '.1.3.6.1.4.1.1916.2.81'  => 'Summit X450a-24t',
        '.1.3.6.1.4.1.1916.2.1'   => 'Summit 1',
        '.1.3.6.1.4.1.1916.2.19'  => 'Summit 1iSX',
        '.1.3.6.1.4.1.1916.2.14'  => 'Summit 1iTX',
        '.1.3.6.1.4.1.1916.2.2'   => 'Summit 2',
        '.1.3.6.1.4.1.1916.2.53'  => 'Summit 200-24',
        '.1.3.6.1.4.1.1916.2.70'  => 'Summit 200-24fx',
        '.1.3.6.1.4.1.1916.2.54'  => 'Summit 200-48',
        '.1.3.6.1.4.1.1916.2.7'   => 'Summit 24',
        '.1.3.6.1.4.1.1916.2.41'  => 'Summit 24e2SX',
        '.1.3.6.1.4.1.1916.2.40'  => 'Summit 24e2TX',
        '.1.3.6.1.4.1.1916.2.25'  => 'Summit 24e3',
        '.1.3.6.1.4.1.1916.2.3'   => 'Summit 3',
        '.1.3.6.1.4.1.1916.2.61'  => 'Summit 300-24',
        '.1.3.6.1.4.1.1916.2.55'  => 'Summit 300-48',
        '.1.3.6.1.4.1.1916.2.4'   => 'Summit 4',
        '.1.3.6.1.4.1.1916.2.64'  => 'Summit 400-24p',
        '.1.3.6.1.4.1.1916.2.63'  => 'Summit 400-24t',
        '.1.3.6.1.4.1.1916.2.59'  => 'Summit 400-24x',
        '.1.3.6.1.4.1.1916.2.6'   => 'Summit 48',
        '.1.3.6.1.4.1.1916.2.16'  => 'Summit 48i',
        '.1.3.6.1.4.1.1916.2.28'  => 'Summit 48i1u',
        '.1.3.6.1.4.1.1916.2.5'   => 'Summit 4FX',
        '.1.3.6.1.4.1.1916.2.15'  => 'Summit 5i',
        '.1.3.6.1.4.1.1916.2.21'  => 'Summit 5iLX',
        '.1.3.6.1.4.1.1916.2.22'  => 'Summit 5iTX',
        '.1.3.6.1.4.1.1916.2.12'  => 'Summit 7iSX',
        '.1.3.6.1.4.1.1916.2.13'  => 'Summit 7iTX',
        '.1.3.6.1.4.1.1916.2.30'  => 'Summit Px1',
        '.1.3.6.1.4.1.1916.2.67'  => 'SummitStack',
        '.1.3.6.1.4.1.1916.2.93'  => 'Summit Ver2Stack',
        '.1.3.6.1.4.1.1916.2.68'  => 'SummitWM 100',
        '.1.3.6.1.4.1.1916.2.69'  => 'SummitWM 1000',
        '.1.3.6.1.4.1.1916.2.94'  => 'SummitWM 200',
        '.1.3.6.1.4.1.1916.2.95'  => 'SummitWM 2000',
        '.1.3.6.1.4.1.1916.2.89'  => 'Summit X250-24p',
        '.1.3.6.1.4.1.1916.2.88'  => 'Summit X250-24t',
        '.1.3.6.1.4.1.1916.2.90'  => 'Summit X250-24x',
        '.1.3.6.1.4.1.1916.2.92'  => 'Summit X250-48p',
        '.1.3.6.1.4.1.1916.2.91'  => 'Summit X250-48t',
        '.1.3.6.1.4.1.1916.2.66'  => 'Summit X450-24t',
        '.1.3.6.1.4.1.1916.2.65'  => 'Summit X450-24x',
        '.1.3.6.1.4.1.1916.2.80'  => 'Summit X450a-24tDC',
        '.1.3.6.1.4.1.1916.2.84'  => 'Summit X450a-24x',
        '.1.3.6.1.4.1.1916.2.82'  => 'Summit X450a-24xDC',
        '.1.3.6.1.4.1.1916.2.76'  => 'Summit X450a-48t',
        '.1.3.6.1.4.1.1916.2.87'  => 'Summit X450a-48tDC',
        '.1.3.6.1.4.1.1916.2.72'  => 'Summit X450e-24p',
        '.1.3.6.1.4.1.1916.2.79'  => 'Summit X450e-48p',
        '.1.3.6.1.4.1.1916.2.100' => 'Summit x150-24t',
        '.1.3.6.1.4.1.1916.2.114' => 'Summit x650-24x',
        '.1.3.6.1.4.1.1916.2.129' => 'NWI-e450a',
        '.1.3.6.1.4.1.1916.2.133' => 'Summit x480-48t',
        '.1.3.6.1.4.1.1916.2.141' => 'Summit x480-48x',
        '.1.3.6.1.4.1.1916.2.167' => 'Summit x670-48x',
        '.1.3.6.1.4.1.1916.2.168' => 'Summit x670v-48x',
    );

    // $hardware = array_str_replace($rewrite_extreme_hardware, $hardware);
    $hardware = $rewrite_extreme_hardware[$hardware];

    return ($hardware);
}


function rewrite_ftos_hardware($hardware)
{
    $rewrite_ftos_hardware = array(
        '.1.3.6.1.4.1.6027.1.1.1'  => 'E1200',
        '.1.3.6.1.4.1.6027.1.1.2'  => 'E600',
        '.1.3.6.1.4.1.6027.1.1.3'  => 'E300',
        '.1.3.6.1.4.1.6027.1.1.4'  => 'E610',
        '.1.3.6.1.4.1.6027.1.1.5'  => 'E1200i',
        '.1.3.6.1.4.1.6027.1.2.1'  => 'C300',
        '.1.3.6.1.4.1.6027.1.2.2'  => 'C150',
        '.1.3.6.1.4.1.6027.1.3.1'  => 'S50',
        '.1.3.6.1.4.1.6027.1.3.2'  => 'S50E',
        '.1.3.6.1.4.1.6027.1.3.3'  => 'S50V',
        '.1.3.6.1.4.1.6027.1.3.4'  => 'S25P-AC',
        '.1.3.6.1.4.1.6027.1.3.5'  => 'S2410CP',
        '.1.3.6.1.4.1.6027.1.3.6'  => 'S2410P',
        '.1.3.6.1.4.1.6027.1.3.7'  => 'S50N-AC',
        '.1.3.6.1.4.1.6027.1.3.8'  => 'S50N-DC',
        '.1.3.6.1.4.1.6027.1.3.9'  => 'S25P-DC',
        '.1.3.6.1.4.1.6027.1.3.10' => 'S25V',
        '.1.3.6.1.4.1.6027.1.3.11' => 'S25N',
    );

    $hardware = $rewrite_ftos_hardware[$hardware];

    return ($hardware);
}


function rewrite_ironware_hardware($hardware)
{
    $rewrite_ironware_hardware = array(
        'snFIWGSwitch'                           => 'Stackable FastIron workgroup',
        'snFIBBSwitch'                           => 'Stackable FastIron backbone',
        'snNIRouter'                             => 'Stackable NetIron',
        'snSI'                                   => 'Stackable ServerIron',
        'snSIXL'                                 => 'Stackable ServerIronXL',
        'snSIXLTCS'                              => 'Stackable ServerIronXL TCS',
        'snTISwitch'                             => 'Stackable TurboIron',
        'snTIRouter'                             => 'Stackable TurboIron',
        'snT8Switch'                             => 'Stackable TurboIron 8',
        'snT8Router'                             => 'Stackable TurboIron 8',
        'snT8SIXLG'                              => 'Stackable ServerIronXLG',
        'snBI4000Switch'                         => 'BigIron 4000',
        'snBI4000Router'                         => 'BigIron 4000',
        'snBI4000SI'                             => 'BigServerIron',
        'snBI8000Switch'                         => 'BigIron 8000',
        'snBI8000Router'                         => 'BigIron 8000',
        'snBI8000SI'                             => 'BigServerIron',
        'snFI2Switch'                            => 'FastIron II',
        'snFI2Router'                            => 'FastIron II',
        'snFI2PlusSwitch'                        => 'FastIron II Plus',
        'snFI2PlusRouter'                        => 'FastIron II Plus',
        'snNI400Router'                          => 'NetIron 400',
        'snNI800Router'                          => 'NetIron 800',
        'snFI2GCSwitch'                          => 'FastIron II GC',
        'snFI2GCRouter'                          => 'FastIron II GC',
        'snFI2PlusGCSwitch'                      => 'FastIron II Plus GC',
        'snFI2PlusGCRouter'                      => 'FastIron II Plus GC',
        'snBI15000Switch'                        => 'BigIron 15000',
        'snBI15000Router'                        => 'BigIron 15000',
        'snNI1500Router'                         => 'NetIron 1500',
        'snFI3Switch'                            => 'FastIron III',
        'snFI3Router'                            => 'FastIron III',
        'snFI3GCSwitch'                          => 'FastIron III GC',
        'snFI3GCRouter'                          => 'FastIron III GC',
        'snSI400Switch'                          => 'ServerIron 400',
        'snSI400Router'                          => 'ServerIron 400',
        'snSI800Switch'                          => 'ServerIron800',
        'snSI800Router'                          => 'ServerIron800',
        'snSI1500Switch'                         => 'ServerIron1500',
        'snSI1500Router'                         => 'ServerIron1500',
        'sn4802Switch'                           => 'Stackable 4802',
        'sn4802Router'                           => 'Stackable 4802',
        'sn4802SI'                               => 'Stackable 4802 ServerIron',
        'snFI400Switch'                          => 'FastIron 400',
        'snFI400Router'                          => 'FastIron 400',
        'snFI800Switch'                          => 'FastIron800',
        'snFI800Router'                          => 'FastIron800',
        'snFI1500Switch'                         => 'FastIron1500',
        'snFI1500Router'                         => 'FastIron1500',
        'snFES2402'                              => 'FES 2402',
        'snFES2402Switch'                        => 'FES2402',
        'snFES2402Router'                        => 'FES2402',
        'snFES4802'                              => 'FES 4802',
        'snFES4802Switch'                        => 'FES4802',
        'snFES4802Router'                        => 'FES4802',
        'snFES9604'                              => 'FES 9604',
        'snFES9604Switch'                        => 'FES9604',
        'snFES9604Router'                        => 'FES9604',
        'snFES12GCF'                             => 'FES 12GCF ',
        'snFES12GCFSwitch'                       => 'FES12GCF ',
        'snFES12GCFRouter'                       => 'FES12GCF',
        'snFES2402P'                             => 'FES 2402 POE ',
        'snFES4802P'                             => 'FES 4802 POE ',
        'snNI4802Switch'                         => 'NetIron 4802',
        'snNI4802Router'                         => 'NetIron 4802',
        'snBIMG8Switch'                          => 'BigIron MG8',
        'snBIMG8Router'                          => 'BigIron MG8',
        'snNI40GRouter'                          => 'NetIron 40G',
        'snFESX424'                              => 'FES 24G',
        'snFESX424Switch'                        => 'FESX424',
        'snFESX424Router'                        => 'FESX424',
        'snFESX424Prem'                          => 'FES 24G-PREM',
        'snFESX424PremSwitch'                    => 'FESX424-PREM',
        'snFESX424PremRouter'                    => 'FESX424-PREM',
        'snFESX424Plus1XG'                       => 'FES 24G + 1 10G',
        'snFESX424Plus1XGSwitch'                 => 'FESX424+1XG',
        'snFESX424Plus1XGRouter'                 => 'FESX424+1XG',
        'snFESX424Plus1XGPrem'                   => 'FES 24G + 1 10G-PREM',
        'snFESX424Plus1XGPremSwitch'             => 'FESX424+1XG-PREM',
        'snFESX424Plus1XGPremRouter'             => 'FESX424+1XG-PREM',
        'snFESX424Plus2XG'                       => 'FES 24G + 2 10G',
        'snFESX424Plus2XGSwitch'                 => 'FESX424+2XG',
        'snFESX424Plus2XGRouter'                 => 'FESX424+2XG',
        'snFESX424Plus2XGPrem'                   => 'FES 24G + 2 10G-PREM',
        'snFESX424Plus2XGPremSwitch'             => 'FESX424+2XG-PREM',
        'snFESX424Plus2XGPremRouter'             => 'FESX424+2XG-PREM',
        'snFESX448'                              => 'FES 48G',
        'snFESX448Switch'                        => 'FESX448',
        'snFESX448Router'                        => 'FESX448',
        'snFESX448Prem'                          => 'FES 48G-PREM',
        'snFESX448PremSwitch'                    => 'FESX448-PREM',
        'snFESX448PremRouter'                    => 'FESX448-PREM',
        'snFESX448Plus1XG'                       => 'FES 48G + 1 10G',
        'snFESX448Plus1XGSwitch'                 => 'FESX448+1XG',
        'snFESX448Plus1XGRouter'                 => 'FESX448+1XG',
        'snFESX448Plus1XGPrem'                   => 'FES 48G + 1 10G-PREM',
        'snFESX448Plus1XGPremSwitch'             => 'FESX448+1XG-PREM',
        'snFESX448Plus1XGPremRouter'             => 'FESX448+1XG-PREM',
        'snFESX448Plus2XG'                       => 'FES 48G + 2 10G',
        'snFESX448Plus2XGSwitch'                 => 'FESX448+2XG',
        'snFESX448Plus2XGRouter'                 => 'FESX448+2XG',
        'snFESX448Plus2XGPrem'                   => 'FES 48G + 2 10G-PREM',
        'snFESX448Plus2XGPremSwitch'             => 'FESX448+2XG-PREM',
        'snFESX448Plus2XGPremRouter'             => 'FESX448+2XG-PREM',
        'snFESX424Fiber'                         => 'FESFiber 24G',
        'snFESX424FiberSwitch'                   => 'FESX424Fiber',
        'snFESX424FiberRouter'                   => 'FESX424Fiber',
        'snFESX424FiberPrem'                     => 'FESFiber 24G-PREM',
        'snFESX424FiberPremSwitch'               => 'FESX424Fiber-PREM',
        'snFESX424FiberPremRouter'               => 'FESX424Fiber-PREM',
        'snFESX424FiberPlus1XG'                  => 'FESFiber 24G + 1 10G',
        'snFESX424FiberPlus1XGSwitch'            => 'FESX424Fiber+1XG',
        'snFESX424FiberPlus1XGRouter'            => 'FESX424Fiber+1XG',
        'snFESX424FiberPlus1XGPrem'              => 'FESFiber 24G + 1 10G-PREM',
        'snFESX424FiberPlus1XGPremSwitch'        => 'FESX424Fiber+1XG-PREM',
        'snFESX424FiberPlus1XGPremRouter'        => 'FESX424Fiber+1XG-PREM',
        'snFESX424FiberPlus2XG'                  => 'FESFiber 24G + 2 10G',
        'snFESX424FiberPlus2XGSwitch'            => 'FESX424Fiber+2XG',
        'snFESX424FiberPlus2XGRouter'            => 'FESX424Fiber+2XG',
        'snFESX424FiberPlus2XGPrem'              => 'FESFiber 24G + 2 10G-PREM',
        'snFESX424FiberPlus2XGPremSwitch'        => 'FESX424Fiber+2XG-PREM',
        'snFESX424FiberPlus2XGPremRouter'        => 'FESX424Fiber+2XG-PREM',
        'snFESX448Fiber'                         => 'FESFiber 48G',
        'snFESX448FiberSwitch'                   => 'FESX448Fiber',
        'snFESX448FiberRouter'                   => 'FESX448Fiber',
        'snFESX448FiberPrem'                     => 'FESFiber 48G-PREM',
        'snFESX448FiberPremSwitch'               => 'FESX448Fiber-PREM',
        'snFESX448FiberPremRouter'               => 'FESX448Fiber-PREM',
        'snFESX448FiberPlus1XG'                  => 'FESFiber 48G + 1 10G',
        'snFESX448FiberPlus1XGSwitch'            => 'FESX448Fiber+1XG',
        'snFESX448FiberPlus1XGRouter'            => 'FESX448Fiber+1XG',
        'snFESX448FiberPlus1XGPrem'              => 'FESFiber 48G + 1 10G-PREM',
        'snFESX448FiberPlus1XGPremSwitch'        => 'FESX448Fiber+1XG-PREM',
        'snFESX448FiberPlus1XGPremRouter'        => 'FESX448Fiber+1XG-PREM',
        'snFESX448FiberPlus2XG'                  => 'FESFiber 48G + 2 10G',
        'snFESX448FiberPlus2XGSwitch'            => 'FESX448Fiber+2XG',
        'snFESX448FiberPlus2XGRouter'            => 'FESX448+2XG',
        'snFESX448FiberPlus2XGPrem'              => 'FESFiber 48G + 2 10G-PREM',
        'snFESX448FiberPlus2XGPremSwitch'        => 'FESX448Fiber+2XG-PREM',
        'snFESX448FiberPlus2XGPremRouter'        => 'FESX448Fiber+2XG-PREM',
        'snFESX424P'                             => 'FES 24G POE',
        'snFESX624'                              => 'FastIron Edge V6 Switch(FES) 24G',
        'snFESX624Switch'                        => 'FESX624',
        'snFESX624Router'                        => 'FESX624',
        'snFESX624Prem'                          => 'FastIron Edge V6 Switch(FES) 24G-PREM',
        'snFESX624PremSwitch'                    => 'FESX624-PREM',
        'snFESX624PremRouter'                    => 'FESX624-PREM',
        'snFESX624Plus1XG'                       => 'FastIron Edge V6 Switch(FES) 24G + 1 10G',
        'snFESX624Plus1XGSwitch'                 => 'FESX624+1XG',
        'snFESX624Plus1XGRouter'                 => 'FESX624+1XG',
        'snFESX624Plus1XGPrem'                   => 'FastIron Edge V6 Switch(FES) 24G + 1 10G-PREM',
        'snFESX624Plus1XGPremSwitch'             => 'FESX624+1XG-PREM',
        'snFESX624Plus1XGPremRouter'             => 'FESX624+1XG-PREM',
        'snFESX624Plus2XG'                       => 'FastIron Edge V6 Switch(FES) 24G + 2 10G',
        'snFESX624Plus2XGSwitch'                 => 'FESX624+2XG',
        'snFESX624Plus2XGRouter'                 => 'FESX624+2XG',
        'snFESX624Plus2XGPrem'                   => 'FastIron Edge V6 Switch(FES) 24G + 2 10G-PREM',
        'snFESX624Plus2XGPremSwitch'             => 'FESX624+2XG-PREM',
        'snFESX624Plus2XGPremRouter'             => 'FESX624+2XG-PREM',
        'snFESX648'                              => 'FastIron Edge V6 Switch(FES) 48G',
        'snFESX648Switch'                        => 'FESX648',
        'snFESX648Router'                        => 'FESX648',
        'snFESX648Prem'                          => 'FastIron Edge V6 Switch(FES) 48G-PREM',
        'snFESX648PremSwitch'                    => 'FESX648-PREM',
        'snFESX648PremRouter'                    => 'FESX648-PREM',
        'snFESX648Plus1XG'                       => 'FastIron Edge V6 Switch(FES) 48G + 1 10G',
        'snFESX648Plus1XGSwitch'                 => 'FESX648+1XG',
        'snFESX648Plus1XGRouter'                 => 'FESX648+1XG',
        'snFESX648Plus1XGPrem'                   => 'FastIron Edge V6 Switch(FES) 48G + 1 10G-PREM',
        'snFESX648Plus1XGPremSwitch'             => 'FESX648+1XG-PREM',
        'snFESX648Plus1XGPremRouter'             => 'FESX648+1XG-PREM',
        'snFESX648Plus2XG'                       => 'FastIron Edge V6 Switch(FES) 48G + 2 10G',
        'snFESX648Plus2XGSwitch'                 => 'FESX648+2XG',
        'snFESX648Plus2XGRouter'                 => 'FESX648+2XG',
        'snFESX648Plus2XGPrem'                   => 'FastIron Edge V6 Switch(FES) 48G + 2 10G-PREM',
        'snFESX648Plus2XGPremSwitch'             => 'FESX648+2XG-PREM',
        'snFESX648Plus2XGPremRouter'             => 'FESX648+2XG-PREM',
        'snFESX624Fiber'                         => 'FastIron V6 Edge Switch(FES)Fiber 24G',
        'snFESX624FiberSwitch'                   => 'FESX624Fiber',
        'snFESX624FiberRouter'                   => 'FESX624Fiber',
        'snFESX624FiberPrem'                     => 'FastIron Edge V6 Switch(FES)Fiber 24G-PREM',
        'snFESX624FiberPremSwitch'               => 'FESX624Fiber-PREM',
        'snFESX624FiberPremRouter'               => 'FESX624Fiber-PREM',
        'snFESX624FiberPlus1XG'                  => 'FastIron Edge V6 Switch(FES)Fiber 24G + 1 10G',
        'snFESX624FiberPlus1XGSwitch'            => 'FESX624Fiber+1XG',
        'snFESX624FiberPlus1XGRouter'            => 'FESX624Fiber+1XG',
        'snFESX624FiberPlus1XGPrem'              => 'FastIron Edge V6 Switch(FES)Fiber 24G + 1 10G-PREM',
        'snFESX624FiberPlus1XGPremSwitch'        => 'FESX624Fiber+1XG-PREM',
        'snFESX624FiberPlus1XGPremRouter'        => 'FESX624Fiber+1XG-PREM',
        'snFESX624FiberPlus2XG'                  => 'FastIron Edge V6 Switch(FES)Fiber 24G + 2 10G',
        'snFESX624FiberPlus2XGSwitch'            => 'FESX624Fiber+2XG',
        'snFESX624FiberPlus2XGRouter'            => 'FESX624Fiber+2XG',
        'snFESX624FiberPlus2XGPrem'              => 'FastIron Edge V6 Switch(FES)Fiber 24G + 2 10G-PREM',
        'snFESX624FiberPlus2XGPremSwitch'        => 'FESX624Fiber+2XG-PREM',
        'snFESX624FiberPlus2XGPremRouter'        => 'FESX624Fiber+2XG-PREM',
        'snFESX648Fiber'                         => 'FastIron Edge V6 Switch(FES)Fiber 48G',
        'snFESX648FiberSwitch'                   => 'FESX648Fiber',
        'snFESX648FiberRouter'                   => 'FESX648Fiber',
        'snFESX648FiberPrem'                     => 'FastIron Edge V6 Switch(FES)Fiber 48G-PREM',
        'snFESX648FiberPremSwitch'               => 'FESX648Fiber-PREM',
        'snFESX648FiberPremRouter'               => 'FESX648Fiber-PREM',
        'snFESX648FiberPlus1XG'                  => 'FastIron Edge V6 Switch(FES)Fiber 48G + 1 10G',
        'snFESX648FiberPlus1XGSwitch'            => 'FESX648Fiber+1XG',
        'snFESX648FiberPlus1XGRouter'            => 'FESX648Fiber+1XG',
        'snFESX648FiberPlus1XGPrem'              => 'FastIron Edge V6 Switch(FES)Fiber 48G + 1 10G-PREM',
        'snFESX648FiberPlus1XGPremSwitch'        => 'FESX648Fiber+1XG-PREM',
        'snFESX648FiberPlus1XGPremRouter'        => 'FESX648Fiber+1XG-PREM',
        'snFESX648FiberPlus2XG'                  => 'FastIron Edge V6 Switch(FES)Fiber 48G + 2 10G',
        'snFESX648FiberPlus2XGSwitch'            => 'FESX648Fiber+2XG',
        'snFESX648FiberPlus2XGRouter'            => 'FESX648+2XG',
        'snFESX648FiberPlus2XGPrem'              => 'FastIron Edge V6 Switch(FES)Fiber 48G + 2 10G-PREM',
        'snFESX648FiberPlus2XGPremSwitch'        => 'FESX648Fiber+2XG-PREM',
        'snFESX648FiberPlus2XGPremRouter'        => 'FESX648Fiber+2XG-PREM',
        'snFESX624P'                             => 'FastIron Edge V6 Switch(FES) 24G POE',
        'snFWSX424'                              => 'FWSX24G',
        'snFWSX424Switch'                        => 'FWSX424',
        'FWSX24GSwitch'                          => 'FWSX424',
        'snFWSX424Router'                        => 'FWSX424',
        'snFWSX424Plus1XG'                       => 'FWSX24G + 1 10G',
        'snFWSX424Plus1XGSwitch'                 => 'FWSX424+1XG',
        'snFWSX424Plus1XGRouter'                 => 'FWSX424+1XG',
        'snFWSX424Plus2XG'                       => 'FWSX24G + 2 10G',
        'snFWSX424Plus2XGSwitch'                 => 'FWSX424+2XG',
        'snFWSX424Plus2XGRouter'                 => 'FWSX424+2XG',
        'snFWSX448'                              => 'FWSX48G',
        'snFWSX448Switch'                        => 'FWSX448',
        'snFWSX448Router'                        => 'FWSX448',
        'snFWSX448Plus1XG'                       => 'FWSX48G + 1 10G',
        'snFWSX448Plus1XGSwitch'                 => 'FWSX448+1XG',
        'snFWSX448Plus1XGRouter'                 => 'FWSX448+1XG',
        'snFWSX448Plus2XG'                       => 'FWSX448G+2XG',
        'snFWSX448Plus2XGSwitch'                 => 'FWSX448+2XG',
        'snFWSX448Plus2XGRouter'                 => 'FWSX448+2XG',
        'snFastIronSuperXFamily'                 => 'FastIron SuperX Family',
        'snFastIronSuperX'                       => 'FastIron SuperX',
        'snFastIronSuperXSwitch'                 => 'FastIron SuperX Switch',
        'snFastIronSuperXRouter'                 => 'FastIron SuperX Router',
        'snFastIronSuperXBaseL3Switch'           => 'FastIron SuperX Base L3 Switch',
        'snFastIronSuperXPrem'                   => 'FastIron SuperX Premium',
        'snFastIronSuperXPremSwitch'             => 'FastIron SuperX Premium Switch',
        'snFastIronSuperXPremRouter'             => 'FastIron SuperX Premium Router',
        'snFastIronSuperXPremBaseL3Switch'       => 'FastIron SuperX Premium Base L3 Switch',
        'snFastIronSuperX800'                    => 'FastIron SuperX 800 ',
        'snFastIronSuperX800Switch'              => 'FastIron SuperX 800 Switch',
        'snFastIronSuperX800Router'              => 'FastIron SuperX 800 Router',
        'snFastIronSuperX800BaseL3Switch'        => 'FastIron SuperX 800 Base L3 Switch',
        'snFastIronSuperX800Prem'                => 'FastIron SuperX 800 Premium',
        'snFastIronSuperX800PremSwitch'          => 'FastIron SuperX 800 Premium Switch',
        'snFastIronSuperX800PremRouter'          => 'FastIron SuperX 800 Premium Router',
        'snFastIronSuperX800PremBaseL3Switch'    => 'FastIron SuperX 800 Premium Base L3 Switch',
        'snFastIronSuperX1600'                   => 'FastIron SuperX 1600 ',
        'snFastIronSuperX1600Switch'             => 'FastIron SuperX 1600 Switch',
        'snFastIronSuperX1600Router'             => 'FastIron SuperX 1600 Router',
        'snFastIronSuperX1600BaseL3Switch'       => 'FastIron SuperX 1600 Base L3 Switch',
        'snFastIronSuperX1600Prem'               => 'FastIron SuperX 1600 Premium',
        'snFastIronSuperX1600PremSwitch'         => 'FastIron SuperX 1600 Premium Switch',
        'snFastIronSuperX1600PremRouter'         => 'FastIron SuperX 1600 Premium Router',
        'snFastIronSuperX1600PremBaseL3Switch'   => 'FastIron SuperX 1600 Premium Base L3 Switch',
        'snFastIronSuperXV6'                     => 'FastIron SuperX V6 ',
        'snFastIronSuperXV6Switch'               => 'FastIron SuperX V6 Switch',
        'snFastIronSuperXV6Router'               => 'FastIron SuperX V6 Router',
        'snFastIronSuperXV6BaseL3Switch'         => 'FastIron SuperX V6 Base L3 Switch',
        'snFastIronSuperXV6Prem'                 => 'FastIron SuperX V6 Premium',
        'snFastIronSuperXV6PremSwitch'           => 'FastIron SuperX V6 Premium Switch',
        'snFastIronSuperXV6PremRouter'           => 'FastIron SuperX V6 Premium Router',
        'snFastIronSuperXV6PremBaseL3Switch'     => 'FastIron SuperX V6 Premium Base L3 Switch',
        'snFastIronSuperX800V6'                  => 'FastIron SuperX 800 V6 ',
        'snFastIronSuperX800V6Switch'            => 'FastIron SuperX 800 V6 Switch',
        'snFastIronSuperX800V6Router'            => 'FastIron SuperX 800 V6 Router',
        'snFastIronSuperX800V6BaseL3Switch'      => 'FastIron SuperX 800 V6 Base L3 Switch',
        'snFastIronSuperX800V6Prem'              => 'FastIron SuperX 800 V6 Premium',
        'snFastIronSuperX800V6PremSwitch'        => 'FastIron SuperX 800 Premium V6 Switch',
        'snFastIronSuperX800V6PremRouter'        => 'FastIron SuperX 800 Premium V6 Router',
        'snFastIronSuperX800V6PremBaseL3Switch'  => 'FastIron SuperX 800 Premium V6 Base L3 Switch',
        'snFastIronSuperX1600V6'                 => 'FastIron SuperX 1600 V6 ',
        'snFastIronSuperX1600V6Switch'           => 'FastIron SuperX 1600 V6 Switch',
        'snFastIronSuperX1600V6Router'           => 'FastIron SuperX 1600 V6 Router',
        'snFastIronSuperX1600V6BaseL3Switch'     => 'FastIron SuperX 1600 V6 Base L3 Switch',
        'snFastIronSuperX1600V6Prem'             => 'FastIron SuperX 1600 Premium V6',
        'snFastIronSuperX1600V6PremSwitch'       => 'FastIron SuperX 1600 Premium V6 Switch',
        'snFastIronSuperX1600V6PremRouter'       => 'FastIron SuperX 1600 Premium V6 Router',
        'snFastIronSuperX1600V6PremBaseL3Switch' => 'FastIron SuperX 1600 Premium V6 Base L3 Switch',
        'snBigIronSuperXFamily'                  => 'BigIron SuperX Family',
        'snBigIronSuperX'                        => 'BigIron SuperX',
        'snBigIronSuperXSwitch'                  => 'BigIron SuperX Switch',
        'snBigIronSuperXRouter'                  => 'BigIron SuperX Router',
        'snBigIronSuperXBaseL3Switch'            => 'BigIron SuperX Base L3 Switch',
        'snTurboIronSuperXFamily'                => 'TurboIron SuperX Family',
        'snTurboIronSuperX'                      => 'TurboIron SuperX',
        'snTurboIronSuperXSwitch'                => 'TurboIron SuperX Switch',
        'snTurboIronSuperXRouter'                => 'TurboIron SuperX Router',
        'snTurboIronSuperXBaseL3Switch'          => 'TurboIron SuperX Base L3 Switch',
        'snTurboIronSuperXPrem'                  => 'TurboIron SuperX Premium',
        'snTurboIronSuperXPremSwitch'            => 'TurboIron SuperX Premium Switch',
        'snTurboIronSuperXPremRouter'            => 'TurboIron SuperX Premium Router',
        'snTurboIronSuperXPremBaseL3Switch'      => 'TurboIron SuperX Premium Base L3 Switch',
        'snNIIMRRouter'                          => 'NetIron IMR',
        'snBIRX16Switch'                         => 'BigIron RX16',
        'snBIRX16Router'                         => 'BigIron RX16',
        'snBIRX8Switch'                          => 'BigIron RX8',
        'snBIRX8Router'                          => 'BigIron RX8',
        'snBIRX4Switch'                          => 'BigIron RX4',
        'snBIRX4Router'                          => 'BigIron RX4',
        'snBIRX32Switch'                         => 'BigIron RX32',
        'snBIRX32Router'                         => 'BigIron RX32',
        'snNIXMR16000Router'                     => 'NetIron XMR16000',
        'snNIXMR8000Router'                      => 'NetIron XMR8000',
        'snNIXMR4000Router'                      => 'NetIron XMR4000',
        'snNIXMR32000Router'                     => 'NetIron XMR32000',
        'snSecureIronLS100'                      => 'SecureIronLS 100',
        'snSecureIronLS100Switch'                => 'SecureIronLS 100 Switch',
        'snSecureIronLS100Router'                => 'SecureIronLS 100 Router',
        'snSecureIronLS300'                      => 'SecureIronLS 300',
        'snSecureIronLS300Switch'                => 'SecureIronLS 300 Switch',
        'snSecureIronLS300Router'                => 'SecureIronLS 300 Router',
        'snSecureIronTM100'                      => 'SecureIronTM 100',
        'snSecureIronTM100Switch'                => 'SecureIronTM 100 Switch',
        'snSecureIronTM100Router'                => 'SecureIronTM 100 Router',
        'snSecureIronTM300'                      => 'SecureIronTM 300',
        'snSecureIronTM300Switch'                => 'SecureIronTM 300 Switch',
        'snSecureIronTM300Router'                => 'SecureIronTM 300 Router',
        'snNetIronMLX16Router'                   => 'NetIron MLX-16',
        'snNetIronMLX8Router'                    => 'NetIron MLX-8',
        'snNetIronMLX4Router'                    => 'NetIron MLX-4',
        'snNetIronMLX32Router'                   => 'NetIron MLX-32',
        'snFGS624P'                              => 'FastIron FGS624P',
        'snFGS624PSwitch'                        => 'FGS624P',
        'snFGS624PRouter'                        => 'FGS624P',
        'snFGS624XGP'                            => 'FastIron FGS624XGP',
        'snFGS624XGPSwitch'                      => 'FGS624XGP',
        'snFGS624XGPRouter'                      => 'FGS624XGP',
        'snFGS624PP'                             => 'FastIron FGS624XGP',
        'snFGS624XGPP'                           => 'FGS624XGP-POE',
        'snFGS648P'                              => 'FastIron GS FGS648P',
        'snFGS648PSwitch'                        => 'FastIron FGS648P',
        'snFGS648PRouter'                        => 'FastIron FGS648P',
        'snFGS648PP'                             => 'FastIron FGS648P-POE',
        'snFLS624'                               => 'FastIron FLS624',
        'snFLS624Switch'                         => 'FastIron FLS624',
        'snFLS624Router'                         => 'FastIron FLS624',
        'snFLS648'                               => 'FastIron FLS648',
        'snFLS648Switch'                         => 'FastIron FLS648',
        'snFLS648Router'                         => 'FastIron FLS648',
        'snSI100'                                => 'ServerIron SI100',
        'snSI100Switch'                          => 'ServerIron SI100',
        'snSI100Router'                          => 'ServerIron SI100',
        'snSI350'                                => 'ServerIron 350 series',
        'snSI350Switch'                          => 'SI350',
        'snSI350Router'                          => 'SI350',
        'snSI450'                                => 'ServerIron 450 series',
        'snSI450Switch'                          => 'SI450',
        'snSI450Router'                          => 'SI450',
        'snSI850'                                => 'ServerIron 850 series',
        'snSI850Switch'                          => 'SI850',
        'snSI850Router'                          => 'SI850',
        'snSI350Plus'                            => 'ServerIron 350 Plus series',
        'snSI350PlusSwitch'                      => 'SI350 Plus',
        'snSI350PlusRouter'                      => 'SI350 Plus',
        'snSI450Plus'                            => 'ServerIron 450 Plus series',
        'snSI450PlusSwitch'                      => 'SI450 Plus',
        'snSI450PlusRouter'                      => 'SI450 Plus',
        'snSI850Plus'                            => 'ServerIron 850 Plus series',
        'snSI850PlusSwitch'                      => 'SI850 Plus',
        'snSI850PlusRouter'                      => 'SI850 Plus',
        'snServerIronGTc'                        => 'ServerIronGT C series',
        'snServerIronGTcSwitch'                  => 'ServerIronGT C',
        'snServerIronGTcRouter'                  => 'ServerIronGT C',
        'snServerIronGTe'                        => 'ServerIronGT E series',
        'snServerIronGTeSwitch'                  => 'ServerIronGT E',
        'snServerIronGTeRouter'                  => 'ServerIronGT E',
        'snServerIronGTePlus'                    => 'ServerIronGT E Plus series',
        'snServerIronGTePlusSwitch'              => 'ServerIronGT E Plus',
        'snServerIronGTePlusRouter'              => 'ServerIronGT E Plus',
        'snServerIron4G'                         => 'ServerIron4G series',
        'snServerIron4GSwitch'                   => 'ServerIron4G',
        'snServerIron4GRouter'                   => 'ServerIron4G',
        'wirelessAp'                             => 'wireless access point',
        'wirelessProbe'                          => 'wireless probe',
        'ironPointMobility'                      => 'IronPoint Mobility Series',
        'ironPointMC'                            => 'IronPoint Mobility Controller',
        'dcrs7504Switch'                         => 'DCRS-7504',
        'dcrs7504Router'                         => 'DCRS-7504',
        'dcrs7508Switch'                         => 'DCRS-7508',
        'dcrs7508Router'                         => 'DCRS-7508',
        'dcrs7515Switch'                         => 'DCRS-7515',
        'dcrs7515Router'                         => 'DCRS-7515',
        'snCes2024F'                             => 'NetIron CES 2024F',
        'snCes2024C'                             => 'NetIron CES 2024C',
        'snCes2048F'                             => 'NetIron CES 2048F',
        'snCes2048C'                             => 'NetIron CES 2048C',
        'snCes2048FX'                            => 'NetIron CES 2048F + 2x10G',
        'snCes2048CX'                            => 'NetIron CES 2048C + 2x10G',
        'snCer2024F'                             => 'NetIron CER 2024F',
        'snCer2024C'                             => 'NetIron CER 2024C',
        'snCer2048F'                             => 'NetIron CER 2048F',
        'snCer2048C'                             => 'NetIron CER 2048C',
        'snCer2048FX'                            => 'NetIron CER 2048F + 2x10G',
        'snCer2048CX'                            => 'NetIron CER 2048C + 2x10G',
        'snTI2X24Router'                         => 'Stackable TurboIron-X24',
    );

    $hardware = array_str_replace($rewrite_ironware_hardware, $hardware);

    return ($hardware);
}


function rewrite_junose_hardware($hardware)
{
    $rewrite_junose_hardware = array(
        'juniErx1400' => 'ERX-1400',
        'juniErx700'  => 'ERX-700',
        'juniErx1440' => 'ERX-1440',
        'juniErx705'  => 'ERX-705',
        'juniErx310'  => 'ERX-310',
        'juniE320'    => 'E320',
        'juniE120'    => 'E120',
        'juniSsx1400' => 'SSX-1400',
        'juniSsx700'  => 'SSX-700',
        'juniSsx1440' => 'SSX-1440',
    );


    $hardware = array_str_replace($rewrite_junose_hardware, $hardware);

    return ($hardware);
}


function rewrite_junos_hardware($hardware)
{
    $rewrite_junos_hardware = array(
        'jnxProductNameM40'            => 'M40',
        'jnxProductNameM20'            => 'M20',
        'jnxProductNameM160'           => 'M160',
        'jnxProductNameM10'            => 'M10',
        'jnxProductNameM5'             => 'M5',
        'jnxProductNameT640'           => 'T640',
        'jnxProductNameT320'           => 'T320',
        'jnxProductNameM40e'           => 'M40e',
        'jnxProductNameM320'           => 'M320',
        'jnxProductNameM7i'            => 'M7i',
        'jnxProductNameM10i'           => 'M10i',
        'jnxProductNameJ2300'          => 'J2300',
        'jnxProductNameJ4300'          => 'J4300',
        'jnxProductNameJ6300'          => 'J6300',
        'jnxProductNameIRM'            => 'IRM',
        'jnxProductNameTX'             => 'TX',
        'jnxProductNameM120'           => 'M120',
        'jnxProductNameJ4350'          => 'J4350',
        'jnxProductNameJ6350'          => 'J6350',
        'jnxProductNameMX960'          => 'MX960',
        'jnxProductNameJ4320'          => 'J4320',
        'jnxProductNameJ2320'          => 'J2320',
        'jnxProductNameJ2350'          => 'J2350',
        'jnxProductNameMX480'          => 'MX480',
        'jnxProductNameSRX5800'        => 'SRX5800',
        'jnxProductNameT1600'          => 'T1600',
        'jnxProductNameSRX5600'        => 'SRX5600',
        'jnxProductNameMX240'          => 'MX240',
        'jnxProductNameEX3200'         => 'EX3200',
        'jnxProductNameEX3300'         => 'EX3300',
        'jnxProductNameEX4200'         => 'EX4200',
        'jnxProductNameEX8208'         => 'EX8208',
        'jnxProductNameEX8216'         => 'EX8216',
        'jnxProductNameSRX3600'        => 'SRX3600',
        'jnxProductNameSRX3400'        => 'SRX3400',
        'jnxProductNameSRX210'         => 'SRX210',
        'jnxProductNameTXP'            => 'TXP',
        'jnxProductNameJCS'            => 'JCS',
        'jnxProductNameSRX240'         => 'SRX240',
        'jnxProductNameSRX650'         => 'SRX650',
        'jnxProductNameSRX100'         => 'SRX100',
        'jnxProductNameESR1000V'       => 'ESR1000V',
        'jnxProductNameEX2200'         => 'EX2200',
        'jnxProductNameEX4500'         => 'EX4500',
        'jnxProductNameFXSeries'       => 'FX Series',
        'jnxProductNameIBM4274M02J02M' => 'IBM4274M02J02M',
        // ?
        'jnxProductNameIBM4274M06J06M' => 'IBM4274M06J06M',
        // ?
        'jnxProductNameIBM4274M11J11M' => 'IBM4274M11J11M',
        // ?
        'jnxProductNameSRX1400'        => 'SRX1400',
        'jnxProductNameIBM4274S58J58S' => 'IBM4274S58J58S',
        // ?
        'jnxProductNameIBM4274S56J56S' => 'IBM4274S56J56S',
        // ?
        'jnxProductNameIBM4274S36J36S' => 'IBM4274S36J36S',
        // ?
        'jnxProductNameIBM4274S34J34S' => 'IBM4274S34J34S',
        // ?
        'jnxProductNameIBM427348EJ48E' => 'IBM427348EJ48E',
        // ?
        'jnxProductNameIBM4274E08J08E' => 'IBM4274E08J08E',
        // ?
        'jnxProductNameIBM4274E16J16E' => 'IBM4274E16J16E',
        // ?
        'jnxProductNameMX80'           => 'MX80',
        'jnxProductName'               => '',
        'jnxProductQFX510048S6Q'       => 'QFX5100-48S6Q',
    );


    $hardware = array_str_replace($rewrite_junos_hardware, $hardware);

    return ($hardware);
}

function rewrite_generic_hardware($hardware)
{
    $rewrite_GenericHW = array(
        ' Computer Corporation' => '',
        ' Corporation'          => '',
        ' Inc.'                 => '',
    );
    return array_str_replace($rewrite_GenericHW, $hardware);
}

function fixiftype($type)
{
    $rewrite_iftype = array(
        '/^frameRelay$/'             => 'Frame Relay',
        '/^ethernetCsmacd$/'         => 'Ethernet',
        '/^softwareLoopback$/'       => 'Loopback',
        '/^tunnel$/'                 => 'Tunnel',
        '/^propVirtual$/'            => 'Virtual Int',
        '/^ppp$/'                    => 'PPP',
        '/^ds1$/'                    => 'DS1',
        '/^pos$/'                    => 'POS',
        '/^sonet$/'                  => 'SONET',
        '/^slip$/'                   => 'SLIP',
        '/^mpls$/'                   => 'MPLS Layer',
        '/^l2vlan$/'                 => 'VLAN Subif',
        '/^atm$/'                    => 'ATM',
        '/^aal5$/'                   => 'ATM AAL5',
        '/^atmSubInterface$/'        => 'ATM Subif',
        '/^propPointToPointSerial$/' => 'PtP Serial',
    );

    $type = array_preg_replace($rewrite_iftype, $type);

    return ($type);
}


function fixifName($inf)
{
    $rewrite_ifname = array(
        'ether'                                          => 'Ether',
        'gig'                                            => 'Gig',
        'fast'                                           => 'Fast',
        'ten'                                            => 'Ten',
        '-802.1q vlan subif'                             => '',
        '-802.1q'                                        => '',
        'bvi'                                            => 'BVI',
        'vlan'                                           => 'Vlan',
        'tunnel'                                         => 'Tunnel',
        'serial'                                         => 'Serial',
        '-aal5 layer'                                    => ' aal5',
        'null'                                           => 'Null',
        'atm'                                            => 'ATM',
        'port-channel'                                   => 'Port-Channel',
        'dial'                                           => 'Dial',
        'hp procurve switch software loopback interface' => 'Loopback Interface',
        'control plane interface'                        => 'Control Plane',
        'loop'                                           => 'Loop',
        'bundle-ether'                                   => 'Bundle-Ether',
    );

    $inf = strtolower($inf);
    $inf = array_str_replace($rewrite_ifname, $inf);

    return $inf;
}


function short_hrDeviceDescr($dev)
{
    $rewrite_hrDevice = array(
        'GenuineIntel:' => '',
        'AuthenticAMD:' => '',
        'Intel(R)'      => '',
        'CPU'           => '',
        '(R)'           => '',
        '  '            => ' ',
    );

    $dev = array_str_replace($rewrite_hrDevice, $dev);
    $dev = preg_replace('/\ +/', ' ', $dev);
    $dev = trim($dev);

    return $dev;
}


function short_port_descr($desc)
{
    list($desc) = explode('(', $desc);
    list($desc) = explode('[', $desc);
    list($desc) = explode('{', $desc);
    list($desc) = explode('|', $desc);
    list($desc) = explode('<', $desc);
    $desc       = trim($desc);

    return $desc;
}


// Underlying rewrite functions
function array_str_replace($array, $string)
{
    foreach ($array as $search => $replace) {
        $string = str_replace($search, $replace, $string);
    }

    return $string;
}


function array_preg_replace($array, $string)
{
    foreach ($array as $search => $replace) {
        $string = preg_replace($search, $replace, $string);
    }

    return $string;
}


function rewrite_adslLineType($adslLineType)
{
    $adslLineTypes = array(
        'noChannel'          => 'No Channel',
        'fastOnly'           => 'Fastpath',
        'interleavedOnly'    => 'Interleaved',
        'fastOrInterleaved'  => 'Fast/Interleaved',
        'fastAndInterleaved' => 'Fast+Interleaved',
    );

    foreach ($adslLineTypes as $type => $text) {
        if ($adslLineType == $type) {
            $adslLineType = $text;
        }
    }

    return ($adslLineType);
}

function rewrite_brocade_fc_switches($descr)
{
    switch ($descr) {
        case "1":
            $hardware = "Brocade 1000 Switch";
            break;
        case "2":
            $hardware = "Brocade 2800 Switch";
            break;
        case "3":
            $hardware = "Brocade 2100/2400 Switch";
            break;
        case "4":
            $hardware = "Brocade 20x0 Switch";
            break;
        case "5":
            $hardware = "Brocade 22x0 Switch";
            break;
        case "6":
            $hardware = "Brocade 2800 Switch";
            break;
        case "7":
            $hardware = "Brocade 2000 Switch";
            break;
        case "9":
            $hardware = "Brocade 3800 Switch";
            break;
        case "10":
            $hardware = "Brocade 12000 Director";
            break;
        case "12":
            $hardware = "Brocade 3900 Switch";
            break;
        case "16":
            $hardware = "Brocade 3200 Switch";
            break;
        case "18":
            $hardware = "Brocade 3000 Switch";
            break;
        case "21":
            $hardware = "Brocade 24000 Director";
            break;
        case "22":
            $hardware = "Brocade 3016 Switch";
            break;
        case "26":
            $hardware = "Brocade 3850 Switch";
            break;
        case "27":
            $hardware = "Brocade 3250 Switch";
            break;
        case "29":
            $hardware = "Brocade 4012 Embedded Switch";
            break;
        case "32":
            $hardware = "Brocade 4100 Switch";
            break;
        case "33":
            $hardware = "Brocade 3014 Switch";
            break;
        case "34":
            $hardware = "Brocade 200E Switch";
            break;
        case "37":
            $hardware = "Brocade 4020 Embedded Switch";
            break;
        case "38":
            $hardware = "Brocade 7420 SAN Router";
            break;
        case "40":
            $hardware = "Fibre Channel Routing (FCR) Front Domain";
            break;
        case "41":
            $hardware = "Fibre Channel Routing (FCR) Xlate Domain";
            break;
        case "42":
            $hardware = "Brocade 48000 Director";
            break;
        case "43":
            $hardware = "Brocade 4024 Embedded Switch";
            break;
        case "44":
            $hardware = "Brocade 4900 Switch";
            break;
        case "45":
            $hardware = "Brocade 4016 Embedded Switch";
            break;
        case "46":
            $hardware = "Brocade 7500 Switch";
            break;
        case "51":
            $hardware = "Brocade 4018 Embedded Switch";
            break;
        case "55.2":
            $hardware = "Brocade 7600 Switch";
            break;
        case "58":
            $hardware = "Brocade 5000 Switch";
            break;
        case "61":
            $hardware = "Brocade 4424 Embedded Switch";
            break;
        case "62":
            $hardware = "Brocade DCX Backbone";
            break;
        case "64":
            $hardware = "Brocade 5300 Switch";
            break;
        case "66":
            $hardware = "Brocade 5100 Switch";
            break;
        case "67":
            $hardware = "Brocade Encryption Switch";
            break;
        case "69":
            $hardware = "Brocade 5410 Blade";
            break;
        case "70":
            $hardware = "Brocade 5410 Embedded Switch";
            break;
        case "71":
            $hardware = "Brocade 300 Switch";
            break;
        case "72":
            $hardware = "Brocade 5480 Embedded Switch";
            break;
        case "73":
            $hardware = "Brocade 5470 Embedded Switch";
            break;
        case "75":
            $hardware = "Brocade M5424 Embedded Switch";
            break;
        case "76":
            $hardware = "Brocade 8000 Switch";
            break;
        case "77":
            $hardware = "Brocade DCX-4S Backbone";
            break;
        case "83":
            $hardware = "Brocade 7800 Extension Switch";
            break;
        case "86":
            $hardware = "Brocade 5450 Embedded Switch";
            break;
        case "87":
            $hardware = "Brocade 5460 Embedded Switch";
            break;
        case "90":
            $hardware = "Brocade 8470 Embedded Switch";
            break;
        case "92":
            $hardware = "Brocade VA-40FC Switch";
            break;
        case "95":
            $hardware = "Brocade VDX 6720-24 Data Center Switch";
            break;
        case "96":
            $hardware = "Brocade VDX 6730-32 Data Center Switch";
            break;
        case "97":
            $hardware = "Brocade VDX 6720-60 Data Center Switch";
            break;
        case "98":
            $hardware = "Brocade VDX 6720-76 Data Center Switch";
            break;
        case "108":
            $hardware = "Dell M84280k FCoE Embedded Switch";
            break;
        case "109":
            $hardware = "Brocade 6510 Switch";
            break;
        case "116":
            $hardware = "Brocade VDX 6710 Data Center Switch";
            break;
        case "117":
            $hardware = "Brocade 6547 Embedded Switch";
            break;
        case "118":
            $hardware = "Brocade 6505 Switch";
            break;
        case "120":
            $hardware = "Brocade DCX 8510-8 Backbone";
            break;
        case "121":
            $hardware = "Brocade DCX 8510-4 Backbone";
            break;
        case "124":
            $hardware = "Brocade 5430 Switch";
            break;
        case "125":
            $hardware = "Brocade 5431 Switch";
            break;
        case "129":
            $hardware = "Brocade 6548 Switch";
            break;
        case "130":
            $hardware = "Brocade M6505 Switch";
            break;
        case "133":
            $hardware = "Brocade 6520 Switch";
            break;
        case "134":
            $hardware = "Brocade 5432 Switch";
            break;
        case "148":
            $hardware = "Brocade 7840 Switch";
            break;
        default:
            $hardware = "Unknown Brocade FC Switch";
    }
    return $hardware;
}

function ipmiSensorName($hardwareId, $sensorIpmi)
{
    $ipmiSensorsNames = array(
        "HP ProLiant BL460c G6" => array(
            "Temp 1" => "Ambient zone",
            "Temp 2" => "CPU 1",
            "Temp 3" => "CPU 2",
            "Temp 4" => "Memory zone",
            "Temp 5" => "Memory zone",
            "Temp 6" => "Memory zone",
            "Temp 7" => "System zone",
            "Temp 8" => "System zone",
            "Temp 9" => "System zone",
            "Temp 10" => "Storage zone",
            "Power Meter" => "Power usage",
        ),
        "HP ProLiant BL460c G1" => array(
            "Temp 1" => "System zone",
            "Temp 2" => "CPU 1 zone",
            "Temp 3" => "CPU 1",
            "Temp 4" => "CPU 1",
            "Temp 5" => "CPU 2 zone",
            "Temp 6" => "CPU 2",
            "Temp 7" => "CPU 2",
            "Temp 8" => "Memory zone",
            "Temp 9" => "Ambient zone",
            "Power Meter" => "Power usage",
        ),
    );

    if (isset($ipmiSensorsNames[$hardwareId], $ipmiSensorsNames[$hardwareId][$sensorIpmi])) {
        return $ipmiSensorsNames[$hardwareId][$sensorIpmi];
    }
    return $sensorIpmi;
}

/**
 * @param $ceragon_type
 * @param $device
 * @return bool|mixed|string
 */
function rewrite_ceraos_hardware($ceragon_type, $device)
{
    if (strstr($ceragon_type, '.2281.1.10')) {
        $hardware = 'IP10 Family';
    } elseif (strstr($ceragon_type, '.2281.1.20.1.1.2')) {
        $hardware = 'IP-20A 1RU';
    } elseif (strstr($ceragon_type, '.2281.1.20.1.1.4')) {
        $hardware = 'IP-20 Evolution LH 1RU';
    } elseif (strstr($ceragon_type, '.2281.1.20.1.1')) {
        $hardware = 'IP-20N 1RU';
    } elseif (strstr($ceragon_type, '.2281.1.20.1.2.2')) {
        $hardware = 'IP-20A 2RU';
    } elseif (strstr($ceragon_type, '.2281.1.20.1.2.4')) {
        $hardware = 'IP-20 Evolution 2RU';
    } elseif (strstr($ceragon_type, '.2281.1.20.1.2')) {
        $hardware = 'IP-20N 2RU';
    } elseif (strstr($ceragon_type, '.2281.1.20.1.3.1')) {
        $hardware = 'IP-20G';
    } elseif (strstr($ceragon_type, '.2281.1.20.1.3.2')) {
        $hardware = 'IP-20GX';
    } elseif (strstr($ceragon_type, '.2281.1.20.2.2.2')) {
        $hardware = 'IP-20S';
    } elseif (strstr($ceragon_type, '.2281.1.20.2.2.3')) {
        $hardware = 'IP-20E (hardware release 1)';
    } elseif (strstr($ceragon_type, '.2281.1.20.2.2.4')) {
        $hardware = 'IP-20E (hardware release 2)';
    } elseif (strstr($ceragon_type, '.2281.1.20.2.2')) {
        $hardware = 'IP-20C';
    } else {
        $hardware = snmp_get($device, 'genEquipInventoryCardName', '-Oqv', 'MWRM-UNIT-NAME');
    }
    return $hardware;
}

/**
 * @param $descr
 * @return int
 */
function get_nagios_state($descr)
{
    switch ($descr) {
        case 'On':
        case 'Okay':
        case 'Ok':
            return 0;
            break;
        case 'Standby':
        case 'Idle':
        case 'Maintenance':
            return 1;
            break;
        case 'Under':
        case 'Over':
            return 2;
            break;
        default:
            return 3;
            break;
    }
}

/**
 * @param $state
 * @return int
 */
function apc_relay_state($state)
{
    switch ($state) {
        case 'immediateCloseEMS':
        case 'immediateOnEMS':
            return 1;
            break;
        case 'immediateOpenEMS':
        case 'immediateOffEMS':
            return 2;
            break;
    }
}

/**
 * @param $value
 * @return mixed
 */
function return_number($value)
{
    preg_match('/[\d\.\-]+/', $value, $temp_response);
    if (!empty($temp_response[0])) {
        $value = $temp_response[0];
    }
    return $value;
}
