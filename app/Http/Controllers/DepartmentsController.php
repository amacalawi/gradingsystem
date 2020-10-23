<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\EducationType;
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
            'edtype' =>  function($q) { 
                $q->select(['id', 'name']); 
            }
        ])
        ->where('is_active', 1)->orderBy('id', 'DESC')->get();

        return $res->map(function($department) {
            return [
                'departmentID' => $department->id,
                'departmentCode' => $department->code,
                'departmentName' => $department->name,
                'departmentDescription' => $department->description,
                'departmentTypeID' => $department->edtype->id,
                'departmentType' => $department->edtype->name,
                'departmentModified' => ($department->updated_at !== NULL) ? date('d-M-Y', strtotime($department->updated_at)).'<br/>'. date('h:i A', strtotime($department->updated_at)) : date('d-M-Y', strtotime($department->created_at)).'<br/>'. date('h:i A', strtotime($department->created_at))
            ];
        });
    }

    public function all_inactive(Request $request)
    {
        $res = Department::
        with([
            'edtype' =>  function($q) { 
                $q->select(['id', 'name']); 
            }
        ])
        ->where('is_active', 0)->orderBy('id', 'DESC')->get();

        return $res->map(function($department) {
            return [
                'departmentID' => $department->id,
                'departmentCode' => $department->code,
                'departmentName' => $department->name,
                'departmentDescription' => $department->description,
                'departmentTypeID' => $department->edtype->id,
                'departmentType' => $department->edtype->name,
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
        $types = (new EducationType)->all_education_types();
        return view('modules/components/schools/departments/add')->with(compact('menus', 'department', 'types', 'segment'));
    }
    
    public function edit(Request $request, $id)
    {   
        $this->is_permitted(2);
        $menus = $this->load_menus();
        $flashMessage = self::messages();
        $segment = request()->segment(4);
        $department = (new Department)->fetch($id);
        $types = (new EducationType)->all_education_types();
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
            'education_type_id' => $request->education_type_id,
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);

        if (!$department) {
            throw new NotFoundHttpException();
        }

        $auditLogs = AuditLog::create([
            'entity' => 'departments',
            'entity_id' => $department->id,
            'description' => 'has inserted a new department.',
            'data' => json_encode(Department::find($department->id)),
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);

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
        $department->education_type_id = $request->education_type_id;
        $department->updated_at = $timestamp;
        $department->updated_by = Auth::user()->id;

        if ($department->update()) {

            $auditLogs = AuditLog::create([
                'entity' => 'departments',
                'entity_id' => $id,
                'description' => 'has modified a department.',
                'data' => json_encode(Department::find($id)),
                'created_at' => $timestamp,
                'created_by' => Auth::user()->id
            ]);

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

            $auditLogs = AuditLog::create([
                'entity' => 'departments',
                'entity_id' => $id,
                'description' => 'has removed a department.',
                'data' => json_encode(Department::find($id)),
                'created_at' => $timestamp,
                'created_by' => Auth::user()->id
            ]);
            
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

            $auditLogs = AuditLog::create([
                'entity' => 'departments',
                'entity_id' => $id,
                'description' => 'has retrieved a department.',
                'data' => json_encode(Department::find($id)),
                'created_at' => $timestamp,
                'created_by' => Auth::user()->id
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The department has been successfully activated.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }   
    }

}
