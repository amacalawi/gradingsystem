<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\GradingSheet;
use App\Models\Quarter;
use App\Models\Subject;
use App\Models\Section;
use App\Models\Batch;
use App\Models\Component;
use App\Models\Admission;
use App\Models\GradingSheetActivity;
use App\Models\SectionInfo;
use App\Models\SectionsSubjects;
use App\Models\Staff;
use App\Models\TransmutationElement;
use App\Models\Transmutation;
use Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\File;
use App\Components\FlashMessages;

class GradingSheetsController extends Controller
{   
    use FlashMessages;
    private $models;

    public function __construct()
    {   
        date_default_timezone_set('Asia/Manila');
        $this->middleware('auth');
    }
    
    public function index()
    {   
        $menus = $this->load_menus();
        return view('modules/academics/gradingsheets/all/manage')->with(compact('menus'));
    }

    public function manage(Request $request)
    {   
        $menus = $this->load_menus();
        return view('modules/academics/gradingsheets/all/manage')->with(compact('menus'));
    }

    public function inactive(Request $request)
    {   
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
            ])->orderBy('id', 'ASC')->get();

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
            ->where('is_active', 1)
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
            $res = GradingSheet::where('is_active', 0)
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
            ])->orderBy('id', 'ASC')->get();

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
            ->where('is_active', 0)
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
        $menus = $this->load_menus();
        $segment = request()->segment(4);
        $grading = (new GradingSheet)->fetch($id);
        $quarters = (new Quarter)->all_quarters();
        $sections = (new Section)->all_sections();
        $subjects = (new Subject)->all_subjects();
        $types = (new GradingSheet)->types();
        return view('modules/academics/gradingsheets/all/add')->with(compact('menus', 'grading', 'quarters', 'sections', 'subjects', 'types', 'segment'));
    }
    
    public function edit(Request $request, $id)
    {   
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
        $timestamp = date('Y-m-d H:i:s');

        $rows = GradingSheet::where([
            'section_id' => $request->section_id,
            'subject_id' => $request->subject_id,
            'quarter_id' => $request->quarter_id,
            'type' => $request->type,
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
            'type' => $request->type,
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

    public function update(Request $request, $id)
    {    
        $timestamp = date('Y-m-d H:i:s');
        $grading = GradingSheet::find($id);

        if(!$grading) {
            throw new NotFoundHttpException();
        }
        
        $iteration = 0;
        foreach ($request->activity as $activity) 
        {
            $activities = explode("_", $activity);

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
            ->where(['is_active' => 1, 'type' => $type])
            ->orderBy('id', 'ASC')->get();

            //--> subjects
            $arr['subjects'] = (new Subject)
            ->whereIn('id', 
                SectionsSubjects::select('subject_id')
                ->whereIn('section_info_id', 
                    SectionInfo::select('id')->where([
                        'batch_id' => (new Batch)->get_current_batch(), 'is_active' => 1
                    ])
                )
            )
            ->where(['is_active' => 1, 'type' => $type])
            ->orderBy('id', 'ASC')->get();

            //--> quarters
            $arr['quarters'] = (new Quarter)->where(['is_active' => 1, 'type' => $type])->orderBy('id', 'ASC')->get();
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
            ->where(['is_active' => 1, 'type' => $type])
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
            ->where(['is_active' => 1, 'type' => $type])
            ->orderBy('id', 'ASC')->get();

            //--> quarters
            $arr['quarters'] = (new Quarter)->where(['is_active' => 1, 'type' => $type])->orderBy('id', 'ASC')->get();
        }

        echo json_encode( $arr ); exit();
    }

    public function get_transmutation_value($score, $type)
    {   
        $res = TransmutationElement::with([
            'transmutation' =>  function($q) { 
                $q->select(['id', 'name']);
            },
        ])
        ->whereIn('transmutation_id', Transmutation::select('id')->where('type', $type))
        ->where('score', '<=', $score)
        ->max('equivalent');

        return $res;
    }

    public function fetch_transmutations($type)
    {
        $res = TransmutationElement::with([
            'transmutation' =>  function($q) use ($type) { 
                $q->select(['id', 'name'])->where('type', $type);
            },
        ])
        ->whereIn('transmutation_id', Transmutation::select('id')->where('type', $type))
        ->get();

        $res = $res->map(function($grading) {
            return (object) [
                'score' => $grading->score,
                'equivalent' => $grading->equivalent
            ];
        });

        echo json_encode( $res ); exit();
    }
}
