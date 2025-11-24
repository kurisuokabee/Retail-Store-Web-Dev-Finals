<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use App\Models\Supplier;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = Category::all();
        $suppliers = Supplier::all();

        // Pick a random category
        $category = $categories->random();
        $supplier = $suppliers->random();

        // Realistic product examples per category
        $productsByCategory = [
            'Electronics' => [
                ['name' => 'Wireless Headphones', 'description' => 'High-quality over-ear wireless headphones with noise cancellation.'],
                ['name' => 'Smartphone X100', 'description' => 'Latest generation smartphone with OLED display and 128GB storage.'],
                ['name' => 'Bluetooth Speaker', 'description' => 'Portable Bluetooth speaker with deep bass and 12-hour battery life.'],
            ],
            'Clothing' => [
                ['name' => 'Men\'s Casual Shirt', 'description' => 'Comfortable cotton shirt, available in multiple colors and sizes.'],
                ['name' => 'Women\'s Denim Jeans', 'description' => 'Slim-fit denim jeans, perfect for casual outings.'],
                ['name' => 'Unisex Hoodie', 'description' => 'Soft fleece hoodie, suitable for all genders and all seasons.'],
            ],
            'Home & Kitchen' => [
                ['name' => 'Stainless Steel Cookware Set', 'description' => '10-piece premium stainless steel pots and pans.'],
                ['name' => 'Vacuum Cleaner', 'description' => 'Bagless vacuum cleaner with HEPA filter for home use.'],
                ['name' => 'LED Desk Lamp', 'description' => 'Adjustable desk lamp with energy-saving LED bulbs.'],
            ],
            'Books' => [
                ['name' => 'Mystery Novel: The Silent Night', 'description' => 'A thrilling mystery novel that keeps you on the edge of your seat.'],
                ['name' => 'Learning Laravel', 'description' => 'Comprehensive guide to mastering Laravel framework.'],
                ['name' => 'Children\'s Story Book', 'description' => 'Fun and educational stories for children aged 5-10.'],
            ],
            'Toys' => [
                ['name' => 'Building Blocks Set', 'description' => 'Creative toy blocks for building and learning.'],
                ['name' => 'Remote Control Car', 'description' => 'Fast RC car suitable for indoor and outdoor play.'],
                ['name' => 'Puzzle Game', 'description' => 'Challenging puzzle game for all ages.'],
            ],
        ];

        // Pick a random product from the selected category
        $productData = $productsByCategory[$category->category_name][array_rand($productsByCategory[$category->category_name])];

        return [
            'product_name' => $productData['name'],
            'description' => $productData['description'],
            'category_id' => $category->category_id,
            'supplier_id' => $supplier->supplier_id,
            'unit_price' => $this->faker->randomFloat(2, 50, 500),
            'cost_price' => $this->faker->randomFloat(2, 20, 300),
            'is_active' => true,
        ];
    }
}
