<?php

namespace Database\Factories;

use App\Models\Region;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'              => $this->faker->name(),
            'email'             => $this->faker->unique()->safeEmail(),
            'phone'             => $this->faker->unique()->numerify('09########'),
           'password'          => static::$password ??= Hash::make('password'), 
            'role'              => 'tenant',   //default state
            'address'           => $this->faker->optional()->streetAddress(),
            'region_id'         => Region::factory(),
            'is_active'         => true,
            'email_verified_at' => now(),
        ];
    }

    public function tenant(): static
    {
        return $this->state(fn() => ['role' => 'tenant']);
    }

    public function technician(): static
    {
        return $this->state(fn() => ['role' => 'technician']);
    }

    public function admin(): static
    {
        return $this->state(fn() => ['role' => 'admin']);
    }
}

    /**
     * Indicate that the model's email address should be unverified.
     */
   // public function unverified(): static
    //{
     //   return $this->state(fn (array $attributes) => [
       //     'email_verified_at' => null,
        //]);
   // }
//}
