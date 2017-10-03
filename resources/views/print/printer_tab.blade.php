<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Printer</h3>
    </div>

    <div class="panel-body">
        <div class="form-group">
            <label for="printerSearch">Search:</label>
            <input type="text" id="printerSearch" value="zebra" class="form-control">
        </div>
        <div class="form-group">
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-default btn-sm" onclick="findPrinter($('#printerSearch').val(), true);">Find Printer</button>
                <button type="button" class="btn btn-default btn-sm" onclick="findDefaultPrinter(true);">Default Printer</button>
                <button type="button" class="btn btn-default btn-sm" onclick="findPrinters();">Find All Printers</button>
            </div>
        </div>
        <hr>
        <div class="form-group">
            <label>Current printer:</label>
            <div id="configPrinter">NONE</div>
        </div>
        <div class="form-group">
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#askHostModal">Set To Host</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="askHostModal" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="askHost">Host:</label>
                        <input type="text" id="askHost" class="form-control" value="192.168.1.254" />
                    </div>
                    <div class="form-group">
                        <label for="askPort">Port:</label>
                        <input type="text" id="askPort" class="form-control" value="9100" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="setPrintHost();">Set</button>
                </div>
            </div>
        </div>
    </div>