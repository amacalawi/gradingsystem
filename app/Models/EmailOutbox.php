<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailOutbox extends Model
{
    protected $guarded = ['id'];

    protected $table = 'emails_outboxes';
    
    public $timestamps = false;
}
