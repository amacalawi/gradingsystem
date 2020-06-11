@inject('students', 'App\Http\Controllers\StudentsController')
@if ( $segment == 'edit' )
    {{ Form::open(array('url' => 'memberships/students/update/'.$student->id, 'name' => 'student_form', 'method' => 'PUT')) }}
@else
    {{ Form::open(array('url' => 'memberships/students/store', 'name' => 'student_form', 'method' => 'POST')) }}
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
                                {{ Form::label('identification_no', 'Student Number', ['class' => '']) }}
                                {{ 
                                    Form::text($name = 'identification_no', $value = !empty($student) ? $student->identification_no : '', 
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
                                    Form::text($name = 'firstname', $value =!empty($student) ? $student->firstname : '', 
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
                                    Form::text($name = 'middlename', $value = !empty($student) ? $student->middlename : '', 
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
                                    Form::text($name = 'lastname', $value = !empty($student) ? $student->lastname : '', 
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
                                    Form::text($name = 'suffix', $value = !empty($student) ? $student->suffix : '', 
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
                                    Form::select('marital_status', $civils, !empty($student) ? $student->marital_status : '', ['class' => 'form-control form-control-lg m-input m-input--solid'])
                                }}
                                <span class="m-form__help m--font-danger">
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group m-form__group required">
                                {{ Form::label('birthdate', 'Birth Date', ['class' => '']) }}
                                {{ 
                                    Form::date($name = 'birthdate', $value = !empty($student) ? $student->birthdate : '', 
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
                                @if (!empty($student))
                                    <div class="m-radio-inline">
                                        <label class="col-md-3 m-radio m-radio--solid">
                                            @if ($student->gender == 'Male')
                                                {{ Form::radio('gender', 'Male', true) }}
                                            @else
                                                {{ Form::radio('gender', 'Male') }}
                                            @endif
                                            Male
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid">
                                            @if ($student->gender == 'Female')
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
                                    Form::text($name = 'current_address', $value = !empty($student) ? $student->current_address : '', 
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
                                    Form::text($name = 'permanent_address', $value = !empty($student) ? $student->permanent_address : '', 
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
                                    Form::text($name = 'telephone_no', $value = !empty($student) ? $student->telephone_no : '', 
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
                                    Form::text($name = 'mobile_no', $value = !empty($student) ? $student->mobile_no : '', 
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

            <!-- REMARKS START -->
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="m-bottom-1">Special Remarks</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            {{ 
                                Form::textarea($name = 'special_remarks', $value = !empty($student) ? $student->special_remarks : '', 
                                $attributes = array(
                                    'id' => 'special_remarks',
                                    'class' => 'form-control form-control-lg m-input m-input--solid',
                                    'rows' => 3
                                )) 
                            }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- REMARKS END -->

            <!-- GUARDIANS START -->
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="m-checkbox m-checkbox--solid" style="position: absolute;">
                                @if ($student->is_guardian > 0) 
                                    {{ Form::checkbox('is_guardian', '1', true, array('id' => 'parent-cell')) }}
                                @else
                                    {{ Form::checkbox('is_guardian', '1', false, array('id' => 'parent-cell')) }}
                                @endif
                                <span></span>
                            </label>    
                            <h5 id="parents-label" class="m-left-2">
                                Parents Guardians Detail
                            </h5>
                        </div>
                    </div>
                    <div id="parents-panel" class="{{ ($student->is_guardian > 0) ? '' : 'hidden' }}">
                        <div class="row">
                            <div class="col-md-12">
                                <h5>
                                    Mothers Information
                                </h5>
                            </div>
                        </div>
                        <div class="row parents-panel-layout">
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group m-form__group">
                                            {{ Form::label('mother_firstname', 'Firstname', ['class' => '']) }}
                                            {{ 
                                                Form::text($name = 'mother_firstname', $value = !empty($student) ? $student->mother_firstname : '', 
                                                $attributes = array(
                                                    'id' => 'mother_firstname',
                                                    'class' => 'form-control form-control-lg m-input m-input--solid'
                                                )) 
                                            }}
                                            <span class="m-form__help m--font-danger">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group m-form__group">
                                            {{ Form::label('mother_middlename', 'Middlename', ['class' => '']) }}
                                            {{ 
                                                Form::text($name = 'mother_middlename', $value = !empty($student) ? $student->mother_middlename : '', 
                                                $attributes = array(
                                                    'id' => 'mother_middlename',
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
                                            {{ Form::label('mother_lastname', 'Lastname', ['class' => '']) }}
                                            {{ 
                                                Form::text($name = 'mother_lastname', $value = !empty($student) ? $student->mother_lastname : '', 
                                                $attributes = array(
                                                    'id' => 'mother_lastname',
                                                    'class' => 'form-control form-control-lg m-input m-input--solid'
                                                )) 
                                            }}
                                            <span class="m-form__help m--font-danger">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group m-form__group">
                                            {{ Form::label('mother_contact_no', 'Contact Number', ['class' => '']) }}
                                            {{ 
                                                Form::text($name = 'mother_contact_no', $value = !empty($student) ? $student->mother_contact_no : '', 
                                                $attributes = array(
                                                    'id' => 'mother_contact_no',
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
                                            {{ Form::label('mother_email', 'Email', ['class' => '']) }}
                                            {{ 
                                                Form::email($name = 'mother_email', $value = !empty($student) ? $student->mother_email : '', 
                                                $attributes = array(
                                                    'id' => 'mother_email',
                                                    'class' => 'form-control form-control-lg m-input m-input--solid'
                                                )) 
                                            }}
                                            <span class="m-form__help m--font-danger">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="avatar-upload m--margin-top-10">
                                    <div class="avatar-edit">
                                        <input type="file" name="mother_avatar" id="mother_avatar" accept=".png, .jpg, .jpeg" />
                                        <label for="mother_avatar"></label>
                                    </div>
                                    <div class="avatar-preview">
                                        @if (!empty($student))
                                            @if ($student->mother_avatar!= '')
                                                <div class="avatar_preview" id="motherPreview" style="background-image: url({{ asset('images/students/'.$student->identification_no.'/'.$student->mother_avatar) }})">
                                                </div>
                                            @else
                                                <div class="avatar_preview" id="motherPreview">
                                                </div>
                                            @endif
                                        @else
                                            <div class="avatar_preview" id="motherPreview">
                                            </div>
                                        @endif
                                    </div>
                                    <a href="#" class="btn btn-danger close-file {{ (!empty($student) && $student->mother_avatar != '') ? '' : 'invisible' }}"><i class="fa fa-close"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h5>
                                    Fathers Information
                                </h5>
                            </div>
                        </div>
                        <div class="row parents-panel-layout">
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group m-form__group">
                                            {{ Form::label('father_firstname', 'Firstname', ['class' => '']) }}
                                            {{ 
                                                Form::text($name = 'father_firstname', $value = !empty($student) ? $student->father_firstname : '', 
                                                $attributes = array(
                                                    'id' => 'father_firstname',
                                                    'class' => 'form-control form-control-lg m-input m-input--solid'
                                                )) 
                                            }}
                                            <span class="m-form__help m--font-danger">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group m-form__group">
                                            {{ Form::label('father_middlename', 'Middlename', ['class' => '']) }}
                                            {{ 
                                                Form::text($name = 'father_middlename', $value = !empty($student) ? $student->father_middlename : '', 
                                                $attributes = array(
                                                    'id' => 'father_middlename',
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
                                            {{ Form::label('father_lastname', 'Lastname', ['class' => '']) }}
                                            {{ 
                                                Form::text($name = 'father_lastname', $value = !empty($student) ? $student->father_lastname : '', 
                                                $attributes = array(
                                                    'id' => 'father_lastname',
                                                    'class' => 'form-control form-control-lg m-input m-input--solid'
                                                )) 
                                            }}
                                            <span class="m-form__help m--font-danger">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group m-form__group">
                                            {{ Form::label('father_contact_no', 'Contact Number', ['class' => '']) }}
                                            {{ 
                                                Form::text($name = 'father_contact_no', $value = !empty($student) ? $student->father_contact_no : '', 
                                                $attributes = array(
                                                    'id' => 'father_contact_no',
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
                                            {{ Form::label('father_email', 'Email', ['class' => '']) }}
                                            {{ 
                                                Form::email($name = 'father_email', $value = !empty($student) ? $student->father_email : '', 
                                                $attributes = array(
                                                    'id' => 'father_email',
                                                    'class' => 'form-control form-control-lg m-input m-input--solid'
                                                )) 
                                            }}
                                            <span class="m-form__help m--font-danger">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="avatar-upload m--margin-top-10">
                                    <div class="avatar-edit">
                                        <input type="file" name="father_avatar" id="father_avatar" accept=".png, .jpg, .jpeg" />
                                        <label for="father_avatar"></label>
                                    </div>
                                    <div class="avatar-preview">
                                        @if (!empty($student))
                                            @if ($student->father_avatar!= '')
                                                <div class="avatar_preview" id="fatherPreview" style="background-image: url({{ asset('images/students/'.$student->identification_no.'/'.$student->father_avatar) }})">
                                                </div>
                                            @else
                                                <div class="avatar_preview" id="fatherPreview">
                                                </div>
                                            @endif
                                        @else
                                            <div class="avatar_preview" id="fatherPreview">
                                            </div>
                                        @endif
                                    </div>
                                    <a href="#" class="btn btn-danger close-file {{ (!empty($student) && $student->father_avatar != '') ? '' : 'invisible' }}"><i class="fa fa-close"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="m-form__group form-group">
                                    {{ Form::label('guardian_selected', 'Set Guardian As', ['class' => '']) }}
                                    <div class="m-radio-inline">
                                        <label class="col-md-3 m-radio m-radio--solid">
                                            @if ($student->mother_selected == 1)
                                                {{ Form::radio('guardian_selected', 'Mother', true) }}
                                            @else
                                                {{ Form::radio('guardian_selected', 'Mother') }}
                                            @endif
                                            Mother
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid">
                                            @if ($student->father_selected == 1)
                                                {{ Form::radio('guardian_selected', 'Father', true) }}
                                            @else
                                                {{ Form::radio('guardian_selected', 'Father') }}
                                            @endif
                                            Father
                                            <span></span>
                                        </label>
                                    </div>
                                    <span class="m-form__help m--font-danger">
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- GUARDIANS END -->

            <!-- SIBLINGS START -->
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="m-checkbox m-checkbox--solid" style="position: absolute;">
                                @if ($student->is_sibling > 0) 
                                    {{ Form::checkbox('is_sibling', '1', true, array('id' => 'sibling-cell')) }}
                                @else
                                    {{ Form::checkbox('is_sibling', '1', false, array('id' => 'sibling-cell')) }}
                                @endif
                                <span></span>
                            </label>    
                            <h5 id="siblings-label" class="m-left-2">
                                Siblings Detail
                            </h5>
                        </div>
                    </div>
                    <div id="siblings-panel" class="{{ ($student->is_sibling > 0) ? '' : 'hidden' }}">
                        @if (!empty($student->siblings))
                            @php $i = 1; @endphp
                            @foreach ($student->siblings as $sibling)
                                <div class="row">
                                    <div class="col-md-11">
                                        <div class="form-group m-form__group">
                                            {{ 
                                                Form::text($name = 'sibling[]', $value = 
                                                $students->get_column_via_id($sibling->sibling_id, 'identification_no') . 
                                                ' - ' . ucfirst($students->get_column_via_id($sibling->sibling_id, 'lastname')) .
                                                ', ' . ucfirst($students->get_column_via_id($sibling->sibling_id, 'firstname')) .
                                                ' ' . ucfirst($students->get_column_via_id($sibling->sibling_id, 'middlename')[0]) . '.'
                                                , 
                                                $attributes = array(
                                                    'class' => 'full-width typeahead sibling form-control form-control-lg m-input m-input--solid',
                                                    'placeholder' => 'search for student number, firstname or lastname'
                                                )) 
                                            }}
                                            <span class="m-form__help m--font-danger"></span>
                                        </div>
                                    </div>
                                    @if ($i > 1)
                                    <div class="col-md-1">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="button" class="minus-sibling btn"><i class="la la-minus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            @php $i++; @endphp
                            @endforeach
                        @else
                            <div class="row">
                                <div class="col-md-11">
                                    <div class="form-group m-form__group">
                                        {{ 
                                            Form::text($name = 'sibling[]', $value = '', 
                                            $attributes = array(
                                                'class' => 'full-width typeahead sibling form-control form-control-lg m-input m-input--solid',
                                                'placeholder' => 'search for student number, firstname or lastname'
                                            )) 
                                        }}
                                        <span class="m-form__help m--font-danger"></span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div id="siblings-panel-button" class="row m-bottom-1 {{ ($student->is_sibling > 0) ? '' : 'hidden' }}">
                        <div class="col-md-12">
                            <button id="add-sibling" type="button" class="btn btn-brand">
                                <i class="la la-plus"></i>&nbsp;Add Sibling
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- SIBLINGS END -->

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
                                    Form::email($name = 'email', $value = !empty($student) ? $student->email : '', 
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
                                    Form::text($name = 'username', $value = $student->username ? $student->username : '', 
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
                                    Form::text($name = 'password', $value = !empty($student) ? $student->password : '', 
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
                                    @if (!empty($student))
                                        @if ($student->avatar!= '')
                                            <div class="avatar_preview" id="studentPreview" style="background-image: url({{ asset('images/students/'.$student->identification_no.'/'.$student->avatar) }})">
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
                                <a href="#" class="btn btn-danger close-file {{ (!empty($student) && $student->avatar != '') ? '' : 'invisible' }}"><i class="fa fa-close"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- AVATAR END -->

            <!-- ROLE START -->
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="m-bottom-1">Roles and Type</h5>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group m-form__group">
                                <label for="exampleSelect1">
                                    Default Role
                                </label>
                                <select id="role_id" name="role_id" class="form-control form-control-lg m-input m-input--solid">
                                    <option value="4">Student</option>
                                </select>
                                <span class="m-form__help m--font-danger">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ROLE END -->
            
            <!-- ADMISSION START -->
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="m-bottom-1">Admission Date</h5>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group m-form__group required">
                                {{ Form::label('admitted_date', 'Date Admitted', ['class' => '']) }}
                                {{ 
                                    Form::date($name = 'admitted_date', $value = $student->admitted_date ? $student->admitted_date : '', 
                                    $attributes = array(
                                        'id' => 'admitted_date',
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
            <!-- ADMISSION END -->
        </div>
    </div>
{{ Form::close() }}