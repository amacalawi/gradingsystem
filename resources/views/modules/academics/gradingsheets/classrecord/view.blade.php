@extends('layouts.app')

@section('content')
    @include('forms.classrecord')
@endsection

@push('styles')
    <link href="{{ asset('css/freezepane-table.css') }}" rel="stylesheet" type="text/css" />
@endpush
@push('scripts')
    <script src="{{ asset('js/freezepane-table.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/forms/classrecord.js') }}" type="text/javascript"></script>
@endpush