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
    Schema::create('profesor', function (Blueprint $table) {
        $table->id('id_profesor');
        $table->unsignedBigInteger('usuario_id')->unique();

        $table->foreign('usuario_id')
            ->references('id_usuario')
            ->on('usuario');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profesor');
    }
};
