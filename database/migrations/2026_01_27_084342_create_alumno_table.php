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
    Schema::create('alumno', function (Blueprint $table) {
        $table->id('id_alumno');
        $table->unsignedBigInteger('usuario_id')->unique();
        $table->unsignedBigInteger('profesor_id');
        $table->unsignedBigInteger('empresa_id');
        $table->date('fecha_alta');

        $table->foreign('usuario_id')
            ->references('id_usuario')
            ->on('usuario');

        $table->foreign('profesor_id')
            ->references('id_profesor')
            ->on('profesor');

        $table->foreign('empresa_id')
            ->references('id_empresa')
            ->on('empresa');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumno');
    }
};
