{{ Form::open(array('url' => 'settings/update', 'name' => 'setting_form', 'method' => 'POST')) }}
<div class="row">
    <div class="col-md-9">
        <!-- BASIC INFOS START -->
        <div class="m-portlet m-portlet--tab">
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-md-12 hidden">
                        {{ 
                            Form::text($name = 'method', $value = !empty($settings) ? 'edit' : 'add', 
                            $attributes = array(
                                'id' => 'method',
                                'class' => 'form-control form-control-lg m-input m-input--solid'
                            )) 
                        }}
                    </div>
                    <div class="col-md-12 hidden">
                        {{ 
                            Form::text($name = 'id', $value = !empty($settings) ? $settings->id : '', 
                            $attributes = array(
                                'id' => 'id',
                                'class' => 'form-control form-control-lg m-input m-input--solid'
                            )) 
                        }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group m-form__group required">
                            {{ Form::label('name', 'Organization Name', ['class' => '']) }}
                            {{ 
                                Form::text($name = 'name', $value = $settings->name, 
                                $attributes = array(
                                    'id' => 'name',
                                    'class' => 'form-control form-control-lg m-input m-input--solid'
                                )) 
                            }}
                            <span class="m-form__help m--font-danger">
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group m-form__group required">
                            {{ Form::label('name', 'Email Address', ['class' => '']) }}
                            {{ 
                                Form::email($name = 'email', $value = $settings->email, 
                                $attributes = array(
                                    'id' => 'email',
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
                            {{ Form::label('name', 'Contact No', ['class' => '']) }}
                            {{ 
                                Form::text($name = 'phone', $value = $settings->phone, 
                                $attributes = array(
                                    'id' => 'phone',
                                    'class' => 'form-control form-control-lg m-input m-input--solid'
                                )) 
                            }}
                            <span class="m-form__help m--font-danger">
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group m-form__group required">
                            {{ Form::label('name', 'Fax No', ['class' => '']) }}
                            {{ 
                                Form::text($name = 'fax', $value = $settings->fax, 
                                $attributes = array(
                                    'id' => 'fax',
                                    'class' => 'form-control form-control-lg m-input m-input--solid'
                                )) 
                            }}
                            <span class="m-form__help m--font-danger">
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group m-form__group required">
                            {{ Form::label('location', 'Location', ['class' => '']) }}
                            {{ 
                                Form::textarea($name = 'location', $value = $settings->location, 
                                $attributes = array(
                                    'id' => 'location',
                                    'class' => 'form-control form-control-lg m-input m-input--solid',
                                    'rows' => 3
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
    <div class="col-md-3">
        <!-- AVATAR START -->
        <div class="m-portlet m-portlet--tab">
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="m-bottom-1">Logo</h5>
                    </div>
                    <div class="col-md-12">
                        <div class="avatar-upload">
                            <div class="avatar-edit">
                                <input type="file" name="avatar" id="avatar" accept=".png, .jpg, .jpeg" />
                                <label for="avatar"></label>
                            </div>
                            <div class="avatar-preview">
                                @if (!empty($settings))
                                    @if ($settings->avatar!= '')
                                        <div class="avatar_preview" id="studentPreview" style="background-image: url('./images/settings/{{ $settings->avatar }}');">
                                        </div>
                                    @else
                                        <div class="avatar_preview" id="studentPreview">
                                        </div>
                                    @endif
                                @else
                                    <div class="avatar_preview" id="studentPreview">
                                    </div>
                                @endif
                            </div>
                            <a href="#" class="btn btn-danger close-file {{ (!empty($settings) && $settings->avatar != '') ? '' : 'invisible' }}"><i class="fa fa-close"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- AVATAR END -->
    </div>
</div>
{{ Form::close() }}