<?php

namespace App\Models\Requisiciones;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanelNovedades extends Model
{
    use HasFactory;

    protected $table = 'rqpe_novedades';

    protected $primaryKey = 'id_novedad_solicitud';

    public $timestamps = true;

    protected $fillable = [
        'fecha_novedad',
        'fk_num_solicitud',
        'fk_id_empleado',
        'descripcion_novedad'
    ];

}
