<?php

namespace App\Models\ArchivoDigital;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanelInformesArchivo extends Model
{

    public static function getInventario($dependencia)
    {
        $sql = \DB::table('arch_registros')
        ->where('dependencia',$dependencia)->get();
        return $sql;
    }

    public static function getDependencias()
    {
        $sql = \DB::table('arch_registros')->select('dependencia')
        ->groupby('dependencia')
        ->get();
        return $sql;
    }
}
