<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambah kolom ke tabel transactions
        Schema::table('transactions', function (Blueprint $table) {
            // Nullable karena mungkin ada barang yang tidak punya ukuran (All Size)
            $table->foreignId('item_size_id')
                  ->nullable()
                  ->after('item_id') // Posisi kolom setelah item_id
                  ->constrained('item_sizes')
                  ->nullOnDelete();
        });

        // 2. Tambah kolom ke tabel item_requests
        Schema::table('item_requests', function (Blueprint $table) {
            $table->foreignId('item_size_id')
                  ->nullable()
                  ->after('item_id')
                  ->constrained('item_sizes')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['item_size_id']);
            $table->dropColumn('item_size_id');
        });

        Schema::table('item_requests', function (Blueprint $table) {
            $table->dropForeign(['item_size_id']);
            $table->dropColumn('item_size_id');
        });
    }
};