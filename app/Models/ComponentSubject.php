<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComponentSubject extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'components_subjects';
    
    public $timestamps = false;

    public function component()
    {   
        return $this->belongsTo('App\Models\Component');
    }

    public function subject()
    {   
        return $this->belongsTo('App\Models\Subject');
    }
}

