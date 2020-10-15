<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnrollmentForm extends Model
{
    protected $guarded = ['id'];

    protected $table = 'enrollments_forms';
    
    public $timestamps = false;
}
