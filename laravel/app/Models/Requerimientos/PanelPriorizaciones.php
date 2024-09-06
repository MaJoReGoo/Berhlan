<?php
//SQl Eloquent para conexión con la base de datos

namespace App\Models\Requerimientos;

use Illuminate\Database\Eloquent\Model;

class PanelPriorizaciones extends Model
 {
  public static function getCriterios()
   {
    $sql = \DB::table('requ_criticidad')->orderby('id_criterio','ASC')->get();
    return $sql;
   }

  public static function getTiempo($grupo, $criticidad)
   {
    $sql = \DB::table('requ_priorizacion')->where('grupo',$grupo)->where('criticidad',$criticidad)->get();
    return $sql;
   }

  public static function actualizarPriorizacion($grupo, $criterio, $datos)
   {
    $sql = \DB::table('requ_priorizacion')->where('grupo',$grupo)->where('criticidad',$criterio)->update($datos);
    return $sql;
   }

  public static function getCriterio($id)
   {
    $sql = \DB::table('requ_criticidad')->where('id_criterio',$id)->get();
    return $sql;
   }
   public static function CriteriosIniciales()
   {
    $sql = \DB::table('requ_criticidad')->where('id_criterio', '<=', 4)->orderby('id_criterio','ASC')->get();
    return $sql;
   }
 }