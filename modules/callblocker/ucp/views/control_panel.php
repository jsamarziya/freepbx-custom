<div class="col-md-12">
    Call Blocker&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="checkbox" name="cbenable" data-toggle="toggle" data-on="Enabled" data-off="Disabled">
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
            alert(data["enabled"]);
        }

        getCallBlockerStatus();
    </script>
</div>
