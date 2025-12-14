<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemSize extends Model
{
    use HasFactory;

    protected $fillable = ['item_id', 'size', 'stock'];

    // Relasi ke Barang Induk (Item)
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    // --- TAMBAHAN PENTING (Agar sinkron dengan ERD) ---

    // 1. Relasi ke Transaksi
    // (Satu ukuran barang bisa tercatat di banyak riwayat transaksi)
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // 2. Relasi ke Permintaan Barang
    // (Satu ukuran barang bisa diminta berkali-kali)
    public function itemRequests()
    {
        return $this->hasMany(ItemRequest::class);
    }
}