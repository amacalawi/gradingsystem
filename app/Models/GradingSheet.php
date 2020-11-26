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
            'section_info' =>  function($q) { 
                $q->select(['staffs.firstname as adviser_firstname', 'staffs.lastname as adviser_lastname','sections_info.id', 'levels.name as level_name' , 'sections.name as section_name'])
                ->join('levels', function($join)
                {
                    $join->on('levels.id', '=', 'sections_info.level_id');
                })
                ->join('sections', function($join)
                {
                    $join->on('sections.id', '=', 'sections_info.section_id');
                })
                ->join('staffs', function($join)
                {
                    $join->on('staffs.id', '=', 'sections_info.adviser_id');
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
                'material_id' => ($grading->material_id) ? $grading->material_id : '',
                'section_id' => ($grading->section_id) ? $grading->section_id : '',
                'section_name' => ($grading->section_info->section_name) ? $grading->section_info->section_name : '',
                'subject_id' => ($grading->subject_id) ? $grading->subject_id : '',
                'subject_name' => ($grading->subject->name) ? $grading->subject->name : '',
                'level_name' => ($grading->section_info->level_name) ? $grading->section_info->level_name : '',
                'locked' => ($grading->is_locked) ? $grading->is_locked : '',
                'type' => '',
                'section_info_id' => $grading->section_info->id,
                'education_type_id' => ($grading->education_type_id) ? $grading->education_type_id : '',
                'adviser' => ($grading->section_info->adviser_firstname) ? ucfirst($grading->section_info->adviser_firstname).' '.ucfirst($grading->section_info->adviser_lastname) : '',
                'teacher' => ($grading->subject->teacher_firstname) ? ucfirst($grading->subject->teacher_firstname).' '.ucfirst($grading->subject->teacher_lastname) : ''
            );
        } else {
            $results = array(
                'id' => '',
                'code' => '',
                'batch_id' => '',
                'quarter_id' => '',
                'material_id' => '',
                'section_info_id' => '',
                'subject_id' => '',
                'education_type_id' => ''
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

    public function section_info()
    {
        return $this->belongsTo('App\Models\SectionInfo', 'section_info_id', 'id');
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

