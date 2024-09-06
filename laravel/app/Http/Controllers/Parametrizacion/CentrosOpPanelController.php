<?php
/*
Controlador de la tabla param_centros
Usa SQl Eloquent del archivo app\Models\Parametrizacion\PanelCentrosOp.php
 */

namespace App\Http\Controllers\Parametrizacion;

use App\Http\Controllers\Controller;
use App\Models\PanelLogin;
use App\Models\Parametrizacion\PanelCentrosOp;
use DB;
use Illuminate\Support\Facades\Session;
use Request;

class CentrosOpPanelController extends Controller
{
    public function showCentrosOp()
    {
        if (Session::has('user')) {
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "parametrizacion/centrosop";
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

            $DatosCentrosOp = PanelCentrosOp::getCentrosOp();
            $CentrosOpActivos = PanelCentrosOp::getCantidadCentrosOpActivos();
            $CentrosOpInactivos = PanelCentrosOp::getCantidadCentrosOpInactivos();
            return view('parametrizacion.panel-centrosop')->with('DatosUsuario', $DatosUsuario)->with('DatosCentrosOp', $DatosCentrosOp)->with('CentrosOpActivos', $CentrosOpActivos)->with('CentrosOpInactivos', $CentrosOpInactivos);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function CentrosOpAgregar()
    {
        if (Session::has('user')) {
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "parametrizacion/centrosop";
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

            return view('parametrizacion.panel-centrosopAgregar')->with('DatosUsuario', $DatosUsuario);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function CentrosOpAgregarDB()
    {
        if (Session::has('user')) {
            $formData = Request::all();
            $descripcion = trim($formData['descripcion']);
            $direccion = trim($formData['direccion']);
            $ciudad = trim($formData['ciudad']);
            $tel1 = trim($formData['tel1']);
            $tel2 = trim($formData['tel2']);

            $datos = array();

            //Realizo las validaciones
            $Mensaje = "";

            $CentroDuplicado = PanelCentrosOp::getCentroOpUnico($descripcion);

            if ($CentroDuplicado != 0) {
                $Mensaje = "Ya se encuentra creado un centro de operación con esa descripción.";
            } else if ($descripcion == "") {
                $Mensaje = "Debe ingresar la descripción.";
            } else if ($direccion == "") {
                $Mensaje = "Debe ingresar la dirección.";
            } else if ($ciudad == "") {
                $Mensaje = "Debe seleccionar la ciudad.";
            } else if ((!ctype_digit($tel1)) && ($tel1 != '')) {
                $Mensaje = "El teléfono 1 solo debe contener números.";
            } else if ((!ctype_digit($tel2)) && ($tel2 != '')) {
                $Mensaje = "El teléfono 2 solo debe contener números.";
            }

            if ($Mensaje != "") {
                $Redireccion = "/panel/parametrizacion/centrosop/agregar";
            } else {
                $datos['descripcion'] = $descripcion;
                $datos['direccion'] = $direccion;
                $datos['ciudad'] = $ciudad;
                $datos['tel1'] = $tel1;
                $datos['tel2'] = $tel2;
                $datos['estado'] = 1; //Activo

                PanelCentrosOp::insertarCentroOp($datos);
                $Mensaje = "Centro de operación creado.";

                //Agrego el guardado al log
                $user = Session::get('user');
                $DatosUsuario = PanelLogin::getUsuario($user);
                $idcentro = PanelCentrosOp::UltimoCentro();
                $datos1 = array();
                $datos1['modulo'] = 10; //Centros de operación
                $datos1['tipo'] = "INS"; //Inserta
                $datos1['registro'] = "Id: $idcentro->id_centro |*| Descripción: $descripcion |*| Dirección: $direccion |*| Id ciudad:$ciudad |*| Teléfonos: $tel1 - $tel2 ";
                $datos1['usuario'] = $DatosUsuario[0]->empleado;
                $datos1['fecha'] = NOW();
                PanelLogin::insertarLog($datos1);
                ////////////////////////////////

                $Redireccion = "/panel/parametrizacion/centrosop";
            }

            return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function CentrosOpModificar($id)
    {
        if (Session::has('user')) {
            $idCentroOp = $id;
            $DatosCentroOp = PanelCentrosOp::getCentroOp($idCentroOp);
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "parametrizacion/centrosop";
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

            if ($DatosCentroOp == true) {
                return view('parametrizacion.panel-centrosopModificar')->with('DatosUsuario', $DatosUsuario)->with('DatosCentroOp', $DatosCentroOp);
            } else {
                $Mensaje = "";
                $Redireccion = "/panel/parametrizacion/centrosop";
                return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
            }
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function CentrosOpModificarDB()
    {
        if (Session::has('user')) {
            $formData = Request::all();
            $id_centro = $formData['id_centro'];
            $descripcion = trim($formData['descripcion']);
            $direccion = trim($formData['direccion']);
            $ciudad = trim($formData['ciudad']);
            $tel1 = trim($formData['tel1']);
            $tel2 = trim($formData['tel2']);
            $estado = trim($formData['estado']);

            $datos = array();

            //Realizo las validaciones
            $Mensaje = "";

            $CentroOpDuplicado = PanelCentrosOp::getCentroOpUnicoModificar($descripcion, $id_centro);

            if ($CentroOpDuplicado != 0) {
                $Mensaje = "Ya se encuentra un centro de operación creado con esa descripción.";
            } else if ($descripcion == "") {
                $Mensaje = "Debe ingresar la descripción.";
            } else if ($direccion == "") {
                $Mensaje = "Debe ingresar la dirección.";
            } else if ($ciudad == "") {
                $Mensaje = "Debe seleccionar la ciudad.";
            } else if ((!ctype_digit($tel1)) && ($tel1 != '')) {
                $Mensaje = "El teléfono 1 solo debe contener números.";
            } else if ((!ctype_digit($tel2)) && ($tel2 != '')) {
                $Mensaje = "El teléfono 2 solo debe contener números.";
            } else if ($estado == "") {
                $Mensaje = "Debe seleccionar el estado.";
            }

            if ($Mensaje == "") {
                $datos['descripcion'] = $descripcion;
                $datos['direccion'] = $direccion;
                $datos['ciudad'] = $ciudad;
                $datos['tel1'] = $tel1;
                $datos['tel2'] = $tel2;
                $datos['estado'] = $estado;

                PanelCentrosOp::actualizarCentroOp($id_centro, $datos);
                $Mensaje = "Centro de operación modificado.";

                //Agrego el guardado al log
                $user = Session::get('user');
                $DatosUsuario = PanelLogin::getUsuario($user);
                $datos1 = array();
                $datos1['modulo'] = 10; //Centros de operación
                $datos1['tipo'] = "UPD"; //Actualiza
                $datos1['registro'] = "Id: $id_centro |*| Descripción: $descripcion |*| Dirección: $direccion |*| Id ciudad:$ciudad |*| Teléfonos: $tel1 - $tel2 |*| Estado: $estado";
                $datos1['usuario'] = $DatosUsuario[0]->empleado;
                $datos1['fecha'] = NOW();
                PanelLogin::insertarLog($datos1);
                ////////////////////////////////
            }

            $Redireccion = "/panel/parametrizacion/centrosop/modificar/" . $id_centro;
            return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function CentrosOpCreate()
    {

        $SiesaCentros = PanelCentrosOp::getCentrosSiesa();
        $CentrosActuales = PanelCentrosOp::getCentrosOp();

        // Obtén las descripciones de las dos colecciones
        $CentrosSiesa = $SiesaCentros->pluck('CentroDes')->toArray();
        $CentrosActuales = $CentrosActuales->pluck('descripcion')->toArray();

        // Encuentra las areas que están en $SiesaAreas pero no en $AreasActuales
        $result = array_diff($CentrosSiesa, $CentrosActuales);
        PanelCentrosOP::quitarTildes();
        foreach ($result as $centro) {

                // Si se encuentra el área, insertar el nuevo cargo en param_cargos
                DB::table('param_centros')->insert([
                    'descripcion' => $centro,
                    'direccion' => 'N/A',
                    'ciudad' => 1,
                    'tel1' => 0,
                    'tel2' => 0,
                    'estado' => 1,

                ]);

        }
        return redirect()->route('show.empleados');

    }
}
