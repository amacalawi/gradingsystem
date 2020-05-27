<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\GradingSheet;
use App\Models\Batch;

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

    public function section()
    {   
        return $this->belongsTo('App\Models\Section');
    }

    public function student()
    {   
        return $this->hasOne('App\Models\Student', 'user_id', 'student_id');
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
