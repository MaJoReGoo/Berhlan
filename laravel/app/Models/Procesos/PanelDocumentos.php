<?php
//SQl Eloquent para conexión con la base de datos

namespace App\Models\Procesos;

use Illuminate\Database\Eloquent\Model;

class PanelDocumentos extends Model
 {
  public static function getDocumentos()
   {
    $sql = \DB::table('proc_documentos')->orderby('fecha1','DESC')->orderby('descripcion','ASC')->get();
    return $sql;
   }

  public static function getDocumentoUnico($id)
   {
    $sql = \DB::table('proc_documentos')->where('descripcion',$id)->count();
    return $sql;
   }

  //Ingresa un nuevo documento
  public static function insertarDocumento($datos)
   {
    $sql = \DB::table('proc_documentos')->insert($datos);
    return $sql;
   }

  //Ingresa el log para los documentos
  public static function insertarDocumentoLog($datos)
   {
    $sql = \DB::table('proc_documentos_log')->insert($datos);
    return $sql;
   }

  //Consulta el ultimo registro insertado
  public static function UltimoDocumento()
   {
    $sql = \DB::table('proc_documentos')->select("id_documento")->orderby('id_documento', 'DESC')->first();
    return $sql;
   }

  //Envía información del documento
  public static function getDocumento($id)
   {
    $sql = \DB::table('proc_documentos')->where('id_documento',$id)->get();
    return $sql;
   }

  public static function getDocumentoLogs($id)
   {
    $sql = \DB::table('proc_documentos_log')->where('documento', $id)->orderby('fecha','DESC')->get();
    return $sql;
   }

  //Para validación del documento que no se repita con la descripción como parámetro
  public static function getDocumentoUnicoMod($id, $id1)
   {
    $sql = \DB::table('proc_documentos')->where('id_documento','!=',$id)->where('descripcion',$id1)->count();
    return $sql;
   }

  //Actualizo la información del documento
  public static function actualizarDocumento($id, $datos)
   {
    $sql = \DB::table('proc_documentos')->where('id_documento', $id)->update($datos);
    return $sql;
   }

  public static function BorrarDocuSubProce($id)
   {
    $sql = \DB::table('proc_subproc_docu')->where('documento', $id)->delete();
    return $sql;
   }

  public static function BorrarDocumentoLog($id)
   {
    $sql = \DB::table('proc_documentos_log')->where('documento', $id)->delete();
    return $sql;
   }

  public static function BorrarDocuPerfiles($id)
   {
    $sql = \DB::table('proc_docu_perf')->where('documento', $id)->delete();
    return $sql;
   }

  public static function BorrarDocumento($id)
   {
    $sql = \DB::table('proc_documentos')->where('id_documento', $id)->delete();
    return $sql;
   }

  //Retorna los documentos asociados al subproceso a partir del subproceso
  public static function getDocumentosSubProceso($id)
   {
    $sql = \DB::table('proc_documentos')->whereIn('id_documento',
    function($query) use ($id)
     {
      $query->select('documento')->from('proc_subproc_docu')->where('subproceso', $id);
     }
    )->orderby('descripcion','ASC')->get();
    return $sql;
   }

  //Retorna los documentos asociados al subproceso a partir del subproceso
  public static function getDocumentosSubProcesoTipo($sub, $tip)
   {
    $sql = \DB::table('proc_documentos')->where('tipo', $tip)->whereIn('id_documento',
    function($query) use ($sub)
     {
      $query->select('documento')->from('proc_subproc_docu')->where('subproceso', $sub);
     }
    )->orderby('descripcion','ASC')->get();
    return $sql;
   }


  //Retorna el numero de veces que aparece el documento asociado a perfiles
  public static function getDocumentoPerfiles($id)
   {
    $sql = \DB::table('proc_docu_asignacion')->where('documento', $id)->count();
    return $sql;
   }

  //Retorna la cantidad de veces que aparece el usuario en los perfiles asociados al documento
  public static function getDocumentoPerfilesAcceso($doc, $usr)
   {
    $sql = \DB::table('proc_docu_asignacion')->where('documento', $doc)->whereIn('perfil',
    function($query) use ($usr)
     {
      $query->select('perfil')->from('proc_perfiles_usuarios')->where('usuario', $usr);
     }
    )->count();
    return $sql;
   }

   public static function getDocumentosUsuarioAcceso($doc, $usr){
    $sql = \DB::table('proc_docu_asignacion')->where('documento',$doc)->where('usuario',$usr)->count();
    return $sql;
   }

   public static function BorrarDocuPerfilesUsuarios($id)
   {
    $sql = \DB::table('proc_docu_asignacion')->where('documento', $id)->delete();
    return $sql;
   }

   public static function getDocumentosSubProcesoVariosTipo($sub, $tip)
   {
    $sql = \DB::table('proc_documentos')->whereIn('tipo', $tip)->whereIn('id_documento',
    function($query) use ($sub)
     {
      $query->select('documento')->from('proc_subproc_docu')->where('subproceso', $sub);
     }
    )->orderby('descripcion','ASC')->get();
    return $sql;
   }

 }
