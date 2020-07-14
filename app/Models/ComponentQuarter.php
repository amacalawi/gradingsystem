<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComponentQuarter extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'components_quarters';
    
    public $timestamps = false;

    public function quarter()
    {   
        return $this->belongsTo('App\Models\Quarter');
    }
}

