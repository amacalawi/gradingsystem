@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="m-portlet m-portlet--tab">
            @include('partials.messages')
            <div class="m-portlet__body">
                @include('forms.quarter')
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/forms/quarter.js') }}" type="text/javascript"></script>
@endpush