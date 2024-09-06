<?php
/*
Controlador para sincronización con los terceros de siesa
Usa SQl Eloquent del archivo app\Models\Parametrizacion\PanelUsuariosSiesa.php
*/

namespace App\Http\Controllers\Parametrizacion;

use App\Http\Controllers\Controller;
use App\Models\Parametrizacion\PanelUsuariosSiesa;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelUsuarios;
use App\Models\PanelLogin;
use Illuminate\Support\Facades\Session;
use Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class SincronizarPanelController extends Controller
 {
  public function UsuariosSiesa()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "parametrizacion/sincronizar";
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

      return view('parametrizacion.panel-sincronizar')->with('DatosUsuario',$DatosUsuario);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function UsuariosInactivarDB()
   {
    if(Session::has('user'))
     {
      $user      = Session::get('user');
      $formData  = Request::all();
      $Empleados = $formData['empleados'];

      $Mensaje = "Usuarios inactivados";
      $emp = "";

      foreach ($Empleados as $DatEmp)
       {
        $datos = array();
        $datos['estado'] = 0;
        PanelEmpleados::actualizarEmpleado($DatEmp, $datos);
        $datos1 = array();
        $datos1['estado'] = 0;
        PanelUsuarios::actualizarUsuarioEmp($DatEmp, $datos1);

        PanelEmpleados::actualizarEmpleado($DatEmp, $datos);
        $IdentEmpleado = PanelEmpleados::getEmpleado($DatEmp);
        $emp = $emp." - ".$IdentEmpleado[0]->identificacion;
       }

      //Agrego el guardado al log
      $DatosUsuario       = PanelLogin::getUsuario($user);
      $datos2             = array();
      $datos2['modulo']   = 55;    //Sincronizar usuarios siesa
      $datos2['tipo']     = "UPD"; //Actualiza
      $datos2['registro'] = "Se inactivan los empleados ".$emp;
      $datos2['usuario']  = $DatosUsuario[0]->empleado;
      $datos2['fecha']    = NOW();
      PanelLogin::insertarLog($datos2);
      ////////////////////////////////

      $Redireccion = "/panel/parametrizacion/sincronizar";
      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function UsuariosActivarDB()
   {
    if(Session::has('user'))
     {
      $user      = Session::get('user');
      $formData  = Request::all();
      $Empleados = $formData['empleados'];

      $Mensaje = "Usuarios activados";
      $emp = "";

      foreach ($Empleados as $DatEmp)
       {
        $datos = array();
        $datos['estado'] = 1;
        PanelEmpleados::actualizarEmpleado($DatEmp, $datos);

        //Consulto si tiene usuario habilitado para habilitarlo también
        $tnusur = PanelUsuarios::UsuarioEmp($DatEmp);
        if($tnusur > 0)
         {
          $datos1 = array();
          $datos1['estado'] = 1;
          PanelUsuarios::actualizarUsuarioEmp($DatEmp, $datos1);
         }

        $IdentEmpleado = PanelEmpleados::getEmpleado($DatEmp);
        $emp = $emp." - ".$IdentEmpleado[0]->identificacion;
       }

      //Agrego el guardado al log
      $DatosUsuario       = PanelLogin::getUsuario($user);
      $datos2             = array();
      $datos2['modulo']   = 55;    //Sincronizar usuarios siesa
      $datos2['tipo']     = "UPD"; //Actualiza
      $datos2['registro'] = "Se activan los empleados ".$emp;
      $datos2['usuario']  = $DatosUsuario[0]->empleado;
      $datos2['fecha']    = NOW();
      PanelLogin::insertarLog($datos2);
      ////////////////////////////////

      $Redireccion = "/panel/parametrizacion/sincronizar";
      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function UsuariosAgregar($id)
   {
    if(Session::has('user'))
     {
      $Empleado      = $id;
      $user          = Session::get('user');
      $DatosUsuario  = PanelLogin::getUsuario($user);
      $DatosEmpleado = PanelUsuariosSiesa::Empleado($Empleado);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "parametrizacion/sincronizar";
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

      return view('parametrizacion.panel-sincronizarAgregar')->with('DatosUsuario',$DatosUsuario)->with('DatosEmpleado',$DatosEmpleado);
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
      $formData        = Request::all();
      $primer_nombre   = trim($formData['primer_nombre']);
      $otnombre        = trim($formData['ot_nombre']);
      $primer_apellido = trim($formData['primer_apellido']);
      $otapellido      = trim($formData['ot_apellido']);
      $identificacion  = $formData['identificacion'];
      $numtel          = $formData['numtel'];
      $correo          = trim($formData['correo']);
      $nacimiento      = $formData['nacimiento'];
      $cargo           = trim($formData['cargo']);
      $centro          = trim($formData['centro_op']);
      $fileImg         = $formData['uploader1'];

      $datos = array();

      //Realizo las validaciones
      $Mensaje = "";

      $EmpleadoDuplicado = PanelEmpleados::getEmpleadoUnico($identificacion);

      if($EmpleadoDuplicado != 0)
        $Mensaje = "Ya se encuentra un empleado con esa identificación.";
      else if($primer_nombre == "")
        $Mensaje = "Debe ingresar el primer nombre.";
      else if($primer_apellido == "")
        $Mensaje = "Debe ingresar el primer apellido.";
      else if($identificacion == "")
        $Mensaje = "Debe ingresar la identificación.";
      else if($numtel == "")
        $Mensaje = "Debe ingresar el numero telefónico.";
      else if($correo == "")
        $Mensaje = "Debe ingresar el email.";
      else if($cargo == "")
        $Mensaje = "Debe seleccionar el cargo.";
      else if($centro == "")
        $Mensaje = "Debe seleccionar el centro de operación.";
      else if($nacimiento == "")
        $Mensaje = "Debe seleccionar la fecha de nacimiento.";

      if($Mensaje != "")
       {
        $Redireccion = "/panel/parametrizacion/sincronizar";
       }
      else
       {
        if($fileImg!='')
         {
          $file            = Request::file('file1');
          $destinationPath = substr(public_path(), 0, -14)."public/archivos/Empleados/";
          $filename        = $identificacion.".jpg";
          $uploadSuccess   = $file->move($destinationPath, $filename);
         }
        else
         {
          $filename = 'Imagen no encontrada';
         }

        $datos['identificacion']   = $identificacion;
        $datos['primer_nombre']    = $primer_nombre;
        $datos['ot_nombre']        = $otnombre;
        $datos['primer_apellido']  = $primer_apellido;
        $datos['ot_apellido']      = $otapellido;
        $datos['correo']           = $correo;
        $datos['numtel']           = $numtel;
        $datos['cargo']            = $cargo;
        $datos['centro_op']        = $centro;
        $datos['estado']           = 1; //Activo
        $datos['fecha_nacimiento'] = $nacimiento;

        PanelEmpleados::insertarEmpleado($datos);
        $Mensaje = "Empleado creado.";

        //Agrego el guardado al log
        $user               = Session::get('user');
        $DatosUsuario       = PanelLogin::getUsuario($user);
        $idempleado         = PanelEmpleados::UltimoEmpleado();
        $datos1             = array();
        $datos1['modulo']   = 55;     //Sincronizar empleados con siesa
        $datos1['tipo']     = "INS";  //Inserta

        $info = "Id: ".$idempleado->id_empleado." |*| Identificación: $identificacion |*| Nombre: $primer_nombre $otnombre $primer_apellido $otapellido";
        $info = $info." |*| Correo: $correo |*| Tel: $numtel |*| Id cargo: $cargo |*| Id centro de operación: $centro |*| fecha nacimiento: $nacimiento";

        $datos1['registro'] = $info;
        $datos1['usuario']  = $DatosUsuario[0]->empleado;
        $datos1['fecha']    = NOW();
        PanelLogin::insertarLog($datos1);
        ////////////////////////////////

        $Redireccion = "/panel/parametrizacion/sincronizar/agregarusr/".$identificacion;
       }

      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function UsuariosNvAgregar($id)
   {
    if(Session::has('user'))
     {
      $idUsuario    = $id;
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "parametrizacion/sincronizar";
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

      $DatosEmpleado = PanelEmpleados::getEmpleadoIdent($id);

      return view('parametrizacion.panel-sincronizarAgregarUsr')->with('DatosUsuario',$DatosUsuario)->with('DatosEmpleado',$DatosEmpleado);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function UsuariosNvAgregarDB()
   {
    if(Session::has('user'))
     {
      $formData      = Request::all();
      $empleado      = trim($formData['empleado']);
      $login         = trim(strtoupper($formData['login']));
      $master        = trim($formData['master']);
      $identempleado = trim($formData['identempleado']);

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
        $Redireccion = "/panel/parametrizacion/sincronizar/agregarusr/".$identempleado;
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


        $Redireccion = "/panel/parametrizacion/usuarios/modificar/".$idusuario->id_usuario;
       }

      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }
 }