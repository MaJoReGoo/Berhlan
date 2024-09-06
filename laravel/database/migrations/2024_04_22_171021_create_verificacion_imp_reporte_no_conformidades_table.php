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
        Schema::create('verifi_reporte_no_conform', function (Blueprint $table) {
            $table->id('id_verificacion_imp_reporte_no_conformidades');
            $table->date('verifica_implementacion_fecha');
            $table->text('verifica_implementacion_observa');
            $table->smallInteger('verifi_imple_respon');
            $table->foreign('verifi_imple_respon')->references('id_empleado')->on('param_empleados');
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
        Schema::dropIfExists('verifi_reporte_no_conform');
    }
};
