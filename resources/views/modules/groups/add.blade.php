@extends('layouts.app')

@section('content')
    @include('forms.group')
@endsection

@push('scripts')
    <script src="{{ asset('js/forms/group.js') }}" type="text/javascript"></script>
@endpush