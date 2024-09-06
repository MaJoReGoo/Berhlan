<?php

namespace App\Http\Controllers\ActivosFijos;

use App\Http\Controllers\Controller;
use App\Models\ActivosFijos\PanelActivosFijos;
use App\Models\PanelLogin;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelEmpresas;
use App\Models\TicActivos\PanelTipos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Exports\ActivosFijosExport;
use Maatwebsite\Excel\Facades\Excel;

class ActivosFijosController extends Controller
{
    public function showIngresarActivosFijos()
    {
        if (Session::has('user')) {
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "activos/ingresar";
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

            $DatosEmpleados = PanelEmpleados::EmpleadosT();

            return view('activos-fijos.panel-ingresaract')->with('DatosUsuario', $DatosUsuario)->with('DatosEmpleados', $DatosEmpleados);

        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }
    public function showConsultaActivosFijos()
    {
        if (Session::has('user')) {
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "activos/consulta";
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

            return view('activos-fijos.panel-consultaParam')->with('DatosUsuario', $DatosUsuario);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function insertarActivosFijos(Request $request)
    {
        //dd($request->all());
        // Obtener los documentos y las categorías enviados
        $user = Session::get('user');
        $DatosUsuario = PanelLogin::getUsuario($user);
        //$fileListJson = $request->input('file-list-hidden');
        $tipo = $request->input('tipo');
        //dd($archivos);
        $empleado = $request->input('empleado');
        $empresa = $request->input('empresa');
        $color = $request->input('color');
        $activo_fijo = $request->input('activo_fijo');
        $codigo_interno = $request->input('codigo_interno');
        $mantenimiento = $request->input('mantenimiento');
        $meses = $request->input('meses');
        $fechainicial = $request->input('fechainicial');
        $observaciones = $request->input('observaciones');

        $ano = date('Y');
        $mes = date('m') * 1;

        //$fileList = json_decode($fileListJson);
        $datos = [
            'tipo' => $tipo,
            'empleado' => $empleado,
            'empresa' => $empresa,
            'mes_mtto' => $meses,
            'mantenimiento' => $mantenimiento,
            'fecha_mtto' => $fechainicial,
            'cod_interno' => $codigo_interno,
            'activo_fijo' => $activo_fijo,
            'color' => $color,
            'observaciones' => $observaciones,
            'estado' => 1,
        ];

        PanelActivosFijos::InsertActivosFijos($datos);

        $idActivo = PanelActivosFijos::getUltimoActivo();

        $uploader = $request->input('uploader');
        if ($uploader != '') {
            $foto_actual = $request->file('foto_actual');
            $ruta = substr(public_path(), 0, -14) . 'public/archivos/ActivosFijos/Fotos/' . $ano . "/" . $mes . "/";
            $extension = $foto_actual->getClientOriginalExtension();
            $nombreArchivo = $ano . "/" . $mes . "/Foto_Activo_" . $idActivo->id_activo . '.' . $extension;
            $foto_actual->move($ruta, $nombreArchivo);
            $datos = ['foto' => $nombreArchivo];
            PanelActivosFijos::updateActivosFijos($idActivo->id_activo, $datos);
        }

        $datos2 = array();
        $datos2['activo'] = $idActivo->id_activo;
        $datos2['fecha'] = NOW();
        $datos2['cambio'] = 'Ingresa activo';
        $datos2['usuario'] = $DatosUsuario[0]->empleado;

        PanelActivosFijos::insertarCambio($datos2);
    }

    public function ConsultaActivosFijos(Request $request)
    {
        $user = Session::get('user');
        $DatosUsuario = PanelLogin::getUsuario($user);
        // dd($request->all());
        $tipoacti = $request->input('tipoacti');
        $empleado = $request->input('empleado');
        $empresa = $request->input('empresa');
        $color = $request->input('color');
        $codigo_interno = $request->input('codigo_interno');
        $activo_fijo = $request->input('activo_fijo');

        $sql = \DB::table('acti2_activo')
            ->where(function ($query) use ($tipoacti, $empleado, $empresa, $color, $codigo_interno, $activo_fijo) {
                if (!is_null($tipoacti)) {
                    $query->where('tipo', $tipoacti);
                }
                if (!is_null($empleado)) {
                    $query->where('empleado', $empleado);
                }
                if (!is_null($empresa)) {
                    $query->where('empresa', $empresa);
                }
                if (!is_null($color)) {
                    $query->where('color', 'like', '%' . $color . '%');
                }
                if (!is_null($codigo_interno)) {
                    $query->where('cod_interno', 'like', '%' . $codigo_interno . '%');
                }
                if (!is_null($activo_fijo)) {
                    $query->where('activo_fijo', 'like', '%' . $activo_fijo . '%');
                }
            })
            ->get();

        return view('activos-fijos.panel-consultaParamListado')->with('DatosUsuario', $DatosUsuario)->with('sql', $sql);
    }

    public function ParamDetalle($id)
    {
        if (Session::has('user')) {
            $Activo = $id;
            $DatosActivo = PanelActivosFijos::getActivo($Activo);
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "activos/consulta";
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
            if ($DatosActivo->count() == 0) {
                $Mensaje = "Solicitud no existe.";
                $Redireccion = "/panel/ticactivos/consultasparam";
                return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
            }

            return view('activos-fijos.panel-consultaParamDetalle')->with('DatosUsuario', $DatosUsuario)->with('DatosActivo', $DatosActivo);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function IngresarActividadDB(Request $request)
    {
        //dd($request->all());

        $user = Session::get('user');
        $DatosUsuario = PanelLogin::getUsuario($user);

        $activo = $request->input('activo');
        $observaciones = $request->input('observaciones');

        $datos = [
            'activo' => $activo,
            'observaciones' => $observaciones,
            'usuario' => $DatosUsuario[0]->empleado,
            'fecha' => NOW(),
        ];

        PanelActivosFijos::insertarActividad($datos);

    }

    public function Acta($id)
    {
        if (Session::has('user')) {
            $Activo = $id;
            $DatosActivo = PanelActivosFijos::getActivo($Activo);

            $e = 0;
            foreach ($DatosActivo as $DatAct) {
                $e++;
            }

            if ($e == 0) {
                $Mensaje = "Activo no existe.";
                $Redireccion = "/panel/menu/104";
                return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
            }

            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            return view('activos-fijos.panel-acta')->with('DatosUsuario', $DatosUsuario)->with('DatosActivo', $DatosActivo);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function Modificar($id)
    {
        if (Session::has('user')) {
            $Activo = $id;
            $DatosActivo = PanelActivosFijos::getActivo($Activo);
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            $e = 0;
            foreach ($DatosActivo as $DatAct) {
                $e++;
            }

            if ($e == 0) {
                $Mensaje = "Activo no existe.";
                $Redireccion = "/panel/menu/104";
                return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
            }

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "activos/consulta";
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

            return view('activos-fijos.panel-modificaract')->with('DatosUsuario', $DatosUsuario)->with('DatosActivo', $DatosActivo);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function ModificarDB(Request $request)
    {
        if (Session::has('user')) {

            $tipo = $request->input('tipo');
            $activo = $request->input('activo');
            //dd($archivos);
            $empleado = $request->input('empleado');
            $empresa = $request->input('empresa');
            $color = $request->input('color');
            $activo_fijo = $request->input('activo_fijo');
            $codigo_interno = $request->input('codigo_interno');
            $mantenimiento = $request->input('mantenimiento');
            $meses = $request->input('meses');
            $fechainicial = $request->input('fechainicial');
            $observaciones = $request->input('observaciones');
            $estado = $request->input('estado');

            $ano = date('Y');
            $mes = date('m') * 1;

            $DatosActivo = PanelActivosFijos::getActivo($activo);
            $datos = [
                'tipo' => $tipo,
                'empleado' => $empleado,
                'empresa' => $empresa,
                'mes_mtto' => $meses,
                'mantenimiento' => $mantenimiento,
                'fecha_mtto' => $fechainicial,
                'cod_interno' => $codigo_interno,
                'activo_fijo' => $activo_fijo,
                'color' => $color,
                'observaciones' => $observaciones,
                'estado' => $estado,
            ];

            //Foto
            $fileImg2 = $request->input('uploader2');
            if ($fileImg2 != '') {
                //Si ya existe una foto, borro el archivo
                if ($DatosActivo[0]->foto != '') {
                    $ruta1 = substr(public_path(), 0, -14) . "public/archivos/ActivosFijos/Fotos/";
                    $borrar = $ruta1 . $DatosActivo[0]->foto;
                    if (file_exists($borrar)) {
                        unlink($borrar);
                    }

                }

                $ruta = substr(public_path(), 0, -14) . "public/archivos/ActivosFijos/Fotos/" . $ano . "/" . $mes . "/";
                $file2 = $request->file('file2');
                $extension = $file2->getClientOriginalExtension();
                $nombre2 = $ano . "/" . $mes . "/Foto_Activo_" . $activo . '.' . $extension;
                $uploadSuccess = $file2->move($ruta, $nombre2);

                $datos['foto'] = $nombre2;
            }

            //Acta firmada
            $fileImg3 = $request->input('uploader3');
            if ($fileImg3 != '') {
                //Si ya existe un acta, borro el archivo
                if ($DatosActivo[0]->acta_firmada != '') {
                    $ruta1 = substr(public_path(), 0, -14) . "public/archivos/ActivosFijos/Actas_firmadas/";
                    $borrar = $ruta1 . $DatosActivo[0]->acta_firmada;
                    if (file_exists($borrar)) {
                        unlink($borrar);
                    }

                }

                $ruta = substr(public_path(), 0, -14) . "public/archivos/ActivosFijos/Actas_firmadas/" . $ano . "/" . $mes . "/";
                $file3 = $request->file('file3');
                $extension = $file3->getClientOriginalExtension();
                $nombre3 = $ano . "/" . $mes . "/Acta_" . $activo . '.' . $extension;
                $uploadSuccess = $file3->move($ruta, $nombre3);
                $datos['acta_firmada'] = $nombre3;

            }

            //Si aplica mantenimiento
            if ($mantenimiento == "S") {
                $mes_mtto = $request->input('meses');
                $datos['mes_mtto'] = $mes_mtto;
                if ($DatosActivo[0]->fecha_mtto == null) {
                    $fecha_mtto = $request->input('fechainicial');
                    $datos['fecha_mtto'] = $fecha_mtto;
                } else {
                    $fecha_mtto = '';
                }
            } else {
                $mes_mtto = 0;
                $fecha_mtto = '';
                $datos['mes_mtto'] = 0;
                $datos['fecha_mtto'] = null;
            }

            //dd($datos);
            PanelActivosFijos::updateActivosFijos($activo, $datos);

            $Mensaje = "Activo modificado.";

            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            // Control de cambios
            $cambios = "";

            if ($DatosActivo[0]->estado != $estado) {
                if ($estado == 0) {
                    $cambios = " || Estado: Activo";
                } else {
                    $cambios = " || Estado: Inactivo";
                }

            }

            if ($DatosActivo[0]->empleado != $empleado) {
                $Emp = PanelEmpleados::getEmpleado($DatosActivo[0]->empleado);
                $cambios = $cambios . " || Colaborador: " . $Emp[0]->primer_nombre . ' ' . $Emp[0]->primer_apellido;
            }

            if ($DatosActivo[0]->empresa != $empresa) {
                $Empr = PanelEmpresas::getEmpresa($DatosActivo[0]->empresa);
                $cambios = $cambios . " || Compañía: " . $Empr[0]->nombre;
            }
            if ($DatosActivo[0]->tipo != $tipo) {
                $tip = PanelTipos::getTipo($DatosActivo[0]->tipo);
                $cambios = $cambios . " || Tipo Activo fijo anterior: " . $tip[0]->descripcion;
            }
            if ($DatosActivo[0]->color != $color) {
                $cambios = $cambios . " || Color: " . $DatosActivo[0]->color;
            }

            if ($DatosActivo[0]->cod_interno != $codigo_interno) {
                $cambios = $cambios . " || Código interno: " . $DatosActivo[0]->cod_interno;
            }

            if ($DatosActivo[0]->activo_fijo != $activo_fijo) {
                $cambios = $cambios . " || Activo fijo: " . $DatosActivo[0]->activo_fijo;
            }

            if ($fileImg2 != '') {
                $cambios = $cambios . " || Se actualizo la imagen";
            }

            if ($fileImg3 != '') {
                $cambios = $cambios . " || Se actualizo el acta firmada";
            }

            if ($DatosActivo[0]->mantenimiento != $mantenimiento) {
                $cambios = $cambios . " || Mantenimiento: " . $DatosActivo[0]->mantenimiento;
            }

            if ($DatosActivo[0]->mes_mtto != $mes_mtto) {
                $cambios = $cambios . " || Meses entre mantenimientos: " . $DatosActivo[0]->mes_mtto;
            }

            if (($fecha_mtto != '') && ($DatosActivo[0]->fecha_mtto == null)) {
                $cambios = $cambios . " || Fecha inicial mantenimiento";
            }

            if ($DatosActivo[0]->observaciones != $observaciones) {
                $cambios = $cambios . " || Observaciones: " . $DatosActivo[0]->observaciones;
            }

            if ($cambios != "") {
                $datos3 = array();
                $datos3['activo'] = $activo;
                $datos3['fecha'] = NOW();
                $datos3['cambio'] = trim($cambios);
                $datos3['usuario'] = $DatosUsuario[0]->empleado;
                PanelActivosFijos::insertarCambio($datos3);
            }

            $Redireccion = "/panel/activos/consulta/parametrizada/detalle/" . $activo;

            return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function actualizarTablaTipoActivosFijos()
    {
        // Obtener los datos actualizados de la tabla TipoDocumentos
        $datosTipoDoc = PanelTipos::getTipos();
        // Devolver los datos formateados en formato JSON
        return response()->json($datosTipoDoc);
    }

    public function actualizarEstadoTipoDocumentos(Request $request)
    {
        $id = $request->input('id');
        $estado = $request->input('estado');

        // Actualizar el estado del artículo en la base de datos
        $idtipoDoc = PanelTipos::getTipo($id);
        //dd($idtipoDoc);
        $datos = ['estado' => $estado];
        PanelTipos::actualizarTipo($idtipoDoc[0]->id_tipoactivo, $datos);

        return response()->json(['success' => true]);
    }

    public function TiposAgregarDB(Request $request)
    {

        $descripcion = $request->input('descripcion');
        $datos = [
            'descripcion' => $descripcion,
            'estado' => 1,
        ];

        PanelTipos::insertarTipo($datos);

    }
    public function ExportExcelActivos()
    {

        return Excel::download(new ActivosFijosExport, 'ActivosFijos.xlsx');


    }
}
