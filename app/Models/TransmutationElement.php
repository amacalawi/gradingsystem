<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Transmutation;

class TransmutationElement extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'transmutations_elements';
    
    public $timestamps = false;

    public function fetch($id)
    {
        $header = self::find($id);
        if ($header) {
            $results = array(
                'id' => ($header->id) ? $header->id : '',
                'code' => ($header->code) ? $header->code : '',
                'name' => ($header->name) ? $header->name : '',
                'description' => ($header->description) ? $header->description : '',
                'slug' => ($header->slug) ? $header->slug : '',
                'order' => ($header->order) ? $header->order : ''
            );
        } else {
            $results = array(
                'id' => '',
                'code' => '',
                'name' => '',
                'description' => '',
                'slug' => '',
                'order' => ''
            );
        }
        return (object) $results;
    }

    public function transmutation()
    {
        return $this->belongsTo('App\Models\Transmutation', 'transmutation_id', 'id');
    }
}

