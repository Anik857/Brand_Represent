<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Banner extends Model
{
  use HasFactory;

  protected $fillable = [
    'key',
    'title',
    'image_path',
    'link_url',
    'is_active',
    'sort_order',
  ];

  protected $casts = [
    'is_active' => 'boolean',
  ];

  public function getImageUrlAttribute(): string
  {
    $path = $this->image_path;
    if (!$path) {
      return '';
    }
    if (Str::startsWith($path, ['http://', 'https://', '/'])) {
      return $path;
    }
    $url = Storage::disk('public')->url($path);
    $version = $this->updated_at ? ('?v=' . $this->updated_at->timestamp) : '';
    return $url . $version;
  }
}
