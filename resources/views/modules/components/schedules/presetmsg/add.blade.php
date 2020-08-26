@extends('layouts.app')

@section('content')
    @include('forms.presetmessage')
@endsection

@push('scripts')
    <script src="{{ asset('js/forms/preset-message.js') }}" type="text/javascript"></script>
@endpush