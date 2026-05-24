<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'recipient_name',
        'phone',
        'province',
        'city',
        'district',
        'address',
        'postal_code',
        'destination_id',
    ];

    // ─── Relationships ───────────────────────────────
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // ─── Accessor ────────────────────────────────────
    public function getFullAddressAttribute(): string
    {
        return implode(', ', array_filter([
            $this->address,
            $this->district,
            $this->city,
            $this->province,
            $this->postal_code,
        ]));
    }
}