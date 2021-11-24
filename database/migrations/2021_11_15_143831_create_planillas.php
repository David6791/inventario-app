<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePlanillas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planillas', function (Blueprint $table) {
            $table->id();

            $table->integer('dias_trabajados');
            $table->integer('haber_basico');
            $table->integer('bono_antiguedad');
            $table->integer('nocturnos');
            $table->integer('total_ganado');
            $table->integer('extras');
            $table->integer('afp');
            $table->integer('iva');
            $table->integer('anticipos');
            $table->integer('faltas_sanciones');
            $table->integer('descuentos');
            $table->integer('liquido_pagable');

            $table->unsignedBigInteger('id_mes');
            $table->foreign('id_mes')->references('id')->on('table_meses');
            $table->unsignedBigInteger('id_year');
            $table->foreign('id_year')->references('id')->on('table_years');

            $table->unsignedBigInteger('id_empleado');
            $table->foreign('id_empleado')->references('id')->on('empleados');
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
        Schema::dropIfExists('planillas');
    }
}
