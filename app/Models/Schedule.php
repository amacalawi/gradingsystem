<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $guarded = ['id'];

    protected $table = 'schedules';
    
    public $timestamps = false;

    public function fetch($id)
    {
        $schedule = self::find($id);
        if ($schedule) {
            $results = array(
                'id' => ($schedule->id) ? $schedule->id : '',
                'code' => ($schedule->code) ? $schedule->code : '',
                'name' => ($schedule->name) ? $schedule->name : '',
                'description' => ($schedule->description) ? $schedule->description : '',
            );
        } else {
            $results = array(
                'id' => '',
                'code' => '',
                'name' => '',
                'description' => ''
            );
        }
        return (object) $results;
    }

    public function get_this_schedule($id)
    {
        $schedule = self::join('dtr_time_settings', 'schedules.id', 'dtr_time_settings.schedule_id')->join('dtr_time_days', 'dtr_time_days.dtr_time_settings_id','dtr_time_settings.id')->where('schedules.id', $id)->where('schedules.is_active', 1)->orderBy('schedules.id', 'desc')->get();
        return $schedule;
    }

    public function get_all_schedules_with_empty()
    {
    	$schedules = self::where('is_active', 1)->orderBy('id', 'asc')->get();

        $schs = array();
        $schs[] = array('' => 'please select a schedule');
        foreach ($schedules as $schedule) {
            $schs[] = array(
                $schedule->id => $schedule->name
            );
        }

        $schedules = array();
        foreach($schs as $sch) {
            foreach($sch as $key => $val) {
                $schedules[$key] = $val;
            }
        }

        return $schedules;
    } 
}
