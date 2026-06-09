<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brands;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            ['title' => 'Apple', 'slug' => 'apple', 'status' => 'active'],
            ['title' => 'Samsung', 'slug' => 'samsung', 'status' => 'active'],
            ['title' => 'Xiaomi', 'slug' => 'xiaomi', 'status' => 'active'],
            ['title' => 'Huawei', 'slug' => 'huawei', 'status' => 'active'],
            ['title' => 'OPPO', 'slug' => 'oppo', 'status' => 'active'],
            ['title' => 'Realme', 'slug' => 'realme', 'status' => 'active'],
            ['title' => 'Lenovo', 'slug' => 'lenovo', 'status' => 'active'],
            ['title' => 'HP', 'slug' => 'hp', 'status' => 'active'],
            ['title' => 'Asus', 'slug' => 'asus', 'status' => 'active'],
            ['title' => 'Honor', 'slug' => 'honor', 'status' => 'active'],
        ];

        foreach ($brands as $brand) {
            Brands::create($brand);
        }
    }
}
