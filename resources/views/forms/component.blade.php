@if ( $segment == 'edit' )
    {{ Form::open(array('url' => 'academics/grading-sheets/components/update/'.$component->id, 'name' => 'component_form', 'method' => 'PUT')) }}
@else
    {{ Form::open(array('url' => 'academics/grading-sheets/components/store', 'name' => 'component_form', 'method' => 'POST')) }}
@endif
<div class="row">
    <div class="col-md-9">
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
                                Form::text($name = 'code', $value = $component->code, 
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
                                Form::text($name = 'name', $value = $component->name, 
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
                                Form::textarea($name = 'description', $value = $component->description, 
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

                @if (!empty($activities))
                    @php $i = 0; @endphp
                    <div id="activity-panel">
                        @foreach ($activities as $activitiez)
                            <div class="row activity-panel-layout">
                                <div class="col-md-11">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group m-form__group required">
                                                {{ Form::label('activity_name', 'Name', ['class' => '']) }}
                                                {{ 
                                                    Form::text($activity = 'activity_name[]', $value = $activitiez->activity, 
                                                    $attributes = array(
                                                        'class' => 'form-control form-control-lg m-input m-input--solid'
                                                    )) 
                                                }}
                                                <span class="m-form__help m--font-danger">
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group m-form__group required">
                                                {{ Form::label('activity_value', 'Value', ['class' => '']) }}
                                                {{ 
                                                    Form::text($name = 'activity_value[]', $value = $activitiez->value, 
                                                    $attributes = array(
                                                        'class' => 'numeric-double form-control form-control-lg m-input m-input--solid'
                                                    )) 
                                                }}
                                                <span class="m-form__help m--font-danger">
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group m-form__group required">
                                                {{ Form::label('activity_description', 'Description', ['class' => '']) }}
                                                {{ 
                                                    Form::text($name = 'activity_description[]', $value = $activitiez->description, 
                                                    $attributes = array(
                                                        'class' => 'form-control form-control-lg m-input m-input--solid'
                                                    )) 
                                                }}
                                                <span class="m-form__help m--font-danger">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if ($i == 0)
                                <div class="col-md-1"></div>
                                @else
                                <div class="col-md-1"><div class="row"><div class="col-md-12"><button type="button" class="minus-activity btn"><i class="la la-minus"></i></button></div></div></div>
                                @endif
                            </div>
                            @php $i++ @endphp
                        @endforeach
                    </div>
                @else
                    <div id="activity-panel">
                        <div class="row activity-panel-layout">
                            <div class="col-md-11">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group m-form__group required">
                                            {{ Form::label('activity_name', 'Name', ['class' => '']) }}
                                            {{ 
                                                Form::text($activity = 'activity_name[]', $value = '', 
                                                $attributes = array(
                                                    'class' => 'form-control form-control-lg m-input m-input--solid'
                                                )) 
                                            }}
                                            <span class="m-form__help m--font-danger">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group m-form__group required">
                                            {{ Form::label('activity_value', 'Value', ['class' => '']) }}
                                            {{ 
                                                Form::text($name = 'activity_value[]', $value = '', 
                                                $attributes = array(
                                                    'class' => 'numeric-double form-control form-control-lg m-input m-input--solid'
                                                )) 
                                            }}
                                            <span class="m-form__help m--font-danger">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group m-form__group required">
                                            {{ Form::label('activity_description', 'Description', ['class' => '']) }}
                                            {{ 
                                                Form::text($name = 'activity_description[]', $value = '', 
                                                $attributes = array(
                                                    'class' => 'form-control form-control-lg m-input m-input--solid'
                                                )) 
                                            }}
                                            <span class="m-form__help m--font-danger">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </div>
                @endif
                
                <div class="row m-bottom-2">
                    <div class="col-md-12">
                        <button id="add-activity" type="button" class="btn btn-brand">
                            <i class="la la-plus"></i>&nbsp;Add Activity
                        </button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group m-form__group">
                            <label >
                                Supported Cells
                            </label>
                            <div class="m-checkbox-list">
                                <label class="m-checkbox m-checkbox--solid">
                                    @if ($component->is_sum_cell !== '')
                                        @if ($component->is_sum_cell > 0) 
                                            {{ Form::checkbox('is_sum_cell', '1', true, array('id' => 'is_sum_cell')) }}
                                        @else
                                            {{ Form::checkbox('is_sum_cell', '1', false, array('id' => 'is_sum_cell')) }}
                                        @endif
                                    @else
                                        {{ Form::checkbox('is_sum_cell', '1', true, array('id' => 'is_sum_cell')) }}
                                    @endif
                                    Has Sum Cell
                                    <span></span>
                                </label>
                                <label class="m-checkbox m-checkbox--solid">
                                    @if ($component->is_hps_cell !== '')
                                        @if ($component->is_hps_cell > 0) 
                                            {{ Form::checkbox('is_hps_cell', '1', true, array('id' => 'is_hps_cell')) }}
                                        @else
                                            {{ Form::checkbox('is_hps_cell', '1', false, array('id' => 'is_hps_cell')) }}
                                        @endif
                                    @else
                                        {{ Form::checkbox('is_hps_cell', '1', true, array('id' => 'is_hps_cell')) }}
                                    @endif
                                    Has HPS Cell
                                    <span></span>
                                </label>
                                <label class="m-checkbox m-checkbox--solid">
                                    @if ($component->is_ps_cell !== '')
                                        @if ($component->is_ps_cell > 0) 
                                            {{ Form::checkbox('is_ps_cell', '1', true, array('id' => 'is_ps_cell')) }}
                                        @else
                                            {{ Form::checkbox('is_ps_cell', '1', false, array('id' => 'is_ps_cell')) }}
                                        @endif
                                    @else
                                        {{ Form::checkbox('is_ps_cell', '1', true, array('id' => 'is_ps_cell')) }}
                                    @endif
                                    Has PS Cell
                                    <span></span>
                                </label>
                            </div>
                        </div>
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
                        <h5 class="m-bottom-1">Quarter</h5>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group m-form__group required">
                            {{ Form::label('quarter_id', 'Set Quarter', ['class' => '']) }}
                            {{  
                                Form::select('quarter_id', $quarters, !empty($component) ? $component->quarter_id : '', ['class' => 'form-control form-control-lg m-input m-input--solid'])
                            }}
                            <span class="m-form__help m--font-danger"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="m-portlet m-portlet--tab">
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="m-bottom-1">Subject</h5>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group m-form__group required">
                            {{ Form::label('subject_id', 'Set Subject', ['class' => '']) }}
                            {{  
                                Form::select('subject_id', $subjects, !empty($component) ? $component->subject_id : '', ['class' => 'form-control form-control-lg m-input m-input--solid'])
                            }}
                            <span class="m-form__help m--font-danger"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}