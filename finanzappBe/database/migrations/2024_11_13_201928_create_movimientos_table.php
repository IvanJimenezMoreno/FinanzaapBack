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
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id('id_movimiento');
            $table->unsignedBigInteger('id_usuario');
            $table->decimal('monto', 8, 2);
            $table->enum('tipo', ['ingreso', 'gasto']);
            $table->string('categoria');
            $table->date('fecha');
            $table->text('notas')->nullable();
            $table->timestamps();

            // Definir la clave foránea
            $table->foreign('id_usuario')->references('id')->on('usuarios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movimientos');
    }
};
