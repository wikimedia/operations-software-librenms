<?php

// FIXME - wtfbbq
if ($_SESSION['userlevel'] >= '5' || $auth) {
    $id    = mres($vars['id']);
    $title = generate_device_link($device);
    $auth  = true;
}
