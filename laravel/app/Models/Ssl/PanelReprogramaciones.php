<?php

namespace App\Models\Ssl;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanelReprogramaciones extends Model
{
    use HasFactory;

    protected $table = 'rqpe_reprogramaciones';

    protected $primaryKey = 'id_reprogramacion';

    public $timestamps = true;

    protected $fillable = [
        'fecha',
        'hora',
        'fk_id_soli_examen'
    ];

}
