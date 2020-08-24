<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DtrTimeDay extends Model
{
    protected $guarded = ['id'];

    protected $table = 'dtr_time_days';

    public $timestamps = false;
}
