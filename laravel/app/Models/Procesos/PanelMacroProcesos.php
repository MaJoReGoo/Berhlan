<?php
//SQl Eloquent para conexión con la base de datos

namespace App\Models\Procesos;

use Illuminate\Database\Eloquent\Model;

class PanelMacroProcesos extends Model
 {
  //Listado de empleados
  public static function getMacroProcesos()
   {
    $sql = \DB::table('proc_macroprocesos')->get();
    return $sql;
   }

  //Envía la información del macroproceso consultado
  public static function getMacroProceso($id)
   {
    $sql = \DB::table('proc_macroprocesos')->where('id_macroproceso', $id)->get();
    return $sql;
   }
 }