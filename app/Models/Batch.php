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

    public function get_current_batch()
    {
        return self::where('status', 'Current')->first()->id;
    }

    public function all_batches()
    {	
    	$batchs = self::where('is_active', 1)->orderBy('id', 'asc')->get();

        $batchx = array();
        $batchx[] = array('' => 'select a batch');
        foreach ($batchs as $batch) {
            $batchx[] = array(
                $batch->id => $batch->name
            );
        }

        $batchs = array();
        foreach($batchx as $batch) {
            foreach($batch as $key => $val) {
                $batchs[$key] = $val;
            }
        }

        return $batchs;
    }
}

