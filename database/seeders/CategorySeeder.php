<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name'        => 'Hoodie',
                'slug'        => 'hoodie',
                'description' => 'Premium streetwear hoodies — oversized, fleece-lined, monochrome.',
                'is_active'   => true,
            ],
            [
                'name'        => 'T-Shirt',
                'slug'        => 't-shirt',
                'description' => 'Drop-shoulder tees, graphic prints, Korean streetwear cut.',
                'is_active'   => true,
            ],
            [
                'name'        => 'Jersey',
                'slug'        => 'jersey',
                'description' => 'Sport-inspired jerseys with fashion-forward design.',
                'is_active'   => true,
            ],
            [
                'name'        => 'Limited Edition',
                'slug'        => 'limited-edition',
                'description' => 'Exclusive drops. Once it\'s gone, it\'s gone.',
                'is_active'   => true,
            ],
            [
                'name'        => 'Outerwear',
                'slug'        => 'outerwear',
                'description' => 'Varsity jackets, coaches, windbreakers.',
                'is_active'   => true,
            ],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}