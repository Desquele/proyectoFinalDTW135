<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    /*
        Creación de la tabla tickets con los campos titulo, descripción, usuario_id (se crea la relación con la tabla users), estado
    */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
        $table->id();
        $table->string('titulo');
        $table->text('descripcion');
        $table->unsignedBigInteger('usuario_id');
        $table->enum('estado', ['abierto', 'cerrado'])->default('abierto');
        $table->timestamps();

        // se hace la relación con el campo id de la tabla usuarios
        $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
