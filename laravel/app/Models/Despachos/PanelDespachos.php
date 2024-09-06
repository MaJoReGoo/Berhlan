<?php
//SQl Eloquent para conexión con la base de datos

namespace App\Models\Despachos;

use Illuminate\Database\Eloquent\Model;

class PanelDespachos extends Model
 {

  public static function insertarDespachos($datos)
   {
    $sql = \DB::table('desp_documentos')->insert($datos);
    return $sql;
   }

   public static function actualizarDespachos($id, $datos)
   {
    $sql = \DB::table('desp_documentos')->where('id', $id)->update($datos);
    return $sql;
   }

public static function getDespachos()
   {
    $sql = \DB::table('desp_documentos')->orderby('fecha','DESC')->paginate(25);
    return $sql;
   }

   public static function getDespachosSinEnviar()
   {
    $sql = \DB::table('desp_documentos')->orderby('fecha','DESC')->where('estado',0)->get();
    return $sql;
   }

 }
