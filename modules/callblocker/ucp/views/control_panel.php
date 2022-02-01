<div class="col-md-12">
    Call Blocker&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="checkbox" id="cbenable" name="cbenable" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-size="mini">
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
            $('#cbenable').bootstrapToggle(data["enabled"] ? 'on' : 'off');
        }

        getCallBlockerStatus();
    </script>
</div>
