<?php
//SQl Eloquent para conexión con la base de datos

namespace App\Models\Parametrizacion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PanelCargos extends Model
 {
  //Listado de Cargos
  public static function getCargos()
   {
    $sql = \DB::table('param_cargos')->orderby('estado','DESC')->orderby('descripcion','ASC')->get();
    return $sql;
   }

  //Cantidad de cargos activos
  public static function getCantidadCargosActivos()
   {
    $sql = \DB::table('param_cargos')->where('estado','1')->count();
    return $sql;
   }

  //Cantidad de cargos inactivos
  public static function getCantidadCargosInactivos()
   {
    $sql = \DB::table('param_cargos')->where('estado','0')->count();
    return $sql;
   }

  //Cuenta los cargos con el fin de validar si existe, teniendo en cuenta el área
  public static function getCargoUnico($id, $id1)
   {
    $sql = \DB::table('param_cargos')->where('descripcion',$id)->where('area',$id1)->count();
    return $sql;
   }

  //Cuenta los cargos con el fin de validar si existe, teniendo en cuenta el área, y que sea diferente del cargo enviado
  public static function getCargoUnicoModificar($id, $id1, $id2)
   {
    $sql = \DB::table('param_cargos')->where('descripcion',$id)->where('area',$id1)->where('id_cargo','!=',$id2)->count();
    return $sql;
   }

  //Retorna la información del cargo buscado
  public static function getCargo($id)
   {
    $sql = \DB::table('param_cargos')->where('id_cargo',$id)->get();
    return $sql;
   }

  //Ingresa un nuevo cargo
  public static function insertarCargo($datos)
   {
    $sql = \DB::table('param_cargos')->insert($datos);
    return $sql;
   }

  //Actualiza la información
  public static function actualizarCargo($id,$datos)
   {
    $sql = \DB::table('param_cargos')->where('id_cargo', $id)->update($datos);
    return $sql;
   }

  //Lista los cargos activos
  public static function getCargosActivos()
   {
    $sql = \DB::table('param_cargos')->where('estado','1')->orderby('descripcion','ASC')->get();
    return $sql;
   }

  //Consulta el ultimo registro insertado
  public static function UltimoCargo()
   {
    $sql = \DB::table('param_cargos')->select("id_cargo")->orderby('id_cargo', 'DESC')->first();
    return $sql;
   }

   public static function getCargoNombre($descripcion)
    {
        $sql = \DB::table('param_cargos')->where('descripcion', $descripcion)->first();
        return $sql;
    }

    //Listado cargos desde SIESA
    public static function getCargoNombreSiesa()
    {
        $id = "SELECT REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(
            w0763.c0763_descripcion,
            'Á', 'A'),
            'É', 'E'),
            'Í', 'I'),
            'Ó', 'O'),
            'Ú', 'U')
             AS 'Cargo',
             REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(
            t107.f107_descripcion,
            'Á', 'A'),
            'É', 'E'),
            'Í', 'I'),
            'Ó', 'O'),
            'Ú', 'U')
             AS 'Area',
            t010.f010_razon_social AS 'Empresa'
        FROM dbo.t200_mm_terceros AS t200
        LEFT JOIN dbo.t015_mm_contactos AS t015 ON t200.f200_rowid_contacto = t015.f015_rowid
        LEFT JOIN dbo.t010_mm_companias AS t010 ON t200.f200_id_cia = t010.f010_id
        LEFT JOIN dbo.w0550_contratos AS w0550 ON t200.f200_rowid = w0550.c0550_rowid_tercero
        LEFT JOIN dbo.w0763_gh01_cargos AS w0763 ON w0550.c0550_rowid_cargo = w0763.c0763_rowid
        LEFT JOIN dbo.t107_mc_proyectos AS t107 ON w0550.c0550_id_proyecto = t107.f107_id AND f107_id_cia = t010.f010_id
        JOIN dbo.t285_co_centro_op AS t285 ON w0550.c0550_id_co = t285.f285_id AND f285_id_cia = f107_id_cia
        WHERE t010.f010_id IN ('1', '5', '4') AND f200_ind_empleado = 1 AND f200_ind_estado = 1 AND c0550_ind_estado = 1
        GROUP BY w0763.c0763_descripcion, t107.f107_descripcion, t107.f107_id, t010.f010_razon_social;";
        $sql = \DB::connection('sqlsrv')->select($id);
        return collect($sql);

    }

    public static function quitarTildes(){
        DB::statement("UPDATE param_cargos SET descripcion = REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(
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
