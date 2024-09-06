<?php
/*
Controlador de la tabla proc_subproc_docu
Usa SQl Eloquent del archivo app\Models\Procesos\PanelSubProceDocu.php
*/

namespace App\Http\Controllers\Procesos;
use App\Http\Controllers\Controller;
use App\Models\PanelLogin;
use App\Models\Procesos\PanelMacroProcesos;
use App\Models\Procesos\PanelSubProcesos;
use App\Models\Procesos\PanelSubProceDocu;
use Illuminate\Support\Facades\Session;
use Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class SubDocProcesosPanelController extends Controller
 {
  public function SubProDocumeListado()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "procesos/subprodocume";
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

      $DatosMacroProcesos = PanelMacroProcesos::getMacroProcesos();
      return view('procesos.panel-subProDocume')->with('DatosUsuario',$DatosUsuario)->with('DatosMacroProcesos',$DatosMacroProcesos);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function SubProDocumeAsociar($id)
   {
    if(Session::has('user'))
     {
      $idSubProceso    = $id;
      $DatosSubProceso = PanelSubProcesos::getSubProceso($idSubProceso);
      $user            = Session::get('user');
      $DatosUsuario    = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "procesos/subprodocume";
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

      return view('procesos.panel-subProDocumeAsociar')->with('DatosUsuario',$DatosUsuario)->with('DatosSubProceso',$DatosSubProceso);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }

  public function SubProDocumeAsociarDB()
   {
    if(Session::has('user'))
     {
      $formData      = Request::all();
      $login         = $formData['login'];
      $id_subproceso = $formData['id_subproceso'];
      $documento     = $formData['documento'];

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
        $Mensaje     = "Asociación realizada.";
       }

      $Redireccion = "/panel/procesos/subprodocume/asociar/".$id_subproceso;
      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  //Esta función es llamada en 2 vistas, cambia la ruta de direccionamiento
  public function SubProDocumeDesasociarDB()
   {
    if(Session::has('user'))
     {
      $formData      = Request::all();
      $login         = $formData['login'];
      $id_subproceso = $formData['subproceso'];
      $documento     = $formData['documento'];
      $ruta          = $formData['ruta'];

      PanelSubProceDocu::borrarSubDoc($id_subproceso, $documento);

      $Mensaje     = "Desasociación realizada.";
      $Redireccion = "/panel/procesos/".$ruta;
      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }
 }