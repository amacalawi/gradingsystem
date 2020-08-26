<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DtrTimeSetting extends Model
{
    protected $guarded = ['id'];

    protected $table = 'dtr_time_settings';

    public $timestamps = false;

    public function fetch($id)
    {
        $dtrtimesetting = self::find($id);
        if ($dtrtimesetting) {
            $results = array(
                'id' => ($dtrtimesetting->id) ? $dtrtimesetting->id : '',
                'mode' => ($dtrtimesetting->mode) ? $dtrtimesetting->mode : '',
                'presetmsg_id' => ($dtrtimesetting->presetmsg_id) ? $dtrtimesetting->presetmsg_id : '',
                'schedule_id' => ($dtrtimesetting->schedule_id) ? $dtrtimesetting->schedule_id : ''
            );
        } else {
            $results = array(
                'id' => '',
                'mode' => '',
                'presetmsg_id' => '',
                'schedule_id' => ''
            );
        }
        return (object) $results;
    }

    public function get_preset_message_id($name, $schedule_id){
        
        $preset_message_id = self::select('presetmsg_id')
        ->where([
            'schedule_id' => $schedule_id,
            'name' => $name
        ])
        ->orderBy('id', 'asc')
        ->pluck('presetmsg_id');

        return $preset_message_id[0];
    }

}
