@extends('layouts.app')

@section('content')
    @include('partials.messages')
    @include('forms.section')
@endsection

@push('scripts')
    <script src="{{ asset('js/forms/section.js') }}" type="text/javascript"></script>
@endpush