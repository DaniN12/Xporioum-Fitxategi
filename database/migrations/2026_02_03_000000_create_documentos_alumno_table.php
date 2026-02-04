<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('documentos_alumno', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('nombre', 150);
            $table->string('archivo', 255);
            $table->timestamps();

            // Foreign key correcta según tu BBDD
            $table->foreign('user_id')
                  ->references('id_usuario')
                  ->on('usuario')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('documentos_alumno');
    }
};
