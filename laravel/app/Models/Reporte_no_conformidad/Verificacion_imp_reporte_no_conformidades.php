<?php

namespace App\Models\Reporte_no_conformidad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verificacion_imp_reporte_no_conformidades extends Model
{
    use HasFactory;

    protected $fillable = [
        'verifica_implementacion_fecha',
        'verifica_implementacion_observa',
        'verifi_imple_respon',
        'verifica_imple_archivos',
        'fk_id_reporte_conform'
    ];
    protected $table = 'mc_veri_reporte';
}
