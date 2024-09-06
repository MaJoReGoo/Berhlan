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
use App\Models\Parametrizacion\PanelNotificaciones;
use App\Models\Requerimientos\PanelSolicitudes;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;


class AtenderRequerimientosPanelController extends Controller
{
  public function Atender()
  {
    if (Session::has('user')) {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if ($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
      {
        $ruta      = "requerimientos/atender";
        $DatosMenu = PanelLogin::getMenuRuta($ruta);
        if ($DatosMenu[0]->libre_acceso == 0)  //Si el modulo no es de libre acceso
        {
          $idmenu    = $DatosMenu[0]->id_menu;

          $ModUser    = explode(',', $DatosUsuario[0]->modulos);
          $NumModUser = count($ModUser);
          $acceso     = 0;
          for ($i = 0; $i < $NumModUser; $i++) {
            if ($idmenu == $ModUser[$i]) {
              $acceso = 1;
              break;
            }
          }

          if ($acceso == 0) //El usuario no tiene acceso al modulo
          {
            $ErrorValidacion = "Usted no tiene acceso al módulo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
          }
        }
      }
      //Termina validación

      //Valido a categorías puede tener acceso
      if ($DatosUsuario[0]->master == 1)
        $DatosGrupos = PanelGrupos::getGruposActivos();
      else
        $DatosGrupos = PanelGrupos::getGruposActivosEmpleado($DatosUsuario[0]->empleado);

      return view('requerimientos.panel-atender')->with('DatosUsuario', $DatosUsuario)->with('DatosGrupos', $DatosGrupos);
    } else {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
    }
  }

  public function AtenderListado($id)
  {
    if (Session::has('user')) {
      $Grupo        = $id;
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if ($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
      {
        $ruta      = "requerimientos/atender";
        $DatosMenu = PanelLogin::getMenuRuta($ruta);
        if ($DatosMenu[0]->libre_acceso == 0)  //Si el modulo no es de libre acceso
        {
          $idmenu    = $DatosMenu[0]->id_menu;

          $ModUser    = explode(',', $DatosUsuario[0]->modulos);
          $NumModUser = count($ModUser);
          $acceso     = 0;
          for ($i = 0; $i < $NumModUser; $i++) {
            if ($idmenu == $ModUser[$i]) {
              $acceso = 1;
              break;
            }
          }

          if ($acceso == 0) //El usuario no tiene acceso al modulo
          {
            $ErrorValidacion = "Usted no tiene acceso al módulo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
          }
        }
      }
      //Termina validación

      //Valido que tenga acceso a las categorías del grupo seleccionado
      if ($DatosUsuario[0]->master == 0) {
        $AccesoGrupo = PanelGrupos::getEmpleadoUnico($Grupo, $DatosUsuario[0]->empleado);
        if ($AccesoGrupo == 0) //El usuario no tiene acceso al grupo
        {
          $ErrorValidacion = "Usted no tiene acceso al grupo seleccionado.";
          return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
      }

      $DatosSolicitudes = PanelSolicitudes::getSolicitudesAbiertasGrupo($Grupo);
      $RequerimientosVencidosCant = PanelSolicitudes::RequerimientosVencidosCant();

      return view('requerimientos.panel-atenderListado')->with('DatosUsuario', $DatosUsuario)->with('DatosSolicitudes', $DatosSolicitudes)->with('Grupo', $Grupo)->with('RequerimientosVencidosCant', $RequerimientosVencidosCant);
    } else {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
    }
  }

  public function AtenderListadoNotificado($id)
  {
    if (Session::has('user')) {
      $Grupo        = $id;
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if ($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
      {
        $ruta      = "requerimientos/atender";
        $DatosMenu = PanelLogin::getMenuRuta($ruta);
        if ($DatosMenu[0]->libre_acceso == 0)  //Si el modulo no es de libre acceso
        {
          $idmenu    = $DatosMenu[0]->id_menu;

          $ModUser    = explode(',', $DatosUsuario[0]->modulos);
          $NumModUser = count($ModUser);
          $acceso     = 0;
          for ($i = 0; $i < $NumModUser; $i++) {
            if ($idmenu == $ModUser[$i]) {
              $acceso = 1;
              break;
            }
          }

          if ($acceso == 0) //El usuario no tiene acceso al modulo
          {
            $ErrorValidacion = "Usted no tiene acceso al módulo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
          }
        }
      }
      //Termina validación

      //Valido que tenga acceso a las categorías del grupo seleccionado
      if ($DatosUsuario[0]->master == 0) {
        $AccesoGrupo = PanelGrupos::getEmpleadoUnico($Grupo, $DatosUsuario[0]->empleado);
        if ($AccesoGrupo == 0) //El usuario no tiene acceso al grupo
        {
          $ErrorValidacion = "Usted no tiene acceso al grupo seleccionado.";
          return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
      }

      $DatosSolicitudesAbiertas = PanelSolicitudes::getSolicitudesAbiertasGrupo($id);
      $DatosSolicitudes = PanelSolicitudes::getSolicitudesAbiertasNotificadosGrupo($id);
      $RequerimientosVencidosCant = PanelSolicitudes::RequerimientosVencidosCant();

      return view('requerimientos.panel-atenderListado')->with('DatosUsuario', $DatosUsuario)->with('DatosSolicitudes', $DatosSolicitudes)->with('Grupo', $Grupo)->with('RequerimientosVencidosCant', $RequerimientosVencidosCant)->with('DatosSolicitudesAbiertas',$DatosSolicitudesAbiertas);;
    } else {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
    }
  }

  public function AtenderListadoTodos($id)
  {
    if (Session::has('user')) {
      $Grupo        = $id;
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if ($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
      {
        $ruta      = "requerimientos/atender";
        $DatosMenu = PanelLogin::getMenuRuta($ruta);
        if ($DatosMenu[0]->libre_acceso == 0)  //Si el modulo no es de libre acceso
        {
          $idmenu    = $DatosMenu[0]->id_menu;

          $ModUser    = explode(',', $DatosUsuario[0]->modulos);
          $NumModUser = count($ModUser);
          $acceso     = 0;
          for ($i = 0; $i < $NumModUser; $i++) {
            if ($idmenu == $ModUser[$i]) {
              $acceso = 1;
              break;
            }
          }

          if ($acceso == 0) //El usuario no tiene acceso al modulo
          {
            $ErrorValidacion = "Usted no tiene acceso al módulo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
          }
        }
      }
      //Termina validación

      //Valido que tenga acceso a las categorías del grupo seleccionado
      if ($DatosUsuario[0]->master == 0) {
        $AccesoGrupo = PanelGrupos::getEmpleadoUnico($Grupo, $DatosUsuario[0]->empleado);
        if ($AccesoGrupo == 0) //El usuario no tiene acceso al grupo
        {
          $ErrorValidacion = "Usted no tiene acceso al grupo seleccionado.";
          return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
      }

      $DatosSolicitudes = PanelSolicitudes::getSolicitudesAbiertasGrupo($id);
      $RequerimientosVencidosCant = PanelSolicitudes::RequerimientosVencidosCant();
      $RequerimientosTodos = PanelSolicitudes::RequerimientosTodosCant($id);

      return view('requerimientos.panel-atenderListado')->with('DatosUsuario', $DatosUsuario)->with('DatosSolicitudes', $DatosSolicitudes)->with('Grupo', $Grupo)->with('RequerimientosVencidosCant', $RequerimientosVencidosCant)->with('RequerimientosTodos', $RequerimientosTodos);
    } else {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
    }
  }

  public function AtenderProcesar($id)
  {
    if (Session::has('user')) {
      $Solicitud      = $id;
      $DatosSolicitud = PanelSolicitudes::getSolicitud($Solicitud);
      $user           = Session::get('user');
      $DatosUsuario   = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if ($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
      {
        $ruta      = "requerimientos/atender";
        $DatosMenu = PanelLogin::getMenuRuta($ruta);
        if ($DatosMenu[0]->libre_acceso == 0)  // Si el modulo no es de libre acceso
        {
          $idmenu    = $DatosMenu[0]->id_menu;

          $ModUser    = explode(',', $DatosUsuario[0]->modulos);
          $NumModUser = count($ModUser);
          $acceso     = 0;
          for ($i = 0; $i < $NumModUser; $i++) {
            if ($idmenu == $ModUser[$i]) {
              $acceso = 1;
              break;
            }
          }

          if ($acceso == 0) //El usuario no tiene acceso al modulo
          {
            $ErrorValidacion = "Usted no esta tiene acceso al módulo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
          }
        }
      }
      //Termina validación

      if ($DatosUsuario[0]->master == 0) {
        $AccesoGrupo = PanelGrupos::getEmpleadoUnico($DatosSolicitud[0]->grupo, $DatosUsuario[0]->empleado);
        if ($AccesoGrupo == 0) //El usuario no tiene acceso al grupo
        {
          $ErrorValidacion = "Usted no tiene acceso al grupo seleccionado.";
          return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
      }

      return view('requerimientos.panel-atenderProcesar')->with('DatosUsuario', $DatosUsuario)->with('DatosSolicitud', $DatosSolicitud);
    } else {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
    }
  }

  public function AtenderTrasladarDB()
  {
    if (Session::has('user')) {
      $formData     = Request::all();
      $solicitud    = $formData['solicitud'];
      $grupo        = $formData['grupo'];
      $nombregrupo  = $formData['nombregrupo'];
      $grupoant     = $formData['grupoant'];
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);
      $correoNotificacion  = $formData['correoNotificacion'];
      $numSolicitud  = $formData['solicitud'];
      $titSolicitud    = $formData['titulo_solicitud'];
      $datosEmail['link_ticket'] = 'https://192.168.1.210/Berhlan/public/panel/requerimientos/misrequerimientos/masinfo/' . $numSolicitud;

      if ($correoNotificacion == '' || $correoNotificacion == NULL || $correoNotificacion == 'No Aplica') {
        $correoNotificacion = 'informes@berhlan.com';
      }

      $Grupos = PanelGrupos::getGrupo($grupo);
      $GrupoNuevo = $Grupos[0]->descripcion;

      $datos = array();

      //Realizo las validaciones
      $Mensaje = "";

      if ($grupo == "")
        $Mensaje = "Debe seleccionar el grupo.";

      if ($Mensaje != "") {
        $Redireccion = "/panel/requerimientos/atender/procesar/" . $solicitud;
      } else {
        $datos['grupo']      = $grupo;
        $datos['usr_cierre'] = 0;
        $datos['categoria']  = 0;
        $datos['estado']     = 1; //Activo

        PanelSolicitudes::actualizarSolicitud($solicitud, $datos);

        //if ($grupoant == 1) {
        /* ENVIO NOTIFICACIÓN TRASLADO DE CASO | CLIENTE */
        $datosEmail['nombre'] = 'NOTIFICACIÓN DE TRASLADO DE REQUERIMIENTOS';
        $datosEmail['numsolicitud'] = $numSolicitud;
        $datosEmail['titsolicitud'] = $titSolicitud;
        $datosEmail['email'] = $correoNotificacion;
        $datosEmail['mensajel1'] = 'SU CASO (' . $numSolicitud . ')';
        $datosEmail['mensajel2'] = 'SE HA TRASLADADO AL GRUPO: ' . $GrupoNuevo . ' ';
        $datosEmail['mensajel3'] = '';

        Mail::send('email.notificacion_requerimiento', $datosEmail, function ($message) use ($datosEmail) {
          $admin = $datosEmail['email'];
          $nombre = $datosEmail['nombre'];
          $message->subject('Notificaciones Intranet');
          $message->from('notificacionesberhlan@berhlan.com', $nombre);
          $message->to($admin);
        });
        /* ENVIO NOTIFICACIÓNTRASLADO DE CASO | CLIENTE */
        // }

        $datos1 = array();

        $datos1['solicitud']   = $solicitud;
        $datos1['fecha']       = NOW();
        $datos1['usuario']     = $DatosUsuario[0]->empleado;
        $datos1['descripcion'] = "Requerimiento trasladado desde " . $nombregrupo;

        PanelSolicitudes::insertarSolicitudDet($datos1);

        $Mensaje     = "Requerimiento trasladado.";
        $Redireccion = "/panel/requerimientos/atender/listado/" . $grupoant;
      }

      return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
    } else {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
    }
  }

  public function AtenderAsignarDB()
  {
    if (Session::has('user')) {
      $formData     = Request::all();
      $grupo    = $formData['grupo'];
      $solicitud    = $formData['solicitud'];
      $titSolicitud    = $formData['titulo_solicitud'];
      $asignado     = $formData['asignado'];
      $categoria    = $formData['categoria'];
      $dependencia  = $formData['depende'];
      $correoNotificacion  = $formData['correoNotificacion'];
      $numSolicitud  = $formData['solicitud'];
      $fechacreacion    = $formData['fechacreacion'];
      $fechaasignacion    = NOW();

      if ($correoNotificacion == '' || $correoNotificacion == NULL || $correoNotificacion == 'No Aplica') {
        $correoNotificacion = 'informes@berhlan.com';
      }

      $datosAsignado = PanelEmpleados::getEmpleado($asignado);
      $nombreEmpleado = $datosAsignado[0]->primer_nombre . ' ' . $datosAsignado[0]->ot_nombre . ' ' . $datosAsignado[0]->primer_apellido . ' ' . $datosAsignado[0]->ot_apellido;
      $correoEmpleado = $datosAsignado[0]->correo;

      if (!$dependencia)
        $dependencia = "";

      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      $datos = array();

      //Realizo las validaciones
      $Mensaje = "";

      if ($asignado == "")
        $Mensaje = "Debe seleccionar el colaborador.";
      else if ($categoria == "")
        $Mensaje = "Debe seleccionar la categoría.";

      if ($Mensaje == "") {
        $datos['usr_cierre'] = $asignado;
        $datos['usr_atiende'] = $asignado;
        $datos['categoria']  = $categoria;
        $datos['depende_de'] = $dependencia;
        $datos['estado']     = 2; //Requerimiento asignado

        PanelSolicitudes::actualizarSolicitud($solicitud, $datos);

        $datos1 = array();

        $datos1['solicitud']   = $solicitud;
        $datos1['fecha']       = NOW();
        $datos1['usuario']     = $DatosUsuario[0]->empleado;
        $datos1['descripcion'] = "Requerimiento asignado y categorizado";

        PanelSolicitudes::insertarSolicitudDet($datos1);

        //if ($grupo == 1) {
        /* ENVIO NOTIFICACIÓN ASIGNACIÓN DE CASO | CLIENTE */
        $datosEmail['nombre'] = 'NOTIFICACIÓN DE ASIGNACIÓN';
        $datosEmail['email'] = $correoNotificacion;
        $datosEmail['numsolicitud'] = $numSolicitud;
        $datosEmail['titsolicitud'] = $titSolicitud;
        $datosEmail['fechacreacion'] = $fechacreacion;
        $datosEmail['fechaasignacion'] = $fechaasignacion;
        $datosEmail['empleado'] = $nombreEmpleado;
        $datosEmail['mensajel1'] = 'SU CASO';
        $datosEmail['mensajel2'] = 'SE HA ASIGNADO A';
        $datosEmail['mensajel3'] = '';
        $datosEmail['link_ticket'] = 'https://192.168.1.210/Berhlan/public/panel/requerimientos/misrequerimientos/masinfo/' . $numSolicitud;

        Mail::send('email.notificacion_requerimiento_asignacion', $datosEmail, function ($message) use ($datosEmail) {
          $admin = $datosEmail['email'];
          //print $admin;
          //die();
          $nombre = $datosEmail['nombre'];
          $message->subject('Notificaciones Intranet');
          $message->from('notificacionesberhlan@berhlan.com', $nombre);
          $message->to($admin);
        });
        /* ENVIO NOTIFICACIÓN ASIGNACIÓN DE CASO | CLIENTE */

        /* ENVIO NOTIFICACIÓN ASIGNACIÓN DE CASO | EMPLEADO */
        $datosEmail['nombre'] = 'NOTIFICACIÓN DE ASIGNACIÓN';
        $datosEmail['email'] = $correoEmpleado;
        $datosEmail['empleado'] = $nombreEmpleado;
        $datosEmail['mensajel1'] = 'TIENE UN NUEVO CASO ASIGNADO';
        $datosEmail['numsolicitud'] = $numSolicitud;
        $datosEmail['titsolicitud'] = $titSolicitud;
        $datosEmail['fechacreacion'] = $fechacreacion;
        $datosEmail['fechaasignacion'] = $fechaasignacion;
        $datosEmail['mensajel2'] = 'El equipo le asignó el caso';
        $datosEmail['mensajel3'] = '';
        $datosEmail['link_ticket'] = 'https://192.168.1.210/Berhlan/public/panel/requerimientos/atender/procesar/' . $numSolicitud;

        Mail::send('email.notificacion_requerimiento_asignacion', $datosEmail, function ($message) use ($datosEmail) {
          $admin = $datosEmail['email'];
          $nombre = $datosEmail['nombre'];
          $message->subject('Notificaciones Intranet');
          $message->from('notificacionesberhlan@berhlan.com', $nombre);
          $message->to($admin);
        });
        /* ENVIO NOTIFICACIÓN ASIGNACIÓN DE CASO | EMPLEADO */
        // }


        $Mensaje = "Requerimiento asignado y categorizado.";
      }

      $Redireccion = "/panel/requerimientos/atender/procesar/" . $solicitud;
      return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
    } else {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
    }
  }

  public function AtenderCerrarNotificacion()
  {
    if (Session::has('user')) {
      $formData     = Request::all();
      $solicitud    = $formData['solicitud'];
      $DatosSolicitud = PanelSolicitudes::getSolicitud($solicitud);
      $tituloSolicitud   = $formData['titulo_solicitud'];
      $aplreintegro = $formData['aplreintegro'];
      $fileImg      = $formData['subir2'];
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);
      $datos = array();
      $datosComments = array();

      // Agregar Información de Comentario de Cierre
      $datosComments['solicitud']   = $solicitud;
      $datosComments['fecha']       = NOW();
      $datosComments['usuario']     = $DatosUsuario[0]->empleado;
      $datosComments['descripcion'] = $formData['comentario_cierre'];
      $datosComments['cierre'] = 1;

      if ($fileImg != '') {
        $ano = date('Y');
        $mes = date('m') * 1;
        $file     = Request::file('archivo');
        $filename = $file->getClientOriginalName();
        $filename = $this->eliminar_tildes($filename);

        $extension = explode(".", $filename);
        $f         = count($extension);
        $final     = strtolower($extension[$f - 1]);

        $destinationPath = substr(public_path(), 0, -14) . "public/archivos/Requerimientos/" . $ano . "/" . $mes . "/";
        $filename        = $ano . "/" . $mes . "/Req_" . $solicitud . "_anexo_2." . $final;
        $uploadSuccess   = $file->move($destinationPath, $filename);

        $datosComments['archivo'] = $filename;
      } else {
        $filename = 'Archivo no encontrado';
      }


      PanelSolicitudes::insertarSolicitudDet($datosComments);
      // Agregar Información de Comentario de Cierre

      if ($DatosSolicitud[0]->fecha_propuesta_cierre == '') {
        $datos['notificacion_cierre'] = 1;
        $FechaCierre = now();
        $datos['fecha_propuesta_cierre'] = $FechaCierre;
        PanelSolicitudes::actualizarSolicitud($solicitud, $datos);
      } else {
        $FechaCierre = $DatosSolicitud[0]->fecha_propuesta_cierre;
      }

      $ParametrosNotificaciones = PanelNotificaciones::getNotificacion(1);
      $FechaCierreMinimo = date("Y-m-d", strtotime($FechaCierre . "+" . $ParametrosNotificaciones->dias_min . "days"));
      $FechaCierreMaximo = date("Y-m-d", strtotime($FechaCierre . "+" . $ParametrosNotificaciones->dias_max . "days"));


      $correoNotificacion  = $formData['correoNotificacion'];
      $numSolicitud  = $formData['solicitud'];

      if ($correoNotificacion == '' || $correoNotificacion == NULL || $correoNotificacion == 'No Aplica') {
        $correoNotificacion = 'informes@berhlan.com';
      }

      if($aplreintegro==1){
        $datos['reintegro'] = $formData['reintegro'];
        PanelSolicitudes::actualizarSolicitud($solicitud, $datos);
      }



      /* ENVIO NOTIFICACIÓN CIERRE DE CASO | CLIENTE */
      $datosEmail['nombre'] = 'NOTIFICACIÓN DE CIERRE';
      $datosEmail['email'] = $correoNotificacion;
      $datosEmail['numsolicitud'] = $numSolicitud;
      $datosEmail['titsolicitud'] = $tituloSolicitud;
      $datosEmail['mensajel1'] = '¡Hemos resuelto su problema con éxito!';
      $datosEmail['mensajel2'] = $FechaCierre;
      $datosEmail['mensajel3'] = $FechaCierreMinimo;
      $datosEmail['mensajel4'] = $FechaCierreMaximo;
      $datosEmail['mensajel5'] = $formData['comentario_cierre'];
      $datosEmail['mensajel6'] = '';
      $datosEmail['link_ticket'] = 'https://192.168.1.210/Berhlan/public/panel/requerimientos/misrequerimientos/masinfo/' . $numSolicitud;

      Mail::send('email.notificacion_cierre', $datosEmail, function ($message) use ($datosEmail, $filename) {
        $admin = $datosEmail['email'];
        $nombre = $datosEmail['nombre'];
        if ($filename !== 'Archivo no encontrado') {
            $message->attach(asset('archivos/Requerimientos/'.$filename));
        }
        $message->subject('Notificaciones Intranet');
        $message->from('notificacionesberhlan@berhlan.com', $nombre);
        $message->to($admin);
      });
      /* ENVIO NOTIFICACIÓN CIERRE DE CASO | CLIENTE */

      $Mensaje = "Notificación Enviada!";
      $Redireccion = "/panel/requerimientos/atender/procesar/" . $solicitud;
      return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
    } else {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
    }
  }

  public function RechazarCerrarNotificacion()
  {
    if (Session::has('user')) {
      $formData     = Request::all();
      $solicitud    = $formData['solicitud'];
      $DatosSolicitud = PanelSolicitudes::getSolicitud($solicitud);
      $tituloSolicitud   = $formData['titulo_solicitud'];
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);
      $datosComments = array();
      $datos = array();
      $datosComments = array();

      $asignado     = $formData['asignado'];
      $datosAsignado = PanelEmpleados::getEmpleado($asignado);
      $nombreEmpleado = $datosAsignado[0]->primer_nombre . ' ' . $datosAsignado[0]->ot_nombre . ' ' . $datosAsignado[0]->primer_apellido . ' ' . $datosAsignado[0]->ot_apellido;
      $correoEmpleado = $datosAsignado[0]->correo;

      $user        = Session::get('user');

      // Subir Archivos en el Rechazo
      if (isset($formData['uploader2'])) {
        $fileImg      = $formData['uploader2'];
      } else {
        $fileImg = '';
      }

      if ($fileImg != '') {
        $ano = date('Y');
        $mes = date('m') * 1;
        $file     = Request::file('file2');
        $filename = $file->getClientOriginalName();
        $filename = $this->eliminar_tildes($filename);

        $extension = explode(".", $filename);
        $f         = count($extension);
        $final     = strtolower($extension[$f - 1]);

        $destinationPath = substr(public_path(), 0, -14) . "public/archivos/Requerimientos/" . $ano . "/" . $mes . "/";
        $filename        = $ano . "/" . $mes . "/Req_" . $solicitud . "_anexo_2." . $final;
        $uploadSuccess   = $file->move($destinationPath, $filename);

        $datosComments['archivo'] = $filename;
      } else {
        $filename = 'Archivo no encontrado';
      }
      // Subir Archivos en el Rechazo


      // Agregar Información de Comentario de Cierre
      $datosComments['solicitud']   = $solicitud;
      $datosComments['fecha']       = NOW();
      $datosComments['usuario']     = $DatosSolicitud[0]->usr_cierre;
      $datosComments['descripcion'] = $formData['comentario_rechazo'];
      $datosComments['rechazo'] = 1;
      PanelSolicitudes::insertarSolicitudDet($datosComments);
      // Agregar Información de Comentario de Cierre

      // Se Formatea la Fecha de Cierre
      $datos['notificacion_cierre'] = 0;
      $FechaCierre = now();
      $datos['fecha_propuesta_cierre'] = NULL;
      PanelSolicitudes::actualizarSolicitud($solicitud, $datos);

      /*$ParametrosNotificaciones = PanelNotificaciones::getNotificacion(1);
      $FechaCierreMinimo = date("Y-m-d", strtotime($FechaCierre . "+" . $ParametrosNotificaciones->dias_min . "days"));
      $FechaCierreMaximo = date("Y-m-d", strtotime($FechaCierre . "+" . $ParametrosNotificaciones->dias_max . "days"));
      */

      $correoNotificacion  = $formData['correoNotificacion'];
      $numSolicitud  = $formData['solicitud'];

      if ($correoNotificacion == '' || $correoNotificacion == NULL || $correoNotificacion == 'No Aplica') {
        $correoNotificacion = 'informes@berhlan.com';
      }

      /* ENVIO NOTIFICACIÓN RECHAZO DE CASO | CLIENTE */
      $datosEmail['nombre'] = 'NOTIFICACIÓN DE RECHAZO';
      $datosEmail['email'] = $correoNotificacion;
      $datosEmail['numsolicitud'] = $numSolicitud;
      $datosEmail['titsolicitud'] = $tituloSolicitud;
      $datosEmail['mensajel1'] = '¡El Cierre de Ticket ha sido Rechazado!';
      $datosEmail['mensajel2'] = $FechaCierre;
      $datosEmail['mensajel3'] = $FechaCierre;
      $datosEmail['mensajel4'] = $FechaCierre;
      $datosEmail['mensajel5'] = $formData['comentario_rechazo'];
      $datosEmail['mensajel6'] = '';
      $datosEmail['link_ticket'] = 'https://192.168.1.210/Berhlan/public/panel/requerimientos/misrequerimientos/masinfo/' . $numSolicitud;

      Mail::send('email.notificacion_rechazo', $datosEmail, function ($message) use ($datosEmail) {
        $admin = $datosEmail['email'];
        $nombre = $datosEmail['nombre'];
        $message->subject('Notificaciones Intranet');
        $message->from('notificacionesberhlan@berhlan.com', $nombre);
        $message->to($admin);
      });
      /* ENVIO NOTIFICACIÓN RECHAZO DE CASO | CLIENTE */

      /* ENVIO NOTIFICACIÓN RECHAZO DE CASO | EMPLEADO */
      $datosEmail['nombre'] = 'NOTIFICACIÓN DE RECHAZO';
      $datosEmail['email'] = $correoEmpleado;
      $datosEmail['empleado'] = $nombreEmpleado;
      $datosEmail['mensajel1'] = '¡El Cierre de Ticket ha sido Rechazado!';
      $datosEmail['numsolicitud'] = $numSolicitud;
      $datosEmail['titsolicitud'] = $tituloSolicitud;
      $datosEmail['mensajel1'] = '¡El Cierre de Ticket ha sido Rechazado!';
      $datosEmail['mensajel2'] = $FechaCierre;
      $datosEmail['mensajel3'] = $FechaCierre;
      $datosEmail['mensajel4'] = $FechaCierre;
      $datosEmail['mensajel5'] = $formData['comentario_rechazo'];
      $datosEmail['mensajel6'] = '';
      $datosEmail['link_ticket'] = 'https://192.168.1.210/Berhlan/public/panel/requerimientos/atender/procesar/' . $numSolicitud;

      Mail::send('email.notificacion_rechazo', $datosEmail, function ($message) use ($datosEmail) {
        $admin = $datosEmail['email'];
        $nombre = $datosEmail['nombre'];
        $message->subject('Notificaciones Intranet');
        $message->from('notificacionesberhlan@berhlan.com', $nombre);
        $message->to($admin);
      });
      /* ENVIO NOTIFICACIÓN RECHAZO DE CASO | EMPLEADO */


      $Mensaje = "Notificación Enviada!";
      $Redireccion = "/panel/requerimientos/misrequerimientos/masinfo/" . $solicitud;
      return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
    } else {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
    }
  }


  public function AtenderCerrarDB()
  {
    if (Session::has('user')) {
      $formData     = Request::all();
      $solicitud    = $formData['solicitud'];
      $DatosSolicitud = PanelSolicitudes::getSolicitud($solicitud);
      $tituloSolicitud   = $formData['titulo_solicitud'];
      $asignado     = $formData['asignado'];
      $descripcion  = trim($formData['descripcion']);
      $grupo        = trim($formData['grupo']);
      $fileImg      = $formData['uploader1'];
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);


      $datos = array();

      //Realizo las validaciones
      $Mensaje = "";

      if ($descripcion == "")
        $Mensaje = "Debe describir la actividad realizada.";

      if ($Mensaje == "") {
        if ($fileImg != '') {
          $ano = date('Y');
          $mes = date('m') * 1;
          $file     = Request::file('file1');
          $filename = $file->getClientOriginalName();
          $filename = AtenderRequerimientosPanelController::eliminar_tildes($filename);

          $extension = explode(".", $filename);
          $f         = count($extension);
          $final     = strtolower($extension[$f - 1]);

          $destinationPath = substr(public_path(), 0, -14) . "public/archivos/Requerimientos/" . $ano . "/" . $mes . "/";
          $filename        = $ano . "/" . $mes . "/Req_" . $solicitud . "_anexo_2." . $final;
          $uploadSuccess   = $file->move($destinationPath, $filename);

          $datos['archivo_cierre'] = $filename;
        } else {
          $filename = 'Archivo no encontrado';
        }

        $datos['usr_cierre']   = $DatosUsuario[0]->empleado;
        $datos['fecha_cierre'] = NOW();
        $datos['desc_cierre']  = $descripcion;
        $datos['estado']       = 3; //Requerimiento pendiente de evaluar
        $datos['quien_cierra'] = 1; //Cuando el Cliente Cierra

        PanelSolicitudes::actualizarSolicitud($solicitud, $datos);

        $datos1 = array();

        $datos1['solicitud']   = $solicitud;
        $datos1['fecha']       = NOW();
        $datos1['usuario']     = $DatosUsuario[0]->empleado;
        //$datos1['descripcion'] = "Requerimiento atendido";
        $datos1['descripcion'] = $formData['descripcion'];

        $FechaCierre = $datos1['fecha'];

        PanelSolicitudes::insertarSolicitudDet($datos1);

        $Mensaje = "Requerimiento atendido.";

        $correoNotificacion  = $formData['correoNotificacion'];
        $numSolicitud  = $formData['solicitud'];

        $datosAsignado = PanelEmpleados::getEmpleado($asignado);
        $nombreEmpleado = $datosAsignado[0]->primer_nombre . ' ' . $datosAsignado[0]->ot_nombre . ' ' . $datosAsignado[0]->primer_apellido . ' ' . $datosAsignado[0]->ot_apellido;
        $correoEmpleado = $datosAsignado[0]->correo;

        if ($correoNotificacion == '' || $correoNotificacion == NULL || $correoNotificacion == 'No Aplica') {
          $correoNotificacion = 'informes@berhlan.com';
        }

        //if ($grupo == 1) {
        /* ENVIO NOTIFICACIÓN CIERRE DE CASO | CLIENTE */
        $datosEmail['nombre'] = 'TICKET CERRADO';
        $datosEmail['email'] = $correoNotificacion;
        $datosEmail['numsolicitud'] = $numSolicitud;
        $datosEmail['titsolicitud'] = $tituloSolicitud;
        $datosEmail['mensajel1'] = '¡Su caso ha sido cerrado con éxito!';
        $datosEmail['mensajel2'] = $FechaCierre;
        $datosEmail['mensajel3'] = '';
        $datosEmail['mensajel4'] = '';
        $datosEmail['mensajel5'] = '';
        $datosEmail['mensajel6'] = '';
        $datosEmail['link_ticket'] = 'https://192.168.1.210/Berhlan/public/panel/requerimientos/misrequerimientos/masinfo/' . $numSolicitud;

        Mail::send('email.notificacion_cerrado', $datosEmail, function ($message) use ($datosEmail) {
          $admin = $datosEmail['email'];
          $nombre = $datosEmail['nombre'];
          $message->subject('Notificaciones Intranet');
          $message->from('notificacionesberhlan@berhlan.com', $nombre);
          $message->to($admin);
        });
        /* ENVIO NOTIFICACIÓN ASIGNACIÓN DE CASO | CLIENTE */

        /* ENVIO NOTIFICACIÓN ASIGNACIÓN DE CASO | EMPLEADO */
        $datosEmailEmp['nombre'] = 'TICKET HA SIDO CERRADO';
        $datosEmailEmp['email'] = $correoEmpleado;
        $datosEmailEmp['empleado'] = $nombreEmpleado;
        $datosEmailEmp['numsolicitud'] = $numSolicitud;
        $datosEmailEmp['titsolicitud'] = $tituloSolicitud;
        $datosEmailEmp['mensajel1'] = '¡Su caso ha sido cerrado con éxito!';
        $datosEmailEmp['mensajel2'] = $FechaCierre;
        $datosEmailEmp['mensajel3'] = '';
        $datosEmailEmp['mensajel4'] = '';
        $datosEmailEmp['mensajel5'] = '';
        $datosEmailEmp['mensajel6'] = '';
        $datosEmailEmp['link_ticket'] = 'https://192.168.1.210/Berhlan/public/panel/requerimientos/atender/procesar/' . $numSolicitud;

        Mail::send('email.notificacion_cerrado', $datosEmailEmp, function ($message) use ($datosEmailEmp) {
          $admin = $datosEmailEmp['email'];
          $nombre = $datosEmailEmp['nombre'];
          $message->subject('Notificaciones Intranet');
          $message->from('notificacionesberhlan@berhlan.com', $nombre);
          $message->to($admin);
        });
        /* ENVIO NOTIFICACIÓN ASIGNACIÓN DE CASO | EMPLEADO */

        $Solicitud      = PanelSolicitudes::Encuesta($DatosUsuario[0]->empleado);
        $DatosSolicitud = PanelSolicitudes::getSolicitud($Solicitud[0]->num_solicitud);
        return view('requerimientos.panel-misrequerimientosEncuesta')->with('DatosUsuario', $DatosUsuario)->with('DatosSolicitud', $DatosSolicitud);
      } else {
        $Redireccion = "/panel/requerimientos/atender/listado/" . $grupo;
        return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
      }
      //}
    } else {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
    }
  }


  public function eliminar_tildes($cadena)
  {
    //Codificamos la cadena en formato utf8 en caso de que nos de errores
    //$cadena = utf8_encode($cadena);

    //Ahora reemplazamos las letras
    $cadena = str_replace(
      array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
      array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
      $cadena
    );

    $cadena = str_replace(
      array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
      array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
      $cadena
    );

    $cadena = str_replace(
      array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
      array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
      $cadena
    );

    $cadena = str_replace(
      array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
      array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
      $cadena
    );

    $cadena = str_replace(
      array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
      array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
      $cadena
    );

    $cadena = str_replace(
      array('ñ', 'Ñ', 'ç', 'Ç', ' ', '#', '%', '°', '´'),
      array('n', 'N', 'c', 'C', '_',  '',  '',  '',  ''),
      $cadena
    );
    return $cadena;
  }

  public function CerrarRequerimientosVencidos()
  {
    if (Session::has('user')) {
      $formData     = Request::all();
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);
      $datos = array();
      $datos1 = array();
      $Grupo        = $formData['grupo'];

      $RequerimientosVencidos = PanelSolicitudes::RequerimientosVencidos();

      foreach ($RequerimientosVencidos as $DataReqV) {
        $solicitud = $DataReqV->num_solicitud;

        $datos['usr_cierre']   = $DatosUsuario[0]->empleado;
        $datos['fecha_cierre'] = NOW();
        $datos['desc_cierre']  = 'Requerimiento Cerrado por estado Vencido';
        $datos['estado']       = 4; //Requerimiento cerrado
        $datos['calificacion']       = 'M';
        $datos['des_calificacion']   = 'Se da por terminado y solución satisfactoria del requerimiento';
        $datos['quien_cierra'] = 2; //Cuando el Equipo Cierra

        PanelSolicitudes::actualizarSolicitud($solicitud, $datos);

        $datos1['solicitud']   = $solicitud;
        $datos1['fecha']       = NOW();
        $datos1['usuario']     = $DatosUsuario[0]->empleado;
        $datos1['descripcion'] = "Requerimiento atendido";

        PanelSolicitudes::insertarSolicitudDet($datos1);
      }

      $Mensaje = "Requerimientos Cerrados.";
      $Redireccion = "/panel/requerimientos/atender/listado/" . $Grupo;
      return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
    } else {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
    }
  }

  /* Nuevas Funciones */
  public function AtenderListadoPersona($id, $idus)
  {
    if (Session::has('user')) {
      $Grupo        = $id;
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if ($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
      {
        $ruta      = "requerimientos/atender";
        $DatosMenu = PanelLogin::getMenuRuta($ruta);
        if ($DatosMenu[0]->libre_acceso == 0)  //Si el modulo no es de libre acceso
        {
          $idmenu    = $DatosMenu[0]->id_menu;

          $ModUser    = explode(',', $DatosUsuario[0]->modulos);
          $NumModUser = count($ModUser);
          $acceso     = 0;
          for ($i = 0; $i < $NumModUser; $i++) {
            if ($idmenu == $ModUser[$i]) {
              $acceso = 1;
              break;
            }
          }

          if ($acceso == 0) //El usuario no tiene acceso al modulo
          {
            $ErrorValidacion = "Usted no tiene acceso al módulo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
          }
        }
      }
      //Termina validación

      //Valido que tenga acceso a las categorías del grupo seleccionado
      if ($DatosUsuario[0]->master == 0) {
        $AccesoGrupo = PanelGrupos::getEmpleadoUnico($Grupo, $DatosUsuario[0]->empleado);
        if ($AccesoGrupo == 0) //El usuario no tiene acceso al grupo
        {
          $ErrorValidacion = "Usted no tiene acceso al grupo seleccionado.";
          return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
      }

      $DatosSolicitudes = PanelSolicitudes::getSolicitudesAbiertasGrupoUsuario($Grupo, $idus);
      $RequerimientosVencidosCant = PanelSolicitudes::RequerimientosVencidosCant();

      return view('requerimientos.panel-atenderListado')->with('DatosUsuario', $DatosUsuario)->with('DatosSolicitudes', $DatosSolicitudes)->with('Grupo', $Grupo)->with('RequerimientosVencidosCant', $RequerimientosVencidosCant)->with('idus', $idus);
    } else {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
    }
  }

  public function AtenderListadoPersonaNotificado($id, $idus)
  {
    if (Session::has('user')) {
      $Grupo        = $id;
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if ($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
      {
        $ruta      = "requerimientos/atender";
        $DatosMenu = PanelLogin::getMenuRuta($ruta);
        if ($DatosMenu[0]->libre_acceso == 0)  //Si el modulo no es de libre acceso
        {
          $idmenu    = $DatosMenu[0]->id_menu;

          $ModUser    = explode(',', $DatosUsuario[0]->modulos);
          $NumModUser = count($ModUser);
          $acceso     = 0;
          for ($i = 0; $i < $NumModUser; $i++) {
            if ($idmenu == $ModUser[$i]) {
              $acceso = 1;
              break;
            }
          }

          if ($acceso == 0) //El usuario no tiene acceso al modulo
          {
            $ErrorValidacion = "Usted no tiene acceso al módulo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
          }
        }
      }
      //Termina validación

      //Valido que tenga acceso a las categorías del grupo seleccionado
      if ($DatosUsuario[0]->master == 0) {
        $AccesoGrupo = PanelGrupos::getEmpleadoUnico($Grupo, $DatosUsuario[0]->empleado);
        if ($AccesoGrupo == 0) //El usuario no tiene acceso al grupo
        {
          $ErrorValidacion = "Usted no tiene acceso al grupo seleccionado.";
          return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
      }

      $DatosSolicitudes = PanelSolicitudes::getSolicitudesAbiertasNotificadosGrupoUsuario($id, $idus);
      $RequerimientosVencidosCant = PanelSolicitudes::RequerimientosVencidosCant();

      return view('requerimientos.panel-atenderListado')->with('DatosUsuario', $DatosUsuario)->with('DatosSolicitudes', $DatosSolicitudes)->with('Grupo', $Grupo)->with('RequerimientosVencidosCant', $RequerimientosVencidosCant)->with('idus', $idus);
    } else {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
    }
  }

  public function AtenderListadoPersonaTodos($id, $idus)
  {
    if (Session::has('user')) {
      $Grupo        = $id;
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if ($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
      {
        $ruta      = "requerimientos/atender";
        $DatosMenu = PanelLogin::getMenuRuta($ruta);
        if ($DatosMenu[0]->libre_acceso == 0)  //Si el modulo no es de libre acceso
        {
          $idmenu    = $DatosMenu[0]->id_menu;

          $ModUser    = explode(',', $DatosUsuario[0]->modulos);
          $NumModUser = count($ModUser);
          $acceso     = 0;
          for ($i = 0; $i < $NumModUser; $i++) {
            if ($idmenu == $ModUser[$i]) {
              $acceso = 1;
              break;
            }
          }

          if ($acceso == 0) //El usuario no tiene acceso al modulo
          {
            $ErrorValidacion = "Usted no tiene acceso al módulo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
          }
        }
      }
      //Termina validación

      //Valido que tenga acceso a las categorías del grupo seleccionado
      if ($DatosUsuario[0]->master == 0) {
        $AccesoGrupo = PanelGrupos::getEmpleadoUnico($Grupo, $DatosUsuario[0]->empleado);
        if ($AccesoGrupo == 0) //El usuario no tiene acceso al grupo
        {
          $ErrorValidacion = "Usted no tiene acceso al grupo seleccionado.";
          return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
      }

      $DatosSolicitudes = PanelSolicitudes:: getSolicitudesAbiertasTodosGrupoUsuario($id, $idus);
      $RequerimientosVencidosCant = PanelSolicitudes::RequerimientosVencidosCant();

      return view('requerimientos.panel-atenderListado')->with('DatosUsuario', $DatosUsuario)->with('DatosSolicitudes', $DatosSolicitudes)->with('Grupo', $Grupo)->with('RequerimientosVencidosCant', $RequerimientosVencidosCant)->with('idus', $idus);
    } else {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
    }
  }

  public function AtenderListadoCategoria($id, $categoria)
  {
    if (Session::has('user')) {
      $Grupo        = $id;
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if ($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
      {
        $ruta      = "requerimientos/atender";
        $DatosMenu = PanelLogin::getMenuRuta($ruta);
        if ($DatosMenu[0]->libre_acceso == 0)  //Si el modulo no es de libre acceso
        {
          $idmenu    = $DatosMenu[0]->id_menu;

          $ModUser    = explode(',', $DatosUsuario[0]->modulos);
          $NumModUser = count($ModUser);
          $acceso     = 0;
          for ($i = 0; $i < $NumModUser; $i++) {
            if ($idmenu == $ModUser[$i]) {
              $acceso = 1;
              break;
            }
          }

          if ($acceso == 0) //El usuario no tiene acceso al modulo
          {
            $ErrorValidacion = "Usted no tiene acceso al módulo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
          }
        }
      }
      //Termina validación

      //Valido que tenga acceso a las categorías del grupo seleccionado
      if ($DatosUsuario[0]->master == 0) {
        $AccesoGrupo = PanelGrupos::getEmpleadoUnico($Grupo, $DatosUsuario[0]->empleado);
        if ($AccesoGrupo == 0) //El usuario no tiene acceso al grupo
        {
          $ErrorValidacion = "Usted no tiene acceso al grupo seleccionado.";
          return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
      }

      $DatosSolicitudes = PanelSolicitudes::getSolicitudesAbiertasGrupoCategoria($Grupo, $categoria);
      $RequerimientosVencidosCant = PanelSolicitudes::RequerimientosVencidosCant();

      return view('requerimientos.panel-atenderListado')->with('DatosUsuario', $DatosUsuario)->with('DatosSolicitudes', $DatosSolicitudes)->with('Grupo', $Grupo)->with('RequerimientosVencidosCant', $RequerimientosVencidosCant)->with('categoria', $categoria);
    } else {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
    }
  }

  public function AtenderListadoCategoriaNotificado($id, $categoria)
  {
    if (Session::has('user')) {
      $Grupo        = $id;
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if ($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
      {
        $ruta      = "requerimientos/atender";
        $DatosMenu = PanelLogin::getMenuRuta($ruta);
        if ($DatosMenu[0]->libre_acceso == 0)  //Si el modulo no es de libre acceso
        {
          $idmenu    = $DatosMenu[0]->id_menu;

          $ModUser    = explode(',', $DatosUsuario[0]->modulos);
          $NumModUser = count($ModUser);
          $acceso     = 0;
          for ($i = 0; $i < $NumModUser; $i++) {
            if ($idmenu == $ModUser[$i]) {
              $acceso = 1;
              break;
            }
          }

          if ($acceso == 0) //El usuario no tiene acceso al modulo
          {
            $ErrorValidacion = "Usted no tiene acceso al módulo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
          }
        }
      }
      //Termina validación

      //Valido que tenga acceso a las categorías del grupo seleccionado
      if ($DatosUsuario[0]->master == 0) {
        $AccesoGrupo = PanelGrupos::getEmpleadoUnico($Grupo, $DatosUsuario[0]->empleado);
        if ($AccesoGrupo == 0) //El usuario no tiene acceso al grupo
        {
          $ErrorValidacion = "Usted no tiene acceso al grupo seleccionado.";
          return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
      }

      $DatosSolicitudes = PanelSolicitudes::getSolicitudesAbiertasNotificadosGrupoCategoria($id, $categoria);
      $RequerimientosVencidosCant = PanelSolicitudes::RequerimientosVencidosCant();

      return view('requerimientos.panel-atenderListado')->with('DatosUsuario', $DatosUsuario)->with('DatosSolicitudes', $DatosSolicitudes)->with('Grupo', $Grupo)->with('RequerimientosVencidosCant', $RequerimientosVencidosCant)->with('categoria', $categoria);
    } else {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
    }
  }
  /* Nuevas Funciones */
}
