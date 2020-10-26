<?php

namespace App\Http\Controllers;

use App\Imports\SubjectImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subject;
use App\Models\Staff;
use App\Models\Quarter;
use App\Models\EducationType;
use App\Models\SubjectEducationTypes;
use App\Models\AuditLog;
use App\Helper\Helper;

class SubjectsController extends Controller
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
        return view('modules/academics/subjects/manage')->with(compact('menus'));
    }

    public function manage(Request $request)
    {   
        $this->is_permitted(1);
        $menus = $this->load_menus();
        return view('modules/academics/subjects/manage')->with(compact('menus'));
    }

    public function inactive(Request $request)
    {   
        $this->is_permitted(1);
        $menus = $this->load_menus();
        return view('modules/academics/subjects/inactive')->with(compact('menus'));
    }

    public function all_active(Request $request)
    {
        $res = Subject::where('is_active', 1)->orderBy('id', 'DESC')->get();

        return $res->map(function($subject) {

            $subjecteducationtypes = SubjectEducationTypes::join('education_types','education_types.id', 'subjects_education_types.education_type_id')->where('subjects_education_types.subject_id', $subject->id)->get();
            $subjecteducationtypes_id = array();
            $subjecteducationtypes_name = array();
            
            foreach ($subjecteducationtypes as $subjecteducationtype) {
                array_push($subjecteducationtypes_id, $subjecteducationtype->id);
                array_push($subjecteducationtypes_name, $subjecteducationtype->name);
            }

            return [
                'subjectID' => $subject->id,
                'subjectCode' => $subject->code,
                'subjectName' => $subject->name,
                'subjectDescription' => $subject->description,
                'subjectModified' => ($subject->updated_at !== NULL) ? date('d-M-Y', strtotime($subject->updated_at)).'<br/>'. date('h:i A', strtotime($subject->updated_at)) : date('d-M-Y', strtotime($subject->created_at)).'<br/>'. date('h:i A', strtotime($subject->created_at)),
                'subjectTypeID' => $subjecteducationtypes_id,
                'subjectTypeName' => $subjecteducationtypes_name,
            ];
        });
    }

    public function all_inactive(Request $request)
    {
        $res = Subject::where('is_active', 0)->orderBy('id', 'DESC')->get();

        return $res->map(function($subject) {

            $subjecteducationtypes = SubjectEducationTypes::join('education_types','education_types.id', 'subjects_education_types.education_type_id')->where('subjects_education_types.subject_id', $subject->id)->get();
            $subjecteducationtypes_id = array();
            $subjecteducationtypes_name = array();
            
            foreach ($subjecteducationtypes as $subjecteducationtype) {
                array_push($subjecteducationtypes_id, $subjecteducationtype->id);
                array_push($subjecteducationtypes_name, $subjecteducationtype->name);
            }

            return [
                'subjectID' => $subject->id,
                'subjectCode' => $subject->code,
                'subjectName' => $subject->name,
                'subjectDescription' => $subject->description,
                'subjectModified' => ($subject->updated_at !== NULL) ? date('d-M-Y', strtotime($subject->updated_at)).'<br/>'. date('h:i A', strtotime($subject->updated_at)) : date('d-M-Y', strtotime($subject->created_at)).'<br/>'. date('h:i A', strtotime($subject->created_at)),
                'subjectTypeID' => $subjecteducationtypes_id,
                'subjectTypeName' => $subjecteducationtypes_name,
            ];
        });
    }

    public function add(Request $request, $id = '')
    {   
        $this->is_permitted(0);
        $menus = $this->load_menus();
        $flashMessage = self::messages();
        $segment = request()->segment(4);
        $types = (new EducationType)->all_education_types_selectpicker();
        $coordinators = (new Staff)->all_coordinators();
        if (count($flashMessage) && $flashMessage[0]['module'] == 'subject') {
            $subject = (new Subject)->fetch($flashMessage[0]['id']);
        } else {
            $subject = (new Subject)->fetch($id);
        }
        return view('modules/academics/subjects/add')->with(compact('menus', 'coordinators', 'types', 'subject', 'segment', 'flashMessage'));
    }
    
    public function edit(Request $request, $id)
    {   
        $this->is_permitted(2);
        $menus = $this->load_menus();
        $flashMessage = self::messages();
        $segment = request()->segment(4);
        $types = (new EducationType)->all_education_types_selectpicker();
        $coordinators = (new Staff)->all_coordinators();
        $subject = (new Subject)->fetch($id);

        return view('modules/academics/subjects/edit')->with(compact('menus', 'coordinators', 'types', 'subject', 'segment', 'flashMessage'));
    }
    
    public function store(Request $request)
    {   
        $this->is_permitted(0);
        $exist_code = Subject::where('code', $request->code)->first();

        if(!$exist_code)
        {
            if($request->material > 1){
                $exist_material = Subject::where('material_id', $request->material)->first();
            } else {
                $exist_material = 0;
            }

            if(!$exist_material){

                $timestamp = date('Y-m-d H:i:s');
                $tle_count = Subject::where('is_tle', $request->is_tle)->count();
                $mapeh_count = Subject::where('is_mapeh', $request->is_mapeh)->count();

                if(($tle_count) <= 2 && ($mapeh_count <= 4))
                {
                    $subject = Subject::create([
                        'code' => $request->code,
                        'name' => $request->name,
                        'description' => $request->description,
                        'coordinator_id' => $request->coordinator,
                        'is_mapeh' => ($request->is_mapeh !== NULL) ? 1 : 0,
                        'is_tle' => ($request->is_tle !== NULL) ? 1 : 0,
                        'material_id' => ($request->material !== NULL) ? $request->material : 1,
                        'created_at' => $timestamp,
                        'created_by' => Auth::user()->id
                    ]);
                            
                    if (!$subject) {
                        throw new NotFoundHttpException();
                    } 
                            
                    //Insert Subject Education Types
                    foreach ($request->type as $type) {
                        if($type > 0){
                            $subjecteducationtypes = SubjectEducationTypes::create([
                                'subject_id' => $subject->id,
                                'education_type_id' => $type,
                                'created_at' => $timestamp,
                                'created_by' => Auth::user()->id
                            ]);
                            $this->audit_logs('subjects_education_types', $subjecteducationtypes->id, 'has inserted a new subject education type.', SubjectEducationTypes::find($subjecteducationtypes->id), $timestamp, Auth::user()->id);
                        }
                    }
                    
                    $this->audit_logs('subjects', $subject->id, 'has inserted a new subject.', Subject::find($subject->id), $timestamp, Auth::user()->id);

                    $data = array(
                        'title' => 'Well done!',
                        'text' => 'The subject has been successfully saved.',
                        'type' => 'success',
                        'class' => 'btn-brand'
                    );

                } else {
                    $data = array(
                        'title' => 'Warning',
                        'text' => 'TLE or MAPEH exceeded limit',
                        'type' => 'warning',
                        'class' => 'btn-brand'
                    );
                }

            } else {
                $data = array( 
                    'title' => 'Warning', 
                    'text' => 'The material already exist in subject.', 
                    'type' => 'warning', 
                    'class' => 'btn-brand' 
                );
            }

        } else {
            $data = array(
                'title' => 'Warning',
                'text' => 'Subject code already exist.',
                'type' => 'warning',
                'class' => 'btn-brand'
            );
        }

        echo json_encode( $data ); exit();
    }

    public function update(Request $request, $id)
    {   
        $this->is_permitted(2);
        $exist_code = 0;
        $exist_code = Subject::where('code', $request->code)->where('id', '!=', $id)->first();

        if(!$exist_code)
        {
            
            $subjecteducationtypes = SubjectEducationTypes::where('subject_id', $id);
            $subjecteducationtypes->delete();
            $exist_material = Subject::where('material_id', $request->material)->where('material_id', '!=', 1)->where('id', '!=', $id)->count();
                            
                if(!$exist_material)
                {
                                
                    $timestamp = date('Y-m-d H:i:s');
                    $tle_count = Subject::where('is_tle', $request->is_tle)->where('id', '!=', $id)->count();
                    $mapeh_count = Subject::where('is_mapeh', $request->is_mapeh)->where('id', '!=', $id)->count();

                    if(($tle_count) <= 2 && ($mapeh_count <= 4))
                    {
                        $subject = Subject::find($id);

                        if(!$subject) {
                            throw new NotFoundHttpException();
                        }   

                        $subject->code = $request->code;
                        $subject->name = $request->name;
                        $subject->description = $request->description;
                        $subject->coordinator_id = $request->coordinator;
                        $subject->is_mapeh = ($request->is_mapeh !== NULL) ? 1 : 0; 
                        $subject->is_tle = ($request->is_tle !== NULL) ? 1 : 0;
                        $subject->material_id = ($request->material !== NULL) ? $request->material : 1;
                        $subject->updated_at = $timestamp;
                        $subject->updated_by = Auth::user()->id;
                                        
                        foreach ($request->type as $type) {
                            if($type > 0){
                                $subjects_education_types = SubjectEducationTypes::create([
                                    'subject_id' => $id,
                                    'education_type_id' => $type,
                                    'created_at' => $timestamp,
                                    'created_by' => Auth::user()->id
                                ]);
                                $this->audit_logs('subjects_education_types', $subjects_education_types->id, 'has inserted a new subject education type.', SubjectEducationTypes::find($subjects_education_types->id), $timestamp, Auth::user()->id);
                            }
                        }
                        
                        if ( $subject->update() ) {
                            $this->audit_logs('subjects', $id, 'has modified a subject.', Subject::find($id), $timestamp, Auth::user()->id);
                            $data = array(
                                'title' => 'Well done!',
                                'text' => 'The subject has been successfully updated.',
                                'type' => 'success',
                                'class' => 'btn-brand'
                            );
                        }

                    } else {
                        $data = array(
                            'title' => 'Warning',
                            'text' => 'TLE or MAPEH exceeded limit',
                            'type' => 'warning',
                            'class' => 'btn-brand'
                        );
                    }

                } else {
                    $data = array(
                        'title' => 'Warning',
                        'text' => 'The material already exist in subject',
                        'type' => 'warning',
                        'class' => 'btn-brand'
                    );
                }

        } else {
            $data = array(
                'title' => 'Warning',
                'text' => 'Subject code already exist.',
                'type' => 'warning',
                'class' => 'btn-brand'
            );
        }

        echo json_encode( $data ); exit();
    }

    public function update_status(Request $request, $id)
    {   
        $this->is_permitted(3);
        $timestamp = date('Y-m-d H:i:s');
        $action = $request->input('items')[0]['action'];

        if ($action == 'Remove') {
            $subjects = Subject::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 0
            ]);
            $this->audit_logs('subjects', $id, 'has removed a subject.', Subject::find($id), $timestamp, Auth::user()->id);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The subject status has been successfully removed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }
        else {
            $subjects = Subject::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 1
            ]);
            $this->audit_logs('subjects', $id, 'has retrieved a subject.', Subject::find($id), $timestamp, Auth::user()->id);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The subject status has been successfully activated.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }  
    } 

        
    public function get_all_subjects()
    {
        $subjects = (new Subject)->get_all_subjects();
        echo json_encode( $subjects ); exit();
    }

    public function get_all_subjects_bytype(Request $request, $type)
    {
        $subjects = (new Subject)->get_all_subjects_bytype($type);
        echo json_encode( $subjects ); exit();
    }

    public function get_all_teachers_bytype()
    {
        $teachers = (new Subject)->get_all_teachers_bytype();
        echo json_encode( $teachers ); exit();
    }
    
    public function get_all_advisers_bytype()
    {
        $advisers = (new Subject)->get_all_advisers_bytype();
        echo json_encode( $advisers ); exit();
    }

    //Added here to avoid conflict
    public function get_all_teachers()
    {
        $teachers = Staff::where('is_active', 1)->orwhere('type','Adviser')->orwhere('type','Teacher')->orderBy('id', 'asc')->get();

        $staffs = array();
        $staffs[] = array('0' => 'select a teacher');

        foreach ($teachers as $teacher) {
            $staffs[] = array(
                $teacher->id  => $teacher->lastname.', '.$teacher->firstname.' '.$teacher->middlename.' ('.$teacher->identification_no.')' ,
            );
        }

        $teachers = array();
        foreach($staffs as $staff) {
            foreach($staff as $key => $val) {
                $teachers[$key] = $val;
            }
        }

        echo json_encode( $teachers ); exit();
    }

    public function import(Request $request)
    {   
        $this->is_permitted(0);
        $error = '';

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

                            $exist = Subject::where('code', $data[0])->get();

                            if ($exist->count() > 0) {

                                if( $data[6] > 1){
                                    $exist_material = Subject::where('material_id', $data[6])->where('code', '!=', $data[0])->count();
                                    $data[4] = 0;
                                    $data[5] = 0;
                                } else {
                                    $exist_material = 0;
                                }

                                if(!$exist_material){

                                    $tle_count = Subject::where('is_tle', 1)->where('code', '!=', $data[0])->count();
                                    $mapeh_count = Subject::where('is_mapeh', 1)->where('code', '!=', $data[0])->count();
                        
                                    if(($tle_count) <= 2 && ($mapeh_count <= 4))
                                    {
                                        $subject = Subject::find($exist->first()->id);
                                        $subject->code = $data[0];
                                        $subject->name = $data[1];
                                        $subject->description = $data[2];
                                        $subject->coordinator_id = $data[7];
                                        $subject->is_mapeh = $data[4];
                                        $subject->is_tle = $data[5];
                                        $subject->material_id = $data[6];
                                        $subject->updated_at = $timestamp;
                                        $subject->updated_by = Auth::user()->id;
                                        $subject->update();
                                        $this->audit_logs('subjects', $subject->id, 'has modified a subject.', Subject::find($subject->id), $timestamp, Auth::user()->id);

                                        $subjecteducationtypes = SubjectEducationTypes::where('subject_id', $exist->first()->id);
                                        $subjecteducationtypes->delete();

                                        $type_arrs = explode(',', $data[3]);
                                        foreach($type_arrs as $type_arr){
                                            $type = EducationType::where('code', $type_arr )->first()->id;
                                            if($type){
                                                $subjecteducationtypes = SubjectEducationTypes::create([
                                                    'subject_id' => $exist->first()->id,
                                                    'education_type_id' => $type,
                                                    'created_at' => $timestamp,
                                                    'created_by' => Auth::user()->id
                                                ]);
                                                $this->audit_logs('subjects_education_types', $subjecteducationtypes->id, 'has inserted a new subject education type.', SubjectEducationTypes::find($subjecteducationtypes->id), $timestamp, Auth::user()->id);
                                            }
                                        }
                                    }else{
                                        $error .= ','.$data[0]; 
                                    }
                                }else{
                                    $error .= ','.$data[0];
                                }

                            } else {

                                if( $data[6] > 1){
                                    $exist_material = Subject::where('material_id', $data[6])->where('code', '!=', $data[0])->count();
                                    $data[4] = 0;
                                    $data[5] = 0;
                                } else {
                                    $exist_material = 0;
                                }
                                        
                                if(!$exist_material)
                                {
                                    $tle_count = Subject::where('is_tle', 1)->where('code', '!=', $data[0])->count();
                                    $mapeh_count = Subject::where('is_mapeh', 1)->where('code', '!=', $data[0])->count();

                                    if(($tle_count) <= 2 && ($mapeh_count <= 4))
                                    {
                                        $subject = Subject::create([
                                            'code' => $data[0],
                                            'name' => $data[1],
                                            'description' => $data[2],
                                            'coordinator_id' => $data[7],
                                            'is_mapeh' => $data[4],
                                            'is_tle' => $data[5],
                                            'material_id' => $data[6],
                                            'created_at' => $timestamp,
                                            'created_by' => Auth::user()->id
                                        ]);
                                        $this->audit_logs('subjects', $subject->id, 'has inserted a new subject.', Subject::find($subject->id), $timestamp, Auth::user()->id);

                                        $type_arrs = explode(',', $data[3]);
                                        foreach($type_arrs as $type_arr){
                                            $type = EducationType::where('code', $type_arr )->first()->id;
                                            if($type){
                                                $subjecteducationtypes = SubjectEducationTypes::create([
                                                    'subject_id' => $subject->id,
                                                    'education_type_id' => $type,
                                                    'created_at' => $timestamp,
                                                    'created_by' => Auth::user()->id
                                                ]);
                                                $this->audit_logs('subjects_education_types', $subjecteducationtypes->id, 'has inserted a new subject education type.', SubjectEducationTypes::find($subjecteducationtypes->id), $timestamp, Auth::user()->id);
                                            }
                                        }
                                    }else{
                                        $error .= ','.$data[0];
                                    }
                                }else{
                                    $error .= ','.$data[0];
                                }
                            }            
                        }
                    }
                }
                fclose($files);
            }
        }

        if($error){
            $data = array(
                'title' => 'Warning.',
                'text' => 'Some data did not saved or updated. Please review excel file in subject code: '.$error,
                'type' => 'warning',
                'class' => 'btn-brand',
                'message' => 'warning'
            );
        }elseif($error == ''){
            $data = array(
                'title' => 'Well done!',
                'text' => 'Subject imported.',
                'type' => 'success',
                'class' => 'btn-brand',
                'message' => 'success'
            );
        }

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
