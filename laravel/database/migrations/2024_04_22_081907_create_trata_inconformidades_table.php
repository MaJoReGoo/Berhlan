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
        Schema::create('trata_inconformidades', function (Blueprint $table) {
                $table->string('id_trata_inconformidades', 100)->primary()->nullable(false);
                $table->date('fecha_inconformidad');
                $table->text('descripcion_no_conformidad');
                $table->string('inconformidad', 25);
                $table->smallInteger('detectado_persona');
                $table->foreign('detectado_persona')->references('id_empleado')->on('param_empleados');
                $table->date('fecha_detectada');
                $table->date('fecha_responsable');
                $table->smallInteger('area_trata');
                $table->foreign('area_trata')->references('id_area')->on('param_areas');
                $table->string('tratamiento_producto', 20);
                $table->text('descripcion_tratamiento');
                $table->date('fecha_seguimiento');
                $table->smallInteger('seg_realizado_responsable');
                $table->foreign('seg_realizado_responsable')->references('id_empleado')->on('param_empleados');
                $table->string('eficaz_tratamiento', 2);
                $table->text('conclusion_final');
                $table->string('evidencia_si_aplica', 100);
                $table->string('niveles_no_conformidad', 10);
                $table->smallInteger('verifi_aprobado_responsable');
                $table->foreign('verifi_aprobado_responsable')->references('id_empleado')->on('param_empleados');
                $table->date('verifi_cierre_fecha');
                $table->string('verifi_accion_correctiva', 2);
                $table->string('relacione_ac');
                $table->smallInteger('verifi_proc_responsable');
                $table->foreign('verifi_proc_responsable')->references('id_empleado')->on('param_empleados');
                $table->string('verifi_plan_accion');
                $table->date('verifi_plan_accion_fecha');
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
        Schema::dropIfExists('trata_inconformidades');
    }
};
