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
                'education_type_id' => ($quarter->education_type_id) ? $quarter->education_type_id : ''
            );
        } else {
            $results = array(
                'id' => '',
                'code' => '',
                'name' => '',
                'description' => '',
                'date_start' => '',
                'date_end' => '',
                'education_type_id' => ''
            );
        }
        return (object) $results;
    }

    public function all_quarters()
    {	
    	$quarters = self::where('is_active', 1)->orderBy('id', 'asc')->get();

        $quarterx = array();
        $quarterx[] = array('' => 'select a quarter');
        foreach ($quarters as $quarter) {
            $quarterx[] = array(
                $quarter->id => $quarter->name
            );
        }

        $quarters = array();
        foreach($quarterx as $quarter) {
            foreach($quarter as $key => $val) {
                $quarters[$key] = $val;
            }
        }

        return $quarters;
    }

    public function edtype()
    {
        return $this->belongsTo('App\Models\EducationType', 'education_type_id', 'id');
    }

    public function all_quarters_via_type($type)
    {
        $quarters = self::where([
            'education_type_id' => $type,
            'is_active' => 1
        ])
        ->orderBy('id', 'asc')
        ->get();

        return $quarters;
    }
}

