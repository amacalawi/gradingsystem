@extends('layouts.app')

@section('content')
    @include('forms.staff')
@endsection

@push('scripts')
    <script src="{{ asset('js/forms/staff.js') }}" type="text/javascript"></script>
@endpush