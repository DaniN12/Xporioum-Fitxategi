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
    Schema::create('usuario', function (Blueprint $table) {
        $table->id('id_usuario');
        $table->string('email', 100)->unique();
        $table->string('contrasena', 255);
        $table->string('nombre', 100);
        $table->string('dni', 15)->unique();
        $table->unsignedBigInteger('idioma_id');
        $table->dateTime('fecha_creacion')->useCurrent();
        $table->boolean('activo')->default(true);

        $table->foreign('idioma_id')
              ->references('id_idioma')
              ->on('idioma');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario');
    }
};
