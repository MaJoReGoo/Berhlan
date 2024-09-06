<?php

//SQl Eloquent para conexión con la base de datos



namespace App\Models\Bpack;



use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;



class PanelSolicitudesAN extends Model

{

  public static function idactualizacion()

  {

    $sql = DB::table('bpac_solicitudan')->select("id_actualizacion")->orderby('id_actualizacion', 'DESC')->first();

    return $sql;

  }



  public static function insertarSolicitudAN($datos)

  {

    $sql = DB::table('bpac_solicitudan')->insert($datos);

    return $sql;

  }



  public static function UltimaSolicitudAN()

  {

    $sql = DB::table('bpac_solicitudan')->select("id_solicitud")->orderby('id_solicitud', 'DESC')->first();

    return $sql;

  }



  public static function insertarSolicitudANdet($datos)

  {

    $sql = DB::table('bpac_solicitudandet')->insert($datos);

    return $sql;

  }



  public static function idnvdesarrollo()

  {

    $sql = DB::table('bpac_solicitudan')->select("id_nvdesarrollo")->orderby('id_nvdesarrollo', 'DESC')->first();

    return $sql;

  }



  public static function actualizarSolicitudAN($id, $datos)

  {

    $sql = DB::table('bpac_solicitudan')->where('id_solicitud', $id)->update($datos);

    return $sql;

  }



  //Nos trae la información de las cantidades de solicitudes abiertas

  public static function SolTotalesEstado()

  {

    $sql = DB::table('bpac_solicitudan')->select("estado")->selectRaw("COUNT('estado') AS cantidad");

    $sql = $sql->whereIn('estado', ['1', '2', '3', '4', '5', '6', '7', '10', '11']);

    $sql = $sql->groupBy('estado')->orderBy('estado', 'ASC')->get();

    return $sql;

  }



  public static function PendientesRuta()

  {

    $sql = DB::table('bpac_solicitudan')->where('estado', '1')->orderBy('id_nvdesarrollo', 'ASC')->orderBy('tipo', 'ASC')->orderBy('fecha_crea', 'ASC')->get();

    return $sql;

  }



  public static function SolicitudAN($id)

  {

    $sql = DB::table('bpac_solicitudan')->where('id_solicitud', $id)->get();

    return $sql;

  }



  public static function DetSolicitudan($id)

  {

    $sql = DB::table('bpac_solicitudandet')->where('solicitud', $id)->orderby('item', 'ASC')->orderby('registro', 'ASC')->get();

    return $sql;

  }



  public static function MovSolicitudan($id)

  {

    $sql = DB::table('bpac_movimientosan')->where('solicitud', $id)->orderby('fecha', 'DESC')->get();

    return $sql;

  }



  public static function DesEstado($id)

  {

    $sql = DB::table('bpac_estadosan')->where('id_estado', $id)->get();

    return $sql;

  }



  public static function SolEstados()

  {

    $sql = DB::table('bpac_estadosan')->orderby('descripcion', 'ASC')->get();

    return $sql;

  }



  public static function insertarMovimiento($datos)

  {

    $sql = DB::table('bpac_movimientosan')->insert($datos);

    return $sql;

  }



  public static function actualizarSolicitudDetAN($id1, $id2, $datos)

  {

    $sql = DB::table('bpac_solicitudandet')->where('solicitud', $id1)->where('registro', $id2)->update($datos);

    return $sql;

  }



  public static function PendientesCoreccRuta()

  {

    $sql = DB::table('bpac_solicitudan')->where('estado', '10')->orderBy('id_nvdesarrollo', 'ASC')->orderBy('tipo', 'ASC')->orderBy('fecha_crea', 'ASC')->get();

    return $sql;

  }



  public static function UltimoRechazoRuta($id)

  {

    $sql = DB::table('bpac_movimientosan')->where('solicitud', $id)->where('estado', '10')->orderBy('fecha', 'DESC')->get();

    return $sql;

  }



  public static function PendientesAprueba()

  {

    $sql = DB::table('bpac_solicitudan')->whereIn('estado', ['2', '5'])->orderBy('id_nvdesarrollo', 'ASC')->orderBy('tipo', 'ASC')->orderBy('fecha_crea', 'ASC')->get();

    return $sql;

  }



  public static function SolDetConFlexo($id)

  {

    $sql = DB::table('bpac_solicitudandet')->select('item')->where('solicitud', $id)->where('ruta', 'F')->orderBy('item', 'ASC')->get();

    return $sql;

  }



  public static function SolDetCan($id)

  {

    $sql = DB::table('bpac_solicitudandet')->select("ruta")->selectRaw("COUNT('solicitud') AS cantidad")->where('solicitud', $id)->where('ruta', '!=',  '');

    $sql = $sql->groupBy('ruta')->orderBy('ruta', 'ASC')->get();

    return $sql;

  }



  public static function PendientesCoreccAprueba()

  {

    $sql = DB::table('bpac_solicitudan')->where('estado', '3')->orWhere('estado', '10')->orderBy('id_nvdesarrollo', 'ASC')->orderBy('tipo', 'ASC')->orderBy('fecha_crea', 'ASC')->get();

    return $sql;

  }



  public static function UltimoRechazoAprueba($id)

  {

    $sql = DB::table('bpac_movimientosan')->where('solicitud', $id)->where('estado', '3')->orWhere('motivo_rechazo', '3')->orderBy('fecha', 'DESC')->get();

    return $sql;

  }



  public static function PendientesSherpa()

  {

    $sql = DB::table('bpac_solicitudan')->where('estado', '4')->orderBy('id_nvdesarrollo', 'ASC')->orderBy('tipo', 'ASC')->orderBy('fecha_crea', 'ASC')->get();

    return $sql;

  }



  public static function PendientesContrato()

  {

    $sql = DB::table('bpac_solicitudan')->whereIn('estado', ['6', '11'])->orderBy('id_nvdesarrollo', 'ASC')->orderBy('tipo', 'ASC')->orderBy('fecha_crea', 'ASC')->get();

    return $sql;

  }



  public static function PendientesAprContrato()

  {

    $sql = DB::table('bpac_solicitudan')->where('estado', '7')->orderBy('id_nvdesarrollo', 'ASC')->orderBy('tipo', 'ASC')->orderBy('fecha_crea', 'ASC')->get();

    return $sql;

  }



  public static function PendientesSol()

  {

    $sql = DB::table('bpac_solicitudan')->whereIn('estado', ['1', '2', '3', '4', '5', '6', '7', '10', '11'])->orderBy('id_nvdesarrollo', 'ASC')->orderBy('tipo', 'ASC')->orderBy('fecha_crea', 'ASC')->get();

    return $sql;

  }



  public static function UsrSolicitaSolicitudes()

  {

    $sql = DB::table('bpac_solicitudan')->select('usr_crea');

    $sql = $sql->join('param_empleados', 'usr_crea', '=', 'id_empleado')->groupby('usr_crea')->orderby('primer_nombre', 'ASC')->orderby('ot_nombre', 'ASC');

    $sql = $sql->orderby('primer_apellido', 'ASC')->orderby('ot_apellido', 'ASC')->get();

    return $sql;

  }



  public static function SolicitudesSql($id)

  {

    $sql = DB::select($id);

    return $sql;

  }



  public static function ConActNv($desde, $hasta)

  {

    $sql1 = DB::table('bpac_solicitudan');

    $sql1 = $sql1->join('bpac_solicitudandet', 'id_solicitud', '=', 'solicitud');



    if (($desde != '') && ($hasta != ''))

      $sql = $sql1->where('fecha_crea', '>=', $desde)->where('fecha_crea', '<=', $hasta);

    else if ($desde != '')

      $sql = $sql1->where('fecha_crea', '>=', $desde);

    else if ($hasta != '')

      $sql = $sql1->where('fecha_crea', '<=', $hasta);

    else

      $sql = $sql1;



    $sql = $sql->orderBy('id_nvdesarrollo', 'ASC')->orderBy('tipo', 'ASC')->orderBy('fecha_crea', 'ASC')->get();

    return $sql;

  }



  public static function fechafin($id)

  {

    $sql = DB::table('bpac_movimientosan')->where('solicitud', $id)->whereIn('estado', ['8', '9'])->orderBy('fecha', 'DESC')->get();

    return $sql;

  }



  public static function fechaaprsherpa($id)
  {
    $sql = DB::table('bpac_movimientosan')->where('solicitud', $id)->where('estado', '6')->where('observaciones', 'like', 'Solicitud aprobada%')->orwhere('observaciones', 'like', 'REVIS%')->orderBy('fecha', 'DESC')->get();
    return $sql;
  }





  public static function ConSherpasAprbadas($item, $referencia, $cliente)

  {

    $sql = DB::table('bpac_solicitudan');

    $sql = $sql->join('bpac_solicitudandet', 'id_solicitud', '=', 'solicitud');



    if ($item != '')

      $sql = $sql->where('item', 'like', '%' . $item . '%');



    if ($referencia != '')

      $sql = $sql->where('referencia', 'like', '%' . $referencia . '%');



    if ($cliente != '')

      $sql = $sql->where('cliente', 'like', '%' . $cliente . '%');



    $sql = $sql->where('estado', '8')->orderBy('item', 'ASC')->orderBy('version', 'DESC')->get();

    return $sql;

  }



  // Nuevas Funciones

  public static function PendientesCoreccApruebaEstado($estado)

  {

    $sql = DB::table('bpac_solicitudan')->where('estado', $estado)->orderBy('id_nvdesarrollo', 'ASC')->orderBy('tipo', 'ASC')->orderBy('fecha_crea', 'ASC')->get();

    return $sql;

  }



  public static function PendientesCoreccTodas()

  {

    $sql = DB::table('bpac_solicitudan')->where('estado', 3)->orWhere('estado', 10)->orderBy('id_nvdesarrollo', 'ASC')->orderBy('tipo', 'ASC')->orderBy('fecha_crea', 'ASC')->get();

    return $sql;

  }

  public static function FechaAprobacionDigital($solicitud)
  {
    $sql = DB::select("SELECT * FROM bpac_movimientosan WHERE solicitud = " . $solicitud . " and estado = 6 ORDER BY fecha ASC LIMIT 1");
    return $sql;
    }





  public static function FechaEnvioSherpaDigital($solicitud)

  {

    $sql = DB::select("SELECT * FROM bpac_movimientosan WHERE solicitud = " . $solicitud . " and estado = 4 ORDER BY fecha ASC LIMIT 1");

    return $sql;

  }



  public static function FechaEnvioSherpaFisica($solicitud)

  {

    $sql = DB::select("SELECT * FROM bpac_movimientosan WHERE solicitud = " . $solicitud . " and estado = 7 ORDER BY fecha ASC LIMIT 1");

    return $sql;

  }



  public static function CantidadReprocesosRuta($solicitud)

  {

    $sql = DB::select("SELECT count(*) as cantrp FROM bpac_movimientosan WHERE solicitud = " . $solicitud . " and estado = 1");

    return $sql;

  }



  public static function CantidadReprocesosPreprensa($solicitud)

  {

    $sql = DB::select("SELECT count(*) as cantrp FROM bpac_movimientosan WHERE solicitud = " . $solicitud . " and estado = 5");

    return $sql;

  }



  public static function CantidadReprocesosPublicidad($solicitud)

  {

    $sql = DB::select("SELECT count(*) as cantrp FROM bpac_movimientosan WHERE solicitud = " . $solicitud . " and (estado = 4 or estado = 6) ");

    return $sql;

  }



  // 

}

