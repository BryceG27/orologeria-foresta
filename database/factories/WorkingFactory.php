<?php

namespace Database\Factories;

use App\Models\Working;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Working>
 */
class WorkingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $customer = \App\Models\Customer::find(fake()->numberBetween(1, 10));

        $delivery_date = fake()->optional()->dateTimeThisYear()->format('Y-m-d');

        return [
            'customer_id' => $customer->is_company ? fake()->numberBetween(1, 10) : $customer->id,
            'company_id' => $customer->is_company ? $customer->id : null,
            'working_id' => Working::max('working_id') + 1,
            'working_status_id' => $delivery_date ? 4 : fake()->numberBetween(1, 3),
            'brand_id' => fake()->numberBetween(1, 8),
            'reference' => fake()->word(),
            'acceptance_date' => fake()->dateTimeThisYear()->format('Y-m-d'),
            'delivery_date' => $delivery_date,
            'working_description' => fake()->sentence(),
            'payment_method_id' => fake()->numberBetween(1, 3),
            'total_cost' => fake()->randomFloat(2, 10, 1000),
            'extra_notes' => fake()->sentence(),
        ];
    }
}
