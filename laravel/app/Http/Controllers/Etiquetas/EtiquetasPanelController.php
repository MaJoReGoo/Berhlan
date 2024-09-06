<?php
/*
Controlador de la tabla bpac_solicitudan
Usa SQl Eloquent de los archivos
app\Models\Bpack\PanelSolicitudesAN.php
*/

namespace App\Http\Controllers\Etiquetas;
use App\Http\Controllers\Controller;
use App\Models\Etiquetas\PanelItemEtiquetasBarras;
use App\Models\PanelLogin;
use Illuminate\Support\Facades\Session;
use Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class EtiquetasPanelController extends Controller
 {
  public function GenerarEtiqueta()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "etiquetas/generar";
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

      $DatosItem = PanelItemEtiquetasBarras::Items();

      return view('etiquetas.panel-generar')->with('DatosUsuario',$DatosUsuario)->with('DatosItem',$DatosItem);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function ListarEtiqueta()
   {
    if(Session::has('user'))
     {
      $formData      = Request::all();
      $item          = $formData['item'];
      $user          = Session::get('user');
      $DatosUsuario  = PanelLogin::getUsuario($user);
      $DatosItem     = PanelItemEtiquetasBarras::InfoItem($item);

      return view('etiquetas.panel-generarListar')->with('DatosUsuario',$DatosUsuario)->with('DatosItem',$DatosItem);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function Maquilas()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "etiquetas/maquilas";
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

      $DatosMaquilas = PanelItemEtiquetasBarras::InfoMaquilas();
      return view('etiquetas.panel-maquilas')->with('DatosUsuario',$DatosUsuario)->with('DatosMaquilas',$DatosMaquilas);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function MaquilasModificar($id)
   {
    if(Session::has('user'))
     {
      $maquila      = $id;
      $DatosMaquila = PanelItemEtiquetasBarras::DetMaquila($maquila);
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "etiquetas/maquilas";
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

      if($DatosMaquila == true)
       {
        return view('etiquetas.panel-maquilasModificar')->with('DatosUsuario',$DatosUsuario)->with('DatosMaquila',$DatosMaquila);
       }
      else
       {
        $Mensaje     = "";
        $Redireccion = "/panel/etiquetas/maquilas";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function MaquilasModificarDB()
   {
    if(Session::has('user'))
     {
      $formData  = Request::all();
      $fileImg   = $formData['uploader1'];
      $idmaquila = $formData['idmaquila'];

      if($fileImg!='')
       {
        $file            = Request::file('file1');
        $destinationPath = substr(public_path(), 0, -14)."public/archivos/Maquilas/";
        $filename        = $idmaquila.".png";
        $uploadSuccess   = $file->move($destinationPath, $filename);
       }
      else
       {
        $filename = 'Imagen no encontrada';
       }

      $Mensaje = "";

      $Redireccion = "/panel/etiquetas/maquilas/modificar/".$idmaquila;
      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }
 }