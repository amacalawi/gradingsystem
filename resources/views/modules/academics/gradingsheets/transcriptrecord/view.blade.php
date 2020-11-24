@extends('layouts.app')

@section('content')
    @include('forms.transcript-record-view')
@endsection

@push('scripts')
    <script src="{{ asset('js/forms/transcript-record.js') }}" type="text/javascript"></script>
@endpush