<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectEducationTypes extends Model
{
    protected $guarded = ['id'];

    protected $table = 'subjects_education_types';
    
    public $timestamps = false;

    public function edtype()
    {
        return $this->belongsTo('App\Models\EducationType', 'education_type_id', 'id');
    }
    
}
