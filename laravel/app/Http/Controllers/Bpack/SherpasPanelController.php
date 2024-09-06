<?php
/*
Controlador de la tabla bpac_solicitudan
Usa SQl Eloquent de los archivos
app\Models\Bpack\PanelSolicitudesAN.php
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


class SherpasPanelController extends Controller
{
  public function PendientesSherpa()
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

      $PenSherpa = PanelSolicitudesAN::PendientesSherpa();

      return view('bpack.panel-pendientesSherpa')->with('DatosUsuario', $DatosUsuario)->with('PenSherpa', $PenSherpa);
    } else {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
    }
  }


  public function PendientesSherpaProcesar($id)
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
        if ($DatSol->estado != 4)
          $i++;
      }

      if ($e == 0) {
        $Mensaje     = "Esta solicitud no existe.";
        $Redireccion = "/panel/bpack/pensherpa";
        return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
      }

      if ($i != 0) {
        $Mensaje     = "Esta solicitud ya no esta pendiente de aprobación sherpas digitales.";
        $Redireccion = "/panel/bpack/pensherpa";
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

      return view('bpack.panel-pendientesSherpaProcesar')->with('DatosUsuario', $DatosUsuario)->with('DatosSolicitud', $DatosSolicitud);
    } else {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
    }
  }


  public function PendientesSherpaProcesarDB()
  {
    if (Session::has('user')) {
      $formData      = Request::all();
      $solicitud     = $formData['solicitud'];
      $tipo          = $formData['tipo'];
      $observaciones = trim($formData['observaciones']);
      $user          = Session::get('user');
      $DatosUsuario  = PanelLogin::getUsuario($user);

      $DatosSolicitud = PanelSolicitudesAN::SolicitudAN($solicitud);
      if ($DatosSolicitud[0]->estado != 4) {
        $Mensaje     = "Esta solicitud ya no esta pendiente por aprobación de sherpa.";
        $Redireccion = "/panel/bpack/pensherpa";
        return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
      }

      $ano   = date('Y');
      $mes   = date('m') * 1;
      $ruta  = substr(public_path(), 0, -14) . "public/archivos/Bpack/Solicitudes/" . $ano . "/" . $mes . "/";
      $ruta1 = substr(public_path(), 0, -14) . "public/archivos/Bpack/Solicitudes/";

      $DetSolicitud = PanelSolicitudesAN::DetSolicitudan($solicitud);

      $rech    = 0;
      $motivo1 = 0;

      foreach ($DetSolicitud as $DatSol) {
        $registro = $DatSol->registro;
        $textapr  = "regaprobado_" . $registro;
        $apr      = $formData[$textapr];
        if ($apr != 'S')  //Si el registro no había sido aprobado previamente
        {
          $datos = array();
          $textregapr = "aprueba_" . $registro;
          $regapr     = $formData[$textregapr];
          if ($regapr == "S")  //Si aprobó el registro
          {
            $textsherpa  = "file2_" . $registro;
            $textsherpa1 = "uploader2_" . $registro;
            $fileImg     = $formData[$textsherpa1];

            if ($fileImg != '')  //Si adjunto el archivo
            {
              //Borro el archivo anterior, si existe
              if ($DatSol->ruta_sherpa != "") {
                $borrar = $ruta1 . $DatSol->ruta_sherpa;
                if (file_exists($borrar))
                  unlink($borrar);
              }

              $file          = Request::file($textsherpa);
              $filename      = $file->getClientOriginalName();
              $filename      = SherpasPanelController::eliminar_tildes($filename);
              $filename      = $ano . "/" . $mes . "/B" . $solicitud . "_SHERPADIG_" . $filename;
              $uploadSuccess = $file->move($ruta, $filename);

              $datos['ruta_sherpa'] = $filename;
            }

            $datos['aprobado1'] = "S";
          } else   //El registro no fue aprobado
          {
            $rech = 1;
            $textversion = "version_" . $registro;
            $textmotivo  = "motivo_" . $registro;
            $motivo      = $formData[$textmotivo];

            if ($motivo1 == 0)
              $motivo1 = $motivo;

            $datos['version']        = $formData[$textversion];
            $datos['motivo_rechazo'] = $motivo;
            $datos['aprobado']       = "N";
            $datos['aprobado1']      = "N";

            if ($tipo == "SBA")  //Si es actualización
            {
              $textitem = "item_" . $registro;
              $item     = $formData[$textitem];
              //Debo consultar en siesa la referencia del ítem escogido
              $referencia = PanelItemEtiquetas::Referencia($item);

              $datos['item']       = $item;
              $datos['referencia'] = $referencia[0]->f120_notas;

              $textarte  = "file1_" . $registro;
              $textarte1 = "uploader1_" . $registro;
              $fileImg  = $formData[$textarte1];
              if ($fileImg != '')  //Si adjunto el arte
              {
                //Borro el archivo anterior
                $borrar = $ruta1 . $DatSol->ruta_arte;
                if (file_exists($borrar))
                  unlink($borrar);

                $file          = Request::file($textarte);
                $filename      = $file->getClientOriginalName();
                $filename      = SherpasPanelController::eliminar_tildes($filename);
                $filename      = $ano . "/" . $mes . "/B" . $solicitud . "_ARTE_" . $filename;
                $uploadSuccess = $file->move($ruta, $filename);

                $datos['ruta_arte'] = $filename;
              }
            }
          }

          if ($tipo == "SBM")  //Si es nuevo desarrollo
          {
            //$textitem = "item_" . $registro;
            //$item     = $formData[$textitem];
            //Debo consultar en siesa la referencia del ítem escogido
            //$referencia = PanelItemEtiquetas::Referencia($item);

            //$datos['item']       = $formData['item'];
            //$datos['referencia']       = $formData['referencia'];
            //$datos['referencia'] = 'No Aplica';
          }

          PanelSolicitudesAN::actualizarSolicitudDetAN($solicitud, $registro, $datos);
        }
      }

      $datos1 = array();

      if ($rech == 0) //Si todo quedo aprobado
      {
        $estado = 6; //Pendiente de prueba de contrato
        $info   = "Solicitud aprobada - Pendiente de P.C. ";
      } else {
        $estado = 5; //Rechazada - pendiente de aprobación por preprensa
        $info = "Solicitud rechazada. ";

        if ($tipo == "SBM")  //Si es actualización
        {
          $fileImg = $formData['uploaderT1'];
          if ($fileImg != '')  //Si adjunto el arte
          {
            //Borro el archivo anterior
            $borrar = $ruta1 . $DatosSolicitud[0]->artes;
            if (file_exists($borrar))
              unlink($borrar);

            $file          = Request::file('fileT1');
            $filename      = $file->getClientOriginalName();
            $filename      = SherpasPanelController::eliminar_tildes($filename);
            $filename      = $ano . "/" . $mes . "/BN_" . $solicitud . "_ARTES_" . $filename;
            $uploadSuccess = $file->move($ruta, $filename);

            $datos1['artes'] = $filename;
          }

          $fileImg1 = $formData['uploaderT2'];
          if ($fileImg1 != '')  //Si adjunto el archivo formato
          {
            //Borro el archivo anterior
            $borrar = $ruta1 . $DatosSolicitud[0]->formato;
            if (file_exists($borrar))
              unlink($borrar);

            $file          = Request::file('fileT2');
            $filename      = $file->getClientOriginalName();
            $filename      = SherpasPanelController::eliminar_tildes($filename);
            $filename      = $ano . "/" . $mes . "/BN_" . $solicitud . "_FORMATO_" . $filename;
            $uploadSuccess = $file->move($ruta, $filename);

            $datos1['formato'] = $filename;
          }
        }
      }

      $datos1['estado'] = $estado;
      PanelSolicitudesAN::actualizarSolicitudAN($solicitud, $datos1);

      $datos2 = array();
      $datos2['solicitud']      = $solicitud;
      $datos2['fecha']          = NOW();
      $datos2['estado']         = $estado;
      $datos2['observaciones']  = $info . $observaciones;
      $datos2['motivo_rechazo'] = $motivo1;
      $datos2['usuario']        = $DatosUsuario[0]->empleado;
      PanelSolicitudesAN::insertarMovimiento($datos2);

      $Mensaje     = "Revisión almacenada";
      $Redireccion = "/panel/bpack/pensherpa";
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
