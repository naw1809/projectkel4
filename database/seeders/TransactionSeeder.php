<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        // Barang masuk
        Transaction::create([
            'item_id' => 1,
            'user_id' => 1,
            'type' => 'in',
            'quantity' => 10,
            'date' => now()->subDays(10),
            'note' => 'Pembelian awal'
        ]);

        Transaction::create([
            'item_id' => 2,
            'user_id' => 1,
            'type' => 'in',
            'quantity' => 5,
            'date' => now()->subDays(8),
            'note' => 'Pembelian awal'
        ]);

        // Barang keluar
        Transaction::create([
            'item_id' => 1,
            'user_id' => 2,
            'type' => 'out',
            'quantity' => 2,
            'date' => now()->subDays(5),
            'note' => 'Untuk cabang A'
        ]);
    }
}