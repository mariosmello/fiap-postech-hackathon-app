<?php

namespace Database\Seeders;

use App\Models\MedicalSpecialty;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSpecialtySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $specialty = MedicalSpecialty::where('name', 'Cardiologia')->first();
        $user = User::where('email', 'doctor@doctor.com')->first();
        $user->specialties()->attach($specialty->id, ['price' => 150.00]);
    }
}
