<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Customer;

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
    public function definition(): array
    {
        // Pick a random customer
        $customer = Customer::inRandomOrder()->first() ?? Customer::factory()->create();

        // Random order status and payment status
        $orderStatuses = ['pending', 'processing', 'completed', 'cancelled'];
        $paymentStatuses = ['pending', 'paid', 'failed'];
        $paymentMethods = ['Cash', 'Credit Card', 'GCash', 'Bank Transfer'];

        return [
            'customer_id' => $customer->customer_id,
            'order_date' => $this->faker->dateTimeThisMonth(),
            'order_status' => $this->faker->randomElement($orderStatuses),
            'total_amount' => 0, // will be updated later after creating order details
            'payment_status' => $this->faker->randomElement($paymentStatuses),
            'payment_method' => $this->faker->randomElement($paymentMethods),
            'shipping_address' => $this->faker->address(),
        ];
    }
}
