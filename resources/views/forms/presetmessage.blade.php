@if ( $segment == 'edit' )
{{ Form::open(array('url' => 'components/schedules/preset-message/update/'.$presetmsg->id, 'name' => 'presetmsg_form', 'method' => 'PUT')) }}
@else
{{ Form::open(array('url' => 'components/schedules/preset-message/store', 'name' => 'presetmsg_form', 'method' => 'POST')) }}
@endif

        <div class="row">
            <div class="col-md-12">
                <div class="m-portlet m-portlet--tab">
                    <div class="m-portlet__body">

                        <h5 class="m-bottom-1">Preset message Information</h5>
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
                                <div class="col-md-12">
                                    <div class="form-group m-form__group">
                                        {{ Form::label('message', 'Message', ['class' => '']) }}
                                        {{ 
                                            Form::textarea($name = 'message', $value = $presetmsg->message, 
                                            $attributes = array(
                                                'id' => 'message',
                                                'class' => 'form-control form-control-lg m-input m-input--solid',
                                                'rows' => 3
                                            )) 
                                        }}
                                        <span class="m-form__help m--font-danger">
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 pull-right">
                                    <button type="button" class="btn btn-default pull-right m-2">
                                        Add  < TIME >
                                    </button>
                                    <button type="button" class="btn btn-default pull-right m-2">
                                        Add < DATE >
                                    </button>
                                    <button type="button" class="btn btn-default pull-right m-2">
                                        Add < STUDENT_NAME >
                                    </button>
                                    <button type="button" class="btn btn-default pull-right m-2">
                                        Add < STUDENT_NUMER >
                                    </button>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
{{ Form::close() }}