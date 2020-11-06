@inject('classrecords', 'App\Http\Controllers\ClassRecordController')
<div class="row">
    <div class="col-md-12">
        <!-- BASIC INFOS START -->
        <div class="m-portlet m-portlet--tab">
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="m-bottom-1">Class Record Information</h4>
                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h5>
                            <strong>Section:</strong>
                            {{ $class_records->section_name }}
                        </h5>
                    </div>
                    <div class="col-md-6">
                        <h5>
                            <strong>Level:</strong> 
                            {{ $class_records->level_name }}
                        </h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h5>
                            <strong>Adviser:</strong>
                            {{ $class_records->adviser_name }}
                        </h5>
                    </div>
                    <div class="col-md-6">
                        <h5>
                            <strong>Batch:</strong> 
                            {{ $class_records->batch_name }}
                        </h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="m-wizard m-wizard--1 m-wizard--success" id="m_wizard">
                            <div class="m-wizard__head m-b-0">
                                <div class="m-wizard__progress">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="m-wizard__nav">
                                    <div class="m-wizard__steps">
                                        @if ($quarters->count() > 0)
                                            @php $iteration = 0; @endphp
                                            @foreach ($quarters as $quarter)
                                                @php $iteration++; @endphp
                                                @if ($iteration == 1)
                                                    <div class="m-wizard__step m-wizard__step--current" data-wizard-target="#m_wizard_form_step_{{ $iteration }}">
                                                        <div class="m-wizard__step-info">
                                                            <a href="#" class="m-wizard__step-number">
                                                                <span>
                                                                    <span>
                                                                        {{ $iteration }}
                                                                    </span>
                                                                </span>
                                                            </a>
                                                            <div class="m-wizard__step-line">
                                                                <span></span>
                                                            </div>
                                                            <div class="m-wizard__step-label">
                                                                {{ $quarter->name }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="m-wizard__step" data-wizard-target="#m_wizard_form_step_{{ $iteration }}">
                                                        <div class="m-wizard__step-info">
                                                            <a href="#" class="m-wizard__step-number">
                                                                <span>
                                                                    <span>
                                                                        {{ $iteration }}
                                                                    </span>
                                                                </span>
                                                            </a>
                                                            <div class="m-wizard__step-line">
                                                                <span></span>
                                                            </div>
                                                            <div class="m-wizard__step-label">
                                                                {{ $quarter->name }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                            <div class="m-wizard__step" data-wizard-target="#m_wizard_form_step_{{ $quarters->count() + 1 }}">
                                                <div class="m-wizard__step-info">
                                                    <a href="#" class="m-wizard__step-number">
                                                        <span>
                                                            <span>
                                                                {{ $quarters->count() + 1 }}
                                                            </span>
                                                        </span>
                                                    </a>
                                                    <div class="m-wizard__step-line">
                                                        <span></span>
                                                    </div>
                                                    <div class="m-wizard__step-label">
                                                        Final Grade
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="m-wizard__form">
                                    <div class="m-portlet__body p-l-1 p-r-1 p-b-0">
                                        @if ($quarters->count() > 0)
                                            @php $iteration = 0; $grades = array(); @endphp
                                            @foreach ($quarters as $quarter)
                                                @php $iteration++; @endphp
                                                    <div class="m-wizard__form-step {{ ($iteration == 1) ? 'm-wizard__form-step--current' : '' }}" id="m_wizard_form_step_{{ $iteration }}">
                                                        <div class="row">
                                                            <table class="class-record class-record-head table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th colspan="20" class="shaded text-center">{{ $quarter->name }}</th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                            <div>
                                                                <table class="class-record class-record-body table-bordered">
                                                                    <tbody>
                                                                        <tr>
                                                                            <th class="text-center">#</th>
                                                                            <th class="text-center">Student</th>
                                                                            @foreach ($class_records->subjects as $subjects)
                                                                                @if ($subjects->subject->material_id == 1) 
                                                                                <th class="header text-center" data-toggle="m-tooltip" data-placement="bottom" colspan="{{ ($subjects->subject->material_id == 1) ? 1 : 2 }}" title="{{ $subjects->subject->description }}">{{ ucwords($subjects->subject->name) }}</th>
                                                                                @endif
                                                                            @endforeach
                                                                            @if ($class_records->has_mapeh > 0) 
                                                                                <th class="header text-center" data-toggle="m-tooltip" data-placement="bottom" title="MAPEH">MAPEH</th>
                                                                            @endif
                                                                            @if ($class_records->has_tle > 0) 
                                                                                <th class="header text-center" data-toggle="m-tooltip" data-placement="bottom" colspan="2" title="ICT/LE">ICT(50%)<br/> LE(50%)</th>
                                                                                <th class="header text-center" data-toggle="m-tooltip" data-placement="bottom" title="ICT/LE">ICT/LE</th>
                                                                            @endif
                                                                            @foreach ($class_records->subjects as $subjects)
                                                                                @if ($subjects->subject->material_id != 1) 
                                                                                <th class="header text-center" data-toggle="m-tooltip" data-placement="bottom" colspan="{{ ($subjects->subject->material_id == 1) ? 1 : 2 }}" title="{{ $subjects->subject->description }}">{{ ucwords($subjects->subject->name) }}</th>
                                                                                @endif
                                                                            @endforeach
                                                                            <th class="header text-center">Quarter Grade</th>
                                                                            <th class="header text-center honors">Honors</th>
                                                                            <th class="header text-center merit">Merit</th>
                                                                            <th class="header text-center">Ranking</th>
                                                                        </tr>
                                                                        @php $i = 0; @endphp
                                                                        @foreach ($class_records->students as $students)
                                                                            @php $i++; $quarterGrade = 0; $gradeCounter = 0; @endphp
                                                                            <tr class="tr_shaded">
                                                                                <td class="text-center">{{ $i }}</td>
                                                                                <td class="text-center">{{ ucfirst($students->student->firstname).' '. ucfirst($students->student->lastname) }}</td>
                                                                                @foreach ($class_records->subjects as $subjects)
                                                                                    @if ($subjects->subject->material_id == 1) 
                                                                                        @php
                                                                                            $subjectGrade = $classrecords->get_subject_quarter_grade($class_records->id, $class_records->batch_id, $quarter->id, $class_records->section_id, $subjects->subject->id, $students->student->id, 0, 0);
                                                                                            if ($subjectGrade != '') {
                                                                                                $gradeCounter++;
                                                                                                $quarterGrade += floatval($subjectGrade);
                                                                                            }
                                                                                        @endphp
                                                                                        @php $grade = $classrecords->get_subject_quarter_grade($class_records->id, $class_records->batch_id, $quarter->id, $class_records->section_id, $subjects->subject->id, $students->student->id, 0, 0); @endphp
                                                                                        <td class="text-center">
                                                                                            @if ($grade != '') 
                                                                                                @php $gradeID = $classrecords->get_subject_quarter_grade_id($class_records->id, $class_records->batch_id, $quarter->id, $class_records->section_id, $subjects->subject->id, $students->student->id, 0, 0); @endphp
                                                                                                <a onclick="popupWindow({{ $gradeID }});" class="m--font-light" href="javascript:;">{{ $grade }}</a>
                                                                                            @endif
                                                                                        </td>
                                                                                    @endif
                                                                                @endforeach
                                                                                @if ($class_records->has_mapeh > 0) 
                                                                                    @php
                                                                                        $mapehGrade = $classrecords->get_subject_quarter_grade($class_records->id, $class_records->batch_id, $quarter->id, $class_records->section_id, 0, $students->student->id, 1, 0);
                                                                                        if ($mapehGrade != '') {
                                                                                            $gradeCounter++;
                                                                                            $quarterGrade += floatval($mapehGrade);
                                                                                        }
                                                                                    @endphp
                                                                                    <td class="text-center">
                                                                                        {{  $mapehGrade }}
                                                                                    </td>
                                                                                @endif
                                                                                @if ($class_records->has_tle > 0) 
                                                                                    @php
                                                                                        $tleGrade = $classrecords->get_subject_quarter_grade($class_records->id, $class_records->batch_id, $quarter->id, $class_records->section_id, 0, $students->student->id, 0, 1);
                                                                                        if ($tleGrade != '') {
                                                                                            $gradeCounter++;
                                                                                            $quarterGrade += floatval($tleGrade);
                                                                                        }
                                                                                    @endphp
                                                                                    <td class="text-center" style="padding-left: 0 !important; padding-right: 0 !important">
                                                                                        @php
                                                                                            $ictGrade = $classrecords->get_ict_le_quarter_grade($class_records->id, $class_records->batch_id, $quarter->id, $class_records->section_id, 0, $students->student->id, 'ICT');
                                                                                            $gradeID = $classrecords->get_ict_le_quarter_grade_id($class_records->id, $class_records->batch_id, $quarter->id, $class_records->section_id, 0, $students->student->id, 'ICT');
                                                                                        @endphp
                                                                                        @if ($ictGrade != '')
                                                                                            <a onclick="popupWindow({{ $gradeID }});" class="m--font-light" href="javascript:;">{{ $ictGrade }}</a>
                                                                                        @endif
                                                                                    </td>
                                                                                    <td class="text-center" style="padding-left: 0 !important; padding-right: 0 !important">
                                                                                        @php
                                                                                            $leGrade = $classrecords->get_ict_le_quarter_grade($class_records->id, $class_records->batch_id, $quarter->id, $class_records->section_id, 0, $students->student->id, 'LE');
                                                                                            $gradeID = $classrecords->get_ict_le_quarter_grade_id($class_records->id, $class_records->batch_id, $quarter->id, $class_records->section_id, 0, $students->student->id, 'LE');
                                                                                        @endphp
                                                                                        @if ($leGrade != '')
                                                                                            <a onclick="popupWindow({{ $gradeID }});" class="m--font-light" href="javascript:;">{{ $leGrade }}</a>
                                                                                        @endif
                                                                                    </td>
                                                                                    <td class="text-center">
                                                                                        {{ $tleGrade }}
                                                                                    </td>
                                                                                @endif
                                                                                @foreach ($class_records->subjects as $subjects)
                                                                                    @if ($subjects->subject->material_id != 1) 
                                                                                        @php
                                                                                            $subjectGrade = $classrecords->get_subject_quarter_grade($class_records->id, $class_records->batch_id, $quarter->id, $class_records->section_id, $subjects->subject->id, $students->student->id, 0, 0);
                                                                                            if ($subjectGrade != '') {
                                                                                                $gradeCounter++;
                                                                                                $quarterGrade += floatval($subjectGrade);
                                                                                            }
                                                                                        @endphp
                                                                                        @php $grade = $classrecords->get_subject_quarter_grade($class_records->id, $class_records->batch_id, $quarter->id, $class_records->section_id, $subjects->subject->id, $students->student->id, 0, 0); @endphp
                                                                                        <td class="text-center">
                                                                                            @if ($grade != '') 
                                                                                                @php $gradeID = $classrecords->get_subject_quarter_grade_id($class_records->id, $class_records->batch_id, $quarter->id, $class_records->section_id, $subjects->subject->id, $students->student->id, 0, 0); @endphp
                                                                                                <a onclick="popupWindow({{ $gradeID }});" class="m--font-light" href="javascript:;">{{ $grade }}</a>
                                                                                            @endif
                                                                                        </td>
                                                                                        <td class="text-center">
                                                                                            {{ $classrecords->get_subject_quarter_rating($class_records->id, $class_records->batch_id, $quarter->id, $class_records->section_id, $subjects->subject->id, $students->student->id, 0, 0) }}
                                                                                        </td>
                                                                                    @endif
                                                                                @endforeach
                                                                                <td class="total_{{ $iteration }} text-center">
                                                                                    @if ($quarterGrade > 0)
                                                                                        @php $grades[$students->student->id][] = floatval(floatval($quarterGrade) / floatval($gradeCounter)); @endphp
                                                                                        {{ number_format(floatval($quarterGrade) / floatval($gradeCounter), 0) }}
                                                                                    @else
                                                                                        @php $grades[$students->student->id][] = 0; @endphp
                                                                                    @endif
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <a href="javascript:;" title="add/edit honors"><i class="la la-edit"></i></a>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <a href="javascript:;" title="add/edit merit"><i class="la la-edit"></i></a>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    <tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                            @endforeach
                                            <div class="m-wizard__form-step" id="m_wizard_form_step_{{ $quarters->count() + 1 }}">
                                                <div class="row">
                                                    <div>
                                                        <table class="class-record class-record-head table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th colspan="20" class="shaded text-center">Final Grade</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                        <table class="class-record class-record-body table-bordered">
                                                            <tbody>
                                                                <tr>
                                                                    <th class="text-center">#</th>
                                                                    <th class="text-center">Student</th>
                                                                    @foreach ($quarters as $quarter)
                                                                        <th class="text-center">{{ $quarter->name }}</th>
                                                                    @endforeach
                                                                    <th class="text-center">Final Grade</th>
                                                                    <th class="text-center honors">Honors</th>
                                                                    <th class="text-center merit">Merit</th>
                                                                    <th class="text-center">Ranking</th>
                                                                </tr>
                                                                @foreach ($class_records->students as $students)
                                                                    <tr class="tr_shaded">
                                                                        <td class="text-center">{{ $i }}</td>
                                                                        <td class="text-center">{{ ucfirst($students->student->firstname).' '. ucfirst($students->student->lastname) }}</td>
                                                                        @php $finalgrades = 0; $fgcounter = 0; @endphp
                                                                        @foreach ($grades[$students->student->id] as $grade) 
                                                                            <td class="text-center">
                                                                                @php $finalgrades += floatval($grade); $fgcounter++; @endphp
                                                                                @if ($grade > 0)
                                                                                    {{ number_format($grade, 0) }}
                                                                                @endif
                                                                            </td>
                                                                        @endforeach
                                                                        <td class="total_{{ $quarters->count() + 1 }} text-center">
                                                                            @if ($finalgrades > 0) 
                                                                                {{ number_format(floatval($finalgrades) / floatval($fgcounter)) }}
                                                                            @endif
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <a href="javascript:;" title="add/edit honors"><i class="la la-edit"></i></a>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <a href="javascript:;" title="add/edit merit"><i class="la la-edit"></i></a>
                                                                        </td>
                                                                        <td class="text-center">
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 ">
                <a href="{{ url('academics/grading-sheets/class-record/export-record/'.$class_records->id) }}" >
                    <button type="button" class="btn btn-success pull-right">
                        Export class record
                    </button>
                </a>
            </div>
        </div>
    </div>
</div>