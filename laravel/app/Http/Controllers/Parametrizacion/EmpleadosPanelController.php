<?php
/*
Controlador de la tabla param_empleados
Usa SQl Eloquent del archivo app\Models\Parametrizacion\PanelEmpleados.php
 */

namespace App\Http\Controllers\Parametrizacion;

use App\Http\Controllers\Controller;
use App\Models\PanelLogin;
use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelCentrosOp;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelUsuarios;
use App\Models\Parametrizacion\PanelUsuariosSiesa;
use App\Models\Parametrizacion\PanelAreas;
use App\Models\Parametrizacion\PanelEmpresas;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Request;

class EmpleadosPanelController extends Controller
{
    public function showEmpleados()
    {
        if (Session::has('user')) {
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "parametrizacion/empleados";
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

            $DatosEmpleados = PanelEmpleados::EmpleadosT();
            $cargos = PanelCargos::getCargos();
            $centrosOp = PanelCentrosOp::getCentrosOpActivos();

            foreach ($cargos as $key => $cargo) {
                $area = PanelAreas::getArea($cargo->area);
                $empresa = PanelEmpresas::getEmpresa($area[0]->empresa);
                $cargo->descripcion = $cargo->descripcion . ' - ' . $area[0]->descripcion . ' - ' . $empresa[0]->nombre;
            }
            foreach ($DatosEmpleados as $empleado) {
                $empleado->centro_op = PanelCentrosOp::getCentroOp($empleado->centro_op)[0]->descripcion;
                $cargo = PanelCargos::getCargo($empleado->cargo);
                $area = PanelAreas::getArea($cargo[0]->area);
                $empresa = PanelEmpresas::getEmpresa($area[0]->empresa);
                $empleado->cargo = $cargo[0]->descripcion . ' - ' . $area[0]->descripcion . ' - ' . $empresa[0]->nombre;
            }

            return view('parametrizacion.panel-empleados')->with('DatosUsuario', $DatosUsuario)->with('DatosEmpleados', $DatosEmpleados)->with('cargos', $cargos)->with('centrosOp', $centrosOp);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function EmpleadosAgregar()
    {
        if (Session::has('user')) {
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "parametrizacion/empleados";
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

            return view('parametrizacion.panel-empleadosAgregar')->with('DatosUsuario', $DatosUsuario);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function EmpleadosAgregarDB(Request $request)
    {
        if (Session::has('user')) {

            $identificacion = $request::input('identificacion');
            $primerNombre = trim($request::input('primer_nombre'));
            $otroNombre = trim($request::input('ot_nombre'));
            $primerApellido = trim($request::input('primer_apellido'));
            $otroApellido = trim($request::input('ot_apellido'));
            $numTel = $request::input('numtel');
            $correo = trim($request::input('correo'));
            $cargo = $request::input('cargo');
            $centro = $request::input('centro_op');
            $fechaNacimiento = $request::input('fecha_nacimiento');


            $mensaje = '';
            $datos = [
                'identificacion' => $identificacion,
                'primer_nombre' => $primerNombre,
                'ot_nombre' => $otroNombre,
                'primer_apellido' => $primerApellido,
                'ot_apellido' => $otroApellido,
                'correo' => $correo,
                'numtel' => $numTel,
                'cargo' => $cargo,
                'centro_op' => $centro,
                'estado' => 1,
                'fecha_nacimiento' => $fechaNacimiento,
                'empleado_siesa' => 0
            ];

            // Verificación de empleado duplicado
            $empleadoDuplicado = PanelEmpleados::getEmpleadoUnico($identificacion);

            if ($empleadoDuplicado != 0) {
                $mensaje = "Ya se encuentra un empleado con esa identificación.";
            } else {
                PanelEmpleados::insertarEmpleado($datos);
                $mensaje = "Empleado creado.";

                //Agrego el guardado al log
                $user = Session::get('user');
                $DatosUsuario = PanelLogin::getUsuario($user);
                $idempleado = PanelEmpleados::UltimoEmpleado();
                $datos1 = array();
                $datos1['modulo'] = 12; //Empleados
                $datos1['tipo'] = "INS"; //Inserta

                $info = "Id: " . $idempleado->id_empleado . " |*| Identificación: $identificacion |*| Nombre: $primerNombre $otroNombre $primerApellido $otroApellido";
                $info = $info . " |*| Correo: $correo |*| Tel: $numTel |*| Id cargo: $cargo |*| Id centro de operación: $centro |*| fecha nacimiento: $fechaNacimiento";

                $datos1['registro'] = $info;
                $datos1['usuario'] = $DatosUsuario[0]->empleado;
                $datos1['fecha'] = NOW();
                PanelLogin::insertarLog($datos1);
            }

            $Redireccion = "/panel/parametrizacion/empleados";

            return view('panel-mensaje')->with('Mensaje', $mensaje)->with('Redireccion', $Redireccion);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function EmpleadosModificar($id)
    {
        if (Session::has('user')) {
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "parametrizacion/empleados";
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
            $datosEmpleado = PanelEmpleados::getEmpleado($id);
            $datosEmpleado[0]->nombre_centro_op = PanelCentrosOp::getCentroOp($datosEmpleado[0]->centro_op)[0]->descripcion;
            $cargo = PanelCargos::getCargo($datosEmpleado[0]->cargo);
            $area = PanelAreas::getArea($cargo[0]->area);
            $empresa = PanelEmpresas::getEmpresa($area[0]->empresa);
            $datosEmpleado[0]->nombre_cargo = $cargo[0]->descripcion . ' - ' . $area[0]->descripcion . ' - ' . $empresa[0]->nombre;

            $centrosOperacion = PanelCentrosOp::getCentrosOpActivos();
            $cargos = PanelCargos::getCargosActivos();

            foreach ($cargos as $key => $cargo) {
                $area = PanelAreas::getArea($cargo->area);
                $empresa = PanelEmpresas::getEmpresa($area[0]->empresa);
                $cargo->descripcion = $cargo->descripcion . ' - ' . $area[0]->descripcion . ' - ' . $empresa[0]->nombre;
            }


            //Termina validación

            if ($datosEmpleado) {
                return view('parametrizacion.panel-empleadosModificar')->with('DatosUsuario', $DatosUsuario)->with('datosEmpleado', $datosEmpleado)
                ->with('centrosOp', $centrosOperacion)->with('cargos', $cargos);
            } else {
                $Mensaje = "";
                $Redireccion = "/panel/parametrizacion/empleados";
                return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
            }
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function EmpleadosModificarDB(Request $request)
    {
        if (Session::has('user')) {

            $id_empleado = $request::input('id_empleado');
            $identificacion = $request::input('identificacion');
            $primerNombre = trim($request::input('primer_nombre'));
            $otroNombre = trim($request::input('ot_nombre'));
            $primerApellido = trim($request::input('primer_apellido'));
            $otroApellido = trim($request::input('ot_apellido'));
            $numTel = $request::input('numtel');
            $correo = trim($request::input('correo'));
            $cargo = $request::input('cargo');
            $centro = $request::input('centro_op');
            $fechaNacimiento = $request::input('fecha_nacimiento');
            $estado = $request::input('estado');

            // Inicialización de mensaje y datos
            $Mensaje = '';
            $datos = [
                'identificacion' => $identificacion,
                'primer_nombre' => $primerNombre,
                'ot_nombre' => $otroNombre,
                'primer_apellido' => $primerApellido,
                'ot_apellido' => $otroApellido,
                'correo' => $correo,
                'numtel' => $numTel,
                'cargo' => $cargo,
                'centro_op' => $centro,
                'fecha_nacimiento' => $fechaNacimiento,
                'estado' => $estado
            ];


            $EmpleadoDuplicado = PanelEmpleados::getEmpleadoUnicoModificar($identificacion, $id_empleado);

            if ($EmpleadoDuplicado != 0) {
                $Mensaje = "Ya se encuentra un empleado con esa identificación.";
            }

            if ($Mensaje == "") {
                PanelEmpleados::actualizarEmpleado($id_empleado, $datos);

                $Mensaje = "Empleado modificado.";

                //Agrego el guardado al log
                $user = Session::get('user');
                $DatosUsuario = PanelLogin::getUsuario($user);
                $datos1 = array();
                $datos1['modulo'] = 12; //Empleados
                $datos1['tipo'] = "UPD"; //Actualiza

                $info = "Id: " . $id_empleado . " |*| Identificación: $identificacion |*| Nombre: $primerNombre $otroNombre $primerApellido $otroApellido";
                $info = $info . " |*| Correo: $correo |*| Tel: $numTel |*| Id cargo: $cargo |*| Id centro de operación: $centro |*| fecha nacimiento: $fechaNacimiento  |*| Estado: $estado";

                $datos1['registro'] = $info;
                $datos1['usuario'] = $DatosUsuario[0]->empleado;
                $datos1['fecha'] = NOW();
                PanelLogin::insertarLog($datos1);
                ////////////////////////////////
            }

            $Redireccion = "/panel/parametrizacion/empleados/modificar/" . $id_empleado;
            return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function EmpleadosUpd()
    {
        if (Session::has('user')) {
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "parametrizacion/empleadosupd";
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

            $DatosEmpleados = PanelEmpleados::EmpleadosActivos();

            return view('parametrizacion.panel-empleadosupd')->with('DatosUsuario', $DatosUsuario)->with('DatosEmpleados', $DatosEmpleados);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function EmpleadosCreate()
    {
        $DatosConsultaSiesa = PanelUsuariosSiesa::EmpleadoTodos();
        $EmpleadosActuales = PanelEmpleados::EmpleadosT();

        // Obtén las identificaciones de las dos colecciones
        $identificacionesSiesa = $DatosConsultaSiesa->pluck('f200_nit')->toArray();
        $identificacionesActuales = $EmpleadosActuales->pluck('identificacion')->toArray();

        // Encuentra las identificaciones que están en $DatosConsultaSiesa pero no en $EmpleadosActuales
        $result = array_diff($identificacionesSiesa, $identificacionesActuales);

        // $diff ahora contiene las identificaciones que están en $DatosConsultaSiesa pero no en $EmpleadosActuales
        $results = [];

        //dd($result);
        foreach ($result as $DatosSiesa) {

            $infoAdicional = $DatosConsultaSiesa->firstWhere('f200_nit', $DatosSiesa);
            //dd($infoAdicional);

            if ($infoAdicional) {
                $nombres = $infoAdicional->f200_nombres;

                if (strpos($nombres, ' ') !== false) {
                    list($nombre1, $nombre2) = explode(' ', $nombres, 2);
                } else {
                    $nombre1 = $nombres;
                    $nombre2 = '';
                }

                // Obtener el ID del cargo correspondiente
                $cargo = PanelCargos::getCargoNombre($infoAdicional->Cargo);
                $centro = PanelCentrosOp::getCentroNombre($infoAdicional->CentroDes);

                if ($cargo && $centro) {

                    $result = ([
                        'identificacion' => $infoAdicional->f200_nit,
                        'primer_nombre' => $nombre1,
                        'ot_nombre' => $nombre2,
                        'primer_apellido' => $infoAdicional->f200_apellido1,
                        'ot_apellido' => $infoAdicional->f200_apellido2,
                        'fecha_nacimiento' => $infoAdicional->f200_fecha_nacimiento,
                        'correo' => $infoAdicional->Correo,
                        'numtel' => $infoAdicional->Tel,
                        'cargo' => $cargo->id_cargo,
                        'centro_op' => $centro->id_centro,
                        'estado' => 1,
                        'empleado_siesa' => 1
                    ]);
                    $empleadoId = PanelEmpleados::insertarEmpleadoGetId($result);
                    //PanelEmpleados::insertarEmpleado($result);

                    $usuario = ([
                        'empleado' => $empleadoId,
                        'login' => $infoAdicional->f200_nit,
                        'password' => Hash::make($infoAdicional->f200_nit),
                        'estado' => 0,
                        'master' => 0,
                        'modulos' => 1,

                    ]);
                    PanelUsuarios::insertarUsuario($usuario);

                    $results[] = [
                        'identificacion' => $infoAdicional->f200_nit,
                        'mensaje' => 'Inserción exitosa',
                    ];

                } else {
                    // Manejar el caso donde no se encuentra el cargo correspondiente
                    $results[] = [
                        'identificacion' => $infoAdicional->f200_nit,
                        'mensaje' => 'Error: Cargo no encontrado',
                    ];

                }

            }
        }
        $this->EmpleadoUpdate();
        return redirect()->route('show.empleados');
    }

    public function EmpleadosStatus()
    {
        $DatosConsultaSiesa = PanelUsuariosSiesa::EmpleadoTodos();
        $EmpleadosActuales = PanelEmpleados::EmpleadosActivos();

        // Obtén las identificaciones de las dos colecciones
        $identificacionesSiesa = $DatosConsultaSiesa->pluck('f200_nit')->toArray();
        $identificacionesActuales = $EmpleadosActuales->pluck('identificacion')->toArray();

        // Encuentra las identificaciones que están en $DatosConsultaSiesa pero no en $EmpleadosActuales
        $result = array_diff($identificacionesActuales, $identificacionesSiesa);
        //dd($result);
        $results = [];
        foreach ($result as $DatosSiesa) {
            $infoAdicional = $EmpleadosActuales->firstWhere('identificacion', $DatosSiesa);
            //dd($infoAdicional);
            if ($infoAdicional && $infoAdicional->empleado_siesa == 1) {

                $result = (['estado' => 0]);
                PanelEmpleados::actualizarEmpleado($infoAdicional->id_empleado, $result);
                $results[] = [
                    'identificacion' => $infoAdicional->identificacion,
                    'mensaje' => 'se inactivo correctamente',
                ];
            }

        }
        //$this->EmpleadoUpdate();
        return redirect()->route('show.empleados');
    }

    public function EmpleadoUpdate2()
    {

        $DatosConsultaSiesa = PanelUsuariosSiesa::EmpleadoTodos();
        //dd($DatosConsultaSiesa);
        $EmpleadosActuales = PanelEmpleados::EmpleadosActivos();
        //dd($EmpleadosActuales);

        $results = [];
        foreach ($DatosConsultaSiesa as $DatoSiesa) {
            $infoAdicional = $EmpleadosActuales->firstWhere('identificacion', $DatoSiesa->f200_nit);
            //dd($DatoSiesa);
            //dd($infoAdicional);

            $cargo = PanelCargos::getCargoNombre($DatoSiesa->Cargo);
            $centro = PanelCentrosOp::getCentroNombre($DatoSiesa->CentroDes);
            //dd($centro);

            if ($infoAdicional && $cargo && $centro) {
                $cargoA = PanelCargos::getCargo($infoAdicional->cargo)->first();
                $centroA = PanelCentrosOp::getCentroOp($infoAdicional->centro_op)->first();
                $nombres = $DatoSiesa->f200_nombres;

                if (strpos($nombres, ' ') !== false) {
                    list($nombre1, $nombre2) = explode(' ', $nombres, 2);
                } else {
                    $nombre1 = $nombres;
                    $nombre2 = '';
                }

                //dd($infoAdicional);
                //dd($centro->id_centro);
                $actualizado = false;

                if ($nombre1 != $infoAdicional->primer_nombre) {
                    $result['primer_nombre'] = $nombre1;
                    //$infoAdicional->primer_nombre = $nombre1;
                    $actualizado = true;
                }

                if ($nombre2 != $infoAdicional->ot_nombre) {
                    $result['ot_nombre'] = $nombre2;
                    //$infoAdicional->ot_nombre = $nombre2;
                    $actualizado = true;
                }

                if ($DatoSiesa->f200_apellido1 != $infoAdicional->primer_apellido) {
                    $result['primer_apellido'] = $DatoSiesa->f200_apellido1;
                    //$infoAdicional->primer_apellido = $DatoSiesa->f200_apellido1;
                    $actualizado = true;
                }
                if ($DatoSiesa->f200_apellido2 != $infoAdicional->ot_apellido) {
                    $result['ot_apellido'] = $DatoSiesa->f200_apellido2;
                    // $infoAdicional->ot_apellido = $DatoSiesa->f200_apellido2;
                    $actualizado = true;
                }

                if ($DatoSiesa->f200_fecha_nacimiento != $infoAdicional->fecha_nacimiento) {
                    $result['fecha_nacimiento'] = $DatoSiesa->f200_fecha_nacimiento;
                    //$infoAdicional->ot_apellido = $DatoSiesa->f200_fecha_nacimiento;
                    $actualizado = true;
                }
                if ($DatoSiesa->Tel != $infoAdicional->numtel) {
                    $result['numtel'] = $DatoSiesa->Tel;
                    // $infoAdicional->numtel = $DatoSiesa->Tel;
                    $actualizado = true;
                }
                if ($cargoA && $centroA) {
                    if ($DatoSiesa->Cargo != $cargoA->descripcion) {
                        $result['cargo'] = $cargo->id_cargo;

                        // $infoAdicional->ot_apellido = $cargo->id_cargo;
                        $actualizado = true;
                    }
                    if ($DatoSiesa->CentroDes != $centroA->descripcion) {
                        $result['centro_op'] = $centro->id_centro;
                        //$infoAdicional->ot_apellido = $centro->id_centro;
                        $actualizado = true;
                    }
                } else {

                }
                // Verificar si se actualizaron los campos y guardar los cambios
                if ($actualizado) {
                    PanelEmpleados::actualizarEmpleado($infoAdicional->id_empleado, $result);
                    //$infoAdicional->save();
                } else {
                    echo 'No hay cambios';
                }

            }
        }
    }
    public function EmpleadoUpdate()
    {
        $DatosConsultaSiesa = PanelUsuariosSiesa::EmpleadoTodos();
        $EmpleadosActuales = PanelEmpleados::EmpleadosActivos();

        foreach ($DatosConsultaSiesa as $DatoSiesa) {
            $infoAdicional = $EmpleadosActuales->firstWhere('identificacion', $DatoSiesa->f200_nit);

            if ($infoAdicional && $infoAdicional->empleado_siesa == 1) {
                $cargo = PanelCargos::getCargoNombre($DatoSiesa->Cargo);
                $centro = PanelCentrosOp::getCentroNombre($DatoSiesa->CentroDes);

                if ($cargo && $centro) {
                    $cargoA = PanelCargos::getCargo($infoAdicional->cargo)->first();
                    $centroA = PanelCentrosOp::getCentroOp($infoAdicional->centro_op)->first();

                    $nombres = $DatoSiesa->f200_nombres;
                    $nombre1 = $nombre2 = '';

                    if (strpos($nombres, ' ') !== false) {
                        list($nombre1, $nombre2) = explode(' ', $nombres, 2);
                    } else {
                        $nombre1 = $nombres;
                    }

                    $changes = [
                        'primer_nombre' => $nombre1,
                        'ot_nombre' => $nombre2,
                        'primer_apellido' => $DatoSiesa->f200_apellido1,
                        'ot_apellido' => $DatoSiesa->f200_apellido2,
                        'fecha_nacimiento' => $DatoSiesa->f200_fecha_nacimiento,
                        'numtel' => $DatoSiesa->Tel,
                        'cargo' => $cargo->id_cargo,
                        'centro_op' => $centro->id_centro,
                    ];

                    // Verificar si hay cambios en algún campo
                    $changed = false;
                    foreach ($changes as $field => $value) {
                        if ($infoAdicional->$field != $value) {
                            $changed = true;
                            break;
                        }
                    }

                    // Actualizar el registro si hay cambios
                    if ($changed) {
                        PanelEmpleados::actualizarEmpleado($infoAdicional->id_empleado, $changes);

                    } else {
                        echo 'No hay cambios';
                    }
                }
            }
        }
    }

    public function updateDataEmpleadoDB()
    {
        $id_empleado = Request::input('id_empleado');
        $numtel = Request::input('numtel');
        $correo = Request::input('correo');

        $data = [
            'correo' =>$correo,
            'numtel' => $numtel,
        ];

        PanelEmpleados::actualizarEmpleado($id_empleado, $data);

        toastr()->success('¡Datos actualizados exitosamente!', '¡Actualización exitosa!', ['positionClass' => 'toast-bottom-right']);
        return redirect()->back();
    }

}
