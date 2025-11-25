<?php

namespace Database\Seeders;

use App\Models\ItemRequest;
use Illuminate\Database\Seeder;

class ItemRequestSeeder extends Seeder
{
    public function run(): void
    {
        ItemRequest::create([
            'item_id' => 1,
            'user_id' => 2,
            'quantity' => 3,
            'reason' => 'Butuh untuk pengiriman ke cabang B',
            'status' => 'pending'
        ]);

        ItemRequest::create([
            'item_id' => 3,
            'user_id' => 3,
            'quantity' => 10,
            'reason' => 'Untuk proses produksi koveksi',
            'status' => 'approved',
            'processed_by' => 1,
            'processed_at' => now()->subDays(2)
        ]);

        ItemRequest::create([
            'item_id' => 2,
            'user_id' => 2,
            'quantity' => 5,
            'reason' => 'Permintaan divisi marketing',
            'status' => 'rejected',
            'rejection_reason' => 'Stok tidak mencukupi',
            'processed_by' => 1,
            'processed_at' => now()->subDays(1)
        ]);
    }
}