<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'batches';
    
    public $timestamps = false;

    public function fetch($id)
    {
        $batch = self::find($id);
        if ($batch) {
            $results = array(
                'id' => ($batch->id) ? $batch->id : '',
                'code' => ($batch->code) ? $batch->code : '',
                'name' => ($batch->name) ? $batch->name : '',
                'description' => ($batch->description) ? $batch->description : '',
                'date_start' => ($batch->date_start) ? $batch->date_start : '',
                'date_end' => ($batch->date_end) ? $batch->date_end : '',
                'status' => ($batch->status) ? $batch->status : ''
            );
        } else {
            $results = array(
                'id' => '',
                'code' => '',
                'name' => '',
                'description' => '',
                'date_start' => '',
                'date_end' => '',
                'status' => ''
            );
        }
        return (object) $results;
    }
}

