<?php
//SQl Eloquent para conexión con la base de datos

namespace App\Models\Procesos;

use Illuminate\Database\Eloquent\Model;

class PanelSubProcesos extends Model
 {
  //Lista los subprocesos correspondientes al proceso
  public static function getSubProcesos($id)
   {
    $sql = \DB::table('proc_subprocesos')->where('proceso', $id)->orderby('numero','ASC')->get();
    return $sql;
   }

  //Para validación de subproceso con el proceso como parámetro
  public static function getSubProcesoUnico($id, $id1)
   {
    $sql = \DB::table('proc_subprocesos')->where('proceso',$id)->where('descripcion',$id1)->count();
    return $sql;
   }

  //Ingresa un nuevo subproceso
  public static function insertarSubProceso($datos)
   {
    $sql = \DB::table('proc_subprocesos')->insert($datos);
    return $sql;
   }

  //Retorna la información del subproceso
  public static function getSubProceso($id)
   {
    $sql = \DB::table('proc_subprocesos')->where('id_subproceso', $id)->get();
    return $sql;
   }

  //Para validación de subproceso con el proceso como parámetro
  public static function getSubProcesoUnicoMod($id, $id1)
   {
    $sql = \DB::table('proc_subprocesos')->where('id_subproceso','!=',$id)->where('descripcion',$id1)->count();
    return $sql;
   }

  //Actualizo la información del subproceso
  public static function actualizarSubProceso($id, $datos)
   {
    $sql = \DB::table('proc_subprocesos')->where('id_subproceso', $id)->update($datos);
    return $sql;
   }

  public static function BorrarSubProceso($id)
   {
    $sql = \DB::table('proc_subprocesos')->where('id_subproceso', $id)->delete();
    return $sql;
   }

  //Lista todos los subprocesos
  public static function getSubProcesosT()
   {
    $sql = \DB::table('proc_subprocesos')->orderby('numero','ASC')->get();
    return $sql;
   }

   public static function getSubProcesosWithProcAndMacroProc()
   {
    $sql = \DB::table('proc_subprocesos')
    ->join('proc_procesos', 'proc_procesos.id_proceso', '=', 'proc_subprocesos.proceso')
    ->join('proc_macroprocesos', 'proc_macroprocesos.id_macroproceso', '=', 'proc_procesos.macroproceso')
    ->select('proc_subprocesos.id_subproceso','proc_subprocesos.descripcion as subproceso', 'proc_procesos.descripcion as proceso', 'proc_macroprocesos.descripcion as macroproceso', 'proc_macroprocesos.fondo')
    ->get();
    return $sql;
   }


 }
