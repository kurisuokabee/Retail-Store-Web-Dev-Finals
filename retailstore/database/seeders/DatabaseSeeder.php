<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Inventory;
use App\Models\Customer;
use App\Models\AdminUser;
use App\Models\Order;
use App\Models\OrderDetail;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // -------------------------------
        // Seed Categories
        // -------------------------------
        $categories = [
            ['category_name' => 'Electronics', 'description' => 'Gadgets, devices, and electronic accessories'],
            ['category_name' => 'Clothing', 'description' => 'Men and women apparel'],
            ['category_name' => 'Home & Kitchen', 'description' => 'Appliances, furniture, and kitchenware'],
            ['category_name' => 'Books', 'description' => 'Novels, textbooks, and magazines'],
            ['category_name' => 'Toys', 'description' => 'Kids toys and games'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['category_name' => $category['category_name']],
                ['description' => $category['description'], 'is_active' => true]
            );
        }

        // -------------------------------
        // Seed Suppliers
        // -------------------------------
        $suppliers = [
            ['supplier_name' => 'TechCorp', 'contact_person' => 'Alice Johnson', 'email' => 'alice@techcorp.com', 'phone' => '09123456789', 'address' => '123 Tech Street, Manila'],
            ['supplier_name' => 'FashionHub', 'contact_person' => 'Brian Lee', 'email' => 'brian@fashionhub.com', 'phone' => '09234567890', 'address' => '456 Fashion Ave, Makati'],
            ['supplier_name' => 'HomeStyle', 'contact_person' => 'Clara Smith', 'email' => 'clara@homestyle.com', 'phone' => '09345678901', 'address' => '789 Home Rd, Quezon City'],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::updateOrCreate(
                ['supplier_name' => $supplier['supplier_name']],
                [
                    'contact_person' => $supplier['contact_person'],
                    'email' => $supplier['email'],
                    'phone' => $supplier['phone'],
                    'address' => $supplier['address'],
                    'is_active' => true,
                ]
            );
        }

        // -------------------------------
        // Seed Products
        // -------------------------------
        Product::factory()->count(20)->create();

        // -------------------------------
        // Seed Inventory
        // -------------------------------
        foreach (Product::all() as $product) {
            Inventory::factory()->create([
                'product_id' => $product->product_id,
                'stock_quantity' => rand(5, 100),
                'reorder_level' => 10,
                'max_stock_level' => 200,
                'last_restocked' => now(),
            ]);
        }

        // -------------------------------
        // Seed Customers
        // -------------------------------
        Customer::factory()->count(10)->create();

        // -------------------------------
        // Seed Admins
        // -------------------------------
        AdminUser::create([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'), 
            'full_name' => 'Admin Admin',
            'role' => 'admin',
            'is_active' => true,
        ]);

        
        // -------------------------------
        // Seed Orders and OrderDetails
        // -------------------------------
        // $orders = Order::factory()->count(15)->create();

        // foreach ($orders as $order) {
        //     // Create 1-5 order details per order
        //     $totalAmount = 0;

        //     $numItems = rand(1, 5);
        //     $products = Product::inRandomOrder()->take($numItems)->get();

        //     foreach ($products as $product) {
        //         $quantity = rand(1, 5);
        //         $subtotal = $product->unit_price * $quantity;

        //         OrderDetail::factory()->create([
        //             'order_id' => $order->order_id,
        //             'product_id' => $product->product_id,
        //             'quantity' => $quantity,
        //             'unit_price' => $product->unit_price,
        //             'subtotal' => $subtotal,
        //         ]);

        //         $totalAmount += $subtotal;
        //     }

        //     // Update total_amount in the order
        //     $order->update(['total_amount' => $totalAmount]);
        // }
    }
}
