<?php
/*
Controlador de la tabla rqpe_solicitud
Usa SQl Eloquent del archivo app\Models\Requisiciones\PanelSolicitudes.php
 */

namespace App\Http\Controllers\Requisiciones;


use App\Http\Controllers\Controller;
use App\Models\PanelLogin;
use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelCentrosOp;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Requisiciones\PanelIngresos;
use App\Models\Requisiciones\PanelNivelesCargos;
use App\Models\Requisiciones\PanelNovedades;
use App\Models\Requisiciones\PanelRequisiciones;
use App\Models\Requisiciones\PanelTiempoEstados;
use App\Models\Requisiciones\PanelTpcontratos;
use App\Models\Requisiciones\PanelHerramientas;
use App\Models\Requisiciones\PanelDotacionesSoli;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Request;

class ConsultasRequisicionesPanelController extends Controller
{
    public function ConsultaUsuario()
    {
        if (Session::has('user')) {
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "requisiciones/consultausr";
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

            return view('requisiciones.panel-consultaUsr')->with('DatosUsuario', $DatosUsuario);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function ConsultaUsrListado()
    {
        if (Session::has('user')) {
            $formData = Request::all();
            $solicitud = trim($formData['solicitud']);
            $cargo = $formData['cargo'];
            $centro_op = $formData['centro_op'];
            $motivo = $formData['motivo'];
            $reemplaza = $formData['reemplaza'];
            $estado = $formData['estado'];
            $soldesde = trim($formData['soldesde']);
            $solhasta = trim($formData['solhasta']);
            $cierredesde = trim($formData['cierredesde']);
            $cierrehasta = trim($formData['cierrehasta']);
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);
            $empleado = $DatosUsuario[0]->empleado;

            $Mensaje = "";
            $sql = "SELECT * FROM rqpe_solicitud WHERE usr_solicita = '$empleado' ";

            if ($solicitud != '') //Si ingreso la solicitud
            {
                if (!ctype_digit($solicitud)) //La solicitud debe ser un numero
                {
                    $Mensaje = "La solicitud debe ser numérica.";
                } else {
                    $sql = $sql . " AND num_solicitud = '$solicitud' ";
                }

            } else {
                if ($cargo != "") {
                    $sql = $sql . " AND cargo = '$cargo' ";
                }

                if ($centro_op != "") {
                    $sql = $sql . " AND centro_operacion = '$centro_op' ";
                }

                if ($motivo != "") {
                    $sql = $sql . " AND motivo = '$motivo' ";
                }

                if ($reemplaza != "") {
                    $sql = $sql . " AND reemplaza_a like '%$reemplaza%' ";
                }

                if ($estado != "") {
                    $sql = $sql . " AND estado = '$estado' ";
                }

                if ($soldesde != "") {
                    $Mensaje = ConsultasRequisicionesPanelController::valida_fecha($soldesde);
                    if ($Mensaje != "") {
                        $Redireccion = "/panel/requisiciones/consultausr";
                        return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
                    } else {
                        $sql = $sql . " AND fecha_solicita >= '$soldesde 00:00:00' ";
                    }
                }

                if ($solhasta != "") {
                    $Mensaje = ConsultasRequisicionesPanelController::valida_fecha($solhasta);
                    if ($Mensaje != "") {
                        $Redireccion = "/panel/requisiciones/consultausr";
                        return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
                    } else {
                        $sql = $sql . " AND fecha_solicita <= '$solhasta 23:59:59' ";
                    }
                }

                if ($cierredesde != "") {
                    $Mensaje = ConsultasRequisicionesPanelController::valida_fecha($cierredesde);
                    if ($Mensaje != "") {
                        $Redireccion = "/panel/requisiciones/consultausr";
                        return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
                    } else {
                        $sql = $sql . " AND fecha_cierre >= '$cierredesde 00:00:00' ";
                    }
                }

                if ($cierrehasta != "") {
                    $Mensaje = ConsultasRequisicionesPanelController::valida_fecha($cierrehasta);
                    if ($Mensaje != "") {
                        $Redireccion = "/panel/requisiciones/consultausr";
                        return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
                    } else {
                        $sql = $sql . " AND fecha_cierre <= '$cierrehasta 23:59:59' ";
                    }
                }
            }

            $sql = $sql . " ORDER BY fecha_solicita ";
            $DatosSolicitudes = PanelRequisiciones::getSolicitudSql($sql);
            $sol = "";
            foreach ($DatosSolicitudes as $DatSol) {
                $sol = 1;
            }

            //No se encontró ningún registro
            if ($sol == "") {
                $Mensaje = "No se encuentran solicitudes realizadas por usted, con los parámetros ingresados.";
            }

            if ($Mensaje != "") {
                $Redireccion = "/panel/requisiciones/consultausr";
                return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
            } else {
                return view('requisiciones.panel-consultaUsrListado')->with('DatosUsuario', $DatosUsuario)->with('DatosSolicitudes', $DatosSolicitudes);
            }
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function ConsultaUsrMasinfo($id)
    {
        if (Session::has('user')) {
            $Solicitud = $id;
            $DatosSolicitud = PanelRequisiciones::getSolicitud($Solicitud);
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            //Valido que la solicitud exista
            $e = 0;
            foreach ($DatosSolicitud as $DatSol) {
                $e++;
            }

            if ($e == 0) {
                $Mensaje = "Solicitud no existe.";
                $Redireccion = "/panel/requisiciones/consultausr";
                return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
            }

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "requisiciones/consultausr";
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

            if ($DatosSolicitud[0]->usr_solicita != $DatosUsuario[0]->empleado) {
                $ErrorValidacion = "Usted no tiene acceso al requerimiento seleccionado.";
                return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
            }

            return view('requisiciones.panel-consultaUsrMasinfo')->with('DatosUsuario', $DatosUsuario)->with('DatosSolicitud', $DatosSolicitud);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function ConsultaAdm()
    {
        if (Session::has('user')) {
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "requisiciones/consultaadm";
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

            return view('requisiciones.panel-consultaAdm')->with('DatosUsuario', $DatosUsuario);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function ConsultaAdmListado()
    {
        if (Session::has('user')) {
            $solicitudes = PanelRequisiciones::getSolicitudes();

            foreach ($solicitudes as $key => $solicitud) {

                $solicitud->centro_operacion = PanelCentrosOp::getCentroOp($solicitud->centro_operacion)[0]->descripcion;

                if ($solicitud->estado == '1') {
                    $solicitud->nombre_estado = 'Pendiente';
                } else if ($solicitud->estado == '5' || $solicitud->estado == '3') {
                    $solicitud->nombre_estado = 'Activo';
                } else if ($solicitud->estado == '6') {
                    $solicitud->nombre_estado = 'Cerrado';
                } else if ($solicitud->estado == '9') {
                    $solicitud->nombre_estado = 'Aplazado';
                } else if ($solicitud->estado == '7' || $solicitud->estado == '8') {
                    $solicitud->nombre_estado = 'Cancelado';
                } else if ($solicitud->estado == '2' || $solicitud->estado == '4') {
                    $solicitud->nombre_estado = 'Rechazado';
                } else if ($solicitud->estado == '10') {
                    $solicitud->nombre_estado = 'Finalizado';
                }
                $solicitud->fecha_solicita = Carbon::parse($solicitud->fecha_solicita)->format('d/m/Y');
                $solicitud->cargo = PanelCargos::getCargo($solicitud->cargo)[0]->descripcion;

                if ($solicitud->motivo == 'RP') {
                    $solicitud->nombre_motivo = 'Reemplazo de personal';
                } elseif ($solicitud->motivo == 'CN') {
                    $solicitud->nombre_motivo = 'Cargo nuevo / Incremento de personal';
                } elseif ($solicitud->motivo == 'LM') {
                    $solicitud->nombre_motivo = 'Licencia de maternidad';
                } elseif ($solicitud->motivo == 'IP') {
                    $solicitud->nombre_motivo = 'Incapacidad permanente';
                }
                $empleado = PanelEmpleados::getEmpleado($solicitud->usr_solicita);
                $solicitud->nombre_usr_solicita = $empleado[0]->primer_nombre . ' ' . $empleado[0]->ot_nombre . ' ' . $empleado[0]->primer_apellido . ' ' . $empleado[0]->ot_apellido;

            }

            return response()->json($solicitudes);
        }
    }

    public function ConsultaAdmMasinfo($Solicitud)
    {
        if (Session::has('user')) {
            $DatosSolicitud = PanelRequisiciones::getSolicitud($Solicitud);
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);
            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "requisiciones/consultaadm";
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

            if ($DatosSolicitud[0]->estado != 1 && $DatosSolicitud[0]->tpcontrato != 0) {
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

            return view('requisiciones.panel-consultaAdmMasinfo')->with('DatosUsuario', $DatosUsuario)
                ->with('DatosSolicitud', $DatosSolicitud)->with('dotaciones', $dotaciones)->with('herramientas', $herramientas)->with('soliRequiere', $soliRequiere)
                ->with('novedades', $novedades)->with('tiempos_estados_solicitud', $tiempos_estados_solicitud)->with('ingresos', $ingresos);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

}
