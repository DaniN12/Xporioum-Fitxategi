<?php
return new class extends Illuminate\Database\Migrations\Migration {
 public function up(): void {
  Illuminate\Support\Facades\Schema::create('normas', function (Illuminate\Database\Schema\Blueprint $table) {
   $table->id('id_norma');
   $table->unsignedBigInteger('idioma_id');
   $table->string('titulo',150);
   $table->text('descripcion')->nullable();
   $table->string('archivo_pdf')->nullable();
   $table->foreign('idioma_id')->references('id_idioma')->on('idioma');
  });
 }
 public function down(): void {
  Illuminate\Support\Facades\Schema::dropIfExists('normas');
 }
};
