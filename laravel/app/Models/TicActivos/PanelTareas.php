<?php
//SQl Eloquent para conexión con la base de datos

namespace App\Models\TicActivos;

use Illuminate\Database\Eloquent\Model;

class PanelTareas extends Model
 {
  public static function getTareas()
   {
    $sql = \DB::table('acti_tareas')->orderby('estado','DESC')->orderby('descripcion','ASC')->get();
    return $sql;
   }

  public static function getCantidadTareasActivas()
   {
    $sql = \DB::table('acti_tareas')->where('estado','1')->count();
    return $sql;
   }

  public static function getCantidadTareasInactivas()
   {
    $sql = \DB::table('acti_tareas')->where('estado','0')->count();
    return $sql;
   }

  public static function getTareaUnica($id)
   {
    $sql = \DB::table('acti_tareas')->where('descripcion',$id)->count();
    return $sql;
   }

  public static function insertarTarea($datos)
   {
    $sql = \DB::table('acti_tareas')->insert($datos);
    return $sql;
   }

  //Consulta el ultimo registro insertado
  public static function UltimaTarea()
   {
    $sql = \DB::table('acti_tareas')->select("id_tarea")->orderby('id_tarea', 'DESC')->first();
    return $sql;
   }

  public static function getTarea($id)
   {
    $sql = \DB::table('acti_tareas')->where('id_tarea',$id)->get();
    return $sql;
   }

  public static function getTareaUnicaModificar($id, $id1)
   {
    $sql = \DB::table('acti_tareas')->where('descripcion',$id)->where('id_tarea', '!=', $id1)->count();
    return $sql;
   }

  public static function actualizarTarea($id, $datos)
   {
    $sql = \DB::table('acti_tareas')->where('id_tarea', $id)->update($datos);
    return $sql;
   }

  public static function getTareasActivas()
   {
    $sql = \DB::table('acti_tareas')->where('estado', '1')->orderby('descripcion','ASC')->get();
    return $sql;
   }
 }