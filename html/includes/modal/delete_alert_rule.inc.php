<?php
/*
 * LibreNMS
 *
 * Copyright (c) 2014 Neil Lathwood <https://github.com/laf/ http://www.lathwood.co.uk/fa>
 *
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.  Please see LICENSE.txt at the top level of
 * the source code distribution for details.
 */

if (is_admin() === false) {
    die('ERROR: You need to be admin');
}

?>

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="Delete" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h5 class="modal-title" id="Delete">Confirm Delete</h5>
            </div>
            <div class="modal-body">
                <p>If you would like to remove the alert rule then please click Delete.</p>
            </div>
            <div class="modal-footer">
                <form role="form" class="remove_token_form">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger danger" id="alert-rule-removal" data-target="alert-rule-removal">Delete</button>
                    <input type="hidden" name="alert_id" id="alert_id" value="">
                    <input type="hidden" name="confirm" id="confirm" value="yes">
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$('#confirm-delete').on('show.bs.modal', function(event) {
    alert_id = $(event.relatedTarget).data('alert_id');
    $("#alert_id").val(alert_id);
});

$('#alert-rule-removal').click('', function(event) {
    event.preventDefault();
    var alert_id = $("#alert_id").val();
    $.ajax({
        type: 'POST',
        url: 'ajax_form.php',
        data: { type: "delete-alert-rule", alert_id: alert_id },
        dataType: "html",
        success: function(msg) {
            if(msg.indexOf("ERROR:") <= -1) {
                $("#row_"+alert_id).remove();
            }
            $("#message").html('<div class="alert alert-info">'+msg+'</div>');
            $("#confirm-delete").modal('hide');
        },
        error: function() {
            $("#message").html('<div class="alert alert-info">The alert rule could not be deleted.</div>');
            $("#confirm-delete").modal('hide');
        }
    });
});
</script>
