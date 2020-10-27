@extends('layouts.guest')

@section('content')
<div class="m-grid m-grid--hor m-grid--root m-page guest-upload-page">
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-2" id="m_login" style="min-height: 100vh; background-image: url({{ asset('assets/app/media/img//bg/bg-3.jpg') }});">
        <div class="m-grid__item m-grid__item--fluid    m-login__wrapper">
            <div class="m-login__container">
                <div class="m-login__logo">
                    <div class="avatar-upload">
                        <div class="avatar-edit">
                            <input type="file" name="avatar" id="avatar" accept=".png, .jpg, .jpeg" />
                            <label for="avatar"></label>
                        </div>
                        <div class="avatar-preview">
                            <div class="avatar_preview" id="avatarPreview">
                            </div>
                        </div>
                        <a href="#" class="btn btn-danger close-file invisible"><i class="fa fa-close"></i></a>
                    </div>
                </div>
                <div class="m-login__signin">
                    {{ Form::open(array('url' => 'upload-data', 'class'=>'m-login__form m-form"', 'name' => 'guest_form', 'method' => 'POST')) }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group m-form__group required">
                                    <input class="form-control m-input" type="text" placeholder="ID Number" name="identification_no" autocomplete="off">
                                    <span class="m-form__help m--font-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group m-form__group required">
                                    <input class="form-control m-input" type="text" placeholder="Firstname" name="firstname" autocomplete="off">
                                    <span class="m-form__help m--font-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group m-form__group required">
                                    <input class="form-control m-input m-login__form-input--last" type="text" placeholder="Lastname" name="lastname">
                                    <span class="m-form__help m--font-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="m-login__form-action">
                            <button class="submit-btn btn btn-info m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">
                                Upload Now
                            </button>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/forms/guest-upload.js') }}" type="text/javascript"></script>
@endpush