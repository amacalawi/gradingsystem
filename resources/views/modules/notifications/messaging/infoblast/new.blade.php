@extends('layouts.app')

@section('content')
    @include('forms.infoblast')
@endsection

@push('scripts')
    <script src="{{ asset('js/forms/infoblast-new.js') }}" type="text/javascript"></script>
@endpush