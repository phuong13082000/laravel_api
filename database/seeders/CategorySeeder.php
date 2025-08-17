<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categoryPath = public_path('data/category');

        $files = File::files($categoryPath);
        foreach ($files as $file) {
            $fileName = $file->getFilename();
            $name = pathinfo($fileName, PATHINFO_FILENAME);

            $parent = Category::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'title' => $name,
                    'image' => url('data/category/' . $fileName),
                    'description' => "",
                    'color' => "#a569bd",
                    'icon' => "fas fa-edit",
                    'parent_id' => null,
                ]
            );

            $this->command->info("Category: {$parent->title}");
        }
    }
}
//php artisan db:seed
