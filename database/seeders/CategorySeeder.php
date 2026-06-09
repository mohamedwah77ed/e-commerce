<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
    {
        $categories = [
            [
                'title' => 'موبايلات',
                'slug' => 'phone',
                'summary' => 'أحدث الموبايلات والهواتف الذكية',
                'status' => 'active',
                'is_parent' => 1,
                'parent_id' => null,
                'added_by' => 1,
            ],
            [
                'title' => 'لابتوبات',
                'slug' => 'laptops',
                'summary' => 'لابتوبات للألعاب والعمل والدراسة',
                'status' => 'active',
                'is_parent' => 1,
                'parent_id' => null,
                'added_by' => 1,
            ],
            [
                'title' => 'تابلت',
                'slug' => 'tablets',
                'summary' => 'أجهزة تابلت وآيباد',
                'status' => 'active',
                'is_parent' => 1,
                'parent_id' => null,
                'added_by' => 1,
            ],
            [
                'title' => 'سماعات',
                'slug' => 'headphones',
                'summary' => 'سماعات لاسلكية وسلكية',
                'status' => 'active',
                'is_parent' => 1,
                'parent_id' => null,
                'added_by' => 1,
            ],
            [
                'title' => 'ساعات ذكية',
                'slug' => 'smart-watches',
                'summary' => 'ساعات ذكية وإكسسوارات',
                'status' => 'active',
                'is_parent' => 1,
                'parent_id' => null,
                'added_by' => 1,
            ],
            [
                'title' => 'الألعاب',
                'slug' => 'gaming',
                'summary' => 'أجهزة وألعاب وإكسسوارات',
                'status' => 'active',
                'is_parent' => 1,
                'parent_id' => null,
                'added_by' => 1,
            ],
            [
                'title' => 'أجهزة منزلية',
                'slug' => 'home-appliances',
                'summary' => 'أجهزة منزلية ذكية',
                'status' => 'active',
                'is_parent' => 1,
                'parent_id' => null,
                'added_by' => 1,
            ],
            [
                'title' => 'اكسسوارات',
                'slug' => 'accessories',
                'summary' => 'اكسسوارات وملحقات',
                'status' => 'active',
                'is_parent' => 1,
                'parent_id' => null,
                'added_by' => 1,
            ],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // التصنيفات الفرعية (Child Categories)
        $phoneParent = Category::where('slug', 'phone')->first()->id;
        $laptopParent = Category::where('slug', 'laptops')->first()->id;

        $childCategories = [
            [
                'title' => 'iPhone',
                'slug' => 'iphone',
                'summary' => 'أجهزة iPhone',
                'status' => 'active',
                'is_parent' => 0,
                'parent_id' => $phoneParent,
                'added_by' => 1,
            ],
            [
                'title' => 'Samsung Galaxy',
                'slug' => 'samsung-galaxy',
                'summary' => 'أجهزة Samsung Galaxy',
                'status' => 'active',
                'is_parent' => 0,
                'parent_id' => $phoneParent,
                'added_by' => 1,
            ],
            [
                'title' => 'Gaming Laptops',
                'slug' => 'gaming-laptops',
                'summary' => 'لابتوبات للألعاب',
                'status' => 'active',
                'is_parent' => 0,
                'parent_id' => $laptopParent,
                'added_by' => 1,
            ],
            [
                'title' => 'Work Laptops',
                'slug' => 'work-laptops',
                'summary' => 'لابتوبات للعمل',
                'status' => 'active',
                'is_parent' => 0,
                'parent_id' => $laptopParent,
                'added_by' => 1,
            ],
        ];

        foreach ($childCategories as $cat) {
            Category::create($cat);
        }
    }
}
