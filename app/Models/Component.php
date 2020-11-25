<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\GradingSheet;
use App\Models\Batch;
use App\Models\Activity;
use App\Models\Quarter;
use App\Models\Component;
use App\Models\QuarterEducationType;

class Component extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'components';
    
    public $timestamps = false;

    public function fetch($id)
    {
        $component = self::with([
            'quarters' =>  function($q) { 
                $q->select(['components_quarters.id', 'components_quarters.component_id', 'components_quarters.quarter_id', 'quarters.name'])->join('quarters', function($join)
                {
                    $join->on('quarters.id', '=', 'components_quarters.quarter_id');
                });
            },
            'subjects' =>  function($q) { 
                $q->select(['components_subjects.id', 'components_subjects.component_id', 'components_subjects.subject_id', 'subjects.name'])->join('subjects', function($join)
                {
                    $join->on('subjects.id', '=', 'components_subjects.subject_id');
                });
            },
        ])
        ->where('id', $id)->get();

        if ($component->count() > 0) {
            $component = $component->first();
            $results = array(
                'id' => ($component->id) ? $component->id : '',
                'batch_id' => ($component->batch_id) ? $component->batch_id : '',
                'quarters' =>  ($component->id) ? $component->quarters->map(function($a) { return $a->quarter_id; }) : '',
                'section_info_id' => ($component->section_info_id) ? $component->section_info_id : '',
                'subject_id' => ($component->id) ? $component->subjects->map(function($a) { return $a->subject_id; }) : '',
                'education_type_id' => ($component->education_type_id) ? $component->education_type_id : '',
                'material_id' => ($component->material_id) ? $component->material_id : '',
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
                'quarters' => '',
                'section_info_id' => '',
                'subject_id' => '',
                'education_type_id' => '',
                'material_id' => '',
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

    public function quarters()
    {
        return $this->hasMany('App\Models\ComponentQuarter', 'component_id', 'id')->where('components_quarters.is_active', 1);
    }

    public function subjects()
    {
        return $this->hasMany('App\Models\ComponentSubject', 'component_id', 'id')->where('components_subjects.is_active', 1);
    }

    public function activities()
    {
        return $this->hasMany('App\Models\Activity', 'component_id', 'id');    
    }

    public function section_info()
    {
        return $this->belongsTo('App\Models\SectionInfo');
    }

    public function subject()
    {   
        return $this->belongsTo('App\Models\Subject');
    }

    public function edtype()
    {
        return $this->belongsTo('App\Models\EducationType', 'education_type_id', 'id');
    }

    public function get_components_via_gradingsheet($id)
    {   
        $quarter = (new GradingSheet)->get_column_via_identifier('quarter_id', $id);
        $subject = (new GradingSheet)->get_column_via_identifier('subject_id', $id);
        $components = self::with([
            'activities' => function($q) use ($id, $quarter, $subject) {
                $q->select(['component_id', 'id', 'activity', 'value', 'description'])
                ->where([
                    'quarter_id' => $quarter,
                    'subject_id' => $subject,
                    'is_active' => 1
                ])
                ->orderBy('id', 'ASC'); 
            },
        ])->where([
            'batch_id' => (new Batch)->get_current_batch(),
            'education_type_id' => (new GradingSheet)->get_column_via_identifier('education_type_id', $id),
            'is_active' => 1
        ])
        ->whereIn('id', 
            (new ComponentSubject)->select('component_id')
            ->where([
                'batch_id' => (new Batch)->get_current_batch(),
                'subject_id' => $subject,
                'is_active' => 1
            ])
        )
        ->whereIn('id', 
            (new ComponentQuarter)->select('component_id')
            ->where([
                'batch_id' => (new Batch)->get_current_batch(),
                'quarter_id' => $quarter,
                'is_active' => 1
            ])
        )
        ->orderBy('id', 'ASC')->get();

        $components = $components->map(function($component) use ($quarter, $subject) {
            $cell = 1; $sum = 0;
            if ($component->is_sum_cell > 0) { $cell++; }
            if ($component->is_hps_cell > 0) { $cell++; }
            if ($component->is_ps_cell > 0) { $cell++; }
            return (object) [
                'id' => $component->id,
                'batch_id' => $component->batch_id,
                'subject_id' => $component->subject_id,
                'name' => $component->name,
                'description' => $component->description,
                'palette' => $component->palette,
                'percentage' => $component->percentage,
                'is_sum_cell' => $component->is_sum_cell,
                'is_hps_cell' => $component->is_hps_cell,
                'is_ps_cell' => $component->is_ps_cell,
                'activities' => $component->activities,
                'sum_value' => (new Activity)->sum_value_via_component($component->id, $quarter, $subject),
                'columns' => (new Activity)->where(['component_id' => $component->id, 'quarter_id' => $quarter, 'subject_id' => $subject, 'is_active' => 1])->count() + floatval($cell)
            ];
        });

        return $components;
    }

    public function all_quarters($componentID)
    {	
        $quarters = Quarter::
        whereIn('id', (new QuarterEducationType)->select('quarter_id')
            ->where([
                'education_type_id' => (new Component)->where('id', $componentID)->pluck('education_type_id'),
                'is_active' => 1
            ])
        )
        ->where([
            'is_active' => 1,
            // 'education_type_id' => (new Component)->where('id', $componentID)->pluck('education_type_id')
        ])
        ->orderBy('id', 'asc')->get();

        $quarterx = array();
        foreach ($quarters as $quarter) {
            $quarterx[] = array(
                $quarter->id => $quarter->name
            );
        }

        $quarters = array();
        foreach($quarterx as $quarter) {
            foreach($quarter as $key => $val) {
                $quarters[$key] = $val;
            }
        }

        return $quarters;
    }
}

