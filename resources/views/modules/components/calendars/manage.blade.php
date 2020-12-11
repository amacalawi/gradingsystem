@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="m-portlet m-portlet--full-height ">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
    @include('modules.components.calendars.event')
@endsection

@push('styles')
    <link href="{{ asset('fullcalendar/dist/fullcalendar.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('fullcalendar/dist/app.min.2.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('fullcalendar/dist/material-design-iconic-font.min.css') }}" rel="stylesheet" type="text/css" >
@endpush

@push('scripts')
    <script src="{{ asset('js/datatables/calendar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('fullcalendar/dist/fullcalendar.min.js') }}" type="text/javascript"></script>
@endpush
