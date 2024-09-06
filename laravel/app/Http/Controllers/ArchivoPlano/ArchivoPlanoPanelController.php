<?php
/*
Controlador de la tabla noticias
Usa SQl Eloquent del archivo app\Models\Noticias\PanelNoticias.php
*/

namespace App\Http\Controllers\ArchivoPlano;

use App\Http\Controllers\Controller;
use App\Models\PanelLogin;
use App\Models\ArchivoPlano\PanelArchivoPlano;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class ArchivoPlanoPanelController extends Controller
{
  var $server = '/Berhlan/public';

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
      array('n', 'N', 'c', 'C', ' ',  '',  '',  '',  ''),
      $cadena
    );
    return $cadena;
  }

  // Lista
  public function listadoArchivoPlano($tipo)
  {
    if (Session::has('user')) {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      if ($tipo == 0) {
        $DatosArchivos = PanelArchivoPlano::getArchivoPlanoLista();
      } else {
        $DatosArchivos = PanelArchivoPlano::getArchivoPlanoListaEstado($tipo);
      }

      return view('archivosPlanos.panel-listarArchivosPlanos')->with('DatosUsuario', $DatosUsuario)->with('DatosArchivos', $DatosArchivos);
    } else {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
    }
  }

  // Agregar
  public function ArchivoPlanoAgregar()
  {
    if (Session::has('user')) {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);
      $DatosArchivos = PanelArchivoPlano::getArchivoPlanoLista();

      return view('archivosPlanos.panel-archivoPlanoAgregar')->with('DatosUsuario', $DatosUsuario);
    } else {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
    }
  }

  public function ArchivoPlanoAgregarDB()
  {
    if (Session::has('user')) {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);
      $formData     = Request::all();
      $datos = array();

      $Cant = PanelArchivoPlano::getCantArchivoPlano();

      if ($Cant == 0) {
        $Consecutivo = 1;
      } else {
        $UltimoId = PanelArchivoPlano::getUltimoArchivoPlano();
        foreach ($UltimoId as $UltId) {
          $Uid = $UltId->consecutivo;
          $Consecutivo = $Uid + 1;
        }
      }

      $apellido_demandante = $this->eliminar_tildes($formData['apellido_demandante']);
      $nombre_demandante = $this->eliminar_tildes($formData['nombre_demandante']);
      $apellido_demandado = $this->eliminar_tildes($formData['apellido_demandado']);
      $nombre_demandado = $this->eliminar_tildes($formData['nombre_demandado']);

      $datos['consecutivo'] = $Consecutivo;
      $datos['fecha_cargue'] = $formData['fecha_cargue'];
      $datos['oficina_origen'] = trim($formData['oficina_origen']);
      $datos['oficina_destino'] = trim($formData['oficina_destino']);
      $datos['codigo_concepto'] = trim($formData['codigo_concepto']);
      $datos['numero_expediente'] = trim($formData['numero_expediente']);
      $datos['cuenta_judicial'] = trim($formData['cuenta_judicial']);
      $datos['cuenta_ahorros'] = trim($formData['cuenta_ahorros']);
      $datos['valor_deposito'] = trim($formData['valor_deposito']);
      $datos['tipo_identificacion_demandante'] = trim($formData['tipo_identificacion_demandante']);
      $datos['identificacion_demandante'] = trim($formData['identificacion_demandante']);
      $datos['tipo_identificacion_demandado'] = trim($formData['tipo_identificacion_demandado']);
      $datos['identificacion_demandado'] = trim($formData['identificacion_demandado']);
      $datos['apellido_demandante'] = trim(strtoupper($apellido_demandante));
      $datos['nombre_demandante'] = trim(strtoupper($nombre_demandante));
      $datos['apellido_demandado'] = trim(strtoupper($apellido_demandado));
      $datos['nombre_demandado'] = trim(strtoupper($nombre_demandado));
      $datos['numero_proceso'] = trim($formData['numero_proceso']);
      $datos['estado'] = trim($formData['estado']);
      $datos['fecha_creacion'] = now();

      PanelArchivoPlano::insertarArchivoPlano($datos);

      $DatosArchivos = PanelArchivoPlano::getArchivoPlanoLista();

      return redirect('https://192.168.1.210' . $this->server . '/panel/archivo-plano/lista/2')->with('DatosUsuario', $DatosUsuario)->with('DatosArchivos', $DatosArchivos);
    } else {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
    }
  }

  //Editar - Duplicar
  public function ArchivoPlanoEditar($id)
  {
    if (Session::has('user')) {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);
      $DatosArchivo = PanelArchivoPlano::getArchivoPlano($id);

      return view('archivosPlanos.panel-archivoPlanoDuplicar')->with('DatosUsuario', $DatosUsuario)->with('DatosArchivo', $DatosArchivo);
    } else {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
    }
  }

  //Generar Archivo
  public function GenerarArchivo()
  {
    if (Session::has('user')) {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);
      $formData = Request::all();
      $dataReg = $formData['idexparc'];
      $datTamReg = sizeof($dataReg);
      $datos = array();
      $fechaTit = date('Y-m-d');
      $fechaTit = str_replace('-', '', $fechaTit);
      $DatosArchivos = PanelArchivoPlano::getArchivoPlanoLista();
      $i = 0;
      $contenido = '';
      $nitBh = '09007427719';
      $nombreArchivo = 'GD' . $fechaTit . $nitBh . '_01';

      $encabp1 = '';
      $encabp1Def = str_pad($encabp1, 23, " ", STR_PAD_LEFT);

      // totalRegistros //
      $encabp2 = $datTamReg;
      $encabp2Def = str_pad($encabp2, 10, "0", STR_PAD_LEFT);

      $encabp3 = '';
      $encabp3Def = str_pad($encabp3, 40, " ", STR_PAD_LEFT);

      $encabp4 = '3';
      $encabp5 = ' ';

      //Nit
      $encabp6 = '9007427719';
      $encabp6Def = str_pad($encabp6, 10, "0", STR_PAD_LEFT);

      $encabp7 = '';
      $encabp7Def = str_pad($encabp7, 12, " ", STR_PAD_LEFT);

      $encabp8 = 'BERHLAN DE';
      $encabp8Def = str_pad($encabp8, 20, " ", STR_PAD_LEFT);

      $encabp9 = 'COLOMBIA SAS';
      $encabp9Def = str_pad($encabp9, 20, " ", STR_PAD_LEFT);

      $encabp10 = '';
      $encabp10Def = str_pad($encabp10, 63, " ", STR_PAD_LEFT);

      $contenido .= $encabp1Def . '' . $encabp2Def . '' . $encabp3Def . '' . $encabp4 . '' . $encabp5 . '' . $encabp6Def . '' . $encabp7Def . '' . $encabp8Def . '' . $encabp9Def . '' . $encabp10Def . PHP_EOL;
      while ($i < $datTamReg) {

        $idRegExp =  $dataReg[$i];
        $dataFile = PanelArchivoPlano::getArchivoPlano($idRegExp);
        $datos['estado'] = 1;
        PanelArchivoPlano::actualizarArchivoPlano($idRegExp, $datos);
        $i++;

        // Consecutivo //
        $numCons = $dataFile[0]->consecutivo;
        $ConsDef = str_pad($numCons, 6, "0", STR_PAD_LEFT);

        //Fecha
        $fechaCargue = str_replace('-', '', $dataFile[0]->fecha_cargue);

        // No. Expediente //
        $numExp = $dataFile[0]->numero_expediente;
        $numExpsDef = str_pad($numExp, 10, "0", STR_PAD_LEFT);

        // Cuenta Judicial //
        $ctJud = $dataFile[0]->cuenta_judicial;
        $ctJudDef = str_pad($ctJud, 12, "0", STR_PAD_LEFT);

        // Cuenta Judicial //
        $ctAhr = $dataFile[0]->cuenta_ahorros;
        $ctAhrDef = str_pad($ctAhr, 12, "0", STR_PAD_LEFT);

        // Valor //
        $valor = $dataFile[0]->valor_deposito;
        $valor2 = $valor . '.00';
        $valorDef = str_pad($valor2, 16, "0", STR_PAD_LEFT);

        // Identificacion Demandante //
        $idDte = $dataFile[0]->identificacion_demandante;
        $idDteDef = str_pad($idDte, 11, "0", STR_PAD_LEFT);

        // Identificacion Demandado //
        $idDdo = $dataFile[0]->identificacion_demandado;
        $idDdoDef = str_pad($idDdo, 11, "0", STR_PAD_LEFT);

        //Apellido y Nombre Demandante
        $apeDte = $dataFile[0]->apellido_demandante;
        $apeDteDef = str_pad($apeDte, 20, " ", STR_PAD_RIGHT);

        $nomDte = $dataFile[0]->nombre_demandante;
        $nomDteDef = str_pad($nomDte, 20, " ", STR_PAD_RIGHT);

        //Apellido y Nombre Demandado
        $apeDdo = $dataFile[0]->apellido_demandado;
        $apeDdoDef = str_pad($apeDdo, 20, " ", STR_PAD_RIGHT);

        $nomDdo = $dataFile[0]->nombre_demandado;
        $nomDdoDef = str_pad($nomDdo, 20, " ", STR_PAD_RIGHT);

        // Numero Proceso //
        $numPro = $dataFile[0]->numero_proceso;
        $numProDef = str_pad($numPro, 23, "0", STR_PAD_LEFT);

        $contenido .= $ConsDef . '' . $fechaCargue . '' . $dataFile[0]->oficina_origen . '' . $dataFile[0]->oficina_destino . '' . $dataFile[0]->codigo_concepto . '' . $numExpsDef . '' . $ctJudDef . '' . $ctAhrDef . '' . $valorDef . '' . $dataFile[0]->tipo_identificacion_demandante . '' . $idDteDef . '' . $dataFile[0]->tipo_identificacion_demandado . '' . $idDdoDef . '' . $apeDteDef . '' . $nomDteDef . '' . $apeDdoDef . '' . $nomDdoDef . '' . $numProDef . PHP_EOL;
      }


      $destinationPath = substr(public_path(), 0, -14) . "public/txtupload/";

      header("Content-Disposition: attachment; filename=\"$nombreArchivo.txt\"");
      header("Content-Type: application/force-download");
      header("Content-Transfer-Encoding: binary");
      header("Content-Length: " . strlen($contenido));
      header("Pragma: no-cache");
      header("Expires: 0");
      echo $contenido;

      //return redirect('https://localhost' . $this->server . '/panel/archivo-plano/lista/2')->with('DatosUsuario', $DatosUsuario)->with('DatosArchivos', $DatosArchivos);
    }
  }
}
