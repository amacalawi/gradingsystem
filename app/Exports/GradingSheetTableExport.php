<?php

namespace App\Exports;

use App\Models\GradingSheet;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Component;
use App\Models\Admission;
use App\Models\Quarter;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class GradingSheetTableExport implements WithTitle, FromView, WithStyles, WithColumnWidths, WithDrawings
{
    private $query;

    public function __construct(String $query)
    {
         $this->query = $query;
    }

    public function view(): View
    {   
        return view('modules.academics.gradingsheets.all.export', [
            'title' => $this->title(),
            'segment' => request()->segment(4),
            'grading' => (new GradingSheet)->fetch($this->query),
            'quarters' => (new Quarter)->all_quarters(),
            'sections' => (new Section)->all_sections(),
            'subjects' => (new Subject)->all_subjects(),
            'components' => (new Component)->get_components_via_gradingsheet($this->query),
            'male_students' => (new Admission)->get_students_via_gradingsheet($this->query, 'Male'),
            'female_students' => (new Admission)->get_students_via_gradingsheet($this->query, 'Female')
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Styling an entire column.
            1 => ['font' => ['size' => 21, 'name' => 'Arial'], 'vertical-align' => 'middle'],
            3 => ['font' => ['size' =>  7, 'name' => 'Arial Narrow', 'italic' => true]],
            4 => ['font' => ['size' => 14, 'name' => 'Arial']],
            5 => ['font' => ['size' => 14, 'name' => 'Arial']],
            7 => ['font' => ['size' => 11, 'name' => 'Arial'], 'vertical-align' => 'middle'],
            8 => ['font' => ['size' => 14, 'name' => 'Arial', 'bold' => true], 'vertical-align' => 'middle'],
            9 => ['allborders' => ['style' => 'PHPExcel_Style_Border::BORDER_THICK'] ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'F' => 4, 'G' => 4, 'H' => 4, 'I' => 4, 'J' => 4, 'K' => 4, 'L' => 4, 'M' => 4, 'N' => 4, 'O' => 4, 
            'P' => 6, 'Q' => 6, 'R' => 6, 'S' => 6, 
            'T' => 4, 'U' => 4, 'V' => 4, 'W' => 4, 'X' => 4, 'Y' => 4, 'Z' => 4, 'AA' => 4, 'AB' => 4, 'AC' => 4, 
            'AD' => 6, 'AE' => 6, 'AF' => 6, 'AG' => 6, 
            'AH' => 13, 'AI' => 10, 'AJ' => 10, 'AK' => 13, 'AL' => 13
        ];
    }

    public function drawings()
    {
        if( file_exists(storage_path('app/public/uploads/depedlogo.png')) && file_exists(storage_path('app/public/uploads/deped.jpg')) ){

            $logo_left = new Drawing();
            $logo_left->setName('SchoolPicture1');
            $logo_left->setDescription('SchoolDescription1');
            $logo_left->setPath( storage_path('app/public/uploads/depedlogo.png') );
            $logo_left->setHeight(100);
            $logo_left->setCoordinates('A1');

            $logo_right = new Drawing();
            $logo_right->setName('SchoolPicture2');
            $logo_right->setDescription('SchoolDescription2');
            $logo_right->setPath( storage_path('app/public/uploads/deped.jpg') );
            $logo_right->setHeight(80);
            $logo_right->setCoordinates('AG1');

            return [$logo_left, $logo_right];
        }
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'GradingSheet';
    }
}