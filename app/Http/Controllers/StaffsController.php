<?php

namespace App\Http\Controllers;

use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\Department;
use App\Models\Designation;
use App\User;
use Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\File;
use App\Components\FlashMessages;

class StaffsController extends Controller
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
        $menus = $this->load_menus();
        return view('modules/memberships/staffs/manage')->with(compact('menus'));
    }

    public function manage(Request $request)
    {   
        $menus = $this->load_menus();
        return view('modules/memberships/staffs/manage')->with(compact('menus'));
    }

    public function inactive(Request $request)
    {   
        $menus = $this->load_menus();
        return view('modules/memberships/staffs/inactive')->with(compact('menus'));
    }

    public function all_active(Request $request)
    {
        $res = Staff::where('is_active', 1)->orderBy('id', 'DESC')->get();

        return $res->map(function($staff) {
            $middlename = !empty($staff->middlename) ? $staff->middlename : '';
            $designation = ($staff->designation_id > 0) ? '('.$staff->designation->name.')' : '';
            return [
                'staffID' => $staff->id,
                'staffNumber' => $staff->identification_no,
                'staffName' => $staff->firstname.' '.$middlename.' '.$staff->lastname,
                'staffGender' => $staff->gender,
                'staffRole' => $staff->role->name.' '.$staff->type,
                'staffDepartment' => $staff->department->name.' '.$designation,
                'staffModified' => ($staff->updated_at !== NULL) ? date('d-M-Y', strtotime($staff->updated_at)).'<br/>'. date('h:i A', strtotime($staff->updated_at)) : date('d-M-Y', strtotime($staff->created_at)).'<br/>'. date('h:i A', strtotime($staff->created_at))
            ];
        });
    }

    public function all_inactive(Request $request)
    {
        $res = Staff::where('is_active', 0)->orderBy('id', 'DESC')->get();

        return $res->map(function($staff) {
            $middlename = !empty($staff->middlename) ? $staff->middlename : '';
            $designation = ($staff->designation_id > 0) ? '('.$staff->designation->name.')' : '';
            return [
                'staffID' => $staff->id,
                'staffNumber' => $staff->identification_no,
                'staffName' => $staff->firstname.' '.$middlename.' '.$staff->lastname,
                'staffGender' => $staff->gender,
                'staffRole' => $staff->role->name.' '.$staff->type,
                'staffDepartment' => $staff->department->name.' '.$designation,
                'staffModified' => ($staff->updated_at !== NULL) ? date('d-M-Y', strtotime($staff->updated_at)).'<br/>'. date('h:i A', strtotime($staff->updated_at)) : date('d-M-Y', strtotime($staff->created_at)).'<br/>'. date('h:i A', strtotime($staff->created_at))
            ];
        });
    }

    public function add(Request $request, $id = '')
    {   
        $menus = $this->load_menus();
        $segment = request()->segment(3);
        $staff = (new Staff)->fetch($id);
        $civils = (new Staff)->marital_status();
        $types = (new Staff)->types();
        $departments = (new Department)->all_departments();
        $designations = (new Designation)->all_designations();
        return view('modules/memberships/staffs/add')->with(compact('menus', 'staff', 'civils', 'types', 'departments', 'designations', 'segment'));
    }
    
    public function edit(Request $request, $id)
    {   
        $menus = $this->load_menus();
        $segment = request()->segment(3);
        $staff = (new Staff)->fetch($id);
        $civils = (new Staff)->marital_status();
        $types = (new Staff)->types();
        $departments = (new Department)->all_departments();
        $designations = (new Designation)->all_designations();
        return view('modules/memberships/staffs/edit')->with(compact('menus', 'staff', 'civils', 'types', 'departments', 'designations', 'segment'));
    }
    
    public function uploads(Request $request)
    {   
        if ($request->get('id') != '') {
            $folderID = $request->get('id');
        } else {
            Storage::disk('uploads')->makeDirectory($request->get('files').'/'.$this->generate_staff_no());
            $folderID = $this->generate_staff_no();
        }

        $files = array();

        foreach($_FILES as $file)
        {   
            $filename = basename($file['name']);
            $files[] = Storage::put($request->get('files').'/'.$folderID.'/'.$filename, (string) file_get_contents($file['tmp_name']));
        }

        $data = array('files' => $files);
        echo json_encode( $data ); exit();
    }

    public function downloads(Request $request) {
        $folderID = $request->get('id');
        $filename = $request->get('filename');
        return response()->download(storage_path('app/public/uploads/'.$request->get('files').'/'.$folderID.'/'.$filename));
    }

    public function store(Request $request)
    {    
        $timestamp = date('Y-m-d H:i:s');

        $rows = User::where([
            'email' => $request->email
        ])->count();

        if ($rows > 0) {
            $data = array(
                'title' => 'Oh snap!',
                'text' => 'The email is already in use.',
                'type' => 'error',
                'class' => 'btn-danger'
            );
    
            echo json_encode( $data ); exit();
        }
        
        $user = User::create([
            'name' => $request->firstname.' '.$request->lastname,
            'username' => $this->generate_staff_no(),
            'email' => $request->email,
            'password' => $request->password,
            'type' => 'staff'
        ]);

        if (!$user) {
            throw new NotFoundHttpException();
        }  

        $staff = Staff::create([
            'user_id' => $user->id,
            'role_id' => $request->role_id,
            'department_id' => $request->department_id,
            'designation_id' => $request->designation_id,
            'identification_no' => $this->generate_staff_no(),
            'type' => $request->type,
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'lastname' => $request->lastname,
            'suffix' => $request->suffix,
            'gender' => $request->gender,
            'marital_status' => $request->marital_status,
            'birthdate' => date('Y-m-d', strtotime($request->birthdate)),
            'current_address' => $request->current_address,
            'permanent_address' => ($request->permanent_address !== NULL) ? $request->permanent_address : NULL,
            'mobile_no' => ($request->mobile_no !== NULL) ? $request->mobile_no : NULL,
            'telephone_no' => ($request->telephone_no !== NULL) ? $request->telephone_no : NULL,
            'date_joined' => date('Y-m-d', strtotime($request->date_joined)),
            'date_resigned' => ($request->date_resigned !== NULL) ? date('Y-m-d', strtotime($request->date_resigned)) : NULL,
            'avatar' => $request->get('avatar'),
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);

        if (!$staff) {
            throw new NotFoundHttpException();
        }

        $data = array(
            'title' => 'Well done!',
            'text' => 'The staff has been successfully saved.',
            'type' => 'success',
            'class' => 'btn-brand'
        );

        echo json_encode( $data ); exit();
    }

    public function update(Request $request, $id)
    {    
        $timestamp = date('Y-m-d H:i:s');
        $staff = Staff::find($id);

        if(!$staff) {
            throw new NotFoundHttpException();
        }

        $user_id = $staff->user_id;
        $staff->role_id = $request->role_id;
        $staff->department_id = $request->department_id;
        $staff->designation_id = $request->designation_id;
        $staff->type = $request->type;
        $staff->firstname = $request->firstname;
        $staff->middlename = $request->middlename;
        $staff->lastname = $request->lastname;
        $staff->suffix = $request->suffix;
        $staff->gender = $request->gender;
        $staff->marital_status = $request->marital_status;
        $staff->birthdate = date('Y-m-d', strtotime($request->birthdate));
        $staff->current_address = $request->current_address;
        $staff->permanent_address = $request->permanent_address;
        $staff->mobile_no = $request->mobile_no;
        $staff->telephone_no = $request->telephone_no;
        $staff->date_joined =  date('Y-m-d', strtotime($request->date_joined));
        $staff->date_resigned = ($request->date_resigned !== NULL) ? date('Y-m-d', strtotime($request->date_resigned)) : NULL;
        if ($request->get('avatar') !== NULL) {
            $staff->avatar = $request->get('avatar');
        }
        $staff->updated_at = $timestamp;
        $staff->updated_by = Auth::user()->id;

        if ($staff->update()) {
            $user = User::where('id', '=', $user_id)->first();
            if ($user->password != $request->password) {
                User::where('id', '=', $user_id)
                ->update([
                    'name' => $request->firstname.' '.$request->lastname,
                    'email' => $request->email,
                    'password' => Hash::make($request->password)
                ]);
            } else {
                User::where('id', '=', $user_id)
                ->update([
                    'name' => $request->firstname.' '.$request->lastname,
                    'email' => $request->email,
                ]);
            }
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The staff has been successfully updated.',
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
            $staffs = Staff::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 0
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The staff has been successfully removed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }    
        else {
            $staffs = Staff::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 1
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The staff has been successfully activated.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }   
    }

    public function generate_staff_no()
    {
        $staffNo = (new Staff)->generate_staff_no();
        return $staffNo;
    }
}
