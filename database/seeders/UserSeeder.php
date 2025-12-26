<?php

namespace Database\Seeders;

use App\Models\Region;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // أدمن واحد
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name'       => 'Admin',
                 'password'   => Hash::make('password'),
                'role'       => 'admin',
                'phone'      => '0999999999',
                'region_id'  => Region::inRandomOrder()->value('id'),
                'is_active'  => true,
            ]
        );

        // 15 مستأجر + 10 فنيين (بسيطة)
        User::factory()->tenant()->count(15)->create();
        User::factory()->technician()->count(10)->create();
    }
}
