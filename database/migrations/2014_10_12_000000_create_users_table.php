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
        Schema::create('users', function (Blueprint $table) {
            $table->id('usId');
            $table->string('usMail')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('usDocumento', 20);
            $table->string('usPassword', 100);
            $table->string('usApellido', 100);
            $table->string('usNombre', 100);
            $table->string('usTelefono', 20);
            $table->string('usDomicilio', 200);
            $table->string('usLocalidad');

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
        Schema::dropIfExists('users');
    }
};
