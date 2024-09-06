<?php

namespace App\Http\Controllers\ArchivoDigital;

use App\Http\Controllers\Controller;
use App\Models\ArchivoDigital\PanelHistorias;
use App\Models\ArchivoDigital\PanelRegistros;
use App\Models\PanelLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use ZipArchive;

class ArchivoCentralController extends Controller
{
    public function showArchivoCentral()
    {
        if (Session::has('user')) {
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "archivo/consultas";
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

            $DatosDependencias = PanelRegistros::getDepedenciasInfo();
            $DatosRegistros = PanelRegistros::getRegistrosInfo();
            $DatosRegistrosAsunto = PanelRegistros::getRegistrosAsuntoInfo();
            //dd($DatosRegistros);
            return view('archivo-digital.panel-archivoCentral')->with('DatosUsuario', $DatosUsuario)->with('DatosRegistros', $DatosRegistros)->with('DatosDependencias', $DatosDependencias)
                ->with('DatosRegistrosAsunto', $DatosRegistrosAsunto);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function ConsultasArchivoCentral(Request $request)
    {
        $user = Session::get('user');
        $DatosUsuario = PanelLogin::getUsuario($user);
        // dd($request->all());
        $dependencia = $request->input('dependencia');
        $empleado = $request->input('empleado');
        $asunto = $request->input('asunto');
        $codigo_caja = $request->input('codigo_caja');

        if($empleado == '' && $asunto == '' && $codigo_caja == '' && $dependencia == ''){
            $Mensaje = "Debe selecionar al menos un campo para la busqueda.";

                $Redireccion = "/panel/archivo/consultas";
                return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
        }

        if ($empleado != '') {

            $historias = PanelHistorias::getHistoriasEmpleado($empleado);

            if ($historias->isEmpty()) {
                $Mensaje = "No hay informacion para mostrar.";

                $Redireccion = "/panel/archivo/consultas";
                return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
            } else {

                return view('archivo-digital.panel-archivoHistoriasConsultaParam')->with('DatosUsuario', $DatosUsuario)->with('historias', $historias);
            }
        }

        if ($asunto != '' || $codigo_caja != '' || $dependencia != '') {
            $sql = \DB::table('arch_registros')
                ->where(function ($query) use ($dependencia, $asunto, $codigo_caja, ) {
                    if (!is_null($dependencia)) {
                        $query->where('dependencia', $dependencia);
                    }
                    if (!is_null($asunto)) {
                        $query->where('titulo_unidad_documental', $asunto);
                    }
                    if (!is_null($codigo_caja)) {
                        $query->where('codigo_caja', $codigo_caja);
                    }
                })
                ->get();
            //dd($sql);
            if ($sql->isEmpty() || $sql[0]->dependencia == '') {
                $Mensaje = "No hay informacion para mostrar o esta la informacion incompleta";

                $Redireccion = "/panel/archivo/consultas";
                return view('panel-mensaje')->with('Mensaje', $Mensaje)->with('Redireccion', $Redireccion);
            } else {

                return view('archivo-digital.panel-archivoCentralParamDocD')->with('DatosUsuario', $DatosUsuario)->with('sql', $sql);
            }

        }

    }

    public function descargarDependencia($dependencia)
    {

        // Ruta de la carpeta que deseas comprimir
        $rutaCarpeta = substr(public_path(), 0, -14) . 'public/archivos/ArchivoDigital/ArchivoCentral/' . $dependencia;

        // Nombre del archivo ZIP resultante
        $nombreZip = $dependencia . '.zip';
        // Ruta completa del archivo ZIP
        $rutaZip = public_path() . '/' . $dependencia . '.zip';
        //dd($rutaZip);

        // Crear una nueva instancia de ZipArchive
        $zip = new ZipArchive;

        // Crear el archivo ZIP
        if ($zip->open($rutaZip, ZipArchive::CREATE) === true) {
            // Agregar archivos y subdirectorios al ZIP

            $this->agregarDirectorioAlZip($rutaCarpeta, $zip);

            // Cerrar el archivo ZIP
            $zip->close();
        }

        // Retornar el archivo ZIP como respuesta
        return response()->download($rutaZip, $nombreZip)->deleteFileAfterSend(true);
    }

    private function agregarDirectorioAlZip($rutaDirectorio, &$zip, $rutaBase = null)
{
    if ($rutaBase === null) {
        $rutaBase = $rutaDirectorio;
    }

    $archivos = scandir($rutaDirectorio);
    $archivos = array_diff($archivos, array('.', '..'));

    foreach ($archivos as $archivo) {
        $rutaCompleta = $rutaDirectorio . '/' . $archivo;
        //dd($rutaCompleta);

        if (is_dir($rutaCompleta)) {
            // Si es un directorio, llamar recursivamente a esta función
            $this->agregarDirectorioAlZip($rutaCompleta, $zip, $rutaBase);
        } else {
            // Si es un archivo, agregarlo al ZIP
            $nombreArchivo = str_replace($rutaBase, '', $rutaCompleta); // Obtener la ruta relativa del archivo
            $zip->addFile($rutaCompleta, $nombreArchivo);

        }
    }
}

    public function descargarRegistros($registro)
    {
        $registroI = PanelRegistros::getRegistro($registro);

        // Ruta de la carpeta que deseas comprimir
        $rutaCarpeta = substr(public_path(), 0, -14) . 'public/archivos/ArchivoDigital/ArchivoCentral/' . $registroI[0]->dependencia . '/' . $registroI[0]->codigo_caja
        . '/' . $registroI[0]->titulo_unidad_documental;
        //dd($rutaCarpeta);
        // Nombre del archivo ZIP resultante
        $nombreZip = $registroI[0]->titulo_unidad_documental . '.zip';
        // Ruta completa del archivo ZIP
        $rutaZip = public_path() . '/' . $registroI[0]->titulo_unidad_documental . '.zip';

        // Crear una nueva instancia de ZipArchive
        $zip = new ZipArchive;

        // Crear el archivo ZIP
        if ($zip->open($rutaZip, ZipArchive::CREATE) === true) {
            // Agregar archivos y subdirectorios al ZIP

            $archivos = scandir($rutaCarpeta);
            $archivos = array_diff($archivos, array('.', '..'));
            foreach ($archivos as $archivo) {
                // Obtener el nombre relativo del archivo
                $nombreArchivo = basename($archivo);
                $archivo = $rutaCarpeta . '/' . $archivo;
                // Agregar el archivo al ZIP
                $zip->addFile($archivo, $nombreArchivo);
            }

            // Cerrar el archivo ZIP
            $zip->close();
        }

        // Retornar el archivo ZIP como respuesta
        return response()->download($rutaZip, $nombreZip)->deleteFileAfterSend(true);
    }

}
