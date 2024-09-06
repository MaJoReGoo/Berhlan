<?php
/*
Controlador de la tabla proc_perfiles
Usa SQl Eloquent del archivo app\Models\Procesos\PanelPerfiles.php
*/

namespace App\Http\Controllers\Procesos;
use App\Http\Controllers\Controller;
use App\Models\PanelLogin;
use App\Models\Procesos\PanelPerfiles;
use Illuminate\Support\Facades\Session;
use Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class PerfilesProcesosPanelController extends Controller
 {
  public function listadoPerfiles()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "procesos/perfiles";
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

      $DatosPerfiles = PanelPerfiles::getPerfiles();
      return view('procesos.panel-perfiles')->with('DatosUsuario',$DatosUsuario)->with('DatosPerfiles',$DatosPerfiles);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function PerfilesAgregar()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "procesos/perfiles";
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

      return view('procesos.panel-perfilesAgregar')->with('DatosUsuario',$DatosUsuario);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function PerfilesAgregarDB()
   {
    if(Session::has('user'))
     {
      $formData    = Request::all();
      $login       = $formData['login'];
      $descripcion = trim($formData['descripcion']);

      $datos = array();

      //Realizo las validaciones
      $Mensaje = "";

      $PerfilDuplicado = PanelPerfiles::getPerfilUnico($descripcion);

      if($PerfilDuplicado != 0)
        $Mensaje = "Ya se encuentra un perfil con esa descripción.";
      else if($descripcion == "")
        $Mensaje = "Debe ingresar la descripción.";

      if($Mensaje != "")
       {
        $Redireccion = "/panel/procesos/perfiles/agregar";
       }
      else
       {
        $datos['descripcion'] = $descripcion;

        PanelPerfiles::insertarPerfil($datos);
        $Mensaje     = "Perfil creado.";
        $Redireccion = "/panel/procesos/perfiles";
       }

      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function PerfilesModificar($id)
   {
    if(Session::has('user'))
     {
      $idPerfil     = $id;
      $DatosPerfil  = PanelPerfiles::getPerfil($idPerfil);
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "procesos/perfiles";
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

      if($DatosPerfil == true)
       {
        return view('procesos.panel-perfilesModificar')->with('DatosUsuario',$DatosUsuario)->with('DatosPerfil',$DatosPerfil);
       }
      else
       {
        $DatosPerfiles = PanelPerfiles::getPerfiles();
        return view('procesos.panel-perfiles')->with('DatosUsuario',$DatosUsuario)->with('DatosPerfiles',$DatosPerfiles);
       }
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function PerfilesModificarDB()
   {
    if(Session::has('user'))
     {
      $formData    = Request::all();
      $id_perfil   = $formData['id_perfil'];
      $descripcion = trim($formData['descripcion']);

      $datos = array();

      //Realizo las validaciones
      $Mensaje = "";

      $PerfilDuplicado = PanelPerfiles::getPerfilUnicoMod($id_perfil, $descripcion);

      if($PerfilDuplicado != 0)
        $Mensaje = "Ya se encuentra un perfil con esa descripción.";
      else if($descripcion == "")
        $Mensaje = "Debe ingresar la descripción.";

      if($Mensaje == "")
       {
        $datos['descripcion'] = $descripcion;

        PanelPerfiles::actualizarPerfil($id_perfil,$datos);

        $Mensaje = "Perfil modificado.";
       }

      $Redireccion = "/panel/procesos/perfiles/modificar/".$id_perfil;
      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function PerfilesEliminarDB()
   {
    if(Session::has('user'))
     {
      $formData     = Request::all();
      $id_perfil    = $formData['id_perfil'];
      $user         = $formData['login'];
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "procesos/perfiles";
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

      PanelPerfiles::BorrarPerUsuProce($id_perfil); //Borra la asociación de los perfiles con los usuarios
      PanelPerfiles::BorrarPerfilDocu($id_perfil);  //Borra la asociación de los perfiles con los documentos
      PanelPerfiles::BorrarPerfil($id_perfil);      //Borra el perfil

      $Mensaje     = "Perfil eliminado.";
      $Redireccion = "/panel/procesos/perfiles";
      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function PerfilesAgregarUsr($id)
   {
    if(Session::has('user'))
     {
      $idPerfil     = $id;
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);
      $DatosPerfil  = PanelPerfiles::getPerfil($idPerfil);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "procesos/perfiles";
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

      return view('procesos.panel-perfilesAgregarUsr')->with('DatosUsuario',$DatosUsuario)->with('DatosPerfil',$DatosPerfil);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function PerfilesAgregarUsrDB()
   {
    if(Session::has('user'))
     {
      $formData = Request::all();
      $login    = $formData['login'];
      $perfil   = $formData['id_perfil'];
      $empleado = $formData['empleado'];

      $datos = array();

      //Realizo las validaciones
      $Mensaje = "";

      $UsuarioDuplicado = PanelPerfiles::getPerfilUsuarioUnico($perfil, $empleado);

      if($UsuarioDuplicado != 0)
        $Mensaje = "Usuario ya se encuentra asociado al perfil.";
      else if($empleado == "")
        $Mensaje = "Debe ingresar el usuario.";

      if($Mensaje == "")
       {
        foreach ($empleado as $empleado) {
            $datos['perfil']  = $perfil;
            $datos['usuario'] = $empleado;

            PanelPerfiles::insertarUsuarioPerfil($datos);
        }

        $Mensaje = "Usuario asociado al perfil.";
       }

      $Redireccion = "/panel/procesos/perfiles/agregarusr/".$perfil;
      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function PerfilesRetirarUsrDB()
   {
    if(Session::has('user'))
     {
      $formData     = Request::all();
      $id_perfil    = $formData['id_perfil'];
      $id_usuario   = $formData['id_usuario'];
      $user         = $formData['login'];
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "procesos/perfiles";
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

      PanelPerfiles::RetirarUsuarioPerfil($id_perfil, $id_usuario);

      $Mensaje     = "Usuario desasociado el perfil.";
      $Redireccion = "/panel/procesos/perfiles/modificar/".$id_perfil;
      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }

 }
