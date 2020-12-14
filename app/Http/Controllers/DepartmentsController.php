<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\EducationType;
use App\Models\DepartmentEducationType;
use App\Models\AuditLog;
use Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\File;
use App\Components\FlashMessages;
use App\Helper\Helper;

class DepartmentsController extends Controller
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

    public function index()
    {   
        $this->is_permitted(1);
        $menus = $this->load_menus();
        return view('modules/components/schools/departments/manage')->with(compact('menus'));
    }

    public function manage(Request $request)
    {   
        $this->is_permitted(1);    
        $menus = $this->load_menus();
        $types = (new EducationType)->manage_education_types();
        return view('modules/components/schools/departments/manage')->with(compact('menus', 'types'));
    }

    public function inactive(Request $request)
    {   
        $this->is_permitted(1);
        $menus = $this->load_menus();
        $types = (new EducationType)->manage_education_types();
        return view('modules/components/schools/departments/inactive')->with(compact('menus', 'types'));
    }

    public function all_active(Request $request)
    {  
        $res = Department::
        with([
            'edtypes' =>  function($q) { 
                $q->select(['departments_education_types.id', 'departments_education_types.department_id', 'departments_education_types.education_type_id', 'education_types.name'])->join('education_types', function($join)
                {
                    $join->on('education_types.id', '=', 'departments_education_types.education_type_id');
                });
            }
        ])
        ->where('is_active', 1)
        ->orderBy('id', 'DESC')
        ->get();

        return $res->map(function($department) {
            return [
                'departmentID' => $department->id,
                'departmentCode' => $department->code,
                'departmentName' => $department->name,
                'departmentDescription' => $department->description,
                'departmentTypeID' => $department->edtypes->map(function($a) { return $a->education_type_id; }),
                'departmentTypeName' => $department->edtypes->map(function($a) { return $a->name; }),
                'departmentModified' => ($department->updated_at !== NULL) ? date('d-M-Y', strtotime($department->updated_at)).'<br/>'. date('h:i A', strtotime($department->updated_at)) : date('d-M-Y', strtotime($department->created_at)).'<br/>'. date('h:i A', strtotime($department->created_at))
            ];
        });
    }

    public function all_inactive(Request $request)
    {   
        $res = Department::
        with([
            'edtypes' =>  function($q) { 
                $q->select(['departments_education_types.id', 'departments_education_types.department_id', 'departments_education_types.education_type_id', 'education_types.name'])->join('education_types', function($join)
                {
                    $join->on('education_types.id', '=', 'departments_education_types.education_type_id');
                });
            }
        ])
        ->where('is_active', 0)
        ->orderBy('id', 'DESC')
        ->get();

        return $res->map(function($department) {
            return [
                'departmentID' => $department->id,
                'departmentCode' => $department->code,
                'departmentName' => $department->name,
                'departmentDescription' => $department->description,
                'departmentTypeID' => $department->edtypes->map(function($a) { return $a->education_type_id; }),
                'departmentTypeName' => $department->edtypes->map(function($a) { return $a->name; }),
                'departmentModified' => ($department->updated_at !== NULL) ? date('d-M-Y', strtotime($department->updated_at)).'<br/>'. date('h:i A', strtotime($department->updated_at)) : date('d-M-Y', strtotime($department->created_at)).'<br/>'. date('h:i A', strtotime($department->created_at))
            ];
        });
    }

    public function add(Request $request, $id = '')
    {   
        $this->is_permitted(0);
        $menus = $this->load_menus();
        $flashMessage = self::messages();
        $segment = request()->segment(4);
        $department = (new Department)->fetch($id);
        $types = (new EducationType)->all_education_types_selectpicker();
        return view('modules/components/schools/departments/add')->with(compact('menus', 'department', 'types', 'segment'));
    }
    
    public function edit(Request $request, $id)
    {   
        $this->is_permitted(2);
        $menus = $this->load_menus();
        $flashMessage = self::messages();
        $segment = request()->segment(4);
        $department = (new Department)->fetch($id);
        $types = (new EducationType)->all_education_types_selectpicker();
        return view('modules/components/schools/departments/edit')->with(compact('menus', 'department', 'types', 'segment'));
    }
    
    public function store(Request $request)
    {    
        $this->is_permitted(0);
        $timestamp = date('Y-m-d H:i:s');

        $rows = Department::where([
            'code' => $request->code
        ])->count();

        if ($rows > 0) {
            $data = array(
                'title' => 'Oh snap!',
                'text' => 'You cannot create a department with an existing code.',
                'type' => 'error',
                'class' => 'btn-danger'
            );
    
            echo json_encode( $data ); exit();
        }

        $department = Department::create([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);

        if (!$department) {
            throw new NotFoundHttpException();
        }

        foreach ($request->education_type_id as $education_type) {
            $department_education_type = DepartmentEducationType::create([
                'department_id' => $department->id,
                'education_type_id' => $education_type,
                'created_at' => $timestamp,
                'created_by' => Auth::user()->id
            ]);
            $this->audit_logs('departments_education_types', $department_education_type->id, 'has inserted a new department education type.', DepartmentEducationType::find($department_education_type->id), $timestamp, Auth::user()->id);
        }

        $this->audit_logs('departments', $department->id, 'has inserted a new department.', Department::find($department->id), $timestamp, Auth::user()->id);
        
        $data = array(
            'title' => 'Well done!',
            'text' => 'The department has been successfully saved.',
            'type' => 'success',
            'class' => 'btn-brand'
        );

        echo json_encode( $data ); exit();
    }

    public function update(Request $request, $id)
    {    
        $this->is_permitted(2);
        $timestamp = date('Y-m-d H:i:s');
        $department = Department::find($id);

        if(!$department) {
            throw new NotFoundHttpException();
        }

        $department->code = $request->code;
        $department->name = $request->name;
        $department->description = $request->description;
        $department->updated_at = $timestamp;
        $department->updated_by = Auth::user()->id;

        if ($department->update()) {

            DepartmentEducationType::where('department_id', $id)->update(['updated_at' => $timestamp, 'updated_by' => Auth::user()->id,'is_active' => 0]);
            foreach ($request->education_type_id as $education_type) {
                $department_education_type = DepartmentEducationType::where(['department_id' => $id, 'education_type_id' => $education_type])
                ->update([
                    'education_type_id' => $education_type,
                    'updated_at' => $timestamp,
                    'updated_by' => Auth::user()->id,
                    'is_active' => 1
                ]);
                $department_education_type = DepartmentEducationType::where(['department_id' => $id, 'education_type_id' => $education_type, 'is_active' => 1])->get();
                if ($department_education_type->count() > 0) {
                    $this->audit_logs('departments_education_types', $department_education_type->first()->id, 'has modified a department education type.', DepartmentEducationType::find($department_education_type->first()->id), $timestamp, Auth::user()->id);
                } else {
                    $department_education_type = DepartmentEducationType::create([
                        'department_id' => $id,
                        'education_type_id' => $education_type,
                        'created_at' => $timestamp,
                        'created_by' => Auth::user()->id
                    ]);
                    $this->audit_logs('departments_education_types', $department_education_type->id, 'has inserted a new department education type.', DepartmentEducationType::find($department_education_type->id), $timestamp, Auth::user()->id);
                }
            }

            $this->audit_logs('departments', $id, 'has modified a department.', Department::find($id), $timestamp, Auth::user()->id);

            $data = array(
                'title' => 'Well done!',
                'text' => 'The department has been successfully updated.',
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
            $department = Department::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 0
            ]);
            $this->audit_logs('departments', $id, 'has removed a department.', Department::find($id), $timestamp, Auth::user()->id);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The department has been successfully removed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }    
        else {
            $department = Department::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 1
            ]);
            $this->audit_logs('departments', $id, 'has retrieved a department.', Department::find($id), $timestamp, Auth::user()->id);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The department has been successfully activated.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }   
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
                    if ($row > 1) 
                    {  
                        $exist = Department::where('code', $data[0])->get();
                        if ($exist->count() > 0) {
                            $department = Department::find($exist->first()->id);
                            $department->code = $data[0];
                            $department->name = $data[1];
                            $department->description = $data[2];
                            $department->updated_at = $timestamp;
                            $department->updated_by = Auth::user()->id;

                            if ($department->update()) {
                                DepartmentEducationType::where('department_id', $exist->first()->id)->update(['updated_at' => $timestamp, 'updated_by' => Auth::user()->id,'is_active' => 0]);
                                $education_types = explode(',',$data[3]);
                                foreach ($education_types as $education_type) {
                                    $education_type_id = EducationType::where('code', $education_type)->first()->id;
                                    $department_education_type = DepartmentEducationType::where(['department_id' => $exist->first()->id, 'education_type_id' => $education_type_id])
                                    ->update([
                                        'education_type_id' => $education_type_id,
                                        'updated_at' => $timestamp,
                                        'updated_by' => Auth::user()->id,
                                        'is_active' => 1
                                    ]);
                                    $department_education_type = DepartmentEducationType::where(['department_id' => $exist->first()->id, 'education_type_id' => $education_type_id, 'is_active' => 1])->get();
                                    if ($department_education_type->count() > 0) {
                                        $this->audit_logs('departments_education_types', $department_education_type->first()->id, 'has modified a department education type.', DepartmentEducationType::find($department_education_type->first()->id), $timestamp, Auth::user()->id);
                                    } else {
                                        $department_education_type = DepartmentEducationType::create([
                                            'department_id' => $exist->first()->id,
                                            'education_type_id' => $education_type_id,
                                            'created_at' => $timestamp,
                                            'created_by' => Auth::user()->id
                                        ]);
                                        $this->audit_logs('departments_education_types', $department_education_type->id, 'has inserted a new department education type.', DepartmentEducationType::find($department_education_type->id), $timestamp, Auth::user()->id);
                                    }
                                }

                                $this->audit_logs('departments', $exist->first()->id, 'has modified a department.', Department::find($exist->first()->id), $timestamp, Auth::user()->id);
                            }
                        } else {
                            $department = Department::create([
                                'code' => $data[0],
                                'name' => $data[1],
                                'description' => $data[2],
                                'created_at' => $timestamp,
                                'created_by' => Auth::user()->id
                            ]);
                    
                            if (!$department) {
                                throw new NotFoundHttpException();
                            }
                            
                            $education_types = explode(',',$data[3]);
                            foreach ($education_types as $education_type) {
                                $education_type_id = EducationType::where('code', $education_type)->first()->id;
                                $department_education_type = DepartmentEducationType::create([
                                    'department_id' => $department->id,
                                    'education_type_id' => $education_type_id,
                                    'created_at' => $timestamp,
                                    'created_by' => Auth::user()->id
                                ]);
                                $this->audit_logs('departments_education_types', $department_education_type->id, 'has inserted a new department education type.', DepartmentEducationType::find($department_education_type->id), $timestamp, Auth::user()->id);
                            }
                    
                            $this->audit_logs('departments', $department->id, 'has inserted a new department.', Department::find($department->id), $timestamp, Auth::user()->id);
                        }
                    } // close for if $row > 1 condition   
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
