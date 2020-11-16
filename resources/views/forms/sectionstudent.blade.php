@if ( $segment == 'edit' )
    {{ Form::open(array('url' => 'academics/admissions/classes/update/'.$sectioninfos->id, 'name' => 'sectionstudent_form', 'method' => 'PUT')) }}
@else
    {{ Form::open(array('url' => 'academics/admissions/classes/store', 'name' => 'sectionstudent_form', 'method' => 'POST')) }}
@endif

<div class="m-portlet m-portlet--tab">
    <div class="m-portlet__body">

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
                    
                    <h5 class="m-bottom-1">Section Information</h5>

                    {{ Form::label('type', 'Type', ['class' => '']) }}
                    {{
                        Form::select('type', $types, $value = $sectioninfos->education_type_id, ['class' => 'form-control form-control-lg m-input m-input--solid', 'id' => 'type'])
                    }}
                    <span class="m-form__help m--font-danger">
                    </span>
                    
                </div>
            </div> 
        </div>

        <div class="row">

            {{--Level--}}
            <div class="col-md-4" id="level-main-div">
                <div class="form-group m-form__group required">
                    @if ( $segment == 'edit' )
                        <div id="level-div">
                            {{ Form::label('level', 'Level', ['class' => '']) }}
                            {{
                                Form::select('level', $levels, $value = $sectioninfos->level_id, ['class' => 'form-control form-control-lg m-input m-input--solid'])
                            }}
                            <span class="m-form__help m--font-danger">
                            </span>
                        </div>
                    @else
                        <div id="level-div"></div>
                    @endif
                </div>
            </div>

            {{--Section--}}
            <div class="col-md-4" id="section-main-div">
                <div class="form-group m-form__group required">
                    @if ( $segment == 'edit' )
                        <div id="section-div">
                            {{ Form::label('section', 'Section', ['class' => '']) }}
                            {{
                                Form::select('section', $sections, $value = $sectioninfos->section_id, ['class' => 'form-control form-control-lg m-input m-input--solid'])
                            }}
                            <span class="m-form__help m--font-danger">
                            </span>
                        </div>
                    @else
                        <div id="section-div"></div>
                    @endif
                </div>
            </div>

            {{--Adviser--}}
            <div class="col-md-4" id="adviser-main-div">
                <div class="form-group m-form__group required">
                    @if ( $segment == 'edit' )
                        <div id="adviser-div">
                            {{ Form::label('adviser', 'Adviser', ['class' => '']) }}
                            {{
                                Form::select('adviser', $advisers, $value = $sectioninfos->adviser_id, ['class' => 'form-control form-control-lg m-input m-input--solid'])
                            }}
                            <span class="m-form__help m--font-danger">
                            </span>
                        </div>
                    @else
                        <div id="adviser-div"></div>
                    @endif
                </div>
            </div>

        </div>

    </div>
</div>

<div class="m-portlet m-portlet--tab" id="subject-teacher-main-div" style="display:none;">
    <div class="m-portlet__body">

        <div class="row">
            <div class="col-md-12">
                <div class="form-group m-form__group required">
                    <h5 class="m-bottom-1">Sections and Subjects</h5>
                </div>
            </div> 
        </div>
        
            <div class="row">
                <div class="col-md-5">
                    @if ( $segment == 'edit' )
                        @php
                            $x=1; 
                        @endphp
                        @if(count($sections_subjects))
                            @foreach( $sections_subjects as $section_subject)
                                <input type="text" value="{{$section_subject->id}}" id="sections_subjects_{{$x}}" name="sections_subjects[]" hidden>
                                <div class="form-group m-form__group subject-div required" id="subject-div_{{$x}}">
                                    {{ Form::label('subject', 'Subject', ['class' => '']) }}
                                    {{
                                        Form::select('subjects[]', $subjects, $value = $section_subject->subject_id, ['class' => 'form-control form-control-lg m-input m-input--solid'])
                                    }}
                                    <span class="m-form__help m--font-danger">
                                    </span>
                                </div>
                                @php
                                    $x++;
                                @endphp
                            @endforeach
                        @else
                            <input type="text" value="0" id="sections_subjects_1" name="sections_subjects[]" hidden>
                            <div class="form-group m-form__group subject-div required" id="subject-div_1">
                                {{ Form::label('subject', 'Subject', ['class' => '']) }}
                                {{
                                    Form::select('subjects[]', $subjects, $value = '0', ['class' => 'form-control form-control-lg m-input m-input--solid'])
                                }}
                                <span class="m-form__help m--font-danger">
                                </span>
                            </div>
                        @endif
                    @else
                        <div class="form-group m-form__group subject-div required" id="subject-div_1" ></div>
                    @endif
                </div>

                <div class="col-md-5">
                    @if ( $segment == 'edit' )
                        @php
                            $x=1;
                        @endphp
                        @if(count($sections_subjects))
                            @foreach( $sections_subjects as $section_subject)
                                <div class="form-group m-form__group teacher-div required" id="teacher-div_{{$x}}">
                                    {{ Form::label('teacher', 'Teacher', ['class' => '']) }}
                                    {{
                                        Form::select('teachers[]', $teachers, $value = $section_subject->teacher_id, ['class' => 'form-control form-control-lg m-input m-input--solid'])
                                    }}
                                    <span class="m-form__help m--font-danger">
                                    </span>
                                </div>
                                @php
                                    $x++;
                                @endphp
                            @endforeach
                        @else
                            <div class="form-group m-form__group teacher-div required" id="teacher-div_1">
                                {{ Form::label('teacher', 'Teacher', ['class' => '']) }}
                                {{
                                    Form::select('teachers[]', $teachers, $value = '0', ['class' => 'form-control form-control-lg m-input m-input--solid'])
                                }}
                                <span class="m-form__help m--font-danger">
                                </span>
                            </div>
                        @endif                            
                    @else
                        <div class="form-group m-form__group teacher-div required" id="teacher-div_1" ></div>
                    @endif
                </div>
                
                <div class="col-md-2">
                    @if ( $segment == 'edit' )
                        @php
                            $x=1;
                        @endphp
                        @if(count($sections_subjects))
                            @foreach( $sections_subjects as $section_subject)
                                <div class="form-group m-form__group remove-div required" id="remove-div_{{$x}}" >
                                    <label style="visibility:hidden;"> Delete: </label><br/>
                                    @if ( $x >= 2 )
                                        <button style="visibility:;" name="remove-button" type="button" id="remove_{{$x}}" class="btn btn-lg btn-danger remove">-</button>
                                    @else
                                    <button style="visibility:hidden;" name="remove-button" type="button" id="remove_1" class="btn btn-lg btn-danger remove">-</button>
                                    @endif
                                </div>
                                @php
                                    $x++;
                                @endphp
                            @endforeach
                        @else
                            <div class="form-group m-form__group remove-div required" id="remove-div_1" >
                                <label style="visibility:hidden;"> Delete: </label><br/>
                                <button style="visibility:hidden;" name="remove-button" type="button" id="remove_1" class="btn btn-lg btn-danger remove">-</button>
                            </div>
                        @endif  
                    @else
                        <div class="form-group m-form__group remove-div required" id="remove-div_1" ></div>
                    @endif 
                </div>
            </div>

        <div class="row">
            <div class="col-md-12">
                <button type="button" class="btn btn-success" id="subject-teacher-addrow">Add Row</button>
            </div>
        </div>

    </div>         
</div> 


{{-- ENLIST STUDENT --}}

<div class="m-portlet m-portlet--tab" id="enlist-div">
    <div class="m-portlet__body">
        <div class="form-group m-form__group required">
            <div class="row">
                                
                <div class="col-md-12">
                    <h5 class="m-bottom-1">Admit Student</h5>
                </div>

                {{--}}
                <div class="col-md-12">
                    <div id="admitted_student">
                        <table class="table">
                            <thead> 
                                <tr>
                                    <th>ID No.</th>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>Action</th>
                                </tr>
                            </thead> 
                            <tbody class="tbody-enlisted-student">
                                @if ( $segment == 'edit' )
                                    @foreach ( $sections_students as $sections_student)
                                        <tr id="enlist-div-{{$sections_student->id}}">
                                            <td>{{$sections_student->identification_no}}</td>
                                            <td>{{$sections_student->lastname.', '.$sections_student->firstname.' '.$sections_student->middlename}}</td>
                                            <td>{{$sections_student->gender}}</td>
                                            <td>
                                                <input type='text' name='list_admitted_student[]' value='{{$sections_student->id}}' readonly='true' hidden> 
                                                <button type='button' id='semi-enlist-student' class='semi-enlist-student btn m-btn m-btn--hover-accent m-btn--pill' value='{{$sections_student->id}}' >
                                                    <span class='la la-close'></span>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <span class="m-form__help m--font-danger">
                    </span>
                </div>
                {{--}}

                {{----}}
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="m-input-icon m-input-icon--left m-bottom-2">
                                <input type="text" class="form-control m-input m-input--solid" placeholder="Search Keywords" id="enlist_generalSearch">
                                <span class="m-input-icon__icon m-input-icon__icon--left">
                                    <span>
                                        <i class="la la-search"></i>
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="enlist_datatable" id="local_data"></div>
                </div>

                @if ( $segment == 'edit' )
                    <div class='tbody-enlisted-student'>
                        <input class="edit-admission-enlist-student" value="{{$sectioninfos->id}}" hidden>
                    </div>
                @else
                    <div class='tbody-enlisted-student'></div>
                @endif
                
                {{----}}
                <div class="col-md-6" style="margin:10px 0px 0px 0px;">
                    <button type="button" class="btn btn-success" data-toggle="modal" id="enlist-btn-load" data-target="#enlist"> Add Student </button>
                </div> 

            </div>
            <span class="m-form__help m--font-danger">
            </span>
        </div>
    </div>
</div> 

{{ Form::close() }}