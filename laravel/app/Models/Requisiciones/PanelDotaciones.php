<?php

namespace App\Models\Requisiciones;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanelDotaciones extends Model
{
    use HasFactory;

    protected $table = 'rqpe_dotacion';

    protected $primaryKey = 'id_dotacion';

    public $timestamps = true;

    protected $fillable = [
        'nombre_dotacion',
        'estado',
        'fk_id_tipo_dotacion'
    ];



}
