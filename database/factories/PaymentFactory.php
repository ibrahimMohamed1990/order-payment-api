<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
 public function definition()
{
    return [
        'payment_method' => $this->faker->randomElement(['credit_card', 'paypal']),
        'status'         => $this->faker->randomElement(['successful', 'failed']),
    ];
}

}
