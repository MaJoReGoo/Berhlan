<?php
//SQl Eloquent para conexión con la base de datos

namespace App\Models\Parametrizacion;

use Illuminate\Database\Eloquent\Model;

class PanelEmpresas extends Model
 {
  //Listado de empresas
  public static function getEmpresas()
   {
    $sql = \DB::table('param_empresas')->orderby('estado','DESC')->orderby('nombre','ASC')->get();
    return $sql;
   }

  //Cantidad de empresas activas
  public static function getCantidadEmpresasActivas()
   {
    $sql = \DB::table('param_empresas')->where('estado','1')->count();
    return $sql;
   }

  //Cantidad de empresas inactivas
  public static function getCantidadEmpresasInactivas()
   {
    $sql = \DB::table('param_empresas')->where('estado','0')->count();
    return $sql;
   }

  //Cuenta las empresas con ese NIT, con el fin de validar la existencia de la misma
  public static function getEmpresaNit($id)
   {
    $sql = \DB::table('param_empresas')->where('identificacion',$id)->count();
    return $sql;
   }

  //Cuenta las empresas con ese NIT, con el fin de validar la existencia de la misma, diferente al parámetro dado
  public static function getEmpresaNitModificar($id, $id1)
   {
    $sql = \DB::table('param_empresas')->where('identificacion',$id)->where('id_empresa','!=',$id1)->count();
    return $sql;
   }

  //Cuenta las empresas con ese nombre, con el fin de validar la existencia de la misma
  public static function getEmpresaNombre($id)
   {
    $sql = \DB::table('param_empresas')->where('nombre',$id)->count();
    return $sql;
   }

  //Cuenta las empresas con ese nombre, con el fin de validar la existencia de la misma, diferente al parámetro dado
  public static function getEmpresaNombreModificar($id, $id1)
   {
    $sql = \DB::table('param_empresas')->where('nombre',$id)->where('id_empresa','!=',$id1)->count();
    return $sql;
   }

  //Ingresa una nueva empresa
  public static function insertarEmpresa($datos)
   {
    $sql = \DB::table('param_empresas')->insert($datos);
    return $sql;
   }

  public static function actualizarEmpresa($id,$datos)
   {
    $sql = \DB::table('param_empresas')->where('id_empresa', $id)->update($datos);
    return $sql;
   }

  //Retorna la información de la empresa buscada
  public static function getEmpresa($id)
   {
    $sql = \DB::table('param_empresas')->where('id_empresa',$id)->get();
    return $sql;
   }

  //Listado de empresas activas
  public static function getEmpresasActivas()
   {
    $sql = \DB::table('param_empresas')->where('estado', '1')->orderby('nombre','ASC')->get();
    return $sql;
   }

  //Consulta el ultimo registro insertado
  public static function UltimaEmpresa()
   {
    $sql = \DB::table('param_empresas')->select("id_empresa")->orderby('id_empresa', 'DESC')->first();
    return $sql;
   }
   
   public static function getEmpresasNombre($descripcion)
   {
       $sql = \DB::table('param_empresas')->where('nombre', $descripcion)->value('id_empresa');
       return $sql;
   }

 }
