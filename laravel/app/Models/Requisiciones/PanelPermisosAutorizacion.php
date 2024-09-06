<?php

namespace App\Models\Requisiciones;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanelPermisosAutorizacion extends Model
{
    use HasFactory;

    protected $table = 'rqpe_permisos_autorizacion';

    protected $primaryKey = 'id_permisos_aut';

    public $timestamps = true;

    protected $fillable = [
        'nivel_permiso_aut',
        'fk_id_empleado',
    ];

}
