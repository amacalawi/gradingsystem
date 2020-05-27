<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectionsStudents extends Model
{
    protected $guarded = ['id'];

    protected $table = 'sections_students';
    
    public $timestamps = false;

    public function fetch($id)
    {
        $sectionstudent = self::find($id);
        if ($sectionstudent) {
            $results = array(
                'id' => ($sectionstudent->id) ? $sectionstudent->id : '',
                'code' => ($sectionstudent->code) ? $sectionstudent->code : '',
                'name' => ($sectionstudent->name) ? $sectionstudent->name : '',
                'description' => ($sectionstudent->description) ? $sectionstudent->description : '',
                'type' => ($sectionstudent->type) ? $sectionstudent->type : '',
                'section_id' => ($sectionstudent->section_id) ? $sectionstudent->section_id : '',
                'staff_id' => ($sectionstudent->staff_id) ? $sectionstudent->staff_id : '',
                'batch_id' => ($sectionstudent->batch_id) ? $sectionstudent->batch_id : '',
            );
        } else {
            $results = array(
                'id' => '',
                'code' => '',
                'name' => '',
                'description' => '',
                'type' => '',
                'section_id' => '',
                'staff_id' => '',
                'batch_id' => '',
            );
        }
        return (object) $results;
    }

    public function getSection_Student( $id )
    {
        
        $sections_students = SectionsStudents::select('sections_students.user_id','admissions.firstname','admissions.middlename','admissions.lastname')
        ->join('admissions','admissions.user_id', '=', 'sections_students.user_id')
        ->where('sections_students.section_id',$id)->get();

        return $sections_students;
    }
}
