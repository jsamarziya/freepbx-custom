var CallblockerC = UCPMC.extend({
    /**
     * This function is similar to PHP's __construct
     * class variables are declared in this method using 'this.variable'
     */
    init: function () {
        this.socket = null;
    },
    /**
     * Add Simple Widget
     * This method is executed when the side bar widget has been added to the side bar.
     * @method addSimpleWidget
     * @link https://wiki.freepbx.org/pages/viewpage.action?pageId=71271742#DevelopingforUCP14+-addSimpleWidget
     * @param  {string}      widget_id    The widget UUID on the dashboard
     */
    addSimpleWidget: function (widget_id) {
        $(".grid-stack-item[data-id='" + widget_id + "']");
    },
    /**
     * Display Widget
     * This method is executed when the side bar widget has finished loading.
     * @method displayWidget
     * @link https://wiki.freepbx.org/pages/viewpage.action?pageId=71271742#DevelopingforUCP14+-displayWidget
     * @param  {string}      widget_id    The widget ID on the dashboard
     * @param  {string}      dashboard_id The dashboard ID the widget has been placed on
     */
    displayWidget: function (widget_id, dashboard_id) {
        $(".grid-stack-item[data-id='" + widget_id + "']");
    },
    /**
     * Display Side Bar Widget
     * This method is executed after the side bar widget has been clicked and the window has fully extended has finished loading.
     * @method displaySimpleWidget
     * @link https://wiki.freepbx.org/pages/viewpage.action?pageId=71271742#DevelopingforUCP14+-displaySimpleWidget
     * @param  {string}            widget_id The widget id in the sidebar
     */
    displaySimpleWidget: function (widget_id) {
        $(".widget-extra-menu[data-id=" + widget_id + "]");
    },
    /**
     * Display Widget Settings
     * This method is executed when the settings window has finished loading.
     * @method displayWidgetSettings
     * @link https://wiki.freepbx.org/pages/viewpage.action?pageId=71271742#DevelopingforUCP14+-displayWidgetSettings
     * @param  {string}      widget_id    The widget ID on the dashboard
     * @param  {string}      dashboard_id The dashboard ID
     */
    displayWidgetSettings: function (widget_id, dashboard_id) {
        $("#widget_settings .widget-settings-content");
    },
    /**
     * Display Simple Widget Settings
     * This method is executed when the settings window has finished loading.
     * @method displaySimpleWidgetSettings
     * @link https://wiki.freepbx.org/pages/viewpage.action?pageId=71271742#DevelopingforUCP14+-displaySimpleWidgetSettings
     * @param  {string}      widget_id    The widget ID on the sidebar
     */
    displaySimpleWidgetSettings: function (widget_id) {
        $("#widget_settings .widget-settings-content")
    },
    /**
     * Resize Widget
     * The method is executed when the widget has been resized
     * @method resize
     * @link https://wiki.freepbx.org/pages/viewpage.action?pageId=71271742#DevelopingforUCP14+-resize
     * @param  {string}      widget_id    The widget ID on the dashboard
     * @param  {string}      dashboard_id The dashboard ID
     */
    resize: function (widget_id, dashboard_id) {
        $(".grid-stack-item[data-id='" + widget_id + "']");
    },
    /**
     * When the dashboard is displayed and has finished loading
     * This method is executed when the dashboard has finished loading
     * @method showDashboard
     * @link https://wiki.freepbx.org/pages/viewpage.action?pageId=71271742#DevelopingforUCP14+-showDashboard
     * @param  {string}            dashboard_id The dashboard id
     */
    showDashboard: function (dashboard_id) {
    },
    /**
     * Window State
     * The method is executed when the tab in the browser (Or the browser itself) is brought into focus or out of focus
     * @method windowState
     * @link https://wiki.freepbx.org/pages/viewpage.action?pageId=71271742#DevelopingforUCP14+-windowState
     * @param  {string}      state    The window state. Can be "hidden" or "visible"
     */
    windowState: function (state) {
    },
    /**
     * Pre Poll (Before the poll)
     * This method is used to populate data to send to the PHP poll function for this module
     * @method prepoll
     * @link https://wiki.freepbx.org/pages/viewpage.action?pageId=71271742#DevelopingforUCP14+-prepoll
     * @return  {mixed}      Data to send back to the PHP poll function for this module
     */
    prepoll: function () {
        var items = {};
        $(".grid-stack-item[data-rawname=callblocker][data-widget_type_id=poll]").each(function () {
            var id = $(this).data("id");
            if ($(this).find(".number").length) {
                items[id] = $(this).find(".number").text();
            }
        });
        return items;
    },
    /**
     * Poll
     * This method is used to process data returned from the PHP poll function for this module
     * @method prepoll
     * @link https://wiki.freepbx.org/pages/viewpage.action?pageId=71271742#DevelopingforUCP14+-poll(Javascript)
     * @param  {mixed}      data    Data returned from the PHP poll function for this module
     */
    poll: function (data) {
        $.each(data.items, function (id, value) {
            $(".grid-stack-item[data-id=" + id + "] .number").text(value);
        });
        //$("#callblocker-badge").text(data.total);
        //$("#nav-btn-callblocker .badge").text(data.total);
    },
    /**
     * Websocket Disconnect
     * @method
     */
    disconnect: function () {
        var $this = this,
            listeners = ["hello"];
        if (this.socket !== null) {
            //remove all listeners so we don't get double binds on a reconnect
            $.each(listeners, function (i, v) {
                $this.socket.removeAllListeners(v);
            });
            this.subscribed = [];
        }
    },
    /**
     * Websocket Connect
     * @method
     */
    connect: function () {
        var $this = this;
        try {
            //connect to the namespace we want to reach in UCP Node Server
            UCP.wsconnect("callblocker", function (socket) {
                if (socket === false) {
                    $this.socket = null;
                    return false;
                } else {
                    $this.socket = socket;
                }

                //emit our event
                $this.socket.emit("hello", "");

                //bind for a response
                $this.socket.on("hello", function (response) {
                    console.log(response);
                });
            });
        } catch (e) {

        }
    },
    /**
     * Formats the "Controls" whitelist column.
     */
    formatWhitelistControls: function (value, row, index, field) {
        return `
            <a title="Edit" onclick="UCP.Modules.Callblocker.showEditWhitelistEntryDialog(${row.id})"><i class="fa fa-pencil"></i></a> 
            <a title="Delete" onclick="UCP.Modules.Callblocker.confirmDelete(${row.id})"><i class="fa fa-trash-o"></i></a>
        `;
    },
    confirmDelete: function (id) {
        const row = UCP.Modules.Callblocker.getWhitelistEntry(id);
        const cid = new Option(row.cid).innerHTML;
        const description = new Option(row.description).innerHTML;
        UCP.showConfirm(
            `<i class="fa fa-warning"></i> Are you sure you wish to delete <b>${cid} "${description}"</b>?`,
            'warning',
            function () {
                UCP.Modules.Callblocker.deleteWhitelistEntry(id);
            }
        );
    },
    getWhitelistEntry: function (id) {
        const data = $('#whitelistTable').bootstrapTable('getData');
        for (const row of data) {
            // noinspection EqualityComparisonWithCoercionJS
            if (row.id == id) {
                return row;
            }
        }
        return null;
    },
    deleteWhitelistEntry: function (id) {
        $.ajax({
            url: "ajax.php",
            data: {"module": "callblocker", "command": "deleteWhitelistEntry", "id": id},
            success: function (data) {
                $('#whitelistTable').bootstrapTable('remove', {field: 'id', values: [id.toString()]});
            }
        });
    },
    showAddWhitelistEntryDialog: function () {
        const content = `
               <div class="form-group">
                   <label for="add-whitelist-cid">CID</label>
                   <input type="text" class="form-control" id="add-whitelist-cid">
               </div>
               <div class="form-group">
                   <label for="add-whitelist-description">Description</label>
                   <input type="text" class="form-control" id="add-whitelist-description">
               </div>
           `;
        const footer = `
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               <button type="button" class="btn btn-primary" onclick="UCP.Modules.Callblocker.addWhitelistEntry()">Add Entry</button>
           `;
        UCP.showDialog("Add Entry", content, footer, function () {
            $('#add-whitelist-cid').focus();
        });
    },
    addWhitelistEntry: function () {
        const cid = $("#add-whitelist-cid").val();
        const description = $("#add-whitelist-description").val();
        $.ajax({
            url: "ajax.php",
            method: "post",
            data: {"module": "callblocker", "command": "addWhitelistEntry", "cid": cid, "description": description},
            success: function (data) {
                $('#whitelistTable').bootstrapTable('refresh');
                $('#globalModal').modal('hide')
            }
        });
    },
    showEditWhitelistEntryDialog: function (id) {
        const row = UCP.Modules.Callblocker.getWhitelistEntry(id);
        const content = `
               <div class="form-group">
                   <label for="edit-whitelist-cid">CID</label>
                   <input type="text" class="form-control" id="edit-whitelist-cid">
               </div>
               <div class="form-group">
                   <label for="edit-whitelist-description">Description</label>
                   <input type="text" class="form-control" id="edit-whitelist-description">
               </div>
           `;
        const footer = `
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               <button type="button" class="btn btn-primary" onclick="UCP.Modules.Callblocker.updateWhitelistEntry(${row.id})">Update Entry</button>
           `;
        UCP.showDialog("Edit Entry", content, footer, function () {
            const cid_input = $('#edit-whitelist-cid');
            cid_input.val(row.cid);
            $('#edit-whitelist-description').val(row.description);
            cid_input.focus();
        });
    },
    updateWhitelistEntry: function (id) {
        const cid = $("#edit-whitelist-cid").val();
        const description = $("#edit-whitelist-description").val();
        $.ajax({
            url: "ajax.php",
            method: "post",
            data: {
                "module": "callblocker",
                "command": "updateWhitelistEntry",
                "id": id,
                "cid": cid,
                "description": description
            },
            success: function (data) {
                $('#whitelistTable').bootstrapTable('refresh');
                $('#globalModal').modal('hide')
            }
        });
    }
});
