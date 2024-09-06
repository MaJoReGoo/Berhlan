<?php

namespace App\Http\Controllers\Ssl;

use App\Http\Controllers\Controller;
use App\Models\PanelLogin;
use App\Models\Parametrizacion\PanelCentrosOp;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Ssl\PanelPermisosExamen;
use App\Models\Ssl\PanelReglasNoti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class GestionarNotificacionesPermisosController extends Controller
{

    public function gestionarNotificacionesPermisos()
    {
        if (Session::has('user')) {
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "ssl/permisos";
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
            $empleados = PanelEmpleados::EmpleadosActivos();
            $centros_op = PanelCentrosOp::getCentrosOpActivos();
            $nivelesPermisos = [1, 2, 3];
            $empleadoNoti;
            foreach ($centros_op as $key => $centro_op) {
                $datosNoti = PanelReglasNoti::where('fk_id_centro_op', $centro_op->id_centro)->pluck('fk_id_empleado')->toArray();
                $empleadoNoti[$centro_op->id_centro] = $datosNoti;
            }

            $empleadoPermisos;
            foreach ($nivelesPermisos as $key => $nivelPermiso) {
                $datosPermisos = PanelPermisosExamen::where('nivel_permiso', $nivelPermiso)->pluck('fk_id_empleado')->toArray();
                $empleadoPermisos[$nivelPermiso] = $datosPermisos;
            }

            return view('ssl.panel-gestion_noticaciones_permisos')->with('DatosUsuario', $DatosUsuario)->with('empleados', $empleados)->with('centros_op', $centros_op)
                ->with('nivelesPermisos', $nivelesPermisos)->with('empleadoNoti', $empleadoNoti)->with('empleadoPermisos', $empleadoPermisos);

        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function gestionarNotificaciones(Request $request)
    {
        foreach ($request->except('_token') as $key => $value) {
            $infoDB = PanelReglasNoti::where('fk_id_centro_op', $key)->pluck('fk_id_empleado')->toArray();
            $nuevosDatos = $value;

            $dataEliminar = array_diff($infoDB, $nuevosDatos);
            $dataAgregar = array_diff($nuevosDatos, $infoDB);

            if (!empty($dataEliminar)) {
                foreach ($dataEliminar as $empleado) {
                    PanelReglasNoti::where('fk_id_centro_op', $key)->where('fk_id_empleado', $empleado)->delete();
                }
            }

            // Crear el nuevo elemento
            if (!empty($dataAgregar)) {
                foreach ($dataAgregar as $empleado) {
                    PanelReglasNoti::create(['fk_id_centro_op' => $key, 'fk_id_empleado' => $empleado]);
                }

            }

        }
        toastr()->success('¡Acción realizada con exito!', '¡Operacíon exitosa!', ['positionClass' => 'toast-bottom-right']);
        return redirect()->back();

    }

    public function gestionarPermisos(Request $request)
    {

        foreach ($request->except('_token') as $key => $value) {
            $key = explode('-', $key)[1];
            $infoDB = PanelPermisosExamen::where('nivel_permiso', $key)->pluck('fk_id_empleado')->toArray();
            $nuevosDatos = $value;

            $dataEliminar = array_diff($infoDB, $nuevosDatos);
            $dataAgregar = array_diff($nuevosDatos, $infoDB);

            if (!empty($dataEliminar)) {
                foreach ($dataEliminar as $empleado) {
                    PanelPermisosExamen::where('nivel_permiso', $key)->where('fk_id_empleado', $empleado)->delete();
                }
            }

            if (!empty($dataAgregar)) {
                foreach ($dataAgregar as $empleado) {
                    PanelPermisosExamen::create(['nivel_permiso' => $key, 'fk_id_empleado' => $empleado]);
                }
            }

        }
        toastr()->success('¡Acción realizada con exito!', '¡Operacíon exitosa!', ['positionClass' => 'toast-bottom-right']);
        return redirect()->back();
    }

}
