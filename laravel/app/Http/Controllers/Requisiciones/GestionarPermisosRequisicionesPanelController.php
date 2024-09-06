<?php

namespace App\Http\Controllers\Requisiciones;

use App\Http\Controllers\Controller;
use App\Models\PanelLogin;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Requisiciones\PanelPermisosAutorizacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class GestionarPermisosRequisicionesPanelController extends Controller
{
    public function MostrarGestionPermisos()
    {
        if (Session::has('user')) {
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "requisiciones/permisos/autorizacion";
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
            $nivelesPermisos = [1, 2];
            $empleados = $empleados = PanelEmpleados::EmpleadosActivos();

            $empleadosPermisos;
            foreach ($nivelesPermisos as $key => $nivelPermiso) {
                $datosPermisos = PanelPermisosAutorizacion::where('nivel_permiso_aut', $nivelPermiso)->pluck('fk_id_empleado')->toArray();
                $empleadosPermisos[$nivelPermiso] = $datosPermisos;
            }

            return view('requisiciones.panel-gestionarPermisosSolicitudes')->with('DatosUsuario', $DatosUsuario)->with('nivelesPermisos', $nivelesPermisos)->with('empleados', $empleados)
                ->with('empleadosPermisos', $empleadosPermisos);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function GestionarPermisosAutorizar(Request $request)
    {

        foreach ($request->except('_token') as $key => $value) {
            $key = explode('-', $key)[1];

            $infoDB = PanelPermisosAutorizacion::where('nivel_permiso_aut', $key)->pluck('fk_id_empleado')->toArray();
            $nuevosDatos = $value;

            $dataEliminar = array_diff($infoDB, $nuevosDatos);
            $dataAgregar = array_diff($nuevosDatos, $infoDB);

            if (!empty($dataEliminar)) {
                foreach ($dataEliminar as $empleado) {
                    PanelPermisosAutorizacion::where('nivel_permiso_aut', $key)->where('fk_id_empleado', $empleado)->delete();
                }
            }

            if (!empty($dataAgregar)) {
                foreach ($dataAgregar as $empleado) {
                    PanelPermisosAutorizacion::create(['nivel_permiso_aut' => $key, 'fk_id_empleado' => $empleado]);
                }
            }

        }
        return redirect()->back();

    }

}
