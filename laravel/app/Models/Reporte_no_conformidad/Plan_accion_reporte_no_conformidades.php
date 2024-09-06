<?php

namespace App\Models\Reporte_no_conformidad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan_accion_reporte_no_conformidades extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_accion_numero',
        'plan_accion_actividad',
        'plan_accion_responsable',
        'plan_accion_fecha_tarea',
        'fk_id_reporte_conform',
    ];
    protected $table = 'mc_plan_reporte';

}
