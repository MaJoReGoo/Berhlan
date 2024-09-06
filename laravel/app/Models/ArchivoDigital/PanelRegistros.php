<?php

namespace App\Models\ArchivoDigital;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanelRegistros extends Model
{
    public static function InsertRegistros($datos)
    {
        $sql = \DB::table('arch_registros')->insertGetId($datos);
        return $sql;
    }

    public static function UpdateRegistro($id,$datos)
    {
        $sql = \DB::table('arch_registros')->where('id_registro',$id)->update($datos);
        return $sql;
    }

    public static function getRegistrosInfo()
    {
        /* SELECT titulo_unidad_documental FROM arch_registros WHERE titulo_unidad_documental IS NOT NULL; */
        $sql = \DB::table('arch_registros')
        ->select('dependencia', 'codigo_caja')
        ->whereNotNull('dependencia')
        ->whereNotNull('codigo_caja')
        ->groupby('dependencia', 'codigo_caja')
        ->get();
        return $sql;
    }
    public static function getRegistrosAsuntoInfo()
    {
        /* SELECT titulo_unidad_documental FROM arch_registros WHERE titulo_unidad_documental IS NOT NULL; */
        $sql = \DB::table('arch_registros')
        ->select('titulo_unidad_documental')
        ->whereNotNull('titulo_unidad_documental')
        ->groupby('titulo_unidad_documental')
        ->get();
        return $sql;
    }


    public static function getDepedenciasInfo()
    {
         /* select DISTINCT `dependencia` from `arch_registros` where `dependencia` is not null and `codigo_caja` is not null group by `dependencia`, `codigo_caja`   */
        $sql = \DB::table('arch_registros')
            ->select('dependencia')
            ->whereNotNull('dependencia')
            ->whereNotNull('codigo_caja')
            ->distinct()
            ->groupBy('dependencia', 'codigo_caja')
            ->get();
        return $sql;
    }


    public static function getRegistro($id){
        $sql = \DB::table('arch_registros')->where('id_registro',$id)->get();
        return $sql;
    }
}
