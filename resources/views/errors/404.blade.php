@extends('layouts.404')

@section('content') 
<div class="m-grid m-grid--hor m-grid--root m-page">
    <div class="m-grid__item m-grid__item--fluid m-grid  m-error-5" style="background-image: url({{ asset('assets/app/media/img/error/bg5.jpg') }});">
        <div class="m-error_container">
            <span class="m-error_title">
                <h1>
                    Oops!
                </h1>
            </span>
            <p class="m-error_subtitle">
                Something went wrong here.
            </p>
            <p class="m-error_description">
                We're working on it and we'll get it fixed
                <br>
                as soon possible.
                <br>
                You can back or use our Help Center.
            </p>
        </div>
    </div>
</div>
@endsection