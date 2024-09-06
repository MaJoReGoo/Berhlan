<?php
/*
Controlador de la tabla requ_grupos
Usa SQl Eloquent del archivo app\Models\Requerimientos\PanelCategorias.php
*/

namespace App\Http\Controllers\Requerimientos;
use App\Http\Controllers\Controller;
use App\Models\PanelLogin;
use App\Models\Requerimientos\PanelGrupos;
use App\Models\Requerimientos\PanelCategorias;
use Illuminate\Support\Facades\Session;
use Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class CategoriasRequerimientosPanelController extends Controller
 {
  public function CategoriasSeleccion()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "requerimientos/categorias";
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

      //Valido a categorías puede tener acceso
      if($DatosUsuario[0]->master == 1)
        $DatosGrupos = PanelGrupos::getGruposActivos();
      else
        $DatosGrupos = PanelGrupos::getGruposActivosEmpleado($DatosUsuario[0]->empleado);

      return view('requerimientos.panel-categorias')->with('DatosUsuario',$DatosUsuario)->with('DatosGrupos',$DatosGrupos);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function CategoriasListado($id)
   {
    if(Session::has('user'))
     {
      $Grupo        = $id;
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "requerimientos/categorias";
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

      //Valido que tenga acceso a las categorías del grupo seleccionado
      if($DatosUsuario[0]->master == 0)
       {
        $AccesoGrupo = PanelGrupos::getEmpleadoUnico($Grupo, $DatosUsuario[0]->empleado);
        if($AccesoGrupo == 0) //El usuario no tiene acceso al grupo
         {
          $ErrorValidacion = "Usted no tiene acceso al grupo seleccionado.";
          return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
         }
       }

      $DatosCategorias = PanelCategorias::getCategoriasGrupo($Grupo);

      return view('requerimientos.panel-categoriasListado')->with('DatosUsuario',$DatosUsuario)->with('DatosCategorias',$DatosCategorias)->with('Grupo',$Grupo);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function CategoriasAgregar($id)
   {
    if(Session::has('user'))
     {
      $Grupo        = $id;
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "requerimientos/categorias";
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

      //Valido que tenga acceso a las categorías del grupo seleccionado
      if($DatosUsuario[0]->master == 0)
       {
        $AccesoGrupo = PanelGrupos::getEmpleadoUnico($Grupo, $DatosUsuario[0]->empleado);
        if($AccesoGrupo == 0) //El usuario no tiene acceso al grupo
         {
          $ErrorValidacion = "Usted no tiene acceso al grupo seleccionado.";
          return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
         }
       }

      return view('requerimientos.panel-categoriasAgregar')->with('DatosUsuario',$DatosUsuario)->with('Grupo',$Grupo);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function CategoriasAgregarDB()
   {
    if(Session::has('user'))
     {
      $formData    = Request::all();
      $descripcion = trim($formData['descripcion']);
      $criterio    = trim($formData['criterio']);
      $grupo       = $formData['grupo'];
      $login       = $formData['login'];

      $datos = array();

      //Realizo las validaciones
      $Mensaje = "";

      $Catgrepetida = PanelCategorias::getCategoriaUnica($grupo, $descripcion);

      if($Catgrepetida != 0)
        $Mensaje = "Ya se encuentra una categoría con esa descripción.";
      else if($descripcion == "")
        $Mensaje = "Debe ingresar el nombre de la categoría.";
      else if($criterio == "")
        $Mensaje = "Debe seleccionar la criticidad.";

      if($Mensaje != "")
       {
        $Redireccion = "/panel/requerimientos/categorias/agregar/".$grupo;
       }
      else
       {
        $datos['grupo']       = $grupo;
        $datos['descripcion'] = $descripcion;
        $datos['criticidad']  = $criterio;
        $datos['estado']      = 1; //Activo

        PanelCategorias::insertarCategoria($datos);
        $Mensaje = "Categoría creada.";

        //Agrego el guardado al log
        $user               = Session::get('user');
        $DatosUsuario       = PanelLogin::getUsuario($user);
        $idcategoria        = PanelCategorias::UltimaCategoria();
        $datos1             = array();
        $datos1['modulo']   = 28;    //Categorías de cierre
        $datos1['tipo']     = "INS"; //Inserta
        $datos1['registro'] = "Id: ".$idcategoria->id_categoria." |*| Descripción: ".$descripcion." |*| Id criterio: ".$criterio;
        $datos1['usuario']  = $DatosUsuario[0]->empleado;
        $datos1['fecha']    = NOW();
        PanelLogin::insertarLog($datos1);
        ////////////////////////////////

        $Redireccion = "/panel/requerimientos/categorias/listado/".$grupo;
       }

      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function CategoriasModificar($id)
   {
    if(Session::has('user'))
     {
      $Categoria      = $id;
      $DatosCategoria = PanelCategorias::getCategoria($Categoria);
      $user           = Session::get('user');
      $DatosUsuario   = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "requerimientos/categorias";
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

      //Valido que tenga acceso a las categorías del grupo seleccionado
      if($DatosUsuario[0]->master == 0)
       {
        $AccesoGrupo = PanelGrupos::getEmpleadoUnico($DatosCategoria[0]->grupo, $DatosUsuario[0]->empleado);
        if($AccesoGrupo == 0) //El usuario no tiene acceso al grupo
         {
          $ErrorValidacion = "Usted no tiene acceso al grupo seleccionado.";
          return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
         }
       }

      if($DatosUsuario == true)
       {
        return view('requerimientos.panel-categoriasModificar')->with('DatosUsuario',$DatosUsuario)->with('DatosCategoria',$DatosCategoria);
       }
      else
       {
        $Mensaje     = "";
        $Redireccion = "/panel/requerimientos/categorias/listado/".$DatosCategoria[0]->grupo;
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function CategoriasModificarDB()
   {
    if(Session::has('user'))
     {
      $formData    = Request::all();
      $categoria   = $formData['categoria'];
      $descripcion = trim($formData['descripcion']);
      $criterio    = trim($formData['criterio']);
      $estado      = trim($formData['estado']);
      $grupo       = trim($formData['grupo']);

      $datos = array();

      //Realizo las validaciones
      $Mensaje = "";

      $ExisteCta = PanelCategorias::getCategoriaUnicaModificar($categoria, $grupo, $descripcion);

      if($ExisteCta != 0)
        $Mensaje = "Ya se encuentra una categoría con esa descripción.";
      else if($descripcion == "")
        $Mensaje = "Debe ingresar el nombre de la categoría.";
      else if($criterio == "")
        $Mensaje = "Debe seleccionar la criticidad.";
       else if($estado == "")
        $Mensaje = "Debe seleccionar el estado.";

      if($Mensaje == "")
       {
        $datos['descripcion'] = $descripcion;
        $datos['criticidad']  = $criterio;
        $datos['estado']      = $estado;

        PanelCategorias::actualizarCategoria($categoria, $datos);
        $Mensaje = "Categoría modificada.";

        //Agrego el guardado al log
        $user               = Session::get('user');
        $DatosUsuario       = PanelLogin::getUsuario($user);
        $datos1             = array();
        $datos1['modulo']   = 28;    //Categorías de cierre
        $datos1['tipo']     = "UPD"; //Actualiza
        $datos1['registro'] = "Id: ".$categoria." |*| Descripción: ".$descripcion." |*| Id criterio: ".$criterio." |*| Estado: ".$estado;
        $datos1['usuario']  = $DatosUsuario[0]->empleado;
        $datos1['fecha']    = NOW();
        PanelLogin::insertarLog($datos1);
        ////////////////////////////////
       }

      $Redireccion = "/panel/requerimientos/categorias/modificar/".$categoria;
      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }
 }