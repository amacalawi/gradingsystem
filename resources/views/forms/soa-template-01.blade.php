@if ( $segment == 'edit' )
    {{ Form::open(array('url' => 'components/csv-management/soa-template-01/update/'.$template->id, 'name' => 'soa_template_form', 'method' => 'PUT')) }}
@else
    {{ Form::open(array('url' => 'components/csv-management/soa-template-01/store', 'name' => 'soa_template_form', 'method' => 'POST')) }}
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
        <div class="col-md-3">
            <div class="form-group m-form__group required">
                {{ Form::label('identification_no', 'Identification No', ['class' => '']) }}
                {{ 
                    Form::text($name = 'identification_no', $value = $template->identification_no, 
                    $attributes = array(
                        'id' => 'identification_no',
                        'class' => 'form-control form-control-lg m-input m-input--solid'
                    )) 
                }}
                <span class="m-form__help m--font-danger">
                </span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group m-form__group required">
                {{ Form::label('firstname', 'Firstname', ['class' => '']) }}
                {{ 
                    Form::text($name = 'firstname', $value = $template->firstname, 
                    $attributes = array(
                        'id' => 'firstname',
                        'class' => 'form-control form-control-lg m-input m-input--solid'
                    )) 
                }}
                <span class="m-form__help m--font-danger">
                </span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group m-form__group required">
                {{ Form::label('middlename', 'Middlename', ['class' => '']) }}
                {{ 
                    Form::text($name = 'middlename', $value = $template->middlename, 
                    $attributes = array(
                        'id' => 'middlename',
                        'class' => 'form-control form-control-lg m-input m-input--solid'
                    )) 
                }}
                <span class="m-form__help m--font-danger">
                </span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group m-form__group required">
                {{ Form::label('lastname', 'Lastname', ['class' => '']) }}
                {{ 
                    Form::text($name = 'lastname', $value = $template->lastname, 
                    $attributes = array(
                        'id' => 'lastname',
                        'class' => 'form-control form-control-lg m-input m-input--solid'
                    )) 
                }}
                <span class="m-form__help m--font-danger">
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group m-form__group required">
                {{ Form::label('outstanding_balance', 'Outstanding Balance', ['class' => '']) }}
                {{ 
                    Form::text($name = 'outstanding_balance', $value = $template->outstanding_balance, 
                    $attributes = array(
                        'id' => 'outstanding_balance',
                        'class' => 'numeric-double form-control form-control-lg m-input m-input--solid'
                    )) 
                }}
                <span class="m-form__help m--font-danger">
                </span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group m-form__group required">
                {{ Form::label('billing_period', 'Billing Period', ['class' => '']) }}
                {{ 
                    Form::text($name = 'billing_period', $value = $template->billing_period, 
                    $attributes = array(
                        'id' => 'billing_period',
                        'class' => 'form-control form-control-lg m-input m-input--solid'
                    )) 
                }}
                <span class="m-form__help m--font-danger">
                </span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group m-form__group required">
                {{ Form::label('billing_due_date', 'Billing Due Date', ['class' => '']) }}
                {{ 
                    Form::date($name = 'billing_due_date', $value = $template->billing_due_date, 
                    $attributes = array(
                        'id' => 'billing_due_date',
                        'class' => 'form-control form-control-lg m-input m-input--solid'
                    )) 
                }}
                <span class="m-form__help m--font-danger">
                </span>
            </div>
        </div>
    </div>
{{ Form::close() }}