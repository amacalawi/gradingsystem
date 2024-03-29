        <!-- Add event -->
        <div class="modal fade" id="addNew-event">
        {{--<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="importClassStudent" id="addNew-event">--}}
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header theme-bg-css">
                        <h4 class="modal-title c-black">Add an Event</h4>
                    </div>
                    <div class="modal-body">
                        <form id="EventForm" class="addEvent" type="GET" role="form">
                            <div class="row">
                                <div class="col-sm-12 m-b-5">
                                    <div class="form-group required">
                                        <div class="fg-line">
                                            {{ Form::label('title', 'EVENT TITLE', ['class' => '']) }}
                                            {{ 
                                                Form::text($name = 'title', $value = '', 
                                                $attributes = array(
                                                    'id' => 'eventName',
                                                    'class' => 'form-control form-control-lg m-input m-input--solid',
                                                    'placeholder' => 'Insert event title here'
                                                )) 
                                            }}
                                            <span class="m-form__help m--font-danger"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 m-b-5">
                                    <div class="form-group required">
                                        <div class="fg-line">
                                            {{ Form::label('description', 'Event Description', ['class' => 'c-black text-uppercase']) }}
                                            {{ 
                                                Form::textarea($name = 'description', $value = '', 
                                                $attributes = array(
                                                    'id' => 'description',
                                                    'class' => 'form-control form-control-lg m-input m-input--solid',
                                                    'rows' => 3,
                                                    'placeholder' => 'Insert event description here'
                                                )) 
                                            }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 m-b-5">
                                    <div class="form-group required">
                                        {{ Form::label('sections', 'Sections', ['class' => 'c-black text-uppercase']) }}
                                        {{
                                            Form::select('sections[]', $sections, '', ['id' => 'sections', 'class' => 'form-control btn-block form-control-lg m-input m-input--solid m-bootstrap-select m_selectpicker', 'multiple' => 'multiple'])
                                        }} 
                                        <span class="m-form__help m--font-danger">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 m-b-5">
                                    <div class="form-group required">
                                        {{ Form::label('holidayType', 'Type', ['class' => 'c-black text-uppercase']) }}
                                        {{
                                            Form::select('holidayType', $types, '', ['id' => 'education_type_id', 'class' => 'form-control btn-block form-control-lg m-input m-input--solid m-bootstrap-select m_selectpicker'])
                                        }} 
                                        <span class="m-form__help m--font-danger">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 m-b-5">
                                    <div class="form-group required">
                                        <div class="fg-line">
                                            {{ Form::label('eventStart', 'Event start', ['class' => 'c-black text-uppercase ']) }}
                                            {{ 
                                                Form::date($name = 'eventStart', $value = '', 
                                                $attributes = array(
                                                    'id' => 'eventStart',
                                                    'class' => 'form-control form-control-lg m-input m-input--solid'
                                                )) 
                                            }}
                                            <span class="m-form__help m--font-danger">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 m-b-5">
                                    <div class="form-group required">
                                        <div class="fg-line">
                                            {{ Form::label('eventEnd', 'Event end', ['class' => 'c-black text-uppercase ']) }}
                                            {{ 
                                                Form::date($name = 'eventEnd', $value = '', 
                                                $attributes = array(
                                                    'id' => 'eventEnd',
                                                    'class' => 'form-control form-control-lg m-input m-input--solid'
                                                )) 
                                            }}
                                            <span class="m-form__help m--font-danger">
                                            </span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">

                                <div id="custom_event" style="display: none;"> <!-- custom day -->

                                    <!-- Normal In -->
                                    <div class="form-group col-12">
                                        <table class="table">
                                            <tr>
                                                <td class="c-black text-uppercase" colspan='4'>Normal In</td>
                                            </tr>
                                            <tr>
                                                <td class='w-3'>From</td>
                                                <td><input id='normalin_from' name='normalin_from' class='form-control w-100' type='time' value='08:00:00'></td>
                                                <td class='w-3'>to</td>
                                                <td><input id='normalin_to' name='normalin_to' class='form-control w-100' type='time' value='17:00:00'></td>
                                            </tr>
                                        </table>
                                    </div>

                                    <!-- Normal Out -->
                                    <div class="form-group col-12">
                                        <table class="table">
                                            <tr>
                                                <td class="c-black text-uppercase" colspan='4'>Normal Out</td>
                                            </tr>
                                            <tr>
                                                <td class='w-3'>From</td>
                                                <td><input id='normalout_from' name='normalout_from' class='form-control w-100' type='time' value='08:00:00'></td>
                                                <td class='w-3'>to</td>
                                                <td><input id='normalout_to' name='normalout_to' class='form-control w-100' type='time' value='17:00:00'></td>
                                            </tr>
                                        </table>
                                    </div>

                                    <!-- Late In -->
                                    <div class="form-group col-12">
                                        <table class="table">
                                            <tr>
                                                <td class="c-black text-uppercase" colspan='4'>Late In</td>
                                            </tr>
                                            <tr>
                                                <td class='w-3'>From</td>
                                                <td><input id='latein_from' name='latein_from' class='form-control w-100' type='time' value='08:00:00'></td>
                                                <td class='w-3'>to</td>
                                                <td><input id='latein_to' name='latein_to' class='form-control w-100' type='time' value='17:00:00'></td>
                                            </tr>
                                        </table>
                                    </div>

                                    <!-- Late Out -->
                                    <div class="form-group col-12">
                                        <table class="table">
                                            <tr>
                                                <td class="c-black text-uppercase" colspan='4'>Late Out</td>
                                            </tr>
                                            <tr>
                                                <td class='w-3'>From</td>
                                                <td><input id='lateout_from' name='lateout_from' class='form-control w-100' type='time' value='08:00:00'></td>
                                                <td class='w-3'>to</td>
                                                <td><input id='lateout_to' name='lateout_to' class='form-control w-100' type='time' value='17:00:00'></td>
                                            </tr>
                                        </table>
                                    </div>

                                    <!-- Early In -->
                                    <div class="form-group col-12">
                                        <table class="table">
                                            <tr>
                                                <td class="c-black text-uppercase" colspan='4'>Early In</td>
                                            </tr>
                                            <tr>
                                                <td class='w-3'>From</td>
                                                <td><input id='earlyin_from' name='earlyin_from' class='form-control w-100' type='time' value='08:00:00'></td>
                                                <td class='w-3'>to</td>
                                                <td><input id='earlyin_to' name='earlyin_to' class='form-control w-100' type='time' value='17:00:00'></td>
                                            </tr>
                                        </table>
                                    </div>

                                    <!-- Early Out -->
                                    <div class="form-group col-12">
                                        <table class="table">
                                            <tr>
                                                <td class="c-black text-uppercase" colspan='4'>Early Out</td>
                                            </tr>
                                            <tr>
                                                <td class='w-3'>From</td>
                                                <td><input id='earlyout_from' name='earlyout_from' class='form-control w-100' type='time' value='08:00:00'></td>
                                                <td class='w-3'>to</td>
                                                <td><input id='earlyout_to' name='earlyout_to' class='form-control w-100' type='time' value='17:00:00'></td>
                                            </tr>
                                        </table>
                                    </div>

                                    <div class="col-sm-12 m-b-5">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group m-form__group">
                                                    {{ Form::label('mormal-in-preset-message', 'Normal-in Preset Message', ['class' => '']) }}
                                                    {{
                                                        Form::select('normal_in_preset_message', $preset_message, '', ['class' => 'form-control form-control-lg m-input m-input--solid'])
                                                    }}
                                                    <span class="m-form__help m--font-danger">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group m-form__group">
                                                    <div class="form-group m-form__group">
                                                        {{ Form::label('mormal-out-preset-message', 'Normal-out Preset Message', ['class' => '']) }}
                                                        {{
                                                            Form::select('normal_out_preset_message', $preset_message, '', ['class' => 'form-control form-control-lg m-input m-input--solid'])
                                                        }}
                                                        <span class="m-form__help m--font-danger">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group m-form__group">
                                                    <div class="form-group m-form__group">
                                                        {{ Form::label('late-in-preset-message', 'Late-in Preset Message', ['class' => '']) }}
                                                        {{
                                                            Form::select('late_in_preset_message', $preset_message, '', ['class' => 'form-control form-control-lg m-input m-input--solid'])
                                                        }}
                                                        <span class="m-form__help m--font-danger">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group m-form__group">
                                                    <div class="form-group m-form__group">
                                                        {{ Form::label('late-out-preset-message', 'Late-out Preset Message', ['class' => '']) }}
                                                        {{
                                                            Form::select('late_out_preset_message', $preset_message, '', ['class' => 'form-control form-control-lg m-input m-input--solid'])
                                                        }}
                                                        <span class="m-form__help m--font-danger">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group m-form__group">
                                                    <div class="form-group m-form__group">
                                                        {{ Form::label('early-in-preset-message', 'Early-in Preset Message', ['class' => '']) }}
                                                        {{
                                                            Form::select('early_in_preset_message', $preset_message, '', ['class' => 'form-control form-control-lg m-input m-input--solid'])
                                                        }}
                                                        <span class="m-form__help m--font-danger">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group m-form__group">
                                                    <div class="form-group m-form__group">
                                                        {{ Form::label('early-out-preset-message', 'Early-out Preset Message', ['class' => '']) }}
                                                        {{
                                                            Form::select('early_out_preset_message', $preset_message, '', ['class' => 'form-control form-control-lg m-input m-input--solid'])
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

                            <div class="row">
                                <div class="col-sm-12">
                                        <div class="form-group required">
                                            {{ Form::label('palette', 'Palette', ['class' => '']) }}
                                            <div class="col-md-12">
                                                <div class="row">
                                                        <div class="m-radio-list col-md-4">
                                                            <label class="m-radio">
                                                                {{ Form::radio('palette', 'm-fc-event--solid-light', '', array('class' => 'colour',)) }}
                                                                <em class="m-right-05 m-badge m-badge--secondary"></em> Light
                                                                <span></span>
                                                            </label>
                                                            <label class="m-radio">
                                                                {{ Form::radio('palette', 'm-fc-event--solid-metal', '', array('class' => 'colour')) }}
                                                                <em class="m-right-05 m-badge m-badge--metal"></em> Metal
                                                                <span></span>
                                                            </label>
                                                            <label class="m-radio">
                                                                {{ Form::radio('palette', 'm-fc-event--solid-lemon', '', array('class' => 'colour')) }}
                                                                <em class="m-right-05 m-badge m-badge--lemon"></em> Lemon
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                        <div class="m-radio-list col-md-4">
                                                            <label class="m-radio">
                                                                {{ Form::radio('palette', 'm-fc-event--solid-amber', '', array('class' => 'colour')) }}
                                                                <em class="m-right-05 m-badge m-badge--amber"></em> Amber
                                                                <span></span>
                                                            </label>
                                                            <label class="m-radio">
                                                                {{ Form::radio('palette', 'm-fc-event--solid-lime', '', array('class' => 'colour')) }}
                                                                <em class="m-right-05 m-badge m-badge--lime"></em> Lime
                                                                <span></span>
                                                            </label>
                                                            <label class="m-radio">
                                                                {{ Form::radio('palette', 'm-fc-event--solid-success', '', array('class' => 'colour')) }}
                                                                <em class="m-right-05 m-badge m-badge--success"></em> Leaf
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                        <div class="m-radio-list col-md-4">
                                                            <label class="m-radio">
                                                                {{ Form::radio('palette', 'm-fc-event--solid-info', '', array('class' => 'colour')) }}
                                                                <em class="m-right-05 m-badge m-badge--info"></em> Sky
                                                                <span></span>
                                                            </label>
                                                            <label class="m-radio">
                                                                {{ Form::radio('palette', 'm-fc-event--solid-accent', '', array('class' => 'colour')) }}
                                                                <em class="m-right-05 m-badge m-badge--accent"></em> Azure
                                                                <span></span>
                                                            </label>
                                                            <label class="m-radio">
                                                                {{ Form::radio('palette', 'm-fc-event--solid-purple', '', array('class' => 'colour')) }}
                                                                <em class="m-right-05 m-badge m-badge--purple"></em> Purple
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            <span class="m-form__help m--font-danger"></span>
                                        </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="submit" class="btn active" id="addEvent">Add Event</button>
                        <button type="button" class="btn " data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>