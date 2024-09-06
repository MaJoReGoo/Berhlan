<?php

namespace App\Http\Controllers\Ssl;

use App\Http\Controllers\Controller;
use App\Models\PanelLogin;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Requisiciones\PanelIngresos;
use App\Models\Requisiciones\PanelPermisosAutorizacion;
use App\Models\Ssl\PanelPermisosExamen;
use App\Models\Ssl\PanelReprogramaciones;
use App\Models\Ssl\PanelSoliExamenes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class ExamenesRequisicionesPanelController extends Controller
{
    public function solicitudesExamenes()
    {
        if (Session::has('user')) {
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);
            $empleado = PanelEmpleados::getEmpleado($DatosUsuario[0]->empleado);
            $nivelPermiso = PanelPermisosExamen::where('fk_id_empleado', $empleado[0]->id_empleado)->pluck('nivel_permiso')->toArray();

            if (empty($nivelPermiso)) {
                return redirect('/panel/menu/128');
            }

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "requisiones/examenes";
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

            if ($nivelPermiso[0] !== 3) {
                $soli_examenes = PanelSoliExamenes::getExamenesCentroOp($empleado[0]->centro_op);
            } else {
                $soli_examenes = PanelSoliExamenes::getExamenes();
            }

            return view('ssl.panel-examenes_solicitudes')->with('DatosUsuario', $DatosUsuario)->with('soli_examenes', $soli_examenes);

        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function solicitudExamen($id)
    {
        if (Session::has('user')) {
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);
            $empleado = PanelEmpleados::getEmpleado($DatosUsuario[0]->empleado);
            $nivelPermiso = PanelPermisosExamen::where('fk_id_empleado', $empleado[0]->id_empleado)->pluck('nivel_permiso')->toArray();

            if (empty($nivelPermiso)) {
                return redirect('/panel/menu/128');
            }

            //Valido que el usuario tenga acceso en la intranet
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "ssl/examenes";
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

            $soli_examenes = PanelSoliExamenes::getExamenDetalle($id);

            $reprogramacion = PanelReprogramaciones::where('fk_id_soli_examen', $id)
                ->orderBy('created_at', 'desc')
                ->first();

            $reprogramaciones = PanelReprogramaciones::where('fk_id_soli_examen', $id)->get();

            return view('ssl.panel-gestionar_soli_examen')->with('DatosUsuario', $DatosUsuario)->with('soli_examenes', $soli_examenes)
                ->with('reprogramacion', $reprogramacion)->with('nivelPermiso', $nivelPermiso)->with('reprogramaciones', $reprogramaciones);

        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function programarExamen(Request $request)
    {
        $examen = PanelSoliExamenes::findOrFail($request->id_soli_examen);
        $examen->lugar = $request->lugar;
        $examen->fecha = $request->fecha;
        $examen->hora = $request->hora;
        $examen->estado_examen = 2;
        $examen->preparacion = $request->preparacion;
        $examen->save();

        $infoExamen = PanelSoliExamenes::getExamenDetalle($request->id_soli_examen);
        $infoExamen[0]->agendar = true;
        $infoExamen = (array) $infoExamen[0];

        $correos = PanelPermisosAutorizacion::join('param_empleados', 'param_empleados.id_empleado', '=', 'rqpe_permisos_autorizacion.fk_id_empleado')
            ->where('centro_op', $infoExamen['centro_operacion'])
            ->pluck('correo');

        foreach ($correos as $correo) {

            Mail::send('email.email_ssl.notificacion_info_examen', $infoExamen, function ($message) use ($infoExamen,$correo) {
                $message->subject('Notificaciones Intranet');
                $message->from('notificacionesberhlan@berhlan.com');
                $message->to($correo);
            });
        }
        toastr()->success('¡Programación realizada con exito!', '¡Programación exitosa!', ['positionClass' => 'toast-bottom-right']);
        return redirect()->back();
    }

    public function reprogramarExamen(Request $request)
    {
        $examen = PanelSoliExamenes::findOrFail($request->id_soli_examen);

        if ($request->asistencia == 1 && $request->reprogramar == 'No') {
            $examen->asistencia = 1;
            $examen->save();
        } else if ($request->asistencia == 1 && $request->reprogramar == 'Si') {
            $examen->asistencia = 1;
            PanelReprogramaciones::create([
                'fecha' => $examen->fecha,
                'hora' => $examen->hora,
                'fk_id_soli_examen' => $examen->id_soli_examen,
            ]);
            $examen->fecha = $request->nuevafecha;
            $examen->hora = $request->nuevahora;
            $examen->save();

            $infoExamen = PanelSoliExamenes::getExamenDetalle($request->id_soli_examen);
            $infoExamen[0]->agendar = true;
            $infoExamen = (array) $infoExamen[0];


            $correos = PanelPermisosAutorizacion::join('param_empleados', 'param_empleados.id_empleado', '=', 'rqpe_permisos_autorizacion.fk_id_empleado')
                ->where('centro_op', $infoExamen['centro_operacion'])
                ->pluck('correo');
            foreach ($correos as $correo) {

                Mail::send('email.email_ssl.notificacion_info_examen', $infoExamen, function ($message) use ($infoExamen,$correos) {
                    $message->subject('Notificaciones Intranet');
                    $message->from('notificacionesberhlan@berhlan.com');
                    $message->to($correo);
                });
            }



        }
        return redirect()->back();
    }

    public function confirmarExamen(Request $request)
    {
        $examen = PanelSoliExamenes::findOrFail($request->id_soli_examen);
        $ruta = substr(public_path(), 0, -14) . 'public/archivos/Requisiciones/conceptos/';

        if ($request->asistencia == '2' && $request->concepto == null && $request->estado_examen == null) {
            $examen->asistencia = 2;
            $examen->estado_examen = 3;
            $examen->save();

            $infoExamen = PanelSoliExamenes::getExamenDetalle($request->id_soli_examen);
            $infoExamen = (array) $infoExamen[0];

            $correos = PanelPermisosAutorizacion::join('param_empleados', 'param_empleados.id_empleado', '=', 'rqpe_permisos_autorizacion.fk_id_empleado')
                ->where('centro_op', $infoExamen['centro_operacion'])
                ->pluck('correo');

            foreach ($correos as $correo) {
                Mail::send('email.email_ssl.notificacion_info_examen', $infoExamen, function ($message) use ($infoExamen,$correo) {
                    $message->subject('Notificaciones Intranet');
                    $message->from('notificacionesberhlan@berhlan.com');
                    $message->to($correo);
                });
            }



        } else if ($request->asistencia == '2' && $request->concepto != null && $request->estado_examen == 4) {
            $examen->asistencia = 2;
            $concepto = $request->file('concepto');
            $nombre_archivo = $concepto->getClientOriginalName();
            $concepto->move($ruta, $nombre_archivo);
            $examen->concepto = $nombre_archivo;
            $examen->estado_examen = 4;
            $examen->save();
            PanelIngresos::where('fk_id_soli_examen', $examen->id_soli_examen)->update(['estado_soli_ingreso' => 3]);

            $infoExamen = PanelSoliExamenes::getExamenDetalle($request->id_soli_examen);
            $infoExamen = (array) $infoExamen[0];

            $correos = PanelPermisosAutorizacion::join('param_empleados', 'param_empleados.id_empleado', '=', 'rqpe_permisos_autorizacion.fk_id_empleado')
                ->where('centro_op', $infoExamen['centro_operacion'])
                ->pluck('correo');

            foreach ($correos as $correo) {
                Mail::send('email.email_ssl.notificacion_info_examen', $infoExamen, function ($message) use ($infoExamen,$correo) {
                    $message->subject('Notificaciones Intranet');
                    $message->from('notificacionesberhlan@berhlan.com');
                    $message->to($correo);
                });
            }



        } else if ($request->asistencia == '2' && $request->concepto != null && $request->estado_examen == 5) {
            $examen->asistencia = 2;
            $concepto = $request->file('concepto');
            $nombre_archivo = $concepto->getClientOriginalName();
            $concepto->move($ruta, $nombre_archivo);
            $examen->concepto = $nombre_archivo;
            $examen->estado_examen = 5;
            $examen->save();
            PanelIngresos::where('fk_id_soli_examen', $examen->id_soli_examen)->update(['estado_soli_ingreso' => 2]);

            $infoExamen = PanelSoliExamenes::getExamenDetalle($request->id_soli_examen);
            $infoExamen = (array) $infoExamen[0];

            $correos = PanelPermisosAutorizacion::join('param_empleados', 'param_empleados.id_empleado', '=', 'rqpe_permisos_autorizacion.fk_id_empleado')
                ->where('centro_op', $infoExamen['centro_operacion'])
                ->pluck('correo');

            foreach ($correos as $correo) {
                Mail::send('email.email_ssl.notificacion_info_examen', $infoExamen, function ($message) use ($infoExamen,$correo) {
                    $message->subject('Notificaciones Intranet');
                    $message->from('notificacionesberhlan@berhlan.com');
                    $message->to($correo);
                });
            }



        }
        toastr()->success('¡Accion realizada con exito!', '¡Accion exitosa!', ['positionClass' => 'toast-bottom-right']);
        return redirect()->back();
    }

    public function descargarConcepto($archivo)
    {
        $rutaCompleta = substr(public_path(), 0, -14) . 'public/archivos/Requisiciones/conceptos/' . $archivo;

        if (file_exists($rutaCompleta)) {
            return response()->download($rutaCompleta);
        } else {
            return abort(404, 'Archivo no encontrado.');
        }
    }

}
