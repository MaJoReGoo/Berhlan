<?php
//SQl Eloquent para conexión con la base de datos

namespace App\Models\TicActivos;

use Illuminate\Database\Eloquent\Model;

class PanelTipos extends Model
 {
  public static function getTipos()
   {
    $sql = \DB::table('acti_tipoactivo')->orderby('estado','DESC')->orderby('descripcion','ASC')->get();
    return $sql;
   }

  public static function getCantidadTiposActivos()
   {
    $sql = \DB::table('acti_tipoactivo')->where('estado','1')->count();
    return $sql;
   }

  public static function getCantidadTiposInactivos()
   {
    $sql = \DB::table('acti_tipoactivo')->where('estado','0')->count();
    return $sql;
   }

  public static function getTipoUnico($id)
   {
    $sql = \DB::table('acti_tipoactivo')->where('descripcion',$id)->count();
    return $sql;
   }

  public static function insertarTipo($datos)
   {
    $sql = \DB::table('acti_tipoactivo')->insert($datos);
    return $sql;
   }

  //Consulta el ultimo registro insertado
  public static function UltimoTipo()
   {
    $sql = \DB::table('acti_tipoactivo')->select("id_tipoactivo")->orderby('id_tipoactivo', 'DESC')->first();
    return $sql;
   }

  public static function getTipo($id)
   {
    $sql = \DB::table('acti_tipoactivo')->where('id_tipoactivo',$id)->get();
    return $sql;
   }

  public static function getTipoUnicoModificar($id, $id1)
   {
    $sql = \DB::table('acti_tipoactivo')->where('descripcion',$id)->where('id_tipoactivo', '!=', $id1)->count();
    return $sql;
   }

  public static function actualizarTipo($id, $datos)
   {
    $sql = \DB::table('acti_tipoactivo')->where('id_tipoactivo', $id)->update($datos);
    return $sql;
   }

  public static function getTiposActivos()
   {
    $sql = \DB::table('acti_tipoactivo')->where('estado', '1')->orderby('descripcion','ASC')->get();
    return $sql;
   }
 }