<?php
//SQl Eloquent para conexión con la base de datos

namespace App\Models\Procesos;

use Illuminate\Database\Eloquent\Model;

class PanelProcesos extends Model
 {
  //Listado de empleados
  public static function getProcesosMacro($id)
   {
    $sql = \DB::table('proc_procesos')->where('macroproceso', $id)->orderby('posicion','ASC')->get();
    return $sql;
   }
 }
