<?php

namespace App\Models\Inconformidad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Trata_inconformidades extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_trata_inconformidades',
        'fecha_inconformidad',
        'descripcion_no_conformidad',
        'inconformidad',
        'detectado_persona',
        'fecha_detectada',
        'fecha_responsable',
        'area_trata',
        'tratamiento_producto',
        'descripcion_tratamiento',
        'fecha_seguimiento',
        'seg_realizado_responsable',
        'eficaz_tratamiento',
        'conclusion_final',
        'evidencia_si_aplica',
        'niveles_no_conformidad',
        'verifi_aprobado_responsable',
        'verifi_cierre_fecha',
        'verifi_accion_correctiva',
        'relacione_ac',
        'verifi_proc_responsable',
        'verifi_plan_accion',
        'verifi_plan_accion_fecha'
    ];
    protected $primaryKey = 'id_trata_inconformidades';
    protected $table = 'trata_inconformidades';

    protected $casts = [
        'id_trata_inconformidades' => 'string',
        'fecha_inconformidad' => 'date',
        'fecha_detectada' => 'date',
        'fecha_responsable' => 'date',
        'verifi_cierre_fecha'=>'date',
        'verifi_plan_accion_fecha'=>'date'
    ];

    public function trata_inconformidad_person(){
        return $this->hasMany(Trata_inconformidad_person::class, 'fk_id_trata_inconformidades', 'id_trata_inconformidades');
    }

}
