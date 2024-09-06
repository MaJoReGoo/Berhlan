<?php

namespace App\Models\Requisiciones;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanelTallaDotacion extends Model
{
    protected $table = 'rqpe_talla_dotacion';

    protected $primaryKey = 'id_talla_dotacion';

    public $timestamps = true;

    protected $fillable = [
        'nombre_talla_dotacion',
        'fk_id_tipo_dotacion',
        'estado_talla_dotacion'
    ];

}
