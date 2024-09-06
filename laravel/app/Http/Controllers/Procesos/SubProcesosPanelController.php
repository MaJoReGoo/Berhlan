<?php
/*
Controlador de la tabla proc_subprocesos
Usa SQl Eloquent del archivo app\Models\Procesos\PanelSubProcesos.php
*/

namespace App\Http\Controllers\Procesos;
use App\Http\Controllers\Controller;
use App\Models\PanelLogin;
use App\Models\Procesos\PanelProcesos;
use App\Models\Procesos\PanelSubProcesos;
use App\Models\Procesos\PanelSubProceDocu;
use Illuminate\Support\Facades\Session;
use Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class SubProcesosPanelController extends Controller
 {
  public function SubProcesosAgregar($id)
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

      return view('procesos.panel-subProcesosAgregar')->with('DatosUsuario',$DatosUsuario)->with('DatosProceso',$DatosProceso);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function SubProcesosAgregarDB()
   {
    if(Session::has('user'))
     {
      $formData     = Request::all();
      $login        = $formData['login'];
      $proceso      = $formData['id_proceso'];
      $descripcion  = trim($formData['descripcion']);
      $numero       = trim($formData['numero']);
      $DatosUsuario = PanelLogin::getUsuario($login);

      $datos = array();

      //Realizo las validaciones
      $Mensaje = "";

      $SubProcesoDuplicado = PanelSubProcesos::getSubProcesoUnico($proceso, $descripcion);

      if($SubProcesoDuplicado != 0)
        $Mensaje = "Ya se encuentra un subproceso con esa descripción.";
      else if($descripcion == "")
        $Mensaje = "Debe ingresar la descripción.";
      else if($numero == "")
        $Mensaje = "Debe ingresar la posición.";
      else if(!ctype_digit($numero))
        $Mensaje = "No es posible ingresar la posición. Solo debe contener números.";

      if($Mensaje == "")
       {
        $datos['descripcion'] = $descripcion;
        $datos['proceso']     = $proceso;
        $datos['numero']      = $numero;

        PanelSubProcesos::insertarSubProceso($datos);

        $datos1 = array();
        $datos1['proceso']       = $proceso;
        $datos1['observaciones'] = "Se ingreso un nuevo subproceso. ".$descripcion;
        $datos1['usuario']       = $DatosUsuario[0]->id_usuario;
        $datos1['fecha']         = NOW();

        PanelProcesos::insertarProcesoLog($datos1);

        $Mensaje     = "Subproceso creado.";
       }

      $Redireccion = "/panel/procesos/subprocesos/agregar/".$proceso;
      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function SubProcesosModificar($id)
   {
    if(Session::has('user'))
     {
      $idSubProceso    = $id;
      $DatosSubProceso = PanelSubProcesos::getSubProceso($idSubProceso);
      $user            = Session::get('user');
      $DatosUsuario    = PanelLogin::getUsuario($user);

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

      return view('procesos.panel-subProcesosModificar')->with('DatosUsuario',$DatosUsuario)->with('DatosSubProceso',$DatosSubProceso);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function SubProcesosModificarDB()
   {
    if(Session::has('user'))
     {
      $formData      = Request::all();
      $login         = $formData['login'];
      $id_subproceso = $formData['id_subproceso'];
      $proceso       = $formData['proceso'];
      $descripcion   = trim($formData['descripcion']);
      $numero        = trim($formData['numero']);


      $datos = array();

      //Realizo las validaciones
      $Mensaje = "";

      $SubProcesoDuplicado = PanelSubProcesos::getSubProcesoUnicoMod($id_subproceso, $descripcion);

      if($SubProcesoDuplicado != 0)
        $Mensaje = "Ya se encuentra un subproceso con esa descripción.";
      else if($descripcion == "")
        $Mensaje = "Debe ingresar la descripción.";
      else if($numero == "")
        $Mensaje = "Debe ingresar la posición.";
      else if(!ctype_digit($numero))
        $Mensaje = "No es posible ingresar la posición. Solo debe contener números.";

      if($Mensaje != "")
       {
        $Redireccion = "/panel/procesos/subprocesos/modificar/".$id_subproceso;
       }
      else
       {
        $datos['descripcion'] = $descripcion;
        $datos['proceso']     = $proceso;
        $datos['numero']      = $numero;

        PanelSubProcesos::actualizarSubProceso($id_subproceso,$datos);

        $DatosUsuario  = PanelLogin::getUsuario($login);

        $datos1 = array();
        $datos1['proceso']       = $proceso;
        $datos1['observaciones'] = "Se modifico el subproceso. ".$descripcion.".";
        $datos1['usuario']       = $DatosUsuario[0]->id_usuario;
        $datos1['fecha']         = NOW();

        PanelProcesos::insertarProcesoLog($datos1);

        $Mensaje     = "Subproceso modificado.";
        $Redireccion = "/panel/procesos/subprocesos/modificar/".$id_subproceso;
       }

      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function SubProcesosEliminarDB()
   {
    if(Session::has('user'))
     {
      $formData        = Request::all();
      $idSubProceso    = $formData['id_subproceso'];
      $DatosSubProceso = PanelSubProcesos::getSubProceso($idSubProceso);
      $user            = Session::get('user');
      $DatosUsuario    = PanelLogin::getUsuario($user);

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

      $proceso = $DatosSubProceso[0]->proceso;
      $datos   = array();

      $datos['proceso']       = $proceso;
      $datos['observaciones'] = "Se elimino el subproceso. ".$DatosSubProceso[0]->descripcion.".";
      $datos['usuario']       = $DatosUsuario[0]->id_usuario;
      $datos['fecha']         = NOW();

      PanelProcesos::insertarProcesoLog($datos);
      PanelSubProceDocu::BorrarSubProceDocu($idSubProceso);
      PanelSubProcesos::BorrarSubProceso($idSubProceso);

      $Mensaje     = "Subproceso eliminado.";
      $Redireccion = "/panel/procesos/procesos/modificar/".$proceso;
      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }
 }