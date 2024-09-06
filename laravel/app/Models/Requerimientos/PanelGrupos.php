<?php
//SQl Eloquent para conexión con la base de datos

namespace App\Models\Requerimientos;

use Illuminate\Database\Eloquent\Model;

class PanelGrupos extends Model
 {
  //Listado los grupos que atenderán requerimientos
  public static function getGrupos()
   {
    $sql = \DB::table('requ_grupos')->orderby('estado','DESC')->orderby('descripcion','ASC')->get();
    return $sql;
   }

  public static function getGrupoUnico($id)
   {
    $sql = \DB::table('requ_grupos')->where('descripcion',$id)->count();
    return $sql;
   }

  public static function insertarGrupo($datos)
   {
    $sql = \DB::table('requ_grupos')->insert($datos);
    return $sql;
   }

  public static function getGrupo($id)
   {
    $sql = \DB::table('requ_grupos')->where('id_grupo',$id)->get();
    return $sql;
   }

  public static function getGrupoUnicoMod($grupo, $des)
   {
    $sql = \DB::table('requ_grupos')->where('id_grupo','!=',$grupo)->where('descripcion',$des)->count();
    return $sql;
   }

  public static function actualizarGrupo($id, $datos)
   {
    $sql = \DB::table('requ_grupos')->where('id_grupo', $id)->update($datos);
    return $sql;
   }

  public static function getGrupoEmpleados($grupo)
   {
    $sql = \DB::table('param_empleados')->whereIn('id_empleado',
    function($query) use ($grupo)
     {
      $query->select('empleado')->from('requ_grupos_emp')->where('grupo', $grupo);
     }
    )->orderby('primer_nombre','ASC')->orderby('ot_nombre','ASC')->orderby('primer_apellido','ASC')->orderby('ot_apellido','ASC')->get();
    return $sql;
   }

  public static function getEmpleadoUnico($grupo, $empleado)
   {
    $sql = \DB::table('requ_grupos_emp')->where('grupo',$grupo)->where('empleado',$empleado)->count();
    return $sql;
   }

  public static function insertarEmpleadoGrupo($datos)
   {
    $sql = \DB::table('requ_grupos_emp')->insert($datos);
    return $sql;
   }

  public static function retirarEmpleado($grupo, $empleado)
   {
    $sql = \DB::table('requ_grupos_emp')->where('grupo', $grupo)->where('empleado', $empleado)->delete();
    return $sql;
   }

  public static function getCriterios()
   {
    $sql = \DB::table('requ_criticidad')->orderby('id_criterio','ASC')->get();
    return $sql;
   }

  public static function UltimoGrupo()
   {
    $sql = \DB::table('requ_grupos')->select('id_grupo')->orderby('id_grupo', 'DESC')->first();
    return $sql;
   }

  public static function insertarPriorizacion($datos)
   {
    $sql = \DB::table('requ_priorizacion')->insert($datos);
    return $sql;
   }

  public static function getGruposActivos()
   {
    $sql = \DB::table('requ_grupos')->where('estado','1')->orderby('descripcion','ASC')->get();
    return $sql;
   }

  public static function getGruposActivosEmpleado($empleado)
   {
    $sql = \DB::table('requ_grupos')->where('estado','1')->whereIn('id_grupo',
    function($query) use ($empleado)
     {
      $query->select('grupo')->from('requ_grupos_emp')->where('empleado', $empleado);
     }
    )->orderby('descripcion','ASC')->get();
    return $sql;
   }

  public static function NombreGrupo($id)
   {
    $sql = \DB::table('requ_grupos')->select('descripcion')->where('id_grupo',$id)->get();
    return $sql;
   }
 }