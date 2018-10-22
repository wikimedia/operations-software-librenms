<?php

$no_refresh = true;

?>

<div class="row">
    <div class="col-sm-12">
        <span id="message"></span>
    </div>
</div>
<?php
if (isset($_POST['create-default'])) {
    $default_rules = array_filter(get_rules_from_json(), function ($rule) {
        return isset($rule['default']) && $rule['default'];
    });

    $default_extra = array(
        'mute' => false,
        'count' => -1,
        'delay' => 300,
        'invert' => false,
        'interval' => 300,
    );

    require_once '../includes/alerts.inc.php';

    foreach ($default_rules as $add_rule) {
        $extra = $default_extra;
        if (isset($add_rule['extra'])) {
            $extra = array_replace($extra, json_decode($add_rule['extra'], true));
        }

        $insert = array(
            'device_id' => -1,
            'rule'      => $add_rule['rule'],
            'query'     => GenSQL($add_rule['rule']),
            'severity'  => 'critical',
            'extra'     => json_encode($extra),
            'disabled'  => 0,
            'name'      => $add_rule['name']
        );

        dbInsert($insert, 'alert_rules');
    }
}//end if

require_once 'includes/modal/new_alert_rule.inc.php';
require_once 'includes/modal/delete_alert_rule.inc.php';
require_once 'includes/modal/alert_rule_collection.inc.php';
?>
<form method="post" action="" id="result_form">
<?php
if (isset($_POST['results_amount']) && $_POST['results_amount'] > 0) {
    $results = $_POST['results'];
} else {
    $results = 50;
}

echo '<div class="table-responsive">
    <table class="table table-hover table-condensed" width="100%">
    <tr>
    <th>#</th>
    <th>Name</th>
    <th>Rule</th>
    <th>Severity</th>
    <th>Status</th>
    <th>Extra</th>
    <th>Enabled</th>
    <th>Action</th>
    </tr>';

echo '<td colspan="7">';
if ($_SESSION['userlevel'] >= '10') {
    echo '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#create-alert" data-device_id="'.$device['device_id'].'"><i class="fa fa-plus"></i> Create new alert rule</button>';
    echo '<i> - OR - </i>';
    echo '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#search_rule_modal" data-device_id="'.$device['device_id'].'"><i class="fa fa-plus"></i> Create rule from collection</button>';
}
echo '</td>
    <td><select name="results" id="results" class="form-control input-sm" onChange="updateResults(this);">';
$result_options = array(
    '10',
    '50',
    '100',
    '250',
    '500',
    '1000',
    '5000',
);
foreach ($result_options as $option) {
    echo "<option value='$option'";
    if ($results == $option) {
        echo ' selected';
    }

    echo ">$option</option>";
}

echo '</select></td>';

$count_query = 'SELECT COUNT(*)';
$full_query  = 'SELECT *';
$sql         = '';
$param       = array();
if (isset($device['device_id']) && $device['device_id'] > 0) {
    $sql   = 'WHERE (device_id=? OR device_id="-1")';
    $param = array($device['device_id']);
}

$query       = " FROM alert_rules $sql";
$count_query = $count_query.$query;
$count       = dbFetchCell($count_query, $param);
if (!isset($_POST['page_number']) && $_POST['page_number'] < 1) {
    $page_number = 1;
} else {
    $page_number = $_POST['page_number'];
}

$start      = (($page_number - 1) * $results);
$full_query = $full_query.$query." ORDER BY id ASC LIMIT $start,$results";

foreach (dbFetchRows($full_query, $param) as $rule) {
    $sub   = dbFetchRows('SELECT * FROM alerts WHERE rule_id = ? ORDER BY `state` DESC, `id` DESC LIMIT 1', array($rule['id']));
    $ico   = 'check';
    $col   = 'success';
    $extra = '';
    if (sizeof($sub) == 1) {
        $sub = $sub[0];
        if ((int) $sub['state'] === 0) {
            $ico = 'check';
            $col = 'success';
        } elseif ((int) $sub['state'] === 1 || (int) $sub['state'] === 2) {
            $ico   = 'remove';
            $col   = 'danger';
            $extra = 'danger';
        }
    }

    $alert_checked = '';
    $orig_ico      = $ico;
    $orig_col      = $col;
    $orig_class    = $extra;
    if ($rule['disabled']) {
        $ico   = 'pause';
        $col   = '';
        $extra = 'active';
    } else {
        $alert_checked = 'checked';
    }

    $rule_extra = json_decode($rule['extra'], true);
    if ($rule['device_id'] == ':-1' || $rule['device_id'] == '-1') {
        $popover_msg = 'Global alert rule';
    } else {
        $popover_msg = 'Device specific rule';
    }
    echo "<tr class='".$extra."' id='row_".$rule['id']."'>";
    echo '<td><i>#'.((int) $rule['id']).'</i></td>';
    echo '<td>'.$rule['name'].'</td>';
    echo "<td class='col-sm-4'>";
    if ($rule_extra['invert'] === true) {
        echo '<strong><em>Inverted</em></strong> ';
    }

    echo '<i>'.htmlentities($rule['rule']).'</i></td>';
    echo '<td>'.$rule['severity'].'</td>';
    echo "<td><span id='alert-rule-".$rule['id']."' class='fa fa-fw fa-2x fa-".$ico.' text-'.$col."'></span> ";
    if ($rule_extra['mute'] === true) {
        echo "<i class='fa fa-fw fa-2x fa-volume-off text-primary' aria-hidden='true'></i></td>";
    }

    echo '<td><small>Max: '.$rule_extra['count'].'<br />Delay: '.$rule_extra['delay'].'<br />Interval: '.$rule_extra['interval'].'</small></td>';
    echo '<td>';
    if ($_SESSION['userlevel'] >= '10') {
        echo "<input id='".$rule['id']."' type='checkbox' name='alert-rule' data-orig_class='".$orig_class."' data-orig_colour='".$orig_col."' data-orig_state='".$orig_ico."' data-alert_id='".$rule['id']."' ".$alert_checked." data-size='small' data-content='".$popover_msg."' data-toggle='modal'>";
    }

    echo '</td>';
    echo '<td>';
    if ($_SESSION['userlevel'] >= '10') {
        echo "<div class='btn-group btn-group-sm' role='group'>";
        echo "<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#create-alert' data-device_id='".$rule['device_id']."' data-alert_id='".$rule['id']."' name='edit-alert-rule' data-content='".$popover_msg."' data-container='body'><i class='fa fa-lg fa-pencil' aria-hidden='true'></i></button> ";
        echo "<button type='button' class='btn btn-danger' aria-label='Delete' data-toggle='modal' data-target='#confirm-delete' data-alert_id='".$rule['id']."' name='delete-alert-rule' data-content='".$popover_msg."' data-container='body'><i class='fa fa-lg fa-trash' aria-hidden='true'></i></button>";
    }

    echo '</td>';
    echo "</tr>\r\n";
}//end foreach

if (($count % $results) > 0) {
    echo '    <tr>
        <td colspan="8" align="center">'.generate_pagination($count, $results, $page_number).'</td>
        </tr>';
}

echo '</table>
    <input type="hidden" name="page_number" id="page_number" value="'.$page_number.'">
    <input type="hidden" name="results_amount" id="results_amount" value="'.$results.'">
    </form>
    </div>';

if ($count < 1) {
    if ($_SESSION['userlevel'] >= '10') {
        echo '<div class="row">
            <div class="col-sm-12">
            <form role="form" method="post">
            <p class="text-center">
            <button type="submit" class="btn btn-success btn-lg" id="create-default" name="create-default"><i class="fa fa-plus"></i> Click here to create the default alert rules!</button>
            </p>
            </form>
            </div>
            </div>';
    }
}

?>

<script>
$("[data-toggle='modal'], [data-toggle='popover']").popover({
    trigger: 'hover',
        'placement': 'top'
});
$('#ack-alert').click('', function(e) {
    event.preventDefault();
    var alert_id = $(this).data("alert_id");
    $.ajax({
        type: "POST",
            url: "ajax_form.php",
            data: { type: "ack-alert", alert_id: alert_id },
            success: function(msg){
                $("#message").html('<div class="alert alert-info">'+msg+'</div>');
                if(msg.indexOf("ERROR:") <= -1) {
                    setTimeout(function() {
                        location.reload(1);
                    }, 1000);
                }
            },
                error: function(){
                    $("#message").html('<div class="alert alert-info">An error occurred acking this alert.</div>');
                }
    });
});

$("[name='alert-rule']").bootstrapSwitch('offColor','danger');
$('input[name="alert-rule"]').on('switchChange.bootstrapSwitch',  function(event, state) {
    event.preventDefault();
    var $this = $(this);
    var alert_id = $(this).data("alert_id");
    var orig_state = $(this).data("orig_state");
    var orig_colour = $(this).data("orig_colour");
    var orig_class = $(this).data("orig_class");
    $.ajax({
        type: 'POST',
            url: 'ajax_form.php',
            data: { type: "update-alert-rule", alert_id: alert_id, state: state },
            dataType: "html",
            success: function(msg) {
                if(msg.indexOf("ERROR:") <= -1) {
                    if(state) {
                        $('#alert-rule-'+alert_id).removeClass('fa-pause');
                        $('#alert-rule-'+alert_id).addClass('fa-'+orig_state);
                        $('#alert-rule-'+alert_id).removeClass('text-default');
                        $('#alert-rule-'+alert_id).addClass('text-'+orig_colour);
                        $('#row_'+alert_id).removeClass('active');
                        $('#row_'+alert_id).addClass(orig_class);
                    } else {
                        $('#alert-rule-'+alert_id).removeClass('fa-'+orig_state);
                        $('#alert-rule-'+alert_id).addClass('fa-pause');
                        $('#alert-rule-'+alert_id).removeClass('text-'+orig_colour);
                        $('#alert-rule-'+alert_id).addClass('text-default');
                        $('#row_'+alert_id).removeClass('warning');
                        $('#row_'+alert_id).addClass('active');
                    }
                } else {
                    $("#message").html('<div class="alert alert-info">'+msg+'</div>');
                    $('#'+alert_id).bootstrapSwitch('toggleState',true );
                }
            },
                error: function() {
                    $("#message").html('<div class="alert alert-info">This alert could not be updated.</div>');
                    $('#'+alert_id).bootstrapSwitch('toggleState',true );
                }
    });
});

function updateResults(results) {
    $('#results_amount').val(results.value);
    $('#page_number').val(1);
    $('#result_form').submit();
}

function changePage(page,e) {
    e.preventDefault();
    $('#page_number').val(page);
    $('#result_form').submit();
}

function newRule(data, e) {
    $('#template_id').val(data.value);
    $('#create-alert').modal({
        show: true
    });
}

</script>
