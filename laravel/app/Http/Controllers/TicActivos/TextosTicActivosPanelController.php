<?php
/*
Controlador de la tabla acti_textos
Usa SQl Eloquent del archivo app\Models\Bpack\PanelTextos.php
*/

namespace App\Http\Controllers\TicActivos;
use App\Http\Controllers\Controller;
use App\Models\TicActivos\PanelTextos;
use App\Models\PanelLogin;
use Illuminate\Support\Facades\Session;
use Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class TextosTicActivosPanelController extends Controller
 {
  public function Textos()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "ticactivos/textos";
        $DatosMenu = PanelLogin::getMenuRuta($ruta);
        if($DatosMenu[0]->libre_acceso == 0)  // Si el modulo no es de libre acceso
         {
          $idmenu    = $DatosMenu[0]->id_menu;

          $ModUser    = explode(',',$DatosUsuario[0]->modulos);
          $NumModUser = count($ModUser);
          $acceso     = 0;
          for($i=0; $i<$NumModUser; $i++)
           {
            if($idmenu == $ModUser[$i])
             {
              $acceso = 1;
              break;
             }
           }

          if($acceso == 0) //El usuario no tiene acceso al modulo
           {
            $ErrorValidacion = "Usted no esta tiene acceso al módulo.";
            return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
           }
         }
       }
      //Termina validación

      $DatosTextos = PanelTextos::getTextos();
      return view('ticactivos.panel-textos')->with('DatosUsuario',$DatosUsuario)->with('DatosTextos',$DatosTextos);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function TextosModificarDB()
   {
    if(Session::has('user'))
     {
      $formData = Request::all();
      $texto1   = trim($formData['texto1']);
      $texto2   = trim($formData['texto2']);

      $datos = array();

      $Mensaje = "Textos modificados";

      $datos['texto1'] = $texto1;
      $datos['texto2'] = $texto2;

      PanelTextos::editarTextos($datos);

      //Agrego el guardado al log
      $user               = Session::get('user');
      $DatosUsuario       = PanelLogin::getUsuario($user);
      $datos1             = array();
      $datos1['modulo']   = 71;    //Textos para actas
      $datos1['tipo']     = "UPD"; //Actualiza
      $datos1['registro'] = "Actualiza textos";
      $datos1['usuario']  = $DatosUsuario[0]->empleado;
      $datos1['fecha']    = NOW();
      PanelLogin::insertarLog($datos1);
      ////////////////////////////////

      $Redireccion = "/panel/ticactivos/textos";

      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }
 }