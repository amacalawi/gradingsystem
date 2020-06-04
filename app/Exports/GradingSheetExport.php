<?php

namespace App\Exports;

use App\Models\GradingSheet;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Component;
use App\Models\Admission;
use App\Models\Quarter;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class GradingSheetExport implements FromView
{

    private $query;

    public function __construct(String $query)
    {
         $this->query = $query;
    }

    public function view(): View
    {   
        return view('modules.academics.gradingsheets.all.export', [
            'segment' => request()->segment(4),
            'grading' => (new GradingSheet)->fetch($this->query),
            'quarters' => (new Quarter)->all_quarters(),
            'sections' => (new Section)->all_sections(),
            'subjects' => (new Subject)->all_subjects(),
            'components' => (new Component)->get_components_via_gradingsheet($this->query),
            'students' => (new Admission)->get_students_via_gradingsheet($this->query),
        ]);
    }
}
