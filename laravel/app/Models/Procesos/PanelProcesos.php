<?php
//SQl Eloquent para conexión con la base de datos

namespace App\Models\Procesos;

use Illuminate\Database\Eloquent\Model;

class PanelProcesos extends Model
 {
  //Lista los procesos correspondientes al macroproceso
  public static function getProcesosMacro($id)
   {
    $sql = \DB::table('proc_procesos')->where('macroproceso', $id)->orderby('posicion','ASC')->get();
    return $sql;
   }

  //Envía la información del proceso consultado
  public static function getProceso($id)
   {
    $sql = \DB::table('proc_procesos')->where('id_proceso', $id)->get();
    return $sql;
   }

  //Envía la información de todos los procesos
  public static function getProcesos()
   {
    $sql = \DB::table('proc_procesos')->where('descripcion', 'ASC')->get();
    return $sql;
   }

  public static function actualizarProceso($id,$datos)
   {
    $sql = \DB::table('proc_procesos')->where('id_proceso', $id)->update($datos);
    return $sql;
   }

  public static function insertarProcesoLog($datos)
   {
    $sql = \DB::table('proc_procesos_log')->insert($datos);
    return $sql;
   }

  public static function getProcesoLogs($id)
   {
    $sql = \DB::table('proc_procesos_log')->where('proceso', $id)->orderby('fecha','DESC')->get();
    return $sql;
   }

   public static function getProcesosWithMacroProc()
    {
        $sql = \DB::table('proc_procesos')
        ->join('proc_macroprocesos', 'proc_procesos.macroproceso', '=', 'proc_macroprocesos.id_macroproceso')
        ->select('proc_procesos.id_proceso','proc_procesos.descripcion as proceso', 'proc_macroprocesos.descripcion as macroproceso', 'proc_macroprocesos.fondo')
        ->get();
        return $sql;
    }
    
 }
