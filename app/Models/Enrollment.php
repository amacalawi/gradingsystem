<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $guarded = ['id'];

    protected $table = 'enrollments';
    
    public $timestamps = false;

    public function level()
    {
        return $this->belongsTo('App\Models\Level');
    }
}
