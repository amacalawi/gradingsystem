@inject('staffs', 'App\Http\Controllers\StaffsController')
@if ( $segment == 'edit' )
    {{ Form::open(array('url' => 'academics/attendance-sheets/staff-attendance/file-attendance/update/'.$attendancesheets->id, 'name' => 'attendancesheets_form', 'method' => 'PUT')) }}
@else
    {{ Form::open(array('url' => 'academics/attendance-sheets/staff-attendance/file-attendance/store', 'name' => 'attendancesheets_form', 'method' => 'POST')) }}
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
        <div class="col-md-12">
            @if (!empty($staff->id)) 
                    <div class="form-group m-form__group required">
                    {{ Form::label('member', 'Staff', ['class' => '']) }}
                    {{ 
                        Form::text($name = 'member', $value = $staff->identification_no.' - '.$staff->lastname.', '.$staff->firstname.' '.ucfirst($staff->middlename[0])
                        , 
                        $attributes = array(
                            'class' => 'full-width typeahead sibling form-control form-control-lg m-input m-input--solid',
                            'placeholder' => 'search for staff number, firstname or lastname'
                        )) 
                    }}
                    <span class="m-form__help m--font-danger"></span>
                </div>
            @else
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group m-form__group required">
                            {{ Form::label('member', 'Staff', ['class' => '']) }}
                            {{ 
                                Form::text($name = 'member', $value = '', 
                                $attributes = array(
                                    'class' => 'full-width typeahead sibling form-control form-control-lg m-input m-input--solid',
                                    'placeholder' => 'search for student number, firstname or lastname'
                                )) 
                            }}
                            <span class="m-form__help m--font-danger"></span>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="col-md-6">
            <div class="form-group m-form__group date" data-provide="datetimepicker" data-date-format="yyyy-mm-dd HH:ii:ss">
                {{ Form::label('timed_in', 'Timed in', ['class' => '']) }}
                {{ 
                    Form::text($name = 'timed_in', $value = $attendancesheets->timed_in, 
                    $attributes = array(
                        'id' => 'timed_in',
                        'class' => 'form-control form-control-lg m-input m-input--solid'
                    )) 
                }}
                <span class="m-form__help m--font-danger"></span>
                <span class="add-on"><i class="icon-remove"></i></span>
                <span class="add-on"><i class="icon-th"></i></span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group m-form__group date" data-provide="datetimepicker" data-date-format="yyyy-mm-dd HH:ii:ss">
                {{ Form::label('timed_out', 'Timed out', ['class' => '']) }}
                {{ 
                    Form::text($name = 'timed_out', $value = $attendancesheets->timed_out, 
                    $attributes = array(
                        'id' => 'timed_out',
                        'class' => 'form-control form-control-lg m-input m-input--solid'
                    )) 
                }}
                <span class="m-form__help m--font-danger"></span>
                <span class="add-on"><i class="icon-remove"></i></span>
                <span class="add-on"><i class="icon-th"></i></span>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group m-form__group required">
                {{ Form::label('type', 'Type', ['class' => '']) }}
                {{
                    Form::select('attendance_category_id', $types, $value = $attendancesheets->attendance_category_id, ['class' => 'form-control form-control-lg m-input m-input--solid'])
                }}
                <span class="m-form__help m--font-danger">
                </span>
            </div>
        </div>        
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group m-form__group">
                {{ Form::label('reason', 'Reason', ['class' => '']) }}
                {{ 
                    Form::textarea($name = 'reason', $value = $attendancesheets->reason, 
                    $attributes = array(
                        'id' => 'reason',
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