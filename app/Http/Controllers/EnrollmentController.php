<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\EnrollmentForm;
use App\Models\Enrollment;
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
        // $this->middleware('guest');
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
        return view('modules/enrollments/index');
    }

    public function all_active(Request $request)
    {
        $res = Enrollment::
        with([
            'level' =>  function($q) { 
                $q->select(['id', 'name']); 
            }
        ])
        ->where('is_active', 1)->orderBy('id', 'DESC')->get();

        return $res->map(function($enroll) {
            return [
                'enrollID' => $enroll->id,
                'enrollLrn' => $enroll->student_lrn,
                'enrollEmail' => $enroll->student_email,
                'enrollFullname' => $enroll->student_firstname.' '.$enroll->student_middlename.' '.$enroll->student_lastname,
                'enrollAgeGender' => $enroll->student_age.' ('.$enroll->student_gender.')',
                'enrollLevel' => $enroll->level->name,
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

    public function store(Request $request)
    {    
        $timestamp = date('Y-m-d H:i:s');

        $rows = Enrollment::where([
            'student_lrn' => $request->lrn_no
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
            'student_email' => $request->student_email,
            'is_new' => $request->is_new,
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
            'title' => 'Well done!',
            'text' => 'The application has been successfully submitted!',
            'type' => 'success',
            'class' => 'btn-brand'
        );

        echo json_encode( $data ); exit();
    }

}
