<?php
return new class extends Illuminate\Database\Migrations\Migration {
 public function up(): void {
  Illuminate\Support\Facades\Schema::create('empresa', function (Illuminate\Database\Schema\Blueprint $table) {
   $table->id('id_empresa');
   $table->string('nombre',150);
   $table->string('direccion',200)->nullable();
   $table->string('telefono',20)->nullable();
   $table->string('email_contacto',100)->nullable();
  });
 }
 public function down(): void {
  Illuminate\Support\Facades\Schema::dropIfExists('empresa');
 }
};
