<?php
/*
Controlador de la tabla noticias
Usa SQl Eloquent del archivo app\Models\Noticias\PanelNoticias.php
*/

namespace App\Http\Controllers\Despachos;
use App\Http\Controllers\Controller;
use App\Models\PanelLogin;
use App\Models\Despachos\PanelDespachos;
use Illuminate\Support\Facades\Session;
use Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class DespachosPanelController extends Controller
 {
    var $server = '/Berhlan/public';

  public function showDespachosCargarDocumento()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);
      $DatosDespachos = PanelDespachos::getDespachos();
      $DespachosSinEnviar = PanelDespachos::getDespachosSinEnviar();

      return view('despachos.panel-cargarDocumentos')->with('DatosUsuario',$DatosUsuario)->with('DatosDespachos',$DatosDespachos)->with('DespachosSinEnviar',$DespachosSinEnviar);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }

   public function insertDespachosCargarDocumento($titulo)
   {
    if(Session::has('user'))
     {

      $user  = Session::get('user');

      $datos = array();

      //Realizo las validaciones

        $DatosUsuario  = PanelLogin::getUsuario($user);

        $datos['nombre']     = $titulo;
        $datos['estado']     = 0;
        $datos['fecha']      = NOW();


        PanelDespachos::insertarDespachos($datos);

       }


      return "ok";
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
   public function modificarDespachosCargarDocumento($id)
   {
    if(Session::has('user'))
     {

      $user  = Session::get('user');

      $datos = array();

      //Realizo las validaciones

        $DatosUsuario  = PanelLogin::getUsuario($user);


        $datos['estado']     = 1;
        $datos['fecha_dispatch']      = NOW();


        PanelDespachos::actualizarDespachos($id,$datos);

       }

      return "ok";
    }
    public function modificarTodosDespachos()
   {

    if(Session::has('user'))
     {

      $user  = Session::get('user');

      $datos = array();

      //Realizo las validaciones

        $DatosUsuario  = PanelLogin::getUsuario($user);
        $DatosDespachos = PanelDespachos::getDespachos();
        $DespachosSinEnviar = PanelDespachos::getDespachosSinEnviar();

        foreach($DespachosSinEnviar as $despaSin){


        $id=$despaSin->id;
        $datos['estado']     = 1;
        $datos['fecha_dispatch']      = NOW();


        PanelDespachos::actualizarDespachos($id,$datos);
        }
       }
       return redirect('/panel/despachos/cargar')->with('DatosUsuario', $DatosUsuario);
      //return redirect('despachos.panel-cargarDocumentos')->with('DatosUsuario',$DatosUsuario)->with('DatosDespachos',$DatosDespachos)->with('DespachosSinEnviar',$DespachosSinEnviar);

    }

}
