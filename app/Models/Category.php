<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'status',
        'featured',
        'sort_order',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'featured' => 'boolean',
    ];

    // Relationships
    public function products()
    {
        return $this->hasMany(Product::class);
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

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'active' => 'success',
            'inactive' => 'secondary',
        ];

        return $badges[$this->status] ?? 'secondary';
    }

    public function getFeaturedBadgeAttribute()
    {
        return $this->featured ? 'primary' : 'secondary';
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : 'https://via.placeholder.com/300x200/4f46e5/ffffff?text=' . urlencode($this->name);
    }

    public function getProductsCountAttribute()
    {
        return $this->products()->count();
    }

    // Methods
    public function generateSlug()
    {
        $slug = Str::slug($this->name);
        $originalSlug = $slug;
        $counter = 1;

        while (static::where('slug', $slug)->where('id', '!=', $this->id)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    // Boot method to auto-generate slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = $category->generateSlug();
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('name') && empty($category->slug)) {
                $category->slug = $category->generateSlug();
            }
        });
    }
}
