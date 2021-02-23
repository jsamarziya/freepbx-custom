<div class="col-md-12">
    <table id="call-history-table"
           class="table"
           data-url="ajax.php?module=cdr&amp;command=grid&amp;extension=<?php echo htmlentities($ext) ?>"
           data-cache="false"
           data-show-toggle="true"
           data-toggle="table"
           data-pagination="true"
           data-search="true"
           data-sort-order="desc"
           data-sort-name="timestamp"
           data-side-pagination="server"
           data-show-refresh="true"
           data-escape="true"
    >
        <thead>
        <tr>
            <th data-field="timestamp" data-sortable="true" data-width="10%">Date</th>
            <th data-field="cid" data-sortable="true" data-width="10%">CID</th>
            <th data-field="description" data-sortable="true">Description</th>
            <th data-field="duration" data-sortable="true" data-width="10%">Duration</th>
            <th data-field="userfield" data-sortable="true" data-width="10%">Disposition</th>
            <th class="text-nowrap" data-width="10%">Controls</th>
        </tr>
        </thead>
    </table>
</div>
<script>
    $('#call-history-table').on('load-success.bs.table', function (e, data) {
        for (const row of data.rows) {
            row.cid = "myCID";
        }
    })
</script>