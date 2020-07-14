<div class="row">
    <div class="col-md-12">
        <div class="m-portlet m-portlet--tab">
            <div class="m-portlet__body">

                <div class="row">
                    <div class="col-md-6">
                        <h5 class="m-bottom-1">Groups Member</h5>
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="btn btn-sm btn-success pull-right" data-toggle="modal" data-target="#enlist" >Add or Remove Member</button>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div id="admitted_student">
                            <table class="table " style="width:100%;">
                                <thead class="">
                                    <tr class="">
                                        <th style="width:20%; padding: 20px 0px 20px 10px;">ID No.</th>
                                        <th style="width:60%; padding: 20px 0px 20px 10px;">Name</th>
                                        <th style="width:20%; padding: 20px 0px 20px 10px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="m-datatable__body" id="group_member_table">
                                    @if ( $segment == 'edit' )
                                        @foreach ( $groupusers as $groupuser)
                                        <tr id='group_member_{{$groupuser->stud_id}}'> 
                                            <td> {{$groupuser->identification_no}}</td> 
                                            <td> {{$groupuser->firstname}} {{$groupuser->lastname}}</td>
                                            <td> 
                                                <span title='remove this' class=' m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill' onclick='removegroupmember({{$groupuser->stud_id}})'><i class='la la-minus'></i></span>
                                                <input type='text' class='cl_group_member' name='group_member[]' value='{{$groupuser->stud_id}}' hidden>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    {{--<script src="{{ asset('js/datatables/group-user.js') }}" type="text/javascript"></script>--}}
@endpush