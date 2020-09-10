@extends('layouts.app')

@section('content')
    @include('forms.printid')
@endsection

@push('scripts')
    <script src="{{ asset('js/forms/printid.js') }}" type="text/javascript"></script>
@endpush