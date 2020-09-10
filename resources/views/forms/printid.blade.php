@if ( $segment == 'edit' )
    {{ Form::open(array('url' => 'academics/academics/sections/update/', 'name' => 'section_form', 'method' => 'PUT')) }}
@else
    {{ Form::open(array('url' => 'academics/academics/sections/store', 'name' => 'section_form', 'method' => 'POST')) }}
@endif

    <div class="row">
        <div class="col-md-8">
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group m-form__group required">
                                {{ Form::label('user_id', 'Search', ['class' => '']) }}
                                {{
                                    Form::select('user_id', $users, $value = '', ['class' => 'select2 form-control form-control-lg m-input m-input--solid'])
                                }}
                                <span class="m-form__help m--font-danger">
                                </span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__body">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="w-100 h-100"  id="" >
                                {{--<input type="image" src="{{ public_('img/thumbs-up.png') }}" alt="Submit" width="48" height="48">--}}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 ">
                            <button type="button" id="print-btn" name="print-btn" class="btn btn-md btn-info w-100"> Preview and Print </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__body" id="basic_info_prt">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="m-bottom-1">Basic Information</h5>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {{ Form::label('idno', 'Identification Number', ['class' => '']) }}
                            {{ 
                                Form::text($name = 'idno', $value = '', 
                                $attributes = array(
                                    'id' => 'idno',
                                    'class' => 'form-control form-control-lg m-input m-input--solid'
                                )) 
                            }}
                        </div>
                        <div class="col-md-6">
                            {{ Form::label('barcode', 'Barcode', ['class' => '']) }}
                            {{ 
                                Form::text($name = 'barcode', $value = '', 
                                $attributes = array(
                                    'id' => 'barcode',
                                    'class' => 'form-control form-control-lg m-input m-input--solid'
                                )) 
                            }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            {{ Form::label('firstname', 'Firstname', ['class' => '']) }}
                            {{ 
                                Form::text($name = 'firstname', $value = '', 
                                $attributes = array(
                                    'id' => 'firstname',
                                    'class' => 'form-control form-control-lg m-input m-input--solid'
                                )) 
                            }}
                        </div>
                        <div class="col-md-4">
                            {{ Form::label('middlename', 'Middlename', ['class' => '']) }}
                            {{ 
                                Form::text($name = 'middlename', $value = '', 
                                $attributes = array(
                                    'id' => 'middlename',
                                    'class' => 'form-control form-control-lg m-input m-input--solid'
                                )) 
                            }}
                        </div>
                        <div class="col-md-4">
                            {{ Form::label('lastname', 'Lastname', ['class' => '']) }}
                            {{ 
                                Form::text($name = 'lastname', $value = '', 
                                $attributes = array(
                                    'id' => 'lastname',
                                    'class' => 'form-control form-control-lg m-input m-input--solid'
                                )) 
                            }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            {{ Form::label('gender', 'Gender', ['class' => '']) }}
                            {{ 
                                Form::text($name = 'gender', $value = '', 
                                $attributes = array(
                                    'id' => 'gender',
                                    'class' => 'form-control form-control-lg m-input m-input--solid'
                                )) 
                            }}
                        </div>
                        <div class="col-md-4">
                            {{ Form::label('level', 'Level', ['class' => '']) }}
                            {{ 
                                Form::text($name = 'level', $value = '', 
                                $attributes = array(
                                    'id' => 'level',
                                    'class' => 'form-control form-control-lg m-input m-input--solid'
                                )) 
                            }}
                        </div>
                        <div class="col-md-4">
                            {{ Form::label('section', 'Section', ['class' => '']) }}
                            {{ 
                                Form::text($name = 'section', $value = '', 
                                $attributes = array(
                                    'id' => 'section',
                                    'class' => 'form-control form-control-lg m-input m-input--solid'
                                )) 
                            }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {{ Form::label('guardian', 'Guardian', ['class' => '']) }}
                            {{ 
                                Form::text($name = 'guardian', $value = '', 
                                $attributes = array(
                                    'id' => 'guardian',
                                    'class' => 'form-control form-control-lg m-input m-input--solid'
                                )) 
                            }}
                        </div>
                        <div class="col-md-6">
                            {{ Form::label('contact_number', 'Contact number', ['class' => '']) }}
                            {{ 
                                Form::text($name = 'contact_number', $value = '', 
                                $attributes = array(
                                    'id' => 'contact_number',
                                    'class' => 'form-control form-control-lg m-input m-input--solid'
                                )) 
                            }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            {{ Form::label('address', 'Address', ['class' => '']) }}
                            {{ 
                                Form::text($name = 'address', $value = '', 
                                $attributes = array(
                                    'id' => 'address',
                                    'class' => 'form-control form-control-lg m-input m-input--solid'
                                )) 
                            }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__body">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="w-100 h-100"  id="photoid" style="padding:150px; background-color: lightgrey; height:200px; background-image: url({{ asset('img/idphoto/default.png') }}); background-repeat: no-repeat; background-size: 100% 100%;" >
                                {{-- 
                                    Form::text($name = 'avatar', $value = '', 
                                    $attributes = array(
                                        'id' => 'avatar',
                                        'class' => 'form-control form-control-lg m-input m-input--solid'
                                    ))
                                --}}
                                {{--<input type="image" src="{{ asset('img/idphoto/default.png') }}" id="avatar_image" name="avatar_image" class="w-100 h-80">--}}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>                

{{ Form::close() }}