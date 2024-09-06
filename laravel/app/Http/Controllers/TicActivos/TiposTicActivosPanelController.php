<?php
/*
Controlador de la tabla acti_tipoactivo
Usa SQl Eloquent del archivo app\Models\Bpack\PanelTipos.php
*/

namespace App\Http\Controllers\TicActivos;
use App\Http\Controllers\Controller;
use App\Models\TicActivos\PanelTipos;
use App\Models\PanelLogin;
use Illuminate\Support\Facades\Session;
use Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class TiposTicActivosPanelController extends Controller
 {
  public function Tipos()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "ticactivos/tipos";
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

      $DatosTipos     = PanelTipos::getTipos();
      $TiposActivos   = PanelTipos::getCantidadTiposActivos();
      $TiposInactivos = PanelTipos::getCantidadTiposInactivos();
      return view('ticactivos.panel-tipos')->with('DatosUsuario',$DatosUsuario)->with('DatosTipos',$DatosTipos)->with('TiposActivos',$TiposActivos)->with('TiposInactivos',$TiposInactivos);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function TiposAgregar()
   {
    if(Session::has('user'))
     {
      $ErrorValidacion = "";  //Variable que retorna el error en caso de que no pase la validación
      $user            = Session::get('user');
      $DatosUsuario    = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "ticactivos/tipos";
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

      return view('ticactivos.panel-tiposAgregar')->with('DatosUsuario',$DatosUsuario);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function TiposAgregarDB()
   {
    if(Session::has('user'))
     {
      $formData    = Request::all();
      $descripcion = trim($formData['descripcion']);
      $pc          = $formData['pc'];
      $campo1      = trim($formData['campo1']);
      $campo2      = trim($formData['campo2']);
      $campo3      = trim($formData['campo3']);

      $datos = array();

      //Realizo las validaciones
      $Mensaje = "";

      $TipoDuplicado = PanelTipos::getTipoUnico($descripcion);

      if($TipoDuplicado != 0)
        $Mensaje = "Ya se encuentra creada una licencia con esa descripción.";
      else if($descripcion == "")
        $Mensaje = "Debe ingresar la descripción.";

      if($Mensaje != "")
       {
        $Redireccion = "/panel/ticactivos/tipos/agregar";
       }
      else
       {
        $datos['descripcion'] = $descripcion;
        $datos['campos_pc']   = $pc;
        $datos['campo1']      = $campo1;
        $datos['campo2']      = $campo2;
        $datos['campo3']      = $campo3;
        $datos['estado']      = 1; //Activo

        PanelTipos::insertarTipo($datos);
        $Mensaje = "Tipo de activo creado.";

        //Agrego el guardado al log
        $user               = Session::get('user');
        $DatosUsuario       = PanelLogin::getUsuario($user);
        $idTipo             = PanelTipos::UltimoTipo();
        $datos1             = array();
        $datos1['modulo']   = 72;    //Tipos de activos
        $datos1['tipo']     = "INS"; //Inserta
        $datos1['registro'] = "Id: ".$idTipo->id_tipoactivo." |*| Descripción: ".$descripcion;
        $datos1['usuario']  = $DatosUsuario[0]->empleado;
        $datos1['fecha']    = NOW();
        PanelLogin::insertarLog($datos1);
        ////////////////////////////////

        $Redireccion = "/panel/ticactivos/tipos";
       }

      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function TiposModificar($id)
   {
    if(Session::has('user'))
     {
      $id_tipo      = $id;
      $DatosTipo    = PanelTipos::getTipo($id_tipo);
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "ticactivos/tipos";
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

      if($DatosTipo == true)
       {
        return view('ticactivos.panel-tiposModificar')->with('DatosUsuario',$DatosUsuario)->with('DatosTipo',$DatosTipo);
       }
      else
       {
        $Mensaje     = "";
        $Redireccion = "/panel/ticactivos/tipos";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function TiposModificarDB()
   {
    if(Session::has('user'))
     {
      $formData    = Request::all();
      $id_tipo     = $formData['id_tipo'];
      $descripcion = trim($formData['descripcion']);
      $pc          = $formData['pc'];
      $campo1      = trim($formData['campo1']);
      $campo2      = trim($formData['campo2']);
      $campo3      = trim($formData['campo3']);
      $estado      = $formData['estado'];

      $datos = array();

      //Realizo las validaciones
      $Mensaje = "";

      $TipoDuplicado = PanelTipos::getTipoUnicoModificar($descripcion, $id_tipo);

      if($TipoDuplicado != 0)
        $Mensaje = "Ya se encuentra creado un tipo de activo con esa descripción.";
      else if($descripcion == "")
        $Mensaje = "Debe ingresar la descripción.";
      else if($estado == "")
        $Mensaje = "Debe seleccionar el estado.";

      if($Mensaje == "")
       {
        $datos['descripcion'] = $descripcion;
        $datos['campos_pc']   = $pc;
        $datos['campo1']      = $campo1;
        $datos['campo2']      = $campo2;
        $datos['campo3']      = $campo3;
        $datos['estado']      = $estado;

        PanelTipos::actualizarTipo($id_tipo, $datos);
        $Mensaje = "Tipo modificado.";

        //Agrego el guardado al log
        $user               = Session::get('user');
        $DatosUsuario       = PanelLogin::getUsuario($user);
        $datos1             = array();
        $datos1['modulo']   = 72;    //Tipos de activos
        $datos1['tipo']     = "UPD"; //Actualiza
        $datos1['registro'] = "Id: ".$id_tipo." |*| Descripción: ".$descripcion." |*| Estado: ".$estado;
        $datos1['usuario']  = $DatosUsuario[0]->empleado;
        $datos1['fecha']    = NOW();
        PanelLogin::insertarLog($datos1);
        ////////////////////////////////
       }

      $Redireccion = "/panel/ticactivos/tipos/modificar/".$id_tipo;
      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }
 }