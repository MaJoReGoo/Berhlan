<?php

namespace App\Models\ArchivoDigital;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanelInsercion extends Model
{
    public static function getInserciones()
    {
        $sql = \DB::table('arch_insercion')->get();
        return $sql;
    }
    public static function InsertInsercion($datos)
    {
        $sql = \DB::table('arch_insercion')->insertGetId($datos);
        return $sql;
    }

    public static function UpdateInsercion($id,$datos)
    {
        $sql = \DB::table('arch_insercion')->where('id_insercion',$id)->update($datos);
        return $sql;
    }

    public static function InsertSolicitud($datos)
    {
        $sql = \DB::table('arch_solicitud')->insert($datos);
        return $sql;
    }

    public static function getSolicitudUltimo()
    {
        $sql = \DB::table('arch_solicitud')->latest("id_solicitud")->first();
        return $sql;
    }

    public static function InsertInsercionSolicitud($datos)
    {
        $sql = \DB::table('arch_insercion_soli')->insert($datos);
        return $sql;
    }

    public static function getSolicitudInsercion($id)
    {
        $sql = \DB::table('arch_insercion_soli AS ais')
            ->select('ais.id_insercion_solicitud','aso.id_solicitud',
                'ai.nombre_entrega', 'ai.fecha_entrega', 'ai.recibido_por', 'ai.fecha_recibe',
                'aso.estado', 'aso.observacion_general', \DB::raw("COUNT(aso.id_solicitud) as cantidad_archivos"))
            ->join('arch_insercion AS ai', 'ais.insercion', '=', 'ai.id_insercion')
            ->join('arch_solicitud AS aso', 'ais.solicitud', '=', 'aso.id_solicitud')
            ->where('ai.nombre_entrega', $id)
            ->groupby('aso.id_solicitud')->get();
        return $sql;
    }

    public static function getSolicitudInserciones()
    {
        $sql = \DB::table('arch_insercion_soli AS ais')
            ->select('ais.id_insercion_solicitud','aso.id_solicitud',
                'ai.nombre_entrega', 'ai.fecha_entrega', 'ai.recibido_por', 'ai.fecha_recibe',
                'aso.estado', 'aso.observacion_general', \DB::raw("COUNT(aso.id_solicitud) as cantidad_archivos"))
            ->join('arch_insercion AS ai', 'ais.insercion', '=', 'ai.id_insercion')
            ->join('arch_solicitud AS aso', 'ais.solicitud', '=', 'aso.id_solicitud')
            ->groupby('aso.id_solicitud')->get();
        return $sql;
    }

    public static function getInsercionSolicitudRecibir($id)
    {
        $sql = \DB::table('arch_insercion_soli as ais')
            ->join('arch_insercion AS ai', 'ais.insercion', '=', 'ai.id_insercion')
            ->join('arch_solicitud AS aso', 'ais.solicitud', '=', 'aso.id_solicitud')
            ->where('aso.id_solicitud', $id)->get();
        return $sql;
    }

    public static function getSolicitud($id)
    {
        $sql = \DB::table('arch_solicitud')->where("id_solicitud",$id)->get();
        return $sql;
    }

    public static function UpdateSolicitud($id,$datos)
    {
        $sql = \DB::table('arch_solicitud')->where('id_solicitud',$id)->update($datos);
        return $sql;
    }

    
}
