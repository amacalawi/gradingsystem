<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\GradingSheet;
use App\Models\Batch;
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

    public function section()
    {   
        return $this->belongsTo('App\Models\Section');
    }

    public function student()
    {   
        return $this->hasOne('App\Models\Student', 'id', 'student_id');
    }

    public function get_students_via_gradingsheet($id)
    {
        $results = self::with([
            'student' => function($q) {
                $q->select([
                    'user_id', 
                    'id', 
                    'identification_no', 
                    'firstname', 
                    'middlename', 
                    'lastname'
                ]);
            },
        ])->where([
            'batch_id' => (new Batch)->get_current_batch(),
            'section_id' => (new GradingSheet)->get_column_via_identifier('section_id', $id),
            'status' => 'admit',
            'is_active' => 1
        ])->orderBy('id', 'ASC')->get();

        $students = $results->map(function($res) {
            return (object) [
                'user_id' => $res->student->user_id,
                'student_id' => $res->student->id,
                'fullname' => ucfirst($res->student->firstname).' '.ucfirst($res->student->lastname),
                'identification_no' => $res->student->identification_no
            ];
        });

        return $students;
    }
}
