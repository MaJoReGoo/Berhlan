<?php

namespace App\Models\Reporte_no_conformidad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responsables_reporte_no_conformidades extends Model
{
    use HasFactory;

    protected $fillable = [
        'responsable_no_conformidad',
        'fk_id_reporte_conform',
    ];
    protected $table = 'res_reporte_no_conform';
}
