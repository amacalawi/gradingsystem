<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PresetMessage extends Model
{
    protected $guarded = ['id'];

    protected $table = 'preset_messages';
    
    public $timestamps = false;

    public function fetch($id)
    {
        $presetmsg = self::find($id);
        if ($presetmsg) {
            $results = array(
                'id' => ($presetmsg->id) ? $presetmsg->id : '',
                'message' => ($presetmsg->message) ? $presetmsg->message : '',
            );
        } else {
            $results = array(
                'id' => '',
                'message' => '',
            );
        }
        return (object) $results;
    }

    public function all_preset_message()
    {	
    	$preset_messages = self::where('is_active', 1)->orderBy('id', 'asc')->get();

        $pmgs = array();
        $pmgs[] = array('0' => 'select a preset message');
        foreach ($preset_messages as $preset_message) {
            $pmgs[] = array(
                $preset_message->id => $preset_message->message
            );
        }

        $preset_messages = array();
        foreach($pmgs as $pmg) {
            foreach($pmg as $key => $val) {
                $preset_messages[$key] = $val;
            }
        }

        return $preset_messages;
    }
}
