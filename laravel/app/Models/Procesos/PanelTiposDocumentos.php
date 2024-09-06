<?php
//SQl Eloquent para conexión con la base de datos

namespace App\Models\Procesos;

use Illuminate\Database\Eloquent\Model;

class PanelTiposDocumentos extends Model
 {
  //Listado de tipos de documentos
  public static function getTiposDocumentos()
   {
    $sql = \DB::table('proc_tipos_documentos')->orderby('descripcion','ASC')->get();
    return $sql;
   }

  public static function getTipoUnico($id)
   {
    $sql = \DB::table('proc_tipos_documentos')->where('descripcion',$id)->count();
    return $sql;
   }

  public static function insertarTipo($datos)
   {
    $sql = \DB::table('proc_tipos_documentos')->insert($datos);
    return $sql;
   }

  public static function getTipo($id)
   {
    $sql = \DB::table('proc_tipos_documentos')->where('id_tipo',$id)->get();
    return $sql;
   }

  public static function getTipoUnicoMod($id, $id1)
   {
    $sql = \DB::table('proc_tipos_documentos')->where('id_tipo','!=',$id)->where('descripcion',$id1)->count();
    return $sql;
   }

  public static function actualizarTipo($id, $datos)
   {
    $sql = \DB::table('proc_tipos_documentos')->where('id_tipo', $id)->update($datos);
    return $sql;
   }

  public static function BorrarTipo($id)
   {
    $sql = \DB::table('proc_tipos_documentos')->where('id_tipo', $id)->delete();
    return $sql;
   }

  public static function TipoAsociado($id)
   {
    $sql = \DB::table('proc_documentos')->where('tipo', $id)->count();
    return $sql;
   }

   

 }
