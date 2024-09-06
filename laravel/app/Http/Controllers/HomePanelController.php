<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PanelLogin;
use App\Models\PanelClientes;
use App\Models\Parametrizacion\PanelEmpleados as ParametrizacionPanelEmpleados;
use App\Models\Parametrizacion\PanelUsuarios;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Request;


class HomePanelController extends Controller
{

    var $server = '/Berhlan/public';

    public function showLogin()
    {
        $ErrorValidacion = "";  //Variable que retorna el error en caso de que no pase la validación
        return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
    }

    public function showLoginVerification()
    {
        $formData = Request::all();
        $user     = strtoupper($formData['username']);
        $pass     = $formData['secret'];

        $UsuarioExiste = PanelLogin::getUsuarioExiste($user);
        if ($UsuarioExiste == 0) {

            // El usuario no existe en la Tabla Login, verifico que exista en la Tabla de Empleados
            $InfoUsuario = ParametrizacionPanelEmpleados::getEmpleadoUnico($user);

            if ($InfoUsuario == 0) {
                $Mensaje = "No existe el usuario " . $user;
                $Redireccion = "/panel/login";
                return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
            } else {

                $DataEmpleado = ParametrizacionPanelEmpleados::getEmpleadoIdent($user);
                $identificacion = $DataEmpleado[0]->identificacion;
                $DataEmpleadoId = $DataEmpleado[0]->id_empleado;
                $DataEmpleadoEmail = $DataEmpleado[0]->correo;

                $InfoUsuarioCant = PanelLogin::getUsuarioEmpleadoCant($DataEmpleadoId);
                if ($InfoUsuarioCant != 0) {
                    $InfoUsuario = PanelLogin::getUsuarioEmpleado($DataEmpleadoId);
                    $idEmpleado = $InfoUsuario[0]->empleado;
                    $idUser = $InfoUsuario[0]->id_usuario;
                } else {
                    $Mensaje = "No existe el usuario " . $user;
                    $Redireccion = "/panel/login";
                    return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
                }
            }

            // Inicio Tercer y Cuarto Escenario //
            /* 
                Usuario No Existe | Escenario 3
                User != Identificación
                Pass != Identificación 

                Usuario No Existe | Escenario 4
                User != Identificación
                Pass = Identificación 
            */

            // Valido que el id del usuario sea el mismo que el id de la tabla de login para verificar que si existe y es la misma cédula

            if (($idEmpleado == $DataEmpleadoId) && ($user == $identificacion)) {

                // Verifico que el usuario esté activo 
                $UsrActivo = $InfoUsuario[0]->estado;
                if ($UsrActivo == 0) {
                    $Mensaje = "El usuario se encuentra inactivo";
                    $Redireccion = "/panel/login";
                    return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
                }

                // le pongo la cédula como login //-- Escenario 3 y 4 --//
                $datos = array();
                $datos['login'] = $DataEmpleado[0]->identificacion;
                PanelLogin::actualizarLogin($idUser, $datos);

                $PassNmEncr  = $InfoUsuario[0]->password;
                $PassNm      = Hash::check($pass, $PassNmEncr);

                //Verifico Si el password no coincide
                if ($PassNm == 0) {
                    $Mensaje = "Error en la contraseña, verifique por favor";
                    $Redireccion = "/panel/login";
                    return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
                } else {
                    // El password es correcto, Válidamos si el password ingresado es la cédula /-- Escenario 4 --/
                    if ($pass == $identificacion) {
                        // Si son Iguales, pide cambio de contraseña
                        Session::put('user', $user);
                        $DatosUsuario = PanelLogin::getUsuario($user);
                        return view('panel-cambiopwd-new')->with('DatosUsuario', $DatosUsuario)->with('pwd1', $pass);
                    } else {

                        // Verifico que el usuario esté activo 
                        $UsrActivo = $InfoUsuario[0]->estado;
                        if ($UsrActivo == 0) {
                            $Mensaje = "El usuario se encuentra inactivo";
                            $Redireccion = "/panel/login";
                            return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
                        }

                        //-- Escenario 3 --//
                        Session::put('user', $user);
                        // Validar Correo //
                        print 'Entro 1' . $DataEmpleadoEmail;
                        die();
                        return view('noticias.panel-noticias')->with('DatosUsuario', $InfoUsuario);
                    }
                }
            } else {
                $Mensaje = "No existe el usuario " . $user;
                $Redireccion = "/panel/login";
                return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
            }
            // Fin Tercer y Cuarto Escenario //

        } else {

            //Datos Generales 
            $InfoUsuario = PanelLogin::getUsuario($user);
            $idEmpleado = $InfoUsuario[0]->empleado;
            $DataEmpleado = ParametrizacionPanelEmpleados::getEmpleado($idEmpleado);
            $identificacion = $DataEmpleado[0]->identificacion;
            $DataEmpleadoEmail = $DataEmpleado[0]->correo;
            $DataEmpleadoEmailEmpresa = $DataEmpleado[0]->email_empresa;
            $idUser = $InfoUsuario[0]->id_usuario;

            // Verifico que el usuario esté activo 
            $UsrActivo = $InfoUsuario[0]->estado;
            if ($UsrActivo == 0) {
                $Mensaje = "El usuario se encuentra inactivo";
                $Redireccion = "/panel/login";
                return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
            }

            // Inicio Primer Escenario //
            /* 
                Usuario Existe
                User = Identificación
                Pass != Identificación 
            */
            if (($user == $identificacion) && ($pass != $identificacion)) {

                $PassNmEncr  = $InfoUsuario[0]->password;
                $PassNm      = Hash::check($pass, $PassNmEncr);

                // Si el password no coincide
                if ($PassNm == 0) {
                    $Mensaje = "Error en la contraseña, verifique por favor";
                    $Redireccion = "/panel/login";
                    return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
                } else {
                    Session::put('user', $user);
                    // Validar Correo //
                    $ValidarEmail = explode('@', $DataEmpleadoEmail);
                    if ($ValidarEmail[1] == 'berhlan.com' || $ValidarEmail[1] == 'bpack.com.co') {
                        return view('noticias.panel-noticias')->with('DatosUsuario', $InfoUsuario);
                    } else {
                        $DatosUsuario = PanelLogin::getUsuario($user);
                        if ($DataEmpleadoEmailEmpresa == 1) {
                            return view('noticias.panel-noticias')->with('DatosUsuario', $InfoUsuario);
                        } else {
                            return view('panel-cambioemail-new')->with('DatosUsuario', $DatosUsuario)->with('pwd1', $DataEmpleadoEmail);
                        }
                    }
                    // Validar Correo //
                }
            }
            // Fin Primer Escenario //


            // Inicio Segundo Escenario //
            /* 
                Usuario Existe
                User = Identificación
                Pass = Identificación 
            */
            if (($user == $identificacion) && ($pass == $identificacion)) {
                // Si son Iguales, pide cambio de contraseña
                $PassNmEncr  = $InfoUsuario[0]->password;
                $PassNm      = Hash::check($pass, $PassNmEncr);

                // Si el password no coincide
                if ($PassNm == 0) {
                    $Mensaje = "Error en la contraseña, verifique por favor";
                    $Redireccion = "/panel/login";
                    return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
                } else {
                    Session::put('user', $user);
                    $DatosUsuario = PanelLogin::getUsuario($user);
                    return view('panel-cambiopwd-new')->with('DatosUsuario', $DatosUsuario)->with('pwd1', $pass);
                }
            }
            // Fin Segundo Escenario //

            // Inicio Tercer Escenario //
            /* 
                Usuario Existe
                User = Identificación
                Pass = Identificación 
            */
            if (($user != $identificacion) && ($pass == $identificacion)) {
                // Si son Iguales, pide cambio de contraseña
                $PassNmEncr  = $InfoUsuario[0]->password;
                $PassNm      = Hash::check($pass, $PassNmEncr);

                // Si el password no coincide
                if ($PassNm == 0) {
                    $Mensaje = "Error en la contraseña, verifique por favor";
                    $Redireccion = "/panel/login";
                    return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
                } else {

                    $datos = array();
                    $datos['login'] = $identificacion;
                    PanelLogin::actualizarLogin($idUser, $datos);

                    Session::put('user', $identificacion);
                    $DatosUsuario = PanelLogin::getUsuario($identificacion);
                    return view('panel-cambiopwd-new')->with('DatosUsuario', $DatosUsuario)->with('pwd1', $pass);
                }
            }
            // Fin Tercer Escenario //

            // Inicio Cuarto Escenario //
            /* 
                Usuario Existe
                User = Identificación
                Pass = Identificación 
            */
            if (($user != $identificacion) && ($pass != $identificacion)) {
                // Si son Iguales, pide cambio de contraseña
                $PassNmEncr  = $InfoUsuario[0]->password;
                $PassNm      = Hash::check($pass, $PassNmEncr);

                // Si el password no coincide
                if ($PassNm == 0) {
                    $Mensaje = "Error en la contraseña, verifique por favor";
                    $Redireccion = "/panel/login";
                    return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
                } else {

                    $datos = array();
                    $datos['login'] = $identificacion;
                    PanelLogin::actualizarLogin($idUser, $datos);

                    Session::put('user', $identificacion);
                    print 'Entro 3' . $DataEmpleadoEmail;
                    die();
                    $DatosUsuario = PanelLogin::getUsuario($identificacion);
                    // Validar Correo //
                    return view('noticias.panel-noticias')->with('DatosUsuario', $InfoUsuario);
                }
            }
            // Fin Tercer Escenario //
        }
    }


    public function showSalir()
    {
        Session::flush();
        return redirect('/panel/login');
    }


    public function showMenu($id)
    {
        if (Session::has('user')) {
            $user         = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);
            $Menu         = PanelLogin::getMenuInfo($id);
            return view('panel-menu')->with('DatosUsuario', $DatosUsuario)->with('Menu', $Menu);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }


    public function showConstruccion()
    {
        if (Session::has('user')) {
            $user         = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);
            return view('panel-construccion')->with('DatosUsuario', $DatosUsuario);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }


    public function PwdModificar()
    {
        if (Session::has('user')) {
            $user         = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);
            return view('panel-cambiopwd')->with('DatosUsuario', $DatosUsuario);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function PwdModificarDB()
    {
        if (Session::has('user')) {
            $formData     = Request::all();
            $user         = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);
            $pwd1         = $formData['pwd1'];
            $pwd2         = $formData['pwd2'];
            $pwd3         = $formData['pwd3'];

            //Realizo las validaciones
            $Mensaje = "";

            $PassNmEncr = $DatosUsuario[0]->password;
            $PassNm     = Hash::check($pwd1, $PassNmEncr);
            if ($PassNm == 0)
                $Mensaje = "Error en la contraseña anterior, verifique por favor.";

            if ($pwd2 != $pwd3)
                $Mensaje = "La contraseña ingresada no coincide.";

            $datos = array();

            if ($Mensaje != "") {
                $Redireccion = "/panel/cambiopwd";
                return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
            } else {
                $datos['password'] = Hash::make($pwd2);

                PanelUsuarios::actualizarUsuario($DatosUsuario[0]->id_usuario, $datos);
                $ErrorValidacion = "Contraseña cambiada.";
                return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
            }
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function EmailModificar()
    {
        if (Session::has('user')) {
            $user         = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);
            return view('panel-cambioemail')->with('DatosUsuario', $DatosUsuario);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function EmailModificarDB()
    {
        if (Session::has('user')) {
            $formData     = Request::all();
            $user         = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);
            $correo         = strtolower($formData['pwd2']);
            $email_empresa  = $formData['email_empresa'];
            $datos = array();
            $id_empleado = $formData['id_empleado'];

            if ($email_empresa != 1) {
                $datos['correo'] = $correo;
            } else {
                if ($correo != '') {
                    $ValidarEmail = explode('@', $correo);
                    if ($ValidarEmail[1] == 'berhlan.com' || $ValidarEmail[1] == 'bpack.com.co') {
                        $datos['correo'] = $correo;
                        $datos['email_empresa'] = 0;
                    } else {
                        $datos['email_empresa']  = $formData['email_empresa'];
                    }
                } else {
                    $datos['email_empresa']  = $formData['email_empresa'];
                }
            }

            ParametrizacionPanelEmpleados::actualizarEmpleado($id_empleado, $datos);
            return view('noticias.panel-noticias')->with('DatosUsuario', $DatosUsuario);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /*Esta funcion es solo como muestra no hace parte del proyecto*/
    public function UsurocarDB()
    {
        if (Session::has('user')) {
            $formData = Request::all();
            $user = $formData['username'];
            $userM = $formData['usernameM'];
            $idM = $formData['idM'];
            $id = $formData['id'];
            $email = $formData['email'];
            $key = $formData['key'];
            $IdEmpleado = $formData['id_empleado'];
            $IdCliente = $formData['id_cliente'];

            if ($IdEmpleado == 0 && $IdCliente == 0) {
                $asociado = 0;
                $tipo = 0;
            }

            if ($IdEmpleado != 0 && $IdCliente == 0) {
                $asociado = $IdEmpleado;
                $tipo = 1;
            }

            if ($IdEmpleado == 0 && $IdCliente != 0) {
                $asociado = $IdCliente;
                $tipo = 2;
            }

            if ($IdEmpleado != 0 && $IdCliente != 0) {
                $asociado = 0;
                $tipo = 0;
            }

            if ($id == 1) {
                $modulos = implode(",", $formData['modulos']);
            } else {
                $modulos = $formData['modulos'];
            }

            $DatosUser = PanelLogin::getUser($idM);

            $usuario = PanelLogin::getUser($idM);

            if (empty($formData['secretM'])) {

                if ($user == $userM) {
                    foreach ($usuario as $DatUs) {
                        $passM = $DatUs->pass;
                    }
                    PanelLogin::updateUser($idM, $user, $passM, $modulos, $email, $key, $tipo, $asociado);
                }

                if ($user != $userM) {

                    $numUs = PanelLogin::getNumUsers();
                    $users = PanelLogin::getUsers();

                    if ($numUs != 0) {
                        foreach ($users as $DatUsers) {

                            $userNm = $DatUsers->nom_user;

                            if ($userNm == $userM) {
                                Session::flash('message1', 'El Usuario ya Existe en el Sistema!');
                            } else {
                                foreach ($usuario as $DatUs) {
                                    $passM = $DatUs->pass;
                                }
                                PanelLogin::updateUser($idM, $userM, $passM, $modulos, $email, $key, $tipo, $asociado);
                            }
                        }
                    }
                }

                $DatosUser = PanelLogin::getUser($id);
                $DatosUsers = PanelLogin::getUsers();
                return view('panel-usuarios')->with('DatosUser', $DatosUser)->with('DatosUsers', $DatosUsers);
            } else {

                if ($user == $userM) {
                    $passM = $formData['secretM'];
                    $passEncr = Hash::make($passM);
                    PanelLogin::updateUser($idM, $userM, $passEncr, $modulos, $email, $key, $tipo, $asociado);
                }

                if ($user != $userM) {

                    $numUs = PanelLogin::getNumUsers();
                    $users = PanelLogin::getUsers();

                    if ($numUs != 0) {
                        foreach ($users as $DatUsers) {

                            $userNm = $DatUsers->nom_user;

                            if ($userNm == $userM) {
                                Session::flash('message1', 'El Usuario ya Existe en el Sistema!');
                            } else {
                                $passM = $formData['secretM'];
                                $passEncr = Hash::make($passM);
                                PanelLogin::updateUser($idM, $userM, $passEncr, $modulos, $email, $key, $tipo, $asociado);
                            }
                        }
                    }
                }

                Session::flush();
                return redirect($this->server . '/panel/login');
            }
        } else {
            return view('panel-loginfalse');
        }
    }
}
