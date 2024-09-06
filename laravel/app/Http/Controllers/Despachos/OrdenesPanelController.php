<?php
/*
Controlador de la tabla noticias
Usa SQl Eloquent del archivo app\Models\Noticias\PanelNoticias.php
*/

namespace App\Http\Controllers\Despachos;
use App\Http\Controllers\Controller;
use App\Models\PanelLogin;
use App\Models\Despachos\PanelDocumentos;
use Illuminate\Support\Facades\Session;
use Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Carbon\Carbon;


class OrdenesPanelController extends Controller
 {
  public function showListarOrdenes()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);
      $DatosDocumentos = PanelDocumentos::getDocumentos();
      $DocumentosSinEnviar = PanelDocumentos::getDOrdenesSinEnviarCant();


      return view('despachos.panel-listarDocumentos')->with('DatosUsuario',$DatosUsuario)->with('DatosDocumentos',$DatosDocumentos)->with('DocumentosSinEnviar',$DocumentosSinEnviar);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }

   public function insertDocumentoOrden($ean,$documento,$orden,$fecha_created,$tipo)
   {

    if(Session::has('user'))
     {


      $user  = Session::get('user');

      $datos = array();

      //Realizo las validaciones

        $DatosUsuario  = PanelLogin::getUsuario($user);

        $datos['tercero']     = $ean;
        $datos['document_id']     = $documento;
        $datos['orden_compra']      = $orden;
        $datos['estado']      = 0;
        $datos['fecha_creacion']      = $fecha_created;

        $existe = $this->ordenRegistrada($orden);

if($tipo==1 && $existe == 0){

    PanelDocumentos::insertarDocumentos($datos);


}else{
    return "existen";
}

       }


      return "AQUI";
    }

    private function ordenRegistrada($orden)
    {
    // Consultar la base de datos para verificar si la orden ya está registrada
    $registroExistente = PanelDocumentos::buscarPorOrden($orden);
    // Devolver true si ya existe, false si no existe
    return $registroExistente;
    }

    public function showEmpleados()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso

      //Termina validación

      $DatosDespachos = PanelDespachos::getDespachos();

      return view('despachos.panel-cargarDocumentos')->with('DatosDespachos',$DatosDespachos)->with('DatosUsuario',$DatosUsuario);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }
   public function modificarDocumentoListado($id)
   {
    if(Session::has('user'))
     {

      $user  = Session::get('user');

      $datos = array();

      //Realizo las validaciones

        $DatosUsuario  = PanelLogin::getUsuario($user);


        $datos['estado']     = 1;
        $datos['fecha_descargue']  = NOW();


        PanelDocumentos::actualizarDocumentos($id,$datos);

       }

      return "2A";
    }

    public function descargarTodasOrdenes()
   {
    if(Session::has('user'))
     {

      $user  = Session::get('user');

      $datos = array();

      //Realizo las validaciones

        $DatosUsuario  = PanelLogin::getUsuario($user);
        $OrdenesSinEnviar = PanelDocumentos::getDOrdenesSinEnviar();

        foreach($OrdenesSinEnviar as $ordeSin){


        $id=$ordeSin->id;
        $datos['estado']     = 1;
        $datos['fecha_descargue']      = NOW();

        PanelDocumentos::actualizarDocumentos($id,$datos);
        }
       }
       return redirect('/panel/despachos/listarorden')->with('DatosUsuario', $DatosUsuario);
      //return redirect('despachos.panel-cargarDocumentos')->with('DatosUsuario',$DatosUsuario)->with('DatosDespachos',$DatosDespachos)->with('DespachosSinEnviar',$DespachosSinEnviar);

    }

}
