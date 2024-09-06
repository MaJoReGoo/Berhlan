<?php

namespace App\Models\Reporte_no_conformidad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Correctivos_reporte_no_conformidades extends Model
{
    use HasFactory;

    protected $fillable = [
        'correctivo_descrip',
        'correctivo_control',
        'correctivo_fecha',
        'correctivo_responsable',
        'fk_id_reporte_conform',
    ];
    protected $table = 'correc_reporte_no_conform';

}
