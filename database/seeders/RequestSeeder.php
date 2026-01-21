<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Request;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;

class RequestSeeder extends Seeder
{
    public function run(): void
    {
        Request::factory()
            ->count(30)
            ->state(function () {

                $tenantId = User::where('role', 'tenant')->inRandomOrder()->value('id')
                    ?? User::factory()->tenant()->create()->id;

                $addressId = Address::where('user_id', $tenantId)->inRandomOrder()->value('id');

                // احتياط إذا ما عنده عنوان
                if (! $addressId) {
                    $addressId = Address::factory()->create([
                        'user_id' => $tenantId,
                    ])->id;
                }

                return [
                    'tenant_id'     => $tenantId,
                    'technician_id' => User::where('role','technician')->inRandomOrder()->value('id'),
                    'service_id'    => Service::inRandomOrder()->value('id'),

                    // ✅ الجديد
                    'address_id'    => $addressId,

                    // إذا لسا عندك region_id بجدول requests:
                    // 'region_id' => Address::find($addressId)->region_id,
                ];
            })
            ->create();
    }
}
