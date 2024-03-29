@if ( $segment == 'edit' )
    {{ Form::open(array('url' => 'academics/academics/subjects/update/'.$subject->id, 'name' => 'subject_form', 'method' => 'PUT')) }}
@else
    {{ Form::open(array('url' => 'academics/academics/subjects/store', 'name' => 'subject_form', 'method' => 'POST')) }}
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
        <div class="col-md-6">
            <div class="form-group m-form__group required">
                <span class="m-form__help m--font-danger">
                </span>
            </div>
        </div>
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
                    Form::text($name = 'code', $value = $subject->code, 
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
                    Form::text($name = 'name', $value = $subject->name, 
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
        <div class="col-md-6">
            <div class="form-group m-form__group required">
                {{ Form::label('type', 'Type', ['class' => '']) }}
                @if ( $segment == 'add' )
                    {{
                        Form::select('type[]', $types, !empty($subject) ? $subject->education_type_id : '', ['id' => 'education_type_id', 'class' => 'form-control btn-block form-control-lg m-input m-input--solid m-bootstrap-select m_selectpicker', 'multiple'])
                    }} 
                @else
                    {{
                        Form::select('type[]', $types, !empty($subject) ? $subject->education_type_id : '', ['id' => 'education_type_id', 'class' => 'form-control form-control-lg m-input m-input--solid m-bootstrap-select m_selectpicker', 'multiple'])
                    }}
                @endif

                <span class="m-form__help m--font-danger">
                </span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group m-form__group required">
                {{ Form::label('coordinator', 'Coordinator', ['class' => '']) }}
                    {{
                        Form::select('coordinator', $coordinators, !empty($subject) ? $subject->coordinator_id : '', ['id' => 'coordinator_id', 'class' => 'form-control btn-block form-control-lg m-input m-input--solid'])
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
                    Form::textarea($name = 'description', $value = $subject->description, 
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

    <div class="row mt-12">
        <div class="col-md-6">
            
                <div class="form-group m-form__group mt-3">
                    <label class="m-radio m-radio--solid" style="position: ;">
                        {{ Form::radio('material', '1', ($subject->material_id == '1') ? 1 : 0 ) }}
                        Substance <span></span>
                    </label>
                </div>
   
                <div class="form-group m-form__group mt-3">
                    <label class="m-radio m-radio--solid" style="position: ;">
                        {{ Form::radio('material', '2', ($subject->material_id == '2') ? 1 : 0 ) }}
                        Conduct <span></span>
                    </label>
                </div>

                <div class="form-group m-form__group mt-3">
                    <label class="m-radio m-radio--solid" style="position: ;">
                        {{ Form::radio('material', '3', ($subject->material_id == '3') ? 1 : 0 ) }}
                        Homeroom <span></span>
                    </label>
                </div>

                <div class="form-group m-form__group mt-3">
                    <label class="m-radio m-radio--solid" style="position: ;">
                        {{ Form::radio('material', '4', ($subject->material_id == '4') ? 1 : 0 ) }}
                        Co-curricular <span></span>
                    </label>
                </div>
        </div>

        <div class="col-md-6">
            <div class="form-group m-form__group mt-3">
                <label class="m-checkbox m-checkbox--solid" style="position: absolute;">
                    @if ($subject->is_mapeh > 0) 
                        {{ Form::checkbox('is_mapeh', '1', true, array('id' => 'parent-cell')) }}
                    @else
                        {{ Form::checkbox('is_mapeh', '1', false, array('id' => 'parent-cell')) }}
                    @endif
                    <span></span>
                </label>    
                <h5 id="parents-label" class="m-left-2">
                    MAPEH
                </h5>
            </div>
            <div class="form-group m-form__group mt-4">
                <label class="m-checkbox m-checkbox--solid" style="position: absolute;">
                    @if ($subject->is_tle > 0) 
                        {{ Form::checkbox('is_tle', '1', true, array('id' => 'parent-cell')) }}
                    @else
                        {{ Form::checkbox('is_tle', '1', false, array('id' => 'parent-cell')) }}
                    @endif
                    <span></span>
                </label>    
                <h5 id="parents-label" class="m-left-2">
                    TLE
                </h5>
            </div>            
        </div>
    </div>
{{ Form::close() }}