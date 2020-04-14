<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberInformation extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'members_informations';
    
    public $timestamps = false;
}

