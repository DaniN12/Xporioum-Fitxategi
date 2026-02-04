<?php
return new class extends Illuminate\Database\Migrations\Migration {
 public function up(): void {
  Illuminate\Support\Facades\Schema::create('alumno', function (Illuminate\Database\Schema\Blueprint $table) {
   $table->id('id_alumno');
   $table->unsignedBigInteger('usuario_id')->unique();
   $table->unsignedBigInteger('profesor_id');
   $table->unsignedBigInteger('empresa_id');
   $table->date('fecha_alta');
   $table->foreign('usuario_id')->references('id_usuario')->on('usuario');
   $table->foreign('profesor_id')->references('id_profesor')->on('profesor');
   $table->foreign('empresa_id')->references('id_empresa')->on('empresa');
  });
 }
 public function down(): void {
  Illuminate\Support\Facades\Schema::dropIfExists('alumno');
 }
};
