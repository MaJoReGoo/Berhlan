<?php

namespace App\Http\Controllers\ActivosFijos;

use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;
use App\Models\PanelLogin;
use App\Models\TicActivos\PanelConsultas;
use Request;

use Illuminate\Support\Facades\Session;

class ConsultasActivosFijosController extends Controller
{
    public function Proyeccion()
    {
        if (Session::has('user')) {
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "activos/proyeccion";
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

            return view('activos-fijos.panel-consultaProye')->with('DatosUsuario', $DatosUsuario);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function ProyeccionListado()
    {
        if (Session::has('user')) {
            $formData = Request::all();
            $empresa = $formData['empresa'];
            $tipohd = $formData['tipohd'];
            $centro = $formData['centro'];
            $fecha = $formData['fecha'];
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            $Mensaje = "";

            $sql = "SELECT acti2_activo.id_activo, MAX(acti2_actividades.fecha) AS ultfecha "
                . "FROM  acti2_activo, acti2_actividades, param_empleados, param_centros "
                . "WHERE acti2_activo.id_activo           = acti2_actividades.activo "
                . "AND   acti2_activo.empleado            = param_empleados.id_empleado "
                . "AND   param_empleados.centro_op       = param_centros.id_centro "
                . "AND   acti2_activo.estado              = '1' "
                . "AND   acti2_activo.mantenimiento       = 'S' ";

            if ($empresa != "") {
                $sql = $sql . " AND acti2_activo.empresa = '$empresa' ";
            }

            if ($tipohd != "") {
                $sql = $sql . " AND acti2_activo.tipo = '$tipohd' ";
            }

            if ($centro != "") {
                $sql = $sql . " AND param_centros.id_centro = '$centro' ";
            }

            $sql = $sql . "GROUP BY acti2_activo.id_activo ORDER BY acti2_activo.id_activo";

            $DatosActivos = PanelConsultas::ProyeccionSql($sql);

            $sol = "";
            foreach ($DatosActivos as $DatAct) {
                $sol = 1;
            }

            //No se encontró ningún registro
            if ($sol == "") {
                $Mensaje = "No se encuentra información, con los parámetros ingresados.";
                $Redireccion = "/panel/activos/proyeccion";
                return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
            }

            return view('activos-fijos.panel-consultaProyeListado')->with('DatosUsuario', $DatosUsuario)->with('DatosActivos', $DatosActivos)->with('fechacorte', $fecha);

        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

}
