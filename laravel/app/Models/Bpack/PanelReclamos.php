<?php
//SQl Eloquent para conexión con la base de datos

namespace App\Models\Bpack;

use Illuminate\Database\Eloquent\Model;

class PanelReclamos extends Model
 {

  public static function Reclamos()
   {
    $sql = \DB::table('bpac_reclamos')->orderby('fecha_ingreso', 'ASC')->get();
    return $sql;
   }

  public static function Reclamo($id)
   {
    $sql = \DB::table('bpac_reclamos')->where('id_reclamo', $id)->get();
    return $sql;
   }
 }