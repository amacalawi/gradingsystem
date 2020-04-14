<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberType extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'members_types';
    
    public $timestamps = false;
}

