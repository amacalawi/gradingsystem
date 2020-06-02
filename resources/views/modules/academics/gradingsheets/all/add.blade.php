@extends('layouts.app')

@section('content')
    @include('forms.gradingsheet')
@endsection

@push('scripts')
    <script src="{{ asset('js/forms/gradingsheet.js') }}" type="text/javascript"></script>
@endpush