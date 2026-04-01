<?php

namespace Database\Seeders;

use App\Models\Request as WorkRequest;
use Illuminate\Database\Seeder;

class RequestAdditionSeeder extends Seeder
{
    public function run(): void
    {
        $requests = WorkRequest::where('status', 'awaiting_final_approval')->get();

        foreach ($requests as $request) {
            $count = rand(1, 3);

            for ($i = 0; $i < $count; $i++) {
                $request->additions()->create([
                    'name' => fake()->randomElement([
                        'Pipe replacement',
                        'Valve replacement',
                        'Extra labor',
                        'Sealant material',
                        'Wiring accessory',
                    ]),
                    'price_syp' => fake()->numberBetween(5000, 50000),
                ]);
            }

            $request->update([
                'final_approval_requested_at' => now(),
            ]);
        }
    }
}