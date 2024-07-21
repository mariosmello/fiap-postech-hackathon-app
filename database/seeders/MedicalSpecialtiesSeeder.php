<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicalSpecialtiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $specialties = [
            ['name' => 'Cardiologia', 'description' => 'Estudo e tratamento do coração e dos vasos sanguíneos.'],
            ['name' => 'Dermatologia', 'description' => 'Estudo e tratamento da pele, cabelos e unhas.'],
            ['name' => 'Neurologia', 'description' => 'Estudo e tratamento do sistema nervoso.'],
            ['name' => 'Pediatria', 'description' => 'Estudo e tratamento de crianças e adolescentes.'],
            ['name' => 'Ginecologia', 'description' => 'Estudo e tratamento do sistema reprodutor feminino.'],
            ['name' => 'Ortopedia', 'description' => 'Estudo e tratamento do sistema musculoesquelético.'],
            ['name' => 'Psiquiatria', 'description' => 'Estudo e tratamento dos transtornos mentais.'],
            ['name' => 'Oftalmologia', 'description' => 'Estudo e tratamento dos olhos.'],
            ['name' => 'Otorrinolaringologia', 'description' => 'Estudo e tratamento do ouvido, nariz e garganta.'],
            ['name' => 'Urologia', 'description' => 'Estudo e tratamento do sistema urinário e do sistema reprodutor masculino.'],
        ];

        DB::table('medical_specialties')->insert($specialties);

    }
}
