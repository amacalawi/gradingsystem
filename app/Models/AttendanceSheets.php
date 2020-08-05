<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceSheets extends Model
{
    protected $guarded = ['id'];

    protected $table = 'attendance_sheets';
    
    public $timestamps = false;

    public function fetch($id)
    {
        $attendance_sheets = self::find($id);
        if ($attendance_sheets) {
            $results = array(
                'id' => ($attendance_sheets->id) ? $attendance_sheets->id : '',
                'user_id' => ($attendance_sheets->user_id) ? $attendance_sheets->user_id : '',
                'timed_in' => ($attendance_sheets->timed_in) ? $attendance_sheets->timed_in : '',
                'timed_out' => ($attendance_sheets->timed_out) ? $attendance_sheets->timed_out : '',
                'attendance_category_id' => ($attendance_sheets->attendance_category_id) ? $attendance_sheets->attendance_category_id : '',
                'reason' => ($attendance_sheets->reason) ? $attendance_sheets->reason : '',
                'status' => ($attendance_sheets->status) ? $attendance_sheets->status : '',
            );
        } else {
            $results = array(
                'id' => '',
                'user_id' => '',
                'timed_in' => '',
                'timed_out' => '',
                'attendance_category_id' => '',
                'reason' => '',
                'status' => '',
            );
        }
        return (object) $results;
    }

    public function staff()
    {
        return $this->belongsTo('App\Models\Staff', 'user_id', 'id');
    }
}
