<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Section;
use App\Models\Level;
use App\Models\Subject;
use App\Models\Staff;
use App\Models\Admission;
use App\Models\Quarter;
use App\Models\EducationType;
use App\Models\AuditLog;
use App\Helper\Helper;

class SectionsController extends Controller
{
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
        return view('modules/academics/sections/manage')->with(compact('menus'));
    }

    public function manage(Request $request)
    {   
        $this->is_permitted(1);
        $menus = $this->load_menus();
        return view('modules/academics/sections/manage')->with(compact('menus'));
    }

    public function inactive(Request $request)
    {   
        $this->is_permitted(1);
        $menus = $this->load_menus();
        return view('modules/academics/sections/inactive')->with(compact('menus'));
    }

    public function all_active(Request $request)
    {
        $res = Section::
        with([
            'edtype' =>  function($q) { 
                $q->select(['id', 'name']); 
            }
        ])
        ->where('is_active', 1)->orderBy('id', 'DESC')->get();

        return $res->map(function($section) {
            return [
                'sectionID' => $section->id,
                'sectionCode' => $section->code,
                'sectionName' => $section->name,
                'sectionDescription' => $section->description,
                'sectionModified' => ($section->updated_at !== NULL) ? date('d-M-Y', strtotime($section->updated_at)).'<br/>'. date('h:i A', strtotime($section->updated_at)) : date('d-M-Y', strtotime($section->created_at)).'<br/>'. date('h:i A', strtotime($section->created_at)),
                'sectionTypeID' => $section->edtype->id,
                'sectionType' => $section->edtype->name,
            ];
        });
    }

    public function all_inactive(Request $request)
    {
        $res = Section::
        with([
            'edtype' =>  function($q) { 
                $q->select(['id', 'name']); 
            }
        ])
        ->where('is_active', 0)->orderBy('id', 'DESC')->get();

        return $res->map(function($section) {
            return [
                'sectionID' => $section->id,
                'sectionCode' => $section->code,
                'sectionName' => $section->name,
                'sectionDescription' => $section->description,
                'sectionModified' => ($section->updated_at !== NULL) ? date('d-M-Y', strtotime($section->updated_at)).'<br/>'. date('h:i A', strtotime($section->updated_at)) : date('d-M-Y', strtotime($section->created_at)).'<br/>'. date('h:i A', strtotime($section->created_at)),
                'sectionTypeID' => $section->edtype->id,
                'sectionType' => $section->edtype->name,
            ];
        });
    }

    public function add(Request $request, $id = '')
    {   
        $this->is_permitted(0);
        $menus = $this->load_menus();
        $flashMessage = self::messages();
        $segment = request()->segment(4);
        
        $subjects = (new Subject)->all_subjects();
        $admitted = (new Admission)->all_admitted_student();
        $types = (new EducationType)->all_education_types();
        $levels = (new Level)->get_all_levels();
        $staffs = Staff::select('id', 'lastname', 'firstname', 'middlename', 'identification_no')->where('type','Teacher')->orderBy('lastname', 'asc')->get();
        
        $sections_subjects = 0;
        $stfs = array();
        $stfs[] = array('' => 'select a teacher');
        foreach ($staffs as $staff) {
            $stfs[] = array(
                $staff->id => $staff->lastname.', '.$staff->firstname.' '.$staff->firstname.' ('.$staff->identification_no.')'
            );
        }

        $staffs = array();
        foreach($stfs as $stf) {
            foreach($stf as $key => $val) {
                $staffs[$key] = $val;
            }
        }

        $section = (new Section)->fetch($id);
        return view('modules/academics/sections/add')->with(compact('menus', 'types', 'section', 'levels', 'sections_subjects', 'admitted', 'staffs', 'subjects', 'segment', 'flashMessage'));
    }
    
    public function edit(Request $request, $id)
    {   
        $this->is_permitted(2);
        $menus = $this->load_menus();
        $flashMessage = self::messages();
        $segment = request()->segment(4);

        $allSubjects = Subject::all();
        $allTeachers = Staff::where('is_active', 1)->where('type','Teacher')->orderBy('lastname', 'asc')->get();
        $types = (new EducationType)->all_education_types();
        $levels = (new Level)->get_all_levels();
        $subjects = (new Subject)->all_subjects();

        $staffs = Staff::select('id', 'lastname', 'firstname', 'middlename', 'identification_no')->where('is_active', 1)->where('type','Teacher')->orderBy('lastname', 'asc')->get();
        $stfs = array();
        $stfs[] = array('' => 'select a teacher');
        foreach ($staffs as $staff) {
            $stfs[] = array(
                $staff->id => $staff->lastname.', '.$staff->firstname.' '.$staff->firstname.' ('.$staff->identification_no.')'
            );
        }
        
        $staffs = array();
        foreach($stfs as $stf) {
            foreach($stf as $key => $val) {
                $staffs[$key] = $val;
            }
        }

        $section = (new Section)->find($id);

        return view('modules/academics/sections/edit')->with(compact('menus', 'types', 'section', 'levels', 'allTeachers', 'allSubjects', 'staffs', 'subjects', 'segment', 'flashMessage'));

    }
    
    public function store(Request $request)
    {   
        $this->is_permitted(0);
        $timestamp = date('Y-m-d H:i:s');

        $section = Section::create([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'education_type_id' => $request->type,
            'level_id' => $request->level,
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);
        
        $this->audit_logs('sections', $section->id, 'has inserted a new section.', Section::find($section->id), $timestamp, Auth::user()->id);

        $data = array(
            'title' => 'Well done!',
            'text' => 'The section has been successfully saved.',
            'type' => 'success',
            'class' => 'btn-brand'
        );

        echo json_encode( $data ); exit();

    }

    public function update(Request $request, $id)
    {   
        $this->is_permitted(2);
        $timestamp = date('Y-m-d H:i:s');
        $section = Section::find($id);

        if(!$section) {
            throw new NotFoundHttpException();
        }

        $section->code = $request->code;
        $section->name = $request->name;
        $section->description = $request->description;
        $section->education_type_id = $request->type;
        $section->level_id = $request->level;
        $section->updated_at = $timestamp;
        $section->updated_by = Auth::user()->id;

        if ($section->update()) {

            $this->audit_logs('sections', $id, 'has modified a section.', Section::find($id), $timestamp, Auth::user()->id);

            $data = array(
                'title' => 'Well done!',
                'text' => 'The section has been successfully updated.',
                'type' => 'success',
                'class' => 'btn-brand'
            );

            echo json_encode( $data ); exit();

        }
    }

    public function update_status(Request $request, $id)
    {   
        $this->is_permitted(3);
        $timestamp = date('Y-m-d H:i:s');
        $action = $request->input('items')[0]['action'];

        if ($action == 'Remove') {
            $sections = Section::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 0
            ]);
            $this->audit_logs('sections', $id, 'has removed a section.', Section::find($id), $timestamp, Auth::user()->id);

            $data = array(
                'title' => 'Well done!',
                'text' => 'The section status has been successfully removed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }
        else {
            $sections = Section::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 1
            ]);
            $this->audit_logs('sections', $id, 'has retrieved a section.', Section::find($id), $timestamp, Auth::user()->id);

            $data = array(
                'title' => 'Well done!',
                'text' => 'The section status has been successfully activated.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        } 
    }  

    public function get_all_sections_bytype(Request $request, $type)
    {
        $sections = (new Section)->get_all_sections_bytype($type);
        echo json_encode( $sections ); exit();
    }

    public function get_all_sections_bylevel(Request $request, $level, $type)
    {
        $sections = (new Section)->get_all_sections_bylevel($level, $type);
        echo json_encode( $sections ); exit();
    }

    public function import(Request $request)
    {   
        $this->is_permitted(0);
        
        foreach($_FILES as $file)
        {  
            $row = 0; $timestamp = date('Y-m-d H:i:s');
            if (($files = fopen($file['tmp_name'], "r")) !== FALSE) 
            {
                while (($data = fgetcsv($files, 3000, ",")) !== FALSE) 
                {
                    $row++;
                    if ($row > 1) { 
                        if ($data[0] !== '') {
                            $exist = Section::where('code', $data[0])->get();
                            $exist_type = EducationType::where('code', $data[3])->get();
                            if($exist_type->count() > 0) {
                                if ($exist->count() > 0) {
                                    $section = Section::find($exist->first()->id);
                                    $section->code = $data[0];
                                    $section->name = $data[1];
                                    $section->description = $data[2];
                                    $section->education_type_id = EducationType::where('code', $data[3])->first()->id;
                                    $section->updated_at = $timestamp;
                                    $section->updated_by = Auth::user()->id;
                                    $section->update();
                                    $this->audit_logs('sections', $exist->first()->id, 'has imported and updated a section.', Section::find($exist->first()->id), $timestamp, Auth::user()->id);
                                } else {
                                    $section = Section::create([
                                        'code' => $data[0],
                                        'name' => $data[1],
                                        'description' => $data[2],
                                        'education_type_id' => EducationType::where('code', $data[3])->first()->id,
                                        'level_id' => Level::where('code', $data[4])->first()->id,
                                        'created_at' => $timestamp,
                                        'created_by' => Auth::user()->id
                                    ]);
                                    $this->audit_logs('sections', $section->id, 'has imported a new section.', Section::find($section->id), $timestamp, Auth::user()->id);
                                }
                            }
                        }
                    }
                }
                fclose($files);
            }
        }

        $data = array(
            'message' => 'success'
        );

        echo json_encode( $data );
        exit();
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
