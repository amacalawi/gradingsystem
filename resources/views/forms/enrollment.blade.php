<div class="row" id="enrollment-layer" style="overflow:hidden">
    <div id="forms" class="m--margin-top-40 offset-md-1 col-md-10">
        <div class="m-portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Enrollment Form
                            <small>
                            </small>
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="#" data-toggle="m-tooltip" class="m-portlet__nav-link m-portlet__nav-link--icon" data-direction="left" data-width="auto" title="Get help with filling up this form">
                                <i class="flaticon-info m--icon-font-size-lg3"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="m-wizard m-wizard--1 m-wizard--success" id="m_wizard">
                <div class="m-portlet__padding-x">
                </div>
                <div class="m-wizard__head m-portlet__padding-x">
                    <div class="m-wizard__progress">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="m-wizard__nav">
                        <div class="m-wizard__steps">
                            <div class="m-wizard__step m-wizard__step--current" data-wizard-target="#m_wizard_form_step_1">
                                <div class="m-wizard__step-info">
                                    <a href="#" class="m-wizard__step-number">
                                        <span>
                                            <span>
                                                1
                                            </span>
                                        </span>
                                    </a>
                                    <div class="m-wizard__step-line">
                                        <span></span>
                                    </div>
                                    <div class="m-wizard__step-label">
                                        Student Details
                                    </div>
                                </div>
                            </div>
                            <div class="m-wizard__step" data-wizard-target="#m_wizard_form_step_2">
                                <div class="m-wizard__step-info">
                                    <a href="#" class="m-wizard__step-number">
                                        <span>
                                            <span>
                                                2
                                            </span>
                                        </span>
                                    </a>
                                    <div class="m-wizard__step-line">
                                        <span></span>
                                    </div>
                                    <div class="m-wizard__step-label">
                                        General Information
                                    </div>
                                </div>
                            </div>
                            <div class="m-wizard__step" data-wizard-target="#m_wizard_form_step_3">
                                <div class="m-wizard__step-info">
                                    <a href="#" class="m-wizard__step-number">
                                        <span>
                                            <span>
                                                3
                                            </span>
                                        </span>
                                    </a>
                                    <div class="m-wizard__step-line">
                                        <span></span>
                                    </div>
                                    <div class="m-wizard__step-label">
                                        Household Capacity and Access to Distance Learning
                                    </div>
                                </div>
                            </div>
                            <div class="m-wizard__step" data-wizard-target="#m_wizard_form_step_4">
                                <div class="m-wizard__step-info">
                                    <a href="#" class="m-wizard__step-number">
                                        <span>
                                            <span>
                                                4
                                            </span>
                                        </span>
                                    </a>
                                    <div class="m-wizard__step-line">
                                        <span></span>
                                    </div>
                                    <div class="m-wizard__step-label">
                                        Certification of Information
                                    </div>
                                </div>
                            </div>
                            <div class="m-wizard__step" data-wizard-target="#m_wizard_form_step_5">
                                <div class="m-wizard__step-info">
                                    <a href="#" class="m-wizard__step-number">
                                        <span>
                                            <span>
                                                5
                                            </span>
                                        </span>
                                    </a>
                                    <div class="m-wizard__step-line">
                                        <span></span>
                                    </div>
                                    <div class="m-wizard__step-label">
                                        Billing Information
                                    </div>
                                </div>
                            </div>
                            <div class="m-wizard__step" data-wizard-target="#m_wizard_form_step_6">
                                <div class="m-wizard__step-info">
                                    <a href="#" class="m-wizard__step-number">
                                        <span>
                                            <span>
                                                6
                                            </span>
                                        </span>
                                    </a>
                                    <div class="m-wizard__step-line">
                                        <span></span>
                                    </div>
                                    <div class="m-wizard__step-label">
                                        Acknowledgement &amp; Confirmation
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="m-wizard__form">
                @if ( !empty($enroll) )
                    {{ Form::open(array('url' => 'academics/admissions/enrollments/update/'.$enroll->id, 'class' => 'm-form m-form--label-align-left- m-form--state-', 'id' => 'm_form', 'name' => 'enrollment_form', 'method' => 'PUT')) }}
                @else
                    {{ Form::open(array('url' => 'enrollment/store', 'class' => 'm-form m-form--label-align-left- m-form--state-', 'id' => 'm_form', 'name' => 'enrollment_form', 'method' => 'POST')) }}
                @endif
                        <div class="m-portlet__body">
                            <div class="m-wizard__form-step m-wizard__form-step--current" id="m_wizard_form_step_1">
                                <div class="row">
                                    <div class="col-xl-8 offset-xl-2">
                                        <div class="m-form__section m-form__section--first">
                                            <div class="m-form__heading">
                                                <h3 class="m-form__heading-title">
                                                    Student Details
                                                </h3>
                                                <div class="row hidden">
                                                    <div class="col-md-12">
                                                        {{ 
                                                            Form::text($name = 'method', $value = !empty($enroll) ? 'edit' : 'add', 
                                                            $attributes = array(
                                                                'id' => 'method',
                                                                'class' => 'form-control form-control-lg m-input m-input--solid'
                                                            )) 
                                                        }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">
                                                    * Email:
                                                </label>
                                                <div class="col-xl-9 col-lg-9">
                                                    {{ 
                                                        Form::email($name = 'student_email', $value = !empty($enroll) ? $enroll->student_email : '', 
                                                        $attributes = array(
                                                            'id' => 'student_email',
                                                            'class' => 'form-control form-control-lg m-input m-input--solid'
                                                        )) 
                                                    }}
                                                    <span class="m-form__help">
                                                        Please enter student email
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">
                                                    * Was the student new?
                                                </label>
                                                <div class="col-xl-9 col-lg-9">
                                                    <div class="m-radio-inline">
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll))
                                                                @if ($enroll->is_new > 0) 
                                                                    {{ Form::radio('is_new', '1', true, array('')) }}
                                                                @else   
                                                                    {{ Form::radio('is_new', '1', false, array('')) }}
                                                                @endif
                                                            @else
                                                                {{ Form::radio('is_new', '1', false, array('')) }}
                                                            @endif
                                                            Yes
                                                            <span></span>
                                                        </label>   
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll))
                                                                @if ($enroll->is_new > 0) 
                                                                    {{ Form::radio('is_new', '0', false, array('')) }}
                                                                @else
                                                                    {{ Form::radio('is_new', '0', true, array('')) }}
                                                                @endif
                                                            @else
                                                                {{ Form::radio('is_new', '0', false, array('')) }}
                                                            @endif
                                                            No
                                                            <span></span>
                                                        </label>  
                                                    </div>
                                                    <span class="m-form__help">
                                                        Please select yes if new student otherwise no if return student
                                                    </span>
                                                </div>
                                            </div>
                                            <div id="student-row" class="{{ !empty($enroll) ? ($enroll->is_new > 0) ? 'hidden' : '' : 'hidden'  }} form-group m-form__group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">
                                                    * Student No:
                                                </label>
                                                <div class="col-xl-9 col-lg-9">
                                                    <div class="row">
                                                        <div class="col-xl-8">
                                                            @if (!empty($enroll) && $enroll->is_new > 0) 
                                                                {{ 
                                                                    Form::text($name = 'student_number', $value = !empty($enroll) ? $enroll->student_no : '', 
                                                                    $attributes = array(
                                                                        'id' => 'student_number',
                                                                        'class' => 'hidden form-control form-control-lg m-input m-input--solid'
                                                                    )) 
                                                                }}
                                                            @else
                                                                {{ 
                                                                    Form::text($name = 'student_number', $value = !empty($enroll) ? $enroll->student_no : '', 
                                                                    $attributes = array(
                                                                        'id' => 'student_number',
                                                                        'class' => 'form-control form-control-lg m-input m-input--solid'
                                                                    )) 
                                                                }}
                                                            @endif
                                                            <span class="m-form__help">
                                                                Please enter student number
                                                            </span>
                                                        </div>
                                                        <div class="col-xl-4">
                                                        <button id="search-student-btn" type="button" class="full-width btn-lg btn btn-secondary">
                                                            <i class="la la-search"></i>&nbsp;Search
                                                        </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">
                                                    * Learner's Reference Number (LRN must be 12 digits)
                                                </label>
                                                <div class="col-xl-9 col-lg-9">
                                                    {{ 
                                                        Form::text($name = 'lrn_no', $value = !empty($enroll) ? $enroll->student_lrn : '', 
                                                        $attributes = array(
                                                            'id' => 'lrn_no',
                                                            'class' => 'form-control form-control-lg m-input m-input--solid'
                                                        )) 
                                                    }}
                                                    <span class="m-form__help">
                                                        Please enter LRN format. E.g: 123456789010
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">
                                                    PSA Birth Certificate No. (if available upon enrolment)
                                                </label>
                                                <div class="col-xl-9 col-lg-9">
                                                    {{ 
                                                        Form::text($name = 'psa_no', $value = !empty($enroll) ? $enroll->student_psa_no : '', 
                                                        $attributes = array(
                                                            'id' => 'psa_no',
                                                            'class' => 'form-control form-control-lg m-input m-input--solid'
                                                        )) 
                                                    }}
                                                    <span class="m-form__help">
                                                        Please enter PSA Birth Certificate No
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">
                                                    * Grade Level
                                                </label>
                                                <div class="col-xl-9 col-lg-9">
                                                    {{
                                                        Form::select('grade_level', $levels, !empty($enroll) ? $enroll->level_id : '', ['id' => 'grade_level', 'data-live-search' => 'true', 'class' => 'form-control form-control-lg m-input m-input--solid m-bootstrap-select m_selectpicker'])
                                                    }}
                                                    <span class="m-form__help">
                                                        Please select the grade level to enroll
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="m-wizard__form-step" id="m_wizard_form_step_2">
                                <div class="row">
                                    <div class="col-xl-8 offset-xl-2">
                                        <div class="m-form__section m-form__section--first">
                                            <div class="m-form__heading">
                                                <h3 class="m-form__heading-title">
                                                    Other Details
                                                </h3>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-4 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Student's Firstname:
                                                    </label>
                                                    {{ 
                                                        Form::text($name = 'student_firstname', $value = !empty($enroll) ? $enroll->student_firstname : '', 
                                                        $attributes = array(
                                                            'id' => 'student_firstname',
                                                            'class' => 'form-control form-control-lg m-input m-input--solid'
                                                        )) 
                                                    }}
                                                    <span class="m-form__help">
                                                        Please enter student's firstname
                                                    </span>
                                                </div>
                                                <div class="col-lg-4 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        Student's Middlename:
                                                    </label>
                                                    {{ 
                                                        Form::text($name = 'student_middlename', $value = !empty($enroll) ? $enroll->student_middlename : '', 
                                                        $attributes = array(
                                                            'id' => 'student_middlename',
                                                            'class' => 'form-control form-control-lg m-input m-input--solid'
                                                        )) 
                                                    }}
                                                    <span class="m-form__help">
                                                        Please enter student's middlename
                                                    </span>
                                                </div>
                                                <div class="col-lg-4 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Student's Lastname:
                                                    </label>
                                                    {{ 
                                                        Form::text($name = 'student_lastname', $value = !empty($enroll) ? $enroll->student_lastname : '', 
                                                        $attributes = array(
                                                            'id' => 'student_lastname',
                                                            'class' => 'form-control form-control-lg m-input m-input--solid'
                                                        )) 
                                                    }}
                                                    <span class="m-form__help">
                                                        Please enter student's lastname
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-4 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Student's Birthdate:
                                                    </label>
                                                    {{ 
                                                        Form::date($name = 'student_birthdate', $value = !empty($enroll) ? $enroll->student_birthdate : '', 
                                                        $attributes = array(
                                                            'id' => 'student_birthdate',
                                                            'class' => 'form-control form-control-lg m-input m-input--solid'
                                                        )) 
                                                    }}
                                                    <span class="m-form__help">
                                                        Please enter student's birthdate
                                                    </span>
                                                </div>
                                                <div class="col-lg-4 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Student's Age:
                                                    </label>
                                                    <input id="student_age" class="form-control form-control-lg m-input m-input--solid " name="student_age" type="text" value="">
                                                    <span class="m-form__help">
                                                        Please enter student's age
                                                    </span>
                                                </div>
                                                <div class="col-lg-4 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Student's Gender:
                                                    </label>
                                                    <div class="m-radio-inline m--margin-top-15 m--margin-bottom-13">
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->student_gender == 'Male') 
                                                                {{ Form::radio('student_gender', 'Male', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('student_gender', 'Male', false, array('')) }}
                                                            @endif
                                                            Male
                                                            <span></span>
                                                        </label>   
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->student_gender == 'Female') 
                                                                {{ Form::radio('student_gender', 'Female', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('student_gender', 'Female', false, array('')) }}
                                                            @endif
                                                            Female
                                                            <span></span>
                                                        </label>  
                                                    </div>
                                                    <span class="m-form__help">
                                                        Please select the student's gender
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Student's Birth Order:
                                                    </label>
                                                    <div class="m-radio-list">
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->student_birthorder == 'Only Child') 
                                                                {{ Form::radio('student_birthorder', 'Only Child', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('student_birthorder', 'Only Child', false, array('')) }}
                                                            @endif
                                                            Only Child
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->student_birthorder == 'Eldest') 
                                                                {{ Form::radio('student_birthorder', 'Eldest', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('student_birthorder', 'Eldest', false, array('')) }}
                                                            @endif
                                                            Eldest
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->student_birthorder == 'Youngest') 
                                                                {{ Form::radio('student_birthorder', 'Youngest', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('student_birthorder', 'Youngest', false, array('')) }}
                                                            @endif
                                                            Youngest
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->student_birthorder == 'Middle') 
                                                                {{ Form::radio('student_birthorder', 'Middle', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('student_birthorder', 'Middle', false, array('')) }}
                                                            @endif
                                                            Middle
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <span class="m-form__help">
                                                        Please select the student's birth order
                                                    </span>
                                                </div>
                                                <div class="col-lg-6 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Student's lives or resides with:
                                                    </label>
                                                    <div class="m-radio-list">
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->student_reside_with == 'Parents') 
                                                                {{ Form::radio('student_reside_with', 'Parents', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('student_reside_with', 'Parents', false, array('')) }}
                                                            @endif
                                                            Parents
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->student_reside_with == 'Guardians') 
                                                                {{ Form::radio('student_reside_with', 'Guardians', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('student_reside_with', 'Guardians', false, array('')) }}
                                                            @endif
                                                            Guardians
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->student_reside_with == 'Relatives') 
                                                                {{ Form::radio('student_reside_with', 'Relatives', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('student_reside_with', 'Relatives', false, array('')) }}
                                                            @endif
                                                            Relatives
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->student_reside_with == 'Others') 
                                                                {{ Form::radio('student_reside_with', 'Others', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('student_reside_with', 'Others', false, array('')) }}
                                                            @endif
                                                            Others
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <span class="m-form__help">
                                                        Please select the student's lives or reside with
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-12 m-form__group-sub"> 
                                                    <label class="form-control-label">
                                                        * Student's Home Address (House Number, Street, District Area, City)
                                                    </label>
                                                    {{ 
                                                        Form::textarea($name = 'student_address', $value = !empty($enroll) ? $enroll->student_address : '', 
                                                        $attributes = array(
                                                            'id' => 'student_address',
                                                            'class' => 'form-control form-control-lg m-input m-input--solid',
                                                            'rows' => 3
                                                        )) 
                                                    }}
                                                    <span class="m-form__help">
                                                        Please enter student's home address
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-12 m-form__group-sub"> 
                                                    <label class="form-control-label">
                                                        * Barangay Name or Number
                                                    </label>
                                                    {{ 
                                                        Form::textarea($name = 'student_barangay', $value = !empty($enroll) ? $enroll->student_barangay : '', 
                                                        $attributes = array(
                                                            'id' => 'student_barangay',
                                                            'class' => 'form-control form-control-lg m-input m-input--solid',
                                                            'rows' => 3
                                                        )) 
                                                    }}
                                                    <span class="m-form__help">
                                                        Please enter barangay name or number
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-12 m-form__group-sub"> 
                                                    <label class="form-control-label">
                                                        * COMPLETE Name and Address of School Last Attended (write N/A if not applicable)
                                                    </label>
                                                    {{ 
                                                        Form::textarea($name = 'student_last_attended', $value = !empty($enroll) ? $enroll->student_last_attended : '', 
                                                        $attributes = array(
                                                            'id' => 'student_last_attended',
                                                            'class' => 'form-control form-control-lg m-input m-input--solid',
                                                            'rows' => 3
                                                        )) 
                                                    }}
                                                    <span class="m-form__help">
                                                        Please enter school last attended
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-12 m-form__group-sub"> 
                                                    <label class="form-control-label">
                                                        * Reason for Enrolling/Transferring
                                                    </label>
                                                    {{ 
                                                        Form::textarea($name = 'student_transfer_reason', $value = !empty($enroll) ? $enroll->student_transfer_reason : '', 
                                                        $attributes = array(
                                                            'id' => 'student_transfer_reason',
                                                            'class' => 'form-control form-control-lg m-input m-input--solid',
                                                            'rows' => 3
                                                        )) 
                                                    }}
                                                    <span class="m-form__help">
                                                        Please enter school last attended
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                        <div class="m-form__section">
                                            <div class="m-form__heading">
                                                <h3 class="m-form__heading-title">
                                                    Father's Details
                                                </h3>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-4 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Father's Firstname:
                                                    </label>
                                                    {{ 
                                                        Form::text($name = 'father_firstname', $value = !empty($enroll) ? $enroll->father_firstname : '', 
                                                        $attributes = array(
                                                            'id' => 'father_firstname',
                                                            'class' => 'form-control form-control-lg m-input m-input--solid'
                                                        )) 
                                                    }}
                                                    <span class="m-form__help">
                                                        Please enter father's firstname
                                                    </span>
                                                </div>
                                                <div class="col-lg-4 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        Father's Middlename:
                                                    </label>
                                                    {{ 
                                                        Form::text($name = 'father_middlename', $value = !empty($enroll) ? $enroll->father_middlename : '', 
                                                        $attributes = array(
                                                            'id' => 'father_middlename',
                                                            'class' => 'form-control form-control-lg m-input m-input--solid'
                                                        )) 
                                                    }}
                                                    <span class="m-form__help">
                                                        Please enter father's middlename
                                                    </span>
                                                </div>
                                                <div class="col-lg-4 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Father's Lastname:
                                                    </label>
                                                    {{ 
                                                        Form::text($name = 'father_lastname', $value = !empty($enroll) ? $enroll->father_lastname : '', 
                                                        $attributes = array(
                                                            'id' => 'father_lastname',
                                                            'class' => 'form-control form-control-lg m-input m-input--solid'
                                                        )) 
                                                    }}
                                                    <span class="m-form__help">
                                                        Please enter father's lastname
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-4 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Father's Mobile Number:
                                                    </label>
                                                    {{ 
                                                        Form::text($name = 'father_contact', $value = !empty($enroll) ? $enroll->father_contact : '', 
                                                        $attributes = array(
                                                            'id' => 'father_contact',
                                                            'class' => 'form-control form-control-lg m-input m-input--solid'
                                                        )) 
                                                    }}
                                                    <span class="m-form__help">
                                                        Please enter father's mobile number
                                                    </span>
                                                </div>
                                                <div class="col-lg-4 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Father's Birthdate:
                                                    </label>
                                                    {{ 
                                                        Form::date($name = 'father_birthdate', $value = !empty($enroll) ? $enroll->father_birthdate : '', 
                                                        $attributes = array(
                                                            'id' => 'father_birthdate',
                                                            'class' => 'form-control form-control-lg m-input m-input--solid'
                                                        )) 
                                                    }}
                                                    <span class="m-form__help">
                                                        Please enter father's birthdate
                                                    </span>
                                                </div>
                                                <div class="col-lg-4 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Father's Birthplace:
                                                    </label>
                                                    {{ 
                                                        Form::text($name = 'father_birthplace', $value = !empty($enroll) ? $enroll->father_birthplace : '', 
                                                        $attributes = array(
                                                            'id' => 'father_birthplace',
                                                            'class' => 'form-control form-control-lg m-input m-input--solid'
                                                        )) 
                                                    }}
                                                    <span class="m-form__help">
                                                        Please enter father's birthplace
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-12 m-form__group-sub"> 
                                                    <label class="form-control-label">
                                                        * Father's Address:
                                                    </label>
                                                    {{ 
                                                        Form::textarea($name = 'father_address', $value = !empty($enroll) ? $enroll->father_address : '', 
                                                        $attributes = array(
                                                            'id' => 'father_address',
                                                            'class' => 'form-control form-control-lg m-input m-input--solid',
                                                            'rows' => 3
                                                        )) 
                                                    }}
                                                    <span class="m-form__help">
                                                    Please enter father's address
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6 m-form__group-sub"> 
                                                    <label class="form-control-label">
                                                        * Father's Religion:
                                                    </label>
                                                    <div class="m-radio-list">
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->father_religion == 'Roman Catholic') 
                                                                {{ Form::radio('father_religion', 'Roman Catholic', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('father_religion', 'Roman Catholic', false, array('')) }}
                                                            @endif
                                                            Roman Catholic
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->father_religion == 'Other') 
                                                                {{ Form::radio('father_religion', 'Other', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('father_religion', 'Other', false, array('')) }}
                                                            @endif
                                                            <input type="radio" name="father_religion" value="Other">
                                                            Other
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    @if (!empty($enroll) && $enroll->father_religion == 'Other') 
                                                        {{ 
                                                            Form::text($name = 'father_specific_religion', $value = !empty($enroll) ? $enroll->father_specific_religion : '', 
                                                            $attributes = array(
                                                                'id' => 'father_specific_religion',
                                                                'class' => 'form-control form-control-lg m-input m-input--solid'
                                                            )) 
                                                        }}
                                                    @else
                                                        {{ 
                                                            Form::text($name = 'father_specific_religion', $value = !empty($enroll) ? $enroll->father_specific_religion : '', 
                                                            $attributes = array(
                                                                'id' => 'father_specific_religion',
                                                                'disabled' => 'disabled',
                                                                'class' => 'hidden form-control form-control-lg m-input m-input--solid'
                                                            )) 
                                                        }}
                                                    @endif
                                                    <span class="m-form__help">
                                                        Please enter specific religion
                                                    </span>
                                                </div>
                                                <div class="col-lg-6 m-form__group-sub"> 
                                                    <label class="form-control-label">
                                                        Father's Occupation:
                                                    </label>
                                                    {{ 
                                                        Form::text($name = 'father_occupation', $value = !empty($enroll) ? $enroll->father_occupation : '', 
                                                        $attributes = array(
                                                            'id' => 'father_occupation',
                                                            'class' => 'form-control form-control-lg m-input m-input--solid'
                                                        )) 
                                                    }}
                                                    <span class="m-form__help">
                                                        Please enter father's occupation
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Father's Educational Attainment:
                                                    </label>
                                                    <div class="m-radio-list">
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->father_education == 'Elementary') 
                                                                {{ Form::radio('father_education', 'Elementary', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('father_education', 'Elementary', false, array('')) }}
                                                            @endif
                                                            Elementary
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->father_education == 'High School') 
                                                                {{ Form::radio('father_education', 'High School', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('father_education', 'High School', false, array('')) }}
                                                            @endif
                                                            High School
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->father_education == 'Undergraduate') 
                                                                {{ Form::radio('father_education', 'Undergraduate', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('father_education', 'Undergraduate', false, array('')) }}
                                                            @endif
                                                            Undergraduate
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->father_education == 'College') 
                                                                {{ Form::radio('father_education', 'College', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('father_education', 'College', false, array('')) }}
                                                            @endif
                                                            College
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->father_education == 'Post-Baccalaureate') 
                                                                {{ Form::radio('father_education', 'Post-Baccalaureate', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('father_education', 'Post-Baccalaureate', false, array('')) }}
                                                            @endif
                                                            Post-Baccalaureate
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <span class="m-form__help">
                                                        Please select the father's educational attainment
                                                    </span>
                                                </div>
                                                <div class="col-lg-6 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Father's Employment Status:
                                                    </label>
                                                    <div class="m-radio-list">
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->father_employment_status == 'Full Time') 
                                                                {{ Form::radio('father_employment_status', 'Full Time', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('father_employment_status', 'Full Time', false, array('')) }}
                                                            @endif
                                                            Full Time
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->father_employment_status == 'Part Time') 
                                                                {{ Form::radio('father_employment_status', 'Part Time', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('father_employment_status', 'Part Time', false, array('')) }}
                                                            @endif
                                                            Part Time
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->father_employment_status == 'Self Employed (i.e. Family Business)') 
                                                                {{ Form::radio('father_employment_status', 'Self Employed (i.e. Family Business)', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('father_employment_status', 'Self Employed (i.e. Family Business)', false, array('')) }}
                                                            @endif
                                                            Self Employed (i.e. Family Business)
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->father_employment_status == 'Unemployed due to community quarantine') 
                                                                {{ Form::radio('father_employment_status', 'Unemployed due to community quarantine', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('father_employment_status', 'Unemployed due to community quarantine', false, array('')) }}
                                                            @endif
                                                            Unemployed due to community quarantine
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->father_employment_status == 'NOT Working') 
                                                                {{ Form::radio('father_employment_status', 'NOT Working', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('father_employment_status', 'NOT Working', false, array('')) }}
                                                            @endif
                                                            <input type="radio" name="father_employment_status" value="NOT Working">
                                                            NOT Working
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <span class="m-form__help">
                                                        Please select the father's employment status
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Father's Place of Work:
                                                    </label>
                                                    <div class="m-radio-list">
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->father_workplace == 'In the Philippines') 
                                                                {{ Form::radio('father_workplace', 'In the Philippines', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('father_workplace', 'In the Philippines', false, array('')) }}
                                                            @endif
                                                            In the Philippines
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->father_workplace == 'Abroad') 
                                                                {{ Form::radio('father_workplace', 'Abroad', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('father_workplace', 'Abroad', false, array('')) }}
                                                            @endif
                                                            Abroad
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <span class="m-form__help">
                                                        Please select the father's workplace
                                                    </span>
                                                </div>
                                                <div class="col-lg-6 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Is the father working from home due to community quarantine:
                                                    </label>
                                                    <div class="m-radio-list">
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->father_work_quarantine == 'Yes') 
                                                                {{ Form::radio('father_work_quarantine', 'Yes', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('father_work_quarantine', 'Yes', false, array('')) }}
                                                            @endif
                                                            <input type="radio" name="father_work_quarantine" value="Yes">
                                                            Yes
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->father_work_quarantine == 'No') 
                                                                {{ Form::radio('father_work_quarantine', 'No', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('father_work_quarantine', 'No', false, array('')) }}
                                                            @endif
                                                            No
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <span class="m-form__help">
                                                        Please select the father's work quarantine
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                        <div class="m-form__section">
                                            <div class="m-form__heading">
                                                <h3 class="m-form__heading-title">
                                                    Mother's Details
                                                </h3>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-4 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Mother's Firstname:
                                                    </label>
                                                    {{ 
                                                        Form::text($name = 'mother_firstname', $value = !empty($enroll) ? $enroll->mother_firstname : '', 
                                                        $attributes = array(
                                                            'id' => 'mother_firstname',
                                                            'class' => 'form-control form-control-lg m-input m-input--solid'
                                                        )) 
                                                    }}
                                                    <span class="m-form__help">
                                                        Please enter mother's firstname
                                                    </span>
                                                </div>
                                                <div class="col-lg-4 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        Mother's Middlename:
                                                    </label>
                                                    {{ 
                                                        Form::text($name = 'mother_middlename', $value = !empty($enroll) ? $enroll->mother_middlename : '', 
                                                        $attributes = array(
                                                            'id' => 'mother_middlename',
                                                            'class' => 'form-control form-control-lg m-input m-input--solid'
                                                        )) 
                                                    }}
                                                    <span class="m-form__help">
                                                        Please enter mother's middlename
                                                    </span>
                                                </div>
                                                <div class="col-lg-4 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Mother's Lastname:
                                                    </label>
                                                    {{ 
                                                        Form::text($name = 'mother_lastname', $value = !empty($enroll) ? $enroll->mother_lastname : '', 
                                                        $attributes = array(
                                                            'id' => 'mother_lastname',
                                                            'class' => 'form-control form-control-lg m-input m-input--solid'
                                                        )) 
                                                    }}
                                                    <span class="m-form__help">
                                                        Please enter mother's lastname
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Mother's Maiden Name:
                                                    </label>
                                                    {{ 
                                                        Form::text($name = 'mother_maidenname', $value = !empty($enroll) ? $enroll->mother_maidenname : '', 
                                                        $attributes = array(
                                                            'id' => 'mother_maidenname',
                                                            'class' => 'form-control form-control-lg m-input m-input--solid'
                                                        )) 
                                                    }}
                                                    <span class="m-form__help">
                                                        Please enter mother's maiden name
                                                    </span>
                                                </div>
                                                <div class="col-lg-6 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Mother's Mobile Number:
                                                    </label>
                                                    {{ 
                                                        Form::text($name = 'mother_contact', $value = !empty($enroll) ? $enroll->mother_contact : '', 
                                                        $attributes = array(
                                                            'id' => 'mother_contact',
                                                            'class' => 'form-control form-control-lg m-input m-input--solid'
                                                        )) 
                                                    }}
                                                    <span class="m-form__help">
                                                        Please enter mother's mobile number
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Mother's Birthdate:
                                                    </label>
                                                    {{ 
                                                        Form::date($name = 'mother_birthdate', $value = !empty($enroll) ? $enroll->mother_birthdate : '', 
                                                        $attributes = array(
                                                            'id' => 'mother_birthdate',
                                                            'class' => 'form-control form-control-lg m-input m-input--solid'
                                                        )) 
                                                    }}
                                                    <span class="m-form__help">
                                                        Please enter mother's birthdate
                                                    </span>
                                                </div>
                                                <div class="col-lg-6 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Mother's Birthplace:
                                                    </label>
                                                    {{ 
                                                        Form::text($name = 'mother_birthplace', $value = !empty($enroll) ? $enroll->mother_birthplace : '', 
                                                        $attributes = array(
                                                            'id' => 'mother_birthplace',
                                                            'class' => 'form-control form-control-lg m-input m-input--solid'
                                                        )) 
                                                    }}
                                                    <span class="m-form__help">
                                                        Please enter mother's birthplace
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-12 m-form__group-sub"> 
                                                    <label class="form-control-label">
                                                        * Mother's Address:
                                                    </label>
                                                    {{ 
                                                        Form::textarea($name = 'mother_address', $value = !empty($enroll) ? $enroll->mother_address : '', 
                                                        $attributes = array(
                                                            'id' => 'mother_address',
                                                            'class' => 'form-control form-control-lg m-input m-input--solid',
                                                            'rows' => 3
                                                        )) 
                                                    }}
                                                    <span class="m-form__help">
                                                    Please enter mother's address
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6 m-form__group-sub"> 
                                                    <label class="form-control-label">
                                                        * Mother's Religion:
                                                    </label>
                                                    <div class="m-radio-list">
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->mother_religion == 'Roman Catholic') 
                                                                {{ Form::radio('mother_religion', 'Roman Catholic', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('mother_religion', 'Roman Catholic', false, array('')) }}
                                                            @endif
                                                            Roman Catholic
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->mother_religion == 'Other') 
                                                                {{ Form::radio('mother_religion', 'Other', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('mother_religion', 'Other', false, array('')) }}
                                                            @endif
                                                            Other
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    @if (!empty($enroll) && $enroll->mother_religion == 'Other') 
                                                        {{ 
                                                            Form::text($name = 'mother_specific_religion', $value = !empty($enroll) ? $enroll->mother_specific_religion : '', 
                                                            $attributes = array(
                                                                'id' => 'mother_specific_religion',
                                                                'class' => 'form-control form-control-lg m-input m-input--solid'
                                                            )) 
                                                        }}
                                                    @else
                                                        {{ 
                                                            Form::text($name = 'mother_specific_religion', $value = !empty($enroll) ? $enroll->mother_specific_religion : '', 
                                                            $attributes = array(
                                                                'id' => 'mother_specific_religion',
                                                                'disabled' => 'disabled',
                                                                'class' => 'hidden form-control form-control-lg m-input m-input--solid'
                                                            )) 
                                                        }}
                                                    @endif
                                                    <span class="m-form__help">
                                                        Please enter specific religion
                                                    </span>
                                                </div>
                                                <div class="col-lg-6 m-form__group-sub"> 
                                                    <label class="form-control-label">
                                                        Mother's Occupation:
                                                    </label>
                                                    {{ 
                                                        Form::text($name = 'mother_occupation', $value = !empty($enroll) ? $enroll->mother_occupation : '', 
                                                        $attributes = array(
                                                            'id' => 'mother_occupation',
                                                            'class' => 'form-control form-control-lg m-input m-input--solid'
                                                        )) 
                                                    }}
                                                    <span class="m-form__help">
                                                        Please enter mother's occupation
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Mother's Educational Attainment:
                                                    </label>
                                                    <div class="m-radio-list">
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->mother_education == 'Elementary') 
                                                                {{ Form::radio('mother_education', 'Elementary', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('mother_education', 'Elementary', false, array('')) }}
                                                            @endif
                                                            Elementary
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->mother_education == 'High School') 
                                                                {{ Form::radio('mother_education', 'High School', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('mother_education', 'High School', false, array('')) }}
                                                            @endif
                                                            High School
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->mother_education == 'Undergraduate') 
                                                                {{ Form::radio('mother_education', 'Undergraduate', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('mother_education', 'Undergraduate', false, array('')) }}
                                                            @endif
                                                            Undergraduate
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->mother_education == 'College') 
                                                                {{ Form::radio('mother_education', 'College', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('mother_education', 'College', false, array('')) }}
                                                            @endif
                                                            College
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->mother_education == 'Post-Baccalaureate') 
                                                                {{ Form::radio('mother_education', 'Post-Baccalaureate', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('mother_education', 'Post-Baccalaureate', false, array('')) }}
                                                            @endif
                                                            Post-Baccalaureate
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <span class="m-form__help">
                                                        Please select the father's educational attainment
                                                    </span>
                                                </div>
                                                <div class="col-lg-6 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Mother's Employment Status:
                                                    </label>
                                                    <div class="m-radio-list">
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->mother_employment_status == 'Full Time') 
                                                                {{ Form::radio('mother_employment_status', 'Full Time', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('mother_employment_status', 'Full Time', false, array('')) }}
                                                            @endif
                                                            Full Time
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->mother_employment_status == 'Part Time') 
                                                                {{ Form::radio('mother_employment_status', 'Part Time', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('mother_employment_status', 'Part Time', false, array('')) }}
                                                            @endif
                                                            Part Time
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->mother_employment_status == 'Self Employed (i.e. Family Business)') 
                                                                {{ Form::radio('mother_employment_status', 'Self Employed (i.e. Family Business)', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('mother_employment_status', 'Self Employed (i.e. Family Business)', false, array('')) }}
                                                            @endif
                                                            Self Employed (i.e. Family Business)
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->mother_employment_status == 'Unemployed due to community quarantine') 
                                                                {{ Form::radio('mother_employment_status', 'Unemployed due to community quarantine', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('mother_employment_status', 'Unemployed due to community quarantine', false, array('')) }}
                                                            @endif
                                                            Unemployed due to community quarantine
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->mother_employment_status == 'NOT Working') 
                                                                {{ Form::radio('mother_employment_status', 'NOT Working', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('mother_employment_status', 'NOT Working', false, array('')) }}
                                                            @endif    
                                                            NOT Working
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <span class="m-form__help">
                                                        Please select the father's employment status
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Mother's Place of Work:
                                                    </label>
                                                    <div class="m-radio-list">
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->mother_workplace == 'In the Philippines') 
                                                                {{ Form::radio('mother_workplace', 'In the Philippines', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('mother_workplace', 'In the Philippines', false, array('')) }}
                                                            @endif    
                                                            In the Philippines
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->mother_workplace == 'Abroad') 
                                                                {{ Form::radio('mother_workplace', 'Abroad', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('mother_workplace', 'Abroad', false, array('')) }}
                                                            @endif    
                                                            Abroad
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <span class="m-form__help">
                                                        Please select mother's workplace
                                                    </span>
                                                </div>
                                                <div class="col-lg-6 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Is the mother working from home due to community quarantine:
                                                    </label>
                                                    <div class="m-radio-list">
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->mother_work_quarantine == 'Yes') 
                                                                {{ Form::radio('mother_work_quarantine', 'Yes', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('mother_work_quarantine', 'Yes', false, array('')) }}
                                                            @endif    
                                                            Yes
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->mother_work_quarantine == 'No') 
                                                                {{ Form::radio('mother_work_quarantine', 'No', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('mother_work_quarantine', 'No', false, array('')) }}
                                                            @endif  
                                                            No
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <span class="m-form__help">
                                                        Please select mother's work quarantine
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-12 m-form__group-sub"> 
                                                    <label class="form-control-label">
                                                        * Parent's Marriage Status:
                                                    </label>
                                                    <div class="m-radio-inline">
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->parent_marriage_status == 'Living Together') 
                                                                {{ Form::radio('parent_marriage_status', 'Living Together', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('parent_marriage_status', 'Living Together', false, array('')) }}
                                                            @endif 
                                                            Living Together
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->parent_marriage_status == 'Single Parent') 
                                                                {{ Form::radio('parent_marriage_status', 'Single Parent', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('parent_marriage_status', 'Single Parent', false, array('')) }}
                                                            @endif 
                                                            Single Parent
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->parent_marriage_status == 'Separated') 
                                                                {{ Form::radio('parent_marriage_status', 'Separated', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('parent_marriage_status', 'Separated', false, array('')) }}
                                                            @endif 
                                                            Separated
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->parent_marriage_status == 'Widow/Widower') 
                                                                {{ Form::radio('parent_marriage_status', 'Widow/Widower', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('parent_marriage_status', 'Widow/Widower', false, array('')) }}
                                                            @endif 
                                                            Widow/Widower
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <span class="m-form__help">
                                                        Please select parent's marriage status
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                        <div class="m-form__section">
                                            <div class="m-form__heading">
                                                <h3 class="m-form__heading-title">
                                                    Guardian's Details
                                                </h3>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-4 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Guardian's Firstname:
                                                    </label>
                                                    {{ 
                                                        Form::text($name = 'guardian_firstname', $value = !empty($enroll) ? $enroll->guardian_firstname : '', 
                                                        $attributes = array(
                                                            'id' => 'guardian_firstname',
                                                            'class' => 'form-control form-control-lg m-input m-input--solid'
                                                        )) 
                                                    }}
                                                    <span class="m-form__help">
                                                        Please enter guardian's firstname
                                                    </span>
                                                </div>
                                                <div class="col-lg-4 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        Guardian's Middlename:
                                                    </label>
                                                    {{ 
                                                        Form::text($name = 'guardian_middlename', $value = !empty($enroll) ? $enroll->guardian_middlename : '', 
                                                        $attributes = array(
                                                            'id' => 'guardian_middlename',
                                                            'class' => 'form-control form-control-lg m-input m-input--solid'
                                                        )) 
                                                    }}
                                                    <span class="m-form__help">
                                                        Please enter guardian's middlename
                                                    </span>
                                                </div>
                                                <div class="col-lg-4 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Guardian's Lastname:
                                                    </label>
                                                    {{ 
                                                        Form::text($name = 'guardian_lastname', $value = !empty($enroll) ? $enroll->guardian_lastname : '', 
                                                        $attributes = array(
                                                            'id' => 'guardian_lastname',
                                                            'class' => 'form-control form-control-lg m-input m-input--solid'
                                                        )) 
                                                    }}
                                                    <span class="m-form__help">
                                                        Please enter guardian's lastname
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Guardian's Relationship to student:
                                                    </label>
                                                    {{ 
                                                        Form::text($name = 'guardian_relationship', $value = !empty($enroll) ? $enroll->guardian_relationship : '', 
                                                        $attributes = array(
                                                            'id' => 'guardian_relationship',
                                                            'class' => 'form-control form-control-lg m-input m-input--solid'
                                                        )) 
                                                    }}
                                                    <span class="m-form__help">
                                                        Please enter guardian's relationship to student
                                                    </span>
                                                </div>
                                                <div class="col-lg-6 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Guardian's Mobile Number:
                                                    </label>
                                                    {{ 
                                                        Form::text($name = 'guardian_contact', $value = !empty($enroll) ? $enroll->guardian_contact : '', 
                                                        $attributes = array(
                                                            'id' => 'guardian_contact',
                                                            'class' => 'form-control form-control-lg m-input m-input--solid'
                                                        )) 
                                                    }}
                                                    <span class="m-form__help">
                                                        Please enter guardian's mobile number
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Guardian's Employment Status :
                                                    </label>
                                                    <div class="m-radio-list">
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->guardian_employment_status == 'Full Time') 
                                                                {{ Form::radio('guardian_employment_status', 'Full Time', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('guardian_employment_status', 'Full Time', false, array('')) }}
                                                            @endif
                                                            Full Time
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->guardian_employment_status == 'Part Time') 
                                                                {{ Form::radio('guardian_employment_status', 'Part Time', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('guardian_employment_status', 'Part Time', false, array('')) }}
                                                            @endif
                                                            Part Time
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->guardian_employment_status == 'Self Employed (i.e. Family Business)') 
                                                                {{ Form::radio('guardian_employment_status', 'Self Employed (i.e. Family Business)', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('guardian_employment_status', 'Self Employed (i.e. Family Business)', false, array('')) }}
                                                            @endif
                                                            Self Employed (i.e. Family Business)
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->guardian_employment_status == 'Unemployed due to community quarantine') 
                                                                {{ Form::radio('guardian_employment_status', 'Unemployed due to community quarantine', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('guardian_employment_status', 'Unemployed due to community quarantine', false, array('')) }}
                                                            @endif
                                                            Unemployed due to community quarantine
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->guardian_employment_status == 'NOT Working') 
                                                                {{ Form::radio('guardian_employment_status', 'NOT Working', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('guardian_employment_status', 'NOT Working', false, array('')) }}
                                                            @endif
                                                            NOT Working
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <span class="m-form__help">
                                                        Please select the father's employment status
                                                    </span>
                                                </div>
                                                <div class="col-lg-6 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Is the guardian working from home due to community quarantine:
                                                    </label>
                                                    <div class="m-radio-list">
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->guardian_work_quarantine == 'Yes') 
                                                                {{ Form::radio('guardian_work_quarantine', 'Yes', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('guardian_work_quarantine', 'Yes', false, array('')) }}
                                                            @endif
                                                            Yes
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->guardian_work_quarantine == 'No') 
                                                                {{ Form::radio('guardian_work_quarantine', 'No', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('guardian_work_quarantine', 'No', false, array('')) }}
                                                            @endif
                                                            No
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <span class="m-form__help">
                                                        Please select the guardian's work quarantine
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Is your family a beneficiary of 4Ps:
                                                    </label>
                                                    <div class="m-radio-list">
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->family_4ps == 'Yes') 
                                                                {{ Form::radio('family_4ps', 'Yes', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('family_4ps', 'Yes', false, array('')) }}
                                                            @endif
                                                            Yes
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->family_4ps == 'No') 
                                                                {{ Form::radio('family_4ps', 'No', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('family_4ps', 'No', false, array('')) }}
                                                            @endif
                                                            No
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <span class="m-form__help">
                                                        Please select family beneficiary
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-12 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Siblings (follow the format: Full Name - Age. [e.g. Juan Dela Cruz - 10]):
                                                    </label>
                                                    {{ 
                                                        Form::text($name = 'student_siblings', $value = !empty($enroll) ? $enroll->student_siblings : '', 
                                                        $attributes = array(
                                                            'id' => 'student_siblings',
                                                            'class' => 'form-control form-control-lg m-input m-input--solid'
                                                        )) 
                                                    }}
                                                    <span class="m-form__help">
                                                        Please enter student siblings
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-12 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Previous Schools' Academic Information (follow the format: Name of School, Year/s stayed, Honor/s received) - Type N/A if NOT APPLICABLE:
                                                    </label>
                                                    {{ 
                                                        Form::text($name = 'student_previous_academic', $value = !empty($enroll) ? $enroll->student_previous_academic : '', 
                                                        $attributes = array(
                                                            'id' => 'student_previous_academic',
                                                            'class' => 'form-control form-control-lg m-input m-input--solid'
                                                        )) 
                                                    }}
                                                    <span class="m-form__help">
                                                        Please enter previous school academic information
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-wizard__form-step" id="m_wizard_form_step_3">
                                <div class="row">
                                    <div class="col-xl-8 offset-xl-2">
                                        <div class="m-form__section m-form__section--first">
                                            <div class="m-form__heading">
                                                <h3 class="m-form__heading-title">
                                                    Household Capacity and Access to Distance Learning Details
                                                </h3>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-12 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * How does your child go to school? Choose all that applies:
                                                    </label>
                                                    <div class="m-checkbox-list">
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            @if (!empty($enroll))
                                                                @php $quarantine = explode(',', $enroll->student_transpo); @endphp
                                                            @else 
                                                                @php $quarantine = array(); @endphp
                                                            @endif
                                                            @if (in_array('Walking', $quarantine))
                                                                {{ Form::checkbox('student_transpo[]', 'Walking', true, array('')) }}
                                                            @else
                                                                {{ Form::checkbox('student_transpo[]', 'Walking', false, array('')) }}
                                                            @endif
                                                            Walking
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            @if (in_array('Public Commute', $quarantine))
                                                                {{ Form::checkbox('student_transpo[]', 'Public Commute', true, array('')) }}
                                                            @else
                                                                {{ Form::checkbox('student_transpo[]', 'Public Commute', false, array('')) }}
                                                            @endif
                                                            Public Commute
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            @if (in_array('Family-owned Vehicle', $quarantine))
                                                                {{ Form::checkbox('student_transpo[]', 'Family-owned Vehicle', true, array('')) }}
                                                            @else
                                                                {{ Form::checkbox('student_transpo[]', 'Family-owned Vehicle', false, array('')) }}
                                                            @endif
                                                            Family-owned Vehicle
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            @if (in_array('School Service', $quarantine))
                                                                {{ Form::checkbox('student_transpo[]', 'School Service', true, array('')) }}
                                                            @else
                                                                {{ Form::checkbox('student_transpo[]', 'School Service', false, array('')) }}
                                                            @endif
                                                            School Service
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <span class="m-form__help">
                                                        Please select student transportation
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-12 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * How many of your household members are studying this SY 2020-2021:
                                                    </label>
                                                    <div class="m-radio-list">
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->student_studying == 1)
                                                                {{ Form::radio('student_studying', '1', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('student_studying', '1', false, array('')) }}
                                                            @endif
                                                            1
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->student_studying == 2)
                                                                {{ Form::radio('student_studying', '2', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('student_studying', '2', false, array('')) }}
                                                            @endif
                                                            2
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->student_studying == 3)
                                                                {{ Form::radio('student_studying', '3', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('student_studying', '3', false, array('')) }}
                                                            @endif
                                                            3
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->student_studying == 'Other')
                                                                {{ Form::radio('student_studying', 'Other', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('student_studying', 'Other', false, array('')) }}
                                                            @endif
                                                            Other
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    @if (!empty($enroll) && $enroll->student_studying !== 'Other') 
                                                        {{ 
                                                            Form::text($name = 'specific_student_studying', $value = !empty($enroll) ? $enroll->specific_student_studying : '', 
                                                            $attributes = array(
                                                                'id' => 'specific_student_studying',
                                                                'class' => 'hidden form-control form-control-lg m-input m-input--solid',
                                                                'disabled' => 'disabled'
                                                            )) 
                                                        }}
                                                    @else
                                                        {{ 
                                                            Form::text($name = 'specific_student_studying', $value = !empty($enroll) ? $enroll->specific_student_studying : '', 
                                                            $attributes = array(
                                                                'id' => 'specific_student_studying',
                                                                'class' => 'form-control form-control-lg m-input m-input--solid'
                                                            )) 
                                                        }}
                                                    @endif
                                                    <span class="m-form__help">
                                                        Please select how many household member studying
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-12 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Who among the household members can provide instructional support to the child's distance learning? (Sino sa mga kasama sa bahay ang makakatulong upang suportahan ang pag aaral ng bata habang naka-distance learning?) Choose all that applies:
                                                    </label>
                                                    <div class="m-radio-list">
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->student_supplies == 'Parents/Guardian')
                                                                {{ Form::radio('student_supplies', 'Parents/Guardian', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('student_supplies', 'Parents/Guardian', false, array('')) }}
                                                            @endif
                                                            Parents/Guardian
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->student_supplies == 'Elder siblings')
                                                                {{ Form::radio('student_supplies', 'Elder siblings', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('student_supplies', 'Elder siblings', false, array('')) }}
                                                            @endif
                                                            Elder siblings
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->student_supplies == 'Grandparents')
                                                                {{ Form::radio('student_supplies', 'Grandparents', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('student_supplies', 'Grandparents', false, array('')) }}
                                                            @endif
                                                            Grandparents
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->student_supplies == 'Extended Members of the family')
                                                                {{ Form::radio('student_supplies', 'Extended Members of the family', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('student_supplies', 'Extended Members of the family', false, array('')) }}
                                                            @endif
                                                            Extended Members of the family
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->student_supplies == 'Others (tutor, house helper)')
                                                                {{ Form::radio('student_supplies', 'Others (tutor, house helper)', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('student_supplies', 'Others (tutor, house helper)', false, array('')) }}
                                                            @endif
                                                            Others (tutor, house helper)
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->student_supplies == 'None')
                                                                {{ Form::radio('student_supplies', 'None', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('student_supplies', 'None', false, array('')) }}
                                                            @endif
                                                            None
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->student_supplies == 'Able to do independent learning')
                                                                {{ Form::radio('student_supplies', 'Able to do independent learning', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('student_supplies', 'Able to do independent learning', false, array('')) }}
                                                            @endif
                                                            Able to do independent learning
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <span class="m-form__help">
                                                        Please select instructional support provider
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-12 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * What devices are available at home that the learner can use for learning? Check all that applies:
                                                    </label>
                                                    <div class="m-checkbox-list">
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            @if (!empty($enroll))
                                                                @php $devices = explode(',', $enroll->student_devices); @endphp
                                                            @else
                                                                @php $devices = array(); @endphp
                                                            @endif
                                                            @if (in_array('Cable TV', $devices))
                                                                {{ Form::checkbox('student_devices[]', 'Cable TV', true, array('')) }}
                                                            @else
                                                                {{ Form::checkbox('student_devices[]', 'Cable TV', false, array('')) }}
                                                            @endif
                                                            Cable TV
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            @if (in_array('Non-Cable TV', $devices))
                                                                {{ Form::checkbox('student_devices[]', 'Non-Cable TV', true, array('')) }}
                                                            @else
                                                                {{ Form::checkbox('student_devices[]', 'Non-Cable TV', false, array('')) }}
                                                            @endif
                                                            Non-Cable TV
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            @if (in_array('Basic Telephone', $devices))
                                                                {{ Form::checkbox('student_devices[]', 'Basic Telephone', true, array('')) }}
                                                            @else
                                                                {{ Form::checkbox('student_devices[]', 'Basic Telephone', false, array('')) }}
                                                            @endif
                                                            Basic Telephone
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            @if (in_array('Smartphone', $devices))
                                                                {{ Form::checkbox('student_devices[]', 'Smartphone', true, array('')) }}
                                                            @else
                                                                {{ Form::checkbox('student_devices[]', 'Smartphone', false, array('')) }}
                                                            @endif
                                                            Smartphone
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            @if (in_array('Tablet / Ipad', $devices))
                                                                {{ Form::checkbox('student_devices[]', 'Tablet / Ipad', true, array('')) }}
                                                            @else
                                                                {{ Form::checkbox('student_devices[]', 'Tablet / Ipad', false, array('')) }}
                                                            @endif
                                                            Tablet / Ipad
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            @if (in_array('Radio', $devices))
                                                                {{ Form::checkbox('student_devices[]', 'Radio', true, array('')) }}
                                                            @else
                                                                {{ Form::checkbox('student_devices[]', 'Radio', false, array('')) }}
                                                            @endif
                                                            Radio
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            @if (in_array('Desktop Computer', $devices))
                                                                {{ Form::checkbox('student_devices[]', 'Desktop Computer', true, array('')) }}
                                                            @else
                                                                {{ Form::checkbox('student_devices[]', 'Desktop Computer', false, array('')) }}
                                                            @endif
                                                            Desktop Computer
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            @if (in_array('Laptop / Netbook', $devices))
                                                                {{ Form::checkbox('student_devices[]', 'Laptop / Netbook', true, array('')) }}
                                                            @else
                                                                {{ Form::checkbox('student_devices[]', 'Laptop / Netbook', false, array('')) }}
                                                            @endif
                                                            Laptop / Netbook
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            @if (in_array('None', $devices))
                                                                {{ Form::checkbox('student_devices[]', 'None', true, array('')) }}
                                                            @else
                                                                {{ Form::checkbox('student_devices[]', 'None', false, array('')) }}
                                                            @endif
                                                            <input type="checkbox" name="student_devices[]" value="None">
                                                            None
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            @if (in_array('Other', $devices))
                                                                {{ Form::checkbox('student_devices[]', 'Other', true, array('')) }}
                                                            @else
                                                                {{ Form::checkbox('student_devices[]', 'Other', false, array('')) }}
                                                            @endif
                                                            Other
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    @if (in_array('Other', $devices))
                                                        {{ 
                                                            Form::text($name = 'specific_student_devices', $value = !empty($enroll) ? $enroll->specific_student_devices : '', 
                                                            $attributes = array(
                                                                'id' => 'specific_student_devices',
                                                                'class' => 'form-control form-control-lg m-input m-input--solid'
                                                            )) 
                                                        }}
                                                    @else
                                                        {{ 
                                                            Form::text($name = 'specific_student_devices', $value = !empty($enroll) ? $enroll->specific_student_devices : '', 
                                                            $attributes = array(
                                                                'id' => 'specific_student_devices',
                                                                'disabled' => 'disabled',
                                                                'class' => 'hidden form-control form-control-lg m-input m-input--solid'
                                                            )) 
                                                        }}
                                                    @endif
                                                    <span class="m-form__help">
                                                        Please select available learning devices
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-12 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Do you have a way to connect to the Internet:
                                                    </label>
                                                    <div class="m-radio-list">
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->student_with_internet == 'Yes')
                                                                {{ Form::radio('student_with_internet', 'Yes', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('student_with_internet', 'Yes', false, array('')) }}
                                                            @endif
                                                            Yes
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->student_with_internet == 'No')
                                                                {{ Form::radio('student_with_internet', 'No', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('student_with_internet', 'No', false, array('')) }}
                                                            @endif
                                                            No
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <span class="m-form__help">
                                                        Please select internet connection
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-12 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * How do you connect to the internet? Choose all that applies:
                                                    </label>
                                                    <div class="m-checkbox-list">
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            @if (!empty($enroll))
                                                                @php $connections = explode(',', $enroll->student_internet_connection); @endphp
                                                            @else
                                                                @php $connections = array(); @endphp
                                                            @endif
                                                            @if (in_array('Own mobile data', $connections))
                                                                {{ Form::checkbox('student_internet_connection[]', 'Own mobile data', true, array('')) }}
                                                            @else
                                                                {{ Form::checkbox('student_internet_connection[]', 'Own mobile data', false, array('')) }}
                                                            @endif
                                                            Own mobile data
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            @if (in_array('Own broadband internet (DSL, wireless fiber, satellite)', $connections))
                                                                {{ Form::checkbox('student_internet_connection[]', 'Own broadband internet (DSL, wireless fiber, satellite)', true, array('')) }}
                                                            @else
                                                                {{ Form::checkbox('student_internet_connection[]', 'Own broadband internet (DSL, wireless fiber, satellite)', false, array('')) }}
                                                            @endif
                                                            Own broadband internet (DSL, wireless fiber, satellite)
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            @if (in_array('Computer Shop', $connections))
                                                                {{ Form::checkbox('student_internet_connection[]', 'Computer Shop', true, array('')) }}
                                                            @else
                                                                {{ Form::checkbox('student_internet_connection[]', 'Computer Shop', false, array('')) }}
                                                            @endif
                                                            Computer Shop
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            @if (in_array('Other places outside the home (e.g. library, neighbor, relatives, barangay)', $connections))
                                                                {{ Form::checkbox('student_internet_connection[]', 'Other places outside the home (e.g. library, neighbor, relatives, barangay)', true, array('')) }}
                                                            @else
                                                                {{ Form::checkbox('student_internet_connection[]', 'Other places outside the home (e.g. library, neighbor, relatives, barangay)', false, array('')) }}
                                                            @endif
                                                            Other places outside the home (e.g. library, neighbor, relatives, barangay)
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            @if (in_array('None', $connections))
                                                                {{ Form::checkbox('student_internet_connection[]', 'None', true, array('')) }}
                                                            @else
                                                                {{ Form::checkbox('student_internet_connection[]', 'None', false, array('')) }}
                                                            @endif
                                                            None
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <span class="m-form__help">
                                                        Please select available learning devices
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-12 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Describe your internet connection:
                                                    </label>
                                                    <div class="m-radio-list">
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->student_describe_internet == 'Stable, fast, can stream audio/videos while surfing other websites/apps')
                                                                {{ Form::radio('student_describe_internet', 'Stable, fast, can stream audio/videos while surfing other websites/apps', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('student_describe_internet', 'Stable, fast, can stream audio/videos while surfing other websites/apps', false, array('')) }}
                                                            @endif
                                                            Stable, fast, can stream audio/videos while surfing other websites/apps
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->student_describe_internet == "Stable, slow, can stream audio/videos but can't surf websites/apps")
                                                                {{ Form::radio('student_describe_internet', "Stable, slow, can stream audio/videos but can't surf websites/apps", true, array('')) }}
                                                            @else
                                                                {{ Form::radio('student_describe_internet', "Stable, slow, can stream audio/videos but can't surf websites/apps", false, array('')) }}
                                                            @endif
                                                            Stable, slow, can stream audio/videos but can't surf websites/apps
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->student_describe_internet == 'Disconnects constantly, fast, can stream videos while surfing other websites/apps')
                                                                {{ Form::radio('student_describe_internet', 'Disconnects constantly, fast, can stream videos while surfing other websites/apps', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('student_describe_internet', 'Disconnects constantly, fast, can stream videos while surfing other websites/apps', false, array('')) }}
                                                            @endif
                                                            Disconnects constantly, fast, can stream videos while surfing other websites/apps
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->student_describe_internet == 'Disconnects constantly, slow, can surf only 1-2 website/app at a given time')
                                                                {{ Form::radio('student_describe_internet', 'Disconnects constantly, slow, can surf only 1-2 website/app at a given time', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('student_describe_internet', 'Disconnects constantly, slow, can surf only 1-2 website/app at a given time', false, array('')) }}
                                                            @endif
                                                            Disconnects constantly, slow, can surf only 1-2 website/app at a given time
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->student_describe_internet == 'I have to go out of the house so I can have an internet connection')
                                                                {{ Form::radio('student_describe_internet', 'I have to go out of the house so I can have an internet connection', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('student_describe_internet', 'I have to go out of the house so I can have an internet connection', false, array('')) }}
                                                            @endif
                                                            I have to go out of the house so I can have an internet connection
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <span class="m-form__help">
                                                        Please select your internet connection description
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-12 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * What distance learning modality/ies do you prefer for your child:
                                                    </label>
                                                    <div class="m-radio-list">
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->student_learning_modality == 'Online Learning (Virtual Classes + Textbook + Online Modules accessible to our learning management system platform)')
                                                                {{ Form::radio('student_learning_modality', 'Online Learning (Virtual Classes + Textbook + Online Modules accessible to our learning management system platform)', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('student_learning_modality', 'Online Learning (Virtual Classes + Textbook + Online Modules accessible to our learning management system platform)', false, array('')) }}
                                                            @endif
                                                            Online Learning (Virtual Classes + Textbook + Online Modules accessible to our learning management system platform)
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->student_learning_modality == 'Printed Modular Learning (Scheduled Virtual Classes + Textbooks + hardcopy materials for those with no or weak internet connections)')
                                                                {{ Form::radio('student_learning_modality', 'Printed Modular Learning (Scheduled Virtual Classes + Textbooks + hardcopy materials for those with no or weak internet connections)', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('student_learning_modality', 'Printed Modular Learning (Scheduled Virtual Classes + Textbooks + hardcopy materials for those with no or weak internet connections)', false, array('')) }}
                                                            @endif
                                                            Printed Modular Learning (Scheduled Virtual Classes + Textbooks + hardcopy materials for those with no or weak internet connections)
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <span class="m-form__help">
                                                        Please select learning modality
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-12 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Please select the delivery of learning you prefer after the First Quarter (August to September 2020):
                                                    </label>
                                                    <div class="m-radio-list">
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->student_learning_delivery == 'FULL BLENDED distance learning for the whole school year (Textbook, modular, and ONLINE LEARNING FROM HOME)')
                                                                {{ Form::radio('student_learning_delivery', 'FULL BLENDED distance learning for the whole school year (Textbook, modular, and ONLINE LEARNING FROM HOME)', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('student_learning_delivery', 'FULL BLENDED distance learning for the whole school year (Textbook, modular, and ONLINE LEARNING FROM HOME)', false, array('')) }}
                                                            @endif
                                                            FULL BLENDED distance learning for the whole school year (Textbook, modular, and ONLINE LEARNING FROM HOME)
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->student_learning_delivery == 'Flexible distance learning at home (Textbook, modular, online) with twice a month face to face sessions from October 2020 to April 2021 (only when the government allows; applicable only for Junior and Senior High School)')
                                                                {{ Form::radio('student_learning_delivery', 'Flexible distance learning at home (Textbook, modular, online) with twice a month face to face sessions from October 2020 to April 2021 (only when the government allows; applicable only for Junior and Senior High School)', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('student_learning_delivery', 'Flexible distance learning at home (Textbook, modular, online) with twice a month face to face sessions from October 2020 to April 2021 (only when the government allows; applicable only for Junior and Senior High School)', false, array('')) }}
                                                            @endif 
                                                            Flexible distance learning at home (Textbook, modular, online) with twice a month face to face sessions from October 2020 to April 2021 (only when the government allows; applicable only for Junior and Senior High School)
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <span class="m-form__help">
                                                        Please select delivery of learning after first quarter
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-12 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * What are the challenges that may affect your child’s learning process through distance education? Choose all that applies:
                                                    </label>
                                                    <div class="m-checkbox-list">
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            @if (!empty($enroll))
                                                                @php $challenges = explode(',', $enroll->student_challenges_education); @endphp
                                                            @else
                                                                @php $challenges = array(); @endphp
                                                            @endif
                                                            @if (in_array('lack of available gadgets/ equipment', $challenges))
                                                                {{ Form::checkbox('student_challenges_education[]', 'lack of available gadgets/ equipment', true, array('')) }}
                                                            @else
                                                                {{ Form::checkbox('student_challenges_education[]', 'lack of available gadgets/ equipment', false, array('')) }}
                                                            @endif
                                                            lack of available gadgets/ equipment
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            @if (in_array('insufficient load/ data allowance', $challenges))
                                                                {{ Form::checkbox('student_challenges_education[]', 'insufficient load/ data allowance', true, array('')) }}
                                                            @else
                                                                {{ Form::checkbox('student_challenges_education[]', 'insufficient load/ data allowance', false, array('')) }}
                                                            @endif
                                                            insufficient load/ data allowance
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            @if (in_array('unstable mobile/ internet connection', $challenges))
                                                                {{ Form::checkbox('student_challenges_education[]', 'unstable mobile/ internet connection', true, array('')) }}
                                                            @else
                                                                {{ Form::checkbox('student_challenges_education[]', 'unstable mobile/ internet connection', false, array('')) }}
                                                            @endif
                                                            unstable mobile/ internet connection
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            @if (in_array('existing health condition/s', $challenges))
                                                                {{ Form::checkbox('student_challenges_education[]', 'existing health condition/s', true, array('')) }}
                                                            @else
                                                                {{ Form::checkbox('student_challenges_education[]', 'existing health condition/s', false, array('')) }}
                                                            @endif
                                                            existing health condition/s
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            @if (in_array('difficulty in independent learning', $challenges))
                                                                {{ Form::checkbox('student_challenges_education[]', 'difficulty in independent learning', true, array('')) }}
                                                            @else
                                                                {{ Form::checkbox('student_challenges_education[]', 'difficulty in independent learning', false, array('')) }}
                                                            @endif
                                                            difficulty in independent learning
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            @if (in_array('conflict with other activities (i.e., house chores)', $challenges))
                                                                {{ Form::checkbox('student_challenges_education[]', 'conflict with other activities (i.e., house chores)', true, array('')) }}
                                                            @else
                                                                {{ Form::checkbox('student_challenges_education[]', 'conflict with other activities (i.e., house chores)', false, array('')) }}
                                                            @endif
                                                            conflict with other activities (i.e., house chores)
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            @if (in_array('No or lack of available space for studying', $challenges))
                                                                {{ Form::checkbox('student_challenges_education[]', 'No or lack of available space for studying', true, array('')) }}
                                                            @else
                                                                {{ Form::checkbox('student_challenges_education[]', 'No or lack of available space for studying', false, array('')) }}
                                                            @endif
                                                            No or lack of available space for studying
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            @if (in_array('distractions (i.e., social media, noise from community/neighbor)', $challenges))
                                                                {{ Form::checkbox('student_challenges_education[]', 'distractions (i.e., social media, noise from community/neighbor)', true, array('')) }}
                                                            @else
                                                                {{ Form::checkbox('student_challenges_education[]', 'distractions (i.e., social media, noise from community/neighbor)', false, array('')) }}
                                                            @endif
                                                            distractions (i.e., social media, noise from community/neighbor)
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            @if (in_array('Other', $challenges))
                                                                {{ Form::checkbox('student_challenges_education[]', 'Other', true, array('')) }}
                                                            @else
                                                                {{ Form::checkbox('student_challenges_education[]', 'Other', false, array('')) }}
                                                            @endif    
                                                            Other
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    @if (in_array('Other', $challenges))
                                                        {{ 
                                                            Form::text($name = 'specific_student_challenges_education', $value = !empty($enroll) ? $enroll->specific_student_challenges_education : '', 
                                                            $attributes = array(
                                                                'id' => 'specific_student_challenges_education',
                                                                'class' => 'form-control form-control-lg m-input m-input--solid'
                                                            )) 
                                                        }}
                                                    @else
                                                        {{ 
                                                            Form::text($name = 'specific_student_challenges_education', $value = !empty($enroll) ? $enroll->specific_student_challenges_education : '', 
                                                            $attributes = array(
                                                                'id' => 'specific_student_challenges_education',
                                                                'disabled' => 'disabled',
                                                                'class' => 'hidden form-control form-control-lg m-input m-input--solid'
                                                            )) 
                                                        }}
                                                    @endif
                                                    <span class="m-form__help">
                                                        Please select student learning challenges
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-wizard__form-step" id="m_wizard_form_step_4">
                                <div class="row">
                                    <div class="col-xl-8 offset-xl-2">
                                        <div class="m-form__section m-form__section--first">
                                            <div class="m-form__heading">
                                                <h3 class="m-form__heading-title">
                                                    Certification of Information
                                                </h3>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-12 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Please select the documents you will bring on the 1st day of the school year:
                                                    </label>
                                                    <div class="m-checkbox-list">
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            @if (!empty($enroll))
                                                                @php $documents = explode(',', $enroll->student_documents); @endphp
                                                            @else
                                                                @php $documents = array(); @endphp
                                                            @endif
                                                            @if (in_array('Original and photocopy of PSA birth certificate', $documents))
                                                                {{ Form::checkbox('student_documents[]', 'Original and photocopy of PSA birth certificate', true, array('')) }}
                                                            @else
                                                                {{ Form::checkbox('student_documents[]', 'Original and photocopy of PSA birth certificate', false, array('')) }}
                                                            @endif
                                                            Original and photocopy of PSA birth certificate
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            @if (in_array('Original and photocopy of Baptismal certificate', $documents))
                                                                {{ Form::checkbox('student_documents[]', 'Original and photocopy of Baptismal certificate', true, array('')) }}
                                                            @else
                                                                {{ Form::checkbox('student_documents[]', 'Original and photocopy of Baptismal certificate', false, array('')) }}
                                                            @endif
                                                            Original and photocopy of Baptismal certificate
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            @if (in_array('Good Moral certificate from the previous school', $documents))
                                                                {{ Form::checkbox('student_documents[]', 'Good Moral certificate from the previous school', true, array('')) }}
                                                            @else
                                                                {{ Form::checkbox('student_documents[]', 'Good Moral certificate from the previous school', false, array('')) }}
                                                            @endif
                                                            Good Moral certificate from the previous school
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            @if (in_array('2 pieces 2x2 recent photos', $documents))
                                                                {{ Form::checkbox('student_documents[]', '2 pieces 2x2 recent photos', true, array('')) }}
                                                            @else
                                                                {{ Form::checkbox('student_documents[]', '2 pieces 2x2 recent photos', false, array('')) }}
                                                            @endif
                                                            2 pieces 2x2 recent photos
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            @if (in_array('Certificate of Completion (for incoming Grades 1 and 7 applicants)', $documents))
                                                                {{ Form::checkbox('student_documents[]', 'Certificate of Completion (for incoming Grades 1 and 7 applicants)', true, array('')) }}
                                                            @else
                                                                {{ Form::checkbox('student_documents[]', 'Certificate of Completion (for incoming Grades 1 and 7 applicants)', false, array('')) }}
                                                            @endif
                                                            Certificate of Completion (for incoming Grades 1 and 7 applicants)
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            @if (in_array('Report Card', $documents))
                                                                {{ Form::checkbox('student_documents[]', 'Report Card', true, array('')) }}
                                                            @else
                                                                {{ Form::checkbox('student_documents[]', 'Report Card', false, array('')) }}
                                                            @endif
                                                            Report Card
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <span class="m-form__help">
                                                        Please select student documents to bring
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-12 m-form__group-sub">
                                                    <label class="form-control-label">
                                                    Please upload a photo or scanned copy of Original PSA Birth Certificate or any document with proof of identity. (School ID, Report Cards or any of the above mentioned):
                                                    </label>
                                                    <a href="javascript:;" class="btn btn-accent add-btn m-btn--custom" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#import-student-document">
                                                        <i class="la la-upload"></i> 
                                                        Import Documents
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-12 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Tuition Fee:
                                                    </label>
                                                    <div class="m-radio-list">
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->student_tuition_fee_types == 'Grade School (Nursery to Grade 6)')
                                                                {{ Form::radio('student_tuition_fee_types', 'Grade School (Nursery to Grade 6)', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('student_tuition_fee_types', 'Grade School (Nursery to Grade 6)', false, array('')) }}
                                                            @endif
                                                            Grade School (Nursery to Grade 6)
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->student_tuition_fee_types == 'Junior High School (Grade 7 to Grade 10)')
                                                                {{ Form::radio('student_tuition_fee_types', 'Junior High School (Grade 7 to Grade 10)', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('student_tuition_fee_types', 'Junior High School (Grade 7 to Grade 10)', false, array('')) }}
                                                            @endif
                                                            Junior High School (Grade 7 to Grade 10)
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->student_tuition_fee_types == 'Senior High School (Grade 11 to Grade 12)')
                                                                {{ Form::radio('student_tuition_fee_types', 'Senior High School (Grade 11 to Grade 12)', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('student_tuition_fee_types', 'Senior High School (Grade 11 to Grade 12)', false, array('')) }}
                                                            @endif
                                                            Senior High School (Grade 11 to Grade 12)
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <span class="m-form__help">
                                                        Please select types tuition fee
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-wizard__form-step" id="m_wizard_form_step_5">
                                <div class="row">
                                    <div class="col-xl-8 offset-xl-2">
                                        <div class="m-form__section m-form__section--first">
                                            <div class="m-form__heading">
                                                <h3 class="m-form__heading-title">
                                                    Billing Information
                                                </h3>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-12 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        Schedule and Mode of Payment
                                                    </label>
                                                    <br/>
                                                    <img class="payment_mode_schedule" src="{{ asset('img/gr1-gr6.png') }}">
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-12 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Choose your preferred terms of payment:
                                                    </label>
                                                    <div class="m-radio-list">
                                                        @foreach ($payment_terms as $payment_term)
                                                            <label class="m-radio m-radio--solid m-radio--brand">
                                                                @if (!empty($enroll) && $enroll->payment_term_id == $payment_term->id)
                                                                    {{ Form::radio('student_payment_terms', $payment_term->id, true, array('')) }}
                                                                @else
                                                                    {{ Form::radio('student_payment_terms', $payment_term->id, false, array('')) }}
                                                                @endif
                                                                {{ $payment_term->name }}
                                                                <span></span>
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                    <span class="m-form__help">
                                                        Please select preferred terms of payments
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-12 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Are you applying for a sibling discount (for 3rd child and up only):
                                                    </label>
                                                    <div class="m-radio-list">
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->student_sibling_discount == 'Yes')
                                                                {{ Form::radio('student_sibling_discount', 'Yes', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('student_sibling_discount', 'Yes', false, array('')) }}
                                                            @endif
                                                            Yes
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->student_sibling_discount == 'No')
                                                                {{ Form::radio('student_sibling_discount', 'No', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('student_sibling_discount', 'No', false, array('')) }}
                                                            @endif
                                                            No
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <span class="m-form__help">
                                                        Please select if applying discount
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-12 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Are you a registered ESC or government subsidy grantee:
                                                    </label>
                                                    <div class="m-radio-list">
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->student_subsidy_grantee == 'Yes')
                                                                {{ Form::radio('student_subsidy_grantee', 'Yes', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('student_subsidy_grantee', 'Yes', false, array('')) }}
                                                            @endif
                                                            Yes
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            @if (!empty($enroll) && $enroll->student_subsidy_grantee == 'No')
                                                                {{ Form::radio('student_subsidy_grantee', 'No', true, array('')) }}
                                                            @else
                                                                {{ Form::radio('student_subsidy_grantee', 'No', false, array('')) }}
                                                            @endif
                                                            No
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <span class="m-form__help">
                                                        Please select if subsidy grantee
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-12 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * What is your payment option:
                                                    </label>
                                                    <div class="m-radio-list">
                                                        @foreach ($payment_options as $payment_option)
                                                            <label class="m-radio m-radio--solid m-radio--brand">
                                                                @if (!empty($enroll) && $enroll->payment_option_id == $payment_option->id)
                                                                    {{ Form::radio('student_payment_option', $payment_option->id, true, array('')) }}
                                                                @else
                                                                    {{ Form::radio('student_payment_option', $payment_option->id, false, array('')) }}
                                                                @endif
                                                                {{ $payment_option->name }}
                                                                <span></span>
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                    <span class="m-form__help">
                                                        Please select preferred option of payments
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-wizard__form-step" id="m_wizard_form_step_6">
                                <div class="row">
                                    <div class="col-xl-8 offset-xl-2">
                                        <div class="m-form__section m-form__section--first">
                                            <div class="m-form__heading">
                                                <h3 class="m-form__heading-title">
                                                    Acknowledgement &amp; Confirmation
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-12 m-form__group-sub">
                                                <label class="form-control-label">
                                                    * I / we certify that the data are given herein and the accompanying documents are true and correct to the best of my / our knowledge and thus, misrepresentation is a sufficient reason for non-admission:
                                                </label>
                                                <div class="m-radio-list">
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        @if (!empty($enroll) && $enroll->student_acknowledge_1 == 'Yes, I acknowledge')
                                                            {{ Form::radio('student_acknowledge_1', 'Yes, I acknowledge', true, array('')) }}
                                                        @else
                                                            {{ Form::radio('student_acknowledge_1', 'Yes, I acknowledge', false, array('')) }}
                                                        @endif
                                                        Yes, I acknowledge
                                                        <span></span>
                                                    </label>
                                                </div>
                                                <span class="m-form__help">
                                                    Please select if acknowledge
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-12 m-form__group-sub">
                                                <label class="form-control-label">
                                                    * I also acknowledge that all official transactions and inquiries must be made via {{ $settings->email }}. I understand that the information shall be used by {{ ucwords($settings->name) }} for legitimate purposes and shall be processed by authorized personnel in accordance with the Data Privacy Policies of the School:
                                                </label>
                                                <div class="m-radio-list">
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        @if (!empty($enroll) && $enroll->student_acknowledge_2 == 'Yes, I acknowledge')
                                                            {{ Form::radio('student_acknowledge_2', 'Yes, I acknowledge', true, array('')) }}
                                                        @else
                                                            {{ Form::radio('student_acknowledge_2', 'Yes, I acknowledge', false, array('')) }}
                                                        @endif
                                                        Yes, I acknowledge
                                                        <span></span>
                                                    </label>
                                                </div>
                                                <span class="m-form__help">
                                                    Please select if acknowledge
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-12 m-form__group-sub">
                                                <label class="form-control-label">
                                                    * I will wait for the verification email from the Admissions Office ({{ $settings->email }}), that email will indicate the schedule of my interview (if any), school enrollment fees, and payment procedures:
                                                </label>
                                                <div class="m-radio-list">
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        @if (!empty($enroll) && $enroll->student_acknowledge_3 == 'Yes, I acknowledge')
                                                            {{ Form::radio('student_acknowledge_3', 'Yes, I acknowledge', true, array('')) }}
                                                        @else
                                                            {{ Form::radio('student_acknowledge_3', 'Yes, I acknowledge', false, array('')) }}
                                                        @endif
                                                        Yes, I acknowledge
                                                        <span></span>
                                                    </label>
                                                </div>
                                                <span class="m-form__help">
                                                    Please select if acknowledge
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-12 m-form__group-sub">
                                                <label class="form-control-label">
                                                    * I understand that all official transactions, inquiries, and corrections (if any) will be made via {{ $settings->email }} ONLY:
                                                </label>
                                                <div class="m-radio-list">
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        @if (!empty($enroll) && $enroll->student_acknowledge_4 == 'Yes, I acknowledge')
                                                            {{ Form::radio('student_acknowledge_4', 'Yes, I acknowledge', true, array('')) }}
                                                        @else
                                                            {{ Form::radio('student_acknowledge_4', 'Yes, I acknowledge', false, array('')) }}
                                                        @endif
                                                        Yes, I acknowledge
                                                        <span></span>
                                                    </label>
                                                </div>
                                                <span class="m-form__help">
                                                    Please select if acknowledge
                                                </span>
                                            </div>
                                        </div>
                                        <div class="{{ !empty($enroll) ? '' : 'hidden' }} form-group m-form__group row">
                                            <div class="col-lg-12">
                                                <div class="m-form__section m-form__section--first">
                                                    <div class="m-form__heading">
                                                        <h3 class="m-form__heading-title">
                                                            Assessment
                                                        </h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 m-form__group-sub">
                                                <label class="form-control-label">
                                                   Assign a class section
                                                </label>
                                                {{
                                                    Form::select('section_info_id', $sections, !empty($enroll) ? $enroll->section_info_id : '', ['id' => 'section_info_id', 'data-live-search' => 'true', 'class' => 'form-control form-control-lg m-input m-input--solid m-bootstrap-select m_selectpicker'])
                                                }}
                                            </div>
                                            <div class="col-lg-6 m-form__group-sub">
                                                <label class="form-control-label">
                                                   Assign a schedule
                                                </label>
                                                {{
                                                    Form::select('schedule_id', $schedules, !empty($enroll) ? $enroll->schedule_id : '', ['id' => 'section_info_id', 'data-live-search' => 'true', 'class' => 'form-control form-control-lg m-input m-input--solid m-bootstrap-select m_selectpicker'])
                                                }}
                                            </div>
                                            <div class="col-lg-6 m-form__group-sub">
                                                <label class="form-control-label" style="margin-top: 15px">
                                                   Check if fully assessed:
                                                </label>
                                                <div class="m-checkbox-list">
                                                    <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                        @if (!empty($enroll) && $enroll->status == 'assessed')
                                                            {{ Form::checkbox('student_status', 'assessed', true, array('')) }}
                                                        @else
                                                            {{ Form::checkbox('student_status', 'assessed', false, array('')) }}
                                                        @endif
                                                        <strong>Yes, I had already assessed the student</strong>
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-wizard__form-step" id="m_wizard_form_step_7">
                                <div class="row">
                                    <div class="col-xl-8 offset-xl-2">
                                        <div class="m-form__section m-form__section--first">
                                            <div class="m-form__heading">
                                                <h3 class="m-form__heading-title">
                                                    Sweet!
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-12 m-form__group-sub">
                                                <label class="form-control-label">
                                                    You have succesffully submited
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__foot m-portlet__foot--fit m--margin-top-40">
                            <div class="m-form__actions m-form__actions">
                                <div class="row">
                                    <div class="col-lg-2"></div>
                                    <div class="col-lg-4 m--align-left">
                                        <a href="#" class="btn btn-secondary m-btn m-btn--custom m-btn--icon" data-wizard-action="prev">
                                            <span>
                                                <i class="la la-arrow-left"></i>
                                                &nbsp;&nbsp;
                                                <span>
                                                    Back
                                                </span>
                                            </span>
                                        </a>
                                    </div>
                                    <div class="col-lg-4 m--align-right">
                                        <a href="#" class="btn btn-brand m-btn m-btn--custom m-btn--icon" data-wizard-action="submit">
                                            <span>
                                                <i class="la la-check"></i>
                                                &nbsp;&nbsp;
                                                <span>
                                                    @if ( !empty($enroll) )
                                                        Update
                                                    @else
                                                        Submit
                                                    @endif
                                                </span>
                                            </span>
                                        </a>
                                        <a href="#" class="btn btn-brand m-btn m-btn--custom m-btn--icon" data-wizard-action="next">
                                            <span>
                                                <span>
                                                    Save & Continue
                                                </span>
                                                &nbsp;&nbsp;
                                                <i class="la la-arrow-right"></i>
                                            </span>
                                        </a>
                                    </div>
                                    <div class="col-lg-2"></div>
                                </div>
                            </div>
                        </div>
                    </form>
                {{ Form::close() }}
            </div>
        </div>
    </div>	
    <div id="acknowledgement" class="hidden" style="width:100%; min-height: 100vh">
        <div class="m-grid__item m-grid__item--fluid m-grid  m-error-3" style="min-height: 100vh; background-image: url({{ asset('assets/app/media/img//error/bg3.jpg') }});">
            <div class="m-error_container row">
                <div class="col-md-12">
                    <p class="m-error_title m--font-light" style="margin-top: 20rem;">
                        Well done!
                    </p>
                    <p class="m-error_subtitle">
                        Your application has been successfully submitted.
                    </p>
                    <p class="m-error_description">
                        Please wait for our call while reviewing your application.
                        <br>
                        THANK YOU...
                    </p>
                </div>
            </div>
        </div>
    </div>		
</div>