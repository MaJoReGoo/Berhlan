<?php
/*
Controlador de la tabla proc_documentos
Usa SQl Eloquent del archivo app\Models\Procesos\PanelDocumentos.php
 */

namespace App\Http\Controllers\Procesos;

use App\Http\Controllers\Controller;
use App\Models\PanelLogin;
use App\Models\Procesos\PanelDocumentos;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Request;

class DocProcesosPanelController extends Controller
{
    public function listadoDocumentos()
    {
        if (Session::has('user')) {
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "procesos/documentos";
                $DatosMenu = PanelLogin::getMenuRuta($ruta);
                if ($DatosMenu[0]->libre_acceso == 0) //Si el modulo no es de libre acceso
                {
                    $idmenu = $DatosMenu[0]->id_menu;

                    $ModUser = explode(',', $DatosUsuario[0]->modulos);
                    $NumModUser = count($ModUser);
                    $acceso = 0;
                    for ($i = 0; $i < $NumModUser; $i++) {
                        if ($idmenu == $ModUser[$i]) {
                            $acceso = 1;
                            break;
                        }
                    }

                    if ($acceso == 0) //El usuario no tiene acceso al modulo
                    {
                        $ErrorValidacion = "Usted no tiene acceso al módulo.";
                        return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
                    }
                }
            }
            //Termina validación

            $DatosDocumentos = PanelDocumentos::getDocumentos();
            return view('procesos.panel-documentos')->with('DatosUsuario', $DatosUsuario)->with('DatosDocumentos', $DatosDocumentos);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function DocumentosAgregar()
    {
        if (Session::has('user')) {
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "procesos/documentos";
                $DatosMenu = PanelLogin::getMenuRuta($ruta);
                if ($DatosMenu[0]->libre_acceso == 0) //Si el modulo no es de libre acceso
                {
                    $idmenu = $DatosMenu[0]->id_menu;

                    $ModUser = explode(',', $DatosUsuario[0]->modulos);
                    $NumModUser = count($ModUser);
                    $acceso = 0;
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

            return view('procesos.panel-documentosAgregar')->with('DatosUsuario', $DatosUsuario);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function DocumentosAgregarDB()
    {
        if (Session::has('user')) {
            $formData = Request::all();
            $login = $formData['login'];
            $descripcion = trim($formData['descripcion']);
            $tipo = $formData['tipo'];
            $fileImg = $formData['uploader1'];

            $datos = array();

            //Realizo las validaciones
            $Mensaje = "";

            $DocumentoDuplicado = PanelDocumentos::getDocumentoUnico($descripcion);

            if ($DocumentoDuplicado != 0) {
                $Mensaje = "Ya se encuentra un documento con esa descripción.";
            } else if ($descripcion == "") {
                $Mensaje = "Debe ingresar la descripción.";
            } else if ($fileImg == "") {
                $ErrorValidacion = "Debe adjuntar la imagen.";
            }

            if ($Mensaje != "") {
                $Redireccion = "/panel/procesos/documentos/agregar";
            } else {
                if ($fileImg != '') {
                    $ruta = substr(public_path(), 0, -14) . "public/archivos/Procesos/Documentos/";

                    $file = Request::file('file1');
                    $destinationPath = $ruta;
                    $filename = $file->getClientOriginalName();
                    $filename = DocProcesosPanelController::eliminar_tildes($filename);
                    $uploadSuccess = $file->move($destinationPath, $filename);
                } else {
                    $filename = 'Imagen no encontrada';
                }

                $datos['descripcion'] = $descripcion;
                $datos['tipo'] = $tipo;
                $datos['ruta1'] = $filename;
                $datos['fecha1'] = NOW();
                $datos['ruta2'] = "";
                $datos['fecha2'] = null;

                PanelDocumentos::insertarDocumento($datos);
                $documento = PanelDocumentos::UltimoDocumento();
                $DatosUsuario = PanelLogin::getUsuario($login);

                $datos1 = array();
                $datos1['documento'] = $documento->id_documento;
                $datos1['observaciones'] = "Se creo un nuevo documento. " . $descripcion . ".";
                $datos1['usuario'] = $DatosUsuario[0]->id_usuario;
                $datos1['fecha'] = NOW();

                PanelDocumentos::insertarDocumentoLog($datos1);

                $Mensaje = "Documento creado.";
                $Redireccion = "/panel/procesos/documentos";
            }

            return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function DocumentosModificar($id)
    {
        if (Session::has('user')) {
            $idDocumento = $id;
            $DatosDocumento = PanelDocumentos::getDocumento($idDocumento);
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "procesos/documentos";
                $DatosMenu = PanelLogin::getMenuRuta($ruta);
                if ($DatosMenu[0]->libre_acceso == 0) //Si el modulo no es de libre acceso
                {
                    $idmenu = $DatosMenu[0]->id_menu;

                    $ModUser = explode(',', $DatosUsuario[0]->modulos);
                    $NumModUser = count($ModUser);
                    $acceso = 0;
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

            if ($DatosDocumento == true) {
                return view('procesos.panel-documentosModificar')->with('DatosUsuario', $DatosUsuario)->with('DatosDocumento', $DatosDocumento);
            } else {
                $DatosDocumentos = PanelDocumentos::getDocumentos();
                return view('procesos.panel-documentos')->with('DatosUsuario', $DatosUsuario)->with('DatosDocumentos', $DatosDocumentos);
            }
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function DocumentosModificarDB()
    {
        if (Session::has('user')) {
            $formData = Request::all();
            $login = $formData['login'];
            $id_documento = $formData['id_documento'];
            $descripcion = trim($formData['descripcion']);
            $tipo = $formData['tipo'];
            $observaciones = trim($formData['observaciones']);
            $fileArchivo = $formData['uploader1'];
            $actual = $formData['actual'] ?? 0;
            $anterior = $formData['anterior'] ?? 0;
            $DatosUsuario = PanelLogin::getUsuario($login);
            $DatosDocumento = PanelDocumentos::getDocumento($id_documento);

            $datos = array();

            //Realizo las validaciones
            $Mensaje = "";

            $DocumentoDuplicado = PanelDocumentos::getDocumentoUnicoMod($id_documento, $descripcion);

            if ($DocumentoDuplicado != 0) {
                $Mensaje = "Ya se encuentra un documento con esa descripción.";
            } else if ($descripcion == "") {
                $Mensaje = "Debe ingresar la descripción.";
            } else if ($observaciones == "") {
                $Mensaje = "Debe explicar el cambio.";
            }

            if ($Mensaje == "") {
                if ($fileArchivo != '') {
                    $ruta = substr(public_path(), 0, -14) . "public/archivos/Procesos/Documentos/";

                    $file = Request::file('file1');
                    $destinationPath = $ruta;
                    $filename = $file->getClientOriginalName();
                    $filename = DocProcesosPanelController::eliminar_tildes($filename);

                    // Si ambos checkboxes están seleccionados, procesar ambos archivos
                    if ($actual == 1 && $anterior == 1) {

                        // Procesar archivo actual
                        $datos['ruta1'] = $filename;
                        $datos['fecha1'] = NOW();
                        //Paso el primer archivo a ser segundo
                        $datos['ruta2'] = "V2-" . $filename;
                        $datos['fecha2'] = NOW();
                        $uploadSuccess = $file->move($destinationPath, $filename);

                        //Renombre el segundo archivo agregándole V2- al inicio
                        $archivo1 = $ruta . $datos['ruta1'];
                        $archivo2 = $ruta . $datos['ruta2'];

                        if (file_exists($archivo1)) {
                            copy($archivo1, $archivo2);
                        }

                    } elseif ($actual == 1) {
                        // Procesar solo archivo actual
                        $datos['ruta1'] = $filename;
                        $datos['fecha1'] = NOW();
                        $uploadSuccess = $file->move($destinationPath, $filename);
                    } elseif ($anterior == 1) {
                        // Procesar solo archivo anterior
                        $datos['ruta2'] = "V2-" . $filename;
                        $datos['fecha2'] = $DatosDocumento[0]->fecha1;
                        $archivo2 = "V2-" . $filename;
                        $uploadSuccess = $file->move($destinationPath, $archivo2);
                    }

                    if ($actual == 0 && $anterior == 0) {
                        /* if ($DatosDocumento[0]->ruta2 != '') {
                            $archivoActual = $ruta . $DatosDocumento[0]->ruta2;
                            $nuevoNombre = $ruta .$DatosDocumento[0]->ruta2;
                            if (file_exists($archivoActual)) {
                                rename($archivoActual, $nuevoNombre);
                            }

                        } */

                        $datos['ruta1'] = $filename;
                        $datos['fecha1'] = NOW();

                        //Paso el primer archivo a ser segundo
                        $datos['ruta2'] = "V2-" . $DatosDocumento[0]->ruta1;
                        $datos['fecha2'] = $DatosDocumento[0]->fecha1;

                        //Renombre el segundo archivo agregándole V2- al inicio
                        $archivo1 = $ruta . $DatosDocumento[0]->ruta1;
                        $archivo2 = $ruta . $datos['ruta2'];
                        if (file_exists($archivo1)) {
                            rename($archivo1, $archivo2);
                        }

                        $uploadSuccess = $file->move($destinationPath, $filename);

                    }
                } else {
                    $filename = 'Archivo no encontrado';
                }

                $datos['descripcion'] = $descripcion;
                $datos['tipo'] = $tipo;

                PanelDocumentos::actualizarDocumento($id_documento, $datos);

                //Ingresamos el log del cambio
                $cambio = "";
                if ($fileArchivo != '') {
                    $cambio = "Se actualizó el archivo. ";
                }

                if ($DatosDocumento[0]->descripcion != $descripcion) {
                    $cambio = $cambio . "Se actualizó el nombre del documento (Antes - " . $DatosDocumento[0]->descripcion . "). ";
                }

                if ($DatosDocumento[0]->tipo != $tipo) {
                    $cambio = $cambio . "Se actualizó el grupo del documento. ";
                }

                $cambio = $cambio . "Observaciones: " . $observaciones . ".";

                $datos1 = array();
                $datos1['documento'] = $id_documento;
                $datos1['observaciones'] = $cambio;
                $datos1['usuario'] = $DatosUsuario[0]->id_usuario;
                $datos1['fecha'] = NOW();

                PanelDocumentos::insertarDocumentoLog($datos1);

                $Mensaje = "Documento modificado.";
            }

            $Redireccion = "/panel/procesos/documentos/modificar/" . $id_documento;
            return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function DocumentosEliminarDB()
    {
        if (Session::has('user')) {
            $formData = Request::all();
            $id_documento = $formData['id_documento'];
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);
            $DatosDocumento = PanelDocumentos::getDocumento($id_documento);

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "procesos/documentos";
                $DatosMenu = PanelLogin::getMenuRuta($ruta);
                if ($DatosMenu[0]->libre_acceso == 0) //Si el modulo no es de libre acceso
                {
                    $idmenu = $DatosMenu[0]->id_menu;

                    $ModUser = explode(',', $DatosUsuario[0]->modulos);
                    $NumModUser = count($ModUser);
                    $acceso = 0;
                    for ($i = 0; $i < $NumModUser; $i++) {
                        if ($idmenu == $ModUser[$i]) {
                            $acceso = 1;
                            break;
                        }
                    }

                    if ($acceso == 0) //El usuario no tiene acceso al modulo
                    {
                        $ErrorValidacion = "Usted no tiene acceso al módulo.";
                        return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
                    }
                }
            }
            //Termina validación

            //Borro el archivo
            $ruta = substr(public_path(), 0, -14) . "public/archivos/Procesos/Documentos/";
            if ($DatosDocumento[0]->ruta1 != '') {
                $borrar = $ruta . $DatosDocumento[0]->ruta1;
                if (file_exists($borrar)) {
                    unlink($borrar);
                }

            }

            if ($DatosDocumento[0]->ruta2 != '') {
                $borrar = $ruta . $DatosDocumento[0]->ruta2;
                if (file_exists($borrar)) {
                    unlink($borrar);
                }

            }

            PanelDocumentos::BorrarDocuSubProce($id_documento); //Borra la asociación entre documentos y subprocesos
            PanelDocumentos::BorrarDocumentoLog($id_documento); //Borra los logs del documento
            PanelDocumentos::BorrarDocuPerfiles($id_documento); //Borra la asociación entre documentos y perfiles
            PanelDocumentos::BorrarDocuPerfilesUsuarios($id_documento); //Borra la asociación entre documentos, perfiles y usuarios
            PanelDocumentos::BorrarDocumento($id_documento); //Borra los documentos

            $Mensaje = "Documento eliminado.";
            $Redireccion = "/panel/procesos/documentos";
            return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
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
            $cadena);

        $cadena = str_replace(
            array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
            array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
            $cadena);

        $cadena = str_replace(
            array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
            array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
            $cadena);

        $cadena = str_replace(
            array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
            array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
            $cadena);

        $cadena = str_replace(
            array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
            array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
            $cadena);

        $cadena = str_replace(
            array('ñ', 'Ñ', 'ç', 'Ç', ' ', '#', '%', '°', '´'),
            array('n', 'N', 'c', 'C', '_', '', '', '', ''),
            $cadena);
        return $cadena;
    }

}
