<?php

namespace App\Models\Inconformidad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class McTratamiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_tratamiento',
        'fecha_diligencia_trata',
        'lugar_trata',
        'proceso_rela_trata',
        'inconfor_trata',
        'descripcion_trata',
        'detectado_persona',
        'fecha_evento_trata',
        'fecha_esti_trata',
        'caracte_no_conformidad',
        'nivel_conformidad',
        'fecha_veri_cierre',
        'veri_cierre_responsable',
        'eficaz_tratamiento',
        'conclusion_final',
        'evidencia_si_aplica'
    ];

    protected $primaryKey = 'id_tratamiento';
    protected $table = 'mc_tratamiento';

    protected $casts = [
        'id_tratamiento' => 'string',
        'fecha_diligencia_trata' => 'date',
        'fecha_evento_trata' => 'date',
        'fecha_esti_trata' => 'date'
    ];

}
