<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;


class CompanySeeder extends Seeder
{
    public function run(): void
    {
        $companies = [
            ['name' => 'TechSolutions', 'street' => 'Gran Vía 12', 'workers' => 120],
            ['name' => 'Innovatek', 'street' => 'Autonomía 45', 'workers' => 80],
            ['name' => 'CodeFactory', 'street' => 'Bilbao 7', 'workers' => 60],
            ['name' => 'DataCorp', 'street' => 'Independencia 33', 'workers' => 200],
            ['name' => 'NetSystems', 'street' => 'Zabalburu 18', 'workers' => 40],
            ['name' => 'SoftWare SL', 'street' => 'Santutxu 9', 'workers' => 25],
            ['name' => 'CyberGroup', 'street' => 'Ercilla 55', 'workers' => 150],
            ['name' => 'CloudNine', 'street' => 'Avenida Norte 101', 'workers' => 90],
            ['name' => 'DevHouse', 'street' => 'Ibañez 4', 'workers' => 30],
            ['name' => 'AI Labs', 'street' => 'Plaza Central 1', 'workers' => 70],
        ];

        foreach ($companies as $company) {
            Company::create($company);
        }
    }
}
