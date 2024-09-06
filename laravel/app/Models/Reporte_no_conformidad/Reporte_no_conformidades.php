<?php

namespace App\Models\Reporte_no_conformidad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reporte_no_conformidades extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_reporte_conform',
        'sistema_de_gestion',
        'ciclo_auditoria',
        '$fecha_auditoria',
        'lugar',
        'fecha_elaboracion',
        'fuente_no_conforme',
        'proceso_no_conforme',
        'nombre_reporte_proceso',
        'tipo_proceso_no_conforme',
        'descripcion_no_conformidad',
        'responsable_no_conformidad',
        'impacto_no_conformidad',
        'analisis_mano_de_obra',
        'analisis_maquinaria',
        'analisis_metodo',
        'analisis_materiales',
        'analisis_medio_ambiente',
        'analisis_otros_factores',
        'prog_cierre_fecha',
        'prog_cierre_responsable',
        'cierre_real_fecha',
        'cierre_real_responsable',
        'consecutivo',
    ];

    protected $casts = [
        'id_reporte_conform' => 'string',
        'proceso_no_conforme' => 'string',
        'fecha_auditoria' => 'date',
        'fecha_elaboracion' => 'date',
        'prog_cierre_fecha' => 'date',
        'cierre_real_fecha' => 'date',
    ];
    protected $primaryKey = 'id_reporte_conform';
    protected $table = 'mc_reporte';
}
