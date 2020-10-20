@extends('layouts.guest')

@section('content')
    <div class="col-md-12">
        @include('forms.enrollment')
    </div>
    @include('modals.import-student-document')
@endsection

@push('styles')
    <link href="{{ asset('assets/vendors/dropzone/dropzone.css') }}" rel="stylesheet" type="text/css" />
@endpush
@push('scripts')
    <script src="{{ asset('assets/vendors/dropzone/dropzone.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/forms/enrollment.js') }}" type="text/javascript"></script>
@endpush