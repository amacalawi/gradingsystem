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
                'identification_no' => $this->generate_staff_no(),
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
                'email' => '',
                'username' => $this->generate_staff_no(),
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

    public function marital_status()
    {	
        $marital_status = array('' => 'select a status', 'Single' => 'Single', 'Married' => 'Married', 'Widowed' => 'Widowed', 'Divorced' => 'Divorced');
        return $marital_status;
    }

    public function specifications()
    {	
        $specifications = array('' => 'select a specification', 'childhood-education' => 'Childhood Education', 'primary-education' => 'Primary Education', 'secondary-education' => 'Secondary Education', 'higher-education' => 'Higher Education');
        return $specifications;
    }

    public function types()
    {	
        $marital_status = array('' => 'select a type', 'Staff' => 'Staff', 'Adviser' => 'Adviser', 'Teacher' => 'Teacher');
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

