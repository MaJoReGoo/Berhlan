<?php
//SQl Eloquent para conexión con la base de datos

namespace App\Models\TicActivos;

use Illuminate\Database\Eloquent\Model;

class PanelLicencias extends Model
 {
  public static function getLicencias()
   {
    $sql = \DB::table('acti_licenciaoffice')->orderby('estado','DESC')->orderby('descripcion','ASC')->get();
    return $sql;
   }

  public static function getCantidadLicenciasActivas()
   {
    $sql = \DB::table('acti_licenciaoffice')->where('estado','1')->count();
    return $sql;
   }

  public static function getCantidadLicenciasInactivas()
   {
    $sql = \DB::table('acti_licenciaoffice')->where('estado','0')->count();
    return $sql;
   }

  public static function getLicenciaUnica($id)
   {
    $sql = \DB::table('acti_licenciaoffice')->where('descripcion',$id)->count();
    return $sql;
   }

  public static function getCodigoUnico($id)
   {
    $sql = \DB::table('acti_licenciaoffice')->where('codigoint',$id)->count();
    return $sql;
   }

  public static function insertarLicencia($datos)
   {
    $sql = \DB::table('acti_licenciaoffice')->insert($datos);
    return $sql;
   }

  //Consulta el ultimo registro insertado
  public static function UltimaLicencia()
   {
    $sql = \DB::table('acti_licenciaoffice')->select("id_licencia")->orderby('id_licencia', 'DESC')->first();
    return $sql;
   }

  public static function getLicencia($id)
   {
    $sql = \DB::table('acti_licenciaoffice')->where('id_licencia',$id)->get();
    return $sql;
   }

  public static function getLicenciaUnicaModificar($id, $id1)
   {
    $sql = \DB::table('acti_licenciaoffice')->where('descripcion',$id)->where('id_licencia', '!=', $id1)->count();
    return $sql;
   }

  public static function getCodigoUnicoModificar($id, $id1)
   {
    $sql = \DB::table('acti_licenciaoffice')->where('codigoint',$id)->where('id_licencia', '!=', $id1)->count();
    return $sql;
   }

  public static function actualizarLicencia($id, $datos)
   {
    $sql = \DB::table('acti_licenciaoffice')->where('id_licencia', $id)->update($datos);
    return $sql;
   }

  public static function getLicenciasActivas()
   {
    $sql = \DB::table('acti_licenciaoffice')->where('estado', '1')->orderby('descripcion','ASC')->get();
    return $sql;
   }

  public static function getLicenciasTpActivas()
   {
    $sql = \DB::table('acti_licenciaoffice');
    $sql = $sql->select('id_licencia')->selectRaw("acti_tipooffice.descripcion AS tpdes")->selectRaw("acti_licenciaoffice.descripcion AS lice");
    $sql = $sql->join('acti_tipooffice', 'acti_tipooffice.id_tipo', '=', 'acti_licenciaoffice.tipo');
    $sql = $sql->where('acti_licenciaoffice.estado', '1')->orderby('acti_tipooffice.descripcion','ASC')->orderby('acti_licenciaoffice.descripcion','ASC')->get();
    return $sql;
   }

  public static function LicenciasyTipo($id)
   {
    $sql = \DB::table('acti_licenciaoffice');
    $sql = $sql->select('id_licencia')->selectRaw("acti_tipooffice.descripcion AS tpdes")->selectRaw("acti_licenciaoffice.descripcion AS lice");
    $sql = $sql->join('acti_tipooffice', 'acti_tipooffice.id_tipo', '=', 'acti_licenciaoffice.tipo');
    $sql = $sql->where('id_licencia', $id)->get();
    return $sql;
   }
 }