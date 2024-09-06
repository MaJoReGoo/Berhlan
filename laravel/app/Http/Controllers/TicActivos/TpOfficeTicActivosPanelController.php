<?php
/*
Controlador de la tabla acti_tipooffice
Usa SQl Eloquent del archivo app\Models\Bpack\PanelTpOffice.php
*/

namespace App\Http\Controllers\TicActivos;
use App\Http\Controllers\Controller;
use App\Models\TicActivos\PanelTpOffice;
use App\Models\PanelLogin;
use Illuminate\Support\Facades\Session;
use Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class TpOfficeTicActivosPanelController extends Controller
 {
  public function TpOffice()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "ticactivos/tpoffice";
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

      $DatosTpOffice     = PanelTpOffice::getTpOffices();
      $TpOfficeActivos   = PanelTpOffice::getCantidadTpOfficeActivos();
      $TpOfficeInactivos = PanelTpOffice::getCantidadTpOfficeInactivos();
      return view('ticactivos.panel-tpOffice')->with('DatosUsuario',$DatosUsuario)->with('DatosTpOffice',$DatosTpOffice)->with('TpOfficeActivos',$TpOfficeActivos)->with('TpOfficeInactivos',$TpOfficeInactivos);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function TpOfficeAgregar()
   {
    if(Session::has('user'))
     {
      $ErrorValidacion = "";  //Variable que retorna el error en caso de que no pase la validación
      $user            = Session::get('user');
      $DatosUsuario    = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "ticactivos/tpoffice";
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

      return view('ticactivos.panel-tpOfficeAgregar')->with('DatosUsuario',$DatosUsuario);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function TpOfficeAgregarDB()
   {
    if(Session::has('user'))
     {
      $formData    = Request::all();
      $descripcion = trim($formData['descripcion']);

      $datos = array();

      //Realizo las validaciones
      $Mensaje = "";

      $TpOfficeDuplicado = PanelTpOffice::getTpOfficeUnico($descripcion);

      if($TpOfficeDuplicado != 0)
        $Mensaje = "Ya se encuentra creado un tipo de office con esa descripción.";
      else if($descripcion == "")
        $Mensaje = "Debe ingresar el nombre del motivo.";

      if($Mensaje != "")
       {
        $Redireccion = "/panel/ticactivos/tpoffice/agregar";
       }
      else
       {
        $datos['descripcion'] = $descripcion;
        $datos['estado']      = 1; //Activo

        PanelTpOffice::insertarTpOffice($datos);
        $Mensaje = "Tipo creado.";

        //Agrego el guardado al log
        $user               = Session::get('user');
        $DatosUsuario       = PanelLogin::getUsuario($user);
        $idtipo             = PanelTpOffice::UltimoTpOffice();
        $datos1             = array();
        $datos1['modulo']   = 73;    //Tipos de office
        $datos1['tipo']     = "INS"; //Inserta
        $datos1['registro'] = "Id: ".$idtipo->id_tipo." |*| Descripción: ".$descripcion;
        $datos1['usuario']  = $DatosUsuario[0]->empleado;
        $datos1['fecha']    = NOW();
        PanelLogin::insertarLog($datos1);
        ////////////////////////////////

        $Redireccion = "/panel/ticactivos/tpoffice";
       }

      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function TpOfficeModificar($id)
   {
    if(Session::has('user'))
     {
      $idMotivo      = $id;
      $DatosTpOffice = PanelTpOffice::getTpOffice($idMotivo);
      $user          = Session::get('user');
      $DatosUsuario  = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "ticactivos/tpoffice";
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

      if($DatosTpOffice == true)
       {
        return view('ticactivos.panel-tpOfficeModificar')->with('DatosUsuario',$DatosUsuario)->with('DatosTpOffice',$DatosTpOffice);
       }
      else
       {
        $Mensaje     = "";
        $Redireccion = "/panel/ticactivos/tpoffice";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function TpOfficeModificarDB()
   {
    if(Session::has('user'))
     {
      $formData    = Request::all();
      $id_tipo     = $formData['id_tipo'];
      $descripcion = trim($formData['descripcion']);
      $estado      = $formData['estado'];

      $datos = array();

      //Realizo las validaciones
      $Mensaje = "";

      $TipoDuplicado = PanelTpOffice::getTpOfficeUnicoModificar($descripcion, $id_tipo);

      if($TipoDuplicado != 0)
        $Mensaje = "Ya se encuentra creado un tipo de office con esa descripción.";
      else if($descripcion == "")
        $Mensaje = "Debe ingresar el motivo.";
      else if($estado == "")
        $Mensaje = "Debe seleccionar el estado.";

      if($Mensaje == "")
       {
        $datos['descripcion'] = $descripcion;
        $datos['estado']      = $estado;

        PanelTpOffice::actualizarTpOffice($id_tipo, $datos);
        $Mensaje = "Tipo de office modificado.";

        //Agrego el guardado al log
        $user               = Session::get('user');
        $DatosUsuario       = PanelLogin::getUsuario($user);
        $datos1             = array();
        $datos1['modulo']   = 73;    //Tipos de office
        $datos1['tipo']     = "UPD"; //Actualiza
        $datos1['registro'] = "Id: ".$id_tipo." |*| Descripción: ".$descripcion." |*| Estado: ".$estado;
        $datos1['usuario']  = $DatosUsuario[0]->empleado;
        $datos1['fecha']    = NOW();
        PanelLogin::insertarLog($datos1);
        ////////////////////////////////
       }

      $Redireccion = "/panel/ticactivos/tpoffice/modificar/".$id_tipo;
      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }
 }