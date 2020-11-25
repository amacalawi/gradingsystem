@inject('form137s', 'App\Http\Controllers\Form137Controller')
<div class="row">
    <div class="col-md-12">
        <!-- BASIC INFOS START -->
        <div id="section-to-print" class="m-portlet m-portlet--tab">
            <div class="m-portlet__body">
                @foreach($students as $student)
                <div class="row">
                    <div class="col-md-12">
                        <h5 class=""><strong>Form 137-E</strong></h5>
                    </div>
                    <div class="col-md-12">
                        <h5 class="text-center">Republica ng Pilipinas</h5>
                        <h6 class="text-center"><span style="font-size:12px;">(Republic of the Philippines)</span></h6>
                        <h5 class="text-center">Kagawaran ng Education</h5>
                        <h6 class="text-center"><span style="font-size:12px;">(Department of Education)</span></h6>
                        <h5 class="text-center">Kawanihan ng Edukasyon Elementarya</h5>
                        <h6 class="text-center"><span style="font-size:12px;">(Bureau of Elementarya)</span></h6>
                        <h6 class="text-center"><span style="font-size:12px;">Rehiyon:________ (Region)</span></h6>
                    </div>
                    <div class="col-md-12 pt-5">
                        <h4 class="text-center">PALAGIAANG TALAAN SA MABABANG PAARALAN</h4>
                        <h6 class="text-center">(Elementary School Permanent Record)</h6>
                    </div>
                    <div class="col-md-12 pt-3">
                        <h6 class="text-right">LRN:____________</h6>
                    </div>
                </div>

                <div class="table-responsive pt-3">
                    <table id="form-137-table" class="w-100 border-1">
                        <thead>
                            <tr>
                                <td class=""><h6><b>Pangalan</b></h6></td>
                                <td class=""><h6>{{$student->student->lastname}}</h6></td>
                                <td class=""><h6>{{$student->student->firstname}}</h6></td>
                                <td class=""><h6>{{$student->student->middlename}}</h6></td>
                                <td class=""><h6><b>Sangay</b></h6></td>
                                <td class=""><h6>{{--$student->student->--}}</h6></td>
                                <td class=""><h6><b>Paaralan</b></h6></td>
                                <td class=""><h6>{{--$student->student->--}}</h6></td>
                            </tr>
                            <tr style="font-size:12px;">
                                <td>(Name)</td>
                                <td class="border-top">Apelyido</td>
                                <td class="border-top">Unang pangalan</td>
                                <td class="border-top">M.I.</td>
                                <td colspan="2">(Division)</td>
                                <td colspan="2">(School)</td>
                            </tr>

                            <tr class="pt-25">
                                <td><h6><b>Kasarian</b></h6></td>
                                <td><h6>{{$student->student->gender}}</h6></td>
                                <td><h6><b>Petsa ng kapanganakan</b></h6></td>
                                <td><h6>{{$student->student->birthdate}}</h6></td>
                                <td><h6><b>Pook</b></h6></td>
                                <td><h6></h6></td>
                                <td><h6><b>Petsa ng Pagpasok</b></h6></td>
                                <td><h6>{{$student->student->admitted_date}}</h6></td>
                            </tr>
                            <tr style="font-size:12px;">
                                <td colspan="2">(Sex)</td>
                                <td colspan="2">(Date of birth)</td>
                                <td colspan="2">Bayan/Lalawigan/Lunsod (Town)</td>
                                <td colspan="2">(Date of Entrance)</td>
                            </tr>

                            <tr>
                                <td><h6><b>Magulang/Tagapag-alaga</b></h6></td>
                                <td colspan="7"></td>
                            </tr>
                            <tr style="font-size:12px;">
                                <td>(Parent/Guardian)</td>
                                <td></td>
                                <td colspan="2">Pangalan (Name)</td>
                                <td colspan="2">Tirahan (Address)</td>
                                <td colspan="2">Hanapbuhay (Occupation)</td>
                            </tr>
                        </thead>
                    </table>
                </div>

                <div class="row">
                    <div class="col-md-12 pt-5">
                        <h5 class="text-center">PAG-UNLAD SA MABABANG PAARALAN</h5>
                        <h6 class="text-center">(Elementary School Progress)</h6>
                    </div>
                </div>

                <div class="row">

                    @foreach($levels as $level)
                        <div class="col-md-6 pt-5">
                            <div class="table-responsive">
                                <table id="report-card-table" class="table-bordered">
                                    <tbody>
                                        <tr>
                                            <td colspan="16" class="text-left"><strong>Elegible for Admission to Grade</strong></td>
                                            <td colspan="5"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="16" class="text-left"><strong>Grade  </strong></td>
                                            <td colspan="5">{{$level->name}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="16" class="text-left"><strong>School Year </strong></td>
                                            <td colspan="5"></td>
                                        </tr>

                                        <tr>
                                            <td rowspan="2" colspan="16" class="text-center"><strong>LEARNING AREAS</strong></td>
                                            <td colspan="{{ (count($quarters)) }}" class="text-center"><strong>Quarterly Ratings</strong></td>
                                            <td rowspan="2" colspan="2" class="text-center"><strong>Remarks</strong></td>
                                        </tr>
                                        <tr>   
                                            @foreach($quarters as $quarter)
                                                <td class="text-center"><strong>{{ $quarter->code }}</strong></td>
                                            @endforeach
                                        </tr>
                                        @php $is_mapeh = 0; $is_tle = 0; $unit = 0; @endphp
                                        @foreach($student->subjects as $subject)
                                            @if($subject->material == 1) 
                                                @if($subject->is_mapeh == 0 && $subject->is_tle == 0)
                                                    <tr>    
                                                        @php $finalGrade = 0; $unit++; $subjectCounter = 0; @endphp
                                                        <td colspan="16">{{ $subject->subject_name }}</td>
                                                        @foreach($quarters as $quarter)
                                                            @php 
                                                                $quarterGrade = $form137s->get_column_grade('quarter_grade', $type, $student->batch->id, $quarter->id, $student->section_info_id, $subject->subject_id, $student->student->id, $subject->material, 0, 0); 
                                                                if ($quarterGrade !== '') {
                                                                    $finalGrade += floatval($quarterGrade);
                                                                    $subjectCounter++;
                                                                }
                                                            @endphp
                                                            <td class="text-center">{{ ($quarterGrade !== '') ? $quarterGrade : '' }}</td>
                                                        @endforeach
                                                        <td class="text-center"> </td>
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
                                                @php $finalGrade = 0; $unit++; $subjectCounter = 0; @endphp
                                                <td colspan="16">MAPEH</td>
                                                @foreach($quarters as $quarter)
                                                    @php 
                                                        $quarterGrade = $form137s->get_column_grade('quarter_grade', $type, $student->batch->id, $quarter->id, $student->section_info_id, $subject->subject_id, $student->student->id, $subject->material, 1, 0); 
                                                        if ($quarterGrade !== '') {
                                                            $finalGrade += floatval($quarterGrade);
                                                            $subjectCounter++;
                                                        }
                                                    @endphp
                                                    <td class="text-center">{{ ($quarterGrade !== '') ? $quarterGrade : '' }}</td>
                                                @endforeach
                                                <td colspan="1"></td>
                                            </tr>
                                        @endif
                                        @if($is_tle > 0)
                                            <tr>
                                                @php $finalGrade = 0; $unit++; $subjectCounter = 0; @endphp
                                                <td colspan="16">ICT/LE</td>
                                                @foreach($quarters as $quarter)
                                                    @php 
                                                        $quarterGrade = $form137s->get_column_grade('quarter_grade', $type, $student->batch->id, $quarter->id, $student->section_info_id, $subject->subject_id, $student->student->id, $subject->material, 0, 1); 
                                                        if ($quarterGrade !== '') {
                                                            $finalGrade += floatval($quarterGrade);
                                                            $subjectCounter++;
                                                        }
                                                    @endphp
                                                    <td class="text-center">{{ ($quarterGrade !== '') ? $quarterGrade : '' }}</td>
                                                @endforeach
                                                <td colspan="1"></td>
                                            </tr>
                                        @endif
                                        @foreach($student->subjects as $subject)
                                            @if($subject->material > 1) 
                                                <tr>    
                                                    @php $finalGrade = 0; $subjectCounter = 0; @endphp
                                                    <td colspan="16">{{ $subject->subject_name }}</td>
                                                    @foreach($quarters as $quarter)
                                                        <td class="text-center"></td>
                                                    @endforeach
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="16">GENERAL AVERAGE</td>
                                            @foreach($quarters as $quarter)
                                                <td class="text-center">{{--general average--}}</td>
                                            @endforeach
                                            <td colspan="1"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                    @endforeach                    
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-3">
                            <p class="text-center m-t-30 m-b-0"><em>{{ ucwords($student->section_info->adviser_firstname).' '.ucwords($student->section_info->adviser_lastname) }}</em></p>
                            <p class="text-center border-top"><strong>CLASS ADVISER</strong></p>
                        </div>
                        <div class="col-md-6">
                            &nbsp;
                        </div>
                        <div class="col-md-3">
                            <p class="text-center m-t-30 m-b-0">&nbsp;</p>
                            <p class="text-center border-top"><strong>PRINCIPAL</strong></p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <!-- BASIC INFOS END -->
    </div>
</div>

<button id="preview-btn" data-toggle="m-tooltip" data-placement="top" title="print preview" class="btn btn-float"><i class="la la-print"></i></button>