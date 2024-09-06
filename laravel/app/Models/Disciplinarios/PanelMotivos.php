<?php
//SQl Eloquent para conexión con la base de datos

namespace App\Models\Disciplinarios;

use Illuminate\Database\Eloquent\Model;

class PanelMotivos extends Model
 {
  public static function getMotivos()
   {
    $sql = \DB::table('disc_motivocierre')->orderby('estado','DESC')->orderby('descripcion','ASC')->get();
    return $sql;
   }

  public static function getCantidadMotivosActivos()
   {
    $sql = \DB::table('disc_motivocierre')->where('estado','1')->count();
    return $sql;
   }

  public static function getCantidadMotivosInactivos()
   {
    $sql = \DB::table('disc_motivocierre')->where('estado','0')->count();
    return $sql;
   }

  public static function getMotivoUnico($id)
   {
    $sql = \DB::table('disc_motivocierre')->where('descripcion',$id)->count();
    return $sql;
   }

  public static function insertarMotivo($datos)
   {
    $sql = \DB::table('disc_motivocierre')->insert($datos);
    return $sql;
   }

  public static function getMotivo($id)
   {
    $sql = \DB::table('disc_motivocierre')->where('id_motivocierre',$id)->get();
    return $sql;
   }

  public static function getMotivoUnicoModificar($id, $id1)
   {
    $sql = \DB::table('disc_motivocierre')->where('descripcion',$id)->where('id_motivocierre', '!=', $id1)->count();
    return $sql;
   }

  public static function actualizarMotivo($id, $datos)
   {
    $sql = \DB::table('disc_motivocierre')->where('id_motivocierre', $id)->update($datos);
    return $sql;
   }

  public static function MotivosActivos()
   {
    $sql = \DB::table('disc_motivocierre')->where('estado', '1')->orderby('descripcion','ASC')->get();
    return $sql;
   }
 }