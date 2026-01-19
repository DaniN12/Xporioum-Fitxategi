<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
 public function up(): void {
  Schema::create('idioma', function (Blueprint $table) {
   $table->id('id_idioma');
   $table->string('nombre',50);
   $table->string('codigo',5)->unique();
  });
 }
 public function down(): void {
  Schema::dropIfExists('idioma');
 }
};
