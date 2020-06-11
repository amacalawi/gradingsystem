<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Component;
use App\Models\Activity;
use App\Models\Batch;
use App\Models\Quarter;
use App\Models\Subject;
use App\Models\UserRole;
use App\Models\Staff;
use App\Models\SectionsSubjects;
use App\Models\SectionInfo;
use App\Models\Section;
use Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\File;
use App\Components\FlashMessages;

class ComponentsController extends Controller
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
        return view('modules/academics/gradingsheets/components/manage')->with(compact('menus'));
    }

    public function manage(Request $request)
    {   
        $menus = $this->load_menus();
        return view('modules/academics/gradingsheets/components/manage')->with(compact('menus'));
    }

    public function inactive(Request $request)
    {   
        $menus = $this->load_menus();
        return view('modules/academics/gradingsheets/components/inactive')->with(compact('menus'));
    }

    public function validated($user, $id)
    {
        if ($id != '') {
            if (Auth::user()->type != 'administrator') {
                $rows = Component::
                whereIn('subject_id', 
                    SectionsSubjects::select('subject_id')
                    ->where([
                        'teacher_id' => (new Staff)->get_column_via_user('id', $user),
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
            $res = Component::with([
                'subject' =>  function($q) { 
                    $q->select(['id', 'name']); 
                },
                'quarter' =>  function($q) { 
                    $q->select(['id', 'name']); 
                }
            ])->where('is_active', 1)->orderBy('order', 'ASC')->get();

            return $res->map(function($component) {
                return [
                    'componentID' => $component->id,
                    'componentPercentage' => $component->percentage,
                    'componentName' => $component->name,
                    'componentDescription' => $component->description,
                    'componentOrder' => $component->order,
                    'componentType' => $component->type,
                    'componentQuarter' => $component->quarter->name,
                    'componentSubject' => $component->subject->name,
                    'componentModified' => ($component->updated_at !== NULL) ? date('d-M-Y', strtotime($component->updated_at)).'<br/>'. date('h:i A', strtotime($component->updated_at)) : date('d-M-Y', strtotime($component->created_at)).'<br/>'. date('h:i A', strtotime($component->created_at))
                ];
            });
        }
        else
        {
            $res = Component::
            whereIn('subject_id', 
                SectionsSubjects::select('subject_id')
                ->where([
                    'teacher_id' => (new Staff)->get_column_via_user('id', Auth::user()->id),
                    'batch_id' => (new Batch)->get_current_batch(),
                    'is_active' => 1
                ])
            )
            ->with([
                'subject' =>  function($q) { 
                    $q->select(['id', 'name']); 
                },
                'quarter' =>  function($q) { 
                    $q->select(['id', 'name']); 
                }
            ])
            ->where('is_active', 1)
            ->orderBy('order', 'ASC')->get();

            return $res->map(function($component) {
                return [
                    'componentID' => $component->id,
                    'componentPercentage' => $component->percentage,
                    'componentName' => $component->name,
                    'componentDescription' => $component->description,
                    'componentOrder' => $component->order,
                    'componentType' => $component->type,
                    'componentQuarter' => $component->quarter->name,
                    'componentSubject' => $component->subject->name,
                    'componentModified' => ($component->updated_at !== NULL) ? date('d-M-Y', strtotime($component->updated_at)).'<br/>'. date('h:i A', strtotime($component->updated_at)) : date('d-M-Y', strtotime($component->created_at)).'<br/>'. date('h:i A', strtotime($component->created_at))
                ];
            });
        }
    }

    public function all_inactive(Request $request)
    {   
        if (Auth::user()->type == 'administrator') 
        { 
            $res = Component::with([
                'subject' =>  function($q) { 
                    $q->select(['id', 'name']); 
                },
                'quarter' =>  function($q) { 
                    $q->select(['id', 'name']); 
                }
            ])->where('is_active', 0)->orderBy('order', 'ASC')->get();

            return $res->map(function($component) {
                return [
                    'componentID' => $component->id,
                    'componentPercentage' => $component->percentage,
                    'componentName' => $component->name,
                    'componentDescription' => $component->description,
                    'componentOrder' => $component->order,
                    'componentType' => $component->type,
                    'componentQuarter' => $component->quarter->name,
                    'componentSubject' => $component->subject->name,
                    'componentModified' => ($component->updated_at !== NULL) ? date('d-M-Y', strtotime($component->updated_at)).'<br/>'. date('h:i A', strtotime($component->updated_at)) : date('d-M-Y', strtotime($component->created_at)).'<br/>'. date('h:i A', strtotime($component->created_at))
                ];
            });
        }
        else 
        {
            $res = Component::
            whereIn('subject_id', 
                SectionsSubjects::select('subject_id')
                ->where([
                    'teacher_id' => (new Staff)->get_column_via_user('id', Auth::user()->id),
                    'batch_id' => (new Batch)->get_current_batch(),
                    'is_active' => 1
                ])
            )
            ->with([
                'subject' =>  function($q) { 
                    $q->select(['id', 'name']); 
                },
                'quarter' =>  function($q) { 
                    $q->select(['id', 'name']); 
                }
            ])
            ->where('is_active', 0)
            ->orderBy('order', 'ASC')->get();

            return $res->map(function($component) {
                return [
                    'componentID' => $component->id,
                    'componentPercentage' => $component->percentage,
                    'componentName' => $component->name,
                    'componentDescription' => $component->description,
                    'componentOrder' => $component->order,
                    'componentType' => $component->type,
                    'componentQuarter' => $component->quarter->name,
                    'componentSubject' => $component->subject->name,
                    'componentModified' => ($component->updated_at !== NULL) ? date('d-M-Y', strtotime($component->updated_at)).'<br/>'. date('h:i A', strtotime($component->updated_at)) : date('d-M-Y', strtotime($component->created_at)).'<br/>'. date('h:i A', strtotime($component->created_at))
                ];
            });
        }
    }

    public function add(Request $request, $id = '')
    {   
        $menus = $this->load_menus();
        $segment = request()->segment(4);
        $component = (new Component)->fetch($id);
        $activities = (new Activity)->lookup('component_id', $id);
        $types = (new Component)->types();
        $quarters = (new Quarter)->all_quarters();
        $subjects = (new Subject)->all_subjects();
        $sections = (new Section)->all_sections();
        return view('modules/academics/gradingsheets/components/add')->with(compact('menus', 'component', 'segment', 'quarters', 'subjects', 'activities', 'types', 'sections'));
    }
    
    public function edit(Request $request, $id)
    {   
        $this->validated(Auth::user()->id, $id);
        $menus = $this->load_menus();
        $segment = request()->segment(4);
        $component = (new Component)->fetch($id);
        $activities = (new Activity)->lookup('component_id', $id);
        $types = (new Component)->types();
        $quarters = (new Quarter)->all_quarters();
        $subjects = (new Subject)->all_subjects();
        $sections = (new Section)->all_sections();
        return view('modules/academics/gradingsheets/components/edit')->with(compact('menus', 'component', 'segment', 'quarters', 'subjects', 'activities', 'types', 'sections'));
    }
    
    public function store(Request $request)
    {    
        $timestamp = date('Y-m-d H:i:s');

        $count = Component::all()->count() + 1;

        $component = Component::create([
            'batch_id' => (new Batch)->get_current_batch(),
            'quarter_id' => $request->quarter_id,
            'section_id' => $request->section_id,
            'subject_id' => $request->subject_id,
            'percentage' => $request->percentage,
            'type' => $request->type,
            'name' => $request->name,
            'description' => $request->description,
            'palette' => $request->palette,
            'order' => $count,
            'is_sum_cell' => ($request->is_sum_cell !== NULL) ? 1 : 0,
            'is_hps_cell' => ($request->is_hps_cell !== NULL) ? 1 : 0,
            'is_ps_cell' => ($request->is_ps_cell !== NULL) ? 1 : 0,
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);

        /*
            if (!empty($request->activity_name)) {
                $activities = $request->activity_name; $iteration = 0;
                foreach ($activities as $activity) {
                    if ($activity !== NULL) {
                        $activity = Activity::create([
                            'component_id' => $component->id,
                            'activity' => $request->activity_name[$iteration],
                            'value' => $request->activity_value[$iteration],
                            'description' => $request->activity_description[$iteration],
                            'created_at' => $timestamp,
                            'created_by' => Auth::user()->id
                        ]);
                    }
                    $iteration++;
                }
            }
        */

        if (!$component) {
            throw new NotFoundHttpException();
        }

        $data = array(
            'title' => 'Well done!',
            'text' => 'The component has been successfully saved.',
            'type' => 'success',
            'class' => 'btn-brand'
        );

        echo json_encode( $data ); exit();
    }

    public function update(Request $request, $id)
    {    
        $timestamp = date('Y-m-d H:i:s');

        $component = Component::find($id);

        if(!$component) {
            throw new NotFoundHttpException();
        }

        if (Auth::user()->type == 'administrator') {
            $component->quarter_id = $request->quarter_id;
            $component->section_id = $request->section_id;
            $component->subject_id = $request->subject_id;
            $component->percentage = $request->percentage;
            $component->type = $request->type;
            $component->name = $request->name;
            $component->description = $request->description;
            $component->palette = $request->palette;
            $component->is_sum_cell = ($request->is_sum_cell !== NULL) ? 1 : 0;
            $component->is_hps_cell = ($request->is_hps_cell !== NULL) ? 1 : 0;
            $component->is_ps_cell = ($request->is_ps_cell !== NULL) ? 1 : 0;
            $component->updated_at = $timestamp;
            $component->updated_by = Auth::user()->id;
            $component->update();
        } else {
            Activity::where('component_id', $id)->update(['is_active' => 0]);
            if (!empty($request->activity_name)) {
                $activities = $request->activity_name; $iteration = 0;
                $activity_components = Activity::where('component_id', $component->id)->orderBy('id', 'ASC')->get();
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
                            } else {
                                $activity_component = Activity::create([
                                    'component_id' => $component->id,
                                    'activity' => $request->activity_name[$iteration],
                                    'value' => $request->activity_value[$iteration],
                                    'description' => $request->activity_description[$iteration],
                                    'created_at' => $timestamp,
                                    'created_by' => Auth::user()->id
                                ]);
                            }
                        } else {
                            $activity_component = Activity::create([
                                'component_id' => $component->id,
                                'activity' => $request->activity_name[$iteration],
                                'value' => $request->activity_value[$iteration],
                                'description' => $request->activity_description[$iteration],
                                'created_at' => $timestamp,
                                'created_by' => Auth::user()->id
                            ]);
                        }
                    }
                    $iteration++;
                }
            }
        }

        $data = array(
            'title' => 'Well done!',
            'text' => 'The component has been successfully updated.',
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
            $components = Component::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 0
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The component has been successfully removed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        } 
        else if ($action == 'Up') {
            $components = Component::find($id);

            $components2 = Component::where([
                'order' => ($components->order - 1),
            ])
            ->update([
                'order' => $components->order,
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id
            ]);

            $components->order = ($components->order - 1);
            $components->updated_at = $timestamp;
            $components->updated_by = Auth::user()->id;
            $components->update();
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The component has been successfully removed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        } 
        else if ($action == 'Down') {
            $components = Component::find($id);

            $components2 = Component::where([
                'order' => ($components->order + 1),
            ])
            ->update([
                'order' => $components->order,
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id
            ]);

            $components->order = ($components->order + 1);
            $components->updated_at = $timestamp;
            $components->updated_by = Auth::user()->id;
            $components->update();
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The component has been successfully removed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );

            echo json_encode( $data ); exit();
        }         
        else {
            $batches = Component::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 1
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The component has been successfully activated.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }   
    }

}