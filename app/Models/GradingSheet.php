<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Module;
use App\Models\SubModule;
use App\Models\Batch;

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
                $q->select(['staffs.firstname as adviser_firstname', 'staffs.lastname as adviser_lastname', 'sections.id', 'sections.name as section_name', 'levels.name as level_name', 'sections_info.type as type'])
                ->join('sections_info', function($join)
                {
                    $join->on('sections_info.section_id', '=', 'sections.id');
                })
                ->join('levels', function($join2)
                {
                    $join2->on('levels.id', '=', 'sections_info.level_id');
                })
                ->join('staffs', function($join3)
                {
                    $join3->on('staffs.id', '=', 'sections_info.adviser_id');
                });
            },
            'subject' =>  function($q) { 
                $q->select(['subjects.id', 'subjects.name', 'staffs.firstname as teacher_firstname', 'staffs.lastname as teacher_lastname'])
                ->join('sections_subjects', function($join2)
                {
                    $join2->on('sections_subjects.subject_id', '=', 'subjects.id');
                })
                ->join('staffs', function($join2)
                {
                    $join2->on('staffs.id', '=', 'sections_subjects.teacher_id');
                })
                ->where([
                    'sections_subjects.batch_id' => (new Batch)->get_current_batch(),
                    'sections_subjects.is_active' => 1
                ]);
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
                'section_name' => ($grading->section->section_name) ? $grading->section->section_name : '',
                'subject_id' => ($grading->subject_id) ? $grading->subject_id : '',
                'subject_name' => ($grading->subject->name) ? $grading->subject->name : '',
                'level_name' => ($grading->section->level_name) ? $grading->section->level_name : '',
                'type' => ($grading->section->type) ? $grading->section->type : '',
                'adviser' => ($grading->section->adviser_firstname) ? ucfirst($grading->section->adviser_firstname).' '.ucfirst($grading->section->adviser_lastname) : '',
                'teacher' => ($grading->subject->teacher_firstname) ? ucfirst($grading->subject->teacher_firstname).' '.ucfirst($grading->subject->teacher_lastname) : ''
            );
        } else {
            $results = array(
                'id' => '',
                'code' => '',
                'batch_id' => '',
                'quarter_id' => '',
                'section_id' => '',
                'subject_id' => '',
                'type' => ''
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

    public function types()
    {	
        $types = array('' => 'select a type', 'childhood-education' => 'Childhood Education', 'primary-education' => 'Primary Education', 'secondary-education' => 'Secondary Education', 'higher-education' => 'Higher Education');
        return $types;
    }
}

