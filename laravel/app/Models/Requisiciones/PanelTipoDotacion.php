<?php

namespace App\Models\Requisiciones;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanelTipoDotacion extends Model
{
    protected $table = 'rqpe_tipo_dotacion';

    protected $primaryKey = 'id_tipo_dotacion';

    public $timestamps = true;

    protected $fillable = [
        'nombre_tipo_dotacion'
    ];

}
