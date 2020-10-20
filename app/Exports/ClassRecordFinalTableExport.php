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
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ClassRecordFinalTableExport implements WithTitle, FromView
{
    private $query;

    public function __construct(String $query, String $finalgrade, String $quarterid)
    {
         $this->query = $query;
         $this->finalgrade = 'Final Grade';
         $this->quarterid = $quarterid;
    }

    public function view(): View
    {   
        return view('modules.academics.gradingsheets.classrecord.exportfinal', [
            'finalgrade' => $this->finalgrade,
            'quarterid' => $this->quarterid,
            'class_records' => (new SectionInfo)->fetch($this->query),
            'quarters' => (new Quarter)->all_quarters_via_type((new SectionInfo)->fetch($this->query)->education_type_id),
        ]);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->finalgrade;
    }
}