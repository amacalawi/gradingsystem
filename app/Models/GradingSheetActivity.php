<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradingSheetActivity extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'gradingsheets_activities';
    
    public $timestamps = false;

    public function get_activity_score_via_activity($id, $student, $grading)
    {
        $gradingActivity = self::where([
            'gradingsheet_id' => $grading,
            'activity_id' => $id,
            'student_id' => $student,
            'is_active' => 1
        ])->get();

        $score = '';
        if ($gradingActivity->count() > 0) {
            $score = ($gradingActivity->first()->score > 0) ? $gradingActivity->first()->score : '';
        } 
        return $score;
    }
}

