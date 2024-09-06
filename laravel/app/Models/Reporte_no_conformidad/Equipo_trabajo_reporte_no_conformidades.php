<?php

namespace App\Models\Reporte_no_conformidad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo_trabajo_reporte_no_conformidades extends Model
{
    use HasFactory;

    protected $fillable = [
        'persona_equipo_trabajo',
        'fk_id_reporte_conform',
    ];
    protected $table = 'mc_equipo_reporte';
}
