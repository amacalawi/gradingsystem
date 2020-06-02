<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}

