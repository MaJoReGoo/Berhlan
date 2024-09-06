<?php
/*
Controlador de la tabla bpac_solicitudan
Usa SQl Eloquent de los archivos
app\Models\Bpack\PanelSolicitudesAN.php
*/

namespace App\Http\Controllers\Bpack;
use App\Http\Controllers\Controller;
use App\Models\Bpack\PanelSolicitudesAN;
use App\Models\PanelLogin;
use Illuminate\Support\Facades\Session;
use Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class ConsultasSolicitudesPanelController extends Controller
 {
  public function Consulta()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "bpack/consolicitudan";
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

      return view('bpack.panel-consolicitudan')->with('DatosUsuario',$DatosUsuario);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function ConsultaListado()
   {
    if(Session::has('user'))
     {
      $formData          = Request::all();
      $solicitud         = $formData['solicitud'];
      $sba               = $formData['sba'];
      $sbm               = $formData['sbm'];
      $cliente           = trim($formData['cliente']);
      $actualizacionpara = $formData['actualizacionpara'];
      $estado            = $formData['estado'];
      $usr_solicita      = $formData['usr_solicita'];
      $soldesde          = $formData['soldesde'];
      $solhasta          = $formData['solhasta'];
      $item              = $formData['item'];
      $referencia        = trim($formData['referencia']);
      $version           = $formData['version'];
      $ruta              = $formData['ruta'];
      $pf                = $formData['pf'];
      $remision          = trim($formData['remision']);
      $motivo            = $formData['motivo'];
      $cierredesde       = $formData['cierredesde'];
      $cierrehasta       = $formData['cierrehasta'];
      $user              = Session::get('user');
      $DatosUsuario      = PanelLogin::getUsuario($user);
      $empleado          = $DatosUsuario[0]->empleado;

      $Mensaje = "";
      $sql = "SELECT * FROM bpac_solicitudan, bpac_solicitudandet ";

      //Si se va a buscar la fecha de cierre
      if(($cierredesde != "") || ($cierrehasta != ""))
        $sql = $sql.", bpac_movimientosan ";

      $sql = $sql." WHERE bpac_solicitudan.id_solicitud = bpac_solicitudandet.solicitud ";

      //Si se va a buscar la fecha de cierre
      if(($cierredesde != "") || ($cierrehasta != ""))
        $sql = $sql." AND bpac_solicitudan.id_solicitud = bpac_movimientosan.solicitud ";

      if($solicitud != '')  //Si ingreso la solicitud
       {
        if(!ctype_digit($solicitud))  //La solicitud debe ser un numero
          $Mensaje = "La solicitud debe ser numérica.";
        else
          $sql = $sql." AND id_solicitud = '$solicitud' ";
       }
      else
       {
        if($sba != "")
          $sql = $sql." AND id_actualizacion = '$sba' ";

        if($sbm != "")
          $sql = $sql." AND id_nvdesarrollo = '$sbm' ";

        if($cliente != "")
          $sql = $sql." AND cliente like '%$cliente%' ";

        if(($actualizacionpara != "") && ($actualizacionpara != "NV"))
          $sql = $sql." AND bpac_solicitudan.tipo = '$actualizacionpara' ";

        if($actualizacionpara == "NV")
          $sql = $sql." AND bpac_solicitudan.tipo = '' ";

        if($estado != "")
          $sql = $sql." AND bpac_solicitudan.estado = '$estado' ";

        if($usr_solicita != "")
          $sql = $sql." AND usr_crea = '$usr_solicita' ";

        if($item != "")
          $sql = $sql." AND item = '$item' ";

        if($referencia != "")
          $sql = $sql." AND referencia like '%$referencia%' ";

        if($version != "")
          $sql = $sql." AND version = '$version' ";

        if($ruta != "")
          $sql = $sql." AND ruta = '$ruta' ";

        if($pf != "")
          $sql = $sql." AND prueba_fisica = '$pf' ";

        if($remision != "")
          $sql = $sql." AND remision like '%$remision%' ";

        if($motivo != "")
          $sql = $sql." AND motivo_rechazo = '$motivo' ";

        if($soldesde != "")
          $sql = $sql." AND fecha_crea >= '$soldesde 00:00:00' ";

        if($solhasta != "")
          $sql = $sql." AND fecha_crea <= '$solhasta 23:59:59' ";

        if(($cierredesde != "") || ($cierrehasta != ""))
          $sql = $sql." AND bpac_solicitudan.estado IN('8', '9') AND bpac_movimientosan.estado IN('8', '9') ";

        if($cierredesde != "")
          $sql = $sql." AND bpac_movimientosan.fecha >= '$cierredesde 00:00:00' ";

        if($cierrehasta != "")
          $sql = $sql." AND bpac_movimientosan.fecha <= '$cierrehasta 23:59:59' ";

       }

      $sql = $sql." ORDER BY fecha_crea ";
      $DatosSolicitudes = PanelSolicitudesAN::SolicitudesSql($sql);
      $sol = "";
      foreach($DatosSolicitudes as $DatSol)
       {
        $sol = 1;
       }

      //No se encontró ningún registro
      if($sol == "")
        $Mensaje = "No se encuentran solicitudes con los parámetros ingresados.";

      if($Mensaje != "")
       {
        $Redireccion = "/panel/bpack/consolicitudan";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }
      else
       {
        return view('bpack.panel-consolicitudanListado')->with('DatosUsuario',$DatosUsuario)->with('DatosSolicitudes',$DatosSolicitudes);
       }
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function ConsultaListadoMasinfo($id)
   {
    if(Session::has('user'))
     {
      $Solicitud      = $id;
      $DatosSolicitud = PanelSolicitudesAN::SolicitudAN($Solicitud);
      $user           = Session::get('user');
      $DatosUsuario   = PanelLogin::getUsuario($user);

      $e = 0;
      foreach($DatosSolicitud as $DatSol)
       {
        $e++;
       }

      if($e == 0)
       {
        $Mensaje     = "Esta solicitud no existe.";
        $Redireccion = "/panel/bpack/consolicitudan";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "bpack/consolicitudan";
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

      return view('bpack.panel-consolicitudanMasinfo')->with('DatosUsuario',$DatosUsuario)->with('DatosSolicitud',$DatosSolicitud);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function OtConsulta()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "bpack/otconsultas";
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

      return view('bpack.panel-otConsulta')->with('DatosUsuario',$DatosUsuario);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function ConsultaSB()
   {
    if(Session::has('user'))
     {
      $formData     = Request::all();
      $desde        = $formData['desde'];
      $hasta        = $formData['hasta'];
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "bpack/otconsultas";
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

      if($hasta != "")
        $hasta = $hasta." 23:59:59";

      $DatosSolicitudes = PanelSolicitudesAN::ConActNv($desde, $hasta);

      foreach ($DatosSolicitudes as $key => $value) {
        $DatosMov = PanelSolicitudesAN::MovSolicitudan($value->id_solicitud);
        $value->movimientos = $DatosMov;
      }

      return view('bpack.panel-consolicitudSB')->with('DatosUsuario',$DatosUsuario)->with('DatosSolicitudes',$DatosSolicitudes);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function ConsultaSh()
   {
    if(Session::has('user'))
     {
      $formData     = Request::all();
      $item         = trim($formData['item']);
      $referencia   = trim($formData['referencia']);
      $cliente      = trim($formData['cliente']);
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "bpack/otconsultas";
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

      $DatosSolicitudes = PanelSolicitudesAN::ConSherpasAprbadas($item, $referencia, $cliente);

      return view('bpack.panel-consolicitudSh')->with('DatosUsuario',$DatosUsuario)->with('DatosSolicitudes',$DatosSolicitudes);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }
 }
