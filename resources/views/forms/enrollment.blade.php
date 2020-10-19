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
                    <form action="{{ url('enrollment/store') }}" method="POST" name="enrollment_form" class="m-form m-form--label-align-left- m-form--state-" id="m_form">
                        <div class="m-portlet__body">
                            <div class="m-wizard__form-step m-wizard__form-step--current" id="m_wizard_form_step_1">
                                <div class="row">
                                    <div class="col-xl-8 offset-xl-2">
                                        <div class="m-form__section m-form__section--first">
                                            <div class="m-form__heading">
                                                <h3 class="m-form__heading-title">
                                                    Student Details
                                                </h3>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">
                                                    * Email:
                                                </label>
                                                <div class="col-xl-9 col-lg-9">
                                                    <input id="student_email" class="bold form-control form-control-lg m-input m-input--solid " name="student_email" type="email" value="">
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
                                                            <input type="radio" name="is_new" value="1">
                                                            Yes
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="is_new" value="0">
                                                            No
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <span class="m-form__help">
                                                        Please select yes if new student otherwise no if return student
                                                    </span>
                                                </div>
                                            </div>
                                            <div id="student-row" class="hidden form-group m-form__group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">
                                                    * Student No:
                                                </label>
                                                <div class="col-xl-9 col-lg-9">
                                                    <div class="row">
                                                        <div class="col-xl-8">
                                                            <input id="student_number" class="hidden bold form-control form-control-lg m-input m-input--solid " name="student_number" type="text" value="">
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
                                                    <input id="lrn_no" class="bold form-control form-control-lg m-input m-input--solid " name="lrn_no" type="text" value="">
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
                                                    <input id="psa_no" class="form-control form-control-lg m-input m-input--solid " name="psa_no" type="text" value="">
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
                                                    <input id="student_firstname" class="form-control form-control-lg m-input m-input--solid " name="student_firstname" type="text" value="">
                                                    <span class="m-form__help">
                                                        Please enter student's firstname
                                                    </span>
                                                </div>
                                                <div class="col-lg-4 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        Student's Middlename:
                                                    </label>
                                                    <input id="student_middlename" class="form-control form-control-lg m-input m-input--solid " name="student_middlename" type="text" value="">
                                                    <span class="m-form__help">
                                                        Please enter student's middlename
                                                    </span>
                                                </div>
                                                <div class="col-lg-4 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Student's Lastname:
                                                    </label>
                                                    <input id="student_lastname" class="form-control form-control-lg m-input m-input--solid " name="student_lastname" type="text" value="">
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
                                                    <input id="student_birthdate" class="form-control form-control-lg m-input m-input--solid " name="student_birthdate" type="date" value="">
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
                                                            <input type="radio" name="student_gender" value="Male">
                                                            Male
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="student_gender" value="Female">
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
                                                            <input type="radio" name="student_birthorder" value="Only Child">
                                                            Only Child
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="student_birthorder" value="Eldest">
                                                            Eldest
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="student_birthorder" value="Youngest">
                                                            Youngest
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="student_birthorder" value="Middle">
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
                                                            <input type="radio" name="student_reside_with" value="Parents">
                                                            Parents
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="student_reside_with" value="Guardians">
                                                            Guardians
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="student_reside_with" value="Relatives">
                                                            Relatives
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="student_reside_with" value="Others">
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
                                                    <textarea id="student_address" col="3" class="form-control form-control-lg m-input m-input--solid " name="student_address"></textarea>
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
                                                    <textarea id="student_barangay" col="3" class="form-control form-control-lg m-input m-input--solid " name="student_barangay"></textarea>
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
                                                    <textarea id="student_last_attended" col="3" class="form-control form-control-lg m-input m-input--solid " name="student_last_attended"></textarea>
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
                                                    <textarea id="student_transfer_reason" col="3" class="form-control form-control-lg m-input m-input--solid " name="student_transfer_reason"></textarea>
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
                                                    <input id="father_firstname" class="form-control form-control-lg m-input m-input--solid " name="father_firstname" type="text" value="">
                                                    <span class="m-form__help">
                                                        Please enter father's firstname
                                                    </span>
                                                </div>
                                                <div class="col-lg-4 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        Father's Middlename:
                                                    </label>
                                                    <input id="father_middlename" class="form-control form-control-lg m-input m-input--solid " name="father_middlename" type="text" value="">
                                                    <span class="m-form__help">
                                                        Please enter father's middlename
                                                    </span>
                                                </div>
                                                <div class="col-lg-4 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Father's Lastname:
                                                    </label>
                                                    <input id="father_lastname" class="form-control form-control-lg m-input m-input--solid " name="father_lastname" type="text" value="">
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
                                                    <input id="father_contact" class="form-control form-control-lg m-input m-input--solid " name="father_contact" type="text" value="">
                                                    <span class="m-form__help">
                                                        Please enter father's mobile number
                                                    </span>
                                                </div>
                                                <div class="col-lg-4 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Father's Birthdate:
                                                    </label>
                                                    <input id="father_birthdate" class="form-control form-control-lg m-input m-input--solid " name="father_birthdate" type="date" value="">
                                                    <span class="m-form__help">
                                                        Please enter father's birthdate
                                                    </span>
                                                </div>
                                                <div class="col-lg-4 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Father's Birthplace:
                                                    </label>
                                                    <input id="father_birthplace" class="form-control form-control-lg m-input m-input--solid " name="father_birthplace" type="text" value="">
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
                                                    <textarea id="father_address" col="3" class="form-control form-control-lg m-input m-input--solid " name="father_address"></textarea>
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
                                                            <input type="radio" name="father_religion" value="Roman Catholic">
                                                            Roman Catholic
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="father_religion" value="Other">
                                                            Other
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <input id="father_specific_religion" disabled="disabled" class="hidden form-control form-control-lg m-input m-input--solid " name="father_specific_religion" type="text" value="">
                                                    <span class="m-form__help">
                                                        Please enter specific religion
                                                    </span>
                                                </div>
                                                <div class="col-lg-6 m-form__group-sub"> 
                                                    <label class="form-control-label">
                                                        Father's Occupation:
                                                    </label>
                                                    <input id="father_occupation" class="form-control form-control-lg m-input m-input--solid " name="father_occupation" type="text" value="">
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
                                                            <input type="radio" name="father_education" value="Elementary">
                                                            Elementary
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="father_education" value="High School">
                                                            High School
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="father_education" value="Undergraduate">
                                                            Undergraduate
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="father_education" value="College">
                                                            College
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="father_education" value="College">
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
                                                            <input type="radio" name="father_employment_status" value="Full Time">
                                                            Full Time
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="father_employment_status" value="Part Time">
                                                            Part Time
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="father_employment_status" value="Self Employed (i.e. Family Business)">
                                                            Self Employed (i.e. Family Business)
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="father_employment_status" value="Unemployed due to community quarantine">
                                                            Unemployed due to community quarantine
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
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
                                                            <input type="radio" name="father_workplace" value="In the Philippines">
                                                            In the Philippines
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="father_workplace" value="Abroad">
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
                                                            <input type="radio" name="father_work_quarantine" value="Yes">
                                                            Yes
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="father_work_quarantine" value="No">
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
                                                    <input id="mother_firstname" class="form-control form-control-lg m-input m-input--solid " name="mother_firstname" type="text" value="">
                                                    <span class="m-form__help">
                                                        Please enter mother's firstname
                                                    </span>
                                                </div>
                                                <div class="col-lg-4 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        Mother's Middlename:
                                                    </label>
                                                    <input id="mother_middlename" class="form-control form-control-lg m-input m-input--solid " name="mother_middlename" type="text" value="">
                                                    <span class="m-form__help">
                                                        Please enter mother's middlename
                                                    </span>
                                                </div>
                                                <div class="col-lg-4 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Mother's Lastname:
                                                    </label>
                                                    <input id="mother_lastname" class="form-control form-control-lg m-input m-input--solid " name="mother_lastname" type="text" value="">
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
                                                    <input id="mother_maidenname" class="form-control form-control-lg m-input m-input--solid " name="mother_maidenname" type="text" value="">
                                                    <span class="m-form__help">
                                                        Please enter mother's maiden name
                                                    </span>
                                                </div>
                                                <div class="col-lg-6 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Mother's Mobile Number:
                                                    </label>
                                                    <input id="mother_contact" class="form-control form-control-lg m-input m-input--solid " name="mother_contact" type="text" value="">
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
                                                    <input id="mother_birthdate" class="form-control form-control-lg m-input m-input--solid " name="mother_birthdate" type="date" value="">
                                                    <span class="m-form__help">
                                                        Please enter mother's birthdate
                                                    </span>
                                                </div>
                                                <div class="col-lg-6 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Mother's Birthplace:
                                                    </label>
                                                    <input id="mother_birthplace" class="form-control form-control-lg m-input m-input--solid " name="mother_birthplace" type="text" value="">
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
                                                    <textarea id="mother_address" col="3" class="form-control form-control-lg m-input m-input--solid " name="mother_address"></textarea>
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
                                                            <input type="radio" name="mother_religion" value="Roman Catholic">
                                                            Roman Catholic
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="mother_religion" value="Other">
                                                            Other
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <input id="mother_specific_religion" disabled="disabled" class="hidden form-control form-control-lg m-input m-input--solid " name="mother_specific_religion" type="text" value="">
                                                    <span class="m-form__help">
                                                        Please enter specific religion
                                                    </span>
                                                </div>
                                                <div class="col-lg-6 m-form__group-sub"> 
                                                    <label class="form-control-label">
                                                        Mother's Occupation:
                                                    </label>
                                                    <input id="mother_occupation" class="form-control form-control-lg m-input m-input--solid " name="mother_occupation" type="text" value="">
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
                                                            <input type="radio" name="mother_education" value="Elementary">
                                                            Elementary
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="mother_education" value="High School">
                                                            High School
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="mother_education" value="Undergraduate">
                                                            Undergraduate
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="mother_education" value="College">
                                                            College
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="mother_education" value="College">
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
                                                            <input type="radio" name="mother_employment_status" value="Full Time">
                                                            Full Time
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="mother_employment_status" value="Part Time">
                                                            Part Time
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="mother_employment_status" value="Self Employed (i.e. Family Business)">
                                                            Self Employed (i.e. Family Business)
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="mother_employment_status" value="Unemployed due to community quarantine">
                                                            Unemployed due to community quarantine
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="mother_employment_status" value="NOT Working">
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
                                                            <input type="radio" name="mother_workplace" value="In the Philippines">
                                                            In the Philippines
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="mother_workplace" value="Abroad">
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
                                                            <input type="radio" name="mother_work_quarantine" value="Yes">
                                                            Yes
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="mother_work_quarantine" value="No">
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
                                                            <input type="radio" name="parent_marriage_status" value="Living Together">
                                                            Living Together
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="parent_marriage_status" value="Single Parent">
                                                            Single Parent
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="parent_marriage_status" value="Separated">
                                                            Separated
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="parent_marriage_status" value="Widow/Widower">
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
                                                    <input id="guardian_firstname" class="form-control form-control-lg m-input m-input--solid " name="guardian_firstname" type="text" value="">
                                                    <span class="m-form__help">
                                                        Please enter guardian's firstname
                                                    </span>
                                                </div>
                                                <div class="col-lg-4 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        Guardian's Middlename:
                                                    </label>
                                                    <input id="guardian_middlename" class="form-control form-control-lg m-input m-input--solid " name="guardian_middlename" type="text" value="">
                                                    <span class="m-form__help">
                                                        Please enter guardian's middlename
                                                    </span>
                                                </div>
                                                <div class="col-lg-4 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Guardian's Lastname:
                                                    </label>
                                                    <input id="guardian_lastname" class="form-control form-control-lg m-input m-input--solid " name="guardian_lastname" type="text" value="">
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
                                                    <input id="guardian_relationship" class="form-control form-control-lg m-input m-input--solid " name="guardian_relationship" type="text" value="">
                                                    <span class="m-form__help">
                                                        Please enter guardian's relationship to student
                                                    </span>
                                                </div>
                                                <div class="col-lg-6 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * Guardian's Mobile Number:
                                                    </label>
                                                    <input id="guardian_contact" class="form-control form-control-lg m-input m-input--solid " name="guardian_contact" type="text" value="">
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
                                                            <input type="radio" name="guardian_employment_status" value="Full Time">
                                                            Full Time
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="guardian_employment_status" value="Part Time">
                                                            Part Time
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="guardian_employment_status" value="Self Employed (i.e. Family Business)">
                                                            Self Employed (i.e. Family Business)
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="guardian_employment_status" value="Unemployed due to community quarantine">
                                                            Unemployed due to community quarantine
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="guardian_employment_status" value="NOT Working">
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
                                                            <input type="radio" name="guardian_work_quarantine" value="Yes">
                                                            Yes
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="guardian_work_quarantine" value="No">
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
                                                            <input type="radio" name="family_4ps" value="Yes">
                                                            Yes
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="family_4ps" value="No">
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
                                                    <input id="student_siblings" class="form-control form-control-lg m-input m-input--solid " name="student_siblings" type="text" value="">
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
                                                    <input id="student_previous_academic" class="form-control form-control-lg m-input m-input--solid " name="student_previous_academic" type="text" value="">
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
                                                            <input type="checkbox" name="student_transpo[]" value="Walking">
                                                            Walking
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            <input type="checkbox" name="student_transpo[]" value="Public Commute">
                                                            Public Commute
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            <input type="checkbox" name="student_transpo[]" value="Family-owned Vehicle">
                                                            Family-owned Vehicle
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            <input type="checkbox" name="student_transpo[]" value="School Service">
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
                                                            <input type="radio" name="student_studying" value="1">
                                                            1
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="student_studying" value="2">
                                                            2
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="student_studying" value="3">
                                                            3
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="student_studying" value="Other">
                                                            Other
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <input id="specific_student_studying" disabled="disabled" class="hidden form-control form-control-lg m-input m-input--solid " name="specific_student_studying" type="text" value="">
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
                                                            <input type="radio" name="student_supplies" value="Parents/Guardian">
                                                            Parents/Guardian
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="student_supplies" value="Elder siblings">
                                                            Elder siblings
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="student_supplies" value="Grandparents">
                                                            Grandparents
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="checkbox" name="student_supplies" value="Extended Members of the family">
                                                            Extended Members of the family
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="checkbox" name="student_supplies" value="Others (tutor, house helper)">
                                                            Others (tutor, house helper)
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="checkbox" name="student_supplies" value="None">
                                                            None
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="checkbox" name="student_supplies" value="Able to do independent learning">
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
                                                            <input type="checkbox" name="student_devices[]" value="Cable TV">
                                                            Cable TV
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            <input type="checkbox" name="student_devices[]" value="Non-Cable TV">
                                                            Non-Cable TV
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            <input type="checkbox" name="student_devices[]" value="Basic Telephone">
                                                            Basic Telephone
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            <input type="checkbox" name="student_devices[]" value="Smartphone">
                                                            Smartphone
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            <input type="checkbox" name="student_devices[]" value="Tablet / Ipad">
                                                            Tablet / Ipad
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            <input type="checkbox" name="student_devices[]" value="Radio">
                                                            Radio
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            <input type="checkbox" name="student_devices[]" value="Desktop Computer">
                                                            Desktop Computer
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            <input type="checkbox" name="student_devices[]" value="Laptop / Netbook">
                                                            Laptop / Netbook
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            <input type="checkbox" name="student_devices[]" value="None">
                                                            None
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            <input type="checkbox" name="student_devices[]" value="Other">
                                                            Other
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <input id="specific_student_devices" disabled="disabled" class="hidden form-control form-control-lg m-input m-input--solid " name="specific_student_devices" type="text" value="">
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
                                                            <input type="radio" name="student_with_internet" value="Yes">
                                                            Yes
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="student_with_internet" value="No">
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
                                                            <input type="checkbox" name="student_internet_connection[]" value="Own mobile data">
                                                            Own mobile data
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            <input type="checkbox" name="student_internet_connection[]" value="Own broadband internet (DSL, wireless fiber, satellite)">
                                                            Own broadband internet (DSL, wireless fiber, satellite)
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            <input type="checkbox" name="student_internet_connection[]" value="Computer Shop">
                                                            Computer Shop
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            <input type="checkbox" name="student_internet_connection[]" value="Other places outside the home (e.g. library, neighbor, relatives, barangay)">
                                                            Other places outside the home (e.g. library, neighbor, relatives, barangay)
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            <input type="checkbox" name="student_internet_connection[]" value="None">
                                                            None
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <input id="specific_student_devices[]" disabled="disabled" class="hidden form-control form-control-lg m-input m-input--solid " name="specific_student_devices[]" type="text" value="">
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
                                                            <input type="radio" name="student_describe_internet" value="Stable, fast, can stream audio/videos while surfing other websites/apps">
                                                            Stable, fast, can stream audio/videos while surfing other websites/apps
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="student_describe_internet" value="Stable, slow, can stream audio/videos but can't surf websites/apps">
                                                            Stable, slow, can stream audio/videos but can't surf websites/apps
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="student_describe_internet" value="Disconnects constantly, fast, can stream videos while surfing other websites/apps">
                                                            Disconnects constantly, fast, can stream videos while surfing other websites/apps
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="student_describe_internet" value="Disconnects constantly, slow, can surf only 1-2 website/app at a given time">
                                                            Disconnects constantly, slow, can surf only 1-2 website/app at a given time
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="student_describe_internet" value="I have to go out of the house so I can have an internet connection">
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
                                                            <input type="radio" name="student_learning_modality" value="Online Learning (Virtual Classes + Textbook + Online Modules accessible to our learning management system platform)">
                                                            Online Learning (Virtual Classes + Textbook + Online Modules accessible to our learning management system platform)
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="student_learning_modality" value="Printed Modular Learning (Scheduled Virtual Classes + Textbooks + hardcopy materials for those with no or weak internet connections)">
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
                                                            <input type="radio" name="student_learning_delivery" value="FULL BLENDED distance learning for the whole school year (Textbook, modular, and ONLINE LEARNING FROM HOME)">
                                                            FULL BLENDED distance learning for the whole school year (Textbook, modular, and ONLINE LEARNING FROM HOME)
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="student_learning_delivery" value="Flexible distance learning at home (Textbook, modular, online) with twice a month face to face sessions from October 2020 to April 2021 (only when the government allows; applicable only for Junior and Senior High School)">
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
                                                            <input type="checkbox" name="student_challenges_education[]" value="lack of available gadgets/ equipment">
                                                            lack of available gadgets/ equipment
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            <input type="checkbox" name="student_challenges_education[]" value="insufficient load/ data allowance">
                                                            insufficient load/ data allowance
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            <input type="checkbox" name="student_challenges_education[]" value="unstable mobile/ internet connection">
                                                            unstable mobile/ internet connection
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            <input type="checkbox" name="student_challenges_education[]" value="existing health condition/s">
                                                            existing health condition/s
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            <input type="checkbox" name="student_challenges_education[]" value="difficulty in independent learning">
                                                            difficulty in independent learning
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            <input type="checkbox" name="student_challenges_education[]" value="conflict with other activities (i.e., house chores)">
                                                            conflict with other activities (i.e., house chores)
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            <input type="checkbox" name="student_challenges_education[]" value="No or lack of available space for studying">
                                                            No or lack of available space for studying
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            <input type="checkbox" name="student_challenges_education[]" value="distractions (i.e., social media, noise from community/neighbor)">
                                                            distractions (i.e., social media, noise from community/neighbor)
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            <input type="checkbox" name="student_challenges_education[]" value="Other">
                                                            Other
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <input id="specific_student_challenges_education" disabled="disabled" class="hidden form-control form-control-lg m-input m-input--solid " name="specific_student_challenges_education" type="text" value="">
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
                                                            <input type="checkbox" name="student_documents[]" value="Original and photocopy of PSA birth certificate">
                                                            Original and photocopy of PSA birth certificate
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            <input type="checkbox" name="student_documents[]" value="Original and photocopy of Baptismal certificate">
                                                            Original and photocopy of Baptismal certificate
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            <input type="checkbox" name="student_documents[]" value="Good Moral certificate from the previous school">
                                                            Good Moral certificate from the previous school
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            <input type="checkbox" name="student_documents[]" value="2 pieces 2x2 recent photos">
                                                            2 pieces 2x2 recent photos
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            <input type="checkbox" name="student_documents[]" value="Certificate of Completion (for incoming Grades 1 and 7 applicants)">
                                                            Certificate of Completion (for incoming Grades 1 and 7 applicants)
                                                            <span></span>
                                                        </label>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            <input type="checkbox" name="student_documents[]" value="Report Card">
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
                                                            <input type="radio" name="student_tuition_fee_types" value="Grade School (Nursery to Grade 6)">
                                                            Grade School (Nursery to Grade 6)
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="student_tuition_fee_types" value="Junior High School (Grade 7 to Grade 10)">
                                                            Junior High School (Grade 7 to Grade 10)
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="student_tuition_fee_types" value="Senior High School (Grade 11 to Grade 12)">
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
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="student_payment_terms" value="1">
                                                            Whole Year / Annual or Cash Basis
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="student_payment_terms" value="2">
                                                            Semestral
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="student_payment_terms" value="3">
                                                            Monthly Option 1
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="student_payment_terms" value="4">
                                                            Monthly Option 2
                                                            <span></span>
                                                        </label>
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
                                                            <input type="radio" name="student_sibling_discount" value="Yes">
                                                            Yes
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="student_sibling_discount" value="No">
                                                            No
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <span class="m-form__help">
                                                        Please select preferred terms of payments
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
                                                            <input type="radio" name="student_subsidy_grantee" value="Yes">
                                                            Yes
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="student_subsidy_grantee" value="No">
                                                            No
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <span class="m-form__help">
                                                        Please select preferred terms of payments
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-12 m-form__group-sub">
                                                    <label class="form-control-label">
                                                        * What is your payment option:
                                                    </label>
                                                    <div class="m-radio-list">
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="student_payment_option" value="1">
                                                            Online (I will pay thru online banking or deposit payment to bank)
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--solid m-radio--brand">
                                                            <input type="radio" name="student_payment_option" value="2">
                                                            Onsite (I will pay in the school Cashier's Office)
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <span class="m-form__help">
                                                        Please select preferred terms of payments
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
                                                        <input type="radio" name="student_acknowledge_1" value="Yes, I acknowledge">
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
                                                    * I also acknowledge that all official transactions and inquiries must be made via admission@sasmanila.edu.ph. I understand that the information shall be used by St. Anthony School, Manila for legitimate purposes and shall be processed by authorized personnel in accordance with the Data Privacy Policies of the School:
                                                </label>
                                                <div class="m-radio-list">
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" name="student_acknowledge_2" value="Yes, I acknowledge">
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
                                                    * I will wait for the verification email from the Admissions Office (admission@sasmanila.edu.ph), that email will indicate the schedule of my interview (if any), school enrollment fees, and payment procedures:
                                                </label>
                                                <div class="m-radio-list">
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" name="student_acknowledge_3" value="Yes, I acknowledge">
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
                                                    * I understand that all official transactions, inquiries, and corrections (if any) will be made via admission@sasmanila.edu.ph ONLY:
                                                </label>
                                                <div class="m-radio-list">
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" name="student_acknowledge_4" value="Yes, I acknowledge">
                                                        Yes, I acknowledge
                                                        <span></span>
                                                    </label>
                                                </div>
                                                <span class="m-form__help">
                                                    Please select if acknowledge
                                                </span>
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
                                                    Submit
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
                </div>
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