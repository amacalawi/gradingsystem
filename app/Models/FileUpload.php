<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileUpload extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'files';
    
    public $timestamps = false;
}

