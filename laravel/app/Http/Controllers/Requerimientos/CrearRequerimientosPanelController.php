<?php
/*
Controlador de la tabla requ_solicitud
Usa SQl Eloquent del archivo app\Models\Requerimientos\PanelSolicitudes.php
*/

namespace App\Http\Controllers\Requerimientos;
use App\Http\Controllers\Controller;
use App\Models\PanelLogin;
use App\Models\Requerimientos\PanelGrupos;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Requerimientos\PanelSolicitudes;
use Illuminate\Support\Facades\Session;
use Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;


class CrearRequerimientosPanelController extends Controller
 {
  public function CrearCaso()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "requerimientos/crearcaso";
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

      return view('requerimientos.panel-crearcaso')->with('DatosUsuario',$DatosUsuario)->with('DatosGrupos',$DatosGrupos);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function CrearCasoSeleccionar()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "requerimientos/crearcaso";
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
      $Grupo    = $formData['Grupo'];

      if(isset($formData['busqueda']))
       {
        $busqueda = trim($formData['busqueda']);
        $bq = $busqueda;
        $busqueda = "%".$busqueda."%";
       }
      else
       {
        $bq       = "";
        $busqueda = "XYZXYZXYZXYZXYZ";
       }

      //Si no es master valido si el usuario si es administrador del grupo
      if($DatosUsuario[0]->master == 0)
       {
        $AccesoGrupo = PanelGrupos::getEmpleadoUnico($Grupo, $DatosUsuario[0]->empleado);
        if($AccesoGrupo == 0) //El usuario no tiene acceso al grupo
         {
          $ErrorValidacion = "Usted no tiene acceso al grupo seleccionado.";
          return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
         }
       }

      $DatosEmpleados = PanelEmpleados::EmpleadosBusquedaActivos($busqueda);
      return view('requerimientos.panel-crearcasoSeleccionar')->with('DatosUsuario',$DatosUsuario)->with('Grupo',$Grupo)->with('DatosEmpleados',$DatosEmpleados)->with('bq',$bq);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function CrearCasoAgregar()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "requerimientos/crearcaso";
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
      $Grupo    = $formData['Grupo'];
      $Empleado = $formData['Empleado'];

      if($DatosUsuario[0]->master == 0)
       {
        $AccesoGrupo = PanelGrupos::getEmpleadoUnico($Grupo, $DatosUsuario[0]->empleado);
        if($AccesoGrupo == 0) //El usuario no tiene acceso al grupo
         {
          $ErrorValidacion = "Usted no tiene acceso al grupo seleccionado.";
          return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
         }
       }


      return view('requerimientos.panel-crearcasoAgregar')->with('DatosUsuario',$DatosUsuario)->with('Grupo',$Grupo)->with('Empleado',$Empleado);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function CrearCasoAgregarDB()
   {
    if(Session::has('user'))
     {
      $formData    = Request::all();
      $grupo       = $formData['grupo'];
      $empleado    = $formData['empleado'];
      $descripcion = trim($formData['descripcion']);
      $user        = Session::get('user');

      $datos = array();

      //Realizo las validaciones
      $Mensaje = "";

      if($descripcion == "")
        $Mensaje = "Debe ingresar la solicitud.";
      else if($empleado == "")
        $Mensaje = "Debe seleccionar el colaborador.";

      if($Mensaje == "")
       {
        $DatosEmpleado = PanelEmpleados::getEmpleado($empleado);
        $DatosUsuario  = PanelLogin::getUsuario($user);
        $infoCreadorCaso = PanelEmpleados::getEmpleadoInfo($DatosUsuario[0]->empleado);

        $datos['grupo']            = $grupo;
        $datos['usr_solicita']     = $empleado;
        $datos['descripcion']      = $descripcion;
        $datos['archivo']          = "";
        $datos['fecha_solicita']   = NOW();
        $datos['centro_solicitud'] = $DatosEmpleado[0]->centro_op;
        $datos['cargo_solicitud']  = $DatosEmpleado[0]->cargo;
        $datos['estado']           = 1;
        $datos['creado_por']       = $DatosUsuario[0]->empleado;
        $datos['usr_cierre']       = 0;
        $datos['desc_cierre']      = '';
        $datos['categoria']        = 0;
        $datos['depende_de']       = '';
        $datos['archivo_cierre']   = '';
        $datos['calificacion']     = '';
        $datos['des_calificacion'] = '';
        $datos['reintegro']        = '';
        $datos['usr_reintegro']    = 0;
        $datos['obs_reintegro']    = '';

        PanelSolicitudes::insertarSolicitud($datos);

        $solicitud = PanelSolicitudes::UltimaSolicitud();
        $Mensaje   = "Requerimiento creado ".$solicitud->num_solicitud;

        $datosEmail['nombre'] = 'NOTIFICACIÓN DE CREACION DE CASO';

        if (strpos($DatosEmpleado[0]->correo, '@berhlan') ||  strpos($DatosEmpleado[0]->correo, '@bpack')) {
            $datosEmail['email'] = $DatosEmpleado[0]->correo;
        } else {
            $datosEmail['email'] = 'informes@berhlan.com';
        }

        $datosEmail['solicitud'] = $solicitud->num_solicitud;
        $datosEmail['mensaje'] = 'SE HA CREADO UN NUEVO CASO';
        $datosEmail['descripcion'] = $descripcion;
        $datosEmail['fechacreacion'] = now();
        $datosEmail['empleado'] = $infoCreadorCaso[0]->nombre;
        $datosEmail['link_ticket'] = 'https://192.168.1.210/Berhlan/public/panel/requerimientos/atender/procesar/' . $solicitud->num_solicitud;

        Mail::send('email.notificacion_crearcaso', $datosEmail, function ($message) use ($datosEmail) {
          $admin = $datosEmail['email'];
          $nombre = $datosEmail['nombre'];
          $message->subject('Notificaciones Intranet');
          $message->from('notificacionesberhlan@berhlan.com', $nombre);
          $message->to($admin);
        });

       }

      $Redireccion = "/panel/requerimientos/atender";
      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }
 }
