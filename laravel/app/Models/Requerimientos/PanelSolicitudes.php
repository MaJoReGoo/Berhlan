<?php
//SQl Eloquent para conexión con la base de datos

namespace App\Models\Requerimientos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PanelSolicitudes extends Model
{
    public static function insertarSolicitud($datos)
    {
        $sql = DB::table('requ_solicitud')->insert($datos);
        return $sql;
    }

    public static function UltimaSolicitud()
    {
        $sql = DB::table('requ_solicitud')->select("num_solicitud")->orderby('num_solicitud', 'DESC')->first();
        return $sql;
    }

    public static function actualizarSolicitud($id, $datos)
    {
        $sql = DB::table('requ_solicitud')->where('num_solicitud', $id)->update($datos);
        return $sql;
    }

    public static function getSolicitudes20dias($id, $fecha)
    {
        $sql = DB::table('requ_solicitud')->where("usr_solicita", $id)->where(function ($query) use ($fecha) {
            $query->where('fecha_cierre', null)->orWhere('fecha_cierre', '>=', $fecha);
        })->orderby('fecha_solicita', 'DESC')->get();
        return $sql;
    }

    public static function getSolicitud($id)
    {
        $sql = DB::table('requ_solicitud')->where('num_solicitud', $id)->get();
        return $sql;
    }

    public static function insertarSolicitudDet($datos)
    {
        $sql = DB::table('requ_solicitud_det')->insert($datos);
        return $sql;
    }

    public static function getSolicitudes($id)
    {
        $sql = DB::table('requ_solicitud_det')->where('solicitud', $id)->orderby('fecha', 'ASC')->get();
        return $sql;
    }

    public static function getSolicitudesAbiertasGrupo($id)
    {
        $sql = DB::table('requ_solicitud')->where('grupo', $id)->whereIn('estado', ['1', '2'])->orderby('estado', 'ASC')->orderby('usr_cierre', 'DESC')->orderby('fecha_solicita', 'ASC')->get();
        return $sql;
    }

    public static function getSolicitudesAbiertasNotificadosGrupo($id)
    {
        $sql = DB::table('requ_solicitud')->where('grupo', $id)->where('notificacion_cierre', 1)->whereIn('estado', ['1', '2'])->orderby('estado', 'ASC')->orderby('usr_cierre', 'DESC')->orderby('fecha_solicita', 'ASC')->get();
        return $sql;
    }

    public static function getSolicitudesAbiertasTodosGrupo($id)
    {
        $sql = DB::table('requ_solicitud')->where('grupo', $id)->whereIn('estado', ['1', '2'])->orderby('estado', 'ASC')->orderby('usr_cierre', 'DESC')->orderby('fecha_solicita', 'ASC')->get();
        return $sql;
    }

    public static function RequerimientosTodosCant($id)
    {
        $sql = DB::table('requ_solicitud')->where('grupo', $id)->whereIn('estado', ['1', '2'])->orderby('estado', 'ASC')->orderby('usr_cierre', 'DESC')->orderby('fecha_solicita', 'ASC')->count();
        return $sql;
    }

    public static function EncuestasPendientes($id)
    {
        $sql = DB::table('requ_solicitud')->where('usr_solicita', $id)->where('estado', 3)->count();
        return $sql;
    }

    public static function Encuesta($id)
    {
        $sql = DB::table('requ_solicitud')->where('usr_solicita', $id)->where('estado', 3)->orderby('fecha_cierre', 'ASC')->get();
        return $sql;
    }

    public static function getSolicitudSql($id)
    {
        $sql = DB::select($id);
        return $sql;
    }

    //Cantidad de requerimientos por grupo y fechas
    public static function TRequerimientosGrupo($grupo, $desde, $hasta)
    {
        $sql1 = DB::table('requ_solicitud')->where('grupo', $grupo);

        if (($desde != '') && ($hasta != '')) {
            $sql = $sql1->where('fecha_solicita', '>=', $desde)->where('fecha_solicita', '<=', $hasta)->count();
        } else if ($desde != '') {
            $sql = $sql1->where('fecha_solicita', '>=', $desde)->count();
        } else if ($hasta != '') {
            $sql = $sql1->where('fecha_solicita', '<=', $hasta)->count();
        } else {
            $sql = $sql1->count();
        }

        return $sql;
    }

    //Requerimientos por estado, grupo y fechas
    public static function ConEstadosRequerimientos($grupo, $desde, $hasta)
    {
        $sql1 = DB::table('requ_solicitud')->select('estado')->selectRaw("COUNT('estado') AS cant")->where('grupo', $grupo);

        if (($desde != '') && ($hasta != '')) {
            $sql2 = $sql1->where('fecha_solicita', '>=', $desde)->where('fecha_solicita', '<=', $hasta);
        } else if ($desde != '') {
            $sql2 = $sql1->where('fecha_solicita', '>=', $desde);
        } else if ($hasta != '') {
            $sql2 = $sql1->where('fecha_solicita', '<=', $hasta);
        } else {
            $sql2 = $sql1;
        }

        $sql = $sql2->groupBy('estado')->orderby('cant', 'DESC')->get();

        return $sql;
    }

    //Empleados que atendieron requerimientos por grupo y fechas
    public static function ConEmpleadosRequerimientos($grupo, $desde, $hasta)
    {
        $sql1 = DB::table('requ_solicitud')->select('usr_atiende')->selectRaw("COUNT('usr_atiende') AS cant")->where('grupo', $grupo)->where('estado', '>', 2);
        //$sql1 = DB::table('requ_solicitud')->select('usr_cierre')->selectRaw("COUNT('usr_cierre') AS cant")->where('grupo', $grupo)->where('estado', '>', 2);

        if (($desde != '') && ($hasta != '')) {
            $sql2 = $sql1->where('fecha_cierre', '>=', $desde)->where('fecha_cierre', '<=', $hasta);
        } else if ($desde != '') {
            $sql2 = $sql1->where('fecha_cierre', '>=', $desde);
        } else if ($hasta != '') {
            $sql2 = $sql1->where('fecha_cierre', '<=', $hasta);
        } else {
            $sql2 = $sql1;
        }

        $sql = $sql2->groupBy('usr_atiende')->orderby('cant', 'DESC')->get();

        return $sql;
    }

    //Requerimientos por area, grupo y fechas
    public static function ConAreasRequerimientos($grupo, $desde, $hasta)
    {
        $sql1 = DB::table('requ_solicitud')->select('area')->selectRaw("COUNT('area') AS cant")->join('param_cargos', 'requ_solicitud.cargo_solicitud', '=', 'param_cargos.id_cargo')->where('grupo', $grupo);

        if (($desde != '') && ($hasta != '')) {
            $sql2 = $sql1->where('fecha_solicita', '>=', $desde)->where('fecha_solicita', '<=', $hasta);
        } else if ($desde != '') {
            $sql2 = $sql1->where('fecha_solicita', '>=', $desde);
        } else if ($hasta != '') {
            $sql2 = $sql1->where('fecha_solicita', '<=', $hasta);
        } else {
            $sql2 = $sql1;
        }

        $sql = $sql2->groupBy('area')->orderBy('cant', 'DESC')->get();

        return $sql;
    }

    //Requerimientos por área que no han sido atendidos, grupo y fechas
    public static function CtaAreaNoatendido($grupo, $desde, $hasta, $area)
    {
        $sql1 = DB::table('requ_solicitud')->join('param_cargos', 'requ_solicitud.cargo_solicitud', '=', 'param_cargos.id_cargo')->where('grupo', $grupo)->where('area', $area)->where('requ_solicitud.estado', '<', 3);

        if (($desde != '') && ($hasta != '')) {
            $sql = $sql1->where('fecha_solicita', '>=', $desde)->where('fecha_solicita', '<=', $hasta)->count();
        } else if ($desde != '') {
            $sql = $sql1->where('fecha_solicita', '>=', $desde)->count();
        } else if ($hasta != '') {
            $sql = $sql1->where('fecha_solicita', '<=', $hasta)->count();
        } else {
            $sql = $sql1->count();
        }

        return $sql;
    }

    //Requerimientos por área que han sido atendidos, grupo y fechas
    public static function CtaAreaAtendido($grupo, $desde, $hasta, $area)
    {
        $sql1 = DB::table('requ_solicitud')->join('param_cargos', 'requ_solicitud.cargo_solicitud', '=', 'param_cargos.id_cargo')->where('grupo', $grupo)->where('area', $area)->where('requ_solicitud.estado', '>', 2);

        if (($desde != '') && ($hasta != '')) {
            $sql = $sql1->where('fecha_solicita', '>=', $desde)->where('fecha_solicita', '<=', $hasta)->count();
        } else if ($desde != '') {
            $sql = $sql1->where('fecha_solicita', '>=', $desde)->count();
        } else if ($hasta != '') {
            $sql = $sql1->where('fecha_solicita', '<=', $hasta)->count();
        } else {
            $sql = $sql1->count();
        }

        return $sql;
    }

    public static function CtaAreaNotificados($grupo, $desde, $hasta, $area)
    {
        $sql1 = DB::table('requ_solicitud')->join('param_cargos', 'requ_solicitud.cargo_solicitud', '=', 'param_cargos.id_cargo')->where('grupo', $grupo)
            ->where('area', $area)->where('requ_solicitud.estado', '<', 3)->where('requ_solicitud.notificacion_cierre', '=', 1);

        if (($desde != '') && ($hasta != '')) {
            $sql = $sql1->where('fecha_solicita', '>=', $desde)->where('fecha_solicita', '<=', $hasta)->count();
        } else if ($desde != '') {
            $sql = $sql1->where('fecha_solicita', '>=', $desde)->count();
        } else if ($hasta != '') {
            $sql = $sql1->where('fecha_solicita', '<=', $hasta)->count();
        } else {
            $sql = $sql1->count();
        }

        return $sql;
    }
    //Requerimientos agrupados por categoría con grupo y fechas, requerimientos cerrados
    public static function ConCategoriasRequerimientos($grupo, $desde, $hasta)
    {
        $sql1 = DB::table('requ_solicitud')->select('categoria')->selectRaw("COALESCE(COUNT('categoria'), 0) AS cant")->where('grupo', $grupo)->whereNotNull('usr_atiende');

        if (($desde != '') && ($hasta != '')) {
            $sql2 = $sql1->where('fecha_solicita', '>=', $desde)->where('fecha_solicita', '<=', $hasta);
        } else if ($desde != '') {
            $sql2 = $sql1->where('fecha_solicita', '>=', $desde);
        } else if ($hasta != '') {
            $sql2 = $sql1->where('fecha_solicita', '<=', $hasta);
        } else {
            $sql2 = $sql1;
        }

        $sql = $sql2->groupBy('categoria')->orderByRaw("COALESCE(COUNT('categoria'), 0) DESC")
            ->get();

        return $sql;
    }
    public static function ConCategoriasRequerimientosPendientes($grupo, $desde, $hasta, $categoria)
    {
        $query = DB::table('requ_solicitud')
            ->selectRaw("COALESCE(COUNT('categoria'), 0) AS cant")
            ->where('grupo', $grupo)
            ->where('estado', '=', 2)
            ->whereNull('notificacion_cierre');

        if ($categoria !== 0) {
            $query->where('categoria', $categoria);
        }

        if ($desde && $hasta) {
            $query->whereBetween('fecha_solicita', [$desde, $hasta]);
        } elseif ($desde) {
            $query->where('fecha_solicita', '>=', $desde);
        } elseif ($hasta) {
            $query->where('fecha_solicita', '<=', $hasta);
        }

        return $query->count();
    }
    //Requerimientos agrupados por categoría con grupo y fechas, requerimientos cerrados
    public static function ConCategoriasRequerimientosAtendidos($grupo, $desde, $hasta, $categoria)
    {
        $query = DB::table('requ_solicitud')
            ->selectRaw("COALESCE(COUNT('categoria'), 0) AS cant")
            ->where('grupo', $grupo)
            ->where('estado', '=', 4);

        if ($categoria !== 0) {
            $query->where('categoria', $categoria);
        }

        if ($desde && $hasta) {
            $query->whereBetween('fecha_solicita', [$desde, $hasta]);
        } elseif ($desde) {
            $query->where('fecha_solicita', '>=', $desde);
        } elseif ($hasta) {
            $query->where('fecha_solicita', '<=', $hasta);
        }

        return $query->count();
    }

    public static function ConCategoriasRequerimientosRecibidos($grupo, $desde, $hasta, $categoria)
    {

        $query = DB::table('requ_solicitud')
            ->selectRaw("COALESCE(COUNT('categoria'), 0) AS cant")
            ->where('grupo', $grupo);

        if ($categoria !== 0) {
            $query->where('categoria', $categoria);
        }

        if ($desde && $hasta) {
            $query->whereBetween('fecha_solicita', [$desde, $hasta]);
        } elseif ($desde) {
            $query->where('fecha_solicita', '>=', $desde);
        } elseif ($hasta) {
            $query->where('fecha_solicita', '<=', $hasta);
        }

        return $query->count();
    }
    public static function ConCategoriasRequerimientosNotificados($grupo, $desde, $hasta, $categoria)
    {

        $query = DB::table('requ_solicitud')
            ->selectRaw("COALESCE(COUNT('categoria'), 0) AS cant")
            ->where('grupo', $grupo)
            ->where('estado', '=', 2)
            ->where('notificacion_cierre', '=', 1);

        if ($categoria !== 0) {
            $query->where('categoria', $categoria);
        }

        if ($desde && $hasta) {
            $query->whereBetween('fecha_solicita', [$desde, $hasta]);
        } elseif ($desde) {
            $query->where('fecha_solicita', '>=', $desde);
        } elseif ($hasta) {
            $query->where('fecha_solicita', '<=', $hasta);
        }

        return $query->count();
    }

    //Requerimientos por criticidad, grupo y fechas
    public static function ConCriticidadRequerimientos($grupo, $desde, $hasta)
    {
        $sql1 = DB::table('requ_solicitud')->select('criticidad')->selectRaw("COUNT('criticidad') AS cant")->join('requ_categorias', 'requ_solicitud.categoria', '=', 'requ_categorias.id_categoria')->where('requ_solicitud.grupo', $grupo)->where('requ_solicitud.estado', '>', 2);

        if (($desde != '') && ($hasta != '')) {
            $sql2 = $sql1->where('fecha_cierre', '>=', $desde)->where('fecha_cierre', '<=', $hasta);
        } else if ($desde != '') {
            $sql2 = $sql1->where('fecha_cierre', '>=', $desde);
        } else if ($hasta != '') {
            $sql2 = $sql1->where('fecha_cierre', '<=', $hasta);
        } else {
            $sql2 = $sql1;
        }

        $sql = $sql2->groupBy('criticidad')->orderBy('cant', 'DESC')->get();

        return $sql;
    }

    //Requerimientos agrupados por calificación con grupo y fechas, requerimientos cerrados
    public static function ConEncuestaRequerimientos($grupo, $desde, $hasta)
    {
        $sql1 = DB::table('requ_solicitud')->select('calificacion')->selectRaw("COUNT('calificacion') AS cant")->where('grupo', $grupo)->where('estado', 4);

        if (($desde != '') && ($hasta != '')) {
            $sql2 = $sql1->where('fecha_cierre', '>=', $desde)->where('fecha_cierre', '<=', $hasta);
        } else if ($desde != '') {
            $sql2 = $sql1->where('fecha_cierre', '>=', $desde);
        } else if ($hasta != '') {
            $sql2 = $sql1->where('fecha_cierre', '<=', $hasta);
        } else {
            $sql2 = $sql1;
        }

        $sql = $sql2->groupBy('calificacion')->orderBy('cant', 'DESC')->get();

        return $sql;
    }

    //Consulta los requerimientos cerrados, calcula la diferencia en días entre la solicitud y el cierre,
    //y luego calcula la diferencia con el tiempo que debería tomarse para el cierre
    //toma como parámetros el grupo y las fechas de solicitud
    //no tiene en cuenta los requerimientos que se asignaron como proyectos o terceros
    public static function ConTiempos($grupo, $desde, $hasta)
    {
        $sql1 = DB::table('requ_solicitud');
        $sql1 = $sql1->select('requ_solicitud.num_solicitud', 'requ_solicitud.fecha_solicita', 'requ_solicitud.fecha_cierre', 'requ_categorias.criticidad', 'requ_priorizacion.tiempo');
        $sql1 = $sql1->addSelect(DB::raw('TIMESTAMPDIFF(day, requ_solicitud.fecha_solicita, requ_solicitud.fecha_cierre) as dias'));
        $sql1 = $sql1->addSelect(DB::raw('(TIMESTAMPDIFF(day, requ_solicitud.fecha_solicita, requ_solicitud.fecha_cierre) - requ_priorizacion.tiempo) as diferencia'));
        $sql1 = $sql1->join('requ_categorias', 'requ_categorias.id_categoria', '=', 'requ_solicitud.categoria');
        $sql1 = $sql1->join('requ_priorizacion', 'requ_priorizacion.criticidad', '=', 'requ_categorias.criticidad');
        $sql1 = $sql1->where('requ_priorizacion.grupo', $grupo)->where('requ_solicitud.grupo', $grupo)->where('requ_solicitud.estado', '>', 2)->where('requ_solicitud.depende_de', '');

        if (($desde != '') && ($hasta != '')) {
            $sql = $sql1->where('fecha_solicita', '>=', $desde)->where('fecha_solicita', '<=', $hasta)->orderBy('diferencia', 'DESC')->get();
        } else if ($desde != '') {
            $sql = $sql1->where('fecha_solicita', '>=', $desde)->orderBy('diferencia', 'DESC')->get();
        } else if ($hasta != '') {
            $sql = $sql1->where('fecha_solicita', '<=', $hasta)->orderBy('diferencia', 'DESC')->get();
        } else {
            $sql = $sql1->orderBy('diferencia', 'DESC')->get();
        }

        return $sql;
    }

    //Información de los requerimientos agrupados por calificación con grupo y fechas, requerimientos cerrados
    public static function ConEncuestaRequerimientosLis($grupo, $desde, $hasta)
    {
        $sql1 = DB::table('requ_solicitud')->where('grupo', $grupo)->where('estado', 4);

        if (($desde != '') && ($hasta != '')) {
            $sql2 = $sql1->where('fecha_cierre', '>=', $desde)->where('fecha_cierre', '<=', $hasta);
        } else if ($desde != '') {
            $sql2 = $sql1->where('fecha_cierre', '>=', $desde);
        } else if ($hasta != '') {
            $sql2 = $sql1->where('fecha_cierre', '<=', $hasta);
        } else {
            $sql2 = $sql1;
        }

        $sql = $sql2->orderBy('requ_solicitud.calificacion', 'ASC')->orderBy('usr_cierre', 'DESC')->orderBy('fecha_cierre', 'DESC')->get();

        return $sql;
    }

    public static function SolicitudesReintegroGrupo($grupo)
    {
        $sql = DB::table('requ_solicitud')->where('grupo', $grupo)->where('reintegro', 1)->orderby('fecha_cierre', 'ASC')->get();
        return $sql;
    }

    public static function ConReintegro($grupo, $desde, $hasta)
    {
        $sql1 = DB::table('requ_solicitud')->where('grupo', $grupo)->whereIn('reintegro', ['1', '2']);

        if (($desde != '') && ($hasta != '')) {
            $sql2 = $sql1->where('fecha_cierre', '>=', $desde)->where('fecha_cierre', '<=', $hasta);
        } else if ($desde != '') {
            $sql2 = $sql1->where('fecha_cierre', '>=', $desde);
        } else if ($hasta != '') {
            $sql2 = $sql1->where('fecha_cierre', '<=', $hasta);
        } else {
            $sql2 = $sql1;
        }

        $sql = $sql2->orderBy('fecha_cierre', 'DESC')->get();

        return $sql;
    }

    //Requerimientos agrupados por calificación con grupo y por meses, requerimientos cerrados
    public static function ConEncuestaReqMensual($grupo, $ano, $mes)
    {
        $sql = DB::table('requ_solicitud')->select('calificacion')->selectRaw("COUNT('calificacion') AS cant")->where('grupo', $grupo)->where('estado', 4);
        $sql = $sql->whereYear('fecha_cierre', $ano)->whereMonth('fecha_cierre', $mes)->groupBy('calificacion')->orderBy('cant', 'DESC')->get();

        return $sql;
    }

    //Requerimientos agrupados por calificación con grupo, empleado y por meses, requerimientos cerrados
    public static function ConEncuestaReqMensualEmp($grupo, $ano, $mes, $empleado)
    {
        $sql = DB::table('requ_solicitud')->select('calificacion')->selectRaw("COUNT('calificacion') AS cant")->where('grupo', $grupo)->where('estado', 4)->where('usr_cierre', $empleado);
        $sql = $sql->whereYear('fecha_cierre', $ano)->whereMonth('fecha_cierre', $mes)->groupBy('calificacion')->orderBy('cant', 'DESC')->get();

        return $sql;
    }

    //Consulta la cantidad de requerimientos asignados por grupo
    public static function RequerimientosAsignados($grupo)
    {
        $sql = DB::table('requ_solicitud')->select('usr_cierre')->selectRaw("COUNT('usr_cierre') AS cant")->where('estado', 2)->where('grupo', $grupo)->groupBy('usr_cierre')->orderBy('cant', 'DESC')->get();

        return $sql;
    }

    public static function cantRequerimientosNotificadosUs($idus, $grupo)
    {
        $sql = DB::table('requ_solicitud')->where('usr_cierre', $idus)->where('notificacion_cierre', 1)->where('estado', 2)->where('grupo', $grupo)->count();

        return $sql;
    }

    //Lista la diferencia de los tiempos en los requerimientos asignados por usuario
    public static function ReqAsigPasados($grupo, $empleado)
    {
        $sql = DB::table('requ_solicitud');
        $sql1 = $sql->select('requ_solicitud.num_solicitud');
        $sql1 = $sql1->addSelect(DB::raw('(TIMESTAMPDIFF(day, requ_solicitud.fecha_solicita, NOW()) - requ_priorizacion.tiempo) as diferencia'));
        $sql1 = $sql1->join('requ_categorias', 'requ_categorias.id_categoria', '=', 'requ_solicitud.categoria');
        $sql1 = $sql1->join('requ_priorizacion', 'requ_priorizacion.criticidad', '=', 'requ_categorias.criticidad');
        $sql1 = $sql1->where('requ_priorizacion.grupo', $grupo)->where('requ_solicitud.grupo', $grupo)->where('requ_solicitud.usr_cierre', $empleado);
        $sql = $sql1->where('requ_solicitud.estado', 2)->get();
        return $sql;
    }

    //Cantidad de requerimientos por grupo y fecha de solicitud, establecido como proyecto
    public static function TReqSolGrupoProyecto($grupo, $desde, $hasta)
    {
        $sql1 = DB::table('requ_solicitud')->where('grupo', $grupo)->where('depende_de', 'P');

        if (($desde != '') && ($hasta != '')) {
            $sql = $sql1->where('fecha_solicita', '>=', $desde)->where('fecha_solicita', '<=', $hasta)->count();
        } else if ($desde != '') {
            $sql = $sql1->where('fecha_solicita', '>=', $desde)->count();
        } else if ($hasta != '') {
            $sql = $sql1->where('fecha_solicita', '<=', $hasta)->count();
        } else {
            $sql = $sql1->count();
        }

        return $sql;
    }

    //Cantidad de requerimientos por grupo y fecha de solicitud, establecido como depende de terceros
    public static function TReqSolGrupoTerceros($grupo, $desde, $hasta)
    {
        $sql1 = DB::table('requ_solicitud')->where('grupo', $grupo)->where('depende_de', 'T');

        if (($desde != '') && ($hasta != '')) {
            $sql = $sql1->where('fecha_solicita', '>=', $desde)->where('fecha_solicita', '<=', $hasta)->count();
        } else if ($desde != '') {
            $sql = $sql1->where('fecha_solicita', '>=', $desde)->count();
        } else if ($hasta != '') {
            $sql = $sql1->where('fecha_solicita', '<=', $hasta)->count();
        } else {
            $sql = $sql1->count();
        }

        return $sql;
    }

    //Cantidad de requerimientos por grupo y fecha de cierre, establecido como proyecto
    public static function TReqAteGrupoProyecto($grupo, $desde, $hasta)
    {
        $sql1 = DB::table('requ_solicitud')->where('grupo', $grupo)->where('depende_de', 'P')->where('estado', '>', '2');

        if (($desde != '') && ($hasta != '')) {
            $sql = $sql1->where('fecha_cierre', '>=', $desde)->where('fecha_cierre', '<=', $hasta)->count();
        } else if ($desde != '') {
            $sql = $sql1->where('fecha_cierre', '>=', $desde)->count();
        } else if ($hasta != '') {
            $sql = $sql1->where('fecha_cierre', '<=', $hasta)->count();
        } else {
            $sql = $sql1->count();
        }

        return $sql;
    }

    //Cantidad de requerimientos por grupo y fecha de cierre, establecido como depende de terceros
    public static function TReqAteGrupoTerceros($grupo, $desde, $hasta)
    {
        $sql1 = DB::table('requ_solicitud')->where('grupo', $grupo)->where('depende_de', 'T')->where('estado', '>', '2');

        if (($desde != '') && ($hasta != '')) {
            $sql = $sql1->where('fecha_cierre', '>=', $desde)->where('fecha_cierre', '<=', $hasta)->count();
        } else if ($desde != '') {
            $sql = $sql1->where('fecha_cierre', '>=', $desde)->count();
        } else if ($hasta != '') {
            $sql = $sql1->where('fecha_cierre', '<=', $hasta)->count();
        } else {
            $sql = $sql1->count();
        }

        return $sql;
    }
    //Cantidad de requerimientos  atendidos por grupo y fechas
    public static function TRequerimientosGrupoAtendidos($grupo, $desde, $hasta)
    {
        $sql1 = DB::table('requ_solicitud')->where('grupo', $grupo)->where('estado', '>', 2);

        if (($desde != '') && ($hasta != '')) {
            $sql = $sql1->where('fecha_solicita', '>=', $desde)->where('fecha_solicita', '<=', $hasta)->count();
        } else if ($desde != '') {
            $sql = $sql1->where('fecha_solicita', '>=', $desde)->count();
        } else if ($hasta != '') {
            $sql = $sql1->where('fecha_solicita', '<=', $hasta)->count();
        } else {
            $sql = $sql1->count();
        }

        return $sql;
    }

    //Consulta la cantidad de requerimientos asignados por grupo, que son proyectos
    public static function ConTProyectoUsuario($grupo)
    {
        $sql = DB::table('requ_solicitud')->select('usr_cierre')->selectRaw("COUNT('usr_cierre') AS cant")->where('estado', 2)->where('grupo', $grupo)->where('depende_de', 'P')->groupBy('usr_cierre')->orderBy('cant', 'DESC')->get();

        return $sql;
    }

    //Consulta la cantidad de requerimientos asignados por grupo, que dependen de terceros
    public static function ConTTercerosUsuario($grupo)
    {
        $sql = DB::table('requ_solicitud')->select('usr_cierre')->selectRaw("COUNT('usr_cierre') AS cant")->where('estado', 2)->where('grupo', $grupo)->where('depende_de', 'T')->groupBy('usr_cierre')->orderBy('cant', 'DESC')->get();
        return $sql;
    }

    //Requerimientos para Notificaciones
    public static function RequerimientosVencidos()
    {
        $fecha = date('Y-m-d');
        $sql = DB::select("SELECT * from requ_solicitud where (estado != 4 and fecha_propuesta_cierre != '' and date_add(fecha_propuesta_cierre, interval 5 day) < '" . $fecha . "' ) order by num_solicitud DESC; ");
        return $sql;
    }

    public static function RequerimientosVencidosCant()
    {
        $fecha = date('Y-m-d');
        $sql = DB::select("SELECT count(*) as NumReqV from requ_solicitud where (estado != 4 and fecha_propuesta_cierre is not null and date_add(fecha_propuesta_cierre, interval 5 day) < '" . $fecha . "' ) order by num_solicitud DESC; ");
        return $sql;
    }

    //Consulta la cantidad de requerimientos asignados por grupo, que dependen de terceros
    public static function getUltimoComentarioCierreCant($solicitud)
    {
        $sql = DB::table('requ_solicitud_det')->where('solicitud', $solicitud)->where('cierre', 1)->orderBy('fecha', 'DESC')->count();
        return $sql;
    }

    public static function getUltimoComentarioCierre($solicitud)
    {
        $sql = DB::table('requ_solicitud_det')->where('solicitud', $solicitud)->where('cierre', 1)->orderBy('fecha', 'DESC')->take(1)->get();
        return $sql;
    }

    //Archivos Iniciales de Requerimientos
    public static function insertarSolicitudIniFiles($datos)
    {
        $sql = DB::table('requ_archivos_ini_det')->insert($datos);
        return $sql;
    }

    public static function getSolicitudFilesIni($id)
    {
        $sql = DB::table('requ_archivos_ini_det')->where('solicitud', $id)->orderby('fecha', 'ASC')->get();
        return $sql;
    }

    public static function actualizarSolicitudFilesIni($id, $datos)
    {
        $sql = DB::table('requ_archivos_ini_det')->where('solicitud', $id)->update($datos);
        return $sql;
    }

    //Consulta Tickets por Usuario
    public static function getSolicitudesAbiertasGrupoUsuario($id, $idus)
    {
        $sql = DB::table('requ_solicitud')->where('grupo', $id)->where('usr_cierre', $idus)->whereIn('estado', ['1', '2'])->orderby('estado', 'ASC')->orderby('usr_cierre', 'DESC')->orderby('fecha_solicita', 'ASC')->get(); // = Local
        return $sql;
    }

    public static function getSolicitudesAbiertasNotificadosGrupoUsuario($id, $idus)
    {
        $sql = DB::table('requ_solicitud')->where('grupo', $id)->where('usr_cierre', $idus)->whereIn('estado', ['1', '2'])->orderby('estado', 'ASC')->orderby('usr_cierre', 'DESC')->orderby('fecha_solicita', 'ASC')->get();
        return $sql;
    }

    public static function getSolicitudesAbiertasTodosGrupoUsuario($id, $idus)
    {
        $sql = DB::table('requ_solicitud')->where('grupo', $id)->where('usr_cierre', $idus)->whereIn('estado', ['1', '2'])->orderby('estado', 'ASC')->orderby('usr_cierre', 'DESC')->orderby('fecha_solicita', 'ASC')->get();
        return $sql;
    }

    public static function getSolicitudesAbiertasUsuario($idus)
    {
        $sql = DB::table('requ_solicitud')->where('usr_solicita', $idus)->where('notificacion_cierre', 1)->whereIn('estado', ['1', '2'])->orderby('fecha_solicita', 'ASC')->count();
        return $sql;
    }

    //Consulta Tickets por Categoria
    public static function getSolicitudesAbiertasGrupoCategoria($id, $categoria)
    {
        $sql = DB::table('requ_solicitud')->where('grupo', $id)->where('categoria', $categoria)->whereIn('estado', ['1', '2'])->orderby('estado', 'ASC')->orderby('usr_cierre', 'DESC')->orderby('fecha_solicita', 'ASC')->get(); // = Local
        return $sql;
    }

    public static function getSolicitudesAbiertasNotificadosGrupoCategoria($id, $categoria)
    {
        $sql = DB::table('requ_solicitud')->where('grupo', $id)->where('categoria', $categoria)->whereIn('estado', ['1', '2'])->orderby('estado', 'ASC')->orderby('usr_cierre', 'DESC')->orderby('fecha_solicita', 'ASC')->get();
        return $sql;
    }

}
