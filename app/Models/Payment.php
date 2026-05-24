<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'transaction_id',
        'snap_token',
        'status',
        'payment_type',
        'gross_amount',
        'payment_response',
        'paid_at',
    ];

    protected $casts = [
        'gross_amount'     => 'decimal:2',
        'payment_response' => 'array',
        'paid_at'          => 'datetime',
    ];

    // ─── Relationships ───────────────────────────────
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // ─── Accessors ───────────────────────────────────
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Menunggu Pembayaran',
            'paid'    => 'Lunas',
            'failed'  => 'Gagal',
            'expired' => 'Kadaluarsa',
            'refund'  => 'Refund',
            default   => ucfirst($this->status),
        };
    }
}