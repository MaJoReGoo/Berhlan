<?php
//SQl Eloquent para conexión con la base de datos

namespace App\Models\Parametrizacion;

use Illuminate\Database\Eloquent\Model;

class PanelCiudades extends Model
 {
  //Listado de ciudades
  public static function getCiudades()
   {
    $sql = \DB::table('param_ciudades')->orderby('estado','DESC')->orderby('nom_depto','ASC')->orderby('nom_ciudad','ASC')->get();
    return $sql;
   }

  //Cantidad de ciudades activas
  public static function getCantidadCiudadesActivas()
   {
    $sql = \DB::table('param_ciudades')->where('estado','1')->count();
    return $sql;
   }

  //Cantidad de ciudades inactivas
  public static function getCantidadCiudadesInactivas()
   {
    $sql = \DB::table('param_ciudades')->where('estado','0')->count();
    return $sql;
   }

  //Cuenta las ciudades con el fin de validar si existe, teniendo en cuenta el código
  public static function getCiudadUnicaCodigo($id)
   {
    $sql = \DB::table('param_ciudades')->where('codigo',$id)->count();
    return $sql;
   }

  //Cuenta las ciudades con el fin de validar si existe, teniendo en cuenta depto y nombre
  public static function getCiudadUnicaNombre($id, $id1)
   {
    $sql = \DB::table('param_ciudades')->where('nom_depto',$id)->where('nom_ciudad',$id1)->count();
    return $sql;
   }

  //Ingresa una nueva ciudad
  public static function insertarCiudad($datos)
   {
    $sql = \DB::table('param_ciudades')->insert($datos);
    return $sql;
   }

  //Cuenta las ciudades con el fin de validar si existe, teniendo en cuenta el código y que no sea la misma ciudad a editar
  public static function getCiudadUnicaCodigoModificar($id, $id1)
   {
    $sql = \DB::table('param_ciudades')->where('codigo',$id)->where('id_ciudad','!=', $id1)->count();
    return $sql;
   }

  //Cuenta las ciudades con el fin de validar si existe, teniendo en cuenta depto y nombre y que no sea la misma ciudad a editar
  public static function getCiudadUnicaNombreModificar($id, $id1, $id2)
   {
    $sql = \DB::table('param_ciudades')->where('nom_depto',$id)->where('nom_ciudad',$id1)->where('id_ciudad','!=', $id2)->count();
    return $sql;
   }

  public static function actualizarCiudad($id,$datos)
   {
    $sql = \DB::table('param_ciudades')->where('id_ciudad', $id)->update($datos);
    return $sql;
   }

  //Realiza la búsqueda de las ciudades activas
  public static function getCiudadesActivas()
   {
    $sql = \DB::table('param_ciudades')->where('estado','1')->orderby('nom_depto','ASC')->orderby('nom_ciudad','ASC')->get();
    return $sql;
   }

  //Retorna la información de la ciudad buscada
  public static function getCiudad($id)
   {
    $sql = \DB::table('param_ciudades')->where('id_ciudad',$id)->get();
    return $sql;
   }

  //Consulta el ultimo registro insertado
  public static function UltimaCiudad()
   {
    $sql = \DB::table('param_ciudades')->select("id_ciudad")->orderby('id_ciudad', 'DESC')->first();
    return $sql;
   }
 }
