<?php

namespace App\Models\Requisiciones;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class PanelDotacionesSoli extends Model
{
    protected $table = 'rqpe_dotacion_soli';

    protected $primaryKey = 'id_dotacion_soli';

    public $timestamps = true;

    protected $fillable = [
        'fk_num_solicitud',
        'fk_id_dotacion',
        'fk_id_talla_dotacion',
        'cantidad_dotacion',
        'fk_id_soli_ingreso'
    ];


    public static function getDotacionesSoli($solicitud)
    {
        $sql = \DB::table('rqpe_dotacion_soli AS rqpe_d_s')
        ->join('rqpe_dotacion AS rqpe_d', 'rqpe_d.id_dotacion', '=', 'rqpe_d_s.fk_id_dotacion')
        ->join('rqpe_talla_dotacion AS rqpe_t_d', 'rqpe_t_d.id_talla_dotacion', '=', 'rqpe_d_s.fk_id_talla_dotacion')
        ->join('rqpe_soli_ingresos AS rqpe_s_i', 'rqpe_s_i.id_soli_ingreso', '=', 'rqpe_d_s.fk_id_soli_ingreso')
        ->where('rqpe_d_s.fk_num_solicitud', $solicitud)
        ->select(
            'rqpe_d.nombre_dotacion',
            'rqpe_t_d.nombre_talla_dotacion',
            'rqpe_d_s.cantidad_dotacion',
            'rqpe_s_i.nombre_soli_ingreso'
        )
        ->get();

        return $sql;
    }



}
