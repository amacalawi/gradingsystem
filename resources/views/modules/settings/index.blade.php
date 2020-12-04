@extends('layouts.app')

@section('content')
    @include('forms.setting')
@endsection

@push('scripts')
    <script src="{{ asset('js/forms/setting.js') }}" type="text/javascript"></script>
@endpush