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
        Schema::create('ahorros', function (Blueprint $table) {
            $table->id('id_ahorro');
            $table->unsignedBigInteger('id_usuario');
            $table->string('nombre_objetivo');
            $table->decimal('monto_objetivo', 8, 2);
            $table->decimal('monto_actual', 8, 2);

            // Definir la clave foránea
            $table->foreign('id_usuario')->references('id')->on('usuarios')->onDelete('cascade');

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
        Schema::dropIfExists('ahorros');
    }
};
