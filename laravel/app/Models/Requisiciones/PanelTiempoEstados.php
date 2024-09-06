<?php

namespace App\Models\Requisiciones;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanelTiempoEstados extends Model
{
    protected $table = 'rqpe_tiempos_estados';

    protected $primaryKey = 'id_tiempos_estados';

    public $timestamps = true;

    protected $fillable = [
        'nombre_estado',
        'fecha_retomada',
        'fecha_estado',
        'fk_num_solicitud',
    ];

}
