@extends('layouts.app')

@section('content')
    
    <!--Begin::Section-->
    <div class="m-portlet">
        @include('widgets.widgets01')
    </div>
    <!--End::Section-->
    
    <!--Begin::Section-->
    <div class="row">
        <div class="col-xl-12">
            @include('widgets.widgets06')
        </div>
    </div>
    <!--End::Section-->
                        
@endsection

@push('scripts')
    <script src="{{ asset('assets/app/js/widgets.js') }}" type="text/javascript"></script>
@endpush