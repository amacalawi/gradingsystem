<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'designations';
    
    public $timestamps = false;

    public function fetch($id)
    {
        $designation = self::with([
            'edtypes' =>  function($q) { 
                $q->select(['designations_education_types.id', 'designations_education_types.designation_id', 'designations_education_types.education_type_id']);
            }
        ])
        ->where('id', $id)->get();

        if ($designation->count() > 0) {
            $designation = $designation->first();
            $results = array(
                'id' => ($designation->id) ? $designation->id : '',
                'code' => ($designation->code) ? $designation->code : '',
                'name' => ($designation->name) ? $designation->name : '',
                'description' => ($designation->description) ? $designation->description : '',
                'education_type_id' => ($designation->id) ? $designation->edtypes->map(function($a) { return $a->education_type_id; }) : ''
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

    public function edtypes()
    {
        return $this->hasMany('App\Models\DesignationEducationType', 'designation_id', 'id')->where('designations_education_types.is_active', 1);
    }

    public function edtype()
    {
        return $this->belongsTo('App\Models\EducationType', 'education_type_id', 'id');
    }

    public function all_designations()
    {	
    	$designations = self::where('is_active', 1)->orderBy('id', 'asc')->get();

        $desigs = array();
        $desigs[] = array('' => 'select a position');
        foreach ($designations as $designation) {
            $desigs[] = array(
                $designation->id => $designation->name
            );
        }

        $designations = array();
        foreach($desigs as $desig) {
            foreach($desig as $key => $val) {
                $designations[$key] = $val;
            }
        }

        return $designations;
    }
}

