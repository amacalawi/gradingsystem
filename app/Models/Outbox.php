<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Outbox extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'outbox';
    
    public $timestamps = false;

    public function message()
    {
        return $this->belongsTo('App\Models\Message', 'message_id', 'id');
    }
}

