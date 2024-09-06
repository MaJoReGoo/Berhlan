<?php

namespace App\Http\Controllers\Requerimientos;

use App\Http\Controllers\Controller;
use App\Models\PanelLogin;
use App\Models\Parametrizacion\PanelAreas;
use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelCentrosOp;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Requerimientos\PanelRequSoliElementos;
use App\Models\Requisiciones\PanelDotacionesSoli;
use App\Models\Requisiciones\PanelHerramientas;
use App\Models\Requisiciones\PanelIngresos;
use App\Models\Requisiciones\PanelRequisiciones;
use App\Models\Requisiciones\PanelSoliRequiere;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ElementosRequisicionesPanelController extends Controller
{
    public function SolicitudElementos()
    {
        if (Session::has('user')) {
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "requerimientos/elementos";
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

            return view('requerimientos.panel-elementos_requisiciones')->with('DatosUsuario', $DatosUsuario);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function SolicitudesElementosArea()
    {
        if (Session::has('user')) {
            $user = Session::get('user');
            $datosUsuario = PanelLogin::getUsuario($user);
            $empleado = PanelEmpleados::getEmpleado($datosUsuario[0]->empleado);
            $cargo = PanelCargos::getCargo($empleado[0]->cargo);
            $area = PanelAreas::getArea($cargo[0]->area)[0]->id_area;

            $estados = [
                1 => 'Pendiente',
                2 => 'Entregado parcial',
                3 => 'Entregado',
                4 => 'Cancelado',
            ];

            if ($area == 10 || $DatosUsuario[0]->master) {
                $solicitudes = PanelRequSoliElementos::getSolicitudesElementosArea($area);
            } else if ($area == 17) {
                $elementos = PanelRequSoliElementos::getSolicitudesElementosArea($area);
                $dotaciones = PanelRequSoliElementos::getSolicitudesDotaciones();
                $solicitudes = $elementos->merge($dotaciones)->unique('fk_num_solicitud');
                $solicitudes = $solicitudes->values()->toArray();
            } else {
                $solicitudes = [];
            }

            foreach ($solicitudes as $key => $solicitud) {
                $solicitud->fecha_aprox_ingreso = Carbon::parse($solicitud->fecha_aprox_ingreso)->format('d/m/Y');
                $solicitud->area = $area;

                if ($area == 10) {
                    $solicitud->estado_tic_soli_elementos = $estados[$solicitud->estado_tic_soli_elementos] ?? $solicitud->estado_tic_soli_elementos;
                }
                if ($area == 17) {
                    $solicitud->estado_sop_soli_elementos = $estados[$solicitud->estado_sop_soli_elementos] ?? $solicitud->estado_sop_soli_elementos;
                }

            }

            return response()->json($solicitudes);
        }
    }

    public function SolicitudElementosInfo($id)
    {
        if (Session::has('user')) {
            $user = Session::get('user');
            $solicitudElementos = PanelRequSoliElementos::where('id_soli_elementos', $id)->get();
            $datosSolicitud = PanelRequisiciones::getSolicitud($solicitudElementos[0]->fk_num_solicitud);
            $datosSolicitud[0]->centro_operacion = PanelCentrosOp::getCentroOp($datosSolicitud[0]->centro_operacion)[0]->descripcion;
            $datosSolicitud[0]->cargo = PanelCargos::getCargo($datosSolicitud[0]->cargo)[0]->descripcion;
            $datosSolicitud[0]->fecha_aprox_ingreso = Carbon::parse($datosSolicitud[0]->fecha_aprox_ingreso)->format('d/m/Y');

            $ingresos = PanelIngresos::where('fk_num_solicitud', $datosSolicitud[0]->num_solicitud)->whereIn('estado_soli_ingreso', ['0', '2'])->get();

            $datosUsuario = PanelLogin::getUsuario($user);
            $empleado = PanelEmpleados::getEmpleado($datosUsuario[0]->empleado);
            $cargo = PanelCargos::getCargo($empleado[0]->cargo);
            $area = PanelAreas::getArea($cargo[0]->area)[0]->id_area;
            $area = 10;

            if ($area == 10 || $DatosUsuario[0]->master) {
                $herramientas = PanelHerramientas::where('area_encargada', '10')->get();
                $elementos = PanelSoliRequiere::getElementosSoliArea($datosSolicitud[0]->num_solicitud, '10');
                $dotaciones = [];
            } else if ($area == 17) {
                $herramientas = PanelHerramientas::where('area_encargada', '17')->get();
                $elementos = PanelSoliRequiere::getElementosSoliArea($datosSolicitud[0]->num_solicitud, '17');
                $dotaciones = PanelDotacionesSoli::getDotacionesSoli($datosSolicitud[0]->num_solicitud);
            }

            return view('requerimientos.panel-detalle_elementos_soli')->with([
                'DatosUsuario' => $datosUsuario,
                'datosSolicitud' => $datosSolicitud,
                'solicitudElementos' => $solicitudElementos,
                'ingresos' => $ingresos,
                'herramientas' => $herramientas,
                'elementos' => $elementos,
                'dotaciones' => $dotaciones,
                'area' => $area,
            ]);
        }
    }

    public function gestionarSolicitudTicElementos(Request $request)
    {
        if (Session::has('user')) {
            $user = Session::get('user');
            $id = $request->input('id_soli_elementos');
            $estadoTicSoliElementos = $request->input('estado_tic_soli_elementos');
            $comentariosTicSoliElementos = $request->input('comentario_tic_soli_elementos');

            PanelRequSoliElementos::where('id_soli_elementos', $id)->update(['estado_tic_soli_elementos' => $estadoTicSoliElementos, 'comentario_tic_soli_elementos' => $comentariosTicSoliElementos]);
        }
        toastr()->success('¡Accion realizada con exito!', '¡Operacíon exitosa!', ['positionClass' => 'toast-bottom-right']);
        return back();
    }

    public function gestionarSolicitudSopElementos(Request $request)
    {
        if (Session::has('user')) {
            $user = Session::get('user');
            $id = $request->input('id_soli_elementos');
            $estadoSopSoliElementos = $request->input('estado_sop_soli_elementos');
            $comentariosSopSoliElementos = $request->input('comentario_sop_soli_elementos');

            PanelRequSoliElementos::where('id_soli_elementos', $id)->update(['estado_sop_soli_elementos' => $estadoSopSoliElementos, 'comentario_sop_soli_elementos' => $comentariosSopSoliElementos]);
        }
        toastr()->success('¡Accion realizada con exito!', '¡Operacíon exitosa!', ['positionClass' => 'toast-bottom-right']);
        return back();
    }

}
