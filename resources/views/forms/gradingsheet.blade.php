@inject('gradings', 'App\Http\Controllers\GradingSheetsController')
@if ( $segment == 'edit' )
    {{ Form::open(array('url' => 'academics/grading-sheets/all-gradingsheets/update/'.$grading->id, 'name' => 'gradingsheet_form', 'method' => 'PUT')) }}
@else
    {{ Form::open(array('url' => 'academics/grading-sheets/all-gradingsheets/store', 'name' => 'gradingsheet_form', 'method' => 'POST')) }}
@endif
    @if ($segment != 'edit' && $segment != 'view')
        <div class="row">
            <div class="col-md-12">
                <!-- BASIC INFOS START -->
                <div class="m-portlet m-portlet--tab">
                    <div class="m-portlet__body">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="m-bottom-1">Grading Sheet Information</h5>
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
                            <div class="col-md-12 hidden">
                                {{ 
                                    Form::text($name = 'gradingsheet_id', $value = !empty($grading) ? $grading->id : '', 
                                    $attributes = array(
                                        'id' => 'gradingsheet_id',
                                        'class' => 'form-control form-control-lg m-input m-input--solid'
                                    )) 
                                }}
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group m-form__group required">
                                    {{ Form::label('education_type_id', 'Education Type', ['class' => '']) }}
                                    {{  
                                        Form::select('education_type_id', $types, !empty($grading) ? $grading->education_type_id : '', ['class' => 'form-control form-control-lg m-input m-input--solid'])
                                    }}
                                    <span class="m-form__help m--font-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group m-form__group required">
                                    {{ Form::label('quarter_id', 'Quarter', ['class' => '']) }}
                                    {{  
                                        Form::select('quarter_id[]', $quarters, !empty($grading) ? $grading->quarter_id : '', ['id' => 'quarter_id', 'class' => 'form-control form-control-lg m-input m-input--solid m-bootstrap-select m_selectpicker', 'multiple'])
                                    }}
                                    <span class="m-form__help m--font-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group m-form__group required">
                                    {{ Form::label('section_info_id', 'Class', ['class' => '']) }}
                                    {{  
                                        Form::select('section_info_id', $sections, !empty($grading) ? $grading->section_info_id : '', ['class' => 'form-control form-control-lg m-input m-input--solid'])
                                    }}
                                    <span class="m-form__help m--font-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group m-form__group required">
                                    {{ Form::label('subject_id', 'Subject', ['class' => '']) }}
                                    {{  
                                        Form::select('subject_id', $subjects, !empty($grading) ? $grading->subject_id : '', ['class' => 'form-control form-control-lg m-input m-input--solid'])
                                    }}
                                    <span class="m-form__help m--font-danger"></span>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
                <!-- BASIC INFOS END -->
            </div>
        </div>
    @else
    <div class="row">
        <div class="col-md-12">
            <!-- BASIC INFOS START -->
            <div id="gradingsheet-layer" class="m-portlet m-portlet--tab">
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="m-bottom-1">Grading Sheet Information 
                                <a class="pull-right fullscreen" title="toggle to fullscreen" href="javascript:;">
                                    <i class="la la-arrows-alt"></i>
                                </a>
                            </h4>
                            <div class="row hidden">
                                <h5 id="type">{{ $grading->education_type_id }}</h5>
                                <div class="col-md-12 hidden">
                                    {{ 
                                        Form::text($name = 'gradingsheet_id', $value = !empty($grading) ? $grading->id : '', 
                                        $attributes = array(
                                            'id' => 'gradingsheet_id',
                                            'class' => 'form-control form-control-lg m-input m-input--solid'
                                        )) 
                                    }}
                                    {{ 
                                        Form::text($name = 'subject_id', $value = !empty($grading) ? $grading->subject_id : '', 
                                        $attributes = array(
                                            'id' => 'subject_id',
                                            'class' => 'form-control form-control-lg m-input m-input--solid'
                                        )) 
                                    }}
                                    {{ 
                                        Form::text($name = 'quarter_id', $value = !empty($grading) ? $grading->quarter_id : '', 
                                        $attributes = array(
                                            'id' => 'quarter_id',
                                            'class' => 'form-control form-control-lg m-input m-input--solid'
                                        )) 
                                    }}
                                    {{ 
                                        Form::text($name = 'section_info_id', $value = !empty($grading) ? $grading->section_info_id : '', 
                                        $attributes = array(
                                            'id' => 'section_info_id',
                                            'class' => 'form-control form-control-lg m-input m-input--solid'
                                        )) 
                                    }}
                                    {{
                                        Form::text($name = 'batch_id', $value = !empty($grading) ? $grading->batch_id : '', 
                                        $attributes = array(
                                            'id' => 'batch_id',
                                            'class' => 'form-control form-control-lg m-input m-input--solid'
                                        )) 
                                    }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>
                                        <strong>Level & Section:</strong>
                                        {{ $grading->level_name }} ({{ $grading->section_name }})
                                    </h5>
                                    <h5 class="m-bottom-2">
                                        <strong>Subject & Teacher:</strong> 
                                        {{ $grading->subject_name }} ({{ $grading->teacher }})
                                    </h5>
                                </div>
                                <div class="col-md-6">
                                    <h5>
                                        <strong>Quarter & Schoolyear:</strong> 
                                        {{ $grading->quarter_name }} ({{ $grading->batch_name }})
                                    </h5>
                                    <h5 class="m-bottom-2">
                                        <strong>Adviser:</strong>
                                        {{ $grading->adviser }}
                                    </h5>
                                </div>
                            </div>

                            @if ($grading->material_id == 1) 
                                @include('forms.gradingsheet-substance')
                            @elseif ($grading->material_id == 2) 
                                @include('forms.gradingsheet-conduct')
                            @elseif ($grading->material_id == 3) 
                                @include('forms.gradingsheet-homeroom')
                            @else
                                @include('forms.gradingsheet-co-curricular')
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        
    <div class="row {{ ($segment == 'edit')  ? '' : 'hidden' }}">
        <div class="col-md-12 ">
            <button type="button" class="btn btn-info pull-right m-2" data-toggle="modal" data-target="#importmodal">
                Import gradingsheet
            </button>
            <a href="{{ url('academics/grading-sheets/all-gradingsheets/export-gradingsheet/'.$grading->id) }}" >
                <button type="button" class="btn btn-success pull-right m-2">
                    Export gradingsheet
                </button>
            </a>
        </div>
    </div>

    @endif
{{ Form::close() }}