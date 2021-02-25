<div class="col-md-12">
    <select id="call-history-report-date" data-toggle="select" data-size="auto" title="Date Range">
    </select>
    <h3 style="margin-top: 1em;">
        <span id="calls-blocked" class="label label-warning" style="margin-left: 5ex;"></span>
        <span id="calls-blacklisted" class="label label-danger" style="margin-left: 5ex;"></span>
        <span id="calls-accepted" class="label label-success" style="margin-left: 5ex;"></span>
    </h3>
    <table id="blocked-callers-table"
           class="table"
           data-cookie="true"
           data-cookie-id-table="ucp-callblocker-blocked-callers-table"
           data-show-toggle="true"
           data-toggle="table"
           data-pagination="false"
           data-search="true"
           data-sort-name="cid"
           data-escape="true"
    >
        <thead>
        <tr>
            <th data-field="count" data-sortable="true">Calls</th>
            <th data-field="cid" data-sortable="true">CID</th>
            <th data-field="description" data-sortable="true">Description</th>
        </tr>
        </thead>
    </table>
</div>
