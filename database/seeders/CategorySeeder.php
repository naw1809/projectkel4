<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create(['name' => 'Baju Anak', 'description' => 'Barang-barang untuk anak-anak']);
        Category::create(['name' => 'Kemeja', 'description' => 'Berbagai jenis kemeja pria dan wanita']);
        Category::create(['name' => 'Celana', 'description' => 'Celana panjang dan pendek untuk segala usia']);
        Category::create(['name' => 'Sepatu', 'description' => 'Sepatu olahraga, formal, dan kasual']);
        Category::create(['name' => 'Jaket', 'description' => 'Jaket untuk berbagai cuaca dan kondisi']);
        Category::create(['name' => 'Tas', 'description' => 'Tas ransel dan tas kantoran']);
        Category::create(['name' => 'Aksesoris', 'description' => 'Aksesoris seperti gelas, topi, dan sepatu']);
        Category::create(['name' => 'Lainnya', 'description' => 'Barang-barang lainnya yang tidak dapat dikelompokkan ke dalam kategori lain']);
    }
}