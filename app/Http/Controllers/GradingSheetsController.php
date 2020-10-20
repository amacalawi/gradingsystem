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
use App\Models\Subject;
use App\Models\Section;
use App\Models\Batch;
use App\Models\Component;
use App\Models\Admission;
use App\Models\GradingSheetActivity;
use App\Models\GradingSheetHomeroom;
use App\Models\GradingSheetQuarter;
use App\Models\SectionInfo;
use App\Models\SectionsSubjects;
use App\Models\Staff;
use App\Models\TransmutationElement;
use App\Models\Transmutation;
use App\Models\EducationType;
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
            $res = GradingSheet::where('is_active', 1)
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
                'is_active' => 1
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
                'is_active' => 1
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
        $quarters = (new Quarter)->all_quarters();
        $sections = (new Section)->all_sections();
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
        $students = (new Admission)->get_students_via_gradingsheet($id);
        return view('modules/academics/gradingsheets/all/edit')->with(compact('menus', 'grading', 'quarters', 'sections', 'subjects', 'components', 'students', 'segment'));
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
                    'section_id' => $request->section_id,
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
            $rows = GradingSheet::where([
                'section_id' => $request->section_id,
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

            $data = array(
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
            foreach ($request->activity as $activity) 
            {
                $activities = explode("_", $activity);
                if (!in_array($activities[1], $students)) {
                    $students[] = $activities[1];
                }

                $row = GradingSheetActivity::where([
                    'gradingsheet_id' => $id,
                    'activity_id' => $activities[0],
                    'student_id' => $activities[1]
                ])->get();

                if ($row->count() > 0) {
                    $gradingActivtity = GradingSheetActivity::where('id', '=', $row->first()->id)
                    ->update([
                        'score' => ($request->score[$iteration] !== NULL) ? $request->score[$iteration] : NULL,
                        'updated_at' => $timestamp,
                        'updated_by' => Auth::user()->id
                    ]);
                } else {
                    $gradingActivtity = GradingSheetActivity::create([
                        'gradingsheet_id' => $id,
                        'activity_id' => $activities[0],
                        'student_id' => $activities[1],
                        'score' => ($request->score[$iteration] !== NULL) ? $request->score[$iteration] : NULL,
                        'created_at' => $timestamp,
                        'created_by' => Auth::user()->id
                    ]);
                }
                
                $iteration++;
            }
        } else {
            $iteration = 0; $students = array();
            foreach ($request->component as $component) 
            {
                $components = explode("_", $component);
                if (!in_array($components[1], $students)) {
                    $students[] = $components[1];
                }

                $row = GradingSheetHomeroom::where([
                    'gradingsheet_id' => $id,
                    'component_id' => $components[0],
                    'student_id' => $components[1]
                ])->get();

                if ($row->count() > 0) {
                    $gradingActivtity = GradingSheetHomeroom::where('id', '=', $row->first()->id)
                    ->update([
                        'score' => ($request->score[$iteration] !== NULL) ? $request->score[$iteration] : NULL,
                        'updated_at' => $timestamp,
                        'updated_by' => Auth::user()->id
                    ]);
                } else {
                    $gradingActivtity = GradingSheetHomeroom::create([
                        'gradingsheet_id' => $id,
                        'component_id' => $components[0],
                        'student_id' => $components[1],
                        'score' => ($request->score[$iteration] !== NULL) ? $request->score[$iteration] : NULL,
                        'created_at' => $timestamp,
                        'created_by' => Auth::user()->id
                    ]);
                }
                
                $iteration++;
            }
        }

        $iteration = 0;
        foreach ($students as $student) 
        {
            $rowQuarter = GradingSheetQuarter::where([
                'gradingsheet_id' => $id,
                'student_id' => $student
            ])->get();

            if ($rowQuarter->count() > 0) {
                $gradingQuarter = GradingSheetQuarter::where('id', '=', $rowQuarter->first()->id)
                ->update([
                    'initial_grade' => ($request->init_grade[$iteration] !== NULL) ? $request->init_grade[$iteration] : NULL,
                    'adjustment_grade' => ($request->tc_score[$iteration] !== NULL) ? $request->tc_score[$iteration] : NULL,
                    'quarter_grade' => ($request->quarter_grade[$iteration] !== NULL) ? $request->quarter_grade[$iteration] : NULL,
                    'rating' => ($request->rating[$iteration] !== NULL) ? $request->rating[$iteration] : NULL,
                    'ranking' => ($request->ranking[$iteration] !== NULL) ? $request->ranking[$iteration] : NULL,
                    'updated_at' => $timestamp,
                    'updated_by' => Auth::user()->id
                ]);
            } else {
                $gradingQuarter = GradingSheetQuarter::create([
                    'gradingsheet_id' => $id,
                    'batch_id' => (new Batch)->get_current_batch(),
                    'quarter_id' => (new GradingSheet)->get_column_via_identifier('quarter_id', $id),
                    'student_id' => $student,
                    'initial_grade' => ($request->init_grade[$iteration] !== NULL) ? $request->init_grade[$iteration] : NULL,
                    'adjustment_grade' => ($request->tc_score[$iteration] !== NULL) ? $request->tc_score[$iteration] : NULL,
                    'quarter_grade' => ($request->quarter_grade[$iteration] !== NULL) ? $request->quarter_grade[$iteration] : NULL,
                    'rating' => ($request->rating[$iteration] !== NULL) ? $request->rating[$iteration] : NULL,
                    'ranking' => ($request->ranking[$iteration] !== NULL) ? $request->ranking[$iteration] : NULL,
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

        if ($action == 'Remove') {
            $gradings = GradingSheet::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 0
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The grading has been successfully removed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        } 
        else if ($action == 'Up') {
            $gradings = GradingSheet::find($id);

            $gradings2 = GradingSheet::where([
                'order' => ($gradings->order - 1),
            ])
            ->update([
                'order' => $gradings->order,
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id
            ]);

            $gradings->order = ($gradings->order - 1);
            $gradings->updated_at = $timestamp;
            $gradings->updated_by = Auth::user()->id;
            $gradings->update();
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The grading has been successfully removed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        } 
        else if ($action == 'Down') {
            $gradings = GradingSheet::find($id);

            $gradings2 = GradingSheet::where([
                'order' => ($gradings->order + 1),
            ])
            ->update([
                'order' => $gradings->order,
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id
            ]);

            $gradings->order = ($gradings->order + 1);
            $gradings->updated_at = $timestamp;
            $gradings->updated_by = Auth::user()->id;
            $gradings->update();
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The grading has been successfully removed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );

            echo json_encode( $data ); exit();
        }         
        else {
            $batches = GradingSheet::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 1
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The grading has been successfully activated.',
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
            $arr['sections'] = (new Section)
            ->whereIn('id', 
                SectionInfo::select('section_id')->where([
                    'batch_id' => (new Batch)->get_current_batch(), 
                    'is_active' => 1
                ])
            )
            ->where(['is_active' => 1, 'education_type_id' => $type])
            ->orderBy('id', 'ASC')->get();

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
            ->where(['is_active' => 1, 'education_type_id' => $type])
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
            ->whereIn('section_info_id', 
                SectionInfo::select('id')->where([
                    'batch_id' => (new Batch)->get_current_batch(), 
                    'is_active' => 1,
                    'section_id' => $section
                ])
            )->where([
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

        if($gs_id == $id)
        {
            $path = $request->file('import_file')->store('Imports');
            Excel::import(new GradingSheetImport($id), $path);
            return back();
        }

    }
}
