<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromView;

class QuarterGradeLookupExport implements WithTitle, FromView
{
    private $query;

    public function __construct(String $query)
    {
         $this->query = $query;
    }

    public function view(): View
    {   
        return view('modules.academics.gradingsheets.all.lookup', [
            'title' => $this->title(),
        ]);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Quarter Grade';
    }
}