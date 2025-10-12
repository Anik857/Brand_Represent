<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        return $this->images ? $this->images[0] : 'https://via.placeholder.com/300x300';
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
