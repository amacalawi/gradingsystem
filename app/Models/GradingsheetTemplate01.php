<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradingsheetTemplate01 extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'gradingsheet_template_01';
    
    public $timestamps = false;

    public function fetch($id)
    {
        $template = self::with([
            'levels' => function($q1) { 
                $q1->select(['id', 'code', 'name']); 
            },
            'sections' => function($q2) { 
                $q2->select(['id', 'code', 'name']); 
            }
        ])
        ->find($id);
        if ($template) {
            $results = array(
                'id' => ($template->id) ? $template->id : '',
                'identification_no' => ($template->identification_no) ? $template->identification_no : '',
                'firstname' => ($template->firstname) ? $template->firstname : '',
                'middlename' => ($template->middlename) ? $template->middlename : '',
                'lastname' => ($template->lastname) ? $template->lastname : '',
                'grade_level' => ($template->grade_level) ? $template->levels->id : '',
                'section' => ($template) ? $template->sections->id : '',
                'adviser' => ($template->adviser) ? $template->adviser : '',
                'academics_status' => ($template->academics_status) ? $template->academics_status : '',
                'eligibility' => ($template->eligibility) ? $template->eligibility : '',
                'remarks' => ($template->remarks) ? $template->remarks : ''
            );
        } else {
            $results = array(
                'id' => '',
                'identification_no' => '',
                'firstname' => '',
                'middlename' => '',
                'lastname' => '',
                'grade_level' => '',
                'section' => '',
                'adviser' => '',
                'academics_status' => '',
                'eligibility' => '',
                'remarks' => ''
            );
        }
        return (object) $results;
    }

    public function levels()
    {
        return $this->belongsTo('App\Models\Level', 'grade_level', 'name');
    }

    public function sections()
    {
        return $this->belongsTo('App\Models\Section', 'section', 'name');
    }

    public function lookup($identification_no, $column)
    {   
        $message = '';
        
        $query = self::where('identification_no', $identification_no)->get();
        if ($query->count() > 0) {
            $message = $query->first()->$column;
        } 

        return $message;
    }
}

