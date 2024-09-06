<?php
//SQl Eloquent para conexión con la base de datos de siesa

namespace App\Models\Bpack;

use Illuminate\Database\Eloquent\Model;

class PanelItemEtiquetas extends Model
 {
  public static function Items()
   {
    $id = "SELECT f120_id, f120_notas
           FROM dbo.t120_mc_items
           WHERE f120_id_tipo_inv_serv = 'INVET001' AND f120_id_cia = '1'
           ORDER BY f120_id";
    $sql = \DB::connection('sqlsrv')->select($id);
    return $sql;
   }

  public static function Referencia($id)
   {
    $id = "SELECT f120_notas
           FROM dbo.t120_mc_items
           WHERE f120_id_tipo_inv_serv = 'INVET001' AND f120_id_cia = '1'
           AND f120_id = '$id' ";
    $sql = \DB::connection('sqlsrv')->select($id);
    return $sql;
   }

 }