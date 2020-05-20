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
        $grading = self::find($id);
        if ($grading) {
            $results = array(
                'id' => ($grading->id) ? $grading->id : '',
                'code' => ($grading->code) ? $grading->code : '',
                'batch_id' => ($grading->batch_id) ? $grading->batch_id : '',
                'quarter_id' => ($grading->quarter_id) ? $grading->quarter_id : '',
                'section_id' => ($grading->section_id) ? $grading->section_id : '',
                'subject_id' => ($grading->subject_id) ? $grading->subject_id : ''
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
}

