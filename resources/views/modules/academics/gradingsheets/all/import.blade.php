    <div class="modal fade" id="importmodal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                {{ Form::open(array('url' => 'academics/grading-sheets/all-gradingsheets/import-gradingsheet/'.$grading->id, 'name' => 'gradingsheet_import_form', 'method' => 'POST', 'enctype' => 'multipart/form-data' )) }}
                    <div class="modal-header">
                        <h4 class="modal-title">Import Grading sheet</h4>
                    </div>

                    <div class="modal-body">
                        
                        <input value="{{$grading->id}}" id="gradingsheetid" hidden>
                        
                        <input type="file" name="import_file" class="form-control" />
                        <div class="w-100">
                            <span id="errormessage"></span>
                        </div>

                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-md btn-default " data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-md btn-info">Save</button> {{--class import-gradingsheet --}}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

