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
    Schema::create('empresa', function (Blueprint $table) {
        $table->id('id_empresa');
        $table->string('nombre', 150);
        $table->string('direccion', 200)->nullable();
        $table->string('telefono', 20)->nullable();
        $table->string('email_contacto', 100)->nullable();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresa');
    }
};
