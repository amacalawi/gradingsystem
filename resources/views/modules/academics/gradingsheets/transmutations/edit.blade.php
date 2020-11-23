@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        @include('forms.transmutation')
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/forms/transmutation.js') }}" type="text/javascript"></script>
@endpush