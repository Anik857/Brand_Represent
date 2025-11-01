<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('banners', function (Blueprint $table) {
      $table->id();
      $table->string('key')->unique(); // e.g., home_banner_1
      $table->string('title')->nullable();
      $table->string('image_path'); // stored path under public disk or absolute URL
      $table->string('link_url')->nullable();
      $table->boolean('is_active')->default(true);
      $table->unsignedInteger('sort_order')->default(0);
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('banners');
  }
};
