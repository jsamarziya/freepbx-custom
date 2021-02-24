<div class="col-md-12">
    <table id="call-history-table"
           class="table"
           data-url="ajax.php?module=callblocker&amp;command=getCallHistory&amp;extension=<?php echo htmlentities($ext) ?>"
           data-cache="false"
           data-cookie="true"
           data-cookie-id-table="ucp-callblocker-call-history-table"
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
                data-formatter="UCP.Modules.Callblocker.formatCallHistoryTimestamp"
            >
                Date
            </th>
            <th data-field="cid" data-sortable="true">CID</th>
            <th data-field="description" data-sortable="true"
                data-formatter="UCP.Modules.Callblocker.formatCallHistoryDescription"
            >
                Description
            </th>
            <th data-field="duration" data-sortable="true"
                data-formatter="UCP.Modules.Callblocker.formatCallHistoryDuration"
            >
                Duration
            </th>
            <th data-field="disposition" data-sortable="true"
                data-formatter="UCP.Modules.Callblocker.formatCallHistoryDisposition"
            >
                Disposition
            </th>
            <th class="text-nowrap" data-formatter="UCP.Modules.Callblocker.formatCallHistoryControls">Controls</th>
        </tr>
        </thead>
    </table>
</div>
