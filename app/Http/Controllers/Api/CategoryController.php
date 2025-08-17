<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\FormatDataService;
use App\Services\ImageUploadService;

class CategoryController extends Controller
{
    protected ImageUploadService $imageUploadService;
    protected FormatDataService $formatData;

    public function __construct(
        ImageUploadService $imageUploadService,
        FormatDataService  $formatData,
    )
    {
        $this->imageUploadService = $imageUploadService;
        $this->formatData = $formatData;
    }

    function buildTree($categories, $parentId = null): array
    {
        $tree = [];

        foreach ($categories as $category) {
            if ($category->parent_id == $parentId) {
                $this->formatData->cleanDataCategory($category);

                $children = $this->buildTree($categories, $category->id);

                if ($children) {
                    $category->children = $children;
                } else {
                    $category->children = [];
                }

                $tree[] = $category;
            }
        }

        return $tree;
    }

    public function index()
    {
        $categories = Category::orderBy('created_at', 'DESC')->get();
        $tree = $this->buildTree($categories);

        return $this->responseSuccess($tree);
    }

    public function show($slug)
    {
        $category = Category::where('slug', $slug)->first();

        if (!$category) {
            return $this->responseError('Category not found');
        }

        foreach ($category->children as $child) {
            $this->formatData->cleanDataCategory($child);
        }

        return $this->responseSuccess([
            'id' => $category->id,
            'title' => $category->title,
            'slug' => $category->slug,
            'icon' => $category->icon,
            'color' => $category->color,
            'description' => $category->description,
            'image' => $this->imageUploadService->getImageUrl($category->image),
            'children' => $category->children,
        ]);
    }
}
