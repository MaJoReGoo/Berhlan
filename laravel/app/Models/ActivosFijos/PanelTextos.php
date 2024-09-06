<?php
//SQl Eloquent para conexión con la base de datos

namespace App\Models\ActivosFijos;

use Illuminate\Database\Eloquent\Model;

class PanelTextos extends Model
 {
  public static function getTextos()
   {
    $sql = \DB::table('acti2_textos')->get();
    return $sql;
   }

  public static function editarTextos($datos)
   {
    $sql = \DB::table('acti2_textos')->update($datos);
    return $sql;
   }
 }
