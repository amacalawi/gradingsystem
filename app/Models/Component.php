<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\GradingSheet;
use App\Models\Batch;
use App\Models\Activity;

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
                'type' => ($component->type) ? $component->type : '',
                'percentage' => ($component->percentage) ? $component->percentage : '',
                'name' => ($component->name) ? $component->name : '',
                'description' => ($component->description) ? $component->description : '',
                'palette' => ($component->palette) ? $component->palette : '',
                'order' => ($component->order) ? $component->order : '',
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
                'type' => '',
                'percentage' => '',
                'name' => '',
                'description' => '',
                'palette' => '',
                'order' => '',
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

    public function types()
    {	
        $types = array('' => 'select a type', 'childhood-education' => 'Childhood Education', 'primary-education' => 'Primary Education', 'secondary-education' => 'Secondary Education', 'higher-education' => 'Higher Education');
        return $types;
    }

    public function activities()
    {
        return $this->hasMany('App\Models\Activity', 'component_id', 'id');    
    }

    public function subject()
    {   
        return $this->belongsTo('App\Models\Subject');
    }

    public function quarter()
    {   
        return $this->belongsTo('App\Models\Quarter');
    }

    public function get_components_via_gradingsheet($id)
    {
        $components = self::with([
            'activities' => function($q) {
                $q->select(['component_id', 'id', 'activity', 'value', 'description'])->orderBy('id', 'ASC'); 
            },
        ])->where([
            'batch_id' => (new Batch)->get_current_batch(),
            'quarter_id' => (new GradingSheet)->get_column_via_identifier('quarter_id', $id),
            'subject_id' => (new GradingSheet)->get_column_via_identifier('subject_id', $id),
            'is_active' => 1
        ])->orderBy('id', 'ASC')->get();

        $components = $components->map(function($component) {
            $cell = 1; $sum = 0;
            if ($component->is_sum_cell > 0) { $cell++; }
            if ($component->is_hps_cell > 0) { $cell++; }
            if ($component->is_ps_cell > 0) { $cell++; }
            return (object) [
                'id' => $component->id,
                'batch_id' => $component->batch_id,
                'quarter_id' => $component->quarter_id,
                'subject_id' => $component->subject_id,
                'name' => $component->name,
                'palette' => $component->palette,
                'percentage' => $component->percentage,
                'is_sum_cell' => $component->is_sum_cell,
                'is_hps_cell' => $component->is_hps_cell,
                'is_ps_cell' => $component->is_ps_cell,
                'activities' => $component->activities,
                'sum_value' => (new Activity)->sum_value_via_component($component->id),
                'columns' => (new Activity)->where(['component_id' => $component->id, 'is_active' => 1])->count() + floatval($cell)
            ];
        });

        return $components;
    }
}

