@inject('reportcards', 'App\Http\Controllers\ReportCardController')
<div class="row">
    <div class="col-md-12">
        <!-- BASIC INFOS START -->
        <div id="section-to-print" class="m-portlet m-portlet--tab">
            <div class="m-portlet__body">
                @foreach($students as $student)
                <div class="row">
                    <div class="col-md-6">
                        <h5 class=""><strong>Report Card</strong></h5>
                        <h5 class="m-bottom-1"><strong>{{ $student->student->learners_reference_no }}</strong></h5>
                    </div>
                    <div class="col-md-6">
                        <h5 class="text-right">Curriculum: Basic Education</h6>
                        <h5 class="m-bottom-1 text-right">Junior Highschool</h6>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="report-card-table" class="table-bordered">
                        <thead>
                            <tr>
                                <td colspan="3"><strong>Student Name</strong></td>
                                <td colspan="13">{{ ucwords($student->student->firstname) }} {{ ($student->student->middlename !== '') ? ucwords($student->student->middlename[0]).'.' : '' }} {{ ucwords($student->student->lastname) }}</td>
                                <td><strong>SEX</strong></td>
                                <td colspan="2">{{ $student->student->gender }}</td>
                                <td colspan="2"><strong>Student No</strong></td>
                                <td colspan="3">{{ $student->student->identification_no }}</td>
                            </tr>
                            <tr>
                                <td colspan="3"><strong>Level &amp; Section</strong></td>
                                <td colspan="16">{{ $student->section_info->level }} - {{ $student->section_info->section }}</td>
                                <td colspan="2"><strong>Schoolyear</strong></td>
                                <td colspan="3">{{ $student->batch->description }}</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td rowspan="2" colspan="16" class="text-center"><strong>Subjects</strong></td>
                                <td colspan="{{ (count($quarters) + 1) }}" class="text-center"><strong>Quarterly Ratings</strong></td>
                                <td rowspan="2" class="text-center"><strong>Units</strong></td>
                                <td rowspan="2" colspan="2" class="text-center"><strong>Remarks</strong></td>
                            </tr>
                            <tr>   
                                @foreach($quarters as $quarter)
                                    <td class="text-center"><strong>{{ $quarter->code }}</strong></td>
                                @endforeach
                                <td class="text-center"><strong>Final</strong></td>
                            </tr>
                            @php $is_mapeh = 0; $is_tle = 0; @endphp
                            @foreach($student->subjects as $subject)
                                @if($subject->material == 1) 
                                    @if($subject->is_mapeh == 0 && $subject->is_tle == 0)
                                        <tr>    
                                            @php $finalGrade = 0; @endphp
                                            <td colspan="16">{{ $subject->subject_name }}</td>
                                            @foreach($quarters as $quarter)
                                                @php 
                                                    $quarterGrade = $reportcards->get_column_grade('quarter_grade', $type, $batch, $quarter->id, $student->section_info_id, $subject->subject_id, $student->student->id, $subject->material); 
                                                    if ($quarterGrade !== '') {
                                                        $finalGrade += floatval($quarterGrade);
                                                    }
                                                @endphp
                                                @if($quarterGrade !== '')
                                                    <td class="text-center">{{ $quarterGrade }}</td>
                                                @else
                                                    <td class="text-center"></td>
                                                @endif
                                            @endforeach
                                            <td class="text-center">
                                                @php $finalGrade = ($finalGrade / count($quarters)); @endphp
                                                {{ ($finalGrade > 0) ? number_format(floor($finalGrade*100)/100,2) : '' }}
                                            </td>
                                            <td class="text-center">1.0</td>
                                            <td colspan="2" class="text-center">
                                                {{ 
                                                    ($finalGrade > 0) ? ($finalGrade >= 75) ? 'Passed' : 'Failed' : ''
                                                }}
                                            </td>
                                        </tr>
                                    @else
                                        @if($subject->is_mapeh == 1 && $subject->is_tle == 0)
                                            @php $is_mapeh++; @endphp
                                        @else
                                            @php $is_tle++; @endphp
                                        @endif
                                    @endif
                                @endif
                            @endforeach
                            @if($is_mapeh > 0)
                                <tr>
                                    <td colspan="16">MAPEH</td>
                                    @foreach($quarters as $quarter)
                                        <td class="text-center"></td>
                                    @endforeach
                                    <td class="text-center"></td>
                                    <td class="text-center">1.0</td>
                                    <td colspan="2" class="text-center"></td>
                                </tr>
                            @endif
                            @if($is_tle > 0)
                                <tr>
                                    <td colspan="16">ICT/LE</td>
                                    @foreach($quarters as $quarter)
                                        <td class="text-center"></td>
                                    @endforeach
                                    <td class="text-center"></td>
                                    <td class="text-center">1.0</td>
                                    <td colspan="2" class="text-center"></td>
                                </tr>
                            @endif
                            @foreach($student->subjects as $subject)
                                @if($subject->material > 1) 
                                    <tr>    
                                        @php $finalGrade = 0; @endphp
                                        <td colspan="16">{{ $subject->subject_name }}</td>
                                        @foreach($quarters as $quarter)
                                            @php 
                                                $quarterGrade = $reportcards->get_column_grade('quarter_grade', $type, $batch, $quarter->id, $student->section_info_id, $subject->subject_id, $student->student->id, $subject->material); 
                                                if ($quarterGrade !== '') {
                                                    $finalGrade += floatval($quarterGrade);
                                                }
                                            @endphp
                                            @if($quarterGrade !== '')
                                                <td class="text-center">{{ $quarterGrade }}</td>
                                            @else
                                                <td class="text-center"></td>
                                            @endif
                                        @endforeach
                                        <td class="text-center">
                                            @php $finalGrade = ($finalGrade / count($quarters)); @endphp
                                            {{ ($finalGrade > 0) ? number_format(floor($finalGrade*100)/100,2) : '' }}
                                        </td>
                                        <td class="text-center"></td>
                                        <td colspan="2" class="text-center">
                                            {{ 
                                                ($finalGrade > 0) ? ($finalGrade >= 75) ? 'Passed' : 'Failed' : ''
                                            }}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="17">GRADING SYSTEM AVERAGING</td>
                                <td colspan="3">GENERAL AVERAGE</td>
                                <td colspan="1" class="text-center">92.44</td>
                                <td colspan="1" class="text-center">8.0</td>
                                <td colspan="1"></td>
                            </tr>
                            <tr>
                                <td colspan="5"></td>
                                <td class="text-center">JUN</td>
                                <td class="text-center">JUL</td>
                                <td class="text-center">AUG</td>
                                <td class="text-center">SEP</td>
                                <td class="text-center">OCT</td>
                                <td class="text-center">NOV</td>
                                <td class="text-center">DEC</td>
                                <td class="text-center">JAN</td>
                                <td class="text-center">FEB</td>
                                <td class="text-center">MAR</td>
                                <td class="text-center">APR</td>
                                <td class="text-center">TOTAL</td>
                                <td colspan="4" class="text-left p-b-0 border-0">Eligible for transfer & admission to</td>
                                <td colspan="3" class="border-0 border-bottom"></td>
                            </tr>
                            <tr>
                                <td colspan="5">Days of School</td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td colspan="3" class="text-left p-b-0 border-0">Has advanced credits in</td>
                                <td colspan="3" class="border-0 border-bottom"></td>
                            </tr>
                            <tr>
                                <td colspan="5">Days Present</td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td colspan="2" class="text-left p-b-0 border-0">Lack credits in</td>
                                <td colspan="4" class="border-0 border-bottom"></td>
                            </tr>
                            <tr>
                                <td colspan="5">Times Tardy</td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td colspan="1" class="text-left p-b-0 border-0">Date</td>
                                <td colspan="5" class="border-0 border-bottom"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <p class="text-center m-t-30 m-b-0"><em>{{ ucwords($student->section_info->adviser_firstname).' '.ucwords($student->section_info->adviser_lastname) }}</em></p>
                        <p class="text-center border-top"><strong>CLASS ADVISER</strong></p>
                    </div>
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-3">
                        <p class="text-center m-t-30 m-b-0">&nbsp;</p>
                        <p class="text-center border-top"><strong>PRINCIPAL</strong></p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <!-- BASIC INFOS END -->
    </div>
</div>

<button id="preview-btn" data-toggle="m-tooltip" data-placement="top" title="print preview" class="btn btn-float"><i class="la la-print"></i></button>