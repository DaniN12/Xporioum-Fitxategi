<?php
return new class extends Illuminate\Database\Migrations\Migration {
 public function up(): void {
  Illuminate\Support\Facades\Schema::create('pin', function (Illuminate\Database\Schema\Blueprint $table) {
   $table->id('id_pin');
   $table->string('codigo_pin',10);
   $table->unsignedBigInteger('profesor_id');
   $table->dateTime('fecha_creacion')->useCurrent();
   $table->dateTime('fecha_expiracion')->nullable();
   $table->boolean('activo')->default(true);
   $table->foreign('profesor_id')->references('id_profesor')->on('profesor');
  });
 }
 public function down(): void {
  Illuminate\Support\Facades\Schema::dropIfExists('pin');
 }
};
