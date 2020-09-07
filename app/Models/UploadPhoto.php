<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UploadPhoto extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'upload_photos';
    
    public $timestamps = false;
}

