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
    Schema::create('pin', function (Blueprint $table) {
        $table->id('id_pin');
        $table->string('codigo_pin', 10);
        $table->unsignedBigInteger('profesor_id');
        $table->dateTime('fecha_creacion')->useCurrent();
        $table->dateTime('fecha_expiracion')->nullable();
        $table->boolean('activo')->default(true);

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
        Schema::dropIfExists('pin');
    }
};
