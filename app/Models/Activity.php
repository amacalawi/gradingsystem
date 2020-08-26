<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Module;
use App\Models\SubModule;

class Activity extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'activities';
    
    public $timestamps = false;

    public function lookup($column, $id)
    {   
        if (!empty($id)) {
            $results = self::where([
                $column => $id,
                'is_active' => 1
            ])->get();

            if ($results->count() > 0) {
                return $results;
            } else {
                return '';
            }
        } else {
            return '';
        }
    }

    public function sum_value_via_component($id)
    {
        $sum = self::where([
            'component_id' => $id,
            'is_active' => 1
        ])->sum('value');

        return $sum;
    }
}

