<?php

namespace App\Http\Controllers\Procesos;

use App\Http\Controllers\Controller;
use App\Models\PanelLogin;
use App\Models\Parametrizacion\PanelUsuarios;
use App\Models\Procesos\PanelDocumentos;
use App\Models\Procesos\PanelMacroProcesos;
use App\Models\Procesos\PanelPerfiles;
use App\Models\Procesos\PanelProcesos;
use App\Models\Procesos\PanelSubProcesos;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Procesos\PanelTiposDocumentos;

class CompartirArchProcesosPanelController extends Controller
{
    public function showAllProcesos()
    {
        if (Session::has('user')) {
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "procesos/compartir";
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
            $DatosMacroProcesos = PanelMacroProcesos::getMacroProcesos();
            $DatosProcesos = PanelProcesos::getProcesosWithMacroProc();
            $DatosSubProcesos = PanelSubProcesos::getSubProcesosWithProcAndMacroProc();
            $Perfiles = PanelPerfiles::getPerfiles();
            $Usuarios = PanelUsuarios::getUsuariosActivos();
            $TiposDocumentos = PanelTiposDocumentos::getTiposDocumentos();

            return view('procesos.panel-compartirArchivos')->with('DatosUsuario', $DatosUsuario)->with('DatosDocumentos', $DatosDocumentos)
                ->with('DatosMacroProcesos', $DatosMacroProcesos)->with('Perfiles', $Perfiles)->with('Usuarios', $Usuarios)->with('DatosSubProcesos', $DatosSubProcesos)
                ->with('DatosProcesos', $DatosProcesos)->with('TiposDocumentos', $TiposDocumentos);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function asociarDocMacroProceso(Request $request)
    {

        $documentosMacroProc = explode(',', $request->input('documentosMacroProc')[0]);
        $perfilMacroProc = $request->input('perfilMacroProc');
        $usuarioMacroProc = $request->input('usuarioMacroProc');
        $documentos_array = [];

        foreach ($documentosMacroProc as $key => $value) {

            $procesos = PanelProcesos::getProcesosMacro($value);
            foreach ($procesos as $key => $value) {

                $subprocesos = PanelSubProcesos::getSubProcesos($value->id_proceso);

                foreach ($subprocesos as $key => $value) {
                    $doc_subproc = PanelDocumentos::getDocumentosSubProceso($value->id_subproceso);

                    foreach ($doc_subproc as $key => $value) {
                        $documentos_array[] = $value->id_documento;
                    }

                }
            }

        }

        if (isset($perfilMacroProc)) {
            foreach ($perfilMacroProc as $key => $perfil) {
                foreach ($documentos_array as $key => $documento) {
                    $asignaciones = DB::table('proc_docu_asignacion')->select('documento', 'perfil')->where('documento', $documento)->where('perfil', $perfil)->get();

                    if (count($asignaciones) === 0) {
                        DB::table('proc_docu_asignacion')->insert([
                            'documento' => $documento,
                            'tipo_asignacion' => 'perfil',
                            'perfil' => $perfil,
                        ]);
                    }
                }
            }
        }

        if (isset($usuarioMacroProc)) {
            foreach ($usuarioMacroProc as $key => $usuario) {
                foreach ($documentos_array as $key => $documento) {

                    $asignaciones = DB::table('proc_docu_asignacion')->select('documento', 'usuario')->where('documento', $documento)->where('usuario', $usuario)->get();

                    if (count($asignaciones) === 0) {

                        DB::table('proc_docu_asignacion')->insert([
                            'documento' => $documento,
                            'tipo_asignacion' => 'usuario',
                            'usuario' => $usuario,
                        ]);

                    }

                }
            }

        }

        toastr()->success('¡Documentación compartida exitosamente!', '¡Proceso exitoso!', ['positionClass' => 'toast-bottom-right']);
        return redirect()->back();

    }

    public function asociarDocProceso(Request $request)
    {

        $documentosProc = explode(',', $request->input('documentosProc')[0]);
        $perfilProc = $request->input('perfilProc');
        $usuarioProc = $request->input('usuarioProc');
        $documentos_array = [];

        foreach ($documentosProc as $key => $value) {

            $subprocesos = PanelSubProcesos::getSubProcesos($value);

            foreach ($subprocesos as $key => $value) {
                $doc_subproc = PanelDocumentos::getDocumentosSubProceso($value->id_subproceso);

                foreach ($doc_subproc as $key => $value) {
                    $documentos_array[] = $value->id_documento;
                }

            }
        }

        if (isset($perfilProc)) {
            foreach ($perfilProc as $key => $perfil) {
                foreach ($documentos_array as $key => $documento) {
                    $asignaciones = DB::table('proc_docu_asignacion')->select('documento', 'perfil')->where('documento', $documento)->where('perfil', $perfil)->get();
                    if (count($asignaciones) === 0) {
                        DB::table('proc_docu_asignacion')->insert([
                            'documento' => $documento,
                            'tipo_asignacion' => 'perfil',
                            'perfil' => $perfil,
                        ]);
                    }
                }
            }
        }

        if (isset($usuarioProc)) {
            foreach ($usuarioProc as $key => $usuario) {
                foreach ($documentos_array as $key => $documento) {

                    $asignaciones = DB::table('proc_docu_asignacion')->select('documento', 'usuario')->where('documento', $documento)->where('usuario', $usuario)->get();

                    if (count($asignaciones) === 0) {

                        DB::table('proc_docu_asignacion')->insert([
                            'documento' => $documento,
                            'tipo_asignacion' => 'usuario',
                            'usuario' => $usuario,
                        ]);

                    }

                }
            }

        }

        toastr()->success('¡Documentación compartida exitosamente!', '¡Proceso exitoso!', ['positionClass' => 'toast-bottom-right']);
        return redirect()->back();

    }

    public function asociarDocSubProceso(Request $request)
    {

        $documentosSubProc = explode(',', $request->input('documentosSubProc')[0]);
        $perfilSubProc = $request->input('perfilSubProc');
        $usuarioSubProc = $request->input('usuarioSubProc');
        $tipoSubProc = $request->input('tipoSubProc');
        $documentos_array = [];

        if (isset($tipoSubProc)) {
            foreach ($documentosSubProc as $key => $value) {
                $doc_subproc = PanelDocumentos::getDocumentosSubProcesoVariosTipo($value, $tipoSubProc);
                foreach ($doc_subproc as $key => $value) {
                    $documentos_array[] = $value->id_documento;
                }
            }
        } else {
            foreach ($documentosSubProc as $key => $value) {
                $doc_subproc = PanelDocumentos::getDocumentosSubProceso($value);
                foreach ($doc_subproc as $key => $value) {
                    $documentos_array[] = $value->id_documento;
                }
            }
        }

        if (isset($perfilSubProc)) {
            foreach ($perfilSubProc as $key => $perfil) {
                foreach ($documentos_array as $key => $documento) {
                    $asignaciones = DB::table('proc_docu_asignacion')->select('documento', 'perfil')->where('documento', $documento)->where('perfil', $perfil)->get();

                    if (count($asignaciones) === 0) {
                        DB::table('proc_docu_asignacion')->insert([
                            'documento' => $documento,
                            'tipo_asignacion' => 'perfil',
                            'perfil' => $perfil,
                        ]);
                    }
                }
            }
        }

        if (isset($usuarioSubProc)) {
            foreach ($usuarioSubProc as $key => $usuario) {
                foreach ($documentos_array as $key => $documento) {

                    $asignaciones = DB::table('proc_docu_asignacion')->select('documento', 'usuario')->where('documento', $documento)->where('usuario', $usuario)->get();

                    if (count($asignaciones) === 0) {

                        DB::table('proc_docu_asignacion')->insert([
                            'documento' => $documento,
                            'tipo_asignacion' => 'usuario',
                            'usuario' => $usuario,
                        ]);
                    }

                }
            }

        }

        toastr()->success('¡Documentación compartida exitosamente!', '¡Proceso exitoso!', ['positionClass' => 'toast-bottom-right']);
        return redirect()->back();

    }

}
