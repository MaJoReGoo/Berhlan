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
        Schema::create('trata_inconformidad_persons', function (Blueprint $table) {
            $table->id('id_trata_respon');
            $table->smallInteger('responsable_tratamiento');
            $table->foreign('responsable_tratamiento')->references('id_empleado')->on('param_empleados');
            $table->string('fk_id_trata_inconformidades',100);
            $table->foreign('fk_id_trata_inconformidades')->references('id_trata_inconformidades')->on('trata_inconformidades');
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
        Schema::dropIfExists('trata_inconformidad_persons');
    }
};
