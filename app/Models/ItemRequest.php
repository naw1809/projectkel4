<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemRequest extends Model
{
    protected $fillable = [
        'item_id',
        'user_id',
        'size', // Menambahkan size agar bisa disimpan
        'quantity',
        'reason',
        'status',
        'rejection_reason',
        'processed_by',
        'processed_at'
    ];

    protected $casts = [
        'processed_at' => 'datetime',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function processedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
}