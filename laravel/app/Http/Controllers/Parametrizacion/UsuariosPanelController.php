<?php
/*
Controlador de la tabla param_usuarios
Usa SQl Eloquent del archivo app\Models\Parametrizacion\PanelUsuarios.php
*/

namespace App\Http\Controllers\Parametrizacion;

use App\Http\Controllers\Controller;
use App\Models\Parametrizacion\PanelUsuarios;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\PanelLogin;
use Illuminate\Support\Facades\Session;
use Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UsuariosPanelController extends Controller
 {
  public function showUsuarios()
   {
    if(Session::has('user'))
     {
      $user              = Session::get('user');
      $DatosUsuario      = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "parametrizacion/usuarios";
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

      $DatosUsr          = PanelUsuarios::getUsuarios();
      $UsuariosActivos   = PanelUsuarios::getCantidadUsuariosActivos();
      $UsuariosInactivos = PanelUsuarios::getCantidadUsuariosInactivos();
      return view('parametrizacion.panel-usuarios')->with('DatosUsuario',$DatosUsuario)->with('DatosUsr',$DatosUsr)->with('UsuariosActivos',$UsuariosActivos)->with('UsuariosInactivos',$UsuariosInactivos);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function UsuariosAgregar()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "parametrizacion/usuarios";
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

      return view('parametrizacion.panel-usuariosAgregar')->with('DatosUsuario',$DatosUsuario);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function UsuariosAgregarDB()
   {
    if(Session::has('user'))
     {
      $formData = Request::all();
      $empleado = trim($formData['empleado']);
      $login    = trim(strtoupper($formData['login']));
      $master   = trim($formData['master']);

      $datos = array();

      //Realizo las validaciones
      $Mensaje = "";

      $UsuarioDuplicado  = PanelUsuarios::getUsuarioLoginUnico($login);
      $EmpleadoDuplicado = PanelUsuarios::getUsuarioEmpleadoUnico($empleado);

      if($UsuarioDuplicado != 0)
        $Mensaje = "Ya se encuentra un usuario con ese LOGIN.";
      else if($EmpleadoDuplicado != 0)
        $Mensaje = "El empleado ya tiene un usuario asignado.";
      else if($empleado == "")
        $Mensaje = "Debe seleccionar un empleado.";
      else if($login == "")
        $Mensaje = "Debe ingresar el LOGIN.";
      else if($master == "")
        $Mensaje = "Debe seleccionar si es tipo master.";


      if($Mensaje != "")
       {
        $Redireccion = "/panel/parametrizacion/usuarios/agregar";
       }
      else
       {
        $datos['empleado'] = $empleado;
        $datos['login']    = $login;
        $IdentEmpleado     = PanelEmpleados::getEmpleado($empleado);
        $password          = $IdentEmpleado[0]->identificacion;
        $datos['password'] = Hash::make($password);
        $datos['estado']   = 1; //Activo
        $datos['master']   = $master;
        $datos['modulos']  = "1";

        PanelUsuarios::insertarUsuario($datos);
        $Mensaje = "Usuario creado.";

        //Agrego el guardado al log
        $user               = Session::get('user');
        $DatosUsuario       = PanelLogin::getUsuario($user);
        $idusuario          = PanelUsuarios::UltimoUsuario();
        $datos1             = array();
        $datos1['modulo']   = 14;    //Usuarios
        $datos1['tipo']     = "INS"; //Inserta
        $datos1['registro'] = "Id: ".$idusuario->id_usuario." |*| Id empleado: $empleado |*| Login: $login |*| Master: $master";
        $datos1['usuario']  = $DatosUsuario[0]->empleado;
        $datos1['fecha']    = NOW();
        PanelLogin::insertarLog($datos1);
        ////////////////////////////////

        $Redireccion = "/panel/parametrizacion/usuarios";
       }

      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function UsuariosModificar($id)
   {
    if(Session::has('user'))
     {
      $idUsuario    = $id;
      $DatosUsr     = PanelUsuarios::getUsuario($idUsuario);
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "parametrizacion/usuarios";
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

      if($DatosUsr == true)
       {
        return view('parametrizacion.panel-usuariosModificar')->with('DatosUsuario',$DatosUsuario)->with('DatosUsr',$DatosUsr);
       }
      else
       {
        $Mensaje     = "";
        $Redireccion = "/panel/parametrizacion/usuarios";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function UsuariosModificarDB()
   {
    if(Session::has('user'))
     {
      $formData   = Request::all();
      $id_usuario = $formData['id_usuario'];
      $login      = trim(strtoupper($formData['login']));
      $estado     = trim($formData['estado']);
      $master     = trim($formData['master']);

      //Realizo las validaciones
      $Mensaje = "";

      $UsuarioDuplicado = PanelUsuarios::getUsuarioLoginUnicoModificar($login, $id_usuario);

      $datos = array();

      if($UsuarioDuplicado != 0)
        $Mensaje = "Ya se encuentra un usuario con ese LOGIN.";
      else if($login == "")
        $Mensaje = "Debe ingresar el LOGIN.";
      else if($master == "")
        $Mensaje = "Debe seleccionar si es tipo master.";
      else if($estado == "")
        $Mensaje = "Debe seleccionar el estado.";

      if($Mensaje == "")
       {
        $datos['login']   = $login;
        $datos['estado']  = $estado;
        $datos['master']  = $master;

        PanelUsuarios::actualizarUsuario($id_usuario, $datos);
        $Mensaje = "Usuario modificado.";

        //Agrego el guardado al log
        $user               = Session::get('user');
        $DatosUsuario       = PanelLogin::getUsuario($user);
        $datos1             = array();
        $datos1['modulo']   = 14;    //Usuarios
        $datos1['tipo']     = "UPD"; //Actualiza
        $datos1['registro'] = "Id: $id_usuario |*| Login: $login |*| Master: $master |*| Estado: $estado";
        $datos1['usuario']  = $DatosUsuario[0]->empleado;
        $datos1['fecha']    = NOW();
        PanelLogin::insertarLog($datos1);
        ////////////////////////////////
       }

      $Redireccion = "/panel/parametrizacion/usuarios/modificar/".$id_usuario;
      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function UsuariosModificarPassDB()
   {
    if(Session::has('user'))
     {
      $formData   = Request::all();
      $id_usuario = $formData['id_usuario'];
      $empleado   = $formData['empleado'];

      $datos = array();

      $datos['password'] = Hash::make($empleado);

      PanelUsuarios::actualizarUsuario($id_usuario, $datos);
      $Mensaje     = "Contraseña restablecida (número de identificación).";

      //Agrego el guardado al log
      $user               = Session::get('user');
      $DatosUsuario       = PanelLogin::getUsuario($user);
      $datos1             = array();
      $datos1['modulo']   = 14;    //Usuarios
      $datos1['tipo']     = "UPD"; //Actualiza
      $datos1['registro'] = "Restablece contraseña |*| Id usuario: $id_usuario";
      $datos1['usuario']  = $DatosUsuario[0]->empleado;
      $datos1['fecha']    = NOW();
      PanelLogin::insertarLog($datos1);
      ////////////////////////////////

      $Redireccion = "/panel/parametrizacion/usuarios/modificar/".$id_usuario;
      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function UsuariosModificarAccesosDB()
   {
    if(Session::has('user'))
     {
      $formData   = Request::all();
      $id_usuario = $formData['id_usuario'];
      $modulos    = implode(", ",$formData['modulos']);

      $datos = array();
      $datos['modulos'] = $modulos;

      PanelUsuarios::actualizarUsuario($id_usuario, $datos);
      $Mensaje = "Permisos actualizados.";

      //Agrego el guardado al log
      $user               = Session::get('user');
      $DatosUsuario       = PanelLogin::getUsuario($user);
      $datos1             = array();
      $datos1['modulo']   = 14;    //Usuarios
      $datos1['tipo']     = "UPD"; //Actualiza
      $datos1['registro'] = "Se cambian los accesos (perfiles) |*| Id usuario: $id_usuario";
      $datos1['usuario']  = $DatosUsuario[0]->empleado;
      $datos1['fecha']    = NOW();
      PanelLogin::insertarLog($datos1);
      ////////////////////////////////

      $Redireccion = "/panel/parametrizacion/usuarios/modificar/".$id_usuario;
      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }
 }