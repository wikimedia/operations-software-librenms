<?php

$pagetitle[] = 'Services';

require_once '../includes/services.inc.php';
$services = service_get($device['device_id']);

require_once 'includes/modal/new_service.inc.php';
require_once 'includes/modal/delete_service.inc.php';

print_optionbar_start();
echo "<span style='font-weight: bold;'>Services</span> &#187; ";

$menu_options = array(
    'basic'   => 'Basic',
    'details' => 'Details',
);

if (!$vars['view']) {
    $vars['view'] = 'basic';
}

$sep = '';
foreach ($menu_options as $option => $text) {
    if (empty($vars['view'])) {
        $vars['view'] = $option;
    }

    echo $sep;
    if ($vars['view'] == $option) {
        echo "<span class='pagemenu-selected'>";
    }

    echo generate_link($text, $vars, array('view' => $option));
    if ($vars['view'] == $option) {
        echo '</span>';
    }

    $sep = ' | ';
}
unset($sep);
if (is_admin() === true) {
    echo '<div class="pull-right"><a data-toggle="modal" href="#create-service"><i class="fa fa-cog" style="color:green" aria-hidden="true"></i> Add Service</a></div>';
}
print_optionbar_end();
?>
    <div class="row col-sm-12"><span id="message"></span></div>
<?php
if (count($services) > '0') {
    // Loop over each service, pulling out the details.
?>
        <table class="table table-hover table-condensed table-striped">
<?php
foreach ($services as $service) {
    $service['service_ds'] = htmlspecialchars_decode($service['service_ds']);
    if ($service['service_status'] == '2') {
        $status = "<span class='col-sm-12 label label-danger label-border'><b>".$service['service_type']."</b></span>";
    } elseif ($service['service_status'] == '1') {
        $status = "<span class='col-sm-12 label label-warning label-border'><b>".$service['service_type']."</b></span>";
    } elseif ($service['service_status'] == '0') {
        $status = "<span class='col-sm-12 label label-success label-border'><b>".$service['service_type']."</b></span>";
    } else {
        $status = "<span class='col-sm-12 label label-info label-border'><b>".$service['service_type']."</b></span>";
    }
?>
    <tr id="row_<?php echo $service['service_id']?>">
    <td class="col-sm-12">
        <div class="col-sm-1"><?php echo $status?></div>
        <div class="col-sm-2 text-muted"><?php echo formatUptime(time() - $service['service_changed'])?></div>
        <div class="col-sm-2 text-muted"><?php echo $service['service_desc']?></div>
        <div class="col-sm-5"><?php echo nl2br(trim($service['service_message']))?></div>
        <div class="col-sm-2">
            <div class="pull-right">
<?php
if (is_admin() === true) {
    echo "<button type='button' class='btn btn-primary btn-sm' aria-label='Edit' data-toggle='modal' data-target='#create-service' data-service_id='{$service['service_id']}' name='edit-service'><i class='fa fa-pencil' aria-hidden='true'></i></button>
        <button type='button' class='btn btn-danger btn-sm' aria-label='Delete' data-toggle='modal' data-target='#confirm-delete' data-service_id='{$service['service_id']}' name='delete-service'><i class='fa fa-trash' aria-hidden='true'></i></button";
}
?>
            </div>
        </div>
<?php
if ($vars['view'] == 'details') {
    // if we have a script for this check, use it.
    $check_script = $config['install_dir'].'/includes/services/check_'.strtolower($service['service_type']).'.inc.php';
    if (is_file($check_script)) {
        include $check_script;

        // If we have a replacement DS use it.
        if (isset($check_ds)) {
            $service['service_ds'] = $check_ds;
        }
    }

    $graphs = json_decode($service['service_ds'], true);
    foreach ($graphs as $k => $v) {
        $graph_array['device'] = $device['device_id'];
        $graph_array['type'] = 'device_service';
        $graph_array['service'] = $service['service_id'];
        $graph_array['ds'] = $k;
?>
        <tr><td colspan="5">
            <div class="col-sm-12">
<?php
        include 'includes/print-graphrow.inc.php';
?>
            </div>
        </td></tr>
<?php
    }
}
}
?>
        </table>
<?php
} else {
?>
        <div class='row col-sm-12'>No Services</div>
<?php
}
?>
