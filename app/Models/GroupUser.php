<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupUser extends Model
{
    protected $guarded = ['id'];

    protected $table = 'groups_users';
    
    public $timestamps = false;
}
