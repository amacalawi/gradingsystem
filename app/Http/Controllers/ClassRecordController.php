<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\SectionInfo;
use App\Models\Staff;
use App\Models\Batch;
use App\Models\Admission;
use App\Models\Quarter;
use App\Models\Subject;
use App\Models\SectionsSubjects;
use App\Models\GradingSheet;
use App\Models\GradingSheetQuarter;
use App\Models\EducationType;
use Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\File;
use App\Components\FlashMessages;

use App\Exports\ClassRecordExport;
use Maatwebsite\Excel\Facades\Excel;

class ClassRecordController extends Controller
{   
    use FlashMessages;
    private $models;

    public function __construct()
    {   
        date_default_timezone_set('Asia/Manila');
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $menus = $this->load_menus();
        return view('modules/schools/classrecords/manage')->with(compact('menus'));
    }

    public function manage(Request $request)
    {   
        $menus = $this->load_menus();
        $types = (new EducationType)->manage_education_types();
        return view('modules/academics/gradingsheets/classrecord/manage')->with(compact('menus', 'types'));
    }

    public function inactive(Request $request)
    {   
        $menus = $this->load_menus();
        $types = (new EducationType)->manage_education_types();
        return view('modules/academics/gradingsheets/classrecord/inactive')->with(compact('menus', 'types'));
    }

    public function validated($id)
    {   
        if (Auth::user()->type != 'administrator') {
            $rows = SectionInfo::
            where([
                'adviser_id' => (new Staff)->get_column_via_user('id', Auth::user()->id),
                'batch_id' => (new Batch)->get_current_batch(),
                'is_active' => 1
            ])
            ->where('id', $id)
            ->where('is_active', 1)->count();
            if (!($rows > 0)) {
                return abort(404);
            }
        }
    }

    public function all_active(Request $request)
    {   
        if (Auth::user()->type != 'administrator') {
            $res = SectionInfo::with([
                'section' =>  function($q) { 
                    $q->select(['id', 'code', 'name', 'description']); 
                },
                'level' =>  function($q) { 
                    $q->select(['id', 'code', 'name', 'description']); 
                },
                'edtype' =>  function($q) { 
                    $q->select(['id', 'name']); 
                }
            ])
            ->where([
                'adviser_id' => (new Staff)->get_column_via_user('id', Auth::user()->id),
                'batch_id' => (new Batch)->get_current_batch(),
                'is_active' => 1
            ])
            ->orderBy('id', 'DESC')
            ->get();
        } else {
            $res = SectionInfo::with([
                'section' =>  function($q) { 
                    $q->select(['id', 'code', 'name', 'description']); 
                },
                'level' =>  function($q) { 
                    $q->select(['id', 'code', 'name', 'description']); 
                },
                'edtype' =>  function($q) { 
                    $q->select(['id', 'name']); 
                }
            ])
            ->where([
                'batch_id' => (new Batch)->get_current_batch(),
                'is_active' => 1
            ])
            ->orderBy('id', 'DESC')
            ->get();
        }

        return $res->map(function($classrecord) {
            return [
                'classrecordID' => $classrecord->id,
                'classrecordCode' => $classrecord->classcode,
                'classrecordSection' => $classrecord->section->name,
                'classrecordLevel' => $classrecord->level->name,
                'classrecordSubjects' => (new SectionsSubjects)->where(['section_info_id' => $classrecord->id, 'is_active' => 1])->count(),
                'classrecordStudents' => (new Admission)->where(['section_id' => $classrecord->section->id, 'status' => 'admit', 'is_active' => 1])->count(),
                'classrecordTypeID' => $classrecord->edtype->id,
                'classrecordType' => $classrecord->edtype->name,
                'classrecordModified' => ($classrecord->updated_at !== NULL) ? date('d-M-Y', strtotime($classrecord->updated_at)).'<br/>'. date('h:i A', strtotime($classrecord->updated_at)) : date('d-M-Y', strtotime($classrecord->created_at)).'<br/>'. date('h:i A', strtotime($classrecord->created_at))
            ];
        });
    }

    public function all_inactive(Request $request)
    {   
        if (Auth::user()->type != 'administrator') {
            $res = SectionInfo::with([
                'section' =>  function($q) { 
                    $q->select(['id', 'code', 'name', 'description']); 
                },
                'level' =>  function($q) { 
                    $q->select(['id', 'code', 'name', 'description']); 
                },
                'edtype' =>  function($q) { 
                    $q->select(['id', 'name']); 
                }
            ])
            ->where([
                'adviser_id' => (new Staff)->get_column_via_user('id', Auth::user()->id),
                'is_active' => 1
            ])
            ->where('batch_id', '!=', (new Batch)->get_current_batch())
            ->orderBy('id', 'DESC')
            ->get();
        } else {
            $res = SectionInfo::with([
                'section' =>  function($q) { 
                    $q->select(['id', 'code', 'name', 'description']); 
                },
                'level' =>  function($q) { 
                    $q->select(['id', 'code', 'name', 'description']); 
                },
                'edtype' =>  function($q) { 
                    $q->select(['id', 'name']); 
                }
            ])
            ->where([
                'is_active' => 1
            ])
            ->where('batch_id', '!=', (new Batch)->get_current_batch())
            ->orderBy('id', 'DESC')
            ->get();
        }

        return $res->map(function($classrecord) {
            return [
                'classrecordID' => $classrecord->id,
                'classrecordCode' => $classrecord->classcode,
                'classrecordSection' => $classrecord->section->name,
                'classrecordLevel' => $classrecord->level->name,
                'classrecordSubjects' => (new SectionsSubjects)->where(['section_info_id' => $classrecord->id, 'is_active' => 1])->count(),
                'classrecordStudents' => (new Admission)->where(['section_id' => $classrecord->section->id, 'status' => 'admit', 'is_active' => 1])->count(),
                'classrecordTypeID' => $classrecord->edtype->id,
                'classrecordType' => $classrecord->edtype->name,
                'classrecordModified' => ($classrecord->updated_at !== NULL) ? date('d-M-Y', strtotime($classrecord->updated_at)).'<br/>'. date('h:i A', strtotime($classrecord->updated_at)) : date('d-M-Y', strtotime($classrecord->created_at)).'<br/>'. date('h:i A', strtotime($classrecord->created_at))
            ];
        });
    }

    public function view(Request $request, $id)
    {   
        $this->validated($id);
        $menus = $this->load_menus();
        $class_records = (new SectionInfo)->fetch($id);
        $quarters = (new Quarter)->all_quarters_via_type((new SectionInfo)->fetch($id)->education_type_id);
        return view('modules/academics/gradingsheets/classrecord/view')->with(compact('menus', 'class_records', 'quarters'));
    }

    public function get_subject_quarter_grade($id, $batch, $quarter, $section, $subject, $student, $is_mapeh = 0, $is_tle = 0)
    {   
        if ($is_mapeh > 0) {
            $gradingsheetID = (new GradingSheet)
            ->select('id')
            ->where([
                'batch_id' => $batch,
                'quarter_id' => $quarter,
                'section_id' => $section,
                'is_active' => 1
            ])
            ->whereIn('subject_id', 
                (new SectionsSubjects)
                ->select('subject_id')
                ->where([
                    'section_info_id' => $id,
                    'is_active' => 1
                ])
                ->whereIn('subject_id',
                    (new Subject)->select('id')->where([
                        'is_mapeh' => 1, 
                        'is_active' => 1
                    ])
                    ->get()
                )
                ->get()
            )
            ->get();

            $quarterGrade = GradingSheetQuarter::where([
                'batch_id' => $batch,
                'quarter_id' => $quarter,
                'student_id' => $student,
                'is_active' => 1
            ])
            ->whereIn('id', $gradingsheetID)
            ->get();

            if ($quarterGrade->count() > 0) {
                $grades = 0;
                foreach ($quarterGrade as $qgrade)
                {
                    $grades += floatval($qgrade->quarter_grade);
                }

                return floatval(floatval($grades) / floatval($quarterGrade));
            } else {
                return '';
            }
        } else if($is_tle > 0) {
            $gradingsheetID = (new GradingSheet)
            ->select('id')
            ->where([
                'batch_id' => $batch,
                'quarter_id' => $quarter,
                'section_id' => $section,
                'is_active' => 1
            ])
            ->whereIn('subject_id', 
                (new SectionsSubjects)
                ->select('subject_id')
                ->where([
                    'section_info_id' => $id,
                    'is_active' => 1
                ])
                ->whereIn('subject_id',
                    (new Subject)->select('id')->where([
                        'is_tle' => 1, 
                        'is_active' => 1
                    ])
                    ->get()
                )
                ->get()
            )
            ->get();

            $quarterGrade = GradingSheetQuarter::where([
                'batch_id' => $batch,
                'quarter_id' => $quarter,
                'student_id' => $student,
                'is_active' => 1
            ])
            ->whereIn('id', $gradingsheetID)
            ->get();

            if ($quarterGrade->count() > 0) {
                $grades = 0;
                foreach ($quarterGrade as $qgrade)
                {
                    $grades += floatval($qgrade->quarter_grade);
                }

                return floatval(floatval($grades) / floatval($quarterGrade));
            } else {
                return '';
            }
        } else {
            $gradingsheetID = (new GradingSheet)->where([
                'batch_id' => $batch,
                'quarter_id' => $quarter,
                'section_id' => $section,
                'subject_id' => $subject,
                'is_active' => 1
            ])->pluck('id')->first();

            $quarterGrade = GradingSheetQuarter::where([
                'batch_id' => $batch,
                'quarter_id' => $quarter,
                'student_id' => $student,
                'gradingsheet_id' => $gradingsheetID,
                'is_active' => 1
            ])->get();

            if ($quarterGrade->count() > 0) {
                return $quarterGrade->first()->quarter_grade;
            } else {
                return '';
            }
        }
    }

    public function export_record(Request $request, $id)
    {
        $quarters = (new Quarter)->all_quarters_via_type((new SectionInfo)->fetch($id)->type);
        return Excel::download(new ClassRecordExport($id), 'ClassRecord_'.$id.'.xlsx');
    }

}
