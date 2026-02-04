<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        // PROFESOR
        DB::table('usuario')->updateOrInsert(
            ['email' => 'profesor@gmail.com'],
            [
                'contrasena' => Hash::make('123456'),
                'nombre' => 'Profesor',
                'dni' => '00000000A',
                'idioma_id' => 1,
                'activo' => true,
                'rol' => 'profesor',

            ]
        );

        // ALUMNO
        DB::table('usuario')->updateOrInsert(
            ['email' => 'alumno@gmail.com'],
            [
                'contrasena' => Hash::make('123456'),
                'nombre' => 'Alumno',
                'dni' => '11111111A',
                'idioma_id' => 1,
                'activo' => true,
                'rol' => 'alumno',
                
            ]
        );
    }
}
