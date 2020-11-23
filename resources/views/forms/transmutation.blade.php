@if ( $segment == 'edit' )
    {{ Form::open(array('url' => 'academics/grading-sheets/transmutations/update/'.$trans->id, 'name' => 'transmutation_form', 'method' => 'PUT')) }}
@else
    {{ Form::open(array('url' => 'academics/grading-sheets/transmutations/store', 'name' => 'transmutation_form', 'method' => 'POST')) }}
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
            <div class="col-md-6">
                <div class="form-group m-form__group required">
                    {{ Form::label('code', 'Code', ['class' => '']) }}
                    {{ 
                        Form::text($name = 'code', $value = $trans->code, 
                        $attributes = array(
                            'id' => 'code',
                            'class' => 'form-control form-control-lg m-input m-input--solid'
                        )) 
                    }}
                    {{ 
                        Form::text($name = 'education_type_id', $value = $trans->education_type_id, 
                        $attributes = array(
                            'id' => 'education_type_id',
                            'class' => 'form-control form-control-lg m-input m-input--solid hidden'
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
                        Form::text($name = 'name', $value = $trans->name, 
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
                        Form::textarea($name = 'description', $value = $trans->description, 
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
        <div class="row">
            @if (!empty($trans->elements))
                @foreach($trans->elements as $element)
                <div class="col-md-6">
                    <div class="row">
                        <div class="offset-md-1 col-md-4">
                            <div class="form-group m-form__group text-center">
                                {{ Form::label('score', 'Score', ['class' => '']) }}
                                {{ 
                                    Form::text($name = 'element_score[]', $value = $element->score, 
                                    $attributes = array(
                                        'class' => 'text-center form-control form-control-lg m-input m-input--solid'
                                    )) 
                                }}
                                <span class="m-form__help m--font-danger">
                                </span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group m-form__group text-center">
                                {{ Form::label('disabled', 'disabled', ['class' => 'invisible']) }}
                                {{ 
                                    Form::text($name = 'disabled[]', $value = '~', 
                                    $attributes = array(
                                        'disabled' => 'disabled',
                                        'class' => 'text-center form-control form-control-lg m-input m-input--solid'
                                    )) 
                                }}
                                <span class="m-form__help m--font-danger">
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group m-form__group text-center required">
                                {{ Form::label('equivalent', 'Equivalent', ['class' => '']) }}
                                {{ 
                                    Form::text($name = 'element_equivalent[]', $value = $element->equivalent, 
                                    $attributes = array(
                                        'class' => 'text-center form-control form-control-lg m-input m-input--solid'
                                    )) 
                                }}
                                <span class="m-form__help m--font-danger">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @else

            @endif
        </div>
        <div id="element-panel-button" class="row m-top-1">
            <div class="col-md-12 text-center">
                <button id="add-sibling" type="button" class="btn btn-brand btn-lg" disabled="disabled">
                    <i class="la la-plus"></i>&nbsp;Add transmutation
                </button>
            </div>
        </div>
    </div>
</div>   
{{ Form::close() }}