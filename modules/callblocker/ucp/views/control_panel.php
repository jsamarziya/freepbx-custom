<div class="col-md-12">
    <div style="margin-top: 10px;">
        Call Blocker&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="checkbox" id="cbenable" name="cbenable" data-toggle="toggle" data-on="Enabled" data-off="Disabled"
               data-size="mini" onchange="enableChanged(this.checked)">
    </div>
</div>

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

    function enableChanged(value) {
        alert(value);
        // $.ajax({
        //     url: "ajax.php",
        //     data: {
        //         "module": "callblocker",
        //         "command": "setCallBlockerStatus",
        //         "value": event.target.value
        //     },
        //     success: function (data) {
        //         updateCallBlockerEnabled(data);
        //     }
        // });
    }

    getCallBlockerStatus();
</script>
