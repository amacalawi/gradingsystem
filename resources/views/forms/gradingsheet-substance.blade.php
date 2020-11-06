<div id="scrolling_table_1" class="scrolly_table">
    <table id="gradingsheet-table" class="table-bordered">
        <tbody>
            <tr>
                <th class="shaded fixed freeze text-center scrolling_table_1">#</th>
                <th class="shaded fixed freeze text-center scrolling_table_1">STUDENT</th>
                @foreach ($components as $component)
                    <th class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 component-header" colspan="{{ $component->columns }}" data-toggle="m-tooltip" data-placement="bottom" title="{{ $component->description }}">{{ $component->name }}</th>
                @endforeach
                <th class="shaded fixed freeze_vertical text-center scrolling_table_1" data-toggle="m-tooltip" data-placement="bottom" title="initial grade">Initial</th>
                <th class="shaded fixed freeze_vertical text-center scrolling_table_1 quarter-bg" data-toggle="m-tooltip" data-placement="bottom" title="quarterly grade">QG</th>
                <th class="shaded fixed freeze_vertical text-center scrolling_table_1" data-toggle="m-tooltip" data-placement="bottom" title="transmutation value">TC</th>
                <th class="shaded fixed freeze_vertical text-center scrolling_table_1" data-toggle="m-tooltip" data-placement="bottom" title="rating value">Rating</th>
                <th class="shaded fixed freeze_vertical text-center scrolling_table_1" data-toggle="m-tooltip" data-placement="bottom" title="ranking value">Ranking</th>
            </tr>
            <tr>
                <th class="shaded fixed freeze text-center scrolling_table_1">-</th>
                <th class="shaded fixed freeze text-center scrolling_table_1">&nbsp;</th>
                @php $component_percentage = 0; @endphp
                @foreach ($components as $component)
                    @php $iteration = 1; @endphp
                    @foreach ($component->activities as $activity)
                        <th class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1" data-toggle="m-tooltip" data-placement="bottom" title="{{ $activity->description }}">
                            <input activity_id="{{ $activity->id }}" name="activity_header[]" class="text-cell" value="{{ $activity->activity }}" {{ ($segment == 'edit') ? '' : 'disabled="disabled"'}} type="text"/>
                        </th>
                        @php $iteration++; @endphp
                    @endforeach
                    @if ($component->is_sum_cell > 0)
                        <th class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1" data-toggle="m-tooltip" data-placement="bottom" title="total activities">SUM</th>
                    @endif
                    @if ($component->is_hps_cell > 0)
                        <th class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1" data-toggle="m-tooltip" data-placement="bottom" title="highest possible score">HPS</th>
                    @endif
                    @if ($component->is_ps_cell > 0)
                        <th class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1" data-toggle="m-tooltip" data-placement="bottom" title="percentage score">PS</th>
                    @endif
                    <th class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1" data-toggle="m-tooltip" data-placement="bottom" title="component's percentage">{{ $component->percentage }}%</th>
                    @php $component_percentage += $component->percentage; @endphp
                @endforeach
                <th class="shaded fixed freeze_vertical text-center scrolling_table_1" data-toggle="m-tooltip" data-placement="bottom" title="total component's percentage">{{ $component_percentage }}%</th>
                <th class="shaded fixed freeze_vertical text-center scrolling_table_1 quarter-bg">&nbsp;</th>
                <th class="shaded fixed freeze_vertical text-center scrolling_table_1">&nbsp;</th>
                <th class="shaded fixed freeze_vertical text-center scrolling_table_1">&nbsp;</th>
                <th class="shaded fixed freeze_vertical text-center scrolling_table_1">&nbsp;</th>
            </tr>
            <tr class="tr_shaded">
                <td class="shaded fixed freeze text-center scrolling_table_1">-</td>
                <td class="shaded fixed freeze text-center scrolling_table_1">&nbsp;</td>
                @php $column = 0; @endphp
                @foreach ($components as $component)
                    @php $iteration = 1; $sumValue = 0; @endphp
                    @foreach ($component->activities as $activity)
                        @php $column++; @endphp
                        <th column="{{ $column }}" group="{{ $component->id }}" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 activity-cell-header">
                            <input activity_id="{{ $activity->id }}" name="activity_header_value[]" class="text-cell" value="{{ $activity->value }}" {{ ($segment == 'edit') ? '' : 'disabled="disabled"'}} type="text"/>
                        </th>
                        @php $iteration++; @endphp
                    @endforeach
                    @if ($component->is_sum_cell > 0)
                        @php $column++; @endphp
                        <th column="{{ $column }}" group="{{ $component->id }}" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 sum-header">{{ $component->sum_value }}</th>
                    @endif
                    @if ($component->is_hps_cell > 0)
                        @php $column++; @endphp
                        <th column="{{ $column }}" group="{{ $component->id }}" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 hps-header">{{ $component->sum_value }}</th>
                    @endif
                    @if ($component->is_ps_cell > 0)
                        @php $column++; @endphp
                        <th column="{{ $column }}" group="{{ $component->id }}" maxvalue="{{ $component->sum_value }}" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 ps-header">100%</th>
                    @endif
                    @php $column++; @endphp
                    <td column="{{ $column }}" group="{{ $component->id }}" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 percentage-header">&nbsp;</td>
                @endforeach
                @php $column++; @endphp
                <td column="{{ $column }}" class="shaded fixed freeze_vertical text-center scrolling_table_1">&nbsp;</td>
                @php $column++; @endphp
                <td column="{{ $column }}" class="shaded fixed freeze_vertical text-center scrolling_table_1 quarter-bg">&nbsp;</td>
                @php $column++; @endphp
                <td column="{{ $column }}" class="shaded fixed freeze_vertical text-center scrolling_table_1">&nbsp;</td>
                @php $column++; @endphp
                <td column="{{ $column }}" class="shaded fixed freeze_vertical text-center scrolling_table_1">&nbsp;</td>
                @php $column++; @endphp
                <td column="{{ $column }}" class="shaded fixed freeze_vertical text-center scrolling_table_1">&nbsp;</td>
            </tr>
            @if (count($male_students) > 0)
            <tr class="tr_shaded">
                <td class="fixed freeze text-center scrolling_table_1 gray-bg">-</td>
                <td class="fixed freeze text-center scrolling_table_1 gray-bg">MALE</td>
                @foreach ($components as $component)
                    @foreach ($component->activities as $activity)
                        <td group="{{ $component->id }}" class="fixed freeze_vertical text-center scrolling_table_1 gray-bg">&nbsp;</td>
                    @endforeach
                    @if ($component->is_sum_cell > 0)
                        <td group="{{ $component->id }}" class="fixed freeze_vertical text-center scrolling_table_1 gray-bg">&nbsp;</td>
                    @endif
                    @if ($component->is_hps_cell > 0)
                        <td group="{{ $component->id }}" class="fixed freeze_vertical text-center scrolling_table_1 gray-bg">&nbsp;</td>
                    @endif
                    @if ($component->is_ps_cell > 0)
                        <td group="{{ $component->id }}" class="fixed freeze_vertical text-center scrolling_table_1 gray-bg">&nbsp;</td>
                    @endif
                    <td group="{{ $component->id }}" class="fixed freeze_vertical text-center scrolling_table_1 gray-bg">&nbsp;</td>
                @endforeach
                <td class="fixed freeze_vertical text-center scrolling_table_1 gray-bg">&nbsp;</td>
                <td class="fixed freeze_vertical text-center scrolling_table_1 gray-bg">&nbsp;</td>
                <td class="fixed freeze_vertical text-center scrolling_table_1 gray-bg">&nbsp;</td>
                <td class="fixed freeze_vertical text-center scrolling_table_1 gray-bg">&nbsp;</td>
                <td class="fixed freeze_vertical text-center scrolling_table_1 gray-bg">&nbsp;</td>
            </tr>
            @endif
            <!-- ALL MALE STUDENTS -->
            @php $iteration = 1; @endphp
            @foreach ($male_students as $student)
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
                                <input value="{{ $activity->id.'_'.$student->student_id }}" name="activity[]" class="hidden text-cell" {{ ($segment == 'edit') ? '' : 'disabled="disabled"'}} type="text"/>    
                                <input maxvalue="{{ $activity->value }}" value="{{ $score }}" name="score[]" class="numeric-double activity-cell text-cell" {{ ($segment == 'edit') ? '' : 'disabled="disabled"'}} type="text"/>
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
                        <input maxvalue="100" name="init_grade[]" value="{{ $gradings->get_colum_via_gradingsheet_student('initial_grade', $grading->id, $student->student_id) }}" class="hidden numeric-double text-cell" {{ ($segment == 'edit') ? '' : 'disabled="disabled"'}} type="text"/>
                        <input maxvalue="100" name="quarter_grade[]" value="{{ $gradings->get_colum_via_gradingsheet_student('quarter_grade', $grading->id, $student->student_id) }}" class="hidden numeric-double text-cell" {{ ($segment == 'edit') ? '' : 'disabled="disabled"'}} type="text"/>
                        <input maxvalue="100" name="tc_score[]" value="{{ $gradings->get_colum_via_gradingsheet_student('adjustment_grade', $grading->id, $student->student_id) }}" class="numeric-double text-cell" {{ ($segment == 'edit') ? '' : 'disabled="disabled"'}} type="text"/>
                        <input name="rating[]" value="{{ $gradings->get_colum_via_gradingsheet_student('rating', $grading->id, $student->student_id) }}" class="hidden text-cell" {{ ($segment == 'edit') ? '' : 'disabled="disabled"'}} type="text"/>
                        <input name="ranking[]" value="{{ $gradings->get_colum_via_gradingsheet_student('ranking', $grading->id, $student->student_id) }}" class="hidden text-cell" {{ ($segment == 'edit') ? '' : 'disabled="disabled"'}} type="text"/>        
                    </td>
                    <td class="shaded fixed freeze_vertical text-center scrolling_table_1 no-padding rating-cell">
                        {{ $gradings->get_colum_via_gradingsheet_student('rating', $grading->id, $student->student_id) }}
                    </td>
                    <td class="shaded fixed freeze_vertical text-center scrolling_table_1 no-padding ranking-cell">
                        {{ $gradings->get_colum_via_gradingsheet_student('ranking', $grading->id, $student->student_id) }}
                    </td>
                </tr>
                @php $iteration++; @endphp
            @endforeach
            @if (count($female_students) > 0)
            <tr class="tr_shaded">
                <td class="fixed freeze text-center scrolling_table_1 gray-bg">-</td>
                <td class="fixed freeze text-center scrolling_table_1 gray-bg">FEMALE</td>
                @foreach ($components as $component)
                    @foreach ($component->activities as $activity)
                        <td group="{{ $component->id }}" class="fixed freeze_vertical text-center scrolling_table_1 gray-bg">&nbsp;</td>
                    @endforeach
                    @if ($component->is_sum_cell > 0)
                        <td group="{{ $component->id }}" class="fixed freeze_vertical text-center scrolling_table_1 gray-bg">&nbsp;</td>
                    @endif
                    @if ($component->is_hps_cell > 0)
                        <td group="{{ $component->id }}" class="fixed freeze_vertical text-center scrolling_table_1 gray-bg">&nbsp;</td>
                    @endif
                    @if ($component->is_ps_cell > 0)
                        <td group="{{ $component->id }}" class="fixed freeze_vertical text-center scrolling_table_1 gray-bg">&nbsp;</td>
                    @endif
                    <td group="{{ $component->id }}" class="fixed freeze_vertical text-center scrolling_table_1 gray-bg">&nbsp;</td>
                @endforeach
                <td class="fixed freeze_vertical text-center scrolling_table_1 gray-bg">&nbsp;</td>
                <td class="fixed freeze_vertical text-center scrolling_table_1 gray-bg">&nbsp;</td>
                <td class="fixed freeze_vertical text-center scrolling_table_1 gray-bg">&nbsp;</td>
                <td class="fixed freeze_vertical text-center scrolling_table_1 gray-bg">&nbsp;</td>
                <td class="fixed freeze_vertical text-center scrolling_table_1 gray-bg">&nbsp;</td>
            </tr>
            @endif
            <!-- ALL FEMALE STUDENTS -->
            @foreach ($female_students as $student)
                <tr class="">
                    <td class="fixed freeze text-center scrolling_table_1">
                        {{ $iteration }}
                        @php 
                            $totalpercentage = 0;
                            $column = 0;
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
                            $column++;
                            @endphp
                            <td column="{{ $column }}" group="{{ $component->id }}" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 no-padding">
                                <input value="{{ $activity->id.'_'.$student->student_id }}" name="activity[]" class="hidden text-cell" {{ ($segment == 'edit') ? '' : 'disabled="disabled"'}} type="text"/>    
                                <input maxvalue="{{ $activity->value }}" value="{{ $score }}" name="score[]" class="numeric-double activity-cell text-cell" {{ ($segment == 'edit') ? '' : 'disabled="disabled"'}} type="text"/>
                            </td>
                        @endforeach
                        @if ($component->is_sum_cell > 0)
                            @php $column++; @endphp
                            <td column="{{ $column }}" group="{{ $component->id }}" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 no-padding sum-cell">
                                {{ $sum }}
                            </td>
                        @endif
                        @if ($component->is_hps_cell > 0)
                            @php $column++; @endphp
                            <td column="{{ $column }}" group="{{ $component->id }}" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 no-padding hps-cell">
                                {{ $hps }}
                            </td>
                        @endif
                        @if ($component->is_ps_cell > 0)
                            @php $column++; @endphp
                            <td column="{{ $column }}" group="{{ $component->id }}" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 no-padding ps-cell">
                                @php 
                                    if (floatval($sum) > 0) {
                                        $ps = (floatval($sum) / floatval($hps)) * 100; 
                                    }
                                @endphp
                                {{ floor($ps*100)/100 }}
                            </td>
                        @endif
                        @php $column++; @endphp
                        <td column="{{ $column }}" group="{{ $component->id }}" maxvalue="{{ $component->percentage }}" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 percentage-cell">
                            @php 
                                if (floatval($sum) > 0) {
                                    $percentage = (floatval($sum) / floatval($hps)) * $component->percentage; 
                                    $totalpercentage += floatval($percentage);
                                }
                            @endphp
                            {{ floor($percentage*100)/100 }}
                        </td>
                    @endforeach
                    @php $column++; @endphp
                    <td column="{{ $column }}" class="shaded fixed freeze_vertical text-center scrolling_table_1 initial-cell">
                        {{ $gradings->get_colum_via_gradingsheet_student('initial_grade', $grading->id, $student->student_id) }}
                    </td>
                    @php $column++; @endphp
                    <td column="{{ $column }}" class="shaded fixed freeze_vertical text-center scrolling_table_1 quarter-bg quarter-cell">
                        {{ $gradings->get_colum_via_gradingsheet_student('quarter_grade', $grading->id, $student->student_id) }}
                    </td>
                    @php $column++; @endphp
                    <td column="{{ $column }}" class="shaded fixed freeze_vertical text-center scrolling_table_1 no-padding tc-cell">
                        <input maxvalue="100" name="init_grade[]" value="{{ $gradings->get_colum_via_gradingsheet_student('initial_grade', $grading->id, $student->student_id) }}" class="hidden numeric-double text-cell" {{ ($segment == 'edit') ? '' : 'disabled="disabled"'}} type="text"/>
                        <input maxvalue="100" name="quarter_grade[]" value="{{ $gradings->get_colum_via_gradingsheet_student('quarter_grade', $grading->id, $student->student_id) }}" class="hidden numeric-double text-cell" {{ ($segment == 'edit') ? '' : 'disabled="disabled"'}} type="text"/> 
                        <input maxvalue="100" name="tc_score[]" value="{{ $gradings->get_colum_via_gradingsheet_student('adjustment_grade', $grading->id, $student->student_id) }}" class="numeric-double text-cell" {{ ($segment == 'edit') ? '' : 'disabled="disabled"'}} type="text"/>
                        <input name="rating[]" value="{{ $gradings->get_colum_via_gradingsheet_student('rating', $grading->id, $student->student_id) }}" class="hidden text-cell" {{ ($segment == 'edit') ? '' : 'disabled="disabled"'}} type="text"/>
                        <input name="ranking[]" value="{{ $gradings->get_colum_via_gradingsheet_student('ranking', $grading->id, $student->student_id) }}" class="hidden text-cell" {{ ($segment == 'edit') ? '' : 'disabled="disabled"'}} type="text"/>        
                    </td>
                    @php $column++; @endphp
                    <td column="{{ $column }}" class="shaded fixed freeze_vertical text-center scrolling_table_1 no-padding rating-cell">
                        {{ $gradings->get_colum_via_gradingsheet_student('rating', $grading->id, $student->student_id) }}
                    </td>
                    @php $column++; @endphp
                    <td column="{{ $column }}" class="shaded fixed freeze_vertical text-center scrolling_table_1 no-padding ranking-cell">
                        {{ $gradings->get_colum_via_gradingsheet_student('ranking', $grading->id, $student->student_id) }}
                    </td>
                </tr>
                @php $iteration++; @endphp
            @endforeach
        </tbody>
    </table>
</div> 

@push('scripts')
    <script src="{{ asset('js/forms/gradingsheet-substance.js') }}" type="text/javascript"></script>
@endpush