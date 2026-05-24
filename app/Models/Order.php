<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'subtotal',
        'shipping_cost',
        'total',
        'courier',
        'courier_service',
        'shipping_days',
        'status',
        'notes',
    ];

    protected $casts = [
        'subtotal'      => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'total'         => 'decimal:2',
    ];

    // ─── Boot: generate order number ─────────────────
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Order $order) {
            $order->order_number = 'NOCTRA-'
                . now()->format('Ymd')
                . '-'
                . strtoupper(Str::random(6));
        });
    }

    // ─── Relationships ───────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function shippingAddress()
    {
        return $this->hasOne(ShippingAddress::class);
    }

    // ─── Scopes ──────────────────────────────────────
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    // ─── Accessors ───────────────────────────────────
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending'    => 'Menunggu Pembayaran',
            'paid'       => 'Sudah Dibayar',
            'processing' => 'Diproses',
            'shipped'    => 'Dikirim',
            'completed'  => 'Selesai',
            'cancelled'  => 'Dibatalkan',
            default      => ucfirst($this->status),
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'pending'    => 'badge-coming-soon',
            'paid'       => 'badge-preorder',
            'processing' => 'badge-preorder',
            'shipped'    => 'badge-available',
            'completed'  => 'badge-available',
            'cancelled'  => 'badge-sold-out',
            default      => 'badge-coming-soon',
        };
    }

    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total, 0, ',', '.');
    }
}