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
    Schema::create('pausa', function (Blueprint $table) {
        $table->id('id_pausa');
        $table->unsignedBigInteger('fichaje_id');
        $table->time('hora_inicio');
        $table->time('hora_fin')->nullable();
        $table->integer('duracion')->nullable();

        $table->foreign('fichaje_id')
            ->references('id_fichaje')
            ->on('fichaje');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pausa');
    }
};
