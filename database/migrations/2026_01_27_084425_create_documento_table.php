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
    Schema::create('documento', function (Blueprint $table) {
        $table->id('id_documento');
        $table->unsignedBigInteger('incidencia_id');
        $table->string('nombre_archivo', 150);
        $table->string('ruta_archivo', 255);
        $table->string('tipo_archivo', 50)->nullable();
        $table->dateTime('fecha_subida')->useCurrent();

        $table->foreign('incidencia_id')
            ->references('id_incidencia')
            ->on('incidencia');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documento');
    }
};
