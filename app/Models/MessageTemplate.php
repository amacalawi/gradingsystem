<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageTemplate extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'messages_templates';
    
    public $timestamps = false;

    public function fetch($id)
    {
        $templates = self::find($id);
        if ($templates) {
            $results = array(
                'id' => ($templates->id) ? $templates->id : '',
                'code' => ($templates->code) ? $templates->code : '',
                'name' => ($templates->name) ? $templates->name : '',
                'messages' => ($templates->messages) ? $templates->messages : '',
                'type' => ($templates->type) ? $templates->type : '',
                'message_type_id' => ($templates->message_type_id) ? $templates->message_type_id : ''
            );
        } else {
            $results = array(
                'id' => '',
                'code' => '',
                'name' => '',
                'messages' => '',
                'type' => '',
                'message_type_id' => ''
            );
        }
        return (object) $results;
    }

    public function types()
    {
        return $this->belongsTo('App\Models\MessageType', 'message_type_id', 'id');
    }
}

