@if ( $segment == 'edit' )
    {{ Form::open(array('url' => 'academics/grading-sheets/components/update/'.$component->id, 'name' => 'component_form', 'method' => 'PUT')) }}
@else
    {{ Form::open(array('url' => 'academics/grading-sheets/components/store', 'name' => 'component_form', 'method' => 'POST')) }}
@endif
<div class="row">
    <div class="col-md-9">
        @if (Auth::user()->type != 'administrator' && ($component->material_id == 1 || $component->material_id == 2))
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="m-bottom-1">Activity Cells</h5>
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
                                                    {{ Form::label('activity_name', 'Code', ['class' => '']) }}
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
                                                {{ Form::label('activity_name', 'Code', ['class' => '']) }}
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
                    
                    <div class="row">
                        <div class="col-md-12">
                            <button id="add-activity" type="button" class="btn btn-brand">
                                <i class="la la-plus"></i>&nbsp;Add Activity
                            </button>
                        </div>
                    </div>
                </div>
            </div>
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
                        <h5 class="m-bottom-1">Component Information</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group m-form__group required">
                            {{ Form::label('name', 'Name', ['class' => '']) }}
                            @if (Auth::user()->type != 'administrator')
                                {{ 
                                    Form::text($name = 'name', $value = $component->name, 
                                    $attributes = array(
                                        'id' => 'name',
                                        'disabled' => 'disabled',
                                        'class' => 'form-control form-control-lg m-input m-input--solid'
                                    )) 
                                }}
                            @else
                                {{ 
                                    Form::text($name = 'name', $value = $component->name, 
                                    $attributes = array(
                                        'id' => 'name',
                                        'class' => 'form-control form-control-lg m-input m-input--solid'
                                    )) 
                                }}
                            @endif
                            <span class="m-form__help m--font-danger">
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group m-form__group required">
                            {{ Form::label('percentage', 'Percentage', ['class' => '']) }}
                            @if (Auth::user()->type != 'administrator')
                                {{ 
                                    Form::text($name = 'percentage', $value = $component->percentage, 
                                    $attributes = array(
                                        'id' => 'percentage',
                                        'disabled' => 'disabled',
                                        'class' => 'numeric form-control form-control-lg m-input m-input--solid'
                                    )) 
                                }}
                            @else
                                {{ 
                                    Form::text($name = 'percentage', $value = $component->percentage, 
                                    $attributes = array(
                                        'id' => 'percentage',
                                        'class' => 'numeric form-control form-control-lg m-input m-input--solid'
                                    )) 
                                }}
                            @endif
                            <span class="m-form__help m--font-danger">
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group m-form__group">
                            {{ Form::label('description', 'Description', ['class' => '']) }}
                            @if (Auth::user()->type != 'administrator')
                                {{ 
                                    Form::textarea($name = 'description', $value = $component->description, 
                                    $attributes = array(
                                        'id' => 'description',
                                        'disabled' => 'disabled',
                                        'class' => 'form-control form-control-lg m-input m-input--solid',
                                        'rows' => 3
                                    )) 
                                }}
                            @else
                                {{ 
                                    Form::textarea($name = 'description', $value = $component->description, 
                                    $attributes = array(
                                        'id' => 'description',
                                        'class' => 'form-control form-control-lg m-input m-input--solid',
                                        'rows' => 3
                                    )) 
                                }}
                            @endif
                            <span class="m-form__help m--font-danger">
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="m-form__group form-group required">
                            {{ Form::label('palette', 'Palette', ['class' => '']) }}
                            <div class="col-md-12">
                                @if (Auth::user()->type != 'administrator')
                                    <div class="row">
                                        <div class="m-radio-list col-md-4">
                                            <label class="m-radio">
                                                {{ Form::radio('palette', 'm-badge--secondary', ($component->palette == 'm-badge--secondary') ? true : false, array('class' => 'colour', 'disabled' => 'disabled')) }}
                                                <em class="m-right-05 m-badge m-badge--secondary"></em> Light
                                                <span></span>
                                            </label>
                                            <label class="m-radio">
                                                {{ Form::radio('palette', 'm-badge--metal', ($component->palette == 'm-badge--metal') ? true : false, array('class' => 'colour', 'disabled' => 'disabled')) }}
                                                <em class="m-right-05 m-badge m-badge--metal"></em> Metal
                                                <span></span>
                                            </label>
                                            <label class="m-radio">
                                                {{ Form::radio('palette', 'm-badge--lemon', ($component->palette == 'm-badge--lemon') ? true : false, array('class' => 'colour', 'disabled' => 'disabled')) }}
                                                <em class="m-right-05 m-badge m-badge--lemon"></em> Lemon
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="m-radio-list col-md-4">
                                            <label class="m-radio">
                                                {{ Form::radio('palette', 'm-badge--amber', ($component->palette == 'm-badge--amber') ? true : false, array('class' => 'colour', 'disabled' => 'disabled')) }}
                                                <em class="m-right-05 m-badge m-badge--amber"></em> Amber
                                                <span></span>
                                            </label>
                                            <label class="m-radio">
                                                {{ Form::radio('palette', 'm-badge--lime', ($component->palette == 'm-badge--lime') ? true : false, array('class' => 'colour', 'disabled' => 'disabled')) }}
                                                <em class="m-right-05 m-badge m-badge--lime"></em> Lime
                                                <span></span>
                                            </label>
                                            <label class="m-radio">
                                                {{ Form::radio('palette', 'm-badge--success', ($component->palette == 'm-badge--success') ? true : false, array('class' => 'colour', 'disabled' => 'disabled')) }}
                                                <em class="m-right-05 m-badge m-badge--success"></em> Leaf
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="m-radio-list col-md-4">
                                            <label class="m-radio">
                                                {{ Form::radio('palette', 'm-badge--info', ($component->palette == 'm-badge--info') ? true : false, array('class' => 'colour', 'disabled' => 'disabled')) }}
                                                <em class="m-right-05 m-badge m-badge--info"></em> Sky
                                                <span></span>
                                            </label>
                                            <label class="m-radio">
                                                {{ Form::radio('palette', 'm-badge--accent', ($component->palette == 'm-badge--accent') ? true : false, array('class' => 'colour', 'disabled' => 'disabled')) }}
                                                <em class="m-right-05 m-badge m-badge--accent"></em> Azure
                                                <span></span>
                                            </label>
                                            <label class="m-radio">
                                                {{ Form::radio('palette', 'm-badge--purple', ($component->palette == 'm-badge--purple') ? true : false, array('class' => 'colour', 'disabled' => 'disabled')) }}
                                                <em class="m-right-05 m-badge m-badge--purple"></em> Purple
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                @else
                                    <div class="row">
                                        <div class="m-radio-list col-md-4">
                                            <label class="m-radio">
                                                {{ Form::radio('palette', 'm-badge--secondary', ($component->palette == 'm-badge--secondary') ? true : false, array('class' => 'colour')) }}
                                                <em class="m-right-05 m-badge m-badge--secondary"></em> Light
                                                <span></span>
                                            </label>
                                            <label class="m-radio">
                                                {{ Form::radio('palette', 'm-badge--metal', ($component->palette == 'm-badge--metal') ? true : false, array('class' => 'colour')) }}
                                                <em class="m-right-05 m-badge m-badge--metal"></em> Metal
                                                <span></span>
                                            </label>
                                            <label class="m-radio">
                                                {{ Form::radio('palette', 'm-badge--lemon', ($component->palette == 'm-badge--lemon') ? true : false, array('class' => 'colour')) }}
                                                <em class="m-right-05 m-badge m-badge--lemon"></em> Lemon
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="m-radio-list col-md-4">
                                            <label class="m-radio">
                                                {{ Form::radio('palette', 'm-badge--amber', ($component->palette == 'm-badge--amber') ? true : false, array('class' => 'colour')) }}
                                                <em class="m-right-05 m-badge m-badge--amber"></em> Amber
                                                <span></span>
                                            </label>
                                            <label class="m-radio">
                                                {{ Form::radio('palette', 'm-badge--lime', ($component->palette == 'm-badge--lime') ? true : false, array('class' => 'colour')) }}
                                                <em class="m-right-05 m-badge m-badge--lime"></em> Lime
                                                <span></span>
                                            </label>
                                            <label class="m-radio">
                                                {{ Form::radio('palette', 'm-badge--success', ($component->palette == 'm-badge--success') ? true : false, array('class' => 'colour')) }}
                                                <em class="m-right-05 m-badge m-badge--success"></em> Leaf
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="m-radio-list col-md-4">
                                            <label class="m-radio">
                                                {{ Form::radio('palette', 'm-badge--info', ($component->palette == 'm-badge--info') ? true : false, array('class' => 'colour')) }}
                                                <em class="m-right-05 m-badge m-badge--info"></em> Sky
                                                <span></span>
                                            </label>
                                            <label class="m-radio">
                                                {{ Form::radio('palette', 'm-badge--accent', ($component->palette == 'm-badge--accent') ? true : false, array('class' => 'colour')) }}
                                                <em class="m-right-05 m-badge m-badge--accent"></em> Azure
                                                <span></span>
                                            </label>
                                            <label class="m-radio">
                                                {{ Form::radio('palette', 'm-badge--purple', ($component->palette == 'm-badge--purple') ? true : false, array('class' => 'colour')) }}
                                                <em class="m-right-05 m-badge m-badge--purple"></em> Purple
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <span class="m-form__help m--font-danger">
                            </span>
                        </div>
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
                                    @if (Auth::user()->type != 'administrator')
                                        @if ($component->is_sum_cell !== '')
                                            @if ($component->is_sum_cell > 0) 
                                                {{ Form::checkbox('is_sum_cell', '1', true, array('id' => 'is_sum_cell', 'disabled' => 'disabled')) }}
                                            @else
                                                {{ Form::checkbox('is_sum_cell', '1', false, array('id' => 'is_sum_cell', 'disabled' => 'disabled')) }}
                                            @endif
                                        @else
                                            {{ Form::checkbox('is_sum_cell', '1', true, array('id' => 'is_sum_cell', 'disabled' => 'disabled')) }}
                                        @endif
                                    @else
                                        @if ($component->is_sum_cell !== '')
                                            @if ($component->is_sum_cell > 0) 
                                                {{ Form::checkbox('is_sum_cell', '1', true, array('id' => 'is_sum_cell')) }}
                                            @else
                                                {{ Form::checkbox('is_sum_cell', '1', false, array('id' => 'is_sum_cell')) }}
                                            @endif
                                        @else
                                            {{ Form::checkbox('is_sum_cell', '1', true, array('id' => 'is_sum_cell')) }}
                                        @endif
                                    @endif
                                    Has Sum Cell
                                    <span></span>
                                </label>
                                <label class="m-checkbox m-checkbox--solid">
                                    @if (Auth::user()->type != 'administrator')
                                        @if ($component->is_hps_cell !== '')
                                            @if ($component->is_hps_cell > 0) 
                                                {{ Form::checkbox('is_hps_cell', '1', true, array('id' => 'is_hps_cell', 'disabled' => 'disabled')) }}
                                            @else
                                                {{ Form::checkbox('is_hps_cell', '1', false, array('id' => 'is_hps_cell', 'disabled' => 'disabled')) }}
                                            @endif
                                        @else
                                            {{ Form::checkbox('is_hps_cell', '1', true, array('id' => 'is_hps_cell', 'disabled' => 'disabled')) }}
                                        @endif
                                    @else
                                        @if ($component->is_hps_cell !== '')
                                            @if ($component->is_hps_cell > 0) 
                                                {{ Form::checkbox('is_hps_cell', '1', true, array('id' => 'is_hps_cell')) }}
                                            @else
                                                {{ Form::checkbox('is_hps_cell', '1', false, array('id' => 'is_hps_cell')) }}
                                            @endif
                                        @else
                                            {{ Form::checkbox('is_hps_cell', '1', true, array('id' => 'is_hps_cell')) }}
                                        @endif
                                    @endif
                                    Has HPS Cell
                                    <span></span>
                                </label>
                                <label class="m-checkbox m-checkbox--solid">
                                    @if (Auth::user()->type != 'administrator')
                                        @if ($component->is_ps_cell !== '')
                                            @if ($component->is_ps_cell > 0) 
                                                {{ Form::checkbox('is_ps_cell', '1', true, array('id' => 'is_ps_cell', 'disabled' => 'disabled')) }}
                                            @else
                                                {{ Form::checkbox('is_ps_cell', '1', false, array('id' => 'is_ps_cell', 'disabled' => 'disabled')) }}
                                            @endif
                                        @else
                                            {{ Form::checkbox('is_ps_cell', '1', true, array('id' => 'is_ps_cell', 'disabled' => 'disabled')) }}
                                        @endif
                                    @else
                                        @if ($component->is_ps_cell !== '')
                                            @if ($component->is_ps_cell > 0) 
                                                {{ Form::checkbox('is_ps_cell', '1', true, array('id' => 'is_ps_cell')) }}
                                            @else
                                                {{ Form::checkbox('is_ps_cell', '1', false, array('id' => 'is_ps_cell')) }}
                                            @endif
                                        @else
                                            {{ Form::checkbox('is_ps_cell', '1', true, array('id' => 'is_ps_cell')) }}
                                        @endif
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
                        <h5 class="m-bottom-1">Type</h5>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group m-form__group required">
                            @if (Auth::user()->type != 'administrator')
                                {{  
                                    Form::select('education_type_id', $types, !empty($component) ? $component->education_type_id : '', ['id' => 'education_type_id', 'class' => 'form-control form-control-lg m-input m-input--solid', 'disabled' => 'disabled'])
                                }}
                            @else
                                {{  
                                    Form::select('education_type_id', $types, !empty($component) ? $component->education_type_id : '', ['id' => 'education_type_id', 'class' => 'form-control form-control-lg m-input m-input--solid'])
                                }}
                            @endif
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
                        <h5 class="m-bottom-1">Quarter</h5>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group m-form__group required">
                            @if (Auth::user()->type != 'administrator')
                                {{  
                                    Form::select('quarter_id[]', $quarters, !empty($component) ? $component->quarters : '', ['id' => 'quarter_id', 'class' => 'form-control form-control-lg m-input m-input--solid m-bootstrap-select m_selectpicker', 'disabled' => 'disabled', 'multiple'])
                                }}
                            @else
                                {{  
                                    Form::select('quarter_id[]', $quarters, !empty($component) ? $component->quarters : '', ['id' => 'quarter_id', 'class' => 'form-control form-control-lg m-input m-input--solid m-bootstrap-select m_selectpicker', 'multiple'])
                                }}
                            @endif
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
                        <h5 class="m-bottom-1">Classes</h5>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group m-form__group required">
                            @if (Auth::user()->type != 'administrator')
                                {{  
                                    Form::select('section_info_id', $sections, !empty($component) ? $component->section_info_id : '', ['id' => 'section_info_id', 'class' => 'form-control form-control-lg m-input m-input--solid', 'disabled' => 'disabled'])
                                }}
                            @else
                                {{  
                                    Form::select('section_info_id', $sections, !empty($component) ? $component->section_info_id : '', ['id' => 'section_info_id', 'class' => 'form-control form-control-lg m-input m-input--solid'])
                                }}
                            @endif
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
                            @if (Auth::user()->type != 'administrator')
                                {{  
                                    Form::select('subject_id[]', $subjects, !empty($component) ? $component->subject_id : '', ['id' => 'subject_id', 'data-live-search' => 'true', 'class' => 'form-control form-control-lg m-input m-input--solid m-bootstrap-select m_selectpicker', 'multiple',  'disabled' => 'disabled'])
                                }}
                            @else
                                {{  
                                    Form::select('subject_id[]', $subjects, !empty($component) ? $component->subject_id : '', ['id' => 'subject_id', 'data-live-search' => 'true', 'class' => 'form-control form-control-lg m-input m-input--solid m-bootstrap-select m_selectpicker', 'multiple'])
                                }}
                            @endif
                            <span class="m-form__help m--font-danger"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}