<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageType extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'messages_types';
    
    public $timestamps = false;
}

