<?php
return new class extends Illuminate\Database\Migrations\Migration {
 public function up(): void {
  Illuminate\Support\Facades\Schema::create('incidencia', function (Illuminate\Database\Schema\Blueprint $table) {
   $table->id('id_incidencia');
   $table->unsignedBigInteger('alumno_id');
   $table->unsignedBigInteger('profesor_id');
   $table->date('fecha');
   $table->text('motivo');
   $table->enum('estado',['pendiente','aceptada','rechazada'])->default('pendiente');
   $table->foreign('alumno_id')->references('id_alumno')->on('alumno');
   $table->foreign('profesor_id')->references('id_profesor')->on('profesor');
  });
 }
 public function down(): void {
  Illuminate\Support\Facades\Schema::dropIfExists('incidencia');
 }
};
