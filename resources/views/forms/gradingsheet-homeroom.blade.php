<div id="scrolling_table_1" class="scrolly_table">
    <table id="gradingsheet-table" class="table-bordered">
        <tbody>
            <tr>
                <th class="shaded fixed freeze text-center scrolling_table_1">#</th>
                <th class="shaded fixed freeze text-center scrolling_table_1">Student</th>
                @foreach ($components as $component)
                    <th class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 component-header" colspan="{{ $component->columns }}" data-toggle="m-tooltip" data-placement="bottom" title="{{ $component->description }}">{{ $component->name }}</th>
                @endforeach
                <th class="shaded fixed freeze_vertical text-center scrolling_table_1 quarter-bg" data-toggle="m-tooltip" data-placement="bottom" title="quarterly grade">QG</th>
                <th class="shaded fixed freeze_vertical text-center scrolling_table_1 quarter-bg hidden" data-toggle="m-tooltip" data-placement="bottom" title="quarterly grade">QG</th>
                <th class="shaded fixed freeze_vertical text-center scrolling_table_1 hidden" data-toggle="m-tooltip" data-placement="bottom" title="transmutation value">TC</th>
                <th class="shaded fixed freeze_vertical text-center scrolling_table_1" data-toggle="m-tooltip" data-placement="bottom" title="rating value">Rating</th>
                <th class="shaded fixed freeze_vertical text-center scrolling_table_1" data-toggle="m-tooltip" data-placement="bottom" title="ranking value">Ranking</th>
            </tr>
            <tr>
                <th class="shaded fixed freeze text-center scrolling_table_1"><strong>0</strong></th>
                <th class="shaded fixed freeze text-center scrolling_table_1">&nbsp;</th>
                @php $component_percentage = 0; @endphp
                @foreach ($components as $component)
                    @php $iteration = 1; @endphp
                    <th class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1" data-toggle="m-tooltip" data-placement="bottom" title="component's percentage">{{ $component->percentage }}%</th>
                    @php $component_percentage += $component->percentage; @endphp
                @endforeach
                <th class="shaded fixed freeze_vertical text-center scrolling_table_1 quarter-bg" title="total quarterly percentage"><span class="hidden">{{ $component_percentage }}%</span></th>
                <th class="shaded fixed freeze_vertical text-center scrolling_table_1 quarter-bg hidden">&nbsp;</th>
                <th class="shaded fixed freeze_vertical text-center scrolling_table_1 hidden">&nbsp;</th>
                <th class="shaded fixed freeze_vertical text-center scrolling_table_1">&nbsp;</th>
                <th class="shaded fixed freeze_vertical text-center scrolling_table_1">&nbsp;</th>
            </tr>
            @php $iteration = 1; @endphp
            @foreach ($students as $student)
                <tr class="">
                    <td class="fixed freeze text-center scrolling_table_1">
                        <strong>{{ $iteration }}</strong>
                        @php 
                            $totalpercentage = 0;
                        @endphp
                    </td>
                    <td class="fixed freeze text-left scrolling_table_1" title="{{ $student->identification_no }}">{{ $student->fullname }}</td>
                    @foreach ($components as $component)
                        @php 
                            $score = $gradings->get_component_score_via_component($component->id, $student->student_id, $grading->id);
                        @endphp
                        <td group="{{ $component->id }}" percentage="{{ $component->percentage }} " maxvalue="100" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1">
                            <input value="{{ $component->id.'_'.$student->student_id }}" name="component[]" class="hidden text-cell" type="text"/>    
                            <input maxvalue="100" value="{{ $score }}" name="score[]" class="numeric-double component-cell text-cell" type="text"/>
                        </td>
                    @endforeach
                    <td class="shaded fixed freeze_vertical text-center scrolling_table_1 quarter-bg initial-cell">
                        {{ $gradings->get_colum_via_gradingsheet_student('initial_grade', $grading->id, $student->student_id) }}
                    </td>
                    <td class="shaded fixed freeze_vertical text-center scrolling_table_1 hidden quarter-bg quarter-cell">
                        {{ $gradings->get_colum_via_gradingsheet_student('quarter_grade', $grading->id, $student->student_id) }}
                    </td>
                    <td class="shaded fixed freeze_vertical text-center scrolling_table_1 no-padding tc-cell hidden">
                        <input maxvalue="100" name="init_grade[]" value="{{ $gradings->get_colum_via_gradingsheet_student('initial_grade', $grading->id, $student->student_id) }}" class="hidden numeric-double text-cell" type="text"/>
                        <input maxvalue="100" name="quarter_grade[]" value="{{ $gradings->get_colum_via_gradingsheet_student('quarter_grade', $grading->id, $student->student_id) }}" class="hidden numeric-double text-cell" type="text"/>
                        <input maxvalue="100" name="tc_score[]" value="{{ $gradings->get_colum_via_gradingsheet_student('adjustment_grade', $grading->id, $student->student_id) }}" class="numeric-double text-cell" type="text"/>
                        <input name="rating[]" value="{{ $gradings->get_colum_via_gradingsheet_student('rating', $grading->id, $student->student_id) }}" class="hidden text-cell" type="text"/>
                        <input name="ranking[]" value="{{ $gradings->get_colum_via_gradingsheet_student('ranking', $grading->id, $student->student_id) }}" class="hidden text-cell" type="text"/>
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
        </tbody>
    </table>
</div> 

@push('scripts')
    <script src="{{ asset('js/forms/gradingsheet-homeroom.js') }}" type="text/javascript"></script>
@endpush