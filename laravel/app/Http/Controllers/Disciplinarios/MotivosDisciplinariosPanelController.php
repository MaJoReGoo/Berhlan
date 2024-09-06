<?php
/*
Controlador de la tabla disc_motivocierre
Usa SQl Eloquent del archivo app\Models\Disciplinarios\PanelMotivos.php
*/

namespace App\Http\Controllers\Disciplinarios;
use App\Http\Controllers\Controller;
use App\Models\Disciplinarios\PanelMotivos;
use App\Models\PanelLogin;
use Illuminate\Support\Facades\Session;
use Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class MotivosDisciplinariosPanelController extends Controller
 {
  public function Motivos()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "disciplinarios/motivos";
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

      $DatosMotivos     = PanelMotivos::getMotivos();
      $MotivosActivos   = PanelMotivos::getCantidadMotivosActivos();
      $MotivosInactivos = PanelMotivos::getCantidadMotivosInactivos();
      return view('disciplinarios.panel-motivos')->with('DatosUsuario',$DatosUsuario)->with('DatosMotivos',$DatosMotivos)->with('MotivosActivos',$MotivosActivos)->with('MotivosInactivos',$MotivosInactivos);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function MotivosAgregar()
   {
    if(Session::has('user'))
     {
      $ErrorValidacion = "";  //Variable que retorna el error en caso de que no pase la validación
      $user            = Session::get('user');
      $DatosUsuario    = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "disciplinarios/motivos";
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

      return view('disciplinarios.panel-motivosAgregar')->with('DatosUsuario',$DatosUsuario);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function MotivosAgregarDB()
   {
    if(Session::has('user'))
     {
      $formData    = Request::all();
      $descripcion = trim($formData['descripcion']);

      $datos = array();

      //Realizo las validaciones
      $Mensaje = "";

      $MotivoDuplicado = PanelMotivos::getMotivoUnico($descripcion);

      if($MotivoDuplicado != 0)
        $Mensaje = "Ya se encuentra creado un motivo con esa descripción.";
      else if($descripcion == "")
        $Mensaje = "Debe ingresar el nombre del motivo.";

      if($Mensaje != "")
       {
        $Redireccion = "/panel/disciplinarios/motivos/agregar";
       }
      else
       {
        $user         = Session::get('user');
        $DatosUsuario = PanelLogin::getUsuario($user);

        $datos['descripcion'] = $descripcion;
        $datos['estado']      = 1; //Activo
        $datos['usrmod']      = $DatosUsuario[0]->empleado;
        $datos['fechamod']    = NOW();

        PanelMotivos::insertarMotivo($datos);
        $Mensaje = "Motivo creado.";

        $Redireccion = "/panel/disciplinarios/motivos";
       }

      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function MotivosModificar($id)
   {
    if(Session::has('user'))
     {
      $idMotivo     = $id;
      $DatosMotivo  = PanelMotivos::getMotivo($idMotivo);
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "disciplinarios/motivos";
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

      if($DatosMotivo == true)
       {
        return view('disciplinarios.panel-motivosModificar')->with('DatosUsuario',$DatosUsuario)->with('DatosMotivo',$DatosMotivo);
       }
      else
       {
        $Mensaje     = "";
        $Redireccion = "/panel/disciplinarios/motivos";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function MotivosModificarDB()
   {
    if(Session::has('user'))
     {
      $formData    = Request::all();
      $id_motivo   = $formData['motivo'];
      $descripcion = trim($formData['descripcion']);
      $estado      = $formData['estado'];

      $datos = array();

      //Realizo las validaciones
      $Mensaje = "";

      $MotivoDuplicado = PanelMotivos::getMotivoUnicoModificar($descripcion, $id_motivo);

      if($MotivoDuplicado != 0)
        $Mensaje = "Ya se encuentra creado un motivo con esa descripción.";
      else if($descripcion == "")
        $Mensaje = "Debe ingresar el motivo.";
      else if($estado == "")
        $Mensaje = "Debe seleccionar el estado.";

      if($Mensaje == "")
       {
        $user         = Session::get('user');
        $DatosUsuario = PanelLogin::getUsuario($user);

        $datos['descripcion'] = $descripcion;
        $datos['estado']      = $estado;
        $datos['usrmod']      = $DatosUsuario[0]->empleado;
        $datos['fechamod']    = NOW();

        PanelMotivos::actualizarMotivo($id_motivo, $datos);
        $Mensaje = "Motivo de cierre modificado.";
       }

      $Redireccion = "/panel/disciplinarios/motivos/modificar/".$id_motivo;
      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }
 }