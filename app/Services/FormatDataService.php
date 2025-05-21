<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;

class FormatDataService
{
    protected ImageUploadService $imageUploadService;

    public function __construct(ImageUploadService $imageUploadService)
    {
        $this->imageUploadService = $imageUploadService;
    }

    public function cleanDataProduct(Product $product): void
    {
        $product->makeHidden('created_at', 'updated_at', 'category_id', 'publish');

        if (!empty($product->image)) {
            $product->image = $this->imageUploadService->getImageUrl($product->image);
        }

        if (!empty($product->category)) {
            $category = $product->category;
            $product->category->makeHidden('created_at', 'updated_at', 'parent_id', 'depth');

            if (!empty($category->image)) {
                $category->image = $this->imageUploadService->getImageUrl($category->image);
            }
        }
    }

    public function cleanDataCategory(Category $category): void
    {
        $category->makeHidden('created_at', 'updated_at', 'parent_id');

        if (!empty($category->image)) {
            $category->image = $this->imageUploadService->getImageUrl($category->image);
        }
    }
}
