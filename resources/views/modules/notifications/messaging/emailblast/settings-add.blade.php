@extends('layouts.app')

@section('content')
    @include('forms.emailbast-settings')
@endsection

@push('scripts')
    <script src="{{ asset('js/forms/emailbast-settings.js') }}" type="text/javascript"></script>
@endpush