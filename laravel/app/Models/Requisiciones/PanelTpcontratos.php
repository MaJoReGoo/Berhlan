<?php

namespace App\Models\Requisiciones;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanelTpcontratos extends Model
{
    protected $table = 'rqpe_tpcontratos';

    protected $primaryKey = 'id_tpcontrato';

    public $timestamps = false;

    protected $fillable = [
        'descripcion',
        'estado'
    ];

}
