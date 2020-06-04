@inject('gradings', 'App\Http\Controllers\GradingSheetsController')
@if ( $segment == 'edit' )
    {{ Form::open(array('url' => 'academics/grading-sheets/all-gradingsheets/update/'.$grading->id, 'name' => 'gradingsheet_form', 'method' => 'PUT')) }}
@else
    {{ Form::open(array('url' => 'academics/grading-sheets/all-gradingsheets/store', 'name' => 'gradingsheet_form', 'method' => 'POST')) }}
@endif
    @if ($segment != 'edit')
        <div class="row">
            <div class="col-md-9">
                <!-- BASIC INFOS START -->
                <div class="m-portlet m-portlet--tab">
                    <div class="m-portlet__body">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="m-bottom-1">Grading Sheet Information</h5>
                            </div>
                        </div>
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
                                <div class="form-group m-form__group required">
                                    {{ Form::label('section_id', 'Section', ['class' => '']) }}
                                    {{  
                                        Form::select('section_id', $sections, !empty($grading) ? $grading->section_id : '', ['class' => 'form-control form-control-lg m-input m-input--solid'])
                                    }}
                                    <span class="m-form__help m--font-danger"></span>
                                </div>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group m-form__group required">
                                    {{ Form::label('subject_id', 'Subject', ['class' => '']) }}
                                    {{  
                                        Form::select('subject_id', $subjects, !empty($grading) ? $grading->subject_id : '', ['class' => 'form-control form-control-lg m-input m-input--solid'])
                                    }}
                                    <span class="m-form__help m--font-danger"></span>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
                <!-- BASIC INFOS END -->
            </div>
            <div class="col-md-3">
                <!-- Quarter TYPE -->
                <div class="m-portlet m-portlet--tab">
                    <div class="m-portlet__body">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="m-bottom-1">Type & Quarter</h5>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group m-form__group required">
                                    {{ Form::label('type', 'Type', ['class' => '']) }}
                                    {{  
                                        Form::select('type', $types, !empty($grading) ? $grading->type : '', ['class' => 'form-control form-control-lg m-input m-input--solid'])
                                    }}
                                    <span class="m-form__help m--font-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group m-form__group required">
                                    {{ Form::label('quarter_id', 'Quarter', ['class' => '']) }}
                                    {{  
                                        Form::select('quarter_id', $quarters, !empty($grading) ? $grading->quarter_id : '', ['class' => 'form-control form-control-lg m-input m-input--solid'])
                                    }}
                                    <span class="m-form__help m--font-danger"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- QUARTER END -->
            </div>
        </div>
    @else
    <div class="row">
        <div class="col-md-12">
            <!-- BASIC INFOS START -->
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="m-bottom-1">Grading Sheet Information</h4>
                            <div class="row hidden">
                                <h5 id="type">{{ $grading->type }}</h5>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>
                                        <strong>Level & Section:</strong>
                                        {{ $grading->level_name }} ({{ $grading->section_name }})
                                    </h5>
                                    <h5 class="m-bottom-2">
                                        <strong>Subject & Teacher:</strong> 
                                        {{ $grading->subject_name }} ({{ $grading->teacher }})
                                    </h5>
                                </div>
                                <div class="col-md-6">
                                    <h5>
                                        <strong>Batch & Quarter:</strong> 
                                        {{ $grading->batch_name }} ({{ $grading->quarter_name }})
                                    </h5>
                                    <h5 class="m-bottom-2">
                                        <strong>Adviser:</strong>
                                        {{ $grading->adviser }}
                                    </h5>
                                </div>
                            </div>

                            <div id="scrolling_table_1" class="scrolly_table">
                                <table id="gradingsheet-table" class="table-bordered">
                                    <tbody>
                                        <tr>
                                            <th class="shaded fixed freeze text-center scrolling_table_1">#</th>
                                            <th class="shaded fixed freeze text-center scrolling_table_1">STUDENT</th>
                                            @foreach ($components as $component)
                                                <th class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 component-header" colspan="{{ $component->columns }}">{{ $component->name }}</th>
                                            @endforeach
                                            <th class="shaded fixed freeze_vertical text-center scrolling_table_1" title="initial grade">Initial</th>
                                            <th class="shaded fixed freeze_vertical text-center scrolling_table_1 quarter-bg" title="quarterly grade">QG</th>
                                            <th class="shaded fixed freeze_vertical text-center scrolling_table_1" title="transmutation value">TC</th>
                                        </tr>
                                        <tr>
                                            <th class="shaded fixed freeze text-center scrolling_table_1">1</th>
                                            <th class="shaded fixed freeze text-center scrolling_table_1">&nbsp;</th>
                                            @php $component_percentage = 0; @endphp
                                            @foreach ($components as $component)
                                                @php $iteration = 1; @endphp
                                                @foreach ($component->activities as $activity)
                                                    <th class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1" title="{{ $activity->activity }}">A{{ $iteration }}</th>
                                                    @php $iteration++; @endphp
                                                @endforeach
                                                @if ($component->is_sum_cell > 0)
                                                    <th class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1" title="total activities">SUM</th>
                                                @endif
                                                @if ($component->is_hps_cell > 0)
                                                    <th class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1" title="highest possible score">HPS</th>
                                                @endif
                                                @if ($component->is_ps_cell > 0)
                                                    <th class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1" title="percentage score">PS</th>
                                                @endif
                                                <th class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1" title="quarterly percentage">{{ $component->percentage }}%</th>
                                                @php $component_percentage += $component->percentage; @endphp
                                            @endforeach
                                            <th class="shaded fixed freeze_vertical text-center scrolling_table_1" title="total quarterly percentage">{{ $component_percentage }}%</th>
                                            <th class="shaded fixed freeze_vertical text-center scrolling_table_1 quarter-bg">&nbsp;</th>
                                            <th class="shaded fixed freeze_vertical text-center scrolling_table_1">&nbsp;</th>
                                        </tr>
                                        <tr class="tr_shaded">
                                            <td class="shaded fixed freeze text-center scrolling_table_1">2</td>
                                            <td class="shaded fixed freeze text-center scrolling_table_1">&nbsp;</td>
                                            @foreach ($components as $component)
                                                @php $iteration = 1; $sumValue = 0; @endphp
                                                @foreach ($component->activities as $activity)
                                                    <th group="{{ $component->id }}" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 activity-cell-header">{{ $activity->value }}</th>
                                                    @php $iteration++; @endphp
                                                @endforeach
                                                @if ($component->is_sum_cell > 0)
                                                    <th group="{{ $component->id }}" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 sum-header">{{ $component->sum_value }}</th>
                                                @endif
                                                @if ($component->is_hps_cell > 0)
                                                    <th group="{{ $component->id }}" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 hps-header">{{ $component->sum_value }}</th>
                                                @endif
                                                @if ($component->is_ps_cell > 0)
                                                    <th group="{{ $component->id }}" maxvalue="{{ $component->sum_value }}" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 ps-header">100%</th>
                                                @endif
                                                <td group="{{ $component->id }}" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 percentage-header">&nbsp;</td>
                                            @endforeach
                                            <td class="shaded fixed freeze_vertical text-center scrolling_table_1">&nbsp;</td>
                                            <td class="shaded fixed freeze_vertical text-center scrolling_table_1 quarter-bg">&nbsp;</td>
                                            <td class="shaded fixed freeze_vertical text-center scrolling_table_1">&nbsp;</td>
                                        </tr>
                                        @php $iteration = 3; @endphp
                                        @foreach ($students as $student)
                                            <tr class="">
                                                <td class="fixed freeze text-center scrolling_table_1">
                                                    {{ $iteration }}
                                                    @php 
                                                        $totalpercentage = 0;
                                                    @endphp
                                                </td>
                                                <td class="fixed freeze text-left scrolling_table_1" title="{{ $student->identification_no }}">{{ $student->fullname }}</td>
                                                @foreach ($components as $component)
                                                    @php 
                                                        $sum = 0;
                                                        $hps = 0;
                                                        $ps = 0;
                                                        $percentage = 0;
                                                    @endphp
                                                    @foreach ($component->activities as $activity)
                                                        @php 
                                                        $score = $gradings->get_activity_score_via_activity($activity->id, $student->student_id, $grading->id);
                                                        $sum += !empty($score) ? floatval($score) : 0 ; 
                                                        if (floatval($score) > 0) { 
                                                            $hps += $activity->value;
                                                        }
                                                        @endphp
                                                        <td group="{{ $component->id }}" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 no-padding">
                                                            <input value="{{ $activity->id.'_'.$student->student_id }}" name="activity[]" class="hidden text-cell" type="text"/>    
                                                            <input maxvalue="{{ $activity->value }}" value="{{ $score }}" name="score[]" class="numeric-double activity-cell text-cell" type="text"/>
                                                        </td>
                                                    @endforeach
                                                    @if ($component->is_sum_cell > 0)
                                                        <td group="{{ $component->id }}" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 no-padding sum-cell">
                                                            {{ $sum }}
                                                        </td>
                                                    @endif
                                                    @if ($component->is_hps_cell > 0)
                                                        <td group="{{ $component->id }}" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 no-padding hps-cell">
                                                            {{ $hps }}
                                                        </td>
                                                    @endif
                                                    @if ($component->is_ps_cell > 0)
                                                        <td group="{{ $component->id }}" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 no-padding ps-cell">
                                                            @php 
                                                                if (floatval($sum) > 0) {
                                                                    $ps = (floatval($sum) / floatval($hps)) * 100; 
                                                                }
                                                            @endphp
                                                            {{ floor($ps*100)/100 }}
                                                        </td>
                                                    @endif
                                                    <td group="{{ $component->id }}" maxvalue="{{ $component->percentage }}" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 percentage-cell">
                                                        @php 
                                                            if (floatval($sum) > 0) {
                                                                $percentage = (floatval($sum) / floatval($hps)) * $component->percentage; 
                                                                $totalpercentage += floatval($percentage);
                                                            }
                                                        @endphp
                                                        {{ floor($percentage*100)/100 }}
                                                    </td>
                                                @endforeach
                                                <td class="shaded fixed freeze_vertical text-center scrolling_table_1 initial-cell">
                                                    {{ $gradings->get_colum_via_gradingsheet_student('initial_grade', $grading->id, $student->student_id) }}
                                                </td>
                                                <td class="shaded fixed freeze_vertical text-center scrolling_table_1 quarter-bg quarter-cell">
                                                    {{ $gradings->get_colum_via_gradingsheet_student('quarter_grade', $grading->id, $student->student_id) }}
                                                </td>
                                                <td class="shaded fixed freeze_vertical text-center scrolling_table_1 no-padding tc-cell">
                                                    <input maxvalue="100" name="init_grade[]" value="{{ $gradings->get_colum_via_gradingsheet_student('initial_grade', $grading->id, $student->student_id) }}" class="hidden numeric-double text-cell" type="text"/>
                                                    <input maxvalue="100" name="quarter_grade[]" value="{{ $gradings->get_colum_via_gradingsheet_student('quarter_grade', $grading->id, $student->student_id) }}" class="hidden numeric-double text-cell" type="text"/>
                                                    <input maxvalue="100" name="tc_score[]" value="{{ $gradings->get_colum_via_gradingsheet_student('adjustment_grade', $grading->id, $student->student_id) }}" class="numeric-double text-cell" type="text"/>
                                                </td>
                                            </tr>
                                            @php $iteration++; @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>                                          		
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        
    <div class="row">
        <div class="col-md-12 ">
            <a href="{{ url('academics/grading-sheets/all-gradingsheets/export-gradingsheet/'.$grading->id ) }}" >
                <button type="button" class="btn btn-success pull-right">
                    Export gradingsheet
                </button>
            </a>
        </div>
    </div>


    @endif
{{ Form::close() }}
