<?php
//SQl Eloquent para conexión con la base de datos

namespace App\Models\TicActivos;

use Illuminate\Database\Eloquent\Model;

class PanelSoftware extends Model
 {
  public static function getSoftwares()
   {
    $sql = \DB::table('acti_software')->orderby('estado','DESC')->orderby('descripcion','ASC')->get();
    return $sql;
   }

  public static function getCantidadSoftwareActivos()
   {
    $sql = \DB::table('acti_software')->where('estado','1')->count();
    return $sql;
   }

  public static function getCantidadSoftwareInactivos()
   {
    $sql = \DB::table('acti_software')->where('estado','0')->count();
    return $sql;
   }

  public static function getSoftwareUnico($id)
   {
    $sql = \DB::table('acti_software')->where('descripcion',$id)->count();
    return $sql;
   }

  public static function insertarSoftware($datos)
   {
    $sql = \DB::table('acti_software')->insert($datos);
    return $sql;
   }

  //Consulta el ultimo registro insertado
  public static function UltimoSoftware()
   {
    $sql = \DB::table('acti_software')->select("id_software")->orderby('id_software', 'DESC')->first();
    return $sql;
   }

  public static function getSoftware($id)
   {
    $sql = \DB::table('acti_software')->where('id_software',$id)->get();
    return $sql;
   }

  public static function getSoftwareUnicoModificar($id, $id1)
   {
    $sql = \DB::table('acti_software')->where('descripcion',$id)->where('id_software', '!=', $id1)->count();
    return $sql;
   }

  public static function actualizarSoftware($id, $datos)
   {
    $sql = \DB::table('acti_software')->where('id_software', $id)->update($datos);
    return $sql;
   }

  public static function getSoftwareActivos()
   {
    $sql = \DB::table('acti_software')->where('estado', '1')->orderby('descripcion','ASC')->get();
    return $sql;
   }

  public static function Programainstalado($id, $id2)
   {
    $sql = \DB::table('acti_sofinstalado')->where('activo',$id)->where('software',$id2)->get();
    return $sql;
   }

 }