<?php
//SQl Eloquent para conexión con la base de datos

namespace App\Models\Disciplinarios;

use Illuminate\Database\Eloquent\Model;

class PanelTipofaltas extends Model
 {
  public static function Tipofaltas()
   {
    $sql = \DB::table('disc_tipofaltas')->orderby('estado','DESC')->orderby('descripcion','ASC')->get();
    return $sql;
   }

  public static function TipofaltasActivas()
   {
    $sql = \DB::table('disc_tipofaltas')->where('estado','1')->orderby('descripcion','ASC')->get();
    return $sql;
   }

  public static function CantidadTipofaltasActivas()
   {
    $sql = \DB::table('disc_tipofaltas')->where('estado','1')->count();
    return $sql;
   }

  public static function CantidadTipofaltasInactivas()
   {
    $sql = \DB::table('disc_tipofaltas')->where('estado','0')->count();
    return $sql;
   }

  public static function TipofaltaUnica($id)
   {
    $sql = \DB::table('disc_tipofaltas')->where('descripcion',$id)->count();
    return $sql;
   }

  public static function insertarTipofalta($datos)
   {
    $sql = \DB::table('disc_tipofaltas')->insert($datos);
    return $sql;
   }

  public static function Tipofalta($id)
   {
    $sql = \DB::table('disc_tipofaltas')->where('id_tipofalta',$id)->get();
    return $sql;
   }

  public static function TipofaltaUnicaModificar($des, $id)
   {
    $sql = \DB::table('disc_tipofaltas')->where('id_tipofalta', '!=', $id)->where('descripcion',$des)->count();
    return $sql;
   }

  public static function actualizarTipofalta($id, $datos)
   {
    $sql = \DB::table('disc_tipofaltas')->where('id_tipofalta', $id)->update($datos);
    return $sql;
   }

  public static function UltimoTipo()
   {
    $sql = \DB::table('disc_tipofaltas')->select("id_tipofalta")->orderby('id_tipofalta', 'DESC')->first();
    return $sql;
   }
 }