<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Module;
use App\Models\SubModule;

class GradingSheet extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'gradingsheets';
    
    public $timestamps = false;

    public function fetch($id)
    {
        $grading = self::where('id', $id)->with([
            'batch' =>  function($q) { 
                $q->select(['id', 'name']); 
            },
            'quarter' =>  function($q) { 
                $q->select(['id', 'name']); 
            },
            'section' =>  function($q) { 
                $q->select(['id', 'name']); 
            },
            'subject' =>  function($q) { 
                $q->select(['id', 'name']); 
            }
        ])->get();

        if ($grading->count() > 0) {
            $grading = $grading->first();
            $results = array(
                'id' => ($grading->id) ? $grading->id : '',
                'code' => ($grading->code) ? $grading->code : '',
                'batch_id' => ($grading->batch_id) ? $grading->batch_id : '',
                'batch_name' => ($grading->batch->name) ? $grading->batch->name : '',
                'quarter_id' => ($grading->quarter_id) ? $grading->quarter_id : '',
                'quarter_name' => ($grading->quarter->name) ? $grading->quarter->name : '',
                'section_id' => ($grading->section_id) ? $grading->section_id : '',
                'section_name' => ($grading->section->name) ? $grading->section->name : '',
                'subject_id' => ($grading->subject_id) ? $grading->subject_id : '',
                'subject_name' => ($grading->subject->name) ? $grading->subject->name : ''
            );
        } else {
            $results = array(
                'id' => '',
                'code' => '',
                'batch_id' => '',
                'quarter_id' => '',
                'section_id' => '',
                'subject_id' => ''
            );
        }
        return (object) $results;
    }

    public function batch()
    {
        return $this->belongsTo('App\Models\Batch', 'batch_id', 'id');
    }

    public function quarter()
    {
        return $this->belongsTo('App\Models\Quarter');
    }

    public function section()
    {
        return $this->belongsTo('App\Models\Section');
    }

    public function subject()
    {
        return $this->belongsTo('App\Models\Subject');
    }

    public function get_column_via_identifier($column, $id)
    {
        return self::where('id', $id)->first()->$column;
    }
}

