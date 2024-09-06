<?php
//SQl Eloquent para conexión con la base de datos de siesa

namespace App\Models\Etiquetas;

use Illuminate\Database\Eloquent\Model;

class PanelItemEtiquetasBarras extends Model
 {
  public static function Items()
   {
    $id = "SELECT f120_id, f120_notas
           FROM dbo.t120_mc_items, dbo.t121_mc_items_extensiones
           WHERE dbo.t120_mc_items.f120_rowid = dbo.t121_mc_items_extensiones.f121_rowid_item
           AND f120_id_tipo_inv_serv = 'INVPT001' AND f120_id_cia = '1'
           AND f120_ind_manufactura = 1
           AND f120_ind_tipo_item IN (1, 3)
           AND f121_ind_estado = 1
           ORDER BY f120_id";
    $sql = \DB::connection('sqlsrv')->select($id);
    return $sql;
   }

  public static function InfoItem($id)
   {
    $id = "SELECT TOP 1 f120_id, f120_notas, f131_id AS codigo, f131_id_unidad_medida AS undmed
           FROM dbo.t120_mc_items, dbo.t131_mc_items_barras
           WHERE dbo.t131_mc_items_barras.f131_rowid_item_ext = dbo.t120_mc_items.f120_rowid
           AND f120_id = '$id'
           AND f120_id_cia = '1'
           ORDER BY f131_id_unidad_medida ";
    $sql = \DB::connection('sqlsrv')->select($id);
    return $sql;
   }

  public static function InfoMaquila($id)
   {
    $id = "SELECT T120.f120_id AS id, MAQ.descripcion AS 'MAQUILA', MAQ.idmaquila AS 'IDMAQUILA',
           CASE WHEN datalength(T120.f120_notas)=0 then t120.f120_descripcion else T120.f120_notas end as 'descripcion'
           FROM dbo.t120_mc_items AS T120
           INNER JOIN dbo.t121_mc_items_extensiones AS T121
           ON T120.f120_rowid = T121.f121_rowid_item
           INNER JOIN (
                       SELECT  T125.f125_rowid_item AS item, T106.f106_descripcion AS descripcion, T106.f106_id AS idmaquila
                       FROM dbo.t125_mc_items_criterios as T125
                       INNER JOIN dbo.t106_mc_criterios_item_mayores as T106
                       ON T125.f125_id_plan = T106.f106_id_plan and T125.f125_id_criterio_mayor = T106.f106_id and T125.f125_id_plan = '11'
                      ) AS MAQ
           ON T120.f120_rowid = MAQ.item
           WHERE T120.f120_id_cia = 1
           AND T120.f120_id_tipo_inv_serv = 'INVPT001'
           AND T120.f120_referencia not like '%vacia%'
           AND T120.f120_id = '$id'";
    $sql = \DB::connection('sqlsrv')->select($id);
    return $sql;
   }

  public static function InfoMaquilas()
   {
    $id = "SELECT T120.f120_id AS id, MAQ.descripcion AS 'MAQUILA', MAQ.idmaquila AS 'IDMAQUILA',
           CASE WHEN datalength(T120.f120_notas)=0 then t120.f120_descripcion else T120.f120_notas end as 'descripcion'
           FROM dbo.t120_mc_items AS T120
           INNER JOIN dbo.t121_mc_items_extensiones AS T121
           ON T120.f120_rowid = T121.f121_rowid_item
           INNER JOIN (
                       SELECT  T125.f125_rowid_item AS item, T106.f106_descripcion AS descripcion, T106.f106_id AS idmaquila
                       FROM dbo.t125_mc_items_criterios as T125
                       INNER JOIN dbo.t106_mc_criterios_item_mayores as T106
                       ON T125.f125_id_plan = T106.f106_id_plan and T125.f125_id_criterio_mayor = T106.f106_id and T125.f125_id_plan = '11'
                      ) AS MAQ
           ON T120.f120_rowid = MAQ.item
           WHERE T120.f120_id_cia = 1
           AND T120.f120_id_tipo_inv_serv = 'INVPT001'
           AND T120.f120_referencia not like '%vacia%'
           AND T120.f120_ind_manufactura = 1
           AND T120.f120_ind_tipo_item IN (1, 3)
           AND T121.f121_ind_estado = 1
           ORDER BY IDMAQUILA ";
    $sql = \DB::connection('sqlsrv')->select($id);
    return $sql;
   }


  public static function DetMaquila($id)
   {
    $id = "SELECT T120.f120_id AS id, MAQ.descripcion AS 'MAQUILA', MAQ.idmaquila AS 'IDMAQUILA',
           CASE WHEN datalength(T120.f120_notas)=0 then t120.f120_descripcion else T120.f120_notas end as 'descripcion'
           FROM dbo.t120_mc_items AS T120
           INNER JOIN dbo.t121_mc_items_extensiones AS T121
           ON T120.f120_rowid = T121.f121_rowid_item
           INNER JOIN (
                       SELECT  T125.f125_rowid_item AS item, T106.f106_descripcion AS descripcion, T106.f106_id AS idmaquila
                       FROM dbo.t125_mc_items_criterios as T125
                       INNER JOIN dbo.t106_mc_criterios_item_mayores as T106
                       ON T125.f125_id_plan = T106.f106_id_plan and T125.f125_id_criterio_mayor = T106.f106_id and T125.f125_id_plan = '11'
                      ) AS MAQ
           ON T120.f120_rowid = MAQ.item
           WHERE T120.f120_id_cia = 1
           AND T120.f120_id_tipo_inv_serv = 'INVPT001'
           AND T120.f120_referencia not like '%vacia%'
           AND T120.f120_ind_manufactura = 1
           AND T120.f120_ind_tipo_item IN (1, 3)
           AND T121.f121_ind_estado = 1
           AND MAQ.idmaquila = $id
           ORDER BY IDMAQUILA ";
    $sql = \DB::connection('sqlsrv')->select($id);
    return $sql;
   }
 }
