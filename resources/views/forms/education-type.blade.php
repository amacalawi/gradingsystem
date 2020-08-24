@if ( $segment == 'edit' )
    {{ Form::open(array('url' => 'components/schools/education-types/update/'.$educationType->id, 'name' => 'education_type_form', 'method' => 'PUT')) }}
@else
    {{ Form::open(array('url' => 'components/schools/education-types/store', 'name' => 'education_type_form', 'method' => 'POST')) }}
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
        <div class="col-md-6">
            <div class="form-group m-form__group required">
                {{ Form::label('code', 'Code', ['class' => '']) }}
                {{ 
                    Form::text($name = 'code', $value = $educationType->code, 
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
                    Form::text($name = 'name', $value = $educationType->name, 
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
                    Form::textarea($name = 'description', $value = $educationType->description, 
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
{{ Form::close() }}