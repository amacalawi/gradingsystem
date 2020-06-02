<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TransmutationElement;

class Transmutation extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'transmutations';
    
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
}

