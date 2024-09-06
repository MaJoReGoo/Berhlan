<?php
//SQl Eloquent para conexión con la base de datos

namespace App\Models\Parametrizacion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PanelAreas extends Model
 {
  //Listado de Áreas
  public static function getAreas()
   {
    $sql = \DB::table('param_areas')->orderby('estado','DESC')->orderby('empresa','DESC')->orderby('descripcion','ASC')->get();
    return $sql;
   }

  //Cantidad de áreas activas
  public static function getCantidadAreasActivas()
   {
    $sql = \DB::table('param_areas')->where('estado','1')->count();
    return $sql;
   }

  //Cantidad de áreas inactivas
  public static function getCantidadAreasInactivas()
   {
    $sql = \DB::table('param_areas')->where('estado','0')->count();
    return $sql;
   }

  //Cuenta las áreas con el fin de validar si existe, teniendo en cuenta la empresa
  public static function getAreaUnica($id, $id1)
   {
    $sql = \DB::table('param_areas')->where('descripcion',$id)->where('empresa',$id1)->count();
    return $sql;
   }

  //Cuenta las áreas con el fin de validar si existe, teniendo en cuenta la empresa, y que sea diferente al área enviada
  public static function getAreaUnicaModificar($id, $id1, $id2)
   {
    $sql = \DB::table('param_areas')->where('descripcion',$id)->where('empresa',$id1)->where('id_area','!=',$id2)->count();
    return $sql;
   }

  //Retorna la información del área buscada
  public static function getArea($id)
   {
    $sql = \DB::table('param_areas')->where('id_area',$id)->get();
    return $sql;
   }

  //Ingresa una nueva área
  public static function insertarArea($datos)
   {
    $sql = \DB::table('param_areas')->insert($datos);
    return $sql;
   }

  //Actualiza la información
  public static function actualizarArea($id, $datos)
   {
    $sql = \DB::table('param_areas')->where('id_area', $id)->update($datos);
    return $sql;
   }

  public static function getAreasActivas()
   {
    $sql = \DB::table('param_areas')->where('estado','1')->orderby('descripcion','ASC')->get();
    return $sql;
   }

  //Consulta el ultimo registro insertado
  public static function UltimaArea()
   {
    $sql = \DB::table('param_areas')->select("id_area")->orderby('id_area', 'DESC')->first();
    return $sql;
   }


    //Listado de Áreas
    public static function getAreasNombre($descripcion)
    {
        $sql = \DB::table('param_areas')->where('descripcion', $descripcion)->value('id_area');
        return $sql;
    }
    public static function getAreasEmpre($descripcion)
    {
        $sql = \DB::table('param_empresas')->where('nombre', $descripcion)->value('id_empresa');
        return $sql;
    }

    //Listado de Cargos para comparar
    public static function getAreaNombreSiesa()
    {
        $id = " SELECT REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(
            t107.f107_descripcion ,
            'Á', 'A'),
            'É', 'E'),
            'Í', 'I'),
            'Ó', 'O'),
            'Ú', 'U')
             AS 'Area',
        t107.f107_id as 'id_siesa', t010.f010_razon_social AS 'Empresa'
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
        group by t107.f107_descripcion,t107.f107_id,t010.f010_razon_social;";
        $sql = \DB::connection('sqlsrv')->select($id);
        return collect($sql);
    }

    public static function quitarTildes(){
        DB::statement("UPDATE param_areas SET descripcion = REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(
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
    
    public static function getAreasPorEmpresa($empresa)
    {
        $sql = \DB::table('param_areas')->where('empresa', $empresa)->get();
        return $sql;
    }
 }
