<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'members';
    
    public $timestamps = false;

    public function fetch($id)
    {       
        if (!empty($id)) {
            $student = self::find($id)->where(['is_active' => '1'])->with([
                'siblings' =>  function($q) { 
                    $q->select(['member_id', 'id', 'firstname', 'middlename', 'lastname']); 
                }
            ]);
        }
        if (!empty($id)) {
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
                'is_guardian' => ($student->is_guardian) ? $student->is_guardian : '',
                'is_sibling' => ($student->is_sibling) ? $student->is_sibling : '',
                'current_address' => ($student->member_info->current_address) ? $student->member_info->current_address : '',
                'permanent_address' => ($student->member_info->permanent_address) ? $student->member_info->permanent_address : '',
                'mobile_no' => ($student->member_info->mobile_no) ? $student->member_info->mobile_no : '',
                'telephone_no' => ($student->member_info->telephone_no) ? $student->member_info->telephone_no : '',
                'special_remarks' => ($student->member_info->special_remarks) ? $student->member_info->special_remarks : '',
                'avatar' => ($student->avatar) ? $student->avatar : '',
                'mother_firstname' => ($student->member_info->mother_firstname) ? ($student->member_info->mother_firstname) : '',
                'mother_middlename' => ($student->member_info->mother_middlename) ? ($student->member_info->mother_middlename) : '',
                'mother_lastname' => ($student->member_info->mother_lastname) ? ($student->member_info->mother_lastname) : '',
                'mother_contact_no' => ($student->member_info->mother_contact_no) ? ($student->member_info->mother_contact_no) : '',
                'mother_avatar' => ($student->member_info->mohther_avatar) ? ($student->member_info->mohther_avatar) : '',
                'mother_selected' => ($student->member_info->mother_selected == 1) ? 1 : 0,
                'father_firstname' => ($student->member_info->father_firstname) ? ($student->member_info->father_firstname) : '',
                'father_middlename' => ($student->member_info->father_middlename) ? ($student->member_info->father_middlename) : '',
                'father_lastname' => ($student->member_info->father_lastname) ? ($student->member_info->father_lastname) : '',
                'father_contact_no' => ($student->member_info->father_contact_no) ? ($student->member_info->father_contact_no) : '',
                'father_avatar' => ($student->member_info->father_avatar) ? ($student->member_info->father_avatar) : '',
                'father_selected' => ($student->member_info->mother_selected) ? 1 : 0,
                'admitted_date' => ($student->admitted_date) ? $student->admitted_date : '',
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
                'identification_no' => '',
                'firstname' => '',
                'middlename' => '',
                'lastname' => '',
                'suffix' => '',
                'gender' => '',
                'birthdate' => '',
                'is_guardian' => '',
                'is_sibling' => '',
                'current_address' => '',
                'permanent_address' => '',
                'mobile_no' => '',
                'telephone_no' => '',
                'special_remarks' => '',
                'avatar' => '',
                'mother_firstname' => '',
                'mother_middlename' => '',
                'mother_lastname' => '',
                'mother_contact_no' => '',
                'mother_avatar' => '',
                'mother_selected' => 0,
                'father_firstname' => '',
                'father_middlename' => '',
                'father_lastname' => '',
                'father_contact_no' => '',
                'father_avatar' => '',
                'father_selected' => 0,
                'admitted_date' => date('Y-m-d'),
                'email_address' => '',
                'username' => '',
                'password' => '',
                'siblings' => '',
                'is_guardian' => 0,
                'is_sibling' => 0
            );
        }
        return (object) $results;
    }

    public function marital_status()
    {	
        $marital_status = array('' => 'select a status', 'Single' => 'Single', 'Married' => 'Married', 'Widowed' => 'Widowed', 'Divorced' => 'Divorced');
        return $marital_status;
    }

    public function member_type()
    {
        return $this->belongsTo('App\Models\MemberType', 'members_type_id', 'id');
    }

    public function member_info()
    {   
        return $this->hasOne('App\Model\MemberInformation', 'member_id', 'id');
    }

    public function user()
    {   
        return $this->hasOne('App\User', 'member_id', 'id');
    }

    public function siblings()
    {
        return $this->hasMany('App\siblings');    
    }
}

