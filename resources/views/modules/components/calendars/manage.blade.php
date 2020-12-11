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
                                        All Active {{ ucfirst(Request::segment(2)) }} 
                                    </h3> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div id="x_calendar"></div>
                </div>
            </div>
        </div>
    </div>
    @include('modules.components.calendars.event')
@endsection

@push('scripts')
    <script src="{{ asset('js/datatables/calendar.js') }}" type="text/javascript"></script>
@endpush
