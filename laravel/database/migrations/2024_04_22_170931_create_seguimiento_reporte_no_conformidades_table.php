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
        Schema::create('segui_reporte_no_conform', function (Blueprint $table) {
            $table->id('id_segui_reporte_no_conformidades');
            $table->date('seguimiento_plan_fecha');
            $table->string('seguimiento_numero',100);
            $table->text('seguimiento_actividad_tarea');
            $table->text('seguimiento_compromisos');
            $table->smallInteger('seguimiento_responsable');
            $table->foreign('seguimiento_responsable')->references('id_empleado')->on('param_empleados');
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
        Schema::dropIfExists('segui_reporte_no_conform');
    }
};
