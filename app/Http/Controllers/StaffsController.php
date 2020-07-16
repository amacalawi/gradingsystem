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
use App\Models\UserRole;
use App\Models\EducationType;
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
        $specifications = (new EducationType)->all_education_types();
        $statuses = (new Staff)->graduate_school_status();
        return view('modules/memberships/staffs/add')->with(compact('menus', 'staff', 'civils', 'types', 'departments', 'designations', 'specifications', 'segment', 'statuses'));
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
        $specifications = (new EducationType)->all_education_types();
        $statuses = (new Staff)->graduate_school_status();
        return view('modules/memberships/staffs/edit')->with(compact('menus', 'staff', 'civils', 'types', 'departments', 'designations', 'specifications', 'segment', 'statuses'));
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
                'error' => 'email',
                'class' => 'btn-danger'
            );
    
            echo json_encode( $data ); exit();
        }

        $rows2 = Staff::where([
            'identification_no' => $request->identification_no
        ])->count();

        if ($rows2 > 0) {
            $data = array(
                'title' => 'Oh snap!',
                'text' => 'The staff number is already in use.',
                'type' => 'error',
                'error' => 'identification_no',
                'class' => 'btn-danger'
            );
    
            echo json_encode( $data ); exit();
        }

        $rows3 = User::where([
            'username' => $request->username
        ])->count();

        if ($rows3 > 0) {
            $data = array(
                'title' => 'Oh snap!',
                'text' => 'The username is already in use.',
                'type' => 'error',
                'error' => 'username',
                'class' => 'btn-danger'
            );
    
            echo json_encode( $data ); exit();
        }
        
        $user = User::create([
            'name' => $request->firstname.' '.$request->lastname,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
            'type' => 'staff'
        ]);

        if (!$user) {
            throw new NotFoundHttpException();
        }  

        $userRole = UserRole::create([
            'user_id' => $user->id,
            'role_id' => 3,
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);

        $staff = Staff::create([
            'user_id' => $user->id,
            'role_id' => $request->role_id,
            'department_id' => $request->department_id,
            'designation_id' => $request->designation_id,
            'identification_no' => $request->identification_no,
            'type' => $request->type,
            'specification' => $request->specification,
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
            'contact_fullname' => ($request->contact_fullname !== NULL) ? $request->contact_fullname : NULL,
            'contact_relation' => ($request->contact_relation !== NULL) ? $request->contact_relation : NULL,
            'contact_phone_no' => ($request->contact_phone_no !== NULL) ? $request->contact_phone_no : NULL,
            'sss_no' => ($request->sss_no !== NULL) ? $request->sss_no : NULL,
            'tin_no' => ($request->tin_no !== NULL) ? $request->tin_no : NULL,
            'pag_ibig_no' => ($request->pag_ibig_no !== NULL) ? $request->pag_ibig_no : NULL,
            'philhealth_no' => ($request->philhealth_no !== NULL) ? $request->philhealth_no : NULL,
            'elementary_graduated' => ($request->elementary_graduated !== NULL) ? $request->elementary_graduated : NULL,
            'secondary_graduated' => ($request->secondary_graduated !== NULL) ? $request->secondary_graduated : NULL,
            'tertiary_graduated' => ($request->tertiary_graduated !== NULL) ? $request->tertiary_graduated : NULL,
            'course_taken' => ($request->course_taken !== NULL) ? $request->course_taken : NULL,
            'master_graduated' => ($request->master_graduated !== NULL) ? $request->master_graduated : NULL,
            'course_specialization' => ($request->course_specialization !== NULL) ? $request->course_specialization : NULL,
            'graduate_school_status' => ($request->graduate_school_status !== NULL) ? $request->graduate_school_status : NULL,
            'date_of_graduation' => ($request->date_of_graduation !== NULL) ? $request->date_of_graduation : NULL,
            'other_educational_attainment' => ($request->other_educational_attainment !== NULL) ? $request->other_educational_attainment : NULL,
            'government_examination' => ($request->government_examination !== NULL) ? $request->government_examination : NULL,
            'work_experience' => ($request->work_experience !== NULL) ? $request->work_experience : NULL,
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

        $rows = User::where([
            'email' => $request->email,
        ])
        ->where('id', '!=', $staff->user_id)
        ->count();

        if ($rows > 0) {
            $data = array(
                'title' => 'Oh snap!',
                'text' => 'The email is already in use.',
                'type' => 'error',
                'error' => 'email',
                'class' => 'btn-danger'
            );
    
            echo json_encode( $data ); exit();
        }

        $rows2 = Staff::where([
            'identification_no' => $request->identification_no
        ])
        ->where('id', '!=', $id)
        ->count();

        if ($rows2 > 0) {
            $data = array(
                'title' => 'Oh snap!',
                'text' => 'The staff number is already in use.',
                'type' => 'error',
                'error' => 'identification_no',
                'class' => 'btn-danger'
            );
    
            echo json_encode( $data ); exit();
        }

        $rows3 = User::where([
            'username' => $request->username
        ])
        ->where('id', '!=', $staff->user_id)
        ->count();

        if ($rows3 > 0) {
            $data = array(
                'title' => 'Oh snap!',
                'text' => 'The username is already in use.',
                'type' => 'error',
                'error' => 'username',
                'class' => 'btn-danger'
            );
    
            echo json_encode( $data ); exit();
        }

        $user_id = $staff->user_id;
        $staff->role_id = $request->role_id;
        $staff->identification_no = $request->identification_no;
        $staff->department_id = $request->department_id;
        $staff->designation_id = $request->designation_id;
        $staff->type = $request->type;
        $staff->specification = $request->specification;
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
        $staff->contact_fullname = ($request->contact_fullname !== NULL) ? $request->contact_fullname : NULL;
        $staff->contact_relation = ($request->contact_relation !== NULL) ? $request->contact_relation : NULL;
        $staff->contact_phone_no = ($request->contact_phone_no !== NULL) ? $request->contact_phone_no : NULL;
        $staff->sss_no = ($request->sss_no !== NULL) ? $request->sss_no : NULL;
        $staff->tin_no = ($request->tin_no !== NULL) ? $request->tin_no : NULL;
        $staff->pag_ibig_no = ($request->pag_ibig_no !== NULL) ? $request->pag_ibig_no : NULL;
        $staff->philhealth_no = ($request->philhealth_no !== NULL) ? $request->philhealth_no : NULL;
        $staff->elementary_graduated = ($request->elementary_graduated !== NULL) ? $request->elementary_graduated : NULL;
        $staff->secondary_graduated = ($request->secondary_graduated !== NULL) ? $request->secondary_graduated : NULL;
        $staff->tertiary_graduated = ($request->tertiary_graduated !== NULL) ? $request->tertiary_graduated : NULL;
        $staff->course_taken = ($request->course_taken !== NULL) ? $request->course_taken : NULL;
        $staff->master_graduated = ($request->master_graduated !== NULL) ? $request->master_graduated : NULL;
        $staff->course_specialization = ($request->course_specialization !== NULL) ? $request->course_specialization : NULL;
        $staff->graduate_school_status = ($request->graduate_school_status !== NULL) ? $request->graduate_school_status : NULL;
        $staff->date_of_graduation = ($request->date_of_graduation !== NULL) ? $request->date_of_graduation : NULL;
        $staff->other_educational_attainment = ($request->other_educational_attainment !== NULL) ? $request->other_educational_attainment : NULL;
        $staff->government_examination = ($request->government_examination !== NULL) ? $request->government_examination : NULL;
        $staff->work_experience = ($request->work_experience !== NULL) ? $request->work_experience : NULL;
        $staff->updated_at = $timestamp;
        $staff->updated_by = Auth::user()->id;

        if ($staff->update()) {
            $user = User::where('id', '=', $user_id)->first();
            if ($user->password != $request->password) {
                User::where('id', '=', $user_id)
                ->update([
                    'name' => $request->firstname.' '.$request->lastname,
                    'email' => $request->email,
                    'username' => $request->username,
                    'password' => Hash::make($request->password)
                ]);
            } else {
                User::where('id', '=', $user_id)
                ->update([
                    'name' => $request->firstname.' '.$request->lastname,
                    'email' => $request->email,
                    'username' => $request->username
                ]);
            }

            $exist = UserRole::where('user_id', $user_id)->count();
            if (!($exist > 0)) {
                $userRole = UserRole::create([
                    'user_id' => $user_id,
                    'role_id' => 3,
                    'created_at' => $timestamp,
                    'created_by' => Auth::user()->id
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

    public function import(Request $request)
    {   
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
                            $exist = Staff::where('identification_no', $data[0])->get();
                            if ($exist->count() > 0) {
                                $staff = Staff::find($exist->first()->id);
                                $user_id = $staff->user_id;
                                $staff->role_id = 3;
                                $staff->identification_no = $data[0];
                                $staff->department_id = Department::where('name', $data[19])->first()->id;
                                $staff->designation_id = Designation::where('name', $data[20])->first()->id;
                                $staff->type = $data[18];
                                $staff->specification = $data[21];
                                $staff->firstname = $data[1];
                                $staff->middlename = $data[2];
                                $staff->lastname = $data[3];
                                $staff->suffix = $data[4];
                                $staff->gender = $data[7];
                                $staff->marital_status = $data[5];
                                $staff->birthdate = date('Y-m-d', strtotime($data[6]));
                                $staff->current_address = $data[8];
                                $staff->permanent_address = ($data[9] !== '') ? $data[9] : NULL;
                                $staff->mobile_no = ($data[11] !== '') ? $data[11] : NULL;
                                $staff->telephone_no = ($data[10] !== '') ? $data[10] : NULL;
                                $staff->date_joined =  date('Y-m-d', strtotime($data[22]));
                                $staff->date_resigned = ($data[23] !== NULL) ? date('Y-m-d', strtotime($data[23])) : NULL;
                                $staff->contact_fullname = ($data[12] !== '') ? $data[12] : NULL;
                                $staff->contact_relation = ($data[13] !== '') ? $data[13] : NULL;
                                $staff->contact_phone_no = ($data[14] !== '') ? $data[14] : NULL;
                                $staff->sss_no = ($data[24] !== '') ? $data[24] : NULL;
                                $staff->tin_no = ($data[25] !== '') ? $data[25] : NULL;
                                $staff->pag_ibig_no = ($data[26] !== '') ? $data[26] : NULL;
                                $staff->philhealth_no = ($data[27] !== '') ? $data[27] : NULL;
                                $staff->elementary_graduated = ($data[28] !== '') ? $data[28] : NULL;
                                $staff->secondary_graduated = ($data[29] !== '') ? $data[29] : NULL;
                                $staff->tertiary_graduated = ($data[30] !== '') ? $data[30] : NULL;
                                $staff->course_taken = ($data[31] !== '') ? $data[31] : NULL;
                                $staff->master_graduated = ($data[32] !== '') ? $data[32] : NULL;
                                $staff->course_specialization = ($data[33] !== '') ? $data[33] : NULL;
                                $staff->graduate_school_status = ($data[34] !== '') ? $data[34] : NULL;
                                $staff->date_of_graduation = ($data[35] !== '') ? $data[35] : NULL;
                                $staff->other_educational_attainment = ($data[36] !== '') ? $data[36] : NULL;
                                $staff->government_examination = ($data[37] !== '') ? $data[37] : NULL;
                                $staff->work_experience = ($data[38] !== '') ? $data[38] : NULL;
                                $staff->is_active = 1;
                                $staff->updated_at = $timestamp;
                                $staff->updated_by = Auth::user()->id;

                                if ($staff->update()) {
                                    $user = User::where('id', '=', $user_id)->first();
                                    if ($user->password != $data[17]) {
                                        User::where('id', '=', $user_id)
                                        ->update([
                                            'name' => $data[1].' '.$data[3],
                                            'email' => $data[15],
                                            'username' => $data[16],
                                            'password' => Hash::make($data[17])
                                        ]);
                                    } else {
                                        User::where('id', '=', $user_id)
                                        ->update([
                                            'name' => $data[1].' '.$data[3],
                                            'email' => $data[15],
                                            'username' => $data[16]
                                        ]);
                                    }

                                    $exist = UserRole::where('user_id', $user_id)->count();
                                    if (!($exist > 0)) {
                                        $userRole = UserRole::create([
                                            'user_id' => $user_id,
                                            'role_id' => 3,
                                            'created_at' => $timestamp,
                                            'created_by' => Auth::user()->id
                                        ]);
                                    }
                                }
                            } else {
                                $user = User::create([
                                    'name' => $data[1].' '.$data[3],
                                    'username' => $data[16],
                                    'email' => $data[15],
                                    'password' => $data[17],
                                    'type' => 'staff'
                                ]);
                        
                                if (!$user) {
                                    throw new NotFoundHttpException();
                                }  
                        
                                $userRole = UserRole::create([
                                    'user_id' => $user->id,
                                    'role_id' => 3,
                                    'created_at' => $timestamp,
                                    'created_by' => Auth::user()->id
                                ]);
                        
                                $staff = Staff::create([
                                    'user_id' => $user->id,
                                    'role_id' => 3,
                                    'department_id' => Department::where('name', $data[19])->first()->id,
                                    'designation_id' => Designation::where('name', $data[20])->first()->id,
                                    'identification_no' => $data[0],
                                    'type' => $data[18],
                                    'specification' => $data[21],
                                    'firstname' => $data[1],
                                    'middlename' => $data[2],
                                    'lastname' => $data[3],
                                    'suffix' => $data[4],
                                    'gender' => $data[7],
                                    'marital_status' => $data[5],
                                    'birthdate' => date('Y-m-d', strtotime($data[6])),
                                    'current_address' => $data[8],
                                    'permanent_address' => ($data[9] !== '') ? $data[9] : NULL,
                                    'mobile_no' => ($data[11] !== '') ? $data[11] : NULL,
                                    'telephone_no' => ($data[10] !== '') ? $data[10] : NULL,
                                    'date_joined' => date('Y-m-d', strtotime($data[22])),
                                    'date_resigned' => ($data[23] !== '') ? date('Y-m-d', strtotime($data[23])) : NULL,
                                    'avatar' => NULL,
                                    'contact_fullname' => ($data[12] !== '') ? $data[12] : NULL,
                                    'contact_relation' => ($data[13] !== '') ? $data[13] : NULL,
                                    'contact_phone_no' => ($data[14] !== '') ? $data[14] : NULL,
                                    'sss_no' => ($data[24] !== '') ? $data[24] : NULL,
                                    'tin_no' => ($data[25] !== '') ? $data[25] : NULL,
                                    'pag_ibig_no' => ($data[26] !== '') ? $data[26] : NULL,
                                    'philhealth_no' => ($data[27] !== '') ? $data[27] : NULL,
                                    'elementary_graduated' => ($data[28] !== '') ? $data[28] : NULL,
                                    'secondary_graduated' => ($data[29] !== '') ? $data[29] : NULL,
                                    'tertiary_graduated' => ($data[30] !== '') ? $data[30] : NULL,
                                    'course_taken' => ($data[31] !== '') ? $data[31] : NULL,
                                    'master_graduated' => ($data[32] !== '') ? $data[32] : NULL,
                                    'course_specialization' => ($data[33] !== '') ? $data[33] : NULL,
                                    'graduate_school_status' => ($data[34] !== '') ? $data[34] : NULL,
                                    'date_of_graduation' => ($data[35] !== '') ? $data[35] : NULL,
                                    'other_educational_attainment' => ($data[36] !== '') ? $data[36] : NULL,
                                    'government_examination' => ($data[37] !== '') ? $data[37] : NULL,
                                    'work_experience' => ($data[38] !== '') ? $data[38] : NULL,
                                    'created_at' => $timestamp,
                                    'created_by' => Auth::user()->id
                                ]);
                            }
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

    public function generate_staff_no()
    {
        $staffNo = (new Staff)->generate_staff_no();
        return $staffNo;
    }
}
