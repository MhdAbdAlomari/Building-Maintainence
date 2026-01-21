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
        $this->call(
            [
                RegionSeeder::class,
                ServiceSeeder::class,
                UserSeeder::class,
                TechnicianDetailSeeder::class,
                RequestSeeder::class,
                MediaSeeder::class,
                AddressSeeder::class
                
                
            ]
            );
    }
}
