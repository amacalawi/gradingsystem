<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EducationType extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'education_types';
    
    public $timestamps = false;

    public function fetch($id)
    {
        $education_type = self::find($id);
        if ($education_type) {
            $results = array(
                'id' => ($education_type->id) ? $education_type->id : '',
                'code' => ($education_type->code) ? $education_type->code : '',
                'name' => ($education_type->name) ? $education_type->name : '',
                'description' => ($education_type->description) ? $education_type->description : ''
            );
        } else {
            $results = array(
                'id' => '',
                'code' => '',
                'name' => '',
                'description' => ''
            );
        }
        return (object) $results;
    }

    public function all_education_types()
    {	
    	$education_types = self::where('is_active', 1)->orderBy('id', 'asc')->get();

        $deps = array();
        $deps[] = array('' => 'select a type');
        foreach ($education_types as $education_type) {
            $deps[] = array(
                $education_type->id => $education_type->name
            );
        }

        $education_types = array();
        foreach($deps as $dep) {
            foreach($dep as $key => $val) {
                $education_types[$key] = $val;
            }
        }

        return $education_types;
    }

    public function manage_education_types()
    {	
    	$education_types = self::where('is_active', 1)->orderBy('id', 'asc')->get();

        $deps = array();
        $deps[] = array('' => 'All');
        foreach ($education_types as $education_type) {
            $deps[] = array(
                $education_type->id => $education_type->name
            );
        }

        $education_types = array();
        foreach($deps as $dep) {
            foreach($dep as $key => $val) {
                $education_types[$key] = $val;
            }
        }

        return $education_types;
    }
}

