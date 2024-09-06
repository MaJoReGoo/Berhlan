<?php

namespace App\Http\Controllers\Requisiciones;

use App\Http\Controllers\Controller;
use App\Models\PanelLogin;
use App\Models\Requisiciones\PanelDotaciones;
use App\Models\Requisiciones\PanelHerramientas;
use App\Models\Requisiciones\PanelMotivos;
use App\Models\Requisiciones\PanelTpcontratos;
use App\Models\Requisiciones\PanelTipoDotacion;
use App\Models\Requisiciones\PanelTallaDotacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ParametrizacionPanelController extends Controller
{
    public function mostrarParametrizacion()
    {
        if (Session::has('user')) {
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "requisiciones/parametrizacion";
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

            $DatosMotivos = PanelMotivos::get();
            $MotivosCant = PanelMotivos::max('id_motivo')+1;

            $DatosContratos = PanelTpcontratos::get();
            $TipoContratoCant = PanelTpcontratos::max('id_tpcontrato')+1;

            $DatosActivos = PanelHerramientas::get();
            $ActivosCant = PanelHerramientas::max('id_herramienta')+1;

            $DatosDotaciones = PanelDotaciones::get();
            $tiposDotaciones = PanelTipoDotacion::get();
            $DotacionesCant = PanelDotaciones::max('id_dotacion')+1;

            $datosTallas = PanelTallaDotacion::get();
            $tallasCant = PanelTallaDotacion::max('id_talla_dotacion')+1;


            $DatosMotivos->map(function ($motivo) {
                if ($motivo->estado == 1) {
                    $motivo->name_estado = 'Activo';
                } else {
                    $motivo->name_estado = 'Inactivo';
                }
            });

            $DatosContratos->map(function ($contrato) {
                if ($contrato->estado == 1) {
                    $contrato->name_estado = 'Activo';
                } else {
                    $contrato->name_estado = 'Inactivo';
                }
            });

            $DatosActivos->map(function ($activo) {
                if ($activo->estado == 1) {
                    $activo->name_estado = 'Activo';
                } else {
                    $activo->name_estado = 'Inactivo';
                }
                if ($activo->area_encargada == 10) {
                    $activo->area_name = 'TIC';
                } else {
                    $activo->area_name = 'SOPORTE ADMINISTRATIVO';
                }
            });

            $DatosDotaciones->map(function ($dotacion) {
                if ($dotacion->estado == 1) {
                    $dotacion->name_estado = 'Activo';
                } else {
                    $dotacion->name_estado = 'Inactivo';
                }
            });

            $datosTallas->map(function ($talla) {
                if ($talla->estado_talla_dotacion == 1) {
                    $talla->name_estado = 'Activo';
                } else {
                    $talla->name_estado = 'Inactivo';
                }
            });

            return view('requisiciones.panel-parametrizacion')->with('DatosUsuario', $DatosUsuario)->with('DatosMotivos', $DatosMotivos)->with('MotivosCant', $MotivosCant)
                ->with('DatosContratos', $DatosContratos)->with('TipoContratoCant', $TipoContratoCant)->with('DatosActivos', $DatosActivos)->with('ActivosCant', $ActivosCant)
                ->with('DatosDotaciones',$DatosDotaciones)->with('DotacionesCant', $DotacionesCant)->with('tiposDotaciones', $tiposDotaciones)->with('datosTallas', $datosTallas)
                ->with('tallasCant', $tallasCant);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function motivosAgregarDB(Request $request)
    {
        $descripcion_motivo = $request->input('descripcion_motivo');
        $estado = $request->input('estado_motivo');

        foreach ($descripcion_motivo as $key => $value) {
            PanelMotivos::create(
                [
                    'descripcion' => $value,
                    'estado' => $estado[$key],
                ]
            );
        }
        toastr()->success('¡Acción realizada con exito!', '¡Operacíon exitosa!', ['positionClass' => 'toast-bottom-right']);
        return redirect()->back();
    }

    public function motivosUpdateDB(Request $request)
    {
        $id = $request->input('id_motivo');
        $estado = $request->input('estado_motivo');

        foreach ($id as $key => $value) {
            PanelMotivos::where('id_motivo', $value)->update([
                'estado' => $estado[$key]
            ]);
        }
        toastr()->success('¡Acción realizada con exito!', '¡Operacíon exitosa!', ['positionClass' => 'toast-bottom-right']);
        return redirect()->back();
    }

    public function tpContratoAgregarDB(Request $request)
    {
        $descripcion = $request->input('descripcion_tipo_contrato');
        $estado = $request->input('estado_tipo_contrato');

        foreach ($descripcion as $key => $value) {
            PanelTpcontratos::create(
                [
                    'descripcion' => $value,
                    'estado' => $estado[$key],
                ]
            );
        }
        toastr()->success('¡Acción realizada con exito!', '¡Operacíon exitosa!', ['positionClass' => 'toast-bottom-right']);
        return redirect()->back();

    }

    public function tpContratoUpdateDB(Request $request)
    {
        $id = $request->input('id_tpcontrato');
        $estado = $request->input('estado_tpcontrato');

        foreach ($id as $key => $value) {
            PanelTpcontratos::where('id_tpcontrato', $value)->update([
                'estado' => $estado[$key]
            ]);
        }
        toastr()->success('¡Acción realizada con exito!', '¡Operacíon exitosa!', ['positionClass' => 'toast-bottom-right']);
        return redirect()->back();
    }

    public function herramientasAgregarDB(Request $request)
    {
        $nombre_herramienta = $request->input('nombre_herramienta');
        $area_encargada = $request->input('area_encargada');
        $estado = $request->input('estado_herramienta');

        foreach ($nombre_herramienta as $key => $value) {
            PanelHerramientas::create(
                [
                    'nombre_herramienta' => $value,
                    'area_encargada' => $area_encargada[$key],
                    'estado' => $estado[$key],
                ]
            );
        }
        toastr()->success('¡Acción realizada con exito!', '¡Operacíon exitosa!', ['positionClass' => 'toast-bottom-right']);
        return redirect()->back();

    }

    public function herramientasUpdateDB(Request $request)
    {
        $id_herramienta = $request->input('id_herramienta');
        $area_encargada = $request->input('area_encargada');
        $estado = $request->input('estado_herramienta');


        foreach ($id_herramienta as $key => $value) {
            PanelHerramientas::where('id_herramienta', $value)->update([
                'area_encargada' => $area_encargada[$key],
                'estado' => $estado[$key]
            ]);
        }
        toastr()->success('¡Acción realizada con exito!', '¡Operacíon exitosa!', ['positionClass' => 'toast-bottom-right']);
        return redirect()->back();
    }


    public function dotacionesAgregarDB(Request $request)
    {
        $nombre_dotacion = $request->input('nombre_dotacion');
        $estado = $request->input('estado_dotacion');
        $fk_id_tipo_dotacion = $request->input('tipo_dotacion');

        foreach ($nombre_dotacion as $key => $value) {
            PanelDotaciones::create(
                [
                    'nombre_dotacion' => $value,
                    'estado' => $estado[$key],
                    'fk_id_tipo_dotacion'=> $fk_id_tipo_dotacion[$key]
                ]
            );
        }
        toastr()->success('¡Acción realizada con exito!', '¡Operacíon exitosa!', ['positionClass' => 'toast-bottom-right']);
        return redirect()->back();

    }

    public function dotacionesUpdateDB(Request $request)
    {
        $id_dotacion = $request->input('id_dotacion');
        $id_tipo_dotacion = $request->input('tipo_dotacion');
        $estado = $request->input('estado_dotacion');


        foreach ($id_dotacion as $key => $value) {
            PanelDotaciones::where('id_dotacion', $value)->update([
                'fk_id_tipo_dotacion' => $id_tipo_dotacion[$key],
                'estado' => $estado[$key]
            ]);
        }
        toastr()->success('¡Acción realizada con exito!', '¡Operacíon exitosa!', ['positionClass' => 'toast-bottom-right']);
        return redirect()->back();
    }

    public function tallasAgregarDB(Request $request)
    {
        $nombreTallaDotacion = $request->input('nombre_talla_dotacion');
        $fk_id_tipo_dotacion = $request->input('id_tipo_dotacion');
        $estado_talla_dotacion = $request->input('estado_talla_dotacion');

        foreach ($nombreTallaDotacion as $key => $value) {
            PanelTallaDotacion::create(
                [
                    'nombre_talla_dotacion' => $value,
                    'fk_id_tipo_dotacion'=> $fk_id_tipo_dotacion[$key],
                    'estado_talla_dotacion' => $estado_talla_dotacion[$key]
                ]
            );
        }
        toastr()->success('¡Acción realizada con exito!', '¡Operacíon exitosa!', ['positionClass' => 'toast-bottom-right']);
        return redirect()->back();

    }

    public function tallasUpdateDB(Request $request)
    {
        $id_talla_dotacion = $request->input('id_talla_dotacion');
        $id_tipo_dotacion = $request->input('tipo_dotacion');
        $estado = $request->input('estado_talla_dotacion');


        foreach ($id_talla_dotacion as $key => $value) {
            PanelTallaDotacion::where('id_talla_dotacion', $value)->update([
                'fk_id_tipo_dotacion' => $id_tipo_dotacion[$key],
                'estado_talla_dotacion' => $estado[$key]
            ]);
        }
        toastr()->success('¡Acción realizada con exito!', '¡Operacíon exitosa!', ['positionClass' => 'toast-bottom-right']);
        return redirect()->back();
    }


}
