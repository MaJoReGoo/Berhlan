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


class RutasPanelController extends Controller
 {
  public function PendientesRuta()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "bpack/solpendientes";
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

      $PenRuta = PanelSolicitudesAN::PendientesRuta();

      return view('bpack.panel-pendientesRuta')->with('DatosUsuario',$DatosUsuario)->with('PenRuta',$PenRuta);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function PendientesRutaProcesar($id)
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
        if($DatSol->estado != 1)
          $i++;
       }

      if($e == 0)
       {
        $Mensaje     = "Esta solicitud no existe.";
        $Redireccion = "/panel/bpack/penruta";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }

      if($i != 0)
       {
        $Mensaje     = "Esta solicitud ya no esta pendiente de ruta.";
        $Redireccion = "/panel/bpack/penruta";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "bpack/solpendientes";
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

      return view('bpack.panel-pendientesRutaProcesar')->with('DatosUsuario',$DatosUsuario)->with('DatosSolicitud',$DatosSolicitud);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function PendientesRutaProcesarDB()
   {
    if(Session::has('user'))
     {
      $formData      = Request::all();
      $solicitud     = $formData['solicitud'];
      $observaciones = trim($formData['observaciones']);
      $user          = Session::get('user');
      $DatosUsuario  = PanelLogin::getUsuario($user);

      $datos = array();
      $datos['estado'] = 2;  //Pendiente de aprobación por preprensa
      PanelSolicitudesAN::actualizarSolicitudAN($solicitud, $datos);

      $DetSolicitud = PanelSolicitudesAN::DetSolicitudan($solicitud);
      foreach($DetSolicitud as $DatSol)
       {
        $registro = $DatSol->registro;
        $textruta = "ruta_".$registro;
        $textuso  = "uso_".$registro;

        $datos1 = array();

        $datos1['ruta'] = $formData[$textruta];
        $datos1['uso']  = $formData[$textuso];

        PanelSolicitudesAN::actualizarSolicitudDetAN($solicitud, $registro, $datos1);
       }

      $datos2 = array();
      $datos2['solicitud']      = $solicitud;
      $datos2['fecha']          = NOW();
      $datos2['estado']         = 2;  //Pendiente de aprobación por preprensa
      $datos2['observaciones']  = "Ruta ingresada. ".$observaciones;
      $datos2['motivo_rechazo'] = 0;
      $datos2['usuario']        = $DatosUsuario[0]->empleado;
      PanelSolicitudesAN::insertarMovimiento($datos2);

      $Mensaje     = "Ruta ingresada";
      $Redireccion = "/panel/bpack/penruta";
      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function RechazarDB()
   {
    if(Session::has('user'))
     {
      $formData      = Request::all();
      $solicitud     = $formData['solicitud'];
      $motivo        = $formData['motivo'];
      $observaciones = trim($formData['observaciones']);
      $user          = Session::get('user');
      $DatosUsuario  = PanelLogin::getUsuario($user);

      $datos = array();
      $datos['estado'] = 10;  //Rechazada por ruta - pendiente de corrección
      PanelSolicitudesAN::actualizarSolicitudAN($solicitud, $datos);

      $datos1 = array();
      $datos1['solicitud']      = $solicitud;
      $datos1['fecha']          = NOW();
      $datos1['estado']         = 10;  //Rechazada por ruta - pendiente de corrección
      $datos1['observaciones']  = "Rechazo en pendiente de ruta. ".$observaciones;
      $datos1['motivo_rechazo'] = $motivo;
      $datos1['usuario']        = $DatosUsuario[0]->empleado;
      PanelSolicitudesAN::insertarMovimiento($datos1);

      $Mensaje     = "Solicitud rechazada";
      $Redireccion = "/panel/bpack/penruta";
      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }
 }