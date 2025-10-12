<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateProductsWithCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all products and categories
        $products = Product::all();
        $categories = Category::all();

        if ($products->isEmpty() || $categories->isEmpty()) {
            $this->command->info('No products or categories found. Please run ProductSeeder and CategorySeeder first.');
            return;
        }

        // Map category names to category IDs
        $categoryMap = [
            'Electronics' => 'Electronics',
            'Fashion & Apparel' => 'Fashion & Apparel',
            'Home & Garden' => 'Home & Garden',
            'Sports & Outdoors' => 'Sports & Outdoors',
            'Books & Media' => 'Books & Media',
            'Health & Beauty' => 'Health & Beauty',
            'Toys & Games' => 'Toys & Games',
            'Automotive' => 'Automotive',
            'Food & Beverages' => 'Food & Beverages',
            'Office Supplies' => 'Office Supplies',
        ];

        $updatedCount = 0;

        foreach ($products as $product) {
            // Find matching category by name
            $category = $categories->where('name', $product->category)->first();
            
            if ($category) {
                $product->update(['category_id' => $category->id]);
                $updatedCount++;
            } else {
                // If no matching category found, assign to first available category
                $product->update(['category_id' => $categories->first()->id]);
                $updatedCount++;
            }
        }

        $this->command->info("Updated {$updatedCount} products with category relationships.");
    }
}
