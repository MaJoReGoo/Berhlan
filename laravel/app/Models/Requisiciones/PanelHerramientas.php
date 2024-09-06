<?php

namespace App\Models\Requisiciones;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanelHerramientas extends Model
{
    protected $table = 'rqpe_herramientas';

    protected $primaryKey = 'id_herramienta';

    public $timestamps = true;

    protected $fillable = [
        'nombre_herramienta',
        'area_encargada',
        'estado'
    ];

}
