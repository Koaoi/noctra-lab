<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id'];

    // ─── Relationships ───────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    // ─── Accessors ───────────────────────────────────
    public function getTotalAttribute(): float
    {
        return $this->items->sum(fn($item) => $item->product->price * $item->quantity);
    }

    public function getItemCountAttribute(): int
    {
        return $this->items->sum('quantity');
    }
}