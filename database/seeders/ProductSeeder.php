<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'iPhone 15 Pro',
                'description' => 'The latest iPhone with advanced camera system and A17 Pro chip.',
                'sku' => 'IPH15-PRO-128',
                'price' => 999.00,
                'compare_price' => 1099.00,
                'quantity' => 50,
                'category' => 'Electronics',
                'brand' => 'Apple',
                'status' => 'active',
                'featured' => true,
                'weight' => 0.6,
                'dimensions' => '6.1 x 2.8 x 0.3',
                'meta_title' => 'iPhone 15 Pro - Latest Apple Smartphone',
                'meta_description' => 'Get the iPhone 15 Pro with advanced camera system and A17 Pro chip. Available now with fast shipping.',
            ],
            [
                'name' => 'Samsung Galaxy S24 Ultra',
                'description' => 'Premium Android smartphone with S Pen and advanced AI features.',
                'sku' => 'SGS24-ULTRA-256',
                'price' => 1199.00,
                'compare_price' => 1299.00,
                'quantity' => 30,
                'category' => 'Electronics',
                'brand' => 'Samsung',
                'status' => 'active',
                'featured' => true,
                'weight' => 0.7,
                'dimensions' => '6.4 x 3.1 x 0.3',
                'meta_title' => 'Samsung Galaxy S24 Ultra - Premium Android Phone',
                'meta_description' => 'Experience the Samsung Galaxy S24 Ultra with S Pen and advanced AI features.',
            ],
            [
                'name' => 'Nike Air Max 270',
                'description' => 'Comfortable running shoes with Max Air cushioning technology.',
                'sku' => 'NAM270-BLK-10',
                'price' => 150.00,
                'compare_price' => 180.00,
                'quantity' => 100,
                'category' => 'Clothing',
                'brand' => 'Nike',
                'status' => 'active',
                'featured' => false,
                'weight' => 1.2,
                'dimensions' => '12 x 8 x 4',
                'meta_title' => 'Nike Air Max 270 - Running Shoes',
                'meta_description' => 'Comfortable Nike Air Max 270 running shoes with Max Air cushioning.',
            ],
            [
                'name' => 'MacBook Pro 16-inch',
                'description' => 'Powerful laptop with M3 Pro chip and Liquid Retina XDR display.',
                'sku' => 'MBP16-M3-512',
                'price' => 2499.00,
                'compare_price' => 2699.00,
                'quantity' => 25,
                'category' => 'Electronics',
                'brand' => 'Apple',
                'status' => 'active',
                'featured' => true,
                'weight' => 2.1,
                'dimensions' => '14 x 9.8 x 0.7',
                'meta_title' => 'MacBook Pro 16-inch - M3 Pro Chip',
                'meta_description' => 'Powerful MacBook Pro 16-inch with M3 Pro chip and Liquid Retina XDR display.',
            ],
            [
                'name' => 'Sony WH-1000XM5 Headphones',
                'description' => 'Industry-leading noise canceling wireless headphones.',
                'sku' => 'SWH1000XM5-BLK',
                'price' => 399.00,
                'compare_price' => 449.00,
                'quantity' => 75,
                'category' => 'Electronics',
                'brand' => 'Sony',
                'status' => 'active',
                'featured' => false,
                'weight' => 0.5,
                'dimensions' => '8 x 7 x 3',
                'meta_title' => 'Sony WH-1000XM5 - Noise Canceling Headphones',
                'meta_description' => 'Industry-leading Sony WH-1000XM5 noise canceling wireless headphones.',
            ],
            [
                'name' => 'Adidas Ultraboost 22',
                'description' => 'High-performance running shoes with Boost midsole technology.',
                'sku' => 'AUB22-WHT-9',
                'price' => 180.00,
                'compare_price' => 200.00,
                'quantity' => 80,
                'category' => 'Clothing',
                'brand' => 'Adidas',
                'status' => 'active',
                'featured' => false,
                'weight' => 1.0,
                'dimensions' => '11 x 7 x 4',
                'meta_title' => 'Adidas Ultraboost 22 - Running Shoes',
                'meta_description' => 'High-performance Adidas Ultraboost 22 running shoes with Boost technology.',
            ],
            [
                'name' => 'Tesla Model 3',
                'description' => 'Electric sedan with autopilot and long-range battery.',
                'sku' => 'TM3-LR-AWD',
                'price' => 45000.00,
                'compare_price' => 50000.00,
                'quantity' => 5,
                'category' => 'Automotive',
                'brand' => 'Tesla',
                'status' => 'active',
                'featured' => true,
                'weight' => 4000.0,
                'dimensions' => '185 x 73 x 56',
                'meta_title' => 'Tesla Model 3 - Electric Sedan',
                'meta_description' => 'Tesla Model 3 electric sedan with autopilot and long-range battery.',
            ],
            [
                'name' => 'Microsoft Surface Pro 9',
                'description' => 'Versatile 2-in-1 laptop and tablet with detachable keyboard.',
                'sku' => 'MSP9-I7-256',
                'price' => 1299.00,
                'compare_price' => 1499.00,
                'quantity' => 40,
                'category' => 'Electronics',
                'brand' => 'Microsoft',
                'status' => 'active',
                'featured' => false,
                'weight' => 1.9,
                'dimensions' => '11.3 x 8.2 x 0.4',
                'meta_title' => 'Microsoft Surface Pro 9 - 2-in-1 Laptop',
                'meta_description' => 'Versatile Microsoft Surface Pro 9 2-in-1 laptop and tablet.',
            ],
            [
                'name' => 'Google Pixel 8 Pro',
                'description' => 'Android smartphone with advanced AI photography features.',
                'sku' => 'GP8P-128-BLK',
                'price' => 899.00,
                'compare_price' => 999.00,
                'quantity' => 60,
                'category' => 'Electronics',
                'brand' => 'Google',
                'status' => 'active',
                'featured' => false,
                'weight' => 0.6,
                'dimensions' => '6.3 x 3.0 x 0.3',
                'meta_title' => 'Google Pixel 8 Pro - AI Photography Phone',
                'meta_description' => 'Google Pixel 8 Pro with advanced AI photography features.',
            ],
            [
                'name' => 'BMW iX Electric SUV',
                'description' => 'Luxury electric SUV with advanced driver assistance systems.',
                'sku' => 'BMW-IX-XDRIVE50',
                'price' => 85000.00,
                'compare_price' => 90000.00,
                'quantity' => 3,
                'category' => 'Automotive',
                'brand' => 'BMW',
                'status' => 'active',
                'featured' => true,
                'weight' => 5500.0,
                'dimensions' => '195 x 78 x 66',
                'meta_title' => 'BMW iX Electric SUV - Luxury EV',
                'meta_description' => 'Luxury BMW iX electric SUV with advanced driver assistance systems.',
            ],
        ];

        foreach ($products as $productData) {
            // Add placeholder images
            $productData['images'] = [
                'https://via.placeholder.com/300x300/4f46e5/ffffff?text=' . urlencode($productData['name']),
                'https://via.placeholder.com/300x300/10b981/ffffff?text=' . urlencode($productData['name'] . '+2'),
                'https://via.placeholder.com/300x300/f59e0b/ffffff?text=' . urlencode($productData['name'] . '+3')
            ];

            Product::create($productData);
        }
    }
}
