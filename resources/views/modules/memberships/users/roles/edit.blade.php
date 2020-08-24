@extends('layouts.app')

@section('content')
    @include('forms.user-role')
@endsection

@push('scripts')
    <script src="{{ asset('js/forms/user-role.js') }}" type="text/javascript"></script>
@endpush