<?php

namespace App\Imports;

use App\Models\Level;
use App\Models\Admission;
use App\Models\Component;
use App\Models\GradingSheetActivity;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithMappedCells;

class GradingSheetImport implements ToModel, WithCalculatedFormulas, WithMappedCells
{
    public function  __construct($id)
    {
        $this->id = $id; //gradingsheet id
    }
    
    public function mapping(): array
    {
        $male_students = (new Admission)->get_students_via_gradingsheet($this->id, 'Male');
        $female_students = (new Admission)->get_students_via_gradingsheet($this->id, 'Female');
        $components = (new Component)->get_components_via_gradingsheet($this->id);

        $row = 10 ;
        if (count($male_students) > 0){
            $row++;
        }
        foreach($male_students as $student)
        {
            $col = 'B';
            foreach($components as $component)
            {
                foreach($component->activities as $activity)
                {
                    $col++;
                    $score = $col.$row;
                    $data[$score] = $score;
                }
                $col = $this->increment($col, 4);
            }
            $row++;
        }
        
        if (count($female_students) > 0){
            $row++;
        }
        foreach($female_students as $student)
        {
            $col = 'B';
            foreach($components as $component)
            {
                foreach($component->activities as $activity)
                {
                    $col++;
                    $score = $col.$row;
                    $data[$score] = $score;
                }
                $col = $this->increment($col, 4);
            }
            $row++;
        }

        return $data;
    }

    public function model(array $rows)
    {
        $timestamp = date('Y-m-d H:i:s');

        $male_students = (new Admission)->get_students_via_gradingsheet($this->id, 'Male');
        $female_students = (new Admission)->get_students_via_gradingsheet($this->id, 'Female');
        $components = (new Component)->get_components_via_gradingsheet($this->id);
       
        $row = 10 ;// row
        if (count($male_students) > 0){
            $row++;
        }
        foreach($male_students as $student)
        {
            $col = 'B'; // column
            foreach($components as $component)
            {
                foreach($component->activities as $activity)
                {
                    $col++;
                    $score = $col.$row;
                    if($rows[$score] !== NULL){
                        $gradingActivtity = GradingSheetActivity::where('activity_id', '=', $activity->id)->where('student_id', '=', $student->student_id)
                        ->update([
                            'score' => $rows[$score],
                            'updated_at' => $timestamp,
                            'updated_by' => Auth::user()->id
                        ]);
                    }
                }
                $col = $this->increment($col, 4);
            }
            $row++;
        }

        if (count($female_students) > 0){
            $row++;
        }

        foreach($female_students as $student)
        {
            $col = 'B'; // column
            foreach($components as $component)
            {
                foreach($component->activities as $activity)
                {
                    $col++;
                    $score = $col.$row;
                    if($rows[$score] !== NULL){
                        $gradingActivtity = GradingSheetActivity::where('activity_id', '=', $activity->id)->where('student_id', '=', $student->student_id)
                        ->update([
                            'score' => $rows[$score],
                            'updated_at' => $timestamp,
                            'updated_by' => Auth::user()->id
                        ]);
                    }
                }
                $col = $this->increment($col, 4);
            }
            $row++;
        }
    }
   
    //Move x to 4 columns to bypass SUM, HPS, PS, Percent
    public function increment($val, $increment)
    {
        for ($i = 1; $i <= $increment; $i++) {
            $val++;
        }

        return $val;
    }
    
}
