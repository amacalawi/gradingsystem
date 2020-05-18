@inject('gradings', 'App\Http\Controllers\GradingSheetsController')
@if ( $segment == 'edit' )
    {{ Form::open(array('url' => 'academics/grading-sheets/all-gradingsheets/update/'.$staff->id, 'name' => 'staff_form', 'method' => 'PUT')) }}
@else
    {{ Form::open(array('url' => 'academics/grading-sheets/all-gradingsheets/store', 'name' => 'staff_form', 'method' => 'POST')) }}
@endif
    @if ($segment != 'edit')
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
                            <div class="col-md-12">
                                <div class="form-group m-form__group required">
                                    {{ Form::label('section_id', 'Select Section', ['class' => '']) }}
                                    {{  
                                        Form::select('section_id', $sections, !empty($grading) ? $grading->section_id : '', ['class' => 'form-control form-control-lg m-input m-input--solid'])
                                    }}
                                    <span class="m-form__help m--font-danger"></span>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
                <!-- BASIC INFOS END -->
            </div>
            <div class="col-md-3">
                <!-- Quarter TYPE -->
                <div class="m-portlet m-portlet--tab">
                    <div class="m-portlet__body">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="m-bottom-1">Quarter</h5>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group m-form__group required">
                                    {{ Form::label('quarter_id', 'Select Quarter', ['class' => '']) }}
                                    {{  
                                        Form::select('quarter_id', $quarters, !empty($grading) ? $grading->quarter_id : '', ['class' => 'form-control form-control-lg m-input m-input--solid'])
                                    }}
                                    <span class="m-form__help m--font-danger"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- QUARTER END -->
            </div>
        </div>
    @else

    @endif
{{ Form::close() }}
