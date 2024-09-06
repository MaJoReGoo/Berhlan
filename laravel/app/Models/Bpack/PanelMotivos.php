<?php
//SQl Eloquent para conexión con la base de datos

namespace App\Models\Bpack;

use Illuminate\Database\Eloquent\Model;

class PanelMotivos extends Model
 {
  public static function getMotivos()
   {
    $sql = \DB::table('bpac_motivos')->orderby('estado','DESC')->orderby('descripcion','ASC')->get();
    return $sql;
   }

  public static function getCantidadMotivosActivos()
   {
    $sql = \DB::table('bpac_motivos')->where('estado','1')->count();
    return $sql;
   }

  public static function getCantidadMotivosInactivos()
   {
    $sql = \DB::table('bpac_motivos')->where('estado','0')->count();
    return $sql;
   }

  public static function getMotivoUnico($id)
   {
    $sql = \DB::table('bpac_motivos')->where('descripcion',$id)->count();
    return $sql;
   }

  public static function insertarMotivo($datos)
   {
    $sql = \DB::table('bpac_motivos')->insert($datos);
    return $sql;
   }

  public static function getMotivo($id)
   {
    $sql = \DB::table('bpac_motivos')->where('id_motivo',$id)->get();
    return $sql;
   }

  public static function getMotivoUnicoModificar($id, $id1)
   {
    $sql = \DB::table('bpac_motivos')->where('descripcion',$id)->where('id_motivo', '!=', $id1)->count();
    return $sql;
   }

  public static function actualizarMotivo($id, $datos)
   {
    $sql = \DB::table('bpac_motivos')->where('id_motivo', $id)->update($datos);
    return $sql;
   }

  public static function getMotivosActivos()
   {
    $sql = \DB::table('bpac_motivos')->where('estado', '1')->orderby('descripcion','ASC')->get();
    return $sql;
   }

  //Consulta el ultimo registro insertado
  public static function UltimoMotivo()
   {
    $sql = \DB::table('bpac_motivos')->select("id_motivo")->orderby('id_motivo', 'DESC')->first();
    return $sql;
   }
 }