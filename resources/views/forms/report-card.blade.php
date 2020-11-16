{{ Form::open(array('url' => 'academics/grading-sheets/report-card/export-view', 'name' => 'reportcard_form', 'method' => 'POST')) }}
    <div class="row">
        <div class="col-md-12">
            <!-- BASIC INFOS START -->
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="m-bottom-1">Report Card Information</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group m-form__group required">
                                {{ Form::label('batch_id', 'Batch', ['class' => '']) }}
                                {{  
                                    Form::select('batch_id', $batches, '', ['id' => 'batch_id', 'class' => 'form-control form-control-lg m-input m-input--solid m-bootstrap-select m_selectpicker'])
                                }}
                                <span class="m-form__help m--font-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group m-form__group required">
                                {{ Form::label('education_type_id', 'Education Type', ['class' => '']) }}
                                {{  
                                    Form::select('education_type_id', $types, '', ['class' => 'form-control form-control-lg m-input m-input--solid m-bootstrap-select m_selectpicker'])
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
                                    Form::select('section_info_id', $sections, '', ['id' => 'section_info_id', 'class' => 'form-control form-control-lg m-input m-input--solid  m-bootstrap-select m_selectpicker'])
                                }}
                                <span class="m-form__help m--font-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group m-form__group required">
                                {{ Form::label('student_id', 'Student', ['class' => '']) }}
                                {{  
                                    Form::select('student_id', $students, '', ['id' => 'student_id', 'data-dropup-auto' => 'false', 'data-live-search' => 'true', 'class' => 'form-control form-control-lg m-input m-input--solid m-bootstrap-select m_selectpicker'])
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
{{ Form::close() }}