<?php
//SQl Eloquent para conexión con la base de datos

namespace App\Models\TicActivos;

use Illuminate\Database\Eloquent\Model;

class PanelMarcas extends Model
 {
  public static function getMarcas()
   {
    $sql = \DB::table('acti_marcas')->orderby('estado','DESC')->orderby('descripcion','ASC')->get();
    return $sql;
   }

  public static function getCantidadMarcasActivas()
   {
    $sql = \DB::table('acti_marcas')->where('estado','1')->count();
    return $sql;
   }

  public static function getCantidadMarcasInactivas()
   {
    $sql = \DB::table('acti_marcas')->where('estado','0')->count();
    return $sql;
   }

  public static function getMarcaUnica($id)
   {
    $sql = \DB::table('acti_marcas')->where('descripcion',$id)->count();
    return $sql;
   }

  public static function insertarMarca($datos)
   {
    $sql = \DB::table('acti_marcas')->insert($datos);
    return $sql;
   }

  //Consulta el ultimo registro insertado
  public static function UltimaMarca()
   {
    $sql = \DB::table('acti_marcas')->select("id_marca")->orderby('id_marca', 'DESC')->first();
    return $sql;
   }

  public static function getMarca($id)
   {
    $sql = \DB::table('acti_marcas')->where('id_marca',$id)->get();
    return $sql;
   }

  public static function getMarcaUnicaModificar($id, $id1)
   {
    $sql = \DB::table('acti_marcas')->where('descripcion',$id)->where('id_marca', '!=', $id1)->count();
    return $sql;
   }

  public static function actualizarMarca($id, $datos)
   {
    $sql = \DB::table('acti_marcas')->where('id_marca', $id)->update($datos);
    return $sql;
   }

  public static function getMarcasActivas()
   {
    $sql = \DB::table('acti_marcas')->where('estado', '1')->orderby('descripcion','ASC')->get();
    return $sql;
   }
 }