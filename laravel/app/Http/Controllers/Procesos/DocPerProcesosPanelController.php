<?php
/*
Controlador de la tabla proc_docu_perf
Usa SQl Eloquent del archivo app\Models\Procesos\PanelDocumentos.php
 */

namespace App\Http\Controllers\Procesos;

use App\Http\Controllers\Controller;
use App\Models\PanelLogin;
use App\Models\Procesos\PanelDocumentos;
use App\Models\Procesos\PanelPerfiles;
use DB;
use Illuminate\Http\Request;
//use Request;
use Illuminate\Support\Facades\Session;

class DocPerProcesosPanelController extends Controller
{
    public function DocumePerfilAgregar($id)
    {
        if (Session::has('user')) {
            $Documento = $id;
            $DatosDocumento = PanelDocumentos::getDocumento($Documento);
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "procesos/perfiles";
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

            return view('procesos.panel-documePerfilAgregar')->with('DatosUsuario', $DatosUsuario)->with('DatosDocumento', $DatosDocumento);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function DocumePerfilAgregarDB()
    {
        if (Session::has('user')) {
            $formData = \Request::all();
            $login = $formData['login'];
            $documento = $formData['id_documento'];
            $perfil = $formData['perfil'];
            $DatosUsuario = PanelLogin::getUsuario($login);

            $datos = array();

            //Realizo las validaciones
            $Mensaje = "";

            $DocPerDuplicado = PanelPerfiles::getDocPerUnico($documento, $perfil);

            if ($DocPerDuplicado != 0) {
                $Mensaje = "Ya se encuentra un perfil asociado al documento.";
            } else if ($perfil == "") {
                $Mensaje = "Debe seleccionar el perfil.";
            }

            if ($Mensaje == "") {
                $datos['documento'] = $documento;
                $datos['perfil'] = $perfil;

                PanelPerfiles::insertarDocPer($datos);
                $Mensaje = "Perfil asociado.";
            }

            $Redireccion = "/panel/procesos/documeperfil/agregar/" . $documento;
            return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function DocumePerfilEliminarDB()
    {
        if (Session::has('user')) {
            $formData = \Request::all();
            $user = $formData['login'];
            $documento = $formData['id_documento'];
            $perfil = $formData['id_perfil'];
            $usuario = $formData['id_usuario'];
            $DatosUsuario = PanelLogin::getUsuario($user);

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "procesos/perfiles";
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

            PanelPerfiles::BorrarDocPerUsr($documento, $perfil,$usuario);

            $Mensaje = "Perfil desasociado.";
            $Redireccion = "/panel/procesos/documentos/modificar/" . $documento;
            return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function DocumenPerfilUsuarioAgregarDB(Request $request)
    {

        //$documentos = $request->input('documentos');
        $documentosArray = explode(',', $request->input('documentos')[0]);
        $perfiles = $request->input('perfil');
        $usuarios = $request->input('usuario');
        // Verificar si $perfiles es null o no
        if (!is_null($perfiles)) {
            foreach ($documentosArray as $documento) {
                foreach ($perfiles as $perfil) {
                    DB::table('proc_docu_asignacion')->insert([
                        'documento' => $documento,
                        'tipo_asignacion' => 'perfil',
                        'perfil' => $perfil,
                    ]);
                }
            }
        }

        // Verificar si $usuarios es null o no
        if (!is_null($usuarios)) {
            foreach ($documentosArray as $documento) {
                foreach ($usuarios as $usuario) {
                    DB::table('proc_docu_asignacion')->insert([
                        'documento' => $documento,
                        'tipo_asignacion' => 'usuario',
                        'usuario' => $usuario,
                    ]);
                }
            }
        }

        return redirect('/panel/procesos/documentos');
    }
}
