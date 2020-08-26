@extends('layouts.app')

@section('content')
    @include('forms.component')
@endsection

@push('scripts')
    <script src="{{ asset('js/forms/component.js') }}" type="text/javascript"></script>
@endpush