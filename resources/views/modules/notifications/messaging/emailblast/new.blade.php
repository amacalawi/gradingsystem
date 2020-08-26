@extends('layouts.app')

@section('content')
    @include('forms.emailblast')
@endsection

@push('scripts')
    <script src="{{ asset('ckeditor/ckeditor.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/forms/emailblast.js') }}" type="text/javascript"></script> 
@endpush