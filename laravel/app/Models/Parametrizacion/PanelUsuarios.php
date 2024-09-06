<?php
//SQl Eloquent para conexión con la base de datos

namespace App\Models\Parametrizacion;

use Illuminate\Database\Eloquent\Model;

class PanelUsuarios extends Model
 {
  //Listado de usuarios
  public static function getUsuarios()
   {
    $sql = \DB::table('param_usuarios')->orderby('estado','DESC')->orderby('login','ASC')->get();
    return $sql;
   }

  //Cantidad de usuarios activos
  public static function getCantidadUsuariosActivos()
   {
    $sql = \DB::table('param_usuarios')->where('estado','1')->count();
    return $sql;
   }

  //Cantidad de usuarios inactivos
  public static function getCantidadUsuariosInactivos()
   {
    $sql = \DB::table('param_usuarios')->where('estado','0')->count();
    return $sql;
   }

  //Cuenta los usuarios con el fin de validar si existe, teniendo en cuenta el login
  public static function getUsuarioLoginUnico($id)
   {
    $sql = \DB::table('param_usuarios')->where('login',$id)->count();
    return $sql;
   }

  //Cuenta los usuarios con el fin de validar si existe, teniendo en cuenta el empleado
  public static function getUsuarioEmpleadoUnico($id)
   {
    $sql = \DB::table('param_usuarios')->where('empleado',$id)->count();
    return $sql;
   }

  //Ingresa un nuevo usuario
  public static function insertarUsuario($datos)
   {
    $sql = \DB::table('param_usuarios')->insert($datos);
    return $sql;
   }

  //Retorna la información del usuario buscado
  public static function getUsuario($id)
   {
    $sql = \DB::table('param_usuarios')->where('id_usuario',$id)->get();
    return $sql;
   }

  public static function getUsuarioLoginUnicoModificar($id, $id1)
   {
    $sql = \DB::table('param_usuarios')->where('login',$id)->where('id_usuario','!=',$id1)->count();
    return $sql;
   }

  public static function actualizarUsuario($id, $datos)
   {
    $sql = \DB::table('param_usuarios')->where('id_usuario', $id)->update($datos);
    return $sql;
   }

  //Actualizar el usuario a partir del empleado
  public static function actualizarUsuarioEmp($id, $datos)
   {
    $sql = \DB::table('param_usuarios')->where('empleado', $id)->update($datos);
    return $sql;
   }

  //Listado de usuarios activos
  public static function getUsuariosActivos()
   {
    $sql = \DB::table('param_usuarios')->where('estado','1')->orderby('login','ASC')->get();
    return $sql;
   }

  //Listado del accesos al programa
  public static function getAccesos($id)
   {
    $sql = \DB::table('soft_menu')->where('padre',$id)->where('estado','1')->orderby('nombre','ASC')->get();
    return $sql;
   }

  //Consulta el ultimo registro insertado
  public static function UltimoUsuario()
   {
    $sql = \DB::table('param_usuarios')->select("id_usuario")->orderby('id_usuario', 'DESC')->first();
    return $sql;
   }

  //Valida si el empleado tiene usuario creado
  public static function UsuarioEmp($id)
   {
    $sql = \DB::table('param_usuarios')->where('empleado', $id)->count();
    return $sql;
   }
 }