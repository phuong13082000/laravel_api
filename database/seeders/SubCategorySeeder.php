<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SubCategorySeeder extends Seeder
{
    public function run(): void
    {
        $basePath = public_path('data/sub-category');

        if (!File::exists($basePath)) {
            $this->command->warn("Folder data/sub-category not found");
            return;
        }

        $folders = File::directories($basePath);

        foreach ($folders as $folder) {
            $parentName = basename($folder);

            $parent = Category::firstOrCreate(
                ['slug' => Str::slug($parentName)],
                [
                    'title' => $parentName,
                    'image' => null,
                    'description' => "",
                    'color' => "#3498db",
                    'icon' => "fas fa-folder",
                    'parent_id' => null,
                ]
            );

            $this->command->info("Category: {$parent->title}");

            $files = File::files($folder);

            foreach ($files as $file) {
                $fileName = $file->getFilename();
                $subName = pathinfo($fileName, PATHINFO_FILENAME);

                $image = url('data/sub-category/' . $parentName . '/' . $fileName);

                $sub = Category::updateOrCreate(
                    ['slug' => Str::slug($subName), 'parent_id' => $parent->id],
                    [
                        'title' => $subName,
                        'image' => $image,
                        'description' => "",
                        'color' => "#2ecc71",
                        'icon' => "fas fa-tag",
                    ]
                );

                $this->command->info("-SubCategory: {$sub->title}");
            }
        }
    }
}
