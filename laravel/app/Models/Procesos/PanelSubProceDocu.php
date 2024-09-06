<?php
//SQl Eloquent para conexión con la base de datos

namespace App\Models\Procesos;

use Illuminate\Database\Eloquent\Model;

class PanelSubProceDocu extends Model
 {
  public static function BorrarSubProceDocu($id)
   {
    $sql = \DB::table('proc_subproc_docu')->where('subproceso', $id)->delete();
    return $sql;
   }

  //Valida la cantidad de documentos asociados al subproceso
  public static function getSubDocUnico($sub, $doc)
   {
    $sql = \DB::table('proc_subproc_docu')->where('subproceso', $sub)->where('documento', $doc)->count();
    return $sql;
   }

  //Inserta la asociación entre el subproceso y el documento
  public static function insertarSubDoc($datos)
   {
    $sql = \DB::table('proc_subproc_docu')->insert($datos);
    return $sql;
   }

  //Desasocia un documento con un subproceso
  public static function borrarSubDoc($sub, $doc)
   {
    $sql = \DB::table('proc_subproc_docu')->where('subproceso', $sub)->where('documento', $doc)->delete();
    return $sql;
   }

  //Retorna los subprocesos asociados al documento a partir del documento
  public static function getSubProDocumen($doc)
   {
    $sql = \DB::table('proc_subprocesos')->whereIn('id_subproceso',
    function($query) use ($doc)
     {
      $query->select('subproceso')->from('proc_subproc_docu')->where('documento', $doc);
     }
    )->orderby('descripcion','ASC')->get();
    return $sql;
   }
 }