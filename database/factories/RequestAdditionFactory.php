<?php

namespace Database\Factories;

use App\Models\Request;
use Illuminate\Database\Eloquent\Factories\Factory;

class RequestAdditionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'request_id' => Request::inRandomOrder()->value('id') ?? Request::factory(),
            'name' => $this->faker->randomElement([
                'Pipe replacement',
                'Valve replacement',
                'Extra labor',
                'Sealant material',
                'Wiring accessory',
            ]),
            'price_syp' => $this->faker->numberBetween(1000, 1000000),
        ];
    }
}