@extends('layouts.app')

@section('content')
    @include('forms.gradingsheet')
    @include('modules.academics.gradingsheets.all.import')
    @include('modals.gradingsheet-components')
@endsection

@push('styles')
    <link href="{{ asset('css/freezepane-table.css') }}" rel="stylesheet" type="text/css" />
@endpush
@push('scripts')
    <script src="{{ asset('js/freezepane-table.js') }}" type="text/javascript"></script>
@endpush