<?php

namespace App\Models\Ssl;

use Illuminate\Database\Eloquent\Model;

class PanelSoliExamenes extends Model
{
    protected $table = 'rqpe_soli_examen_ocu';
    public $timestamps = true;
    protected $primaryKey = 'id_soli_examen';

    protected $fillable = [
        'consec_examen',
        'lugar',
        'fecha',
        'hora',
        'preparacion',
        'asistencia',
        'estado_examen',
        'concepto',
        'fk_num_solicitud',
    ];

    public static function getExamenes()
    {
        $sql = \DB::table('rqpe_soli_examen_ocu AS rqpe_s_ex')
            ->join('rqpe_solicitud AS rqpe_s', 'rqpe_s_ex.fk_num_solicitud', '=', 'rqpe_s.num_solicitud')
            ->join('param_cargos AS p_c', 'rqpe_s.cargo', '=', 'p_c.id_cargo')
            ->join('param_centros AS p_c_op', 'rqpe_s.centro_operacion', '=', 'p_c_op.id_centro')
            ->join('rqpe_soli_ingresos AS rqpe_s_i', 'rqpe_s_i.fk_id_soli_examen', '=', 'rqpe_s_ex.id_soli_examen')
            ->select('rqpe_s_ex.id_soli_examen', 'rqpe_s_ex.consec_examen', 'rqpe_s_ex.estado_examen','rqpe_s_ex.asistencia', 'rqpe_s_ex.fk_num_solicitud',
                'p_c.descripcion AS cargo', 'p_c_op.descripcion AS centro_operacion',
                'rqpe_s_i.nombre_soli_ingreso', 'rqpe_s_i.cedula_soli_ingreso')
            ->get();
        return $sql;
    }

    public static function getExamenesCentroOp($centro_operacion)
    {
        $sql = \DB::table('rqpe_soli_examen_ocu AS rqpe_s_ex')
            ->join('rqpe_solicitud AS rqpe_s', 'rqpe_s_ex.fk_num_solicitud', '=', 'rqpe_s.num_solicitud')
            ->join('param_cargos AS p_c', 'rqpe_s.cargo', '=', 'p_c.id_cargo')
            ->join('param_centros AS p_c_op', 'rqpe_s.centro_operacion', '=', 'p_c_op.id_centro')
            ->join('rqpe_soli_ingresos AS rqpe_s_i', 'rqpe_s_i.fk_id_soli_examen', '=', 'rqpe_s_ex.id_soli_examen')
            ->select('rqpe_s_ex.id_soli_examen', 'rqpe_s_ex.consec_examen', 'rqpe_s_ex.estado_examen','rqpe_s_ex.asistencia', 'rqpe_s_ex.fk_num_solicitud',
                'p_c.descripcion AS cargo', 'p_c_op.descripcion AS centro_operacion',
                'rqpe_s_i.nombre_soli_ingreso', 'rqpe_s_i.cedula_soli_ingreso')
            ->where('rqpe_s.centro_operacion', $centro_operacion)
            ->get();
        return $sql;
    }

    public static function getExamenDetalle($id_examen)
    {
        $sql = \DB::table('rqpe_soli_examen_ocu AS rqpe_s_e_o')
            ->join('rqpe_solicitud AS rqpe_s', 'rqpe_s.num_solicitud', '=', 'rqpe_s_e_o.fk_num_solicitud')
            ->join('rqpe_soli_ingresos AS rqpe_s_i', 'rqpe_s_i.fk_id_soli_examen', '=', 'rqpe_s_e_o.id_soli_examen')
            ->join('param_cargos AS p_c', 'p_c.id_cargo', '=', 'rqpe_s.cargo')
            ->join('param_centros AS p_centros', 'p_centros.id_centro', '=', 'rqpe_s.centro_operacion')
            ->where('rqpe_s_e_o.id_soli_examen', '=', $id_examen)
            ->select(
                'rqpe_s_e_o.id_soli_examen',
                'rqpe_s_e_o.consec_examen',
                'rqpe_s_i.nombre_soli_ingreso',
                'rqpe_s_i.cedula_soli_ingreso',
                'rqpe_s_e_o.estado_examen',
                'p_c.descripcion AS cargo',
                'p_centros.descripcion AS centro_operacion',
                'rqpe_s.responsable_proceso',
                'rqpe_s_e_o.lugar',
                'rqpe_s_e_o.fecha',
                'rqpe_s_e_o.hora',
                'rqpe_s_e_o.preparacion',
                \DB::raw("DATE_FORMAT(rqpe_s_e_o.fecha, '%d/%m/%Y') as fecha_formateada"),
                \DB::raw("DATE_FORMAT(rqpe_s_e_o.hora, '%h:%i %p') as hora_formateada"),
                'rqpe_s_e_o.asistencia',
                'rqpe_s_e_o.concepto',
                'rqpe_s_e_o.fk_num_solicitud',
                'rqpe_s.centro_operacion'
            )
            ->get();
        return $sql;
    }

    public static function getInfoExamen($id_examen)
    {
        $sql = \DB::table('rqpe_soli_examen_ocu as rqpe_s_e_o')
            ->join('rqpe_solicitud as rqpe_s', 'rqpe_s.num_solicitud', '=', 'rqpe_s_e_o.fk_num_solicitud')
            ->join('param_cargos as p_c', 'p_c.id_cargo', '=', 'rqpe_s.cargo')
            ->join('param_centros as p_cen', 'p_cen.id_centro', '=', 'rqpe_s.centro_operacion')
            ->select('rqpe_s_e_o.id_soli_examen', 'rqpe_s_e_o.consec_examen', 'p_c.descripcion as cargo', 'p_cen.descripcion as centro_operacion')
            ->where('rqpe_s_e_o.id_soli_examen', $id_examen)
            ->get();

        return $sql;
    }

}
