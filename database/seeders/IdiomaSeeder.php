<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class IdiomaSeeder extends Seeder
{

    public function run(): void
    {
         DB::table('idioma')->insert([
            ['nombre' => 'Castellano', 'codigo' => 'es'],
            ['nombre' => 'Euskera', 'codigo' => 'eu'],
        ]);
    }
}
