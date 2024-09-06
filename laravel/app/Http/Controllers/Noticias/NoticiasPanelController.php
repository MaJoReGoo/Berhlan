<?php
/*
Controlador de la tabla noticias
Usa SQl Eloquent del archivo app\Models\Noticias\PanelNoticias.php
*/

namespace App\Http\Controllers\Noticias;
use App\Http\Controllers\Controller;
use App\Models\PanelLogin;
use Illuminate\Support\Facades\Session;
use Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class NoticiasPanelController extends Controller
 {
  public function showNoticias()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);
      return view('noticias.panel-noticias')->with('DatosUsuario',$DatosUsuario);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }
 }