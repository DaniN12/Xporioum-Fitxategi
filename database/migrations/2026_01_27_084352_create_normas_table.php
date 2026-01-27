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
    Schema::create('normas', function (Blueprint $table) {
        $table->id('id_norma');
        $table->unsignedBigInteger('idioma_id');
        $table->string('titulo', 150);
        $table->text('descripcion')->nullable();
        $table->string('archivo_pdf', 255)->nullable();

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
        Schema::dropIfExists('normas');
    }
};
