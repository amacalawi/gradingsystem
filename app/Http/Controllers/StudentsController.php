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

        $userRole = UserRole::create([
            'user_id' => $user->id,
            'role_id' => 4,
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);

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

            $mother_user = User::create([
                'name' => $request->mother_firstname.' '.$request->mother_lastname,
                'username' => 'M'.$student->identification_no,
                'email' => $request->mother_email,
                'password' => (new Student)->random(),
                'type' => 'parent'
            ]);

            $motherRole = UserRole::create([
                'user_id' => $mother_user->id,
                'role_id' => 5,
                'created_at' => $timestamp,
                'created_by' => Auth::user()->id
            ]);

            $mother_guardian_user = GuardianUser::create([
                'guardian_id' => $guardian->id,
                'user_id' => $mother_user->id,
                'created_at' => $timestamp,
                'created_by' => Auth::user()->id
            ]);

            $father_user = User::create([
                'name' => $request->father_firstname.' '.$request->father_lastname,
                'username' => 'F'.$student->identification_no,
                'email' => $request->father_email,
                'password' => (new Student)->random(),
                'type' => 'parent'
            ]);

            $fatherRole = UserRole::create([
                'user_id' => $father_user->id,
                'role_id' => 5,
                'created_at' => $timestamp,
                'created_by' => Auth::user()->id
            ]);

            $father_guardian_user = GuardianUser::create([
                'guardian_id' => $guardian->id,
                'user_id' => $father_user->id,
                'created_at' => $timestamp,
                'created_by' => Auth::user()->id
            ]);
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
                }
            }
        }

        if (!$student) {
            throw new NotFoundHttpException();
        }

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
            $guardian = Guardian::where('student_id', $id)->pluck('id');
            $motherUser = GuardianUser::where('guardian_id', $guardian)->orderBy('id', 'asc')->first()->user_id;
            $fatherUser = GuardianUser::where('guardian_id', $guardian)->orderBy('id', 'desc')->first()->user_id;

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
            
            $exist = UserRole::where('user_id', $user_id)->count();
            if (!($exist > 0)) {
                $userRole = UserRole::create([
                    'user_id' => $user_id,
                    'role_id' => 4,
                    'created_at' => $timestamp,
                    'created_by' => Auth::user()->id
                ]);
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

                $mother_user = User::where([
                    'username' => 'M'.$student->identification_no
                ])
                ->update([
                    'name' => $request->mother_firstname.' '.$request->mother_lastname,
                    'email' => $mother_email,
                    'updated_at' => $timestamp
                ]);

                if ($mother_user) {
                    $mother_user = User::where(['username' => 'M'.$student->identification_no])->first();
                    $motherExist = UserRole::where('user_id', $mother_user->id)->count();
                    if (!($motherExist > 0)) {
                        $userRole = UserRole::create([
                            'user_id' => $mother_user->id,
                            'role_id' => 5,
                            'created_at' => $timestamp,
                            'created_by' => Auth::user()->id
                        ]);
                    }
                }
    
                $father_user = User::where([
                    'username' => 'F'.$student->identification_no
                ])
                ->update([
                    'name' => $request->father_firstname.' '.$request->father_lastname,
                    'email' => $father_email,
                    'updated_at' => $timestamp
                ]);

                if ($father_user) {
                    $father_user = User::where(['username' => 'F'.$student->identification_no])->first();
                    $fatherExist = UserRole::where('user_id', $father_user->id)->count();
                    if (!($fatherExist > 0)) {
                        $userRole = UserRole::create([
                            'user_id' => $father_user->id,
                            'role_id' => 5,
                            'created_at' => $timestamp,
                            'created_by' => Auth::user()->id
                        ]);
                    }
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
                    }
                }
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
                            $exist = Student::where('identification_no', $data[0])->get();
                            if ($exist->count() > 0) {
                                $student = Student::find($exist->first()->id);
                                $student->identification_no = $data[0];
                                $student->firstname = $data[1];
                                $student->middlename = $data[2];
                                $student->lastname = $data[3];
                                $student->suffix = $data[4];
                                $student->gender = $data[7];
                                $student->marital_status = $data[5];
                                $student->birthdate = date('Y-m-d', strtotime($data[6]));
                                $student->current_address = $data[8];
                                $student->permanent_address = ($data[9] !== '') ? $data[9] : NULL;
                                $student->mobile_no = ($data[11] !== '') ? $data[11] : NULL;
                                $student->telephone_no = ($data[10] !== '') ? $data[10] : NULL;
                                $student->admitted_date = date('Y-m-d');
                                $student->special_remarks = ($data[12] !== '') ? $data[12] : NULL;
                                $student->is_guardian = ($data[16] !== '' || $data[22] !== '') ? 1 : 0; 
                                $student->is_sibling = ($data[29] !== '') ? 1 : 0; 
                                $student->updated_at = $timestamp;
                                $student->updated_by = Auth::user()->id;
                                $student->is_active = 1;
                                $user_id = $student->user_id;
                        
                                if ($student->update()) {
                                    $password = User::where('id', $user_id)->pluck('password');
                                    if ($password != $data[15]) {
                                        User::where('id', $user_id)
                                        ->update([
                                            'name' => $data[1].' '.$data[3],
                                            'email' => $data[13],
                                            'username' => $data[14],
                                            'password' => Hash::make($data[15])
                                        ]);
                                    } else {
                                        User::where('id', $user_id)
                                        ->update([
                                            'name' => $data[1].' '.$data[3],
                                            'email' => $data[13],
                                            'username' => $data[14],
                                        ]);
                                    }
                                    
                                    $exist = UserRole::where('user_id', $user_id)->count();
                                    if (!($exist > 0)) {
                                        $userRole = UserRole::create([
                                            'user_id' => $user_id,
                                            'role_id' => 4,
                                            'created_at' => $timestamp,
                                            'created_by' => Auth::user()->id
                                        ]);
                                    }
                        
                                    if ($data[16] !== '' || $data[22] !== '') {
                                        $guardian = Guardian::where([
                                            'student_id' => $student->id,
                                        ])
                                        ->update([
                                            'mother_firstname' => $data[16],
                                            'mother_middlename' => ($data[17] !== '') ? $data[17] : NULL, 
                                            'mother_lastname' => $data[18],
                                            'mother_contact_no' => $data[19],
                                            'mother_email' => $data[20],
                                            'mother_address' => ($data[21] !== '') ? $request->mother_address : NULL, 
                                            'mother_selected' => ($data[28] == 'Mother') ? 1 : 0,
                                            'father_firstname' => $data[22],
                                            'father_middlename' => ($data[23] !== '') ? $data[23] : NULL, 
                                            'father_lastname' => $data[24],
                                            'father_contact_no' => $data[25],
                                            'father_email' => $data[26],
                                            'father_address' => ($data[27] !== '') ? $data[27] : NULL, 
                                            'father_selected' => ($data[28] == 'Father') ? 1 : 0,
                                            'updated_at' => $timestamp,
                                            'updated_by' => Auth::user()->id,
                                            'is_active' => 1
                                        ]);
                        
                                        $mother_user = User::where([
                                            'username' => 'M'.$student->identification_no
                                        ])
                                        ->update([
                                            'name' => $data[16].' '.$data[18],
                                            'email' => $data[20],
                                            'updated_at' => $timestamp
                                        ]);
                        
                                        if ($mother_user) {
                                            $mother_user = User::where(['username' => 'M'.$student->identification_no])->first();
                                            $motherExist = UserRole::where('user_id', $mother_user->id)->count();
                                            if (!($motherExist > 0)) {
                                                $userRole = UserRole::create([
                                                    'user_id' => $mother_user->first()->id,
                                                    'role_id' => 5,
                                                    'created_at' => $timestamp,
                                                    'created_by' => Auth::user()->id
                                                ]);
                                            }
                                        }
                            
                                        $father_user = User::where([
                                            'username' => 'F'.$student->identification_no
                                        ])
                                        ->update([
                                            'name' => $data[22].' '.$data[24],
                                            'email' => $data[26],
                                            'updated_at' => $timestamp
                                        ]);
                        
                                        if ($father_user) {
                                            $father_user = User::where(['username' => 'F'.$student->identification_no])->first();
                                            $fatherExist = UserRole::where('user_id', $father_user->id)->count();
                                            if (!($fatherExist > 0)) {
                                                $userRole = UserRole::create([
                                                    'user_id' => $father_user->id,
                                                    'role_id' => 5,
                                                    'created_at' => $timestamp,
                                                    'created_by' => Auth::user()->id
                                                ]);
                                            }
                                        }
                                    }
                        
                                    Sibling::where('student_id', $student->id)->forceDelete();
                                    if ($data[29] !== '') {
                                        $siblingz = explode('-', $data[29]);
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
                                                }
                                            }
                                        }
                                    }
                                }
                            } else {
                                $user = User::create([
                                    'name' => $data[1].' '.$data[3],
                                    'username' => $data[14],
                                    'email' => $data[13],
                                    'password' => $data[15],
                                    'type' => 'student'
                                ]);
                        
                                if (!$user) {
                                    throw new NotFoundHttpException();
                                }  
                        
                                $userRole = UserRole::create([
                                    'user_id' => $user->id,
                                    'role_id' => 4,
                                    'created_at' => $timestamp,
                                    'created_by' => Auth::user()->id
                                ]);
                        
                                $student = Student::create([
                                    'user_id' => $user->id,
                                    'role_id' => 4,
                                    'identification_no' => $data[0],
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
                                    'admitted_date' => date('Y-m-d'),
                                    'special_remarks' => ($data[12] !== '') ? $data[12] : NULL, 
                                    'is_guardian' => ($data[16] !== '' || $data[22] !== '') ? 1 : 0, 
                                    'is_sibling' => ($data[29] !== '') ? 1 : 0, 
                                    'avatar' => NULL,
                                    'created_at' => $timestamp,
                                    'created_by' => Auth::user()->id
                                ]);
                        
                                if ($data[16] !== '' || $data[22] !== '') {
                                    $guardian = Guardian::create([
                                        'student_id' => $student->id,
                                        'mother_firstname' => $data[16],
                                        'mother_middlename' => ($data[17] !== '') ? $data[17] : NULL, 
                                        'mother_lastname' => $data[18],
                                        'mother_contact_no' => $data[19],
                                        'mother_email' => $data[20],
                                        'mother_address' => ($data[21] !== '') ? $data[21] : NULL,
                                        'mother_avatar' => NULL,
                                        'mother_selected' => ($data[28] == 'Mother') ? 1 : 0,
                                        'father_firstname' => $data[22],
                                        'father_middlename' => ($data[23] !== '') ? $data[23] : NULL, 
                                        'father_lastname' => $data[24],
                                        'father_contact_no' => $data[25],
                                        'father_email' => $data[26],
                                        'father_address' => ($data[27] !== '') ? $data[27] : NULL,
                                        'father_avatar' => NULL,
                                        'father_selected' => ($data[28] == 'Father') ? 1 : 0,
                                        'created_at' => $timestamp,
                                        'created_by' => Auth::user()->id
                                    ]);
                        
                                    $mother_user = User::create([
                                        'name' => $data[16].' '.$data[18],
                                        'username' => 'M'.$student->identification_no,
                                        'email' => ($data[20] !== NULL) ? $data[20] : NULL,
                                        'password' => (new Student)->random(),
                                        'type' => 'parent'
                                    ]);
                        
                                    $motherRole = UserRole::create([
                                        'user_id' => $mother_user->id,
                                        'role_id' => 5,
                                        'created_at' => $timestamp,
                                        'created_by' => Auth::user()->id
                                    ]);
                        
                                    $mother_guardian_user = GuardianUser::create([
                                        'guardian_id' => $guardian->id,
                                        'user_id' => $mother_user->id,
                                        'created_at' => $timestamp,
                                        'created_by' => Auth::user()->id
                                    ]);
                        
                                    $father_user = User::create([
                                        'name' => $data[22].' '.$data[24],
                                        'username' => 'F'.$student->identification_no,
                                        'email' => ($data[26] !== NULL) ? $data[26] : NULL,
                                        'password' => (new Student)->random(),
                                        'type' => 'parent'
                                    ]);
                        
                                    $fatherRole = UserRole::create([
                                        'user_id' => $father_user->id,
                                        'role_id' => 5,
                                        'created_at' => $timestamp,
                                        'created_by' => Auth::user()->id
                                    ]);
                        
                                    $father_guardian_user = GuardianUser::create([
                                        'guardian_id' => $guardian->id,
                                        'user_id' => $father_user->id,
                                        'created_at' => $timestamp,
                                        'created_by' => Auth::user()->id
                                    ]);
                                }
                        
                                if ($data[29] !== NULL) {
                                    $siblingz = explode('-',$data[29]);
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
                                            }
                                        }
                                    }
                                }
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
}
