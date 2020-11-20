<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalendarSection extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'calendars_sections';
    
    public $timestamps = false;
}

