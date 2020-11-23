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
        $trans = self::with([
            'elements' => function($q) {
                $q->select(['id', 'transmutation_id', 'score', 'equivalent']); 
            },
        ])->find($id);
        if ($trans) {
            $results = array(
                'id' => ($trans->id) ? $trans->id : '',
                'code' => ($trans->code) ? $trans->code : '',
                'name' => ($trans->name) ? $trans->name : '',
                'description' => ($trans->description) ? $trans->description : '',
                'education_type_id' => ($trans->education_type_id) ? $trans->education_type_id : '',
                'elements' ($trans->id) ? ($trans->elements) : ''
            );
        } else {
            $results = array(
                'id' => '',
                'code' => '',
                'name' => '',
                'description' => '',
                'education_type_id' => '',
                'elements' => ''
            );
        }
        return (object) $results;
    }

    public function elements()
    {
        return $this->hasMany('App\Models\TransmutationElement', 'transmutation_id', 'id');    
    }
}

