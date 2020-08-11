<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceSheetsSettings extends Model
{
    protected $guarded = ['id'];

    protected $table = 'attendance_sheets_settings';
    
    public $timestamps = false;

    public function fetch_staff($id)
    {
        $staffssettings = self::with([
            'staff' =>  function($q) { 
                $q->select(['id', 'identification_no', 'firstname', 'lastname', 'middlename']);
            }
        ])
        ->where('id', $id)->get();

        if ($staffssettings->count() > 0) {
            $staffssettings = $staffssettings->first();
            $results = array(
                'id' => ($staffssettings->id) ? $staffssettings->id : '',
                'batch_id' => ($staffs->batch_id) ? $staffs->batch_id : '',
                'staffname' => ($staffssettings->staffs->identification_no) ? $staffssettings->staffs->identification_no : '',
                'schedule_id' => ($staffssettings->schedule_id) ? $staffssettings->schedule_id : '',
            );
        } else {
            $results = array(
                'id' => '',
                'batch_id' => '',
                'staffname' => '',
                'schedule_id' => '',
            );
        }
        return (object) $results;
    }

    public function fetch_student($id)
    {
        $studentssettings = self::with([
            'student' =>  function($q) { 
                $q->select(['id', 'identification_no', 'firstname', 'lastname', 'middlename']);
            }
        ])
        ->where('id', $id)->get();

        if ($studentssettings->count() > 0) {
            $studentssettings = $studentssettings->first();
            $results = array(
                'id' => ($studentssettings->id) ? $studentssettings->id : '',
                'batch_id' => ($student->batch_id) ? $student->batch_id : '',
                'studentname' => ($studentssettings->student->identification_no) ? $studentssettings->student->identification_no : '',
                'schedule_id' => ($studentssettings->schedule_id) ? $studentssettings->schedule_id : '',
            );
        } else {
            $results = array(
                'id' => '',
                'batch_id' => '',
                'studentname' => '',
                'schedule_id' => '',
            );
        }
        return (object) $results;
    }

    public function staff()
    {
        return $this->belongsTo('App\Models\Staff', 'user_id', 'user_id')->where('is_active', 1)->where('role_id', 3);
    }

    public function student()
    {
        return $this->belongsTo('App\Models\Student', 'user_id', 'user_id')->where('is_active', 1)->where('role_id', 4);
    }

    public function schedule()
    {
        return $this->belongsTo('App\Models\Schedule', 'schedule_id', 'id');
    }
}
