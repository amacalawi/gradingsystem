<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Department;
use Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\File;
use App\Components\FlashMessages;

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
    public function index()
    {
        return view('modules/schools/departments/manage');
    }

    public function manage(Request $request)
    {   
        return view('modules/schools/departments/manage');
    }

    public function inactive(Request $request)
    {   
        return view('modules/schools/departments/inactive');
    }

    public function all_active(Request $request)
    {
        $res = Department::where('is_active', 1)->orderBy('id', 'DESC')->get();

        return $res->map(function($department) {
            return [
                'departmentID' => $department->id,
                'departmentCode' => $department->code,
                'departmentName' => $department->name,
                'departmentDescription' => $department->description,
                'departmentType' => $department->type,
                'departmentModified' => ($department->updated_at !== NULL) ? date('d-M-Y', strtotime($department->updated_at)).'<br/>'. date('h:i A', strtotime($department->updated_at)) : date('d-M-Y', strtotime($department->created_at)).'<br/>'. date('h:i A', strtotime($department->created_at))
            ];
        });
    }

    public function all_inactive(Request $request)
    {
        $res = Department::where('is_active', 0)->orderBy('id', 'DESC')->get();

        return $res->map(function($department) {
            return [
                'departmentID' => $department->id,
                'departmentCode' => $department->code,
                'departmentName' => $department->name,
                'departmentDescription' => $department->description,
                'departmentType' => $department->type,
                'departmentModified' => ($department->updated_at !== NULL) ? date('d-M-Y', strtotime($department->updated_at)).'<br/>'. date('h:i A', strtotime($department->updated_at)) : date('d-M-Y', strtotime($department->created_at)).'<br/>'. date('h:i A', strtotime($department->created_at))
            ];
        });
    }

    public function add(Request $request, $id = '')
    {   
        $flashMessage = self::messages();
        $segment = request()->segment(3);
        if (count($flashMessage) && $flashMessage[0]['module'] == 'department') {
            $department = (new Department)->fetch($flashMessage[0]['id']);
        } else {
            $department = (new Department)->fetch($id);
        }
        $types = (new Department)->types();
        return view('modules/schools/departments/add')->with(compact('department', 'types', 'segment', 'flashMessage'));
    }
    
    public function edit(Request $request, $id)
    {   
        $flashMessage = self::messages();
        $segment = request()->segment(3);
        $department = (new Department)->find($id);
        $types = (new Department)->types();
        return view('modules/schools/departments/edit')->with(compact('department', 'types', 'segment', 'flashMessage'));
    }
    
    public function store(Request $request)
    {    
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
            'type' => $request->type,
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);

        if (!$department) {
            throw new NotFoundHttpException();
        }

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
        $timestamp = date('Y-m-d H:i:s');
        $department = Department::find($id);

        if(!$department) {
            throw new NotFoundHttpException();
        }

        $department->code = $request->code;
        $department->name = $request->name;
        $department->description = $request->description;
        $department->type = $request->type;
        $department->updated_at = $timestamp;
        $department->updated_by = Auth::user()->id;

        if ($department->update()) {

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
        $timestamp = date('Y-m-d H:i:s');
        $action = $request->input('items')[0]['action'];

        if ($action == 'Remove') {
            $departments = Department::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 0
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
            $batches = Department::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 1
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
