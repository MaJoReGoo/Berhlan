<?php
//SQl Eloquent para conexión con la base de datos

namespace App\Models\TicActivos;

use Illuminate\Database\Eloquent\Model;

class PanelTpOffice extends Model
 {
  public static function getTpOffices()
   {
    $sql = \DB::table('acti_tipooffice')->orderby('estado','DESC')->orderby('descripcion','ASC')->get();
    return $sql;
   }

  public static function getCantidadTpOfficeActivos()
   {
    $sql = \DB::table('acti_tipooffice')->where('estado','1')->count();
    return $sql;
   }

  public static function getCantidadTpOfficeInactivos()
   {
    $sql = \DB::table('acti_tipooffice')->where('estado','0')->count();
    return $sql;
   }

  public static function getTpOfficeUnico($id)
   {
    $sql = \DB::table('acti_tipooffice')->where('descripcion',$id)->count();
    return $sql;
   }

  public static function insertarTpOffice($datos)
   {
    $sql = \DB::table('acti_tipooffice')->insert($datos);
    return $sql;
   }

  //Consulta el ultimo registro insertado
  public static function UltimoTpOffice()
   {
    $sql = \DB::table('acti_tipooffice')->select("id_tipo")->orderby('id_tipo', 'DESC')->first();
    return $sql;
   }

  public static function getTpOffice($id)
   {
    $sql = \DB::table('acti_tipooffice')->where('id_tipo',$id)->get();
    return $sql;
   }

  public static function getTpOfficeUnicoModificar($id, $id1)
   {
    $sql = \DB::table('acti_tipooffice')->where('descripcion',$id)->where('id_tipo', '!=', $id1)->count();
    return $sql;
   }

  public static function actualizarTpOffice($id, $datos)
   {
    $sql = \DB::table('acti_tipooffice')->where('id_tipo', $id)->update($datos);
    return $sql;
   }

  public static function getTpOfficeActivos()
   {
    $sql = \DB::table('acti_tipooffice')->where('estado', '1')->orderby('descripcion','ASC')->get();
    return $sql;
   }


 }