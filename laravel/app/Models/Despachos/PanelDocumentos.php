<?php
//SQl Eloquent para conexión con la base de datos

namespace App\Models\Despachos;

use Illuminate\Database\Eloquent\Model;

class PanelDocumentos extends Model
 {

  public static function insertarDocumentos($datos)
   {
    $sql = \DB::table('desp_listdocumentos')->insert($datos);
    return $sql;
   }

   public static function actualizarDocumentos($id, $datos)
   {
    $sql = \DB::table('desp_listdocumentos')->where('id', $id)->update($datos);
    return $sql;
   }

   public static function getDocumentos()
   {
    $sql = \DB::table('desp_listdocumentos')->orderby('fecha_creacion','DESC')->paginate(25);
    return $sql;
   }
   public static function buscarPorOrden($orden)
   {
    $sql = \DB::table('desp_listdocumentos')->orderby('fecha_creacion','DESC')->where('orden_compra',$orden)->count();
    return $sql;
   }


   public static function getDOrdenesSinEnviar()
   {
    $sql = \DB::table('desp_listdocumentos')->orderby('fecha_creacion','DESC')->where('estado',0)->get();
    return $sql;
   }
   public static function getDOrdenesSinEnviarCant()
   {
    $sql = \DB::table('desp_listdocumentos')->orderby('fecha_creacion','DESC')->where('estado',0)->count();
    return $sql;
   }

 }
