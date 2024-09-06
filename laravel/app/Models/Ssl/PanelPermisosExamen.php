<?php

namespace App\Models\Ssl;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanelPermisosExamen extends Model
{
    use HasFactory;

    protected $table = 'rqpe_permisos_exam';

    protected $primaryKey = 'id_permiso';

    public $timestamps = true;

    protected $fillable = [
        'nivel_permiso',
        'fk_id_empleado',
    ];

}
