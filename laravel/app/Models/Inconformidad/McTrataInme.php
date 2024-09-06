<?php

namespace App\Models\Inconformidad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class McTrataInme extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'tratamiento',
        'descripcion_inme_trata',
        'persona_trata',
        'fk_id_trata'
    ];
    protected $primaryKey = 'id';
    protected $table = 'mc_trata_inme';

}
