@inject('transcriptrecords', 'App\Http\Controllers\TranscriptRecordController')
<div class="row">
    <div class="col-md-12">
        <!-- BASIC INFOS START -->
        <div id="section-to-print" class="m-portlet m-portlet--tab">
            <div class="m-portlet__body">
                @foreach($students as $student)
                <div class="row">
                    <div class="col-md-12">
                        <h5 class=""><strong>Transcript Records</strong></h5>
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

                <div class="">
                    <table id="" class="w-100 border-1">
                        <tbody>
                            <tr>
                                <td width="100"><h6><b>Pangalan</b></h6></td>
                                <td width="200"><h6>{{$student->student->lastname}}</h6></td>
                                <td width="200"><h6>{{$student->student->firstname}}</h6></td>
                                <td width="200"><h6>{{$student->student->middlename}}</h6></td>
                                <td width="100" class="pl-3"><h6><b>Sangay</b></h6></td>
                                <td width="200"><h6></h6></td>
                                <td width="100" class="pl-3"><h6><b>Paaralan</b></h6></td>
                                <td class=""><h6>{{--$student->student->--}}</h6></td>
                            </tr>
                            <tr style="font-size:12px;">
                                <td>(Name)</td>
                                <td class="border-top">Apelyido</td>
                                <td class="border-top">Unang pangalan</td>
                                <td class="border-top">M.I.</td>
                                <td width="100" class="pl-3">(Division)</td>
                                <td class="border-top"></td>
                                <td width="100" class="pl-3">(School)</td>
                                <td class="border-top"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    <table id="" class="w-100 border-1">
                        <tbody>
                            <tr class="pt-25">
                                <td width="100"><h6><b>Kasarian</b></h6></td>
                                <td width="200"><h6>{{$student->student->gender}}</h6></td>
                                <td width="200" class="pl-3"><h6><b>Petsa ng kapanganakan</b></h6></td>
                                <td width="200"><h6>{{$student->student->birthdate}}</h6></td>
                                <td width="250" class="pl-3"><h6><b>Pook</b></h6></td>
                                <td><h6></h6></td>
                                <td width="150" class="pl-3"><h6><b>Petsa ng Pagpasok</b></h6></td>
                                <td><h6>{{$student->student->admitted_date}}</h6></td>
                            </tr>
                            <tr style="font-size:12px;">
                                <td width="100">(Sex)</td>
                                <td class="border-top"></td>
                                <td class="pl-3">(Date of birth)</td>
                                <td class="border-top"></td>
                                <td width="250" class="pl-3">Bayan/Lalawigan/Lunsod (Town)</td>
                                <td width="250" class="border-top"></td>
                                <td class="pl-3">(Date of Entrance)</td>
                                <td class="border-top"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    <table id="" class="w-100 border-1">
                        <tbody>
                            <tr>
                                <td width="200"><h6><b>Magulang/Tagapag-alaga</b></h6></td>
                                <td colspan=""></td>
                                <td colspan=""></td>
                                <td colspan=""></td>
                            </tr>
                            <tr style="font-size:12px;">
                                <td width="100">(Parent/Guardian)</td>
                                <td width="200" class="border-top pl-3">Pangalan (Name)</td>
                                <td width="550" class="border-top pl-3">Tirahan (Address)</td>
                                <td width="150" class="border-top pl-3">Hanapbuhay (Occupation)</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="row">
                    <div class="col-md-12 pt-5">
                        <h5 class="text-center">PAG-UNLAD SA MABABANG PAARALAN</h5>
                        <h6 class="text-center">(Elementary School Progress)</h6>
                    </div>
                </div>

                <div class="row">

                    @foreach($levels_section_infos as $levels_section_info)
                        @php
                            $quarterDetails = $transcriptrecords->get_quarter_per_batch($levels_section_info->batch_id);
                        @endphp
                        <div class="col-md-6 pt-5">
                            <div class="table-responsive">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td style="width:300px;" colspan="16" class="text-right"><strong>Elegible for Admission to Grade: </strong></td>
                                            <td style="width:500px;" class="pl-5" colspan="{{ (count($quarterDetails)+2) }}"></td>
                                        </tr>
                                        <tr>
                                            <td style="width:300px;" colspan="16" class="text-right"><strong>Grade School: </strong></td>
                                            <td style="width:500px;" class="border-top pl-5" colspan="{{ (count($quarterDetails)+2) }}">{{$levels_section_info->level_name}}</td>
                                        </tr>
                                        <tr>
                                            <td style="width:300px;" colspan="16" class="text-right"><strong>School Year: </strong></td>
                                            <td style="width:500px;" class="border-top pl-5" colspan="{{ (count($quarterDetails)+2) }}">{{$levels_section_info->batch_name}}</td>
                                        </tr>
                                    <tbody>
                                </table>

                                <table id="report-card-table" class="table-bordered">
                                    <tbody>
                                        <tr>
                                            <td colspan="16" class="text-left"><strong>Elegible for Admission to Grade</strong></td>
                                            <td colspan="{{ (count($quarterDetails)+2) }}"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="16" class="text-left"><strong>Grade  </strong></td>
                                            <td colspan="{{ (count($quarterDetails)+2) }}">{{$levels_section_info->level_name}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="16" class="text-left"><strong>School Year </strong></td>
                                            <td colspan="{{ (count($quarterDetails)+2) }}">{{$levels_section_info->batch_name}}</td>
                                        </tr>

                                        <tr>
                                            <td rowspan="2" colspan="16" class="text-center"><strong>LEARNING AREAS</strong></td>
                                            <td colspan="{{ (count($quarterDetails)) }}" class="text-center"><strong>Quarterly Ratings</strong></td>
                                            <td rowspan="2" colspan="2" class="text-center"><strong>Remarks</strong></td>
                                        </tr>
                                        <tr>
                                            @foreach($quarterDetails as $quarterDetail)
                                                <td class="text-center"><strong>{{ $quarterDetail->name }}</strong></td>
                                            @endforeach
                                        </tr>
                                        @php $is_mapeh = 0; $is_tle = 0; $unit = 0; @endphp
                                        @foreach($student->subjects as $subject)
                                            @if($subject->material == 1) 
                                                @if($subject->is_mapeh == 0 && $subject->is_tle == 0)
                                                    <tr>    
                                                        @php $finalGrade = 0; $unit++; $subjectCounter = 0; @endphp
                                                        <td colspan="16">{{ $subject->subject_name }}</td>
                                                        @foreach($quarterDetails as $quarterDetail)
                                                            @php 
                                                                $quarterGrade = $transcriptrecords->get_column_grade('quarter_grade', $type, $levels_section_info->batch_id, $quarterDetail->id, $levels_section_info->section_info_id, $subject->subject_id, $student->student->id, $subject->material, 0, 0); 
                                                                if ($quarterGrade !== '') {
                                                                    $finalGrade += floatval($quarterGrade);
                                                                    $subjectCounter++;
                                                                }
                                                            @endphp
                                                            <td class="text-center">{{ ($quarterGrade !== '') ? $quarterGrade : '' }}</td>
                                                        @endforeach
                                                        <td class="text-center" > </td>
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
                                                @foreach($quarterDetails as $quarterDetail)
                                                    @php 
                                                        $quarterGrade = $transcriptrecords->get_column_grade('quarter_grade', $type, $levels_section_info->batch_id, $quarterDetail->id, $student->section_info_id, $subject->subject_id, $student->student->id, $subject->material, 1, 0); 
                                                        if ($quarterGrade !== '') {
                                                            $finalGrade += floatval($quarterGrade);
                                                            $subjectCounter++;
                                                        }
                                                    @endphp
                                                    <td class="text-center">{{ ($quarterGrade !== '') ? $quarterGrade : '' }}</td>
                                                @endforeach
                                                <td class="text-center" > </td>
                                            </tr>
                                        @endif
                                        @if($is_tle > 0)
                                            <tr>
                                                @php $finalGrade = 0; $unit++; $subjectCounter = 0; @endphp
                                                <td colspan="16">ICT/LE</td>
                                                @foreach($quarterDetails as $quarterDetail)
                                                    @php 
                                                        $quarterGrade = $transcriptrecords->get_column_grade('quarter_grade', $type, $levels_section_info->batch_id, $quarterDetail->id, $student->section_info_id, $subject->subject_id, $student->student->id, $subject->material, 0, 1); 
                                                        if ($quarterGrade !== '') {
                                                            $finalGrade += floatval($quarterGrade);
                                                            $subjectCounter++;
                                                        }
                                                    @endphp
                                                    <td class="text-center">{{ ($quarterGrade !== '') ? $quarterGrade : '' }}</td>
                                                @endforeach
                                                <td class="text-center" > </td>
                                            </tr>
                                        @endif
                                        @foreach($student->subjects as $subject)
                                            @if($subject->material > 1) 
                                                <tr>    
                                                    @php $finalGrade = 0; $subjectCounter = 0; @endphp
                                                    <td colspan="16">{{ $subject->subject_name }}</td>
                                                    @foreach($quarterDetails as $quarterDetails)
                                                        <td class="text-center"></td>
                                                    @endforeach
                                                    <td class="text-center" > </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="16">GENERAL AVERAGE</td>
                                            @foreach($quarterDetails as $quarterDetail)
                                                <td class="text-center">{{--general average--}}</td>
                                            @endforeach
                                            <td class="text-center" > </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    @endforeach                    
                </div>

                <div class="w-100 m-5">
                    <div class="row">
                        <div class="col-md-12 pt-5">
                            <h5 class="text-center">CERTIFICATE OF TRANSFER</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 pt-5">
                            <h5 class="text-left">To WHOM IT MAY CONCERN</h5>
                            <p class="text-center">
                                This is to certify that this is a true record of the Elementary School Permanent Record of <span style="border-bottom: 1px solid #000; width:300px;">&nbsp;</span>. He/She is eligible for transfer and admission of
                                Grade Year <span style="border-bottom: 1px solid #000; width:300px;">&nbsp;</span>
                            </p>
                        </div>
                    </div>
                    <div class="row col-md-12">
                        <div class="col-md-4"> </div>
                        <div class="col-md-4"> </div>
                        <div class="col-md-4">
                            <p class="text-center m-t-30 m-b-0"><em></em></p>
                            <p class="text-center border-top"><strong>Signature</strong></p>
                        </div>
                    </div>
                    <div class="row col-md-12">
                        <div class="col-md-4">
                            <p class="text-center m-t-30 m-b-0"><em></em></p>
                            <p class="text-center border-top"><strong>Date</strong></p>
                        </div>
                        <div class="col-md-4"> </div>
                        <div class="col-md-4">
                            <p class="text-center m-t-30 m-b-0"><em></em></p>
                            <p class="text-center border-top"><strong>Designation</strong></p>
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