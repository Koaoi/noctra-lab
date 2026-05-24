<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $hoodie   = Category::where('slug', 'hoodie')->first();
        $tshirt   = Category::where('slug', 't-shirt')->first();
        $jersey   = Category::where('slug', 'jersey')->first();
        $limited  = Category::where('slug', 'limited-edition')->first();
        $outer    = Category::where('slug', 'outerwear')->first();

        $products = [
            [
                'category_id' => $hoodie->id,
                'name'        => 'NOCTRA Oversized Hoodie Black',
                'slug'        => 'noctra-oversized-hoodie-black',
                'description' => 'Heavyweight 420gsm fleece hoodie. Dropped shoulder cut. Minimal branding. The foundation of your wardrobe.',
                'material'    => '80% Cotton, 20% Polyester — 420gsm heavyweight fleece',
                'price'       => 485000,
                'stock'       => 30,
                'sizes'       => ['S', 'M', 'L', 'XL', 'XXL'],
                'weight'      => 0.6,
                'status'      => 'available',
                'is_limited'  => false,
            ],
            [
                'category_id' => $tshirt->id,
                'name'        => 'NOCTRA Graphic Tee — VOID',
                'slug'        => 'noctra-graphic-tee-void',
                'description' => 'Drop-shoulder Korean-cut tee. "VOID" graphic artwork front. 200gsm combed cotton.',
                'material'    => '100% Combed Cotton — 200gsm',
                'price'       => 265000,
                'stock'       => 50,
                'sizes'       => ['S', 'M', 'L', 'XL'],
                'weight'      => 0.3,
                'status'      => 'available',
                'is_limited'  => false,
            ],
            [
                'category_id' => $limited->id,
                'name'        => 'NOCTRA LAB Vol.1 — Monochrome Set',
                'slug'        => 'noctra-lab-vol-1-monochrome-set',
                'description' => 'Limited drop. Vol.1 Monochrome matching set — Hoodie + Tee. Only 50 units worldwide.',
                'material'    => 'Premium French Terry blend',
                'price'       => 750000,
                'stock'       => 15,
                'sizes'       => ['M', 'L', 'XL'],
                'weight'      => 0.9,
                'status'      => 'available',
                'is_limited'  => true,
            ],
            [
                'category_id' => $jersey->id,
                'name'        => 'NOCTRA Sport Jersey — Shadow',
                'slug'        => 'noctra-sport-jersey-shadow',
                'description' => 'Mesh fabric sport jersey. Streetwear-forward design. Breathable, lightweight.',
                'material'    => '100% Polyester mesh — 160gsm',
                'price'       => 320000,
                'stock'       => 25,
                'sizes'       => ['S', 'M', 'L', 'XL'],
                'weight'      => 0.25,
                'status'      => 'available',
                'is_limited'  => false,
            ],
            [
                'category_id' => $limited->id,
                'name'        => 'NOCTRA Drop 002 — Coming Soon',
                'slug'        => 'noctra-drop-002',
                'description' => 'Drop 002 is coming. Sign up for the waitlist.',
                'material'    => 'TBA',
                'price'       => 599000,
                'stock'       => 0,
                'sizes'       => ['S', 'M', 'L', 'XL'],
                'weight'      => 0.5,
                'status'      => 'coming_soon',
                'is_limited'  => true,
                'drop_at'     => now()->addDays(14),
            ],
            [
                'category_id' => $outer->id,
                'name'        => 'NOCTRA Varsity Jacket — Noir',
                'slug'        => 'noctra-varsity-jacket-noir',
                'description' => 'Full black varsity jacket. Wool-blend body, leather-look sleeves. Minimal embroidery.',
                'material'    => 'Wool 60% / Acrylic 40% body — PU leather sleeves',
                'price'       => 980000,
                'stock'       => 8,
                'sizes'       => ['M', 'L', 'XL'],
                'weight'      => 1.2,
                'status'      => 'available',
                'is_limited'  => true,
            ],
        ];

        foreach ($products as $data) {
            $product = Product::create($data);

            // Buat placeholder image record
            // (Gambar asli diupload via admin panel)
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => 'products/placeholder.jpg',
                'is_primary' => true,
                'sort_order' => 0,
            ]);
        }
    }
}