<?php

namespace App\Exports;

use App\Models\SectionInfo;
use App\Models\Staff;
use App\Models\Batch;
use App\Models\Admission;
use App\Models\Quarter;
use App\Models\Subject;
use App\Models\SectionsSubjects;
use App\Models\GradingSheet;
use App\Models\GradingSheetQuarter;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ClassRecordExport implements FromView, WithMultipleSheets
{
    private $query;

    public function __construct(String $query)
    {
         $this->query = $query;
    }

    public function view(): View
    {   
        return view('modules.academics.gradingsheets.classrecord.export', [
            'class_records' => (new SectionInfo)->fetch($this->query),
            'quarters' => (new Quarter)->all_quarters_via_type((new SectionInfo)->fetch($this->query)->education_type_id),
        ]);
    }
 
    public function sheets(): array
    {
        $sheets = [];

        $quarters = (new Quarter)->all_quarters_via_type((new SectionInfo)->fetch($this->query)->education_type_id);
        foreach($quarters as $quarter)
        {
            $sheets[] = new ClassRecordTableExport($this->query, $quarter->name, $quarter->id);
        }            
        $sheets[] = new ClassRecordFinalTableExport($this->query, $quarter->name, $quarter->id);

        return $sheets;
    }
}
