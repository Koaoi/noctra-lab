<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->words(3, true);

        return [
            'category_id' => Category::inRandomOrder()->first()?->id ?? 1,
            'name'        => 'NOCTRA ' . ucwords($name),
            'slug'        => Str::slug('NOCTRA ' . $name) . '-' . $this->faker->unique()->numberBetween(100, 999),
            'description' => $this->faker->paragraphs(2, true),
            'material'    => $this->faker->randomElement([
                '100% Combed Cotton 220gsm',
                '80% Cotton 20% Polyester 380gsm',
                'Premium French Terry blend',
            ]),
            'price'       => $this->faker->randomElement([
                265000, 320000, 450000, 485000, 599000, 750000
            ]),
            'stock'       => $this->faker->numberBetween(0, 50),
            'sizes'       => ['S', 'M', 'L', 'XL'],
            'weight'      => $this->faker->randomFloat(2, 0.2, 1.5),
            'status'      => $this->faker->randomElement([
                'available', 'available', 'available', 'sold_out', 'preorder'
            ]),
            'is_limited'  => $this->faker->boolean(30),
        ];
    }

    public function available(): static
    {
        return $this->state(['status' => 'available', 'stock' => rand(5, 50)]);
    }

    public function soldOut(): static
    {
        return $this->state(['status' => 'sold_out', 'stock' => 0]);
    }

    public function limited(): static
    {
        return $this->state(['is_limited' => true]);
    }
}