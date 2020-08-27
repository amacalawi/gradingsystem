@if ( $segment == 'edit' )
    {{ Form::open(array('url' => 'notifications/messaging/emailblast/settings/update/'.$email->id, 'name' => 'email_form', 'method' => 'PUT')) }}
@else
    {{ Form::open(array('url' => 'notifications/messaging/emailblast/settings/store', 'name' => 'email_form', 'method' => 'POST')) }}
@endif

<div class="row">
    <div class="col-md-12">
        <div class="m-portlet m-portlet--tab">
            <div class="m-portlet__body">
                
                <h5 class="m-bottom-1">Email Settings Account</h5>

                <div class="row">
                    <div class="col-md-12 hidden">
                        {{ 
                            Form::text($name = 'method', $value = ($segment == 'edit') ? 'edit' : 'add', 
                            $attributes = array(
                                'id' => 'method',
                                'class' => 'form-control form-control-lg m-input m-input--solid'
                            )) 
                        }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group m-form__group required">
                            {{ Form::label('username', 'Username', ['class' => '']) }}
                            {{ 
                                Form::text($name = 'username', $value = $email->username, 
                                $attributes = array(
                                    'id' => 'username ',
                                    'class' => 'form-control form-control-lg m-input m-input--solid'
                                )) 
                            }}
                            <span class="m-form__help m--font-danger">
                            </span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group m-form__group required">
                            {{ Form::label('email', 'Email', ['class' => '']) }}
                            {{ 
                                Form::text($name = 'email', $value = $email->email, 
                                $attributes = array(
                                    'id' => 'email',
                                    'class' => 'form-control form-control-lg m-input m-input--solid'
                                )) 
                            }}
                            <span class="m-form__help m--font-danger">
                            </span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group m-form__group required">
                            {{ Form::label('password', 'Password', ['class' => '']) }}
                            {{ 
                                Form::text($name = 'password', $value = $email->password, 
                                $attributes = array(
                                    'id' => 'password',
                                    'class' => 'form-control form-control-lg m-input m-input--solid'
                                )) 
                            }}
                            <span class="m-form__help m--font-danger">
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{ Form::close() }}