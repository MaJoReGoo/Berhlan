<?php
/*
Controlador de la tabla requ_solicitud
Usa SQl Eloquent del archivo app\Models\Requerimientos\PanelSolicitudes.php
*/

namespace App\Http\Controllers\Requerimientos;

use App\Http\Controllers\Controller;
use App\Models\PanelLogin;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Requerimientos\PanelSolicitudes;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;


class MisRequerimientosPanelController extends Controller
{
  public function MisRequerimientos()
  {
    if (Session::has('user')) {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if ($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
      {
        $ruta      = "requerimientos/misrequerimientos";
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

      //Valido si tiene encuestas pendientes de contestar
      $encuesta = PanelSolicitudes::EncuestasPendientes($DatosUsuario[0]->empleado);
      if ($encuesta > 0) {
        $Solicitud      = PanelSolicitudes::Encuesta($DatosUsuario[0]->empleado);
        $DatosSolicitud = PanelSolicitudes::getSolicitud($Solicitud[0]->num_solicitud);
        return view('requerimientos.panel-misrequerimientosEncuesta')->with('DatosUsuario', $DatosUsuario)->with('DatosSolicitud', $DatosSolicitud);
      } else {
        return view('requerimientos.panel-misrequerimientos')->with('DatosUsuario', $DatosUsuario);
      }
    } else {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
    }
  }

  public function EncuestaDB()
  {
    if (Session::has('user')) {
      $formData    = Request::all();
      $solicitud   = $formData['solicitud'];
      $descripcion = trim($formData['descripcion']);
      $encuesta    = $formData['encuesta'];
      $user        = Session::get('user');

      $datos = array();

      $datos['calificacion']       = $encuesta;
      $datos['des_calificacion']   = $descripcion;
      $datos['fecha_calificacion'] = NOW();
      $datos['estado']             = 4;

      PanelSolicitudes::actualizarSolicitud($solicitud, $datos);

      $Mensaje     = "Gracias por su respuesta";
      $Redireccion = "/panel/requerimientos/misrequerimientos";
      return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
    } else {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
    }
  }

  public function SolicitudAgregarDB()
  {
    if (Session::has('user')) {
      $formData    = Request::all();
      $descripcion = trim($formData['descripcion']);
      $grupo       = $formData['grupo'];

      //Recepción de Archivos
      if (isset($formData['files'])) {
        $tamFiles = sizeof($formData['files']);
        $files = $formData['files'];
      } else {
        $tamFiles = 0;
      }

      $user        = Session::get('user');

      if ($formData['email_notificacion'] != '') {
        $emailNot     = $formData['email_notificacion'];
      } else {
        $emailNot     = 'No Aplica';
      }

      if ($formData['cel_notificacion'] != '') {
        $celNot     = $formData['cel_notificacion'];
      } else {
        $celNot     = 'No Aplica';
      }

      $datos = array();

      //Realizo las validaciones
      $Mensaje = "";

      if ($descripcion == "")
        $Mensaje = "Debe ingresar la solicitud.";
      else if ($grupo == "")
        $Mensaje = "Debe seleccionar el grupo.";

      if ($Mensaje == "") {
        $DatosUsuario  = PanelLogin::getUsuario($user);
        $DatosEmpleado = PanelEmpleados::getEmpleado($DatosUsuario[0]->empleado);

        $datos['grupo']            = $grupo;
        $datos['descripcion']      = $descripcion;
        $datos['archivo']          = '';
        $datos['usr_solicita']     = $DatosUsuario[0]->empleado;
        $datos['fecha_solicita']   = NOW();
        $datos['centro_solicitud'] = $DatosEmpleado[0]->centro_op;
        $datos['cargo_solicitud']  = $DatosEmpleado[0]->cargo;
        $datos['estado']           = 1;
        $datos['creado_por']       = 0;
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
        $datos['email_notificacion'] = $emailNot;
        $datos['cel_notificacion'] = $celNot;

        PanelSolicitudes::insertarSolicitud($datos);
        $solicitud = PanelSolicitudes::UltimaSolicitud();

        //Verificamos que hayan Archivos
        if ($tamFiles != 0) {

          $datosFiles = array();

          foreach ($files as $fileImg) {
            $ano = date('Y');
            $mes = date('m') * 1;
            $filename = $fileImg->getClientOriginalName();
            $filename = MisRequerimientosPanelController::eliminar_tildes($filename);

            $extension = explode(".", $filename);
            $f         = count($extension);
            $final     = strtolower($extension[$f - 1]);

            $destinationPath = substr(public_path(), 0, -14) . "public/archivos/Requerimientos/" . $ano . "/" . $mes . "/";

            $filename = $ano . "/" . $mes . "/Req_" . $solicitud->num_solicitud . "_anexo_" . substr($filename, 0, 5) . '.' . $final;
            $uploadSuccess   = $fileImg->move($destinationPath, $filename);

            $datosFiles['solicitud'] = $solicitud->num_solicitud;
            $datosFiles['fecha'] = NOW();
            $datosFiles['usuario'] = $DatosUsuario[0]->empleado;
            $datosFiles['descripcion'] = 'Archivo de Inicio';
            $datosFiles['archivo'] = $filename;

            PanelSolicitudes::insertarSolicitudIniFiles($datosFiles);
          }
        }

        $Mensaje   = "Requerimiento creado " . $solicitud->num_solicitud;
      }

      $Redireccion = "/panel/requerimientos/misrequerimientos";
      return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
    } else {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
    }
  }

  public function MisRequerimientosMasinfo($id)
  {
    if (Session::has('user')) {
      $Solicitud      = $id;
      $DatosSolicitud = PanelSolicitudes::getSolicitud($Solicitud);
      $user           = Session::get('user');
      $DatosUsuario   = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if ($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
      {
        $ruta      = "requerimientos/misrequerimientos";
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

      if ($DatosSolicitud[0]->usr_solicita != $DatosUsuario[0]->empleado) {
        $ErrorValidacion = "Usted no tiene acceso al requerimiento seleccionado.";
        return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
      }

      return view('requerimientos.panel-misrequerimientosMasinfo')->with('DatosUsuario', $DatosUsuario)->with('DatosSolicitud', $DatosSolicitud);
    } else {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
    }
  }

  public function InformacionAgregarDB()
  {
    if (Session::has('user')) {
      $formData    = Request::all();
      $descripcion = trim($formData['descripcion']);
      $solicitud   = $formData['solicitud'];
      $tituloSolicitud   = $formData['titulo_solicitud'];
      $grupo   = $formData['grupo'];
      $user        = Session::get('user');
      if (isset($formData['uploader2'])) {
        $fileImg      = $formData['uploader2'];
      } else {
        $fileImg = '';
      }

      $ruta        = $formData['ruta'];
      $correoNotificacion  = $formData['correoNotificacion'];
      $numSolicitud  = $formData['solicitud'];

      if ($correoNotificacion == '' || $correoNotificacion == NULL || $correoNotificacion == 'No Aplica') {
        $correoNotificacion = 'informes@berhlan.com';
      }

      $datos = array();

      //Realizo las validaciones
      $Mensaje = "";

      if ($descripcion == "")
        $Mensaje = "Debe ingresar la descripción.";

      if ($Mensaje == "") {
        if ($fileImg != '') {
          $ano = date('Y');
          $mes = date('m') * 1;
          $file     = Request::file('file2');
          $filename = $file->getClientOriginalName();
          $filename = MisRequerimientosPanelController::eliminar_tildes($filename);

          $extension = explode(".", $filename);
          $f         = count($extension);
          $final     = strtolower($extension[$f - 1]);

          $destinationPath = substr(public_path(), 0, -14) . "public/archivos/Requerimientos/" . $ano . "/" . $mes . "/";
          $filename        = $ano . "/" . $mes . "/Req_" . $solicitud . "_anexo_2." . $final;
          $uploadSuccess   = $file->move($destinationPath, $filename);

          $datos['archivo'] = $filename;
        } else {
          $filename = 'Archivo no encontrado';
        }
        $DatosUsuario         = PanelLogin::getUsuario($user);
        $datos['solicitud']   = $solicitud;
        $datos['fecha']       = NOW();
        $datos['usuario']     = $DatosUsuario[0]->empleado;
        $datos['descripcion'] = $descripcion;

        PanelSolicitudes::insertarSolicitudDet($datos);
      }

      //if ($grupo == 1) {
      /* ENVIO NOTIFICACIÓN ACTUALIZACIÓN DE CASO | CLIENTE */
      $datosEmail['nombre'] = 'NOTIFICACIÓN DE ACTUALIZACIÓN';
      $datosEmail['email'] = $correoNotificacion;
      $datosEmail['numsolicitud'] = $numSolicitud;
      $datosEmail['titsolicitud'] = $tituloSolicitud;
      $datosEmail['mensajel1'] = 'SU CASO';
      $datosEmail['mensajel2'] = 'Queremos informarle que su ticket tuvo una actualización recientemente';
      $datosEmail['mensajel3'] = $descripcion;
      $datosEmail['link_ticket'] = 'https://192.168.1.210/Berhlan/public/panel/requerimientos/misrequerimientos/masinfo/' . $numSolicitud;

      Mail::send('email.notificacion_requerimiento', $datosEmail, function ($message) use ($datosEmail) {
        $admin = $datosEmail['email'];
        $nombre = $datosEmail['nombre'];
        $message->subject('Notificaciones Intranet');
        $message->from('notificacionesberhlan@berhlan.com', $nombre);
        $message->to($admin);
      });
      /* ENVIO NOTIFICACIÓN ACTUALIZACIÓN DE CASO | CLIENTE */
      // }

      $Mensaje = "Información almacenada";

      if ($ruta != '')
        $Redireccion = $ruta . $solicitud;
      else
        $Redireccion = "/panel/requerimientos/misrequerimientos/masinfo/" . $solicitud;

      return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
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
}
