<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleHeader extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'roles_headers';
    
    public $timestamps = false;
}

