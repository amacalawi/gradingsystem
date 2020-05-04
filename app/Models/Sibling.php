<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sibling extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'siblings';
    
    public $timestamps = false;
}

