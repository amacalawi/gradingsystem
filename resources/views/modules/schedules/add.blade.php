@extends('layouts.app')

@section('content')
    @include('forms.schedule')
@endsection

@push('scripts')
    <script src="{{ asset('js/forms/schedule.js') }}" type="text/javascript"></script>
@endpush