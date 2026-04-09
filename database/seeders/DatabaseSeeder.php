<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\Warehouse;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'name' => 'Kabel UTP Cat 6',
            'brand' => 'Belden',
            'type' => 'Indoor',
            'unit' => 'Roll',
            'price' => 1200000,
            'stock' => 50
        ]);

        Product::create([
            'name' => 'Router MikroTik',
            'brand' => 'MikroTik',
            'type' => 'hAP ac2',
            'unit' => 'Pcs',
            'price' => 1100000,
            'stock' => 12
        ]);

        Supplier::create([
            'name' => 'PT Teknologi Maju',
            'address' => 'Jakarta Industrial Estate Pulogadung',
            'phone' => '021-1234567'
        ]);

        Customer::create([
            'name' => 'CV Jaya Abadi',
            'address' => 'Jl. Sudirman No. 10, Jakarta',
            'phone' => '0812-9876-5432'
        ]);

        Warehouse::create([
            'code' => 'GDG-01',
            'name' => 'Gudang Utama Jakarta',
            'location' => 'Jakarta Timur'
        ]);
    }
}
