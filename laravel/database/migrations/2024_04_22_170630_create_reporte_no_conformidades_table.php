<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reportes_no_conform', function (Blueprint $table) {
            $table->string('id_reporte_conform',100)->primary()->nullable(false);
            $table->string('sistema_de_gestion',45);
            $table->string('ciclo_auditoria',30);
            $table->string('lugar',15);
            $table->date('fecha_elaboracion');
            $table->string('fuente_no_conforme',25);
            $table->smallInteger('proceso_no_conforme');
            $table->foreign('proceso_no_conforme')->references('id_area')->on('param_areas');
            $table->smallInteger('nombre_reporte_proceso');
            $table->foreign('nombre_reporte_proceso')->references('id_empleado')->on('param_empleados');
            $table->string('tipo_proceso_no_conforme',15);
            $table->text('descripcion_no_conformidad');
            $table->string('impacto_no_conformidad',8);
            $table->string('requerimiento_no_conformidad',20);
            $table->text('analisis_mano_de_obra');
            $table->text('analisis_maquinaria');
            $table->text('analisis_metodo');
            $table->text('analisis_materiales');
            $table->text('analisis_medio_ambiente');
            $table->text('analisis_otros_factores');
            $table->string('plan_accion',5);
            $table->date('prog_cierre_fecha');
            $table->smallInteger('prog_cierre_responsable');
            $table->foreign('prog_cierre_responsable')->references('id_empleado')->on('param_empleados');
            $table->date('cierre_real_fecha');
            $table->smallInteger('cierre_real_responsable');
            $table->foreign('cierre_real_responsable')->references('id_empleado')->on('param_empleados');
            $table->string('estado_reporte',15);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reportes_no_conform');
    }
};
