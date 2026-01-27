<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfesorSeeder extends Seeder
{

    public function run(): void
    {
        $profesor =DB::table('usuario')->where('rol', 'profesor')->first();
 // PROFESOR (relación 1–1)
        DB::table('profesor')->insert([
            'usuario_id' => $profesor->id_usuario
        ]);
        }
}
