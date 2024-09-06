<?php
/*
Controlador de la tabla rqpe_solicitud
Usa SQl Eloquent del archivo app\Models\Requisiciones\PanelSolicitudes.php
 */

namespace App\Http\Controllers\Requisiciones;

use App\Http\Controllers\Controller;
use App\Models\PanelLogin;
use App\Models\Requisiciones\PanelIngresos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class GestionIngresosPanelController extends Controller
{
    public function mostrarVistaIngresos()
    {
        if (Session::has('user')) {
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "requisiciones/gestion/ingresos";
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

            return view('requisiciones.panel-gestion_de_ingresos')->with('DatosUsuario', $DatosUsuario);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function obtenerDatosIngresos()
    {
        if (Session::has('user')) {
            $ingresos = PanelIngresos::whereIn('estado_soli_ingreso', ['0', '1', '2'])->get();

            $ingresos = $ingresos->map(function ($ingreso) {
                if ($ingreso->estado_diligencia_ingreso == 0) {
                    $ingreso->estado_diligencia_ingreso = 'Pendiente por diligenciar';
                } else if ($ingreso->estado_diligencia_ingreso == 1) {
                    $ingreso->estado_diligencia_ingreso = 'Diligenciado';
                }
                return $ingreso;
            });

            return response()->json($ingresos);
        }

    }

    public function obtenerIngresoDetalle(Request $request)
    {
        if (Session::has('user')) {
            $ingresos = PanelIngresos::where('id_soli_ingreso', $request->input('id_soli_ingreso'))->get();

            $ingresos = $ingresos->map(function ($ingreso) {
                if ($ingreso->estado_diligencia_ingreso == 0) {
                    $ingreso->estado_diligencia_ingreso = 'Pendiente por diligenciar';
                } else if ($ingreso->estado_diligencia_ingreso == 1) {
                    $ingreso->estado_diligencia_ingreso = 'Diligenciado';
                }
                if ($ingreso->estado_soli_ingreso == 0) {
                    $ingreso->nombre_estado_ingreso = 'No se requiere examen';
                } else if ($ingreso->estado_soli_ingreso == 1) {
                    $ingreso->nombre_estado_ingreso = 'Pendiente de resultado';
                } else if ($ingreso->estado_soli_ingreso == 2) {
                    $ingreso->nombre_estado_ingreso = 'Aprobado';
                }
                return $ingreso;
            });

            return response()->json($ingresos);
        }

    }

    public function gestionarIngreso(Request $request)
    {
        if (Session::has('user')) {
            $ingresos = PanelIngresos::where('id_soli_ingreso', $request->input('id_soli_ingreso'))->update([
                'fecha_induccion' => $request->input('fecha_induccion'),
                'fecha_inicio_laboral' => $request->input('fecha_inicio_laboral'),
            ]);
            return back();
        }

    }

    public function obtenerExamenesIngresos()
    {
        if (Session::has('user')) {

            $examenesIngresos = PanelIngresos::obtenerExamenesIngresos();
            foreach ($examenesIngresos as $examenIngreso) {

                if ($examenIngreso->estado_examen == 4 ) {
                    $examenIngreso->resultado = 'No Apto';
                } else if ($examenIngreso->estado_examen == 5){
                    $examenIngreso->resultado = 'Apto';
                } else {
                    $examenIngreso->resultado = 'N/A';
                }

                if ($examenIngreso->estado_examen == 1 && $examenIngreso->asistencia == null) {
                    $examenIngreso->estado_examen = 'Pendiente';
                } else if ( $examenIngreso->estado_examen == 2 && $examenIngreso->asistencia == null) {
                    $examenIngreso->estado_examen = 'Agendado';
                } else if ($examenIngreso->estado_examen == 2 && $examenIngreso->asistencia == 1) {
                    $examenIngreso->estado_examen = 'Reprogramado';
                } else if ($examenIngreso->estado_examen == 3) {
                    $examenIngreso->estado_examen = 'Pendiente de resultado';
                } else if ($examenIngreso->estado_examen == 4) {
                    $examenIngreso->estado_examen = 'Cerrado (No Apto)';
                } else if ($examenIngreso->estado_examen == 5) {
                    $examenIngreso->estado_examen = 'Cerrado (Apto)';
                }


            }

            return response()->json($examenesIngresos);
        }

    }

}
