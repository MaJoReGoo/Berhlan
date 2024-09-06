<?php
/*
Controlador de la tabla requ_grupos
Usa SQl Eloquent del archivo app\Models\Requerimientos\PanelGrupos.php
*/

namespace App\Http\Controllers\Requerimientos;
use App\Http\Controllers\Controller;
use App\Models\PanelLogin;
use App\Models\Requerimientos\PanelGrupos;
use Illuminate\Support\Facades\Session;
use Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class GruposRequerimientosPanelController extends Controller
 {
  public function GruposListado()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "requerimientos/grupos";
        $DatosMenu = PanelLogin::getMenuRuta($ruta);
        if($DatosMenu[0]->libre_acceso == 0)  //Si el modulo no es de libre acceso
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
            $ErrorValidacion = "Usted no tiene acceso al módulo.";
            return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
           }
         }
       }
      //Termina validación

      $DatosGrupos = PanelGrupos::getGrupos();
      return view('requerimientos.panel-grupos')->with('DatosUsuario',$DatosUsuario)->with('DatosGrupos',$DatosGrupos);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function GruposAgregar()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "requerimientos/grupos";
        $DatosMenu = PanelLogin::getMenuRuta($ruta);
        if($DatosMenu[0]->libre_acceso == 0)  //Si el modulo no es de libre acceso
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

      return view('requerimientos.panel-gruposAgregar')->with('DatosUsuario',$DatosUsuario);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function GruposAgregarDB()
   {
    if(Session::has('user'))
     {
      $formData    = Request::all();
      $descripcion = trim($formData['descripcion']);
      $reintegro   = $formData['reintegro'];

      $datos  = array();
      $datos1 = array();

      //Realizo las validaciones
      $Mensaje = "";

      $GrupoDuplicado = PanelGrupos::getGrupoUnico($descripcion);

      if($GrupoDuplicado != 0)
        $Mensaje = "Ya se encuentra un grupo con esa descripción.";
      else if($descripcion == "")
        $Mensaje = "Debe ingresar la descripción.";

      if($Mensaje != "")
       {
        $Redireccion = "/panel/requerimientos/grupos/agregar";
       }
      else
       {
        $datos['descripcion'] = $descripcion;
        $datos['estado']      = 1;
        $datos['reintegro']   = $reintegro;

        PanelGrupos::insertarGrupo($datos);

        $grupo     = PanelGrupos::UltimoGrupo();
        $Criterios = PanelGrupos::getCriterios();

        foreach ($Criterios as $DatCri)
         {
          $datos1['grupo']      = $grupo->id_grupo;
          $datos1['criticidad'] = $DatCri->id_criterio;
          $datos1['tiempo']     = '0';
          PanelGrupos::insertarPriorizacion($datos1);
         }

        $Mensaje = "Grupo creado.";

        //Agrego el guardado al log
        $user               = Session::get('user');
        $DatosUsuario       = PanelLogin::getUsuario($user);
        $datos1             = array();
        $datos1['modulo']   = 30;    //Grupos requerimientos
        $datos1['tipo']     = "INS"; //Inserta
        $datos1['registro'] = "Id: ".$grupo->id_grupo." |*| Descripción: ".$descripcion;
        $datos1['usuario']  = $DatosUsuario[0]->empleado;
        $datos1['fecha']    = NOW();
        PanelLogin::insertarLog($datos1);
        ////////////////////////////////

        $Redireccion = "/panel/requerimientos/grupos";
       }

      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function GruposModificar($id)
   {
    if(Session::has('user'))
     {
      $idGrupo      = $id;
      $DatosGrupo   = PanelGrupos::getGrupo($idGrupo);
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "requerimientos/grupos";
        $DatosMenu = PanelLogin::getMenuRuta($ruta);
        if($DatosMenu[0]->libre_acceso == 0)  //Si el modulo no es de libre acceso
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

      if($DatosGrupo == true)
       {
        return view('requerimientos.panel-gruposModificar')->with('DatosUsuario',$DatosUsuario)->with('DatosGrupo',$DatosGrupo);
       }
      else
       {
        $Mensaje     = "";
        $Redireccion = "/panel/requerimientos/grupos";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function GruposModificarDB()
   {
    if(Session::has('user'))
     {
      $formData    = Request::all();
      $id_grupo    = $formData['id_grupo'];
      $descripcion = trim($formData['descripcion']);
      $estado      = $formData['estado'];
      $reintegro   = $formData['reintegro'];

      $datos = array();

      //Realizo las validaciones
      $Mensaje = "";

      $GrupoDuplicado = PanelGrupos::getGrupoUnicoMod($id_grupo, $descripcion);

      if($GrupoDuplicado != 0)
        $Mensaje = "Ya se encuentra un grupo con esa descripción.";
      else if($descripcion == "")
        $Mensaje = "Debe ingresar la descripción del grupo.";

      if($Mensaje == "")
       {
        $datos['descripcion'] = $descripcion;
        $datos['estado']      = $estado;
        $datos['reintegro']   = $reintegro;

        PanelGrupos::actualizarGrupo($id_grupo, $datos);

        $Mensaje = "Grupo modificado.";

        //Agrego el guardado al log
        $user               = Session::get('user');
        $DatosUsuario       = PanelLogin::getUsuario($user);
        $datos1             = array();
        $datos1['modulo']   = 30;    //Grupos requerimientos
        $datos1['tipo']     = "UPD"; //Actualiza
        $datos1['registro'] = "Id: ".$id_grupo." |*| Descripción: ".$descripcion." |*| Estado: ".$estado;
        $datos1['usuario']  = $DatosUsuario[0]->empleado;
        $datos1['fecha']    = NOW();
        PanelLogin::insertarLog($datos1);
        ////////////////////////////////

       }

      $Redireccion = "/panel/requerimientos/grupos/modificar/".$id_grupo;
      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function EmpleadosGruposAsociar($id)
   {
    if(Session::has('user'))
     {
      $Grupo        = $id;
      $DatosGrupo   = PanelGrupos::getGrupo($Grupo);
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "requerimientos/grupos";
        $DatosMenu = PanelLogin::getMenuRuta($ruta);
        if($DatosMenu[0]->libre_acceso == 0)  //Si el modulo no es de libre acceso
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
            $ErrorValidacion = "Usted no tiene acceso al módulo.";
            return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
           }
         }
       }
      //Termina validación

      return view('requerimientos.panel-empleadosAgregar')->with('DatosUsuario',$DatosUsuario)->with('DatosGrupo',$DatosGrupo);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function EmpleadosGruposAsociarDB()
   {
    if(Session::has('user'))
     {
      $formData = Request::all();
      $grupo    = $formData['id_grupo'];
      $empleado = $formData['empleado'];

      $datos = array();

      //Realizo las validaciones
      $Mensaje = "";

      $EmpleadoDuplicado = PanelGrupos::getEmpleadoUnico($grupo, $empleado);

      if($EmpleadoDuplicado != 0)
        $Mensaje = "El empleado ya se encuentra asociado al grupo.";
      else if($empleado == "")
        $Mensaje = "Debe seleccionar el empleado.";

      if($Mensaje == "")
       {
        $datos['grupo']    = $grupo;
        $datos['empleado'] = $empleado;

        PanelGrupos::insertarEmpleadoGrupo($datos);
        $Mensaje = "Usuario asociado.";

        //Agrego el guardado al log
        $user               = Session::get('user');
        $DatosUsuario       = PanelLogin::getUsuario($user);
        $datos1             = array();
        $datos1['modulo']   = 30;    //Grupos requerimientos
        $datos1['tipo']     = "INS"; //Inserta
        $datos1['registro'] = "Id: ".$grupo." |*| Id empleado: ".$empleado;
        $datos1['usuario']  = $DatosUsuario[0]->empleado;
        $datos1['fecha']    = NOW();
        PanelLogin::insertarLog($datos1);
        ////////////////////////////////
       }

      $Redireccion = "/panel/requerimientos/empleados/asociar/".$grupo;
      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function EmpleadosGruposDesasociarDB()
   {
    if(Session::has('user'))
     {
      $formData     = Request::all();
      $grupo        = $formData['grupo'];
      $empleado     = $formData['empleado'];
      $user         = $formData['login'];
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "requerimientos/grupos";
        $DatosMenu = PanelLogin::getMenuRuta($ruta);
        if($DatosMenu[0]->libre_acceso == 0)  //Si el modulo no es de libre acceso
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
            $ErrorValidacion = "Usted no tiene acceso al módulo.";
            return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
           }
         }
       }
      //Termina validación

      PanelGrupos::retirarEmpleado($grupo, $empleado);
      $Mensaje = "Empleado retirado del grupo.";

      //Agrego el guardado al log
      $user               = Session::get('user');
      $DatosUsuario       = PanelLogin::getUsuario($user);
      $datos1             = array();
      $datos1['modulo']   = 30;    //Grupos requerimientos
      $datos1['tipo']     = "DEL"; //Borrado
      $datos1['registro'] = "Id: ".$grupo." |*| Id empleado: ".$empleado;
      $datos1['usuario']  = $DatosUsuario[0]->empleado;
      $datos1['fecha']    = NOW();
      PanelLogin::insertarLog($datos1);
      ////////////////////////////////

      $Redireccion = "/panel/requerimientos/grupos/modificar/".$grupo;
      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }
 }