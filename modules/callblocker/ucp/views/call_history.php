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
            <th data-field="timestamp" data-sortable="true"
                data-formatter="UCP.Modules.Callblocker.formatCallHistoryTimestamp">
                Date
            </th>
            <th data-field="cid" data-sortable="true">CID</th>
            <th data-field="description" data-sortable="true">Description</th>
            <th data-field="duration" data-sortable="true"
                data-formatter="UCP.Modules.Callblocker.formatCallHistoryDuration">
                Duration
            </th>
            <th data-field="userfield" data-sortable="true">Disposition</th>
            <th class="text-nowrap">Controls</th>
        </tr>
        </thead>
    </table>
</div>
