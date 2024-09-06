<?php
//SQl Eloquent para conexión con la base de datos de siesa

namespace App\Models\Parametrizacion;

use Illuminate\Database\Eloquent\Model;

class PanelUsuariosSiesa extends Model
 {
  public static function Usuariosactivos()
   {
    $id = "SELECT f200_nit, f200_nombres, f200_apellido1, f200_apellido2, t107.f107_descripcion AS 'Area', w0763.c0763_descripcion AS 'Cargo',
           t285.f285_descripcion AS 'CentroDes', t010.f010_razon_social AS 'Empresa', t015.f015_celular AS 'Tel'
           FROM dbo.t200_mm_terceros AS t200
           LEFT JOIN dbo.t015_mm_contactos AS t015
           ON t200.f200_rowid_contacto = t015.f015_rowid
           LEFT JOIN dbo.t010_mm_companias AS t010
           ON t200.f200_id_cia = t010.f010_id
           LEFT JOIN dbo.w0550_contratos AS w0550
           ON t200.f200_rowid = w0550.c0550_rowid_tercero
           LEFT JOIN dbo.w0763_gh01_cargos AS w0763
           ON w0550.c0550_rowid_cargo = w0763.c0763_rowid
           LEFT JOIN dbo.t107_mc_proyectos AS t107
           ON w0550.c0550_id_proyecto = t107.f107_id AND f107_id_cia=t010.f010_id
           JOIN dbo.t285_co_centro_op AS t285
           ON w0550.c0550_id_co = t285.f285_id AND f285_id_cia = f107_id_cia
           WHERE  t010.f010_id IN ('1','5','4') AND f200_ind_empleado = 1 AND f200_ind_estado = 1 AND c0550_ind_estado = 1
           ORDER BY t010.f010_razon_social, t285.f285_descripcion, t107.f107_descripcion, w0763.c0763_descripcion, f200_nit";
    $sql = \DB::connection('sqlsrv')->select($id);
    return $sql;
   }

  public static function EmpleadoUnico($iden)
   {
    $id = "SELECT COUNT (f200_nit) AS cantidad
           FROM dbo.t200_mm_terceros AS t200
           LEFT JOIN dbo.t015_mm_contactos AS t015
           ON t200.f200_rowid_contacto = t015.f015_rowid
           LEFT JOIN dbo.t010_mm_companias AS t010
           ON t200.f200_id_cia = t010.f010_id
           LEFT JOIN dbo.w0550_contratos AS w0550
           ON t200.f200_rowid = w0550.c0550_rowid_tercero
           LEFT JOIN dbo.w0763_gh01_cargos AS w0763
           ON w0550.c0550_rowid_cargo = w0763.c0763_rowid
           LEFT JOIN dbo.t107_mc_proyectos AS t107
           ON w0550.c0550_id_proyecto = t107.f107_id AND f107_id_cia=t010.f010_id
           JOIN dbo.t285_co_centro_op AS t285
           ON w0550.c0550_id_co = t285.f285_id AND f285_id_cia = f107_id_cia
           WHERE  t010.f010_id IN ('1','5','4') AND f200_ind_empleado = 1 AND f200_ind_estado = 1 AND c0550_ind_estado = 1 AND f200_nit = '$iden' ";
    $sql = \DB::connection('sqlsrv')->select($id);
    return $sql;
   }

  public static function Empleado($iden)
   {
    $id = "SELECT f200_nit, f200_nombres, f200_apellido1, f200_apellido2, t015.f015_celular AS 'Tel', t015.f015_email as 'Correo', f200_fecha_nacimiento,
           w0763.c0763_descripcion AS 'Cargo', t107.f107_descripcion AS 'Area', t010.f010_razon_social AS 'Empresa', t285.f285_descripcion AS 'CentroDes'
           FROM dbo.t200_mm_terceros AS t200
           LEFT JOIN dbo.t015_mm_contactos AS t015
           ON t200.f200_rowid_contacto = t015.f015_rowid
           LEFT JOIN dbo.t010_mm_companias AS t010
           ON t200.f200_id_cia = t010.f010_id
           LEFT JOIN dbo.w0550_contratos AS w0550
           ON t200.f200_rowid = w0550.c0550_rowid_tercero
           LEFT JOIN dbo.w0763_gh01_cargos AS w0763
           ON w0550.c0550_rowid_cargo = w0763.c0763_rowid
           LEFT JOIN dbo.t107_mc_proyectos AS t107
           ON w0550.c0550_id_proyecto = t107.f107_id AND f107_id_cia=t010.f010_id
           JOIN dbo.t285_co_centro_op AS t285
           ON w0550.c0550_id_co = t285.f285_id AND f285_id_cia = f107_id_cia
           WHERE  t010.f010_id IN ('1','5','4') AND f200_ind_empleado = 1 AND f200_ind_estado = 1 AND c0550_ind_estado = 1 AND f200_nit = '$iden'";
    $sql = \DB::connection('sqlsrv')->select($id);
    return $sql;
   }


   public static function EmpleadoTodos()
   {
    $id = "SELECT rtrim(ltrim(f200_nit)) as 'f200_nit', f200_nombres, f200_apellido1, f200_apellido2, t015.f015_celular AS 'Tel', t015.f015_email as 'Correo', f200_fecha_nacimiento,
           REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(
            w0763.c0763_descripcion,
            'Á', 'A'),
            'É', 'E'),
            'Í', 'I'),
            'Ó', 'O'),
            'Ú', 'U')
             AS 'Cargo', REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(
            t107.f107_descripcion,
            'Á', 'A'),
            'É', 'E'),
            'Í', 'I'),
            'Ó', 'O'),
            'Ú', 'U')
            AS 'Area', t010.f010_razon_social AS 'Empresa', t285.f285_descripcion AS 'CentroDes'
           FROM dbo.t200_mm_terceros AS t200
           LEFT JOIN dbo.t015_mm_contactos AS t015
           ON t200.f200_rowid_contacto = t015.f015_rowid
           LEFT JOIN dbo.t010_mm_companias AS t010
           ON t200.f200_id_cia = t010.f010_id
           LEFT JOIN dbo.w0550_contratos AS w0550
           ON t200.f200_rowid = w0550.c0550_rowid_tercero
           LEFT JOIN dbo.w0763_gh01_cargos AS w0763
           ON w0550.c0550_rowid_cargo = w0763.c0763_rowid
           LEFT JOIN dbo.t107_mc_proyectos AS t107
           ON w0550.c0550_id_proyecto = t107.f107_id AND f107_id_cia=t010.f010_id
           JOIN dbo.t285_co_centro_op AS t285
           ON w0550.c0550_id_co = t285.f285_id AND f285_id_cia = f107_id_cia
           WHERE  t010.f010_id IN ('1','5','4') AND f200_ind_empleado = 1 AND f200_ind_estado = 1 AND c0550_ind_estado = 1 ";
    $sql = \DB::connection('sqlsrv')->select($id);
    return collect($sql);
   }
 }
