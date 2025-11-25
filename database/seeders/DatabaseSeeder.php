<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            UnitSeeder::class,
            ItemSeeder::class,
            TransactionSeeder::class,
            ItemRequestSeeder::class,
        ]);
    }
}