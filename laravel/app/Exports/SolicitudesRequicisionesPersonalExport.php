<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SolicitudesRequicisionesPersonalExport implements FromQuery, WithHeadings, WithStyles
{
    protected $query;
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
        $this->query = DB::table('rqpe_solicitud AS rqpe_s')
            ->leftJoin('param_empleados AS p_e', 'p_e.id_empleado', '=', 'rqpe_s.usr_solicita')
            ->leftJoin('param_cargos AS p_c', 'p_c.id_cargo', '=', 'p_e.cargo')
            ->leftJoin('param_centros AS p_cen', 'p_cen.id_centro', '=', 'rqpe_s.centro_operacion')
            ->leftJoin('param_cargos AS p_c1', 'p_c1.id_cargo', '=', 'rqpe_s.cargo')
            ->leftJoin('param_areas AS p_a', 'p_a.id_area', '=', 'p_c1.area')
            ->leftJoin('rqpe_niveles_cargos AS rqpe_n_c', 'rqpe_n_c.id_nivel_cargo', '=', 'rqpe_s.fk_nivel_cargo')
            ->leftJoin('param_empleados AS p_e1', 'p_e1.id_empleado', '=', 'rqpe_s.usr_nomina')
            ->select(
                DB::raw('MONTHNAME(rqpe_s.fecha_solicita) AS mes_de_recepcion'),
                'rqpe_s.fecha_solicita',
                'rqpe_n_c.dias_nivel_cargo AS ANS',
                DB::raw("DATE_FORMAT(rqpe_s.fecha_nomina, '%d/%m/%Y') AS fecha_aprobacion"),
                DB::raw("DATE_FORMAT(rqpe_s.fecha_finalizado_parcial, '%d/%m/%Y') AS fecha_finalizado_parcial"),
                DB::raw("DATE_FORMAT(rqpe_s.fecha_finalizacion, '%d/%m/%Y') AS fecha_finalizacion"),
                'rqpe_n_c.dias_nivel_cargo AS indicador',
                'rqpe_s.dias_aplazado',
                'rqpe_s.dias_proceso',
                'rqpe_s.dias_proceso_real',
                DB::raw("CONCAT(p_e.primer_nombre, ' ', p_e.ot_nombre, ' ', p_e.primer_apellido, ' ', p_e.ot_apellido) AS nombre_solicitante"),
                'p_c.descripcion AS cargo_solicitante',
                'p_cen.descripcion AS sede',
                'p_a.descripcion AS AREA',
                'rqpe_s.num_vacantes',
                'p_c1.descripcion AS cargo_solicitado',
                'rqpe_s.num_solicitud',
                'rqpe_n_c.nombre_nivel_cargo AS rol',
                DB::raw("SUBSTRING(rqpe_n_c.nombre_nivel_cargo, 1, 1) AS ANS_P"),
                DB::raw("CASE
                    WHEN rqpe_s.motivo = 'RP' THEN 'REEMPLAZO'
                    WHEN rqpe_s.motivo = 'CN' THEN 'CARGO NUEVO / INCREMENTO'
                    WHEN rqpe_s.motivo = 'LM' THEN 'LICENCIA MATERNIDAD'
                    WHEN rqpe_s.motivo = 'IP' THEN 'INCAPACIDAD PERMANENTE'
                    END AS tipo_solicitud"),
                'rqpe_s.reemplaza_a',
                DB::raw("CASE
                    WHEN rqpe_s.estado = 5 OR rqpe_s.estado = 3 THEN 'EN PROCESO'
                    WHEN rqpe_s.estado = 6 THEN 'CERRADO'
                    WHEN rqpe_s.estado = 9 THEN 'APLAZADO'
                    WHEN rqpe_s.estado = 7 OR rqpe_s.estado = 8 THEN 'CANCELADO'
                    WHEN rqpe_s.estado = 2 OR rqpe_s.estado = 4 THEN 'RECHAZADA'
                    WHEN rqpe_s.estado = 10 THEN 'FINALIZADO'
                    ELSE 'PENDIENTE' END AS estado"),
                'observaciones',
                DB::raw("CONCAT(p_e1.primer_nombre, ' ', p_e1.ot_nombre, ' ', p_e1.primer_apellido, ' ', p_e1.ot_apellido) AS nombre_responsable"),
                'responsable_proceso as empresa_responsable'
            )
            ->orderBy('rqpe_s.fecha_solicita', 'desc');

        if (!empty($this->filters['fecha_solicitud_inicial']) && empty($this->filters['fecha_solicitud_final'])) {
            $this->query->where('rqpe_s.fecha_solicita', '>=', $this->filters['fecha_solicitud_inicial']);
        }

        if (!empty($this->filters['fecha_solicitud_inicial']) && !empty($this->filters['fecha_solicitud_final'])) {
            $this->query->whereBetween('rqpe_s.fecha_solicita', [$this->filters['fecha_solicitud_inicial'], $this->filters['fecha_solicitud_final']]);
        }

        if (!empty($this->filters['centro_operacion'])) {
            $this->query->where('rqpe_s.centro_operacion', $this->filters['centro_operacion']);
        }

        if (!empty($this->filters['estado'])) {
            $this->query->whereIn('rqpe_s.estado', explode(',',$this->filters['estado']));
        }
    }

    public function query()
    {
        return $this->query;
    }

    public function headings(): array
    {
        // Extract the column names from the query
        $columns = (array) $this->query->first();
        return array_keys($columns);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}

