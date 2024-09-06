<?php
use App\Http\Controllers\ActivosFijos\ActivosFijosController;
use App\Http\Controllers\ActivosFijos\ConsultasActivosFijosController;
use App\Http\Controllers\ActivosFijos\TextosActivosFijosController;
use App\Http\Controllers\ArchivoDigital\ArchivoCentralController;
use App\Http\Controllers\ArchivoDigital\HistoriasPanelController;
use App\Http\Controllers\ArchivoDigital\InformesArchivoDigitalController;
use App\Http\Controllers\ArchivoDigital\InsercionDocumentalController;
use App\Http\Controllers\ArchivoDigital\TipoDocumentoController;
use App\Http\Controllers\ArchivoDigital\TransferenciaDocumentalController;
use App\Http\Controllers\ArchivoPlano\ArchivoPlanoPanelController;
use App\Http\Controllers\Bpack\AprContratoPanelController;
use App\Http\Controllers\Bpack\ApruebaPanelController;
use App\Http\Controllers\Bpack\CancelarPanelController;
use App\Http\Controllers\Bpack\ConsultasSolicitudesPanelController;
use App\Http\Controllers\Bpack\ContratoPanelController;
use App\Http\Controllers\Bpack\CorreccionRechazoApruebaPanelController;
use App\Http\Controllers\Bpack\CorreccionRechazoRutaPanelController;
use App\Http\Controllers\Bpack\MotivosBpackPanelController;
use App\Http\Controllers\Bpack\MuestrasPanelController;
use App\Http\Controllers\Bpack\PendientesPanelController;
use App\Http\Controllers\Bpack\ReclamosPanelController;
use App\Http\Controllers\Bpack\RutasPanelController;
use App\Http\Controllers\Bpack\SherpasPanelController;
use App\Http\Controllers\Bpack\SolicitudANPanelController;
use App\Http\Controllers\CumpleanosPanelController;
use App\Http\Controllers\Despachos\DespachosPanelController;
use App\Http\Controllers\Despachos\OrdenesPanelController;
use App\Http\Controllers\Disciplinarios\AtenderDisciplinariosPanelController;
use App\Http\Controllers\Disciplinarios\ConsultasDisciplinariosPanelController;
use App\Http\Controllers\Disciplinarios\MotivosDisciplinariosPanelController;
use App\Http\Controllers\Disciplinarios\SolicitudDisciplinariosPanelController;
use App\Http\Controllers\Disciplinarios\TipofaltasDisciplinariosPanelController;
use App\Http\Controllers\Etiquetas\EtiquetasPanelController;
use App\Http\Controllers\HomePanelController;
use App\Http\Controllers\Noticias\NoticiasPanelController;
use App\Http\Controllers\Parametrizacion\AreasPanelController;
use App\Http\Controllers\Parametrizacion\CargosPanelController;
use App\Http\Controllers\Parametrizacion\CentrosOpPanelController;
use App\Http\Controllers\Parametrizacion\CiudadesPanelController;
use App\Http\Controllers\Parametrizacion\EmpleadosPanelController;
use App\Http\Controllers\Parametrizacion\EmpresasPanelController;
use App\Http\Controllers\Parametrizacion\SincronizarPanelController;
use App\Http\Controllers\Parametrizacion\UsuariosPanelController;
use App\Http\Controllers\Procesos\CadenaProcesosPanelController;
use App\Http\Controllers\Procesos\DocPerProcesosPanelController;
use App\Http\Controllers\Procesos\DocProcesosPanelController;
use App\Http\Controllers\Procesos\DocSubProcesosPanelController;
use App\Http\Controllers\Procesos\PerfilesProcesosPanelController;
use App\Http\Controllers\Procesos\ProcesosPanelController;
use App\Http\Controllers\Procesos\SubDocProcesosPanelController;
use App\Http\Controllers\Procesos\SubProcesosPanelController;
use App\Http\Controllers\Procesos\TipoDocProcesosPanelController;
use App\Http\Controllers\Procesos\CompartirArchProcesosPanelController;
use App\Http\Controllers\Requerimientos\AtenderRequerimientosPanelController;
use App\Http\Controllers\Requerimientos\CategoriasRequerimientosPanelController;
use App\Http\Controllers\Requerimientos\ConsultasRequerimientosPanelController;
use App\Http\Controllers\Requerimientos\CrearRequerimientosPanelController;
use App\Http\Controllers\Requerimientos\GruposRequerimientosPanelController;
use App\Http\Controllers\Requerimientos\InformeRequerimientosPanelController;
use App\Http\Controllers\Requerimientos\MisRequerimientosPanelController;
use App\Http\Controllers\Requerimientos\PriorizacionRequerimientosPanelController;
use App\Http\Controllers\Requerimientos\ReintegroRequerimientosPanelController;
use App\Http\Controllers\Requerimientos\ElementosRequisicionesPanelController;
use App\Http\Controllers\Requisiciones\ConsultasRequisicionesPanelController;
use App\Http\Controllers\Ssl\ExamenesRequisicionesPanelController;
use App\Http\Controllers\Requisiciones\InformeRequisicionesPanelController;
use App\Http\Controllers\Requisiciones\ParametrizacionPanelController;
use App\Http\Controllers\Requisiciones\MotivosRequisicionesPanelController;
use App\Http\Controllers\Requisiciones\SolRequisicionesPanelController;
use App\Http\Controllers\Requisiciones\TpcontratosRequisicionesPanelController;
use App\Http\Controllers\Requisiciones\GestionIngresosPanelController;
use App\Http\Controllers\SolCompra\AprobadoresSolCompraPanelController;
use App\Http\Controllers\SolCompra\AprobarSolCompraPanelController;
use App\Http\Controllers\SolCompra\MotivosSolCompraPanelController;
use App\Http\Controllers\SolCompra\SolicitudSolCompraPanelController;
use App\Http\Controllers\TicActivos\ActivosTicActivosPanelController;
use App\Http\Controllers\TicActivos\ConsultasTicActivosPanelController;
use App\Http\Controllers\TicActivos\LicenciasTicActivosPanelController;
use App\Http\Controllers\TicActivos\MarcasTicActivosPanelController;
use App\Http\Controllers\TicActivos\SoftwareTicActivosPanelController;
use App\Http\Controllers\TicActivos\TareasTicActivosPanelController;
use App\Http\Controllers\TicActivos\TextosTicActivosPanelController;
use App\Http\Controllers\TicActivos\TiposTicActivosPanelController;
use App\Http\Controllers\TicActivos\TpOfficeTicActivosPanelController;
use App\Http\Controllers\Inconformidades\InconformidadesTratamientoController;
use App\Http\Controllers\Inconformidades\InconformidadesReporteController;
use App\Http\Controllers\MuestrasComerciales\MuestrasComercialesPanelController;
use App\Http\Controllers\Ssl\GestionarNotificacionesPermisosController;
use App\Http\Controllers\Requisiciones\GestionarPermisosRequisicionesPanelController;

use Illuminate\Support\Facades\Route;

/* Ruta de inicio del proyecto */
Route::get('/', [HomePanelController::class, 'showLogin']);
Route::get('/inicio', [HomePanelController::class, 'showLogin']);
Route::get('/error', function () { })->name('showError');

/* Rutas Panel Login */
Route::group
(
    ['middleware' => ['web']],
    function () {
        /* Rutas de Logeo */
        Route::get('/panel/login', [HomePanelController::class, 'showLogin']);
        Route::post('/panel/loginverification', [HomePanelController::class, 'showLoginVerification']);

        /* Rutas de Logeo */
        Route::get('/panel/cambiopwd', [HomePanelController::class, 'PwdModificar']);
        Route::post('/panel/cambiopwd/modificardb', [HomePanelController::class, 'PwdModificarDB']);

        /* Rutas de Cambio de Email */
        Route::get('/panel/cambioemail', [HomePanelController::class, 'EmailModificar']);
        Route::post('/panel/cambioemail/modificardb', [HomePanelController::class, 'EmailModificarDB']);

        /* Cerrar sesión */
        Route::get('/panel/logout', [HomePanelController::class, 'showSalir']);

        /* Submenu */
        Route::get('/panel/menu/{id}', [HomePanelController::class, 'showMenu'])->where('id', '[0-9]+');

        /* Ruta en construcción */
        Route::get('/panel/construccion', [HomePanelController::class, 'showConstruccion']);

        /* Rutas para cumpleaños */
        Route::get('/panel/cumple/{id}', [CumpleanosPanelController::class, 'showCumpleanos'])->where('id', '[0-9]+');

        /* Rutas para noticias */
        Route::get('/panel/noticias/noticias', [NoticiasPanelController::class, 'showNoticias']);

        /* Rutas panel empresas */
        Route::get('/panel/parametrizacion/empresas', [EmpresasPanelController::class, 'showEmpresas']);
        Route::get('/panel/parametrizacion/empresas/agregar', [EmpresasPanelController::class, 'EmpresasAgregar']);
        Route::post('/panel/parametrizacion/empresas/agregardb', [EmpresasPanelController::class, 'EmpresasAgregarDB']);
        Route::get('/panel/parametrizacion/empresas/modificar/{id}', [EmpresasPanelController::class, 'EmpresasModificar'])->where('id', '[0-9]+');
        Route::post('/panel/parametrizacion/empresas/modificardb', [EmpresasPanelController::class, 'EmpresasModificarDB']);

        /* Rutas panel áreas */
        Route::get('/panel/parametrizacion/areas', [AreasPanelController::class, 'showAreas'])->name('show.areas');
        Route::get('/panel/parametrizacion/areas/agregar', [AreasPanelController::class, 'AreasAgregar']);
        Route::post('/panel/parametrizacion/areas/agregardb', [AreasPanelController::class, 'AreasAgregarDB']);
        Route::get('/panel/parametrizacion/areas/modificar/{id}', [AreasPanelController::class, 'AreasModificar'])->where('id', '[0-9]+');
        Route::post('/panel/parametrizacion/areas/modificardb', [AreasPanelController::class, 'AreasModificarDB']);
        Route::get('/panel/parametrizacion/areassiesa', [AreasPanelController::class, 'AreasCreate'])->name('areas.siesa');

        /* Rutas panel cargos */
        Route::get('/panel/parametrizacion/cargos', [CargosPanelController::class, 'showCargos'])->name('show.cargos');
        Route::get('/panel/parametrizacion/cargos/agregar', [CargosPanelController::class, 'CargosAgregar']);
        Route::post('/panel/parametrizacion/cargos/agregardb', [CargosPanelController::class, 'CargosAgregarDB']);
        Route::get('/panel/parametrizacion/cargos/modificar/{id}', [CargosPanelController::class, 'CargosModificar'])->where('id', '[0-9]+');
        Route::post('/panel/parametrizacion/cargos/modificardb', [CargosPanelController::class, 'CargosModificarDB']);
        Route::get('/panel/parametrizacion/cargossiesa', [CargosPanelController::class, 'CargosCreate'])->name('cargos.siesa');

        /* Rutas panel ciudades */
        Route::get('/panel/parametrizacion/ciudades', [CiudadesPanelController::class, 'showCiudades']);
        Route::get('/panel/parametrizacion/ciudades/agregar', [CiudadesPanelController::class, 'CiudadesAgregar']);
        Route::post('/panel/parametrizacion/ciudades/agregardb', [CiudadesPanelController::class, 'CiudadesAgregarDB']);
        Route::get('/panel/parametrizacion/ciudades/modificar/{id}', [CiudadesPanelController::class, 'CiudadesModificar'])->where('id', '[0-9]+');
        Route::post('/panel/parametrizacion/ciudades/modificardb', [CiudadesPanelController::class, 'CiudadesModificarDB']);

        /* Rutas panel centros de operación */
        Route::get('/panel/parametrizacion/centrosop', [CentrosOpPanelController::class, 'showCentrosOp'])->name('show.centros');
        Route::get('/panel/parametrizacion/centrosop/agregar', [CentrosOpPanelController::class, 'CentrosOpAgregar']);
        Route::post('/panel/parametrizacion/centrosop/agregardb', [CentrosOpPanelController::class, 'CentrosOpAgregarDB']);
        Route::get('/panel/parametrizacion/centrosop/modificar/{id}', [CentrosOpPanelController::class, 'CentrosOpModificar'])->where('id', '[0-9]+');
        Route::post('/panel/parametrizacion/centrosop/modificardb', [CentrosOpPanelController::class, 'CentrosOpModificarDB']);
        Route::get('/panel/parametrizacion/centrosopsiesa', [CentrosOpPanelController::class, 'CentrosOpCreate'])->name('centros.siesa');

        /* Rutas Panel Empleados */
        Route::get('/panel/parametrizacion/empleados', [EmpleadosPanelController::class, 'showEmpleados'])->name('show.empleados');
        Route::get('/panel/parametrizacion/empleados/agregar', [EmpleadosPanelController::class, 'EmpleadosAgregar']);
        Route::post('/panel/parametrizacion/empleados/agregardb', [EmpleadosPanelController::class, 'EmpleadosAgregarDB'])->name('agregarEmpleado');
        Route::get('/panel/parametrizacion/empleados/modificar/{id}', [EmpleadosPanelController::class, 'EmpleadosModificar'])->where('id', '[0-9]+');
        Route::post('/panel/parametrizacion/empleados/modificardb', [EmpleadosPanelController::class, 'EmpleadosModificarDB'])->name('empleadoModificarDB');
        Route::get('/panel/parametrizacion/empleadosupd', [EmpleadosPanelController::class, 'EmpleadosUpd']);
        Route::get('/panel/parametrizacion/empleadosiesa', [EmpleadosPanelController::class, 'EmpleadosCreate'])->name('empleados.siesa');
        Route::get('/panel/parametrizacion/empleadoinasiesa', [EmpleadosPanelController::class, 'EmpleadosStatus'])->name('empleadosina.siesa');
        Route::get('/panel/parametrizacion/empleadoupdsiesa', [EmpleadosPanelController::class, 'EmpleadoUpdate'])->name('empleadosUpd.siesa');
        Route::post('/panel/parametrizacion/updatemisdatosemp', [EmpleadosPanelController::class, 'updateDataEmpleadoDB'])->name('updateDataEmpleadoDB');

        /* Rutas Panel Usuarios */
        Route::get('/panel/parametrizacion/usuarios', [UsuariosPanelController::class, 'showUsuarios']);
        Route::get('/panel/parametrizacion/usuarios/agregar', [UsuariosPanelController::class, 'UsuariosAgregar']);
        Route::post('/panel/parametrizacion/usuarios/agregardb', [UsuariosPanelController::class, 'UsuariosAgregarDB']);
        Route::get('/panel/parametrizacion/usuarios/modificar/{id}', [UsuariosPanelController::class, 'UsuariosModificar'])->where('id', '[0-9]+');
        Route::post('/panel/parametrizacion/usuarios/modificardb', [UsuariosPanelController::class, 'UsuariosModificarDB']);
        Route::post('/panel/parametrizacion/usuarios/modificarpassdb', [UsuariosPanelController::class, 'UsuariosModificarPassDB']);
        Route::post('/panel/parametrizacion/usuarios/modificaraccesosdb', [UsuariosPanelController::class, 'UsuariosModificarAccesosDB']);

        /* Rutas Panel Sincronizar usuarios con Siesa */
        Route::get('/panel/parametrizacion/sincronizar', [SincronizarPanelController::class, 'UsuariosSiesa']);
        Route::get('/panel/parametrizacion/sincronizar/agregar/{id}', [SincronizarPanelController::class, 'UsuariosAgregar'])->where('id', '[0-9]+');
        Route::post('/panel/parametrizacion/sincronizar/agregardb', [SincronizarPanelController::class, 'UsuariosAgregarDB']);
        Route::get('/panel/parametrizacion/sincronizar/agregarusr/{id}', [SincronizarPanelController::class, 'UsuariosNvAgregar'])->where('id', '[0-9]+');
        Route::post('/panel/parametrizacion/sincronizar/agregarusrdb', [SincronizarPanelController::class, 'UsuariosNvAgregarDB']);
        Route::post('/panel/parametrizacion/sincronizar/inactivardb', [SincronizarPanelController::class, 'UsuariosInactivarDB']);
        Route::post('/panel/parametrizacion/sincronizar/activardb', [SincronizarPanelController::class, 'UsuariosActivarDB']);

        /* Rutas Panel Procesos */
        Route::get('/panel/procesos/procesos', [ProcesosPanelController::class, 'listadoProcesos']);
        Route::get('/panel/procesos/procesos/modificar/{id}', [ProcesosPanelController::class, 'ProcesosModificar'])->where('id', '[0-9]+');
        Route::post('/panel/procesos/procesos/modificardb', [ProcesosPanelController::class, 'ProcesosModificarDB']);

        /* Rutas Panel Procesos/Cadena de valor */
        Route::get('/panel/procesos/cadena', [CadenaProcesosPanelController::class, 'ImagenCadena']);
        Route::get('/panel/procesos/cadena/detalla/{id}', [CadenaProcesosPanelController::class, 'CadenaDetalla'])->where('id', '[0-9]+');
        Route::get('/panel/procesos/cadena/consulta', [CadenaProcesosPanelController::class, 'CadenaConsulta']);
        Route::get('/panel/procesos/consulta', [CadenaProcesosPanelController::class, 'Consulta']);
        Route::get('/panel/procesos/consulta/detalle', [CadenaProcesosPanelController::class, 'ConsultaDetalle']);

        /* Rutas Panel Procesos/SubProcesos */
        Route::get('/panel/procesos/subprocesos/agregar/{id}', [SubProcesosPanelController::class, 'SubProcesosAgregar'])->where('id', '[0-9]+');
        Route::post('/panel/procesos/subprocesos/agregardb', [SubProcesosPanelController::class, 'SubProcesosAgregarDB']);
        Route::get('/panel/procesos/subprocesos/modificar/{id}', [SubProcesosPanelController::class, 'SubProcesosModificar'])->where('id', '[0-9]+');
        Route::post('/panel/procesos/subprocesos/modificardb', [SubProcesosPanelController::class, 'SubProcesosModificarDB']);
        Route::post('/panel/procesos/subprocesos/eliminardb', [SubProcesosPanelController::class, 'SubProcesosEliminarDB']);

        /* Rutas Panel Procesos/Documentos */
        Route::get('/panel/procesos/documentos', [DocProcesosPanelController::class, 'listadoDocumentos']);
        Route::get('/panel/procesos/documentos/agregar', [DocProcesosPanelController::class, 'DocumentosAgregar']);
        Route::post('/panel/procesos/documentos/agregardb', [DocProcesosPanelController::class, 'DocumentosAgregarDB']);
        Route::get('/panel/procesos/documentos/modificar/{id}', [DocProcesosPanelController::class, 'DocumentosModificar'])->where('id', '[0-9]+');
        Route::post('/panel/procesos/documentos/modificardb', [DocProcesosPanelController::class, 'DocumentosModificarDB']);
        Route::post('/panel/procesos/documentos/eliminardb', [DocProcesosPanelController::class, 'DocumentosEliminarDB']);

        /* Rutas Panel Procesos/Subprocesos - Documentos */
        Route::get('/panel/procesos/subprodocume', [SubDocProcesosPanelController::class, 'SubProDocumeListado']);
        Route::get('/panel/procesos/subprodocume/asociar/{id}', [SubDocProcesosPanelController::class, 'SubProDocumeAsociar'])->where('id', '[0-9]+');
        Route::post('/panel/procesos/subprodocume/asociardb', [SubDocProcesosPanelController::class, 'SubProDocumeAsociarDB']);
        Route::post('/panel/procesos/subprodocume/desasociardb', [SubDocProcesosPanelController::class, 'SubProDocumeDesasociarDB']);

        /* Rutas Panel Procesos/Documentos - Subprocesos */
        Route::get('/panel/procesos/documesubpro', [DocSubProcesosPanelController::class, 'DocumeSubProListado']);
        Route::get('/panel/procesos/documesubpro/asociar/{id}', [DocSubProcesosPanelController::class, 'DocumeSubProAsociar'])->where('id', '[0-9]+');
        Route::post('/panel/procesos/documesubpro/asociardb', [DocSubProcesosPanelController::class, 'DocumeSubProAsociarDB']);

        /* Rutas Panel Procesos/Perfiles */
        Route::get('/panel/procesos/perfiles', [PerfilesProcesosPanelController::class, 'listadoPerfiles']);
        Route::get('/panel/procesos/perfiles/agregar', [PerfilesProcesosPanelController::class, 'PerfilesAgregar']);
        Route::post('/panel/procesos/perfiles/agregardb', [PerfilesProcesosPanelController::class, 'PerfilesAgregarDB']);
        Route::get('/panel/procesos/perfiles/modificar/{id}', [PerfilesProcesosPanelController::class, 'PerfilesModificar'])->where('id', '[0-9]+');
        Route::post('/panel/procesos/perfiles/modificardb', [PerfilesProcesosPanelController::class, 'PerfilesModificarDB']);
        Route::post('/panel/procesos/perfiles/eliminardb', [PerfilesProcesosPanelController::class, 'PerfilesEliminarDB']);
        Route::get('/panel/procesos/perfiles/agregarusr/{id}', [PerfilesProcesosPanelController::class, 'PerfilesAgregarUsr'])->where('id', '[0-9]+');
        Route::post('/panel/procesos/perfiles/agregarusrdb', [PerfilesProcesosPanelController::class, 'PerfilesAgregarUsrDB']);
        Route::post('/panel/procesos/perfiles/eliminarusrdb', [PerfilesProcesosPanelController::class, 'PerfilesRetirarUsrDB']);

        /* Rutas Panel Procesos/Documentos - Perfiles */
        Route::get('/panel/procesos/documeperfil/agregar/{id}', [DocPerProcesosPanelController::class, 'DocumePerfilAgregar'])->where('id', '[0-9]+');
        Route::post('/panel/procesos/documeperfil/agregardb', [DocPerProcesosPanelController::class, 'DocumePerfilAgregarDB']);
        Route::post('/panel/procesos/documeperfil/agregardb', [DocPerProcesosPanelController::class, 'DocumenPerfilUsuarioAgregarDB'])->name('documento.perfil');
        Route::post('/panel/procesos/documeperfil/eliminardb', [DocPerProcesosPanelController::class, 'DocumePerfilEliminarDB']);

        /* Rutas Panel Archivos Planos */
        Route::get('/panel/archivo-plano/lista/{tipo}', [ArchivoPlanoPanelController::class, 'listadoArchivoPlano'])->where('tipo', '[0-9]+');
        Route::get('/panel/archivo-plano/agregar', [ArchivoPlanoPanelController::class, 'ArchivoPlanoAgregar']);
        Route::post('/panel/archivo-plano/agregardb', [ArchivoPlanoPanelController::class, 'ArchivoPlanoAgregarDB']);
        Route::get('/panel/archivo-plano/modificar/{id}', [ArchivoPlanoPanelController::class, 'ArchivoPlanoEditar'])->where('id', '[0-9]+');
        Route::get('/panel/archivo-plano/duplicar/{id}', [ArchivoPlanoPanelController::class, 'ArchivoPlanoEditar'])->where('id', '[0-9]+');
        Route::post('/panel/archivo-plano/modificardb', [ArchivoPlanoPanelController::class, 'ArchivoPlanoModificarDB']);
        Route::post('/panel/archivo-plano/eliminardb', [ArchivoPlanoPanelController::class, 'ArchivoPlanoEliminarDB']);
        Route::post('/panel/archivo-plano/generar-archivo', [ArchivoPlanoPanelController::class, 'GenerarArchivo']);

        /* Rutas Panel Procesos/Tipo de documentos */
        Route::get('/panel/procesos/tiposdocumentos', [TipoDocProcesosPanelController::class, 'listadoTiposDocumentos']);
        Route::get('/panel/procesos/tiposdocumentos/agregar', [TipoDocProcesosPanelController::class, 'TiposDocumentosAgregar']);
        Route::post('/panel/procesos/tiposdocumentos/agregardb', [TipoDocProcesosPanelController::class, 'TiposDocumentosAgregarDB']);
        Route::get('/panel/procesos/tiposdocumentos/modificar/{id}', [TipoDocProcesosPanelController::class, 'TiposDocumentosModificar'])->where('id', '[0-9]+');
        Route::post('/panel/procesos/tiposdocumentos/modificardb', [TipoDocProcesosPanelController::class, 'TiposDocumentosModificarDB']);
        Route::post('/panel/procesos/tiposdocumentos/eliminardb', [TipoDocProcesosPanelController::class, 'TiposDocumentosEliminarDB']);

        /* Ruta Panel Procesos/compartir archivos */
        Route::get('/panel/procesos/compartir', [CompartirArchProcesosPanelController::class, 'showAllProcesos']);
        Route::post('/panel/procesos/compartir/macroproceso', [CompartirArchProcesosPanelController::class, 'asociarDocMacroProceso'])->name('asociarDocMacroProceso');
        Route::post('/panel/procesos/compartir/proceso', [CompartirArchProcesosPanelController::class, 'asociarDocProceso'])->name('asociarDocProceso');
        Route::post('/panel/procesos/compartir/subproceso', [CompartirArchProcesosPanelController::class, 'asociarDocSubProceso'])->name('asociarDocSubProceso');

        /* Rutas Panel Requerimientos/Grupos */
        Route::get('/panel/requerimientos/grupos', [GruposRequerimientosPanelController::class, 'GruposListado']);
        Route::get('/panel/requerimientos/grupos/agregar', [GruposRequerimientosPanelController::class, 'GruposAgregar']);
        Route::post('/panel/requerimientos/grupos/agregardb', [GruposRequerimientosPanelController::class, 'GruposAgregarDB']);
        Route::get('/panel/requerimientos/grupos/modificar/{id}', [GruposRequerimientosPanelController::class, 'GruposModificar'])->where('id', '[0-9]+');
        Route::post('/panel/requerimientos/grupos/modificardb', [GruposRequerimientosPanelController::class, 'GruposModificarDB']);

        /* Rutas Panel Requerimientos/Grupos - Empleados */
        Route::get('/panel/requerimientos/empleados/asociar/{id}', [GruposRequerimientosPanelController::class, 'EmpleadosGruposAsociar'])->where('id', '[0-9]+');
        Route::post('/panel/requerimientos/empleados/asociardb', [GruposRequerimientosPanelController::class, 'EmpleadosGruposAsociarDB']);
        Route::post('/panel/requerimientos/empleados/desasociardb', [GruposRequerimientosPanelController::class, 'EmpleadosGruposDesasociarDB']);

        /* Rutas Panel Requerimientos/Priorización */
        Route::get('/panel/requerimientos/priorizacion', [PriorizacionRequerimientosPanelController::class, 'PriorizacionListado']);
        Route::post('/panel/requerimientos/priorizacion/modificardb', [PriorizacionRequerimientosPanelController::class, 'PriorizacionModificarDB']);

        /* Rutas Panel Requerimientos/Categorias */
        Route::get('/panel/requerimientos/categorias', [CategoriasRequerimientosPanelController::class, 'CategoriasSeleccion']);
        Route::get('/panel/requerimientos/categorias/listado/{id}', [CategoriasRequerimientosPanelController::class, 'CategoriasListado'])->where('id', '[0-9]+');
        Route::get('/panel/requerimientos/categorias/agregar/{id}', [CategoriasRequerimientosPanelController::class, 'CategoriasAgregar'])->where('id', '[0-9]+');
        Route::post('/panel/requerimientos/categorias/agregardb', [CategoriasRequerimientosPanelController::class, 'CategoriasAgregarDB']);
        Route::get('/panel/requerimientos/categorias/modificar/{id}', [CategoriasRequerimientosPanelController::class, 'CategoriasModificar'])->where('id', '[0-9]+');
        Route::post('/panel/requerimientos/categorias/modificardb', [CategoriasRequerimientosPanelController::class, 'CategoriasModificarDB']);

        /* Requerimientos Categoría */
        Route::get('/panel/requerimientos/atender/listado-categoria/{id}/{categoria}', [AtenderRequerimientosPanelController::class, 'AtenderListadoCategoria'])->where('id', '[0-9]+')->where('categoria', '[0-9]+');
        Route::get('/panel/requerimientos/atender/listado-categoria-notificado/{id}/{categoria}', [AtenderRequerimientosPanelController::class, 'AtenderListadoCategoriaNotificado'])->where('id', '[0-9]+')->where('categoria', '[0-9]+');

        /* Rutas Panel Requerimientos/Mis requerimientos */
        Route::get('/panel/requerimientos/misrequerimientos', [MisRequerimientosPanelController::class, 'MisRequerimientos']);
        Route::get('/panel/requerimientos/misrequerimientos/encuesta', [MisRequerimientosPanelController::class, 'MisRequerimientos']);
        Route::post('/panel/requerimientos/misrequerimientos/encuestadb', [MisRequerimientosPanelController::class, 'EncuestaDB']);
        Route::post('/panel/requerimientos/misrequerimientos/agregardb', [MisRequerimientosPanelController::class, 'SolicitudAgregarDB']);
        Route::get('/panel/requerimientos/misrequerimientos/masinfo/{id}', [MisRequerimientosPanelController::class, 'MisRequerimientosMasinfo'])->where('id', '[0-9]+');
        Route::post('/panel/requerimientos/misrequerimientos/agregarinfodb', [MisRequerimientosPanelController::class, 'InformacionAgregarDB']);

        /* Rutas Panel Requerimientos/Atender */
        Route::get('/panel/requerimientos/atender', [AtenderRequerimientosPanelController::class, 'Atender']);
        Route::get('/panel/requerimientos/atender/listado/{id}', [AtenderRequerimientosPanelController::class, 'AtenderListado'])->where('id', '[0-9]+');
        Route::get('/panel/requerimientos/atender/listado-notificado/{id}', [AtenderRequerimientosPanelController::class, 'AtenderListadoNotificado'])->where('id', '[0-9]+');
        Route::get('/panel/requerimientos/atender/listado-todos/{id}', [AtenderRequerimientosPanelController::class, 'AtenderListadoTodos'])->where('id', '[0-9]+');
        Route::get('/panel/requerimientos/atender/procesar/{id}', [AtenderRequerimientosPanelController::class, 'AtenderProcesar'])->where('id', '[0-9]+');
        Route::post('/panel/requerimientos/atender/trasladardb', [AtenderRequerimientosPanelController::class, 'AtenderTrasladarDB']);
        Route::post('/panel/requerimientos/atender/asignardb', [AtenderRequerimientosPanelController::class, 'AtenderAsignarDB']);
        Route::post('/panel/requerimientos/atender/cerrardb', [AtenderRequerimientosPanelController::class, 'AtenderCerrarDB']);
        Route::post('/panel/requerimientos/atender/cerrar-notificacion', [AtenderRequerimientosPanelController::class, 'AtenderCerrarNotificacion']);
        Route::post('/panel/requerimientos/atender/rechazar-notificacion', [AtenderRequerimientosPanelController::class, 'RechazarCerrarNotificacion']);

        /* 19/02/2024 NUEVAS FUNCIONES - JULIAN CARMONA */
        /* Requerimientos Filtros */
        Route::get('/panel/requerimientos/atender/listado-persona/{id}/{idus}', [AtenderRequerimientosPanelController::class, 'AtenderListadoPersona'])->where('id', '[0-9]+')->where('idus', '[0-9]+');
        Route::get('/panel/requerimientos/atender/listado-persona-notificado/{id}/{idus}', [AtenderRequerimientosPanelController::class, 'AtenderListadoPersonaNotificado'])->where('id', '[0-9]+')->where('idus', '[0-9]+');
        Route::get('/panel/requerimientos/atender/listado-persona-todos/{id}/{idus}', [AtenderRequerimientosPanelController::class, 'AtenderListadoPersonaTodos'])->where('id', '[0-9]+')->where('idus', '[0-9]+');
        /* Rutas Panel Requerimientos/Crear caso */
        Route::get('/panel/requerimientos/crearcaso', [CrearRequerimientosPanelController::class, 'CrearCaso']);
        Route::post('/panel/requerimientos/crearcaso/seleccionar', [CrearRequerimientosPanelController::class, 'CrearCasoSeleccionar']);
        Route::post('/panel/requerimientos/crearcaso/agregar', [CrearRequerimientosPanelController::class, 'CrearCasoAgregar']);
        Route::post('/panel/requerimientos/crearcaso/agregardb', [CrearRequerimientosPanelController::class, 'CrearCasoAgregarDB']);

        /* Rutas Panel Requerimientos/Consultas */
        Route::get('/panel/requerimientos/consultausr', [ConsultasRequerimientosPanelController::class, 'ConsultaUsuario']);
        Route::post('/panel/requerimientos/consultausr/listado', [ConsultasRequerimientosPanelController::class, 'ConsultaUsrListado']);
        Route::get('/panel/requerimientos/consultausr/masinfo/{id}', [ConsultasRequerimientosPanelController::class, 'ConsultaUsrMasinfo'])->where('id', '[0-9]+');
        Route::get('/panel/requerimientos/consultausr/masinfo1/{id}', [ConsultasRequerimientosPanelController::class, 'ConsultaUsrMasinfo1'])->where('id', '[0-9]+');
        Route::get('/panel/requerimientos/consultagru', [ConsultasRequerimientosPanelController::class, 'ConsultaGrupo']);
        Route::get('/panel/requerimientos/consultagru/formulario/{id}', [ConsultasRequerimientosPanelController::class, 'ConsultaGruFormulario'])->where('id', '[0-9]+');
        Route::post('/panel/requerimientos/consultagru/listado', [ConsultasRequerimientosPanelController::class, 'ConsultaGruListado']);
        Route::get('/panel/requerimientos/consultagru/masinfo/{id}', [ConsultasRequerimientosPanelController::class, 'ConsultaGruMasinfo'])->where('id', '[0-9]+');

        /* Rutas Panel Requerimientos/Informe */
        Route::get('/panel/requerimientos/informe', [InformeRequerimientosPanelController::class, 'Informe']);
        Route::post('/panel/requerimientos/informe/detalle', [InformeRequerimientosPanelController::class, 'InformeDetalle']);
        Route::post('/panel/requerimientos/informe/encuesta', [InformeRequerimientosPanelController::class, 'InformeEncuesta']);
        Route::post('/panel/requerimientos/informe/reintegro', [InformeRequerimientosPanelController::class, 'InformeReintegro']);
        Route::post('/panel/requerimientos/informe/tiempos', [InformeRequerimientosPanelController::class, 'InformeTiempos']);
        Route::post('/panel/requerimientos/informe/meses', [InformeRequerimientosPanelController::class, 'InformeMeses']);

        /* Rutas Panel Requerimientos/Reintegro */
        Route::get('/panel/requerimientos/reintegro', [ReintegroRequerimientosPanelController::class, 'Reintegro']);
        Route::get('/panel/requerimientos/reintegro/listado/{id}', [ReintegroRequerimientosPanelController::class, 'ReintegroListado'])->where('id', '[0-9]+');
        Route::get('/panel/requerimientos/reintegro/finalizar/{id}', [ReintegroRequerimientosPanelController::class, 'ReintegroFinalizar'])->where('id', '[0-9]+');
        Route::post('/panel/requerimientos/reintegro/finalizardb', [ReintegroRequerimientosPanelController::class, 'ReintegroFinalizarDB']);

        /* Rutas Panel Requerimientos Vencidos */
        Route::post('/panel/requerimientos/cerrar-vencidos', [AtenderRequerimientosPanelController::class, 'CerrarRequerimientosVencidos']);

        /* Rutas Panel Requerimientos/Elementos */
        Route::get('/panel/requerimientos/elementos', [ElementosRequisicionesPanelController::class, 'SolicitudElementos'])->name('SolicitudElementos');
        Route::get('/panel/requerimientos/elementos/area', [ElementosRequisicionesPanelController::class, 'SolicitudesElementosArea'])->name('SolicitudesElementosArea');
        Route::get('/panel/requerimientos/elementos/solicitud/{id}', [ElementosRequisicionesPanelController::class, 'SolicitudElementosInfo'])->name('SolicitudElementosInfo');
        Route::post('/panel/requerimientos/elementos/solicitud/gestionarTic', [ElementosRequisicionesPanelController::class, 'gestionarSolicitudTicElementos'])->name('gestionarSolicitudTicElementos');
        Route::post('/panel/requerimientos/elementos/solicitud/gestionarSop', [ElementosRequisicionesPanelController::class, 'gestionarSolicitudSopElementos'])->name('gestionarSolicitudSopElementos');


        /* Rutas Panel Requisiciones/Solicitudes */
        Route::get('/panel/requisiciones/solicitud', [SolRequisicionesPanelController::class, 'Solicitud']);
        Route::post('/panel/requisiciones/solicitud/agregardb', [SolRequisicionesPanelController::class, 'SolicitudAgregarDB'])->name('agregarSolicitud');
        Route::get('/panel/requisiciones/solicitud/masinfo/{id}', [SolRequisicionesPanelController::class, 'SolicitudMasinfo'])->where('id', '[0-9]+');
        Route::get('/panel/requisiciones/solicitud/migrarinfo', [SolRequisicionesPanelController::class, 'migrarInfo']);
        Route::post('/panel/requisiciones/solicitudes/descargar', [SolRequisicionesPanelController::class, 'exportarSolicitudes'])->name('exportarSolicitudes');

        /* Rutas Panel Requisiciones/Nomina */
        Route::get('/panel/requisiciones/nomina', [SolRequisicionesPanelController::class, 'Nomina']);
        Route::get('/panel/requisiciones/nomina/autorizar/{id}', [SolRequisicionesPanelController::class, 'NominaAutorizar'])->where('id', '[0-9]+');
        Route::post('/panel/requisiciones/nomina/autorizardb', [SolRequisicionesPanelController::class, 'NominaAutorizarDB']);
        Route::post('/panel/requisiciones/nomina/rechazardb', [SolRequisicionesPanelController::class, 'NominaRechazarDB']);
        Route::post('/panel/requisiciones/nomina/gestionar/niveles_cargos', [SolRequisicionesPanelController::class, 'gestionarNivelesCargos'])->name('gestionarNivelesCargos');
        Route::post('/panel/requisiciones/nomina/actualizarEstado', [SolRequisicionesPanelController::class, 'actualizarEstadoSoli'])->name('actualizarEstadoSoli');
        Route::post('/panel/requisiciones/nomina/novedades', [SolRequisicionesPanelController::class, 'enviarNovedad'])->name('enviarNovedad');
        Route::post('/panel/requisiciones/nomina/examenes', [SolRequisicionesPanelController::class, 'crearExamenesIngresos'])->name('crearExamenesIngresos');
        Route::post('/panel/requisiciones/tallas/dotacion', [SolRequisicionesPanelController::class, 'getTallasDotacion'])->name('getTallasDotacion');
        Route::post('/panel/requisiciones/pedirDotaciones', [SolRequisicionesPanelController::class, 'pedirDotaciones'])->name('pedirDotaciones');

        /* Rutas Panel Requisiciones/Gerencia */
        Route::get('/panel/requisiciones/gerencia', [SolRequisicionesPanelController::class, 'Gerencia']);
        Route::get('/panel/requisiciones/gerencia/autorizar/{id}', [SolRequisicionesPanelController::class, 'GerenciaAutorizar'])->where('id', '[0-9]+');
        Route::post('/panel/requisiciones/gerencia/autorizardb', [SolRequisicionesPanelController::class, 'GerenciaAutorizarDB']);

        /* Rutas Panel Requisiciones/Hojas de vida */
        Route::get('/panel/requisiciones/hv', [SolRequisicionesPanelController::class, 'Hv']);
        Route::get('/panel/requisiciones/hv/adjuntar/{id}', [SolRequisicionesPanelController::class, 'HvAdjuntar'])->where('id', '[0-9]+');
        Route::post('/panel/requisiciones/hv/adjuntardb', [SolRequisicionesPanelController::class, 'HvAdjuntarDB']);
        Route::get('/panel/requisiciones/hv/masinfo/{id}', [SolRequisicionesPanelController::class, 'HvMasinfo'])->where('id', '[0-9]+');
        Route::get('/panel/requisiciones/hv/horario/{id}', [SolRequisicionesPanelController::class, 'HvHorario'])->where('id', '[0-9]+');
        Route::post('/panel/requisiciones/hv/horariodb', [SolRequisicionesPanelController::class, 'HvHorarioDB']);

        /* Rutas Panel Requisiciones/Entrevistas */
        Route::get('/panel/requisiciones/entrevistas', [SolRequisicionesPanelController::class, 'Entrevista']);
        Route::get('/panel/requisiciones/entrevistas/procesar/{id}', [SolRequisicionesPanelController::class, 'EntrevistaProcesar'])->where('id', '[0-9]+');
        Route::post('/panel/requisiciones/entrevistas/procesardb', [SolRequisicionesPanelController::class, 'EntrevistaProcesarDB']);

        /* Rutas Panel Requisiciones/Contratación */
        Route::get('/panel/requisiciones/contratacion', [SolRequisicionesPanelController::class, 'Contratacion']);
        Route::get('/panel/requisiciones/contratacion/procesar/{id}', [SolRequisicionesPanelController::class, 'ContratacionProcesar'])->where('id', '[0-9]+');
        Route::post('/panel/requisiciones/contratacion/procesardb', [SolRequisicionesPanelController::class, 'ContratacionProcesarDB']);

        /* Rutas Panel Requisiciones/Cancelación */
        Route::get('/panel/requisiciones/cancelacion', [SolRequisicionesPanelController::class, 'Cancelacion']);
        Route::post('/panel/requisiciones/cancelacion/detalle', [SolRequisicionesPanelController::class, 'CancelacionDetalle']);
        Route::post('/panel/requisiciones/cancelacion/procesardb', [SolRequisicionesPanelController::class, 'CancelacionProcesarDB']);

        /* Rutas Panel Requisiciones/Consultas */
        Route::get('/panel/requisiciones/consultausr', [ConsultasRequisicionesPanelController::class, 'ConsultaUsuario']);
        Route::post('/panel/requisiciones/consultausr/listado', [ConsultasRequisicionesPanelController::class, 'ConsultaUsrListado']);
        Route::get('/panel/requisiciones/consultausr/masinfo/{id}', [ConsultasRequisicionesPanelController::class, 'ConsultaUsrMasinfo'])->where('id', '[0-9]+');
        Route::get('/panel/requisiciones/consultaadm', [ConsultasRequisicionesPanelController::class, 'ConsultaAdm']);
        Route::get('/panel/requisiciones/consultaadm/listado', [ConsultasRequisicionesPanelController::class, 'ConsultaAdmListado']);
        Route::get('/panel/requisiciones/consultaadm/masinfo/{id}', [ConsultasRequisicionesPanelController::class, 'ConsultaAdmMasinfo'])->where('id', '[0-9]+');

        /* Rutas Panel Requisiciones/Informe */
        Route::get('/panel/requisiciones/informe', [InformeRequisicionesPanelController::class, 'Informe']);
        Route::post('/panel/requisiciones/informe/detalle', [InformeRequisicionesPanelController::class, 'InformeDetalle']);

        /* Rutas Panel Requisiones/permisos autorización */

        Route::get('/panel/requisiciones/permisos', [GestionarPermisosRequisicionesPanelController::class, 'MostrarGestionPermisos']);
        Route::post('/panel/requisiciones/permisos/gestionar', [GestionarPermisosRequisicionesPanelController::class, 'GestionarPermisosAutorizar'])->name('GestionarPermisosAutorizar');


        /* Rutas Panel Requisiciones/Parametrizacion*/
        Route::get('/panel/requisiciones/parametrizacion', [ParametrizacionPanelController::class, 'mostrarParametrizacion']);
        Route::post('/panel/requisiciones/parametrizacion/agregardb/motivos', [ParametrizacionPanelController::class, 'motivosAgregarDB'])->name('motivosAgregarDB');
        Route::post('/panel/requisiciones/parametrizacion/updatedb/motivos', [ParametrizacionPanelController::class, 'motivosUpdateDB'])->name('motivosUpdateDB');
        Route::post('/panel/requisiciones/parametrizacion/agregardb/tpcontratos', [ParametrizacionPanelController::class, 'tpContratoAgregarDB'])->name('tpContratoAgregarDB');
        Route::post('/panel/requisiciones/parametrizacion/updatedb/tpcontratos', [ParametrizacionPanelController::class, 'tpContratoUpdateDB'])->name('tpContratoUpdateDB');
        Route::post('/panel/requisiciones/parametrizacion/agregardb/activos', [ParametrizacionPanelController::class, 'herramientasAgregarDB'])->name('herramientasAgregarDB');
        Route::post('/panel/requisiciones/parametrizacion/updatedb/activos', [ParametrizacionPanelController::class, 'herramientasUpdateDB'])->name('herramientasUpdateDB');
        Route::post('/panel/requisiciones/parametrizacion/agregardb/dotaciones', [ParametrizacionPanelController::class, 'dotacionesAgregarDB'])->name('dotacionesAgregarDB');
        Route::post('/panel/requisiciones/parametrizacion/updatedb/dotaciones', [ParametrizacionPanelController::class, 'dotacionesUpdateDB'])->name('dotacionesUpdateDB');
        Route::post('/panel/requisiciones/parametrizacion/agregardb/tallas', [ParametrizacionPanelController::class, 'tallasAgregarDB'])->name('tallasAgregarDB');
        Route::post('/panel/requisiciones/parametrizacion/updatedb/tallas', [ParametrizacionPanelController::class, 'tallasUpdateDB'])->name('tallasUpdateDB');

        /* Rutas panel Requisiones/Gestion de ingresos */
        Route::get('/panel/requisiciones/gestion/ingresos', [GestionIngresosPanelController::class, 'mostrarVistaIngresos']);
        Route::get('/panel/requisiciones/gestion/ingresos/datos', [GestionIngresosPanelController::class, 'obtenerDatosIngresos']);
        Route::get('/panel/requisiciones/gestion/ingresos/examenes', [GestionIngresosPanelController::class, 'obtenerExamenesIngresos']);
        Route::post('/panel/requisiciones/gestion/ingresos/detalle', [GestionIngresosPanelController::class, 'obtenerIngresoDetalle']);
        Route::post('/panel/requisiciones/gestion/ingresos/gestionar', [GestionIngresosPanelController::class, 'gestionarIngreso'])->name('gestionarIngreso');

        /* Rutas Panel Procesos disciplinarios/Tipos de faltas */
        Route::get('/panel/disciplinarios/tipofaltas', [TipofaltasDisciplinariosPanelController::class, 'Tipofaltas']);
        Route::get('/panel/disciplinarios/tipofaltas/agregar', [TipofaltasDisciplinariosPanelController::class, 'TipofaltasAgregar']);
        Route::post('/panel/disciplinarios/tipofaltas/agregardb', [TipofaltasDisciplinariosPanelController::class, 'TipofaltasAgregarDB']);
        Route::get('/panel/disciplinarios/tipofaltas/modificar/{id}', [TipofaltasDisciplinariosPanelController::class, 'TipofaltasModificar'])->where('id', '[0-9]+');
        Route::post('/panel/disciplinarios/tipofaltas/modificardb', [TipofaltasDisciplinariosPanelController::class, 'TipofaltasModificarDB']);

        /* Rutas Panel Procesos disciplinarios/Motivos de cierre */
        Route::get('/panel/disciplinarios/motivos', [MotivosDisciplinariosPanelController::class, 'Motivos']);
        Route::get('/panel/disciplinarios/motivos/agregar', [MotivosDisciplinariosPanelController::class, 'MotivosAgregar']);
        Route::post('/panel/disciplinarios/motivos/agregardb', [MotivosDisciplinariosPanelController::class, 'MotivosAgregarDB']);
        Route::get('/panel/disciplinarios/motivos/modificar/{id}', [MotivosDisciplinariosPanelController::class, 'MotivosModificar'])->where('id', '[0-9]+');
        Route::post('/panel/disciplinarios/motivos/modificardb', [MotivosDisciplinariosPanelController::class, 'MotivosModificarDB']);

        /* Rutas Panel Procesos disciplinarios/Solicitudes */
        Route::get('/panel/disciplinarios/solicitud', [SolicitudDisciplinariosPanelController::class, 'Solicitud']);
        Route::post('/panel/disciplinarios/solicitud', [SolicitudDisciplinariosPanelController::class, 'Solicitud']);
        Route::get('/panel/disciplinarios/solicitud/formulario/{id}', [SolicitudDisciplinariosPanelController::class, 'SolicitudFormulario'])->where('id', '[0-9]+');
        Route::post('/panel/disciplinarios/solicitud/agregardb', [SolicitudDisciplinariosPanelController::class, 'SolicitudAgregarDB']);
        Route::get('/panel/disciplinarios/solicitud/masinfo/{id}', [SolicitudDisciplinariosPanelController::class, 'SolicitudMasinfo'])->where('id', '[0-9]+');

        /* Rutas Panel Procesos disciplinarios/Atender */
        Route::get('/panel/disciplinarios/atender', [AtenderDisciplinariosPanelController::class, 'Atender']);
        Route::get('/panel/disciplinarios/atender/procesar/{id}', [AtenderDisciplinariosPanelController::class, 'AtenderProcesar'])->where('id', '[0-9]+');
        Route::post('/panel/disciplinarios/reclasificar', [AtenderDisciplinariosPanelController::class, 'ReclasificarDB']);
        Route::post('/panel/disciplinarios/atender/procesardb', [AtenderDisciplinariosPanelController::class, 'AtenderProcesarDB']);
        Route::get('/panel/disciplinarios/textos/{id}', [AtenderDisciplinariosPanelController::class, 'Textos'])->where('id', '[0-9]+');
        Route::post('/panel/disciplinarios/atender/colaborador', [AtenderDisciplinariosPanelController::class, 'AtenderEmpleado']);

        /* Rutas Panel Procesos disciplinarios/Consultas */
        Route::get('/panel/disciplinarios/consultausr', [ConsultasDisciplinariosPanelController::class, 'ConsultaUsuario']);
        Route::post('/panel/disciplinarios/consultausr/listado', [ConsultasDisciplinariosPanelController::class, 'ConsultaUsrListado']);
        Route::get('/panel/disciplinarios/consultausr/masinfo/{id}', [ConsultasDisciplinariosPanelController::class, 'ConsultaUsrMasinfo'])->where('id', '[0-9]+');
        Route::get('/panel/disciplinarios/consultaadm', [ConsultasDisciplinariosPanelController::class, 'ConsultaAdm']);
        Route::post('/panel/disciplinarios/consultaadm/listado', [ConsultasDisciplinariosPanelController::class, 'ConsultaAdmListado']);
        Route::get('/panel/disciplinarios/consultaadm/masinfo/{id}', [ConsultasDisciplinariosPanelController::class, 'ConsultaAdmMasinfo'])->where('id', '[0-9]+');

        /* Rutas Panel Procesos disciplinarios/Informe - Reportes*/
        Route::get('/panel/disciplinarios/informe', [ConsultasDisciplinariosPanelController::class, 'Informe']);
        Route::post('/panel/disciplinarios/informe/detalle', [ConsultasDisciplinariosPanelController::class, 'InformeDetalle']);
        Route::get('/panel/disciplinarios/reporteg', [ConsultasDisciplinariosPanelController::class, 'Reporteg']);
        Route::post('/panel/disciplinarios/reporteg/detalle', [ConsultasDisciplinariosPanelController::class, 'ReportegDetalle']);

        /* Rutas Panel Procesos disciplinarios/Borrar */
        Route::get('/panel/disciplinarios/borrar', [SolicitudDisciplinariosPanelController::class, 'Borrar']);
        Route::post('/panel/disciplinarios/borrar/detalle', [SolicitudDisciplinariosPanelController::class, 'BorrarDetalle']);
        Route::get('/panel/disciplinarios/borrar/detalleb/{id}', [SolicitudDisciplinariosPanelController::class, 'BorrarDetalleB'])->where('id', '[0-9]+');
        Route::post('/panel/disciplinarios/borrar/procesardb', [SolicitudDisciplinariosPanelController::class, 'BorrarProcesarDB']);

        /* Rutas Panel Bcloud /Solicitud actualizaciones, nuevos desarrollos */
        Route::get('/panel/bpack/solicitudan', [SolicitudANPanelController::class, 'SolicitudAN']);
        Route::post('/panel/bpack/solicitudan/solicitudANform', [SolicitudANPanelController::class, 'SolicitudANForm']);
        Route::post('/panel/bpack/solicitudan/solicitudANformdb', [SolicitudANPanelController::class, 'SolicitudANFormDB']);

        /* Rutas Panel Bcloud/Consultas */
        Route::get('/panel/bpack/consolicitudan', [ConsultasSolicitudesPanelController::class, 'Consulta']);
        Route::post('/panel/bpack/consolicitudan/listado', [ConsultasSolicitudesPanelController::class, 'ConsultaListado']);
        Route::get('/panel/bpack/consolicitudan/masinfo/{id}', [ConsultasSolicitudesPanelController::class, 'ConsultaListadoMasinfo'])->where('id', '[0-9]+');
        Route::get('/panel/bpack/otconsultas', [ConsultasSolicitudesPanelController::class, 'OtConsulta']);
        Route::post('/panel/bpack/otconsultas/listadosb', [ConsultasSolicitudesPanelController::class, 'ConsultaSB']);
        Route::post('/panel/bpack/otconsultas/listadosh', [ConsultasSolicitudesPanelController::class, 'ConsultaSh']);

        /* Rutas Panel Bcloud /Motivos de rechazo */
        Route::get('/panel/bpack/motivos', [MotivosBpackPanelController::class, 'Motivos']);
        Route::get('/panel/bpack/motivos/agregar', [MotivosBpackPanelController::class, 'MotivosAgregar']);
        Route::post('/panel/bpack/motivos/agregardb', [MotivosBpackPanelController::class, 'MotivosAgregarDB']);
        Route::get('/panel/bpack/motivos/modificar/{id}', [MotivosBpackPanelController::class, 'MotivosModificar'])->where('id', '[0-9]+');
        Route::post('/panel/bpack/motivos/modificardb', [MotivosBpackPanelController::class, 'MotivosModificarDB']);

        /* Rutas Panel Bcloud /Solicitudes pendientes de */
        Route::get('/panel/bpack/solpendientes', [PendientesPanelController::class, 'Pendientes']);

        /* Rutas Panel Bcloud /Pendiente de ruta */
        Route::get('/panel/bpack/penruta', [RutasPanelController::class, 'PendientesRuta']);
        Route::get('/panel/bpack/penruta/procesar/{id}', [RutasPanelController::class, 'PendientesRutaProcesar'])->where('id', '[0-9]+');
        Route::post('/panel/bpack/penruta/procesardb', [RutasPanelController::class, 'PendientesRutaProcesarDB']);
        Route::post('/panel/bpack/penruta/rechazardb', [RutasPanelController::class, 'RechazarDB']);

        /* Rutas Panel Bcloud /Correccion por rechazo en ruta */
        Route::get('/panel/bpack/correcruta/{id}', [CorreccionRechazoRutaPanelController::class, 'CorreccionRechazoRuta'])->where('id', '[0-9]+');
        Route::get('/panel/bpack/correcruta/procesar/{id}', [CorreccionRechazoRutaPanelController::class, 'CorreccionRechazoRutaProcesar'])->where('id', '[0-9]+');
        Route::post('/panel/bpack/correcruta/procesardb', [CorreccionRechazoRutaPanelController::class, 'CorreccionRechazoRutaProcesarDB']);

        /* Rutas Panel Bcloud /Pendiente de aprobación por preprensa */
        Route::get('/panel/bpack/penaprueba', [ApruebaPanelController::class, 'PendientesAprueba']);
        Route::get('/panel/bpack/penaprueba/procesar/{id}', [ApruebaPanelController::class, 'PendientesApruebaProcesar'])->where('id', '[0-9]+');
        Route::post('/panel/bpack/penaprueba/procesardb', [ApruebaPanelController::class, 'PendientesApruebaProcesarDB']);

        /* Rutas Panel Bcloud /Correccion por rechazo en aprobación */
        Route::get('/panel/bpack/correcaprueba/{id}', [CorreccionRechazoApruebaPanelController::class, 'CorreccionRechazoAprueba'])->where('id', '[0-9]+');
        Route::get('/panel/bpack/correcaprueba/procesar/{id}', [CorreccionRechazoApruebaPanelController::class, 'CorreccionRechazoApruebaProcesar'])->where('id', '[0-9]+');
        Route::post('/panel/bpack/correcaprueba/procesardb', [CorreccionRechazoApruebaPanelController::class, 'CorreccionRechazoApruebaProcesarDB']);

        /* Rutas Panel Bcloud /Pendiente de aprobación sherpas digitales */
        Route::get('/panel/bpack/pensherpa', [SherpasPanelController::class, 'PendientesSherpa']);
        Route::get('/panel/bpack/pensherpa/procesar/{id}', [SherpasPanelController::class, 'PendientesSherpaProcesar'])->where('id', '[0-9]+');
        Route::post('/panel/bpack/pensherpa/procesardb', [SherpasPanelController::class, 'PendientesSherpaProcesarDB']);

        /* Rutas Panel Bcloud /Pendiente de prueba de contrato */
        Route::get('/panel/bpack/pencontrato', [ContratoPanelController::class, 'PendientesContrato']);
        Route::get('/panel/bpack/pencontrato/procesar/{id}', [ContratoPanelController::class, 'PendientesContratoProcesar'])->where('id', '[0-9]+');
        Route::post('/panel/bpack/pencontrato/procesardb', [ContratoPanelController::class, 'PendientesContratoProcesarDB']);

        /* Rutas Panel Bcloud /Pendiente de aprobación prueba de contrato */
        Route::get('/panel/bpack/penaprcontrato', [AprContratoPanelController::class, 'PendientesAprContrato']);
        Route::get('/panel/bpack/penaprcontrato/procesar/{id}', [AprContratoPanelController::class, 'PendientesAprContratoProcesar'])->where('id', '[0-9]+');
        Route::post('/panel/bpack/penaprcontrato/procesardb', [AprContratoPanelController::class, 'PendientesAprContratoProcesarDB']);
        Route::post('/panel/bpack/penaprcontrato/rechazardb', [AprContratoPanelController::class, 'RechazarDB']);

        /* Rutas Panel Bcloud /Cancelación solicitud actualización o nuevo desarrollo */
        Route::get('/panel/bpack/cancelarsol', [CancelarPanelController::class, 'PendientesSolicitudes']);
        Route::get('/panel/bpack/cancelarsol/procesar/{id}', [CancelarPanelController::class, 'PendientesSolicitudesProcesar'])->where('id', '[0-9]+');
        Route::post('/panel/bpack/cancelarsol/procesardb', [CancelarPanelController::class, 'PendientesSolicitudesProcesarDB']);

        /* Rutas Panel Bcloud /Muestras físicas */
        Route::get('/panel/bpack/muestras', [MuestrasPanelController::class, 'Muestras']);
        Route::post('/panel/bpack/muestras/agregardb', [MuestrasPanelController::class, 'MuestrasAgregarDB']);
        Route::get('/panel/bpack/muestras/pendientes/{id}', [MuestrasPanelController::class, 'Pendientes'])->where('id', '[0-9]+');
        Route::get('/panel/bpack/muestras/procesar/{id}', [MuestrasPanelController::class, 'Procesar'])->where('id', '[0-9]+');
        Route::post('/panel/bpack/muestras/procesardb', [MuestrasPanelController::class, 'ProcesarDB']);
        Route::get('/panel/bpack/muestrascon', [MuestrasPanelController::class, 'ConsultaMuestras']);
        Route::post('/panel/bpack/muestrascon/listado', [MuestrasPanelController::class, 'ConsultaMuestrasListado']);

        /* Rutas Panel Bcloud /Reclamos y quejas */
        Route::get('/panel/bpack/reclamos', [ReclamosPanelController::class, 'Reclamos']);
        Route::get('/panel/bpack/reclamos/info/{id}', [ReclamosPanelController::class, 'ReclamosInfo'])->where('id', '[0-9]+');

        /* Rutas Panel TIC Activos/Ingresar activo */
        Route::get('/panel/ticactivos/ingresaract', [ActivosTicActivosPanelController::class, 'Ingresar']);
        Route::post('/panel/ticactivos/ingresaract/detalle', [ActivosTicActivosPanelController::class, 'IngresarDet']);
        Route::post('/panel/ticactivos/ingresaract/ingresardb', [ActivosTicActivosPanelController::class, 'IngresarDB']);
        Route::get('/panel/ticactivos/acta/{id}', [ActivosTicActivosPanelController::class, 'Acta'])->where('id', '[0-9]+');
        Route::post('/panel/ticactivos/actividad', [ActivosTicActivosPanelController::class, 'IngresarActividadDB']);
        Route::get('/panel/ticactivos/modificaract/{id}', [ActivosTicActivosPanelController::class, 'Modificar'])->where('id', '[0-9]+');
        Route::post('/panel/ticactivos/modificaract/modificaractdb', [ActivosTicActivosPanelController::class, 'ModificarDB']);

        /* Rutas Panel TIC Activos/Consultas */
        Route::get('/panel/ticactivos/consultasact', [ConsultasTicActivosPanelController::class, 'Consultas']);
        Route::get('/panel/ticactivos/conexempleados', [ConsultasTicActivosPanelController::class, 'Exempleados']);
        Route::get('/panel/ticactivos/conexempleados/{id}', [ConsultasTicActivosPanelController::class, 'obtenerDatosEmpleado']);
        Route::get('/panel/ticactivos/consultasparam', [ConsultasTicActivosPanelController::class, 'Parametrizada']);
        Route::post('/panel/ticactivos/consultasparam/listado', [ConsultasTicActivosPanelController::class, 'ParamListado']);
        Route::get('/panel/ticactivos/consultasparam/detalle/{id}', [ConsultasTicActivosPanelController::class, 'ParamDetalle'])->where('id', '[0-9]+');
        Route::get('/panel/ticactivos/concantidades', [ConsultasTicActivosPanelController::class, 'Cantidades']);
        Route::get('/panel/ticactivos/consultasproye', [ConsultasTicActivosPanelController::class, 'Proyeccion']);
        Route::post('/panel/ticactivos/consultasproye/listado', [ConsultasTicActivosPanelController::class, 'ProyeccionListado']);
        Route::get('/panel/ticactivos/consultasedades', [ConsultasTicActivosPanelController::class, 'Edades']);
        Route::get('/panel/ticactivos/consultasmtto', [ConsultasTicActivosPanelController::class, 'Mantenimientos']);
        Route::post('/panel/ticactivos/consultasmtto/listado', [ConsultasTicActivosPanelController::class, 'MantenimientosListado']);
        Route::get('/panel/ticactivos/consultastareas', [ConsultasTicActivosPanelController::class, 'Tareas']);
        Route::post('/panel/ticactivos/consultastareas/listado', [ConsultasTicActivosPanelController::class, 'TareasListado']);
        Route::get('/panel/ticactivos/consultasesperados', [ConsultasTicActivosPanelController::class, 'Esperados']);
        Route::post('/panel/ticactivos/consultasesperados/listado', [ConsultasTicActivosPanelController::class, 'EsperadosListado']);
        Route::get('/panel/ticactivos/activosxusuario', [ConsultasTicActivosPanelController::class, 'activosActualesXHistorico'])->name('activo.usuario');
        Route::get('/panel/ticactivos/usuarioxactivo', [ConsultasTicActivosPanelController::class, 'UsuarioXactivoAsignado'])->name('usuario.activo');

        /* Rutas Panel TIC Activos/Licencias de office */
        Route::get('/panel/ticactivos/licencias', [LicenciasTicActivosPanelController::class, 'Licencias']);
        Route::get('/panel/ticactivos/licencias/agregar', [LicenciasTicActivosPanelController::class, 'LicenciasAgregar']);
        Route::post('/panel/ticactivos/licencias/agregardb', [LicenciasTicActivosPanelController::class, 'LicenciasAgregarDB']);
        Route::get('/panel/ticactivos/licencias/modificar/{id}', [LicenciasTicActivosPanelController::class, 'LicenciasModificar'])->where('id', '[0-9]+');
        Route::post('/panel/ticactivos/licencias/modificardb', [LicenciasTicActivosPanelController::class, 'LicenciasModificarDB']);

        /* Rutas Panel TIC Activos/Marcas y modelos */
        Route::get('/panel/ticactivos/marcas', [MarcasTicActivosPanelController::class, 'Marcas']);
        Route::get('/panel/ticactivos/marcas/agregar', [MarcasTicActivosPanelController::class, 'MarcasAgregar']);
        Route::post('/panel/ticactivos/marcas/agregardb', [MarcasTicActivosPanelController::class, 'MarcasAgregarDB']);
        Route::get('/panel/ticactivos/marcas/modificar/{id}', [MarcasTicActivosPanelController::class, 'MarcasModificar'])->where('id', '[0-9]+');
        Route::post('/panel/ticactivos/marcas/modificardb', [MarcasTicActivosPanelController::class, 'MarcasModificarDB']);

        /* Rutas Panel TIC Activos/Software */
        Route::get('/panel/ticactivos/software', [SoftwareTicActivosPanelController::class, 'Software']);
        Route::get('/panel/ticactivos/software/agregar', [SoftwareTicActivosPanelController::class, 'SoftwareAgregar']);
        Route::post('/panel/ticactivos/software/agregardb', [SoftwareTicActivosPanelController::class, 'SoftwareAgregarDB']);
        Route::get('/panel/ticactivos/software/modificar/{id}', [SoftwareTicActivosPanelController::class, 'SoftwareModificar'])->where('id', '[0-9]+');
        Route::post('/panel/ticactivos/software/modificardb', [SoftwareTicActivosPanelController::class, 'SoftwareModificarDB']);

        /* Rutas Panel TIC Activos/Tareas de mantenimiento */
        Route::get('/panel/ticactivos/tareas', [TareasTicActivosPanelController::class, 'Tareas']);
        Route::get('/panel/ticactivos/tareas/agregar', [TareasTicActivosPanelController::class, 'TareasAgregar']);
        Route::post('/panel/ticactivos/tareas/agregardb', [TareasTicActivosPanelController::class, 'TareasAgregarDB']);
        Route::get('/panel/ticactivos/tareas/modificar/{id}', [TareasTicActivosPanelController::class, 'TareasModificar'])->where('id', '[0-9]+');
        Route::post('/panel/ticactivos/tareas/modificardb', [TareasTicActivosPanelController::class, 'TareasModificarDB']);

        /* Rutas Panel TIC Activos/Texto para actas */
        Route::get('/panel/ticactivos/textos', [TextosTicActivosPanelController::class, 'Textos']);
        Route::post('/panel/ticactivos/textos/modificardb', [TextosTicActivosPanelController::class, 'TextosModificarDB']);

        /* Rutas Panel TIC Activos/Tipos de activos */
        Route::get('/panel/ticactivos/tipos', [TiposTicActivosPanelController::class, 'Tipos']);
        Route::get('/panel/ticactivos/tipos/agregar', [TiposTicActivosPanelController::class, 'TiposAgregar']);
        Route::post('/panel/ticactivos/tipos/agregardb', [TiposTicActivosPanelController::class, 'TiposAgregarDB']);
        Route::get('/panel/ticactivos/tipos/modificar/{id}', [TiposTicActivosPanelController::class, 'TiposModificar'])->where('id', '[0-9]+');
        Route::post('/panel/ticactivos/tipos/modificardb', [TiposTicActivosPanelController::class, 'TiposModificarDB']);

        /* Rutas Panel TIC Activos/Tipos de office */
        Route::get('/panel/ticactivos/tpoffice', [TpOfficeTicActivosPanelController::class, 'TpOffice']);
        Route::get('/panel/ticactivos/tpoffice/agregar', [TpOfficeTicActivosPanelController::class, 'TpOfficeAgregar']);
        Route::post('/panel/ticactivos/tpoffice/agregardb', [TpOfficeTicActivosPanelController::class, 'TpOfficeAgregarDB']);
        Route::get('/panel/ticactivos/tpoffice/modificar/{id}', [TpOfficeTicActivosPanelController::class, 'TpOfficeModificar'])->where('id', '[0-9]+');
        Route::post('/panel/ticactivos/tpoffice/modificardb', [TpOfficeTicActivosPanelController::class, 'TpOfficeModificarDB']);

        /* Rutas Panel para impresión de etiquetas */
        Route::get('/panel/etiquetas/generar', [EtiquetasPanelController::class, 'GenerarEtiqueta']);
        Route::post('/panel/etiquetas/generar/listar', [EtiquetasPanelController::class, 'ListarEtiqueta']);
        Route::get('/panel/etiquetas/maquilas', [EtiquetasPanelController::class, 'Maquilas']);
        Route::get('/panel/etiquetas/maquilas/modificar/{id}', [EtiquetasPanelController::class, 'MaquilasModificar'])->where('id', '[0-9]+');
        Route::post('/panel/etiquetas/maquilas/modificardb', [EtiquetasPanelController::class, 'MaquilasModificarDB']);

        /* Rutas Panel Solicitud de compra/Motivos de rechazo */
        Route::get('/panel/solcompra/motivos', [MotivosSolCompraPanelController::class, 'Motivos']);
        Route::get('/panel/solcompra/motivos/agregar', [MotivosSolCompraPanelController::class, 'MotivosAgregar']);
        Route::post('/panel/solcompra/motivos/agregardb', [MotivosSolCompraPanelController::class, 'MotivosAgregarDB']);
        Route::get('/panel/solcompra/motivos/modificar/{id}', [MotivosSolCompraPanelController::class, 'MotivosModificar'])->where('id', '[0-9]+');
        Route::post('/panel/solcompra/motivos/modificardb', [MotivosSolCompraPanelController::class, 'MotivosModificarDB']);

        /* Rutas Panel Solicitud de compra/Aprobadores */
        Route::get('/panel/solcompra/aprobadores', [AprobadoresSolCompraPanelController::class, 'Aprobadores']);
        Route::post('/panel/solcompra/aprobadores', [AprobadoresSolCompraPanelController::class, 'Aprobadores']);
        Route::post('/panel/solcompra/aprobadores/agregardb', [AprobadoresSolCompraPanelController::class, 'AprobadoresAgregarDB']);
        Route::post('/panel/solcompra/aprobadores/retirar', [AprobadoresSolCompraPanelController::class, 'AprobadoresRetirarDB']);
        Route::post('/panel/solcompra/aprobadores/editar', [AprobadoresSolCompraPanelController::class, 'AprobadoresEditarDB']);

        /* Rutas Panel Solicitud de compra/Solicitar RQS */
        Route::get('/panel/solcompra/solicitud', [SolicitudSolCompraPanelController::class, 'Solicitud']);
        Route::post('/panel/solcompra/solicitud/agregardb', [SolicitudSolCompraPanelController::class, 'SolicitudAgregarDB']);
        Route::get('/panel/solcompra/comprobante/{id}', [SolicitudSolCompraPanelController::class, 'Comprobante'])->where('id', '[0-9]+');

        /* Rutas Panel Solicitud de compra/Aprobar */
        Route::get('/panel/solcompra/aprobar', [AprobarSolCompraPanelController::class, 'Aprobar']);
        Route::get('/panel/solcompra/aprobar/autorizar/{id}', [AprobarSolCompraPanelController::class, 'AprobarAutorizar'])->where('id', '[0-9]+');
        Route::post('/panel/solcompra/aprobar/autorizardb', [AprobarSolCompraPanelController::class, 'AprobarAutorizarDB']);

        /* Rutas Panel Despachos */
        Route::get('/panel/despachos/cargar', [DespachosPanelController::class, 'showDespachosCargarDocumento'])->name('showDespachosCargarDocumento');
        Route::get('/panel/despachos/cargardespacho/{titulo}', [DespachosPanelController::class, 'insertDespachosCargarDocumento']);
        Route::get('/panel/despachos/editardespacho/{id}', [DespachosPanelController::class, 'modificarDespachosCargarDocumento']);
        Route::get('/panel/despachos/enviardespachos', [DespachosPanelController::class, 'modificarTodosDespachos']);

        Route::get('/panel/despachos/listarorden', [OrdenesPanelController::class, 'showListarOrdenes'])->name('showListarOrdenes');
        Route::get('/panel/despachos/cargardespacho/{ean}/{documento}/{orden}/{fecha_created}/{tipo}', [OrdenesPanelController::class, 'insertDocumentoOrden']);
        Route::get('/panel/despachos/listarorden/descargue/{id}', [OrdenesPanelController::class, 'modificarDocumentoListado']);
        Route::get('/panel/despachos/descargarordenes', [OrdenesPanelController::class, 'descargarTodasOrdenes']);

        /* Rutas Activos Fijos */
        Route::get('/panel/activos/ingresar', [ActivosFijosController::class, 'showIngresarActivosFijos'])->name('showIngresarActivosFijos');
        Route::post('/panel/activos/ingresar', [ActivosFijosController::class, 'insertarActivosFijos'])->name('insert.activosfijos');
        Route::get('/panel/activos/consulta', [ActivosFijosController::class, 'showConsultaActivosFijos'])->name('showConsultaActivosFijos');
        Route::get('/panel/activos/consulta/parametrizada', [ActivosFijosController::class, 'ConsultaActivosFijos'])->name('ConsultaActivosFijos');
        Route::get('/panel/activos/consulta/parametrizada/detalle/{id}', [ActivosFijosController::class, 'ParamDetalle'])->name('ParamDetalle');
        Route::post('/panel/activos/ingresaractividad', [ActivosFijosController::class, 'IngresarActividadDB'])->name('insert.actividades');
        Route::get('/panel/activos/acta/{id}', [ActivosFijosController::class, 'Acta'])->where('id', '[0-9]+');
        Route::get('/panel/activos/modificaract/{id}', [ActivosFijosController::class, 'Modificar'])->where('id', '[0-9]+')->name('Modificar');
        Route::post('/panel/activos/modificaract/modificaractdb', [ActivosFijosController::class, 'ModificarDB'])->name('ModificarDB');

        Route::get('/panel/activos/textos', [TextosActivosFijosController::class, 'Textos']);
        Route::post('/panel/activos/textos/modificardb', [TextosActivosFijosController::class, 'TextosModificarDB'])->name('TextosModificarDB');

        Route::get('/panel/activos/tipos', [ActivosFijosController::class, 'actualizarTablaTipoActivosFijos'])->name('actualizarTablaTipos');
        Route::post('/panel/activos/tipos/estado', [ActivosFijosController::class, 'actualizarEstadoTipoDocumentos'])->name('actualizar.estadoTipoActivo');
        Route::post('/panel/activos/tipos/agregardb', [ActivosFijosController::class, 'TiposAgregarDB'])->name('insertar.tipoactivo');

        Route::get('/panel/activos/proyeccion', [ConsultasActivosFijosController::class, 'Proyeccion']);
        Route::post('/panel/activos/consultasproye/listado', [ConsultasActivosFijosController::class, 'ProyeccionListado']);

        Route::get('/panel/activos/export', [ActivosFijosController::class, 'ExportExcelActivos']);

        /* Rutas Archivo Digital */
        Route::get('/panel/archivo/historias', [HistoriasPanelController::class, 'showHistoriasLaborales'])->name('showHistoriasLaborales');
        Route::get('/panel/archivo/historias/{id}', [HistoriasPanelController::class, 'obtenerDatosEmpleado'])->name('showHistoriaEmpleado');
        Route::get('/panel/archivo/historias/docs/{id}', [HistoriasPanelController::class, 'obtenerDocEmpleado']);
        Route::get('/panel/archivo/historias/tipodocs/{id}', [HistoriasPanelController::class, 'obtenerTipoDoc']);
        Route::get('/panel/archivo/historias/documentos/{id}', [HistoriasPanelController::class, 'descargarDocumentos'])->name('down.historias');
        Route::post('/panel/archivo/historias/docs', [HistoriasPanelController::class, 'insertarHistoriasLaborales'])->name('insert.historias');
        Route::post('/panel/archivo/historias/documento', [HistoriasPanelController::class, 'UpdateHistoriasLaborales'])->name('update.documento');

        Route::post('/panel/archivo/historias/tipodocumento', [TipoDocumentoController::class, 'InsertarTipoDoc'])->name('insert.tipodocumento');
        Route::get('/panel/archivo/historias/tipodocumentos/', [TipoDocumentoController::class, 'actualizarTablaTipoDocumentos'])->name('actualizar.tablaTipoDocumentos');
        Route::post('/panel/archivo/historias/tipodocumento/estado', [TipoDocumentoController::class, 'actualizarEstadoTipoDocumentos'])->name('actualizar.estadoTipoDocumentos');

        Route::get('/panel/archivo/transferenciau', [TransferenciaDocumentalController::class, 'showTransferenciaDocumentalU'])->name('showTransferenciaDocumentalU');
        Route::post('/panel/archivo/transferenciau', [TransferenciaDocumentalController::class, 'insertarTransferenciaDocumentalU'])->name('insert.transferencia');
        Route::get('/panel/archivo/transferenciau/recibir/{id}', [TransferenciaDocumentalController::class, 'transferenciaDocumentalUDetalle'])->where('id', '[0-9]+');

        Route::get('/panel/archivo/transferenciad', [TransferenciaDocumentalController::class, 'showTransferenciaDocumentalD'])->name('showTransferenciaDocumentalD');
        Route::post('/panel/archivo/transferenciad', [TransferenciaDocumentalController::class, 'insertarTransferenciaDocumentalU'])->name('insert.transferencia');
        Route::get('/panel/archivo/transferenciad/recibir/{id}', [TransferenciaDocumentalController::class, 'transferenciaDocumentalRecibir'])->where('id', '[0-9]+');
        Route::post('/panel/archivo/transferenciad/recibir', [TransferenciaDocumentalController::class, 'transferenciaDocumentalRecibirConfirmar'])->name('recibir.fuid');
        Route::get('/panel/archivo/transferenciad/escanear/{id}', [TransferenciaDocumentalController::class, 'transferenciaDocumentalDEscanear'])->where('id', '[0-9]+');
        Route::post('/panel/archivo/transferenciad/escanear', [TransferenciaDocumentalController::class, 'transferenciaDocumentalDEscanearConfirmar'])->name('escanear.fuid');

        Route::get('/panel/archivo/insercionu', [InsercionDocumentalController::class, 'showInsercionDocumentalU'])->name('showInsercionDocumentalU');
        Route::get('/panel/archivo/insercionu/recibir/{id}', [InsercionDocumentalController::class, 'insercionDocumentalURecibir'])->name('insercionDocumentalURecibir');
        Route::get('/panel/archivo/inserciond', [InsercionDocumentalController::class, 'showInsercionDocumentalD'])->name('showInsercionDocumentalD');
        Route::post('/panel/archivo/insercionu', [InsercionDocumentalController::class, 'insertarInsercionDocumentalU'])->name('insert.insercionU');
        Route::get('/panel/archivo/inserciond/recibir/{id}', [InsercionDocumentalController::class, 'insercionDocumentalRecibir'])->where('id', '[0-9]+');
        Route::post('/panel/archivo/inserciond/recibir', [InsercionDocumentalController::class, 'transferenciaDocumentalRecibirConfirmar'])->name('recibir.solicitudinsercion');
        Route::get('/panel/archivo/inserciond/escaner/{id}', [InsercionDocumentalController::class, 'insercionDocumentalDEscanear'])->where('id', '[0-9]+');
        Route::post('/panel/archivo/inserciond/escanear', [InsercionDocumentalController::class, 'InsercionDocumentalDEscanearConfirmar'])->name('escanear.insercion');

        Route::get('/panel/archivo/consultas', [ArchivoCentralController::class, 'showArchivoCentral'])->name('showArchivoCentral');
        Route::get('/panel/archivo/consultas/parametrizada', [ArchivoCentralController::class, 'ConsultasArchivoCentral'])->name('ConsultasArchivoCentral');
        Route::get('/panel/archivo/consultas/parametrizada/dependencia/{id}', [ArchivoCentralController::class, 'descargarDependencia'])->name('down.dependencia');
        Route::get('/panel/archivo/consultas/parametrizada/registro/{id}', [ArchivoCentralController::class, 'descargarRegistros'])->name('down.registro');

        Route::get('/panel/archivo/informes', [InformesArchivoDigitalController::class, 'ShowInformes']);
        Route::post('/panel/archivo/informes/inventario/', [InformesArchivoDigitalController::class, 'exportInventario'])->name('exportar');

        /* Rutas de mejora continua */
        Route::get('/panel/noconformidades/tratamiento', [InconformidadesTratamientoController::class, 'showIngresarTramiento'])->name('showIngresarTramiento');
        Route::post('/panel/noconformidades/tratamiento', [InconformidadesTratamientoController::class, 'insertarTratamientoNoConf'])->name('insertarTratamientoNoConf');
        Route::get('/panel/noconformidades/reporte', [InconformidadesReporteController::class, 'showIngresarReporte'])->name('showIngresarReporte');
        Route::post('/panel/noconformidades/reporte', [InconformidadesReporteController::class, 'insertarReporteNoConf'])->name('insertarReporteNoConf');
        Route::get('/panel/noconformidades/completar_reporte/{id}', [InconformidadesReporteController::class, 'showCompletarReporteNoConf'])->name('showCompletarReporteNoConf');
        Route::get('/panel/noconformidades/completar_tratamiento/{id}', [InconformidadesTratamientoController::class, 'showCompletarTratamientoNoConf'])->name('showCompletarTratamientoNoConf');
        Route::post('/panel/noconformidades/completar_reporte', [InconformidadesTratamientoController::class, 'completarTratamientoNoConf'])->name('completarTratamientoNoConf');
        Route::post('/panel/noconformidades/completar_tratamiento', [InconformidadesReporteController::class, 'completarReporteNoConf'])->name('completarReporteNoConf');
        Route::get('/panel/noconformidades/consultar', [InconformidadesTratamientoController::class, 'showParametrosConsultar'])->name('showParametrosConsultar');
        Route::post('/panel/noconformidades/show_tratamientos', [InconformidadesTratamientoController::class, 'searchTrataNoConf'])->name('searchTrataNoConf');
        Route::post('/panel/noconformidades/show_reportes', [InconformidadesReporteController::class, 'searchReporteNoConf'])->name('searchReporteNoConf');

        Route::get('/panel/noconformidades/ver/tratamiento/{id}', [InconformidadesTratamientoController::class, 'showTrataNoConformidad'])->name('showTrataNoConformidad');
        Route::get('/panel/noconformidades/word/tratamiento/{id}', [InconformidadesTratamientoController::class, 'documentWord'])->name('documentWord');
        Route::get('/panel/noconformidades/ver/reporte/{id}', [InconformidadesReporteController::class, 'showReporteNoConformidad'])->name('showReporteNoConformidad');
        Route::get('/panel/noconformidades/word/reporte/{id}', [InconformidadesTratamientoController::class, 'documentWord'])->name('documentWord');
        Route::get('/panel/noconformidades/excel/reporte/{id}', [InconformidadesReporteController::class, 'documentExcel'])->name('documentExcel');
        Route::Post('/panel/noconformidades/downloadAll/trata', [InconformidadesTratamientoController::class, 'downloadAllTrata'])->name('downloadAllTrata');
        Route::Post('/panel/noconformidades/downloadAll/repor', [InconformidadesReporteController::class, 'downloadAllRepor'])->name('downloadAllRepor');


        Route::get('/panel/noconformidades/graficos', [InconformidadesTratamientoController::class, 'showGraficaNoConformidad'])->name('showGraficaNoConformidad');
        Route::Post('/panel/noconformidades/graficos/actualizarTrata', [InconformidadesTratamientoController::class, 'updateGraficaTrata'])->name('updateGraficaTrata');
        Route::Post('/panel/noconformidades/graficos/actualizarRepor', [InconformidadesReporteController::class, 'updateGraficaReporte'])->name('updateGraficaReporte');

        Route::Post('/panel/noconformidades/update/trata', [InconformidadesTratamientoController::class, 'updateTratamientoNoConf'])->name('updateTratamientoNoConf');
        Route::Post('/panel/noconformidades/update/reporte', [InconformidadesReporteController::class, 'updateReporteNoConf'])->name('updateReporteNoConf');

        Route::get('/descargarSegui/{id}/{rutaArchivo}', [InconformidadesReporteController::class, 'archivoSeguiRepor'])->name('archivoSeguiRepor');
        Route::get('/descargarVeri/{id}/{rutaArchivo}', [InconformidadesReporteController::class, 'archivoVeriRepor'])->name('archivoVeriRepor');

        Route::post('/panel/noconformidades/dbexcel/tratamiento', [InconformidadesTratamientoController::class, 'descargaTrataDbExcel'])->name('descargaTrataDbExcel');
        Route::post('/panel/noconformidades/dbexcel/reporte', [InconformidadesReporteController::class, 'descargaReporteDbExcel'])->name('descargaReporteDbExcel');

        /* Rutas Muestras Comerciales */
        Route::get('/panel/muestrascomerciales/lista', [MuestrasComercialesPanelController::class, 'showListaMuestrasComerciales'])->name('listaMuestrasComerciales');
        Route::get('/panel/muestrascomerciales/preagregar', [MuestrasComercialesPanelController::class, 'showMuestrasComercialesPreAgregar']);
        Route::post('/panel/muestrascomerciales/agregar', [MuestrasComercialesPanelController::class, 'showMuestrasComercialesAgregar']);
        Route::post('/panel/muestrascomerciales/agregardb', [MuestrasComercialesPanelController::class, 'MuestrasComercialesAgregarDB']);
        Route::get('/panel/itemmuestracomercial-eliminar/{id}/{idmc}', [MuestrasComercialesPanelController::class, 'ItemsEliminar'])->where('id', '[0-9]+')->where('idmc', '[0-9]+');
        Route::get('/panel/muestrascomerciales-modificar/{id}', [MuestrasComercialesPanelController::class, 'showMuestasComercialesModificar'])->where('id', '[0-9]+');
        Route::post('/panel/muestrascomerciales/modificardb', [MuestrasComercialesPanelController::class, 'MuestrasComercialesModificarDB']);
        Route::get('/panel/muestrascomerciales-modificar-item/{id}/{idmc}', [MuestrasComercialesPanelController::class, 'showMuestasComercialesModificarItem'])->where('id', '[0-9]+')->where('idmc', '[0-9]+');
        Route::post('/panel/muestrascomerciales/modificar-itemdb', [MuestrasComercialesPanelController::class, 'MuestrasComercialesModificarItemDB']);


        /* Rutas Panel SSL/Examenes */
        Route::get('/panel/ssl/examenes', [ExamenesRequisicionesPanelController::class, 'solicitudesExamenes']);
        Route::post('/panel/ssl/examenes/programar', [ExamenesRequisicionesPanelController::class, 'programarExamen'])->name('programarExamen');
        Route::get('/panel/ssl/examenes/solicitud/{id}', [ExamenesRequisicionesPanelController::class, 'solicitudExamen'])->name('solicitudExamen');
        Route::post('/panel/ssl/examenes/reprogramar', [ExamenesRequisicionesPanelController::class, 'reprogramarExamen'])->name('reprogramarExamen');
        Route::post('/panel/ssl/examenes/confirmarExamen', [ExamenesRequisicionesPanelController::class, 'confirmarExamen'])->name('confirmarExamen');
        Route::get('/panel/ssl/descargar/concepto/{archivo}', [ExamenesRequisicionesPanelController::class, 'descargarConcepto'])->name('descargarConcepto');

        /* Rutas Panel SSL/Permisos*/
        Route::get('/panel/ssl/permisos', [GestionarNotificacionesPermisosController::class, 'gestionarNotificacionesPermisos']);
        Route::post('/panel/ssl/permisos/notificaciones', [GestionarNotificacionesPermisosController::class, 'gestionarNotificaciones'])->name('gestionarNotificaciones');
        Route::post('/panel/ssl/permisos/niveles', [GestionarNotificacionesPermisosController::class, 'gestionarPermisos'])->name('gestionarPermisos');

    }
);
