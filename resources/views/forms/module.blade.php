@if ( $segment == 'edit' )
    {{ Form::open(array('url' => 'components/menus/modules/update/'.$module->id, 'name' => 'module_form', 'method' => 'PUT')) }}
@else
    {{ Form::open(array('url' => 'components/menus/modules/store', 'name' => 'module_form', 'method' => 'POST')) }}
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
                {{ Form::label('code', 'Code', ['class' => '']) }}
                {{ 
                    Form::text($name = 'code', $value = $module->code, 
                    $attributes = array(
                        'id' => 'code',
                        'class' => 'form-control form-control-lg m-input m-input--solid'
                    )) 
                }}
                <span class="m-form__help m--font-danger">
                </span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group m-form__group required">
                {{ Form::label('name', 'Name', ['class' => '']) }}
                {{ 
                    Form::text($name = 'name', $value = $module->name, 
                    $attributes = array(
                        'id' => 'name',
                        'class' => 'form-control form-control-lg m-input m-input--solid'
                    )) 
                }}
                <span class="m-form__help m--font-danger">
                </span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group m-form__group">
                {{ Form::label('slug', 'Slug', ['class' => '']) }}
                {{ 
                    Form::text($name = 'slug', $value = $module->slug, 
                    $attributes = array(
                        'id' => 'slug',
                        'class' => 'form-control form-control-lg m-input m-input--solid',
                        'disabled' => 'disabled'
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
                {{ Form::label('name', 'Icon', ['class' => '']) }}
                {{ 
                    Form::text($name = 'icon', $value = $module->icon, 
                    $attributes = array(
                        'id' => 'icon',
                        'class' => 'form-control form-control-lg m-input m-input--solid'
                    )) 
                }}
                <span class="m-form__help m--font-danger">
                </span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group m-form__group required">
                {{ Form::label('header_id', 'Header', ['class' => '']) }}
                {{
                    Form::select('header_id', $headers, $value = $module->header_id, ['class' => 'select2 form-control form-control-lg m-input m-input--solid'])
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
                    Form::textarea($name = 'description', $value = $module->description, 
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