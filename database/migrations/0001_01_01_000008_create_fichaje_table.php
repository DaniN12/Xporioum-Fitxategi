<?php
return new class extends Illuminate\Database\Migrations\Migration {
 public function up(): void {
  Illuminate\Support\Facades\Schema::create('fichaje', function (Illuminate\Database\Schema\Blueprint $table) {
   $table->id('id_fichaje');
   $table->unsignedBigInteger('alumno_id');
   $table->unsignedBigInteger('pin_id');
   $table->date('fecha');
   $table->time('hora_entrada');
   $table->time('hora_salida')->nullable();
   $table->decimal('total_horas',5,2)->nullable();
   $table->foreign('alumno_id')->references('id_alumno')->on('alumno');
   $table->foreign('pin_id')->references('id_pin')->on('pin');
  });
 }
 public function down(): void {
  Illuminate\Support\Facades\Schema::dropIfExists('fichaje');
 }
};
