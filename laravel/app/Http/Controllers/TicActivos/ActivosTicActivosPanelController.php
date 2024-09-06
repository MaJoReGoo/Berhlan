<?php
/*
Controlador de la tabla acti_activo
Usa SQl Eloquent del archivo app\Models\Bpack\PanelActivos.php
*/

namespace App\Http\Controllers\TicActivos;
use App\Http\Controllers\Controller;
use App\Models\TicActivos\PanelActivos;
use App\Models\TicActivos\PanelTipos;
use App\Models\TicActivos\PanelSoftware;
use App\Models\TicActivos\PanelLicencias;
use App\Models\TicActivos\PanelMarcas;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelEmpresas;
use App\Models\PanelLogin;
use Illuminate\Support\Facades\Session;
use Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class ActivosTicActivosPanelController extends Controller
 {
  public function Ingresar()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "ticactivos/ingresaract";
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

      return view('ticactivos.panel-ingresaract')->with('DatosUsuario',$DatosUsuario);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function IngresarDet()
   {
    if(Session::has('user'))
     {
      $formData = Request::all();
      $tipo     = $formData['tipo'];
      $empleado = $formData['empleado'];

      $datosactivo = array();

      $datosactivo['tipo']     = $tipo;
      $datosactivo['empleado'] = $empleado;

      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      $sql = "SELECT SUBSTRING_INDEX(cod_interno, '-', 1) AS primero, MAX(SUBSTRING_INDEX(cod_interno, '-', 2)) AS segundo "
            ."FROM acti_activo WHERE tipo = '$tipo' GROUP BY primero ORDER BY cod_interno;";

      $DatosUltCon = PanelActivos::ActivosSql($sql);

      return view('ticactivos.panel-ingresaractDet')->with('DatosUsuario',$DatosUsuario)->with('DatosActivo',$datosactivo)->with('DatosUltCon',$DatosUltCon);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function IngresarDB()
   {
    if(Session::has('user'))
     {
      $formData = Request::all();

      $datos = array();

      $tipo                 = $formData['tipo'];
      $datos['tipo']        = $tipo;
      $datos['empleado']    = $formData['empleado'];
      $datos['empresa']     = $formData['empresa'];
      $datos['marca']       = $formData['marca'];
      $datos['serial']      = trim($formData['serial']);
      $datos['cod_interno'] = trim($formData['codigoint']);
      $datos['activofijo']  = trim($formData['activofijo']);

      $fechaadq = trim($formData['adquisicion']);
      if($fechaadq == "")
        $fechaadq = NULL;
      $datos['fechaadq'] = $fechaadq;

      $valor_compra = $formData['valcompra'];
      if($valor_compra == "")
        $valor_compra = 0;

      $datos['valor_compra'] = $valor_compra;
      $datos['usrclave']     = trim($formData['usrclave']);

      $garantia = $formData['garantia'];
      if($garantia == "")
        $garantia = NULL;

      $datos['garantia']      = $garantia;
      $datos['foto']          = "";
      $datos['factura']       = "";
      $datos['actafirmada']   = "";
      $mantenimiento          = $formData['mantenimiento'];
      $datos['mantenimiento'] = $mantenimiento;

      //Si aplica mantenimiento
      if($mantenimiento == "S")
       {
        $datos['mes_mtto']  = $formData['meses'];
        $datos['fechamtto'] = $formData['fechainicial'];
       }
      else
       {
        $datos['mes_mtto'] = 0;
       }

      $datos['mac1']          = trim($formData['mac1']);
      $datos['ip1']           = trim($formData['ip1']);
      $datos['observaciones'] = trim($formData['observaciones']);

      $Tipoactivo = PanelTipos::getTipo($tipo);

      if($Tipoactivo[0]->campos_pc == "S")
       {
        $datos['tamano_dd']     = trim($formData['tamanodd']);
        $datos['tipo_dd']       = trim($formData['tipodd']);
        $datos['tamano_ram']    = trim($formData['tamanoram']);
        $datos['tipo_ram']      = trim($formData['tiporam']);
        $datos['procesador']    = trim($formData['procesador']);
        $datos['office']        = $formData['licoffice'];
        $datos['mac2']          = trim($formData['mac2']);
        $datos['ip2']           = trim($formData['ip2']);
        $datos['controlremoto'] = trim($formData['remoto']);
        $datos['lic_windows']   = $formData['licencia'];
       }
      else
       {
        $datos['tamano_dd']     = "";
        $datos['tipo_dd']       = "";
        $datos['tamano_ram']    = "";
        $datos['tipo_ram']      = "";
        $datos['procesador']    = "";
        $datos['office']        = 0;
        $datos['mac2']          = "";
        $datos['ip2']           = "";
        $datos['controlremoto'] = "";
        $datos['lic_windows']   = "";
       }

      if($Tipoactivo[0]->campo1 != "")
        $datos['campo1'] = trim($formData['campo1']);
      else
        $datos['campo1'] = "";

      if($Tipoactivo[0]->campo2 != "")
        $datos['campo2'] = trim($formData['campo2']);
      else
        $datos['campo2'] = "";

      if($Tipoactivo[0]->campo3 != "")
        $datos['campo3'] = trim($formData['campo3']);
      else
        $datos['campo3'] = "";

      $datos['estado'] = 1; //Activo

      PanelActivos::insertarActivo($datos);
      $Mensaje = "Activo creado.";

      $idActivo = PanelActivos::UltimoActivo();

      $ano = date('Y');
      $mes = date('m')*1;

      //Factura
      $fileImg1 = $formData['uploader1'];
      if($fileImg1 != '')
       {
        $ruta = substr(public_path(), 0, -14)."public/archivos/Activostic/Facturas/".$ano."/".$mes."/";

        $file1         = Request::file('file1');
        $nombre1       = $ano."/".$mes."/Factura_Activo_".$idActivo->id_activo.".pdf";
        $uploadSuccess = $file1->move($ruta, $nombre1);

        $datos1            = array();
        $datos1['factura'] = $nombre1;
        PanelActivos::actualizarActivo($idActivo->id_activo, $datos1);
       }

      //Foto
      $fileImg2 = $formData['uploader2'];
      if($fileImg2 != '')
       {
        $ruta = substr(public_path(), 0, -14)."public/archivos/Activostic/Fotos/".$ano."/".$mes."/";

        $file2         = Request::file('file2');
        $nombre2       = $ano."/".$mes."/Foto_Activo_".$idActivo->id_activo.".jpg";
        $uploadSuccess = $file2->move($ruta, $nombre2);

        $datos2         = array();
        $datos2['foto'] = $nombre2;
        PanelActivos::actualizarActivo($idActivo->id_activo, $datos2);
       }

      if($Tipoactivo[0]->campos_pc == "S")
       {
        $datos3 = array();
        $prog = $formData['programas'];
        foreach($prog as $DatPro)
         {
          if(($DatPro) && ($DatPro != 300))
           {
            $datos3['activo']   = $idActivo->id_activo;
            $datos3['software'] = $DatPro;
            PanelActivos::ingresarPrograma($datos3);
           }
         }
       }

      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Si aplica como mantenimiento ingreso un registro en actividades como punto de partida
      if($mantenimiento == "S")
       {
        $datos5                  = array();
        $datos5['activo']        = $idActivo->id_activo;
        $datos5['mantenimiento'] = 'I';
        $datos5['observaciones'] = 'INGRESO';
        $datos5['usuario']       = $DatosUsuario[0]->empleado;
        $datos5['fecha']         = NOW();

        PanelActivos::insertarActividad($datos5);
       }

      $datos6            = array();
      $datos6['activo']  = $idActivo->id_activo;
      $datos6['fecha']   = NOW();
      $datos6['cambio']  = 'Ingresa activo';
      $datos6['usuario'] = $DatosUsuario[0]->empleado;

      PanelActivos::insertarCambio($datos6);

      $Redireccion = "/panel/ticactivos/acta/".$idActivo->id_activo;

      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function Acta($id)
   {
    if(Session::has('user'))
     {
      $Activo      = $id;
      $DatosActivo = PanelActivos::Activo($Activo);

      $e = 0;
      foreach($DatosActivo as $DatAct)
        $e++;

      if($e == 0)
       {
        $Mensaje = "Activo no existe.";
        $Redireccion = "/panel/menu/64";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }

      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      return view('ticactivos.panel-acta')->with('DatosUsuario',$DatosUsuario)->with('DatosActivo',$DatosActivo);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function IngresarActividadDB()
   {
    if(Session::has('user'))
     {
      $formData     = Request::all();
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      $datos  = array();
      $activo = $formData['activo'];
      $mttosn = $formData['mttosn'];
      if($mttosn == 'S')
        $datos['mantenimiento'] = $formData['mantenimiento'];
      else
        $datos['mantenimiento'] = "N";

      $datos['activo']        = $activo;
      $datos['observaciones'] = trim($formData['observaciones']);
      $datos['usuario']       = $DatosUsuario[0]->empleado;
      $datos['fecha']         = NOW();

      PanelActivos::insertarActividad($datos);
      $actividad = PanelActivos::UltimaActividad();
      $Mensaje   = "Actividad ingresada.";

      if($mttosn == 'S')
       {
        $datos1 = array();
        $activ  = $formData['actividades'];
        foreach($activ as $DatAct)
         {
          if($DatAct != 300)
           {
            $datos1['actividad'] = $actividad->id_actividad;
            $datos1['tarea']     = $DatAct;
            PanelActivos::ingresarTareaAct($datos1);
           }
         }
       }

      $Redireccion = "/panel/ticactivos/consultasparam/detalle/".$activo;

      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function Modificar($id)
   {
    if(Session::has('user'))
     {
      $Activo       = $id;
      $DatosActivo  = PanelActivos::Activo($Activo);
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      $e = 0;
      foreach($DatosActivo as $DatAct)
        $e++;

      if($e == 0)
       {
        $Mensaje = "Activo no existe.";
        $Redireccion = "/panel/menu/64";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "ticactivos/consultasact";
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

      return view('ticactivos.panel-modificaract')->with('DatosUsuario',$DatosUsuario)->with('DatosActivo', $DatosActivo);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function ModificarDB()
   {
    if(Session::has('user'))
     {
      $formData = Request::all();

      $datos = array();

      $activo               = $formData['activo'];
      $tipo                 = $formData['tipo'];
      $empleado             = $formData['empleado'];
      $datos['empleado']    = $empleado;
      $empresa              = $formData['empresa'];
      $datos['empresa']     = $empresa;
      $marca                = $formData['marca'];
      $datos['marca']       = $marca;
      $serial               = trim($formData['serial']);
      $datos['serial']      = $serial;
      $codinterno           = trim($formData['codigoint']);
      $datos['cod_interno'] = $codinterno;
      $activofijo           = trim($formData['activofijo']);
      $datos['activofijo']  = $activofijo;
      $usrclave             = trim($formData['usrclave']);
      $datos['usrclave']    = $usrclave;

      $ano = date('Y');
      $mes = date('m')*1;

      $DatosActivo = PanelActivos::Activo($activo);

      //Factura
      $fileImg1 = $formData['uploader1'];
      if($fileImg1 != '')
       {
        //Si ya existe una factura, borro el archivo
        if($DatosActivo[0]->factura != '')
         {
          $ruta1  = substr(public_path(), 0, -14)."public/archivos/Activostic/Facturas/";
          $borrar = $ruta1.$DatosActivo[0]->factura;
          if(file_exists($borrar))
           unlink($borrar);
         }

        $ruta          = substr(public_path(), 0, -14)."public/archivos/Activostic/Facturas/".$ano."/".$mes."/";
        $file1         = Request::file('file1');
        $nombre1       = $ano."/".$mes."/Factura_Activo_".$activo.".pdf";
        $uploadSuccess = $file1->move($ruta, $nombre1);

        $datos['factura'] = $nombre1;
       }

      //Foto
      $fileImg2 = $formData['uploader2'];
      if($fileImg2 != '')
       {
        //Si ya existe una foto, borro el archivo
        if($DatosActivo[0]->foto != '')
         {
          $ruta1  = substr(public_path(), 0, -14)."public/archivos/Activostic/Fotos/";
          $borrar = $ruta1.$DatosActivo[0]->foto;
          if(file_exists($borrar))
           unlink($borrar);
         }

        $ruta          = substr(public_path(), 0, -14)."public/archivos/Activostic/Fotos/".$ano."/".$mes."/";
        $file2         = Request::file('file2');
        $nombre2       = $ano."/".$mes."/Foto_Activo_".$activo.".jpg";
        $uploadSuccess = $file2->move($ruta, $nombre2);

        $datos['foto'] = $nombre2;
       }

      //Acta firmada
      $fileImg3 = $formData['uploader3'];
      if($fileImg3 != '')
       {
        //Si ya existe un acta, borro el archivo
        if($DatosActivo[0]->actafirmada != '')
         {
          $ruta1  = substr(public_path(), 0, -14)."public/archivos/Activostic/Actas_firmadas/";
          $borrar = $ruta1.$DatosActivo[0]->actafirmada;
          if(file_exists($borrar))
           unlink($borrar);
         }

        $ruta          = substr(public_path(), 0, -14)."public/archivos/Activostic/Actas_firmadas/".$ano."/".$mes."/";
        $file3         = Request::file('file3');
        $nombre3       = $ano."/".$mes."/Acta_".$activo.".pdf";
        $uploadSuccess = $file3->move($ruta, $nombre3);

        $datos['actafirmada'] = $nombre3;
       }

      $garantia = $formData['garantia'];
      if($garantia != "")
        $datos['garantia'] = $garantia;

      $fechaadq = $formData['adquisicion'];
      if($fechaadq != "")
        $datos['fechaadq'] = $fechaadq;

      $valor_compra = $formData['valcompra'];
      if($valor_compra != "")
        $datos['valor_compra'] = $valor_compra;

      $mantenimiento          = $formData['mantenimiento'];
      $datos['mantenimiento'] = $mantenimiento;

      //Si aplica mantenimiento
      if($mantenimiento == "S")
       {
        $mes_mtto          = $formData['meses'];
        $datos['mes_mtto'] = $mes_mtto;
        if($DatosActivo[0]->fechamtto == NULL)
         {
          $fechamtto          = $formData['fechainicial'];
          $datos['fechamtto'] = $fechamtto;
         }
        else
         {
          $fechamtto = '';
         }
       }
      else
       {
        $mes_mtto           = 0;
        $fechamtto          = '';
        $datos['mes_mtto']  = 0;
        $datos['fechamtto'] = NULL;
       }

      $mac1                   = trim($formData['mac1']);
      $datos['mac1']          = $mac1;
      $ip1                    = trim($formData['ip1']);
      $datos['ip1']           = $ip1;
      $obs                    = trim($formData['observaciones']);
      $datos['observaciones'] = $obs;

      $Tipoactivo = PanelTipos::getTipo($tipo);

      if($Tipoactivo[0]->campos_pc == "S")
       {
        $tamano_dd              = trim($formData['tamanodd']);
        $datos['tamano_dd']     = $tamano_dd;
        $tipo_dd                = trim($formData['tipodd']);
        $datos['tipo_dd']       = $tipo_dd;
        $tamano_ram             = trim($formData['tamanoram']);
        $datos['tamano_ram']    = $tamano_ram;
        $tipo_ram               = trim($formData['tiporam']);
        $datos['tipo_ram']      = $tipo_ram;
        $procesador             = trim($formData['procesador']);
        $datos['procesador']    = $procesador;
        $office                 = $formData['licoffice'];
        $datos['office']        = $office;
        $mac2                   = trim($formData['mac2']);
        $datos['mac2']          = $mac2;
        $ip2                    = trim($formData['ip2']);
        $datos['ip2']           = $ip2;
        $controlremoto          = trim($formData['remoto']);
        $datos['controlremoto'] = $controlremoto;
        $lic_windows            = $formData['licencia'];
        $datos['lic_windows']   = $lic_windows;
       }

      if($Tipoactivo[0]->campo1 != "")
       {
        $cam1            = trim($formData['campo1']);
        $datos['campo1'] = $cam1;
       }

      if($Tipoactivo[0]->campo2 != "")
       {
        $cam2            = trim($formData['campo2']);
        $datos['campo2'] = $cam2;
       }

      if($Tipoactivo[0]->campo3 != "")
       {
        $cam3            = trim($formData['campo3']);
        $datos['campo3'] = $cam3;
       }

      $estado          = $formData['estado'];
      $datos['estado'] = $estado;

      PanelActivos::actualizarActivo($activo, $datos);

      $Mensaje = "Activo modificado.";

      if($Tipoactivo[0]->campos_pc == "S")
       {
        //Borro todos los programas
        PanelActivos::borrarProgramas($activo);

        $datos1 = array();
        $prog = $formData['programas'];
        foreach($prog as $DatPro)
         {
          if(($DatPro) && ($DatPro != 300))
           {
            $datos1['activo']   = $activo;
            $datos1['software'] = $DatPro;
            PanelActivos::ingresarPrograma($datos1);
           }
         }
       }

      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Si es necesario ingresar un punto de partida en actividades
      if(($mantenimiento == "S") && ($DatosActivo[0]->fechamtto == NULL))
       {
        $datos2                  = array();
        $datos2['activo']        = $activo;
        $datos2['mantenimiento'] = 'I';
        $datos2['observaciones'] = 'INGRESO';
        $datos2['usuario']       = $DatosUsuario[0]->empleado;
        $datos2['fecha']         = NOW();

        PanelActivos::insertarActividad($datos5);
       }

      // Control de cambios
      $cambios = "";

      if($DatosActivo[0]->estado != $estado)
       {
        if($estado == 0)
          $cambios = " || Estado: Activo";
        else
          $cambios = " || Estado: Inactivo";
       }

      if($DatosActivo[0]->empleado != $empleado)
       {
        $Emp     = PanelEmpleados::getEmpleado($DatosActivo[0]->empleado);
        $cambios = $cambios." || Colaborador: ".$Emp[0]->identificacion;
       }

      if($DatosActivo[0]->empresa != $empresa)
       {
        $Empr    = PanelEmpresas::getEmpresa($DatosActivo[0]->empresa);
        $cambios = $cambios." || Compañía: ".$Empr[0]->nombre;
       }

      if($DatosActivo[0]->marca != $marca)
       {
        $Marc    = PanelMarcas::getMarca($DatosActivo[0]->marca);
        $cambios = $cambios." || Marca y modelo: ".$Marc[0]->descripcion;
       }

      if($DatosActivo[0]->serial != $serial)
        $cambios = $cambios." || Serial: ".$DatosActivo[0]->serial;

      if($DatosActivo[0]->cod_interno != $codinterno)
        $cambios = $cambios." || Código interno: ".$DatosActivo[0]->cod_interno;

      if($DatosActivo[0]->activofijo != $activofijo)
        $cambios = $cambios." || Activo fijo: ".$DatosActivo[0]->activofijo;

      if($DatosActivo[0]->usrclave != $usrclave)
        $cambios = $cambios." || Usuario y clave: ".$DatosActivo[0]->usrclave;

      if($fileImg1 != '')
        $cambios = $cambios." || Se actualizo la factura";

      if($fileImg2 != '')
        $cambios = $cambios." || Se actualizo la imagen";

      if($fileImg3 != '')
        $cambios = $cambios." || Se actualizo el acta firmada";

      if($DatosActivo[0]->garantia != $garantia)
        $cambios = $cambios." || Garantía: ".$DatosActivo[0]->garantia;

      if($DatosActivo[0]->fechaadq != $fechaadq)
        $cambios = $cambios." || Fecha de adquisición: ".$DatosActivo[0]->fechaadq;

      if($DatosActivo[0]->valor_compra != $valor_compra)
        $cambios = $cambios." || Valor compra: ".$DatosActivo[0]->valor_compra;

      if($DatosActivo[0]->mantenimiento != $mantenimiento)
        $cambios = $cambios." || Mantenimiento: ".$DatosActivo[0]->mantenimiento;

      if($DatosActivo[0]->mes_mtto != $mes_mtto)
        $cambios = $cambios." || Meses entre mantenimientos: ".$DatosActivo[0]->mes_mtto;

      if(($fechamtto != '') && ($DatosActivo[0]->fechamtto == NULL))
        $cambios = $cambios." || Fecha inicial mantenimiento";

      if($DatosActivo[0]->mac1 != $mac1)
        $cambios = $cambios." || Mac 1: ".$DatosActivo[0]->mac1;

      if($DatosActivo[0]->ip1 != $ip1)
        $cambios = $cambios." || IP 1: ".$DatosActivo[0]->ip1;

      if($DatosActivo[0]->observaciones != $obs)
        $cambios = $cambios." || Observaciones: ".$DatosActivo[0]->observaciones;

      if($Tipoactivo[0]->campos_pc == "S")
       {
        if($DatosActivo[0]->tamano_dd != $tamano_dd)
          $cambios = $cambios." || Tamaño de DD: ".$DatosActivo[0]->tamano_dd;

        if($DatosActivo[0]->tipo_dd != $tipo_dd)
          $cambios = $cambios." || Tipo DD: ".$DatosActivo[0]->tipo_dd;

        if($DatosActivo[0]->tamano_ram != $tamano_ram)
          $cambios = $cambios." || Tamaño RAM: ".$DatosActivo[0]->tamano_ram;

        if($DatosActivo[0]->tipo_ram != $tipo_ram)
          $cambios = $cambios." || Tipo de RAM: ".$DatosActivo[0]->tipo_ram;

        if($DatosActivo[0]->procesador != $procesador)
          $cambios = $cambios." || Procesador: ".$DatosActivo[0]->procesador;

        if(($DatosActivo[0]->office != $office) && ($DatosActivo[0]->office != 0))
         {
          $Licencia = PanelLicencias::LicenciasyTipo($DatosActivo[0]->office);
          $cambios  = $cambios." || Licencia de office: ".$Licencia[0]->lice;
         }

        if($DatosActivo[0]->mac2 != $mac2)
          $cambios = $cambios." || Mac 2: ".$DatosActivo[0]->mac2;

        if($DatosActivo[0]->ip2 != $ip2)
          $cambios = $cambios." || Ip 2: ".$DatosActivo[0]->ip2;

        if($DatosActivo[0]->controlremoto != $controlremoto)
          $cambios = $cambios." || Control remoto: ".$DatosActivo[0]->controlremoto;

        if($DatosActivo[0]->lic_windows != $lic_windows)
          $cambios = $cambios." || Licencia de Windows: ".$DatosActivo[0]->lic_windows;
       }

      if($Tipoactivo[0]->campo1 != "")
       {
        if($DatosActivo[0]->campo1 != $cam1)
          $cambios = $cambios." || Parámetro 1: ".$DatosActivo[0]->campo1;
       }

      if($Tipoactivo[0]->campo2 != "")
       {
        if($DatosActivo[0]->campo2 != $cam2)
          $cambios = $cambios." || Parámetro 2: ".$DatosActivo[0]->campo2;
       }

      if($Tipoactivo[0]->campo3 != "")
       {
        if($DatosActivo[0]->campo3 != $cam3)
          $cambios = $cambios." || Parámetro 3: ".$DatosActivo[0]->campo3;
       }

      if($cambios != "")
       {
        $datos3            = array();
        $datos3['activo']  = $activo;
        $datos3['fecha']   = NOW();
        $datos3['cambio']  = trim($cambios);
        $datos3['usuario'] = $DatosUsuario[0]->empleado;
        PanelActivos::insertarCambio($datos3);
       }

      $Redireccion = "/panel/ticactivos/modificaract/".$activo;

      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }
 }