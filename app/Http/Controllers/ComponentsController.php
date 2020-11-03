<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Component;
use App\Models\ComponentQuarter;
use App\Models\ComponentSubject;
use App\Models\Activity;
use App\Models\Batch;
use App\Models\Quarter;
use App\Models\Subject;
use App\Models\UserRole;
use App\Models\Staff;
use App\Models\SectionsSubjects;
use App\Models\SectionInfo;
use App\Models\Section;
use App\Models\EducationType;
use App\Models\QuarterEducationType;
use App\Models\AuditLog;
use Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\File;
use App\Components\FlashMessages;
use App\Helper\Helper;

class ComponentsController extends Controller
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
        return view('modules/academics/gradingsheets/components/manage')->with(compact('menus'));
    }

    public function manage(Request $request)
    {   
        $this->is_permitted(1);
        $menus = $this->load_menus();
        return view('modules/academics/gradingsheets/components/manage')->with(compact('menus'));
    }

    public function inactive(Request $request)
    {   
        $this->is_permitted(1);
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
                'subjects' =>  function($q) { 
                    $q->select(['components_subjects.id', 'components_subjects.component_id', 'components_subjects.subject_id', 'subjects.name'])->join('subjects', function($join)
                    {
                        $join->on('subjects.id', '=', 'components_subjects.subject_id');
                    });
                },
                'quarters' =>  function($q) { 
                    $q->select(['components_quarters.id', 'components_quarters.component_id', 'components_quarters.quarter_id', 'quarters.name'])->join('quarters', function($join)
                    {
                        $join->on('quarters.id', '=', 'components_quarters.quarter_id');
                    });
                },
                'section_info' =>  function($q) { 
                    $q->select(['sections_info.id', 'levels.name as level' , 'sections.name as section'])
                    ->join('levels', function($join)
                    {
                        $join->on('levels.id', '=', 'sections_info.level_id');
                    })
                    ->join('sections', function($join)
                    {
                        $join->on('sections.id', '=', 'sections_info.section_id');
                    });
                },
                'edtype' =>  function($q) { 
                    $q->select(['id', 'name']); 
                }
            ])
            ->where([
                'batch_id' => (new Batch)->get_current_batch(),
                'is_active' => 1
            ])->orderBy('order', 'ASC')->get();

            return $res->map(function($component) {
                return [
                    'componentID' => $component->id,
                    'componentPercentage' => $component->percentage,
                    'componentName' => $component->name,
                    'componentDescription' => $component->description,
                    'componentOrder' => $component->order,
                    'componentTypeID' => $component->edtype->id,
                    'componentType' => $component->edtype->name,
                    'componentType' => $component->edtype->name,
                    'componentClass' => $component->section_info->level.' - '.$component->section_info->section,
                    'componentQuarter' => $component->quarters->map(function($a, $iteration=0) { 
                        $iteration++;
                        if ($iteration > 1) {
                            return '<br/>'.$a->name;
                        }  else {
                            return $a->name;
                        }
                    }),
                    'componentSubject' => $component->subjects->map(function($a) { return $a->name; }),
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
                'subjects' =>  function($q) { 
                    $q->select(['components_subjects.id', 'components_subjects.component_id', 'components_subjects.subject_id', 'subjects.name'])->join('subjects', function($join)
                    {
                        $join->on('subjects.id', '=', 'components_subjects.subject_id');
                    });
                },
                'quarters' =>  function($q) { 
                    $q->select(['components_quarters.id', 'components_quarters.component_id', 'components_quarters.quarter_id', 'quarters.name'])->join('quarters', function($join)
                    {
                        $join->on('quarters.id', '=', 'components_quarters.quarter_id');
                    });
                },
                'section_info' =>  function($q) { 
                    $q->select(['sections_info.id', 'levels.name as level' , 'sections.name as section'])
                    ->join('levels', function($join)
                    {
                        $join->on('levels.id', '=', 'sections_info.level_id');
                    })
                    ->join('sections', function($join)
                    {
                        $join->on('sections.id', '=', 'sections_info.section_id');
                    });
                },
                'edtype' =>  function($q) { 
                    $q->select(['id', 'name']); 
                }
            ])
            ->where([
                'batch_id' => (new Batch)->get_current_batch(),
                'is_active' => 1
            ])
            ->orderBy('order', 'ASC')->get();

            return $res->map(function($component) {
                return [
                    'componentID' => $component->id,
                    'componentPercentage' => $component->percentage,
                    'componentName' => $component->name,
                    'componentDescription' => $component->description,
                    'componentOrder' => $component->order,
                    'componentTypeID' => $component->edtype->id,
                    'componentType' => $component->edtype->name,
                    'componentType' => $component->edtype->name,
                    'componentClass' => $component->section_info->level.' - '.$component->section_info->section,
                    'componentQuarter' => $component->quarters->map(function($a, $iteration=0) { 
                        $iteration++;
                        if ($iteration > 1) {
                            return '<br/>'.$a->name;
                        }  else {
                            return $a->name;
                        }
                    }),
                    'componentSubject' => $component->subjects->map(function($a) { return $a->name; }),
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
                'subjects' =>  function($q) { 
                    $q->select(['components_subjects.id', 'components_subjects.component_id', 'components_subjects.subject_id', 'subjects.name'])->join('subjects', function($join)
                    {
                        $join->on('subjects.id', '=', 'components_subjects.subject_id');
                    });
                },
                'quarters' =>  function($q) { 
                    $q->select(['components_quarters.id', 'components_quarters.component_id', 'components_quarters.quarter_id', 'quarters.name'])->join('quarters', function($join)
                    {
                        $join->on('quarters.id', '=', 'components_quarters.quarter_id');
                    });
                },
                'section_info' =>  function($q) { 
                    $q->select(['sections_info.id', 'levels.name as level' , 'sections.name as section'])
                    ->join('levels', function($join)
                    {
                        $join->on('levels.id', '=', 'sections_info.level_id');
                    })
                    ->join('sections', function($join)
                    {
                        $join->on('sections.id', '=', 'sections_info.section_id');
                    });
                },
                'edtype' =>  function($q) { 
                    $q->select(['id', 'name']); 
                }
            ])
            ->where([
                'batch_id' => (new Batch)->get_current_batch(),
                'is_active' => 0
            ])
            ->orderBy('order', 'ASC')->get();

            return $res->map(function($component) {
                return [
                    'componentID' => $component->id,
                    'componentPercentage' => $component->percentage,
                    'componentName' => $component->name,
                    'componentDescription' => $component->description,
                    'componentOrder' => $component->order,
                    'componentTypeID' => $component->edtype->id,
                    'componentType' => $component->edtype->name,
                    'componentType' => $component->edtype->name,
                    'componentClass' => $component->section_info->level.' - '.$component->section_info->section,
                    'componentQuarter' => $component->quarters->map(function($a, $iteration=0) { 
                        $iteration++;
                        if ($iteration > 1) {
                            return '<br/>'.$a->name;
                        }  else {
                            return $a->name;
                        }
                    }),
                    'componentSubject' => $component->subjects->map(function($a) { return $a->name; }),
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
                'subjects' =>  function($q) { 
                    $q->select(['components_subjects.id', 'components_subjects.component_id', 'components_subjects.subject_id', 'subjects.name'])->join('subjects', function($join)
                    {
                        $join->on('subjects.id', '=', 'components_subjects.subject_id');
                    });
                },
                'quarters' =>  function($q) { 
                    $q->select(['components_quarters.id', 'components_quarters.component_id', 'components_quarters.quarter_id', 'quarters.name'])->join('quarters', function($join)
                    {
                        $join->on('quarters.id', '=', 'components_quarters.quarter_id');
                    });
                },
                'section_info' =>  function($q) { 
                    $q->select(['sections_info.id', 'levels.name as level' , 'sections.name as section'])
                    ->join('levels', function($join)
                    {
                        $join->on('levels.id', '=', 'sections_info.level_id');
                    })
                    ->join('sections', function($join)
                    {
                        $join->on('sections.id', '=', 'sections_info.section_id');
                    });
                },
                'edtype' =>  function($q) { 
                    $q->select(['id', 'name']); 
                }
            ])
            ->where([
                'batch_id' => (new Batch)->get_current_batch(),
                'is_active' => 0
            ])
            ->orderBy('order', 'ASC')->get();

            return $res->map(function($component) {
                return [
                    'componentID' => $component->id,
                    'componentPercentage' => $component->percentage,
                    'componentName' => $component->name,
                    'componentDescription' => $component->description,
                    'componentOrder' => $component->order,
                    'componentTypeID' => $component->edtype->id,
                    'componentType' => $component->edtype->name,
                    'componentType' => $component->edtype->name,
                    'componentClass' => $component->section_info->level.' - '.$component->section_info->section,
                    'componentQuarter' => $component->quarters->map(function($a, $iteration=0) { 
                        $iteration++;
                        if ($iteration > 1) {
                            return '<br/>'.$a->name;
                        }  else {
                            return $a->name;
                        }
                    }),
                    'componentSubject' => $component->subjects->map(function($a) { return $a->name; }),
                    'componentModified' => ($component->updated_at !== NULL) ? date('d-M-Y', strtotime($component->updated_at)).'<br/>'. date('h:i A', strtotime($component->updated_at)) : date('d-M-Y', strtotime($component->created_at)).'<br/>'. date('h:i A', strtotime($component->created_at))
                ];
            });
        }
    }

    public function add(Request $request, $id = '')
    {   
        $this->is_permitted(0);
        $menus = $this->load_menus();
        $segment = request()->segment(4);
        $component = (new Component)->fetch($id);
        $activities = (new Activity)->lookup('component_id', $id);
        $types = (new EducationType)->all_education_types();
        $quarters = (new Quarter)->all_quarters();
        $subjects = (new Subject)->all_subjects_selectpicker();
        $sections = (new SectionInfo)->all_classes();
        return view('modules/academics/gradingsheets/components/add')->with(compact('menus', 'component', 'segment', 'quarters', 'subjects', 'activities', 'types', 'sections'));
    }
    
    public function edit(Request $request, $id)
    {   
        $this->is_permitted(2);
        $this->validated(Auth::user()->id, $id);
        $menus = $this->load_menus();
        $segment = request()->segment(4);
        $component = (new Component)->fetch($id);
        $activities = (new Activity)->lookup('component_id', $id);
        $types = (new EducationType)->all_education_types();
        $quarters = (new Component)->all_quarters($id);
        $subjects = (new Subject)->all_subjects_selectpicker($id);
        $sections = (new SectionInfo)->all_classes();
        return view('modules/academics/gradingsheets/components/edit')->with(compact('menus', 'component', 'segment', 'quarters', 'subjects', 'activities', 'types', 'sections'));
    }
    
    public function store(Request $request)
    {    
        $this->is_permitted(0);
        $timestamp = date('Y-m-d H:i:s');

        $count = Component::all()->count() + 1;

        $component = Component::create([
            'batch_id' => (new Batch)->get_current_batch(),
            'section_info_id' => $request->section_info_id,
            'percentage' => $request->percentage,
            'education_type_id' => $request->education_type_id,
            'material_id' => (new Subject)->where('id', $request->subject_id)->first()->material_id,
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

        foreach ($request->subject_id as $subject) {
            $component_subject = ComponentSubject::create([
                'component_id' => $component->id,
                'batch_id' => (new Batch)->get_current_batch(),
                'subject_id' => $subject,
                'created_at' => $timestamp,
                'created_by' => Auth::user()->id
            ]);
            $this->audit_logs('components_subjects', $component_subject->id, 'has inserted a new component quarter.', ComponentSubject::find($component_subject->id), $timestamp, Auth::user()->id);
        }

        foreach ($request->quarter_id as $quarter) {
            $component_quarter = ComponentQuarter::create([
                'component_id' => $component->id,
                'batch_id' => (new Batch)->get_current_batch(),
                'quarter_id' => $quarter,
                'created_at' => $timestamp,
                'created_by' => Auth::user()->id
            ]);
            $this->audit_logs('components_quarters', $component_quarter->id, 'has inserted a new component quarter.', ComponentQuarter::find($component_quarter->id), $timestamp, Auth::user()->id);
        }

        foreach ($request->quarter_id as $quarter) {
            foreach ($request->subject_id as $subject) {
                $material = Subject::where('id', $subject)->pluck('material_id')[0];
                if ($material == 1) {
                    $activitiesCount = 10; $iteration = 1;
                    while ($activitiesCount != 0) {
                        $activity = Activity::create([
                            'component_id' => $component->id,
                            'quarter_id' => $quarter,
                            'subject_id' => $subject,
                            'activity' => 'A'.$iteration,
                            'value' => NULL,
                            'description' => 'Activity '.$iteration,
                            'created_at' => $timestamp,
                            'created_by' => Auth::user()->id
                        ]);
                        $this->audit_logs('activities', $activity->id, 'has generated a new component activity.', Activity::find($activity->id), $timestamp, Auth::user()->id);

                        $iteration++; $activitiesCount--;
                    }
                }
                else if ($material == 2) {
                    $activitiesCount = 10; $iteration = 1;
                    $conducts = array(
                        "affirms one's faith by doing what is good and right",
                        "shows honesty in dealing with others",
                        "completes the assigned tasks promptly",
                        "shares blessings with the less fortunate",
                        "shows consistency in doing good to others",
                        "maintains cleanliness or orderliness of the surroundings",
                        "promotes and develops Filipino values and traditions",
                        "respects people in the community",
                        "shows concern to school properties",
                        "demostrates discipline by working conscientiously",
                    );
                    while ($activitiesCount != 0) {
                        $activity = Activity::create([
                            'component_id' => $component->id,
                            'quarter_id' => $quarter,
                            'subject_id' => $subject,
                            'activity' => 'C'.$iteration,
                            'value' => 4,
                            'description' => $conducts[$iteration-1],
                            'created_at' => $timestamp,
                            'created_by' => Auth::user()->id
                        ]);
                        $this->audit_logs('activities', $activity->id, 'has generated a new component activity.', Activity::find($activity->id), $timestamp, Auth::user()->id);

                        $iteration++; $activitiesCount--;
                    }
                }
            }
        }

        if (!$component) {
            throw new NotFoundHttpException();
        }

        $this->audit_logs('components', $component->id, 'has inserted a new component.', Component::find($component->id), $timestamp, Auth::user()->id);

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
        $this->is_permitted(2);
        $timestamp = date('Y-m-d H:i:s');

        $component = Component::find($id);

        if(!$component) {
            throw new NotFoundHttpException();
        }

        if (Auth::user()->type == 'administrator') {
            $component->section_info_id = $request->section_info_id;
            $component->percentage = $request->percentage;
            $component->education_type_id = $request->education_type_id;
            $component->material_id = (new Subject)->where('id', $request->subject_id)->first()->material_id;
            $component->name = $request->name;
            $component->description = $request->description;
            $component->palette = $request->palette;
            $component->is_sum_cell = ($request->is_sum_cell !== NULL) ? 1 : 0;
            $component->is_hps_cell = ($request->is_hps_cell !== NULL) ? 1 : 0;
            $component->is_ps_cell = ($request->is_ps_cell !== NULL) ? 1 : 0;
            $component->updated_at = $timestamp;
            $component->updated_by = Auth::user()->id;
            $component->update();

            ComponentSubject::where('component_id', $id)->update(['updated_at' => $timestamp, 'updated_by' => Auth::user()->id,'is_active' => 0]);
            foreach ($request->subject_id as $subject) {
                $component_subject = ComponentSubject::where(['component_id' => $id, 'subject_id' => $subject])
                ->update([
                    'component_id' => $component->id,
                    'subject_id' => $subject,
                    'updated_at' => $timestamp,
                    'updated_by' => Auth::user()->id,
                    'is_active' => 1
                ]);
                $component_subject = ComponentSubject::where(['component_id' => $id, 'subject_id' => $subject, 'is_active' => 1])->get();
                if ($component_subject->count() > 0) {
                    $this->audit_logs('components_subjects', $component_subject->first()->id, 'has modified a component subject.', ComponentSubject::find($component_subject->first()->id), $timestamp, Auth::user()->id);
                } else {
                    $component_subject = ComponentSubject::create([
                        'component_id' => $component->id,
                        'batch_id' => (new Batch)->get_current_batch(),
                        'subject_id' => $subject,
                        'created_at' => $timestamp,
                        'created_by' => Auth::user()->id
                    ]);
                    $this->audit_logs('components_subjects', $component_subject->id, 'has inserted a new component subject.', ComponentSubject::find($component_subject->id), $timestamp, Auth::user()->id);
                }
            }

            ComponentQuarter::where('component_id', $id)->update(['updated_at' => $timestamp, 'updated_by' => Auth::user()->id,'is_active' => 0]);
            foreach ($request->quarter_id as $quarter) {
                $component_quarter = ComponentQuarter::where(['component_id' => $id, 'quarter_id' => $quarter])
                ->update([
                    'component_id' => $component->id,
                    'quarter_id' => $quarter,
                    'updated_at' => $timestamp,
                    'updated_by' => Auth::user()->id,
                    'is_active' => 1
                ]);
                $component_quarter = ComponentQuarter::where(['component_id' => $id, 'quarter_id' => $quarter, 'is_active' => 1])->get();
                if ($component_quarter->count() > 0) {
                    $this->audit_logs('components_quarters', $component_quarter->first()->id, 'has modified a component quarter.', ComponentQuarter::find($component_quarter->first()->id), $timestamp, Auth::user()->id);
                } else {
                    $component_quarter = ComponentQuarter::create([
                        'component_id' => $component->id,
                        'batch_id' => (new Batch)->get_current_batch(),
                        'quarter_id' => $quarter,
                        'created_at' => $timestamp,
                        'created_by' => Auth::user()->id
                    ]);
                    $this->audit_logs('components_quarters', $component_quarter->id, 'has inserted a new component quarter.', ComponentQuarter::find($component_quarter->id), $timestamp, Auth::user()->id);
                }
            }

            $this->audit_logs('components', $id, 'has modified a component.', Component::find($id), $timestamp, Auth::user()->id);
            
        } else {
            // Activity::where('component_id', $id)->update(['is_active' => 0]);
            // if (!empty($request->activity_name)) {
            //     $activities = $request->activity_name; $iteration = 0;
            //     $activity_components = Activity::where('component_id', $component->id)->orderBy('id', 'ASC')->get();
            //     foreach ($activities as $activity) 
            //     {
            //         if ($activity !== NULL) {
            //             if ($activity_components->count() > 0 && $activity_components->count() > $iteration) {
            //                 if ($activity_components[$iteration]->id !== NULL) {
            //                     $activity_component = Activity::where('id', $activity_components[$iteration]->id)
            //                     ->update([
            //                         'activity' => $request->activity_name[$iteration],
            //                         'value' => $request->activity_value[$iteration],
            //                         'description' => $request->activity_description[$iteration],
            //                         'updated_at' => $timestamp,
            //                         'updated_by' => Auth::user()->id,
            //                         'is_active' => 1
            //                     ]);
            //                     $this->audit_logs('activities', $activity_components[$iteration]->id, 'has modified a component activity.', Activity::find($activity_components[$iteration]->id), $timestamp, Auth::user()->id);
            //                 } else {
            //                     $activity_component = Activity::create([
            //                         'component_id' => $component->id,
            //                         'activity' => $request->activity_name[$iteration],
            //                         'value' => $request->activity_value[$iteration],
            //                         'description' => $request->activity_description[$iteration],
            //                         'created_at' => $timestamp,
            //                         'created_by' => Auth::user()->id
            //                     ]);
            //                     $this->audit_logs('activities', $activity_component->id, 'has inserted a new component activity.', Activity::find($activity_component->id), $timestamp, Auth::user()->id);
            //                 }
            //             } else {
            //                 $activity_component = Activity::create([
            //                     'component_id' => $component->id,
            //                     'activity' => $request->activity_name[$iteration],
            //                     'value' => $request->activity_value[$iteration],
            //                     'description' => $request->activity_description[$iteration],
            //                     'created_at' => $timestamp,
            //                     'created_by' => Auth::user()->id
            //                 ]);
            //                 $this->audit_logs('activities', $activity_component->id, 'has inserted a new component activity.', Activity::find($activity_component->id), $timestamp, Auth::user()->id);
            //             }
            //         }
            //         $iteration++;
            //     }
            // }
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
        $this->is_permitted(3);
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
            $this->audit_logs('components', $id, 'has removed a component.', Component::find($id), $timestamp, Auth::user()->id);
            
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
            $this->audit_logs('components', $id, 'has retrieved a component.', Component::find($id), $timestamp, Auth::user()->id);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The component has been successfully activated.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }   
    }

    public function reload_quarter($type)
    {
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

        echo json_encode( $arr ); exit();
    }

    public function reload_subject($section)
    {
        $arr['subjects'] = (new Subject)
        ->whereIn('id',
            SectionsSubjects::select('subject_id')
            ->whereIn('section_info_id', 
                SectionInfo::select('id')->where([
                    'batch_id' => (new Batch)->get_current_batch(), 
                    'is_active' => 1,
                    'section_info_id' => $section
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