<?php

namespace App\Imports;

use App\Models\Level;
use App\Models\EducationType;
use App\Models\Admission;
use App\Models\Section;
use App\Models\SectionInfo;
use App\Models\Batch;
use App\Models\Staff;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithMappedCells;

class ClassImport implements ToModel, WithCalculatedFormulas, WithMappedCells
{
    public function mapping(): array
    {
        $row = 2 ;
        $max_upload = 501;

        $timestamp = date('Y-m-d H:i:s');

        for($x=0; $x<$max_upload; $x++)
        {
            $col = 'A';
            for($y=0; $y<4; $y++){
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
            
            if($checkexist)
            {
                $educationtype = $this->check_type( $rows['A'.$row] ); //type coloumn
                if($educationtype['id'])
                {
                    $section_id = $this->check_section( $rows['B'.$row], $educationtype['id'] );
                    $level_id   = $this->check_level( $rows['C'.$row], $educationtype['id'] );
                    $adviser_id = $this->check_adviser( $rows['D'.$row] );

                    if($section_id && $level_id && $adviser_id)
                    {
                        $batch_id = Batch::where('is_active','1')->where('status','Current')->pluck('id');
                        $classcode = $this->generate_classcode($educationtype['code'] , $section_id, $batch_id[0]);
                        $timestamp = date('Y-m-d H:i:s');
                        
                        $sectioninfo = SectionInfo::create([
                            'batch_id' => $batch_id[0],
                            'section_id' => $section_id,
                            'adviser_id' => $adviser_id,
                            'level_id' => $level_id,
                            'education_type_id' => $educationtype['id'],
                            'classcode' => $classcode,
                            'created_at' => $timestamp,
                            'created_by' => Auth::user()->id
                        ]);
                    }
                }
            }
            $row++;
        }
    }

    //check if row has at least 1 data
    public function check_rowdata($row, $rows)
    {
        $col = 'A';
        $max_col = 4;
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

    public function check_type($typecoloumn)
    {
        $educationtypes = EducationType::select('id', 'code')->where('code', $typecoloumn)->where('is_active', 1)->get();
        $education_id = 0;
        foreach($educationtypes as $educationtype){
            if($educationtype->id){
                $education_id = array( 
                    'id' => $educationtype->id,
                    'code' => $educationtype->code,
                );
            }
        }
        return $education_id;
    }

    public function check_section($section_code, $educationtype_id)
    {
        $section_ids = Section::select('id')->where('code', $section_code)->where('education_type_id', $educationtype_id)->where('is_active', 1)->get();
        $sec_id = 0;
        foreach($section_ids as $section_id){
            if($section_id->id){
                $sec_id = $section_id->id;
            }
        }
        return $sec_id;
    }

    public function check_level($level_code, $educationtype_id)
    {
        $level_ids = Level::select('id')->where('code', $level_code)->where('education_type_id', $educationtype_id)->where('is_active', 1)->get();
        $lvl_id = 0;
        foreach($level_ids as $level_id){
            if($level_id->id){
                $lvl_id = $level_id->id;
            }
        }
        return $lvl_id;
    }

    public function check_adviser($id_no)
    {
        $adviser_ids = Staff::select('id')->where('identification_no', $id_no)->where('type', 'Adviser')->where('is_active', 1)->get();
        $adv_id = 0;
        foreach($adviser_ids as $adviser_id){
            if($adviser_id->id){
                $adv_id = $adviser_id->id;
            }
        }
        return $adv_id;
    }

    public function generate_classcode($type, $section_id, $batch_id)
    {
        //Type
        $tc = '';
        $type_code = explode('-', $type);
        foreach ($type_code as $ty_code) {
            $tc .= strtoupper($ty_code[0]);
        }

        //section
        $section_code = Section::where('id', $section_id)->pluck('name');
        $sc = strtoupper(substr($section_code[0], 0, 2));

        //batch
        $batch_code = Batch::where('id', $batch_id)->where('status', 'Current')->pluck('date_start');
        $bt_code = explode('-', $batch_code[0]);
        foreach ($bt_code as $btcode)
        {
            if( strlen($btcode) == 4){ //Year
                $bc = substr($btcode, 2, 2);
            }
        }

        //section id
        $sidc = sprintf("%02d", $section_id);

        //combine
        $classcode = $tc.$sc.'-'.$bc.$sidc;

        return $classcode;
    }
}
