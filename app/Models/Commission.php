<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commission extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'reference_image',
        'budget',
        'size_preference',
        'color_preference',
        'status',
        'admin_notes',
        'quoted_price',
    ];

    protected $casts = [
        'budget'       => 'decimal:2',
        'quoted_price' => 'decimal:2',
    ];

    // ─── Relationships ───────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ─── Accessors ───────────────────────────────────
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending'     => 'Menunggu Review',
            'reviewing'   => 'Sedang Direview',
            'approved'    => 'Disetujui',
            'in_progress' => 'Dalam Pengerjaan',
            'completed'   => 'Selesai',
            'rejected'    => 'Ditolak',
            default       => ucfirst($this->status),
        };
    }

    public function getReferenceImageUrlAttribute(): ?string
    {
        if (!$this->reference_image) {
            return null;
        }
        return asset('storage/' . $this->reference_image);
    }
}