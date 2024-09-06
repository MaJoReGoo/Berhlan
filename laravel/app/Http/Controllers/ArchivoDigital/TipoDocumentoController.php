<?php

namespace App\Http\Controllers\ArchivoDigital;

use App\Http\Controllers\Controller;
use App\Models\ArchivoDigital\PanelTipoDocumento;
use Illuminate\Http\Request;

class TipoDocumentoController extends Controller
{
    public function InsertarTipoDoc(Request $request)
    {
        $descripcion = $request->input('descripcion_td');
        $datos = ['descripcion' => $descripcion,
            'estado' => 1];
        PanelTipoDocumento::InsertTipoDocumento($datos);
    }

    public function actualizarTablaTipoDocumentos()
    {
        // Obtener los datos actualizados de la tabla TipoDocumentos
        $datosTipoDoc = PanelTipoDocumento::getTipoDocumentos();
        // Devolver los datos formateados en formato JSON
        return response()->json($datosTipoDoc);
    }
    public function actualizarEstadoTipoDocumentos(Request $request)
    {
        $id = $request->input('id');
        $estado = $request->input('estado');

        // Actualizar el estado del artículo en la base de datos
        $idtipoDoc = PanelTipoDocumento::getTipoDocumento($id);
        //dd($idtipoDoc);
        $datos = ['estado' => $estado];
        PanelTipoDocumento::UpdateTipoDocumento($idtipoDoc[0]->id_tipodocumento,$datos);

        return response()->json(['success' => true]);
    }
}
