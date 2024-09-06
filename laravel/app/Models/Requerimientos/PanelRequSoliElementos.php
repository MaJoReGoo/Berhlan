<?php

namespace App\Models\Requerimientos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanelRequSoliElementos extends Model
{
    use HasFactory;

    protected $table = 'requ_soli_elementos';

    protected $primaryKey = 'id_soli_elementos';

    public $timestamps = true;

    protected $fillable = [
        'consecutivo_elementos',
        'estado_tic_soli_elementos',
        'comentario_tic_soli_elementos',
        'estado_sop_soli_elementos',
        'comentario_sop_soli_elementos',
        'fk_num_solicitud'
    ];

    public static function getSolicitudesElementosArea($Area)
    {
        $sql = \DB::table('requ_soli_elementos as requ_s_e')
            ->select([
                'requ_s_e.id_soli_elementos',
                'requ_s_e.consecutivo_elementos',
                'requ_s_e.fk_num_solicitud',
                'requ_s_e.estado_tic_soli_elementos',
                'requ_s_e.estado_sop_soli_elementos',
                'rqpe_s.fecha_aprox_ingreso',
                'p_c.descripcion as cargo',
                'p_cen.descripcion as centro_operacion',
            ])
            ->distinct()
            ->join('rqpe_soli_requiere as rqpe_s_r', 'rqpe_s_r.fk_num_solicitud', '=', 'requ_s_e.fk_num_solicitud')
            ->join('rqpe_herramientas as rqpe_h', 'rqpe_h.id_herramienta', '=', 'rqpe_s_r.fk_id_herramienta')
            ->join('rqpe_solicitud as rqpe_s', 'rqpe_s.num_solicitud', '=', 'requ_s_e.fk_num_solicitud')
            ->join('param_cargos as p_c', 'p_c.id_cargo', '=', 'rqpe_s.cargo')
            ->join('param_centros as p_cen', 'p_cen.id_centro', '=', 'rqpe_s.centro_operacion')
            ->where('rqpe_h.area_encargada', $Area)
            ->get();
        return $sql;
    }

    public static function getSolicitudesDotaciones()
    {
        $sql = \DB::table('requ_soli_elementos as requ_s_e')
            ->select([
                'requ_s_e.id_soli_elementos',
                'requ_s_e.fk_num_solicitud',
                'requ_s_e.consecutivo_elementos',
                'requ_s_e.estado_sop_soli_elementos',
                'rqpe_s.fecha_aprox_ingreso',
                'p_c.descripcion as cargo',
                'p_cen.descripcion as centro_operacion',
            ])
            ->distinct()
            ->join('rqpe_dotacion_soli as rqpe_d_s', 'rqpe_d_s.fk_num_solicitud', '=', 'requ_s_e.fk_num_solicitud')
            ->join('rqpe_solicitud as rqpe_s', 'rqpe_s.num_solicitud', '=', 'requ_s_e.fk_num_solicitud')
            ->join('param_cargos as p_c', 'p_c.id_cargo', '=', 'rqpe_s.cargo')
            ->join('param_centros as p_cen', 'p_cen.id_centro', '=', 'rqpe_s.centro_operacion')
            ->get();
        return $sql;
    }

}
