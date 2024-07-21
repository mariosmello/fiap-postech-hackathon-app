<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        Role::updateOrCreate(['name' => 'admin']);
        Role::updateOrCreate(['name' => 'patient']);
        Role::updateOrCreate(['name' => 'doctor']);

        if (!User::where('email', 'doctor@doctor.com')->first()) {
            User::factory()->create([
                'name' => 'Doctor',
                'email' => 'doctor@doctor.com',
                'document' => '81456693085',
                'crm' => '52831999',
                'password' => '123',
            ])->assignRole('doctor');
        }

        User::factory(10)->roleDoctor()->create();

        if (!User::where('email', 'patient1@patient.com')->first()) {
            User::factory()->create([
                'name' => 'Patient 1',
                'email' => 'patient1@patient.com',
                'document' => '19091163194',
                'password' => '123',
            ])->assignRole('patient');
        }

        if (!User::where('email', 'patient2@patient.com')->first()) {
            User::factory()->create([
                'name' => 'Patient 2',
                'email' => 'patient2@patient.com',
                'document' => '31136951040',
                'password' => '123',
            ])->assignRole('patient');
        }

    }
}
