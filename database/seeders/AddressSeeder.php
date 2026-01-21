<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Region;
use App\Models\User;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    public function run(): void
    {
        // لازم يكون في Regions
        if (Region::count() === 0) {
            $this->command?->warn('No regions found. Seed regions first.');
            return;
        }

        // إذا بدك تقتصر على tenants فقط:
        // $users = User::where('role', 'tenant')->get();
        $users = User::all();

        if ($users->count() === 0) {
            $this->command?->warn('No users found. Seed users first.');
            return;
        }

        foreach ($users as $user) {
            // لكل مستخدم: 1 إلى 3 عناوين
            $count = rand(1, 3);

            // أنشئ عناوين للمستخدم
            $addresses = Address::factory()
                ->count($count)
                ->create([
                    'user_id' => $user->id,
                    'region_id' => Region::inRandomOrder()->value('id'),
                ]);

            // خلّي واحد منهم default (إذا ما فيه default قبل)
            if (! $user->addresses()->where('is_default', true)->exists()) {
                $addresses->first()->update([
                    'is_default' => true,
                    'label' => $addresses->first()->label ?? 'Home',
                ]);
            }
        }

        $this->command?->info('Addresses seeded successfully ✅');
    }
}
