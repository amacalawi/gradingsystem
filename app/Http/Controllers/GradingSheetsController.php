<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Exports\GradingSheetExport;
use App\Imports\GradingSheetImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Models\GradingSheet;
use App\Models\Quarter;
use App\Models\QuarterEducationType;
use App\Models\Subject;
use App\Models\Section;
use App\Models\Batch;
use App\Models\Component;
use App\Models\Admission;
use App\Models\Activity;
use App\Models\GradingSheetActivity;
use App\Models\GradingSheetHomeroom;
use App\Models\GradingSheetQuarter;
use App\Models\SectionInfo;
use App\Models\SectionsSubjects;
use App\Models\Staff;
use App\Models\TransmutationElement;
use App\Models\Transmutation;
use App\Models\EducationType;
use App\Models\AuditLog;
use Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\File;
use App\Components\FlashMessages;
use App\Helper\Helper;

class GradingSheetsController extends Controller
{   
    use FlashMessages;
    private $models;

    public function __construct()
    {   
        date_default_timezone_set('Asia/Manila');
        $this->middleware('auth');
    }
    
    public function is_permitted($permission)
    {
        $privileges = explode(',', strtolower(Helper::get_privileges()));
        if (!$privileges[$permission] == 1) {
            return abort(404);
        }
    }

    public function index()
    {   
        $this->is_permitted(1);
        $menus = $this->load_menus();
        return view('modules/academics/gradingsheets/all/manage')->with(compact('menus'));
    }

    public function manage(Request $request)
    {   
        $this->is_permitted(1);
        $menus = $this->load_menus();
        return view('modules/academics/gradingsheets/all/manage')->with(compact('menus'));
    }

    public function inactive(Request $request)
    {   
        $this->is_permitted(1);
        $menus = $this->load_menus();
        return view('modules/academics/gradingsheets/all/inactive')->with(compact('menus'));
    }

    public function validated($user, $id)
    {
        if ($id != '') {
            if (Auth::user()->type != 'administrator') {
                $rows = GradingSheet::
                whereIn('subject_id', 
                    SectionsSubjects::select('subject_id')
                    ->where([
                        'teacher_id' => (new Staff)->get_column_via_user('id', Auth::user()->id),
                        'batch_id' => (new Batch)->get_current_batch(),
                        'is_active' => 1
                    ])
                )
                ->where('id', $id)
                ->where('is_active', 1)->count();
                if (!($rows > 0)) {
                    return abort(404);
                }
            }
        }

        return true;
    }

    public function all_active(Request $request)
    {   
        if (Auth::user()->type == 'administrator') 
        {  
            $res = GradingSheet::
            with([
                'section_info' =>  function($q) { 
                    $q->select(['sections_info.id', 'sections_info.adviser_id', 'levels.name as level' , 'sections.name as section'])
                    ->join('levels', function($join)
                    {
                        $join->on('levels.id', '=', 'sections_info.level_id');
                    })
                    ->join('sections', function($join)
                    {
                        $join->on('sections.id', '=', 'sections_info.section_id');
                    });
                },
                'subject' =>  function($q) { 
                    $q->select(['id', 'name']); 
                },
                'quarter' =>  function($q) { 
                    $q->select(['id', 'name']); 
                }
            ])
            ->where([
                'batch_id' => (new Batch)->get_current_batch(),
                'is_active' => 1
            ])
            ->orderBy('id', 'ASC')->get();

            return $res->map(function($grading) {
                return [
                    'gradingID' => $grading->id,
                    'gradingCode' => $grading->code,
                    'gradingSection' => $grading->section_info->level.' - '.$grading->section_info->section,
                    'gradingSubject' => $grading->subject->name,
                    'gradingQuarter' => $grading->quarter->name,
                    'gradingStatusID' => $grading->is_locked,
                    'gradingStatus' => ($grading->is_locked > 0) ? 'Locked' : 'Open',
                    'gradingAdviser' => 1,
                    'gradingModified' => ($grading->updated_at !== NULL) ? date('d-M-Y', strtotime($grading->updated_at)).'<br/>'. date('h:i A', strtotime($grading->updated_at)) : date('d-M-Y', strtotime($grading->created_at)).'<br/>'. date('h:i A', strtotime($grading->created_at))
                ];
            });
        }
        else
        {   
            $teacher = (new Staff)->get_column_via_user('id', Auth::user()->id);
            $res1 = GradingSheet::select('id')
            ->whereIn('subject_id', 
                SectionsSubjects::select('subject_id')
                ->whereIn('section_info_id', 
                    SectionInfo::select('id')->where([
                        'batch_id' => (new Batch)->get_current_batch(), 
                        'is_active' => 1
                    ])
                )
                ->where([
                    'teacher_id' => $teacher,
                    'batch_id' => (new Batch)->get_current_batch(),
                    'is_active' => 1
                ])
            )
            ->where([
                'batch_id' => (new Batch)->get_current_batch(),
                'is_active' => 1
            ])
            ->orderBy('id', 'ASC')->get();

            $res2 = GradingSheet::select('id')
            ->whereIn('section_info_id', 
                SectionInfo::select('id')->where([
                    'adviser_id' => $teacher,
                    'batch_id' => (new Batch)->get_current_batch(), 
                    'is_active' => 1
                ])
            )
            ->where([
                'batch_id' => (new Batch)->get_current_batch(),
                'is_active' => 1
            ])
            ->orderBy('id', 'ASC')->get();

            $arr = array();
            foreach ($res1 as $res) {
                if (!in_array($res->id, $arr)) {
                    $arr[] = $res->id;
                }
            }
            foreach ($res2 as $res) {
                if (!in_array($res->id, $arr)) {
                    $arr[] = $res->id;
                }
            }

            $res = GradingSheet::
            with([
                'section_info' =>  function($q) { 
                    $q->select(['sections_info.id', 'sections_info.adviser_id', 'levels.name as level' , 'sections.name as section'])
                    ->join('levels', function($join)
                    {
                        $join->on('levels.id', '=', 'sections_info.level_id');
                    })
                    ->join('sections', function($join)
                    {
                        $join->on('sections.id', '=', 'sections_info.section_id');
                    });
                },
                'subject' =>  function($q) { 
                    $q->select(['id', 'name']); 
                },
                'quarter' =>  function($q) { 
                    $q->select(['id', 'name']); 
                }
            ])
            ->whereIn('id', $arr)
            ->where([
                'batch_id' => (new Batch)->get_current_batch(),
                'is_active' => 1
            ])
            ->orderBy('id', 'ASC')->get();

            return $res->map(function($grading) use ($teacher) {
                return [
                    'gradingID' => $grading->id,
                    'gradingCode' => $grading->code,
                    'gradingSection' => $grading->section_info->level.' - '.$grading->section_info->section,
                    'gradingSubject' => $grading->subject->name,
                    'gradingQuarter' => $grading->quarter->name,
                    'gradingStatusID' => $grading->is_locked,
                    'gradingStatus' => ($grading->is_locked > 0) ? 'Locked' : 'Open',
                    'gradingAdviser' => ($grading->section_info->adviser_id == $teacher) ? 1 : 0,
                    'gradingModified' => ($grading->updated_at !== NULL) ? date('d-M-Y', strtotime($grading->updated_at)).'<br/>'. date('h:i A', strtotime($grading->updated_at)) : date('d-M-Y', strtotime($grading->created_at)).'<br/>'. date('h:i A', strtotime($grading->created_at))
                ];
            });
        }
    }

    public function all_inactive(Request $request)
    {   
        if (Auth::user()->type == 'administrator') 
        { 
            $res = GradingSheet::with([
                'section' =>  function($q) { 
                    $q->select(['id', 'name']); 
                },
                'subject' =>  function($q) { 
                    $q->select(['id', 'name']); 
                },
                'quarter' =>  function($q) { 
                    $q->select(['id', 'name']); 
                }
            ])
            ->where([
                'batch_id' => (new Batch)->get_current_batch(),
                'is_active' => 0
            ])
            ->orderBy('id', 'ASC')->get();

            return $res->map(function($grading) {
                return [
                    'gradingID' => $grading->id,
                    'gradingCode' => $grading->code,
                    'gradingSection' => $grading->section->name,
                    'gradingSubject' => $grading->subject->name,
                    'gradingQuarter' => $grading->quarter->name,
                    'gradingModified' => ($grading->updated_at !== NULL) ? date('d-M-Y', strtotime($grading->updated_at)).'<br/>'. date('h:i A', strtotime($grading->updated_at)) : date('d-M-Y', strtotime($grading->created_at)).'<br/>'. date('h:i A', strtotime($grading->created_at))
                ];
            });
        }
        else
        {
            $res = GradingSheet::
            whereIn('subject_id', 
                SectionsSubjects::select('subject_id')
                ->whereIn('section_info_id', 
                    SectionInfo::select('id')->where([
                        'batch_id' => (new Batch)->get_current_batch(), 
                        'is_active' => 1
                    ])
                )
                ->where([
                    'teacher_id' => (new Staff)->get_column_via_user('id', Auth::user()->id),
                    'batch_id' => (new Batch)->get_current_batch(),
                    'is_active' => 1
                ])
            )
            ->with([
                'section' =>  function($q) { 
                    $q->select(['id', 'name']); 
                },
                'subject' =>  function($q) { 
                    $q->select(['id', 'name']); 
                },
                'quarter' =>  function($q) { 
                    $q->select(['id', 'name']); 
                }
            ])
            ->where([
                'batch_id' => (new Batch)->get_current_batch(),
                'is_active' => 0
            ])
            ->orderBy('id', 'ASC')->get();

            return $res->map(function($grading) {
                return [
                    'gradingID' => $grading->id,
                    'gradingCode' => $grading->code,
                    'gradingSection' => $grading->section->name,
                    'gradingSubject' => $grading->subject->name,
                    'gradingQuarter' => $grading->quarter->name,
                    'gradingModified' => ($grading->updated_at !== NULL) ? date('d-M-Y', strtotime($grading->updated_at)).'<br/>'. date('h:i A', strtotime($grading->updated_at)) : date('d-M-Y', strtotime($grading->created_at)).'<br/>'. date('h:i A', strtotime($grading->created_at))
                ];
            });
        }
    }

    public function add(Request $request, $id = '')
    {   
        $this->is_permitted(0);
        $menus = $this->load_menus();
        $segment = request()->segment(4);
        $grading = (new GradingSheet)->fetch($id);
        $quarters = (new Quarter)->all_quarters_selectpicker();
        $sections = (new SectionInfo)->all_classes();
        $subjects = (new Subject)->all_subjects();
        $types = (new EducationType)->all_education_types();
        return view('modules/academics/gradingsheets/all/add')->with(compact('menus', 'grading', 'quarters', 'sections', 'subjects', 'types', 'segment'));
    }
    
    public function edit(Request $request, $id)
    {   
        $this->is_permitted(2);
        $this->validated(Auth::user()->id, $id);
        $menus = $this->load_menus();
        $segment = request()->segment(4);
        $grading = (new GradingSheet)->fetch($id);
        $quarters = (new Quarter)->all_quarters();
        $sections = (new Section)->all_sections();
        $subjects = (new Subject)->all_subjects();
        $components = (new Component)->get_components_via_gradingsheet($id);
        $male_students = (new Admission)->get_students_via_gradingsheet($id, 'Male');
        $female_students = (new Admission)->get_students_via_gradingsheet($id, 'Female');
        return view('modules/academics/gradingsheets/all/edit')->with(compact('menus', 'grading', 'quarters', 'sections', 'subjects', 'components', 'male_students', 'female_students', 'segment'));
    }

    public function view(Request $request, $id)
    {   
        $this->is_permitted(1);
        $this->validated(Auth::user()->id, $id);
        $menus = $this->load_menus();
        $segment = request()->segment(4);
        $grading = (new GradingSheet)->fetch($id);
        $quarters = (new Quarter)->all_quarters();
        $sections = (new Section)->all_sections();
        $subjects = (new Subject)->all_subjects();
        $components = (new Component)->get_components_via_gradingsheet($id);
        $male_students = (new Admission)->get_students_via_gradingsheet($id, 'Male');
        $female_students = (new Admission)->get_students_via_gradingsheet($id, 'Female');
        return view('modules/academics/gradingsheets/all/view')->with(compact('menus', 'grading', 'quarters', 'sections', 'subjects', 'components', 'male_students', 'female_students', 'segment'));
    }
    
    public function store(Request $request)
    {    
        $this->is_permitted(0);
        $timestamp = date('Y-m-d H:i:s');
        $subjects = Subject::find($request->subject_id);

        if ($subjects->is_mapeh > 0) 
        {
            if ($subjects->code == 'health') {
                $rows = GradingSheet::where([
                    'section_id' => $request->section_id,
                    'subject_id' => $request->subject_id,
                    'education_type_id' => $request->education_type_id,
                    'batch_id' => (new Batch)->get_current_batch()
                ])->count();

                if ($rows == 0) {
                    $count = GradingSheet::all()->count() + 1;

                    $grading = GradingSheet::create([
                        'code' => (new Section)->get_column_via_identifier('name', $request->section_id).': '.(new Subject)->get_column_via_identifier('name', $request->subject_id),
                        'section_id' => $request->section_id,
                        'subject_id' => $request->subject_id,
                        'quarter_id' => $request->quarter_id,
                        'material_id' => (new Subject)->where('id', $request->subject_id)->first()->material_id,
                        'education_type_id' => $request->education_type_id,
                        'batch_id' => (new Batch)->get_current_batch(),
                        'created_at' => $timestamp,
                        'created_by' => Auth::user()->id
                    ]);

                    if (!$grading) {
                        throw new NotFoundHttpException();
                    }

                    $this->audit_logs('gradingsheets', $grading->id, 'has generated a new gradingsheet.', GradingSheet::find($grading->id), $timestamp, Auth::user()->id);

                    $data = array(
                        'title' => 'Well done!',
                        'text' => 'The grading sheet has been successfully saved.',
                        'type' => 'success',
                        'class' => 'btn-brand'
                    );

                    echo json_encode( $data ); exit();
                } else {
                    $data = array(
                        'title' => 'Oh snap!',
                        'text' => 'This section, subject and quarter is already exist.',
                        'type' => 'error',
                        'class' => 'btn-danger'
                    );
            
                    echo json_encode( $data ); exit();
                }
            } else if ($subjects->code == 'arts') {
                $rows = GradingSheet::where([
                    'section_id' => $request->section_id,
                    'subject_id' => $request->subject_id,
                    'education_type_id' => $request->education_type_id,
                    'batch_id' => (new Batch)->get_current_batch()
                ])->count();

                if ($rows == 0) {
                    $count = GradingSheet::all()->count() + 1;

                    $grading = GradingSheet::create([
                        'code' => (new Section)->get_column_via_identifier('name', $request->section_id).': '.(new Subject)->get_column_via_identifier('name', $request->subject_id),
                        'section_id' => $request->section_id,
                        'subject_id' => $request->subject_id,
                        'quarter_id' => $request->quarter_id,
                        'material_id' => (new Subject)->where('id', $request->subject_id)->first()->material_id,
                        'education_type_id' => $request->education_type_id,
                        'batch_id' => (new Batch)->get_current_batch(),
                        'created_at' => $timestamp,
                        'created_by' => Auth::user()->id
                    ]);

                    if (!$grading) {
                        throw new NotFoundHttpException();
                    }

                    $this->audit_logs('gradingsheets', $grading->id, 'has generated a new gradingsheet.', GradingSheet::find($grading->id), $timestamp, Auth::user()->id);

                    $data = array(
                        'title' => 'Well done!',
                        'text' => 'The grading sheet has been successfully saved.',
                        'type' => 'success',
                        'class' => 'btn-brand'
                    );

                    echo json_encode( $data ); exit();
                } else {
                    $data = array(
                        'title' => 'Oh snap!',
                        'text' => 'This section, subject and quarter is already exist.',
                        'type' => 'error',
                        'class' => 'btn-danger'
                    );
            
                    echo json_encode( $data ); exit();
                }
            } else if ($subjects->code == 'pe') {
                $rows = GradingSheet::where([
                    'section_id' => $request->section_id,
                    'subject_id' => $request->subject_id,
                    'education_type_id' => $request->education_type_id,
                    'batch_id' => (new Batch)->get_current_batch()
                ])->count();

                if ($rows < 2) {
                    $rowx = GradingSheet::where([
                        'section_id' => $request->section_id,
                        'subject_id' => $request->subject_id,
                        'quarter_id' => $request->quarter_id,
                        'education_type_id' => $request->education_type_id,
                        'batch_id' => (new Batch)->get_current_batch()
                    ])->count();
        
                    if ($rowx > 0) {
                        $data = array(
                            'title' => 'Oh snap!',
                            'text' => 'This section, subject and quarter is already exist.',
                            'type' => 'error',
                            'class' => 'btn-danger'
                        );
                
                        echo json_encode( $data ); exit();
                    }
        
                    $count = GradingSheet::all()->count() + 1;
        
                    $grading = GradingSheet::create([
                        'code' => (new Section)->get_column_via_identifier('name', $request->section_id).': '.(new Subject)->get_column_via_identifier('name', $request->subject_id),
                        'section_id' => $request->section_id,
                        'subject_id' => $request->subject_id,
                        'quarter_id' => $request->quarter_id,
                        'material_id' => (new Subject)->where('id', $request->subject_id)->first()->material_id,
                        'education_type_id' => $request->education_type_id,
                        'batch_id' => (new Batch)->get_current_batch(),
                        'created_at' => $timestamp,
                        'created_by' => Auth::user()->id
                    ]);
        
                    if (!$grading) {
                        throw new NotFoundHttpException();
                    }

                    $this->audit_logs('gradingsheets', $grading->id, 'has generated a new gradingsheet.', GradingSheet::find($grading->id), $timestamp, Auth::user()->id);
        
                    $data = array(
                        'title' => 'Well done!',
                        'text' => 'The grading sheet has been successfully saved.',
                        'type' => 'success',
                        'class' => 'btn-brand'
                    );
        
                    echo json_encode( $data ); exit();
                } else {
                    $data = array(
                        'title' => 'Oh snap!',
                        'text' => 'This section, subject and quarter is already exist.',
                        'type' => 'error',
                        'class' => 'btn-danger'
                    );
            
                    echo json_encode( $data ); exit();
                }
            } else {

                $rows = GradingSheet::where([
                    'section_id' => $request->section_info_id,
                    'subject_id' => $request->subject_id,
                    'quarter_id' => $request->quarter_id,
                    'education_type_id' => $request->education_type_id,
                    'batch_id' => (new Batch)->get_current_batch()
                ])->count();
                 
                if ($rows > 0) {
                    $data = array(
                        'title' => 'Oh snap!',
                        'text' => 'This section, subject and quarter is already exist.',
                        'type' => 'error',
                        'class' => 'btn-danger'
                    );
            
                    echo json_encode( $data ); exit();
                }
    
                $count = GradingSheet::all()->count() + 1;
    
                $grading = GradingSheet::create([
                    'code' => (new Section)->get_column_via_identifier('name', $request->section_id).': '.(new Subject)->get_column_via_identifier('name', $request->subject_id),
                    'section_id' => $request->section_id,
                    'subject_id' => $request->subject_id,
                    'quarter_id' => $request->quarter_id,
                    'material_id' => (new Subject)->where('id', $request->subject_id)->first()->material_id,
                    'education_type_id' => $request->education_type_id,
                    'batch_id' => (new Batch)->get_current_batch(),
                    'created_at' => $timestamp,
                    'created_by' => Auth::user()->id
                ]);
    
                if (!$grading) {
                    throw new NotFoundHttpException();
                }
                
                $this->audit_logs('gradingsheets', $grading->id, 'has generated a new gradingsheet.', GradingSheet::find($grading->id), $timestamp, Auth::user()->id);

                $data = array(
                    'title' => 'Well done!',
                    'text' => 'The grading sheet has been successfully saved.',
                    'type' => 'success',
                    'class' => 'btn-brand'
                );
    
                echo json_encode( $data ); exit();
            }
        } 
        else 
        {   
            $rows = GradingSheet::whereIn('quarter_id', $request->quarter_id)
            ->where([
                'section_info_id' => $request->section_info_id,
                'subject_id' => $request->subject_id,
                'education_type_id' => $request->education_type_id,
                'batch_id' => (new Batch)->get_current_batch(),
                'is_active' => 1
            ])->count();

            if ($rows > 0) {
                $data = array(
                    'title' => 'Oh snap!',
                    'text' => 'This class, quarter and subject are already exist.',
                    'type' => 'error',
                    'class' => 'btn-danger'
                );
        
                echo json_encode( $data ); exit();
            }

            $count = GradingSheet::all()->count() + 1;
            $classcode = (new Section)->get_column_via_identifier('name', (new SectionInfo)->where('id', $request->section_info_id)->pluck('section_id')).': '.(new Subject)->get_column_via_identifier('name', $request->subject_id);

            foreach ($request->quarter_id as $quarter) {
                $grading = GradingSheet::create([
                    'code' => $classcode,
                    'section_info_id' => $request->section_info_id,
                    'subject_id' => $request->subject_id,
                    'quarter_id' => $quarter,
                    'material_id' => (new Subject)->where('id', $request->subject_id)->first()->material_id,
                    'education_type_id' => $request->education_type_id,
                    'batch_id' => (new Batch)->get_current_batch(),
                    'created_at' => $timestamp,
                    'created_by' => Auth::user()->id
                ]);

                if (!$grading) {
                    throw new NotFoundHttpException();
                }
    
                $this->audit_logs('gradingsheets', $grading->id, 'has generated a new gradingsheet.', GradingSheet::find($grading->id), $timestamp, Auth::user()->id);
            }

            $data = array(
                'data' => $rows,
                'title' => 'Well done!',
                'text' => 'The grading sheet has been successfully saved.',
                'type' => 'success',
                'class' => 'btn-brand'
            );

            echo json_encode( $data ); exit();
        }
    }

    public function update(Request $request, $id)
    {    
        $this->is_permitted(2);
        $timestamp = date('Y-m-d H:i:s');
        $grading = GradingSheet::find($id);

        if(!$grading) {
            throw new NotFoundHttpException();
        }

        if ($grading->material_id <= 2) {
            $iteration = 0; $students = array();
            // foreach ($request->activity as $activity) 
            // {
            //     $activities = explode("_", $activity);
            //     if (!in_array($activities[1], $students)) {
            //         $students[] = $activities[1];
            //     }
                
            //     if ($grading->material_id == 2) {
            //         $row = GradingSheetActivity::where([
            //             'gradingsheet_id' => $id,
            //             'activity_id' => $activities[0],
            //             'student_id' => $activities[1]
            //         ])->get();

            //         if ($row->count() > 0) {
            //             $gradingActivtity = GradingSheetActivity::where('id', '=', $row->first()->id)
            //             ->update([
            //                 'score' => ($request->score[$iteration] !== NULL) ? $request->score[$iteration] : NULL,
            //                 'updated_at' => $timestamp,
            //                 'updated_by' => Auth::user()->id
            //             ]);
            //         } else {
            //             $gradingActivtity = GradingSheetActivity::create([
            //                 'gradingsheet_id' => $id,
            //                 'activity_id' => $activities[0],
            //                 'student_id' => $activities[1],
            //                 'score' => ($request->score[$iteration] !== NULL) ? $request->score[$iteration] : NULL,
            //                 'created_at' => $timestamp,
            //                 'created_by' => Auth::user()->id
            //             ]);
            //         }
            //     }
            //     $iteration++;
            // }
        } else {
            // $iteration = 0; $students = array();
            // foreach ($request->component as $component) 
            // {
            //     $components = explode("_", $component);
            //     if (!in_array($components[1], $students)) {
            //         $students[] = $components[1];
            //     }

            //     $row = GradingSheetHomeroom::where([
            //         'gradingsheet_id' => $id,
            //         'component_id' => $components[0],
            //         'student_id' => $components[1]
            //     ])->get();

            //     if ($row->count() > 0) {
            //         $gradingActivtity = GradingSheetHomeroom::where('id', '=', $row->first()->id)
            //         ->update([
            //             'score' => ($request->score[$iteration] !== NULL) ? $request->score[$iteration] : NULL,
            //             'updated_at' => $timestamp,
            //             'updated_by' => Auth::user()->id
            //         ]);
            //     } else {
            //         $gradingActivtity = GradingSheetHomeroom::create([
            //             'gradingsheet_id' => $id,
            //             'component_id' => $components[0],
            //             'student_id' => $components[1],
            //             'score' => ($request->score[$iteration] !== NULL) ? $request->score[$iteration] : NULL,
            //             'created_at' => $timestamp,
            //             'created_by' => Auth::user()->id
            //         ]);
            //     }
                
            //     $iteration++;
            // }

            // $iteration = 0; $requestGrade = array();
            // foreach ($students as $student) 
            // {
            //     $rowQuarter = GradingSheetQuarter::where([
            //         'gradingsheet_id' => $id,
            //         'student_id' => $student
            //     ])->get();

            //     if ($rowQuarter->count() > 0) {
            //         $gradingQuarter = GradingSheetQuarter::where('id', '=', $rowQuarter->first()->id)
            //         ->update([
            //             'initial_grade' => ($request->init_grade[$iteration] !== NULL) ? $request->init_grade[$iteration] : NULL,
            //             'adjustment_grade' => ($request->tc_score[$iteration] !== NULL) ? $request->tc_score[$iteration] : NULL,
            //             'quarter_grade' => ($request->quarter_grade[$iteration] !== NULL) ? $request->quarter_grade[$iteration] : NULL,
            //             'rating' => ($request->rating[$iteration] !== NULL) ? $request->rating[$iteration] : NULL,
            //             'ranking' => ($request->ranking[$iteration] !== NULL) ? $request->ranking[$iteration] : NULL,
            //             'updated_at' => $timestamp,
            //             'updated_by' => Auth::user()->id
            //         ]);
            //     } else {
            //         $gradingQuarter = GradingSheetQuarter::create([
            //             'gradingsheet_id' => $id,
            //             'batch_id' => (new Batch)->get_current_batch(),
            //             'quarter_id' => (new GradingSheet)->get_column_via_identifier('quarter_id', $id),
            //             'student_id' => $student,
            //             'initial_grade' => ($request->init_grade[$iteration] !== NULL) ? $request->init_grade[$iteration] : NULL,
            //             'adjustment_grade' => ($request->tc_score[$iteration] !== NULL) ? $request->tc_score[$iteration] : NULL,
            //             'quarter_grade' => ($request->quarter_grade[$iteration] !== NULL) ? $request->quarter_grade[$iteration] : NULL,
            //             'rating' => ($request->rating[$iteration] !== NULL) ? $request->rating[$iteration] : NULL,
            //             'ranking' => ($request->ranking[$iteration] !== NULL) ? $request->ranking[$iteration] : NULL,
            //             'created_at' => $timestamp,
            //             'created_by' => Auth::user()->id
            //         ]);
            //     }

            //     $requestGrade[] = $request->quarter_grade[$iteration];
            //     $iteration++;
            // }
        }

        $data = array(
            'title' => 'Well done!',
            'text' => 'The grading sheet has been successfully updated.',
            'type' => 'success',
            'class' => 'btn-brand'
        );

        echo json_encode( $data ); exit();
    }

    public function update_rows(Request $request, $id)
    {
        $this->is_permitted(2);
        $timestamp = date('Y-m-d H:i:s');
        $grading = GradingSheet::find($id);

        if(!$grading) {
            throw new NotFoundHttpException();
        }

        if ($grading->material_id <= 2) 
        {
            $students = array();
            $activities = explode("_", $request->get('activity'));
            if (!in_array($activities[1], $students)) {
                $students[] = $activities[1];
            }

            if ($request->get('score') !== 'tc') {
                $row = GradingSheetActivity::where([
                    'gradingsheet_id' => $id,
                    'activity_id' => $activities[0],
                    'student_id' => $activities[1]
                ])->get();

                if ($row->count() > 0) {
                    $gradingActivtity = GradingSheetActivity::where('id', '=', $row->first()->id)
                    ->update([
                        'score' => ($request->get('score') !== NULL) ? $request->get('score') : NULL,
                        'updated_at' => $timestamp,
                        'updated_by' => Auth::user()->id
                    ]);
                } else {
                    $gradingActivtity = GradingSheetActivity::create([
                        'gradingsheet_id' => $id,
                        'activity_id' => $activities[0],
                        'student_id' => $activities[1],
                        'score' => ($request->get('score') !== NULL) ? $request->get('score') : NULL,
                        'created_at' => $timestamp,
                        'created_by' => Auth::user()->id
                    ]);
                }
            }
        }
        else
        {
            $students = array();
            $components = explode("_", $request->get('component'));
            if (!in_array($components[1], $students)) {
                $students[] = $components[1];
            }

            if ($request->get('score') !== 'tc') {
                $row = GradingSheetHomeroom::where([
                    'gradingsheet_id' => $id,
                    'component_id' => $components[0],
                    'student_id' => $components[1]
                ])->get();

                if ($row->count() > 0) {
                    $gradingActivtity = GradingSheetHomeroom::where('id', '=', $row->first()->id)
                    ->update([
                        'score' => ($request->get('score') !== NULL) ? $request->get('score') : NULL,
                        'updated_at' => $timestamp,
                        'updated_by' => Auth::user()->id
                    ]);
                } else {
                    $gradingActivtity = GradingSheetHomeroom::create([
                        'gradingsheet_id' => $id,
                        'component_id' => $components[0],
                        'student_id' => $components[1],
                        'score' => ($request->get('score') !== NULL) ? $request->get('score') : NULL,
                        'created_at' => $timestamp,
                        'created_by' => Auth::user()->id
                    ]);
                }
            }
        }

        $iteration = 0; $requestGrade = array();
        foreach ($students as $student) 
        {
            $rowQuarter = GradingSheetQuarter::where([
                'gradingsheet_id' => $id,
                'student_id' => $student
            ])->get();

            if ($rowQuarter->count() > 0) {
                $gradingQuarter = GradingSheetQuarter::where('id', '=', $rowQuarter->first()->id)
                ->update([
                    'initial_grade' => ($request->get('igrade') !== NULL) ? $request->get('igrade') : NULL,
                    'adjustment_grade' => ($request->get('tcscore') !== NULL) ? $request->get('tcscore') : NULL,
                    'quarter_grade' => ($request->get('qgrade') !== NULL) ? $request->get('qgrade') : NULL,
                    'rating' => ($request->get('rating') !== NULL) ? $request->get('rating') : NULL,
                    'ranking' => ($request->get('ranking') !== NULL) ? $request->get('ranking') : NULL,
                    'updated_at' => $timestamp,
                    'updated_by' => Auth::user()->id
                ]);
            } else {
                $gradingQuarter = GradingSheetQuarter::create([
                    'gradingsheet_id' => $id,
                    'batch_id' => (new Batch)->get_current_batch(),
                    'quarter_id' => (new GradingSheet)->get_column_via_identifier('quarter_id', $id),
                    'student_id' => $student,
                    'initial_grade' => ($request->get('igrade') !== NULL) ? $request->get('igrade') : NULL,
                    'adjustment_grade' => ($request->get('tcscore') !== NULL) ? $request->get('tcscore') : NULL,
                    'quarter_grade' => ($request->get('qgrade') !== NULL) ? $request->get('qgrade') : NULL,
                    'rating' => ($request->get('rating') !== NULL) ? $request->get('rating') : NULL,
                    'ranking' => ($request->get('ranking') !== NULL) ? $request->get('ranking') : NULL,
                    'created_at' => $timestamp,
                    'created_by' => Auth::user()->id
                ]);
            }

            $iteration++;
        }

        $data = array(
            'title' => 'Well done!',
            'text' => 'The grading sheet has been successfully updated.',
            'type' => 'success',
            'class' => 'btn-brand'
        );

        echo json_encode( $data ); exit();
    }

    public function update_status(Request $request, $id)
    {   
        $this->is_permitted(3);
        $timestamp = date('Y-m-d H:i:s');
        $action = $request->input('items')[0]['action'];

        if ($action == 'Lock') {
            $department = Gradingsheet::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_locked' => 1
            ]);
            $this->audit_logs('gradingsheets', $id, 'has locked a gradingsheet.', Gradingsheet::find($id), $timestamp, Auth::user()->id);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The gradingsheet has been successfully locked.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }    
        else {
            $department = Gradingsheet::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_locked' => 0
            ]);
            $this->audit_logs('gradingsheets', $id, 'has unlocked a gradingsheet.', Gradingsheet::find($id), $timestamp, Auth::user()->id);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The gradingsheet has been successfully unlocked.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }   
    }

    public function get_activity_score_via_activity($id, $student, $grading)
    {
        return (new GradingSheetActivity)->get_activity_score_via_activity($id, $student, $grading);
    }

    public function get_component_score_via_component($id, $student, $grading)
    {
        return (new GradingSheetHomeroom)->get_component_score_via_component($id, $student, $grading);
    }

    public function reload($type)
    {   
        if (Auth::user()->type == 'administrator') 
        {   
            //--> sections
            $res = (new SectionInfo)
            ->with([
                'section' =>  function($q) { 
                    $q->select(['id', 'name', 'description']);
                },
                'level' =>  function($q) { 
                    $q->select(['id', 'name', 'description']);
                }
            ])
            ->where([
                'batch_id' => (new Batch)->get_current_batch(), 
                'education_type_id' => $type,
                'is_active' => 1
            ])
            ->orderBy('id', 'ASC')->get();

            $arr['sections'] = $res->map(function($class) {
                return [
                    'id' => $class->id,
                    'name' => $class->level->name.' - '.$class->section->name
                ];
            });

            //--> subjects
            $arr['subjects'] = (new Subject)
            ->whereIn('subjects.id', 
                SectionsSubjects::select('subject_id')
                ->whereIn('section_info_id', 
                    SectionInfo::select('id')->where([
                        'batch_id' => (new Batch)->get_current_batch(), 'is_active' => 1
                    ])
                )
            )
            ->join('subjects_education_types', 'subjects_education_types.subject_id', 'subjects.id')
            ->where(['subjects.is_active' => 1, 'education_type_id' => $type])
            ->orderBy('subjects.id', 'ASC')->get();

            //--> quarters
            $arr['quarters'] = (new Quarter)
            ->whereIn('id',
                QuarterEducationType::select('quarter_id')
                ->where([
                    'education_type_id' => $type,
                    'is_active' => 1
                ])
            )
            ->where([
                'batch_id' => (new Batch)->get_current_batch(), 
                'is_active' => 1
            ])
            ->orderBy('id', 'ASC')->get();
        }
        else
        {   
            //--> sections
            $arr['sections'] = (new Section)
            ->whereIn('id',     
                SectionInfo::select('section_id')
                ->whereIn('id', 
                    SectionsSubjects::select('section_info_id')->where([
                        'teacher_id' => (new Staff)->get_column_via_user('id', Auth::user()->id),
                        'batch_id' => (new Batch)->get_current_batch(),
                        'is_active' => 1
                    ])
                )->where([
                    'batch_id' => (new Batch)->get_current_batch(), 
                    'is_active' => 1
                ])
            )
            ->where(['is_active' => 1, 'education_type_id' => $type])
            ->orderBy('id', 'ASC')->get();

            //--> subjects
            $arr['subjects'] = (new Subject)
            ->whereIn('id', 
                SectionsSubjects::select('subject_id')
                ->whereIn('section_info_id', 
                    SectionInfo::select('id')->where([
                        'batch_id' => (new Batch)->get_current_batch(), 
                        'is_active' => 1]
                    )
                )->where([
                    'teacher_id' => (new Staff)->get_column_via_user('id', Auth::user()->id),
                    'batch_id' => (new Batch)->get_current_batch(),
                    'is_active' => 1
                ])
            )
            ->where(['is_active' => 1, 'education_type_id' => $type])
            ->orderBy('id', 'ASC')->get();

            //--> quarters
            $arr['quarters'] = (new Quarter)
            ->where(['is_active' => 1, 'education_type_id' => $type])
            ->orderBy('id', 'ASC')->get();
        }

        echo json_encode( $arr ); exit();
    }

    public function reload_subject($section)
    {   
        //--> subjects
        $arr['subjects'] = (new Subject)
        ->whereIn('id', 
            SectionsSubjects::select('subject_id')
            ->where([
                'section_info_id' => $section,
                'batch_id' => (new Batch)->get_current_batch(),
                'is_active' => 1
            ])
        )
        ->where(['is_active' => 1])
        ->orderBy('id', 'ASC')->get();

        echo json_encode( $arr ); exit();
    }

    public function get_transmutation_value($score, $type)
    {   
        $res = TransmutationElement::with([
            'transmutation' =>  function($q) { 
                $q->select(['id', 'name']);
            },
        ])
        ->whereIn('transmutation_id', Transmutation::select('id')->where('education_type_id', $type))
        ->where('score', '<=', $score)
        ->max('equivalent');

        return $res;
    }

    public function fetch_transmutations($type)
    {
        $res = TransmutationElement::with([
            'transmutation' =>  function($q) use ($type) { 
                $q->select(['id', 'name'])->where('education_type_id', $type);
            },
        ])
        ->whereIn('transmutation_id', Transmutation::select('id')->where('education_type_id', $type))
        ->get();

        $res = $res->map(function($grading) {
            return (object) [
                'score' => $grading->score,
                'equivalent' => $grading->equivalent
            ];
        });

        echo json_encode( $res ); exit();
    }

    public function get_colum_via_gradingsheet_student($column, $gradingID, $student)
    {
        $res = (new GradingSheetQuarter)->get_colum_via_gradingsheet_student($column, $gradingID, $student);
        return $res;
    }

    public function export_gradingsheet(Request $request, $id)
    {   
        $gradingsheet = (new GradingSheet)->fetch($id);
        return Excel::download(new GradingSheetExport($id), 'GradingSheet_'.$id.'.xlsx');
    }

    public function import_gradingsheet(Request $request, $id)
    {
        $this->validate( $request, [
            'import_file' => 'required|mimes:xls,xlsx'
        ]);

        preg_match_all('!\d+!', $request->file('import_file')->getClientOriginalName(), $gradingsheet_id);
        $gs_id = implode(' ', $gradingsheet_id[0]); //get file id

        $path = $request->file('import_file')->store('Imports');
        Excel::import(new GradingSheetImport($id), $path);
        return back();
    }

    public function update_activity_header(Request $request)
    {   
        $this->is_permitted(2);
        $timestamp = date('Y-m-d H:i:s');
        $activity = Activity::find($request->get('id'));

        if(!$activity) {
            throw new NotFoundHttpException();
        }

        $activity->activity = $request->get('val');
        $activity->updated_at = $timestamp;
        $activity->updated_by = Auth::user()->id;

        if ($activity->update()) {

            $this->audit_logs('activities', $request->get('id'), 'has modified a component activity.', Activity::find($request->get('id')), $timestamp, Auth::user()->id);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The component activity has been successfully updated.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }
    }

    public function update_activity_value(Request $request)
    {   
        $this->is_permitted(2);
        $timestamp = date('Y-m-d H:i:s');
        $activity = Activity::find($request->get('id'));

        if(!$activity) {
            throw new NotFoundHttpException();
        }

        $activity->value = $request->get('val');
        $activity->updated_at = $timestamp;
        $activity->updated_by = Auth::user()->id;

        if ($activity->update()) {

            $this->audit_logs('activities', $request->get('id'), 'has modified a component activity.', Activity::find($request->get('id')), $timestamp, Auth::user()->id);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The component activity has been successfully updated.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }
    }

    public function get_activity_components(Request $request)
    {
        $res = Activity::select(['activities.id', 'activities.activity', 'activities.value', 'activities.description'])
        ->join('components', function($join)
        {
            $join->on('components.id', '=', 'activities.component_id');
        })
        ->where([
            'activities.component_id' => $request->get('component_id'),
            'activities.quarter_id' => $request->get('quarter_id'),
            'activities.subject_id' => $request->get('subject_id'),
            'components.section_info_id' => $request->get('section_info_id'),
            'components.batch_id' => $request->get('batch_id'),
            'activities.is_active' => 1
        ])
        ->get();

        return response()
        ->json([
            'status' => 'ok',
            'data' => $res
        ]);
    }

    public function update_components(Request $request)
    {   
        $timestamp = date('Y-m-d H:i:s');

        Activity::join('components', function($join)
        {
            $join->on('components.id', '=', 'activities.component_id');
        })
        ->where([
            'activities.component_id' => $request->get('component_id'),
            'activities.quarter_id' => $request->get('quarter_id'),
            'activities.subject_id' => $request->get('subject_id'),
            'components.section_info_id' => $request->get('section_info_id'),
            'components.batch_id' => $request->get('batch_id')
        ])
        ->update(['activities.is_active' => 0]);
        if (!empty($request->activity_name)) {
            $activities = $request->activity_name; $iteration = 0;
            $activity_components = Activity::select('activities.id')
            ->join('components', function($join)
            {
                $join->on('components.id', '=', 'activities.component_id');
            })
            ->where([
                'activities.component_id' => $request->get('component_id'),
                'activities.quarter_id' => $request->get('quarter_id'),
                'activities.subject_id' => $request->get('subject_id'),
                'components.section_info_id' => $request->get('section_info_id'),
                'components.batch_id' => $request->get('batch_id')
            ])
            ->orderBy('activities.id', 'ASC')->get();
            foreach ($activities as $activity) 
            {
                if ($activity !== NULL) {
                    if ($activity_components->count() > 0 && $activity_components->count() > $iteration) {
                        if ($activity_components[$iteration]->id !== NULL) {
                            $activity_component = Activity::where('id', $activity_components[$iteration]->id)
                            ->update([
                                'activity' => $request->activity_name[$iteration],
                                'value' => $request->activity_value[$iteration],
                                'description' => $request->activity_description[$iteration],
                                'updated_at' => $timestamp,
                                'updated_by' => Auth::user()->id,
                                'is_active' => 1
                            ]);
                            $this->audit_logs('activities', $activity_components[$iteration]->id, 'has modified a component activity.', Activity::find($activity_components[$iteration]->id), $timestamp, Auth::user()->id);
                        } else {
                            $activity_component = Activity::create([
                                'component_id' => $request->get('component_id'),
                                'quarter_id' => $request->get('quarter_id'),
                                'subject_id' => $request->get('subject_id'),
                                'activity' => $request->activity_name[$iteration],
                                'value' => $request->activity_value[$iteration],
                                'description' => $request->activity_description[$iteration],
                                'created_at' => $timestamp,
                                'created_by' => Auth::user()->id
                            ]);
                            $this->audit_logs('activities', $activity_component->id, 'has inserted a new component activity.', Activity::find($activity_component->id), $timestamp, Auth::user()->id);
                        }
                    } else {
                        $activity_component = Activity::create([
                            'component_id' => $request->get('component_id'),
                            'quarter_id' => $request->get('quarter_id'),
                            'subject_id' => $request->get('subject_id'),
                            'activity' => $request->activity_name[$iteration],
                            'value' => $request->activity_value[$iteration],
                            'description' => $request->activity_description[$iteration],
                            'created_at' => $timestamp,
                            'created_by' => Auth::user()->id
                        ]);
                        $this->audit_logs('activities', $activity_component->id, 'has inserted a new component activity.', Activity::find($activity_component->id), $timestamp, Auth::user()->id);
                    }
                }
                $iteration++;
            }
        }

        $data = array(
            'data' => $activity_components,
            'title' => 'Well done!',
            'text' => 'The component has been successfully updated.',
            'type' => 'success',
            'class' => 'btn-brand'
        );

        echo json_encode( $data ); exit();
    }

    public function audit_logs($entity, $entity_id, $description, $data, $timestamp, $user)
    {
        $auditLogs = AuditLog::create([
            'entity' => $entity,
            'entity_id' => $entity_id,
            'description' => $description,
            'data' => json_encode($data),
            'created_at' => $timestamp,
            'created_by' => $user
        ]);

        return true;
    }
}