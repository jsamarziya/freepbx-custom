<div class="col-md-12">
    <div id="<?php echo $list ?>-toolbar">
        <button class="btn btn-primary" title="Add Entry"
                onclick="UCP.Modules.Callblocker.showAddListEntryDialog('<?php echo $list ?>', '<?php echo $list ?>-table')">
            <i class="fa fa-plus-circle"></i> Add
        </button>
    </div>
    <table id="<?php echo $list ?>-table"
           class="table"
           data-toolbar="#<?php echo $list ?>-toolbar"
           data-url="ajax.php?module=callblocker&amp;command=getList&amp;list=<?php echo $list ?>"
           data-cache="false"
           data-cookie="true"
           data-cookie-id-table="ucp-callblocker-<?php echo $list ?>-table"
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
            <th class="text-nowrap" data-width="5%"
                data-formatter="UCP.Modules.Callblocker.format<?php echo ucfirst(strtolower($list)) ?>Controls">
                Controls
            </th>
        </tr>
        </thead>
    </table>
</div>
