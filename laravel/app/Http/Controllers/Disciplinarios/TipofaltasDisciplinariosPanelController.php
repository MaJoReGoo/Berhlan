<?php
/*
Controlador de la tabla disc_tipofaltas
Usa SQl Eloquent del archivo app\Models\Disciplinarios\PanelTipofaltas.php
*/

namespace App\Http\Controllers\Disciplinarios;
use App\Http\Controllers\Controller;
use App\Models\Disciplinarios\PanelTipofaltas;
use App\Models\PanelLogin;
use Illuminate\Support\Facades\Session;
use Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class TipofaltasDisciplinariosPanelController extends Controller
 {
  public function Tipofaltas()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "disciplinarios/tipofaltas";
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

      $DatosTipofaltas     = PanelTipofaltas::Tipofaltas();
      $TipofaltasActivas   = PanelTipofaltas::CantidadTipofaltasActivas();
      $TipofaltasInactivas = PanelTipofaltas::CantidadTipofaltasInactivas();
      return view('disciplinarios.panel-tipofaltas')->with('DatosUsuario',$DatosUsuario)->with('DatosTipofaltas',$DatosTipofaltas)->with('TipofaltasActivas',$TipofaltasActivas)->with('TipofaltasInactivas',$TipofaltasInactivas);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function TipofaltasAgregar()
   {
    if(Session::has('user'))
     {
      $ErrorValidacion = "";  //Variable que retorna el error en caso de que no pase la validación
      $user            = Session::get('user');
      $DatosUsuario    = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "disciplinarios/tipofaltas";
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

      return view('disciplinarios.panel-tipofaltasAgregar')->with('DatosUsuario',$DatosUsuario);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function TipofaltasAgregarDB()
   {
    if(Session::has('user'))
     {
      $formData    = Request::all();
      $descripcion = trim($formData['descripcion']);
      $detalle     = trim($formData['detalle']);

      $datos = array();

      //Realizo las validaciones
      $Mensaje = "";

      $TipofaltaDuplicada = PanelTipofaltas::TipofaltaUnica($descripcion);

      if($TipofaltaDuplicada != 0)
        $Mensaje = "Ya se encuentra creado un tipo de falta con esa descripción.";
      else if($descripcion == "")
        $Mensaje = "Debe ingresar el nombre del tipo de falta.";
      else if($detalle == "")
        $Mensaje = "Debe ingresar el detalle.";

      if($Mensaje != "")
       {
        $Redireccion = "/panel/disciplinarios/tipofaltas/agregar";
       }
      else
       {
        $user         = Session::get('user');
        $DatosUsuario = PanelLogin::getUsuario($user);

        $datos['descripcion'] = $descripcion;
        $datos['detalle']     = $detalle;
        $datos['estado']      = 1; //Activo
        $datos['usrmod']      = $DatosUsuario[0]->empleado;
        $datos['fechamod']    = NOW();

        PanelTipofaltas::insertarTipofalta($datos);
        $Mensaje = "Tipo de falta creada.";
        $idtipo  = PanelTipofaltas::UltimoTipo();

        $fileImg = $formData['uploader1'];
        if($fileImg != '')
         {
          $file     = Request::file('file1');
          $destinationPath = substr(public_path(), 0, -14)."public/archivos/Disciplinarios/";
          $filename        = $idtipo->id_tipofalta.".docx";
          $uploadSuccess   = $file->move($destinationPath, $filename);
         }

        $Redireccion = "/panel/disciplinarios/tipofaltas/modificar/".$idtipo->id_tipofalta;
       }

      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function TipofaltasModificar($id)
   {
    if(Session::has('user'))
     {
      $idTipofalta    = $id;
      $DatosTipofalta = PanelTipofaltas::Tipofalta($idTipofalta);
      $user           = Session::get('user');
      $DatosUsuario   = PanelLogin::getUsuario($user);

      $e = 0;
      foreach($DatosTipofalta as $DaTpf)
        $e++;

      if($e == 0)
       {
        $Mensaje     = "Este tipo de falta ($idTipofalta) no existe.";
        $Redireccion = "/panel/disciplinarios/tipofaltas";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "disciplinarios/tipofaltas";
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

      if($DatosTipofalta == true)
       {
        return view('disciplinarios.panel-tipofaltasModificar')->with('DatosUsuario',$DatosUsuario)->with('DatosTipofalta',$DatosTipofalta);
       }
      else
       {
        $Mensaje     = "";
        $Redireccion = "/panel/disciplinarios/tipofaltas";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function TipofaltasModificarDB()
   {
    if(Session::has('user'))
     {
      $formData    = Request::all();
      $tipofalta   = $formData['tipofalta'];
      $descripcion = trim($formData['descripcion']);
      $detalle     = trim($formData['detalle']);
      $estado      = $formData['estado'];
      $fileImg     = $formData['uploader1'];

      $datos = array();

      //Realizo las validaciones
      $Mensaje = "";

      $TipofaltaDuplicada = PanelTipofaltas::TipofaltaUnicaModificar($descripcion, $tipofalta);

      if($TipofaltaDuplicada != 0)
        $Mensaje = "Ya se encuentra creada un tipo de falta con esa descripción.";
      else if($descripcion == "")
        $Mensaje = "Debe ingresar el nombre de la falta.";
      else if($estado == "")
        $Mensaje = "Debe seleccionar el estado.";

      if($Mensaje == "")
       {
        $user                 = Session::get('user');
        $DatosUsuario         = PanelLogin::getUsuario($user);
        $datos['descripcion'] = $descripcion;
        $datos['detalle']     = $detalle;
        $datos['estado']      = $estado;
        $datos['usrmod']      = $DatosUsuario[0]->empleado;
        $datos['fechamod']    = NOW();

        PanelTipofaltas::actualizarTipofalta($tipofalta, $datos);
        $Mensaje = "Tipo de falta modificada.";

        if($fileImg != '')
         {
          $file            = Request::file('file1');
          $destinationPath = substr(public_path(), 0, -14)."public/archivos/Disciplinarios/";
          $filename        = $tipofalta.".docx";
          $uploadSuccess   = $file->move($destinationPath, $filename);
         }
       }

      $Redireccion = "/panel/disciplinarios/tipofaltas/modificar/".$tipofalta;
      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }

 }