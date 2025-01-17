<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PanelLogin extends Model
{
  //Verifica si el login existe
  public static function getUsuarioExiste($id)
  {
    $sql = DB::table('param_usuarios')->where('login', $id)->count();
    return $sql;
  }

  //Retorna la información del usuario con el login enviado como parámetro
  public static function getUsuario($id)
  {
    $sql = DB::table('param_usuarios')->where('login', $id)->get();
    return $sql;
  }

  //Retorna la información de todos los módulos del menú según el padre para tipo master
  public static function getMenuT($padre)
  {
    $sql = DB::table('soft_menu')->where('padre', $padre)->where('estado', '1')->orderby('posicion', 'ASC')->get();
    return $sql;
  }

  public static function getMenu($modulos, $padre)
  {
    $sql = DB::select("SELECT * FROM soft_menu WHERE padre = $padre AND estado = '1' AND (id_menu IN ($modulos) OR libre_acceso = 1) ORDER BY posicion ASC");
    return $sql;
  }

  public static function getMenuInfo($id)
  {
    $sql = DB::table('soft_menu')->where('id_menu', $id)->get();
    return $sql;
  }

  public static function getMenuRuta($id)
  {
    $sql = DB::table('soft_menu')->where('url', $id)->get();
    return $sql;
  }

  public static function insertarLog($datos)
  {
    $sql = DB::table('soft_log')->insert($datos);
    return $sql;
  }

  public static function actualizarLogin($id, $datos)
  {
    $sql = DB::table('param_usuarios')->where('id_usuario', $id)->update($datos);
    return $sql;
  }

  public static function getUsuarioEmpleado($id)
  {
    $sql = DB::table('param_usuarios')->where('empleado', $id)->get();
    return $sql;
  }
  public static function getUsuarioEmpleadoCant($id)
  {
    $sql = DB::table('param_usuarios')->where('empleado', $id)->count();
    return $sql;
  }
}
