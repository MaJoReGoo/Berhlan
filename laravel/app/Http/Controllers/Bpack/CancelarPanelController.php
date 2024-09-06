<?php
/*
Controlador de la tabla bpac_solicitudan
Usa SQl Eloquent de los archivos
app\Models\Bpack\PanelSolicitudesAN.php
*/

namespace App\Http\Controllers\Bpack;
use App\Http\Controllers\Controller;
use App\Models\Bpack\PanelSolicitudesAN;
use App\Models\PanelLogin;
use Illuminate\Support\Facades\Session;
use Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class CancelarPanelController extends Controller
 {
  public function PendientesSolicitudes()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "bpack/cancelarsol";
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

      $PendientesSol = PanelSolicitudesAN::PendientesSol();
      return view('bpack.panel-pendientesCancelar')->with('DatosUsuario',$DatosUsuario)->with('PendientesSol',$PendientesSol);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function PendientesSolicitudesProcesar($id)
   {
    if(Session::has('user'))
     {
      $Solicitud      = $id;
      $DatosSolicitud = PanelSolicitudesAN::SolicitudAN($Solicitud);
      $user           = Session::get('user');
      $DatosUsuario   = PanelLogin::getUsuario($user);

      $e = 0;
      $i = 0;
      foreach($DatosSolicitud as $DatSol)
       {
        $e++;
        if(($DatSol->estado == 8) || ($DatSol->estado == 9))
          $i++;
       }

      if($e == 0)
       {
        $Mensaje     = "Esta solicitud no existe.";
        $Redireccion = "/panel/bpack/cancelarsol";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }

      if($i != 0)
       {
        $Mensaje     = "Esta solicitud ya esta finalizada.";
        $Redireccion = "/panel/bpack/cancelarsol";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "bpack/cancelarsol";
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

      return view('bpack.panel-pendientesCancelarProcesar')->with('DatosUsuario',$DatosUsuario)->with('DatosSolicitud',$DatosSolicitud);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function PendientesSolicitudesProcesarDB()
   {
    if(Session::has('user'))
     {
      $formData      = Request::all();
      $solicitud     = $formData['solicitud'];
      $motivo        = $formData['motivo'];
      $observaciones = $formData['observaciones'];
      $user          = Session::get('user');
      $DatosUsuario  = PanelLogin::getUsuario($user);

      $e = 0;
      $i = 0;
      $DatosSolicitud = PanelSolicitudesAN::SolicitudAN($solicitud);
      foreach($DatosSolicitud as $DatSol)
       {
        $e++;
        if(($DatSol->estado == 8) || ($DatSol->estado == 9))
          $i++;
       }

      if($e == 0)
       {
        $Mensaje     = "Esta solicitud no existe.";
        $Redireccion = "/panel/bpack/cancelarsol";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }

      if($i != 0)
       {
        $Mensaje     = "Esta solicitud ya esta finalizada.";
        $Redireccion = "/panel/bpack/cancelarsol";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }

      $datos           = array();
      $datos['estado'] = 9;
      PanelSolicitudesAN::actualizarSolicitudAN($solicitud, $datos);

      $datos1 = array();
      $datos1['solicitud']      = $solicitud;
      $datos1['fecha']          = NOW();
      $datos1['estado']         = 9;
      $datos1['observaciones']  = "Solicitud cancelada. ".$observaciones;
      $datos1['motivo_rechazo'] = $motivo;
      $datos1['usuario']        = $DatosUsuario[0]->empleado;
      PanelSolicitudesAN::insertarMovimiento($datos1);

      $Mensaje     = "Solicitud cancelada";
      $Redireccion = "/panel/menu/3";
      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }
 }