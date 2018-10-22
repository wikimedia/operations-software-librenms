<?php
/*
 * LibreNMS
 *
 * Copyright (c) 2014 Neil Lathwood <https://github.com/laf/ http://www.lathwood.co.uk/fa>
 * Copyright (c) 2018 TheGreatDoc <https://github.com/thegreatdoc/>
 *
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.  Please see LICENSE.txt at the top level of
 * the source code distribution for details.
 */

use LibreNMS\Authentication\LegacyAuth;

if (!LegacyAuth::user()->hasGlobalAdmin()) {
    die('ERROR: You need to be admin');
}

?>

<div class="modal fade" id="attach-alert-template" tabindex="-1" role="dialog" aria-labelledby="Attach" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h5 class="modal-title" id="Attach">Attach template to rules...</h5>
            </div>
            <div class="modal-body">
                <p>Please select the rules that you would like to assign this template to.</p>
                <form class="form-group">
                    <div class="form-group">
                        <label for="rules_list">Select rules</label>
                        <select multiple="multiple" class="form-control" id="rules_list" name="rules_list" size="10">
                            <option>--Clear Rules--</option>
<?php

foreach (dbFetchRows("SELECT `id`,`rule`,`name` FROM `alert_rules`", array()) as $rule) {
    $is_avail = dbFetchCell("SELECT `alert_templates_id` FROM `alert_template_map` WHERE `alert_rule_id` = ?", [$rule['id']]);
    if (!isset($is_avail)) {
        echo '<option value="' . $rule['id'] . '">' . $rule['name'] . '</option>';
    } else {
        $template = dbFetchCell("SELECT `name` FROM `alert_templates` WHERE `id` = ?", [$is_avail]);
        echo '<option value="' . $rule['id'] . '" disabled>' . $rule['name'] . ' - Used in template: ' . $template . '</option>';
    }
}
?>
                        </select>
                    </div>
                </form>
                <span id="template_error"></span><br />
            </div>
            <div class="modal-footer">
                <form role="form" class="attach_rule_form">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger danger" id="alert-template-attach" data-target="alert-template-attach">Attach</button>
                    <input type="hidden" name="template_id" id="template_id" value="">
                    <input type="hidden" name="confirm" id="confirm" value="yes">
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$('#attach-alert-template').on('show.bs.modal', function(e) {
    var template_id = $('#template_id').val();
    $.ajax({
        type: "POST",
        url: "ajax_form.php",
        data: { type: "parse-template-rules", template_id: template_id },
        dataType: "json",
        success: function(output) {
            selected_items = [];
            $.each( output.rule_id, function( i, elem) {
                elem = parseInt(elem);
                selected_items.push(elem);
                $("#rules_list option[value='"+ elem + "']").attr('disabled', false);
            });
            $('#rules_list').val(selected_items);
        }
    });
});

$('#attach-alert-template').on('hide.bs.modal', function(e) {
    $('#rules_list').val([]);
    $('template_id').val('');
});

$('#alert-template-attach').click('', function(event) {
    event.preventDefault();
    var template_id = $("#template_id").val();
    var items = [];
    $('#rules_list :selected').each(function(i, selectedElement) {
        items.push($(selectedElement).val());
    });
    var rules = items.join(',');
    $.ajax({
        type: 'POST',
        url: 'ajax_form.php',
        data: { type: "attach-alert-template", template_id: template_id, rule_id: rules },
        dataType: "json",
        success: function(data) {
            if (data.status == 'ok') {
                toastr.success(data.message);
                $("#attach-alert-template").modal('hide');
                $.each( data.old_rules, function(index, itemData){
                    if (itemData != "--Clear Rules--") {
                        $("#rules_list option[value=" + itemData + "]").prop('disabled', false).text(data.rule_name[index]);
                    }
                });
                $.each( data.new_rules, function(index, itemData){
                    if (itemData != "--Clear Rules--") {
                        $("#rules_list option[value=" + itemData + "]").prop('disabled', true).text(data.nrule_name[index] + ' - Used in template:' + data.template_name[index]);
                    }
                });
            } else {
                //$('#template_error').html('<div class="alert alert-danger">'+msg+'</div>');
                toastr.error(data.message);
            }
        },
        error: function(data) {
            //$("#template_error").html('<div class="alert alert-danger">The alert rules could not be attached to this template.</div>');
            toastr.error(data.message);
        }
    });
});
</script>
