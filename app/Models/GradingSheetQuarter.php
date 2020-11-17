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

    public function get_column_grade($column, $type, $batch, $quarter, $section, $subject, $student, $material, $is_mapeh=0, $is_tle=0)
    {   
        if ($is_mapeh > 0) {
            /* MAPEH */
            $gradingsheetID = (new GradingSheet)
            ->select('id')
            ->where([
                'batch_id' => $batch,
                'quarter_id' => $quarter,
                'section_info_id' => $section, 
                'is_active' => 1
            ])
            ->whereIn('subject_id', 
                (new SectionsSubjects)
                ->select('subject_id')
                ->where([
                    'section_info_id' => $section, 
                    'is_active' => 1
                ])
                ->whereIn('subject_id',
                    (new Subject)->select('id')->where([
                        'is_mapeh' => 1, 
                        'is_active' => 1
                    ])
                    ->get()
                )
                ->get()
            )
            ->get();

            $quarterGrade = self::where([
                'batch_id' => $batch,
                'quarter_id' => $quarter,
                'student_id' => $student,
                'is_active' => 1
            ])
            ->whereIn('gradingsheet_id', $gradingsheetID)
            ->get();

            if ($quarterGrade->count() > 0) {
                $grades = 0;
                foreach ($quarterGrade as $qgrade)
                {   
                    if ($qgrade->quarter_grade > 0) {
                        if (strtolower((new Subject)->find((new GradingSheet)->find($qgrade->gradingsheet_id)->subject_id)->code) == 'music') {
                            $grades += floatval(floatval($qgrade->quarter_grade) * floatval(.25));
                        } else {
                            $grades += floatval(floatval($qgrade->quarter_grade) * floatval(.75));
                        }
                    }
                }
                return $grades;
            } else {
                return '';
            }
        }
        else if ($is_tle > 0) {
            /* TLE */
            $gradingsheetID = (new GradingSheet)
            ->select('id')
            ->where([
                'batch_id' => $batch,
                'quarter_id' => $quarter,
                'section_info_id' => $section, 
                'is_active' => 1
            ])
            ->whereIn('subject_id', 
                (new SectionsSubjects)
                ->select('subject_id')
                ->where([
                    'section_info_id' => $section, 
                    'is_active' => 1
                ])
                ->whereIn('subject_id',
                    (new Subject)->select('id')->where([
                        'is_tle' => 1, 
                        'is_active' => 1
                    ])
                    ->get()
                )
                ->get()
            )
            ->get();

            $quarterGrade = self::where([
                'batch_id' => $batch,
                'quarter_id' => $quarter,
                'student_id' => $student,
                'is_active' => 1
            ])
            ->whereIn('gradingsheet_id', $gradingsheetID)
            ->get();

            if ($quarterGrade->count() > 0) {
                $grades = 0;
                foreach ($quarterGrade as $qgrade)
                {
                    $grades += floatval($qgrade->quarter_grade);
                }
                
                $grade = floatval(floatval($grades) / floatval($quarterGrade->count()));

                return (floor($grade * 100) / 100) ;
            } else {
                return '';
            }
        }
        else {
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
    }

    public function gradingsheet()
    {   
        return $this->belongsTo('App\Models\GradingSheet', 'gradingsheet_id', 'id');
    }
}

