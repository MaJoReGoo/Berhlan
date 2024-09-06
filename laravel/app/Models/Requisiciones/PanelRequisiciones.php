<?php
//SQl Eloquent para conexión con la base de datos

namespace App\Models\Requisiciones;

use Illuminate\Database\Eloquent\Model;

class PanelRequisiciones extends Model
{
    public static function insertarSolicitud($datos)
    {
        $sql = \DB::table('rqpe_solicitud')->insert($datos);
        return $sql;
    }

    public static function getSolicitudes()
    {
        $sql = \DB::table('rqpe_solicitud')->orderby('num_solicitud', 'DESC')->get();
        return $sql;
    }

    public static function UltimaSolicitud()
    {
        $sql = \DB::table('rqpe_solicitud')->select('num_solicitud')->orderby('num_solicitud', 'DESC')->first();
        return $sql;
    }

    public static function getSolicitudes20dias($id, $fecha)
    {
        $sql = \DB::table('rqpe_solicitud')->where("usr_solicita", $id)->where(function ($query) use ($fecha) {$query->where('fecha_cierre', '>=', $fecha)->orWhere('fecha_cierre', null);})->orderby('fecha_solicita', 'ASC')->get();
        return $sql;
    }

    public static function SolicitudesNomina()
    {
        $sql = \DB::table('rqpe_solicitud')->whereIn('estado', [1, 3, 5, 9, 10])->orderby('fecha_solicita', 'DESC')->get();
        return $sql;
    }

    public static function SolicitudesElementos()
    {
        $sql = \DB::table('rqpe_solicitud')->whereIn('estado', [3, 5, 6, 9])->orderby('fecha_solicita', 'DESC')->get();
        return $sql;
    }

    public static function SolicitudesGerencia()
    {
        $sql = \DB::table('rqpe_solicitud')->where('estado', 3)->orderby('fecha_solicita', 'DESC')->get();
        return $sql;
    }

    public static function SolicitudesHv()
    {
        $sql = \DB::table('rqpe_solicitud')->where('estado', 5)->orderby('fecha_solicita', 'DESC')->get();
        return $sql;
    }

    public static function getSolicitud($id)
    {
        $sql = \DB::table('rqpe_solicitud')->where('num_solicitud', $id)->get();
        return $sql;
    }

    public static function actualizarSolicitud($id, $datos)
    {
        $sql = \DB::table('rqpe_solicitud')->where('num_solicitud', $id)->update($datos);
        return $sql;
    }

    public static function getEstadoSolicitud($id)
    {
        $sql = \DB::table('rqpe_estados')->where('id_estado', $id)->get();
        return $sql;
    }

    public static function getEstadosSolicitud()
    {
        $sql = \DB::table('rqpe_estados')->orderBy('descripcion', 'ASC')->get();
        return $sql;
    }

    public static function getCandidatoUnico($sol, $ident)
    {
        $sql = \DB::table('rqpe_solicitud_det')->where('solicitud', $sol)->where('identificacion', $ident)->count();
        return $sql;
    }

    public static function insertarSolicitudDet($datos)
    {
        $sql = \DB::table('rqpe_solicitud_det')->insert($datos);
        return $sql;
    }

    public static function SolicitudesDet($id)
    {
        $sql = \DB::table('rqpe_solicitud_det')->where('solicitud', $id)->orderby('estado', 'ASC')->get();
        return $sql;
    }

    public static function SolicitudDet($id)
    {
        $sql = \DB::table('rqpe_solicitud_det')->where('id_detalle', $id)->get();
        return $sql;
    }

    public static function actualizarSolDet($id, $datos)
    {
        $sql = \DB::table('rqpe_solicitud_det')->where('id_detalle', $id)->update($datos);
        return $sql;
    }

    public static function actualizarSolicitudDet($id, $id1, $datos)
    {
        $sql = \DB::table('rqpe_solicitud_det')->where('solicitud', $id)->where('identificacion', $id1)->update($datos);
        return $sql;
    }

    //Consulta la cantidad de hojas de vida en estados "En proceso de contratación" y Contratado
    public static function HvAprobadas($id)
    {
        $sql = \DB::table('rqpe_solicitud_det')->where('solicitud', $id)->whereIn('estado', ['2P', '3C'])->count();
        return $sql;
    }

    public static function CandidatosPorEntrevista($id)
    {
        $sql = \DB::table('rqpe_solicitud_det')->join('rqpe_solicitud', 'rqpe_solicitud.num_solicitud', '=', 'rqpe_solicitud_det.solicitud')->where('rqpe_solicitud.usr_solicita', $id)->where('rqpe_solicitud_det.estado', '1I')->get();
        return $sql;
    }

    public static function CandidatosPorContratacion()
    {
        $sql = \DB::table('rqpe_solicitud_det')->join('rqpe_solicitud', 'rqpe_solicitud.num_solicitud', '=', 'rqpe_solicitud_det.solicitud')->where('rqpe_solicitud_det.estado', '2P')->orderBy('num_solicitud', 'ASC')->orderBy('fecha_entrevista', 'ASC')->get();
        return $sql;
    }

    //Consulta la cantidad de candidatos contratados en la solicitud
    public static function Contratados($id)
    {
        $sql = \DB::table('rqpe_solicitud_det')->where('solicitud', $id)->where('estado', '3C')->count();
        return $sql;
    }

    //Consulta la cantidad de candidatos que pasaron la entrevista y están pendientes de contrato
    public static function PenContrato($id)
    {
        $sql = \DB::table('rqpe_solicitud_det')->where('solicitud', $id)->where('estado', '2P')->count();
        return $sql;
    }

    //Consulta la cantidad de candidatos pendientes por entrevista
    public static function PenEntrevista($id)
    {
        $sql = \DB::table('rqpe_solicitud_det')->where('solicitud', $id)->where('estado', '1I')->count();
        return $sql;
    }

    public static function CanRechazados($id)
    {
        $sql = \DB::table('rqpe_solicitud_det')->where('solicitud', $id)->where('estado', '4R')->count();
        return $sql;
    }

    //Actualizo el estado de los demás candidatos que no fueron tenidos en cuenta
    public static function actualizarSolicitudDetEstado($id, $datos)
    {
        $sql = \DB::table('rqpe_solicitud_det')->where('solicitud', $id)->whereIn('estado', ['1I', '2P'])->update($datos);
        return $sql;
    }

    public static function getSolicitudSql($id)
    {
        $sql = \DB::select($id);
        return $sql;
    }

    //Cantidad de solicitudes por fechas
    public static function TSolicitudes($desde, $hasta)
    {
        $sql1 = \DB::table('rqpe_solicitud');

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

    //Solicitudes por estado y fechas
    public static function ConEstadosSolicitudes($desde, $hasta)
    {
        $sql1 = \DB::table('rqpe_solicitud')->select('estado')->selectRaw("COUNT('estado') AS cant");

        if (($desde != '') && ($hasta != '')) {
            $sql2 = $sql1->where('fecha_solicita', '>=', $desde)->where('fecha_solicita', '<=', $hasta);
        } else if ($desde != '') {
            $sql2 = $sql1->where('fecha_solicita', '>=', $desde);
        } else if ($hasta != '') {
            $sql2 = $sql1->where('fecha_solicita', '<=', $hasta);
        } else {
            $sql2 = $sql1;
        }

        $sql = $sql2->groupBy('estado')->orderBy('cant', 'DESC')->get();

        return $sql;
    }

    //Solicitudes por motivo y fechas
    public static function ConMotivosSolicitudes($desde, $hasta)
    {
        $sql1 = \DB::table('rqpe_solicitud')->select('motivo')->selectRaw("COUNT('motivo') AS cant");

        if (($desde != '') && ($hasta != '')) {
            $sql2 = $sql1->where('fecha_solicita', '>=', $desde)->where('fecha_solicita', '<=', $hasta);
        } else if ($desde != '') {
            $sql2 = $sql1->where('fecha_solicita', '>=', $desde);
        } else if ($hasta != '') {
            $sql2 = $sql1->where('fecha_solicita', '<=', $hasta);
        } else {
            $sql2 = $sql1;
        }

        $sql = $sql2->groupBy('motivo')->orderBy('cant', 'DESC')->get();

        return $sql;
    }

    //Solicitudes por cargo y fechas
    public static function ConCargosSolicitudes($desde, $hasta)
    {
        $sql1 = \DB::table('rqpe_solicitud')->select('cargo')->selectRaw("SUM(num_vacantes) AS cant");

        if (($desde != '') && ($hasta != '')) {
            $sql2 = $sql1->where('fecha_solicita', '>=', $desde)->where('fecha_solicita', '<=', $hasta);
        } else if ($desde != '') {
            $sql2 = $sql1->where('fecha_solicita', '>=', $desde);
        } else if ($hasta != '') {
            $sql2 = $sql1->where('fecha_solicita', '<=', $hasta);
        } else {
            $sql2 = $sql1;
        }

        $sql = $sql2->groupBy('cargo')->orderBy('cant', 'DESC')->get();

        return $sql;
    }

    //Consulta el numero de contratados segun el cargo
    public static function CargoContratados($id)
    {
        $sql1 = \DB::table('rqpe_solicitud');
        $sql1 = $sql1->join('rqpe_solicitud_det', 'rqpe_solicitud.num_solicitud', '=', 'rqpe_solicitud_det.solicitud');
        $sql = $sql1->where('cargo', $id)->where('rqpe_solicitud_det.estado', '3C')->count();
        return $sql;
    }

    //Consulta el numero de candidatos en proceso según el cargo
    public static function CargoEnproceso($id)
    {
        $sql1 = \DB::table('rqpe_solicitud');
        $sql1 = $sql1->join('rqpe_solicitud_det', 'rqpe_solicitud.num_solicitud', '=', 'rqpe_solicitud_det.solicitud');
        $sql = $sql1->where('cargo', $id)->whereIn('rqpe_solicitud_det.estado', ['1I', '2P'])->count();
        return $sql;
    }

    //Solicitudes rechazadas por nómina
    public static function ConRechazosNomina($desde, $hasta)
    {
        $sql1 = \DB::table('rqpe_solicitud')->select('rechazo_nomina')->selectRaw("COUNT(rechazo_nomina) AS cant")->where('rechazo_nomina', '>', 0);

        if (($desde != '') && ($hasta != '')) {
            $sql2 = $sql1->where('fecha_solicita', '>=', $desde)->where('fecha_solicita', '<=', $hasta);
        } else if ($desde != '') {
            $sql2 = $sql1->where('fecha_solicita', '>=', $desde);
        } else if ($hasta != '') {
            $sql2 = $sql1->where('fecha_solicita', '<=', $hasta);
        } else {
            $sql2 = $sql1;
        }

        $sql = $sql2->groupBy('rechazo_nomina')->orderBy('cant', 'DESC')->get();

        return $sql;
    }

    //Solicitudes rechazadas por gerencia
    public static function ConRechazosGerencia($desde, $hasta)
    {
        $sql1 = \DB::table('rqpe_solicitud')->select('rechazo_gerencia')->selectRaw("COUNT(rechazo_gerencia) AS cant")->where('rechazo_gerencia', '>', 0);

        if (($desde != '') && ($hasta != '')) {
            $sql2 = $sql1->where('fecha_solicita', '>=', $desde)->where('fecha_solicita', '<=', $hasta);
        } else if ($desde != '') {
            $sql2 = $sql1->where('fecha_solicita', '>=', $desde);
        } else if ($hasta != '') {
            $sql2 = $sql1->where('fecha_solicita', '<=', $hasta);
        } else {
            $sql2 = $sql1;
        }

        $sql = $sql2->groupBy('rechazo_gerencia')->orderBy('cant', 'DESC')->get();

        return $sql;
    }

    //Solicitudes Canceladas
    public static function ConSolicitudesCanceladas($desde, $hasta)
    {
        $sql1 = \DB::table('rqpe_solicitud')->select('motivo_rechazo')->selectRaw("COUNT(motivo_rechazo) AS cant")->where('motivo_rechazo', '>', 0);

        if (($desde != '') && ($hasta != '')) {
            $sql2 = $sql1->where('fecha_solicita', '>=', $desde)->where('fecha_solicita', '<=', $hasta);
        } else if ($desde != '') {
            $sql2 = $sql1->where('fecha_solicita', '>=', $desde);
        } else if ($hasta != '') {
            $sql2 = $sql1->where('fecha_solicita', '<=', $hasta);
        } else {
            $sql2 = $sql1;
        }

        $sql = $sql2->groupBy('motivo_rechazo')->orderBy('cant', 'DESC')->get();

        return $sql;
    }

    //Motivos por lo que candidatos que fueron rechazados en la entrevista
    public static function ConMotCandRechazadosEntrevistas($desde, $hasta)
    {
        $sql1 = \DB::table('rqpe_solicitud_det')->select('rechazo_entrevista')->selectRaw("COUNT(rechazo_entrevista) AS cant")->where('rechazo_entrevista', '>', 0);

        if (($desde != '') && ($hasta != '')) {
            $sql2 = $sql1->where('fecha_entrevista', '>=', $desde)->where('fecha_entrevista', '<=', $hasta);
        } else if ($desde != '') {
            $sql2 = $sql1->where('fecha_entrevista', '>=', $desde);
        } else if ($hasta != '') {
            $sql2 = $sql1->where('fecha_entrevista', '<=', $hasta);
        } else {
            $sql2 = $sql1;
        }

        $sql = $sql2->groupBy('rechazo_entrevista')->orderBy('cant', 'DESC')->get();

        return $sql;
    }

    //Motivos por lo que candidatos que fueron rechazados en proceso de contratación
    public static function ConMotCandRechazadosContratacion($desde, $hasta)
    {
        $sql1 = \DB::table('rqpe_solicitud_det')->select('rechazo_contrato')->selectRaw("COUNT(rechazo_contrato) AS cant")->where('rechazo_contrato', '>', 0);

        if (($desde != '') && ($hasta != '')) {
            $sql2 = $sql1->where('fecha_contrato', '>=', $desde)->where('fecha_contrato', '<=', $hasta);
        } else if ($desde != '') {
            $sql2 = $sql1->where('fecha_contrato', '>=', $desde);
        } else if ($hasta != '') {
            $sql2 = $sql1->where('fecha_contrato', '<=', $hasta);
        } else {
            $sql2 = $sql1;
        }

        $sql = $sql2->groupBy('rechazo_contrato')->orderBy('cant', 'DESC')->get();

        return $sql;
    }

    public static function getSolitudesCentroOp($centro_operacion)
    {
        $sql = \DB::table('rqpe_solicitud')->whereIn('estado', [1, 3, 5, 9])->where('centro_operacion', $centro_operacion)->orderby('fecha_solicita', 'DESC')->get();
        return $sql;
    }

}
