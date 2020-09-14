@if ( $segment == 'edit' )
    {{ Form::open(array('url' => 'components/csv-management/gradingsheet-template-01/update/'.$template->id, 'name' => 'gradingsheet_template_form', 'method' => 'PUT')) }}
@else
    {{ Form::open(array('url' => 'components/csv-management/gradingsheet-template-01/store', 'name' => 'gradingsheet_template_form', 'method' => 'POST')) }}
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
                {{ Form::label('identification_no', 'Identification No', ['class' => '']) }}
                {{ 
                    Form::text($name = 'identification_no', $value = $template->identification_no, 
                    $attributes = array(
                        'id' => 'identification_no',
                        'class' => 'form-control form-control-lg m-input m-input--solid'
                    )) 
                }}
                <span class="m-form__help m--font-danger">
                </span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group m-form__group required">
                {{ Form::label('grade_level', 'Level', ['class' => '']) }}
                {{
                    Form::select('grade_level', $levels, $value = $template->grade_level, ['class' => 'form-control form-control-lg m-input m-input--solid'])
                }}
                <span class="m-form__help m--font-danger"></span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group m-form__group required">
                {{ Form::label('section', 'Section', ['class' => '']) }}
                {{
                    Form::select('section', $sections, $value = $template->section, ['class' => 'form-control form-control-lg m-input m-input--solid'])
                }}
                <span class="m-form__help m--font-danger"></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group m-form__group required">
                {{ Form::label('firstname', 'Firstname', ['class' => '']) }}
                {{ 
                    Form::text($name = 'firstname', $value = $template->firstname, 
                    $attributes = array(
                        'id' => 'firstname',
                        'class' => 'form-control form-control-lg m-input m-input--solid'
                    )) 
                }}
                <span class="m-form__help m--font-danger">
                </span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group m-form__group required">
                {{ Form::label('middlename', 'Middlename', ['class' => '']) }}
                {{ 
                    Form::text($name = 'middlename', $value = $template->middlename, 
                    $attributes = array(
                        'id' => 'middlename',
                        'class' => 'form-control form-control-lg m-input m-input--solid'
                    )) 
                }}
                <span class="m-form__help m--font-danger">
                </span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group m-form__group required">
                {{ Form::label('lastname', 'Lastname', ['class' => '']) }}
                {{ 
                    Form::text($name = 'lastname', $value = $template->lastname, 
                    $attributes = array(
                        'id' => 'lastname',
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
            <div class="form-group m-form__group required">
                {{ Form::label('adviser', 'Adviser', ['class' => '']) }}
                {{ 
                    Form::text($name = 'adviser', $value = $template->adviser, 
                    $attributes = array(
                        'id' => 'adviser',
                        'class' => 'form-control form-control-lg m-input m-input--solid'
                    )) 
                }}
                <span class="m-form__help m--font-danger">
                </span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group m-form__group required">
                {{ Form::label('eligibility', 'Eligibility', ['class' => '']) }}
                {{ 
                    Form::text($name = 'eligibility', $value = $template->eligibility, 
                    $attributes = array(
                        'id' => 'eligibility',
                        'class' => 'form-control form-control-lg m-input m-input--solid'
                    )) 
                }}
                <span class="m-form__help m--font-danger">
                </span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group m-form__group required">
                {{ Form::label('academics_status', 'Academic Status', ['class' => '']) }}
                {{
                    Form::select('academics_status',  array('' => 'select an academic status', 'Passed' => 'Passed', 'Failed' => 'Failed'), $value = $template->academics_status, ['class' => 'form-control form-control-lg m-input m-input--solid'])
                }}
                <span class="m-form__help m--font-danger"></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group m-form__group required">
                {{ Form::label('remarks', 'Remarks', ['class' => '']) }}
                {{ 
                    Form::textarea($name = 'remarks', $value = $template->remarks, 
                    $attributes = array(
                        'id' => 'remarks',
                        'class' => 'form-control form-control-lg m-input m-input--solid',
                        'rows' => 3
                    )) 
                }}
                <span class="m-form__help m--font-danger">
                </span>
            </div>
        </div>
    </div>
{{ Form::close() }}