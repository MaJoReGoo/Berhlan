<?php

namespace App\Http\Controllers\Inconformidades;

use App\Exports\ReporteExport;
use App\Http\Controllers\Controller;
use App\Models\PanelLogin;
use App\Models\Parametrizacion\PanelAreas;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Reporte_no_conformidad\Equipo_trabajo_reporte_no_conformidades;
use App\Models\Reporte_no_conformidad\Plan_accion_reporte_no_conformidades;
use App\Models\Reporte_no_conformidad\Reporte_no_conformidades;
use App\Models\Reporte_no_conformidad\Seguimiento_reporte_no_conformidades;
use App\Models\Reporte_no_conformidad\Verificacion_imp_reporte_no_conformidades;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use ZipArchive;

class InconformidadesReporteController extends Controller
{
    public function showIngresarReporte()
    {

        if (Session::has('user')) {
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "noconformidades/reporte";
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
            $areas = PanelAreas::getAreasPorEmpresa('1');
            $Empleados = PanelEmpleados::EmpleadosWithCargoActivos();

            $maxConsecutivo = Reporte_no_conformidades::selectRaw('MAX(consecutivo) AS consecutivo')->first()->consecutivo;
            $consecutivo = ($maxConsecutivo) ? $maxConsecutivo + 1 : 1;
            $consecutivo = sprintf('%03d', $consecutivo);
            return view('inconformidades.panelCrearReporteInconformidad')->with(['DatosUsuario' => $DatosUsuario, 'Empleados' => $Empleados, 'areas' => $areas, 'consecutivo' => $consecutivo]);

        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }

    }

    public function insertarReporteNoConf(Request $request)
    {
        //Obtener la información enviada
        $user = Session::get('user');
        $DatosUsuario = PanelLogin::getUsuario($user);
        $sistema_de_gestion = $request->input('sistema_gestion');
        $ciclo_auditoria = $request->input('ciclo_auditoria');
        $fecha_auditoria = $request->input('fecha_auditoria');
        $lugar = $request->input('lugar_reporte');
        $fecha_elaboracion = $request->input('fecha_elaboracion');

        $fuente_no_conforme = $request->input('fuente_razon');
        if ($fuente_no_conforme === 'otro') {
            $fuente_no_conforme = $request->input('fuente_otro');
        };
        $proceso_no_conforme = $request->input('proceso_no_conforme');
        $nombre_reporte_proceso = $request->input('nombre_proceso_reporta');
        $tipo_proceso_no_conforme = $request->input('tipo_no_conformidad');
        $descripcion_no_conformidad = $request->input('descrip_no_corformidad');

        $responsable_no_conformidad = $request->input('responsable_no_conformidad');

        $impacto_no_conformidad = $request->input('impacto_no_conformidad');
        // $requerimiento_no_conformidad = $request->input('requiere_no_conformidad');
        $analisis_mano_de_obra = $request->input('mano_de_obra');
        $analisis_maquinaria = $request->input('maquinaria');
        $analisis_metodo = $request->input('metodo');
        $analisis_materiales = $request->input('materiales');
        $analisis_medio_ambiente = $request->input('medio_ambiente');
        $analisis_otros_factores = $request->input('otros_factores');

        $persona_equipo_trabajo = $request->input('persona_equipo');

        $plan_accion_numero = $request->input('plan_accion_n#');
        $plan_accion_actividad = $request->input('plan_accion_actividad');
        $plan_accion_responsable = $request->input('plan_accion_responsable');
        $plan_accion_fecha_tarea = $request->input('plan_accion_fecha_tarea');

        $seguimiento_plan_fecha = $request->input('seguimiento_plan_fecha');
        $seguimiento_numero = $request->input('seguimiento_plan_n#');
        $seguimiento_actividad_tarea = $request->input('seguimiento_plan_descrip');
        $seguimiento_compromisos = $request->input('seguimiento_plan_compromisos');
        $seguimiento_responsable = $request->input('seguimiento_plan_responsable');
        $segui_plan_archivos = $request->file('segui_plan_archivos');

        //Otra tabla
        $verifica_implementacion_fecha = $request->input('verifica_implementacion_fecha');
        $verifica_implementacion_observa = $request->input('verifica_implementacion_observa');
        $verifica_implementacion_responsable = $request->input('verifica_implementacion_responsable');
        $verifica_imple_archivos = $request->file('verifica_imple_archivos');

        $prog_cierre_fecha = $request->input('prog_cierre_fecha');
        $prog_cierre_responsable = $request->input('prog_cierre_responsable');
        $cierre_real_fecha = $request->input('cierre_real_fecha');
        $cierre_real_responsable = $request->input('cierre_real_responsable');

        $consecutivo = $request->input('consecutivo');

        $notificar = $request->input('notificar');

        $maxId = Reporte_no_conformidades::selectRaw('MAX(CAST(SUBSTRING_INDEX(id_reporte_conform,"-", -1) AS UNSIGNED)) AS id')->first()->id;
        $nuevoId = ($maxId) ? $maxId + 1 : 1;
        $id_reporte_conform = str_replace('-', '', now()->format('d-m-Y')) . '-' . $nuevoId;

        $tabla1 = [
            'id_reporte_conform' => $id_reporte_conform,
            'sistema_de_gestion' => $sistema_de_gestion,
            'ciclo_auditoria' => $ciclo_auditoria,
            'fecha_auditoria' => $fecha_auditoria,
            'lugar' => $lugar,
            'fecha_elaboracion' => $fecha_elaboracion,
            'fuente_no_conforme' => $fuente_no_conforme,
            'proceso_no_conforme' => $proceso_no_conforme,
            'nombre_reporte_proceso' => $nombre_reporte_proceso,
            'tipo_proceso_no_conforme' => $tipo_proceso_no_conforme,
            'descripcion_no_conformidad' => $descripcion_no_conformidad,
            'responsable_no_conformidad' => $responsable_no_conformidad,
            'impacto_no_conformidad' => $impacto_no_conformidad,
            'analisis_mano_de_obra' => $analisis_mano_de_obra,
            'analisis_maquinaria' => $analisis_maquinaria,
            'analisis_metodo' => $analisis_metodo,
            'analisis_materiales' => $analisis_materiales,
            'analisis_medio_ambiente' => $analisis_medio_ambiente,
            'analisis_otros_factores' => $analisis_otros_factores,
            'prog_cierre_fecha' => $prog_cierre_fecha,
            'prog_cierre_responsable' => $prog_cierre_responsable,
            'cierre_real_fecha' => $cierre_real_fecha,
            'cierre_real_responsable' => $cierre_real_responsable,
            'consecutivo' => $consecutivo,
        ];
        Reporte_no_conformidades::create($tabla1);

        if ($persona_equipo_trabajo[0] !== null) {
            foreach ($persona_equipo_trabajo as $persona) {
                Equipo_trabajo_reporte_no_conformidades::create([
                    'persona_equipo_trabajo' => $persona,
                    'fk_id_reporte_conform' => $id_reporte_conform,
                ]);
            }
        }

        if ($plan_accion_actividad[0] !== null) {
            foreach ($plan_accion_numero as $indice => $plan_accion_numero_value) {

                $tabla2 = [
                    'plan_accion_numero' => $plan_accion_numero_value,
                    'plan_accion_actividad' => $plan_accion_actividad[$indice],
                    'plan_accion_responsable' => $plan_accion_responsable[$indice],
                    'plan_accion_fecha_tarea' => $plan_accion_fecha_tarea[$indice],
                    'fk_id_reporte_conform' => $id_reporte_conform,
                ];

                Plan_accion_reporte_no_conformidades::create($tabla2);
            }
        }

        if ($seguimiento_plan_fecha[0] !== null) {
            foreach ($seguimiento_plan_fecha as $indice => $seguimiento_plan_fecha_value) {
                if (isset($segui_plan_archivos[$indice])) {
                    $ruta = substr(public_path(), 0, -14) . 'public/archivos/Reporte/Seguimiento/' . $id_reporte_conform . '/';
                    $extension = $segui_plan_archivos[$indice]->getClientOriginalExtension();
                    $nombreOriginal = $segui_plan_archivos[$indice]->getClientOriginalName();
                    $nombreArchivo = 'Archivo-Seguimiento-' . $nombreOriginal . '-' . $id_reporte_conform . '.' . $extension;
                    $segui_plan_archivos[$indice]->move($ruta, $nombreArchivo);
                    $segui_plan_archivos[$indice] = $nombreArchivo;
                }
                $tabla3 = [
                    'seguimiento_plan_fecha' => $seguimiento_plan_fecha_value,
                    'seguimiento_numero' => $seguimiento_numero[$indice],
                    'seguimiento_actividad_tarea' => $seguimiento_actividad_tarea[$indice],
                    'seguimiento_compromisos' => $seguimiento_compromisos[$indice],
                    'seguimiento_responsable' => $seguimiento_responsable[$indice],
                    'segui_plan_archivos' => $segui_plan_archivos[$indice] ?? null,
                    'fk_id_reporte_conform' => $id_reporte_conform,
                ];
                Seguimiento_reporte_no_conformidades::create($tabla3);
            }
        }

        foreach ($verifica_implementacion_responsable as $indice => $verifica_implementacion_responsable_value) {
            if (isset($verifica_imple_archivos[$indice])) {
                $ruta = substr(public_path(), 0, -14) . 'public/archivos/Reporte/Verificacion/' . $id_reporte_conform . '/';
                $extension = $verifica_imple_archivos[$indice]->getClientOriginalExtension();
                $nombreOriginal = $verifica_imple_archivos[$indice]->getClientOriginalName();
                $nombreArchivo = 'Archivo-Verificacion-' . $nombreOriginal . '-' . $id_reporte_conform . '.' . $extension;
                $verifica_imple_archivos[$indice]->move($ruta, $nombreArchivo);
                $verifica_imple_archivos[$indice] = $nombreArchivo;
            }
            $tabla4 = [
                'verifica_implementacion_fecha' => $verifica_implementacion_fecha[$indice],
                'verifica_implementacion_observa' => $verifica_implementacion_observa[$indice],
                'verifi_imple_respon' => $verifica_implementacion_responsable_value,
                'verifica_imple_archivos' => $verifica_imple_archivos[$indice] ?? null,
                'fk_id_reporte_conform' => $id_reporte_conform,
            ];
            Verificacion_imp_reporte_no_conformidades::create($tabla4);
        }

        $jefe_calidad = PanelEmpleados::getJefeCalidadPorCentro($lugar);
        $infoResRepor = PanelEmpleados::getEmpleadoInfo($responsable_no_conformidad);
        $jefeDataNoti['correo'] = $jefe_calidad[0]->correo;
        $jefeDataNoti['planta'] = strtoupper($lugar);
        $jefeDataNoti['fecha_elaboracion'] = $fecha_elaboracion;
        $jefeDataNoti['area'] = PanelAreas::getArea($proceso_no_conforme)[0]->descripcion;
        $jefeDataNoti['responsable'] = $infoResRepor[0]->nombre;
        $jefeDataNoti['cargo'] = $infoResRepor[0]->cargo;
        $jefeDataNoti['url_reporte'] = env('APP_URL') . '/Berhlan/public/panel/noconformidades/completar_reporte/' . $id_reporte_conform;

        Mail::send('email.email_mejora_continua.notificacion_reporte_accion_mejora', $jefeDataNoti, function ($message) use ($jefeDataNoti) {
            $message->subject('Notificaciones Intranet');
            $message->from('notificacionesberhlan@berhlan.com');
            $message->to($jefeDataNoti['correo']);
        });

        foreach ($notificar as $posicion => $valor) {

            $infoNotiRepor = PanelEmpleados::getEmpleado($valor);
            $infoResRepor = PanelEmpleados::getEmpleadoInfo($responsable_no_conformidad);
            $dataCorreo['correo'] = $infoNotiRepor[0]->correo;
            $dataCorreo['planta'] = strtoupper($lugar);
            $dataCorreo['fecha_elaboracion'] = $fecha_elaboracion;
            $dataCorreo['area'] = PanelAreas::getArea($proceso_no_conforme)[0]->descripcion;
            $dataCorreo['responsable'] = $infoResRepor[0]->nombre;
            $dataCorreo['cargo'] = $infoResRepor[0]->cargo;
            $dataCorreo['url_reporte'] = env('APP_URL') . '/Berhlan/public/panel/noconformidades/completar_reporte/' . $id_reporte_conform;

            Mail::send('email.email_mejora_continua.notificacion_reporte_accion_mejora', $dataCorreo, function ($message) use ($dataCorreo) {
                $message->subject('Notificaciones Intranet');
                $message->from('notificacionesberhlan@berhlan.com');
                $message->to($dataCorreo['correo']);
            });
        }
        toastr()->success('¡Reporte de accion o mejora continua creado exitosamente!', '¡Creación exitosa!', ['positionClass' => 'toast-bottom-right']);
        return redirect()->back();
    }

    public function showCompletarReporteNoConf($id)
    {
        $user = Session::get('user');
        $DatosUsuario = PanelLogin::getUsuario($user);
        $registro_reporte = Reporte_no_conformidades::find($id);

        $infoPersonCierre = PanelEmpleados::getEmpleadoInfo($registro_reporte['prog_cierre_responsable']);
        $infoPersonCierreReal = PanelEmpleados::getEmpleadoInfo($registro_reporte['cierre_real_responsable']);

        $registro_equipo_reporte = Equipo_trabajo_reporte_no_conformidades::where('fk_id_reporte_conform', $id)->get();
        $registro_plan_accion_reporte = Plan_accion_reporte_no_conformidades::where('fk_id_reporte_conform', $id)->get();
        $registro_seguimiento_reporte = Seguimiento_reporte_no_conformidades::where('fk_id_reporte_conform', $id)->get();
        $registro_verifi_imp_reporte = Verificacion_imp_reporte_no_conformidades::where('fk_id_reporte_conform', $id)->get();
        $registro_reporte['consecutivo'] = sprintf('%03d', $registro_reporte['consecutivo']);

        $result = Plan_accion_reporte_no_conformidades::where('fk_id_reporte_conform', $id)
            ->where('id_plan_accion_reporte_no_conformidades', function ($query, ) use ($id) {
                $query->selectRaw('MAX(id_plan_accion_reporte_no_conformidades)')
                    ->from('mc_plan_reporte')
                    ->where('fk_id_reporte_conform', $id);
            })
            ->pluck('plan_accion_numero')
            ->first() ?? null;

        $incrementable = $result ? explode("-", $result)[1] : 1;

        $areas = PanelAreas::getAreasPorEmpresa('1');
        $Empleados = PanelEmpleados::EmpleadosWithCargoActivos();
        return view('inconformidades.panelDiligenciarReporte')->with(['DatosUsuario' => $DatosUsuario, 'registro_reporte' => $registro_reporte, 'registro_equipo_reporte' => $registro_equipo_reporte, 'registro_plan_accion_reporte' => $registro_plan_accion_reporte, 'registro_seguimiento_reporte' => $registro_seguimiento_reporte, 'registro_verifi_imp_reporte' => $registro_verifi_imp_reporte, 'areas' => $areas, 'Empleados' => $Empleados, 'incrementable' => $incrementable]);
    }

    public function completarReporteNoConf(Request $request)
    {
        $user = Session::get('user');
        $DatosUsuario = PanelLogin::getUsuario($user);
        $id_reporte_conform = $request->input('id_reporte_conform');

        $analisis_mano_de_obra = $request->input('mano_de_obra');
        $analisis_maquinaria = $request->input('maquinaria');
        $analisis_metodo = $request->input('metodo');
        $analisis_materiales = $request->input('materiales');
        $analisis_medio_ambiente = $request->input('medio_ambiente');
        $analisis_otros_factores = $request->input('otros_factores');

        $persona_equipo_trabajo = $request->input('persona_equipo');

        //Otra tabla
        $plan_accion_numero = $request->input('plan_accion_n#');
        $plan_accion_actividad = $request->input('plan_accion_actividad');
        $plan_accion_responsable = $request->input('plan_accion_responsable');
        $plan_accion_fecha_tarea = $request->input('plan_accion_fecha_tarea');

        //Otra tabla
        $seguimiento_plan_fecha = $request->input('seguimiento_plan_fecha');
        $seguimiento_numero = $request->input('seguimiento_plan_n#');
        $seguimiento_actividad_tarea = $request->input('seguimiento_plan_descrip');
        $seguimiento_compromisos = $request->input('seguimiento_plan_compromisos');
        $seguimiento_responsable = $request->input('seguimiento_plan_responsable');
        $segui_plan_archivos = $request->file('segui_plan_archivos');

        Reporte_no_conformidades::where('id_reporte_conform', $id_reporte_conform)->update([
            'analisis_mano_de_obra' => $analisis_mano_de_obra,
            'analisis_maquinaria' => $analisis_maquinaria,
            'analisis_metodo' => $analisis_metodo,
            'analisis_materiales' => $analisis_materiales,
            'analisis_medio_ambiente' => $analisis_medio_ambiente,
            'analisis_medio_ambiente' => $analisis_medio_ambiente,
            'analisis_otros_factores' => $analisis_otros_factores,

        ]);

        if (isset($persona_equipo_trabajo)) {
            foreach ($persona_equipo_trabajo as $persona) {
                Equipo_trabajo_reporte_no_conformidades::create([
                    'persona_equipo_trabajo' => $persona,
                    'fk_id_reporte_conform' => $id_reporte_conform,
                ]);
            }
        }

        if (isset($plan_accion_numero)) {
            foreach ($plan_accion_numero as $indice => $plan_accion_numero_value) {
                $tabla1 = [
                    'plan_accion_numero' => $plan_accion_numero_value,
                    'plan_accion_actividad' => $plan_accion_actividad[$indice],
                    'plan_accion_responsable' => $plan_accion_responsable[$indice],
                    'plan_accion_fecha_tarea' => $plan_accion_fecha_tarea[$indice],
                    'fk_id_reporte_conform' => $id_reporte_conform,
                ];
                Plan_accion_reporte_no_conformidades::create($tabla1);
            }
        }

        if (isset($seguimiento_plan_fecha)) {
            foreach ($seguimiento_plan_fecha as $indice => $seguimiento_plan_fecha_value) {
                if (isset($segui_plan_archivos[$indice])) {
                    $ruta = substr(public_path(), 0, -14) . 'public/archivos/Reporte/Seguimiento/' . $id_reporte_conform . '/';
                    $extension = $segui_plan_archivos[$indice]->getClientOriginalExtension();
                    $nombreOriginal = $segui_plan_archivos[$indice]->getClientOriginalName();
                    $nombreArchivo = 'Archivo-Seguimiento-' . $nombreOriginal . '-' . $id_reporte_conform . '.' . $extension;
                    $segui_plan_archivos[$indice]->move($ruta, $nombreArchivo);
                    $segui_plan_archivos[$indice] = $nombreArchivo;
                }
                $tabla2 = [
                    'seguimiento_plan_fecha' => $seguimiento_plan_fecha_value,
                    'seguimiento_numero' => $seguimiento_numero[$indice],
                    'seguimiento_actividad_tarea' => $seguimiento_actividad_tarea[$indice],
                    'seguimiento_compromisos' => $seguimiento_compromisos[$indice],
                    'seguimiento_responsable' => $seguimiento_responsable[$indice],
                    'segui_plan_archivos' => $segui_plan_archivos[$indice] ?? null,
                    'fk_id_reporte_conform' => $id_reporte_conform,
                ];

                Seguimiento_reporte_no_conformidades::create($tabla2);
            }
        }

        toastr()->success('¡Reporte de no conformidad o mejora continua diligenciado correctamente!', '¡Creación exitosa!', ['positionClass' => 'toast-bottom-right']);
        return redirect()->back();
    }

    public function searchReporteNoConf(request $request)
    {
        $user = Session::get('user');
        $DatosUsuario = PanelLogin::getUsuario($user);
        $fecha_ini = $request->input('fecha_ini_repor');
        $fecha_final = $request->input('fecha_final_repor');
        $estado_reporte = $request->input('estado_reporte');
        $proceso_no_conforme = $request->input('proceso_no_conforme');

        $sql = Reporte_no_conformidades::query();

        if ($fecha_ini !== null && $fecha_final !== null) {
            $sql->whereBetween('fecha_elaboracion', [$fecha_ini, $fecha_final]);
        }
        if ($fecha_ini !== null) {
            $sql->where('fecha_elaboracion', '>', $fecha_ini);
        }
        // if ($estado_reporte !== null) {
        //     $sql->where('estado_reporte', '=', $estado_reporte);
        // }
        if ($proceso_no_conforme !== null) {
            $sql->where('proceso_no_conforme', '=', $proceso_no_conforme);
        }

        $registrosReporte = $sql->get();

        if (count($registrosReporte) !== 0) {
            foreach ($registrosReporte as $key) {
                $area = PanelAreas::getArea($key->getAttributes()['proceso_no_conforme']);
                $key->setAttribute('proceso_no_conforme', $area[0]->descripcion);
            }

            return view('inconformidades.panelConsultarInformesNoConformidad')->with(['DatosUsuario' => $DatosUsuario, 'RegistrosReporte' => $registrosReporte]);
        } else {
            toastr()->warning('¡No se han encontrado registros en busqueda!', '¡Advertencia!', ['positionClass' => 'toast-bottom-right']);
            return redirect()->route('showParametrosConsultar');
        }
    }

    public function showReporteNoConformidad($id)
    {
        $user = Session::get('user');
        $DatosUsuario = PanelLogin::getUsuario($user);
        $empleado = PanelEmpleados::getEmpleadoInfo($DatosUsuario[0]->empleado);
        $registro_reporte = Reporte_no_conformidades::find($id);

        $infoPersonCierre = PanelEmpleados::getEmpleadoInfo($registro_reporte['prog_cierre_responsable']);
        $infoPersonCierreReal = PanelEmpleados::getEmpleadoInfo($registro_reporte['cierre_real_responsable']);

        $registro_equipo_reporte = Equipo_trabajo_reporte_no_conformidades::where('fk_id_reporte_conform', $id)->get();
        $registro_plan_accion_reporte = Plan_accion_reporte_no_conformidades::where('fk_id_reporte_conform', $id)->get();
        $registro_seguimiento_reporte = Seguimiento_reporte_no_conformidades::where('fk_id_reporte_conform', $id)->get();
        $registro_verifi_imp_reporte = Verificacion_imp_reporte_no_conformidades::where('fk_id_reporte_conform', $id)->get();

        $resultados = Plan_accion_reporte_no_conformidades::where('fk_id_reporte_conform', $id)
            ->pluck('plan_accion_numero')
            ->toArray();
        $consecutivos_plan = $resultados;
        $areas = PanelAreas::getAreasPorEmpresa('1');
        $Empleados = PanelEmpleados::EmpleadosWithCargoActivos();
        return view('inconformidades.panelVerReporteAccionesCorrectivas')->with(['DatosUsuario' => $DatosUsuario, 'registro_reporte' => $registro_reporte, 'registro_equipo_reporte' => $registro_equipo_reporte, 'registro_plan_accion_reporte' => $registro_plan_accion_reporte, 'registro_seguimiento_reporte' => $registro_seguimiento_reporte, 'registro_verifi_imp_reporte' => $registro_verifi_imp_reporte, 'areas' => $areas, 'Empleados' => $Empleados, 'consecutivos_plan' => $consecutivos_plan, 'empleado' => $empleado]);
    }

    public function documentExcel($id)
    {
        $plantilla = storage_path('app/templates/F-AC-01-04_REPORTE_DE_NO_CONFORMIDAD,_ACCION_CORRECTIVA_Y_O_DE_MEJORA_V6.xlsx');
        $spreadsheet = IOFactory::load($plantilla);
        $sheet = $spreadsheet->getActiveSheet();

        $registro_reporte = Reporte_no_conformidades::find($id);
        $infoPersonCierre = PanelEmpleados::getEmpleadoInfo($registro_reporte['prog_cierre_responsable']);
        $registro_reporte['prog_cierre_responsable'] = $infoPersonCierre[0]->nombre;
        $registro_reporte['prog_cierre_cargo_responsable'] = $infoPersonCierre[0]->cargo;
        $infoNomReporteProc = PanelEmpleados::getEmpleadoInfo($registro_reporte['nombre_reporte_proceso']);
        $registro_reporte['nombre_reporte_proceso'] = $infoNomReporteProc[0]->nombre . ' - ' . $infoNomReporteProc[0]->cargo;
        $infoResponsable = PanelEmpleados::getEmpleadoInfo($registro_reporte['responsable_no_conformidad']);
        $registro_reporte['responsable_no_conformidad'] = $infoResponsable[0]->nombre . ' - ' . $infoResponsable[0]->cargo;
        $infoPersonCierreReal = PanelEmpleados::getEmpleadoInfo($registro_reporte['cierre_real_responsable']);
        $registro_reporte['proceso_no_conforme'] = PanelAreas::getArea($registro_reporte['proceso_no_conforme'])[0]->descripcion;
        $registro_reporte['cierre_real_responsable'] = $infoPersonCierreReal[0]->nombre;
        $registro_reporte['cierre_real_cargo_responsable'] = $infoPersonCierreReal[0]->cargo;

        //dump($registro_reporte);

        $sheet->setCellValue('K7', $registro_reporte->id_reporte_conform);
        $sheet->setCellValue('T7', $registro_reporte->fecha_elaboracion->format('d-m-Y'));
        $sheet->setCellValue('K8', $registro_reporte->sistema_de_gestion);
        $sheet->setCellValue('K9', $registro_reporte->ciclo_auditoria);
        $sheet->setCellValue('K10', $registro_reporte->lugar);

        if ($registro_reporte->fuente_no_conforme === 'documentos normativos') {
            $sheet->setCellValue('D14', 'X');
        } else if ($registro_reporte->fuente_no_conforme === 'procesos') {
            $sheet->setCellValue('D15', 'X');
        } else if ($registro_reporte->fuente_no_conforme === 'procedimientos') {
            $sheet->setCellValue('D16', 'X');
        } else if ($registro_reporte->fuente_no_conforme === 'producto no conforme') {
            $sheet->setCellValue('D17', 'X');
        } else if ($registro_reporte->fuente_no_conforme === 'quejas y reclamos') {
            $sheet->setCellValue('H14', 'X');
        } else if ($registro_reporte->fuente_no_conforme === 'auditoria interna') {
            $sheet->setCellValue('H15', 'X');
        } else if ($registro_reporte->fuente_no_conforme === 'auditoria interna') {
            $sheet->setCellValue('H16', 'X');
        } else if ($registro_reporte->fuente_no_conforme === 'otro') {
            $sheet->setCellValue('H17', 'X');
        }
        $sheet->setCellValue('K13', 'Proceso No Conforme:' . $registro_reporte->proceso_no_conforme);
        $sheet->setCellValue('K15', 'Nombre del R de proceso que reporta la No Conformidad (o del auditor líder):' . $registro_reporte->nombre_reporte_proceso);

        if ($registro_reporte->tipo_proceso_no_conforme === 'correctiva') {
            $sheet->setCellValue('P15', 'X');
        } else if ($registro_reporte->tipo_proceso_no_conforme === 'mejora') {
            $sheet->setCellValue('S15', 'X');
        }
        $sheet->setCellValue('C21', $registro_reporte->descripcion_no_conformidad);
        $sheet->setCellValue('C23', $registro_reporte->responsable_no_conformidad);

        $registro_equipo_reporte = Equipo_trabajo_reporte_no_conformidades::where('fk_id_reporte_conform', $id)->get();

        $i = 0;

        if (count($registro_equipo_reporte) !== 0) {
            $filas_equipo = count($registro_equipo_reporte) - 1;
        } else {
            $filas_equipo = count($registro_equipo_reporte);
        }

        if (count($registro_equipo_reporte) !== 0) {
            if (count($registro_equipo_reporte) !== 1) {
                $sheet->insertNewRowBefore(27, $filas_equipo);
            }
            foreach ($registro_equipo_reporte as $key) {

                $infoEquipoReporte = PanelEmpleados::getEmpleadoInfo($key->getAttributes()['persona_equipo_trabajo']);
                $key->setAttribute('persona_equipo_trabajo', $infoEquipoReporte[0]->nombre);
                $key->setAttribute('cargo_equipo_no_conformidad', $infoEquipoReporte[0]->cargo);
                $sheet->mergeCells('C' . 27 + $i . ':' . 'L' . 27 + $i);
                $sheet->mergeCells('M' . 27 + $i . ':' . 'V' . 27 + $i);
                $sheet->setCellValue('C' . 27 + $i, $key->getAttributes()['persona_equipo_trabajo']);
                $sheet->setCellValue('M' . 27 + $i, $key->getAttributes()['cargo_equipo_no_conformidad']);
                $i++;
            }
        }

        if ($registro_reporte->impacto_no_conformidad === 'Alto') {
            $sheet->setCellValue('H' . 31 + $filas_equipo, 'X');
        } else if ($registro_reporte->impacto_no_conformidad === 'Medio') {
            $sheet->setCellValue('H' . 32 + $filas_equipo, 'X');
        } else if ($registro_reporte->impacto_no_conformidad === 'Bajo') {
            $sheet->setCellValue('H' . 33 + $filas_equipo, 'X');
        }

        $sheet->setCellValue('C' . 62 + $filas_equipo, $registro_reporte->analisis_mano_de_obra);
        $sheet->setCellValue('C' . 65 + $filas_equipo, $registro_reporte->analisis_maquinaria);
        $sheet->setCellValue('C' . 68 + $filas_equipo, $registro_reporte->analisis_metodo);
        $sheet->setCellValue('C' . 71 + $filas_equipo, $registro_reporte->analisis_materiales);
        $sheet->setCellValue('C' . 74 + $filas_equipo, $registro_reporte->analisis_medio_ambiente);
        $sheet->setCellValue('C' . 77 + $filas_equipo, $registro_reporte->analisis_otros_factores);

        $i = 0;
        $registro_plan_accion_reporte = Plan_accion_reporte_no_conformidades::where('fk_id_reporte_conform', $id)->get();

        if (count($registro_plan_accion_reporte) !== 0) {
            $filas_plan_accion = count($registro_plan_accion_reporte) - 1;
        } else {
            $filas_plan_accion = count($registro_plan_accion_reporte);
        }

        if (count($registro_plan_accion_reporte) !== 0) {
            if (count($registro_plan_accion_reporte) !== 1) {
                $sheet->insertNewRowBefore(81 + $filas_equipo, $filas_plan_accion);
            }

            foreach ($registro_plan_accion_reporte as $key) {
                $infoPersonPlanAcReporte = PanelEmpleados::getEmpleadoInfo($key->getAttributes()['plan_accion_responsable']);
                $sheet->mergeCells('C' . 81 + $filas_equipo + $i . ':' . 'D' . 81 + $filas_equipo + $i);
                $sheet->mergeCells('E' . 81 + $filas_equipo + $i . ':' . 'N' . 81 + $filas_equipo + $i);
                $sheet->mergeCells('O' . 81 + $filas_equipo + $i . ':' . 'R' . 81 + $filas_equipo + $i);
                $sheet->mergeCells('S' . 81 + $filas_equipo + $i . ':' . 'V' . 81 + $filas_equipo + $i);
                $key->setAttribute('plan_accion_responsable', $infoPersonPlanAcReporte[0]->nombre);
                $key->setAttribute('plan_accion_cargo_responsable', $infoPersonPlanAcReporte[0]->cargo);

                $sheet->setCellValue('C' . 81 + $filas_equipo + $i, $key->getAttributes()['plan_accion_numero']);
                $sheet->setCellValue('E' . 81 + $filas_equipo + $i, $key->getAttributes()['plan_accion_actividad']);
                $sheet->setCellValue('O' . 81 + $filas_equipo + $i, $key->getAttributes()['plan_accion_responsable']);
                $fecha_tarea = new DateTime($key->getAttributes()['plan_accion_fecha_tarea']);
                $fecha_tarea = $fecha_tarea->format('d-m-Y');
                $sheet->setCellValue('S' . 81 + $filas_equipo + $i, $fecha_tarea);
                $i++;
            }
        }

        $i = 0;
        $registro_seguimiento_reporte = Seguimiento_reporte_no_conformidades::where('fk_id_reporte_conform', $id)->get();

        if (count($registro_seguimiento_reporte) !== 0) {
            $filas_seguimiento = count($registro_seguimiento_reporte) - 1;
        } else {
            $filas_seguimiento = count($registro_seguimiento_reporte);
        }

        if (count($registro_seguimiento_reporte) !== 0) {
            if (count($registro_seguimiento_reporte) !== 1) {
                $sheet->insertNewRowBefore(85 + $filas_equipo + $filas_plan_accion, $filas_seguimiento);
            }

            foreach ($registro_seguimiento_reporte as $key) {
                $infoPersonSegReporte = PanelEmpleados::getEmpleadoInfo($key->getAttributes()['seguimiento_responsable']);
                $sheet->mergeCells('C' . 85 + $filas_equipo + $filas_plan_accion + $i . ':' . 'E' . 85 + $filas_equipo + $filas_plan_accion + $i);
                $sheet->mergeCells('G' . 85 + $filas_equipo + $filas_plan_accion + $i . ':' . 'L' . 85 + $filas_equipo + $filas_plan_accion + $i);
                $sheet->mergeCells('M' . 85 + $filas_equipo + $filas_plan_accion + $i . ':' . 'R' . 85 + $filas_equipo + $filas_plan_accion + $i);
                $sheet->mergeCells('S' . 85 + $filas_equipo + $filas_plan_accion + $i . ':' . 'V' . 85 + $filas_equipo + $filas_plan_accion + $i);
                $key->setAttribute('seguimiento_responsable', $infoPersonSegReporte[0]->nombre);
                $key->setAttribute('seguimiento_cargo_responsable', $infoPersonSegReporte[0]->cargo);
                $fecha_segui = new DateTime($key->getAttributes()['seguimiento_plan_fecha']);
                $fecha_segui = $fecha_segui->format('d-m-Y');
                $sheet->setCellValue('C' . 85 + $filas_equipo + $filas_plan_accion + $i, $fecha_segui);
                $sheet->setCellValue('F' . 85 + $filas_equipo + $filas_plan_accion + $i, $key->getAttributes()['seguimiento_numero']);
                $sheet->setCellValue('G' . 85 + $filas_equipo + $filas_plan_accion + $i, $key->getAttributes()['seguimiento_actividad_tarea']);
                $sheet->setCellValue('M' . 85 + $filas_equipo + $filas_plan_accion + $i, $key->getAttributes()['seguimiento_compromisos']);
                $sheet->setCellValue('S' . 85 + $filas_equipo + $filas_plan_accion + $i, $key->getAttributes()['seguimiento_responsable']);
                $i++;
            }
        }

        $i = 0;
        $registro_verifi_imp_reporte = Verificacion_imp_reporte_no_conformidades::where('fk_id_reporte_conform', $id)->get();

        if (count($registro_verifi_imp_reporte) !== 0) {
            $filas_verifi_correctivo = count($registro_verifi_imp_reporte) - 1;
        } else {
            $filas_verifi_correctivo = count($registro_verifi_imp_reporte);
        }

        if (count($registro_verifi_imp_reporte) !== 1) {
            $sheet->insertNewRowBefore(89 + $filas_equipo + $filas_plan_accion + $filas_seguimiento, $filas_verifi_correctivo);
        }
        foreach ($registro_verifi_imp_reporte as $key) {
            $infoPersonSegReporte = PanelEmpleados::getEmpleadoInfo($key->getAttributes()['verifi_imple_respon']);
            $sheet->mergeCells('C' . 89 + $filas_equipo + $filas_plan_accion + $filas_seguimiento + $i . ':' . 'E' . 89 + $filas_equipo + $filas_plan_accion + $filas_seguimiento + $i);
            $sheet->mergeCells('F' . 89 + $filas_equipo + $filas_plan_accion + $filas_seguimiento + $i . ':' . 'M' . 89 + $filas_equipo + $filas_plan_accion + $filas_seguimiento + $i);
            $sheet->mergeCells('N' . 89 + $filas_equipo + $filas_plan_accion + $filas_seguimiento + $i . ':' . 'R' . 89 + $filas_equipo + $filas_plan_accion + $filas_seguimiento + $i);
            $sheet->mergeCells('S' . 89 + $filas_equipo + $filas_plan_accion + $filas_seguimiento + $i . ':' . 'V' . 89 + $filas_equipo + $filas_plan_accion + $filas_seguimiento + $i);
            $key->setAttribute('verifi_imple_respon', $infoPersonSegReporte[0]->nombre);
            $key->setAttribute('verifi_imple_cargo_respon', $infoPersonSegReporte[0]->cargo);
            $fecha_veri_imp = new DateTime($key->getAttributes()['verifica_implementacion_fecha']);
            $fecha_veri_imp = $fecha_veri_imp->format('d-m-Y');
            $sheet->setCellValue('C' . 89 + $filas_equipo + $filas_plan_accion + $filas_seguimiento + $i, $fecha_veri_imp);
            $sheet->setCellValue('F' . 89 + $filas_equipo + $filas_plan_accion + $filas_seguimiento + $i, $key->getAttributes()['verifica_implementacion_observa']);
            $sheet->setCellValue('N' . 89 + $filas_equipo + $filas_plan_accion + $filas_seguimiento + $i, $key->getAttributes()['verifi_imple_respon']);
            $sheet->setCellValue('S' . 89 + $filas_equipo + $filas_plan_accion + $filas_seguimiento + $i, $key->getAttributes()['verifi_imple_cargo_respon']);
            $i++;
        }

        $sheet->setCellValue('G' . 93 + $filas_equipo + $filas_plan_accion + $filas_seguimiento + $filas_verifi_correctivo, $registro_reporte->prog_cierre_fecha->format('d-m-Y'));
        $sheet->setCellValue('K' . 93 + $filas_equipo + $filas_plan_accion + $filas_seguimiento + $filas_verifi_correctivo, $registro_reporte->prog_cierre_responsable);
        $sheet->setCellValue('G' . 94 + $filas_equipo + $filas_plan_accion + $filas_seguimiento + $filas_verifi_correctivo, $registro_reporte->cierre_real_fecha->format('d-m-Y'));
        $sheet->setCellValue('K' . 94 + $filas_equipo + $filas_plan_accion + $filas_seguimiento + $filas_verifi_correctivo, $registro_reporte->cierre_real_responsable);

        // Guardar el archivo Excel modificado
        $writer = new Xlsx($spreadsheet);
        $nombreArchivo = $registro_reporte->id_reporte_conform . '.xlsx';
        $writer->save(storage_path('app/public/Reportes/' . $nombreArchivo));

        return response()->download(storage_path('app/public/Reportes/' . $nombreArchivo));
    }

    public function updateGraficaReporte(Request $request)
    {
        $fecha_ini_repor = $request->input('fecha_ini_repor');
        $fecha_final_repor = $request->input('fecha_final_repor');

        $sql = Reporte_no_conformidades::selectRaw('COUNT(mc_reporte.proceso_no_conforme) AS cantidad, pa.descripcion')
            ->join('param_areas as pa', 'pa.id_area', '=', 'mc_reporte.proceso_no_conforme');
        if ($fecha_ini_repor !== null && $fecha_final_repor !== null) {
            $sql->whereBetween('mc_reporte.fecha_elaboracion', [$fecha_ini_repor, $fecha_final_repor]);
        }

        if ($fecha_ini_repor !== null) {
            $sql->where('mc_reporte.fecha_elaboracion', '>=', $fecha_ini_repor);
        }

        $sql->groupBy('pa.id_area', 'pa.descripcion');

        $cantidadRegistros = $sql->get();

        if (count($cantidadRegistros) === 0) {
            toastr()->warning('¡No se han encontrado registros en busqueda!', '¡Advertencia!', ['positionClass' => 'toast-bottom-right']);
            return response()->json(['message' => 'No hay registros']);

        } else {
            return response()->json($cantidadRegistros);
        }
    }

    public function downloadAllRepor(Request $request)
    {
        $reportes = json_decode($request->input('reportes'), true);
        $plantilla = storage_path('app/templates/F-AC-01-04_REPORTE_DE_NO_CONFORMIDAD,_ACCION_CORRECTIVA_Y_O_DE_MEJORA_V6.xlsx');
        $zip = new ZipArchive();
        $zipFileName = 'informes_reporte_acciones_correctivas_o_mejora.zip';
        $zipFilePath = storage_path("app/public/" . $zipFileName);

        if ($zip->open($zipFilePath, ZipArchive::CREATE) === true) {

            foreach ($reportes as $key => $value) {

                $spreadsheet = IOFactory::load($plantilla);
                $sheet = $spreadsheet->getActiveSheet();

                $registro_reporte = Reporte_no_conformidades::find($value['id_reporte_conform']);
                $infoPersonCierre = PanelEmpleados::getEmpleadoInfo($registro_reporte['prog_cierre_responsable']);
                $registro_reporte['prog_cierre_responsable'] = $infoPersonCierre[0]->nombre;
                $registro_reporte['prog_cierre_cargo_responsable'] = $infoPersonCierre[0]->cargo;
                $infoNomReporteProc = PanelEmpleados::getEmpleadoInfo($registro_reporte['nombre_reporte_proceso']);
                $registro_reporte['nombre_reporte_proceso'] = $infoNomReporteProc[0]->nombre . ' - ' . $infoNomReporteProc[0]->cargo;
                $infoResponsable = PanelEmpleados::getEmpleadoInfo($registro_reporte['responsable_no_conformidad']);
                $registro_reporte['responsable_no_conformidad'] = $infoResponsable[0]->nombre . ' - ' . $infoResponsable[0]->cargo;
                $infoPersonCierreReal = PanelEmpleados::getEmpleadoInfo($registro_reporte['cierre_real_responsable']);
                $registro_reporte['proceso_no_conforme'] = PanelAreas::getArea($registro_reporte['proceso_no_conforme'])[0]->descripcion;
                $registro_reporte['cierre_real_responsable'] = $infoPersonCierreReal[0]->nombre;
                $registro_reporte['cierre_real_cargo_responsable'] = $infoPersonCierreReal[0]->cargo;

                //dump($registro_reporte);

                $sheet->setCellValue('K7', $registro_reporte->id_reporte_conform);
                $sheet->setCellValue('T7', $registro_reporte->fecha_elaboracion->format('d-m-Y'));
                $sheet->setCellValue('K8', $registro_reporte->sistema_de_gestion);
                $sheet->setCellValue('K9', $registro_reporte->ciclo_auditoria);
                $sheet->setCellValue('K10', $registro_reporte->lugar);

                if ($registro_reporte->fuente_no_conforme === 'documentos normativos') {
                    $sheet->setCellValue('D14', 'X');
                } else if ($registro_reporte->fuente_no_conforme === 'procesos') {
                    $sheet->setCellValue('D15', 'X');
                } else if ($registro_reporte->fuente_no_conforme === 'procedimientos') {
                    $sheet->setCellValue('D16', 'X');
                } else if ($registro_reporte->fuente_no_conforme === 'producto no conforme') {
                    $sheet->setCellValue('D17', 'X');
                } else if ($registro_reporte->fuente_no_conforme === 'quejas y reclamos') {
                    $sheet->setCellValue('H14', 'X');
                } else if ($registro_reporte->fuente_no_conforme === 'auditoria interna') {
                    $sheet->setCellValue('H15', 'X');
                } else if ($registro_reporte->fuente_no_conforme === 'auditoria interna') {
                    $sheet->setCellValue('H16', 'X');
                } else if ($registro_reporte->fuente_no_conforme === 'otro') {
                    $sheet->setCellValue('H17', 'X');
                }
                $sheet->setCellValue('K13', 'Proceso No Conforme:' . $registro_reporte->proceso_no_conforme);
                $sheet->setCellValue('K15', 'Nombre del R de proceso que reporta la No Conformidad (o del auditor líder):' . $registro_reporte->nombre_reporte_proceso);

                if ($registro_reporte->tipo_proceso_no_conforme === 'correctiva') {
                    $sheet->setCellValue('P15', 'X');
                } else if ($registro_reporte->tipo_proceso_no_conforme === 'mejora') {
                    $sheet->setCellValue('S15', 'X');
                }
                $sheet->setCellValue('C21', $registro_reporte->descripcion_no_conformidad);
                $sheet->setCellValue('C23', $registro_reporte->responsable_no_conformidad);

                $registro_equipo_reporte = Equipo_trabajo_reporte_no_conformidades::where('fk_id_reporte_conform', $value['id_reporte_conform'])->get();

                $i = 0;

                if (count($registro_equipo_reporte) !== 0) {
                    $filas_equipo = count($registro_equipo_reporte) - 1;
                } else {
                    $filas_equipo = count($registro_equipo_reporte);
                }

                if (count($registro_equipo_reporte) !== 0) {
                    if (count($registro_equipo_reporte) !== 1) {
                        $sheet->insertNewRowBefore(27, $filas_equipo);
                    }
                    foreach ($registro_equipo_reporte as $key) {

                        $infoEquipoReporte = PanelEmpleados::getEmpleadoInfo($key->getAttributes()['persona_equipo_trabajo']);
                        $key->setAttribute('persona_equipo_trabajo', $infoEquipoReporte[0]->nombre);
                        $key->setAttribute('cargo_equipo_no_conformidad', $infoEquipoReporte[0]->cargo);
                        $sheet->mergeCells('C' . 27 + $i . ':' . 'L' . 27 + $i);
                        $sheet->mergeCells('M' . 27 + $i . ':' . 'V' . 27 + $i);
                        $sheet->setCellValue('C' . 27 + $i, $key->getAttributes()['persona_equipo_trabajo']);
                        $sheet->setCellValue('M' . 27 + $i, $key->getAttributes()['cargo_equipo_no_conformidad']);
                        $i++;
                    }
                }

                if ($registro_reporte->impacto_no_conformidad === 'Alto') {
                    $sheet->setCellValue('H' . 31 + $filas_equipo, 'X');
                } else if ($registro_reporte->impacto_no_conformidad === 'Medio') {
                    $sheet->setCellValue('H' . 32 + $filas_equipo, 'X');
                } else if ($registro_reporte->impacto_no_conformidad === 'Bajo') {
                    $sheet->setCellValue('H' . 33 + $filas_equipo, 'X');
                }

                $sheet->setCellValue('C' . 62 + $filas_equipo, $registro_reporte->analisis_mano_de_obra);
                $sheet->setCellValue('C' . 65 + $filas_equipo, $registro_reporte->analisis_maquinaria);
                $sheet->setCellValue('C' . 68 + $filas_equipo, $registro_reporte->analisis_metodo);
                $sheet->setCellValue('C' . 71 + $filas_equipo, $registro_reporte->analisis_materiales);
                $sheet->setCellValue('C' . 74 + $filas_equipo, $registro_reporte->analisis_medio_ambiente);
                $sheet->setCellValue('C' . 77 + $filas_equipo, $registro_reporte->analisis_otros_factores);

                $i = 0;
                $registro_plan_accion_reporte = Plan_accion_reporte_no_conformidades::where('fk_id_reporte_conform', $value['id_reporte_conform'])->get();

                if (count($registro_plan_accion_reporte) !== 0) {
                    $filas_plan_accion = count($registro_plan_accion_reporte) - 1;
                } else {
                    $filas_plan_accion = count($registro_plan_accion_reporte);
                }

                if (count($registro_plan_accion_reporte) !== 0) {
                    if (count($registro_plan_accion_reporte) !== 1) {
                        $sheet->insertNewRowBefore(81 + $filas_equipo, $filas_plan_accion);
                    }

                    foreach ($registro_plan_accion_reporte as $key) {
                        $infoPersonPlanAcReporte = PanelEmpleados::getEmpleadoInfo($key->getAttributes()['plan_accion_responsable']);
                        $sheet->mergeCells('C' . 81 + $filas_equipo + $i . ':' . 'D' . 81 + $filas_equipo + $i);
                        $sheet->mergeCells('E' . 81 + $filas_equipo + $i . ':' . 'N' . 81 + $filas_equipo + $i);
                        $sheet->mergeCells('O' . 81 + $filas_equipo + $i . ':' . 'R' . 81 + $filas_equipo + $i);
                        $sheet->mergeCells('S' . 81 + $filas_equipo + $i . ':' . 'V' . 81 + $filas_equipo + $i);
                        $key->setAttribute('plan_accion_responsable', $infoPersonPlanAcReporte[0]->nombre);
                        $key->setAttribute('plan_accion_cargo_responsable', $infoPersonPlanAcReporte[0]->cargo);

                        $sheet->setCellValue('C' . 81 + $filas_equipo + $i, $key->getAttributes()['plan_accion_numero']);
                        $sheet->setCellValue('E' . 81 + $filas_equipo + $i, $key->getAttributes()['plan_accion_actividad']);
                        $sheet->setCellValue('O' . 81 + $filas_equipo + $i, $key->getAttributes()['plan_accion_responsable']);
                        $fecha_tarea = new DateTime($key->getAttributes()['plan_accion_fecha_tarea']);
                        $fecha_tarea = $fecha_tarea->format('d-m-Y');
                        $sheet->setCellValue('S' . 81 + $filas_equipo + $i, $fecha_tarea);
                        $i++;
                    }
                }

                $i = 0;
                $registro_seguimiento_reporte = Seguimiento_reporte_no_conformidades::where('fk_id_reporte_conform', $value['id_reporte_conform'])->get();

                if (count($registro_seguimiento_reporte) !== 0) {
                    $filas_seguimiento = count($registro_seguimiento_reporte) - 1;
                } else {
                    $filas_seguimiento = count($registro_seguimiento_reporte);
                }

                if (count($registro_seguimiento_reporte) !== 0) {
                    if (count($registro_seguimiento_reporte) !== 1) {
                        $sheet->insertNewRowBefore(85 + $filas_equipo + $filas_plan_accion, $filas_seguimiento);
                    }

                    foreach ($registro_seguimiento_reporte as $key) {
                        $infoPersonSegReporte = PanelEmpleados::getEmpleadoInfo($key->getAttributes()['seguimiento_responsable']);
                        $sheet->mergeCells('C' . 85 + $filas_equipo + $filas_plan_accion + $i . ':' . 'E' . 85 + $filas_equipo + $filas_plan_accion + $i);
                        $sheet->mergeCells('G' . 85 + $filas_equipo + $filas_plan_accion + $i . ':' . 'L' . 85 + $filas_equipo + $filas_plan_accion + $i);
                        $sheet->mergeCells('M' . 85 + $filas_equipo + $filas_plan_accion + $i . ':' . 'R' . 85 + $filas_equipo + $filas_plan_accion + $i);
                        $sheet->mergeCells('S' . 85 + $filas_equipo + $filas_plan_accion + $i . ':' . 'V' . 85 + $filas_equipo + $filas_plan_accion + $i);
                        $key->setAttribute('seguimiento_responsable', $infoPersonSegReporte[0]->nombre);
                        $key->setAttribute('seguimiento_cargo_responsable', $infoPersonSegReporte[0]->cargo);
                        $fecha_segui = new DateTime($key->getAttributes()['seguimiento_plan_fecha']);
                        $fecha_segui = $fecha_segui->format('d-m-Y');
                        $sheet->setCellValue('C' . 85 + $filas_equipo + $filas_plan_accion + $i, $fecha_segui);
                        $sheet->setCellValue('F' . 85 + $filas_equipo + $filas_plan_accion + $i, $key->getAttributes()['seguimiento_numero']);
                        $sheet->setCellValue('G' . 85 + $filas_equipo + $filas_plan_accion + $i, $key->getAttributes()['seguimiento_actividad_tarea']);
                        $sheet->setCellValue('M' . 85 + $filas_equipo + $filas_plan_accion + $i, $key->getAttributes()['seguimiento_compromisos']);
                        $sheet->setCellValue('S' . 85 + $filas_equipo + $filas_plan_accion + $i, $key->getAttributes()['seguimiento_responsable']);
                        $i++;
                    }
                }

                $i = 0;
                $registro_verifi_imp_reporte = Verificacion_imp_reporte_no_conformidades::where('fk_id_reporte_conform', $value['id_reporte_conform'])->get();

                if (count($registro_verifi_imp_reporte) !== 0) {
                    $filas_verifi_correctivo = count($registro_verifi_imp_reporte) - 1;
                } else {
                    $filas_verifi_correctivo = count($registro_verifi_imp_reporte);
                }

                if (count($registro_verifi_imp_reporte) !== 1) {
                    $sheet->insertNewRowBefore(89 + $filas_equipo + $filas_plan_accion + $filas_seguimiento, $filas_verifi_correctivo);
                }
                foreach ($registro_verifi_imp_reporte as $key) {

                    $infoPersonSegReporte = PanelEmpleados::getEmpleadoInfo($key->getAttributes()['verifi_imple_respon']);
                    $sheet->mergeCells('C' . 89 + $filas_equipo + $filas_plan_accion + $filas_seguimiento + $i . ':' . 'E' . 89 + $filas_equipo + $filas_plan_accion + $filas_seguimiento + $i);
                    $sheet->mergeCells('F' . 89 + $filas_equipo + $filas_plan_accion + $filas_seguimiento + $i . ':' . 'M' . 89 + $filas_equipo + $filas_plan_accion + $filas_seguimiento + $i);
                    $sheet->mergeCells('N' . 89 + $filas_equipo + $filas_plan_accion + $filas_seguimiento + $i . ':' . 'R' . 89 + $filas_equipo + $filas_plan_accion + $filas_seguimiento + $i);
                    $sheet->mergeCells('S' . 89 + $filas_equipo + $filas_plan_accion + $filas_seguimiento + $i . ':' . 'V' . 89 + $filas_equipo + $filas_plan_accion + $filas_seguimiento + $i);
                    $key->setAttribute('verifi_imple_respon', $infoPersonSegReporte[0]->nombre);
                    $key->setAttribute('verifi_imple_cargo_respon', $infoPersonSegReporte[0]->cargo);
                    $fecha_veri_imp = new DateTime($key->getAttributes()['verifica_implementacion_fecha']);
                    $fecha_veri_imp = $fecha_veri_imp->format('d-m-Y');
                    $sheet->setCellValue('C' . 89 + $filas_equipo + $filas_plan_accion + $filas_seguimiento + $i, $fecha_veri_imp);
                    $sheet->setCellValue('F' . 89 + $filas_equipo + $filas_plan_accion + $filas_seguimiento + $i, $key->getAttributes()['verifica_implementacion_observa']);
                    $sheet->setCellValue('N' . 89 + $filas_equipo + $filas_plan_accion + $filas_seguimiento + $i, $key->getAttributes()['verifi_imple_respon']);
                    $sheet->setCellValue('S' . 89 + $filas_equipo + $filas_plan_accion + $filas_seguimiento + $i, $key->getAttributes()['verifi_imple_cargo_respon']);
                    $i++;
                }

                $sheet->setCellValue('G' . 93 + $filas_equipo + $filas_plan_accion + $filas_seguimiento + $filas_verifi_correctivo, $registro_reporte->prog_cierre_fecha->format('d-m-Y'));
                $sheet->setCellValue('K' . 93 + $filas_equipo + $filas_plan_accion + $filas_seguimiento + $filas_verifi_correctivo, $registro_reporte->prog_cierre_responsable);
                $sheet->setCellValue('G' . 94 + $filas_equipo + $filas_plan_accion + $filas_seguimiento + $filas_verifi_correctivo, $registro_reporte->cierre_real_fecha->format('d-m-Y'));
                $sheet->setCellValue('K' . 94 + $filas_equipo + $filas_plan_accion + $filas_seguimiento + $filas_verifi_correctivo, $registro_reporte->cierre_real_responsable);

                // Guardar el archivo Excel modificado
                $writer = new Xlsx($spreadsheet);
                $nombreArchivo = $registro_reporte->id_reporte_conform . '.xlsx';
                $writer->save(storage_path('app/public/Reportes/' . $nombreArchivo));
                $zip->addFile(storage_path('app/public/Reportes/' . $nombreArchivo), $nombreArchivo);

            }

            $zip->close();
        }
        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }

    public function updateReporteNoConf(Request $request)
    {
        //Obtener la información enviada
        $user = Session::get('user');
        $DatosUsuario = PanelLogin::getUsuario($user);
        $id_reporte_conform = $request->input('id_reporte_conform');
        $sistema_de_gestion = $request->input('sistema_gest ion');
        $ciclo_auditoria = $request->input('ciclo_auditoria');
        $fecha_auditoria = $request->input('fecha_auditoria');
        $lugar = $request->input('lugar_reporte');
        $fecha_elaboracion = $request->input('fecha_elaboracion');

        $fuente_no_conforme = $request->input('fuente_razon');
        if ($fuente_no_conforme === 'otro') {
            $fuente_no_conforme = $request->input('fuente_otro');
        };
        $proceso_no_conforme = $request->input('proceso_no_conforme');
        $nombre_reporte_proceso = $request->input('nombre_proceso_reporta');
        $tipo_proceso_no_conforme = $request->input('tipo_no_conformidad');
        $descripcion_no_conformidad = $request->input('descrip_no_corformidad');
        $responsable_no_conformidad = $request->input('responsable_no_conformidad');

        $impacto_no_conformidad = $request->input('impacto_no_conformidad');
        $analisis_mano_de_obra = $request->input('mano_de_obra');
        $analisis_maquinaria = $request->input('maquinaria');
        $analisis_metodo = $request->input('metodo');
        $analisis_materiales = $request->input('materiales');
        $analisis_medio_ambiente = $request->input('medio_ambiente');
        $analisis_otros_factores = $request->input('otros_factores');

        //Otra tabla
        $verifica_implementacion_fecha = $request->input('verifica_implementacion_fecha');
        $verifica_implementacion_observa = $request->input('verifica_implementacion_observa');
        $verifica_implementacion_responsable = $request->input('verifica_implementacion_responsable');
        $verifica_imple_archivos = $request->file('verifica_imple_archivos');

        $prog_cierre_fecha = $request->input('prog_cierre_fecha');
        $prog_cierre_responsable = $request->input('prog_cierre_responsable');
        $cierre_real_fecha = $request->input('cierre_real_fecha');
        $cierre_real_responsable = $request->input('cierre_real_responsable');

        //Otra tabla
        $persona_equipo_trabajo = $request->input('persona_equipo');

        //Otra tabla
        $plan_accion_numero = $request->input('plan_accion_n#');
        $plan_accion_actividad = $request->input('plan_accion_actividad');
        $plan_accion_responsable = $request->input('plan_accion_responsable');
        $plan_accion_fecha_tarea = $request->input('plan_accion_fecha_tarea');

        //Otra tabla
        $seguimiento_plan_fecha = $request->input('seguimiento_plan_fecha');
        $seguimiento_numero = $request->input('seguimiento_plan_n#');
        $seguimiento_actividad_tarea = $request->input('seguimiento_plan_descrip');
        $seguimiento_compromisos = $request->input('seguimiento_plan_compromisos');
        $seguimiento_responsable = $request->input('seguimiento_plan_responsable');
        $segui_plan_archivos = $request->file('segui_plan_archivos');

        $tabla1 = [
            'sistema_de_gestion' => $sistema_de_gestion,
            'ciclo_auditoria' => $ciclo_auditoria,
            'fecha_auditoria' => $fecha_auditoria,
            'lugar' => $lugar,
            'fecha_elaboracion' => $fecha_elaboracion,
            'fuente_no_conforme' => $fuente_no_conforme,
            'proceso_no_conforme' => $proceso_no_conforme,
            'nombre_reporte_proceso' => $nombre_reporte_proceso,
            'tipo_proceso_no_conforme' => $tipo_proceso_no_conforme,
            'descripcion_no_conformidad' => $descripcion_no_conformidad,
            'impacto_no_conformidad' => $impacto_no_conformidad,
            'analisis_mano_de_obra' => $analisis_mano_de_obra,
            'analisis_maquinaria' => $analisis_maquinaria,
            'analisis_metodo' => $analisis_metodo,
            'analisis_materiales' => $analisis_materiales,
            'analisis_medio_ambiente' => $analisis_medio_ambiente,
            'analisis_otros_factores' => $analisis_otros_factores,
            'prog_cierre_fecha' => $prog_cierre_fecha,
            'prog_cierre_responsable' => $prog_cierre_responsable,
            'cierre_real_fecha' => $cierre_real_fecha,
            'cierre_real_responsable' => $cierre_real_responsable,
        ];

        Reporte_no_conformidades::where('id_reporte_conform', $id_reporte_conform)->update($tabla1);

        if ($persona_equipo_trabajo[0] !== null) {
            $registro_equipo_reporte = Equipo_trabajo_reporte_no_conformidades::where('fk_id_reporte_conform', $id_reporte_conform)->get();
            foreach ($persona_equipo_trabajo as $posicion => $persona) {

                Equipo_trabajo_reporte_no_conformidades::where('id_equipo_trabajo_reporte_no_conformidades', $registro_equipo_reporte[$posicion]->id_equipo_trabajo_reporte_no_conformidades)->update([
                    'persona_equipo_trabajo' => $persona,
                ]);

            }
        }

        if ($plan_accion_numero[0] !== null) {
            $registro_plan_accion_reporte = Plan_accion_reporte_no_conformidades::where('fk_id_reporte_conform', $id_reporte_conform)->get();
            foreach ($plan_accion_numero as $posicion => $value) {
                $tabla2 = [
                    'plan_accion_numero' => $value,
                    'plan_accion_actividad' => $plan_accion_actividad[$posicion],
                    'plan_accion_responsable' => $plan_accion_responsable[$posicion],
                    'plan_accion_fecha_tarea' => $plan_accion_fecha_tarea[$posicion],
                ];
                Plan_accion_reporte_no_conformidades::where('id_plan_accion_reporte_no_conformidades', $registro_plan_accion_reporte[$posicion]->id_plan_accion_reporte_no_conformidades)->update(
                    $tabla2
                );
            }
        }

        if ($seguimiento_plan_fecha[0] !== null) {
            $registro_seguimiento_reporte = Seguimiento_reporte_no_conformidades::where('fk_id_reporte_conform', $id_reporte_conform)->get();
            foreach ($seguimiento_plan_fecha as $posicion => $value) {

                if (isset($segui_plan_archivos[$posicion])) {
                    $ruta = substr(public_path(), 0, -14) . 'public/archivos/Reporte/Seguimiento/' . $id_reporte_conform . '/';
                    $extension = $segui_plan_archivos[$posicion]->getClientOriginalExtension();
                    $nombreOriginal = $segui_plan_archivos[$posicion]->getClientOriginalName();
                    $nombreArchivo = 'Archivo-Seguimiento-' . $nombreOriginal . '-' . $id_reporte_conform . '.' . $extension;
                    $segui_plan_archivos[$posicion]->move($ruta, $nombreArchivo);
                    $segui_plan_archivos[$posicion] = $nombreArchivo;
                }

                $tabla3 = [
                    'seguimiento_plan_fecha' => $value,
                    'seguimiento_numero' => $seguimiento_numero[$posicion],
                    'seguimiento_actividad_tarea' => $seguimiento_actividad_tarea[$posicion],
                    'seguimiento_compromisos' => $seguimiento_compromisos[$posicion],
                    'seguimiento_responsable' => $seguimiento_responsable[$posicion],
                    'segui_plan_archivos' => $segui_plan_archivos[$posicion] ?? $registro_seguimiento_reporte[$posicion]['segui_plan_archivos'],
                ];
                Seguimiento_reporte_no_conformidades::where('id_segui_reporte_no_conformidades', $registro_seguimiento_reporte[$posicion]->id_segui_reporte_no_conformidades)->update(
                    $tabla3
                );
            }

        }
        $registro_verifi_reporte = Verificacion_imp_reporte_no_conformidades::where('fk_id_reporte_conform', $id_reporte_conform)->get();
        foreach ($verifica_implementacion_responsable as $posicion => $value) {
            if (isset($verifica_imple_archivos[$posicion])) {
                $ruta = substr(public_path(), 0, -14) . 'public/archivos/Reporte/Verificacion/' . $id_reporte_conform . '/';
                $extension = $verifica_imple_archivos[$posicion]->getClientOriginalExtension();
                $nombreOriginal = $verifica_imple_archivos[$posicion]->getClientOriginalName();
                $nombreArchivo = 'Archivo-Verificacion-' . $nombreOriginal . '-' . $id_reporte_conform . '.' . $extension;
                $verifica_imple_archivos[$posicion]->move($ruta, $nombreArchivo);
                $verifica_imple_archivos[$posicion] = $nombreArchivo;
            }

            $tabla4 = [
                'verifica_implementacion_fecha' => $verifica_implementacion_fecha[$posicion],
                'verifica_implementacion_observa' => $verifica_implementacion_observa[$posicion],
                'verifi_imple_respon' => $value,
                'verifica_imple_archivos' => $verifica_imple_archivos[$posicion] ?? $registro_verifi_reporte[$posicion]['verifica_imple_archivos'],
            ];
            Verificacion_imp_reporte_no_conformidades::where('id_verificacion_imp_reporte_no_conformidades', $registro_verifi_reporte[$posicion]->id_verificacion_imp_reporte_no_conformidades)->update(
                $tabla4
            );
        }

        toastr()->success('¡Reporte de accion o mejora continua actualizado exitosamente!', '¡Actualización exitosa!', ['positionClass' => 'toast-bottom-right']);
        return back();
    }

    public function archivoSeguiRepor($id, $rutaArchivo)
    {
        $ruta = substr(public_path(), 0, -14) . 'public/archivos/Reporte/Seguimiento/' . $id . '/';
        $rutaCompleta = $ruta . $rutaArchivo;

        if (file_exists($rutaCompleta)) {
            return response()->download($rutaCompleta);
        } else {
            abort(404);
        }
    }

    public function archivoVeriRepor($id, $rutaArchivo)
    {
        $ruta = substr(public_path(), 0, -14) . 'public/archivos/Reporte/Verificacion/' . $id . '/';
        $rutaCompleta = $ruta . $rutaArchivo;

        if (file_exists($rutaCompleta)) {
            return response()->download($rutaCompleta);
        } else {
            abort(404);
        }
    }

    public function descargaReporteDbExcel(Request $request)
    {
        $fecha_ini = $request->input('fecha_ini_repor');
        $fecha_final = $request->input('fecha_final_repor');

        $query = DB::table('get_reportes');

        if ($fecha_ini !== null && $fecha_final !== null) {
            $query->whereBetween('fecha_elaboracion', [$fecha_ini, $fecha_final]);
        }

        if ($fecha_ini !== null && $fecha_final === null) {
            $query->where('fecha_elaboracion', '>=', $fecha_ini);
        }

        $reportes = $query->get();
        return Excel::download(new ReporteExport($reportes), 'reportes_no_conformidad.xlsx');
    }

}
