<?php

namespace App\Models\Reporte_no_conformidad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seguimiento_reporte_no_conformidades extends Model
{
    use HasFactory;

    protected $fillable = [
        'seguimiento_plan_fecha',
        'seguimiento_numero',
        'seguimiento_actividad_tarea',
        'seguimiento_compromisos',
        'seguimiento_responsable',
        'segui_plan_archivos',
        'fk_id_reporte_conform'
    ];
    protected $table = 'mc_segui_reporte';
}
