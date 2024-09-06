<?php
/*
Controlador de la tabla param_empresas
Usa SQl Eloquent del archivo app\Models\Parametrizacion\PanelEmpresas.php
*/

namespace App\Http\Controllers\Parametrizacion;

use App\Http\Controllers\Controller;
use App\Models\Parametrizacion\PanelEmpresas;
use App\Models\PanelLogin;
use Illuminate\Support\Facades\Session;
use Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class EmpresasPanelController extends Controller
 {
  public function showEmpresas()
   {
    if(Session::has('user'))
     {
      $user              = Session::get('user');
      $DatosUsuario      = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "parametrizacion/empresas";
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

      $DatosEmpresas     = PanelEmpresas::getEmpresas();
      $EmpresasActivas   = PanelEmpresas::getCantidadEmpresasActivas();
      $EmpresasInactivas = PanelEmpresas::getCantidadEmpresasInactivas();
      return view('parametrizacion.panel-empresas')->with('DatosUsuario',$DatosUsuario)->with('DatosEmpresas',$DatosEmpresas)->with('EmpresasActivas',$EmpresasActivas)->with('EmpresasInactivas',$EmpresasInactivas);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }

  public function EmpresasAgregar()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "parametrizacion/empresas";
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

      return view('parametrizacion.panel-empresasAgregar')->with('DatosUsuario',$DatosUsuario);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }

  public function EmpresasAgregarDB()
   {
    if(Session::has('user'))
     {
      $formData       = Request::all();
      $identificacion = trim($formData['identificacion']);
      $nombre         = trim($formData['nombre']);
      $fileImg        = $formData['uploader1'];

      $datos = array();

      //Realizo las validaciones
      $Mensaje          = "";
      $ExisteNit        = PanelEmpresas::getEmpresaNit($identificacion);
      $ExisteNombre     = PanelEmpresas::getEmpresaNombre($nombre);
      $EmpresaDuplicada = $ExisteNit + $ExisteNombre;

      if(!ctype_digit($identificacion))
        $Mensaje = "No es posible ingresar la empresa. El NIT solo debe contener números.";
      else if($EmpresaDuplicada != 0)
        $Mensaje = "No es posible ingresar la empresa. Ya se encuentra una, con igual nombre o NIT.";
      else if($nombre == "")
        $Mensaje = "Debe ingresar el nombre de la empresa.";
      else if($fileImg == "")
        $Mensaje = "Debe adjuntar la imagen.";

      if($Mensaje != "")
       {
        $Redireccion = "/panel/parametrizacion/empresas/agregar";
       }
      else
       {
        if($fileImg!='')
         {
          $file            = Request::file('file1');
          $destinationPath = substr(public_path(), 0, -14)."public/archivos/Logos/";
          $filename        = $identificacion.".png";
          $uploadSuccess   = $file->move($destinationPath, $filename);
         }
        else
         {
          $filename = 'Imagen no encontrada';
         }

        $datos['identificacion'] = $identificacion;
        $datos['nombre']         = $nombre;
        $datos['estado']         = 1; //Activo

        PanelEmpresas::insertarEmpresa($datos);
        $Mensaje = "Empresa creada.";

        //Agrego el guardado al log
        $user               = Session::get('user');
        $DatosUsuario       = PanelLogin::getUsuario($user);
        $idempresa          = PanelEmpresas::UltimaEmpresa();
        $datos1             = array();
        $datos1['modulo']   = 13;    //Empresas
        $datos1['tipo']     = "INS"; //Inserta
        $datos1['registro'] = "Id: ".$idempresa->id_empresa." |*| Nit: $identificacion |*| Nombre: $nombre";
        $datos1['usuario']  = $DatosUsuario[0]->empleado;
        $datos1['fecha']    = NOW();
        PanelLogin::insertarLog($datos1);
        ////////////////////////////////

        $Redireccion = "/panel/parametrizacion/empresas";
       }

      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function EmpresasModificar($id)
   {
    if(Session::has('user'))
     {
      $idEmpresa    = $id;
      $DatosEmpresa = PanelEmpresas::getEmpresa($idEmpresa);
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "parametrizacion/empresas";
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

      if($DatosEmpresa == true)
       {
        return view('parametrizacion.panel-empresasModificar')->with('DatosUsuario',$DatosUsuario)->with('DatosEmpresa',$DatosEmpresa);
       }
      else
       {
        $Mensaje     = "";
        $Redireccion = "/panel/parametrizacion/empresas";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function EmpresasModificarDB()
   {
    if(Session::has('user'))
     {
      $formData       = Request::all();
      $fileImg        = $formData['uploader1'];
      $id_empresa     = $formData['id_empresa'];
      $identificacion = trim($formData['identificacion']);
      $nombre         = trim($formData['nombre']);
      $estado         = trim($formData['estado']);
      $datos          = array();

      //Realizo las validaciones
      $Mensaje = "";

      $ExisteNit        = PanelEmpresas::getEmpresaNitModificar($identificacion, $id_empresa);
      $ExisteNombre     = PanelEmpresas::getEmpresaNombreModificar($nombre, $id_empresa);
      $EmpresaDuplicada = $ExisteNit + $ExisteNombre;

      if(!ctype_digit($identificacion))
        $Mensaje = "No es posible ingresar la empresa. El NIT solo debe contener números.";
      else if($EmpresaDuplicada != 0)
        $Mensaje = "No es posible ingresar la empresa. Ya se encuentra una, con igual nombre o NIT.";
      else if($nombre == "")
        $Mensaje = "Debe ingresar el nombre de la empresa.";
      else if($estado == "")
        $Mensaje = "Debe seleccionar el estado.";

      if($Mensaje == "")
       {
        if($fileImg!='')
         {
          $file            = Request::file('file1');
          $destinationPath = substr(public_path(), 0, -14)."public/archivos/Logos/";
          $filename        = $identificacion.".png";
          $uploadSuccess   = $file->move($destinationPath, $filename);
         }
        else
         {
          $filename = 'Imagen no encontrada';
         }

        $datos['identificacion'] = $identificacion;
        $datos['nombre']         = $nombre;
        $datos['estado']         = $estado;

        PanelEmpresas::actualizarEmpresa($id_empresa, $datos);
        $Mensaje = "Empresa modificada.";

        //Agrego el guardado al log
        $user               = Session::get('user');
        $DatosUsuario       = PanelLogin::getUsuario($user);
        $datos1             = array();
        $datos1['modulo']   = 13;    //Empresas
        $datos1['tipo']     = "UPD"; //Actualiza
        $datos1['registro'] = "Id: $id_empresa |*| Nit: $identificacion |*| Nombre: $nombre |*| Estado: $estado";
        $datos1['usuario']  = $DatosUsuario[0]->empleado;
        $datos1['fecha']    = NOW();
        PanelLogin::insertarLog($datos1);
        ////////////////////////////////
       }

      $Redireccion = "/panel/parametrizacion/empresas/modificar/".$id_empresa;
      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }
 }