<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DtrSendingConfig extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'dtr_sending_configs';
    
    public $timestamps = false;
}

