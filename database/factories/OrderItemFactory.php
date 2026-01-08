<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
 public function definition()
{
    return [
        'product_name' => $this->faker->word(),
        'quantity'     => rand(1, 3),
        'price'        => $this->faker->randomFloat(2, 10, 100),
    ];
}

}
