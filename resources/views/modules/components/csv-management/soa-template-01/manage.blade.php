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
                                        All Active {{ ucwords(str_replace('-',' ', Request::segment(3))) }} 
                                    </h3> 
                                </div>
                                <div>
                                    <a title="move to inactive {{ strtolower(Request::segment(3)) }}" href="{{ url('/'.Request::segment(1).'/'.Request::segment(2).'/'.Request::segment(3).'/inactive') }}" class="pull-right moves m--font-danger">
                                        INACTIVE {{ strtoupper(Request::segment(3)) }} <i class="la la-angle-double-right"></i>
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
                        <div class="clearfix"></div>
                    </div>
                    <div class="m_datatable" id="local_data"></div>
                </div>
            </div>
        </div>
    </div>
    @include('modals.import-soa-template-01')
@endsection

@push('styles')
    <link href="{{ asset('assets/vendors/dropzone/dropzone.css') }}" rel="stylesheet" type="text/css" />
@endpush
@push('scripts')
    <script src="{{ asset('assets/vendors/dropzone/dropzone.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/datatables/soa-template-01.js') }}" type="text/javascript"></script>
@endpush
