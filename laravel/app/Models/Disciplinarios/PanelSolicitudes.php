<?php
//SQl Eloquent para conexión con la base de datos

namespace App\Models\Disciplinarios;

use Illuminate\Database\Eloquent\Model;

class PanelSolicitudes extends Model
 {

  public static function siesa()
   {
    $sql = \DB::connection('sqlsrv')->table('dbo.t200_mm_terceros')->get();
    return $sql;
   }

  public static function insertarSolicitud($datos)
   {
    $sql = \DB::table('disc_solicitud')->insert($datos);
    return $sql;
   }

  //O atendida        1 Abierta pendiente
  public static function SolicitudesPendientes()
   {
    $sql = \DB::table('disc_solicitud')->where('estado', '1')->orderby('fecha_solicita','DESC')->get();
    return $sql;
   }

  //Solicitudes con el acusado como parámetro
  public static function SolicitudesEmpleado($id)
   {
    $sql = \DB::table('disc_solicitud')->where("colaborador", $id)->orderby('estado','DESC')->orderby('fecha_solicita','DESC')->get();
    return $sql;
   }

  public static function Solicitud($id)
   {
    $sql = \DB::table('disc_solicitud')->where('id_solicitud', $id)->get();
    return $sql;
   }

  public static function actualizarSolicitud($id, $datos)
   {
    $sql = \DB::table('disc_solicitud')->where('id_solicitud', $id)->update($datos);
    return $sql;
   }

  public static function Solicitudes20dias($id, $fecha)
   {
    $sql = \DB::table('disc_solicitud')->where("usr_solicita", $id)->where(function($query) use ($fecha) {$query->where('fecha_cierre', NULL)->orWhere('fecha_cierre', '>=', $fecha);})->orderby('fecha_solicita', 'ASC')->get();
    return $sql;
   }

  public static function UsrSolicitaSolicitudes()
   {
    $sql = \DB::table('disc_solicitud')->select('usr_solicita');
    $sql = $sql->join('param_empleados', 'usr_solicita', '=', 'id_empleado')->groupby('usr_solicita')->orderby('primer_nombre','ASC')->orderby('ot_nombre','ASC');
    $sql = $sql->orderby('primer_apellido','ASC')->orderby('ot_apellido','ASC')->get();
    return $sql;
   }

  public static function UsrFaltaSolicitudes()
   {
    $sql = \DB::table('disc_solicitud')->select('colaborador');
    $sql = $sql->join('param_empleados', 'colaborador', '=', 'id_empleado')->groupby('colaborador')->orderby('primer_nombre','ASC')->orderby('ot_nombre','ASC');
    $sql = $sql->orderby('primer_apellido','ASC')->orderby('ot_apellido','ASC')->get();
    return $sql;
   }

  //Consulta los usuarios que cometieron faltas amarradas al usuario que solicita
  public static function UsrFaltaSolicitudesUsr($id)
   {
    $sql = \DB::table('disc_solicitud')->select('colaborador')->where('usr_solicita', $id);
    $sql = $sql->join('param_empleados', 'colaborador', '=', 'id_empleado')->groupby('colaborador')->orderby('primer_nombre','ASC')->orderby('ot_nombre','ASC');
    $sql = $sql->orderby('primer_apellido','ASC')->orderby('ot_apellido','ASC')->get();
    return $sql;
   }

  public static function UsrCierreSolicitudes()
   {
    $sql = \DB::table('disc_solicitud')->select('usr_cierre')->where('usr_cierre', '!=', '0');
    $sql = $sql->join('param_empleados', 'usr_cierre', '=', 'id_empleado')->groupby('usr_cierre')->orderby('primer_nombre','ASC')->orderby('ot_nombre','ASC');
    $sql = $sql->orderby('primer_apellido','ASC')->orderby('ot_apellido','ASC')->get();
    return $sql;
   }

  public static function SolicitudesSql($id)
   {
    $sql = \DB::select($id);
    return $sql;
   }

  public static function FaltasColaborador($id, $sol)
   {
    $sql = \DB::table('disc_solicitud')->where("colaborador", $id)->where("id_solicitud", "!=", $sol)->orderby('estado', 'DESC')->orderby('fecha_solicita', 'ASC')->get();
    return $sql;
   }

  public static function FaltasColaboradorSinExoneracion($id, $sol)
   {
    $sql = \DB::table('disc_solicitud')->where("colaborador", $id)->where("id_solicitud", "!=", $sol)->where("motivo_cierre", "!=", 4)->orderby('estado', 'DESC')->orderby('fecha_solicita', 'ASC')->get();
    return $sql;
   }

  //Listado de solicitudes parametrizado por fechas
  public static function SolicitudesFechas($desde, $hasta, $estado)
   {
    $sql1 = \DB::table('disc_solicitud')->where('estado', $estado);

    if(($desde != '') && ($hasta != ''))
      $sql = $sql1->where('fecha_solicita', '>=', $desde)->where('fecha_solicita', '<=', $hasta)->orderby('fecha_solicita','ASC')->get();
    else if ($desde != '')
      $sql = $sql1->where('fecha_solicita', '>=', $desde)->orderby('fecha_solicita','ASC')->get();
    else if ($hasta != '')
      $sql = $sql1->where('fecha_solicita', '<=', $hasta)->orderby('fecha_solicita','ASC')->get();
    else
      $sql = $sql1->orderby('fecha_solicita','ASC')->get();
    return $sql;
   }

  //Cantidad de solicitudes por fechas
  public static function TSolicitudes($desde, $hasta)
   {
    $sql1 = \DB::table('disc_solicitud');

    if(($desde != '') && ($hasta != ''))
      $sql = $sql1->where('fecha_solicita', '>=', $desde)->where('fecha_solicita', '<=', $hasta)->count();
    else if ($desde != '')
      $sql = $sql1->where('fecha_solicita', '>=', $desde)->count();
    else if ($hasta != '')
      $sql = $sql1->where('fecha_solicita', '<=', $hasta)->count();
    else
      $sql = $sql1->count();
    return $sql;
   }

  //Solicitudes según estado parámetro fechas
  public static function EstadoSolicitudes($desde, $hasta, $estado)
   {
    $sql1 = \DB::table('disc_solicitud')->where('estado', $estado);

    if(($desde != '') && ($hasta != ''))
      $sql2 = $sql1->where('fecha_solicita', '>=', $desde)->where('fecha_solicita', '<=', $hasta);
    else if ($desde != '')
      $sql2 = $sql1->where('fecha_solicita', '>=', $desde);
    else if ($hasta != '')
      $sql2 = $sql1->where('fecha_solicita', '<=', $hasta);
    else
      $sql2 = $sql1;

    $sql = $sql2->count();

    return $sql;
   }

  //Solicitudes por tipo de cierre y fechas
  public static function TipocierreSolicitudes($desde, $hasta)
   {
    $sql1 = \DB::table('disc_solicitud')->select('motivo_cierre')->selectRaw("COUNT('motivo_cierre') AS cant")->where('motivo_cierre', '!=', 0);

    if(($desde != '') && ($hasta != ''))
      $sql2 = $sql1->where('fecha_solicita', '>=', $desde)->where('fecha_solicita', '<=', $hasta);
    else if ($desde != '')
      $sql2 = $sql1->where('fecha_solicita', '>=', $desde);
    else if ($hasta != '')
      $sql2 = $sql1->where('fecha_solicita', '<=', $hasta);
    else
      $sql2 = $sql1;

    $sql = $sql2->groupBy('motivo_cierre')->orderBy('cant', 'DESC')->get();

    return $sql;
   }

  //Solicitudes por tipo de falta y fechas
  public static function TipofaltaSolicitudes($desde, $hasta)
   {
    $sql1 = \DB::table('disc_solicitud')->select('tipo_falta')->selectRaw("COUNT('tipo_falta') AS cant");

    if(($desde != '') && ($hasta != ''))
      $sql2 = $sql1->where('fecha_solicita', '>=', $desde)->where('fecha_solicita', '<=', $hasta);
    else if ($desde != '')
      $sql2 = $sql1->where('fecha_solicita', '>=', $desde);
    else if ($hasta != '')
      $sql2 = $sql1->where('fecha_solicita', '<=', $hasta);
    else
      $sql2 = $sql1;

    $sql = $sql2->groupBy('tipo_falta')->orderBy('cant', 'DESC')->get();

    return $sql;
   }

  //Solicitudes atendidas en el mes
  public static function AtendidosMes($ano, $mes)
   {
    $sql = \DB::table('disc_solicitud')->where('estado', '0')->whereYear('fecha_cierre',$ano)->whereMonth('fecha_cierre',$mes)->count();
    return $sql;
   }

  //Solicitudes pendientes en el mes
  public static function PendientesMes($ano, $mes)
   {
    $sql = \DB::table('disc_solicitud')->where('estado', '1')->whereYear('fecha_solicita',$ano)->whereMonth('fecha_solicita',$mes)->count();
    return $sql;
   }

  public static function BorrarSolicitud($id)
   {
    $sql = \DB::table('disc_solicitud')->where('id_solicitud', $id)->delete();
    return $sql;
   }
 }