<?php

echo 'AVTECH: ';
if (ends_with($device['sysObjectID'], '.20916.1.7')) {
    //  TemPageR 3E
    $device_oid = '.1.3.6.1.4.1.20916.1.7.';

    $internal = array(
        'id'        => 0,
        'oid'       => $device_oid.'1.1.1.1.0',
        'descr_oid' => $device_oid.'1.1.2.0',
    );
    avtech_add_sensor($device, $internal, $valid);

    $sen1 = array(
        'id'        => 1,
        'oid'       => $device_oid.'1.2.1.1.0',
        'descr_oid' => $device_oid.'1.2.1.3.0',
    );
    avtech_add_sensor($device, $sen1, $valid);

    $sen2 = array(
        'id'        => 2,
        'oid'       => $device_oid.'1.2.2.1.0',
        'descr_oid' => $device_oid.'1.2.2.3.0',
    );
    avtech_add_sensor($device, $sen2, $valid);
} elseif (ends_with($device['sysObjectID'], '.20916.1.9')) {
    //  RoomAlert 3E
    $device_oid = '.1.3.6.1.4.1.20916.1.9.';

    $internal = array(
        'id'        => 0,
        'oid'       => $device_oid.'1.1.1.1.0',
        'descr_oid' => $device_oid.'1.1.1.3.0',
    );
    avtech_add_sensor($device, $internal, $valid);

    $sen1 = array(
        'id'        => 1,
        'oid'       => $device_oid.'1.1.2.1.0',
        'descr_oid' => $device_oid.'1.1.2.6.0',
    );
    avtech_add_sensor($device, $sen1, $valid);
} elseif (ends_with($device['sysObjectID'], '.20916.1.1')) {
    //  TemPageR 4E
    $device_oid = '.1.3.6.1.4.1.20916.1.1.';

    $internal = array(
        'id'        => 0,
        'oid'       => $device_oid.'1.1.1.0',
        'descr'     => 'Internal',
        'max_oid'   => $device_oid.'3.1.0',
        'min_oid'   => $device_oid.'3.2.0',
    );
    avtech_add_sensor($device, $internal, $valid);

    $sen1 = array(
        'id'        => 1,
        'oid'       => $device_oid.'1.1.2.0',
        'descr'     => 'Sensor 1',
        'max_oid'   => $device_oid.'3.3.0',
        'min_oid'   => $device_oid.'3.4.0',
    );
    avtech_add_sensor($device, $sen1, $valid);

    $sen2 = array(
        'id'        => 2,
        'oid'       => $device_oid.'1.1.3.0',
        'descr'     => 'Sensor 2',
        'max_oid'   => $device_oid.'3.5.0',
        'min_oid'   => $device_oid.'3.6.0',
    );
    avtech_add_sensor($device, $sen2, $valid);

    $sen3 = array(
        'id'        => 3,
        'oid'       => $device_oid.'1.1.4.0',
        'descr'     => 'Sensor 3',
        'max_oid'   => $device_oid.'3.7.0',
        'min_oid'   => $device_oid.'3.8.0',
    );
    avtech_add_sensor($device, $sen3, $valid);
} elseif (ends_with($device['sysObjectID'], '.20916.1.6')) {
    //  RoomAlert 4E
    $device_oid = '.1.3.6.1.4.1.20916.1.6.';
    $divisor = 1;

    $internal = array(
        'id'        => 0,
        'oid'       => $device_oid.'1.1.1.2.0',
        'descr_oid' => $device_oid.'1.1.2.1.0',
        'divisor'   => $divisor,
    );
    avtech_add_sensor($device, $internal, $valid);

    $sen1 = array(
        'id'        => 1,
        'oid'       => $device_oid.'1.2.2.1.0',
        'descr_oid' => $device_oid.'1.2.1.6.0',
        'divisor'   => $divisor,
    );
    avtech_add_sensor($device, $sen1, $valid);

    $sen2 = array(
        'id'        => 2,
        'oid'       => $device_oid.'1.2.2.1.0',
        'descr_oid' => $device_oid.'1.2.2.6.0',
        'divisor'   => $divisor,
    );
    avtech_add_sensor($device, $sen2, $valid);
}
