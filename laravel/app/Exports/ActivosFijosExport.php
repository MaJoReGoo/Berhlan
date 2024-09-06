<?php

namespace App\Exports;

use App\Models\PanelActivosFijo;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Facades\DB;

class ActivosFijosExport implements FromView, ShouldAutoSize
{
    public function view(): View
    {
        $sql = DB::table('acti2_activo AS act2')
        ->select(DB::raw("CONCAT(pe.primer_nombre,' ',pe.ot_nombre,' ',pe.primer_apellido,' ',pe.ot_apellido) AS nombre"),
        'pe.identificacion','pee.nombre AS empresa', 'ata.descripcion','act2.cod_interno', 'act2.activo_fijo','act2.color', 'act2.observaciones')
        ->JOIN( 'acti_tipoactivo AS ata' ,'act2.tipo','=','ata.id_tipoactivo')
        ->JOIN( 'param_empleados AS pe', 'act2.empleado','=','pe.id_empleado')
        ->JOIN( 'param_empresas AS pee', 'act2.empresa','=','pee.id_empresa')
        ->groupby('act2.cod_interno')
        ->get();


        return view('activos-fijos.archivos.formato-tabla', [
            'activos' => $sql
        ]);
    }
}
