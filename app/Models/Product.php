<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'material',
        'price',
        'stock',
        'sizes',
        'weight',
        'status',
        'is_limited',
        'drop_at',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'price'      => 'decimal:2',
        'weight'     => 'decimal:2',
        'sizes'      => 'array',
        'is_limited' => 'boolean',
        'drop_at'    => 'datetime',
    ];

    // ─── Boot: auto slug ─────────────────────────────
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    // ─── Relationships ───────────────────────────────
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }

    // ─── Scopes ──────────────────────────────────────
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeLimited($query)
    {
        return $query->where('is_limited', true);
    }

    public function scopeByCategory($query, $slug)
    {
        return $query->whereHas('category', fn($q) => $q->where('slug', $slug));
    }

    public function scopeSearch($query, string $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('name', 'like', "%{$keyword}%")
              ->orWhere('description', 'like', "%{$keyword}%");
        });
    }

    // ─── Accessors ───────────────────────────────────
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getPrimaryImageUrlAttribute(): string
    {
        if ($this->primaryImage) {
            return asset('storage/' . $this->primaryImage->image_path);
        }

        if ($this->images->isNotEmpty()) {
            return asset('storage/' . $this->images->first()->image_path);
        }

        return asset('images/placeholder.jpg');
    }

    public function getAverageRatingAttribute(): float
    {
        return round($this->reviews->avg('rating') ?? 0, 1);
    }

    public function getIsAvailableAttribute(): bool
    {
        return $this->status === 'available' && $this->stock > 0;
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'available'   => 'Available',
            'sold_out'    => 'Sold Out',
            'preorder'    => 'Preorder',
            'coming_soon' => 'Coming Soon',
            default       => ucfirst($this->status),
        };
    }
}