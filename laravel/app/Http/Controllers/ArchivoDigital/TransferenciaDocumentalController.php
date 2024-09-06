<?php

namespace App\Http\Controllers\ArchivoDigital;

use App\Http\Controllers\Controller;
use App\Models\ArchivoDigital\PanelFuid;
use App\Models\ArchivoDigital\PanelFuidRegistro;
use App\Models\ArchivoDigital\PanelRegistros;
use App\Models\PanelLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TransferenciaDocumentalController extends Controller
{
    public function showTransferenciaDocumentalU()
    {
        if (Session::has('user')) {
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "archivo/transferenciau";
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
            $DatosRegistrosFuid = PanelFuidRegistro::getFuidRegistro($DatosUsuario[0]->empleado);

            return view('archivo-digital.panel-archivoTransferenciaDocU')->with('DatosUsuario', $DatosUsuario)->with('DatosRegistrosFuid', $DatosRegistrosFuid);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }
    public function insertarTransferenciaDocumentalU(Request $request)
    {
        //dd($request->all());
        // Obtener los documentos y las categorías enviados
        $user = Session::get('user');
        $DatosUsuario = PanelLogin::getUsuario($user);

        //dd($archivos);
        $entidad_remitente = $request->input('entidad_remitente');
        $entidad_productora = $request->input('entidad_productora');
        $unidad_administrativa = $request->input('unidad_administrativa');
        $dependencia_productora = $request->input('dependencia_productora');
        $codigo_depedencia = $request->input('codigo_depedencia');
        $observacion_general = $request->input('observacion_general');
        $empleado = $request->input('empleado_hidden');
        $asunto = $request->input('asunto');
        $fecha_inicial = $request->input('fecha_inicial');
        $fecha_final = $request->input('fecha_final');
        $observaciones = $request->input('observaciones');

        $datos = ['entidad_remitente' => $entidad_remitente,
            'entidad_productora' => $entidad_productora,
            'unidad_administrativa' => $unidad_administrativa,
            'dependencia_productora' => $dependencia_productora,
            'codigo_oficina_productora' => $codigo_depedencia,
            'observacion_general' => $observacion_general,
            'elaborado_por' => $DatosUsuario[0]->empleado,
            'fecha_elaboracion' => now(),
            'entregado_por' => $DatosUsuario[0]->empleado,
            'fecha_entrega' => now(),
            'estado' => 1];

        PanelFuid::InsertFuid($datos);

        $registros_nuevos = [];

        for ($i = 0; $i < count($asunto); $i++) {
            $registros = [
                'titulo_unidad_documental' => $asunto[$i],
                'fecha_inicial' => $fecha_inicial[$i],
                'fecha_final' => $fecha_final[$i],
                'observaciones_ind' => $observaciones[$i],

            ];
            // Insertar el registro y guardar su ID
            $registro_id = PanelRegistros::InsertRegistros($registros);
            $registros_nuevos[] = $registro_id;
        }

        // Obtener el ID del último registro insertado en PanelFuid
        $fuid_id = PanelFuid::getUltimoId();

        foreach ($registros_nuevos as $registro) {

            $datos = [
                'registros' => $registro,
                'fuid' => $fuid_id->id_fuid];

            PanelFuidRegistro::InsertFuidRegistro($datos);
            $DatosRegistrosFuid = PanelFuidRegistro::getFuidRegistro($DatosUsuario[0]->empleado);
        }

    }

    public function showTransferenciaDocumentalD()
    {
        if (Session::has('user')) {
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "archivo/transferenciau";
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
            $DatosRegistrosFuid = PanelFuidRegistro::getFuidRegistros();

            return view('archivo-digital.panel-archivoTransferenciaDocD')->with('DatosUsuario', $DatosUsuario)->with('DatosRegistrosFuid', $DatosRegistrosFuid);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function transferenciaDocumentalRecibir($id)
    {
        if (Session::has('user')) {
            $Datosfuid = PanelFuidRegistro::getFuidRegistroRecibir($id);
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "archivo/transferenciad";
                $DatosMenu = PanelLogin::getMenuRuta($ruta);
                if ($DatosMenu[0]->libre_acceso == 0) // Si el modulo no es de libre acceso
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

            if ($Datosfuid == true) {
                //dd($Datosfuid);
                $disabled = false;
                return view('archivo-digital.panel-archivoTransferenciaDocDRecibir', ['disabled' => $disabled])->with('DatosUsuario', $DatosUsuario)->with('Datosfuid', $Datosfuid);
            } else {
                $Mensaje = "";
                $Redireccion = "/panel/archivo/transferenciad";
                return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
            }
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function transferenciaDocumentalRecibirConfirmar(Request $request)
    {
        $user = Session::get('user');
        $DatosUsuario = PanelLogin::getUsuario($user);

        //dd($request->all());
        $id_fuid = $request->input('id_fuid');
        $entidad_remitente = $request->input('entidad_remitente');
        $entidad_productora = $request->input('entidad_productora');
        $unidad_administrativa = $request->input('unidad_administrativa');
        $dependencia_productora = $request->input('dependencia_productora');
        $codigo_depedencia = $request->input('codigo_depedencia');
        $observacion_general = $request->input('observacion_general');
        $estado = PanelFuid::getFuid($id_fuid);
        if ($estado[0]->estado == 1 || $estado[0]->estado == 2) {
            $estadonuevo = 2;
        } elseif ($estado[0]->estado == 3) {
            $estadonuevo = 3;
        }
        $datos = ['entidad_remitente' => $entidad_remitente,
            'entidad_productora' => $entidad_productora,
            'unidad_administrativa' => $unidad_administrativa,
            'dependencia_productora' => $dependencia_productora,
            'codigo_oficina_productora' => $codigo_depedencia,
            'observacion_general' => $observacion_general,
            'recibido_por' => $DatosUsuario[0]->empleado,
            'fecha_recibido' => now(),
            'estado' => $estadonuevo];

        PanelFuid::UpdateFuid($id_fuid, $datos);

        $id_registro = $request->input('id_registro');
        $codigo_caja = $request->input('codigo_caja');
        $codigo_und_documental = $request->input('codigo_und_documental');
        $codigo_serie = $request->input('codigo_serie');
        $codigo_subserie = $request->input('codigo_subserie');
        $asunto = $request->input('asunto');
        $fecha_inicial = $request->input('fecha_inicial');
        $fecha_final = $request->input('fecha_final');
        $soporte = $request->input('soporte');
        $frecuencia_consulta = $request->input('frecuencia_consulta');
        $modulo = $request->input('modulo');
        $entrepano = $request->input('entrepano');
        $dependencia = $request->input('dependencia');
        $observaciones_ind = $request->input('observaciones_ind');

        $datosactualizar = [];
        foreach ($id_registro as $key => $id) {
            $datosactualizar[] = ['codigo_caja' => $codigo_caja[$key],
                'codigo_und_documental' => $codigo_und_documental[$key],
                'codigo_serie' => $codigo_serie[$key],
                'codigo_subserie' => $codigo_subserie[$key],
                'titulo_unidad_documental' => $asunto[$key],
                'fecha_inicial' => $fecha_inicial[$key],
                'fecha_final' => $fecha_final[$key],
                'soporte' => $soporte[$key],
                'frecuencia_consulta' => $frecuencia_consulta[$key],
                'modulo' => $modulo[$key],
                'entrepano' => $entrepano[$key],
                'dependencia' => $dependencia[$key],
                'observaciones_ind' => $observaciones_ind[$key],
            ];
        }

        foreach ($datosactualizar as $key => $datos) {
            PanelRegistros::UpdateRegistro($id_registro[$key], $datos);
        }

    }

    public function transferenciaDocumentalUDetalle($id)
    {
        if (Session::has('user')) {
            $Datosfuid = PanelFuidRegistro::getFuidRegistroRecibir($id);
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "archivo/transferenciau";
                $DatosMenu = PanelLogin::getMenuRuta($ruta);
                if ($DatosMenu[0]->libre_acceso == 0) // Si el modulo no es de libre acceso
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

            if ($Datosfuid == true) {
                //dd($Datosfuid);
                $disabled = true;
                return view('archivo-digital.panel-archivoTransferenciaDocDRecibir', ['disabled' => $disabled])->with('DatosUsuario', $DatosUsuario)->with('Datosfuid', $Datosfuid);
            } else {
                $Mensaje = "";
                $Redireccion = "/panel/archivo/transferenciad";
                return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
            }
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function transferenciaDocumentalDEscanear($id)
    {

        $Datosfuids = PanelFuidRegistro::getRegistrosEscaneoFuid($id);

        return response()->json($Datosfuids);

    }

    public function transferenciaDocumentalDEscanearConfirmar(Request $request)
    {

        $file = $request->file('file-3');
        $asunto = $request->input('asunto');
        $cod_caja = $request->input('codigo_caja');
        $dependencia = $request->input('dependencia');
        $id_registro = $request->input('id_registro');

        foreach ($id_registro as $key => $reg) {
            $ruta = substr(public_path(), 0, -14) . 'public/archivos/ArchivoDigital/ArchivoCentral/' . $dependencia[$key] . '/' . $cod_caja[$key] . "/" . $asunto[$key] . "/";
            $extension = $file[$key]->getClientOriginalExtension();
            $nombreArchivo = $asunto[$key] . '.' . $extension;
            $file[$key]->move($ruta, $nombreArchivo);
            $datos = ['ruta' => $nombreArchivo];
            PanelRegistros::UpdateRegistro($reg, $datos);
        }

        $id_fuid = $request->input('id_fuid_h');
        $datos2 = ["estado" => 3];
        PanelFuid::UpdateFuid($id_fuid, $datos2);

    }
}
