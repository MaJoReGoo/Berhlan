<?php
/*
Controlador de la tabla proc_tiposdocumentos
Usa SQl Eloquent del archivo app\Models\Procesos\PanelTiposDocumentos.php
*/

namespace App\Http\Controllers\Procesos;
use App\Http\Controllers\Controller;
use App\Models\PanelLogin;
use App\Models\Procesos\PanelTiposDocumentos;
use Illuminate\Support\Facades\Session;
use Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class TipoDocProcesosPanelController extends Controller
 {
  public function listadoTiposDocumentos()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "procesos/tiposdocumentos";
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

      $DatosTiposDocumentos = PanelTiposDocumentos::getTiposDocumentos();
      return view('procesos.panel-tiposdocumentos')->with('DatosUsuario',$DatosUsuario)->with('DatosTiposDocumentos',$DatosTiposDocumentos);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function TiposDocumentosAgregar()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "procesos/tiposdocumentos";
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
            $ErrorValidacion = "Usted no esta tiene acceso al módulo.";
            return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
           }
         }
       }
      //Termina validación

      return view('procesos.panel-tiposdocumentosAgregar')->with('DatosUsuario',$DatosUsuario);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function TiposDocumentosAgregarDB()
   {
    if(Session::has('user'))
     {
      $formData    = Request::all();
      $descripcion = trim($formData['descripcion']);

      $datos = array();

      //Realizo las validaciones
      $Mensaje = "";

      $TipoDuplicado = PanelTiposDocumentos::getTipoUnico($descripcion);

      if($TipoDuplicado != 0)
        $Mensaje = "Ya se encuentra un tipo de documento con esa descripción.";
      else if($descripcion == "")
        $Mensaje = "Debe ingresar la descripción.";

      if($Mensaje != "")
       {
        $Redireccion = "/panel/procesos/tiposdocumentos/agregar";
       }
      else
       {
        $datos['descripcion'] = $descripcion;

        PanelTiposDocumentos::insertarTipo($datos);
        $Mensaje     = "Tipo de documento creado.";
        $Redireccion = "/panel/procesos/tiposdocumentos";
       }

      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function TiposDocumentosModificar($id)
   {
    if(Session::has('user'))
     {
      $idTipo       = $id;
      $DatosTipo    = PanelTiposDocumentos::getTipo($idTipo);
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "procesos/tiposdocumentos";
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
            $ErrorValidacion = "Usted no esta tiene acceso al módulo.";
            return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
           }
         }
       }
      //Termina validación

      if($DatosTipo == true)
       {
        return view('procesos.panel-tiposdocumentosModificar')->with('DatosUsuario',$DatosUsuario)->with('DatosTipo',$DatosTipo);
       }
      else
       {
        $Mensaje     = "";
        $Redireccion = "/panel/procesos/tiposdocumentos";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function TiposDocumentosModificarDB()
   {
    if(Session::has('user'))
     {
      $formData    = Request::all();
      $id_tipo     = $formData['id_tipo'];
      $descripcion = trim($formData['descripcion']);

      $datos = array();

      //Realizo las validaciones
      $Mensaje = "";

      $TipoDuplicado = PanelTiposDocumentos::getTipoUnicoMod($id_tipo, $descripcion);

      if($TipoDuplicado != 0)
        $Mensaje = "Ya se encuentra un tipo de documento con esa descripción.";
      else if($descripcion == "")
        $Mensaje = "Debe ingresar la descripción.";

      if($Mensaje == "")
       {
        $datos['descripcion'] = $descripcion;

        PanelTiposDocumentos::actualizarTipo($id_tipo,$datos);

        $Mensaje = "Tipo de documento modificado.";
       }

      $Redireccion = "/panel/procesos/tiposdocumentos/modificar/".$id_tipo;
      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function TiposDocumentosEliminarDB()
   {
    if(Session::has('user'))
     {
      $formData     = Request::all();
      $id_tipo      = $formData['id_tipo'];
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "procesos/tiposdocumentos";
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

      //validar que no este asociado a un documento para poderlo borrar
      $asociado = PanelTiposDocumentos::TipoAsociado($id_tipo);
      if($asociado > 0)
       {
        $Mensaje = "No se puede borrar el tipo de documento, por que tiene documentos asociados.";
       }
      else
       {
        PanelTiposDocumentos::BorrarTipo($id_tipo);
        $Mensaje = "Tipo de documento eliminado.";
       }

      $Redireccion = "/panel/procesos/tiposdocumentos";
      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }
 }