<?php

namespace App\Imports;

use App\Models\Subject;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithMappedCells;

class SubjectImport implements ToModel, WithCalculatedFormulas, WithMappedCells
{
    public function mapping(): array
    {
        $row = 2 ;
        $max_upload = 501;

        $timestamp = date('Y-m-d H:i:s');

        for($x=0; $x<$max_upload; $x++)
        {
            $col = 'A';
            for($y=0; $y<6; $y++){
                $score = $col.$row;
                $data[$score] = $score;
                $col++;
            }
            $row++;
        }

        return $data;
    }

    public function model(array $rows)
    {
        $row = 2 ;
        $max_upload = 501;

        $timestamp = date('Y-m-d H:i:s');

        for($x=0; $x<$max_upload; $x++)
        {
            $col = 'A';
            $checkexist = $this->check_rowdata($row, $rows);
            $score = $col.$row;
            
            if($checkexist){
                $subject = Subject::create([
                    'code' => $rows[$col++.$row],
                    'name' => $rows[$col++.$row],
                    'description' => $rows[$col++.$row],
                    'type' => $rows[$col++.$row],
                    'is_mapeh' => $rows[$col++.$row],
                    'is_tle' => $rows[$col++.$row],
                    'created_at' => $timestamp,
                    'created_by' => Auth::user()->id
                ]);
            }
            $row++;
        }
    }

    //check if row has at least 1 data
    public function check_rowdata($row, $rows)
    {
        $col = 'A';
        $max_col = 6;
        $data_count = 0;
        
        for($y=0; $y<$max_col; $y++)
        {
            $score = $col.$row;
            if(!empty($rows[$score]))
            {
                $data_count++;
            }
            $col++;
        }

        if($data_count > 0){
            return true;
        }else{
            return false;
        }
    }

}
