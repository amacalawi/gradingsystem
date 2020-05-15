@if ( $segment == 'edit' )
    {{ Form::open(array('url' => 'academics/academics/sections/update/'.$section->id, 'name' => 'section_form', 'method' => 'PUT')) }}
@else
    {{ Form::open(array('url' => 'academics/academics/sections/store', 'name' => 'section_form', 'method' => 'POST')) }}
@endif
    <div class="row">
        <div class="col-md-9">
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__body">

                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="m-bottom-1">Section Details</h5>
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
                        <div class="col-md-6">
                            <div class="form-group m-form__group required">
                                <span class="m-form__help m--font-danger">
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group m-form__group required">
                                <span class="m-form__help m--font-danger">
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group m-form__group required">
                                {{ Form::label('code', 'Code', ['class' => '']) }}
                                {{ 
                                    Form::text($name = 'code', $value = $section->code, 
                                    $attributes = array(
                                        'id' => 'code',
                                        'class' => 'form-control form-control-lg m-input m-input--solid'
                                    )) 
                                }}
                                <span class="m-form__help m--font-danger">
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group m-form__group required">
                                {{ Form::label('name', 'Name', ['class' => '']) }}
                                {{ 
                                    Form::text($name = 'name', $value = $section->name, 
                                    $attributes = array(
                                        'id' => 'name',
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
                                {{ Form::label('description', 'Description', ['class' => '']) }}
                                {{ 
                                    Form::textarea($name = 'description', $value = $section->description, 
                                    $attributes = array(
                                        'id' => 'description',
                                        'class' => 'form-control form-control-lg m-input m-input--solid',
                                        'rows' => 3
                                    )) 
                                }}
                                <span class="m-form__help m--font-danger">
                                </span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__body">
                    <div class="row" id="subject-teacher-div">
                        <div class="col-md-12">
                            <h5 class="m-bottom-1">Subjects and Teacher</h5>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group m-form__group required">
                                {{--
                                {{ Form::label('subject', 'Subject', ['class' => '']) }}
                                {{  
                                    Form::select('subject_id', $subjects, !empty($section) ? $section->level_id : '', ['class' => 'form-control form-control-lg m-input m-input--solid'])
                                }}
                                <span class="m-form__help m--font-danger">
                                </span>
                                --}}
                                <div id="option-subject"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group m-form__group required">
                                {{--
                                {{ Form::label('teacher', 'Teacher', ['class' => '']) }}
                                {{  
                                    Form::select('staff_id', $staffs, !empty($section) ? $section->level_id : '', ['class' => 'form-control form-control-lg m-input m-input--solid'])
                                }}
                                <span class="m-form__help m--font-danger">
                                </span>
                                --}}
                                <div id="option-teacher"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <button type="button" class="btn btn-success" id="subject-teacher-addrow">Add Row</button>
                        </div>

                    </div>
                </div>
            </div> 

        </div>

        <div class="col-md-3">
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__body">
                    <div class="row">

                        <div class="col-md-12">
                            <h5 class="m-bottom-1">Levels</h5>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group m-form__group required">
                                {{ Form::label('level', 'Level', ['class' => '']) }}
                                {{  
                                    Form::select('level_id', $levels, !empty($section) ? $section->level_id : '', ['class' => 'form-control form-control-lg m-input m-input--solid'])
                                }}
                                <span class="m-form__help m--font-danger">
                                </span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


        
    </div>                

{{ Form::close() }}