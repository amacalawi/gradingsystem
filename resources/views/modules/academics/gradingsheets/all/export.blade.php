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
@endphp

<table id="gradingsheet-table" class="table-bordered" style="1px solid black;">
    <tbody>
        <tr>
            <th style="font-size:15px;">
                <h4>Grading Sheet Information</h4>
            </th>
        </tr>
        <tr>
            <th class="shaded fixed freeze text-center scrolling_table_1 cities">
                Level and Section: <b> {{ $grading->level_name }} ({{ $grading->section_name }}) </b>
            </th>
        </tr>
        <tr>
            <th class="shaded fixed freeze text-center scrolling_table_1">
                Subject and Teacher: <b> {{ $grading->subject_name }} ({{ $grading->teacher }}) </b>
            </th>
        </tr>
        <tr>
            <th class="shaded fixed freeze text-center scrolling_table_1">
                Batch and Quarter: <b> {{ $grading->batch_name }} ({{ $grading->quarter_name }}) </b>
            </th>
        </tr>
        <tr>
            <th class="shaded fixed freeze text-center scrolling_table_1">
                Adviser: <b> {{ $grading->adviser }} </b>
            </th>
        </tr> 
        <tr>
            <td></td>
        </tr>                
        <tr>
            @php
                $column_letter_repo = array();
                $column_letter = 'A';
            @endphp

            <th style="background-color:#f4f5f8; width:5px; text-align: center;" class="shaded fixed freeze text-center scrolling_table_1">#</th> 
            <th style="background-color:#f4f5f8; width:30px;" class="shaded fixed freeze text-center scrolling_table_1">STUDENT</th>
            @foreach ($components as $component)
                @php $colored = get_clour($component->palette); @endphp
                <th style="padding:50px; text-align: center; background-color:{{$colored}};" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 component-header" colspan="{{ $component->columns }}">{{ $component->name }}</th>
            @endforeach
            <th style="text-align: center; background-color:#f4f5f8;" class="shaded fixed freeze_vertical text-center scrolling_table_1" title="initial grade">Initial</th>
            <th style="text-align: center; background-color:#fffcbe;" class="shaded fixed freeze_vertical text-center scrolling_table_1 quarter-bg" title="quarterly grade">QG</th>
            <th style="text-align: center; background-color:#f4f5f8;" class="shaded fixed freeze_vertical text-center scrolling_table_1" title="transmutation value">TC</th>
        </tr>
        <tr>
            <th style="text-align: center; background-color:#f4f5f8;" class="shaded fixed freeze text-center scrolling_table_1">1</th> @php $column_letter_repo['#'] = $column_letter++; @endphp
            <th style="text-align: center; background-color:#f4f5f8;" class="shaded fixed freeze text-center scrolling_table_1">&nbsp;</th> @php $column_letter_repo['student'] = $column_letter++; @endphp
            @php $component_percentage = 0; @endphp
            
            @foreach ($components as $component)
                @php $iteration = 1; @endphp
                @php $colored = get_clour($component->palette); @endphp
                @foreach ($component->activities as $activity)
                    <th style="text-align: center; text-align: center; background-color:{{$colored}};" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1" title="{{ $activity->activity }}">A{{ $iteration }}</th> @php $column_letter_repo['A'.$column_letter] =  $column_letter++; @endphp
                    @php $iteration++; @endphp
                @endforeach
                <th style="text-align: center; background-color:{{$colored}};" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1" title="total activities">SUM</th> @php $column_letter_repo['SUM'.$column_letter] =  $column_letter++; @endphp
                <th style="text-align: center; background-color:{{$colored}};" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1" title="highest possible score">HPS</th>@php $column_letter_repo['HPS'.$column_letter] =  $column_letter++; @endphp
                <th style="text-align: center; background-color:{{$colored}};" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1" title="percentage score">PS</th>@php $column_letter_repo['PS'.$column_letter] =  $column_letter++; @endphp
                <th style="text-align: center; background-color:{{$colored}};" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1" title="quarterly percentage">{{ $component->percentage }}%</th> @php $column_letter_repo['percent'.$column_letter] =  $column_letter++; @endphp
                @php $component_percentage += $component->percentage; @endphp

            @endforeach
            <th style="text-align: center; background-color:#f4f5f8;" class="shaded fixed freeze_vertical text-center scrolling_table_1" title="total quarterly percentage">{{ $component_percentage }}%</th>@php $column_letter_repo['initial'] =  $column_letter++; @endphp
            <th style="text-align: center; background-color:#fffcbe;" class="shaded fixed freeze_vertical text-center scrolling_table_1 quarter-bg">&nbsp;</th>@php $column_letter_repo['QG'] =  $column_letter++; @endphp
            <th style="text-align: center; background-color:#f4f5f8;" class="shaded fixed freeze_vertical text-center scrolling_table_1">&nbsp;</th>@php $column_letter_repo['TC'] =  $column_letter++; @endphp
        </tr>
        <tr class="tr_shaded">
            <td style="text-align: center; background-color:#f4f5f8;" class="shaded fixed freeze text-center scrolling_table_1">2</td>
            <td style="text-align: center; background-color:#f4f5f8;" class="shaded fixed freeze text-center scrolling_table_1">&nbsp;</td>
            @foreach ($components as $component)
                @php $iteration = 1; $sumValue = 0; @endphp
                @foreach ($component->activities as $activity)
                    @php $colored = get_clour($component->palette); @endphp
                    <th style="text-align: center; background-color:{{$colored}};" group="{{ $component->id }}" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 activity-cell-header">{{ $activity->value }}</th>
                    @php $iteration++; @endphp
                @endforeach
                    <th style="text-align: center; background-color:{{$colored}};" group="{{ $component->id }}" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 sum-header">{{ $component->sum_value }}</th>
                    <th style="text-align: center; background-color:{{$colored}};" group="{{ $component->id }}" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 hps-header">{{ $component->sum_value }}</th>
                    <th style="text-align: center; background-color:{{$colored}};" group="{{ $component->id }}" maxvalue="{{ $component->sum_value }}" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 ps-header">100%</th>
                    <td style="text-align: center; background-color:{{$colored}};" group="{{ $component->id }}" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 percentage-header">&nbsp;</td>
            @endforeach
            <td style="text-align: center; background-color:#f4f5f8;" class="shaded fixed freeze_vertical text-center scrolling_table_1">&nbsp;</td>
            <td style="text-align: center; background-color:#fffcbe;" class="shaded fixed freeze_vertical text-center scrolling_table_1 quarter-bg">&nbsp;</td>
            <td style="text-align: center; background-color:#f4f5f8;" class="shaded fixed freeze_vertical text-center scrolling_table_1">&nbsp;</td>
        </tr>
        
        @php 
            $iteration = 3; 
            $rownumber = 10; //start of student

            $total_row_after = $rownumber+count($students)+3; // 3 number of spaces row
            $total_row_befor = $total_row_after+40 // 40 number of qg_lookup
        @endphp
        
        @foreach ($students as $student)
            @php
                $columnletter_x = 'A'; 
                $columnletter_y = 'A';

                $hps_col_x = 'C';
                $percent_col_x = 'C';
                $percent_array = array();
            @endphp
            <tr class="">
                <td style="text-align: center;" class="fixed freeze text-center scrolling_table_1">
                    {{ $iteration }}
                    @php 
                        $totalpercentage = 0;
                        $columnletter_x++;
                        $columnletter_y++;
                    @endphp
                </td>
                <td class="fixed freeze text-left scrolling_table_1" title="{{ $student->identification_no }}">
                    {{ $student->fullname }}
                    @php 
                        $columnletter_x++;
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
                        <td style="text-align: center; background-color:{{$colored}};" group="{{ $component->id }}" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 no-padding">
                            {{$score}}
                        </td>
                    @endforeach


                    <!-- SUM -->
                    <td style="text-align: center; background-color:{{$colored}};" group="{{ $component->id }}" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 no-padding sum-cell">
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
                        $hps_row_default = 9; //Change only if table adjusted
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

                    <td style="text-align: center; background-color:{{$colored}};" group="{{ $component->id }}" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 no-padding hps-cell">
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
                    
                    <td style="text-align: center; background-color:{{$colored}};" group="{{ $component->id }}" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 no-padding ps-cell">
                        {{$ps_formula}} <!-- PS Complete Formula -->
                    </td>            
                    @php
                        $columnletter_x++;
                        $columnletter_y++;
                        $hps_col_x++;
                        $percent_col_x++; 
                    @endphp


                    <!-- Percent N% -->
                    <td style="text-align: center; background-color:{{$colored}};" group="{{ $component->id }}" maxvalue="{{ $component->percentage }}" class="{{ $component->palette }} fixed freeze_vertical text-center scrolling_table_1 percentage-cell">
                        
                        @php
                            $percent_col_x++; 
                            $percent_formula = '=ROUND('.$columnletter_y.$rownumber.'*'.$percent_col_x.'8'.',2)';
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
                <td style="text-align: center; background-color:#f4f5f8;" class="shaded fixed freeze_vertical text-center scrolling_table_1 initial-cell">
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
                <td style="text-align: center; background-color:#fffcbe;" class="shaded fixed freeze_vertical text-center scrolling_table_1 quarter-bg quarter-cell">
                    @php
                        $qg_formula = '=LOOKUP('.$column_letter_repo['initial'].$rownumber.','.'A'.$total_row_after.':'.'B'.$total_row_befor.')';
                    @endphp
                    {{$qg_formula}} <!-- QG Complete Formula -->
                </td>


                <!-- TC -->
                <td style="text-align: center; background-color:#f4f5f8;" class="shaded fixed freeze_vertical text-center scrolling_table_1 no-padding tc-cell">
                    {{ $gradings->get_colum_via_gradingsheet_student('adjustment_grade', $grading->id, $student->student_id) }}
                </td>
            </tr>

            @php $iteration++; $rownumber++; @endphp
        
        @endforeach
        
        <!-- Spaces before QG lookup //for formality -->
        <?php for( $spaces=1; $spaces<3; $spaces++ ){ ?>
            <tr>
                <td></td>
            </tr>  
        <?php } ?>

        <tr>
            <td colspan="2"> Quarter Grade lookup </td>
        </tr>
        <?php
            $row = 41;
            $double = 0.00;
            $equal_value = 60;
            for( $qg_count=1; $qg_count<=$row ; $qg_count++ ){
        ?>
        <tr>
            <td> <?php echo number_format($double,2) ?> </td>
            <td> <?php echo $equal_value; ?> </td>
        </tr>
        <?php
                if($qg_count < 16){
                    $double = $double + 4.00;
                } else {
                    $double = $double + 1.60;
                }
                $equal_value++;
            } //die();
        ?>
        
    </tbody>
</table>