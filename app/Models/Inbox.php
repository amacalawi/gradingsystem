<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'inbox';
    
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}

