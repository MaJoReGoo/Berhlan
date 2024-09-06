<?php

namespace App\Http\Controllers\ArchivoDigital;

use App\Http\Controllers\Controller;
use App\Models\ArchivoDigital\PanelHistorias;
use App\Models\ArchivoDigital\PanelTipoDocumento;
use App\Models\PanelLogin;
use App\Models\Parametrizacion\PanelEmpleados;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use ZipArchive;

class HistoriasPanelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showHistoriasLaborales()
    {
        if (Session::has('user')) {
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "archivo/historias";
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
            //Termina validación
            $DatosEmpleados = PanelEmpleados::EmpleadosT();
            $DatosTipoDoc = PanelTipoDocumento::getTipoDocumentos();

            return view('archivo-digital.panel-archivoHistoriasConsulta')->with('DatosUsuario', $DatosUsuario)->with('DatosEmpleados', $DatosEmpleados)
            ->with('DatosTipoDoc', $DatosTipoDoc);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PanelHistorias  $panelHistorias
     * @return \Illuminate\Http\Response
     */
    public function show(PanelHistorias $panelHistorias)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PanelHistorias  $panelHistorias
     * @return \Illuminate\Http\Response
     */
    public function edit(PanelHistorias $panelHistorias)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PanelHistorias  $panelHistorias
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PanelHistorias $panelHistorias)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PanelHistorias  $panelHistorias
     * @return \Illuminate\Http\Response
     */
    public function destroy(PanelHistorias $panelHistorias)
    {
        //
    }

    public function obtenerDatosEmpleado($id)
    {
        $empleado = PanelEmpleados::getEmpleadoInfo($id);
        $countDoc = PanelHistorias::getCountHistoriasEmpleado($id);
        $DatosCountTipoDoc = PanelTipoDocumento::getCountTipoDocumentos();
        $DatosTipoDoc = PanelTipoDocumento::getTipoDocumentos();
        $tipoDoc = PanelHistorias::getTipoDocumentoshistoriaPendiente($id);
        // Procesar los datos del empleado según tus necesidades
        return response()->json([
            'empleado' => $empleado,
            'countDoc' => $countDoc,
            'tipoDoc' => $tipoDoc,
            'DatosCountTipoDoc' => $DatosCountTipoDoc,
            'DatosTipoDoc' => $DatosTipoDoc
        ]);
    }

    public function obtenerDocEmpleado($id)
    {
        $docEmpleado = PanelHistorias::getHistoriasDocEmpleado($id);
        // Procesar los datos del empleado según tus necesidades
        return response()->json($docEmpleado);
    }

    public function insertarHistoriasLaborales(Request $request)
    {
        //dd($request->all());
        // Obtener los documentos y las categorías enviados
        $user = Session::get('user');
        $DatosUsuario = PanelLogin::getUsuario($user);
        $archivos = $request->file('file');
        $categorias = $request->input('categorias');
        $modulo = $request->input('modulo');
        $estrepano = $request->input('estrepano');
        $ncaja = $request->input('ncaja');
        $nombreCate =
        $empleado = $request->input('empleado_hidden'); // Aquí debes obtener el ID del empleado de alguna manera
        $cedula = PanelEmpleados::getEmpleado($empleado);
        $fecha_creacion = now();
        $ruta = substr(public_path(), 0, -14) . 'public/archivos/ArchivoDigital/Historias/' . $cedula[0]->identificacion;
        // Iterar sobre los documentos y categorías para insertarlos en la base de datos
        foreach ($archivos as $key => $archivo) {
            $extension = $archivo->getClientOriginalExtension();
            $tipodesc = PanelTipoDocumento::getTipoDocumento($categorias[$key]);
            $nombreArchivo = $cedula[0]->identificacion . '-' . $tipodesc[0]->descripcion . '.' . $extension;
            $archivo->move($ruta, $nombreArchivo);
            DB::table('arch_historiaslabor')->insert([
                'empleado' => $empleado,
                'tipo_documento' => $categorias[$key],
                'modulo' => $modulo,
                'estrepano' => $estrepano,
                'ncaja' => $ncaja,
                'archivo' => $nombreArchivo,
                'fecha_creacion' => $fecha_creacion,
                'usuario_crear' => $DatosUsuario[0]->id_usuario,
            ]);
        }
    }

    public function descargarDocumentos($empleadoId)
    {
        $cedula = PanelEmpleados::getEmpleado($empleadoId);
        // Obtener la ruta de la carpeta del empleado
        $ruta = substr(public_path(), 0, -14) . 'public/archivos/ArchivoDigital/Historias/' . $cedula[0]->identificacion;

        // Obtener todos los documentos del empleado
        $documentos = PanelHistorias::getDocumentosEmpleado($empleadoId);

        // Comprimir los documentos en un archivo ZIP
        $zipFile = public_path() . '/' . $cedula[0]->identificacion . '.zip';
        //dd($zipFile);
        $zip = new ZipArchive;
        if ($zip->open($zipFile, ZipArchive::CREATE) === true) {
            foreach ($documentos as $documento) {
                $archivo = $ruta . '/' . $documento->archivo;
                if (file_exists($archivo)) {
                    $zip->addFile($archivo, $documento->archivo);

                } else {
                    // Manejar el caso en que el archivo no existe
                    // Por ejemplo, podrías imprimir un mensaje de advertencia
                    // o registrar el error en algún lugar.
                    echo "El archivo $archivo no existe.";
                }
            }
            $zip->close();
            //dd($zip);
        }
        return response()->download($zipFile)->deleteFileAfterSend(true);
    }

    public function UpdateHistoriasLaborales(Request $request)
    {
        // Obtener los documentos y las categorías enviados
        $user = Session::get('user');
        $DatosUsuario = PanelLogin::getUsuario($user);
        $fecha_actualizacion = now();
        $documentoId = $request->input('documento_id');
        $doctipo = PanelHistorias::getDocumentoshistoria($documentoId);
        //dd($doctipo);
        $tipodesc = PanelTipoDocumento::getTipoDocumento($doctipo[0]->tipo_documento);

        //dd($archivos);
        $empleado = $request->input('empleado_hidden2'); // Aquí debes obtener el ID del empleado de alguna manera
        $cedula = PanelEmpleados::getEmpleado($empleado);

        // Verificar si se cargó un archivo
        if ($request->hasFile('file2')) {
            // Obtener el nombre del archivo anterior
            $nombreArchivoAnterior = PanelHistorias::getDocumentoshistoria($documentoId);
            // Eliminar el archivo anterior si existe
            if ($nombreArchivoAnterior) {
                $nombreArchivo = pathinfo($nombreArchivoAnterior[0]->archivo, PATHINFO_FILENAME);
                $rutaDirectorio = substr(public_path(), 0, -14) . 'public/archivos/ArchivoDigital/Historias/' . $cedula[0]->identificacion . '/';
                $archivosDirectorio = scandir($rutaDirectorio);
                foreach ($archivosDirectorio as $archivo) {
                    $nombre = pathinfo($archivo, PATHINFO_FILENAME);
                    if ($nombre == $nombreArchivo) {
                        $rutaArchivoAnterior = $rutaDirectorio . $archivo;
                        if (file_exists($rutaArchivoAnterior)) {
                            unlink($rutaArchivoAnterior);
                        }
                    }
                }
            }

            // Subir el nuevo archivo
            $archivo = $request->file('file2');
            $extension = $archivo->getClientOriginalExtension();
            $nombreArchivo = $cedula[0]->identificacion . '-' . $tipodesc[0]->descripcion . '.' . $extension;

            // Mover el archivo a la ubicación deseada
            $rutaArchivo = substr(public_path(), 0, -14) . 'public/archivos/ArchivoDigital/Historias/' . $cedula[0]->identificacion;

            $datos = ['archivo' => $nombreArchivo,
                'fecha_actualizacion' => $fecha_actualizacion,
                'usuario_update' => $DatosUsuario[0]->id_usuario];
            // Actualizar la información del documento en la base de datos
            PanelHistorias::actualizarDocumentoHistoria($documentoId, $datos);

            // Mover el archivo al directorio deseado
            $archivo->move($rutaArchivo, $nombreArchivo);

        }

    }

    public function obtenerTipoDoc($id)
    {

        $countDoc = PanelHistorias::getTipoDocumentoshistoriaPendiente($id);
        // Procesar los datos del empleado según tus necesidades
        return response()->json($countDoc);
    }


}
