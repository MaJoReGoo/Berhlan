<?php

namespace App\Http\Controllers\ArchivoDigital;

use App\Http\Controllers\Controller;
use App\Models\ArchivoDigital\PanelFuidRegistro;
use App\Models\ArchivoDigital\PanelInsercion;
use App\Models\PanelLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class InsercionDocumentalController extends Controller
{
    public function showInsercionDocumentalU()
    {
        if (Session::has('user')) {
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "archivo/insercionu";
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
            $DatosInserciones = PanelInsercion::getSolicitudInsercion($DatosUsuario[0]->empleado);
            //dd($DatosInserciones);

            return view('archivo-digital.panel-archivoInsercionU')->with('DatosUsuario', $DatosUsuario)->with('DatosInserciones', $DatosInserciones);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function showInsercionDocumentalD()
    {
        if (Session::has('user')) {
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "archivo/inserciond";
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
            $DatosInserciones = PanelInsercion::getSolicitudInserciones();

            return view('archivo-digital.panel-archivoInsercionD')->with('DatosUsuario', $DatosUsuario)->with('DatosInserciones', $DatosInserciones);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function insertarInsercionDocumentalU(Request $request)
    {
        //dd($request->all());
        // Obtener los documentos y las categorías enviados
        $user = Session::get('user');
        $DatosUsuario = PanelLogin::getUsuario($user);

        //dd($archivos);

        $descripcion = $request->input('descripcion');
        $folios = $request->input('folios');
        $observaciones = $request->input('observaciones');
        $observacion_general = $request->input('observacion_general');

        $datos = [
            'observacion_general' => $observacion_general,
            'estado' => 1,
        ];

        PanelInsercion::InsertSolicitud($datos);

        $registros_nuevos = [];

        for ($i = 0; $i < count($descripcion); $i++) {
            $registros = [
                'descripcion' => $descripcion[$i],
                'nro_folios' => $folios[$i],
                'nombre_entrega' => $DatosUsuario[0]->empleado,
                'fecha_entrega' => now(),
                'observaciones' => $observaciones[$i],

            ];
            // Insertar el registro y guardar su ID
            $registro_id = PanelInsercion::InsertInsercion($registros);
            $registros_nuevos[] = $registro_id;
        }

        // Obtener el ID del último registro insertado en PanelFuid
        $solicitud_id = PanelInsercion::getSolicitudUltimo();

        foreach ($registros_nuevos as $registro) {

            $datos = [
                'insercion' => $registro,
                'solicitud' => $solicitud_id->id_solicitud,
            ];

            PanelInsercion::InsertInsercionSolicitud($datos);
            //$DatosRegistrosFuid = PanelFuidRegistro::getFuidRegistro($DatosUsuario[0]->empleado);
        }

    }

    public function insercionDocumentalRecibir($id)
    {
        if (Session::has('user')) {
            $DatosSolIns = PanelInsercion::getInsercionSolicitudRecibir($id);
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "parametrizacion/empleados";
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
            //dd($DatosSolIns);

            if ($DatosSolIns == true) {
                $disabled = false;
                return view('archivo-digital.panel-archivoInsercionDRecibir', ['disabled' => $disabled])->with('DatosUsuario', $DatosUsuario)->with('DatosSolIns', $DatosSolIns);
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
        $id_solicitud = $request->input('id_solicitud');
        $observacion_general = $request->input('observacion_general');
        $estado = PanelInsercion::getSolicitud($id_solicitud);
        if ($estado[0]->estado == 1 || $estado[0]->estado == 2) {
            $estadonuevo = 2;
        } elseif ($estado[0]->estado == 3) {
            $estadonuevo = 3;
        }
        $datos = [
            'observacion_general' => $observacion_general,
            'estado' => $estadonuevo];

        PanelInsercion::UpdateSolicitud($id_solicitud, $datos);

        $id_insercion = $request->input('id_insercion');
        $descripcion = $request->input('descripcion');
        $folios = $request->input('folios');
        $observaciones = $request->input('observaciones');

        $datosactualizar = [];
        foreach ($id_insercion as $key => $id) {
            $datosactualizar[] = ['descripcion' => $descripcion[$key],
                'nro_folios' => $folios[$key],
                'observaciones' => $observaciones[$key],
                'recibido_por' => $DatosUsuario[0]->empleado,
                'fecha_recibe' => now(),
            ];
        }

        foreach ($datosactualizar as $key => $datos) {
            PanelInsercion::UpdateInsercion($id_insercion[$key], $datos);
        }

    }

    public function insercionDocumentalURecibir($id)
    {
        if (Session::has('user')) {
            $DatosSolIns = PanelInsercion::getInsercionSolicitudRecibir($id);
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "parametrizacion/empleados";
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
            //dd($DatosSolIns);

            if ($DatosSolIns == true) {
                $disabled = true;
                return view('archivo-digital.panel-archivoInsercionDRecibir', ['disabled' => $disabled])->with('DatosUsuario', $DatosUsuario)->with('DatosSolIns', $DatosSolIns);
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

    public function insercionDocumentalDEscanear($id)
    {

        if (Session::has('user')) {
            $DatosSolIns = PanelInsercion::getInsercionSolicitudRecibir($id);
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);
            $Datosfuids = PanelFuidRegistro::getRegistrosEscaneoFuidNotNull();

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "parametrizacion/empleados";
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

            if ($DatosSolIns == true) {
                $disabled = false;
                return view('archivo-digital.panel-archivoInsercionDEscanear', ['disabled' => $disabled])->with('DatosUsuario', $DatosUsuario)
                    ->with('Datosfuids', $Datosfuids)->with('DatosSolIns', $DatosSolIns);
            } else {
                $Mensaje = "";
                $Redireccion = "/panel/archivo/inserciond";
                return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
            }
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }

    }

    public function InsercionDocumentalDEscanearConfirmar(Request $request)
    {
        //dd($request->all());
        $file = $request->file('file-3');
        $asunto = $request->input('asunto');
        $cod_caja = $request->input('codigo_caja');
        $dependencia = $request->input('dependencia');
        $descripcion = $request->input('descripcion');
        $id_insercion = $request->input('id_insercion');


        foreach ($id_insercion as $key => $reg) {
            $ruta = substr(public_path(), 0, -14) . 'public/archivos/ArchivoDigital/ArchivoCentral/' . $dependencia[$key] . '/' . $cod_caja[$key] . "/" . $asunto[$key] . "/";
            $extension = $file[$key]->getClientOriginalExtension();
            $nombreArchivo = $descripcion[$key].'- Insercion' . '.' . $extension;
            $rutaArchivo = $dependencia[$key] . '/' . $cod_caja[$key] . "/" . $asunto[$key] . "/". $nombreArchivo;
            $file[$key]->move($ruta, $nombreArchivo);
            $datos = ['ruta' => $rutaArchivo];
            PanelInsercion::UpdateInsercion($reg, $datos);
        }

        $id_solicitud = $request->input('id_solicitud');
        $datos2 = ['estado' => 3];
        PanelInsercion::UpdateSolicitud($id_solicitud, $datos2);

    }
}
