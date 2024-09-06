<?php
/*
Controlador de la tabla rqpe_solicitud
Usa SQl Eloquent del archivo app\Models\Requisiciones\PanelSolicitudes.php
 */

namespace App\Http\Controllers\Requisiciones;

use App\Exports\SolicitudesRequicisionesPersonalExport;
use App\Http\Controllers\Controller;
use App\Models\PanelLogin;
use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelCentrosOp;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Requerimientos\PanelRequSoliElementos;
use App\Models\Requisiciones\PanelDotaciones;
use App\Models\Requisiciones\PanelDotacionesSoli;
use App\Models\Requisiciones\PanelHerramientas;
use App\Models\Requisiciones\PanelIngresos;
use App\Models\Requisiciones\PanelMotivos;
use App\Models\Requisiciones\PanelNivelesCargos;
use App\Models\Requisiciones\PanelNovedades;
use App\Models\Requisiciones\PanelPermisosAutorizacion;
use App\Models\Requisiciones\PanelRequisiciones;
use App\Models\Requisiciones\PanelSoliRequiere;
use App\Models\Requisiciones\PanelTallaDotacion;
use App\Models\Requisiciones\PanelTiempoEstados;
use App\Models\Requisiciones\PanelTipoDotacion;
use App\Models\Requisiciones\PanelTpcontratos;
use App\Models\Ssl\PanelReglasNoti;
use App\Models\Ssl\PanelSoliExamenes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Request;

class SolRequisicionesPanelController extends Controller
{
    public function Solicitud()
    {
        if (Session::has('user')) {
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "requisiciones/solicitud";
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
            $herramientas = PanelHerramientas::where('estado', 1)->get();
            return view('requisiciones.panel-solicitud')->with('DatosUsuario', $DatosUsuario)->with('herramientas', $herramientas);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function SolicitudAgregarDB(Request $request)
    {
        if (Session::has('user')) {
            $formData = $request::all();
            $user = Session::get('user');
            $cargo = $formData['cargo'];
            $centro_op = $formData['centro_op'];
            $motivo = $formData['motivo'];
            $nombre = trim($formData['nombre']);
            $observaciones = trim($formData['observaciones']);
            $aplicativos = trim($formData['aplicativos']);
            $numvacantes = $formData['numvacantes'];
            if (isset($formData['requiere'])) {
                $requiere = $formData['requiere'];
            }

            $requiere_dotacion = $formData['requiere_dotacion'];

            $datos = array();

            if ($motivo == "CN") {
                $nombre = "No aplica";
            }

            $DatosUsuario = PanelLogin::getUsuario($user);

            $datos['cargo'] = $cargo;
            $datos['centro_operacion'] = $centro_op;
            $datos['motivo'] = $motivo;
            $datos['reemplaza_a'] = $nombre;
            $datos['observaciones'] = $observaciones;
            $datos['num_vacantes'] = $numvacantes;
            $datos['aplicativos'] = $aplicativos;
            $datos['usr_solicita'] = $DatosUsuario[0]->empleado;
            $datos['fecha_solicita'] = NOW();
            $datos['estado'] = 1;
            $datos['requiere_dotacion'] = $requiere_dotacion;

            PanelRequisiciones::insertarSolicitud($datos);
            $solicitud = PanelRequisiciones::UltimaSolicitud();

            if (isset($formData['requiere'])) {
                foreach ($requiere as $key => $value) {
                    $datos = [
                        'fk_num_solicitud' => $solicitud->num_solicitud,
                        'fk_id_herramienta' => $value,
                    ];
                    PanelSoliRequiere::create($datos);
                }
            }

            $Mensaje = "Solicitud creada #" . $solicitud->num_solicitud;

            $Redireccion = "/panel/requisiciones/solicitud";
            return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
        }

    }

    public function SolicitudMasinfo($id)
    {
        if (Session::has('user')) {
            $Solicitud = $id;
            $DatosSolicitud = PanelRequisiciones::getSolicitud($Solicitud);
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "requisiciones/solicitud";
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

            $DatosSolicitud[0]->centro_operacion = PanelCentrosOp::getCentroOp($DatosSolicitud[0]->centro_operacion)[0]->descripcion;
            if ($DatosSolicitud[0]->estado == '1') {
                $DatosSolicitud[0]->nombre_estado = 'Pendiente';
            } else if ($DatosSolicitud[0]->estado == '5' || $DatosSolicitud[0]->estado == '3') {
                $DatosSolicitud[0]->nombre_estado = 'Activo';
            } else if ($DatosSolicitud[0]->estado == '6') {
                $DatosSolicitud[0]->nombre_estado = 'Cerrado';
            } else if ($DatosSolicitud[0]->estado == '9') {
                $DatosSolicitud[0]->nombre_estado = 'Aplazado';
            } else if ($DatosSolicitud[0]->estado == '7' || $DatosSolicitud[0]->estado == '8') {
                $DatosSolicitud[0]->nombre_estado = 'Cancelado';
            } else if ($DatosSolicitud[0]->estado == '2' || $DatosSolicitud[0]->estado == '4') {
                $DatosSolicitud[0]->nombre_estado = 'Rechazado';
            } else if ($DatosSolicitud[0]->estado == '10') {
                $DatosSolicitud[0]->nombre_estado = 'Finalizado';
            }

            $DatosSolicitud[0]->fecha_solicita = Carbon::parse($DatosSolicitud[0]->fecha_solicita)->format('d/m/Y');
            $DatosSolicitud[0]->cargo = PanelCargos::getCargo($DatosSolicitud[0]->cargo)[0]->descripcion;

            if ($DatosSolicitud[0]->motivo == 'RP') {
                $DatosSolicitud[0]->motivo = 'Reemplazo de personal';
            } elseif ($DatosSolicitud[0]->motivo == 'CN') {
                $DatosSolicitud[0]->motivo = 'Cargo nuevo / Incremento de personal';
            } elseif ($DatosSolicitud[0]->motivo == 'LM') {
                $DatosSolicitud[0]->motivo = 'Licencia de maternidad';
            } elseif ($DatosSolicitud[0]->motivo == 'IP') {
                $DatosSolicitud[0]->motivo = 'Incapacidad permanente';
            }
            $empleado = PanelEmpleados::getEmpleado($DatosSolicitud[0]->usr_solicita);
            $DatosSolicitud[0]->usr_solicita = $empleado[0]->primer_nombre . ' ' . $empleado[0]->ot_nombre . ' ' . $empleado[0]->primer_apellido . ' ' . $empleado[0]->ot_apellido;

            if ($DatosSolicitud[0]->estado != 1) {
                $DatosSolicitud[0]->nombre_tipo_contrato = PanelTpcontratos::where('id_tpcontrato', $DatosSolicitud[0]->tpcontrato)->get()[0]->descripcion;
                $DatosSolicitud[0]->fecha_aprox_ingreso = Carbon::parse($DatosSolicitud[0]->fecha_aprox_ingreso)->format('d/m/Y');
                $DatosSolicitud[0]->fk_nivel_cargo = PanelNivelesCargos::where('id_nivel_cargo', $DatosSolicitud[0]->fk_nivel_cargo)->first()->nombre_nivel_cargo;
            }

            $tiempos_estados_solicitud = PanelTiempoEstados::where('fk_num_solicitud', $Solicitud)
                ->select('id_tiempos_estados as id', 'nombre_estado as content', 'fecha_estado as start', 'fecha_retomada as end')
                ->get();

            $herramientas = PanelHerramientas::where('estado', 1)->get();
            $soliRequiere = \DB::table('rqpe_soli_requiere AS rqpe_s_r')
                ->join('rqpe_herramientas AS rqpe_h', 'rqpe_h.id_herramienta', '=', 'rqpe_s_r.fk_id_herramienta')
                ->where('rqpe_s_r.fk_num_solicitud', $Solicitud)
                ->pluck('rqpe_h.nombre_herramienta');
            $dotaciones = PanelDotacionesSoli::getDotacionesSoli($Solicitud);

            $novedades = PanelNovedades::where('fk_num_solicitud', $Solicitud)->get();
            $ingresos = PanelIngresos::where('fk_num_solicitud', $Solicitud)->whereIn('estado_soli_ingreso', ['0', '1', '2'])->get();

            $ingresos = $ingresos->map(function ($ingreso) {
                if ($ingreso->estado_soli_ingreso == 0) {
                    $ingreso->nombre_estado_ingreso = 'No se requiere examen';
                } else if ($ingreso->estado_soli_ingreso == 1) {
                    $ingreso->nombre_estado_ingreso = 'Pendiente de resultado';
                } else if ($ingreso->estado_soli_ingreso == 2) {
                    $ingreso->nombre_estado_ingreso = 'Aprobado';
                }
                return $ingreso;
            });

            return view('requisiciones.panel-solicitudMasinfo')->with('DatosUsuario', $DatosUsuario)->with('DatosSolicitud', $DatosSolicitud)->with('herramientas', $herramientas)->with('dotaciones', $dotaciones)->with('ingresos', $ingresos)
                ->with('novedades', $novedades)->with('tiempos_estados_solicitud', $tiempos_estados_solicitud)->with('soliRequiere', $soliRequiere);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function Nomina()
    {
        if (Session::has('user')) {
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);
            $empleado = PanelEmpleados::getEmpleado($DatosUsuario[0]->empleado);

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "requisiciones/nomina";
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

            $nivelPermiso = PanelPermisosAutorizacion::where('fk_id_empleado', $DatosUsuario[0]->empleado)->pluck('nivel_permiso_aut');
            $centros_operacion = PanelCentrosOp::getCentrosOpActivos();

            if (!$nivelPermiso->isEmpty()) {
                if ($nivelPermiso[0] == 1) {
                    $DatosSolicitudes = PanelRequisiciones::getSolitudesCentroOp($empleado[0]->centro_op);
                } else if ($nivelPermiso[0] == 2) {
                    $DatosSolicitudes = PanelRequisiciones::SolicitudesNomina();
                }
            } else {
                $DatosSolicitudes = [];
            }

            $niveles_cargos = PanelNivelesCargos::get();
            return view('requisiciones.panel-nomina')->with('DatosUsuario', $DatosUsuario)->with('DatosSolicitudes', $DatosSolicitudes)->with('niveles_cargos', $niveles_cargos)->with('centros_operacion', $centros_operacion)
                ->with('nivelPermiso', $nivelPermiso);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function NominaAutorizar($id)
    {
        if (Session::has('user')) {
            $Solicitud = $id;
            $DatosSolicitud = PanelRequisiciones::getSolicitud($Solicitud);
            $soliRequiere = \DB::table('rqpe_soli_requiere AS rqpe_s_r')
                ->join('rqpe_herramientas AS rqpe_h', 'rqpe_h.id_herramienta', '=', 'rqpe_s_r.fk_id_herramienta')
                ->where('rqpe_s_r.fk_num_solicitud', $id)
                ->pluck('rqpe_h.nombre_herramienta');

            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);
            $empleado = PanelEmpleados::getEmpleado($DatosUsuario[0]->empleado);

            $nivelPermiso = PanelPermisosAutorizacion::where('fk_id_empleado', $DatosUsuario[0]->empleado)->pluck('nivel_permiso_aut');

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "requisiciones/nomina";
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
            $herramientas = PanelHerramientas::where('estado', 1)->get();
            $dotaciones = PanelDotaciones::where('estado', 1)->get();
            $dotacionesSoli = PanelDotacionesSoli::getDotacionesSoli($Solicitud);
            $niveles_cargos = PanelNivelesCargos::where('estado_nivel_cargo', 1)->get();
            $Tpcontratos = PanelTpcontratos::where('estado', 1)->get();
            $novedades = PanelNovedades::where('fk_num_solicitud', $Solicitud)->get();
            $consecutivo = PanelIngresos::where('fk_num_solicitud', $Solicitud)->orderByRaw('CAST(SUBSTRING(consecutivo, 5) AS UNSIGNED) DESC')->first();
            $consecutivo = $consecutivo == null ? 1 : (int) explode('-', $consecutivo->consecutivo)[1] + 1;
            $ingresos = PanelIngresos::where('fk_num_solicitud', $Solicitud)->whereIn('estado_soli_ingreso', ['0', '1', '2'])->get();

            $ingresos = $ingresos->map(function ($ingreso) {
                if ($ingreso->estado_soli_ingreso == 0) {
                    $ingreso->nombre_estado_ingreso = 'No se requiere examen';
                } else if ($ingreso->estado_soli_ingreso == 1) {
                    $ingreso->nombre_estado_ingreso = 'Pendiente';
                } else if ($ingreso->estado_soli_ingreso == 2) {
                    $ingreso->nombre_estado_ingreso = 'Aprobado';
                }
                return $ingreso;
            });

            $tiempos_estados_solicitud = PanelTiempoEstados::where('fk_num_solicitud', $Solicitud)
                ->select('id_tiempos_estados as id', 'nombre_estado as content', 'fecha_estado as start', 'fecha_retomada as end')->get();

            return view('requisiciones.panel-nominaAutorizar', ['DatosUsuario' => $DatosUsuario, 'DatosSolicitud' => $DatosSolicitud,
                'herramientas' => $herramientas, 'dotaciones' => $dotaciones, 'soliRequiere' => $soliRequiere, 'niveles_cargos' => $niveles_cargos,
                'Tpcontratos' => $Tpcontratos, 'nivelPermiso' => $nivelPermiso, 'novedades' => $novedades, 'tiempos_estados_solicitud' => $tiempos_estados_solicitud,
                'consecutivo' => $consecutivo, 'ingresos' => $ingresos, 'dotacionesSoli' => $dotacionesSoli]);

        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function NominaAutorizarDB()
    {
        if (Session::has('user')) {
            $formData = Request::all();
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);
            $solicitud = $formData['solicitud'];
            $cargo = trim($formData['cargo']);
            $salario = trim($formData['salario']);
            $contrato = trim($formData['contrato']);
            $condiciones = trim($formData['condiciones']);
            $requiere_dotacion = $formData['requiere_dotacion'];

            if (isset($formData['requiere'])) {
                $requiere = $formData['requiere'];
            }

            $respon_proceso = $formData['respon_proceso'];
            $fecha_aprox_ingreso = $formData['fecha_aprox_ingreso'];
            $nivel_cargo = $formData['nivel_cargo'];

            $datos = array();

            //Realizo las validaciones
            $Mensaje = "";

            if ($cargo == "") {
                $Mensaje = "Debe seleccionar el cargo.";
            } else if ($salario == "") {
                $Mensaje = "Debe ingresar el salario.";
            } else if ($contrato == "") {
                $Mensaje = "Debe seleccionar el tipo de contrato.";
            }

            if ($Mensaje == "") {
                $datos['cargo'] = $cargo;
                $datos['salario'] = $salario;
                $datos['tpcontrato'] = $contrato;
                $datos['condiciones'] = $condiciones;
                $datos['usr_nomina'] = $DatosUsuario[0]->empleado;
                $datos['fecha_nomina'] = NOW();
                $datos['responsable_proceso'] = $respon_proceso;
                $datos['fecha_aprox_ingreso'] = $fecha_aprox_ingreso;
                $datos['fk_nivel_cargo'] = $nivel_cargo;
                $datos['requiere_dotacion'] = $requiere_dotacion;
                $datos['estado'] = '3';

                $soliHerramientas = PanelSoliRequiere::where('fk_num_solicitud', $solicitud)->get();

                foreach ($soliHerramientas as $key => $value) {
                    PanelSoliRequiere::where('id_soli_requiere', $value->id_soli_requiere)->delete();
                }

                if (isset($requiere)) {
                    foreach ($requiere as $key => $value) {
                        $data = [
                            'fk_num_solicitud' => $solicitud,
                            'fk_id_herramienta' => $value,
                        ];
                        PanelSoliRequiere::create($data);
                    }
                }

                $DatosSolicitud = PanelRequisiciones::getSolicitud($solicitud);

                PanelRequisiciones::actualizarSolicitud($solicitud, $datos);
                PanelTiempoEstados::create([
                    'nombre_estado' => 'Activo',
                    'fecha_estado' => NOW(),
                    'fk_num_solicitud' => $solicitud,
                ]);
                $dataCorreo = PanelRequisiciones::getSolicitud($solicitud);
                $correoUsuario = PanelEmpleados::getEmpleado($dataCorreo[0]->usr_solicita)[0]->correo;
                $dataCorreo[0]->cargo = PanelCargos::getCargo($dataCorreo[0]->cargo)[0]->descripcion;
                $dataCorreo[0]->centro_operacion = PanelCentrosOp::getCentroOp($dataCorreo[0]->centro_operacion)[0]->descripcion;
                $dataCorreo[0]->link_solicitud = env('APP_URL') . '/Berhlan/public/panel/requerimientos/elementos/' . $dataCorreo[0]->num_solicitud;

                $elementosAreaTic = PanelSoliRequiere::getElementosSoliArea($solicitud, '10');
                $elementosSopAdm = PanelSoliRequiere::getElementosSoliArea($solicitud, '17');

                $dataCorreo = (array) $dataCorreo[0];
                if (!$elementosAreaTic->isEmpty()) {
                    $dataCorreo['elemArea'] = $elementosAreaTic->toArray();

                    // Se notifica si se requiere elementos que provee TIC

                    Mail::send('email.email_requision_personal.notificacion_solicitud_personal', $dataCorreo, function ($message) use ($dataCorreo) {
                        $message->subject('Notificaciones Intranet');
                        $message->from('notificacionesberhlan@berhlan.com');
                        $message->to(env('GRUPO_CORREO_INFRAESTRUCTURA'));
                    });
                    unset($dataCorreo['elemArea']);
                }

                if (!$elementosSopAdm->isEmpty()) {

                    $dataCorreo['elemArea'] = $elementosSopAdm->toArray();

                    $correosSOP = \DB::table('param_cargos AS p_c')
                        ->join('param_empleados AS p_e', 'p_e.cargo', '=', 'p_c.id_cargo')
                        ->select('p_e.correo')
                        ->where('p_c.AREA', '=', '17')
                        ->where('p_e.estado', '=', '1')
                        ->where('p_e.centro_op', '=', '1')
                        ->where('p_e.correo', 'LIKE', '%@berhlan.com')
                        ->get();
                    // Se notifica si se requiere elementos que provee SOPORTE ADMINISTRATIVO
                    foreach ($correosSOP as $key => $correo) {
                        Mail::send('email.email_requision_personal.notificacion_solicitud_personal', $dataCorreo, function ($message) use ($dataCorreo, $correo) {
                            $message->subject('Notificaciones Intranet');
                            $message->from('notificacionesberhlan@berhlan.com');
                            $message->to($correo->correo);
                        });
                    }

                    unset($dataCorreo['elemArea']);
                }

                $dataCorreo['link_solicitud'] = env('APP_URL') . '/Berhlan/public/panel/requisiciones/solicitud/masinfo/' . $dataCorreo['num_solicitud'];
                $dataCorreo['aprobacion'] = '1';
                // Se notifica al solicitante que la solicitud fue aprobada al solicitante
                Mail::send('email.email_requision_personal.notificacion_solicitud_personal', $dataCorreo, function ($message) use ($dataCorreo, $correoUsuario) {
                    $message->subject('Notificaciones Intranet');
                    $message->from('notificacionesberhlan@berhlan.com');
                    $message->to($correoUsuario);
                });

                $numero_soli_elemento = PanelRequSoliElementos::latest('id_soli_elementos')->first();
                $numero_soli_elemento = $numero_soli_elemento != null ? $numero_soli_elemento->id_soli_elementos + 1 : 1;

                PanelRequSoliElementos::create([
                    'consecutivo_elementos' => 'RE-' . $numero_soli_elemento,
                    'estado_soli_elementos' => '1',
                    'fk_num_solicitud' => $solicitud,
                ]);

                $Mensaje = "Solicitud autorizada.";
            }

            $Redireccion = "/panel/requisiciones/nomina";
            return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function NominaRechazarDB()
    {
        if (Session::has('user')) {
            $formData = Request::all();
            $solicitud = $formData['solicitud'];
            $observaciones = trim($formData['observaciones']);
            $motivo = trim($formData['motivo']);
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            $datos = array();

            //Realizo las validaciones
            $Mensaje = "";

            if ($observaciones == "") {
                $Mensaje = "Debe ingresar las observaciones.";
            } else if ($motivo == "") {
                $Mensaje = "Debe seleccionar el motivo.";
            }

            if ($Mensaje == "") {
                $datos['estado'] = 2;
                $datos['salario'] = 0;
                $datos['tpcontrato'] = 0;
                $datos['condiciones'] = "";
                $datos['usr_nomina'] = $DatosUsuario[0]->empleado;
                $datos['fecha_nomina'] = NOW();
                $datos['rechazo_nomina'] = $motivo;
                $datos['obs_rechazo'] = $observaciones;

                PanelRequisiciones::actualizarSolicitud($solicitud, $datos);

                $dataCorreo = PanelRequisiciones::getSolicitud($solicitud)->toArray();
                $correoUsuario = PanelEmpleados::getEmpleado($dataCorreo[0]->usr_solicita)[0]->correo;
                $dataCorreo[0]->cargo = PanelCargos::getCargo($dataCorreo[0]->cargo)[0]->descripcion;
                $dataCorreo[0]->centro_operacion = PanelCentrosOp::getCentroOp($dataCorreo[0]->centro_operacion)[0]->descripcion;

                $dataCorreo[0]->rechazo_nomina = PanelMotivos::where('id_motivo', $dataCorreo[0]->rechazo_nomina)->get()[0]->descripcion;

                $dataCorreo = (array) $dataCorreo[0];
                // Se notifica al solicitante que la solicitud fue rechazada
                Mail::send('email.email_requision_personal.notificacion_rechazo_soli_personal', $dataCorreo, function ($message) use ($dataCorreo, $correoUsuario) {
                    $message->subject('Notificaciones Intranet');
                    $message->from('notificacionesberhlan@berhlan.com');
                    $message->to($correoUsuario);
                });

                $Mensaje = "Solicitud rechazada.";
            }

            $Redireccion = "/panel/requisiciones/nomina";
            return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function actualizarEstadoSoli()
    {
        if (Session::has('user')) {
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            $formData = Request::all();
            $solicitud = $formData['solicitud'];
            $estado = $formData['estado'];

            if (isset($formData['notificar_solicitante'])) {
                $notificar_solicitante = $formData['notificar_solicitante'];
            }

            $infoDBSoli = PanelRequisiciones::getSolicitud($solicitud)[0];

            // Estado por defecto entra en 3

            if ($estado == 3) {
                $datos['estado'] = $estado;
                $datos['dias_proceso'] = $formData['dias_proceso'];
                $datos['dias_proceso_real'] = $formData['dias_proceso_real'];
                PanelTiempoEstados::create([
                    'nombre_estado' => 'Activo',
                    'fecha_estado' => NOW(),
                    'fk_num_solicitud' => $solicitud,
                ]);
                PanelRequisiciones::actualizarSolicitud($solicitud, $datos);
            } else if ($estado == 9) { // Esta condición cambia la solicitud a aplazado

                $datos['estado'] = $estado;
                $datos['fecha_aplazado'] = now();
                $datos['dias_proceso'] = $formData['dias_proceso'];
                $datos['dias_proceso_real'] = $formData['dias_proceso_real'];
                PanelTiempoEstados::create([
                    'nombre_estado' => 'Aplazado',
                    'fecha_estado' => NOW(),
                    'fk_num_solicitud' => $solicitud,
                ]);
                PanelRequisiciones::actualizarSolicitud($solicitud, $datos);

            } else if ($infoDBSoli->estado == 9 && $estado == 3) { // Los dias aplazados se tomando cuando el estado cambia de 9 a 3 esto se considera cuando que la solicitud se retoma

                $datos['estado'] = $estado;
                $datos['fecha_aprox_ingreso'] = $formData['nueva_fecha_aprox'];
                $datos['dias_aplazado'] = $formData['dias_aplazado'];
                $datos['dias_proceso'] = $formData['dias_proceso'];
                $datos['dias_proceso_real'] = $formData['dias_proceso_real'];

                $registro = PanelTiempoEstados::where('nombre_estado', 'Aplazado')->latest()->first();
                $registro->update(['fecha_retomada' => NOW()]);

                PanelRequisiciones::actualizarSolicitud($solicitud, $datos);
            } else if ($estado == 7) { // Esta condición cambia la solicitud a cancelada
                $datos['estado'] = $estado;
                $datos['dias_proceso'] = $formData['dias_proceso'];
                $datos['dias_proceso_real'] = $formData['dias_proceso_real'];
                $datos['dias_aplazado'] = $formData['dias_aplazado'];

                if ($infoDBSoli->estado == 9) {
                    $registro = PanelTiempoEstados::where('nombre_estado', 'Aplazado')->latest()->first();
                    $registro->update(['fecha_retomada' => NOW()]);
                }

                PanelTiempoEstados::create([
                    'nombre_estado' => 'Cancelada',
                    'fecha_estado' => NOW(),
                    'fk_num_solicitud' => $solicitud,
                ]);
                PanelRequisiciones::actualizarSolicitud($solicitud, $datos);
            } else if ($estado == 10) { //Esta condición cambia la solicitud a finalizada parcialmente
                $datos['estado'] = $estado;
                $datos['dias_proceso'] = $formData['dias_proceso'];
                $datos['dias_proceso_real'] = $formData['dias_proceso_real'];
                $datos['dias_aplazado'] = $formData['dias_aplazado'];
                $datos['fecha_finalizado_parcial'] = NOW();

                if ($infoDBSoli->estado == 9) {
                    $registro = PanelTiempoEstados::where('nombre_estado', 'Aplazado')->latest()->first();
                    $registro->update(['fecha_retomada' => NOW()]);
                }

                PanelTiempoEstados::create([
                    'nombre_estado' => 'Finalizado',
                    'fecha_estado' => NOW(),
                    'fk_num_solicitud' => $solicitud,
                ]);
                PanelRequisiciones::actualizarSolicitud($solicitud, $datos);

            } else if ($estado == 6) { //Esta condición cambia la solicitud a finalizada
                $datos['estado'] = $estado;
                $datos['fecha_finalizacion'] = NOW();
                $datos['dias_proceso'] = $formData['dias_proceso'];
                $datos['dias_proceso_real'] = $formData['dias_proceso_real'];
                $datos['dias_aplazado'] = $formData['dias_aplazado'];

                PanelRequisiciones::actualizarSolicitud($solicitud, $datos);

                if ($infoDBSoli->estado == 9) {
                    $registro = PanelTiempoEstados::where('nombre_estado', 'Aplazado')->latest()->first();
                    $registro->update(['fecha_retomada' => NOW()]);
                }

                PanelTiempoEstados::create([
                    'nombre_estado' => 'Cerrado',
                    'fecha_estado' => NOW(),
                    'fk_num_solicitud' => $solicitud,
                ]);
            }

            $dataCorreo = PanelRequisiciones::getSolicitud($solicitud)[0];
            $correoUsuario = PanelEmpleados::getEmpleado($dataCorreo->usr_solicita)[0]->correo;
            $dataCorreo->cargo = PanelCargos::getCargo($dataCorreo->cargo)[0]->descripcion;
            $dataCorreo->centro_operacion = PanelCentrosOp::getCentroOp($dataCorreo->centro_operacion)[0]->descripcion;
            $dataCorreo->link_solicitud = env('APP_URL') . '/Berhlan/public/panel/requisiciones/solicitud/masinfo/' . $dataCorreo->num_solicitud;
            $dataCorreo->cambioEstado = 1;

            $dataCorreo = (array) $dataCorreo;

            $elementosTIC = PanelSoliRequiere::getElementosSoliArea($solicitud, '10');

            $elementosSOP = PanelSoliRequiere::getElementosSoliArea($solicitud, '17');

            $dotacionesSOP = PanelDotacionesSoli::getDotacionesSoli($solicitud);

            if ($elementosTIC->isNotEmpty()) {
                // Se notifica el cambio de estado segun si en esta solicitud se requiere elementos que provee TIC
                Mail::send('email.email_requision_personal.notificacion_solicitud_personal', $dataCorreo, function ($message) use ($dataCorreo) {
                    $message->subject('Notificaciones Intranet');
                    $message->from('notificacionesberhlan@berhlan.com');
                    $message->to($correo->correo);
                });

            }

            if ($elementosSOP->isNotEmpty() || $dotacionesSOP->isNotEmpty()) {
                $correosSOP = \DB::table('param_cargos AS p_c')
                    ->join('param_empleados AS p_e', 'p_e.cargo', '=', 'p_c.id_cargo')
                    ->select('p_e.correo')
                    ->where('p_c.AREA', '=', '17')
                    ->where('p_e.estado', '=', '1')
                    ->where('p_e.centro_op', '=', '1')
                    ->where('p_e.correo', 'LIKE', '%@berhlan.com')
                    ->get();

                foreach ($correosSOP as $key => $correo) {
                    // Se notifica el cambio de estado segun si en esta solicitud se requiere elementos que provee SOPORTE ADMINISTRATIVO
                    Mail::send('email.email_requision_personal.notificacion_solicitud_personal', $dataCorreo, function ($message) use ($dataCorreo, $correo) {
                        $message->subject('Notificaciones Intranet');
                        $message->from('notificacionesberhlan@berhlan.com');
                        $message->to($correo->correo);
                    });
                }

            }
            if ($estado != 9 || isset($notificar_solicitante)) {
                Mail::send('email.email_requision_personal.notificacion_solicitud_personal', $dataCorreo, function ($message) use ($dataCorreo, $correoUsuario) {
                    $message->subject('Notificaciones Intranet');
                    $message->from('notificacionesberhlan@berhlan.com');
                    $message->to($correoUsuario);
                });
            }

            toastr()->success('¡Actualización de estado exitoso!', '¡Exito!', ['positionClass' => 'toast-bottom-right']);
            return back();

        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }

    }

    public function crearExamenesIngresos(Request $request)
    {
        if (Session::has('user')) {
            $formData = $request::all();
            $examen_medico_values = [];
            foreach ($formData as $key => $value) {
                if (strpos($key, 'examen_medico') === 0) {
                    $examen_medico_values[] = $value;
                }
            }
            $generos_values = [];
            foreach ($formData as $key => $value) {
                if (strpos($key, 'genero') === 0) {
                    $generos_values[] = $value;
                }
            }
            $infoSolicitud = PanelRequisiciones::getSolicitud($formData['fk_num_solicitud'])[0];
            $usuariosNotificar = PanelReglasNoti::where('fk_id_centro_op', $infoSolicitud->centro_operacion)->get();
            foreach ($usuariosNotificar as $usuario) {
                $correosExamen[] = PanelEmpleados::getEmpleado($usuario->fk_id_empleado)[0]->correo;
            }

            foreach ($formData['cedula_soli_ingreso'] as $key => $value) {

                $numero_examen = null;
                $examen = null;

                if ($examen_medico_values[$key] == "Si") {
                    $numero_examen = PanelSoliExamenes::orderByRaw('CAST(SUBSTRING(consec_examen, 5) AS UNSIGNED) DESC')
                        ->selectRaw('CAST(SUBSTRING(consec_examen, 5) AS UNSIGNED) as numero')
                        ->pluck('numero')
                        ->first();
                    $numero_examen = $numero_examen != null ? $numero_examen + 1 : 1;

                    $examen = PanelSoliExamenes::create([
                        'consec_examen' => 'SSL-' . $numero_examen,
                        'estado_examen' => 1,
                        'fk_num_solicitud' => $formData['fk_num_solicitud'],
                    ]);

                    $dataCorreo = PanelSoliExamenes::getInfoExamen($examen->id_soli_examen);

                    $dataCorreo[0]->link_examen = env('APP_URL') . '/Berhlan/public/panel/ssl/examenes/solicitud/' . $examen->id_soli_examen;
                    $dataCorreo = (array) $dataCorreo[0];

                    foreach ($correosExamen as $index => $correo) {
                        Mail::send('email.email_ssl.notificacion_solicitud_examen', $dataCorreo, function ($message) use ($dataCorreo, $correo) {
                            $message->subject('Notificaciones Intranet');
                            $message->from('notificacionesberhlan@berhlan.com');
                            $message->to($correo);
                        });
                    }
                }

                PanelIngresos::create([
                    'consecutivo' => $formData['consecutivo'][$key],
                    'nombre_soli_ingreso' => $formData['nombre_soli_ingreso'][$key],
                    'genero_soli_ingreso' => $generos_values[$key],
                    'cedula_soli_ingreso' => $value,
                    'correo_soli_ingreso' => $formData['correo_soli_ingreso'][$key],
                    'telefono_soli_ingreso' => $formData['telefono_soli_ingreso'][$key],
                    'estado_soli_ingreso' => $examen_medico_values[$key] == "Si" ? 1 : 0,
                    'fk_num_solicitud' => $formData['fk_num_solicitud'],
                    'fk_id_soli_examen' => $examen != null ? $examen->id_soli_examen : null,
                ]);
            }
            toastr()->success('¡Acción realizada exitosamente!', '¡Exito!', ['positionClass' => 'toast-bottom-right']);
            return redirect()->back();

        }
    }

    public function enviarNovedad()
    {

        if (Session::has('user')) {
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);
            $formData = Request::all();
            $solicitud = $formData['id_solicitud'];
            $descripcion_novedad = $formData['descripcion_novedad'];
            $fecha_novedad = now()->format('Y-m-d H:i:s');
            $empleado = $DatosUsuario[0]->empleado;
            $correo = PanelEmpleados::getEmpleado($DatosUsuario[0]->empleado)[0]->correo;

            $datos = [
                'fecha_novedad' => $fecha_novedad,
                'fk_num_solicitud' => $solicitud,
                'fk_id_empleado' => $empleado,
                'descripcion_novedad' => $descripcion_novedad,
            ];

            $novedad = PanelNovedades::create($datos);
            $info_solicitud = PanelRequisiciones::getSolicitud($solicitud);
            $dataCorreo['fecha'] = $fecha_novedad;
            $dataCorreo['solicitud'] = $info_solicitud[0]->num_solicitud;
            $dataCorreo['cargo'] = PanelCargos::getCargo($info_solicitud[0]->cargo)[0]->descripcion;
            $dataCorreo['estado'] = $info_solicitud[0]->estado;
            $dataCorreo['descripcion_novedad'] = $descripcion_novedad;
            $dataCorreo['link_solicitud'] = env('APP_URL') . '/Berhlan/public/panel/requisiciones/solicitud/masinfo/' . $dataCorreo['solicitud'];

            Mail::send('email.email_requision_personal.notificacion_novedad_solicitud', $dataCorreo, function ($message) use ($dataCorreo, $correo) {
                $message->subject('Notificaciones Intranet');
                $message->from('notificacionesberhlan@berhlan.com');
                $message->to($correo->correo);
            });

        }
        toastr()->success('¡Novedad creada exitosamente!', '¡Exito!', ['positionClass' => 'toast-bottom-right']);
        return back();
    }

    public function exportarSolicitudes()
    {

        if (Session::has('user')) {

            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);
            $formData = Request::all();
            $nivelPermiso = PanelPermisosAutorizacion::where('fk_id_empleado', $DatosUsuario[0]->empleado)->pluck('nivel_permiso_aut');
            if ($nivelPermiso[0] == 1) {
                $formData['centro_operacion'] = PanelEmpleados::getEmpleado($DatosUsuario[0]->empleado)[0]->centro_op;
            }

            if (isset($estado)) {
                $formData['estado'] = explode(',', $formData['estado']);
            }

            if (!isset($formData['fecha_solicitud_final'])) {
                $formData['fecha_solicitud_final'] = null;
            }

            $datos = [
                'fecha_solicitud_inicial' => $formData['fecha_solicitud_inicial'],
                'fecha_solicitud_final' => $formData['fecha_solicitud_final'],
                'centro_operacion' => $formData['centro_operacion'],
                'estado' => $formData['estado'],
            ];

            return Excel::download(new SolicitudesRequicisionesPersonalExport($datos), 'solicitudes.xlsx');

        }
        return view('panel-login');
    }

    public function gestionarNivelesCargos()
    {
        $formData = Request::all();
        $nombre_nivel_cargo = $formData['nombre_nivel_cargo'];
        $dias_nivel_cargo = $formData['dias_nivel_cargo'];
        $estado_nivel_cargo = $formData['estado_nivel_cargo'];

        foreach ($nombre_nivel_cargo as $key => $value) {
            PanelNivelesCargos::updateOrCreate(
                [
                    'nombre_nivel_cargo' => $value,
                ],
                [
                    'nombre_nivel_cargo' => $value,
                    'dias_nivel_cargo' => $dias_nivel_cargo[$key],
                    'estado_nivel_cargo' => $estado_nivel_cargo[$key],
                ]
            );
        }
    }

    public function migrarInfo()
    {

        $results = \DB::select('SELECT num_solicitud, requiere FROM rqpe_solicitud WHERE requiere IS NOT NULL AND requiere <> ""');

        foreach ($results as $key => $value) {
            $value->requiere = explode('.', $value->requiere);
            $value->requiere = array_map('trim', $value->requiere);
            $value->requiere = array_filter($value->requiere);

            foreach ($value->requiere as $key => $valor) {

                if ($valor === 'Computadora portátil') {
                    $value->requiere[$key] = '1';
                } else if ($valor === 'Computadora de escritorio') {
                    $value->requiere[$key] = '2';
                } else if ($valor === 'Teléfono/sim corporativo') {
                    $value->requiere[$key] = '3';
                } else if ($valor === 'Puesto de trabajo') {
                    $value->requiere[$key] = '4';
                } else if ($valor === 'Silla') {
                    $value->requiere[$key] = '5';
                }
                $datos = [
                    'fk_num_solicitud' => $value->num_solicitud,
                    'fk_id_herramienta' => $value->requiere[$key],
                ];

                PanelSoliRequiere::create($datos);
            }
        }

        return $results;
    }

    public function getTallasDotacion(Request $request)
    {
        $id_dotacion = $request::input('id_dotacion');
        $dotacion = PanelDotaciones::where('id_dotacion', $id_dotacion)->get();
        $tipo_dotacion = PanelTipoDotacion::where('id_tipo_dotacion', $dotacion[0]->fk_id_tipo_dotacion)->get();
        $tallas = PanelTallaDotacion::where('fk_id_tipo_dotacion', $tipo_dotacion[0]->id_tipo_dotacion)->get();
        return response()->json($tallas);
    }

    public function pedirDotaciones(Request $request)
    {

        if (Session::has('user')) {
            $fk_num_solicitud = $request::input('num_solicitud');
            $id_soli_ingreso = $request::input('id_soli_ingreso');
            $dotaciones = $request::input('dotacion');
            $tallas = $request::input('talla');
            $cantidades = $request::input('cantidad');

            foreach ($dotaciones as $key => $value) {

                PanelDotacionesSoli::create([
                    'fk_id_dotacion' => $value,
                    'fk_id_talla_dotacion' => $tallas[$key],
                    'cantidad_dotacion' => $cantidades[$key],
                    'fk_num_solicitud' => $fk_num_solicitud,
                    'fk_id_soli_ingreso' => $id_soli_ingreso,
                ]);
            }
            return redirect()->back();
        }
    }

}
