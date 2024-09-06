<?php
//SQl Eloquent para conexión con la base de datos

namespace App\Models\TicActivos;

use Illuminate\Database\Eloquent\Model;

class PanelTextos extends Model
 {
  public static function getTextos()
   {
    $sql = \DB::table('acti_textos')->get();
    return $sql;
   }

  public static function editarTextos($datos)
   {
    $sql = \DB::table('acti_textos')->update($datos);
    return $sql;
   }
 }