@inject('staffs', 'App\Http\Controllers\StaffsController')
@if ( $segment == 'edit' )
    {{ Form::open(array('url' => 'memberships/staffs/update/'.$staff->id, 'name' => 'staff_form', 'method' => 'PUT')) }}
@else
    {{ Form::open(array('url' => 'memberships/staffs/store', 'name' => 'staff_form', 'method' => 'POST')) }}
@endif
    <div class="row">
        <div class="col-md-9">
            <!-- BASIC INFOS START -->
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="m-bottom-1">Basic Information</h5>
                        </div>
                    </div>
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
                        <div class="offset-md-6 col-md-6">
                            <div class="form-group m-form__group required">
                                {{ Form::label('identification_no', 'Staff Number', ['class' => '']) }}
                                {{ 
                                    Form::text($name = 'identification_no', $value = !empty($staff) ? $staff->identification_no : $staffs->generate_staff_no(), 
                                    $attributes = array(
                                        'id' => 'identification_no',
                                        'class' => 'bold form-control form-control-lg m-input m-input--solid'
                                    )) 
                                }}
                                <span class="m-form__help m--font-danger">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group m-form__group required">
                                {{ Form::label('firstname', 'Firstname', ['class' => '']) }}
                                {{ 
                                    Form::text($name = 'firstname', $value = !empty($staff) ? $staff->firstname : '', 
                                    $attributes = array(
                                        'id' => 'firstname',
                                        'class' => 'form-control form-control-lg m-input m-input--solid'
                                    )) 
                                }}
                                <span class="m-form__help m--font-danger">
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group m-form__group">
                                {{ Form::label('middlename', 'Middlename', ['class' => '']) }}
                                {{ 
                                    Form::text($name = 'middlename', $value = !empty($staff) ? $staff->middlename : '', 
                                    $attributes = array(
                                        'id' => 'middlename',
                                        'class' => 'form-control form-control-lg m-input m-input--solid'
                                    )) 
                                }}
                                <span class="m-form__help m--font-danger">
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group m-form__group required">
                                {{ Form::label('lastname', 'Lastname', ['class' => '']) }}
                                {{ 
                                    Form::text($name = 'lastname', $value = !empty($staff) ? $staff->lastname : '', 
                                    $attributes = array(
                                        'id' => 'lastname',
                                        'class' => 'form-control form-control-lg m-input m-input--solid'
                                    )) 
                                }}
                                <span class="m-form__help m--font-danger">
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group m-form__group">
                                {{ Form::label('suffix', 'Suffix', ['class' => '']) }}
                                {{ 
                                    Form::text($name = 'suffix', $value = !empty($staff) ? $staff->suffix : '', 
                                    $attributes = array(
                                        'id' => 'suffix',
                                        'class' => 'form-control form-control-lg m-input m-input--solid'
                                    )) 
                                }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group m-form__group required">
                                {{ Form::label('marital_status', 'Marital Status', ['class' => '']) }}
                                {{
                                    Form::select('marital_status', $civils, !empty($staff) ? $staff->marital_status : '', ['class' => 'form-control form-control-lg m-input m-input--solid'])
                                }}
                                <span class="m-form__help m--font-danger">
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group m-form__group required">
                                {{ Form::label('birthdate', 'Birth Date', ['class' => '']) }}
                                {{ 
                                    Form::date($name = 'birthdate', $value = !empty($staff) ? $staff->birthdate : '', 
                                    $attributes = array(
                                        'id' => 'birthdate',
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
                            <div class="m-form__group form-group required">
                                {{ Form::label('gender', 'Gender', ['class' => '']) }}
                                @if (!empty($staff))
                                    <div class="m-radio-inline">
                                        <label class="col-md-3 m-radio m-radio--solid">
                                            @if ($staff->gender == 'Male')
                                                {{ Form::radio('gender', 'Male', true) }}
                                            @else
                                                {{ Form::radio('gender', 'Male') }}
                                            @endif
                                            Male
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid">
                                            @if ($staff->gender == 'Female')
                                                {{ Form::radio('gender', 'Female', true) }}
                                            @else
                                                {{ Form::radio('gender', 'Female') }}
                                            @endif
                                            Female
                                            <span></span>
                                        </label>
                                    </div>
                                @else
                                    <div class="m-radio-inline">
                                        <label class="col-md-3 m-radio m-radio--solid">
                                            {{ Form::radio('gender', 'Male') }}
                                            Male
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid">
                                            {{ Form::radio('gender', 'Female') }}
                                            Female
                                            <span></span>
                                        </label>
                                    </div>
                                @endif
                                <span class="m-form__help m--font-danger">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- BASIC INFOS END -->
            
            <!-- OTHER INFOS START -->
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="m-bottom-1">Additional Information</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            {{ Form::label('current_address', 'Current Address', ['class' => '']) }}
                        </div>
                        <div class="col-md-9">
                            <div class="form-group m-form__group required">
                                {{ 
                                    Form::text($name = 'current_address', $value = !empty($staff) ? $staff->current_address : '', 
                                    $attributes = array(
                                        'id' => 'current_address',
                                        'class' => 'form-control form-control-lg m-input m-input--solid'
                                    )) 
                                }}
                                <span class="m-form__help m--font-danger">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            {{ Form::label('permanent_address', 'Permanent Address', ['class' => '']) }}
                        </div>
                        <div class="col-md-9">
                            <div class="form-group m-form__group">
                                {{ 
                                    Form::text($name = 'permanent_address', $value = !empty($staff) ? $staff->permanent_address : '', 
                                    $attributes = array(
                                        'id' => 'permanent_address',
                                        'class' => 'form-control form-control-lg m-input m-input--solid'
                                    )) 
                                }}
                                <span class="m-form__help m--font-danger">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            {{ Form::label('telephone_no', 'Telephone Number', ['class' => '']) }}
                        </div>
                        <div class="col-md-9">
                            <div class="form-group m-form__group">
                                {{ 
                                    Form::text($name = 'telephone_no', $value = !empty($staff) ? $staff->telephone_no : '', 
                                    $attributes = array(
                                        'id' => 'telephone_no',
                                        'class' => 'form-control form-control-lg m-input m-input--solid'
                                    )) 
                                }}
                                <span class="m-form__help m--font-danger">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            {{ Form::label('mobile_no', 'Mobile Number', ['class' => '']) }}
                        </div>
                        <div class="col-md-9">
                            <div class="form-group m-form__group">
                                {{ 
                                    Form::text($name = 'mobile_no', $value = !empty($staff) ? $staff->mobile_no : '', 
                                    $attributes = array(
                                        'id' => 'mobile_no',
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
            <!-- OTHER INFOS END -->

            <!-- ACCOUNT START -->
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="m-bottom-1">Account Information</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            {{ Form::label('email', 'Email Address', ['class' => '']) }}
                        </div>
                        <div class="col-md-9">
                            <div class="form-group m-form__group required">
                                {{ 
                                    Form::email($name = 'email', $value = !empty($staff) ? $staff->email : '', 
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
                        <div class="col-md-3">
                            {{ Form::label('username', 'Username', ['class' => '']) }}
                        </div>
                        <div class="col-md-9">
                            <div class="form-group m-form__group required">
                                {{ 
                                    Form::text($name = 'username', $value = !empty($staff) ? $staff->username : $staffs->generate_staff_no(), 
                                    $attributes = array(
                                        'id' => 'username',
                                        'class' => 'bold form-control form-control-lg m-input m-input--solid'
                                    )) 
                                }}
                                <span class="m-form__help m--font-danger">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            {{ Form::label('password', 'Password', ['class' => '']) }}
                        </div>
                        <div class="col-md-9">
                            <div class="form-group m-form__group required">
                                {{ 
                                    Form::text($name = 'password', $value = !empty($staff) ? $staff->password : '', 
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
            <!-- ACCOUNT END -->
        </div>
        <div class="col-md-3">
            <!-- AVATAR START -->
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="m-bottom-1">Photo</h5>
                        </div>
                        <div class="col-md-12">
                            <div class="avatar-upload">
                                <div class="avatar-edit">
                                    <input type="file" name="avatar" id="avatar" accept=".png, .jpg, .jpeg" />
                                    <label for="avatar"></label>
                                </div>
                                <div class="avatar-preview">
                                    @if (!empty($staff))
                                        @if ($staff->avatar!= '')
                                            <div class="avatar_preview" id="staffPreview" style="background-image: url({{ asset('images/staffs/'.$staff->identification_no.'/'.$staff->avatar) }})">
                                            </div>
                                        @else
                                            <div class="avatar_preview" id="staffPreview">
                                            </div>
                                        @endif
                                    @else
                                        <div class="avatar_preview" id="staffPreview">
                                        </div>
                                    @endif
                                </div>
                                <a href="#" class="btn btn-danger close-file {{ (!empty($staff) && $staff->avatar != '') ? '' : 'invisible' }}"><i class="fa fa-close"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- AVATAR END -->

            <!-- ROLES AND TYPE -->
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="m-bottom-1">Roles and Type</h5>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group m-form__group">
                                <label for="role">
                                    User Role
                                </label>
                                <select id="role_id" name="role_id" class="form-control form-control-lg m-input m-input--solid">
                                    <option value="3">Staff</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group m-form__group required">
                                {{ Form::label('type', 'Staff Type', ['class' => '']) }}
                                {{
                                    Form::select('type', $types, !empty($staff) ? $staff->type : '', ['class' => 'form-control form-control-lg m-input m-input--solid'])
                                }}
                                <span class="m-form__help m--font-danger">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ROLES AND TYPE END -->

            <!-- DEPARTMENTS & DEISGNATIONS -->
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="m-bottom-1">Departments & Designation</h5>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group m-form__group required">
                                {{ Form::label('department', 'Department', ['class' => '']) }}
                                {{
                                    Form::select('department_id', $departments, !empty($staff) ? $staff->department_id : '', ['class' => 'form-control form-control-lg m-input m-input--solid'])
                                }}
                                <span class="m-form__help m--font-danger">
                                </span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group m-form__group required">
                                {{ Form::label('designation', 'Designation', ['class' => '']) }}
                                {{
                                    Form::select('designation_id', $designations, !empty($staff) ? $staff->designation_id : '', ['class' => 'form-control form-control-lg m-input m-input--solid'])
                                }}
                                <span class="m-form__help m--font-danger">
                                </span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group m-form__group required">
                                {{ Form::label('specification', 'Specification', ['class' => '']) }}
                                {{
                                    Form::select('specification', $specifications, !empty($staff) ? $staff->specification : '', ['class' => 'form-control form-control-lg m-input m-input--solid'])
                                }}
                                <span class="m-form__help m--font-danger">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- DEPARTMENTS & DEISGNATIONS END -->
            
            <!-- HIRING DATE -->
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="m-bottom-1">Hiring Date</h5>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group m-form__group required">
                                {{ Form::label('date_joined', 'Date Joined', ['class' => '']) }}
                                {{ 
                                    Form::date($name = 'date_joined', $value = !empty($staff) ? $staff->date_joined : '', 
                                    $attributes = array(
                                        'id' => 'date_joined',
                                        'class' => 'form-control form-control-lg m-input m-input--solid'
                                    )) 
                                }}
                                <span class="m-form__help m--font-danger">
                                </span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group m-form__group">
                                {{ Form::label('date_resigned', 'Date Joined', ['class' => '']) }}
                                {{ 
                                    Form::date($name = 'date_resigned', $value = !empty($staff) ? $staff->date_resigned : '', 
                                    $attributes = array(
                                        'id' => 'date_resigned',
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
            <!-- HIRING DATE END -->
        </div>
    </div>
{{ Form::close() }}
