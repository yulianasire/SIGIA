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
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id('asisId');
            $table->foreignId('idEstudiante')->constrained('users','usId')->onDelete('cascade');
            $table->date('asisFecha');
            $table->enum('asisEstado', ['presente', 'ausente', 'justificada']);
            $table->boolean('asisFalta')->default(false);
            $table->foreignId('idIncripcion')->nullable()->constrained('inscripciones', 'insId')->onDelete('set null');
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
        Schema::dropIfExists('asistencias');
    }
};
