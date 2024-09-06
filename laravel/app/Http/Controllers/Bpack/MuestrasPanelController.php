<?php
/*
Controlador de la tabla bpac_muestras
Usa SQl Eloquent del archivo app\Models\Bpack\PanelMuestras.php
*/

namespace App\Http\Controllers\Bpack;

use App\Http\Controllers\Controller;
use App\Models\Bpack\PanelMuestras;
use App\Models\PanelLogin;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class MuestrasPanelController extends Controller
{
  public function Muestras()
  {
    if (Session::has('user')) {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if ($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
      {
        $ruta      = "bpack/muestras";
        $DatosMenu = PanelLogin::getMenuRuta($ruta);
        if ($DatosMenu[0]->libre_acceso == 0)  // Si el modulo no es de libre acceso
        {
          $idmenu    = $DatosMenu[0]->id_menu;

          $ModUser    = explode(',', $DatosUsuario[0]->modulos);
          $NumModUser = count($ModUser);
          $acceso     = 0;
          for ($i = 0; $i < $NumModUser; $i++) {
            if ($idmenu == $ModUser[$i]) {
              $acceso = 1;
              break;
            }
          }

          if ($acceso == 0) //El usuario no tiene acceso al modulo
          {
            $ErrorValidacion = "Usted no esta tiene acceso al módulo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
          }
        }
      }
      //Termina validación

      return view('bpack.panel-muestras')->with('DatosUsuario', $DatosUsuario);
    } else {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
    }
  }


  public function MuestrasAgregarDB()
  {
    if (Session::has('user')) {
      $formData      = Request::all();
      $descripcion   = trim($formData['descripcion']);
      $tamano        = trim($formData['tamano']);
      $cantidad      = trim($formData['cantidad']);
      $observaciones = trim($formData['observaciones']);
      $user          = Session::get('user');
      $DatosUsuario  = PanelLogin::getUsuario($user);

      $datos = array();

      $datos['descripcion']   = $descripcion;
      $datos['tamano']        = $tamano;
      $datos['cantidad']      = $cantidad;
      $datos['observaciones'] = $observaciones;
      $datos['usr_crea']      = $DatosUsuario[0]->empleado;
      $datos['fecha_crea']    = NOW();
      $datos['archivo']       = "";
      $datos['remision']      = "";
      $datos['obs_cierre']    = "";
      $datos['usr_cierre']    = 0;

      PanelMuestras::insertarMuestra($datos);
      $numsol = PanelMuestras::UltimaSolicitud();

      $fileImg = $formData['uploader1'];
      if ($fileImg != '') {
        $ano  = date('Y');
        $mes  = date('m') * 1;
        $ruta = substr(public_path(), 0, -14) . "public/archivos/Bpack/Muestras/" . $ano . "/" . $mes . "/";
        $file          = Request::file('file1');
        $filename      = $file->getClientOriginalName();
        $filename      = MuestrasPanelController::eliminar_tildes($filename);
        $filename      = $ano . "/" . $mes . "/SMF_" . $numsol->id_solicitud . "_Muestra_" . $filename;
        $uploadSuccess = $file->move($ruta, $filename);

        $datos1 = array();
        $datos1['archivo'] = $filename;
        PanelMuestras::actualizarMuestra($numsol->id_solicitud, $datos1);
      }

      $Mensaje = "Muestra física solicitada.";
      $Redireccion = "/panel/bpack/muestras";

      return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
    } else {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
    }
  }


  public function Pendientes($id)
  {
    if (Session::has('user')) {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if ($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
      {
        $ruta      = "bpack/solpendientes";
        $DatosMenu = PanelLogin::getMenuRuta($ruta);
        if ($DatosMenu[0]->libre_acceso == 0)  // Si el modulo no es de libre acceso
        {
          $idmenu    = $DatosMenu[0]->id_menu;

          $ModUser    = explode(',', $DatosUsuario[0]->modulos);
          $NumModUser = count($ModUser);
          $acceso     = 0;
          for ($i = 0; $i < $NumModUser; $i++) {
            if ($idmenu == $ModUser[$i]) {
              $acceso = 1;
              break;
            }
          }

          if ($acceso == 0) //El usuario no tiene acceso al modulo
          {
            $ErrorValidacion = "Usted no esta tiene acceso al módulo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
          }
        }
      }
      //Termina validación

      if ($id == 0) {
        $MuestrasPendientes = PanelMuestras::SolMuestrasAbiertas();
        $MuestrasPendientesCant = PanelMuestras::SolTMuestrasAbiertas();
        $titEstado = 'Activas';
      }

      if ($id == 1) {
        $MuestrasPendientes = PanelMuestras::SolMuestrasCerradas();
        $MuestrasPendientesCant = PanelMuestras::SolMuestrasCerradasCant();
        $titEstado = 'Cerradas';
      }

      if ($id == 2) {
        $estado = 1;
        $MuestrasPendientes = PanelMuestras::SolMuestrasEstado($estado);
        $MuestrasPendientesCant = PanelMuestras::SolMuestrasCerradasCant($estado);
        $titEstado = 'Canceladas';
      }


      return view('bpack.panel-muestrasPendientes')->with('DatosUsuario', $DatosUsuario)->with('MuestrasPendientes', $MuestrasPendientes)->with('MuestrasPendientesCant', $MuestrasPendientesCant)->with('titEstado', $titEstado);
    } else {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
    }
  }

  public function Procesar($id)
  {
    if (Session::has('user')) {
      $Muestra      = $id;
      $DatosMuestra = PanelMuestras::Muestra($Muestra);

      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if ($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
      {
        $ruta      = "bpack/solpendientes";
        $DatosMenu = PanelLogin::getMenuRuta($ruta);
        if ($DatosMenu[0]->libre_acceso == 0)  // Si el modulo no es de libre acceso
        {
          $idmenu    = $DatosMenu[0]->id_menu;

          $ModUser    = explode(',', $DatosUsuario[0]->modulos);
          $NumModUser = count($ModUser);
          $acceso     = 0;
          for ($i = 0; $i < $NumModUser; $i++) {
            if ($idmenu == $ModUser[$i]) {
              $acceso = 1;
              break;
            }
          }

          if ($acceso == 0) //El usuario no tiene acceso al modulo
          {
            $ErrorValidacion = "Usted no esta tiene acceso al módulo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
          }
        }
      }
      //Termina validación

      $e = 0;
      foreach ($DatosMuestra as $DatMue)
        $e++;

      if ($e == 0) {
        $Mensaje     = "Este solicitud no existe.";
        $Redireccion = "/panel/bpack/muestras/pendientes/0";
        return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
      }

      if ($DatosMuestra[0]->usr_cierre != 0) {
        $Mensaje     = "Este solicitud ya fue atendida ";
        $Redireccion = "/panel/bpack/muestras/pendientes/0";
        return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
      } else {
        return view('bpack.panel-muestrasProcesar')->with('DatosUsuario', $DatosUsuario)->with('DatosMuestra', $DatosMuestra);
      }
    } else {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
    }
  }


  public function ProcesarDB()
  {
    if (Session::has('user')) {
      $formData     = Request::all();
      $muestra      = trim($formData['muestra']);
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      $datos = array();

      $datos['remision']     = trim($formData['remision']);
      $datos['obs_cierre']   = trim($formData['observaciones']);
      $datos['usr_cierre']   = $DatosUsuario[0]->empleado;
      $datos['fecha_cierre'] = NOW();

      PanelMuestras::actualizarMuestra($muestra, $datos);

      $Mensaje = "Solicitud procesada correctamente.";
      $Redireccion = "/panel/bpack/muestras/pendientes/0";

      return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
    } else {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
    }
  }

  public function ConsultaMuestras()
  {
    if (Session::has('user')) {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if ($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
      {
        $ruta      = "bpack/muestrascon";
        $DatosMenu = PanelLogin::getMenuRuta($ruta);
        if ($DatosMenu[0]->libre_acceso == 0)  // Si el modulo no es de libre acceso
        {
          $idmenu    = $DatosMenu[0]->id_menu;

          $ModUser    = explode(',', $DatosUsuario[0]->modulos);
          $NumModUser = count($ModUser);
          $acceso     = 0;
          for ($i = 0; $i < $NumModUser; $i++) {
            if ($idmenu == $ModUser[$i]) {
              $acceso = 1;
              break;
            }
          }

          if ($acceso == 0) //El usuario no tiene acceso al modulo
          {
            $ErrorValidacion = "Usted no esta tiene acceso al módulo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
          }
        }
      }
      //Termina validación

      return view('bpack.panel-muestrascon')->with('DatosUsuario', $DatosUsuario);
    } else {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
    }
  }


  public function ConsultaMuestrasListado()
  {
    if (Session::has('user')) {
      $formData     = Request::all();
      $solicitud    = $formData['solicitud'];
      $descripcion  = trim($formData['descripcion']);
      $tamano       = trim($formData['tamano']);
      $cantidad     = $formData['cantidad'];
      $estado       = $formData['estado'];
      $usr_solicita = $formData['usr_solicita'];
      $soldesde     = $formData['soldesde'];
      $solhasta     = $formData['solhasta'];
      $remision     = trim($formData['remision']);
      $usr_cierre   = $formData['usr_cierre'];
      $cierredesde  = $formData['cierredesde'];
      $cierrehasta  = $formData['cierrehasta'];
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      $Mensaje = "";
      $sql = "SELECT * FROM bpac_muestras WHERE TRUE ";

      if ($solicitud != '')  //Si ingreso la solicitud
      {
        if (!ctype_digit($solicitud))  //La solicitud debe ser un numero
          $Mensaje = "La solicitud debe ser numérica.";
        else
          $sql = $sql . " AND id_solicitud = '$solicitud' ";
      } else {
        if ($descripcion != "")
          $sql = $sql . " AND descripcion like '%$descripcion%' ";

        if ($tamano != "")
          $sql = $sql . " AND tamano like '%$tamano%' ";

        if ($cantidad != "")
          $sql = $sql . " AND cantidad = '$cantidad' ";

        if ($estado == "A")  //Atendida
          $sql = $sql . " AND usr_cierre != 0 ";

        if ($estado == "P")  //Pendientes
          $sql = $sql . " AND usr_cierre = 0 ";

        if ($usr_solicita != "")
          $sql = $sql . " AND usr_crea = '$usr_solicita' ";

        if ($soldesde != "")
          $sql = $sql . " AND fecha_crea >= '$soldesde 00:00:00' ";

        if ($solhasta != "")
          $sql = $sql . " AND fecha_crea <= '$solhasta 23:59:59' ";

        if ($remision != "")
          $sql = $sql . " AND remision like '%$remision%' ";

        if ($usr_cierre != "")
          $sql = $sql . " AND usr_cierre = '$usr_cierre' ";

        if ($cierredesde != "")
          $sql = $sql . " AND fecha_cierre >= '$cierredesde 00:00:00' ";

        if ($cierrehasta != "")
          $sql = $sql . " AND fecha_cierre <= '$cierrehasta 23:59:59' ";
      }

      $sql = $sql . " ORDER BY fecha_crea ";
      $DatosSolicitudes = PanelMuestras::MuestrasSql($sql);
      $sol = "";
      foreach ($DatosSolicitudes as $DatSol) {
        $sol = 1;
      }

      //No se encontró ningún registro
      if ($sol == "")
        $Mensaje = "No se encuentran solicitudes, con los parámetros ingresados.";

      if ($Mensaje != "") {
        $Redireccion = "/panel/bpack/muestrascon";
        return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
      } else {
        return view('bpack.panel-muestrasConListado')->with('DatosUsuario', $DatosUsuario)->with('DatosSolicitudes', $DatosSolicitudes);
      }
    } else {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
    }
  }


  public function eliminar_tildes($cadena)
  {
    //Codificamos la cadena en formato utf8 en caso de que nos de errores
    //$cadena = utf8_encode($cadena);

    //Ahora reemplazamos las letras
    $cadena = str_replace(
      array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
      array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
      $cadena
    );

    $cadena = str_replace(
      array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
      array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
      $cadena
    );

    $cadena = str_replace(
      array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
      array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
      $cadena
    );

    $cadena = str_replace(
      array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
      array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
      $cadena
    );

    $cadena = str_replace(
      array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
      array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
      $cadena
    );

    $cadena = str_replace(
      array('ñ', 'Ñ', 'ç', 'Ç', ' ', '#', '%', '°', '´'),
      array('n', 'N', 'c', 'C', '_',  '',  '',  '',  ''),
      $cadena
    );
    return $cadena;
  }

  public function CancelarDB($id)
  {
    if (Session::has('user')) {
      $formData     = Request::all();
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      $datos = array();

      $datos['cancelada']     = 1;
      $datos['fecha_cierre'] = NOW();

      PanelMuestras::actualizarMuestra($id, $datos);

      $Mensaje = "Solicitud procesada correctamente.";
      $Redireccion = "/panel/bpack/muestras/pendientes/0";

      return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
    } else {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
    }
  }
}
