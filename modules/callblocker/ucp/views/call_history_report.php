<div class="col-md-12">
    <select id="call-history-report-date" data-toggle="select" data-size="auto" title="Date Range">
    </select>
    <h3 style="margin-top: 1em;">
        <span id="calls-blocked" class="label label-warning" style="margin-left: 5ex;"></span>
        <span id="calls-blacklisted" class="label label-danger" style="margin-left: 5ex;"></span>
        <span id="calls-accepted" class="label label-success" style="margin-left: 5ex;"></span>
    </h3>
    <div style="margin-top: 4em;">
        <div id="blocked-callers-table-toolbar">
            <h4>Blocked Callers</h4>
        </div>
        <table id="blocked-callers-table"
               class="table"
               data-toolbar="#blocked-callers-table-toolbar"
               data-cookie="true"
               data-cookie-id-table="ucp-callblocker-blocked-callers-table"
               data-show-toggle="true"
               data-toggle="table"
               data-pagination="true"
               data-search="true"
               data-sort-name="cid"
               data-escape="true"
        >
            <thead>
            <tr>
                <th data-field="count" data-sortable="true" data-width="5%">Calls</th>
                <th data-field="cid" data-sortable="true">CID</th>
                <th data-field="description" data-sortable="true"
                    data-formatter="UCP.Modules.Callblocker.formatCallerDescription">
                    Description
                </th>
            </tr>
            </thead>
        </table>
    </div>
    <div style="margin-top: 4em;">
        <div id="blacklisted-callers-table-toolbar">
            <h4>Blacklisted Callers</h4>
        </div>
        <table id="blacklisted-callers-table"
               class="table"
               data-toolbar="#blacklisted-callers-table-toolbar"
               data-cookie="true"
               data-cookie-id-table="ucp-callblocker-blacklisted-callers-table"
               data-show-toggle="true"
               data-toggle="table"
               data-pagination="true"
               data-search="true"
               data-sort-name="cid"
               data-escape="true"
        >
            <thead>
            <tr>
                <th data-field="count" data-sortable="true" data-width="5%">Calls</th>
                <th data-field="cid" data-sortable="true">CID</th>
                <th data-field="description" data-sortable="true"
                    data-formatter="UCP.Modules.Callblocker.formatCallerDescription">
                    Description
                </th>
            </tr>
            </thead>
        </table>
    </div>
    <div style="margin-top: 4em;">
        <div id="accepted-callers-table-toolbar">
            <h4>Accepted Callers</h4>
        </div>
        <table id="accepted-callers-table"
               class="table"
               data-toolbar="#accepted-callers-table-toolbar"
               data-cookie="true"
               data-cookie-id-table="ucp-callblocker-accepted-callers-table"
               data-show-toggle="true"
               data-toggle="table"
               data-pagination="true"
               data-search="true"
               data-sort-name="cid"
               data-escape="true"
        >
            <thead>
            <tr>
                <th data-field="count" data-sortable="true" data-width="5%">Calls</th>
                <th data-field="cid" data-sortable="true">CID</th>
                <th data-field="description" data-sortable="true"
                    data-formatter="UCP.Modules.Callblocker.formatCallerDescription">
                    Description
                </th>
            </tr>
            </thead>
        </table>
    </div>
</div>
