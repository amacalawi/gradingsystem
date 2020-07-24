<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradingSheetHomeroom extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'gradingsheets_homerooms';
    
    public $timestamps = false;

    public function get_component_score_via_component($id, $student, $grading)
    {
        $gradingComponent = self::where([
            'gradingsheet_id' => $grading,
            'component_id' => $id,
            'student_id' => $student,
            'is_active' => 1
        ])->get();

        $score = '';
        if ($gradingComponent->count() > 0) {
            $score = ($gradingComponent->first()->score !== NULL) ? $gradingComponent->first()->score : '';
        } 
        return $score;
    }
}

