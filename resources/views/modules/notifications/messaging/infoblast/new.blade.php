@extends('layouts.app')

@section('content')
    @include('forms.infoblast')
    @include('modals.infoblast-template')
@endsection

@push('scripts')
    <script src="{{ asset('js/forms/infoblast-new.js') }}" type="text/javascript"></script>
@endpush