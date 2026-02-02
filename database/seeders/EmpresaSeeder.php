<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmpresaSeeder extends Seeder

{
    public function run(): void
    {
         // EMPRESA DE PRUEBA
        DB::table('empresa')->insert([
            'nombre' => 'Empresa Demo',
            'direccion' => 'Calle Principal 1',
            'telefono' => '600000000',
            'email_contacto' => 'empresa@demo.com'
        ]);
    }
}
