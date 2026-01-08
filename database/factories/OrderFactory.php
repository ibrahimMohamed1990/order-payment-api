<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
public function definition()
{
    return [
        'user_id' => User::factory(),
        'total'   => $this->faker->randomFloat(2, 50, 500),
        'status'  => $this->faker->randomElement([
            Order::STATUS_PENDING,
            Order::STATUS_CONFIRMED
        ]),
    ];
}

}
