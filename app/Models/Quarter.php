<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quarter extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'quarters';
    
    public $timestamps = false;

    public function fetch($id)
    {
        $quarter = self::find($id);
        if ($quarter) {
            $results = array(
                'id' => ($quarter->id) ? $quarter->id : '',
                'code' => ($quarter->code) ? $quarter->code : '',
                'name' => ($quarter->name) ? $quarter->name : '',
                'description' => ($quarter->description) ? $quarter->description : '',
                'date_start' => ($quarter->date_start) ? $quarter->date_start : '',
                'date_end' => ($quarter->date_end) ? $quarter->date_end : '',
                'type' => ($quarter->type) ? $quarter->type : ''
            );
        } else {
            $results = array(
                'id' => '',
                'code' => '',
                'name' => '',
                'description' => '',
                'date_start' => '',
                'date_end' => '',
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
}

