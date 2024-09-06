<?php
//SQl Eloquent para conexión con la base de datos

namespace App\Models\Procesos;

use Illuminate\Database\Eloquent\Model;

class PanelPerfiles extends Model
 {
  //Listado de perfiles
  public static function getPerfiles()
   {
    $sql = \DB::table('proc_perfiles')->orderby('descripcion','ASC')->get();
    return $sql;
   }

  //Retorna el listado de usuarios que pertenecen al perfil
  public static function getUsuariosPerfil($id)
   {
    $sql = \DB::table('param_usuarios')->join('param_empleados','param_empleados.id_empleado','=','param_usuarios.empleado')->whereIn('id_usuario',
    function($query) use ($id)
     {
      $query->select('usuario')->from('proc_perfiles_usuarios')->where('perfil', $id);
     }
    )->orderby('login','ASC')->get();
    return $sql;
   }

  public static function getPerfilUnico($id)
   {
    $sql = \DB::table('proc_perfiles')->where('descripcion',$id)->count();
    return $sql;
   }

  public static function insertarPerfil($datos)
   {
    $sql = \DB::table('proc_perfiles')->insert($datos);
    return $sql;
   }

  public static function getPerfil($id)
   {
    $sql = \DB::table('proc_perfiles')->where('id_perfil',$id)->get();
    return $sql;
   }

  public static function getPerfilUnicoMod($per, $des)
   {
    $sql = \DB::table('proc_perfiles')->where('id_perfil','!=', $per)->where('descripcion',$des)->count();
    return $sql;
   }

  public static function actualizarPerfil($id, $datos)
   {
    $sql = \DB::table('proc_perfiles')->where('id_perfil',$id)->update($datos);
    return $sql;
   }

  public static function BorrarPerUsuProce($id)
   {
    $sql = \DB::table('proc_perfiles_usuarios')->where('perfil', $id)->delete();
    return $sql;
   }

  public static function BorrarPerfilDocu($id)
   {
    $sql = \DB::table('proc_docu_perf')->where('perfil', $id)->delete();
    return $sql;
   }

  public static function BorrarPerfil($id)
   {
    $sql = \DB::table('proc_perfiles')->where('id_perfil', $id)->delete();
    return $sql;
   }

  public static function RetirarUsuarioPerfil($per, $usr)
   {
    $sql = \DB::table('proc_perfiles_usuarios')->where('perfil', $per)->where('usuario', $usr)->delete();
    return $sql;
   }

  public static function getPerfilUsuarioUnico($per, $usr)
   {
    $sql = \DB::table('proc_perfiles_usuarios')->where('perfil', $per)->where('usuario', $usr)->count();
    return $sql;
   }

  public static function insertarUsuarioPerfil($datos)
   {
    $sql = \DB::table('proc_perfiles_usuarios')->insert($datos);
    return $sql;
   }

  public static function getDocumentosPerfil($id)
   {
    $sql = \DB::table('proc_perfiles')->whereIn('id_perfil',
    function($query) use ($id)
     {
      $query->select('perfil')->from('proc_docu_asignacion')->where('documento', $id);
     }
    )->orderby('descripcion','ASC')->get();
    return $sql;
   }

  public static function getDocPerUnico($doc, $per)
   {
    $sql = \DB::table('proc_docu_perf')->where('documento', $doc)->where('perfil', $per)->count();
    return $sql;
   }

  public static function insertarDocPer($datos)
   {
    $sql = \DB::table('proc_docu_perf')->insert($datos);
    return $sql;
   }

  public static function BorrarDocPer($doc, $per)
   {
    $sql = \DB::table('proc_docu_perf')->where('documento', $doc)->where('perfil', $per)->delete();
    return $sql;
   }

   public static function insertarDocPerUsr($datos)
   {
    $sql = \DB::table('proc_docu_asignacion')->insert($datos);
    return $sql;
   }

   public static function getDocumentosUsuario($id)
   {
    $sql = \DB::table('param_usuarios')->whereIn('id_usuario',
    function($query) use ($id)
     {
      $query->select('usuario')->from('proc_docu_asignacion')->where('documento', $id);
     }
    )->get();
    return $sql;
   }

   public static function BorrarDocPerUsr($doc, $per, $usr)
   {
    $sql = \DB::table('proc_docu_asignacion')->where('documento', $doc)->where('perfil', $per)->orwhere('usuario',$usr)->delete();
    return $sql;
   }

 }
