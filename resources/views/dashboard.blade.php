@extends('layouts.app')

@section('content')
    
    <!--Begin::Section-->
    <div class="m-portlet">
        @include('widgets.widgets01')
    </div>
    <!--End::Section-->
    
    <!--Begin::Section-->
    <div class="row">
        <div class="col-xl-6">
            @include('widgets.widgets02')
        </div>
        <div class="col-xl-6">
            @include('widgets.widgets03')
        </div>
    </div>
    <!--End::Section-->

    <!--Begin::Section-->
    <div class="row">
        <div class="col-xl-8">
            @include('widgets.widgets04')
        </div>
        <div class="col-xl-4">
            @include('widgets.widgets05')
        </div>
    </div>
    <!--End::Section-->

@endsection