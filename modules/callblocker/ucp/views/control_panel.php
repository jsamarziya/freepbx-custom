<div class="col-md-12">
    <table>
        <tr>
            <td>
                Call Blocker&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </td>
            <input type="checkbox" name="dndenable" data-toggle="toggle" data-on="<?php echo _("Enabled")?>" data-off="<?php echo _("Disabled")?>">
            <td>
                <div class="onoffswitch">
                    <input type="checkbox" name="enabled" class="onoffswitch-checkbox" id="enabled">
                    <label class="onoffswitch-label" for="enabled">
                        <div class="onoffswitch-inner"></div>
                        <div class="onoffswitch-switch"></div>
                    </label>
                </div>
            </td>
        </tr>
    </table>
    <script>
       function getCallBlockerStatus() {
            $.ajax({
                url: "ajax.php",
                data: {
                    "module": "callblocker",
                    "command": "getCallBlockerStatus",
                },
                success: function (data) {
                    updateCallBlockerEnabled(data);
                }
            });
        }
        function updateCallBlockerEnabled(data) {
            alert(data);
        }
        getCallBlockerStatus();
    </script>
</div>
