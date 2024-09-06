<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReporteExport implements FromView
{
    protected $reportes;

    public function __construct($reportes)
    {
        $this->reportes = $reportes;
    }

    public function view(): View
    {
        return view('export.reporteExport', [
            'reportes' => $this->reportes,
        ]);
    }
}

