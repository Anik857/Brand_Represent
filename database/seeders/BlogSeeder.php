<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $blogs = [
            [
                'title' => 'Let\'s start bring sale on this summer vacation',
                'excerpt' => 'Discover the latest summer collection with amazing discounts and offers. Get ready for the hottest deals of the season.',
                'content' => 'Summer is here and we\'re excited to bring you the most amazing collection of fashion items. Our summer sale features the latest trends in clothing, accessories, and footwear. Don\'t miss out on these incredible deals that will make your summer wardrobe complete.',
                'featured_image' => 'frontend/assets/img/bl-1.png',
                'author' => 'Admin',
                'is_published' => true,
            ],
            [
                'title' => 'New Collection Launch - Fall 2024',
                'excerpt' => 'Introducing our stunning fall collection with premium quality materials and contemporary designs.',
                'content' => 'We\'re thrilled to announce the launch of our Fall 2024 collection. This season brings together comfort, style, and sustainability. Each piece is carefully crafted to provide you with the perfect blend of fashion and functionality.',
                'featured_image' => 'frontend/assets/img/bl-2.png',
                'author' => 'Admin',
                'is_published' => true,
            ],
            [
                'title' => 'Sustainable Fashion - Our Commitment',
                'excerpt' => 'Learn about our commitment to sustainable fashion and eco-friendly practices.',
                'content' => 'At Brand Represent, we believe in making a positive impact on the environment. Our sustainable fashion initiative focuses on using eco-friendly materials, ethical production processes, and reducing our carbon footprint.',
                'featured_image' => 'frontend/assets/img/bl-3.png',
                'author' => 'Admin',
                'is_published' => true,
            ],
            [
                'title' => 'Fashion Tips for Every Occasion',
                'excerpt' => 'Expert styling tips to help you look your best for any event or occasion.',
                'content' => 'Whether you\'re attending a formal event, casual outing, or business meeting, we\'ve got you covered. Our fashion experts share their top tips for creating the perfect look for every occasion.',
                'featured_image' => 'frontend/assets/img/bl-1.png',
                'author' => 'Admin',
                'is_published' => true,
            ],
            [
                'title' => 'Customer Spotlight - Success Stories',
                'excerpt' => 'Read inspiring stories from our valued customers and their fashion journey.',
                'content' => 'We love hearing from our customers! In this spotlight series, we share inspiring stories of how our products have helped customers express their unique style and confidence.',
                'featured_image' => 'frontend/assets/img/bl-2.png',
                'author' => 'Admin',
                'is_published' => true,
            ],
        ];

        foreach ($blogs as $blogData) {
            $blogData['slug'] = Str::slug($blogData['title']);
            $blogData['views'] = rand(50, 500);
            Blog::create($blogData);
        }
    }
}