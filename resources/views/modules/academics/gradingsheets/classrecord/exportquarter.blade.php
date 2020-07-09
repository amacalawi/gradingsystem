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
            <td> {{ $quartername }} </td>
        </tr>

        <tr>
            <td style="text-align: center; border: 1px solid black;"> # </td>
            <td style="text-align: center; border: 1px solid black;"> STUDENT </td>
            @foreach ($class_records->subjects as $subjects)
                <td style="text-align: center; border: 1px solid black;">{{ $subjects->subject->code }}</td>
            @endforeach
            @if ($class_records->has_mapeh > 0) 
                <td style="text-align: center; border: 1px solid black;">MAPEH</td>
            @endif
            @if ($class_records->has_tle > 0) 
                <td style="text-align: center; border: 1px solid black;">TLE</td>
            @endif
            <td style="text-align: center; border: 1px solid black;">Quarter Grade</td>
        </tr>

        @php $i = 0; $row = 7; $quarter_grade = []; @endphp

        @foreach ($class_records->students as $students)
            @php $i++; $quarterGrade = 0; $gradeCounter = 0; $col = 'C'; $count_qg = 0; @endphp
            <tr>
                <td style="text-align: center; border: 1px solid black;"> {{ $i }}</td>
                <td style="border: 1px solid black;"> {{ $students->student->firstname.' '. $students->student->lastname }}</td>
                @foreach ($class_records->subjects as $subjects)
                    @php
                        $gradeCounter++;
                        $subjectGrade = $classrecords->get_subject_quarter_grade($class_records->id, $class_records->batch_id, $quarterid, $class_records->section_id, $subjects->subject->id, $students->student->id, 0, 0);
                        if ($subjectGrade != '') {
                            $quarterGrade += floatval($subjectGrade);
                        }
                    @endphp
                    <td style="text-align: center; border: 1px solid black;"> {{ $classrecords->get_subject_quarter_grade($class_records->id, $class_records->batch_id, $quarterid, $class_records->section_id, $subjects->subject->id, $students->student->id, 0, 0) }}</td>
                    
                    @php
                        $quarter_grade[$count_qg] = $col.$row;
                        $col++; $count_qg++;
                    @endphp

                @endforeach

                @if ($class_records->has_mapeh > 0) 
                    @php
                        $gradeCounter++;
                        $mapehGrade = $classrecords->get_subject_quarter_grade($class_records->id, $class_records->batch_id, $quarterid, $class_records->section_id, 0, $students->student->id, 1, 0);
                        if ($mapehGrade != '') {
                            $quarterGrade += floatval($mapehGrade);
                        }
                    @endphp
                    <td style="text-align: center; border: 1px solid black;"> {{ $classrecords->get_subject_quarter_grade($class_records->id, $class_records->batch_id, $quarterid, $class_records->section_id, 0, $students->student->id, 1, 0) }} </td>
                    
                    @php
                        $quarter_grade[$count_qg] = $col.$row;
                        $col++; $count_qg++;
                    @endphp
                
                @endif

                @if ($class_records->has_tle > 0) 
                    @php
                        $gradeCounter++;
                        $tleGrade = $classrecords->get_subject_quarter_grade($class_records->id, $class_records->batch_id, $quarterid, $class_records->section_id, 0, $students->student->id, 0, 1);
                        if ($tleGrade != '') {
                            $quarterGrade += floatval($tleGrade);
                        }
                    @endphp
                    <td style="text-align: center; border: 1px solid black;"> {{ $classrecords->get_subject_quarter_grade($class_records->id, $class_records->batch_id, $quarterid, $class_records->section_id, 0, $students->student->id, 0, 1) }} </td>
                
                    @php
                        $quarter_grade[$count_qg] = $col.$row;
                        $col++; $count_qg++;
                    @endphp
                
                @endif

                <td style="text-align: center; border: 1px solid black;">
                    @php 
                        $add = 1;
                        $quartergrade_formula = '=SUM(';
                        for($x=0; $x<count($quarter_grade); $x++)
                        {
                            $quartergrade_formula .= $quarter_grade[$x];
                                
                            if( count($quarter_grade) > $add ){
                                $quartergrade_formula .= '+';
                            }
                            $add++;
                        }

                        $quartergrade_formula .= ')/'.count($quarter_grade);

                    @endphp
                        
                    {{ $quartergrade_formula }} <!-- Quartergrade formula -->
                </td>
            </tr>

            @php $row++; @endphp

        @endforeach

    </tbody>
</table>
  