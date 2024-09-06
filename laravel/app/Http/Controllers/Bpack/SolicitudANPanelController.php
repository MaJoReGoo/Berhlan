<?php
/*
Controlador de la tabla bpac_solicitudan
Usa SQl Eloquent del archivo app\Models\Bpack\PanelSolicitudesan.php
*/

namespace App\Http\Controllers\Bpack;
use App\Http\Controllers\Controller;
use App\Models\PanelLogin;
use App\Models\Bpack\PanelItemEtiquetas;
use App\Models\Bpack\PanelSolicitudesAN;
use Illuminate\Support\Facades\Session;
use Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class SolicitudANPanelController extends Controller
 {
  public function SolicitudAN()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "bpack/solicitudan";
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

      return view('bpack.panel-solicitudAN')->with('DatosUsuario',$DatosUsuario);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function SolicitudANForm()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);
      $formData     = Request::all();
      $tipo         = $formData['tipo'];

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "bpack/solicitudan";
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

      if($tipo == "A")   //Si es actualización
       {
        $DatosItem = PanelItemEtiquetas::Items();
        return view('bpack.panel-solicitudAc')->with('DatosUsuario',$DatosUsuario)->with('DatosItem',$DatosItem);
       }
      else               //Si es nuevo desarrollo
       {
        return view('bpack.panel-solicitudNv')->with('DatosUsuario',$DatosUsuario);
       }
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function SolicitudANFormDB()
   {
    if(Session::has('user'))
     {
      $formData      = Request::all();
      $cliente       = trim($formData['cliente']);
      $observaciones = trim($formData['observaciones']);
      $tipo          = $formData['tipo'];
      $user          = Session::get('user');
      $DatosUsuario  = PanelLogin::getUsuario($user);

      $ano  = date('Y');
      $mes  = date('m')*1;
      $ruta = substr(public_path(), 0, -14)."public/archivos/Bpack/Solicitudes/".$ano."/".$mes."/";


      if($tipo == "A")  //Si es una actualización
       {
        $ultimoid = PanelSolicitudesAN::idactualizacion();
        $ultimoid = ($ultimoid->id_actualizacion)+1;

        $datos = array();

        $datos['id_actualizacion'] = $ultimoid;
        $datos['id_nvdesarrollo']  = 0;
        $datos['cliente']          = $cliente;
        $datos['tipo']             = $formData['actpara'];
        $datos['artes']            = "";
        $datos['formato']          = "";
        $datos['observaciones']    = $observaciones;
        $datos['estado']           = 1;
        $datos['usr_crea']         = $DatosUsuario[0]->empleado;
        $datos['fecha_crea']       = NOW();

        PanelSolicitudesAN::insertarSolicitudAN($datos);
        $numsol = PanelSolicitudesAN::UltimaSolicitudAN();

        $b = 0;
        $a = 1;
        $item = $formData['item'];

        foreach($item as $DatItem)
         {
          $datos1 = array();

          if($DatItem)  //Si ingreso el ítem
           {
            $referencia = PanelItemEtiquetas::Referencia($DatItem);
            $textver    = "version_".$a;
            $textarc    = "file1_".$a;
            $fileImg    = $formData[$textarc];

            if($fileImg!='')
             {
              $file          = Request::file($textarc);
              $filename      = $file->getClientOriginalName();
              $filename      = SolicitudANPanelController::eliminar_tildes($filename);
              $filename      = $ano."/".$mes."/B".$numsol->id_solicitud."_ARTE_".$filename;
              $uploadSuccess = $file->move($ruta, $filename);
             }
            else
             {
              $filename = 'Imagen no encontrada';
             }

            $b++;

            $datos1['solicitud']      = $numsol->id_solicitud;
            $datos1['registro']       = $b;
            $datos1['item']           = $DatItem;
            $datos1['referencia']     = $referencia[0]->f120_notas;
            $datos1['ruta_arte']      = $filename;
            $datos1['version']        = $formData[$textver];
            $datos1['ruta']           = "";
            $datos1['uso']            = 0;
            $datos1['aprobado']       = "P";
            $datos1['aprobado1']      = "P";
            $datos1['aprobado2']      = "";
            $datos1['ruta_sherpa']    = "";
            $datos1['prueba_fisica']  = "";
            $datos1['remision']       = "";
            $datos1['motivo_rechazo'] = 0;
            PanelSolicitudesAN::insertarSolicitudANdet($datos1);
           }
          $a++;
         }

        $Mensaje = "Solicitud creada con el número ".$numsol->id_solicitud." SBA".$ultimoid;

       }
      else if($tipo == "N")  //Si es un nuevo desarrollo
       {

        $ultimoid = PanelSolicitudesAN::idnvdesarrollo();
        $ultimoid = ($ultimoid->id_nvdesarrollo)+1;

        $fileImg = $formData['uploader1'];
        if($fileImg == '')
         {
          $Mensaje     = "No se encontró el arte";
          $Redireccion = "/panel/bpack/solicitudan";
          return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
         }

        $datos = array();

        $datos['id_actualizacion'] = 0;
        $datos['id_nvdesarrollo']  = $ultimoid;
        $datos['cliente']          = $cliente;
        $datos['tipo']             = "";
        $datos['artes']            = "";
        $datos['formato']          = "";
        $datos['observaciones']    = $observaciones;
        $datos['estado']           = 1;
        $datos['usr_crea']         = $DatosUsuario[0]->empleado;
        $datos['fecha_crea']       = NOW();

        PanelSolicitudesAN::insertarSolicitudAN($datos);
        $numsol = PanelSolicitudesAN::UltimaSolicitudAN();

        $Mensaje = "Solicitud creada con el número ".$numsol->id_solicitud." SBM".$ultimoid;

        $file          = Request::file('file1');
        $filename      = $file->getClientOriginalName();
        $filename      = SolicitudANPanelController::eliminar_tildes($filename);
        $filename      = $ano."/".$mes."/BN_".$numsol->id_solicitud."_ARTES_".$filename;
        $uploadSuccess = $file->move($ruta, $filename);

        $fileImg2  = $formData['uploader2'];
        $filename2 = "";
        if($fileImg2 != '')
         {
          $file2         = Request::file('file2');
          $filename2     = $file2->getClientOriginalName();
          $filename2     = SolicitudANPanelController::eliminar_tildes($filename2);
          $filename2     = $ano."/".$mes."/BN_".$numsol->id_solicitud."_FORMATO_".$filename2;
          $uploadSuccess = $file2->move($ruta, $filename2);
         }

        $datos1 = array();
        $datos['artes']   = $filename;
        $datos['formato'] = $filename2;
        PanelSolicitudesAN::actualizarSolicitudAN($numsol->id_solicitud, $datos);

        $b = 0;
        $a = 1;
        $referencia = $formData['referencia'];

        foreach($referencia as $DatRef)
         {
          $datos2 = array();

          if($DatRef)  //Si ingreso la referencia
           {
            $textver = "version_".$a;

            $b++;

            $datos1['solicitud']      = $numsol->id_solicitud;
            $datos1['registro']       = $b;
            $datos1['item']           = 0;
            $datos1['referencia']     = $DatRef;
            $datos1['ruta_arte']      = "";
            $datos1['version']        = $formData[$textver];
            $datos1['ruta']           = "";
            $datos1['uso']            = 0;
            $datos1['aprobado']       = "P";
            $datos1['aprobado1']      = "P";
            $datos1['aprobado2']      = "P";
            $datos1['ruta_sherpa']    = "";
            $datos1['prueba_fisica']  = "";
            $datos1['remision']       = "";
            $datos1['motivo_rechazo'] = 0;
            PanelSolicitudesAN::insertarSolicitudANdet($datos1);
           }
          $a++;
         }
       }

      $datos3 = array();
      $datos3['solicitud']      = $numsol->id_solicitud;
      $datos3['fecha']          = NOW();
      $datos3['estado']         = 1;
      $datos3['observaciones']  = "Solicitud ingresada. ".$observaciones;
      $datos3['motivo_rechazo'] = 0;
      $datos3['usuario']        = $DatosUsuario[0]->empleado;
      PanelSolicitudesAN::insertarMovimiento($datos3);

      $Redireccion = "/panel/menu/3";
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