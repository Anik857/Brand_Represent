<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'description' => 'Latest electronic devices and gadgets including smartphones, laptops, tablets, and accessories.',
                'status' => 'active',
                'featured' => true,
                'sort_order' => 1,
                'meta_title' => 'Electronics - Latest Gadgets and Devices',
                'meta_description' => 'Discover the latest electronic devices, smartphones, laptops, and tech accessories at Brand Represent.',
            ],
            [
                'name' => 'Fashion & Apparel',
                'description' => 'Trendy clothing, shoes, and accessories for men, women, and children.',
                'status' => 'active',
                'featured' => true,
                'sort_order' => 2,
                'meta_title' => 'Fashion & Apparel - Trendy Clothing and Accessories',
                'meta_description' => 'Shop the latest fashion trends, clothing, shoes, and accessories for all ages and styles.',
            ],
            [
                'name' => 'Home & Garden',
                'description' => 'Everything you need for your home and garden including furniture, decor, and tools.',
                'status' => 'active',
                'featured' => false,
                'sort_order' => 3,
                'meta_title' => 'Home & Garden - Furniture, Decor, and Tools',
                'meta_description' => 'Transform your home and garden with our collection of furniture, decor, and gardening tools.',
            ],
            [
                'name' => 'Sports & Outdoors',
                'description' => 'Sports equipment, outdoor gear, and fitness accessories for active lifestyles.',
                'status' => 'active',
                'featured' => false,
                'sort_order' => 4,
                'meta_title' => 'Sports & Outdoors - Equipment and Gear',
                'meta_description' => 'Get active with our sports equipment, outdoor gear, and fitness accessories.',
            ],
            [
                'name' => 'Books & Media',
                'description' => 'Books, magazines, movies, music, and educational materials for all ages.',
                'status' => 'active',
                'featured' => false,
                'sort_order' => 5,
                'meta_title' => 'Books & Media - Books, Movies, and Music',
                'meta_description' => 'Explore our collection of books, movies, music, and educational materials.',
            ],
            [
                'name' => 'Health & Beauty',
                'description' => 'Health products, beauty supplies, skincare, and personal care items.',
                'status' => 'active',
                'featured' => true,
                'sort_order' => 6,
                'meta_title' => 'Health & Beauty - Skincare and Personal Care',
                'meta_description' => 'Take care of yourself with our health and beauty products, skincare, and personal care items.',
            ],
            [
                'name' => 'Toys & Games',
                'description' => 'Toys, games, puzzles, and educational items for children of all ages.',
                'status' => 'active',
                'featured' => false,
                'sort_order' => 7,
                'meta_title' => 'Toys & Games - Fun for All Ages',
                'meta_description' => 'Find the perfect toys, games, and educational items for children and families.',
            ],
            [
                'name' => 'Automotive',
                'description' => 'Car accessories, parts, tools, and maintenance products for vehicle owners.',
                'status' => 'active',
                'featured' => false,
                'sort_order' => 8,
                'meta_title' => 'Automotive - Car Accessories and Parts',
                'meta_description' => 'Everything you need for your vehicle including accessories, parts, and maintenance products.',
            ],
            [
                'name' => 'Food & Beverages',
                'description' => 'Gourmet foods, beverages, snacks, and specialty items for food lovers.',
                'status' => 'active',
                'featured' => false,
                'sort_order' => 9,
                'meta_title' => 'Food & Beverages - Gourmet and Specialty Items',
                'meta_description' => 'Discover gourmet foods, beverages, and specialty items for food enthusiasts.',
            ],
            [
                'name' => 'Office Supplies',
                'description' => 'Office equipment, stationery, and supplies for home and business use.',
                'status' => 'inactive',
                'featured' => false,
                'sort_order' => 10,
                'meta_title' => 'Office Supplies - Equipment and Stationery',
                'meta_description' => 'Stock up on office equipment, stationery, and supplies for productivity.',
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }

        $this->command->info('Categories seeded successfully!');
    }
}
