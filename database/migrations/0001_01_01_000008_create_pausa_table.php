<?php
return new class extends Illuminate\Database\Migrations\Migration {
 public function up(): void {
  Illuminate\Support\Facades\Schema::create('pausa', function (Illuminate\Database\Schema\Blueprint $table) {
   $table->id('id_pausa');
   $table->unsignedBigInteger('fichaje_id');
   $table->time('hora_inicio');
   $table->time('hora_fin')->nullable();
   $table->integer('duracion')->nullable();
   $table->foreign('fichaje_id')->references('id_fichaje')->on('fichaje');
  });
 }
 public function down(): void {
  Illuminate\Support\Facades\Schema::dropIfExists('pausa');
 }
};
