<?php

namespace App\Models\Inconformidad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trata_inconformidad_person extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['responsable_tratamiento','fk_id_trata_inconformidades'];
    protected $primaryKey = 'id_trata_respon';
    protected $table = 'trata_inconformidad_persons';


    public function trata_inconformidad(){
        return $this->belongsTo(Trata_inconformidades::class, 'fk_id_trata_inconformidades', 'id_trata_inconformidades');
    }

}
