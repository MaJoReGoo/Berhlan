<?php

namespace App\Http\Controllers\Inconformidades;

use App\Http\Controllers\Controller;
use App\Models\Inconformidad\McTrataInme;
use App\Models\Inconformidad\McTratamiento;
use App\Models\Inconformidad\McTratamientoPerson;
use App\Models\PanelLogin;
use App\Models\Parametrizacion\PanelAreas;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Reporte_no_conformidad\Reporte_no_conformidades;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TratamientoExport;
use Illuminate\Support\Facades\DB;
use ZipArchive;

class InconformidadesTratamientoController extends Controller
{
    public function showIngresarTramiento()
    {

        if (Session::has('user')) {
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "noconformidades/tratamiento";
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
            $Empleados = PanelEmpleados::EmpleadosWithCargoActivos();
            $areas = PanelAreas::getAreasPorEmpresa('1');
            $maxId = McTratamiento::selectRaw('MAX(CAST(SUBSTRING_INDEX(id_tratamiento,"-", 1) AS UNSIGNED)) AS id')->first()->id;
            $nuevoId = ($maxId) ? $maxId + 1 : 1;
            return view('inconformidades.panelCrearTratamiento')->with(['DatosUsuario' => $DatosUsuario, 'Empleados' => $Empleados, 'areas' => $areas, 'nuevoId' => $nuevoId]);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }

    }

    public function insertarTratamientoNoConf(Request $request)
    {

        $user = Session::get('user');
        $DatosUsuario = PanelLogin::getUsuario($user);
        $fecha_diligencia_trata = $request->input('fecha_diligencia_trata');
        $lugar_trata = $request->input('lugar_trata');
        $proceso_rela_trata = $request->input('proceso_rela_trata');
        $inconfor_trata = $request->input('inconfor_trata');
        $descripcion_trata = $request->input('descripcion_trata');
        $detectado_persona = $request->input('detectado_persona');
        $fecha_evento_trata = $request->input('fecha_evento_trata');

        //otra tabla
        $responsable_trata = $request->input('responsable_trata');
        //
        $fecha_esti_trata = $request->input('fecha_esti_trata');

        $tratamiento = collect($request->all())->filter(function ($value, $key) {
            return str_starts_with($key, 'tratamiento');
        })->values();
        $descripcion_inme_trata = $request->input('descripcion_inme_trata');
        $persona_trata = $request->input('persona_trata');

        $caracte_no_conformidad = $request->input('caracte_no_conformidad');
        $nivel_conformidad = $request->input('nivel_conformidad');
        $fecha_veri_cierre = $request->input('fecha_veri_cierre');
        $veri_cierre_responsable = $request->input('veri_cierre_responsable');
        $eficaz_tratamiento = $request->input('eficaz_tratamiento');
        $conclusion_final = $request->input('conclusion_final');
        $evidencia_aplica = $request->input('evidencia_aplica');
        $nuevoId = $request->input('nuevoId');

        $id_tratamiento = $nuevoId . '-' . $fecha_diligencia_trata;

        $datos = [
            'id_tratamiento' => $id_tratamiento,
            'fecha_diligencia_trata' => $fecha_diligencia_trata,
            'lugar_trata' => $lugar_trata,
            'proceso_rela_trata' => $proceso_rela_trata,
            'inconfor_trata' => $inconfor_trata,
            'descripcion_trata' => $descripcion_trata,
            'detectado_persona' => $detectado_persona,
            'fecha_evento_trata' => $fecha_evento_trata,
            'fecha_esti_trata' => $fecha_esti_trata,
            'caracte_no_conformidad' => $caracte_no_conformidad,
            'nivel_conformidad' => $nivel_conformidad,
            'fecha_veri_cierre' => $fecha_veri_cierre,
            'veri_cierre_responsable' => $veri_cierre_responsable,
            'eficaz_tratamiento' => $eficaz_tratamiento,
            'conclusion_final' => $conclusion_final,
        ];

        $uploader = $request->input('uploader');
        if ($uploader != '') {
            $evidencia_si_aplica = $request->file('evidencia_aplica');
            $ruta = substr(public_path(), 0, -14) . 'public/archivos/Inconformidades/tratamiento_no_conformidad/';
            $extension = $evidencia_si_aplica->getClientOriginalExtension();
            $nombreArchivo = $id_tratamiento . '.' . $extension;
            $evidencia_si_aplica->move($ruta, $nombreArchivo);
            $datos += ['evidencia_si_aplica' => $nombreArchivo];
        };

        McTratamiento::create($datos);

        foreach ($responsable_trata as $key => $value) {

            McTratamientoPerson::create([
                'responsable_trata' => $value,
                'fk_id_trata' => $id_tratamiento,
            ]);
            if ($key > 0) {
                $infoResTrata = PanelEmpleados::getEmpleado($value);
                $infoResponsable = PanelEmpleados::getEmpleadoInfo($responsable_trata[0]);
                $dataCorreo['email'] = $infoResTrata[0]->correo;
                $dataCorreo['planta'] = strtoupper($lugar_trata);
                $dataCorreo['fecha_diligenciada'] = $fecha_diligencia_trata;
                $dataCorreo['area'] = PanelAreas::getArea($proceso_rela_trata)[0]->descripcion;
                $dataCorreo['responsable'] = $infoResponsable[0]->nombre;
                $dataCorreo['cargo'] = $infoResponsable[0]->cargo;
                $dataCorreo['url_tratamiento'] = env('APP_URL') . '/Berhlan/public/panel/noconformidades/completar_tratamiento/' . $id_tratamiento;

                Mail::send('email.email_mejora_continua.notificacion_tratamiento', $dataCorreo, function ($message) use ($dataCorreo) {
                    $message->subject('Notificaciones Intranet');
                    $message->from('notificacionesberhlan@berhlan.com');
                    $message->to($dataCorreo['email']);
                });
            }
        }

        foreach ($tratamiento as $key => $value) {
            McTrataInme::create([
                'tratamiento' => $value,
                'descripcion_inme_trata' => $descripcion_inme_trata[$key],
                'persona_trata' => $persona_trata[$key],
                'fk_id_trata' => $id_tratamiento,
            ]);
        }

        $areas = PanelAreas::getAreasPorEmpresa('1');
        toastr()->success('¡Tratamiento de inconformidad creado exitosamente!', '¡Creación exitosa!', ['positionClass' => 'toast-bottom-right']);
        $Empleados = PanelEmpleados::EmpleadosWithCargoActivos();
        $maxId = McTratamiento::selectRaw('MAX(CAST(SUBSTRING_INDEX(id_tratamiento,"-", 1) AS UNSIGNED)) AS id')->first()->id;
        $nuevoId = ($maxId) ? $maxId + 1 : 1;
        return view('inconformidades.panelCrearTratamiento')->with(['DatosUsuario' => $DatosUsuario, 'Empleados' => $Empleados, 'areas' => $areas, 'nuevoId' => $nuevoId]);
    }

    public function showCompletarTratamientoNoConf($id)
    {
        $user = Session::get('user');
        $DatosUsuario = PanelLogin::getUsuario($user);
        $registro_tratamiento = McTratamiento::find($id);
        $infoDetectado = PanelEmpleados::getEmpleadoInfo($registro_tratamiento->detectado_persona);
        $registro_tratamiento['detectado_persona_name'] = $infoDetectado[0]->nombre;
        $registro_tratamiento['cargo_detectado_persona'] = $infoDetectado[0]->cargo;
        $infoVeriCierreRespon = PanelEmpleados::getEmpleadoInfo($registro_tratamiento->veri_cierre_responsable);
        $registro_tratamiento['veri_cierre_responsable_name'] = $infoVeriCierreRespon[0]->nombre;
        $registro_tratamiento['cargo_veri_cierre_responsable'] = $infoVeriCierreRespon[0]->cargo;
        $registro_tratamiento_persons = McTratamientoPerson::where('fk_id_trata', $id)->get();
        foreach ($registro_tratamiento_persons as $key) {
            $infoResTrata = PanelEmpleados::getEmpleadoInfo($key->getAttributes()['responsable_trata']);
            $key->setAttribute('responsable_tratamiento_name', $infoResTrata[0]->nombre);
            $key->setAttribute('cargo_responsable_tratamiento', $infoResTrata[0]->cargo);
        }
        $registro_tratamiento_inme = McTrataInme::where('fk_id_trata', $id)->get();
        $Empleados = PanelEmpleados::EmpleadosWithCargoActivos();
        $areas = PanelAreas::getAreasPorEmpresa('1');

        return view('inconformidades.panelDiligenciarTrata')->with(['DatosUsuario' => $DatosUsuario, 'registro_tratamiento' => $registro_tratamiento, 'registro_tratamiento_persons' => $registro_tratamiento_persons, 'Empleados' => $Empleados, 'areas' => $areas, 'registro_tratamiento_inme' => $registro_tratamiento_inme]);
    }

    public function completarTratamientoNoConf(Request $request)
    {

        $id_tratamiento = $request->input('id_tratamiento');
        $descripcion_inme_trata = $request->input('descripcion_inme_trata');
        $persona_trata = $request->input('persona_trata');
        $registro_tratamiento_inme = McTrataInme::where('fk_id_trata', $id_tratamiento)->get();

        foreach ($registro_tratamiento_inme as $key => $value) {
            McTrataInme::where('fk_id_trata', $id_tratamiento)->where('id', $registro_tratamiento_inme[$key]->id)->update([
                'descripcion_inme_trata' => $descripcion_inme_trata[$key],
                'persona_trata' => $persona_trata[$key],
            ]);
        }

        toastr()->success('¡Diligenciamiento exitoso del tratamiento de no conformidad!', '¡Creación exitosa!', ['positionClass' => 'toast-bottom-right']);
        return redirect()->back();
    }

    public function showParametrosConsultar()
    {
        if (Session::has('user')) {
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "noconformidades/consultar";
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
            return view('inconformidades.panelParametrosNoConformidad')->with('DatosUsuario', $DatosUsuario)->with('areas', $areas);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function searchTrataNoConf(request $request)
    {
        $user = Session::get('user');
        $DatosUsuario = PanelLogin::getUsuario($user);
        $descripcion_trata = $request->input('descripcion_trata');
        $fecha_ini = $request->input('fecha_ini_trata');
        $fecha_final = $request->input('fecha_final_trata');
        $inconfor_trata = $request->input('inconfor_trata');
        $proceso_rela_trata = $request->input('proceso_rela_trata');

        $sql = McTratamiento::query();

        if ($descripcion_trata !== null) {
            $sql->where('descripcion_trata', 'LIKE', '%' . $descripcion_trata . '%');
        }

        if ($fecha_ini !== null && $fecha_final !== null) {
            $sql->whereBetween('fecha_diligencia_trata', [$fecha_ini, $fecha_final]);
        }
        if ($fecha_ini !== null) {
            $sql->where('fecha_diligencia_trata', '>', $fecha_ini);
        }

        if ($inconfor_trata !== null) {
            $sql->where('inconfor_trata', $inconfor_trata);
        }

        if ($proceso_rela_trata !== null) {
            $sql->where('proceso_rela_trata', '=', $proceso_rela_trata);
        }

        $registrosTratamiento = $sql->get();

        if (count($registrosTratamiento) !== 0) {
            foreach ($registrosTratamiento as $key) {
                $infoDetectado = PanelEmpleados::getEmpleadoInfo($key->getAttributes()['detectado_persona']);
                $key->setAttribute('detectado_persona', $infoDetectado[0]->nombre);
                $area = PanelAreas::getArea($key->getAttributes()['proceso_rela_trata']);
                $key->setAttribute('proceso_rela_trata', $area[0]->descripcion);
            }
            return view('inconformidades.panelConsultarInformesNoConformidad')->with(['DatosUsuario' => $DatosUsuario, 'RegistrosTratamiento' => $registrosTratamiento]);
        } else {
            toastr()->warning('¡No se han encontrado registros en busqueda!', '¡Advertencia!', ['positionClass' => 'toast-bottom-right']);
            return redirect()->route('showParametrosConsultar');
        }

    }

    public function showTrataNoConformidad($id)
    {
        $user = Session::get('user');
        $DatosUsuario = PanelLogin::getUsuario($user);
        $empleado = PanelEmpleados::getEmpleadoInfo($DatosUsuario[0]->empleado);
        $registro_tratamiento = McTratamiento::find($id);
        $infoDetectado = PanelEmpleados::getEmpleadoInfo($registro_tratamiento->detectado_persona);
        $registro_tratamiento['detectado_persona_name'] = $infoDetectado[0]->nombre;
        $registro_tratamiento['cargo_detectado_persona'] = $infoDetectado[0]->cargo;
        $infoVeriCierreRespon = PanelEmpleados::getEmpleadoInfo($registro_tratamiento->veri_cierre_responsable);
        $registro_tratamiento['veri_cierre_responsable_name'] = $infoVeriCierreRespon[0]->nombre;
        $registro_tratamiento['cargo_veri_cierre_responsable'] = $infoVeriCierreRespon[0]->cargo;
        $registro_tratamiento_persons = McTratamientoPerson::where('fk_id_trata', $id)->get();
        foreach ($registro_tratamiento_persons as $key) {
            $infoResTrata = PanelEmpleados::getEmpleadoInfo($key->getAttributes()['responsable_trata']);
            $key->setAttribute('responsable_tratamiento_name', $infoResTrata[0]->nombre);
            $key->setAttribute('cargo_responsable_tratamiento', $infoResTrata[0]->cargo);
        }
        $registro_tratamiento_inme = McTrataInme::where('fk_id_trata', $id)->get();
        $Empleados = PanelEmpleados::EmpleadosWithCargoActivos();
        $areas = PanelAreas::getAreasPorEmpresa('1');
        return view('inconformidades.panelVerTratamientoNoConformidad')->with(['DatosUsuario' => $DatosUsuario, 'registro_tratamiento' => $registro_tratamiento, 'registro_tratamiento_persons' => $registro_tratamiento_persons, 'Empleados' => $Empleados, 'areas' => $areas, 'registro_tratamiento_inme' => $registro_tratamiento_inme, 'empleado'=>$empleado]);

    }

    public function documentWord($id)
    {
        $plantilla = storage_path('app/templates/F-AC-01-20_FORMATO_TRATAMIENTO_NO_CONFORMIDADES.xlsx');
        $spreadsheet = IOFactory::load($plantilla);
        $sheet = $spreadsheet->getActiveSheet();

        $info_tratamiento = McTratamiento::find($id);
        $infoDetectado = PanelEmpleados::getEmpleadoInfo($info_tratamiento->detectado_persona);
        $info_tratamiento['detectado_persona_name'] = $infoDetectado[0]->nombre;
        $info_tratamiento['cargo_detectado_persona'] = $infoDetectado[0]->cargo;
        $info_tratamiento['proceso_rela_trata'] = PanelAreas::getArea($info_tratamiento['proceso_rela_trata'])[0]->descripcion;
        $infoVeriCierreRespon = PanelEmpleados::getEmpleadoInfo($info_tratamiento->veri_cierre_responsable);
        $info_tratamiento['veri_cierre_responsable_name'] = $infoVeriCierreRespon[0]->nombre;
        $info_tratamiento['cargo_veri_cierre_responsable'] = $infoVeriCierreRespon[0]->cargo;

        $info_tratamiento_persons = McTratamientoPerson::where('fk_id_trata', $id)->get();

        $info_tratamiento_inme = McTrataInme::where('fk_id_trata', $id)->get();

        foreach ($info_tratamiento_persons as $key) {
            $infoResTrata = PanelEmpleados::getEmpleadoInfo($key->getAttributes()['responsable_trata']);
            $key->setAttribute('responsable_tratamiento_name', $infoResTrata[0]->nombre);
            $key->setAttribute('cargo_responsable_tratamiento', $infoResTrata[0]->cargo);
        }

        $sheet->setCellValue('F7', explode(" ", $info_tratamiento->fecha_diligencia_trata->format('d-m-Y'))[0]);
        $sheet->setCellValue('K7', $info_tratamiento->lugar_trata);
        $sheet->setCellValue('S7', $info_tratamiento->proceso_rela_trata);

        if ($info_tratamiento->inconfor_trata === "producto") {
            $sheet->setCellValue('F10', 'X');
        } else if ($info_tratamiento->inconfor_trata === "proceso relacionado") {
            $sheet->setCellValue('K10', 'X');
        } else if ($info_tratamiento->inconfor_trata === "otro") {
            $sheet->setCellValue('R10', 'X');
        }

        $sheet->setCellValue('C13', $info_tratamiento->descripcion_trata);

        $sheet->setCellValue('C21', ' Nombre:' . $info_tratamiento->detectado_persona_name);
        $sheet->setCellValue('C22', ' Cargo:' . $info_tratamiento->cargo_detectado_persona);
        $sheet->setCellValue('C24', ' Fecha: ' . explode(" ", $info_tratamiento->fecha_evento_trata->format('d-m-Y'))[0]);
        $personas;
        foreach ($info_tratamiento_persons as $key => $value) {
            if ($key === 0) {
                $personas = ' Nombre: ';
            }
            if ($key === 3) {
                $personas .= $value->responsable_tratamiento_name;
            } else {

                if (count($info_tratamiento_persons) === 1) {
                    $personas .= $value->responsable_tratamiento_name;
                } else {
                    $personas .= $value->responsable_tratamiento_name . ' - ';
                }

            }
        }

        $sheet->setCellValue('M21', $personas);

        $cargos;

        foreach ($info_tratamiento_persons as $key => $value) {
            if ($key === 0) {
                $cargos = ' Cargo: ';
            }
            if ($key === 3) {
                $cargos .= $value->cargo_responsable_tratamiento;
            } else {
                if (count($info_tratamiento_persons) === 1) {
                    $cargos .= $value->cargo_responsable_tratamiento;
                } else {
                    $cargos .= $value->cargo_responsable_tratamiento . ' - ';
                }

            }
        }

        $sheet->setCellValue('M22', $cargos);

        $sheet->setCellValue('M24', ' Fecha: ' . explode(" ", $info_tratamiento->fecha_esti_trata->format('d-m-Y'))[0]);

        if ($info_tratamiento_inme[0]->descripcion_inme_trata !== null) {
            $content = " ";
            foreach ($info_tratamiento_inme as $key => $value) {

                if ($value->tratamiento === "Reproceso") {
                    $sheet->setCellValue('G27', 'X');
                } else if ($value->tratamiento === "Reclasificacion") {
                    $sheet->setCellValue('K27', 'X');
                } else if ($value->tratamiento === "Rechazo") {
                    $sheet->setCellValue('N27', 'X');
                } else if ($value->tratamiento === "Derogacion") {
                    $sheet->setCellValue('T27', 'X');
                } else {
                    $sheet->setCellValue('U27', ' Otro:' . 'X');
                }

                $value->persona_trata = PanelEmpleados::getEmpleadoInfo($value->persona_trata)[0]->nombre;

                $content .= "• " . $value->tratamiento . ' - ' . $value->descripcion_inme_trata . ' - ' . $value->persona_trata . "\n";
            }

            $sheet->setCellValue('C29', $content);
        }

        //BAJO
        if ($sheet->getCell('S47')->getValue() === $info_tratamiento->caracte_no_conformidad) {
            $sheet->setCellValue('S47', $info_tratamiento->caracte_no_conformidad . ' X ');
        } else if ($sheet->getCell('S51')->getValue() === $info_tratamiento->caracte_no_conformidad) {
            $sheet->setCellValue('S51', $info_tratamiento->caracte_no_conformidad . ' X ');
        } else if ($info_tratamiento->nivel_conformidad === 'otro_bajo') {
            $sheet->setCellValue('S54', "OTRO: " . $info_tratamiento->caracte_no_conformidad);
        }
        //
        //MEDIO
        if ($sheet->getCell('D47')->getValue() === $info_tratamiento->caracte_no_conformidad) {
            $sheet->setCellValue('D47', $info_tratamiento->caracte_no_conformidad . ' X ');
        } else if ($sheet->getCell('D51')->getValue() === $info_tratamiento->caracte_no_conformidad) {
            $sheet->setCellValue('D51', $info_tratamiento->caracte_no_conformidad . ' X ');
        } else if ($sheet->getCell('D54')->getValue() === $info_tratamiento->caracte_no_conformidad) {
            $sheet->setCellValue('D54', $info_tratamiento->caracte_no_conformidad . ' X ');
        } else if ($sheet->getCell('D59')->getValue() === $info_tratamiento->caracte_no_conformidad) {
            $sheet->setCellValue('D59', $info_tratamiento->caracte_no_conformidad . ' X ');
        } else if ($sheet->getCell('D62')->getValue() === $info_tratamiento->caracte_no_conformidad) {
            $sheet->setCellValue('D62', $info_tratamiento->caracte_no_conformidad . ' X ');
        } else if ($sheet->getCell('D65')->getValue() === $info_tratamiento->caracte_no_conformidad) {
            $sheet->setCellValue('D65', $info_tratamiento->caracte_no_conformidad . ' X ');
        } else if ($sheet->getCell('D69')->getValue() === $info_tratamiento->caracte_no_conformidad) {
            $sheet->setCellValue('D69', $info_tratamiento->caracte_no_conformidad . ' X ');
        } else if ($info_tratamiento->nivel_conformidad === 'otro_medio') {
            $sheet->setCellValue('D73', "OTRO: " . $info_tratamiento->caracte_no_conformidad);
        }
        //

        //Alto
        if ($sheet->getCell('I47')->getValue() === $info_tratamiento->caracte_no_conformidad) {
            $sheet->setCellValue('I47', $info_tratamiento->caracte_no_conformidad . ' X ');
        } else if ($sheet->getCell('I51')->getValue() === $info_tratamiento->caracte_no_conformidad) {
            $sheet->setCellValue('I51', $info_tratamiento->caracte_no_conformidad . ' X ');
        } else if ($sheet->getCell('I54')->getValue() === $info_tratamiento->caracte_no_conformidad) {
            $sheet->setCellValue('I54', $info_tratamiento->caracte_no_conformidad . ' X ');
        } else if ($sheet->getCell('I59')->getValue() === $info_tratamiento->caracte_no_conformidad) {
            $sheet->setCellValue('I59', $info_tratamiento->caracte_no_conformidad . ' X ');
        } else if ($sheet->getCell('I62')->getValue() === $info_tratamiento->caracte_no_conformidad) {
            $sheet->setCellValue('I62', $info_tratamiento->caracte_no_conformidad . ' X ');
        } else if ($sheet->getCell('I65')->getValue() === $info_tratamiento->caracte_no_conformidad) {
            $sheet->setCellValue('I65', $info_tratamiento->caracte_no_conformidad . ' X ');
        } else if ($sheet->getCell('I69')->getValue() === $info_tratamiento->caracte_no_conformidad) {
            $sheet->setCellValue('I69', $info_tratamiento->caracte_no_conformidad . ' X ');
        } else if ($sheet->getCell('I73')->getValue() === $info_tratamiento->caracte_no_conformidad) {
            $sheet->setCellValue('I73', $info_tratamiento->caracte_no_conformidad . ' X ');
        } else if ($sheet->getCell('I80')->getValue() === $info_tratamiento->caracte_no_conformidad) {
            $sheet->setCellValue('I80', $info_tratamiento->caracte_no_conformidad . ' X ');
        } else if ($info_tratamiento->nivel_conformidad === 'otro_alto') {
            $sheet->setCellValue('I81', "OTRO: " . $info_tratamiento->caracte_no_conformidad);
        }

        //

        //Muy alto

        if ($sheet->getCell('M47')->getValue() === $info_tratamiento->caracte_no_conformidad) {
            $sheet->setCellValue('M47', $info_tratamiento->caracte_no_conformidad . ' X ');
        } else if ($sheet->getCell('M51')->getValue() === $info_tratamiento->caracte_no_conformidad) {
            $sheet->setCellValue('M51', $info_tratamiento->caracte_no_conformidad . ' X ');
        }if ($sheet->getCell('M54')->getValue() === $info_tratamiento->caracte_no_conformidad) {
            $sheet->setCellValue('M54', $info_tratamiento->caracte_no_conformidad . ' X ');
        } else if ($sheet->getCell('M59')->getValue() === $info_tratamiento->caracte_no_conformidad) {
            $sheet->setCellValue('M59', $info_tratamiento->caracte_no_conformidad . ' X ');
        }if ($sheet->getCell('M62')->getValue() === $info_tratamiento->caracte_no_conformidad) {
            $sheet->setCellValue('M62', $info_tratamiento->caracte_no_conformidad . ' X ');
        } else if ($sheet->getCell('M65')->getValue() === $info_tratamiento->caracte_no_conformidad) {
            $sheet->setCellValue('M65', $info_tratamiento->caracte_no_conformidad . ' X ');
        } else if ($sheet->getCell('M69')->getValue() === $info_tratamiento->caracte_no_conformidad) {
            $sheet->setCellValue('M69', $info_tratamiento->caracte_no_conformidad . ' X ');
        } else if ($sheet->getCell('M73')->getValue() === $info_tratamiento->caracte_no_conformidad) {
            $sheet->setCellValue('M73', $info_tratamiento->caracte_no_conformidad . ' X ');
        } else if ($sheet->getCell('M80')->getValue() === $info_tratamiento->caracte_no_conformidad) {
            $sheet->setCellValue('M80', $info_tratamiento->caracte_no_conformidad . ' X ');
        } else if ($info_tratamiento->nivel_conformidad === 'otro_muyalto') {
            $sheet->setCellValue('M81', "OTRO: " . $info_tratamiento->caracte_no_conformidad);
        }
        //
        $fecha_veri_cierre = new DateTime($info_tratamiento->fecha_veri_cierre);
        $fecha_veri_cierre = $fecha_veri_cierre->format('d-m-Y');
        $sheet->setCellValue('D91', 'Fecha: ' . $fecha_veri_cierre);
        $sheet->setCellValue('L91', $info_tratamiento->veri_cierre_responsable_name);
        $sheet->setCellValue('D93', $info_tratamiento->cargo_veri_cierre_responsable);
        if ($info_tratamiento->eficaz_tratamiento === 'si') {
            $sheet->setCellValue('D96', ' SI   __X__');
        } else {
            $sheet->setCellValue('D97', ' NO __X__ ');
        }
        $sheet->setCellValue('L95', $info_tratamiento->conclusion_final);

        if ($info_tratamiento->evidencia_si_aplica) {
            $drawing = new Drawing();
            $drawing->setPath(substr(public_path(), 0, -14) . '/public/archivos/Inconformidades/tratamiento_no_conformidad/' . $info_tratamiento->id_tratamiento . '.jpg');
            $drawing->setHeight(100); // Altura de la imagen en píxeles
            $drawing->setCoordinates('D100'); // Celda donde se colocará la imagen
            $drawing->setWorksheet($sheet);
        }

        $nombreArchivo = $info_tratamiento->id_tratamiento . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save(storage_path('app/public/Tratamientos/' . $nombreArchivo));
        return response()->download(storage_path('app/public/Tratamientos/' . $nombreArchivo));
    }

    public function showGraficaNoConformidad()
    {
        if (Session::has('user')) {
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "noconformidades/graficos";
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

            $datosTratamiento = McTratamiento::join('param_areas', 'param_areas.id_area', '=', 'mc_tratamiento.proceso_rela_trata')
                ->selectRaw('COUNT(mc_tratamiento.proceso_rela_trata) AS cantidad, param_areas.descripcion')
                ->groupBy('param_areas.descripcion')
                ->get();

            $datosReporte = Reporte_no_conformidades::join('param_areas AS pa', 'mc_reporte.proceso_no_conforme', '=', 'pa.id_area')
                ->selectRaw('COUNT(mc_reporte.proceso_no_conforme) AS cantidad, pa.descripcion')
                ->groupBy('pa.descripcion')
                ->get();

            return view('inconformidades.panelInformesGraficos')->with(['DatosUsuario' => $DatosUsuario, 'datosTratamiento' => $datosTratamiento, 'datosReporte' => $datosReporte]);

        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function updateGraficaTrata(Request $request)
    {
        $fecha_ini_trata = $request->input('fecha_ini_trata');
        $fecha_final_trata = $request->input('fecha_final_trata');

        $sql = McTratamiento::selectRaw('COUNT(mc_tratamiento.proceso_rela_trata) AS cantidad, param_areas.descripcion')
            ->join('param_areas', 'param_areas.id_area', '=', 'mc_tratamiento.proceso_rela_trata');

        if ($fecha_ini_trata !== null && $fecha_final_trata !== null) {
            $sql->whereBetween('mc_tratamiento.fecha_diligencia_trata', [$fecha_ini_trata, $fecha_final_trata]);
        }

        if ($fecha_ini_trata !== null && $fecha_final_trata === null) {
            $sql->where('mc_tratamiento.fecha_diligencia_trata', '>=', $fecha_ini_trata);
        }

        $sql->groupBy('param_areas.id_area', 'param_areas.descripcion');

        $cantidadRegistros = $sql->get();

        if (count($cantidadRegistros) === 0) {
            toastr()->warning('¡No se han encontrado registros en busqueda!', '¡Advertencia!', ['positionClass' => 'toast-bottom-right']);
            return response()->json(['message' => 'No hay registros']);

        } else {
            return response()->json($cantidadRegistros);
        }

    }

    public function downloadAllTrata(Request $request)
    {
        $reportes = json_decode($request->input('reportes'), true);
        $plantilla = storage_path('app/templates/F-AC-01-20_FORMATO_TRATAMIENTO_NO_CONFORMIDADES.xlsx');
        $zip = new ZipArchive();
        $zipFileName = 'informes_tratamientos.zip';
        $zipFilePath = storage_path("app/public/" . $zipFileName);

        if ($zip->open($zipFilePath, ZipArchive::CREATE) === true) {

            foreach ($reportes as $key => $value) {

                $spreadsheet = IOFactory::load($plantilla);
                $sheet = $spreadsheet->getActiveSheet();

                $info_tratamiento = McTratamiento::find($value['id_tratamiento']);
                $infoDetectado = PanelEmpleados::getEmpleadoInfo($info_tratamiento->detectado_persona);
                $info_tratamiento['detectado_persona_name'] = $infoDetectado[0]->nombre;
                $info_tratamiento['cargo_detectado_persona'] = $infoDetectado[0]->cargo;
                $info_tratamiento['proceso_rela_trata'] = PanelAreas::getArea($info_tratamiento['proceso_rela_trata'])[0]->descripcion;
                $infoVeriCierreRespon = PanelEmpleados::getEmpleadoInfo($info_tratamiento->veri_cierre_responsable);
                $info_tratamiento['veri_cierre_responsable_name'] = $infoVeriCierreRespon[0]->nombre;
                $info_tratamiento['cargo_veri_cierre_responsable'] = $infoVeriCierreRespon[0]->cargo;

                $info_tratamiento_persons = McTratamientoPerson::where('fk_id_trata', $value['id_tratamiento'])->get();

                $info_tratamiento_inme = McTrataInme::where('fk_id_trata', $value['id_tratamiento'])->get();

                foreach ($info_tratamiento_persons as $key) {
                    $infoResTrata = PanelEmpleados::getEmpleadoInfo($key->getAttributes()['responsable_trata']);
                    $key->setAttribute('responsable_tratamiento_name', $infoResTrata[0]->nombre);
                    $key->setAttribute('cargo_responsable_tratamiento', $infoResTrata[0]->cargo);
                }


                $sheet->setCellValue('F7', explode(" ", $info_tratamiento->fecha_diligencia_trata->format('d-m-Y'))[0]);
                $sheet->setCellValue('K7', $info_tratamiento->lugar_trata);
                $sheet->setCellValue('S7', $info_tratamiento->proceso_rela_trata);

                if ($info_tratamiento->inconfor_trata === "producto") {
                    $sheet->setCellValue('F10', 'X');
                } else if ($info_tratamiento->inconfor_trata === "proceso relacionado") {
                    $sheet->setCellValue('K10', 'X');
                } else if ($info_tratamiento->inconfor_trata === "otro") {
                    $sheet->setCellValue('R10', 'X');
                }

                $sheet->setCellValue('C13', $info_tratamiento->descripcion_trata);

                $sheet->setCellValue('C21', ' Nombre: ' . $info_tratamiento->detectado_persona_name);
                $sheet->setCellValue('C22', ' Cargo: ' . $info_tratamiento->cargo_detectado_persona);
                $sheet->setCellValue('C24', ' Fecha: ' . explode(" ", $info_tratamiento->fecha_evento_trata->format('d-m-Y'))[0]);
                $personas;
                foreach ($info_tratamiento_persons as $key => $value) {
                    if ($key === 0) {
                        $personas = ' Nombre: ';
                    }
                    if (count($info_tratamiento_persons) === $key || count($info_tratamiento_persons) === 1) {
                        $personas .= $value->responsable_tratamiento_name;
                    } else {
                        $personas .= $value->responsable_tratamiento_name . ' - ';
                    }
                }

                $sheet->setCellValue('M21', $personas);

                $cargos;

                foreach ($info_tratamiento_persons as $key => $value) {
                    if ($key === 0) {
                        $cargos = ' Cargo: ';
                    }
                    if (count($info_tratamiento_persons) === $key || count($info_tratamiento_persons) === 1) {
                        $cargos .= $value->cargo_responsable_tratamiento;
                    } else {
                        $cargos .= $value->cargo_responsable_tratamiento . ' - ';
                    }
                }

                $sheet->setCellValue('M22', $cargos);

                $sheet->setCellValue('M24', ' Fecha: ' . explode(" ", $info_tratamiento->fecha_esti_trata->format('d-m-Y'))[0]);

                if ($info_tratamiento_inme[0]->descripcion_inme_trata !== null) {
                $content = " ";
                foreach ($info_tratamiento_inme as $key => $value) {

                    if ($value->tratamiento === "Reproceso") {
                        $sheet->setCellValue('G27', 'X');
                    } else if ($value->tratamiento === "Reclasificacion") {
                        $sheet->setCellValue('K27', 'X');
                    } else if ($value->tratamiento === "Rechazo") {
                        $sheet->setCellValue('N27', 'X');
                    } else if ($value->tratamiento === "Derogacion") {
                        $sheet->setCellValue('T27', 'X');
                    } else {
                        $sheet->setCellValue('U27', ' Otro:' . 'X');
                    }

                    $value->persona_trata = PanelEmpleados::getEmpleadoInfo($value->persona_trata)[0]->nombre;

                    $content .= "• " . $value->tratamiento . ' - ' . $value->descripcion_inme_trata . ' - ' . $value->persona_trata . "\n";
                }

                $sheet->setCellValue('C29', $content);
            }

                //BAJO
                if ($sheet->getCell('S47')->getValue() === $info_tratamiento->caracte_no_conformidad) {
                    $sheet->setCellValue('S47', $info_tratamiento->caracte_no_conformidad . ' X ');
                } else if ($sheet->getCell('S51')->getValue() === $info_tratamiento->caracte_no_conformidad) {
                    $sheet->setCellValue('S51', $info_tratamiento->caracte_no_conformidad . ' X ');
                } else if ($info_tratamiento->nivel_conformidad === 'otro_bajo') {
                    $sheet->setCellValue('S54', "OTRO: " . $info_tratamiento->caracte_no_conformidad);
                }
                //
                //MEDIO
                if ($sheet->getCell('D47')->getValue() === $info_tratamiento->caracte_no_conformidad) {
                    $sheet->setCellValue('D47', $info_tratamiento->caracte_no_conformidad . ' X ');
                } else if ($sheet->getCell('D51')->getValue() === $info_tratamiento->caracte_no_conformidad) {
                    $sheet->setCellValue('D51', $info_tratamiento->caracte_no_conformidad . ' X ');
                } else if ($sheet->getCell('D54')->getValue() === $info_tratamiento->caracte_no_conformidad) {
                    $sheet->setCellValue('D54', $info_tratamiento->caracte_no_conformidad . ' X ');
                } else if ($sheet->getCell('D59')->getValue() === $info_tratamiento->caracte_no_conformidad) {
                    $sheet->setCellValue('D59', $info_tratamiento->caracte_no_conformidad . ' X ');
                } else if ($sheet->getCell('D62')->getValue() === $info_tratamiento->caracte_no_conformidad) {
                    $sheet->setCellValue('D62', $info_tratamiento->caracte_no_conformidad . ' X ');
                } else if ($sheet->getCell('D65')->getValue() === $info_tratamiento->caracte_no_conformidad) {
                    $sheet->setCellValue('D65', $info_tratamiento->caracte_no_conformidad . ' X ');
                } else if ($sheet->getCell('D69')->getValue() === $info_tratamiento->caracte_no_conformidad) {
                    $sheet->setCellValue('D69', $info_tratamiento->caracte_no_conformidad . ' X ');
                } else if ($info_tratamiento->nivel_conformidad === 'otro_medio') {
                    $sheet->setCellValue('D73', "OTRO: " . $info_tratamiento->caracte_no_conformidad);
                }
                //

                //Alto
                if ($sheet->getCell('I47')->getValue() === $info_tratamiento->caracte_no_conformidad) {
                    $sheet->setCellValue('I47', $info_tratamiento->caracte_no_conformidad . ' X ');
                } else if ($sheet->getCell('I51')->getValue() === $info_tratamiento->caracte_no_conformidad) {
                    $sheet->setCellValue('I51', $info_tratamiento->caracte_no_conformidad . ' X ');
                } else if ($sheet->getCell('I54')->getValue() === $info_tratamiento->caracte_no_conformidad) {
                    $sheet->setCellValue('I54', $info_tratamiento->caracte_no_conformidad . ' X ');
                } else if ($sheet->getCell('I59')->getValue() === $info_tratamiento->caracte_no_conformidad) {
                    $sheet->setCellValue('I59', $info_tratamiento->caracte_no_conformidad . ' X ');
                } else if ($sheet->getCell('I62')->getValue() === $info_tratamiento->caracte_no_conformidad) {
                    $sheet->setCellValue('I62', $info_tratamiento->caracte_no_conformidad . ' X ');
                } else if ($sheet->getCell('I65')->getValue() === $info_tratamiento->caracte_no_conformidad) {
                    $sheet->setCellValue('I65', $info_tratamiento->caracte_no_conformidad . ' X ');
                } else if ($sheet->getCell('I69')->getValue() === $info_tratamiento->caracte_no_conformidad) {
                    $sheet->setCellValue('I69', $info_tratamiento->caracte_no_conformidad . ' X ');
                } else if ($sheet->getCell('I73')->getValue() === $info_tratamiento->caracte_no_conformidad) {
                    $sheet->setCellValue('I73', $info_tratamiento->caracte_no_conformidad . ' X ');
                } else if ($sheet->getCell('I80')->getValue() === $info_tratamiento->caracte_no_conformidad) {
                    $sheet->setCellValue('I80', $info_tratamiento->caracte_no_conformidad . ' X ');
                } else if ($info_tratamiento->nivel_conformidad === 'otro_alto') {
                    $sheet->setCellValue('I81', "OTRO: " . $info_tratamiento->caracte_no_conformidad);
                }

                //

                //Muy alto

                if ($sheet->getCell('M47')->getValue() === $info_tratamiento->caracte_no_conformidad) {
                    $sheet->setCellValue('M47', $info_tratamiento->caracte_no_conformidad . ' X ');
                } else if ($sheet->getCell('M51')->getValue() === $info_tratamiento->caracte_no_conformidad) {
                    $sheet->setCellValue('M51', $info_tratamiento->caracte_no_conformidad . ' X ');
                }if ($sheet->getCell('M54')->getValue() === $info_tratamiento->caracte_no_conformidad) {
                    $sheet->setCellValue('M54', $info_tratamiento->caracte_no_conformidad . ' X ');
                } else if ($sheet->getCell('M59')->getValue() === $info_tratamiento->caracte_no_conformidad) {
                    $sheet->setCellValue('M59', $info_tratamiento->caracte_no_conformidad . ' X ');
                }if ($sheet->getCell('M62')->getValue() === $info_tratamiento->caracte_no_conformidad) {
                    $sheet->setCellValue('M62', $info_tratamiento->caracte_no_conformidad . ' X ');
                } else if ($sheet->getCell('M65')->getValue() === $info_tratamiento->caracte_no_conformidad) {
                    $sheet->setCellValue('M65', $info_tratamiento->caracte_no_conformidad . ' X ');
                } else if ($sheet->getCell('M69')->getValue() === $info_tratamiento->caracte_no_conformidad) {
                    $sheet->setCellValue('M69', $info_tratamiento->caracte_no_conformidad . ' X ');
                } else if ($sheet->getCell('M73')->getValue() === $info_tratamiento->caracte_no_conformidad) {
                    $sheet->setCellValue('M73', $info_tratamiento->caracte_no_conformidad . ' X ');
                } else if ($sheet->getCell('M80')->getValue() === $info_tratamiento->caracte_no_conformidad) {
                    $sheet->setCellValue('M80', $info_tratamiento->caracte_no_conformidad . ' X ');
                } else if ($info_tratamiento->nivel_conformidad === 'otro_muyalto') {
                    $sheet->setCellValue('M81', "OTRO: " . $info_tratamiento->caracte_no_conformidad);
                }
                //

                $fecha_veri_cierre = new DateTime($info_tratamiento->fecha_veri_cierre);
                $fecha_veri_cierre = $fecha_veri_cierre->format('d-m-Y');
                $sheet->setCellValue('D91', 'Fecha: ' . $fecha_veri_cierre);
                $sheet->setCellValue('L91', $info_tratamiento->veri_cierre_responsable_name);
                $sheet->setCellValue('D93', $info_tratamiento->cargo_veri_cierre_responsable);
                if ($info_tratamiento->eficaz_tratamiento === 'si') {
                    $sheet->setCellValue('D96', ' SI   __X__');
                } else {
                    $sheet->setCellValue('D97', ' NO __X__ ');
                }
                $sheet->setCellValue('L95', $info_tratamiento->conclusion_final);

                if ($info_tratamiento->evidencia_si_aplica) {
                    $drawing = new Drawing();
                    $drawing->setPath(substr(public_path(), 0, -14) . '/public/archivos/Inconformidades/tratamiento_no_conformidad/' . $info_tratamiento->id_tratamiento . '.jpg');
                    $drawing->setHeight(100); // Altura de la imagen en píxeles
                    $drawing->setCoordinates('D100'); // Celda donde se colocará la imagen
                    $drawing->setWorksheet($sheet);
                }
                $nombreArchivo = $info_tratamiento->id_tratamiento . '.xlsx';
                $writer = new Xlsx($spreadsheet);
                $writer->save(storage_path('app/public/Tratamientos/' . $nombreArchivo));
                $zip->addFile(storage_path('app/public/Tratamientos/' . $nombreArchivo), $nombreArchivo);
            }

            $zip->close();
        }

        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }
    public function updateTratamientoNoConf(Request $request)
    {
        $user = Session::get('user');
        $DatosUsuario = PanelLogin::getUsuario($user);

        $id_tratamiento = $request->input('id_tratamiento');
        $fecha_diligencia_trata = $request->input('fecha_diligencia_trata');
        $lugar_trata = $request->input('lugar_trata');
        $proceso_rela_trata = $request->input('proceso_rela_trata');
        $inconfor_trata = $request->input('inconfor_trata');
        $descripcion_trata = $request->input('descripcion_trata');
        $detectado_persona = $request->input('detectado_persona');
        $fecha_evento_trata = $request->input('fecha_evento_trata');

        //otra tabla
        $responsable_trata = $request->input('responsable_trata');
        //
        $fecha_esti_trata = $request->input('fecha_esti_trata');

        $tratamiento = collect($request->all())->filter(function ($value, $key) {
            return str_starts_with($key, 'tratamiento');
        })->values();
        $descripcion_inme_trata = $request->input('descripcion_inme_trata');
        $persona_trata = $request->input('persona_trata');

        $caracte_no_conformidad = $request->input('caracte_no_conformidad');
        $nivel_conformidad = $request->input('nivel_conformidad');
        $fecha_veri_cierre = $request->input('fecha_veri_cierre');
        $veri_cierre_responsable = $request->input('veri_cierre_responsable');
        $eficaz_tratamiento = $request->input('eficaz_tratamiento');
        $conclusion_final = $request->input('conclusion_final');
        $evidencia_aplica = $request->input('evidencia_aplica');

        $datos = [
            'fecha_diligencia_trata' => $fecha_diligencia_trata,
            'lugar_trata' => $lugar_trata,
            'proceso_rela_trata' => $proceso_rela_trata,
            'inconfor_trata' => $inconfor_trata,
            'descripcion_trata' => $descripcion_trata,
            'detectado_persona' => $detectado_persona,
            'fecha_evento_trata' => $fecha_evento_trata,
            'fecha_esti_trata' => $fecha_esti_trata,
            'caracte_no_conformidad' => $caracte_no_conformidad,
            'nivel_conformidad' => $nivel_conformidad,
            'fecha_veri_cierre' => $fecha_veri_cierre,
            'veri_cierre_responsable' => $veri_cierre_responsable,
            'eficaz_tratamiento' => $eficaz_tratamiento,
            'conclusion_final' => $conclusion_final,
        ];

        $uploader = $request->input('uploader');
        if ($uploader != '') {
            $evidencia_si_aplica = $request->file('evidencia_aplica');
            $ruta = substr(public_path(), 0, -14) . 'public/archivos/Inconformidades/tratamiento_no_conformidad/';
            $extension = $evidencia_si_aplica->getClientOriginalExtension();
            $nombreArchivo = $id_tratamiento . '.' . $extension;
            $evidencia_si_aplica->move($ruta, $nombreArchivo);
            $datos += ['evidencia_si_aplica' => $nombreArchivo];
        }

        McTratamiento::where('id_tratamiento', $id_tratamiento)->update($datos);
        $registros_trata_inme = McTrataInme::where('fk_id_trata', $id_tratamiento)->get();

        foreach ($tratamiento as $key => $value) {
            McTrataInme::where('fk_id_trata', $id_tratamiento)->where('id', $registros_trata_inme[$key]->id)->update([
                'tratamiento' => $value,
                'descripcion_inme_trata' => $descripcion_inme_trata[$key],
                'persona_trata' => $persona_trata[$key],
            ]);
        }

        $registros_trata = McTratamientoPerson::where('fk_id_trata', $id_tratamiento)->get();

        foreach ($responsable_trata as $posicion => $valor) {
            McTratamientoPerson::where('fk_id_trata', $id_tratamiento)->where('id', $registros_trata[$posicion]->id)->update([
                'responsable_trata' => $valor,
            ]);
        }

        toastr()->success('¡Tratamiento de inconformidad actualizado exitosamente!', '¡Actualización exitosa!', ['positionClass' => 'toast-bottom-right']);
        return back();
    }

    public function descargaTrataDbExcel(Request $request)
    {
        $fecha_ini = $request->input('fecha_ini_trata');
        $fecha_final = $request->input('fecha_final_trata');

        $query = DB::table('get_tratamientos');

        if ($fecha_ini !== null && $fecha_final !== null) {
            $query->whereBetween('fecha_diligencia_trata', [$fecha_ini, $fecha_final]);
        }

        if ($fecha_ini !== null && $fecha_final === null) {
            $query->where('fecha_diligencia_trata', '>=', $fecha_ini);
        }

        $tratamientos = $query->get();

        return Excel::download(new TratamientoExport($tratamientos), 'tratamientos.xlsx');
    }

}
