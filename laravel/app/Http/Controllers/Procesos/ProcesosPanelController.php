<?php
/*
Controlador de la tabla proc_procesos
Usa SQl Eloquent del archivo app\Models\Procesos\PanelProcesos.php
*/

namespace App\Http\Controllers\Procesos;
use App\Http\Controllers\Controller;
use App\Models\PanelLogin;
use App\Models\Procesos\PanelMacroProcesos;
use App\Models\Procesos\PanelProcesos;
use Illuminate\Support\Facades\Session;
use Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class ProcesosPanelController extends Controller
 {
  public function listadoProcesos()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "procesos/procesos";
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

      $DatosMacroProcesos = PanelMacroProcesos::getMacroProcesos();
      return view('procesos.panel-procesos')->with('DatosUsuario',$DatosUsuario)->with('DatosMacroProcesos',$DatosMacroProcesos);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function ProcesosModificar($id)
   {
    if(Session::has('user'))
     {
      $idProceso    = $id;
      $DatosProceso = PanelProcesos::getProceso($idProceso);
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "procesos/procesos";
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

      if($DatosProceso == true)
       {
        return view('procesos.panel-procesosModificar')->with('DatosUsuario',$DatosUsuario)->with('DatosProceso',$DatosProceso);
       }
      else
       {
        $DatosMacroProcesos = PanelMacroProcesos::getMacroProcesos();
        return view('procesos.panel-procesos')->with('DatosUsuario',$DatosUsuario)->with('DatosMacroProcesos',$DatosMacroProcesos);
       }
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function ProcesosModificarDB()
   {
    if(Session::has('user'))
     {
      $formData      = Request::all();
      $login         = $formData['login'];
      $id_proceso    = $formData['id_proceso'];
      $descripcion   = trim($formData['descripcion']);
      $fondo         = trim($formData['fondo']);
      $posicion      = trim($formData['posicion']);
      $observaciones = trim($formData['observaciones']);
      $fileExcel     = $formData['uploader1'];
      $DatosUsuario  = PanelLogin::getUsuario($login);
      $DatosProceso  = PanelProcesos::getProceso($id_proceso);

      $datos    = array();

      //Realizo las validaciones
      $Mensaje = "";

      if($descripcion == "")
        $Mensaje = "Debe ingresar el nombre del proceso.";
      else if($fondo == "")
        $Mensaje = "Debe ingresar el color html que representa el proceso.";
      else if($posicion == "")
        $Mensaje = "Debe ingresar la posición.";
      else if(!ctype_digit($posicion))
        $Mensaje = "No es posible ingresar la posición. Solo debe contener números.";
      else if($observaciones == "")
        $Mensaje = "Debe ingresar las observaciones.";

      if($Mensaje != "")
       {
        $Redireccion = "/panel/procesos/procesos/modificar/".$id_proceso;
       }
      else
       {
        if($fileExcel != '')
         {
          //$ruta = "D:/xampp/htdocs/Berhlan/public/archivos/Procesos/"; ////funciona
          //$ruta = realpath(__DIR__.'../../../../../../../')."/Berhlan/public/archivos/Procesos/";  //funciona

          $ruta = substr(public_path(), 0, -14)."public/archivos/Procesos/";

          $file            = Request::file('file1');
          $destinationPath = $ruta;
          $filename        = $file->getClientOriginalName();
          $filename        = ProcesosPanelController::eliminar_tildes($filename);

          //Borro el segundo archivo
        //   if($DatosProceso[0]->ruta2 != '')
        //    {
        //     $borrar = $ruta.$DatosProceso[0]->ruta2;
        //     if(file_exists($borrar))
        //      unlink($borrar);
        //    }

          $datos['ruta1']  = $filename;
          $datos['fecha1'] = NOW();

          //Paso el primer archivo a ser segundo
          $datos['ruta2']  = "V2-".$DatosProceso[0]->ruta1;
          $datos['fecha2'] = $DatosProceso[0]->fecha1;

          //Renombre el segundo archivo agregándole V2- al inicio
          $archivo1 = $ruta.$DatosProceso[0]->ruta1;
          $archivo2 = $ruta."V2-".$DatosProceso[0]->ruta1;

          if (file_exists($filename)) {
            rename($archivo1, $archivo2, $context = null);
          }
          $uploadSuccess = $file->move($destinationPath, $filename);

         }
        else
         {
          $filename = 'Archivo no encontrado';
         }

        $datos['posicion']    = $posicion;
        $datos['descripcion'] = $descripcion;
        $datos['fondo']       = $fondo;

        PanelProcesos::actualizarProceso($id_proceso, $datos);

        //Ingresamos el log del cambio
        $cambio = "";
        if($fileExcel != '')
          $cambio = "Se actualizó el archivo. ";
        if($DatosProceso[0]->descripcion != $descripcion)
          $cambio = $cambio."Se actualizó el nombre del proceso (Antes - ".$DatosProceso[0]->descripcion."). ";
        if($DatosProceso[0]->fondo != $fondo)
          $cambio = $cambio."Se actualizó el color (Antes - ".$DatosProceso[0]->fondo."). ";
        if($DatosProceso[0]->posicion != $posicion)
          $cambio = $cambio."Se actualizó la posición (Antes - ".$DatosProceso[0]->posicion."). ";

        $cambio = $cambio."Observaciones: ".$observaciones.".";
        $datos1 = array();
        $datos1['proceso']       = $id_proceso;
        $datos1['observaciones'] = $cambio;
        $datos1['usuario']       = $DatosUsuario[0]->id_usuario;
        $datos1['fecha']         = NOW();

        PanelProcesos::insertarProcesoLog($datos1);

        $Mensaje     = "Proceso modificado.";
        $Redireccion = "/panel/procesos/procesos/modificar/".$id_proceso;
       }

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

    return strtoupper($cadena);
   }
 }
