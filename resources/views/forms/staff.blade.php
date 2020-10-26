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
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="m-top-1 m-bottom-1">Contact Details Information</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            {{ Form::label('contact_fullname', 'Fullname', ['class' => '']) }}
                        </div>
                        <div class="col-md-9">
                            <div class="form-group m-form__group">
                                {{ 
                                    Form::text($name = 'contact_fullname', $value = !empty($staff) ? $staff->contact_fullname : '', 
                                    $attributes = array(
                                        'id' => 'contact_fullname',
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
                            {{ Form::label('contact_relation', 'Relation', ['class' => '']) }}
                        </div>
                        <div class="col-md-9">
                            <div class="form-group m-form__group">
                                {{ 
                                    Form::text($name = 'contact_relation', $value = !empty($staff) ? $staff->contact_relation : '', 
                                    $attributes = array(
                                        'id' => 'contact_relation',
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
                            {{ Form::label('contact_phone_no', 'Phone No.', ['class' => '']) }}
                        </div>
                        <div class="col-md-9">
                            <div class="form-group m-form__group">
                                {{ 
                                    Form::text($name = 'contact_phone_no', $value = !empty($staff) ? $staff->contact_phone_no : '', 
                                    $attributes = array(
                                        'id' => 'contact_phone_no',
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

            <!-- BENEFITS INFOS START -->
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="m-bottom-1">Benefits Information</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group m-form__group">
                                {{ Form::label('sss_no', 'SSS No.', ['class' => '']) }}
                                {{ 
                                    Form::text($name = 'sss_no', $value = !empty($staff) ? $staff->sss_no : '', 
                                    $attributes = array(
                                        'id' => 'sss_no',
                                        'class' => 'form-control form-control-lg m-input m-input--solid'
                                    )) 
                                }}
                                <span class="m-form__help m--font-danger">
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group m-form__group">
                                {{ Form::label('tin_no', 'TIN', ['class' => '']) }}
                                {{ 
                                    Form::text($name = 'tin_no', $value = !empty($staff) ? $staff->tin_no : '', 
                                    $attributes = array(
                                        'id' => 'tin_no',
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
                            <div class="form-group m-form__group">
                                {{ Form::label('pag_ibig_no', 'HDMF(Pag-ibig) No.', ['class' => '']) }}
                                {{ 
                                    Form::text($name = 'pag_ibig_no', $value = !empty($staff) ? $staff->pag_ibig_no : '', 
                                    $attributes = array(
                                        'id' => 'pag_ibig_no',
                                        'class' => 'form-control form-control-lg m-input m-input--solid'
                                    )) 
                                }}
                                <span class="m-form__help m--font-danger">
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group m-form__group">
                                {{ Form::label('philhealth_no', 'PhilHealth No', ['class' => '']) }}
                                {{ 
                                    Form::text($name = 'philhealth_no', $value = !empty($staff) ? $staff->philhealth_no : '', 
                                    $attributes = array(
                                        'id' => 'philhealth_no',
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
            <!-- BENEFITS INFOS END -->

            <!-- EDUCATIONAL BACKGROUND INFOS START -->
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="m-bottom-1">Educational Background Information</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group m-form__group">
                                {{ Form::label('elementary_graduated', 'Elementary School/Year Graduated', ['class' => '']) }}
                                {{ 
                                    Form::text($name = 'elementary_graduated', $value = !empty($staff) ? $staff->elementary_graduated : '', 
                                    $attributes = array(
                                        'id' => 'elementary_graduated',
                                        'class' => 'form-control form-control-lg m-input m-input--solid'
                                    )) 
                                }}
                                <span class="m-form__help m--font-danger">
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group m-form__group">
                                {{ Form::label('secondary_graduated', 'Secondary School/Year Graduated', ['class' => '']) }}
                                {{ 
                                    Form::text($name = 'secondary_graduated', $value = !empty($staff) ? $staff->secondary_graduated : '', 
                                    $attributes = array(
                                        'id' => 'secondary_graduated',
                                        'class' => 'form-control form-control-lg m-input m-input--solid'
                                    )) 
                                }}
                                <span class="m-form__help m--font-danger">
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group m-form__group">
                                {{ Form::label('tertiary_graduated', 'Tertiary School/Year Graduated', ['class' => '']) }}
                                {{ 
                                    Form::text($name = 'tertiary_graduated', $value = !empty($staff) ? $staff->tertiary_graduated : '', 
                                    $attributes = array(
                                        'id' => 'tertiary_graduated',
                                        'class' => 'form-control form-control-lg m-input m-input--solid'
                                    )) 
                                }}
                                <span class="m-form__help m--font-danger">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group m-form__group">
                                {{ Form::label('course_taken', 'Course/Major', ['class' => '']) }}
                                {{ 
                                    Form::text($name = 'course_taken', $value = !empty($staff) ? $staff->course_taken : '', 
                                    $attributes = array(
                                        'id' => 'course_taken',
                                        'class' => 'form-control form-control-lg m-input m-input--solid'
                                    )) 
                                }}
                                <span class="m-form__help m--font-danger">
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group m-form__group">
                                {{ Form::label('master_graduated', 'Masters Deg. Graduate School/Address', ['class' => '']) }}
                                {{ 
                                    Form::text($name = 'master_graduated', $value = !empty($staff) ? $staff->master_graduated : '', 
                                    $attributes = array(
                                        'id' => 'master_graduated',
                                        'class' => 'form-control form-control-lg m-input m-input--solid'
                                    )) 
                                }}
                                <span class="m-form__help m--font-danger">
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group m-form__group">
                                {{ Form::label('course_specialization', 'Course/Specialization', ['class' => '']) }}
                                {{ 
                                    Form::text($name = 'course_specialization', $value = !empty($staff) ? $staff->course_specialization : '', 
                                    $attributes = array(
                                        'id' => 'course_specialization',
                                        'class' => 'form-control form-control-lg m-input m-input--solid'
                                    )) 
                                }}
                                <span class="m-form__help m--font-danger">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group m-form__group">
                                {{ Form::label('graduate_school_status', 'Graduate School Status', ['class' => '']) }}
                                {{
                                    Form::select('graduate_school_status', $statuses, !empty($staff) ? $staff->graduate_school_status : '', ['class' => 'form-control form-control-lg m-input m-input--solid'])
                                }}
                                <span class="m-form__help m--font-danger">
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group m-form__group">
                                {{ Form::label('date_of_graduation', 'Date of Graduation', ['class' => '']) }}
                                {{ 
                                    Form::text($name = 'date_of_graduation', $value = !empty($staff) ? $staff->date_of_graduation : '', 
                                    $attributes = array(
                                        'id' => 'date_of_graduation',
                                        'class' => 'form-control form-control-lg m-input m-input--solid'
                                    )) 
                                }}
                                <span class="m-form__help m--font-danger">
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group m-form__group">
                                {{ Form::label('other_educational_attainment', 'Other Educational Attainment', ['class' => '']) }}
                                {{ 
                                    Form::text($name = 'other_educational_attainment', $value = !empty($staff) ? $staff->other_educational_attainment : '', 
                                    $attributes = array(
                                        'id' => 'other_educational_attainment',
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
                            <div class="form-group m-form__group">
                                {{ Form::label('government_examination', 'Government Examination Acquired (Government Exam-Major/PRC Number/Month Year Acquired)', ['class' => '']) }}
                                {{ 
                                    Form::text($name = 'government_examination', $value = !empty($staff) ? $staff->government_examination : '', 
                                    $attributes = array(
                                        'id' => 'government_examination',
                                        'class' => 'form-control form-control-lg m-input m-input--solid'
                                    )) 
                                }}
                                <span class="m-form__help m--font-danger">
                                </span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group m-form__group">
                                {{ Form::label('work_experience', 'Work Experience before HCCS (Year Of Service/Job Position/Company Name)', ['class' => '']) }}
                                {{ 
                                    Form::text($name = 'work_experience', $value = !empty($staff) ? $staff->work_experience : '', 
                                    $attributes = array(
                                        'id' => 'work_experience',
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
            <!-- EDUCATIONAL BACKGROUND INFOS END -->

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
                                    Form::select('type[]', $types, !empty($staff) ? $staff->type : '', ['id' => 'type', 'multiple' => 'multiple', 'class' => 'form-control form-control-lg m-input m-input--solid m-bootstrap-select m_selectpicker'])
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
                                {{ Form::label('designation', 'Position', ['class' => '']) }}
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
                                {{ Form::label('date_resigned', 'Date Resigned', ['class' => '']) }}
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
