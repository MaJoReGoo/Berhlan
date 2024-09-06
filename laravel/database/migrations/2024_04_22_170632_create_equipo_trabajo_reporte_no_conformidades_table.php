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
        Schema::create('equip_reporte_no_conform', function (Blueprint $table) {
            $table->id('id_equipo_trabajo_reporte_no_conformidades');
            $table->smallInteger('persona_equipo_trabajo');
            $table->foreign('persona_equipo_trabajo')->references('id_empleado')->on('param_empleados');
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
        Schema::dropIfExists('equip_reporte_no_conform');
    }
};
