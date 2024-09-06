<?php
//SQl Eloquent para conexión con la base de datos

namespace App\Models\Parametrizacion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PanelNotificaciones extends Model
{
    //Listado de Áreas
    public static function getNotificaciones()
    {
        $sql = DB::table('param_notificaciones')->orderby('id', 'DESC')->get();
        return $sql;
    }

    //Cantidad de áreas activas
    public static function getCantidadNotificaciones()
    {
        $sql = DB::table('param_notificaciones')->orderby('id', 'DESC')->count();
        return $sql;
    }


    public static function getNotificacion($id)
    {
        $sql = DB::table('param_notificaciones')->where('id', $id)->first();
        return $sql;
    }

    public static function insertarNotificacion($datos)
    {
        $sql = DB::table('param_notificaciones')->insert($datos);
        return $sql;
    }

    //Actualiza la información
    public static function actualizarNotificacion($id, $datos)
    {
        $sql = DB::table('param_notificaciones')->where('id', $id)->update($datos);
        return $sql;
    }

    public static function UltimaNotificacion()
    {
        $sql = DB::table('param_notificaciones')->orderby('id', 'DESC')->first();
        return $sql;
    }
}
