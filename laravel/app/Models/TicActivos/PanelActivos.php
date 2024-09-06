<?php
//SQl Eloquent para conexión con la base de datos

namespace App\Models\TicActivos;

use Illuminate\Database\Eloquent\Model;


class PanelActivos extends Model
 {
  public static function insertarActivo($datos)
   {
    $sql = \DB::table('acti_activo')->insert($datos);
    return $sql;
   }

  //Consulta el ultimo registro insertado
  public static function UltimoActivo()
   {
    $sql = \DB::table('acti_activo')->select("id_activo")->orderby('id_activo', 'DESC')->first();
    return $sql;
   }

  public static function insertarActividad($datos)
   {
    $sql = \DB::table('acti_actividades')->insert($datos);
    return $sql;
   }

  public static function insertarCambio($datos)
   {
    $sql = \DB::table('acti_cambios')->insert($datos);
    return $sql;
   }

  public static function actualizarActivo($id, $datos)
   {
    $sql = \DB::table('acti_activo')->where('id_activo', $id)->update($datos);
    return $sql;
   }

  public static function ingresarPrograma($datos)
   {
    $sql = \DB::table('acti_sofinstalado')->insert($datos);
    return $sql;
   }

  public static function borrarProgramas($id)
   {
    $sql = \DB::table('acti_sofinstalado')->where('activo', $id)->delete();
    return $sql;
   }

  public static function Activo($id)
   {
    $sql = \DB::table('acti_activo')->where('id_activo',$id)->get();
    return $sql;
   }

  public static function Programasinstalados($id)
   {
    $sql = \DB::table('acti_sofinstalado')->join('acti_software', 'id_software', '=', 'software')->where('activo',$id)->orderby('acti_software.descripcion','ASC')->get();
    return $sql;
   }

  public static function ActivosLicencias($id)
   {
    $sql = \DB::table('acti_activo')->where('office',$id)->orderby('cod_interno','ASC')->get();
    return $sql;
   }

  public static function ActivosSql($id)
   {
    $sql = \DB::select($id);
    return $sql;
   }

  public static function Actividades($id)
   {
    $sql = \DB::table('acti_actividades')->where('activo',$id)->where('mantenimiento', '!=', 'I')->orderby('fecha','DESC')->get();
    return $sql;
   }

  public static function Cambios($id)
   {
    $sql = \DB::table('acti_cambios')->where('activo',$id)->orderby('fecha','DESC')->get();
    return $sql;
   }

  public static function TareasActividades($id)
   {
    $sql = \DB::table('acti_actv_tareas')->join('acti_tareas', 'id_tarea', '=', 'tarea')->where('actividad',$id)->orderby('acti_tareas.descripcion','ASC')->get();
    return $sql;
   }

  public static function ingresarTareaAct($datos)
   {
    $sql = \DB::table('acti_actv_tareas')->insert($datos);
    return $sql;
   }

  //Consulta el ultimo registro insertado
  public static function UltimaActividad()
   {
    $sql = \DB::table('acti_actividades')->select("id_actividad")->orderby('id_actividad', 'DESC')->first();
    return $sql;
   }

   //Consulta por persona que activo tiene asignado actualmente y cual tuvo en su momento
   public static function ActivosActAsignados($identificacion, $usuario, $nombres)
   {
       $resultados = "SELECT
       aa.cod_interno,
       MAX(aa.id_activo) AS activo,
       MAX(pe.identificacion) AS identificacion, MAX(pe.primer_nombre) AS primer_nombre,
       MAX(pe.ot_nombre) AS ot_nombre, MAX(pe.primer_apellido) AS primer_apellido,
       MAX(pe.ot_apellido) AS ot_apellido, MAX(ac.fecha) AS fecha,
       CASE WHEN pe.identificacion = $identificacion THEN 'Igual' ELSE 'Diferente' END AS tipo_identificacion
       FROM
       acti_activo AS aa
       JOIN param_empleados AS pe ON pe.id_empleado = aa.empleado
       LEFT JOIN acti_cambios AS ac ON aa.id_activo = ac.activo
       WHERE
       (
       aa.id_activo IN (
       SELECT ac.activo FROM acti_cambios as ac
       WHERE ac.cambio LIKE '%|| Colaborador: $identificacion%' or ac.cambio LIKE '%Colaborador: $usuario%' OR ac.cambio LIKE '%|| Colaborador Anterior: $nombres%'
       )
       OR
       pe.identificacion = $identificacion
       )
       GROUP BY
       aa.cod_interno ,tipo_identificacion";

       $sql = \DB::connection('mysql')->select($resultados);
       return $sql;

   }

  /*  Consulta que trae por activo el usuario actual asignado
   y el historicos de los que los tuvieron asignado */
   public static function UsuariosXactivo($activo){

       $sql = \DB::table('acti_activo as aa')
       ->select('aa.empleado','ac.cambio','ac.fecha')
       ->join('acti_cambios as ac','aa.id_activo','=','ac.activo')
       ->where('ac.activo',$activo)
       ->where('ac.cambio', 'like', '%Colaborador:%')
       ->get();

       return $sql;

   }

   public static function ActivoxEmpleado($empleado)
   {

       $sql = \DB::table('acti_activo as aa')
           ->select('aa.id_activo', 'am.descripcion as marca', 'att.descripcion as tipo', 'aa.activofijo', 'aa.serial', 'aa.cod_interno')
           ->join('acti_tipoactivo as att', 'att.id_tipoactivo', '=', 'aa.tipo')
           ->join('acti_marcas as am', 'am.id_marca', '=', 'aa.marca')
           ->where('empleado', $empleado)->get();

       return $sql;
   }

   public static function EmpleadoDeUsuario($primer_nombre,$primer_apellido,$identificacion){

       $sql=\DB::table('param_empleados as pe')
       ->where('pe.primer_nombre',$primer_nombre)
       ->where('pe.primer_apellido',$primer_apellido)
       ->orwhere('pe.identificacion',$identificacion)
       ->get();

       return $sql;
   }

   public static function getActivos(){
       $sql=\DB::table('acti_activo')->get();
       return $sql;
   }
 }
