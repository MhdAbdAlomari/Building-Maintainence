<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RequestFactory extends Factory
{
    public function definition(): array
    {
        // اختار Tenant موجود (بدون ما ننشئ واحد جديد بكل مرة)
        $tenant = User::where('role', 'tenant')->inRandomOrder()->first()
            ?? User::factory()->tenant()->create();

        // اختار عنوان لهذا الـ tenant
        $addressId = Address::where('user_id', $tenant->id)->inRandomOrder()->value('id');

        // إذا ما عنده عنوان (احتياط)
        if (! $addressId) {
            $addressId = Address::factory()->create([
                'user_id' => $tenant->id,
                // region_id موجود ضمن AddressFactory أو حطه هون إذا لازم
            ])->id;
        }

        $service = Service::inRandomOrder()->first() ?? Service::factory()->create();

        $date = $this->faker->dateTimeBetween('now', '+7 days');

        return [
            'tenant_id'      => $tenant->id,
            'technician_id'  => null,
            'service_id'     => $service->id,

           
            'address_id'     => $addressId,

            // إذا لسا عندك region_id بجدول requests ومو حاذفه:
            // خليه يجي من العنوان (مو عشوائي)
            // 'region_id'   => Address::find($addressId)->region_id,

            'status'         => $this->faker->randomElement([
                'pending', 'accepted', 'on_the_way', 'complete', 'canceled'
            ]),
            'title'          => $this->faker->words(3, true),
            'description'    => $this->faker->sentence(12),
            'scheduled_date' => $date->format('Y-m-d'),
            'scheduled_time' => $date->format('H:i:s'),
            'cancellation_reason' => null,
            'canceled_at'    => null,
        ];
    }
}
