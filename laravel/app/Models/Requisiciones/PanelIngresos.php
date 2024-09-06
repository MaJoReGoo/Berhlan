<?php

namespace App\Models\Requisiciones;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanelIngresos extends Model
{
    use HasFactory;

    protected $table = 'rqpe_soli_ingresos';

    protected $primaryKey = 'id_soli_ingreso';

    public $timestamps = true;

    protected $fillable = [
        'consecutivo',
        'nombre_soli_ingreso',
        'genero_soli_ingreso',
        'cedula_soli_ingreso',
        'correo_soli_ingreso',
        'telefono_soli_ingreso',
        'estado_soli_ingreso',
        'estado_diligencia_ingreso',
        'fk_num_solicitud',
        'fk_id_soli_examen',
        'fecha_induccion',
        'fecha_inicio_laboral',
    ];

    public static function obtenerExamenesIngresos()
    {
        $sql = \DB::table('rqpe_soli_ingresos as rqpe_s_i')
            ->join('rqpe_soli_examen_ocu as rqpe_s_e_o', 'rqpe_s_e_o.id_soli_examen', '=', 'rqpe_s_i.fk_id_soli_examen')
            ->select(
                'rqpe_s_i.consecutivo',
                'rqpe_s_i.cedula_soli_ingreso',
                'rqpe_s_i.nombre_soli_ingreso',
                \DB::raw('COALESCE(rqpe_s_e_o.lugar, "pendiente por diligenciar") as lugar'),
                'rqpe_s_e_o.fecha',
                \DB::raw('COALESCE(DATE_FORMAT(rqpe_s_e_o.hora, "%h:%i %p"), "pendiente por diligenciar") as hora'),
                'rqpe_s_e_o.asistencia',
                'rqpe_s_e_o.estado_examen',
                'rqpe_s_e_o.concepto'
            )
            ->get();

        return $sql;
    }

}
