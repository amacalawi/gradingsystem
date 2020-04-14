@extends('layouts.app')

@section('content')
    @include('forms.student')
@endsection

@push('scripts')
    <script src="{{ asset('js/forms/student.js') }}" type="text/javascript"></script>
@endpush