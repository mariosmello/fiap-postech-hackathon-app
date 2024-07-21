<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (!User::where('email', 'unidentified@unidentified.com')->first()) {
            User::factory()->create([
                'name' => 'Unidentified User',
                'email' => 'unidentified@unidentified.com',
                'password' => '123',
            ]);
        }
    }
}
