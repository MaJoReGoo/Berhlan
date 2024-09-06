<?php
/*
Controlador de la tabla acti_tareas
Usa SQl Eloquent del archivo app\Models\Bpack\PanelTareas.php
*/

namespace App\Http\Controllers\TicActivos;
use App\Http\Controllers\Controller;
use App\Models\TicActivos\PanelTareas;
use App\Models\PanelLogin;
use Illuminate\Support\Facades\Session;
use Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class TareasTicActivosPanelController extends Controller
 {
  public function Tareas()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "ticactivos/tareas";
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

      $DatosTareas     = PanelTareas::getTareas();
      $TareasActivas   = PanelTareas::getCantidadTareasActivas();
      $TareasInactivas = PanelTareas::getCantidadTareasInactivas();
      return view('ticactivos.panel-tareas')->with('DatosUsuario',$DatosUsuario)->with('DatosTareas',$DatosTareas)->with('TareasActivas',$TareasActivas)->with('TareasInactivas',$TareasInactivas);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function TareasAgregar()
   {
    if(Session::has('user'))
     {
      $ErrorValidacion = "";  //Variable que retorna el error en caso de que no pase la validación
      $user            = Session::get('user');
      $DatosUsuario    = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "ticactivos/tareas";
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

      return view('ticactivos.panel-tareasAgregar')->with('DatosUsuario',$DatosUsuario);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function TareasAgregarDB()
   {
    if(Session::has('user'))
     {
      $formData    = Request::all();
      $descripcion = trim($formData['descripcion']);

      $datos = array();

      //Realizo las validaciones
      $Mensaje = "";

      $TareaDuplicada = PanelTareas::getTareaUnica($descripcion);

      if($TareaDuplicada != 0)
        $Mensaje = "Ya se encuentra creada una tarea con esa descripción.";
      else if($descripcion == "")
        $Mensaje = "Debe ingresar la tarea.";

      if($Mensaje != "")
       {
        $Redireccion = "/panel/ticactivos/tareas/agregar";
       }
      else
       {
        $datos['descripcion'] = $descripcion;
        $datos['estado']      = 1; //Activo

        PanelTareas::insertarTarea($datos);
        $Mensaje = "Tarea creada.";

        //Agrego el guardado al log
        $user               = Session::get('user');
        $DatosUsuario       = PanelLogin::getUsuario($user);
        $idtarea            = PanelTareas::UltimaTarea();
        $datos1             = array();
        $datos1['modulo']   = 70;    //Tareas mantenimiento
        $datos1['tipo']     = "INS"; //Inserta
        $datos1['registro'] = "Id: ".$idtarea->id_tarea." |*| Descripción: ".$descripcion;
        $datos1['usuario']  = $DatosUsuario[0]->empleado;
        $datos1['fecha']    = NOW();
        PanelLogin::insertarLog($datos1);
        ////////////////////////////////

        $Redireccion = "/panel/ticactivos/tareas";
       }

      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function TareasModificar($id)
   {
    if(Session::has('user'))
     {
      $id_tarea      = $id;
      $DatosTarea    = PanelTareas::getTarea($id_tarea);
      $user          = Session::get('user');
      $DatosUsuario  = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "ticactivos/tareas";
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

      if($DatosTarea == true)
       {
        return view('ticactivos.panel-tareasModificar')->with('DatosUsuario',$DatosUsuario)->with('DatosTarea',$DatosTarea);
       }
      else
       {
        $Mensaje     = "";
        $Redireccion = "/panel/ticactivos/tareas";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function TareasModificarDB()
   {
    if(Session::has('user'))
     {
      $formData    = Request::all();
      $id_tarea    = $formData['id_tarea'];
      $descripcion = trim($formData['descripcion']);
      $estado      = $formData['estado'];

      $datos = array();

      //Realizo las validaciones
      $Mensaje = "";

      $TareaDuplicada = PanelTareas::getTareaUnicaModificar($descripcion, $id_tarea);

      if($TareaDuplicada != 0)
        $Mensaje = "Ya se encuentra creada una tarea con esa descripción.";
      else if($descripcion == "")
        $Mensaje = "Debe ingresar la tarea.";
      else if($estado == "")
        $Mensaje = "Debe seleccionar el estado.";

      if($Mensaje == "")
       {
        $datos['descripcion'] = $descripcion;
        $datos['estado']      = $estado;

        PanelTareas::actualizarTarea($id_tarea, $datos);
        $Mensaje = "Tarea modificada.";

        //Agrego el guardado al log
        $user               = Session::get('user');
        $DatosUsuario       = PanelLogin::getUsuario($user);
        $datos1             = array();
        $datos1['modulo']   = 70;    //Tareas de mantenimiento
        $datos1['tipo']     = "UPD"; //Actualiza
        $datos1['registro'] = "Id: ".$id_tarea." |*| Descripción: ".$descripcion." |*| Estado: ".$estado;
        $datos1['usuario']  = $DatosUsuario[0]->empleado;
        $datos1['fecha']    = NOW();
        PanelLogin::insertarLog($datos1);
        ////////////////////////////////
       }

      $Redireccion = "/panel/ticactivos/tareas/modificar/".$id_tarea;
      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }
 }