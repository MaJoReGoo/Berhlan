<?php
/*
Controlador de la tabla requ_solicitud
Usa SQl Eloquent del archivo app\Models\Requerimientos\PanelSolicitudes.php
*/

namespace App\Http\Controllers\Requerimientos;
use App\Http\Controllers\Controller;
use App\Models\PanelLogin;
use App\Models\Requerimientos\PanelSolicitudes;
use App\Models\Requerimientos\PanelGrupos;
use Illuminate\Support\Facades\Session;
use Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class ReintegroRequerimientosPanelController extends Controller
 {
  public function Reintegro()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "requerimientos/reintegro";
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

      //Valido a categorías puede tener acceso
      if($DatosUsuario[0]->master == 1)
        $DatosGrupos = PanelGrupos::getGruposActivos();
      else
        $DatosGrupos = PanelGrupos::getGruposActivosEmpleado($DatosUsuario[0]->empleado);

      return view('requerimientos.panel-reintegro')->with('DatosUsuario',$DatosUsuario)->with('DatosGrupos',$DatosGrupos);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function ReintegroListado($id)
   {
    if(Session::has('user'))
     {
      $Grupo        = $id;
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "requerimientos/reintegro";
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

      //Valido que tenga acceso a las categorías del grupo seleccionado
      if($DatosUsuario[0]->master == 0)
       {
        $AccesoGrupo = PanelGrupos::getEmpleadoUnico($Grupo, $DatosUsuario[0]->empleado);
        if($AccesoGrupo == 0) //El usuario no tiene acceso al grupo
         {
          $ErrorValidacion = "Usted no tiene acceso al grupo seleccionado.";
          return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
         }
       }

      $DatosSolicitudes = PanelSolicitudes::SolicitudesReintegroGrupo($Grupo);

      return view('requerimientos.panel-reintegroListado')->with('DatosUsuario',$DatosUsuario)->with('DatosSolicitudes',$DatosSolicitudes)->with('Grupo',$Grupo);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function ReintegroFinalizar($id)
   {
    if(Session::has('user'))
     {
      $Solicitud      = $id;
      $DatosSolicitud = PanelSolicitudes::getSolicitud($Solicitud);
      $user           = Session::get('user');
      $DatosUsuario   = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "requerimientos/atender";
        $DatosMenu = PanelLogin::getMenuRuta($ruta);
        if($DatosMenu[0]->libre_acceso == 0)  // Si el modulo no es de libre acceso
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
            $ErrorValidacion = "Usted no esta tiene acceso al módulo.";
            return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
           }
         }
       }
      //Termina validación

      if($DatosUsuario[0]->master == 0)
       {
        $AccesoGrupo = PanelGrupos::getEmpleadoUnico($DatosSolicitud[0]->grupo, $DatosUsuario[0]->empleado);
        if($AccesoGrupo == 0) //El usuario no tiene acceso al grupo
         {
          $ErrorValidacion = "Usted no tiene acceso al grupo seleccionado.";
          return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
         }
       }

      //Valido que la solicitud aun se encuentre en estado pendiente de revisión nomina
      if($DatosSolicitud[0]->reintegro != 1)
       {
        $Mensaje     = "Requerimiento ya no se encuentra pendiente por reintegro.";
        $Redireccion = "/panel/requerimientos/reintegro";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }
      else
       {
        return view('requerimientos.panel-reintegroFinalizar')->with('DatosUsuario',$DatosUsuario)->with('DatosSolicitud',$DatosSolicitud);
       }
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function ReintegroFinalizarDB()
   {
    if(Session::has('user'))
     {
      $formData     = Request::all();
      $solicitud    = $formData['solicitud'];
      $fecha        = $formData['fecha'];
      $descripcion  = trim($formData['descripcion']);
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      $datos = array();

      //Realizo las validaciones
      $Mensaje = "";

      if($fecha == "")
        $Mensaje = "Debe ingresar la fecha de entrega.";

      if($Mensaje == "")
       {
        $datos['reintegro']       = 2;
        $datos['fecha_reintegro'] = $fecha;
        $datos['usr_reintegro']   = $DatosUsuario[0]->empleado;
        $datos['obs_reintegro']   = $descripcion;

        PanelSolicitudes::actualizarSolicitud($solicitud, $datos);

        $Mensaje = "Reintegro ingresado.";
       }

      $Redireccion = "/panel/requerimientos/reintegro";
      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }
  }