<?php

namespace App\Models\Requisiciones;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanelNivelesCargos extends Model
{
    use HasFactory;

    protected $table = 'rqpe_niveles_cargos';

    protected $primaryKey = 'id_nivel_cargo';

    public $timestamps = true;

    protected $fillable = [
        'nombre_nivel_cargo',
        'dias_nivel_cargo',
        'estado_nivel_cargo'
    ];

}
