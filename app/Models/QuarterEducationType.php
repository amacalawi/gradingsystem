<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuarterEducationType extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'quarters_education_types';
    
    public $timestamps = false;

    public function quarter()
    {   
        return $this->belongsTo('App\Models\Quarter');
    }

    public function education_type()
    {   
        return $this->belongsTo('App\Models\EducationType');
    }
}

