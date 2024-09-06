<?php

namespace App\Models\Inconformidad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class McTratamientoPerson extends Model
{
    use HasFactory;
    protected $fillable =
    [
        'responsable_trata',
        'fk_id_trata'
    ];
    protected $primaryKey = 'id';
    protected $table = 'mc_trata_person';
}
