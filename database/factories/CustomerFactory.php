<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $is_company = fake()->boolean();

        return [
            'name' => !$is_company ? fake()->firstName() : null,
            'surname' => !$is_company ? fake()->lastName() : null,
            'company_name' => $is_company ? fake()->company() : null,
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'is_company' => $is_company,
            'notes' => fake()->sentence(),
        ];
    }
}
