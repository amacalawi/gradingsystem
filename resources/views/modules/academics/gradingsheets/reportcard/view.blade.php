@extends('layouts.app')

@section('content')
    @include('forms.report-card-view')
@endsection

@push('scripts')
    <script src="{{ asset('js/forms/report-card.js') }}" type="text/javascript"></script>
@endpush