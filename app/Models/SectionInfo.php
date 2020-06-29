<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Subject;
use App\Models\SectionsSubjects;

class SectionInfo extends Model
{
    protected $guarded = ['id'];

    protected $table = 'sections_info';
    
    public $timestamps = false;

    public function fetch($id)
    {
        $sectioninfos = self::with([
            'section' =>  function($q) { 
                $q->select(['id', 'code', 'name', 'description']); 
            },
            'level' =>  function($q) { 
                $q->select(['id', 'code', 'name', 'description']); 
            },
            'section_subjects.subject',
            'section_students.student'
        ])
        ->where('id', '=', $id)
        ->get();

        if ($sectioninfos) {
            $sectioninfos = $sectioninfos->first();
            $results = array(
                'id' => ($sectioninfos->id) ? $sectioninfos->id : '',
                'batch_id' => ($sectioninfos->batch_id) ? $sectioninfos->batch_id : '',
                'section_id' => ($sectioninfos->section_id) ? $sectioninfos->section_id : '',
                'adviser_id' => ($sectioninfos->adviser_id) ? $sectioninfos->adviser_id : '',
                'level_id' => ($sectioninfos->level_id) ? $sectioninfos->level_id : '',
                'section_name' => ($sectioninfos->section->name) ? $sectioninfos->section->name : '',
                'level_name' => ($sectioninfos->level->name) ? $sectioninfos->level->name : '',
                'type' => ($sectioninfos->type) ? $sectioninfos->type : '',
                'subjects' => ($sectioninfos->section_subjects) ? $sectioninfos->section_subjects : '',
                'students' => ($sectioninfos->section_students) ? $sectioninfos->section_students : '',
                'has_tle' => (new SectionsSubjects)->where(['is_active' => 1])->whereIn('subject_id', (new Subject)->select('id')->where(['is_active' => 1, 'is_tle' => 1]))->count(),
                'has_mapeh' => (new SectionsSubjects)->where(['is_active' => 1])->whereIn('subject_id', (new Subject)->select('id')->where(['is_active' => 1, 'is_mapeh' => 1]))->count()
            );
        } else {
            $results = array(
                'id' => '',
                'batch_id' => '',
                'section_id' => '',
                'adviser_id' => '',
                'level_id' => '',
                'type' => '',
            );
        }
        return (object) $results;
    }

    public function section()
    {   
        return $this->belongsTo('App\Models\Section');
    }

    public function level()
    {   
        return $this->belongsTo('App\Models\Level');
    }

    public function section_subjects()
    {
        return $this->hasMany('App\Models\SectionsSubjects', 'section_info_id', 'id')
        ->whereIn('subject_id', (new Subject)->select('id')->where(['is_active' => 1, 'is_mapeh' => 0, 'is_tle' => 0]))
        ->where('is_active', 1);   
    }

    public function section_students()
    {
        return $this->hasMany('App\Models\Admission', 'section_id', 'section_id')->where('is_active', 1);      
    }
}
