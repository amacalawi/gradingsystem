<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'components';
    
    public $timestamps = false;

    public function fetch($id)
    {
        $component = self::find($id);
        if ($component) {
            $results = array(
                'id' => ($component->id) ? $component->id : '',
                'batch_id' => ($component->batch_id) ? $component->batch_id : '',
                'quarter_id' => ($component->quarter_id) ? $component->quarter_id : '',
                'subject_id' => ($component->subject_id) ? $component->subject_id : '',
                'percentage' => ($component->percentage) ? $component->percentage : '',
                'name' => ($component->name) ? $component->name : '',
                'description' => ($component->description) ? $component->description : '',
                'order' => ($component->order) ? $component->order : '',
                'quarter_id' => ($component->quarter_id) ? $component->quarter_id : '',
                'subject_id' => ($component->subject_id) ? $component->subject_id : '',
                'is_sum_cell' => ($component->is_sum_cell > 0) ? 1 : 0,
                'is_hps_cell' => ($component->is_hps_cell > 0) ? 1 : 0,
                'is_ps_cell' => ($component->is_ps_cell > 0) ? 1 : 0,
                'activity_name' => '',
                'activity_value' => '',
                'activity_description' => ''
            );
        } else {
            $results = array(
                'id' => '',
                'batch_id' => '',
                'quarter_id' => '',
                'subject_id' => '',
                'percentage' => '',
                'name' => '',
                'description' => '',
                'order' => '',
                'quarter_id' => '',
                'subject_id' => '',
                'is_sum_cell' => '',
                'is_hps_cell' => '',
                'is_ps_cell' => '',
                'activity_name' => '',
                'activity_value' => '',
                'activity_description' => ''
            );
        }
        return (object) $results;
    }
}

