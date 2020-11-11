<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\SectionInfo;
use App\Models\Batch;
use App\Models\EducationType;
use App\Models\QuarterEducationType;
use App\Models\GradingSheetQuarter;
use App\Models\Admission;
use Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\File;
use App\Components\FlashMessages;
use App\Helper\Helper;

class ReportCardController extends Controller
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

    public function is_permitted($permission)
    {
        $privileges = explode(',', strtolower(Helper::get_privileges()));
        if (!$privileges[$permission] == 1) {
            return abort(404);
        }
    }

    public function export(Request $request)
    {   
        $this->is_permitted(1);
        $menus = $this->load_menus();
        $types = (new EducationType)->all_education_types();
        $batches = (new Batch)->all_batches();
        $sections = (new SectionInfo)->all_classes();
        $students = ['' => 'select a student'];
        return view('modules/academics/gradingsheets/reportcard/manage')->with(compact('menus', 'types', 'batches', 'sections', 'students'));
    }

    public function export_view(Request $request)
    { 
        $this->is_permitted(1);
        $menus = $this->load_menus();

        $students = (new Admission)
        ->with([
            'student' =>  function($q) { 
                $q->select(['id', 'firstname', 'middlename', 'lastname', 'gender', 'identification_no', 'learners_reference_no']);
            },
            'batch' => function($q) {
                $q->select(['id', 'code', 'name', 'description']);
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
            'subjects' =>  function($q) { 
                $q->select(['sections_subjects.id', 'sections_subjects.section_info_id', 'subjects.id as subject_id', 'subjects.name as subject_name', 'subjects.material_id as material' , 'subjects.is_mapeh as is_mapeh', 'subjects.is_tle as is_tle'])
                ->join('subjects', function($join)
                {
                    $join->on('subjects.id', '=', 'sections_subjects.subject_id');
                });
            },
        ])
        ->where([
            'batch_id' => $request->get('batch_id'), 
            'section_info_id' => $request->get('section_info_id'),
            'student_id' => $request->get('student_id'),
            'is_active' => 1
        ])
        ->orderBy('id', 'ASC')->get();

        $quarters = (new QuarterEducationType)->all_quarters_via_type($request->get('type_id'));
        $batch = $request->get('batch_id');
        $type = $request->get('type_id');

        return view('modules/academics/gradingsheets/reportcard/view')->with(compact('menus', 'students', 'quarters', 'batch', 'type'));
    }

    public function reload_classes(Request $request)
    {   
        if ($request->get('batch') !== NULL && $request->get('type') !== NULL) {
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
                'batch_id' => $request->get('batch'), 
                'education_type_id' => $request->get('type'),
                'is_active' => 1
            ])
            ->orderBy('id', 'ASC')->get();

            $arr['sections'] = $res->map(function($class) {
                return [
                    'id' => $class->id,
                    'name' => $class->level->name.' - '.$class->section->name
                ];
            });
        } 
        else {
            if ($request->get('batch') !== NULL) {
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
                    'batch_id' => $request->get('batch'), 
                    'is_active' => 1
                ])
                ->orderBy('id', 'ASC')->get();

                $arr['sections'] = $res->map(function($class) {
                    return [
                        'id' => $class->id,
                        'name' => $class->level->name.' - '.$class->section->name
                    ];
                });
            } else {
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
                    'education_type_id' => $request->get('type'),
                    'is_active' => 1
                ])
                ->orderBy('id', 'ASC')->get();

                $arr['sections'] = $res->map(function($class) {
                    return [
                        'id' => $class->id,
                        'name' => $class->level->name.' - '.$class->section->name
                    ];
                });
            }
        }

        echo json_encode( $arr ); exit();
    }

    public function reload_students(Request $request)
    {   
        if ($request->get('batch') !== NULL && $request->get('section') !== NULL) {
            $res = (new Admission)
            ->with([
                'student' =>  function($q) { 
                    $q->select(['id', 'firstname', 'middlename', 'lastname']);
                }
            ])
            ->where([
                'batch_id' => $request->get('batch'), 
                'section_info_id' => $request->get('section'),
                'is_active' => 1
            ])
            ->groupBy('student_id')
            ->orderBy('id', 'ASC')->get();

            $arr['students'] = $res->map(function($stud) {
                $middlename = ($stud->student->middlename !== NULL) ? ucwords($stud->student->middlename) : '';
                return [
                    'id' => $stud->student->id,
                    'name' => ucwords($stud->student->lastname).', '.ucwords($stud->student->firstname). ' '.$middlename
                ];
            });
        } 
        else {
            if ($request->get('batch') !== NULL) {
                $res = (new Admission)
                ->with([
                    'student' =>  function($q) { 
                        $q->select(['id', 'firstname', 'middlename', 'lastname']);
                    }
                ])
                ->where([
                    'batch_id' => $request->get('batch'), 
                    'is_active' => 1
                ])
                ->groupBy('student_id')
                ->orderBy('id', 'ASC')->get();

                $arr['students'] = $res->map(function($stud) {
                    $middlename = ($stud->student->middlename !== NULL) ? ucwords($stud->student->middlename) : '';
                    return [
                        'id' => $stud->student->id,
                        'name' => ucwords($stud->student->lastname).', '.ucwords($stud->student->firstname). ' '.$middlename
                    ];
                });
            } else {
                $res = (new Admission)
                ->with([
                    'student' =>  function($q) { 
                        $q->select(['id', 'firstname', 'middlename', 'lastname']);
                    }
                ])
                ->where([
                    'section_info_id' => $request->get('section'),
                    'is_active' => 1
                ])
                ->groupBy('student_id')
                ->orderBy('id', 'ASC')->get();

                $arr['students'] = $res->map(function($stud) {
                    $middlename = ($stud->student->middlename !== NULL) ? ucwords($stud->student->middlename) : '';
                    return [
                        'id' => $stud->student->id,
                        'name' => ucwords($stud->student->lastname).', '.ucwords($stud->student->firstname). ' '.$middlename
                    ];
                });
            }
        }

        echo json_encode( $arr ); exit();
    }

    public function get_column_grade($column, $type, $batch, $quarter, $section, $subject, $student, $material)
    {
        $res = (new GradingSheetQuarter)->get_column_grade($column, $type, $batch, $quarter, $section, $subject, $student, $material);
        return $res;
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
