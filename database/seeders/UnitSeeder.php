<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        Unit::create(['name' => 'Pieces', 'symbol' => 'pcs']);
        Unit::create(['name' => 'Kilogram', 'symbol' => 'kg']);
        Unit::create(['name' => 'Liter', 'symbol' => 'L']);
        Unit::create(['name' => 'Meter', 'symbol' => 'm']);
        Unit::create(['name' => 'Dus', 'symbol' => 'dus']);
    }
}