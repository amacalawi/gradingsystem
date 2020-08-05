<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'staffs';
    
    public $timestamps = false;

    public function fetch($id)
    {       
        if (!empty($id)) 
        {   
            $staff = self::with([
                'user' =>  function($q) { 
                    $q->select(['id', 'email', 'username', 'password']); 
                },
            ])->where('id', $id)->first();
            
            $results = array(
                'id' => ($staff->id) ? $staff->id : '',
                'user_id' => ($staff->user_id) ? $staff->user_id : '',
                'role_id' => ($staff->role_id) ? $staff->role_id : '',
                'department_id' => ($staff->department_id) ? $staff->department_id : '',
                'designation_id' => ($staff->designation_id) ? $staff->designation_id : '',
                'identification_no' => ($staff->identification_no) ? $staff->identification_no : '',
                'type' => ($staff->type) ? $staff->type : '',
                'specification' => ($staff->specification) ? $staff->specification : '',
                'firstname' => ($staff->firstname) ? $staff->firstname : '',
                'middlename' => ($staff->middlename) ? $staff->middlename : '',
                'lastname' => ($staff->lastname) ? $staff->lastname : '',
                'suffix' => ($staff->suffix) ? $staff->suffix : '',
                'gender' => ($staff->gender) ? $staff->gender : '',
                'birthdate' => ($staff->birthdate) ? $staff->birthdate : '',
                'marital_status' => ($staff->marital_status) ? $staff->marital_status : '',
                'current_address' => ($staff->current_address) ? $staff->current_address : '',
                'permanent_address' => ($staff->permanent_address) ? $staff->permanent_address : '',
                'mobile_no' => ($staff->mobile_no) ? $staff->mobile_no : '',
                'telephone_no' => ($staff->telephone_no) ? $staff->telephone_no : '',
                'avatar' => ($staff->avatar) ? $staff->avatar : '',
                'contact_fullname' => ($staff->contact_fullname) ? $staff->contact_fullname : '',
                'contact_relation' => ($staff->contact_relation) ? $staff->contact_relation : '',
                'contact_phone_no' => ($staff->contact_phone_no) ? $staff->contact_phone_no : '',
                'sss_no' => ($staff->sss_no) ? $staff->sss_no : '',
                'tin_no' => ($staff->tin_no) ? $staff->tin_no : '',
                'pag_ibig_no' => ($staff->pag_ibig_no) ? $staff->pag_ibig_no : '',
                'philhealth_no' => ($staff->philhealth_no) ? $staff->philhealth_no : '',
                'elementary_graduated' => ($staff->elementary_graduated) ? $staff->elementary_graduated : '',
                'secondary_graduated' => ($staff->secondary_graduated) ? $staff->secondary_graduated : '',
                'tertiary_graduated' => ($staff->tertiary_graduated) ? $staff->tertiary_graduated : '',
                'course_taken' => ($staff->course_taken) ? $staff->course_taken : '',
                'master_graduated' => ($staff->master_graduated) ? $staff->master_graduated : '',
                'course_specialization' => ($staff->course_specialization) ? $staff->course_specialization : '',
                'graduate_school_status' => ($staff->graduate_school_status) ? $staff->graduate_school_status : '',
                'date_of_graduation' => ($staff->date_of_graduation) ? $staff->date_of_graduation : '',
                'other_educational_attainment' => ($staff->other_educational_attainment) ? $staff->other_educational_attainment : '',
                'government_examination' => ($staff->government_examination) ? $staff->government_examination : '',
                'work_experience' => ($staff->work_experience) ? $staff->work_experience : '',
                'email' => $staff->user->email,
                'username' => ($staff->user->username) ? $staff->user->username : '',
                'password' => ($staff->user->password) ? $staff->user->password : '',
                'date_joined' => ($staff->date_joined) ? $staff->date_joined : '',
                'date_resigned' => ($staff->date_resigned) ? $staff->date_resigned : '',
            );
        } else {
            $results = array(
                'id' => '',
                'user_id' => '',
                'role_id' => '',
                'department_id' => '',
                'designation_id' => '',
                'identification_no' => '',
                'type' => '',
                'specification' => '',
                'firstname' => '',
                'middlename' => '',
                'lastname' => '',
                'suffix' => '',
                'gender' => '',
                'marital_status' => '',
                'birthdate' => '',
                'current_address' => '',
                'permanent_address' => '',
                'mobile_no' => '',
                'telephone_no' => '',
                'avatar' => '',
                'contact_fullname' => '',
                'contact_relation' => '',
                'contact_phone_no' => '',
                'sss_no' => '',
                'tin_no' => '',
                'pag_ibig_no' => '',
                'philhealth_no' => '',
                'elementary_graduated' => '',
                'secondary_graduated' => '',
                'tertiary_graduated' => '',
                'course_taken' => '',
                'master_graduated' => '',
                'course_specialization' => '',
                'graduate_school_status' => '',
                'date_of_graduation' => '',
                'other_educational_attainment' => '',
                'government_examination' => '',
                'work_experience' => '',
                'email' => '',
                'username' => '',
                'password' => $this->random(),
                'date_joined' => date('Y-m-d'),
                'date_resigned' => ''
            );
        }
        return (object) $results;
    }

    public function random()
    {
        $random = str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ1234567890_!$%^&!$%^&');
        $password = substr($random, 0, 10);
        return $password;
    }

    public function generate_staff_no()
    {   
        $series = self::get()->count() + 1;
        
        if ($series <= 10) {
            return 'P'.date('Y').'0000'.$series;
        } 
        else if ($series <= 100) {
            return 'P'.date('Y').'000'.$series; 
        }
        else if ($series <= 1000) {
            return 'P'.date('Y').'00'.$series; 
        }
        else if ($series <= 10000) {
            return 'P'.date('Y').'0'.$series; 
        }
        else {
            return 'P'.date('Y').''.$series; 
        }
    }

    public function specifications()
    {	
        $specifications = array('' => 'select a specification', 'childhood-education' => 'Childhood Education', 'primary-education' => 'Primary Education', 'secondary-education' => 'Secondary Education', 'higher-education' => 'Higher Education');
        return $specifications;
    }
    
    public function marital_status()
    {	
        $marital_status = array('' => 'select a status', 'Single' => 'Single', 'Married' => 'Married', 'Widowed' => 'Widowed', 'Divorced' => 'Divorced');
        return $marital_status;
    }

    public function graduate_school_status()
    {	
        $marital_status = 
        array(
            '' => 'select a status', 
            'Graduated' => 'Graduated', 
            'Comprehensive Exam Passer' => 'Comprehensive Exam Passer', 
            'Completed Academic Requirements' => 'Completed Academic Requirements', 
            'Earned 9 Units' => 'Earned 9 Units',
            'Earned 18 Units' => 'Earned 18 Units',
            'Earned 27 Units' => 'Earned 27 Units',
            'Not Applicable' => 'Not Applicable'
        );
        return $marital_status;
    }

    public function types()
    {	
        $marital_status = array('' => 'select a type', 'Adviser' => 'Adviser', 'Teacher' => 'Teacher', 'Coordinator' => 'Coordinator', 'Administrator' => 'Administrator');
        return $marital_status;
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function role()
    {
        return $this->belongsTo('App\Models\Role', 'role_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo('App\Models\Department', 'department_id', 'id');
    }

    public function designation()
    {
        return $this->belongsTo('App\Models\Designation', 'designation_id', 'id');
    }

    public function get_column_via_user($column, $id)
    {
        return self::where('user_id', $id)->first()->$column;
        return $sections;  
    }
}

