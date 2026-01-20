<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // IDIOMAS
        DB::table('idioma')->insert([
            ['nombre' => 'Castellano', 'codigo' => 'es'],
            ['nombre' => 'Euskera', 'codigo' => 'eu'],
        ]);

        // USUARIO ADMIN
        DB::table('usuario')->insert([
            'email' => 'admin@centro.local',
            'contrasena' => Hash::make('password'),
            'nombre' => 'Administrador',
            'dni' => '00000000A',
            'idioma_id' => 1,
            'activo' => true
        ]);

        // PROFESOR (relación 1–1)
        DB::table('profesor')->insert([
            'usuario_id' => 1
        ]);

        // EMPRESA DE PRUEBA
        DB::table('empresa')->insert([
            'nombre' => 'Empresa Demo',
            'direccion' => 'Calle Principal 1',
            'telefono' => '600000000',
            'email_contacto' => 'empresa@demo.com'
        ]);
    }

}
