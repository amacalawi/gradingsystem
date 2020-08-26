@inject('staffs', 'App\Http\Controllers\StaffsController')
@if ( $segment == 'edit' )
    {{ Form::open(array('url' => 'academics/attendance-sheets/staff-attendance/settings/update/'.$attendancesheetssettings->id, 'name' => 'attendancesheets_form', 'method' => 'PUT')) }}
@else
    {{ Form::open(array('url' => 'academics/attendance-sheets/staff-attendance/settings/store', 'name' => 'attendancesheets_form', 'method' => 'POST')) }}
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

        <div class="col-md-12" id="staffs-panel">
            @if (!empty($staff->id)) 
                <div  class="form-group m-form__group required">
                    {{ Form::label('member', 'Staff', ['class' => '']) }}
                    {{ 
                        Form::text($name = 'member[]', $value = $staff->identification_no.' - '.$staff->lastname.', '.$staff->firstname.' '.ucfirst($staff->middlename[0])
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
                                Form::text($name = 'member[]', $value = '', 
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

        @if ( $segment == 'add' )
            <div class="col-md-9">
                <div id="staffs-panel-button" class="row m-bottom-1 ">
                    <div class="col-md-12">
                        <button id="add-staff" type="button" class="btn btn-brand">
                            <i class="la la-plus"></i>&nbsp;Add Staff
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <div class="col-md-12">
            <div class="form-group m-form__group required">
                {{ Form::label('schedule', 'Schedule', ['class' => '']) }}
                {{
                    Form::select('schedule_id', $schedule, $value = $attendancesheetssettings->schedule_id, ['class' => 'form-control form-control-lg m-input m-input--solid'])
                }}
                <span class="m-form__help m--font-danger">
                </span>
            </div>
        </div>

    </div>
{{ Form::close() }}