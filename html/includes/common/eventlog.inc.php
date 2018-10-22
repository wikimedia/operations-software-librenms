<?php

$common_output[] = '
<div class="table-responsive">
    <table id="eventlog" class="table table-hover table-condensed table-striped">
        <thead>
            <tr>
                <th data-column-id="eventicon"></th>
                <th data-column-id="datetime" data-order="desc">Datetime</th>
                <th data-column-id="hostname">Hostname</th>
                <th data-column-id="type">Type</th>
                <th data-column-id="message">Message</th>
                <th data-column-id="username">User</th>
            </tr>
        </thead>
    </table>
</div>
<script>

var eventlog_grid = $("#eventlog").bootgrid({
    ajax: true,
    rowCount: [50, 100, 250, -1],
    post: function ()
    {
        return {
            id: "eventlog",
            device: "' .mres($vars['device']) .'",
            eventtype: "' .mres($vars['eventtype']) .'",
        };
    },
    url: "ajax_table.php"
});

</script>
';
