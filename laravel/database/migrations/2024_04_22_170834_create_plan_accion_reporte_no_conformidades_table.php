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
        Schema::create('plan_accion_reporte_no_conform', function (Blueprint $table) {
            $table->id('id_plan_accion_reporte_no_conformidades');
            $table->string('plan_accion_numero',100);
            $table->string('plan_accion_actividad',100);
            $table->smallInteger('plan_accion_responsable');
            $table->foreign('plan_accion_responsable')->references('id_empleado')->on('param_empleados');
            $table->date('plan_accion_fecha_tarea');
            $table->string('fk_id_reporte_conform',100);
            $table->foreign('fk_id_reporte_conform')->references('id_reporte_conform')->on('reportes_no_conform');
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
        Schema::dropIfExists('plan_accion_reporte_no_conform');
    }
};
