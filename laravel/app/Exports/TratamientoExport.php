<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TratamientoExport implements FromView
{
    protected $tratamientos;

    public function __construct($tratamientos)
    {
        $this->tratamientos = $tratamientos;
    }

    public function view(): View
    {
        return view('export.tratamientoExport', [
            'tratamientos' => $this->tratamientos,
        ]);
    }
}

