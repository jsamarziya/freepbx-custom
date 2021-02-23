<div class="col-md-12">
    <div id="whitelist-toolbar">
        <button class="btn btn-primary" title="Add Entry"
                onclick="UCP.Modules.Callblocker.showAddWhitelistEntryDialog()">
            <i class="fa fa-plus-circle"></i> Add
        </button>
    </div>
    <table id="whitelistTable"
           class="table"
           data-toolbar="#whitelist-toolbar"
           data-url="ajax.php?module=callblocker&amp;command=grid"
           data-cache="false"
           data-show-toggle="true"
           data-toggle="table"
           data-pagination="true"
           data-search="true"
           data-sort-name="description"
           data-show-refresh="true"
           data-escape="true"
    >
        <thead>
        <tr>
            <th data-field="id" data-visible="false">ID</th>
            <th data-field="cid" data-sortable="true" data-width="15%">CID</th>
            <th data-field="description" data-sortable="true">Description</th>
            <th class="text-nowrap" data-width="5%" data-formatter="UCP.Modules.Callblocker.formatWhitelistControls">
                Controls
            </th>
        </tr>
        </thead>
    </table>
</div>
