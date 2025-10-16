<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'sku',
        'price',
        'compare_price',
        'quantity',
        'category_id',
        'category',
        'brand',
        'images',
        'status',
        'featured',
        'weight',
        'dimensions',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'images' => 'array',
        'featured' => 'boolean',
        'price' => 'decimal:2',
        'compare_price' => 'decimal:2',
        'weight' => 'decimal:2',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('quantity', '>', 0);
    }

    // Accessors
    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->price, 2);
    }

    public function getFormattedComparePriceAttribute()
    {
        return $this->compare_price ? '$' . number_format($this->compare_price, 2) : null;
    }

    public function getDiscountPercentageAttribute()
    {
        if ($this->compare_price && $this->compare_price > $this->price) {
            return round((($this->compare_price - $this->price) / $this->compare_price) * 100);
        }
        return 0;
    }

    public function getMainImageAttribute()
    {
        $firstImage = $this->images[0] ?? null;
        if (!$firstImage) {
            return 'https://via.placeholder.com/300x300';
        }

        // Return absolute URLs as-is
        if (Str::startsWith($firstImage, ['http://', 'https://'])) {
            return $firstImage;
        }

        // Normalize storage-relative paths to a full URL
        $normalized = str_replace('\\', '/', $firstImage);

        // Case 1: begins with "/storage/..." -> make absolute URL
        if (Str::startsWith($normalized, '/storage/')) {
            return url($normalized);
        }

        // Case 2: begins with "storage/..." -> make absolute URL
        if (Str::startsWith($normalized, 'storage/')) {
            return url('/' . $normalized);
        }

        // Case 3: raw path under public disk (e.g., "products/filename.jpg")
        if (!Str::startsWith($normalized, ['http://', 'https://', '/'])) {
            return Storage::disk('public')->url($normalized);
        }

        // Fallback
        return url(ltrim($normalized, '/'));
    }

    public function getImageUrlsAttribute(): array
    {
        $images = $this->images ?? [];
        if (!is_array($images)) {
            return [];
        }

        return array_map(function ($img) {
            if (!$img) {
                return null;
            }
            $normalized = str_replace('\\', '/', $img);
            if (Str::startsWith($normalized, ['http://', 'https://'])) {
                return $normalized;
            }
            if (Str::startsWith($normalized, '/storage/')) {
                return url($normalized);
            }
            if (Str::startsWith($normalized, 'storage/')) {
                return url('/' . $normalized);
            }
            if (!Str::startsWith($normalized, ['http://', 'https://', '/'])) {
                return Storage::disk('public')->url($normalized);
            }
            return url(ltrim($normalized, '/'));
        }, $images);
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'active' => 'success',
            'inactive' => 'secondary',
            'draft' => 'warning',
        ];

        return $badges[$this->status] ?? 'secondary';
    }
}
