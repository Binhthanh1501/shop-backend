<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        DB::table('products')->insert([
            [
                'sku' => 'DOL01',
                'name' => 'Rina Double-Breasted Top',
                'img' => 'images/Rina(1).webp',
                'description' => 'Áo kaki lụa co giãn nhẹ tay phồng',
                'brand' => 'Dear Rose',
                'price' => 120000,
                'inventory' => 50,
                'category_id' => 1, // quần áo
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sku' => 'TX01',
                'name' => 'Túi Tote',
                'img' => 'images/tote.jfif',
                'description' => 'Túi đeo vai di động dung tích lớn',
                'brand' => 'Dear Rose',
                'price' => 250000,
                'inventory' => 20,
                'category_id' => 2, // túi xách
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sku' => 'GD01',
                'name' => 'Sandal gót vuông',
                'img' => 'images/giay.webp',
                'description' => 'Giày Sandal Gót Vuông 9P Sườn Kép Quai Ngang...',
                'brand' => 'Dear Rose',
                'price' => 320000,
                'inventory' => 25,
                'category_id' => 3, // giày dép
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

    }
}

