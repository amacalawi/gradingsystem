<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dtrlog extends Model
{
    protected $guarded = ['id'];

    protected $table = 'dtr_logs';

    public $timestamps = false;
}
