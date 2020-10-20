<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\EnrollmentForm;
use App\Models\Enrollment;
use App\Models\Level;
use App\Models\Batch;
use App\Models\Student;
use App\User;
use Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\File;
use App\Components\FlashMessages;
use App\Helper\Helper;

class EnrollmentController extends Controller
{   
    use FlashMessages;
    private $models;

    public function __construct()
    {   
        date_default_timezone_set('Asia/Manila');
    }
    
    public function is_permitted($permission)
    {
        $privileges = explode(',', strtolower(Helper::get_privileges()));
        if (!$privileges[$permission] == 1) {
            return abort(404);
        }
    }

    public function index(Request $request)
    {
        $levels = (new Level)->get_all_levels_with_empty();
        return view('modules/enrollments/index')->with(compact('levels'));
    }

    public function edit(Request $request, $id)
    {
        $this->middleware('auth');
        $this->is_permitted(1);    
        $levels = (new Level)->get_all_levels_with_empty();
        $enroll = Enrollment::find($id);
        return view('modules/enrollments/edit')->with(compact('levels', 'enroll'));
    }

    public function all_active(Request $request)
    {
        $res = Enrollment::
        with([
            'level' =>  function($q) { 
                $q->select(['id', 'name']); 
            }
        ])
        ->where(['batch_id' => (new Batch)->get_current_batch(), 'is_active' => 1])
        ->orderBy('id', 'DESC')
        ->get();

        return $res->map(function($enroll) {
            return [
                'enrollID' => $enroll->id,
                'enrollLrn' => $enroll->student_lrn,
                'enrollEmail' => $enroll->student_email,
                'enrollFullname' => $enroll->student_firstname.' '.$enroll->student_middlename.' '.$enroll->student_lastname,
                'enrollAgeGender' => $enroll->student_age.' ('.$enroll->student_gender.')',
                'enrollLevel' => $enroll->level->name,
                'enrollStatus' => $enroll->status,
                'enrollModified' => ($enroll->updated_at !== NULL) ? date('d-M-Y', strtotime($enroll->updated_at)).'<br/>'. date('h:i A', strtotime($enroll->updated_at)) : date('d-M-Y', strtotime($enroll->created_at)).'<br/>'. date('h:i A', strtotime($enroll->created_at))
            ];
        });
    }

    public function manage(Request $request)
    {   
        $this->middleware('auth');
        $this->is_permitted(1);    
        $menus = $this->load_menus();
        return view('modules/academics/admissions/enrollments/manage')->with(compact('menus'));
    }

    public function inactive(Request $request)
    {   
        $this->middleware('auth');
        $this->is_permitted(1);
        $menus = $this->load_menus();
        return view('modules/academics/admissions/enrollments/inactive')->with(compact('menus'));
    }

    public function search(Request $request)
    {
        $student = Student::with([
            'user' =>  function($q) { 
                $q->select(['id', 'email']); 
            },
            'guardian' =>  function($q) { 
                $q->select(['student_id', 'id', 'mother_firstname', 'mother_middlename', 'mother_lastname', 'mother_contact_no', 'mother_email', 'mother_address', 'father_firstname', 'father_middlename', 'father_lastname', 'father_contact_no', 'father_email', 'father_address']); 
            }
        ])
        ->where('identification_no', $request->get('id_number'))
        ->get();

        if ($student->count() > 0) {
            $student = $student->first();
            $enroll = Enrollment::where('student_no', $request->get('id_number'))->get();
            if ($enroll->count() > 0) {
                $enrolls = $enroll->last();
            }
            $arr = array(
                'student_number' => $student->identification_no,
                'student_email' => $student->user->email,
                'lrn_no' => $student->learners_reference_no,
                'psa_no' => !empty($enrolls) ? $enrolls->student_psa_no : '',
                'student_firstname' => $student->firstname,
                'student_middlename' => $student->middlename,
                'student_lastname' => $student->lastname,
                'student_gender' => $student->gender,
                'student_birthdate' => $student->birthdate,
                'student_birthorder' => !empty($enrolls) ? $enrolls->student_birthorder : '',
                'student_reside_with' => !empty($enrolls) ? $enrolls->student_reside_with : '',
                'student_address' => $student->current_address,
                'student_barangay' => !empty($enrolls) ? $enrolls->student_barangay : '',
                'student_last_attended' => !empty($enrolls) ? $enrolls->student_last_attended : '',
                'student_transfer_reason' => !empty($enrolls) ? $enrolls->student_transfer_reason : '',
                'father_firstname' => $student->guardian->father_firstname,
                'father_middlename' => $student->guardian->father_middlename,
                'father_lastname' => $student->guardian->father_lastname,
                'father_contact' => $student->guardian->father_contact_no,
                'father_birthdate' => !empty($enrolls) ? $enrolls->father_birthdate : '',
                'father_birthplace' => !empty($enrolls) ? $enrolls->father_birthplace : '',
                'father_address' => $student->guardian->father_address,
                'father_religion' => !empty($enrolls) ? $enrolls->father_religion : '',
                'father_specific_religion' => !empty($enrolls) ? $enrolls->father_specific_religion : '',
                'father_occupation' => !empty($enrolls) ? $enrolls->father_occupation : '',
                'father_education' => !empty($enrolls) ? $enrolls->father_education : '',
                'father_employment_status' => !empty($enrolls) ? $enrolls->father_employment_status : '',
                'father_workplace' => !empty($enrolls) ? $enrolls->father_workplace : '',
                'father_work_quarantine' => !empty($enrolls) ? $enrolls->father_work_quarantine : '',
                'mother_firstname' => $student->guardian->mother_firstname,
                'mother_middlename' => $student->guardian->mother_middlename,
                'mother_lastname' => $student->guardian->mother_lastname,
                'mother_maidenname' => !empty($enrolls) ? $enrolls->mother_maidenname : '',
                'mother_contact' => $student->guardian->mother_contact_no,
                'mother_birthdate' => !empty($enrolls) ? $enrolls->mother_birthdate : '',
                'mother_birthplace' => !empty($enrolls) ? $enrolls->mother_contact : '',
                'mother_address' => $student->guardian->mother_address,
                'mother_religion' => !empty($enrolls) ? $enrolls->mother_religion : '',
                'mother_specific_religion' => !empty($enrolls) ? $enrolls->mother_specific_religion : '',
                'mother_occupation' => !empty($enrolls) ? $enrolls->mother_occupation : '',
                'mother_education' => !empty($enrolls) ? $enrolls->mother_education : '',
                'mother_employment_status' => !empty($enrolls) ? $enrolls->mother_employment_status : '',
                'mother_workplace' => !empty($enrolls) ? $enrolls->mother_workplace : '',
                'mother_work_quarantine' => !empty($enrolls) ? $enrolls->mother_work_quarantine : '',
                'parent_marriage_status' => !empty($enrolls) ? $enrolls->parent_marriage_status : '',
                'guardian_firstname' => !empty($enrolls) ? $enrolls->guardian_firstname : '',
                'guardian_middlename' => !empty($enrolls) ? $enrolls->guardian_middlename : '',
                'guardian_lastname' => !empty($enrolls) ? $enrolls->guardian_lastname : '',
                'guardian_contact' => !empty($enrolls) ? $enrolls->guardian_contact : '',
                'guardian_relationship' => !empty($enrolls) ? $enrolls->guardian_relationship : '',
                'guardian_employment_status' => !empty($enrolls) ? $enrolls->guardian_employment_status : '',
                'guardian_work_quarantine' => !empty($enrolls) ? $enrolls->guardian_work_quarantine : '',
                'family_4ps' => !empty($enrolls) ? $enrolls->family_4ps : '',
                'student_siblings' => !empty($enrolls) ? $enrolls->student_siblings : '',
                'student_previous_academic' => !empty($enrolls) ? $enrolls->student_previous_academic : '',
                'student_transpo[]' => !empty($enrolls) ? $enrolls->student_transpo : '',
                'student_studying' => !empty($enrolls) ? $enrolls->student_studying : '',
                'specific_student_studying' => !empty($enrolls) ? $enrolls->specific_student_studying : '',
                'student_supplies' => !empty($enrolls) ? $enrolls->student_supplies : '',
                'student_devices[]' => !empty($enrolls) ? $enrolls->student_devices : '',
                'specific_student_devices' => !empty($enrolls) ? $enrolls->specific_student_devices : '',
                'student_with_internet' => !empty($enrolls) ? $enrolls->student_with_internet : '',
                'student_internet_connection[]' => !empty($enrolls) ? $enrolls->student_internet_connection : '',
                'student_describe_internet' => !empty($enrolls) ? $enrolls->student_describe_internet : '', 
                'student_learning_modality' => !empty($enrolls) ? $enrolls->student_learning_modality : '',
                'student_learning_delivery' => !empty($enrolls) ? $enrolls->student_learning_delivery : '',
                'student_challenges_education[]' => !empty($enrolls) ? $enrolls->student_challenges_education : '',
                'specific_student_challenges_education' => !empty($enrolls) ? $enrolls->specific_student_challenges_education  : '',
                'student_tuition_fee_types' => !empty($enrolls) ? $enrolls->student_tuition_fee_types : '',
                'student_documents[]' => !empty($enrolls) ? $enrolls->student_documents : '',
                'student_payment_terms' => !empty($enrolls) ? $enrolls->payment_term_id : '',
                'student_sibling_discount' => !empty($enrolls) ? $enrolls->student_sibling_discount : '',
                'student_subsidy_grantee' => !empty($enrolls) ? $enrolls->student_subsidy_grantee : '',
                'student_payment_option' => !empty($enrolls) ? $enrolls->payment_option_id : '',
            );

            $data = array(
                'data' => $arr,
                'title' => 'Well done!',
                'text' => 'The student number is exist',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        } else {
            $data = array(
                'data' => $request->get('id_number'),
                'title' => 'Oops!',
                'text' => 'The student number is not exist.',
                'type' => 'error',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }
    }

    public function store(Request $request)
    {    
        $timestamp = date('Y-m-d H:i:s');

        $rows = Enrollment::where([
            'student_lrn' => $request->lrn_no,
            'batch_id' => (new Batch)->get_current_batch()
        ])->count();

        if ($rows > 0) {
            $data = array(
                'title' => 'Oh snap!',
                'text' => 'You cannot enroll with an existing lrn.',
                'type' => 'error',
                'class' => 'btn-danger'
            );
    
            echo json_encode( $data ); exit();
        }

        $enrollment = Enrollment::create([
            'batch_id' => (new Batch)->get_current_batch(),
            'student_email' => $request->student_email,
            'is_new' => $request->is_new,
            'student_no' => !empty($request->student_number) ? $request->student_number : NULL,
            'student_lrn' => $request->lrn_no,
            'student_psa_no' => $request->psa_no,
            'level_id' => $request->grade_level,
            'student_firstname' => $request->student_firstname,
            'student_middlename' => $request->student_middlename,
            'student_lastname' => $request->student_lastname,
            'student_age' => $request->student_age,
            'student_gender' => $request->student_gender,
            'student_birthdate' => date('Y-m-d', strtotime($request->student_birthdate)),
            'student_birthorder' => $request->student_birthorder,
            'student_reside_with' => $request->student_reside_with,
            'student_address' => $request->student_address,
            'student_barangay' => $request->student_barangay,
            'student_last_attended' => $request->student_last_attended,
            'student_transfer_reason' => $request->student_transfer_reason,
            'father_firstname' => $request->father_firstname,
            'father_middlename' => $request->father_middlename,
            'father_lastname' => $request->father_lastname,
            'father_contact' => $request->father_contact,
            'father_birthdate' => date('Y-m-d', strtotime($request->father_birthdate)),
            'father_birthplace' => $request->father_birthplace,
            'father_address' => $request->father_address,
            'father_religion' => $request->father_religion,
            'father_specific_religion' => $request->father_specific_religion,
            'father_occupation' => $request->father_occupation,
            'father_education' => $request->father_education,
            'father_employment_status' => $request->father_employment_status,
            'father_workplace' => $request->father_workplace,
            'father_work_quarantine' => $request->father_work_quarantine,
            'mother_firstname' => $request->mother_firstname,
            'mother_middlename' => $request->mother_middlename,
            'mother_lastname' => $request->mother_lastname,
            'mother_maidenname' => $request->mother_maidenname,
            'mother_contact' => $request->mother_contact,
            'mother_birthdate' => date('Y-m-d', strtotime($request->mother_birthdate)),
            'mother_birthplace' => $request->mother_contact,
            'mother_address' => $request->mother_address,
            'mother_religion' => $request->mother_religion,
            'mother_specific_religion' => $request->mother_specific_religion,
            'mother_occupation' => $request->mother_occupation,
            'mother_education' => $request->mother_education,
            'mother_employment_status' => $request->mother_employment_status,
            'mother_workplace' => $request->mother_workplace,
            'mother_work_quarantine' => $request->mother_work_quarantine,
            'parent_marriage_status' => $request->parent_marriage_status,
            'guardian_firstname' => $request->guardian_firstname,
            'guardian_middlename' => $request->guardian_middlename,
            'guardian_lastname' => $request->guardian_lastname,
            'guardian_contact' => $request->guardian_contact,
            'guardian_relationship' => $request->guardian_relationship,
            'guardian_employment_status' => $request->guardian_employment_status,
            'guardian_work_quarantine' => $request->guardian_work_quarantine,
            'family_4ps' => $request->family_4ps,
            'student_siblings' => $request->student_siblings,
            'student_previous_academic' => $request->student_previous_academic,
            'student_transpo' => implode(',', $request->student_transpo),
            'student_studying' => $request->student_studying,
            'specific_student_studying' => $request->specific_student_studying,
            'student_supplies' => $request->student_supplies,
            'student_devices' => implode(',', $request->student_devices),
            'specific_student_devices' => $request->specific_student_devices,
            'student_with_internet' => $request->student_with_internet,
            'student_internet_connection' => implode(',', $request->student_internet_connection),
            'student_describe_internet' => $request->student_describe_internet, 
            'student_learning_modality' => $request->student_learning_modality,
            'student_learning_delivery' => $request->student_learning_delivery,
            'student_challenges_education' => implode(',', $request->student_challenges_education),
            'specific_student_challenges_education' => $request->specific_student_challenges_education,
            'student_documents' => implode(',', $request->student_documents),
            'student_tuition_fee_types' => $request->student_tuition_fee_types,
            'payment_term_id' => $request->student_payment_terms,
            'student_sibling_discount' => $request->student_sibling_discount,
            'student_subsidy_grantee' => $request->student_subsidy_grantee,
            'payment_option_id' => $request->student_payment_option,
            'student_acknowledge_1' => $request->student_acknowledge_1,
            'student_acknowledge_2' => $request->student_acknowledge_2,
            'student_acknowledge_3' => $request->student_acknowledge_3,
            'student_acknowledge_4' => $request->student_acknowledge_4,
            'created_at' => $timestamp
        ]);

        if (!$enrollment) {
            throw new NotFoundHttpException();
        }

        $data = array(
            'data' => $request->student_birthorder,
            'title' => 'Well done!',
            'text' => 'The application has been successfully submitted!',
            'type' => 'success',
            'class' => 'btn-brand'
        );

        echo json_encode( $data ); exit();
    }

}
