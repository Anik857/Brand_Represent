<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();
        
        if ($products->isEmpty()) {
            $this->command->info('No products found. Please run ProductSeeder first.');
            return;
        }

        $orders = [
            [
                'customer_name' => 'John Doe',
                'customer_email' => 'john.doe@example.com',
                'customer_phone' => '+1 (555) 123-4567',
                'shipping_address' => "123 Main Street\nNew York, NY 10001\nUnited States",
                'billing_address' => "123 Main Street\nNew York, NY 10001\nUnited States",
                'subtotal' => 299.99,
                'tax_amount' => 24.00,
                'shipping_cost' => 9.99,
                'discount_amount' => 0,
                'total_amount' => 333.98,
                'status' => 'delivered',
                'payment_status' => 'paid',
                'payment_method' => 'Credit Card',
                'notes' => 'Customer requested express shipping',
                'shipped_at' => now()->subDays(5),
                'delivered_at' => now()->subDays(2),
                'items' => [
                    ['product_id' => 1, 'quantity' => 1],
                    ['product_id' => 2, 'quantity' => 2],
                ]
            ],
            [
                'customer_name' => 'Jane Smith',
                'customer_email' => 'jane.smith@example.com',
                'customer_phone' => '+1 (555) 987-6543',
                'shipping_address' => "456 Oak Avenue\nLos Angeles, CA 90210\nUnited States",
                'billing_address' => "456 Oak Avenue\nLos Angeles, CA 90210\nUnited States",
                'subtotal' => 149.50,
                'tax_amount' => 12.00,
                'shipping_cost' => 5.99,
                'discount_amount' => 10.00,
                'total_amount' => 157.49,
                'status' => 'shipped',
                'payment_status' => 'paid',
                'payment_method' => 'PayPal',
                'notes' => null,
                'shipped_at' => now()->subDays(1),
                'delivered_at' => null,
                'items' => [
                    ['product_id' => 3, 'quantity' => 1],
                    ['product_id' => 4, 'quantity' => 1],
                ]
            ],
            [
                'customer_name' => 'Mike Johnson',
                'customer_email' => 'mike.johnson@example.com',
                'customer_phone' => '+1 (555) 456-7890',
                'shipping_address' => "789 Pine Street\nChicago, IL 60601\nUnited States",
                'billing_address' => "789 Pine Street\nChicago, IL 60601\nUnited States",
                'subtotal' => 89.99,
                'tax_amount' => 7.20,
                'shipping_cost' => 0,
                'discount_amount' => 0,
                'total_amount' => 97.19,
                'status' => 'processing',
                'payment_status' => 'paid',
                'payment_method' => 'Credit Card',
                'notes' => 'Free shipping applied',
                'shipped_at' => null,
                'delivered_at' => null,
                'items' => [
                    ['product_id' => 5, 'quantity' => 1],
                ]
            ],
            [
                'customer_name' => 'Sarah Wilson',
                'customer_email' => 'sarah.wilson@example.com',
                'customer_phone' => '+1 (555) 321-0987',
                'shipping_address' => "321 Elm Street\nHouston, TX 77001\nUnited States",
                'billing_address' => "321 Elm Street\nHouston, TX 77001\nUnited States",
                'subtotal' => 199.99,
                'tax_amount' => 16.00,
                'shipping_cost' => 7.99,
                'discount_amount' => 0,
                'total_amount' => 223.98,
                'status' => 'confirmed',
                'payment_status' => 'pending',
                'payment_method' => 'Bank Transfer',
                'notes' => 'Customer will pay via bank transfer',
                'shipped_at' => null,
                'delivered_at' => null,
                'items' => [
                    ['product_id' => 6, 'quantity' => 1],
                    ['product_id' => 7, 'quantity' => 1],
                ]
            ],
            [
                'customer_name' => 'David Brown',
                'customer_email' => 'david.brown@example.com',
                'customer_phone' => '+1 (555) 654-3210',
                'shipping_address' => "654 Maple Drive\nPhoenix, AZ 85001\nUnited States",
                'billing_address' => "654 Maple Drive\nPhoenix, AZ 85001\nUnited States",
                'subtotal' => 79.99,
                'tax_amount' => 6.40,
                'shipping_cost' => 4.99,
                'discount_amount' => 0,
                'total_amount' => 91.38,
                'status' => 'cancelled',
                'payment_status' => 'failed',
                'payment_method' => 'Credit Card',
                'notes' => 'Payment failed - card declined',
                'shipped_at' => null,
                'delivered_at' => null,
                'items' => [
                    ['product_id' => 8, 'quantity' => 1],
                ]
            ],
            [
                'customer_name' => 'Emily Davis',
                'customer_email' => 'emily.davis@example.com',
                'customer_phone' => '+1 (555) 789-0123',
                'shipping_address' => "987 Cedar Lane\nPhiladelphia, PA 19101\nUnited States",
                'billing_address' => "987 Cedar Lane\nPhiladelphia, PA 19101\nUnited States",
                'subtotal' => 159.99,
                'tax_amount' => 12.80,
                'shipping_cost' => 6.99,
                'discount_amount' => 15.00,
                'total_amount' => 164.78,
                'status' => 'pending',
                'payment_status' => 'pending',
                'payment_method' => 'Credit Card',
                'notes' => 'New customer - first order',
                'shipped_at' => null,
                'delivered_at' => null,
                'items' => [
                    ['product_id' => 9, 'quantity' => 1],
                    ['product_id' => 10, 'quantity' => 1],
                ]
            ],
        ];

        foreach ($orders as $orderData) {
            $items = $orderData['items'];
            unset($orderData['items']);

            // Generate order number
            $orderData['order_number'] = 'ORD-' . strtoupper(Str::random(8));

            $order = Order::create($orderData);

            // Create order items
            foreach ($items as $item) {
                $product = $products->find($item['product_id']);
                if ($product) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'product_sku' => $product->sku,
                        'quantity' => $item['quantity'],
                        'unit_price' => $product->price,
                        'total_price' => $product->price * $item['quantity'],
                    ]);
                }
            }
        }

        $this->command->info('Orders seeded successfully!');
    }
}
