@extends('layouts.app')

@section('content')
    @include('forms.infoblast')
@endsection

@push('scripts')
    <script src="{{ asset('js/forms/batch.js') }}" type="text/javascript"></script>
@endpush