<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SectionsSubjects extends Model
{
    protected $guarded = ['id'];

    protected $table = 'sections_subjects';
    
    public $timestamps = false;
}
