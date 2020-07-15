<div class="modal fade" id="importmodule" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {{ Form::open(array('url' => 'academics/academics/levels/import-levels', 'name' => 'levels_import_form', 'method' => 'POST', 'enctype' => 'multipart/form-data' )) }}
                <div class="modal-header">
                    <h4 class="modal-title">Import {{ ucfirst(Request::segment(3)) }}</h4>
                </div>

                <div class="modal-body">

                    <input value="" id="levelsid" hidden>
                    
                    <input type="file" name="import_file" class="form-control" />
                    <i>Maximum of 500 records per upload.</i>

                    <div class="w-100">
                        <span id="errormessage"></span>
                    </div>

                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-default " data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-md btn-info">Save</button>
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

