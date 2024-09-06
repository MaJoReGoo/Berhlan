<?php
//SQl Eloquent para conexión con la base de datos

namespace App\Models\Parametrizacion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PanelCentrosOp extends Model
 {
  //Listado de centros de operación
  public static function getCentrosOp()
   {
    $sql = \DB::table('param_centros')->orderby('estado','DESC')->orderby('descripcion','ASC')->get();
    return $sql;
   }

  //Cantidad de centros activos
  public static function getCantidadCentrosOpActivos()
   {
    $sql = \DB::table('param_centros')->where('estado','1')->count();
    return $sql;
   }

  //Cantidad de centros inactivos
  public static function getCantidadCentrosOpInactivos()
   {
    $sql = \DB::table('param_centros')->where('estado','0')->count();
    return $sql;
   }

  //Cuenta los centros con el fin de validar si existe, teniendo en cuenta la descripcion
  public static function getCentroOpUnico($id)
   {
    $sql = \DB::table('param_centros')->where('descripcion',$id)->count();
    return $sql;
   }

  //Ingresa un nuevo centro de operación
  public static function insertarCentroOp($datos)
   {
    $sql = \DB::table('param_centros')->insert($datos);
    return $sql;
   }

  //Retorna la información del centro de operación buscado
  public static function getCentroOp($id)
   {
    $sql = \DB::table('param_centros')->where('id_centro',$id)->get();
    return $sql;
   }

  //Cuenta los centros con el fin de validar si existe, teniendo en cuenta la descripción, diferente al que se esta editando
  public static function getCentroOpUnicoModificar($id, $id1)
   {
    $sql = \DB::table('param_centros')->where('descripcion',$id)->where('id_centro','!=',$id1)->count();
    return $sql;
   }

  public static function actualizarCentroOp($id,$datos)
   {
    $sql = \DB::table('param_centros')->where('id_centro', $id)->update($datos);
    return $sql;
   }

  //Listado de centros de operación activos
  public static function getCentrosOpActivos()
   {
    $sql = \DB::table('param_centros')->where('estado','1')->orderby('descripcion','ASC')->get();
    return $sql;
   }

  //Consulta el ultimo registro insertado
  public static function UltimoCentro()
   {
    $sql = \DB::table('param_centros')->select("id_centro")->orderby('id_centro', 'DESC')->first();
    return $sql;
   }

   public static function getCentroNombre($descripcion)
   {
    $sql = \DB::table('param_centros')->where('descripcion', $descripcion)->first();
    return $sql;
   }
   public static function getCentrosSiesa()
   {
       $id = "SELECT REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(
        t285.f285_descripcion,
        'Á', 'A'),
        'É', 'E'),
        'Í', 'I'),
        'Ó', 'O'),
        'Ú', 'U')
         AS 'CentroDes'
       FROM dbo.t200_mm_terceros AS t200
       LEFT JOIN dbo.t015_mm_contactos AS t015
       ON t200.f200_rowid_contacto = t015.f015_rowid
       LEFT JOIN dbo.t010_mm_companias AS t010
       ON t200.f200_id_cia = t010.f010_id
       LEFT JOIN dbo.w0550_contratos AS w0550
       ON t200.f200_rowid = w0550.c0550_rowid_tercero
       LEFT JOIN dbo.w0763_gh01_cargos AS w0763
       ON w0550.c0550_rowid_cargo = w0763.c0763_rowid
       LEFT JOIN dbo.t107_mc_proyectos AS t107
       ON w0550.c0550_id_proyecto = t107.f107_id AND f107_id_cia=t010.f010_id
       JOIN dbo.t285_co_centro_op AS t285
       ON w0550.c0550_id_co = t285.f285_id AND f285_id_cia = f107_id_cia
       WHERE  t010.f010_id IN ('1','5','4') AND f200_ind_empleado = 1 AND f200_ind_estado = 1 AND c0550_ind_estado = 1
       group by t285.f285_descripcion";
       $sql = \DB::connection('sqlsrv')->select($id);
       return collect($sql);
   }

   public static function quitarTildes(){
    DB::statement("UPDATE param_centros SET descripcion = REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(
        descripcion,
        'á', 'a'),
        'é', 'e'),
        'í', 'i'),
        'ó', 'o'),
        'ú', 'u'),
        'Á', 'A'),
        'É', 'E'),
        'Í', 'I'),
        'Ó', 'O'),
        'Ú', 'U');");

}
 }
