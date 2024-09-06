<?php

namespace App\Models\ArchivoDigital;

use Illuminate\Database\Eloquent\Model;

class PanelTipoDocumento extends Model
{
    public static function getTipoDocumento($id_tipodocumento)
    {
        $sql = \DB::table('arch_tipodocument')->where('id_tipodocumento', $id_tipodocumento)->get();
        return $sql;
    }
    public static function getTipoDocumentos()
    {
        $sql = \DB::table('arch_tipodocument')->get();
        return $sql;
    }
    public static function getCountTipoDocumentos()
    {
        $sql = \DB::table('arch_tipodocument')->count();
        return $sql;
    }
    public static function InsertTipoDocumento($datos)
    {
        $sql = \DB::table('arch_tipodocument')->insert($datos);
        return $sql;
    }
    public static function UpdateTipoDocumento($id,$datos)
    {
        $sql = \DB::table('arch_tipodocument')->where('id_tipodocumento',$id)->update($datos);
        return $sql;
    }

}
