<?php

// database/factories/PaymentFactory.php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\Request as WorkRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        $req = WorkRequest::inRandomOrder()->first() ?? WorkRequest::factory()->create();

        return [
            'request_id' => $req->id,
            'tenant_id' => $req->tenant_id,
            'amount_usd_cents' => $this->faker->numberBetween(50, 2000),
            'currency' => 'usd',
            'status' => $this->faker->randomElement(['pending','paid']),
            'stripe_session_id' => $this->faker->uuid(),
            'stripe_payment_intent_id' => null,
        ];
    }

    public function paid(): static
    {
        return $this->state(fn () => ['status' => 'paid']);
    }
}
