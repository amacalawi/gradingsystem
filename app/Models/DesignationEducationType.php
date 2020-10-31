<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DesignationEducationType extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'designations_education_types';
    
    public $timestamps = false;

    public function designation()
    {   
        return $this->belongsTo('App\Models\Designation');
    }

    public function education_type()
    {   
        return $this->belongsTo('App\Models\EducationType');
    }
}

