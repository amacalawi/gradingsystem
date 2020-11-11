<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\GradingSheet;

class GradingSheetQuarter extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'gradingsheets_quarters';
    
    public $timestamps = false;

    public function get_colum_via_gradingsheet_student($column, $grading, $student)
    {
        $gradingQuarter = self::where([
            'gradingsheet_id' => $grading,
            'student_id' => $student,
            'is_active' => 1
        ])->get();

        $value = '';

        if ($gradingQuarter->count() > 0) {
            $value = ($gradingQuarter->first()->$column !== NULL) ? $gradingQuarter->first()->$column : '';
        } 

        return $value;
    }

    public function get_column_grade($column, $type, $batch, $quarter, $section, $subject, $student, $material)
    {   
        $gradingsheetID = (new GradingSheet)
        ->where([
            'batch_id' => intval($batch), 
            'education_type_id' => $type, 
            'material_id' => $material,
            'quarter_id' => $quarter, 
            'section_info_id' => $section, 
            'subject_id' => $subject, 
            'is_active' => 1
        ])
        ->get();

        $value = '';
        if ($gradingsheetID->count() > 0) {
            $gradingQuarter = self::where([
                'gradingsheet_id' => $gradingsheetID->first()->id,
                'batch_id' => $batch,
                'quarter_id' => $quarter,
                'student_id' => $student,
                'is_active' => 1
            ])
            ->get();

            if ($gradingQuarter->count() > 0) {
                $value = ($gradingQuarter->first()->$column !== NULL) ? $gradingQuarter->first()->$column : '';
            } 

            return $value;
        } else {
            return $value;
        }
    }

    public function gradingsheet()
    {   
        return $this->belongsTo('App\Models\GradingSheet', 'gradingsheet_id', 'id');
    }
}

