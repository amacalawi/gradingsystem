@inject('classrecords', 'App\Http\Controllers\ClassRecordController')

<table id="gradingsheet-table" class="table-bordered" style="1px solid black;">
    <tbody>
        <tr>
            <th style="font-size:15px;">
                <h4>Class Record Information</h4>
            </th>
        </tr>
        <tr>
            <td> Section: <b> {{ $class_records->section_name }} </b> </td>
        </tr>
        <tr>
            <td> Level: <b> {{ $class_records->level_name }} </b> </td>
        </tr>

        <tr>
            <td> </td>
        </tr>

        <tr>
            <td> {{ $finalgrade }} </td>
        </tr>

        <tr>
            <td style="text-align: center; border: 1px solid black;"> # </td>
            <td style="text-align: center; border: 1px solid black;"> STUDENT </td>
            @foreach ($quarters as $quarter)
                <td style="text-align: center; border: 1px solid black;">{{ $quarter->name }}</td>
            @endforeach
            <td style="text-align: center; border: 1px solid black;">FINAL GRADE</td>
        </tr>

        @php $i = 1; $row = 7; @endphp
        @foreach ($class_records->students as $students)
            <tr>
                <td style="text-align: center;  border: 1px solid black;"> {{ $i }} </td>
                <td style="border: 1px solid black;"> {{ $students->student->firstname.' '. $students->student->lastname }} </td>
                    @php $col = 'C'; @endphp
                    @foreach($class_records->subjects as $subjects)
                        <!-- col subjects -->
                        @php $col++; @endphp
                    @endforeach
        
                    @if ($class_records->has_mapeh > 0) 
                        <!-- col if has_mapeh -->
                        @php $col++; @endphp
                    @endif
        
                    @if ($class_records->has_tle > 0) 
                        <!-- col if has_tle -->
                        @php $col++; @endphp
                    @endif

                    @php $add = 1; $x_quarter_formula = '=SUM('; @endphp
                    @foreach ($quarters as $quarter)
                        @php
                            $x_quarter_val = "=SUM('".$quarter->name."'!".$col.$row.")";
                            $x_quarter_formula .= "'".$quarter->name."'!".$col.$row;

                            if( count($quarters) > $add )
                            {
                                $x_quarter_formula .= '+';
                                $add++;
                            } 
                        @endphp

                        <td style="text-align: center; border: 1px solid black;"> {{ $x_quarter_val }} </td>

                    @endforeach

                    @php $x_quarter_formula .= ')/'.count($quarters); @endphp
                    
                    <td style="text-align: center; border: 1px solid black;"> {{ $x_quarter_formula }} </td>
            </tr>
            @php $i++; $row++; @endphp
        @endforeach

    </tbody>
</table>
  