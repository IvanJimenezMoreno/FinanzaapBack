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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id('id_pago');
            $table->unsignedBigInteger('id_usuario');
            $table->string('nombre_pago');
            $table->date('fecha_pago');
            $table->decimal('monto_pago', 8, 2);
            $table->boolean('estado_pago');
            $table->boolean('recordatorio_activado');
            $table->string('descripcion')->nullable(); 

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
        Schema::dropIfExists('pagos');
    }
};
