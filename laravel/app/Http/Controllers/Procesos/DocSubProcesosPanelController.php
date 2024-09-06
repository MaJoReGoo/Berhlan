<?php
/*
Controlador de la tabla proc_subproc_docu
Usa SQl Eloquent del archivo app\Models\Procesos\PanelSubProceDocu.php
*/

namespace App\Http\Controllers\Procesos;
use App\Http\Controllers\Controller;
use App\Models\PanelLogin;
use App\Models\Procesos\PanelDocumentos;
use App\Models\Procesos\PanelSubProceDocu;
use Illuminate\Support\Facades\Session;
use Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class DocSubProcesosPanelController extends Controller
 {
  public function DocumeSubProListado()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "procesos/documesubpro";
        $DatosMenu = PanelLogin::getMenuRuta($ruta);
        if($DatosMenu[0]->libre_acceso == 0)  //Si el modulo no es de libre acceso
         {
          $idmenu    = $DatosMenu[0]->id_menu;

          $ModUser    = explode(',',$DatosUsuario[0]->modulos);
          $NumModUser = count($ModUser);
          $acceso     = 0;
          for($i=0; $i<$NumModUser; $i++)
           {
            if($idmenu == $ModUser[$i])
             {
              $acceso = 1;
              break;
             }
           }

          if($acceso == 0) //El usuario no tiene acceso al modulo
           {
            $ErrorValidacion = "Usted no tiene acceso al módulo.";
            return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
           }
         }
       }
      //Termina validación

      $DatosDocumentos = PanelDocumentos::getDocumentos();
      return view('procesos.panel-documeSubPro')->with('DatosUsuario',$DatosUsuario)->with('DatosDocumentos',$DatosDocumentos);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function DocumeSubProAsociar($id)
   {
    if(Session::has('user'))
     {
      $Documento      = $id;
      $DatosDocumento = PanelDocumentos::getDocumento($Documento);
      $user            = Session::get('user');
      $DatosUsuario    = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "procesos/documesubpro";
        $DatosMenu = PanelLogin::getMenuRuta($ruta);
        if($DatosMenu[0]->libre_acceso == 0)  //Si el modulo no es de libre acceso
         {
          $idmenu    = $DatosMenu[0]->id_menu;

          $ModUser    = explode(',',$DatosUsuario[0]->modulos);
          $NumModUser = count($ModUser);
          $acceso     = 0;
          for($i=0; $i<$NumModUser; $i++)
           {
            if($idmenu == $ModUser[$i])
             {
              $acceso = 1;
              break;
             }
           }

          if($acceso == 0) //El usuario no tiene acceso al modulo
           {
            $ErrorValidacion = "Usted no tiene acceso al módulo.";
            return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
           }
         }
       }
      //Termina validación

      return view('procesos.panel-documeSubProAsociar')->with('DatosUsuario',$DatosUsuario)->with('DatosDocumento',$DatosDocumento);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function DocumeSubProAsociarDB()
   {
    if(Session::has('user'))
     {
      $formData      = Request::all();
      $login         = $formData['login'];
      $id_subproceso = $formData['subproceso'];
      $documento     = $formData['id_documento'];

      $datos = array();

      //Realizo las validaciones
      $Mensaje = "";

      $DocumentoDuplicado = PanelSubProceDocu::getSubDocUnico($id_subproceso, $documento);

      if($DocumentoDuplicado != 0)
        $Mensaje = "Documento ya se encuentra asociado al subproceso.";

      if($Mensaje == "")
       {
        $datos['documento']  = $documento;
        $datos['subproceso'] = $id_subproceso;

        PanelSubProceDocu::insertarSubDoc($datos);
        $Mensaje = "Asociación realizada.";
       }

      $Redireccion = "/panel/procesos/documesubpro/asociar/".$documento;
      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }
 }