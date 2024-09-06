<?php

namespace App\Models\Requisiciones;

use Illuminate\Database\Eloquent\Model;

class PanelSoliRequiere extends Model
{
    protected $table = 'rqpe_soli_requiere';

    protected $primaryKey = 'id_soli_requiere';

    public $timestamps = true;

    protected $fillable = [
        'fk_num_solicitud',
        'fk_id_herramienta',
    ];

    public static function getElementosSoliArea($solicitud, $area)
    {
        $sql = \DB::table('rqpe_soli_requiere')
        ->join('rqpe_herramientas AS rqpe_he', 'rqpe_he.id_herramienta', '=', 'rqpe_soli_requiere.fk_id_herramienta')
        ->select('rqpe_soli_requiere.fk_id_herramienta', 'rqpe_he.nombre_herramienta', 'rqpe_he.area_encargada')
        ->where('rqpe_soli_requiere.fk_num_solicitud', $solicitud)
        ->where('rqpe_he.area_encargada', $area)
        ->get();
        return $sql;
    }

}
