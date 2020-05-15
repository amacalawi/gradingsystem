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
                        
                        @if($sections_subjects)
                            @foreach($sections_subjects as $sections_subject)

                                <input value="{{ $sections_subject->id }}" name="sections_subjects[]" hidden>

                                <div class="col-md-6">
                                    <div class="form-group m-form__group required">
                                        
                                        <label>Subject</label>
                                        <select class="form-control form-control-lg m-input m-input--solid" id="subjects" name="subjects[]" placeholder="Please assign subject">
                                            <option value='NULL' > Please select subject </option>
                                            @foreach($allSubjects as $allSubject)
                                                {{ $found = 0 }}
                                                
                                                @if( $allSubject->id ==  $sections_subject->subject_id)
                                                    <option value='{{ $allSubject->id }}' selected> {{ $allSubject->name }} </option>
                                                    {{ $found = 1 }}
                                                @endif

                                                @if($found == 0)
                                                    <option value='{{ $allSubject->id }}'> {{ $allSubject->name }} </option>
                                                @endif

                                            @endforeach
                                            
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group m-form__group required">
                                        <label>Teacher</label>
                                        <select class="form-control form-control-lg m-input m-input--solid" id="teachers" name="teachers[]" placeholder="Please assign teacher">
                                            <option value='NULL' > Please select teacher </option>
                                            @foreach($allTeachers as $allTeacher)
                                                {{ $found = 0 }}
                                                
                                                @if( $allTeacher->id ==  $sections_subject->staff_id)
                                                    <option value='{{ $allTeacher->id }}' selected> {{ $allTeacher->lastname }}, {{ $allTeacher->firstname }} {{ $allTeacher->middlename }} ( {{ $allTeacher->user_id }} )</option>
                                                    {{ $found = 1 }}
                                                @endif

                                                @if($found == 0)
                                                    <option value='{{ $allTeacher->id }}'> {{ $allTeacher->lastname }}, {{ $allTeacher->firstname }} {{ $allTeacher->middlename }} ( {{ $allTeacher->user_id }} ) </option>
                                                @endif
                                                
                                            @endforeach
                                            
                                        </select>

                                    </div>
                                </div>
                            @endforeach

                            <div class="col-md-6">
                                <div class="form-group m-form__group required">
                                    <div id="option-subject" style="display:none;"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group m-form__group required">
                                    <div id="option-teacher" style="display:none;"></div>
                                </div>
                            </div>

                        @else
                            <div class="col-md-6">
                                <div class="form-group m-form__group required">
                                    <div id="option-subject"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group m-form__group required">
                                    <div id="option-teacher"></div>
                                </div>
                            </div>
                        @endif

                        <div class="col-md-6">
                            <button type="button" class="btn btn-success" id="subject-teacher-addrow">Add Row</button>
                        </div>

                    </div>
                </div>
            </div> 

            {{-- ENLIST STUDENT --}}
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__body">
                    <div class="row" id="subject-teacher-div">
                        
                        <div class="col-md-12">
                            <h5 class="m-bottom-1">Enlist Student</h5>
                        </div>

                        <div class="col-md-12">
                            <div id="admitted_student">
                                @if ( $segment == 'edit' )
                                    @foreach ( $sections_students as $sections_student)
                                        <input type='text' id="list_admitted_student" name='list_admitted_student[]' value='{{$sections_student->user_id}}' readonly='true' hidden>
                                        <button type='button' class='btn p-2 m-1 bg-secondary' >{{$sections_student->lastname}}, {{$sections_student->firstname}} {{$sections_student->middlename}}</button>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6" style="margin:10px 0px 0px 0px;">
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#enlist"> Add Student </button>
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