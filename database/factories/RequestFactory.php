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
        $tenant = User::where('role', 'tenant')->inRandomOrder()->first()
            ?? User::factory()->tenant()->create();

        $addressId = Address::where('user_id', $tenant->id)->inRandomOrder()->value('id');

        if (! $addressId) {
            $addressId = Address::factory()->create([
                'user_id' => $tenant->id,
            ])->id;
        }

        $service = Service::inRandomOrder()->first() ?? Service::factory()->create();

        $date = $this->faker->dateTimeBetween('now', '+7 days');

        $status = $this->faker->randomElement([
            'pending',
            'estimate_price',
            'confirmed',
            'processing',
            'awaiting_final_approval',
            'completed',
            'rejected',
            'cancelled',
        ]);

        $estimatedPrice = in_array($status, [
            'estimate_price',
            'confirmed',
            'processing',
            'awaiting_final_approval',
            'completed',
        ])
            ? $this->faker->numberBetween(50000, 300000)
            : null;

        $requestedFinalPrice = $status === 'awaiting_final_approval' && $estimatedPrice
            ? $estimatedPrice + $this->faker->numberBetween(10000, 100000)
            : null;

        $finalPrice = null;

        if ($status === 'completed') {
            $finalPrice = $estimatedPrice
                ? $this->faker->numberBetween((int) ($estimatedPrice * 0.8), $estimatedPrice)
                : $this->faker->numberBetween(50000, 300000);
        }

        return [
            'tenant_id' => $tenant->id,
            'technician_id' => in_array($status, [
                'estimate_price',
                'confirmed',
                'processing',
                'awaiting_final_approval',
                'completed',
            ])
                ? User::where('role', 'technician')->inRandomOrder()->value('id')
                : null,
            'service_id' => $service->id,
            'address_id' => $addressId,

            'status' => $status,
            'title' => $this->faker->words(3, true),
            'description' => $this->faker->sentence(12),
            'scheduled_date' => $date->format('Y-m-d'),
            'scheduled_time' => $date->format('H:i:s'),

            'estimated_price' => $estimatedPrice,
            'estimate_note' => in_array($status, [
                'estimate_price',
                'confirmed',
                'processing',
                'awaiting_final_approval',
                'completed',
            ])
                ? $this->faker->optional()->sentence()
                : null,


            'final_price_syp' => $finalPrice,
            'is_paid' => false,
            'paid_at' => null,

            'cancellation_reason' => $status === 'cancelled'
                ? $this->faker->sentence()
                : null,

            'cancelled_at' => $status === 'cancelled'
                ? now()
                : null,

            'estimated_at' => in_array($status, [
                'estimate_price',
                'confirmed',
                'processing',
                'awaiting_final_approval',
                'completed',
            ])
                ? now()
                : null,

            'confirmed_at' => in_array($status, [
                'confirmed',
                'processing',
                'awaiting_final_approval',
                'completed',
            ])
                ? now()
                : null,

            'processing_at' => in_array($status, [
                'processing',
                'awaiting_final_approval',
                'completed',
            ])
                ? now()
                : null,

            'final_approval_requested_at' => $status === 'awaiting_final_approval'
                ? now()
                : null,

            'completed_at' => $status === 'completed'
                ? now()
                : null,

            'rejected_at' => $status === 'rejected'
                ? now()
                : null,
        ];
    }
}