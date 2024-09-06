<?php
//SQl Eloquent para conexión con la base de datos

namespace App\Models\TicActivos;

use Illuminate\Database\Eloquent\Model;
use DB;

class PanelConsultas extends Model
 {
  public static function EmpresasActivos()
   {
    $sql = \DB::table('acti_activo')->select('empresa')->where('estado', 1)->groupBy('empresa')->get();
    return $sql;
   }

  public static function ActivosEmpresa($id)
   {
    $sql = \DB::table('acti_activo')->select('tipo')->selectRaw("COUNT('tipo') AS cant");
    $sql = $sql->where('empresa', $id)->where('estado', 1)->groupBy('tipo')->orderBy('cant', 'DESC')->get();
    return $sql;
   }

  public static function CentrosActivos()
   {
    $sql = \DB::table('acti_activo')->select('param_centros.id_centro', 'param_centros.descripcion  AS descp');
    $sql = $sql->join('param_empleados', 'id_empleado', '=', 'acti_activo.empleado');
    $sql = $sql->join('param_centros', 'id_centro', '=', 'param_empleados.centro_op');
    $sql = $sql->where('acti_activo.estado', 1)->groupBy('param_centros.id_centro', 'param_centros.descripcion')->get();
    return $sql;
   }

  public static function ActivosCentro($id)
   {
    $sql = \DB::table('acti_activo')->select('tipo', 'empresa')->selectRaw("COUNT('tipo') AS cant");
    $sql = $sql->join('param_empleados', 'id_empleado', '=', 'acti_activo.empleado');
    $sql = $sql->where('param_empleados.centro_op', $id)->where('acti_activo.estado', 1)->groupBy('empresa', 'tipo')->orderBy('cant', 'DESC')->get();
    return $sql;
   }

  public static function AreasActivos()
   {
    $sql = \DB::table('acti_activo')->select('param_areas.id_area', 'param_areas.descripcion  AS descp');
    $sql = $sql->join('param_empleados', 'id_empleado', '=', 'acti_activo.empleado');
    $sql = $sql->join('param_cargos', 'id_cargo', '=', 'param_empleados.cargo');
    $sql = $sql->join('param_areas', 'id_area', '=', 'param_cargos.area');
    $sql = $sql->where('acti_activo.estado', 1)->groupBy('param_areas.id_area', 'param_areas.descripcion')->get();
    return $sql;
   }

  public static function ActivosArea($id)
   {
    $sql = \DB::table('acti_activo')->select('tipo', 'param_centros.descripcion  AS descp')->selectRaw("COUNT('tipo') AS cant");
    $sql = $sql->join('param_empleados', 'id_empleado', '=', 'acti_activo.empleado');
    $sql = $sql->join('param_cargos', 'id_cargo', '=', 'param_empleados.cargo');
    $sql = $sql->join('param_areas', 'id_area', '=', 'param_cargos.area');
    $sql = $sql->join('param_centros', 'id_centro', '=', 'param_empleados.centro_op');
    $sql = $sql->where('param_cargos.area', $id)->where('acti_activo.estado', 1)->groupBy('param_centros.descripcion', 'tipo')->orderBy('descp', 'ASC')->orderBy('tipo', 'DESC')->get();
    return $sql;
   }

  public static function ProyeccionSql($id)
   {
    $sql = \DB::select($id);
    return $sql;
   }

  public static function Exempleados()
   {
    $sql = \DB::table('acti_activo');
    $sql = $sql->join('param_empleados', 'id_empleado', '=', 'acti_activo.empleado');
    $sql = $sql->where('acti_activo.estado', 1)->where('param_empleados.estado', 0)->orderby('id_activo', 'ASC')->get();
    return $sql;
   }

  public static function TiposActivos()
   {
    $sql = \DB::table('acti_activo')->select('tipo', 'descripcion');
    $sql = $sql->join('acti_tipoactivo', 'id_tipoactivo', '=', 'tipo');
    $sql = $sql->where('acti_activo.estado', 1)->groupBy('tipo', 'descripcion')->orderby('descripcion', 'ASC')->get();
    return $sql;
   }

  //Calcula el numero de meses entre la primera y última fecha de los activos según la adquisición
  public static function NumIntervalos($id)
   {
    $sel = "((TIMESTAMPDIFF(MONTH, MIN(fechaadq), MAX(fechaadq))+1)/".$id.") AS intervalo";
    $sql = \DB::table('acti_activo')->select($sel);
    $sql = $sql->where('acti_activo.estado', 1)->where('fechaadq', '!=', NULL)->get();
    return $sql;
   }

  public static function CanActivosPeriodos($id1, $id2, $id3)
   {
    $sql = \DB::table('acti_activo')->where('tipo', $id1)->where('fechaadq', '>', $id2)->where('fechaadq', '<=', $id3)->count();
    return $sql;
   }

  public static function EmpleadosMtto()
   {
    $sql = \DB::table('acti_actividades')->select('usuario')->whereIN('mantenimiento', ['P', 'C'])->groupBy('usuario')->get();
    return $sql;
   }

  public static function EmpleadosTareas()
   {
    $sql = \DB::table('acti_actividades')->select('usuario')->where('mantenimiento', '!=', 'I')->groupBy('usuario')->get();
    return $sql;
   }

  //Fecha del ultimo mtto realizado, incluye ingreso
  public static function FechaUltActividad($id)
   {
    $sql = \DB::table('acti_actividades')->select('fecha')->where('activo', $id)->where('mantenimiento', '!=', 'N')->orderBy('fecha', 'DESC')->get();
    return $sql;
   }

  public static function FechaActividadAnt($id, $id1)
   {
    $sql = \DB::table('acti_actividades')->select('fecha')->where('activo', $id1)->where('fecha', '<', $id)->where('mantenimiento', '!=', 'N')->orderBy('fecha', 'DESC')->get();
    return $sql;
   }

   public static function ExmpleadosGroup()
   {

       $sql = \DB::table('acti_activo as aa')->select('pe.id_empleado' ,DB::raw('count(aa.id_activo) as cantidad'))
           ->join('param_empleados as pe', 'pe.id_empleado', '=', 'aa.empleado')
           ->where('aa.estado', '=', 1)->where('pe.estado', '=', 0)
           ->groupby('pe.id_empleado')->get();

       return $sql;

   }
 }
