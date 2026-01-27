<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void{
    Schema::create('incidencia', function (Blueprint $table) {
        $table->id('id_incidencia');
        $table->unsignedBigInteger('alumno_id');
        $table->unsignedBigInteger('profesor_id');
        $table->date('fecha');
        $table->text('motivo');
        $table->enum('estado', ['pendiente', 'aceptada', 'rechazada'])->default('pendiente');

        $table->foreign('alumno_id')
            ->references('id_alumno')
            ->on('alumno');

        $table->foreign('profesor_id')
            ->references('id_profesor')
            ->on('profesor');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidencia');
    }
};
