<?php
/*
Controlador de la tabla acti_software
Usa SQl Eloquent del archivo app\Models\Bpack\PanelSoftware.php
*/

namespace App\Http\Controllers\TicActivos;
use App\Http\Controllers\Controller;
use App\Models\TicActivos\PanelSoftware;
use App\Models\PanelLogin;
use Illuminate\Support\Facades\Session;
use Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class SoftwareTicActivosPanelController extends Controller
 {
  public function Software()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "ticactivos/software";
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

      $DatosSoftware     = PanelSoftware::getSoftwares();
      $SoftwareActivos   = PanelSoftware::getCantidadSoftwareActivos();
      $SoftwareInactivos = PanelSoftware::getCantidadSoftwareInactivos();
      return view('ticactivos.panel-software')->with('DatosUsuario',$DatosUsuario)->with('DatosSoftware',$DatosSoftware)->with('SoftwareActivos',$SoftwareActivos)->with('SoftwareInactivos',$SoftwareInactivos);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function SoftwareAgregar()
   {
    if(Session::has('user'))
     {
      $ErrorValidacion = "";  //Variable que retorna el error en caso de que no pase la validación
      $user            = Session::get('user');
      $DatosUsuario    = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "ticactivos/software";
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

      return view('ticactivos.panel-softwareAgregar')->with('DatosUsuario',$DatosUsuario);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function SoftwareAgregarDB()
   {
    if(Session::has('user'))
     {
      $formData    = Request::all();
      $descripcion = trim($formData['descripcion']);

      $datos = array();

      //Realizo las validaciones
      $Mensaje = "";

      $SoftwareDuplicado = PanelSoftware::getSoftwareUnico($descripcion);

      if($SoftwareDuplicado != 0)
        $Mensaje = "Ya se encuentra un software creado con esa descripción.";
      else if($descripcion == "")
        $Mensaje = "Debe ingresar el software.";

      if($Mensaje != "")
       {
        $Redireccion = "/panel/ticactivos/software/agregar";
       }
      else
       {
        $datos['descripcion'] = $descripcion;
        $datos['estado']      = 1; //Activo

        PanelSoftware::insertarSoftware($datos);
        $Mensaje = "Software creado.";

        //Agrego el guardado al log
        $user               = Session::get('user');
        $DatosUsuario       = PanelLogin::getUsuario($user);
        $idtipo             = PanelSoftware::UltimoSoftware();
        $datos1             = array();
        $datos1['modulo']   = 69; //Software
        $datos1['tipo']     = "INS"; //Inserta
        $datos1['registro'] = "Id: ".$idtipo->id_software." |*| Descripción: ".$descripcion;
        $datos1['usuario']  = $DatosUsuario[0]->empleado;
        $datos1['fecha']    = NOW();
        PanelLogin::insertarLog($datos1);
        ////////////////////////////////

        $Redireccion = "/panel/ticactivos/software";
       }

      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function SoftwareModificar($id)
   {
    if(Session::has('user'))
     {
      $id_software   = $id;
      $DatosSoftware = PanelSoftware::getSoftware($id_software);
      $user          = Session::get('user');
      $DatosUsuario  = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "ticactivos/software";
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

      if($DatosSoftware == true)
       {
        return view('ticactivos.panel-softwareModificar')->with('DatosUsuario',$DatosUsuario)->with('DatosSoftware',$DatosSoftware);
       }
      else
       {
        $Mensaje     = "";
        $Redireccion = "/panel/ticactivos/software";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function SoftwareModificarDB()
   {
    if(Session::has('user'))
     {
      $formData    = Request::all();
      $id_software = $formData['id_software'];
      $descripcion = trim($formData['descripcion']);
      $estado      = $formData['estado'];

      $datos = array();

      //Realizo las validaciones
      $Mensaje = "";

      $SoftwareDuplicado = PanelSoftware::getSoftwareUnicoModificar($descripcion, $id_software);

      if($SoftwareDuplicado != 0)
        $Mensaje = "Ya se encuentra creada un software con esa descripción.";
      else if($descripcion == "")
        $Mensaje = "Debe ingresar el software.";
      else if($estado == "")
        $Mensaje = "Debe seleccionar el estado.";

      if($Mensaje == "")
       {
        $datos['descripcion'] = $descripcion;
        $datos['estado']      = $estado;

        PanelSoftware::actualizarSoftware($id_software, $datos);
        $Mensaje = "Software modificado.";

        //Agrego el guardado al log
        $user               = Session::get('user');
        $DatosUsuario       = PanelLogin::getUsuario($user);
        $datos1             = array();
        $datos1['modulo']   = 69;    //Software
        $datos1['tipo']     = "UPD"; //Actualiza
        $datos1['registro'] = "Id: ".$id_software." |*| Descripción: ".$descripcion." |*| Estado: ".$estado;
        $datos1['usuario']  = $DatosUsuario[0]->empleado;
        $datos1['fecha']    = NOW();
        PanelLogin::insertarLog($datos1);
        ////////////////////////////////
       }

      $Redireccion = "/panel/ticactivos/software/modificar/".$id_software;
      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }
 }