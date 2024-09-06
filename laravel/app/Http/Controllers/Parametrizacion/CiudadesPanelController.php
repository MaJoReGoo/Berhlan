<?php
/*
Controlador de la tabla param_ciudades
Usa SQl Eloquent del archivo app\Models\Parametrizacion\PanelCiudades.php
*/

namespace App\Http\Controllers\Parametrizacion;

use App\Http\Controllers\Controller;
use App\Models\Parametrizacion\PanelCiudades;
use App\Models\PanelLogin;
use Illuminate\Support\Facades\Session;
use Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class CiudadesPanelController extends Controller
 {
  public function showCiudades()
   {
    if(Session::has('user'))
     {
      $user              = Session::get('user');
      $DatosUsuario      = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "parametrizacion/ciudades";
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

      $DatosCiudades     = PanelCiudades::getCiudades();
      $CiudadesActivas   = PanelCiudades::getCantidadCiudadesActivas();
      $CiudadesInactivas = PanelCiudades::getCantidadCiudadesInactivas();
      return view('parametrizacion.panel-ciudades')->with('DatosUsuario',$DatosUsuario)->with('DatosCiudades',$DatosCiudades)->with('CiudadesActivas',$CiudadesActivas)->with('CiudadesInactivas',$CiudadesInactivas);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function CiudadesAgregar()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "parametrizacion/ciudades";
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

      return view('parametrizacion.panel-ciudadesAgregar')->with('DatosUsuario',$DatosUsuario);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function CiudadesAgregarDB()
   {
    if(Session::has('user'))
     {
      $formData   = Request::all();
      $codigo     = trim($formData['codigo']);
      $nom_depto  = trim($formData['nom_depto']);
      $nom_ciudad = trim($formData['nom_ciudad']);
      $login      = $formData['login'];

      $datos = array();

      //Realizo las validaciones
      $Mensaje = "";

      $ExisteCodigo    = PanelCiudades::getCiudadUnicaCodigo($codigo);
      $ExisteCiudad    = PanelCiudades::getCiudadUnicaNombre($nom_depto, $nom_ciudad);
      $CiudadDuplicada = $ExisteCodigo + $ExisteCiudad;

      if(!ctype_digit($codigo))
        $Mensaje = "No es posible ingresar la ciudad. El código solo debe contener números.";
      else if($CiudadDuplicada != 0)
        $Mensaje = "No es posible ingresar la ciudad. Ya se encuentra una, con la misma información.";
      else if($nom_depto == "")
        $Mensaje = "Debe ingresar el nombre del departamento.";
      else if($nom_ciudad == "")
        $Mensaje = "Debe ingresar el nombre de la ciudad.";

      $DatosUsuario = PanelLogin::getUsuario($login);

      if($Mensaje != "")
       {
        $Redireccion = "/panel/parametrizacion/ciudades/agregar";
       }
      else
       {
        $datos['codigo']     = $codigo;
        $datos['nom_ciudad'] = $nom_ciudad;
        $datos['nom_depto']  = $nom_depto;
        $datos['estado']     = 1; //Activo

        PanelCiudades::insertarCiudad($datos);
        $Mensaje = "Ciudad creada.";

        //Agrego el guardado al log
        $user               = Session::get('user');
        $DatosUsuario       = PanelLogin::getUsuario($user);
        $idciudad           = PanelCiudades::UltimaCiudad();
        $datos1             = array();
        $datos1['modulo']   = 11;     //Ciudades
        $datos1['tipo']     = "INS"; //Inserta
        $datos1['registro'] = "Id: ".$idciudad->id_ciudad." |*| Código: $codigo |*| Ciudad: $nom_ciudad |*| Departamento: $nom_depto";
        $datos1['usuario']  = $DatosUsuario[0]->empleado;
        $datos1['fecha']    = NOW();
        PanelLogin::insertarLog($datos1);
        ////////////////////////////////

        $Redireccion = "/panel/parametrizacion/ciudades";
       }

      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }

  public function CiudadesModificar($id)
   {
    if(Session::has('user'))
     {
      $idCiudad     = $id;
      $DatosCiudad  = PanelCiudades::getCiudad($idCiudad);
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "parametrizacion/ciudades";
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

      if($DatosCiudad == true)
       {
        return view('parametrizacion.panel-ciudadesModificar')->with('DatosUsuario',$DatosUsuario)->with('DatosCiudad',$DatosCiudad);
       }
      else
       {
        $Mensaje     = "";
        $Redireccion = "/panel/parametrizacion/ciudades";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function CiudadesModificarDB()
   {
    if(Session::has('user'))
     {
      $formData     = Request::all();
      $id_ciudad    = $formData['id_ciudad'];
      $codigo       = trim($formData['codigo']);
      $nom_depto    = trim($formData['nom_depto']);
      $nom_ciudad   = trim($formData['nom_ciudad']);
      $estado       = trim($formData['estado']);

      $datos = array();

      //Realizo las validaciones
      $Mensaje = "";

      $ExisteCodigo    = PanelCiudades::getCiudadUnicaCodigoModificar($codigo, $id_ciudad);
      $ExisteCiudad    = PanelCiudades::getCiudadUnicaNombreModificar($nom_depto, $nom_ciudad, $id_ciudad);
      $CiudadDuplicada = $ExisteCodigo + $ExisteCiudad;

      if(!ctype_digit($codigo))
        $Mensaje = "No es posible ingresar la ciudad. El código solo debe contener números.";
      else if($CiudadDuplicada != 0)
        $Mensaje = "No es posible ingresar la ciudad. Ya se encuentra una, con la misma información.";
      else if($nom_depto == "")
        $Mensaje = "Debe ingresar el nombre del departamento.";
      else if($nom_ciudad == "")
        $Mensaje = "Debe ingresar el nombre de la ciudad.";
      else if($estado == "")
        $Mensaje = "Debe seleccionar el estado.";

      if($Mensaje == "")
       {
        $datos['codigo']     = $codigo;
        $datos['nom_depto']  = $nom_depto;
        $datos['nom_ciudad'] = $nom_ciudad;
        $datos['estado']     = $estado;

        PanelCiudades::actualizarCiudad($id_ciudad, $datos);
        $Mensaje = "Ciudad modificada.";

        //Agrego el guardado al log
        $user               = Session::get('user');
        $DatosUsuario       = PanelLogin::getUsuario($user);
        $datos1             = array();
        $datos1['modulo']   = 11;     //Ciudades
        $datos1['tipo']     = "UPD";  //Actualiza
        $datos1['registro'] = "Id: ".$id_ciudad." |*| Código: $codigo |*| Ciudad: $nom_ciudad |*| Departamento: $nom_depto |*| Estado: $estado";
        $datos1['usuario']  = $DatosUsuario[0]->empleado;
        $datos1['fecha']    = NOW();
        PanelLogin::insertarLog($datos1);
        ////////////////////////////////
       }

      $Redireccion = "/panel/parametrizacion/ciudades/modificar/".$id_ciudad;
      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }
 }