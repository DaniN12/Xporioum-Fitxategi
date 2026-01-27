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
    Schema::create('fichaje', function (Blueprint $table) {
        $table->id('id_fichaje');
        $table->unsignedBigInteger('alumno_id');
        $table->unsignedBigInteger('pin_id');
        $table->date('fecha');
        $table->time('hora_entrada');
        $table->time('hora_salida')->nullable();
        $table->decimal('total_horas', 5, 2)->nullable();

        $table->foreign('alumno_id')
            ->references('id_alumno')
            ->on('alumno');

        $table->foreign('pin_id')
            ->references('id_pin')
            ->on('pin');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fichaje');
    }
};
