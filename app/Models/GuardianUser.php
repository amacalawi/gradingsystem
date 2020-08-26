<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuardianUser extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'guardians_users';
    
    public $timestamps = false;
}

