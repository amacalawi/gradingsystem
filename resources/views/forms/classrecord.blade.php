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
                                                @if ($iteration == 1) 
                                                    <div class="m-wizard__form-step m-wizard__form-step--current" id="m_wizard_form_step_{{ $iteration }}">
                                                        <div class="row">
                                                            <table class="class-record class-record-head table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th colspan="20" class="shaded text-center">{{ $quarter->name }}</th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                            <div id="scrolling_table_1" class=" scrolly_table">
                                                                <table class="class-record table-bordered">
                                                                    <tbody>
                                                                        <tr>
                                                                            
                                                                            <th class="shaded fixed freeze text-center scrolling_table_1">#</th>
                                                                            <th class="shaded fixed freeze text-center scrolling_table_1">Student</th>
                                                                            @foreach ($class_records->subjects as $subjects)
                                                                                <th class="shaded fixed freeze_vertical text-center scrolling_table_1" data-toggle="m-tooltip" data-placement="bottom" title="{{ $subjects->subject->name }}">{{ $subjects->subject->code }}</th>
                                                                            @endforeach
                                                                            @if ($class_records->has_mapeh > 0) 
                                                                                <th class="shaded fixed freeze_vertical text-center scrolling_table_1" data-toggle="m-tooltip" data-placement="bottom" title="MAPEH">MAPEH</th>
                                                                            @endif
                                                                            @if ($class_records->has_tle > 0) 
                                                                                <th class="shaded fixed freeze_vertical text-center scrolling_table_1" data-toggle="m-tooltip" data-placement="bottom" title="TLE">TLE</th>
                                                                            @endif
                                                                            <th class="shaded fixed freeze_vertical text-center scrolling_table_1">Quarter Grade</th>
                                                                            <th class="shaded fixed freeze_vertical text-center scrolling_table_1">Ranking</th>
                                                                        </tr>
                                                                        @php $i = 0; @endphp
                                                                        @foreach ($class_records->students as $students)
                                                                            @php $i++; $quarterGrade = 0; $gradeCounter = 0; @endphp
                                                                            <tr class="tr_shaded">
                                                                                <td class="shaded fixed freeze text-center scrolling_table_1">{{ $i }}</td>
                                                                                <td class="shaded fixed freeze text-center scrolling_table_1">{{ ucfirst($students->student->firstname).' '. ucfirst($students->student->lastname) }}</td>
                                                                                @foreach ($class_records->subjects as $subjects)
                                                                                    @php
                                                                                        $gradeCounter++;
                                                                                        $subjectGrade = $classrecords->get_subject_quarter_grade($class_records->id, $class_records->batch_id, $quarter->id, $class_records->section_id, $subjects->subject->id, $students->student->id, 0, 0);
                                                                                        if ($subjectGrade != '') {
                                                                                            $quarterGrade += floatval($subjectGrade);
                                                                                        }
                                                                                    @endphp
                                                                                    <td class="shaded fixed freeze_vertical text-center scrolling_table_1">
                                                                                        {{ $classrecords->get_subject_quarter_grade($class_records->id, $class_records->batch_id, $quarter->id, $class_records->section_id, $subjects->subject->id, $students->student->id, 0, 0) }}
                                                                                    </td>
                                                                                @endforeach
                                                                                @if ($class_records->has_mapeh > 0) 
                                                                                    @php
                                                                                        $gradeCounter++;
                                                                                        $mapehGrade = $classrecords->get_subject_quarter_grade($class_records->id, $class_records->batch_id, $quarter->id, $class_records->section_id, 0, $students->student->id, 1, 0);
                                                                                        if ($mapehGrade != '') {
                                                                                            $quarterGrade += floatval($mapehGrade);
                                                                                        }
                                                                                    @endphp
                                                                                    <td class="shaded fixed freeze_vertical text-center scrolling_table_1">
                                                                                        {{ $classrecords->get_subject_quarter_grade($class_records->id, $class_records->batch_id, $quarter->id, $class_records->section_id, 0, $students->student->id, 1, 0) }}
                                                                                    </td>
                                                                                @endif
                                                                                @if ($class_records->has_tle > 0) 
                                                                                    @php
                                                                                        $gradeCounter++;
                                                                                        $tleGrade = $classrecords->get_subject_quarter_grade($class_records->id, $class_records->batch_id, $quarter->id, $class_records->section_id, 0, $students->student->id, 0, 1);
                                                                                        if ($tleGrade != '') {
                                                                                            $quarterGrade += floatval($tleGrade);
                                                                                        }
                                                                                    @endphp
                                                                                    <td class="shaded fixed freeze_vertical text-center scrolling_table_1">
                                                                                        {{ $classrecords->get_subject_quarter_grade($class_records->id, $class_records->batch_id, $quarter->id, $class_records->section_id, 0, $students->student->id, 0, 1) }}
                                                                                    </td>
                                                                                @endif
                                                                                <td class="total_{{ $iteration }} shaded fixed freeze_vertical text-center scrolling_table_1">
                                                                                    @if ($quarterGrade > 0)
                                                                                        @php $grades[$students->student->id][] = floatval(floatval($quarterGrade) / floatval($gradeCounter)); @endphp
                                                                                        {{ number_format(floatval($quarterGrade) / floatval($gradeCounter), 0) }}
                                                                                    @else
                                                                                        @php $grades[$students->student->id][] = 0; @endphp
                                                                                    @endif
                                                                                </td>
                                                                                <td class="shaded fixed freeze_vertical text-center scrolling_table_1">
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    <tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="m-wizard__form-step" id="m_wizard_form_step_{{ $iteration }}">
                                                        <div class="row">
                                                            <div id="scrolling_table_1" class=" scrolly_table">
                                                                <table class="class-record class-record-head table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th colspan="20" class="shaded text-center">{{ $quarter->name }}</th>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                                <table class="class-record table-bordered">
                                                                    <tbody>
                                                                        <tr>
                                                                            <th class="shaded fixed freeze text-center scrolling_table_1">#</th>
                                                                            <th class="shaded fixed freeze text-center scrolling_table_1">Student</th>
                                                                            @foreach ($class_records->subjects as $subjects)
                                                                                <th class="shaded fixed freeze_vertical text-center scrolling_table_1" data-toggle="m-tooltip" data-placement="bottom" title="{{ $subjects->subject->name }}">{{ $subjects->subject->code }}</th>
                                                                            @endforeach
                                                                            @if ($class_records->has_mapeh > 0) 
                                                                                <th class="shaded fixed freeze_vertical text-center scrolling_table_1" data-toggle="m-tooltip" data-placement="bottom" title="MAPEH">MAPEH</th>
                                                                            @endif
                                                                            @if ($class_records->has_tle > 0) 
                                                                                <th class="shaded fixed freeze_vertical text-center scrolling_table_1" data-toggle="m-tooltip" data-placement="bottom" title="TLE">TLE</th>
                                                                            @endif
                                                                            <th class="shaded fixed freeze_vertical text-center scrolling_table_1">Quarter Grade</th>
                                                                            <th class="shaded fixed freeze_vertical text-center scrolling_table_1">Ranking</th>
                                                                        </tr>
                                                                        @php $i = 0; @endphp
                                                                        @foreach ($class_records->students as $students)
                                                                            @php $i++; $quarterGrade = 0; $gradeCounter = 0; @endphp
                                                                            <tr class="tr_shaded">
                                                                                <td class="shaded fixed freeze text-center scrolling_table_1">{{ $i }}</td>
                                                                                <td class="shaded fixed freeze text-center scrolling_table_1">{{ ucfirst($students->student->firstname).' '. ucfirst($students->student->lastname) }}</td>
                                                                                @foreach ($class_records->subjects as $subjects)
                                                                                    @php
                                                                                        $gradeCounter++;
                                                                                        $subjectGrade = $classrecords->get_subject_quarter_grade($class_records->id, $class_records->batch_id, $quarter->id, $class_records->section_id, $subjects->subject->id, $students->student->id, 0, 0);
                                                                                        if ($subjectGrade != '') {
                                                                                            $quarterGrade += floatval($subjectGrade);
                                                                                        }
                                                                                    @endphp
                                                                                    <td class="shaded fixed freeze_vertical text-center scrolling_table_1">
                                                                                        {{ $classrecords->get_subject_quarter_grade($class_records->id, $class_records->batch_id, $quarter->id, $class_records->section_id, $subjects->subject->id, $students->student->id, 0, 0) }}
                                                                                    </td>
                                                                                @endforeach
                                                                                @if ($class_records->has_mapeh > 0) 
                                                                                    @php
                                                                                        $gradeCounter++;
                                                                                        $mapehGrade = $classrecords->get_subject_quarter_grade($class_records->id, $class_records->batch_id, $quarter->id, $class_records->section_id, 0, $students->student->id, 1, 0);
                                                                                        if ($mapehGrade != '') {
                                                                                            $quarterGrade += floatval($mapehGrade);
                                                                                        }
                                                                                    @endphp
                                                                                    <td class="shaded fixed freeze_vertical text-center scrolling_table_1">
                                                                                        {{ $classrecords->get_subject_quarter_grade($class_records->id, $class_records->batch_id, $quarter->id, $class_records->section_id, 0, $students->student->id, 1, 0) }}
                                                                                    </td>
                                                                                @endif
                                                                                @if ($class_records->has_tle > 0) 
                                                                                    @php    
                                                                                        $gradeCounter++;
                                                                                        $tleGrade = $classrecords->get_subject_quarter_grade($class_records->id, $class_records->batch_id, $quarter->id, $class_records->section_id, 0, $students->student->id, 0, 1);
                                                                                        if ($tleGrade != '') {
                                                                                            $quarterGrade += floatval($tleGrade);
                                                                                        }
                                                                                    @endphp
                                                                                    <td class="shaded fixed freeze_vertical text-center scrolling_table_1">
                                                                                        {{ $classrecords->get_subject_quarter_grade($class_records->id, $class_records->batch_id, $quarter->id, $class_records->section_id, 0, $students->student->id, 0, 1) }}
                                                                                    </td>
                                                                                @endif
                                                                                <td class="total_{{ $iteration }} shaded fixed freeze_vertical text-center scrolling_table_1">
                                                                                    @if ($quarterGrade > 0)
                                                                                        @php $grades[$students->student->id][] = floatval(floatval($quarterGrade) / floatval($gradeCounter)); @endphp
                                                                                        {{ number_format(floatval($quarterGrade) / floatval($gradeCounter), 0) }}
                                                                                    @else
                                                                                        @php $grades[$students->student->id][] = 0; @endphp
                                                                                    @endif
                                                                                </td>
                                                                                <td class="shaded fixed freeze_vertical text-center scrolling_table_1">
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    <tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                            <div class="m-wizard__form-step" id="m_wizard_form_step_{{ $quarters->count() + 1 }}">
                                                <div class="row">
                                                    <div id="scrolling_table_1" class=" scrolly_table">
                                                        <table class="class-record class-record-head table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th colspan="20" class="shaded text-center">Final Grade</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                        <table class="class-record table-bordered">
                                                            <tbody>
                                                                <tr>
                                                                    <th class="shaded fixed freeze text-center scrolling_table_1">#</th>
                                                                    <th class="shaded fixed freeze text-center scrolling_table_1">Student</th>
                                                                    @foreach ($quarters as $quarter)
                                                                        <th class="shaded fixed freeze_vertical text-center scrolling_table_1">{{ $quarter->name }}</th>
                                                                    @endforeach
                                                                    <th class="shaded fixed freeze_vertical text-center scrolling_table_1">Final Grade</th>
                                                                    <th class="shaded fixed freeze_vertical text-center scrolling_table_1">Ranking</th>
                                                                </tr>
                                                                @foreach ($class_records->students as $students)
                                                                    <tr class="tr_shaded">
                                                                        <td class="shaded fixed freeze text-center scrolling_table_1">{{ $i }}</td>
                                                                        <td class="shaded fixed freeze text-center scrolling_table_1">{{ ucfirst($students->student->firstname).' '. ucfirst($students->student->lastname) }}</td>
                                                                        @php $finalgrades = 0; $fgcounter = 0; @endphp
                                                                        @foreach ($grades[$students->student->id] as $grade) 
                                                                            <td class="shaded fixed freeze_vertical text-center scrolling_table_1">
                                                                                @php $finalgrades += floatval($grade); $fgcounter++; @endphp
                                                                                @if ($grade > 0)
                                                                                    {{ number_format($grade, 0) }}
                                                                                @endif
                                                                            </td>
                                                                        @endforeach
                                                                        <td class="total_{{ $quarters->count() + 1 }} shaded fixed freeze_vertical text-center scrolling_table_1">
                                                                            @if ($finalgrades > 0) 
                                                                                {{ number_format(floatval($finalgrades) / floatval($fgcounter)) }}
                                                                            @endif
                                                                        </td>
                                                                        <td class="shaded fixed freeze_vertical text-center scrolling_table_1">
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