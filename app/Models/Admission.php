<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Student;

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
                'batch_id' => ($admission->batch_id) ? $admission->batch_id : '',
                'section_id' => ($admission->section_id) ? $admission->section_id : '',
                'student_id' => ($admission->student_id) ? $admission->student_id : '',
                'status' => ($admission->status) ? $admission->status : '',
            );
        } else {
            $results = array(
                'id' => '',
                'batch_id' => '',
                'section_id' => '',
                'student_id' =>  '',
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
        $student = Student::select('*')
            ->where('is_active', 1)
            ->where('id', $id)
            ->get();
            
        return $student;
    }
   
    public function getthisAdmitted($id)
    {
        $admitted = Admission::where('section_id', $id)
        ->join('students', 'students.id', '=', 'admissions.student_id')
        ->orderBy('admissions.id', 'desc')
        ->get();

        return $admitted;
    }

}
