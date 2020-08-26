@if ( $segment == 'edit' )
    {{ Form::open(array('url' => 'memberships/users/accounts/update/'.$user->id, 'name' => 'user_account_form', 'method' => 'PUT')) }}
@else
    {{ Form::open(array('url' => 'memberships/users/accounts/store', 'name' => 'user_account_form', 'method' => 'POST')) }}
@endif
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
        <div class="col-md-4">
            <div class="form-group m-form__group required">
                {{ Form::label('name', 'Fullname', ['class' => '']) }}
                {{ 
                    Form::text($name = 'name', $value = $user->name, 
                    $attributes = array(
                        'id' => 'name',
                        'class' => 'form-control form-control-lg m-input m-input--solid'
                    )) 
                }}
                <span class="m-form__help m--font-danger">
                </span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group m-form__group required">
                {{ Form::label('email', 'Email', ['class' => '']) }}
                {{ 
                    Form::text($name = 'email', $value = $user->email, 
                    $attributes = array(
                        'id' => 'email',
                        'type' => 'email',
                        'class' => 'form-control form-control-lg m-input m-input--solid'
                    )) 
                }}
                <span class="m-form__help m--font-danger">
                </span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group m-form__group required">
                {{ Form::label('role_id', 'Role', ['class' => '']) }}
                {{
                    Form::select('role_id', $roles, $value = $user->role_id, ['class' => 'select2 form-control form-control-lg m-input m-input--solid'])
                }}
                <span class="m-form__help m--font-danger">
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group m-form__group required">
                {{ Form::label('username', 'Username', ['class' => '']) }}
                {{ 
                    Form::text($name = 'username', $value = !empty($user) ? $user->username : '', 
                    $attributes = array(
                        'id' => 'username',
                        'class' => 'form-control form-control-lg m-input m-input--solid'
                    )) 
                }}
                <span class="m-form__help m--font-danger">
                </span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group m-form__group required">
                {{ Form::label('password', 'Password', ['class' => '']) }}
                {{ 
                    Form::text($name = 'password', $value = !empty($user) ? $user->password : '', 
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
    <div class="row">
        <div class="col-md-6">
            <div class="form-group m-form__group required">
                {{ Form::label('secret_question_id', 'Secret Question', ['class' => '']) }}
                {{
                    Form::select('secret_question_id', $secrets, $value = $user->secret_question_id, ['class' => 'select2 form-control form-control-lg m-input m-input--solid'])
                }}
                <span class="m-form__help m--font-danger">
                </span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group m-form__group required">
                {{ Form::label('secret_password', 'Secret Password', ['class' => '']) }}
                {{ 
                    Form::text($name = 'secret_password', $value = !empty($user) ? $user->secret_password : '', 
                    $attributes = array(
                        'id' => 'secret_password',
                        'class' => 'form-control form-control-lg m-input m-input--solid'
                    )) 
                }}
                <span class="m-form__help m--font-danger">
                </span>
            </div>
        </div>
    </div>
{{ Form::close() }}