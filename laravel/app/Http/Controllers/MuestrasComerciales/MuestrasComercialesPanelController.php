<?php

namespace App\Http\Controllers\MuestrasComerciales;

use App\Http\Controllers\Controller;
use App\Models\PanelLogin;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelEmpleados as ParametrizacionPanelEmpleados;
use App\Models\Parametrizacion\PanelUsuarios;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Request;
use App\Models\MuestrasComerciales\PanelMuestrasComerciales;
use Exception;

class MuestrasComercialesPanelController extends Controller
{

    var $server = '/Berhlan/public';

    public function eliminar_tildes($cadena)
    {
        //Codificamos la cadena en formato utf8 en caso de que nos de errores
        //$cadena = utf8_encode($cadena);

        //Ahora reemplazamos las letras
        $cadena = str_replace(
            array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
            array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
            $cadena
        );

        $cadena = str_replace(
            array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
            array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
            $cadena
        );

        $cadena = str_replace(
            array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
            array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
            $cadena
        );

        $cadena = str_replace(
            array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
            array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
            $cadena
        );

        $cadena = str_replace(
            array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
            array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
            $cadena
        );

        $cadena = str_replace(
            array('ñ', 'Ñ', 'ç', 'Ç', ' ', '#', '%', '°', '´'),
            array('n', 'N', 'c', 'C', '_',  '',  '',  '',  ''),
            $cadena
        );
        return $cadena;
    }

    public function showListaMuestrasComerciales()
    {

        if (Session::has('user')) {
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);
            $DatosMuestrasComerciales = PanelMuestrasComerciales::getMuestrasComerciales();

            $ErrorValidacion = "";  //Variable que retorna el error en caso de que no pase la validación
            return view('muestras-comerciales.panel-muestrascomerciales')->with('ErrorValidacion', $ErrorValidacion)->with('DatosUsuario', $DatosUsuario)->with('DatosMuestrasComerciales', $DatosMuestrasComerciales);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    // Agregar
    public function showMuestrasComercialesPreAgregar()
    {
        if (Session::has('user')) {
            $user         = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);
            $Empleado = ParametrizacionPanelEmpleados::getEmpleado($DatosUsuario[0]->empleado);
            $idEmpleado = $Empleado[0]->id_empleado;
            $NombreEmpleado = $Empleado[0]->primer_nombre . ' ' . $Empleado[0]->ot_nombre . ' ' . $Empleado[0]->primer_apellido . ' ' . $Empleado[0]->ot_apellido;

            return view('muestras-comerciales.panel-muestrasComercialesPreAgregar')->with('DatosUsuario', $DatosUsuario);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function showMuestrasComercialesAgregar()
    {
        if (Session::has('user')) {
            $user         = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);
            $Empleado = ParametrizacionPanelEmpleados::getEmpleado($DatosUsuario[0]->empleado);
            $idEmpleado = $Empleado[0]->id_empleado;
            $NombreEmpleado = $Empleado[0]->primer_nombre . ' ' . $Empleado[0]->ot_nombre . ' ' . $Empleado[0]->primer_apellido . ' ' . $Empleado[0]->ot_apellido;
            $formData     = Request::all();
            $marca = $formData['marca'];


            /* PRODUCTOS SIESA  */
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://192.168.1.206/WSUNOEE/WSUNOEE.asmx',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_HTTP_CONTENT_DECODING => true,
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '<soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
                   <soap12:Body>
                     <EjecutarConsultaXML xmlns="http://tempuri.org/">
                       <pvstrxmlParametros>
                         &lt;Consulta>
                             &lt;NombreConexion>UnoEE&lt;/NombreConexion>
                             &lt;IdCia>1&lt;/IdCia>
                             &lt;IdProveedor>ES&lt;/IdProveedor>
                             &lt;IdConsulta>CONSULTA_MCMARCA&lt;/IdConsulta>
                             &lt;Usuario>web.service&lt;/Usuario>
                             &lt;Clave>12345&lt;/Clave>
                             &lt;Parametros>
                                &lt;marca>' . $marca . '&lt;/marca>
                            &lt;/Parametros>
                         &lt;/Consulta>
                       </pvstrxmlParametros>
                     </EjecutarConsultaXML>
                   </soap12:Body>
                 </soap12:Envelope>',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: text/xml; charset=utf-8'
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $DataRTPItems = array();
            $newDataRTPItems = array();
            $soap_response = $response;
            $dom_result = new \DOMDocument;

            if (!$dom_result->loadXML($soap_response))
                throw new Exception(_('Error parsing response'), 11);

            $xpath = new \DOMXPath($dom_result);

            // Define an XPath query to select all rows within the list
            $query = "//NewDataSet/Resultado";

            // Use the query to fetch all rows
            $rows = $xpath->query($query);

            // Iterate through the rows and output their text content
            $numRows = 0;
            foreach ($rows as $row) {
                $DataRTPItems['item'] = $dom_result->getElementsByTagName('item')->item($numRows)->nodeValue;
                $DataRTPItems['descripcion'] = $dom_result->getElementsByTagName('descripcion')->item($numRows)->nodeValue;
                $DataRTPItems['maquila'] = $dom_result->getElementsByTagName('maquila')->item($numRows)->nodeValue;
                array_push($newDataRTPItems, $DataRTPItems);
                $numRows++;
            }
            /* PRODUCTOS SIESA  */

            return view('muestras-comerciales.panel-muestrasComercialesAgregar')->with('DatosUsuario', $DatosUsuario)->with('idEmpleado', $idEmpleado)->with('NombreEmpleado', $NombreEmpleado)->with('newDataRTPItems', $newDataRTPItems)->with('marca', $marca);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function MuestrasComercialesAgregarDB()
    {
        if (Session::has('user')) {
            $user         = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);
            $Empleado = $DatosUsuario[0]->empleado;
            $DataEmpleado = PanelEmpleados::getEmpleado($Empleado);
            $emailEmpleadoCm = $DataEmpleado[0]->correo;
            $nombreEmpleadoCm = $DataEmpleado[0]->primer_nombre . ' ' . $DataEmpleado[0]->ot_nombre . ' ' . $DataEmpleado[0]->primer_apellido . ' ' . $DataEmpleado[0]->ot_apellido;
            $formData     = Request::all();
            $datos = array();
            $datosItems = array();
            $datosLogs = array();

            $Cant = PanelMuestrasComerciales::getCantMuestrasComerciales();

            if ($Cant == 0) {
                $Consecutivo = 1;
            } else {
                $UltimoId = PanelMuestrasComerciales::getUltimoMuestrasComerciales();
                foreach ($UltimoId as $UltId) {
                    $Uid = $UltId->consecutivo;
                    $Consecutivo = $Uid + 1;
                }
            }

            $datos['consecutivo'] = $Consecutivo;
            $datos['nombre_destinatario'] = $formData['destinatario'];
            $datos['celular_destinatario'] = $formData['cel-destinatario'];

            $fechaSolicitud = date('Y-m-d H:i:s');
            $fechaMercadeo = date('Y-m-d H:i:s', strtotime($fechaSolicitud . ' +2 days'));
            $fechaCalidad = date('Y-m-d H:i:s', strtotime($fechaSolicitud . ' +5 days'));

            $datos['fecha_solicitud'] = $fechaSolicitud;
            $datos['fecha_mercadeo'] = $fechaMercadeo;
            $datos['fecha_calidad'] = $fechaCalidad;

            $marca = $formData['marca'];
            $datos['fecha_estimada_entrega'] = $formData['fecha_entrega'];
            $datos['nit_cliente'] = $formData['nit'];
            $datos['direccion_cliente'] = $formData['direccion'];
            $datos['gestionado'] = 0;
            $datos['despachado'] = 0;
            $datos['motivo'] = $formData['motivo'];
            $datos['motivo_rechazo'] = 0;
            $datos['aprobado_mercadeo'] = 0;
            $datos['aprobado_calidad'] = 0;
            $datos['estado'] = 0;
            $datos['id_empleado'] = $formData['idEmpleado'];
            $datos['ciudad'] = $formData['ciudad'];
            $datos['nombre_cliente'] = $formData['razon_social'];
            $items =  $formData['items'];
            $TamItems = sizeof($items);
            $datos['marca'] = $formData['marca'];

            if ($marca == 'BONDI' || $marca == 'SUPER B') {
                //$correoNotificacion = 'leidy.sanchez@berhlan.com';
                $correoNotificacion = 'julian.carmona@berhlan.com';
                $nombreEmpleado = 'Leidy Sanchez';
            }

            if ($marca == 'AMATIC' || $marca == 'BERHLAN') {
                //$correoNotificacion = 'sara.velez@berhlan.com';
                $correoNotificacion = 'julian.carmona@berhlan.com';
                $nombreEmpleado = 'Sara Velez';
            }

            if ($marca == 'MAQUILA') {
                //$correoNotificacion = 'victor.castano@berhlan.com';
                $correoNotificacion = 'julian.carmona@berhlan.com';
                $nombreEmpleado = 'Victor Castaño';
            }

            if ($correoNotificacion == '' || $correoNotificacion == NULL || $correoNotificacion == 'No Aplica') {
                //$correoNotificacion = 'informes@berhlan.com';
                $correoNotificacion = 'julian.carmona@berhlan.com';
                $nombreEmpleado = 'Notificaciones Berhlan';
            }

            $correoNotificacionCm = $emailEmpleadoCm;
            $nombreEmpleadoCm = $nombreEmpleadoCm;




            PanelMuestrasComerciales::insertMuestraComercial($datos);
            $ultiomoMC = PanelMuestrasComerciales::getUltimoMuestrasComerciales();
            $ultimoIdMc = $ultiomoMC[0]->id;

            /* CREACIÓN DE LOGS */
            $datosLogs['idmc'] = $ultimoIdMc;
            $datosLogs['iduser'] = $Empleado;
            $datosLogs['movimiento'] = 'Creación de Solicitud Comercial';
            $items = $formData['items'];
            $itemsJson = json_encode($items);
            $datosLogs['items'] = $itemsJson;
            $datosLogs['fecha'] = NOW();
            PanelMuestrasComerciales::insertLogsMuestraComercial($datosLogs);
            /* CREACIÓN DE LOGS */

            date_default_timezone_set('America/Bogota');
            $fecha = date("Y-m-d");

            /* ENVIO NOTIFICACIÓN POR MARCA */
            $datosEmail['nombre'] = 'SOLICITUDES MUESTRAS COMERCIALES';
            $datosEmail['email'] = $correoNotificacion;
            $datosEmail['numsolicitud'] = 'MC-' . $ultiomoMC[0]->consecutivo;
            $datosEmail['titsolicitud'] = '';
            $datosEmail['fechacreacion'] = $fecha;
            $datosEmail['empleado'] =  $nombreEmpleado;
            $datosEmail['marca'] = $marca;
            $datosEmail['mensajel1'] = 'SOLICITUD';
            $datosEmail['mensajel2'] = 'DE LA MARCA';
            $datosEmail['mensajel3'] = 'SE HA RECIBIDO CON ÉXITO!!!';
            $datosEmail['link_ticket'] = 'https://192.168.1.210/Berhlan/public/panel/muestrascomerciales-modificar/' . $ultimoIdMc;

            Mail::send('email.notificacion_muestra_comercial', $datosEmail, function ($message) use ($datosEmail) {
                $admin = $datosEmail['email'];
                $nombre = $datosEmail['nombre'];
                $message->subject('Notificaciones Intranet');
                $message->from('notificacionesberhlan@berhlan.com', $nombre);
                $message->to($admin);
            });
            /* ENVIO NOTIFICACIÓN POR MARCA */

            /* ENVIO NOTIFICACIÓN COMERCIAL*/
            $datosEmail['nombre'] = 'SOLICITUDES MUESTRAS COMERCIALES';
            $datosEmail['email'] = $correoNotificacionCm;
            $datosEmail['numsolicitud'] = 'MC-' . $ultiomoMC[0]->consecutivo;
            $datosEmail['titsolicitud'] = '';
            $datosEmail['fechacreacion'] = $fecha;
            $datosEmail['empleado'] =  $nombreEmpleadoCm;
            $datosEmail['marca'] = $marca;
            $datosEmail['mensajel1'] = 'SU SOLICITUD';
            $datosEmail['mensajel2'] = 'DE LA MARCA';
            $datosEmail['mensajel3'] = 'SE HA RECIBIDO CON ÉXITO!!!';
            $datosEmail['link_ticket'] = 'https://192.168.1.210/Berhlan/public/panel/muestrascomerciales-modificar/' . $ultimoIdMc;

            Mail::send('email.notificacion_muestra_comercial', $datosEmail, function ($message) use ($datosEmail) {
                $admin = $datosEmail['email'];
                $nombre = $datosEmail['nombre'];
                $message->subject('Notificaciones Intranet');
                $message->from('notificacionesberhlan@berhlan.com', $nombre);
                $message->to($admin);
            });
            /* ENVIO NOTIFICACIÓN POR COMERCIAL */

            $i = 0;
            while ($i < $TamItems) {
                $item = explode(';', $formData['items'][$i]);
                $datosItems['id_muestra_comercial'] = $ultimoIdMc;
                $datosItems['id_item_siesa'] = $item[0];
                $datosItems['marca'] = $item[2];
                $maquila = $formData['maquila'][$i];

                if ($maquila == 1) {

                    //$correoNotificacion = 'victor.castano@berhlan.com';
                    $correoNotificacion = 'julian.carmona@berhlan.com';
                    $nombreEmpleado = 'Victor Castaño';

                    /* ENVIO NOTIFICACIÓN SI ES MAQUILA */
                    $datosEmail['nombre'] = 'SOLICITUDES MUESTRAS COMERCIALES';
                    $datosEmail['email'] = $correoNotificacion;
                    $datosEmail['numsolicitud'] = 'MC-' . $ultiomoMC[0]->consecutivo;
                    $datosEmail['titsolicitud'] = '';
                    $datosEmail['fechacreacion'] = ' (Modificación) | ' . $fecha;
                    $datosEmail['empleado'] =  $nombreEmpleado;
                    $datosEmail['marca'] = $marca . ' (Con una Maquila)';
                    $datosEmail['mensajel1'] = 'SOLICITUD';
                    $datosEmail['mensajel2'] = 'DE LA MARCA';
                    $datosEmail['mensajel3'] = 'SE HA RECIBIDO CON ÉXITO!!!';
                    $datosEmail['link_ticket'] = 'https://192.168.1.210/Berhlan/public/panel/muestrascomerciales-modificar/' . $ultimoIdMc;

                    Mail::send('email.notificacion_muestra_comercial', $datosEmail, function ($message) use ($datosEmail) {
                        $admin = $datosEmail['email'];
                        $nombre = $datosEmail['nombre'];
                        $message->subject('Notificaciones Intranet');
                        $message->from('notificacionesberhlan@berhlan.com', $nombre);
                        $message->to($admin);
                    });
                    /* ENVIO NOTIFICACIÓN SI ES MAQUILA */
                }

                $datosItems['descripcion_item'] = $item[1];
                $datosItems['observaciones'] = $formData['observaciones'][$i];
                $datosItems['cantidad'] = $formData['cantidad'][$i];
                $datosItems['maquila'] = $formData['maquila'][$i];
                PanelMuestrasComerciales::insertItemsMuestraComercial($datosItems);
                $i++;
            }

            $MuestrasComerciales =  PanelMuestrasComerciales::getMuestrasComerciales();

            return redirect('/panel/muestrascomerciales/lista')->with('DatosUsuario', $DatosUsuario)->with('MuestrasComerciales', $MuestrasComerciales);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    // Editar Solicitud
    public function showMuestasComercialesModificar($id)
    {
        if (Session::has('user')) {
            $user         = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);
            $MuestraComercial = PanelMuestrasComerciales::getMuestraComercial($id);
            $ItemsMuestraComercial = PanelMuestrasComerciales::getItemsMuestrasComerciales($id);


            $marca = $MuestraComercial[0]->marca;
            $Empleado = ParametrizacionPanelEmpleados::getEmpleado($DatosUsuario[0]->empleado);
            $idEmpleado = $Empleado[0]->id_empleado;
            $NombreEmpleado = $Empleado[0]->primer_nombre . ' ' . $Empleado[0]->ot_nombre . ' ' . $Empleado[0]->primer_apellido . ' ' . $Empleado[0]->ot_apellido;
            $CargoEmpleado = $Empleado[0]->cargo;

            /* PRODUCTOS SIESA  */
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://192.168.1.206/WSUNOEE/WSUNOEE.asmx',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_HTTP_CONTENT_DECODING => true,
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '<soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
                <soap12:Body>
                  <EjecutarConsultaXML xmlns="http://tempuri.org/">
                    <pvstrxmlParametros>
                      &lt;Consulta>
                          &lt;NombreConexion>UnoEE&lt;/NombreConexion>
                          &lt;IdCia>1&lt;/IdCia>
                          &lt;IdProveedor>ES&lt;/IdProveedor>
                          &lt;IdConsulta>CONSULTA_MCMARCA&lt;/IdConsulta>
                          &lt;Usuario>web.service&lt;/Usuario>
                          &lt;Clave>12345&lt;/Clave>
                          &lt;Parametros>
                             &lt;marca>' . $marca . '&lt;/marca>
                         &lt;/Parametros>
                      &lt;/Consulta>
                    </pvstrxmlParametros>
                  </EjecutarConsultaXML>
                </soap12:Body>
              </soap12:Envelope>',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: text/xml; charset=utf-8'
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $DataRTPItems = array();
            $newDataRTPItems = array();
            $soap_response = $response;
            $dom_result = new \DOMDocument;

            if (!$dom_result->loadXML($soap_response))
                throw new Exception(_('Error parsing response'), 11);

            $xpath = new \DOMXPath($dom_result);

            // Define an XPath query to select all rows within the list
            $query = "//NewDataSet/Resultado";

            // Use the query to fetch all rows
            $rows = $xpath->query($query);

            // Iterate through the rows and output their text content
            $numRows = 0;
            foreach ($rows as $row) {
                $DataRTPItems['item'] = $dom_result->getElementsByTagName('item')->item($numRows)->nodeValue;
                $DataRTPItems['descripcion'] = $dom_result->getElementsByTagName('descripcion')->item($numRows)->nodeValue;
                $DataRTPItems['maquila'] = $dom_result->getElementsByTagName('maquila')->item($numRows)->nodeValue;
                array_push($newDataRTPItems, $DataRTPItems);
                $numRows++;
            }
            /* PRODUCTOS SIESA  */

            return view('muestras-comerciales.panel-muestrasComercialesEditar')->with('DatosUsuario', $DatosUsuario)->with('MuestraComercial', $MuestraComercial)->with('ItemsMuestraComercial', $ItemsMuestraComercial)->with('newDataRTPItems', $newDataRTPItems)->with('idEmpleado', $idEmpleado)->with('NombreEmpleado', $NombreEmpleado)->with('CargoEmpleado', $CargoEmpleado);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function MuestrasComercialesModificarDB()
    {
        if (Session::has('user')) {
            $user         = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            $Empleado = $DatosUsuario[0]->empleado;

            $formData     = Request::all();
            $datos = array();
            $datosItems = array();

            $idMc = $formData['id'];
            $MuestraComercial = PanelMuestrasComerciales::getMuestraComercial($idMc);
            $Consecutivo = $MuestraComercial[0]->consecutivo;
            $Marca = $MuestraComercial[0]->marca;
            $EmpleadoCm = $MuestraComercial[0]->id_empleado;
            $DataEmpleado = PanelEmpleados::getEmpleado($EmpleadoCm);
            $correoNotificacionCm = $DataEmpleado[0]->correo;
            $nombreEmpleadoCm = $DataEmpleado[0]->primer_nombre . ' ' . $DataEmpleado[0]->ot_nombre . ' ' . $DataEmpleado[0]->primer_apellido . ' ' . $DataEmpleado[0]->ot_apellido;

            $consecutivo = $formData['consecutivo'];
            $datos['nombre_destinatario'] = $formData['destinatario'];
            $datos['celular_destinatario'] = $formData['cel-destinatario'];
            $datos['fecha_estimada_entrega'] = $formData['fecha_entrega'];
            $datos['nit_cliente'] = $formData['nit'];
            $datos['direccion_cliente'] = $formData['direccion'];
            $datos['gestionado'] = $formData['gestionado'];
            $datos['despachado'] = $formData['despachado'];
            $datos['motivo'] = $formData['motivo'];
            $datos['estado'] = $formData['estado'];
            $datos['motivo_rechazo'] = $formData['motivo_rechazo'];
            $datos['observaciones_rechazo'] = $formData['observaciones_rechazo'];
            $aprobado_mercadeo = $formData['aprobado_mercadeo'];
            $datos['aprobado_mercadeo'] = $formData['aprobado_mercadeo'];
            $aprobado_calidad = $formData['aprobado_calidad'];
            $datos['aprobado_calidad'] = $formData['aprobado_calidad'];
            $datos['nombre_cliente'] = $formData['razon_social'];
            $datos['ciudad'] = $formData['ciudad'];
            $datos['observaciones_mercadeo'] = $formData['observaciones_mercadeo'];
            $datos['observaciones_calidad'] = $formData['observaciones_calidad'];
            $datos['estado_despachado'] = $formData['estado_despachado'];

            $marca = $formData['marca'];
            $datos['marca'] = $formData['marca'];

            $MuestraComercial = PanelMuestrasComerciales::getMuestraComercial($idMc);
            date_default_timezone_set('America/Bogota');
            $fecha = date("Y-m-d");


            // Si Cambia el Estado
            if ($formData['estado'] != 0) {

                if ($formData['estado'] == 1) {
                    $titEstado = 'Aprobado';
                }

                if ($formData['estado'] == 2) {
                    $titEstado = 'Rechazado';
                }

                if ($formData['estado'] == 3) {
                    $titEstado = 'Cancelado';
                }



                if (isset($formData['items'])) {
                    if (in_array("0", $formData['items'])) {

                        /* CREACIÓN DE LOGS */
                        $items = $formData['itemslogs'];
                        $datosLogs['idmc'] = $idMc;
                        $datosLogs['iduser'] = $Empleado;
                        $datosLogs['movimiento'] = 'Cambio de Estado a ( ' . $titEstado . ' )';
                        $datosLogs['items'] = $items;
                        $datosLogs['fecha'] = NOW();
                        PanelMuestrasComerciales::insertLogsMuestraComercial($datosLogs);
                        /* CREACIÓN DE LOGS */
                    } else {
                        /* CREACIÓN DE LOGS */
                        $items = $formData['items'];
                        $itemsJson = json_encode($items);
                        $datosLogs['items'] = $itemsJson;
                        $items = $itemsJson;
                        $datosLogs['idmc'] = $idMc;
                        $datosLogs['iduser'] = $Empleado;
                        $datosLogs['movimiento'] = 'Ingreso de Nuevos Items y Cambio de Estado a ( ' . $titEstado . ' )';
                        $datosLogs['items'] = $items;
                        $datosLogs['fecha'] = NOW();
                        PanelMuestrasComerciales::insertLogsMuestraComercial($datosLogs);
                        /* CREACIÓN DE LOGS */
                    }
                } else {
                    /* CREACIÓN DE LOGS */
                    $items = $formData['itemslogs'];
                    $datosLogs['idmc'] = $idMc;
                    $datosLogs['iduser'] = $Empleado;
                    $datosLogs['movimiento'] = 'Cambio de Estado a ( ' . $titEstado . ' )';
                    $datosLogs['items'] = $items;
                    $datosLogs['fecha'] = NOW();
                    PanelMuestrasComerciales::insertLogsMuestraComercial($datosLogs);
                    /* CREACIÓN DE LOGS */
                }
            }


            // Si Cambia el Estado Despachado
            if ($formData['estado_despachado'] != 0) {

                if ($formData['estado_despachado'] == 1) {
                    $titEstado = 'Despachado';
                }

                if ($formData['estado_despachado'] == 2) {
                    $titEstado = 'Sin Despachar';
                }


                if (isset($formData['items'])) {
                    if (in_array("0", $formData['items'])) {
                        /* CREACIÓN DE LOGS */
                        $items = $formData['itemslogs'];
                        $datosLogs['idmc'] = $idMc;
                        $datosLogs['iduser'] = $Empleado;
                        $datosLogs['movimiento'] = 'Cambio de Estado Despachado a ( ' . $titEstado . ' )';
                        $datosLogs['items'] = $items;
                        $datosLogs['fecha'] = NOW();
                        PanelMuestrasComerciales::insertLogsMuestraComercial($datosLogs);
                        /* CREACIÓN DE LOGS */
                    } else {
                        /* CREACIÓN DE LOGS */
                        $items = $formData['items'];
                        $itemsJson = json_encode($items);
                        $datosLogs['items'] = $itemsJson;
                        $items = $itemsJson;
                        $datosLogs['idmc'] = $idMc;
                        $datosLogs['iduser'] = $Empleado;
                        $datosLogs['movimiento'] = 'Ingreso de Nuevos Items y Cambio de Estado Despchado a ( ' . $titEstado . ' )';
                        $datosLogs['items'] = $items;
                        $datosLogs['fecha'] = NOW();
                        PanelMuestrasComerciales::insertLogsMuestraComercial($datosLogs);
                        /* CREACIÓN DE LOGS */
                    }
                } else {
                    /* CREACIÓN DE LOGS */
                    $items = $formData['itemslogs'];
                    $datosLogs['idmc'] = $idMc;
                    $datosLogs['iduser'] = $Empleado;
                    $datosLogs['movimiento'] = 'Cambio de Estado Despachado a ( ' . $titEstado . ' )';
                    $datosLogs['items'] = $items;
                    $datosLogs['fecha'] = NOW();
                    PanelMuestrasComerciales::insertLogsMuestraComercial($datosLogs);
                    /* CREACIÓN DE LOGS */
                }

                /* ENVIO NOTIFICACIÓN COMERCIAL */
                $datosEmail['nombre'] = 'SOLICITUDES MUESTRAS COMERCIALES';
                $datosEmail['email'] = $correoNotificacionCm;
                $datosEmail['numsolicitud'] = 'MC-' . $Consecutivo;
                $datosEmail['titsolicitud'] = '';
                $datosEmail['fechacreacion'] = $fecha;
                $datosEmail['empleado'] =  $nombreEmpleadoCm;
                $datosEmail['marca'] = $Marca;
                $datosEmail['mensajel1'] = 'SU SOLICITUD';
                $datosEmail['mensajel2'] = 'DE LA MARCA';
                $datosEmail['mensajel3'] = 'SE HA MODIFICADO EN DESPACHOS A ( ' . $titEstado . ' ) !!!';
                $datosEmail['link_ticket'] = 'https://192.168.1.210/Berhlan/public/panel/muestrascomerciales-modificar/' . $idMc;

                Mail::send('email.notificacion_muestra_comercial', $datosEmail, function ($message) use ($datosEmail) {
                    $admin = $datosEmail['email'];
                    $nombre = $datosEmail['nombre'];
                    $message->subject('Notificaciones Intranet');
                    $message->from('notificacionesberhlan@berhlan.com', $nombre);
                    $message->to($admin);
                });
                /* ENVIO NOTIFICACIÓN POR COMERCIAL */
            }


            // Si Aprobó Mercadeo
            /* ENVIO NOTIFICACIÓN POR APROBADO */
            if ($aprobado_mercadeo != 0 && $aprobado_calidad == 0) {

                //$correoNotificacion = 'lina.castro@berhlan.com';
                $correoNotificacion = 'julian.carmona@berhlan.com';
                $nombreEmpleado = 'Lina Castro';

                //$correoNotificacion2 = 'luis.suarez@berhlan.com';
                $correoNotificacion2 = 'julian.carmona@berhlan.com';
                $nombreEmpleado2 = 'Luis Alejandro Suarez';

                //$correoNotificacion3 = 'guiomar.lara@berhlan.com';
                $correoNotificacion3 = 'julian.carmona@berhlan.com';
                $nombreEmpleado3 = 'Guiomar Lara';

                //$correoNotificacion4 = 'yorlady.marulanda@berhlan.com';
                $correoNotificacion4 = 'julian.carmona@berhlan.com';
                $nombreEmpleado4 = 'Yorlady Marulanda';

                //$correoNotificacion5 = 'juan.arias@berhlan.com';
                $correoNotificacion5 = 'julian.carmona@berhlan.com';
                $nombreEmpleado5 = 'Juan Camilo Arias';

                //$correoNotificacion6 = 'andres.ariza@berhlan.com';
                $correoNotificacion6 = 'julian.carmona@berhlan.com';
                $nombreEmpleado6 = 'Andrés Ariza';

                /* CORREO 1 */
                $datosEmail['nombre'] = 'SOLICITUDES MUESTRAS COMERCIALES';
                $datosEmail['email'] = $correoNotificacion;
                $datosEmail['numsolicitud'] = 'MC-' . $MuestraComercial[0]->consecutivo;
                $datosEmail['titsolicitud'] = '';
                $datosEmail['fechacreacion'] = ' (Modificación) | ' . $fecha;
                $datosEmail['empleado'] =  $nombreEmpleado;
                $datosEmail['marca'] = $marca;
                $datosEmail['mensajel1'] = 'SOLICITUD';
                $datosEmail['mensajel2'] = 'DE LA MARCA';
                $datosEmail['mensajel3'] = 'SE HA MODIFICAD CON UN CAMBIO DE ESTADO A ( ' . $titEstado . ' )!!!';
                $datosEmail['link_ticket'] = 'https://192.168.1.210/Berhlan/public/panel/muestrascomerciales-modificar/' . $idMc;

                Mail::send('email.notificacion_muestra_comercial', $datosEmail, function ($message) use ($datosEmail) {
                    $admin = $datosEmail['email'];
                    $nombre = $datosEmail['nombre'];
                    $message->subject('Notificaciones Intranet');
                    $message->from('notificacionesberhlan@berhlan.com', $nombre);
                    $message->to($admin);
                });
                /* CORREO 1 */


                /* CORREO 2 */
                $datosEmail['nombre'] = 'SOLICITUDES MUESTRAS COMERCIALES';
                $datosEmail['email'] = $correoNotificacion2;
                $datosEmail['numsolicitud'] = 'MC-' . $MuestraComercial[0]->consecutivo;
                $datosEmail['titsolicitud'] = '';
                $datosEmail['fechacreacion'] = ' (Modificación) | ' . $fecha;
                $datosEmail['empleado'] =  $nombreEmpleado2;
                $datosEmail['marca'] = $marca;
                $datosEmail['mensajel1'] = 'SOLICITUD';
                $datosEmail['mensajel2'] = 'DE LA MARCA';
                $datosEmail['mensajel3'] = 'SE HA MODIFICAD CON UN CAMBIO DE ESTADO A ( ' . $titEstado . ' )!!!';
                $datosEmail['link_ticket'] = 'https://192.168.1.210/Berhlan/public/panel/muestrascomerciales-modificar/' . $idMc;

                Mail::send('email.notificacion_muestra_comercial', $datosEmail, function ($message) use ($datosEmail) {
                    $admin = $datosEmail['email'];
                    $nombre = $datosEmail['nombre'];
                    $message->subject('Notificaciones Intranet');
                    $message->from('notificacionesberhlan@berhlan.com', $nombre);
                    $message->to($admin);
                });
                /* CORREO 2 */

                /* CORREO 3 */
                $datosEmail['nombre'] = 'SOLICITUDES MUESTRAS COMERCIALES';
                $datosEmail['email'] = $correoNotificacion3;
                $datosEmail['numsolicitud'] = 'MC-' . $MuestraComercial[0]->consecutivo;
                $datosEmail['titsolicitud'] = '';
                $datosEmail['fechacreacion'] = ' (Modificación) | ' . $fecha;
                $datosEmail['empleado'] =  $nombreEmpleado3;
                $datosEmail['marca'] = $marca;
                $datosEmail['mensajel1'] = 'SOLICITUD';
                $datosEmail['mensajel2'] = 'DE LA MARCA';
                $datosEmail['mensajel3'] = 'SE HA MODIFICAD CON UN CAMBIO DE ESTADO A ( ' . $titEstado . ' )!!!';
                $datosEmail['link_ticket'] = 'https://192.168.1.210/Berhlan/public/panel/muestrascomerciales-modificar/' . $idMc;

                Mail::send('email.notificacion_muestra_comercial', $datosEmail, function ($message) use ($datosEmail) {
                    $admin = $datosEmail['email'];
                    $nombre = $datosEmail['nombre'];
                    $message->subject('Notificaciones Intranet');
                    $message->from('notificacionesberhlan@berhlan.com', $nombre);
                    $message->to($admin);
                });
                /* CORREO 3 */

                /* CORREO 4 */
                $datosEmail['nombre'] = 'SOLICITUDES MUESTRAS COMERCIALES';
                $datosEmail['email'] = $correoNotificacion4;
                $datosEmail['numsolicitud'] = 'MC-' . $MuestraComercial[0]->consecutivo;
                $datosEmail['titsolicitud'] = '';
                $datosEmail['fechacreacion'] = ' (Modificación) | ' . $fecha;
                $datosEmail['empleado'] =  $nombreEmpleado4;
                $datosEmail['marca'] = $marca;
                $datosEmail['mensajel1'] = 'SOLICITUD';
                $datosEmail['mensajel2'] = 'DE LA MARCA';
                $datosEmail['mensajel3'] = 'SE HA MODIFICAD CON UN CAMBIO DE ESTADO A ( ' . $titEstado . ' )!!!';
                $datosEmail['link_ticket'] = 'https://192.168.1.210/Berhlan/public/panel/muestrascomerciales-modificar/' . $idMc;

                Mail::send('email.notificacion_muestra_comercial', $datosEmail, function ($message) use ($datosEmail) {
                    $admin = $datosEmail['email'];
                    $nombre = $datosEmail['nombre'];
                    $message->subject('Notificaciones Intranet');
                    $message->from('notificacionesberhlan@berhlan.com', $nombre);
                    $message->to($admin);
                });
                /* CORREO 4 */

                /* CORREO 5 */
                $datosEmail['nombre'] = 'SOLICITUDES MUESTRAS COMERCIALES';
                $datosEmail['email'] = $correoNotificacion5;
                $datosEmail['numsolicitud'] = 'MC-' . $MuestraComercial[0]->consecutivo;
                $datosEmail['titsolicitud'] = '';
                $datosEmail['fechacreacion'] = ' (Modificación) | ' . $fecha;
                $datosEmail['empleado'] =  $nombreEmpleado5;
                $datosEmail['marca'] = $marca;
                $datosEmail['mensajel1'] = 'SOLICITUD';
                $datosEmail['mensajel2'] = 'DE LA MARCA';
                $datosEmail['mensajel3'] = 'SE HA MODIFICAD CON UN CAMBIO DE ESTADO A ( ' . $titEstado . ' )!!!';
                $datosEmail['link_ticket'] = 'https://192.168.1.210/Berhlan/public/panel/muestrascomerciales-modificar/' . $idMc;

                Mail::send('email.notificacion_muestra_comercial', $datosEmail, function ($message) use ($datosEmail) {
                    $admin = $datosEmail['email'];
                    $nombre = $datosEmail['nombre'];
                    $message->subject('Notificaciones Intranet');
                    $message->from('notificacionesberhlan@berhlan.com', $nombre);
                    $message->to($admin);
                });
                /* CORREO 5 */

                /* CORREO 6 */
                $datosEmail['nombre'] = 'SOLICITUDES MUESTRAS COMERCIALES';
                $datosEmail['email'] = $correoNotificacion6;
                $datosEmail['numsolicitud'] = 'MC-' . $MuestraComercial[0]->consecutivo;
                $datosEmail['titsolicitud'] = '';
                $datosEmail['fechacreacion'] = ' (Modificación) | ' . $fecha;
                $datosEmail['empleado'] =  $nombreEmpleado6;
                $datosEmail['marca'] = $marca;
                $datosEmail['mensajel1'] = 'SOLICITUD';
                $datosEmail['mensajel2'] = 'DE LA MARCA';
                $datosEmail['mensajel3'] = 'SE HA MODIFICAD CON UN CAMBIO DE ESTADO A ( ' . $titEstado . ' )!!!';
                $datosEmail['link_ticket'] = 'https://192.168.1.210/Berhlan/public/panel/muestrascomerciales-modificar/' . $idMc;

                Mail::send('email.notificacion_muestra_comercial', $datosEmail, function ($message) use ($datosEmail) {
                    $admin = $datosEmail['email'];
                    $nombre = $datosEmail['nombre'];
                    $message->subject('Notificaciones Intranet');
                    $message->from('notificacionesberhlan@berhlan.com', $nombre);
                    $message->to($admin);
                });
                /* CORREO 6 */

                /* ENVIO NOTIFICACIÓN COMERCIAL */
                $datosEmail['nombre'] = 'SOLICITUDES MUESTRAS COMERCIALES';
                $datosEmail['email'] = $correoNotificacionCm;
                $datosEmail['numsolicitud'] = 'MC-' . $Consecutivo;
                $datosEmail['titsolicitud'] = '';
                $datosEmail['fechacreacion'] = $fecha;
                $datosEmail['empleado'] =  $nombreEmpleadoCm;
                $datosEmail['marca'] = $Marca;
                $datosEmail['mensajel1'] = 'SU SOLICITUD';
                $datosEmail['mensajel2'] = 'DE LA MARCA';
                $datosEmail['mensajel3'] = 'SE HA MODIFICAD CON UN CAMBIO DE ESTADO A ( ' . $titEstado . ' )!!!';
                $datosEmail['link_ticket'] = 'https://192.168.1.210/Berhlan/public/panel/muestrascomerciales-modificar/' . $idMc;

                Mail::send('email.notificacion_muestra_comercial', $datosEmail, function ($message) use ($datosEmail) {
                    $admin = $datosEmail['email'];
                    $nombre = $datosEmail['nombre'];
                    $message->subject('Notificaciones Intranet');
                    $message->from('notificacionesberhlan@berhlan.com', $nombre);
                    $message->to($admin);
                });
                /* ENVIO NOTIFICACIÓN POR COMERCIAL */

                if (isset($formData['items'])) {
                    if (in_array("0", $formData['items'])) {
                        /* CREACIÓN DE LOGS */
                        $items = $formData['itemslogs'];
                        $datosLogs['idmc'] = $idMc;
                        $datosLogs['iduser'] = $Empleado;
                        $datosLogs['movimiento'] = 'Aprobado Mercadeo y Envío de Notifiaciones';
                        $datosLogs['items'] = $items;
                        $datosLogs['fecha'] = NOW();
                        PanelMuestrasComerciales::insertLogsMuestraComercial($datosLogs);
                        /* CREACIÓN DE LOGS */
                    } else {
                        /* CREACIÓN DE LOGS */
                        $items = $formData['items'];
                        $itemsJson = json_encode($items);
                        $datosLogs['items'] = $itemsJson;
                        $items = $itemsJson;
                        $datosLogs['idmc'] = $idMc;
                        $datosLogs['iduser'] = $Empleado;
                        $datosLogs['movimiento'] = 'Ingreso de Nuevos Items, Aprobado Mercadeo y Envío de Notifiaciones';
                        $datosLogs['items'] = $items;
                        $datosLogs['fecha'] = NOW();
                        PanelMuestrasComerciales::insertLogsMuestraComercial($datosLogs);
                        /* CREACIÓN DE LOGS */
                    }
                } else {
                    /* CREACIÓN DE LOGS */
                    $items = $formData['itemslogs'];
                    $datosLogs['idmc'] = $idMc;
                    $datosLogs['iduser'] = $Empleado;
                    $datosLogs['movimiento'] = 'Aprobado Mercadeo y Envío de Notifiaciones';
                    $datosLogs['items'] = $items;
                    $datosLogs['fecha'] = NOW();
                    PanelMuestrasComerciales::insertLogsMuestraComercial($datosLogs);
                    /* CREACIÓN DE LOGS */
                }
            }
            /* ENVIO NOTIFICACIÓN POR APROBADO */

            $fileImg      =  $formData['subir'];
            if ($fileImg != '') {
                $ano = date('Y');
                $mes = date('m') * 1;
                $file     = Request::file('archivo');
                $filename = $file->getClientOriginalName();
                $filename = $this->eliminar_tildes($filename);

                $extension = explode(".", $filename);
                $f         = count($extension);
                $final     = strtolower($extension[$f - 1]);

                $destinationPath = substr(public_path(), 0, -14) . "public/archivos/muestrasComerciales/" . $ano . "/" . $mes . "/";
                $filename        = $ano . "/" . $mes . "/MC_" . $consecutivo . "_anexo_2." . $final;
                $uploadSuccess   = $file->move($destinationPath, $filename);

                $datos['archivo_calidad'] = $filename;
            } else {
                $filename = 'No Hay Archivo';
            }

            // Si Aprobó Calidad
            if ($formData['aprobado_calidad'] != 0 && ($formData['fecha_calidad_aprobado'] == '' || $formData['fecha_calidad_aprobado'] == NULL)) {
                $datos['fecha_calidad_aprobado'] = NOW();

                if (isset($formData['items'])) {
                    if (in_array("0", $formData['items'])) {
                        /* CREACIÓN DE LOGS */
                        $items = $formData['itemslogs'];
                        $datosLogs['idmc'] = $idMc;
                        $datosLogs['iduser'] = $Empleado;
                        $datosLogs['movimiento'] = 'Aprobado Calidad';
                        $datosLogs['items'] = $items;
                        $datosLogs['fecha'] = NOW();
                        PanelMuestrasComerciales::insertLogsMuestraComercial($datosLogs);
                        /* CREACIÓN DE LOGS */
                    } else {
                        /* CREACIÓN DE LOGS */
                        $items = $formData['items'];
                        $itemsJson = json_encode($items);
                        $datosLogs['items'] = $itemsJson;
                        $items = $itemsJson;
                        $datosLogs['idmc'] = $idMc;
                        $datosLogs['iduser'] = $Empleado;
                        $datosLogs['movimiento'] = 'Ingreso de Nuevos Items y Aprobado Calidad';
                        $datosLogs['items'] = $items;
                        $datosLogs['fecha'] = NOW();
                        PanelMuestrasComerciales::insertLogsMuestraComercial($datosLogs);
                        /* CREACIÓN DE LOGS */
                    }
                } else {
                    /* CREACIÓN DE LOGS */
                    $items = $formData['itemslogs'];
                    $datosLogs['idmc'] = $idMc;
                    $datosLogs['iduser'] = $Empleado;
                    $datosLogs['movimiento'] = 'Aprobado Calidad';
                    $datosLogs['items'] = $items;
                    $datosLogs['fecha'] = NOW();
                    PanelMuestrasComerciales::insertLogsMuestraComercial($datosLogs);
                    /* CREACIÓN DE LOGS */

                    /* ENVIO NOTIFICACIÓN COMERCIAL */
                    $datosEmail['nombre'] = 'SOLICITUDES MUESTRAS COMERCIALES';
                    $datosEmail['email'] = $correoNotificacionCm;
                    $datosEmail['numsolicitud'] = 'MC-' . $Consecutivo;
                    $datosEmail['titsolicitud'] = '';
                    $datosEmail['fechacreacion'] = $fecha;
                    $datosEmail['empleado'] =  $nombreEmpleadoCm;
                    $datosEmail['marca'] = $Marca;
                    $datosEmail['mensajel1'] = 'SU SOLICITUD';
                    $datosEmail['mensajel2'] = 'DE LA MARCA';
                    $datosEmail['mensajel3'] = 'SE HA APROBADO POR CALIDAD!!!';
                    $datosEmail['link_ticket'] = 'https://192.168.1.210/Berhlan/public/panel/muestrascomerciales-modificar/' . $idMc;

                    Mail::send('email.notificacion_muestra_comercial', $datosEmail, function ($message) use ($datosEmail) {
                        $admin = $datosEmail['email'];
                        $nombre = $datosEmail['nombre'];
                        $message->subject('Notificaciones Intranet');
                        $message->from('notificacionesberhlan@berhlan.com', $nombre);
                        $message->to($admin);
                    });
                    /* ENVIO NOTIFICACIÓN POR COMERCIAL */
                }
            }

            // Si Aprobó Mercadeo * fue notificado arriba
            if ($formData['aprobado_mercadeo'] != 0 && ($formData['fecha_mercadeo_aprobado'] == '' || $formData['fecha_mercadeo_aprobado'] == NULL)) {
                $datos['fecha_mercadeo_aprobado'] = NOW();
            }


            // Si hay Ingreso de Nuevos Items o Cambio General
            if (isset($formData['items'])) {

                if (in_array("0", $formData['items'])) {
                    /* CREACIÓN DE LOGS */
                    $items = $formData['itemslogs'];
                    $datosLogs['idmc'] = $idMc;
                    $datosLogs['iduser'] = $Empleado;
                    $datosLogs['movimiento'] = 'Cambio General';
                    $datosLogs['items'] = $items;
                    $datosLogs['fecha'] = NOW();
                    PanelMuestrasComerciales::insertLogsMuestraComercial($datosLogs);
                    /* CREACIÓN DE LOGS */
                } else {
                    /* CREACIÓN DE LOGS */
                    $items = $formData['items'];
                    $itemsJson = json_encode($items);
                    $datosLogs['items'] = $itemsJson;
                    $items = $itemsJson;
                    $datosLogs['idmc'] = $idMc;
                    $datosLogs['iduser'] = $Empleado;
                    $datosLogs['movimiento'] = 'Ingreso de Nuevos Items';
                    $datosLogs['items'] = $items;
                    $datosLogs['fecha'] = NOW();
                    PanelMuestrasComerciales::insertLogsMuestraComercial($datosLogs);
                    /* CREACIÓN DE LOGS */
                }

                $items =  $formData['items'];
                $TamItems = sizeof($items);
                $i = 0;
                while ($i < $TamItems) {
                    $item = explode(';', $formData['items'][$i]);
                    if ($item[0] != 0) {
                        $datosItems['id_muestra_comercial'] = $idMc;
                        $datosItems['id_item_siesa'] = $item[0];
                        $datosItems['marca'] = $item[2];
                        $maquila = $formData['maquila'][$i];


                        if ($maquila == 1) {
                            /* ENVIO NOTIFICACIÓN SI ES MAQUILA */
                            //$correoNotificacion = 'victor.castano@berhlan.com';
                            $correoNotificacion = 'julian.carmona@berhlan.com';
                            $nombreEmpleado = 'Victor Castaño';

                            $datosEmail['nombre'] = 'SOLICITUDES MUESTRAS COMERCIALES';
                            $datosEmail['email'] = $correoNotificacion;
                            $datosEmail['numsolicitud'] = 'MC-' . $MuestraComercial[0]->consecutivo;
                            $datosEmail['titsolicitud'] = '';
                            $datosEmail['fechacreacion'] = ' (Modificación) | ' . $fecha;
                            $datosEmail['empleado'] =  $nombreEmpleado;
                            $datosEmail['marca'] = $marca;
                            $datosEmail['mensajel1'] = 'SOLICITUD';
                            $datosEmail['mensajel2'] = 'DE LA MARCA';
                            $datosEmail['mensajel3'] = 'SE HA RECIBIDO CON ÉXITO!!!';
                            $datosEmail['link_ticket'] = 'https://192.168.1.210/Berhlan/public/panel/muestrascomerciales-modificar/' . $idMc;

                            Mail::send('email.notificacion_muestra_comercial', $datosEmail, function ($message) use ($datosEmail) {
                                $admin = $datosEmail['email'];
                                $nombre = $datosEmail['nombre'];
                                $message->subject('Notificaciones Intranet');
                                $message->from('notificacionesberhlan@berhlan.com', $nombre);
                                $message->to($admin);
                            });
                            /* ENVIO NOTIFICACIÓN SI ES MAQUILA */
                        }

                        $datosItems['descripcion_item'] = $item[1];
                        $datosItems['observaciones'] = $formData['observaciones'][$i];
                        $datosItems['cantidad'] = $formData['cantidad'][$i];
                        $datosItems['maquila'] = $formData['maquila'][$i];
                        PanelMuestrasComerciales::insertItemsMuestraComercial($datosItems);
                        $i++;
                    } else {
                        $i++;
                    }
                }
            }

            PanelMuestrasComerciales::updateMuestraComercial($idMc, $datos);

            $MuestrasComerciales =  PanelMuestrasComerciales::getMuestrasComerciales();

            return redirect('/panel/muestrascomerciales/lista')->with('DatosUsuario', $DatosUsuario)->with('MuestrasComerciales', $MuestrasComerciales);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function ItemsEliminar($id, $idmc)
    {
        if (Session::has('user')) {

            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);
            $Empleado = $DatosUsuario[0]->empleado;

            $DatosiTem = PanelMuestrasComerciales::getItemMuestraComercial($id);
            $ItemSiesa = $DatosiTem[0]->id_item_siesa;
            $logsItems = PanelMuestrasComerciales::getUltimoLogMuestraComercial($idmc);
            $Items = $logsItems[0]->items;
            $ItemEliminado = $DatosiTem[0]->id_item_siesa;

            if ($DatosiTem == true) {

                /* CREACIÓN DE LOGS */
                $datosLogs['idmc'] = $idmc;
                $datosLogs['iduser'] = $Empleado;
                $datosLogs['movimiento'] = 'Se Elimino el Ítem ' . $ItemEliminado;
                $items = $Items;
                $itemsJson = json_encode($items);
                $datosLogs['items'] = $itemsJson;
                $datosLogs['fecha'] = NOW();
                PanelMuestrasComerciales::insertLogsMuestraComercial($datosLogs);
                /* CREACIÓN DE LOGS */

                PanelMuestrasComerciales::deleteItemMuestraComercial($id);
            } else {
                Session::flash('message2', 'El Ítem no Existe en el Sistema!');
            }

            $MuestraComercial = PanelMuestrasComerciales::getMuestraComercial($idmc);
            $EmpleadoCm = $MuestraComercial[0]->id_empleado;
            $Marca = $MuestraComercial[0]->marca;
            $DataEmpleado = PanelEmpleados::getEmpleado($EmpleadoCm);
            $correoNotificacionCm = $DataEmpleado[0]->correo;
            $nombreEmpleadoCm = $DataEmpleado[0]->primer_nombre . ' ' . $DataEmpleado[0]->ot_nombre . ' ' . $DataEmpleado[0]->primer_apellido . ' ' . $DataEmpleado[0]->ot_apellido;
            $ItemsMuestraComercial = PanelMuestrasComerciales::getItemsMuestrasComerciales($idmc);

            date_default_timezone_set('America/Bogota');
            $fecha = date("Y-m-d");

            /* ENVIO NOTIFICACIÓN COMERCIAL */
            $datosEmail['nombre'] = 'SOLICITUDES MUESTRAS COMERCIALES';
            $datosEmail['email'] = $correoNotificacionCm;
            $datosEmail['numsolicitud'] = 'MC-' . $MuestraComercial[0]->consecutivo;
            $datosEmail['titsolicitud'] = '';
            $datosEmail['fechacreacion'] = $fecha;
            $datosEmail['empleado'] =  $nombreEmpleadoCm;
            $datosEmail['marca'] = $Marca;
            $datosEmail['mensajel1'] = 'SU SOLICITUD';
            $datosEmail['mensajel2'] = 'DE LA MARCA';
            $datosEmail['mensajel3'] = 'SE HA ELIMNADO UN ÍTEM DE TU SOLICITUD ( ' . $ItemSiesa . ' )!!!';
            $datosEmail['link_ticket'] = 'https://192.168.1.210/Berhlan/public/panel/muestrascomerciales-modificar/' . $idmc;

            Mail::send('email.notificacion_muestra_comercial', $datosEmail, function ($message) use ($datosEmail) {
                $admin = $datosEmail['email'];
                $nombre = $datosEmail['nombre'];
                $message->subject('Notificaciones Intranet');
                $message->from('notificacionesberhlan@berhlan.com', $nombre);
                $message->to($admin);
            });
            /* ENVIO NOTIFICACIÓN POR COMERCIAL */

            /* PRODUCTOS SIESA  */
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://192.168.1.206/WSUNOEE/WSUNOEE.asmx',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_HTTP_CONTENT_DECODING => true,
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '<soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
                   <soap12:Body>
                     <EjecutarConsultaXML xmlns="http://tempuri.org/">
                       <pvstrxmlParametros>
                         &lt;Consulta>
                             &lt;NombreConexion>UnoEE&lt;/NombreConexion>
                             &lt;IdCia>1&lt;/IdCia>
                             &lt;IdProveedor>ES&lt;/IdProveedor>
                             &lt;IdConsulta>CONSULTA_MCITEMS&lt;/IdConsulta>
                             &lt;Usuario>web.service&lt;/Usuario>
                             &lt;Clave>12345&lt;/Clave>
                         &lt;/Consulta>
                       </pvstrxmlParametros>
                     </EjecutarConsultaXML>
                   </soap12:Body>
                 </soap12:Envelope>',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: text/xml; charset=utf-8'
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $DataRTPItems = array();
            $newDataRTPItems = array();
            $soap_response = $response;
            $dom_result = new \DOMDocument;

            if (!$dom_result->loadXML($soap_response))
                throw new Exception(_('Error parsing response'), 11);

            $xpath = new \DOMXPath($dom_result);

            // Define an XPath query to select all rows within the list
            $query = "//NewDataSet/Resultado";

            // Use the query to fetch all rows
            $rows = $xpath->query($query);

            // Iterate through the rows and output their text content
            $numRows = 0;
            foreach ($rows as $row) {
                $DataRTPItems['item'] = $dom_result->getElementsByTagName('item')->item($numRows)->nodeValue;
                $DataRTPItems['descripcion'] = $dom_result->getElementsByTagName('descripcion')->item($numRows)->nodeValue;
                $DataRTPItems['maquila'] = $dom_result->getElementsByTagName('maquila')->item($numRows)->nodeValue;
                array_push($newDataRTPItems, $DataRTPItems);
                $numRows++;
            }
            /* PRODUCTOS SIESA  */

            return redirect('/panel/muestrascomerciales-modificar/' . $idmc)->with('DatosUsuario', $DatosUsuario)->with('MuestraComercial', $MuestraComercial)->with('ItemsMuestraComercial', $ItemsMuestraComercial)->with('newDataRTPItems', $newDataRTPItems);
        } else {
            return view('panel-loginfalse');
        }
    }

    // Editar Item
    public function showMuestasComercialesModificarItem($id, $idmc)
    {
        if (Session::has('user')) {
            $user         = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);
            $MuestraComercial = PanelMuestrasComerciales::getMuestraComercial($idmc);
            $ItemMuestraComercial = PanelMuestrasComerciales::getItemMuestraComercial($id);
            $marca = $ItemMuestraComercial[0]->marca;

            /* PRODUCTOS SIESA  */
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://192.168.1.206/WSUNOEE/WSUNOEE.asmx',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_HTTP_CONTENT_DECODING => true,
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '<soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
                <soap12:Body>
                  <EjecutarConsultaXML xmlns="http://tempuri.org/">
                    <pvstrxmlParametros>
                      &lt;Consulta>
                          &lt;NombreConexion>UnoEE&lt;/NombreConexion>
                          &lt;IdCia>1&lt;/IdCia>
                          &lt;IdProveedor>ES&lt;/IdProveedor>
                          &lt;IdConsulta>CONSULTA_MCMARCA&lt;/IdConsulta>
                          &lt;Usuario>web.service&lt;/Usuario>
                          &lt;Clave>12345&lt;/Clave>
                          &lt;Parametros>
                             &lt;marca>' . $marca . '&lt;/marca>
                         &lt;/Parametros>
                      &lt;/Consulta>
                    </pvstrxmlParametros>
                  </EjecutarConsultaXML>
                </soap12:Body>
              </soap12:Envelope>',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: text/xml; charset=utf-8'
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $DataRTPItems = array();
            $newDataRTPItems = array();
            $soap_response = $response;
            $dom_result = new \DOMDocument;

            if (!$dom_result->loadXML($soap_response))
                throw new Exception(_('Error parsing response'), 11);

            $xpath = new \DOMXPath($dom_result);

            // Define an XPath query to select all rows within the list
            $query = "//NewDataSet/Resultado";

            // Use the query to fetch all rows
            $rows = $xpath->query($query);

            // Iterate through the rows and output their text content
            $numRows = 0;
            foreach ($rows as $row) {
                $DataRTPItems['item'] = $dom_result->getElementsByTagName('item')->item($numRows)->nodeValue;
                $DataRTPItems['descripcion'] = $dom_result->getElementsByTagName('descripcion')->item($numRows)->nodeValue;
                $DataRTPItems['maquila'] = $dom_result->getElementsByTagName('maquila')->item($numRows)->nodeValue;
                array_push($newDataRTPItems, $DataRTPItems);
                $numRows++;
            }
            /* PRODUCTOS SIESA  */

            return view('muestras-comerciales.panel-muestrasComercialesEditarItem')->with('DatosUsuario', $DatosUsuario)->with('MuestraComercial', $MuestraComercial)->with('ItemMuestraComercial', $ItemMuestraComercial)->with('newDataRTPItems', $newDataRTPItems);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function MuestrasComercialesModificarItemDB()
    {
        if (Session::has('user')) {
            $user         = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);
            $formData     = Request::all();
            $datosItems = array();
            $id = $formData['id'];
            $item = explode(';', $formData['item']);
            $datosItems['id_item_siesa'] = $item[0];
            $datosItems['marca'] = $item[2];
            $datosItems['maquila'] = $item[2];
            $datosItems['descripcion_item'] = $item[1];
            $datosItems['observaciones'] = $formData['observaciones'];
            $datosItems['cantidad'] = $formData['cantidad'];
            $datosItems['maquila'] = $formData['maquila'];

            PanelMuestrasComerciales::updateItemMuestraComercial($id, $datosItems);

            $MuestrasComerciales =  PanelMuestrasComerciales::getMuestrasComerciales();

            return redirect('/panel/muestrascomerciales/lista')->with('DatosUsuario', $DatosUsuario)->with('MuestrasComerciales', $MuestrasComerciales);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }
}
