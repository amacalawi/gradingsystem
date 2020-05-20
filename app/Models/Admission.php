<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    protected $guarded = ['id'];

    protected $table = 'admissions';
    
    public $timestamps = false;

    public function fetch($id)
    {
        $admission = self::find($id);
        if ($admission) {
            $results = array(
                'id' => ($admission->id) ? $admission->id : '',
                'user_id' => ($admission->user_id) ? $admission->user_id : '',
                'batch_id' => ($admission->batch_id) ? $admission->batch_id : '',
                'level_id' => ($admission->level_id) ? $admission->level_id : '',
                'section_id' => ($admission->section_id) ? $admission->section_id : '',
                'status' => ($admission->status) ? $admission->status : '',
            );
        } else {
            $results = array(
                'id' => '',
                'user_id' => '',
                'batch_id' => '',
                'level_id' => '',
                'section_id' => '',
                'status' => '',
            );
        }
        return (object) $results;
    }

    public function all_admitted_student()
    {
        $admitted = self::where('is_active', 1)->where('status', 'admit')->where('batch_id', '1')->orderBy('id', 'desc')->get();
        return $admitted;
    }

    public function get_this_admitted( $id )
    {
        $admitted = Admission::select('admissions.id as admin_id','admissions.*','students.id as stud_id', 'students.*')
            ->join('students', 'students.id', '=', 'admissions.user_id')
            ->where('admissions.is_active', 1)
            ->where('admissions.user_id', $id)
            ->orderBy('admin_id', 'desc')->get();
            
        return $admitted;
    }
   
    public function getAdmitted_SectionsStudents($id) //sections_students_id
    {
        $admitted = Admission::where('section_student_id', $id)
        ->join('students', 'students.id', '=', 'admissions.user_id')
        ->where('status', 'admit')
        ->orderBy('admissions.id', 'desc')->get();
        return $admitted;
    }

}
