<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = $this->faker->randomElement(['sent', 'late', 'paid', 'cancelled']);

        return [
            'customer' => $this->faker->name,
            'number' => 'FA-'.$this->faker->unique()->numberBetween(1000, 9999),
            'status' => $status,
            'sent_at' => $this->faker->dateTimeBetween('-1 year'),
            'paid_at' => ($status === 'paid') ? $this->faker->dateTimeBetween('-1 year') : null,
        ];
    }

    public function paid(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'paid',
                'paid_at' => now(),
            ];
        });
    }

    public function late(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'late',
                'paid_at' => null,
            ];
        });
    }
}
