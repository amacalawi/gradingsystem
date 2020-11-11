@inject('gradings', 'App\Http\Controllers\GradingSheetsController')

<style>
    .m-badge--lemon {
      background-color:#FFD600;
    }
    .m-badge--secondary{
      background-color:#eaeaea;
    }
    .m-badge--metal{
      background-color:#c4c5d6;
    }
    .m-badge--amber{
      background-color:#ffc107 ;
    }
    .m-badge--lime{
      background-color:#8BC34A ;
    }
    .m-badge--success{
      background-color:#34bfa3 ;
    }
    .m-badge--info{
      background-color:#36a3f7;
    }
    .m-badge--accent{
      background-color:#00c5dc ;
    }
    .m-badge--purple{
      background-color:#BA68C8 ;
    }
    .font-family-default{
      font-family:Arial;
    }
</style>

@php
    function get_clour($colour)
    {
        if($colour == 'm-badge--lemon')
        {
            return '#FFD600';
        }
        if($colour == 'm-badge--secondary')
        {
            return '#eaeaea';
        }
        if($colour == 'm-badge--metal')
        {
            return '#c4c5d6';
        }
        if($colour == 'm-badge--amber')
        {
            return '#ffc107';
        }
        if($colour == 'm-badge--lime')
        {
            return '#8BC34A';
        }
        if($colour == 'm-badge--success')
        {
            return '#34bfa3';
        }
        if($colour == 'm-badge--info')
        {
            return '#36a3f7';
        }
        if($colour == 'm-badge--accent')
        {
            return '#00c5dc';
        }
        if($colour == 'm-badge--purple')
        {
            return '#BA68C8';
        }
    }

    function get_coloumcount($coloums)
    {
        $count = 4;
        foreach($coloums as $coloum)
        {
            $count++;
        }

        return $count;
    }
@endphp

<table id="gradingsheet-table" class="table-bordered" style="1px solid black;">
    <tbody>
        {{--1--}}
        <tr>
            <th colspan="35" rowspan="2" valign="middle" style="text-align:center;">
                <h4><b>Class Record</b></h4>
            </th>
        </tr>

        {{--2--}}
        <tr>
            <th colspan="35" style="text-align:center;">
            </th>
        </tr>

        {{--3--}}
        <tr>
            <th colspan="35" style="text-align:center;">
                <li>(Pursuant to Deped Order 8 series of 2015)</li>
            </th>
        </tr>

        {{--4--}}
        <tr>
            <th colspan="6" style="text-align: right;">
                <h4><b>REGION</b></h4>
            </th>
            <th colspan="4" style="border: 5px solid black;"></th>

            <th colspan="4" style="text-align: right;">
                <h4><b>DIVISION</b></h4>
            </th>
            <th colspan="4" style="border: 5px solid black;"></th>

            <th></th>
            
            <th colspan="4" style="text-align: right;">
                <h4><b>DISTRICT</b></h4>
            </th>
            <th colspan="6" style="border: 1px solid black;"></th>
        </tr>

        {{--5--}}
        <tr>
            <th colspan="6" style="text-align: right;">
                <h4><b>SCHOOL NAME</b></h4>
            </th>
            <th colspan="12" style="border: 5px solid black;"></th>

            <th></th>

            <th colspan="4" style="text-align: right;">
                <h4><b>SCHOOL ID</b></h4>
            </th>
            <th colspan="6" style="border: 5px solid black;"></th>

            <th colspan="3" style="text-align: right;">
                <h4><b>SCHOOL YEAR</b></h4>
            </th>
            <th colspan="3" style="border: 1px solid black;"></th>
        </tr>
        
        {{--6--}}
        <tr>
            <th colspan="35">
            </th>
        </tr> 

        {{--7--}}
        <tr>
            <th colspan="5" style="text-align: center;" >
                <h4><b>{{ strtoupper($grading->quarter_name) }}</b></h4>
            </th>

            <th colspan="5" style="border: 50px solid black; text-align: right;">
                <h4><b>GRADE AND SECTION: </b></h4>
            </th>
            <th colspan="6" style="border: 50px solid black; text-align: left;">
                <h4><b>{{ strtoupper($grading->level_name) }} - {{ strtoupper($grading->section_name) }}</b></h4>
            </th>

            <th colspan="3" style="border: 50px solid black; text-align: right;">
                <h4><b>TEACHER: </b></h4>
            </th>
            <th colspan="9" style="border: 50px solid black; text-align: left;">
                <h4><b>{{ strtoupper($grading->adviser) }}</b></h4>
            </th>

            <th colspan="4" style="border: 50px solid black; text-align: right;">
                <h4><b>SUBJECT: </b></h4>
            </th>
            <th colspan="3" style="border: 50px solid black; text-align: left;">
                <h4><b>{{ strtoupper($grading->subject_name) }}</b></h4>
            </th>
        </tr>
               
        {{--8--}}
        <tr>
            @php
                $column_letter_repo = array();
                $column_letter = 'A';
            @endphp

            <th valign="middle" style="border: 1px solid black;" class="shaded fixed freeze text-center scrolling_table_1"> </th> 
            <th valign="middle" colspan="4" style="word-wrap: break-word; overflow-wrap: break-word; border: 1px solid black; text-align: center;" class="shaded fixed freeze text-center scrolling_table_1">LEARNERS' NAME</th>
            @foreach ($components as $component)
                @php $colored = get_clour($component->palette); @endphp
                @php $coloumcount = get_coloumcount($component->activities); @endphp
                <th valign="middle" colspan="{{ $coloumcount }}" style="word-wrap: break-word; overflow-wrap: break-word; text-align: center; border-collapse: collapse; border: 1px solid black;" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 component-header" >{{ strtoupper($component->name) }} ({{$component->percentage}}%)</th>
            @endforeach
            <th valign="middle" style="word-wrap: break-word; overflow-wrap: break-word; text-align: center; border: 2px solid black;" class="shaded fixed freeze_vertical text-center scrolling_table_1" title="initial grade">INITIAL</th>
            <th valign="middle" style="word-wrap: break-word; overflow-wrap: break-word; text-align: center; border: 2px solid black;" class="shaded fixed freeze_vertical text-center scrolling_table_1 quarter-bg" title="quarterly grade">QG</th>
            <th valign="middle" style="word-wrap: break-word; overflow-wrap: break-word; text-align: center; border: 2px solid black;" class="shaded fixed freeze_vertical text-center scrolling_table_1" title="transmutation value">TC</th>
            <th valign="middle" style="word-wrap: break-word; overflow-wrap: break-word; text-align: center; border: 2px solid black;" class="shaded fixed freeze_vertical text-center scrolling_table_1" title="transmutation value">RATING</th>
            <th valign="middle" style="word-wrap: break-word; overflow-wrap: break-word; text-align: center; border: 2px solid black;" class="shaded fixed freeze_vertical text-center scrolling_table_1" title="transmutation value">RANKING</th>
        </tr>

        {{--9--}}
        <tr>
            <th style="border: 1px solid black;" class="shaded fixed freeze text-center scrolling_table_1"></th> @php $column_letter_repo['#'] = $column_letter++; @endphp
            <th colspan="4" style="text-align: left; border: 1px solid black;" class="shaded fixed freeze text-center scrolling_table_1">{{ strtoupper($grading->subject_name) }}</th> 
            @php 
                for($x=0; $x<4; $x++ ){
                    $column_letter++; 
                }
                $column_letter_repo['student'] = $column_letter;
            @endphp
            @php $component_percentage = 0; @endphp
            
            @foreach ($components as $component)
                @php $iteration = 1; @endphp
                @php $colored = get_clour($component->palette); @endphp
                @foreach ($component->activities as $activity)
                    <th style="text-align: center; border: 2px solid black;" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1" title="{{ $activity->activity }}">A{{ $iteration }}</th> @php $column_letter_repo['A'.$column_letter] =  $column_letter++; @endphp
                    @php $iteration++; @endphp
                @endforeach
                <th style="text-align: center; border: 2px solid black; " class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1" title="total activities">SUM</th> @php $column_letter_repo['SUM'.$column_letter] =  $column_letter++; @endphp
                <th style="text-align: center; border: 2px solid black; " class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1" title="highest possible score">HPS</th>@php $column_letter_repo['HPS'.$column_letter] =  $column_letter++; @endphp
                <th style="text-align: center; border: 2px solid black; " class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1" title="percentage score">PS</th>@php $column_letter_repo['PS'.$column_letter] =  $column_letter++; @endphp
                <th style="text-align: center; border: 2px solid black; " class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1" title="quarterly percentage">{{ $component->percentage }}%</th> @php $column_letter_repo['percent'.$column_letter] =  $column_letter++; @endphp
                @php $component_percentage += $component->percentage; @endphp
            @endforeach
            <th style="text-align: center; border: 2px solid black;" class="shaded fixed freeze_vertical text-center scrolling_table_1" title="total quarterly percentage">{{ $component_percentage }}%</th>@php $column_letter_repo['initial'] =  $column_letter++; @endphp
            <th style="text-align: center; border: 2px solid black;" class="shaded fixed freeze_vertical text-center scrolling_table_1 quarter-bg">&nbsp;</th>@php $column_letter_repo['QG'] =  $column_letter++; @endphp
            <th style="text-align: center; border: 2px solid black;" class="shaded fixed freeze_vertical text-center scrolling_table_1">&nbsp;</th>@php $column_letter_repo['TC'] =  $column_letter++; @endphp
            <th style="text-align: center; border: 2px solid black;" class="shaded fixed freeze_vertical text-center scrolling_table_1">&nbsp;</th>
            <th style="text-align: center; border: 2px solid black;" class="shaded fixed freeze_vertical text-center scrolling_table_1">&nbsp;</th>
        </tr>

        {{--10--}}
        <tr class="tr_shaded">
            <td style="border: 2px solid black;" class="shaded fixed freeze text-center scrolling_table_1"></td>
            <td colspan="4" style="text-align: right; border: 2px solid black;" class="shaded fixed freeze text-center scrolling_table_1">HIGHEST POSIBLE SCORE</td>
            @foreach ($components as $component)
                @php $iteration = 1; $sumValue = 0; @endphp
                @foreach ($component->activities as $activity)
                    @php $colored = get_clour($component->palette); @endphp
                    <th style="text-align: center; border: 2px solid black;" group="{{ $component->id }}" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 activity-cell-header">{{ $activity->value }}</th>
                    @php $iteration++; @endphp
                @endforeach
                    <td style="text-align: center; border: 2px solid black;" group="{{ $component->id }}" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 sum-header">{{ $component->sum_value }}</td>
                    <td style="text-align: center; border: 2px solid black;" group="{{ $component->id }}" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 hps-header">{{ $component->sum_value }}</td>
                    <td style="text-align: center; border: 2px solid black;" group="{{ $component->id }}" maxvalue="{{ $component->sum_value }}" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 ps-header">100%</td>
                    <td style="text-align: center; border: 2px solid black;" group="{{ $component->id }}" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 percentage-header">&nbsp;</td>
            @endforeach
            <td style="text-align: center; border: 2px solid black;" class="shaded fixed freeze_vertical text-center scrolling_table_1">&nbsp;</td>
            <td style="text-align: center; border: 2px solid black;" class="shaded fixed freeze_vertical text-center scrolling_table_1 quarter-bg">&nbsp;</td>
            <td style="text-align: center; border: 2px solid black;" class="shaded fixed freeze_vertical text-center scrolling_table_1">&nbsp;</td>
            <td style="text-align: center; border: 2px solid black;" class="shaded fixed freeze_vertical text-center scrolling_table_1">&nbsp;</td>
            <td style="text-align: center; border: 2px solid black;" class="shaded fixed freeze_vertical text-center scrolling_table_1">&nbsp;</td>
        </tr>
        
        {{--11--}}
        @php 
            $iteration = 6; 
            $rownumber = 11; //start of student
            //$total_row_after = $rownumber+count($students)+3; // 3 number of spaces row
            //$total_row_befor = $total_row_after+40 // 40 number of qg_lookup
        @endphp
        @if (count($male_students) > 0)
            <tr class="tr_shaded">
                <td style="background-color:#9e9e9e; border: 2px solid black;" class="fixed freeze text-center scrolling_table_1 gray-bg"> </td>
                <td colspan="4" style="background-color:#9e9e9e; border: 2px solid black;" class="fixed freeze text-center scrolling_table_1 gray-bg">MALE</td>
                @foreach ($components as $component)
                    @foreach ($component->activities as $activity)
                        <td group="{{ $component->id }}" style="background-color:#9e9e9e; border: 2px solid black;" class="fixed freeze_vertical text-center scrolling_table_1 gray-bg">&nbsp;</td>
                    @endforeach
                    {{--@if ($component->is_sum_cell > 0)--}}
                        <td group="{{ $component->id }}" style="background-color:#9e9e9e; border: 2px solid black;" class="fixed freeze_vertical text-center scrolling_table_1 gray-bg">&nbsp;</td>
                    {{--@endif--}}
                    {{--@if ($component->is_hps_cell > 0)--}}
                        <td group="{{ $component->id }}" style="background-color:#9e9e9e; border: 2px solid black;" class="fixed freeze_vertical text-center scrolling_table_1 gray-bg">&nbsp;</td>
                    {{--@endif--}}
                    {{--@if ($component->is_ps_cell > 0)--}}
                        <td group="{{ $component->id }}" style="background-color:#9e9e9e; border: 2px solid black;" class="fixed freeze_vertical text-center scrolling_table_1 gray-bg">&nbsp;</td>
                    {{--@endif--}}
                        <td group="{{ $component->id }}" style="background-color:#9e9e9e; border: 2px solid black;" class="fixed freeze_vertical text-center scrolling_table_1 gray-bg">&nbsp;</td>
                @endforeach
                <td style="background-color:#9e9e9e; border: 2px solid black;" class="fixed freeze_vertical text-center scrolling_table_1 gray-bg">&nbsp;</td>
                <td style="background-color:#9e9e9e; border: 2px solid black;" class="fixed freeze_vertical text-center scrolling_table_1 gray-bg">&nbsp;</td>
                <td style="background-color:#9e9e9e; border: 2px solid black;" class="fixed freeze_vertical text-center scrolling_table_1 gray-bg">&nbsp;</td>
                <td style="background-color:#9e9e9e; border: 2px solid black;" class="fixed freeze_vertical text-center scrolling_table_1 gray-bg">&nbsp;</td>
                <td style="background-color:#9e9e9e; border: 2px solid black;" class="fixed freeze_vertical text-center scrolling_table_1 gray-bg">&nbsp;</td>
            </tr>
            @php
                $rownumber++;   
            @endphp
        @endif

        {{--12--}}
        @php
            $count_male = 1;    
        @endphp
        @foreach ($male_students as $student)
            @php
                $columnletter_x = 'B'; 
                $columnletter_y = 'A';

                $hps_col_x = 'F';
                $percent_col_x = 'F';
                $percent_array = array();
            @endphp
            <tr class="">
                <td style="text-align: center; border: 2px solid black;" class="fixed freeze text-center scrolling_table_1">
                    {{-- $iteration --}} {{ $count_male }}
                    @php
                        $count_male++;
                        $totalpercentage = 0;
                        $columnletter_x++;
                        $columnletter_y++;
                    @endphp
                </td>
                <td colspan="4" style="border: 2px solid black;" class="fixed freeze text-left scrolling_table_1" title="{{ $student->identification_no }}">
                    {{ $student->fullname }}
                    @php 
                        for($x=0; $x<3; $x++){
                            $columnletter_x++;
                            $columnletter_y++;
                        }
                        //$columnletter_y++;
                    @endphp
                </td>

                @foreach ($components as $component)
                    
                    @php $colored = get_clour($component->palette); @endphp

                    @php 
                        $sum = 0;
                        $hps = 0;
                        $ps = 0;
                        $percentage = 0;
                    @endphp

                    <!-- A(N) -->
                    @foreach ($component->activities as $activity)
                        @php 
                            $score = $gradings->get_activity_score_via_activity($activity->id, $student->student_id, $grading->id);
                            $sum += !empty($score) ? floatval($score) : 0 ; 
                            
                            if (floatval($score) > 0) { 
                                $hps += $activity->value;
                            }

                            $columnletter_y++;
                            $colored = get_clour($component->palette);
                        @endphp
                        {{--background-color:{{$colored}};--}}
                        <td style="text-align: center; border: 2px solid black;" group="{{ $component->id }}" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 no-padding">
                            {{$score}}
                        </td>
                    @endforeach


                    <!-- SUM -->
                    <td style="text-align: center; border: 2px solid black;" group="{{ $component->id }}" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 no-padding sum-cell">
                        =SUM({{$columnletter_x}}{{$rownumber}}:{{$columnletter_y}}{{$rownumber}})
                    </td>
                    @php
                        $columnletter_x++;
                        $columnletter_y++;
                        $columnletter_x = $columnletter_y;
                        $sum_col_location = $columnletter_x;
                        $percent_col_x = $columnletter_x;
                        $columnletter_x++;
                    @endphp


                    <!-- HPS -->
                    @php
                        $count = 1;
                        $hps_row_default = 10; //Change only if table adjusted
                        $hps_formula = '=(';
                    @endphp

                    @foreach ($component->activities as $activity)
                        @php
                            $hps_formula .= 'IF('.$hps_col_x.$rownumber.'="" , 0, '.$hps_col_x.$hps_row_default.')';
                                
                            if( count($component->activities) > $count ){
                                $hps_formula .= '+';
                                $count++;
                            }

                            $hps_col_x++;

                        @endphp
                    @endforeach

                    @php
                        $hps_formula .= ')';
                        $hps_col_x++;
                        $hps_col_location = $hps_col_x;
                    @endphp

                    <td style="text-align: center; border: 2px solid black;" group="{{ $component->id }}" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 no-padding hps-cell">
                        {{$hps_formula}} <!-- HPS Complete Formula -->
                    </td>

                    @php
                        $columnletter_x++;
                        $columnletter_y++;
                        $hps_col_x++;
                        $percent_col_x++; 
                    @endphp 


                    <!-- PS -->
                    @php
                        $ps_formula = '=IF('.$sum_col_location.$rownumber.'>0,'.'('.$sum_col_location.$rownumber.'/'.$hps_col_location.$rownumber.')*100,0)'; 
                    @endphp
                    
                    <td style="text-align: center; border: 2px solid black;" group="{{ $component->id }}" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 no-padding ps-cell">
                        {{$ps_formula}} <!-- PS Complete Formula -->
                    </td>            
                    @php
                        $columnletter_x++;
                        $columnletter_y++;
                        $hps_col_x++;
                        $percent_col_x++; 
                    @endphp


                    <!-- Percent N% -->
                    <td style="text-align: center; border: 2px solid black;" group="{{ $component->id }}" maxvalue="{{ $component->percentage }}" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 percentage-cell">
                        
                        @php
                            $percent_col_x++; 
                            $percent_formula = '=ROUND('.$columnletter_y.$rownumber.'*'.$percent_col_x.'9'.',2)';
                        @endphp
                        {{ $percent_formula }} <!-- Percent Complete Formula -->
                    </td>
                    @php
                        $columnletter_x++;
                        $columnletter_y++;
                        $hps_col_x++;
                        array_push($percent_array, $columnletter_y);
                    @endphp

                @endforeach


                <!-- Initial -->
                <td style="text-align: center; border: 2px solid black; background-color:#f4f5f8;" class="shaded fixed freeze_vertical text-center scrolling_table_1 initial-cell">
                    @php
                        $initial_formula = '=(';
                        $initial_counter = 1;

                        foreach($percent_array as $key => $value){
                            
                            $initial_formula .= $value.$rownumber;
                            if(count($percent_array) > $initial_counter ){
                                $initial_formula .= '+';
                                $initial_counter++;
                            }
                        }
                        
                        //Add TC value
                        $initial_formula .= ')+';
                        $initial_formula .= $column_letter_repo['TC'].$rownumber;
                        
                    @endphp

                    {{$initial_formula}} <!-- Initial Complete Formula -->
                </td>


                <!-- QG -->
                <td style="text-align: center; border: 2px solid black; background-color:#fffcbe;" class="shaded fixed freeze_vertical text-center scrolling_table_1 quarter-bg quarter-cell">
                    @php
                        //$qg_formula = "=LOOKUP(".$column_letter_repo['initial'].$rownumber.","."'Quarter Grade'! A".$total_row_after.":"."B".$total_row_befor.")";
                        $qg_formula = "=LOOKUP(".$column_letter_repo['initial'].$rownumber.","."'Quarter Grade'! A2:"."B42)";
                    @endphp
                    {{$qg_formula}} <!-- QG Complete Formula -->
                </td>


                <!-- TC -->
                <td style="text-align: center; border: 2px solid black; background-color:#f4f5f8;" class="shaded fixed freeze_vertical text-center scrolling_table_1 no-padding tc-cell">
                    {{ $gradings->get_colum_via_gradingsheet_student('adjustment_grade', $grading->id, $student->student_id) }}
                </td>

                <!-- Rating -->
                <td style="text-align: center; border: 2px solid black; background-color:#f4f5f8;" class="shaded fixed freeze_vertical text-center scrolling_table_1 no-padding tc-cell">
                    {{ $gradings->get_colum_via_gradingsheet_student('rating', $grading->id, $student->student_id) }}
                </td>

                <!-- Ranking -->
                <td style="text-align: center; border: 2px solid black; background-color:#f4f5f8;" class="shaded fixed freeze_vertical text-center scrolling_table_1 no-padding tc-cell">
                    {{ $gradings->get_colum_via_gradingsheet_student('ranking', $grading->id, $student->student_id) }}
                </td>                
            </tr>

            @php $iteration++; $rownumber++; @endphp
        
        @endforeach


        <!-- Female -->
        @if (count($female_students) > 0)
            <tr class="tr_shaded">
                <td style="background-color:#9e9e9e; border: 2px solid black;" class="fixed freeze text-center scrolling_table_1 gray-bg"> </td>
                <td colspan="4" style="background-color:#9e9e9e; border: 2px solid black;" class="fixed freeze text-center scrolling_table_1 gray-bg">FEMALE</td>
                @foreach ($components as $component)
                    @foreach ($component->activities as $activity)
                        <td group="{{ $component->id }}" style="background-color:#9e9e9e; border: 2px solid black;" class="fixed freeze_vertical text-center scrolling_table_1 gray-bg">&nbsp;</td>
                    @endforeach
                    {{--@if ($component->is_sum_cell > 0)--}}
                        <td group="{{ $component->id }}" style="background-color:#9e9e9e; border: 2px solid black;" class="fixed freeze_vertical text-center scrolling_table_1 gray-bg">&nbsp;</td>
                    {{--@endif--}}
                    {{--@if ($component->is_hps_cell > 0)--}}
                        <td group="{{ $component->id }}" style="background-color:#9e9e9e; border: 2px solid black; " class="fixed freeze_vertical text-center scrolling_table_1 gray-bg">&nbsp;</td>
                    {{--@endif--}}
                    {{--@if ($component->is_ps_cell > 0)--}}
                        <td group="{{ $component->id }}" style="background-color:#9e9e9e; border: 2px solid black;" class="fixed freeze_vertical text-center scrolling_table_1 gray-bg">&nbsp;</td>
                    {{--@endif--}}
                        <td group="{{ $component->id }}" style="background-color:#9e9e9e; border: 2px solid black;" class="fixed freeze_vertical text-center scrolling_table_1 gray-bg">&nbsp;</td>
                @endforeach
                <td style="background-color:#9e9e9e; border: 2px solid black;" class="fixed freeze_vertical text-center scrolling_table_1 gray-bg">&nbsp;</td>
                <td style="background-color:#9e9e9e; border: 2px solid black;" class="fixed freeze_vertical text-center scrolling_table_1 gray-bg">&nbsp;</td>
                <td style="background-color:#9e9e9e; border: 2px solid black;" class="fixed freeze_vertical text-center scrolling_table_1 gray-bg">&nbsp;</td>
                <td style="background-color:#9e9e9e; border: 2px solid black;" class="fixed freeze_vertical text-center scrolling_table_1 gray-bg">&nbsp;</td>
                <td style="background-color:#9e9e9e; border: 2px solid black;" class="fixed freeze_vertical text-center scrolling_table_1 gray-bg">&nbsp;</td>
            </tr>
            @php
                $rownumber++;   
            @endphp
        @endif

        @php
            $count_female = 1;    
        @endphp
        @foreach ($female_students as $student)
            @php
                $columnletter_x = 'B'; 
                $columnletter_y = 'A';

                $hps_col_x = 'F';
                $percent_col_x = 'F';
                $percent_array = array();
            @endphp
            <tr class="">
                <td style="text-align: center; border: 2px solid black;" class="fixed freeze text-center scrolling_table_1">
                    {{-- $iteration --}} {{ $count_female }}
                    @php 
                        $count_female++;
                        $totalpercentage = 0;
                        $columnletter_x++;
                        $columnletter_y++;
                    @endphp
                </td>
                <td colspan="4" style="border: 2px solid black;" class="fixed freeze text-left scrolling_table_1" title="{{ $student->identification_no }}">
                    {{ $student->fullname }}
                    @php 
                        for($x=0; $x<3; $x++){
                            $columnletter_x++;
                            $columnletter_y++;
                        }
                        //$columnletter_y++;
                    @endphp
                </td>

                @foreach ($components as $component)
                    
                    @php $colored = get_clour($component->palette); @endphp

                    @php 
                        $sum = 0;
                        $hps = 0;
                        $ps = 0;
                        $percentage = 0;
                    @endphp

                    <!-- A(N) -->
                    @foreach ($component->activities as $activity)
                        @php 
                            $score = $gradings->get_activity_score_via_activity($activity->id, $student->student_id, $grading->id);
                            $sum += !empty($score) ? floatval($score) : 0 ; 
                            
                            if (floatval($score) > 0) { 
                                $hps += $activity->value;
                            }

                            $columnletter_y++;
                            $colored = get_clour($component->palette);
                        @endphp
                        {{-- background-color:{{$colored}}; --}}
                        <td style="text-align: center; border: 2px solid black;" group="{{ $component->id }}" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 no-padding">
                            {{$score}}
                        </td>
                    @endforeach


                    <!-- SUM -->
                    <td style="text-align: center; border: 2px solid black;" group="{{ $component->id }}" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 no-padding sum-cell">
                        =SUM({{$columnletter_x}}{{$rownumber}}:{{$columnletter_y}}{{$rownumber}})
                    </td>
                    @php
                        $columnletter_x++;
                        $columnletter_y++;
                        $columnletter_x = $columnletter_y;
                        $sum_col_location = $columnletter_x;
                        $percent_col_x = $columnletter_x;
                        $columnletter_x++;
                    @endphp


                    <!-- HPS -->
                    @php
                        $count = 1;
                        $hps_row_default = 10; //Change only if table adjusted
                        $hps_formula = '=(';
                    @endphp

                    @foreach ($component->activities as $activity)
                        @php
                            $hps_formula .= 'IF('.$hps_col_x.$rownumber.'="" , 0, '.$hps_col_x.$hps_row_default.')';
                                
                            if( count($component->activities) > $count ){
                                $hps_formula .= '+';
                                $count++;
                            }

                            $hps_col_x++;

                        @endphp
                    @endforeach

                    @php
                        $hps_formula .= ')';
                        $hps_col_x++;
                        $hps_col_location = $hps_col_x;
                    @endphp

                    <td style="text-align: center; border: 2px solid black; " group="{{ $component->id }}" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 no-padding hps-cell">
                        {{$hps_formula}} <!-- HPS Complete Formula -->
                    </td>

                    @php
                        $columnletter_x++;
                        $columnletter_y++;
                        $hps_col_x++;
                        $percent_col_x++; 
                    @endphp 


                    <!-- PS -->
                    @php
                        $ps_formula = '=IF('.$sum_col_location.$rownumber.'>0,'.'('.$sum_col_location.$rownumber.'/'.$hps_col_location.$rownumber.')*100,0)'; 
                    @endphp
                    
                    <td style="text-align: center; border: 2px solid black;" group="{{ $component->id }}" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 no-padding ps-cell">
                        {{$ps_formula}} <!-- PS Complete Formula -->
                    </td>            
                    @php
                        $columnletter_x++;
                        $columnletter_y++;
                        $hps_col_x++;
                        $percent_col_x++; 
                    @endphp


                    <!-- Percent N% -->
                    <td style="text-align: center; border: 2px solid black;" group="{{ $component->id }}" maxvalue="{{ $component->percentage }}" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 percentage-cell">
                        
                        @php
                            $percent_col_x++; 
                            $percent_formula = '=ROUND('.$columnletter_y.$rownumber.'*'.$percent_col_x.'9'.',2)';
                        @endphp
                        {{ $percent_formula }} <!-- Percent Complete Formula -->
                    </td>
                    @php
                        $columnletter_x++;
                        $columnletter_y++;
                        $hps_col_x++;
                        array_push($percent_array, $columnletter_y);
                    @endphp

                @endforeach


                <!-- Initial -->
                <td style="text-align: center; border: 2px solid black; background-color:#f4f5f8;" class="shaded fixed freeze_vertical text-center scrolling_table_1 initial-cell">
                    @php
                        $initial_formula = '=(';
                        $initial_counter = 1;

                        foreach($percent_array as $key => $value){
                            
                            $initial_formula .= $value.$rownumber;
                            if(count($percent_array) > $initial_counter ){
                                $initial_formula .= '+';
                                $initial_counter++;
                            }
                        }
                        
                        //Add TC value
                        $initial_formula .= ')+';
                        $initial_formula .= $column_letter_repo['TC'].$rownumber;
                        
                    @endphp

                    {{$initial_formula}} <!-- Initial Complete Formula -->
                </td>


                <!-- QG -->
                <td style="text-align: center; border: 2px solid black; background-color:#fffcbe;" class="shaded fixed freeze_vertical text-center scrolling_table_1 quarter-bg quarter-cell">
                    @php
                        //$qg_formula = "=LOOKUP(".$column_letter_repo['initial'].$rownumber.","."'Quarter Grade'! A".$total_row_after.":"."B".$total_row_befor.")";
                        $qg_formula = "=LOOKUP(".$column_letter_repo['initial'].$rownumber.","."'Quarter Grade'! A2:"."B42)";
                    @endphp
                    {{$qg_formula}} <!-- QG Complete Formula -->
                </td>


                <!-- TC -->
                <td style="text-align: center; border: 2px solid black; background-color:#f4f5f8;" class="shaded fixed freeze_vertical text-center scrolling_table_1 no-padding tc-cell">
                    {{ $gradings->get_colum_via_gradingsheet_student('adjustment_grade', $grading->id, $student->student_id) }}
                </td>

                <!-- Rating -->
                <td style="text-align: center; border: 2px solid black; background-color:#f4f5f8;" class="shaded fixed freeze_vertical text-center scrolling_table_1 no-padding tc-cell">
                    {{ $gradings->get_colum_via_gradingsheet_student('rating', $grading->id, $student->student_id) }}
                </td>

                <!-- Ranking -->
                <td style="text-align: center; border: 2px solid black; background-color:#f4f5f8;" class="shaded fixed freeze_vertical text-center scrolling_table_1 no-padding tc-cell">
                    {{ $gradings->get_colum_via_gradingsheet_student('ranking', $grading->id, $student->student_id) }}
                </td>                
            </tr>

            @php $iteration++; $rownumber++; @endphp
        
        @endforeach
    </tbody>
</table>