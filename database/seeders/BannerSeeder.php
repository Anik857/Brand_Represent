<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banner;

class BannerSeeder extends Seeder
{
  public function run(): void
  {
    $defaults = [
      [
        'key' => 'home_banner_1',
        'title' => 'Home Banner 1',
        'image_path' => '/frontend/assets/img/banner_1.jpg',
        'sort_order' => 1,
      ],
      [
        'key' => 'home_banner_2',
        'title' => 'Home Banner 2',
        'image_path' => '/frontend/assets/img/banner_2.jpg',
        'sort_order' => 2,
      ],
      [
        'key' => 'home_banner_3',
        'title' => 'Home Banner 3',
        'image_path' => '/frontend/assets/img/banner_3.jpg',
        'sort_order' => 3,
      ],
    ];

    foreach ($defaults as $data) {
      Banner::updateOrCreate(
        ['key' => $data['key']],
        [
          'title' => $data['title'],
          'image_path' => $data['image_path'],
          'is_active' => true,
          'sort_order' => $data['sort_order'],
        ]
      );
    }
  }
}
