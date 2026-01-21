<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AddressesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'   =>$user_id,
            'region_id'      => $region->id,
            'address_text'   => $this->faker->streetAddress(),
            'latitude'  => $this->faker->randomFloat(8, 33.40, 33.60),
            'longitude' => $this->faker->randomFloat(8, 36.15, 36.40),
        ];
    }
}
