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


class ApruebaPanelController extends Controller
 {
  public function PendientesAprueba()
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

      $PenAprueba = PanelSolicitudesAN::PendientesAprueba();

      return view('bpack.panel-pendientesAprueba')->with('DatosUsuario',$DatosUsuario)->with('PenAprueba',$PenAprueba);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function PendientesApruebaProcesar($id)
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
        if(($DatSol->estado != 2) && ($DatSol->estado != 5))
          $i++;
       }

      if($e == 0)
       {
        $Mensaje     = "Esta solicitud no existe.";
        $Redireccion = "/panel/bpack/penaprueba";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }

      if($i != 0)
       {
        $Mensaje     = "Esta solicitud ya no esta pendiente de aprobación.";
        $Redireccion = "/panel/bpack/penaprueba";
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

      return view('bpack.panel-pendientesApruebaProcesar')->with('DatosUsuario',$DatosUsuario)->with('DatosSolicitud',$DatosSolicitud);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function PendientesApruebaProcesarDB()
   {
    if(Session::has('user'))
     {
      $formData      = Request::all();
      $solicitud     = $formData['solicitud'];
      $observaciones = trim($formData['observaciones']);
      $aprueba       = $formData['aprueba'];
      $tipo          = $formData['tipo'];
      $user          = Session::get('user');
      $DatosUsuario  = PanelLogin::getUsuario($user);

      $datos = array();

      if($aprueba == "R")
        $estado = 3; //Pendiente de corrección
      else
        $estado = 4; //Pendiente de aprobación por Berhlan

      $datos['estado'] = $estado;

      PanelSolicitudesAN::actualizarSolicitudAN($solicitud, $datos);

      $ano   = date('Y');
      $mes   = date('m')*1;
      $ruta  = substr(public_path(), 0, -14)."public/archivos/Bpack/Solicitudes/".$ano."/".$mes."/";
      $ruta1 = substr(public_path(), 0, -14)."public/archivos/Bpack/Solicitudes/";

      $DetSolicitud = PanelSolicitudesAN::DetSolicitudan($solicitud);
      $mot1 = 0;
      foreach($DetSolicitud as $DatSol)
       {
        $registro = $DatSol->registro;
        $textaprobado = "aprobado_".$registro;
        $aprobadoant  = $formData[$textaprobado];
        if($aprobadoant != "S")
         {
          $datos1 = array();
          $textmotivo = "motivo_".$registro;
          $motivo  = $formData[$textmotivo];
          if($motivo != "")
           {
            $datos1['motivo_rechazo'] = $motivo;
            $datos1['aprobado']       = "N";
            if($mot1 == 0)
              $mot1 = $motivo;
           }
          else
           {
            if($tipo == "SBA")
             {
              $textprueba              = "prueba_".$registro;
              $datos1['prueba_fisica'] = $formData[$textprueba];
             }

            $textarc  = "file1_".$registro;
            $textarc1 = "uploader1_".$registro;
            $fileImg  = $formData[$textarc1];

            if($fileImg!='')  //Si adjunto el archivo
             {
              //Borro el archivo anterior, si existe
              if($DatSol->ruta_sherpa != "")
               {
                $borrar = $ruta1.$DatSol->ruta_sherpa;
                if(file_exists($borrar))
                  unlink($borrar);
               }

              $file          = Request::file($textarc);
              $filename      = $file->getClientOriginalName();
              $filename      = ApruebaPanelController::eliminar_tildes($filename);
              $filename      = $ano."/".$mes."/B".$solicitud."_SHERPADIG_".$filename;
              $uploadSuccess = $file->move($ruta, $filename);

              $datos1['ruta_sherpa'] = $filename;
             }
            $datos1['aprobado'] = "S";
           }

          PanelSolicitudesAN::actualizarSolicitudDetAN($solicitud, $registro, $datos1);
         }
       }

      $datos2 = array();
      $datos2['solicitud']      = $solicitud;
      $datos2['fecha']          = NOW();
      $datos2['estado']         = $estado;
      $datos2['observaciones']  = "Revisión preprensa. ".$observaciones;
      $datos2['motivo_rechazo'] = $mot1;
      $datos2['usuario']        = $DatosUsuario[0]->empleado;
      PanelSolicitudesAN::insertarMovimiento($datos2);

      $Mensaje     = "Revisión ingresada";
      $Redireccion = "/panel/bpack/penaprueba";
      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
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
                          $cadena);

    $cadena = str_replace(
                          array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
                          array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
                          $cadena);

    $cadena = str_replace(
                          array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
                          array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
                          $cadena);

    $cadena = str_replace(
                          array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
                          array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
                          $cadena);

    $cadena = str_replace(
                          array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
                          array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
                          $cadena);

    $cadena = str_replace(
                          array('ñ', 'Ñ', 'ç', 'Ç', ' ', '#', '%', '°', '´'),
                          array('n', 'N', 'c', 'C', '_',  '',  '',  '',  ''),
                          $cadena);
    return $cadena;
   }
 }