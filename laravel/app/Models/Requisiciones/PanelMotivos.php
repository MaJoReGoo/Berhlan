<?php

namespace App\Models\Requisiciones;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanelMotivos extends Model
{
    protected $table = 'rqpe_motivos';

    protected $primaryKey = 'id_motivo';

    public $timestamps = false;

    protected $fillable = [
        'descripcion',
        'estado'
    ];

}
