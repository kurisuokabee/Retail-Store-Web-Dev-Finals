<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderDetail>
 */
class OrderDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {   
        $product = Product::inRandomOrder()->first();

        $quantity = rand(1, 5);

        return [
            'product_id' => $product->product_id ?? Product::factory()->create()->product_id,
            'quantity' => $quantity,
            'unit_price' => $product->unit_price ?? 100,
            'subtotal' => ($product->unit_price ?? 100) * $quantity,
        ];
    }
}
