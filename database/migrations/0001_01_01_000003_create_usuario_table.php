<?php
return new class extends Illuminate\Database\Migrations\Migration {
 public function up(): void {
  Illuminate\Support\Facades\Schema::create('usuario', function (Illuminate\Database\Schema\Blueprint $table) {
   $table->id('id_usuario');
   $table->string('email',100)->unique();
   $table->string('contrasena');
   $table->string('nombre',100);
   $table->string('dni',15)->unique();
   $table->unsignedBigInteger('idioma_id');
   $table->dateTime('fecha_creacion')->useCurrent();
   $table->boolean('activo')->default(true);
   $table->foreign('idioma_id')->references('id_idioma')->on('idioma');
  });
 }
 public function down(): void {
  Illuminate\Support\Facades\Schema::dropIfExists('usuario');
 }
};
