<?php

namespace App\Models\ArchivoDigital;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanelFuid extends Model
{
    public static function InsertFuid($datos)
    {
        $sql = \DB::table('arch_fuid')->insert($datos);
        return $sql;
    }

    public static function getUltimoId()
    {
        $sql = \DB::table('arch_fuid')->latest("id_fuid")->first();
        return $sql;
    }

    public static function UpdateFuid($id,$datos)
    {
        $sql = \DB::table('arch_fuid')->where('id_fuid',$id)->update($datos);
        return $sql;
    }

    public static function getFuid($id)
    {
        $sql = \DB::table('arch_fuid')->where("id_fuid",$id)->get();
        return $sql;
    }


}
