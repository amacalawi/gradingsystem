<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'students';
    
    public $timestamps = false;

    public function fetch($id)
    {       
        if (!empty($id)) {
            $student = self::with([
                'siblings' => function($q) {
                    $q->select(['student_id', 'sibling_id']); 
                },
                'user' =>  function($q) { 
                    $q->select(['id', 'email', 'username', 'password']); 
                },
                'guardian' =>  function($q) { 
                    $q->select(['student_id', 'mother_firstname', 'mother_middlename', 'mother_lastname', 'mother_contact_no', 'mother_email', 'mother_avatar', 'mother_selected', 'father_firstname', 'father_middlename', 'father_lastname', 'father_contact_no', 'father_email', 'father_avatar', 'father_selected']); 
                },
            ])->where('id', $id)->first();

            $results = array(
                'id' => ($student->id) ? $student->id : '',
                'members_type_id' => ($student->members_type_id) ? $student->members_type_id : '',
                'identification_no' => ($student->identification_no) ? $student->identification_no : '',
                'firstname' => ($student->firstname) ? $student->firstname : '',
                'middlename' => ($student->middlename) ? $student->middlename : '',
                'lastname' => ($student->lastname) ? $student->lastname : '',
                'suffix' => ($student->suffix) ? $student->suffix : '',
                'gender' => ($student->gender) ? $student->gender : '',
                'birthdate' => ($student->birthdate) ? $student->birthdate : '',
                'marital_status' => ($student->marital_status) ? $student->marital_status : '',
                'current_address' => ($student->current_address) ? $student->current_address : '',
                'permanent_address' => ($student->permanent_address) ? $student->permanent_address : '',
                'mobile_no' => ($student->mobile_no) ? $student->mobile_no : '',
                'telephone_no' => ($student->telephone_no) ? $student->telephone_no : '',
                'special_remarks' => ($student->special_remarks) ? $student->special_remarks : '',
                'mother_firstname' => ($student->guardian->mother_firstname) ? ($student->guardian->mother_firstname) : '',
                'mother_middlename' => ($student->guardian->mother_middlename) ? ($student->guardian->mother_middlename) : '',
                'mother_lastname' => ($student->guardian->mother_lastname) ? ($student->guardian->mother_lastname) : '',
                'mother_contact_no' => ($student->guardian->mother_contact_no) ? ($student->guardian->mother_contact_no) : '',
                'mother_email' => ($student->guardian->mother_email) ? ($student->guardian->mother_email) : '',
                'mother_avatar' => ($student->guardian->mother_avatar) ? ($student->guardian->mother_avatar) : '',
                'mother_selected' => ($student->guardian->mother_selected == 1) ? 1 : 0,
                'father_firstname' => ($student->guardian->father_firstname) ? ($student->guardian->father_firstname) : '',
                'father_middlename' => ($student->guardian->father_middlename) ? ($student->guardian->father_middlename) : '',
                'father_lastname' => ($student->guardian->father_lastname) ? ($student->guardian->father_lastname) : '',
                'father_contact_no' => ($student->guardian->father_contact_no) ? ($student->guardian->father_contact_no) : '',
                'father_email' => ($student->guardian->father_email) ? ($student->guardian->father_email) : '',
                'father_avatar' => ($student->guardian->father_avatar) ? ($student->guardian->father_avatar) : '',
                'father_selected' => ($student->guardian->father_selected) ? 1 : 0,
                'admitted_date' => ($student->admitted_date) ? $student->admitted_date : '',
                'avatar' => ($student->avatar) ? $student->avatar : '',
                'email' => ($student->user->email) ? $student->user->email : '',
                'username' => ($student->user->username) ? $student->user->username : '',
                'password' => ($student->user->password) ? $student->user->password : '',
                'siblings' => $student->siblings,
                'is_guardian' => ($student->is_guardian) ? $student->is_guardian : 0,
                'is_sibling' => ($student->is_sibling) ? $student->is_sibling : 0
            );
        } else {
            $results = array(
                'id' => '',
                'members_type_id' => '',
                'identification_no' => $this->generate_student_no(),
                'firstname' => '',
                'middlename' => '',
                'lastname' => '',
                'suffix' => '',
                'gender' => '',
                'birthdate' => '',
                'marital_status' => '',
                'current_address' => '',
                'permanent_address' => '',
                'mobile_no' => '',
                'telephone_no' => '',
                'special_remarks' => '',
                'mother_firstname' => '',
                'mother_middlename' => '',
                'mother_lastname' => '',
                'mother_contact_no' => '',
                'mother_email' => '',
                'mother_avatar' => '',
                'mother_selected' => 0,
                'father_firstname' => '',
                'father_middlename' => '',
                'father_lastname' => '',
                'father_contact_no' => '',
                'father_email' => '',
                'father_avatar' => '',
                'father_selected' => 0,
                'admitted_date' => date('Y-m-d'),
                'avatar' => '',
                'email' => '',
                'username' => $this->generate_student_no(),
                'password' => $this->random(),
                'siblings' => '',
                'is_guardian' => 0,
                'is_sibling' => 0
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

    public function generate_student_no()
    {   
        $series = self::get()->count() + 1;
        
        if ($series <= 10) {
            return 'S'.date('Y').'0000'.$series;
        } 
        else if ($series <= 100) {
            return 'S'.date('Y').'000'.$series; 
        }
        else if ($series <= 1000) {
            return 'S'.date('Y').'00'.$series; 
        }
        else if ($series <= 10000) {
            return 'S'.date('Y').'0'.$series; 
        }
        else {
            return 'S'.date('Y').''.$series; 
        }
    }

    public function marital_status()
    {	
        $marital_status = array('' => 'select a status', 'Single' => 'Single', 'Married' => 'Married', 'Widowed' => 'Widowed', 'Divorced' => 'Divorced');
        return $marital_status;
    }

    public function user()
    {   
        return $this->belongsTo('App\User');
    }

    public function guardian()
    {   
        return $this->hasOne('App\Models\Guardian', 'student_id', 'id');
    }

    public function siblings()
    {
        return $this->hasMany('App\Models\Sibling', 'student_id', 'id');    
    }

    public function get_all_siblings($id)
    {
        $resources = self::where('is_active', '1')->where('identification_no', '!=', $id)->get();

        $siblings = $resources->map(function($res) {
            $middlename = $res->middlename ? strtoupper($res->middlename[0]).'.' : '';
            return [
                $res->identification_no.' - '. ucwords($res->lastname) .', '. ucwords($res->firstname) . ' ' . $middlename
            ];
        });

        return $siblings;
    }
}

