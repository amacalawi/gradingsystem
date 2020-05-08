<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'users_roles';
    
    public $timestamps = false;
}

