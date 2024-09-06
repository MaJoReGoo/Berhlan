<?php

namespace App\Http\Controllers\ArchivoDigital;

use App\Http\Controllers\Controller;
use App\Models\ArchivoDigital\PanelInformesArchivo;
use App\Models\PanelLogin;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\IOFactory;

class InformesArchivoDigitalController extends Controller
{
    public function ShowInformes()
    {
        if (Session::has('user')) {
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "archivo/informes";
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
            $DatosDepedencia = PanelInformesArchivo::getDependencias();

            return view('archivo-digital.panel-archivoInformes')->with('DatosUsuario', $DatosUsuario)->with('DatosDepedencia', $DatosDepedencia);

        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }

    }

    public function exportInventario(Request $request)
    {

        $dependencia = $request->input('dependencia');

        $datosConsulta = PanelInformesArchivo::getInventario($dependencia);

        $archivo = substr(public_path(), 0, -14) . 'public/archivos/ArchivoDigital/Formatos/FUID.xlsx';
        // Cargar el archivo Excel existente
        $spreadsheet = IOFactory::load($archivo);

        // Obtener la hoja en la que deseas agregar los datos
        $hoja = $spreadsheet->getActiveSheet();

        // Filas en las que deseas comenzar a agregar los datos
        $filaInicio = 16;

        $hoja->setCellValue('E9',$dependencia);

        // Agregar los datos a la hoja
        foreach ($datosConsulta as $filaDatos) {
            //dd($filaDatos);

            $fechaInicialParts = explode('-', $filaDatos->fecha_inicial);
            $fechaInicialPartss = explode(' ', $fechaInicialParts[2]);
            $fechaFinalParts = explode('-', $filaDatos->fecha_final);
            $fechaFinalPartss = explode(' ', $fechaFinalParts[2]);


            $datosFila = [$filaDatos->codigo_caja,
                $filaDatos->codigo_und_documental,
                $filaDatos->codigo_serie,
                $filaDatos->codigo_subserie,
                $filaDatos->titulo_unidad_documental,
                $fechaInicialParts[0], // Año
                $fechaInicialParts[1], // Mes
                $fechaInicialPartss[0], // Día
                $fechaFinalParts[0], // Año
                $fechaFinalParts[1], // Mes
                $fechaFinalPartss[0], // Día
                $filaDatos->soporte,
                $filaDatos->frecuencia_consulta,
                null,
                $filaDatos->modulo,
                $filaDatos->entrepano,
                $filaDatos->dependencia,
                $filaDatos->observaciones_ind];
            $hoja->mergeCells('T'.$filaInicio.':'.'V'.$filaInicio);
            $hoja->fromArray([$datosFila], null, 'C' . $filaInicio);
            $filaInicio++;
        }

        // Guardar el archivo Excel temporalmente
        $tempFile = tempnam(sys_get_temp_dir(), 'excel');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($tempFile);

        // Devolver el archivo Excel como una respuesta de descarga

        return response()->download($tempFile, $dependencia . '.xlsx')->deleteFileAfterSend(true);
    }

}
