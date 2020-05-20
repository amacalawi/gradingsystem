@extends('layouts.app')

@section('content')
    @include('partials.messages')
    @include('forms.sectionstudent')
    @include('modules.academics.admissions.sectionsstudents.enlist')
@endsection

@push('scripts')
    <script src="{{ asset('js/forms/sectionstudent.js') }}" type="text/javascript"></script>
@endpush