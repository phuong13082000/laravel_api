<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $basePath = public_path('data/product');

        if (!File::exists($basePath)) {
            $this->command->warn("Folder data/product not found");
            return;
        }

        $categories = File::directories($basePath);

        foreach ($categories as $categoryPath) {
            $categoryName = basename($categoryPath);

            $category = Category::firstOrCreate(
                ['slug' => Str::slug($categoryName)],
                [
                    'title' => $categoryName,
                    'image' => null,
                    'description' => "",
                    'color' => "#a569bd",
                    'icon' => "fas fa-edit",
                    'parent_id' => null,
                ]
            );
            $this->command->info("Category: {$category->title}");

            $subCategories = File::directories($categoryPath);

            foreach ($subCategories as $subPath) {
                $subName = basename($subPath);

                $subCategory = Category::firstOrCreate(
                    ['slug' => Str::slug($subName), 'parent_id' => $category->id],
                    [
                        'title' => $subName,
                        'image' => null,
                        'description' => "",
                        'color' => "#a569bd",
                        'icon' => "fas fa-edit",
                    ]
                );
                $this->command->info("-SubCategory: {$subCategory->title}");

                $products = File::directories($subPath);

                foreach ($products as $productPath) {
                    $productName = basename($productPath);

                    $files = File::files($productPath);
                    $images = [];

                    foreach ($files as $file) {
                        $ext = strtolower($file->getExtension());
                        if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
                            $images[] = url('data/product/' . $categoryName . '/' . $subName . '/' . $productName . '/' . $file->getFilename());
                        }
                    }

                    $product = Product::updateOrCreate(
                        ['slug' => Str::slug($productName)],
                        [
                            'title' => $productName,
                            'images' => $images,
                            'category_id' => $subCategory->id,
                            'brand_id' => null,
                            'unit' => '1',
                            'stock' => rand(1, 100),
                            'discount' => rand(0, 100),
                            'price' => rand(10, 90),
                            'description' => "description {$productName}",
                            'more_details' => null,
                            'publish' => 1,
                        ]
                    );

                    $this->command->info("--Product: {$product->title}");
                }
            }
        }
    }
}
