<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ─── Boot: auto-generate slug ────────────────────
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Category $category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    // ─── Relationships ───────────────────────────────
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // ─── Scopes ─────────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}