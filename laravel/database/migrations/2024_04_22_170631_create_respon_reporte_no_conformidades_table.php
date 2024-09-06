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
        Schema::create('res_reporte_no_conform', function (Blueprint $table) {
            $table->id('id_respon_reporte_no_conformidades');
            $table->smallInteger('responsable_no_conformidad');
            $table->foreign('responsable_no_conformidad')->references('id_empleado')->on('param_empleados');
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
        Schema::dropIfExists('res_reporte_no_conform');
    }
};
