<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */


    public function run(): void
    {
        User::create([
        'name' => 'Profesor Admin',
        'email' => 'profesor@sanluis.com',
        'dni' => '00000000A',
        'company' => 'Centro San Luis',
        'password' => Hash::make('password'),
        'role' => 'teacher',
    ]);
    }
}
