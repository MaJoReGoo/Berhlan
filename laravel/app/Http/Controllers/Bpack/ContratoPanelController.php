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


class ContratoPanelController extends Controller
 {
  public function PendientesContrato()
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

      $PenContrato = PanelSolicitudesAN::PendientesContrato();

      return view('bpack.panel-pendientesContrato')->with('DatosUsuario',$DatosUsuario)->with('PenContrato',$PenContrato);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function PendientesContratoProcesar($id)
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
        if(($DatSol->estado != 6) && ($DatSol->estado != 11))
          $i++;
       }

      if($e == 0)
       {
        $Mensaje     = "Esta solicitud no existe.";
        $Redireccion = "/panel/bpack/pencontrato";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }

      if($i != 0)
       {
        $Mensaje     = "Esta solicitud ya no esta pendiente de prueba contrato física.";
        $Redireccion = "/panel/bpack/pencontrato";
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

      return view('bpack.panel-pendientesContratoProcesar')->with('DatosUsuario',$DatosUsuario)->with('DatosSolicitud',$DatosSolicitud);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function PendientesContratoProcesarDB()
   {
    if(Session::has('user'))
     {
      $formData      = Request::all();
      $solicitud     = $formData['solicitud'];
      $observaciones = trim($formData['observaciones']);
      $user          = Session::get('user');
      $DatosUsuario  = PanelLogin::getUsuario($user);

      $DatosSolicitud = PanelSolicitudesAN::SolicitudAN($solicitud);
      if(($DatosSolicitud[0]->estado != 6) && ($DatosSolicitud[0]->estado != 11))
       {
        $Mensaje     = "Esta solicitud ya no esta pendiente por prueba de contrato.";
        $Redireccion = "/panel/bpack/pencontrato";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }

      $DetSolicitud = PanelSolicitudesAN::DetSolicitudan($solicitud);

      $avanza = 0;

      foreach($DetSolicitud as $DatSol)
       {
        $registro = $DatSol->registro;
        $textapr  = "regaprobado_".$registro;
        $apr      = $formData[$textapr];

        if($apr != 'S')  //Si el registro no había sido aprobado previamente
         {
          $textremision = "remision_".$registro;
          $remision     = $formData[$textremision];

          if($remision == "")
           {
            $avanza = 1;
            $remision = "";
           }

          $datos = array();
          $datos['remision'] = $remision;

          PanelSolicitudesAN::actualizarSolicitudDetAN($solicitud, $registro, $datos);
         }
       }

      if($avanza == 0) //Diligencio todas la remisiones
       {
        $datos1 = array();
        $estado = 7; //Pendiente de aprobación prueba de contrato
        $datos1['estado'] = $estado;

        PanelSolicitudesAN::actualizarSolicitudAN($solicitud, $datos1);

        $info = "Se ingresaron las pruebas de contrato. ";
       }
      else
       {
        if($observaciones == "")
         {
          $Mensaje     = "El formulario no se diligencio completamente, debe ingresar al menos las observaciones.";
          $Redireccion = "/panel/bpack/pencontrato/procesar/".$solicitud;
          return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
         }

        $estado = 6; //Pendiente de prueba de contrato
        $info = "Solicitud parcialmente guardada. ";

       }

      $datos2 = array();
      $datos2['solicitud']      = $solicitud;
      $datos2['fecha']          = NOW();
      $datos2['estado']         = $estado;
      $datos2['observaciones']  = $info.$observaciones;
      $datos2['motivo_rechazo'] = 0;
      $datos2['usuario']        = $DatosUsuario[0]->empleado;
      PanelSolicitudesAN::insertarMovimiento($datos2);

      $Mensaje     = $info;
      $Redireccion = "/panel/bpack/pencontrato";
      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }
 }