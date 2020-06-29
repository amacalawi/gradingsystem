<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectionsSubjects extends Model
{
    protected $guarded = ['id'];

    protected $table = 'sections_subjects';
    
    public $timestamps = false;

    public function getSection_Subject($id)
    {
        $sections_subjects = SectionsSubjects::select('sections_subjects.id','sections_subjects.subject_id','sections_subjects.staff_id','subjects.name', 'staffs.firstname', 'staffs.middlename', 'staffs.lastname', 'staffs.user_id')
        ->join('subjects','subjects.id', '=', 'sections_subjects.subject_id')
        ->join('staffs','staffs.id', '=', 'sections_subjects.staff_id')
        ->where('sections_subjects.section_student_id', $id)
        ->where('sections_subjects.is_active', 1)->get();

        return $sections_subjects;
    }

    public function get_sections_subjects($section_info_id)
    {
        $sections_subjects = SectionsSubjects::where('section_info_id', $section_info_id)->get();
        return $sections_subjects;
    }

    public function subject()
    {   
        return $this->belongsTo('App\Models\Subject');
    }
}
