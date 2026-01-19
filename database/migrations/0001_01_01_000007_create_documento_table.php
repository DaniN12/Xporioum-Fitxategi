<?php
return new class extends Illuminate\Database\Migrations\Migration {
 public function up(): void {
  Illuminate\Support\Facades\Schema::create('documento', function (Illuminate\Database\Schema\Blueprint $table) {
   $table->id('id_documento');
   $table->unsignedBigInteger('incidencia_id');
   $table->string('nombre_archivo',150);
   $table->string('ruta_archivo');
   $table->string('tipo_archivo',50)->nullable();
   $table->dateTime('fecha_subida')->useCurrent();
   $table->foreign('incidencia_id')->references('id_incidencia')->on('incidencia');
  });
 }
 public function down(): void {
  Illuminate\Support\Facades\Schema::dropIfExists('documento');
 }
};
