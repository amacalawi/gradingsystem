<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepartmentEducationType extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'departments_education_types';
    
    public $timestamps = false;

    public function department()
    {   
        return $this->belongsTo('App\Models\Department');
    }

    public function education_type()
    {   
        return $this->belongsTo('App\Models\EducationType');
    }
}

