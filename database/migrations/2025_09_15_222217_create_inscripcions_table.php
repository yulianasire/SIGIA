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
        Schema::create('inscripciones', function (Blueprint $table) {
            $table->id('insId');
            $table->foreignId('idEstudiante')->constrained('users', 'usId');
            $table->foreignId('idMateria')->constrained('materias', 'matId');
            $table->string('insCicloLectivo', 20);
            $table->enum('insEstado', ['pendiente', 'aprobada', 'rechazada'])->default('pendiente');
            $table->unique(['idEstudiante', 'idMateria', 'insCicloLectivo']);
            $table->rememberToken();
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
        Schema::dropIfExists('inscripciones');
    }
};
