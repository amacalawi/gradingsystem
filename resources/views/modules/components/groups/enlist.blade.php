<div id="enlist" name="enlist" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Add or Remove Member</h4>
            </div>
        
            <div class="modal-body">
                <p>
                    <div class="m-portlet__body">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="m-input-icon m-input-icon--left m-bottom-2">
                                    <input type="text" class="form-control m-input m-input--solid" placeholder="Search Keywords" id="generalSearch">
                                    <span class="m-input-icon__icon m-input-icon__icon--left">
                                        <span>
                                            <i class="la la-search"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-7" >
                                <span class="pull-left p-2 pull-right">List of available members</span>
                            </div>
                        </div>
                        <div class="groupmember_datatable" id="local_data"></div>
                    </div>
                </p>            
            </div>
        
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="enlist-member-selected" data-dismiss="modal"> Save </button>
            </div>
            
        </div>
    </div>
</div>

@push('scripts')
  <script src="{{ asset('js/datatables/enlist-member.js') }}" type="text/javascript"></script>
@endpush