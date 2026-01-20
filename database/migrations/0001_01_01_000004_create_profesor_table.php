<?php
return new class extends Illuminate\Database\Migrations\Migration {
 public function up(): void {
  Illuminate\Support\Facades\Schema::create('profesor', function (Illuminate\Database\Schema\Blueprint $table) {
   $table->id('id_profesor');
   $table->unsignedBigInteger('usuario_id')->unique();
   $table->foreign('usuario_id')->references('id_usuario')->on('usuario');
  });
 }
 public function down(): void {
  Illuminate\Support\Facades\Schema::dropIfExists('profesor');
 }
};
