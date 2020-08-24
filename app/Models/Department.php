<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'departments';
    
    public $timestamps = false;

    public function fetch($id)
    {
        $department = self::find($id);
        if ($department) {
            $results = array(
                'id' => ($department->id) ? $department->id : '',
                'code' => ($department->code) ? $department->code : '',
                'name' => ($department->name) ? $department->name : '',
                'description' => ($department->description) ? $department->description : '',
                'education_type_id' => ($department->education_type_id) ? $department->education_type_id : ''
            );
        } else {
            $results = array(
                'id' => '',
                'code' => '',
                'name' => '',
                'description' => '',
                'education_type_id' => ''
            );
        }
        return (object) $results;
    }

    public function edtype()
    {
        return $this->belongsTo('App\Models\EducationType', 'education_type_id', 'id');
    }

    public function all_departments()
    {	
    	$departments = self::where('is_active', 1)->orderBy('id', 'asc')->get();

        $deps = array();
        $deps[] = array('' => 'select a department');
        foreach ($departments as $department) {
            $deps[] = array(
                $department->id => $department->name
            );
        }

        $departments = array();
        foreach($deps as $dep) {
            foreach($dep as $key => $val) {
                $departments[$key] = $val;
            }
        }

        return $departments;
    }

}

