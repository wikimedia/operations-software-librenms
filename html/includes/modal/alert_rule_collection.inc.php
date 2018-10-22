<?php
/**
 * search_rule_collection.inc.php
 *
 * LibreNMS search_rule_collection modal
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package    LibreNMS
 * @link       http://librenms.org
 * @copyright  2016 Neil Lathwood
 * @author     Neil Lathwood <neil@lathwood.co.uk>
 */

if (is_admin() === false) {
    die('ERROR: You need to be admin');
}

?>

<div class="modal fade" id="search_rule_modal" tabindex="-1" role="dialog" aria-labelledby="search_rule" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h5 class="modal-title" id="search_rule">Alert rule collection</h5>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="rule_collection" class="table table-condensed table-hover">
                        <thead>
                            <tr>
                                <th data-column-id="name" data-width="200px">Name</th>
                                <th data-column-id="rule">Rule</th>
                                <td data-column-id="action" data-formatter="action"></td>
                            </tr>
                        </thead>
                        <?php
                        $tmp_rule_id = 0;
                        foreach (get_rules_from_json() as $rule) {
                            $rule['rule_id'] = $tmp_rule_id;
                            echo "
                                <tr>
                                    <td>{$rule['name']}</td>
                                    <td>{$rule['rule']}</td>
                                    <td>{$rule['rule_id']}</td>
                                </tr>
                            ";
                            $tmp_rule_id++;
                        }
                        ?>
                    </table>
                    <script>
                        var grid = $("#rule_collection").bootgrid({
                            formatters: {
                                "action": function (column, row) {
                                    return "<button type=\"button\" id=\"rule_from_collection\" name=\"rule_from_collection\" data-rule_id=\"" + row.action + "\" class=\"btn btn-sm btn-primary rule_from_collection\">Select</button";
                                }
                            }
                        }).on("loaded.rs.jquery.bootgrid", function()
                        {
                            grid.find(".rule_from_collection").on("click", function(e)
                            {
                                var template_rule_id = $(this).data("rule_id");
                                    $("#template_id").val(template_rule_id);
                                    $("#search_rule_modal").modal('hide');
                                    $("#create-alert").modal('show');
                            }).end();
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $("#search_rule_modal").on('hidden.bs.modal', function(e) {
        $("#template_rule_id").val('');
        $("#rule_suggest").val('');
        $("#rule_display").html('');
    });
</script>
