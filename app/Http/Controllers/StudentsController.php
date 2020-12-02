<?php

namespace App\Http\Controllers;

use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Guardian;
use App\Models\GuardianUser;
use App\Models\Sibling;
use App\Models\UserRole;
use App\Models\AuditLog;
use App\User;
use Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\File;
use App\Components\FlashMessages;
use App\Helper\Helper;

class StudentsController extends Controller
{   
    use FlashMessages;
    private $models;

    public function __construct()
    {   
        ini_set('max_execution_time', 0);
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
        return view('modules/memberships/students/manage')->with(compact('menus'));
    }

    public function manage(Request $request)
    {   
        $this->is_permitted(1);
        $menus = $this->load_menus();
        return view('modules/memberships/students/manage')->with(compact('menus'));
    }

    public function inactive(Request $request)
    {   
        $this->is_permitted(1);
        $menus = $this->load_menus();
        return view('modules/memberships/students/inactive')->with(compact('menus'));
    }

    public function all_active(Request $request)
    {
        $res = Student::where('is_active', 1)
        ->with([
            'user' =>  function($q) { 
                $q->select(['id', 'email']); 
            }
        ])->orderBy('id', 'DESC')->get();

        return $res->map(function($student) {
            $middlename = !empty($student->middlename) ? $student->middlename : '';
            $designation = ($student->designation_id > 0) ? '('.$student->designation->name.')' : '';
            return [
                'studentID' => $student->id,
                'studentNumber' => $student->identification_no,
                'studentName' => $student->firstname.' '.$middlename.' '.$student->lastname,
                'studentGender' => $student->gender,
                'studentEmail' => $student->user->email,
                'studentContactNo' => $student->mobile_no,
                'studentModified' => ($student->updated_at !== NULL) ? date('d-M-Y', strtotime($student->updated_at)).'<br/>'. date('h:i A', strtotime($student->updated_at)) : date('d-M-Y', strtotime($student->created_at)).'<br/>'. date('h:i A', strtotime($student->created_at))
            ];
        });
    }

    public function all_inactive(Request $request)
    {
        $res = Student::where('is_active', 0)
        ->with([
            'user' =>  function($q) { 
                $q->select(['id', 'email']); 
            }
        ])->orderBy('id', 'DESC')->get();

        return $res->map(function($student) {
            $middlename = !empty($student->middlename) ? $student->middlename : '';
            return [
                'studentID' => $student->id,
                'studentNumber' => $student->identification_no,
                'studentName' => $student->firstname.' '.$middlename.' '.$student->lastname,
                'studentGender' => $student->gender,
                'studentEmail' => $student->user->email,
                'studentContactNo' => $student->mobile_no,
                'studentModified' => ($student->updated_at !== NULL) ? date('d-M-Y', strtotime($student->updated_at)).'<br/>'. date('h:i A', strtotime($student->updated_at)) : date('d-M-Y', strtotime($student->created_at)).'<br/>'. date('h:i A', strtotime($student->created_at))
            ];
        });
    }

    public function uploads(Request $request)
    {   
        if ($request->get('id') != '') {
            $folderID = $request->get('id');
            $motherFolder = str_replace('S', 'M', $request->get('id'));
            $fatherFolder = str_replace('S', 'F', $request->get('id'));
        } else {
            Storage::disk('uploads')->makeDirectory($request->get('files').'/'.$this->generate_student_no());
            Storage::disk('uploads')->makeDirectory('guardians/mother/'.str_replace('S', 'M', $this->generate_student_no()));
            Storage::disk('uploads')->makeDirectory('guardians/father/'.str_replace('S', 'F', $this->generate_student_no()));
            $folderID = $this->generate_student_no();
            $motherFolder = str_replace('S', 'M', $this->generate_student_no());
            $fatherFolder = str_replace('S', 'F', $this->generate_student_no());
        }

        $files = array();

        foreach($_FILES as $file)
        {   
            $filename = basename($file['name']);
            if ($file == 'mother_avatar') {
                $files[] = Storage::put('guardians/'.$motherFolder.'/'.$filename, (string) file_get_contents($file['tmp_name']));
            } else if ($file == 'father_avatar') {
                $files[] = Storage::put('guardians/'.$fatherFolder.'/'.$filename, (string) file_get_contents($file['tmp_name']));
            } else {
                $files[] = Storage::put($request->get('files').'/'.$folderID.'/'.$filename, (string) file_get_contents($file['tmp_name']));
            }
        }

        $data = array('files' => $files);
        echo json_encode( $data ); exit();
    }

    public function downloads(Request $request) {
        $folderID = $request->get('id');
        $filename = $request->get('filename');
        return response()->download(storage_path('app/public/uploads/'.$request->get('files').'/'.$folderID.'/'.$filename));
    }

    public function add(Request $request, $id = '')
    {   
        $this->is_permitted(0);
        $menus = $this->load_menus();
        $segment = request()->segment(3);
        $student = (new Student)->fetch($id);
        $civils = (new Student)->marital_status();
        return view('modules/memberships/students/add')->with(compact('menus', 'student', 'civils', 'segment'));
    }
    
    public function edit(Request $request, $id)
    {   
        $this->is_permitted(2);
        $menus = $this->load_menus();
        $segment = request()->segment(3);
        $student = (new Student)->fetch($id);
        $civils = (new Student)->marital_status();
        return view('modules/memberships/students/edit')->with(compact('menus', 'student', 'civils', 'segment'));
    }
    
    public function store(Request $request)
    {    
        $this->is_permitted(0); 
        $timestamp = date('Y-m-d H:i:s');
        $email = $request->email;
        $mother_email =  $request->mother_email;
        $father_email = $request->father_email;

        $rows = User::where(function($query) use ($email, $mother_email, $father_email){
            $query->orWhere('email', $email);
            $query->orWhere('email', $mother_email);
            $query->orWhere('email', $father_email);
        })
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

        $rows2 = Student::where([
            'identification_no' => $request->identification_no
        ])->count();

        if ($rows2 > 0) {
            $data = array(
                'title' => 'Oh snap!',
                'text' => 'The student number is already in use.',
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
            'type' => 'student'
        ]);

        if (!$user) {
            throw new NotFoundHttpException();
        }  

        $this->audit_logs('users', $user->id, 'has inserted a new user.', User::find($user->id), $timestamp, Auth::user()->id);

        $userRole = UserRole::create([
            'user_id' => $user->id,
            'role_id' => 4,
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);
        $this->audit_logs('users_roles', $userRole->id, 'has inserted a new user role.', UserRole::find($userRole->id), $timestamp, Auth::user()->id);

        $student = Student::create([
            'user_id' => $user->id,
            'role_id' => $request->role_id,
            'identification_no' => $request->identification_no,
            'learners_reference_no' => $request->learners_reference_no,
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
            'admitted_date' => date('Y-m-d', strtotime($request->admitted_date)),
            'special_remarks' => ($request->special_remarks !== NULL) ? $request->special_remarks : NULL, 
            'is_guardian' => ($request->is_guardian !== NULL) ? 1 : 0, 
            'is_sibling' => ($request->is_sibling !== NULL) ? 1 : 0, 
            'avatar' => $request->get('avatar'),
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);

        if ($request->is_guardian !== NULL) {
            $guardian = Guardian::create([
                'student_id' => $student->id,
                'mother_firstname' => $request->mother_firstname,
                'mother_middlename' => ($request->mother_middlename !== NULL) ? $request->mother_middlename : NULL, 
                'mother_lastname' => $request->mother_lastname,
                'mother_contact_no' => $request->mother_contact_no,
                'mother_email' => $request->mother_email,
                'mother_address' => ($request->mother_address !== NULL) ? $request->mother_address : NULL,
                'mother_avatar' => $request->get('mother_avatar'),
                'mother_selected' => ($request->guardian_selected == 'Mother') ? 1 : 0,
                'father_firstname' => $request->father_firstname,
                'father_middlename' => ($request->father_middlename !== NULL) ? $request->father_middlename : NULL, 
                'father_lastname' => $request->father_lastname,
                'father_contact_no' => $request->father_contact_no,
                'father_email' => $request->father_email,
                'father_address' => ($request->father_address !== NULL) ? $request->father_address : NULL,
                'father_avatar' => $request->get('father_avatar'),
                'father_selected' => ($request->guardian_selected == 'Father') ? 1 : 0,
                'created_at' => $timestamp,
                'created_by' => Auth::user()->id
            ]);
            $this->audit_logs('guardians', $guardian->id, 'has inserted a new guardian.', Guardian::find($guardian->id), $timestamp, Auth::user()->id);

            $mother_user = User::create([
                'name' => $request->mother_firstname.' '.$request->mother_lastname,
                'username' => 'M'.$student->identification_no,
                'email' => $request->mother_email,
                'password' => (new Student)->random(),
                'type' => 'parent'
            ]);
            $this->audit_logs('users', $mother_user->id, 'has inserted a new user.', User::find($mother_user->id), $timestamp, Auth::user()->id);

            $motherRole = UserRole::create([
                'user_id' => $mother_user->id,
                'role_id' => 5,
                'created_at' => $timestamp,
                'created_by' => Auth::user()->id
            ]);
            $this->audit_logs('users_roles', $motherRole->id, 'has inserted a new user role.', UserRole::find($motherRole->id), $timestamp, Auth::user()->id);

            $mother_guardian_user = GuardianUser::create([
                'guardian_id' => $guardian->id,
                'user_id' => $mother_user->id,
                'created_at' => $timestamp,
                'created_by' => Auth::user()->id
            ]);
            $this->audit_logs('guardians_users', $mother_guardian_user->id, 'has inserted a new guardian user.', GuardianUser::find($mother_guardian_user->id), $timestamp, Auth::user()->id);

            $father_user = User::create([
                'name' => $request->father_firstname.' '.$request->father_lastname,
                'username' => 'F'.$student->identification_no,
                'email' => $request->father_email,
                'password' => (new Student)->random(),
                'type' => 'parent'
            ]);
            $this->audit_logs('users', $father_user->id, 'has inserted a new user.', User::find($father_user->id), $timestamp, Auth::user()->id);

            $fatherRole = UserRole::create([
                'user_id' => $father_user->id,
                'role_id' => 5,
                'created_at' => $timestamp,
                'created_by' => Auth::user()->id
            ]);
            $this->audit_logs('users_roles', $fatherRole->id, 'has inserted a new user role.', UserRole::find($fatherRole->id), $timestamp, Auth::user()->id);

            $father_guardian_user = GuardianUser::create([
                'guardian_id' => $guardian->id,
                'user_id' => $father_user->id,
                'created_at' => $timestamp,
                'created_by' => Auth::user()->id
            ]);
            $this->audit_logs('guardians_users', $father_guardian_user->id, 'has inserted a new guardian user.', GuardianUser::find($father_guardian_user->id), $timestamp, Auth::user()->id);
        }

        if ($request->is_sibling !== NULL) {
            foreach ($request->sibling as $sibling) {
                if ($sibling !== NULL) {
                    $siblings = Sibling::create([
                        'student_id' => $student->id,
                        'sibling_id' => Student::where('identification_no', substr($sibling, 0, 10))->first()->id,
                        'created_at' => $timestamp,
                        'created_by' => Auth::user()->id
                    ]);
                    $this->audit_logs('siblings', $siblings->id, 'has inserted a new sibling.', Sibling::find($siblings->id), $timestamp, Auth::user()->id);
                }
            }
        }

        if (!$student) {
            throw new NotFoundHttpException();
        }

        $this->audit_logs('students', $student->id, 'has inserted a new student.', Student::find($student->id), $timestamp, Auth::user()->id);

        $data = array(
            'title' => 'Well done!',
            'text' => 'The student has been successfully saved.',
            'type' => 'success',
            'class' => 'btn-brand'
        );

        echo json_encode( $data ); exit();
    }

    public function update(Request $request, $id)
    {    
        $this->is_permitted(2);  
        $timestamp = date('Y-m-d H:i:s');
        $student = Student::find($id);
        $email = $request->email;
        $mother_email = $request->mother_email;
        $father_email = $request->father_email;
        $user_id = $student->user_id;

        if(!$student) {
            throw new NotFoundHttpException();
        }

        $rows = User::where(function($query) use ($email){
            $query->orWhere('email', $email);
        })
        ->where('id', '!=', $user_id)
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

        $rows2 = Student::where([
            'identification_no' => $request->identification_no
        ])
        ->where('id', '!=', $id)
        ->count();

        if ($rows2 > 0) {
            $data = array(
                'title' => 'Oh snap!',
                'text' => 'The student number is already in use.',
                'type' => 'error',
                'error' => 'identification_no',
                'class' => 'btn-danger'
            );
    
            echo json_encode( $data ); exit();
        }

        $rows3 = User::where([
            'username' => $request->username
        ])
        ->where('id', '!=', $user_id)
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

        if ($request->is_guardian !== NULL) {
            $guardian = Guardian::where('student_id', $id)->get();
            if ($guardian->count() > 0) {
                $guardian = $guardian->first()->id;
                $motherUser = GuardianUser::where('guardian_id', $guardian)->orderBy('id', 'asc')->get();
                if ($motherUser->count() > 0) {
                    $motherUser = $motherUser->first()->user_id;
                }
                $fatherUser = GuardianUser::where('guardian_id', $guardian)->orderBy('id', 'desc')->get();
                if ($fatherUser->count() > 0) {
                    $fatherUser = $fatherUser->first()->user_id;
                }

                $rows = User::where(function ($query) use ($user_id, $email) {
                    $query->where('id', '!=', $user_id)->where('email', $email);
                })->orWhere(function($query) use ($motherUser, $mother_email) {
                    $query->where('id', '!=', $motherUser)->where('email', $mother_email);
                })->orWhere(function($query) use ($fatherUser, $father_email) {
                    $query->where('id', '!=', $fatherUser)->where('email', $father_email);
                })->count();    

                if ($rows > 0) {
                    $data = array(
                        'title' => 'Oh snap!',
                        'rows' => $rows,
                        'text' => 'The email is already in use.',
                        'type' => 'error',
                        'class' => 'btn-danger'
                    );
            
                    echo json_encode( $data ); exit();
                }
            }
        }

        $student->role_id = $request->role_id;
        $student->identification_no = $request->identification_no;
        $student->learners_reference_no = $request->learners_reference_no;
        $student->firstname = $request->firstname;
        $student->middlename = $request->middlename;
        $student->lastname = $request->lastname;
        $student->suffix = $request->suffix;
        $student->gender = $request->gender;
        $student->marital_status = $request->marital_status;
        $student->birthdate = date('Y-m-d', strtotime($request->birthdate));
        $student->current_address = $request->current_address;
        $student->permanent_address = ($request->permanent_address !== NULL) ? $request->permanent_address : NULL;
        $student->mobile_no = ($request->mobile_no !== NULL) ? $request->mobile_no : NULL;
        $student->telephone_no = ($request->telephone_no !== NULL) ? $request->telephone_no : NULL;
        $student->admitted_date = date('Y-m-d', strtotime($request->admitted_date));
        $student->special_remarks = ($request->special_remarks !== NULL) ? $request->special_remarks : NULL;
        $student->is_guardian = ($request->is_guardian !== NULL) ? 1 : 0; 
        $student->is_sibling = ($request->is_sibling !== NULL) ? 1 : 0; 
        if ($request->get('avatar') !== NULL) {
            $student->avatar = $request->get('avatar');
        }
        $student->updated_at = $timestamp;
        $student->updated_by = Auth::user()->id;

        if ($student->update()) {
            $password = User::where('id', $user_id)->pluck('password');
            if ($password != $request->password) {
                User::where('id', $user_id)
                ->update([
                    'name' => $request->firstname.' '.$request->lastname,
                    'email' => $request->email,
                    'username' => $request->username,
                    'password' => Hash::make($request->password)
                ]);
            } else {
                User::where('id', $user_id)
                ->update([
                    'name' => $request->firstname.' '.$request->lastname,
                    'email' => $request->email,
                    'username' => $request->username,
                ]);
            }
            $this->audit_logs('users', $user_id, 'has modified a user.', User::find($user_id), $timestamp, Auth::user()->id);
            
            $exist = UserRole::where('user_id', $user_id)->count();
            if (!($exist > 0)) {
                $userRole = UserRole::create([
                    'user_id' => $user_id,
                    'role_id' => 4,
                    'created_at' => $timestamp,
                    'created_by' => Auth::user()->id
                ]);
                $this->audit_logs('users_roles', $userRole->id, 'has inserted a new user role.', UserRole::find($userRole->id), $timestamp, Auth::user()->id);
            }

            if ($request->is_guardian !== NULL) {
                $guardian = Guardian::where([
                    'student_id' => $id,
                ])
                ->update([
                    'mother_firstname' => $request->mother_firstname,
                    'mother_middlename' => ($request->mother_middlename !== NULL) ? $request->mother_middlename : NULL, 
                    'mother_lastname' => $request->mother_lastname,
                    'mother_contact_no' => $request->mother_contact_no,
                    'mother_email' => $request->mother_email,
                    'mother_address' => ($request->mother_address !== NULL) ? $request->mother_address : NULL, 
                    'mother_selected' => ($request->guardian_selected == 'Mother') ? 1 : 0,
                    'father_firstname' => $request->father_firstname,
                    'father_middlename' => ($request->father_middlename !== NULL) ? $request->father_middlename : NULL, 
                    'father_lastname' => $request->father_lastname,
                    'father_contact_no' => $request->father_contact_no,
                    'father_email' => $request->father_email,
                    'father_address' => ($request->father_address !== NULL) ? $request->father_address : NULL, 
                    'father_selected' => ($request->guardian_selected == 'Father') ? 1 : 0,
                    'updated_at' => $timestamp,
                    'updated_by' => Auth::user()->id,
                    'is_active' => 1
                ]);

                if ($request->get('mother_avatar') !== NULL) {
                    $guardian = Guardian::where([
                        'student_id' => $id,
                    ])
                    ->update([
                        'mother_avatar' => $request->get('mother_avatar')
                    ]);
                }

                if ($request->get('father_avatar') !== NULL) {
                    $guardian = Guardian::where([
                        'student_id' => $id,
                    ])
                    ->update([
                        'father_avatar' => $request->get('father_avatar')
                    ]);
                }

                $guardian = Guardian::where(['student_id' => $id])->get();
                if ($guardian->count() > 0) {
                    $this->audit_logs('guardians', $guardian->first()->id, 'has modified a guardian.', Guardian::find($guardian->first()->id), $timestamp, Auth::user()->id);
                } else {
                    $guardian = Guardian::create([
                        'student_id' => $student->id,
                        'mother_firstname' => $request->mother_firstname,
                        'mother_middlename' => ($request->mother_middlename !== NULL) ? $request->mother_middlename : NULL, 
                        'mother_lastname' => $request->mother_lastname,
                        'mother_contact_no' => $request->mother_contact_no,
                        'mother_email' => $request->mother_email,
                        'mother_address' => ($request->mother_address !== NULL) ? $request->mother_address : NULL,
                        'mother_avatar' => $request->get('mother_avatar'),
                        'mother_selected' => ($request->guardian_selected == 'Mother') ? 1 : 0,
                        'father_firstname' => $request->father_firstname,
                        'father_middlename' => ($request->father_middlename !== NULL) ? $request->father_middlename : NULL, 
                        'father_lastname' => $request->father_lastname,
                        'father_contact_no' => $request->father_contact_no,
                        'father_email' => $request->father_email,
                        'father_address' => ($request->father_address !== NULL) ? $request->father_address : NULL,
                        'father_avatar' => $request->get('father_avatar'),
                        'father_selected' => ($request->guardian_selected == 'Father') ? 1 : 0,
                        'created_at' => $timestamp,
                        'created_by' => Auth::user()->id
                    ]);
                    $this->audit_logs('guardians', $guardian->id, 'has inserted a new guardian.', Guardian::find($guardian->id), $timestamp, Auth::user()->id);
                }

                $mother_user = User::where([
                    'username' => 'M'.$student->identification_no
                ])
                ->update([
                    'name' => $request->mother_firstname.' '.$request->mother_lastname,
                    'email' => $mother_email,
                    'updated_at' => $timestamp
                ]);
                $mother_user = User::where(['username' => 'M'.$student->identification_no])->get();
                if ($mother_user->count() > 0) {
                    $this->audit_logs('users', $mother_user->first()->id, 'has modified a user.', User::find($mother_user->first()->id), $timestamp, Auth::user()->id);
                    $motherExist = UserRole::where('user_id', $mother_user->first()->id)->count();
                    if (!($motherExist > 0)) {
                        $userRole = UserRole::create([
                            'user_id' => $mother_user->id,
                            'role_id' => 5,
                            'created_at' => $timestamp,
                            'created_by' => Auth::user()->id
                        ]);
                        $this->audit_logs('users_roles', $userRole->id, 'has insert a new user role.', UserRole::find($userRole->id), $timestamp, Auth::user()->id);
                    }
                } else {
                    $mother_user = User::create([
                        'name' => $request->mother_firstname.' '.$request->mother_lastname,
                        'username' => 'M'.$student->identification_no,
                        'email' => $request->mother_email,
                        'password' => (new Student)->random(),
                        'type' => 'parent'
                    ]);
                    $this->audit_logs('users', $mother_user->id, 'has inserted a new user.', User::find($mother_user->id), $timestamp, Auth::user()->id);
        
                    $motherRole = UserRole::create([
                        'user_id' => $mother_user->id,
                        'role_id' => 5,
                        'created_at' => $timestamp,
                        'created_by' => Auth::user()->id
                    ]);
                    $this->audit_logs('users_roles', $motherRole->id, 'has inserted a new user role.', UserRole::find($motherRole->id), $timestamp, Auth::user()->id);
        
                    $mother_guardian_user = GuardianUser::create([
                        'guardian_id' => $guardian->id,
                        'user_id' => $mother_user->id,
                        'created_at' => $timestamp,
                        'created_by' => Auth::user()->id
                    ]);
                    $this->audit_logs('guardians_users', $mother_guardian_user->id, 'has inserted a new guardian user.', GuardianUser::find($mother_guardian_user->id), $timestamp, Auth::user()->id);
                }
    
                $father_user = User::where([
                    'username' => 'F'.$student->identification_no
                ])
                ->update([
                    'name' => $request->father_firstname.' '.$request->father_lastname,
                    'email' => $father_email,
                    'updated_at' => $timestamp
                ]);
                $father_user = User::where(['username' => 'F'.$student->identification_no])->get();
                if ($father_user->count() > 0) {
                    $this->audit_logs('users', $father_user->first()->id, 'has modified a user.', User::find($father_user->first()->id), $timestamp, Auth::user()->id);
                    $fatherExist = UserRole::where('user_id', $father_user->first()->id)->count();
                    if (!($fatherExist > 0)) {
                        $userRole = UserRole::create([
                            'user_id' => $father_user->id,
                            'role_id' => 5,
                            'created_at' => $timestamp,
                            'created_by' => Auth::user()->id
                        ]);
                        $this->audit_logs('users_roles', $userRole->id, 'has insert a new user role.', UserRole::find($userRole->id), $timestamp, Auth::user()->id);
                    }
                } else {
                    $father_user = User::create([
                        'name' => $request->father_firstname.' '.$request->father_lastname,
                        'username' => 'F'.$student->identification_no,
                        'email' => $request->father_email,
                        'password' => (new Student)->random(),
                        'type' => 'parent'
                    ]);
                    $this->audit_logs('users', $father_user->id, 'has inserted a new user.', User::find($father_user->id), $timestamp, Auth::user()->id);
        
                    $fatherRole = UserRole::create([
                        'user_id' => $father_user->id,
                        'role_id' => 5,
                        'created_at' => $timestamp,
                        'created_by' => Auth::user()->id
                    ]);
                    $this->audit_logs('users_roles', $fatherRole->id, 'has inserted a new user role.', UserRole::find($fatherRole->id), $timestamp, Auth::user()->id);
        
                    $father_guardian_user = GuardianUser::create([
                        'guardian_id' => $guardian->id,
                        'user_id' => $father_user->id,
                        'created_at' => $timestamp,
                        'created_by' => Auth::user()->id
                    ]);
                    $this->audit_logs('guardians_users', $father_guardian_user->id, 'has inserted a new guardian user.', GuardianUser::find($father_guardian_user->id), $timestamp, Auth::user()->id);
                }
            }

            Sibling::where('student_id', $student->id)->forceDelete();
            if ($request->is_sibling !== NULL) {
                foreach ($request->sibling as $sibling) {
                    if ($sibling !== NULL) {
                        $siblings = Sibling::create([
                            'student_id' => $student->id,
                            'sibling_id' => Student::where('identification_no', substr($sibling, 0, 10))->first()->id,
                            'created_at' => $timestamp,
                            'created_by' => Auth::user()->id
                        ]);
                        $this->audit_logs('siblings', $siblings->id, 'has inserted a new sibling.', Sibling::find($siblings->id), $timestamp, Auth::user()->id);
                    }
                }
            }

            $this->audit_logs('students', $id, 'has modified a student.', Student::find($id), $timestamp, Auth::user()->id);

            $data = array(
                'title' => 'Well done!',
                'text' => 'The student has been successfully updated.',
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
            $students = Student::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 0
            ]);
            $this->audit_logs('students', $id, 'has removed a student.', Student::find($id), $timestamp, Auth::user()->id);

            $data = array(
                'title' => 'Well done!',
                'text' => 'The student has been successfully removed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }    
        else {
            $students = Student::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 1
            ]);
            $this->audit_logs('students', $id, 'has retrieved a student.', Student::find($id), $timestamp, Auth::user()->id);

            $data = array(
                'title' => 'Well done!',
                'text' => 'The student has been successfully activated.',
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
                    if ($row > 1) {   
                        if ($data[0] !== '') {
                            $mobile_no = ($data[12] !== '') ? (strlen($data[12]) > 10) ? $data[12] : '0'.$data[12] : NULL;
                            $mother_mobile = ($data[20] !== '') ? (strlen($data[20]) > 10) ? $data[20] : '0'.$data[20] : NULL;
                            $father_mobile = ($data[26] !== '') ? (strlen($data[26]) > 10) ? $data[26] : '0'.$data[26] : NULL;
                            $mother_email = ($data[21] !== '') ? $data[21] : NULL;
                            $father_email = ($data[27] !== '') ? $data[27] : NULL;
                            $exist = Student::where('identification_no', $data[0])->get();
                            if ($exist->count() > 0) {
                                $student = Student::find($exist->first()->id);
                                $student->identification_no = $data[0];
                                $student->learners_reference_no = $data[1];
                                $student->firstname = $data[2];
                                $student->middlename = $data[3];
                                $student->lastname = $data[4];
                                $student->suffix = $data[5];
                                $student->gender = $data[8];
                                $student->marital_status = $data[6];
                                $student->birthdate = date('Y-m-d', strtotime($data[7]));
                                $student->current_address = $data[9];
                                $student->permanent_address = ($data[10] !== '') ? $data[10] : NULL;
                                $student->mobile_no = $mobile_no;
                                $student->telephone_no = ($data[11] !== '') ? $data[11] : NULL;
                                $student->admitted_date = date('Y-m-d');
                                $student->special_remarks = ($data[13] !== '') ? $data[13] : NULL;
                                $student->is_guardian = ($data[17] !== '' || $data[23] !== '') ? 1 : 0; 
                                $student->is_sibling = ($data[30] !== '') ? 1 : 0; 
                                $student->updated_at = $timestamp;
                                $student->updated_by = Auth::user()->id;
                                $student->is_active = 1;
                                $user_id = $student->user_id;
                        
                                if ($student->update()) {
                                    $password = User::where('id', $user_id)->pluck('password');
                                    if ($password != $data[16]) {
                                        User::where('id', $user_id)
                                        ->update([
                                            'name' => $data[2].' '.$data[4],
                                            'email' => $data[14],
                                            'username' => $data[15],
                                            'password' => Hash::make($data[16])
                                        ]);
                                    } else {
                                        User::where('id', $user_id)
                                        ->update([
                                            'name' => $data[2].' '.$data[4],
                                            'email' => $data[14],
                                            'username' => $data[15],
                                        ]);
                                    }
                                    $this->audit_logs('users', $user_id, 'has imported and updated a user.', User::find($user_id), $timestamp, Auth::user()->id);
                                    
                                    $exist = UserRole::where('user_id', $user_id)->count();
                                    if (!($exist > 0)) {
                                        $userRole = UserRole::create([
                                            'user_id' => $user_id,
                                            'role_id' => 4,
                                            'created_at' => $timestamp,
                                            'created_by' => Auth::user()->id
                                        ]);
                                        $this->audit_logs('users_roles', $userRole->id, 'has imported a new user role.', UserRole::find($userRole->id), $timestamp, Auth::user()->id);
                                    }
                        
                                    if ($data[17] !== '' || $data[23] !== '') {
                                        $guardian = Guardian::where([
                                            'student_id' => $student->id,
                                        ])
                                        ->update([
                                            'mother_firstname' => $data[17],
                                            'mother_middlename' => ($data[18] !== '') ? $data[18] : NULL, 
                                            'mother_lastname' => $data[19],
                                            'mother_contact_no' => $mother_mobile,
                                            'mother_email' => $mother_email,
                                            'mother_address' => ($data[22] !== '') ? $data[22] : NULL, 
                                            'mother_selected' => ($data[29] == 'Mother') ? 1 : 0,
                                            'father_firstname' => $data[23],
                                            'father_middlename' => ($data[24] !== '') ? $data[24] : NULL, 
                                            'father_lastname' => $data[25],
                                            'father_contact_no' => $father_mobile,
                                            'father_email' => $father_email,
                                            'father_address' => ($data[28] !== '') ? $data[28] : NULL, 
                                            'father_selected' => ($data[29] == 'Father') ? 1 : 0,
                                            'updated_at' => $timestamp,
                                            'updated_by' => Auth::user()->id,
                                            'is_active' => 1
                                        ]);
                                        $guardian = Guardian::where(['student_id' => $student->id])->get();
                                        if ($guardian->count() > 0) {
                                            $this->audit_logs('guardians', $guardian->first()->id, 'has imported and updated a guardian.', Guardian::find($guardian->first()->id), $timestamp, Auth::user()->id);
                                        }

                                        $mother_user = User::where([
                                            'username' => 'M'.$student->identification_no
                                        ])
                                        ->update([
                                            'name' => $data[17].' '.$data[19],
                                            'email' => $mother_email,
                                            'updated_at' => $timestamp
                                        ]);
                                        $mother_user = User::where(['username' => 'M'.$student->identification_no])->get();
                                        if ($mother_user->count() > 0) {
                                            $this->audit_logs('users', $mother_user->first()->id, 'has imported and updated a user.', User::find($mother_user->first()->id), $timestamp, Auth::user()->id);
                                            $motherExist = UserRole::where('user_id', $mother_user->first()->id)->count();
                                            if (!($motherExist > 0)) {
                                                $userRole = UserRole::create([
                                                    'user_id' => $mother_user->first()->id,
                                                    'role_id' => 5,
                                                    'created_at' => $timestamp,
                                                    'created_by' => Auth::user()->id
                                                ]);
                                                $this->audit_logs('users_roles', $userRole->id, 'has imported a new user role.', UserRole::find($userRole->id), $timestamp, Auth::user()->id);
                                            }
                                        }
                            
                                        $father_user = User::where([
                                            'username' => 'F'.$student->identification_no
                                        ])
                                        ->update([
                                            'name' => $data[23].' '.$data[25],
                                            'email' => $father_email,
                                            'updated_at' => $timestamp
                                        ]);
                                        $father_user = User::where(['username' => 'F'.$student->identification_no])->get();
                                        if ($father_user->count() > 0) {
                                            $this->audit_logs('users', $father_user->first()->id, 'has imported and updated a user.', User::find($father_user->first()->id), $timestamp, Auth::user()->id);
                                            $fatherExist = UserRole::where('user_id', $father_user->first()->id)->count();
                                            if (!($fatherExist > 0)) {
                                                $userRole = UserRole::create([
                                                    'user_id' => $father_user->first()->id,
                                                    'role_id' => 5,
                                                    'created_at' => $timestamp,
                                                    'created_by' => Auth::user()->id
                                                ]);
                                                $this->audit_logs('users_roles', $userRole->id, 'has imported a new user role.', UserRole::find($userRole->id), $timestamp, Auth::user()->id);
                                            }
                                        }
                                    }
                        
                                    Sibling::where('student_id', $student->id)->forceDelete();
                                    if ($data[30] !== '') {
                                        $siblingz = explode('-', $data[30]);
                                        foreach ($siblingz as $sibling) {
                                            if ($sibling !== '') {
                                                $siblingExist = Student::where('identification_no', substr($sibling, 0, 10))->count();
                                                if ($siblingExist > 0) {
                                                    $siblings = Sibling::create([
                                                        'student_id' => $student->id,
                                                        'sibling_id' => Student::where('identification_no', substr($sibling, 0, 10))->first()->id,
                                                        'created_at' => $timestamp,
                                                        'created_by' => Auth::user()->id
                                                    ]);
                                                    $this->audit_logs('siblings', $siblings->id, 'has imported a new sibling.', Sibling::find($siblings->id), $timestamp, Auth::user()->id);
                                                }
                                            }
                                        }
                                    }
                                }

                                $this->audit_logs('students', $student->id, 'has imported and updated a student.', Student::find($student->id), $timestamp, Auth::user()->id);
                            } else {
                                $user = User::create([
                                    'name' => $data[2].' '.$data[4],
                                    'username' => $data[15],
                                    'email' => $data[14],
                                    'password' => $data[16],
                                    'type' => 'student'
                                ]);
                        
                                if (!$user) {
                                    throw new NotFoundHttpException();
                                }  
                                
                                $this->audit_logs('users', $user->id, 'has imported a new user.', User::find($user->id), $timestamp, Auth::user()->id);

                                $userRole = UserRole::create([
                                    'user_id' => $user->id,
                                    'role_id' => 4,
                                    'created_at' => $timestamp,
                                    'created_by' => Auth::user()->id
                                ]);
                                $this->audit_logs('users_roles', $userRole->id, 'has imported a new user role.', userRole::find($userRole->id), $timestamp, Auth::user()->id);
                        
                                $student = Student::create([
                                    'user_id' => $user->id,
                                    'role_id' => 4,
                                    'identification_no' => $data[0],
                                    'learners_reference_no' => $data[1],
                                    'firstname' => $data[2],
                                    'middlename' => $data[3],
                                    'lastname' => $data[4],
                                    'suffix' => $data[5],
                                    'gender' => $data[8],
                                    'marital_status' => $data[6],
                                    'birthdate' => date('Y-m-d', strtotime($data[7])),
                                    'current_address' => $data[9],
                                    'permanent_address' => ($data[10] !== '') ? $data[10] : NULL,
                                    'mobile_no' => $mobile_no,
                                    'telephone_no' => ($data[11] !== '') ? $data[11] : NULL,
                                    'admitted_date' => date('Y-m-d'),
                                    'special_remarks' => ($data[13] !== '') ? $data[13] : NULL, 
                                    'is_guardian' => ($data[17] !== '' || $data[23] !== '') ? 1 : 0, 
                                    'is_sibling' => ($data[30] !== '') ? 1 : 0, 
                                    'avatar' => NULL,
                                    'created_at' => $timestamp,
                                    'created_by' => Auth::user()->id
                                ]);
                        
                                if ($data[17] !== '' || $data[23] !== '') {
                                    $guardian = Guardian::create([
                                        'student_id' => $student->id,
                                        'mother_firstname' => $data[17],
                                        'mother_middlename' => ($data[18] !== '') ? $data[18] : NULL, 
                                        'mother_lastname' => $data[19],
                                        'mother_contact_no' => $mother_mobile,
                                        'mother_email' => $mother_email,
                                        'mother_address' => ($data[22] !== '') ? $data[22] : NULL,
                                        'mother_avatar' => NULL,
                                        'mother_selected' => ($data[29] == 'Mother') ? 1 : 0,
                                        'father_firstname' => $data[23],
                                        'father_middlename' => ($data[24] !== '') ? $data[24] : NULL, 
                                        'father_lastname' => $data[25],
                                        'father_contact_no' => $father_mobile,
                                        'father_email' => $father_email,
                                        'father_address' => ($data[28] !== '') ? $data[28] : NULL,
                                        'father_avatar' => NULL,
                                        'father_selected' => ($data[29] == 'Father') ? 1 : 0,
                                        'created_at' => $timestamp,
                                        'created_by' => Auth::user()->id
                                    ]);
                                    $this->audit_logs('guardians', $guardian->id, 'has imported a new guardian.', Guardian::find($guardian->id), $timestamp, Auth::user()->id);

                                    //** MOTHER INFO */
                                    $mother_user = User::create([
                                        'name' => $data[17].' '.$data[19],
                                        'username' => 'M'.$student->identification_no,
                                        'email' => $mother_email,
                                        'password' => (new Student)->random(),
                                        'type' => 'parent'
                                    ]);
                                    $this->audit_logs('users', $mother_user->id, 'has imported a new user.', User::find($mother_user->id), $timestamp, Auth::user()->id);
                        
                                    $motherRole = UserRole::create([
                                        'user_id' => $mother_user->id,
                                        'role_id' => 5,
                                        'created_at' => $timestamp,
                                        'created_by' => Auth::user()->id
                                    ]);
                                    $this->audit_logs('users_roles', $motherRole->id, 'has imported a new user role.', UserRole::find($motherRole->id), $timestamp, Auth::user()->id);
                      
                                    $mother_guardian_user = GuardianUser::create([
                                        'guardian_id' => $guardian->id,
                                        'user_id' => $mother_user->id,
                                        'created_at' => $timestamp,
                                        'created_by' => Auth::user()->id
                                    ]);
                                    $this->audit_logs('guardians_users', $mother_guardian_user->id, 'has imported a new guardian user.', GuardianUser::find($mother_guardian_user->id), $timestamp, Auth::user()->id);
                                    //** END MOTHER INFO */
                                        
                                    //** FATHER INFO */
                                    $father_user = User::create([
                                        'name' => $data[23].' '.$data[25],
                                        'username' => 'F'.$student->identification_no,
                                        'email' => $father_email,
                                        'password' => (new Student)->random(),
                                        'type' => 'parent'
                                    ]);
                                    $this->audit_logs('users', $father_user->id, 'has imported a new user.', User::find($father_user->id), $timestamp, Auth::user()->id);
                        
                                    $fatherRole = UserRole::create([
                                        'user_id' => $father_user->id,
                                        'role_id' => 5,
                                        'created_at' => $timestamp,
                                        'created_by' => Auth::user()->id
                                    ]);
                                    $this->audit_logs('users_roles', $fatherRole->id, 'has imported a new user role.', UserRole::find($fatherRole->id), $timestamp, Auth::user()->id);

                                    $father_guardian_user = GuardianUser::create([
                                        'guardian_id' => $guardian->id,
                                        'user_id' => $father_user->id,
                                        'created_at' => $timestamp,
                                        'created_by' => Auth::user()->id
                                    ]);
                                    $this->audit_logs('guardians_users', $father_guardian_user->id, 'has imported a new guardian user.', GuardianUser::find($father_guardian_user->id), $timestamp, Auth::user()->id);
                                    //** END FATHER INFO */
                                }
                        
                                if ($data[30] !== NULL) {
                                    $siblingz = explode('-',$data[30]);
                                    foreach ($siblingz as $sibling) {
                                        if ($sibling != '') {
                                            $siblingExist = Student::where('identification_no', substr($sibling, 0, 10))->count();
                                            if ($siblingExist > 0) {
                                                $siblings = Sibling::create([
                                                    'student_id' => $student->id,
                                                    'sibling_id' => Student::where('identification_no', substr($sibling, 0, 10))->first()->id,
                                                    'created_at' => $timestamp,
                                                    'created_by' => Auth::user()->id
                                                ]);
                                                $this->audit_logs('siblings', $siblings->id, 'has imported a new sibling.', Sibling::find($siblings->id), $timestamp, Auth::user()->id);
                                            }
                                        }
                                    }
                                }

                                $this->audit_logs('students', $student->id, 'has imported a new student.', Student::find($student->id), $timestamp, Auth::user()->id);
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

    public function get_column_via_id($id, $column)
    {
        return (new Student)->where('id', $id)->first()->$column;
    }

    public function generate_student_no()
    {
        $studentNo = (new Student)->generate_student_no();
        return $studentNo;
    }

    public function get_all_siblings(Request $request)
    {
        $siblings = (new Student)->get_all_siblings($request->get('id'));
        echo json_encode( $siblings ); exit();
    }

    public function get_student($id)
    {
        $student = (new Student)->get_this_student( $id );
        echo json_encode( $student ); exit();
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
