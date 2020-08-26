@if ( $segment == 'edit' )
    {{ Form::open(array('url' => 'notifications/messaging/infoblast/templates/update/'.$template->id, 'name' => 'template_form', 'method' => 'PUT')) }}
@else
    {{ Form::open(array('url' => 'notifications/messaging/infoblast/templates/store', 'name' => 'template_form', 'method' => 'POST')) }}
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
                    Form::text($name = 'code', $value = $template->code, 
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
                    Form::text($name = 'name', $value = $template->name, 
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
            <div class="form-group m-form__group required">
                {{ Form::label('messages', 'Messages', ['class' => '']) }}
                {{ 
                    Form::textarea($name = 'messages', $value = $template->messages, 
                    $attributes = array(
                        'id' => 'messages',
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
        <div class="col-md-12">
            {{ Form::label('codex', 'Codex', ['class' => '']) }}
            <div class="form-group m-form__group">
                <button btn-groups="1,2,3" values="<STUD_NO>" type="button" class="codex-btn m-b-10 btn btn-secondary btn-sm">
                    &lt;STUDENT NO&gt;
                </button>
                <button btn-groups="1,2,3" values="<FIRSTNAME>" type="button" class="codex-btn m-b-10 btn btn-secondary btn-sm">
                    &lt;FIRSTNAME&gt;
                </button>
                <button btn-groups="1,2,3" values="<MIDDLENAME>" type="button" class="codex-btn m-b-10 btn btn-secondary btn-sm">
                    &lt;MIDDLENAME&gt;
                </button>
                <button btn-groups="1,2,3" values="<LASTNAME>" type="button" class="codex-btn m-b-10 btn btn-secondary btn-sm">
                    &lt;LASTNAME&gt;
                </button>
                <button btn-groups="1,2,3" values="<BIRTHDATE>" type="button" class="codex-btn m-b-10 btn btn-secondary btn-sm">
                    &lt;BIRTHDATE&gt;
                </button>
                <button btn-groups="1,2,3" values="<EMAIL>" type="button" class="codex-btn m-b-10 btn btn-secondary btn-sm">
                    &lt;EMAIL&gt;
                </button>
                <button btn-groups="2" values="<OUTSTANDING_BALANCE>" type="button" class="codex-btn m-b-10 btn btn-secondary btn-sm" {{ ($template->message_type_id == 2) ? '' : 'disabled="disabled"' }}>
                    &lt;OUTSTANDING BALANCE&gt;
                </button>
                <button btn-groups="2" values="<BILLING_PERIOD>" type="button" class="codex-btn m-b-10 btn btn-secondary btn-sm" {{ ($template->message_type_id == 2) ? '' : 'disabled="disabled"' }}>
                    &lt;BILLING PERIOD&gt;
                </button>
                <button btn-groups="2" values="<BILLING_DUEDATE>" type="button" class="codex-btn m-b-10 btn btn-secondary btn-sm" {{ ($template->message_type_id == 2) ? '' : 'disabled="disabled"' }}>
                    &lt;BILLING DUEDATE&gt;
                </button>
                <button btn-groups="3" values="<GRADE_LEVEL>" type="button" class="codex-btn m-b-10 btn btn-secondary btn-sm" {{ ($template->message_type_id == 3) ? '' : 'disabled="disabled"' }}>
                    &lt;GRADE LEVEL&gt;
                </button>
                <button btn-groups="3" values="<SECTION>" type="button" class="codex-btn m-b-10 btn btn-secondary btn-sm" {{ ($template->message_type_id == 3) ? '' : 'disabled="disabled"' }}>
                    &lt;SECTION&gt;
                </button>
                <button btn-groups="3" values="<ADVISER>" type="button" class="codex-btn m-b-10 btn btn-secondary btn-sm" {{ ($template->message_type_id == 3) ? '' : 'disabled="disabled"' }}>
                    &lt;ADVISER&gt;
                </button>
                <button btn-groups="3" values="<ACADEMICS_STATUS>" type="button" class="codex-btn m-b-10 btn btn-secondary btn-sm" {{ ($template->message_type_id == 3) ? '' : 'disabled="disabled"' }}>
                    &lt;ACADEMIC STATUS&gt;
                </button>
                <button btn-groups="3" values="<REMARKS>" type="button" class="codex-btn m-b-10 btn btn-secondary btn-sm" {{ ($template->message_type_id == 3) ? '' : 'disabled="disabled"' }}>
                    &lt;REMARKS&gt;
                </button>
                <button btn-groups="3" values="<ELIGIBILITY>" type="button" class="codex-btn m-b-10 btn btn-secondary btn-sm" {{ ($template->message_type_id == 3) ? '' : 'disabled="disabled"' }}>
                    &lt;ELIGIBILITY&gt;
                </button>
                <button btn-groups="3" values="<TABLE>" type="button" class="codex-btn m-b-10 btn btn-secondary btn-sm" {{ ($template->message_type_id == 3) ? '' : 'disabled="disabled"' }}>
                    &lt;TABLE&gt;
                </button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 m-n-t-10">
            {{ Form::label('save_as', 'Save template as', ['class' => '']) }}
            <div class="m-radio-inline">
                <label class="m-radio">
                    @if ($template->message_type_id == 1 || $segment == 'add')
                        {{ Form::radio('message_type_id', '1', true) }}
                    @else
                        {{ Form::radio('message_type_id', '1', false) }}
                    @endif
                    <input type="radio" name="message_type_id" value="1" checked="checked">
                    Messaging
                    <span></span>
                </label>
                <label class="m-radio">
                    @if ($template->message_type_id == 2)
                        {{ Form::radio('message_type_id', '2', true) }}
                    @else
                        {{ Form::radio('message_type_id', '2', false) }}
                    @endif
                    SOA
                    <span></span>
                </label>
                <label class="m-radio">
                    @if ($template->message_type_id == 3)
                        {{ Form::radio('message_type_id', '3', true) }}
                    @else
                        {{ Form::radio('message_type_id', '3', false) }}
                    @endif
                    Gradingsheet
                    <span></span>
                </label>
            </div>
        </div>
    </div>
{{ Form::close() }}