<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        Item::create([
            'code' => 'BA-001',
            'name' => 'Setelan Piyama Anak Dino',
            'category_id' => 1,
            'unit_id' => 1,
            'stock' => 50,
            'price' => 45000,
            'description' => 'Piyama bahan katun motif dinosaurus untuk usia 3-5 tahun'
        ]);

        Item::create([
            'code' => 'KM-001',
            'name' => 'Kemeja Flannel Kotak-kotak',
            'category_id' => 2,
            'unit_id' => 1,
            'stock' => 30,
            'price' => 120000,
            'description' => 'Kemeja lengan panjang bahan flannel premium'
        ]);

        Item::create([
            'code' => 'KM-002',
            'name' => 'Kemeja Polos Putih Slimfit',
            'category_id' => 2,
            'unit_id' => 1,
            'stock' => 25,
            'price' => 150000,
            'description' => 'Kemeja formal bahan katun oxford'
        ]);

        Item::create([
            'code' => 'CL-001',
            'name' => 'Celana Chino Panjang',
            'category_id' => 3,
            'unit_id' => 1,
            'stock' => 40,
            'price' => 175000,
            'description' => 'Celana chino warna khaki ukuran 32'
        ]);

        Item::create([
            'code' => 'CL-002',
            'name' => 'Jeans Denim Regular',
            'category_id' => 3,
            'unit_id' => 1,
            'stock' => 20,
            'price' => 250000,
            'description' => 'Celana jeans bahan tebal warna biru dongker'
        ]);

        Item::create([
            'code' => 'SP-001',
            'name' => 'Sepatu Sneaker Classic',
            'category_id' => 4,
            'unit_id' => 1,
            'stock' => 15,
            'price' => 300000,
            'description' => 'Sepatu olahraga bahan sintetis'
        ]);

        Item::create([
            'code' => 'JK-001',
            'name' => 'Jaket Hoodie Fleece',
            'category_id' => 5,
            'unit_id' => 1,
            'stock' => 35,
            'price' => 200000,
            'description' => 'Jaket hoodie bahan fleece'
        ]);

        Item::create([
            'code' => 'TS-001',
            'name' => 'Tas Ransel Laptop',
            'category_id' => 6,
            'unit_id' => 1,
            'stock' => 10,
            'price' => 400000,
            'description' => 'Tas ransel dengan kompartemen khusus laptop hingga 15 inci'
        ]);

        Item::create([
            'code' => 'AK-001',
            'name' => 'Topi Baseball Casual',
            'category_id' => 7,
            'unit_id' => 1,
            'stock' => 60,
            'price' => 80000,
            'description' => 'Topi baseball bahan katun dengan desain casual'
        ]);

        Item::create([
            'code' => 'AK-002',
            'name' => 'Gelang Kulit Fashion',
            'category_id' => 7,
            'unit_id' => 1,
            'stock' => 45,
            'price' => 60000,
            'description' => 'Gelang bahan kulit asli dengan desain trendy'
        ]);

        Item::create([
            'code' => 'SP-002',
            'name' => 'Sepatu Sneaker Trendy',
            'category_id' => 4,
            'unit_id' => 1,
            'stock' => 20,
            'price' => 250000,
            'description' => 'Sepatu olahraga bahan sintetis dengan desain trendy'
        ]);
    }
}