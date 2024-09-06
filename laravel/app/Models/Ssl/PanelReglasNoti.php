<?php

namespace App\Models\Ssl;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanelReglasNoti extends Model
{
    use HasFactory;

    protected $table = 'rqpe_reglas_noti';

    protected $primaryKey = 'id_regla_noti';

    public $timestamps = true;

    protected $fillable = [
        'fk_id_centro_op',
        'fk_id_empleado',
    ];

}
