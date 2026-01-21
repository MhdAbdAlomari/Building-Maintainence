<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Region;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition(): array
    {
        // نطاق تقريبي لسوريا (عدّل إذا بدك)
        $lat = $this->faker->latitude(32.5, 34.5);
        $lng = $this->faker->longitude(35.5, 38.5);

        return [
            'user_id'      => User::inRandomOrder()->value('id') ?? User::factory(),
            'region_id'    => Region::inRandomOrder()->value('id'),
            'label'        => $this->faker->randomElement(['Home', 'Work', 'Other', null]),
            'address_text' => $this->faker->streetAddress(),
            'latitude'     => $lat,
            'longitude'    => $lng,
            'is_default'   => false,
        ];
    }

    /**
     * عنوان افتراضي للمستخدم
     */
    public function default(): static
    {
        return $this->state(fn () => [
            'is_default' => true,
            'label' => 'Home',
        ]);
    }
}
