<?php
/*
Controlador de la tabla acti_licenciaoffice
Usa SQl Eloquent del archivo app\Models\Bpack\PanelLicencias.php
*/

namespace App\Http\Controllers\TicActivos;
use App\Http\Controllers\Controller;
use App\Models\TicActivos\PanelLicencias;
use App\Models\PanelLogin;
use Illuminate\Support\Facades\Session;
use Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class LicenciasTicActivosPanelController extends Controller
 {
  public function Licencias()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "ticactivos/licencias";
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

      $DatosLicencias     = PanelLicencias::getLicencias();
      $LicenciasActivas   = PanelLicencias::getCantidadLicenciasActivas();
      $LicenciasInactivas = PanelLicencias::getCantidadLicenciasInactivas();
      return view('ticactivos.panel-licencias')->with('DatosUsuario',$DatosUsuario)->with('DatosLicencias',$DatosLicencias)->with('LicenciasActivas',$LicenciasActivas)->with('LicenciasInactivas',$LicenciasInactivas);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function LicenciasAgregar()
   {
    if(Session::has('user'))
     {
      $ErrorValidacion = "";  //Variable que retorna el error en caso de que no pase la validación
      $user            = Session::get('user');
      $DatosUsuario    = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "ticactivos/licencias";
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

      return view('ticactivos.panel-licenciasAgregar')->with('DatosUsuario',$DatosUsuario);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function LicenciasAgregarDB()
   {
    if(Session::has('user'))
     {
      $formData = Request::all();
      $tipo     = $formData['tipo'];
      $licencia = trim($formData['licencia']);
      $codigo   = trim($formData['codigo']);
      $medio    = $formData['medio'];
      $usuario  = trim($formData['usuario']);
      $password = trim($formData['password']);

      $datos = array();

      //Realizo las validaciones
      $Mensaje = "";

      $LicenciaDuplicada = PanelLicencias::getLicenciaUnica($licencia);
      $CodigoDuplicado   = PanelLicencias::getCodigoUnico($codigo);

      if($LicenciaDuplicada != 0)
        $Mensaje = "Ya se encuentra creada una licencia con esa descripción.";
      else if($CodigoDuplicado != 0)
        $Mensaje = "Ya se encuentra creada una licencia con ese código.";
      else if($licencia == "")
        $Mensaje = "Debe ingresar la licencia.";

      if($Mensaje != "")
       {
        $Redireccion = "/panel/ticactivos/licencias/agregar";
       }
      else
       {
        $datos['tipo']        = $tipo;
        $datos['descripcion'] = $licencia;
        $datos['codigoint']   = $codigo;
        $datos['medio']       = $medio;
        $datos['usuario']     = $usuario;
        $datos['clave']       = $password;
        $datos['estado']      = 1; //Activo

        PanelLicencias::insertarLicencia($datos);
        $Mensaje = "Licencia creada.";

        //Agrego el guardado al log
        $user               = Session::get('user');
        $DatosUsuario       = PanelLogin::getUsuario($user);
        $idLicencia         = PanelLicencias::UltimaLicencia();
        $datos1             = array();
        $datos1['modulo']   = 67;    //Licencias de office
        $datos1['tipo']     = "INS"; //Inserta
        $datos1['registro'] = "Id: ".$idLicencia->id_licencia." |*| Descripción: ".$licencia;
        $datos1['usuario']  = $DatosUsuario[0]->empleado;
        $datos1['fecha']    = NOW();
        PanelLogin::insertarLog($datos1);
        ////////////////////////////////

        $Redireccion = "/panel/ticactivos/licencias";
       }

      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function LicenciasModificar($id)
   {
    if(Session::has('user'))
     {
      $id_licencia   = $id;
      $DatosLicencia = PanelLicencias::getLicencia($id_licencia);
      $user          = Session::get('user');
      $DatosUsuario  = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "ticactivos/licencias";
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

      if($DatosLicencia == true)
       {
        return view('ticactivos.panel-licenciasModificar')->with('DatosUsuario',$DatosUsuario)->with('DatosLicencia',$DatosLicencia);
       }
      else
       {
        $Mensaje     = "";
        $Redireccion = "/panel/ticactivos/licencias";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function LicenciasModificarDB()
   {
    if(Session::has('user'))
     {
      $formData   = Request::all();
      $idlicencia = $formData['id_licencia'];
      $tipo       = $formData['tipo'];
      $licencia   = trim($formData['licencia']);
      $codigo     = trim($formData['codigo']);
      $medio      = $formData['medio'];
      $usuario    = trim($formData['usuario']);
      $password   = trim($formData['password']);
      $estado     = $formData['estado'];

      $datos = array();

      //Realizo las validaciones
      $Mensaje = "";

      $LicenciaDuplicada = PanelLicencias::getLicenciaUnicaModificar($licencia, $idlicencia);
      $CodigoDuplicado   = PanelLicencias::getCodigoUnicoModificar($codigo, $idlicencia);

      if($LicenciaDuplicada != 0)
        $Mensaje = "Ya se encuentra creada una licencia con esa descripción.";
      else if($CodigoDuplicado != 0)
        $Mensaje = "Ya se encuentra creada una licencia con ese código.";
      else if($licencia == "")
        $Mensaje = "Debe ingresar la licencia.";
      else if($estado == "")
        $Mensaje = "Debe seleccionar el estado.";

      if($Mensaje == "")
       {
        $datos['tipo']        = $tipo;
        $datos['descripcion'] = $licencia;
        $datos['codigoint']   = $codigo;
        $datos['medio']       = $medio;
        $datos['usuario']     = $usuario;
        $datos['clave']       = $password;
        $datos['estado']      = $estado;

        PanelLicencias::actualizarLicencia($idlicencia, $datos);
        $Mensaje = "Licencia modificada.";

        //Agrego el guardado al log
        $user               = Session::get('user');
        $DatosUsuario       = PanelLogin::getUsuario($user);
        $datos1             = array();
        $datos1['modulo']   = 67;    //Licencia de office
        $datos1['tipo']     = "UPD"; //Actualiza
        $datos1['registro'] = "Id: ".$idlicencia." |*| Licencia: ".$licencia." |*| Estado: ".$estado;
        $datos1['usuario']  = $DatosUsuario[0]->empleado;
        $datos1['fecha']    = NOW();
        PanelLogin::insertarLog($datos1);
        ////////////////////////////////
       }

      $Redireccion = "/panel/ticactivos/licencias/modificar/".$idlicencia;
      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }
 }