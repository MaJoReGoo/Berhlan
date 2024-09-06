<?php
/*
Controlador de la tabla disc_solicitud
Usa SQl Eloquent del archivo app\Models\Disciplinarios\PanelSolicitudes.php
*/

namespace App\Http\Controllers\Disciplinarios;
use App\Http\Controllers\Controller;
use App\Models\PanelLogin;
use App\Models\Disciplinarios\PanelSolicitudes;
use App\Models\Parametrizacion\PanelEmpleados;
use Illuminate\Support\Facades\Session;
use Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class AtenderDisciplinariosPanelController extends Controller
 {
  public function Atender()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "disciplinarios/atender";
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

      $DatosSolicitudes = PanelSolicitudes::SolicitudesPendientes();
      $empleado = "";
      return view('disciplinarios.panel-atender')->with('DatosUsuario',$DatosUsuario)->with('DatosSolicitudes',$DatosSolicitudes)->with('Empconsulta',$empleado);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function AtenderEmpleado()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "disciplinarios/atender";
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

      $formData = Request::all();
      $empleado = $formData['empleado'];

      if($empleado == "")
       {
        $DatosSolicitudes = PanelSolicitudes::SolicitudesPendientes();
       }
      else
       {
        $idempleado = PanelEmpleados::getEmpleadoIdent($empleado);
        if($idempleado->count() > 0)
          $idcol = $idempleado[0]->id_empleado;
        else
          $idcol = "-1";

        $DatosSolicitudes = PanelSolicitudes::SolicitudesEmpleado($idcol);
       }

      return view('disciplinarios.panel-atender')->with('DatosUsuario',$DatosUsuario)->with('DatosSolicitudes',$DatosSolicitudes)->with('Empconsulta',$empleado);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function AtenderProcesar($id)
   {
    if(Session::has('user'))
     {
      $Solicitud      = $id;
      $DatosSolicitud = PanelSolicitudes::Solicitud($Solicitud);
      $user           = Session::get('user');
      $DatosUsuario   = PanelLogin::getUsuario($user);

      $e = 0;
      foreach($DatosSolicitud as $DatSol)
        $e++;

      if($e == 0)
       {
        $Mensaje     = "Esta solicitud no existe.";
        $Redireccion = "/panel/disciplinarios/atender";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "disciplinarios/atender";
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

      return view('disciplinarios.panel-atenderProcesar')->with('DatosUsuario',$DatosUsuario)->with('DatosSolicitud',$DatosSolicitud);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function ReclasificarDB()
   {
    if(Session::has('user'))
     {
      $formData  = Request::all();
      $solicitud = $formData['solicitud'];
      $falta     = $formData['falta'];

      $datos = array();

      $datos['tipo_falta'] = $falta;
      PanelSolicitudes::actualizarSolicitud($solicitud, $datos);
      $Mensaje = "Solicitud reclasificada.";

      $Redireccion = "/panel/disciplinarios/atender/procesar/".$solicitud;
      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function AtenderProcesarDB()
   {
    if(Session::has('user'))
     {
      $formData      = Request::all();
      $solicitud     = $formData['solicitud'];
      $motivo        = $formData['motivo'];
      $fecha         = $formData['fecha'];
      $resultado     = trim($formData['resultado']);
      $observaciones = trim($formData['observaciones']);

      $datos = array();

      //Realizo las validaciones
      $Mensaje = "";

      if($motivo == "")
        $Mensaje = "Debe seleccionar el motivo de cierre.";
      else if($fecha == "")
        $Mensaje = "Debe ingresar la fecha.";
      else if($resultado == "")
        $Mensaje = "Debe ingresar el resultado del proceso.";

      if($motivo == 1)
       {
        $dias = $formData['dias'];
        if($dias == "")
          $Mensaje = "Debe ingresar los días de suspensión.";
       }
      else
       {
        $dias = 0;
       }

      if($Mensaje != "")
       {
        $Redireccion = "/panel/disciplinarios/atender/procesar/".$solicitud;
       }
      else
       {
        $user         = Session::get('user');
        $DatosUsuario = PanelLogin::getUsuario($user);

        $datos['motivo_cierre']   = $motivo;
        $datos['suspension']      = $dias;
        $datos['fecha_descargos'] = $fecha;
        $datos['resultado']       = $resultado;
        $datos['obs_cierre']      = $observaciones;
        $datos['usr_cierre']      = $DatosUsuario[0]->empleado;
        $datos['fecha_cierre']    = NOW();
        $datos['estado']          = 0;  //Atendido

        PanelSolicitudes::actualizarSolicitud($solicitud, $datos);
        $Mensaje = "Solicitud atendida.";

        $Redireccion = "/panel/disciplinarios/atender";
       }

      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function Textos($id)
   {
    if(Session::has('user'))
     {
      $Solicitud      = $id;
      $DatosSolicitud = PanelSolicitudes::Solicitud($Solicitud);
      $user           = Session::get('user');
      $DatosUsuario   = PanelLogin::getUsuario($user);

      $e = 0;
      foreach($DatosSolicitud as $DatSol)
        $e++;

      if($e == 0)
       {
        $Mensaje     = "Esta solicitud no existe.";
        $Redireccion = "/panel/disciplinarios/atender";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "disciplinarios/atender";
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

      return view('disciplinarios.panel-textos')->with('DatosSolicitud',$DatosSolicitud);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }
 }