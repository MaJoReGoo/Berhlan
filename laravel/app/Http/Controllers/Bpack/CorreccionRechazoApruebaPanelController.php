<?php
/*
Controlador de la tabla bpac_solicitudan
Usa SQl Eloquent de los archivos app\Models\Bpack\PanelSolicitudesAN.php
*/

namespace App\Http\Controllers\Bpack;

use App\Http\Controllers\Controller;
use App\Models\Bpack\PanelSolicitudesAN;
use App\Models\Bpack\PanelItemEtiquetas;
use App\Models\PanelLogin;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class CorreccionRechazoApruebaPanelController extends Controller
{
  public function CorreccionRechazoAprueba($area)
  {
    if (Session::has('user')) {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if ($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
      {
        $ruta      = "bpack/solpendientes";
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

      /*    print $area;
      die();
 */
      switch ($area) {

        case 0:
          $PenCorAprueba = PanelSolicitudesAN::PendientesCoreccAprueba();
          break;

        case 3:
          $estado = 3;
          $PenCorAprueba = PanelSolicitudesAN::PendientesCoreccApruebaEstado($estado);
          break;

        case 10:
          $estado = 10;
          $PenCorAprueba = PanelSolicitudesAN::PendientesCoreccApruebaEstado($estado);
          break;
      }

      return view('bpack.panel-pendientesCorrecAprueba')->with('DatosUsuario', $DatosUsuario)->with('PenCorAprueba', $PenCorAprueba);
    } else {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
    }
  }


  public function CorreccionRechazoApruebaProcesar($id)
  {
    if (Session::has('user')) {
      $Solicitud      = $id;
      $DatosSolicitud = PanelSolicitudesAN::SolicitudAN($Solicitud);
      $user           = Session::get('user');
      $DatosUsuario   = PanelLogin::getUsuario($user);

      $e = 0;
      $i = 0;
      foreach ($DatosSolicitud as $DatSol) {
        $e++;
        if ($DatSol->estado != 3)
          $i++;
      }

      if ($e == 0) {
        $Mensaje     = "Esta solicitud no existe.";
        $Redireccion = "/panel/bpack/correcaprueba/0";
        return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
      }

      if ($i != 0) {
        $Mensaje     = "Esta solicitud ya no esta pendiente corrección.";
        $Redireccion = "/panel/bpack/correcaprueba/0";
        return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
      }

      //Valido que el usuario tenga acceso
      if ($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
      {
        $ruta      = "bpack/solpendientes";
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

      return view('bpack.panel-pendientesCorrecApruebaProcesar')->with('DatosUsuario', $DatosUsuario)->with('DatosSolicitud', $DatosSolicitud);
    } else {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
    }
  }


  public function CorreccionRechazoApruebaProcesarDB()
  {
    if (Session::has('user')) {
      $formData      = Request::all();
      $solicitud     = $formData['solicitud'];
      $soltipo       = $formData['soltipo'];
      $observaciones = trim($formData['observaciones']);
      $user          = Session::get('user');
      $DatosUsuario  = PanelLogin::getUsuario($user);

      $DatosSolicitud = PanelSolicitudesAN::SolicitudAN($solicitud);
      if ($DatosSolicitud[0]->estado != 3) {
        $Mensaje     = "Esta solicitud ya no esta pendiente corrección.";
        $Redireccion = "/panel/bpack/correcaprueba/0";
        return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
      }

      $ano   = date('Y');
      $mes   = date('m') * 1;
      $ruta  = substr(public_path(), 0, -14) . "public/archivos/Bpack/Solicitudes/" . $ano . "/" . $mes . "/";
      $ruta1 = substr(public_path(), 0, -14) . "public/archivos/Bpack/Solicitudes/";

      $datos = array();
      $datos['estado'] = 2; //Pendiente de aprobación por preprensa

      if ($soltipo == "SBM")  //Si es un nuevo desarrollo
      {
        //Si cambiaron los artes
        $fileImg  = $formData['uploaderT1'];
        $fileImg1 = $formData['uploaderT2'];

        if ($fileImg != '')  //Si adjunto el archivo
        {
          //Borro el archivo anterior
          $borrar = $ruta1 . $DatosSolicitud[0]->artes;
          if (file_exists($borrar))
            unlink($borrar);

          $file          = Request::file('fileT1');
          $filename      = $file->getClientOriginalName();
          $filename      = CorreccionRechazoApruebaPanelController::eliminar_tildes($filename);
          $filename      = $ano . "/" . $mes . "/BN_" . $solicitud . "_ARTES_" . $filename;
          $uploadSuccess = $file->move($ruta, $filename);

          $datos['artes'] = $filename;
        }

        if ($fileImg1 != '')  //Si adjunto el archivo formato
        {
          //Borro el archivo anterior
          $borrar = $ruta1 . $DatosSolicitud[0]->formato;
          if (file_exists($borrar))
            unlink($borrar);

          $file          = Request::file('fileT2');
          $filename      = $file->getClientOriginalName();
          $filename      = CorreccionRechazoApruebaPanelController::eliminar_tildes($filename);
          $filename      = $ano . "/" . $mes . "/BN_" . $solicitud . "_FORMATO_" . $filename;
          $uploadSuccess = $file->move($ruta, $filename);

          $datos['formato'] = $filename;
        }
      }

      PanelSolicitudesAN::actualizarSolicitudAN($solicitud, $datos);

      $DetSolicitud = PanelSolicitudesAN::DetSolicitudan($solicitud);

      foreach ($DetSolicitud as $DatSol) {
        $r        = $DatSol->registro;
        $textapr  = "aprobado_" . $r;
        $aprobado = $formData[$textapr];
        if ($aprobado == "N") {
          $datos1 = array();

          $textver           = "version_" . $r;
          $datos1['version'] = $formData[$textver];

          if ($soltipo == "SBA")  //Si es una actualización
          {
            $textitem   = "item_" . $r;
            $item       = $formData[$textitem];
            $referencia = PanelItemEtiquetas::Referencia($item);

            $datos1['item']       = $item;
            $datos1['referencia'] = $referencia[0]->f120_notas;

            //Procedo a actualizar el archivo si es necesario
            $textarc  = "file1_" . $r;
            $textarc1 = "uploader1_" . $r;
            $fileImg  = $formData[$textarc1];

            if ($fileImg != '')  //Si adjunto el archivo
            {
              //Borro el archivo anterior
              $borrar = $ruta1 . $DatSol->ruta_arte;
              if (file_exists($borrar))
                unlink($borrar);

              $file          = Request::file($textarc);
              $filename      = $file->getClientOriginalName();
              $filename      = CorreccionRechazoApruebaPanelController::eliminar_tildes($filename);
              $filename      = $ano . "/" . $mes . "/B" . $solicitud . "_ARTE_" . $filename;
              $uploadSuccess = $file->move($ruta, $filename);

              $datos1['ruta_arte'] = $filename;
            }
          } else {
            if ($DatSol->item != 0)  //Si ítem ya había sido ingresado en un paso posterior
            {
              $textitem   = "item_" . $r;
              $item       = $formData[$textitem];
              $referencia = PanelItemEtiquetas::Referencia($item);

              $datos1['item']       = $item;
              $datos1['referencia'] = $referencia[0]->f120_notas;
            } else {
              $textrefer            = "referencia_" . $r;
              $datos1['referencia'] = $formData[$textrefer];
            }
          }

          $datos1['aprobado']       = "P";
          $datos1['motivo_rechazo'] = 0;
          PanelSolicitudesAN::actualizarSolicitudDetAN($solicitud, $r, $datos1);
        }
      }

      $Mensaje = "Solicitud corregida";

      $datos2 = array();
      $datos2['solicitud']      = $solicitud;
      $datos2['fecha']          = NOW();
      $datos2['estado']         = 2; //Pendiente de aprobación por preprensa
      $datos2['observaciones']  = "Solicitud corregida. " . $observaciones;
      $datos2['motivo_rechazo'] = 0;
      $datos2['usuario']        = $DatosUsuario[0]->empleado;
      PanelSolicitudesAN::insertarMovimiento($datos2);

      $Redireccion = "/panel/bpack/correcaprueba/0";
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
