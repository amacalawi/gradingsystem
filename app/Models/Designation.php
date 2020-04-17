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
        $designation = self::find($id);
        if ($designation) {
            $results = array(
                'id' => ($designation->id) ? $designation->id : '',
                'code' => ($designation->code) ? $designation->code : '',
                'name' => ($designation->name) ? $designation->name : '',
                'description' => ($designation->description) ? $designation->description : '',
                'type' => ($designation->type) ? $designation->type : ''
            );
        } else {
            $results = array(
                'id' => '',
                'code' => '',
                'name' => '',
                'description' => '',
                'type' => ''
            );
        }
        return (object) $results;
    }

    public function types()
    {	
        $types = array('' => 'select a type', 'childhood-education' => 'Childhood Education', 'primary-education' => 'Primary Education', 'secondary-education' => 'Secondary Education', 'higher-education' => 'Higher Education');
        return $types;
    }

    public function all_designations()
    {	
    	$designations = self::where('is_active', 1)->orderBy('id', 'asc')->get();

        $desigs = array();
        $desigs[] = array('' => 'select a designation');
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

