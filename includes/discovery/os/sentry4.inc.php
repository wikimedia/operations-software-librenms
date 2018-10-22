<?php

if (starts_with($sysDescr, 'Sentry') && str_contains($sysDescr, array('Switched', 'Smart'))) {
    // ServerTech doesn't have a way to distinguish between sentry3 and sentry4 devices
    // Hopefully, we can use the version string to figure it out
    $version = trim(snmp_get($device, 'serverTech.4.1.1.1.3.0', '-Osqnv', 'Sentry3-MIB', 'sentry'));
    $version = explode(" ", $version);
    $version = intval($version[1]);

    // It appears that version 8 and up is good for sentry4
    if ($version >= 8) {
        $os = 'sentry4';
    }
}
