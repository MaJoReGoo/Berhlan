<?php
//SQl Eloquent para conexión con la base de datos

namespace App\Models\ArchivoPlano;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PanelArchivoPlano extends Model
{

   public static function insertarArchivoPlano($datos)
   {
      $sql = DB::table('archivo_plano')->insert($datos);
      return $sql;
   }

   public static function actualizarArchivoPlano($id, $datos)
   {
      $sql = DB::table('archivo_plano')->where('id', $id)->update($datos);
      return $sql;
   }

   public static function getArchivoPlano($id)
   {
      $sql = DB::table('archivo_plano')->where('id', $id)->get();
      return $sql;
   }

   public static function getArchivoPlanoLista()
   {
      $sql = DB::table('archivo_plano')->orderby('consecutivo', 'DESC')->paginate(25);
      return $sql;
   }

   public static function getArchivoPlanoListaEstado($estado)
   {
      $sql = DB::table('archivo_plano')->where('estado', $estado)->orderby('consecutivo', 'DESC')->paginate(25);
      return $sql;
   }

   public static function deleteArchivoPlano($id)
   {
      $sql = DB::table('archivo_plano')->where('id', $id)->delete();
      return $sql;
   }

   public static function getUltimoArchivoPlano()
   {
      $sql = DB::table('archivo_plano')->orderby('id', 'DESC')->take(1)->get();
      return $sql;
   }

   public static function getCantArchivoPlano()
   {
      $sql = DB::table('archivo_plano')->count();
      return $sql;
   }

   public static function getCantArchivoPlanoExp()
   {
      $sql = DB::table('archivo_plano')->where('estado', 2)->count();
      return $sql;
   }
}
