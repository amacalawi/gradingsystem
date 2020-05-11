@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="m-portlet m-portlet--full-height ">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <div class="flex align-items-center">
                            <div class="mr-auto">
                                <h3 class="m-portlet__head-text">
                                    All Inactive {{ ucfirst(Request::segment(3)) }} 
                                </h3> 
                            </div>
                            <div>
                                <a title="move to active {{ strtolower(Request::segment(3)) }}" href="{{ url('/'.Request::segment(1).'/'.Request::segment(2).'/'.Request::segment(3)) }}" class="pull-right moves moves-back m--font-info">
                                    <i class="la la-angle-double-left"></i> ACTIVE {{ strtoupper(Request::segment(3)) }} 
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                </div>
                <div class="m_datatable" id="local_data"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/datatables/inactive-subject.js') }}" type="text/javascript"></script>
@endpush