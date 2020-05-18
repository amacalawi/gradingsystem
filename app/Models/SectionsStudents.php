<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectionsStudents extends Model
{
    protected $guarded = ['id'];

    protected $table = 'sections_students';
    
    public $timestamps = false;

    public function getSection_Student( $id )
    {
        $sections_students = SectionsStudents::select('sections_students.user_id','admissions.firstname','admissions.middlename','admissions.lastname')
        ->join('admissions','admissions.user_id', '=', 'sections_students.user_id')
        ->where('sections_students.section_id',$id)->get();

        return $sections_students;
    }
}
