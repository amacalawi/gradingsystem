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
                                        All Active {{ ucfirst(Request::segment(4)) }} 
                                    </h3> 
                                </div>
                                <div>
                                    <a title="refresh datatable" href="javascript:;" class="refresh-table pull-right moves m--font-danger">
                                        <span class="refresh-text">DATA AS OF {{ date('d-M-Y h:i A') }}</span> <i class="la la-refresh"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="m-input-icon m-input-icon--left m-bottom-2">
                                <input type="text" class="form-control m-input m-input--solid" placeholder="Search Keywords" id="generalSearch">
                                <span class="m-input-icon__icon m-input-icon__icon--left">
                                    <span>
                                        <i class="la la-search"></i>
                                    </span>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="m-form__group m-form__group--inline">
                                <div class="m-form__control">
                                    <select class="form-control m-bootstrap-select m-bootstrap-select--solid" id="m_form_type">
                                        <option value="">
                                            All
                                        </option>
                                        <option value="1">
                                            Messaging
                                        </option>
                                        <option value="2">
                                            SOA
                                        </option>
                                        <option value="3">
                                            Gradingsheet
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-md-none m--margin-bottom-10"></div>
                        </div>
                    </div>
                    <div class="row m-b-10">
                        <div class="col-md-3 text-left">
                            <h5><i class="fa fa-envelope"></i> Total Messages: {{ $messages }}</h5>
                        </div>
                        <div class="col-md-3 text-center">
                            <h5><i class="fa fa-check"></i> Total Success: {{ $successful }}</h5>
                        </div>
                        <div class="col-md-3 text-center">
                            <h5><i class="fa fa-exclamation"></i> Total Pending: {{ $pending }}</h5>
                        </div>
                        <div class="col-md-3 text-right">
                            <h5><i class="fa fa-close"></i> Total Failed: {{ $failure }}</h5>
                        </div>
                    </div>
                    <div class="m_datatable" id="local_data"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/datatables/tracking.js') }}" type="text/javascript"></script>
@endpush
