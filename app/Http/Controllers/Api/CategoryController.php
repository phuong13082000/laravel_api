<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    function buildTree($categories, $parentId = null): array
    {
        $tree = [];

        foreach ($categories as $category) {
            if ($category->parent_id == $parentId) {
                $category->makeHidden('created_at', 'updated_at', 'parent_id');

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
            $child->makeHidden('created_at', 'updated_at', 'parent_id');
        }

        return $this->responseSuccess([
            'id' => $category->id,
            'title' => $category->title,
            'slug' => $category->slug,
            'icon' => $category->icon,
            'color' => $category->color,
            'description' => $category->description,
            'image' => $category->image,
            'children' => $category->children,
        ]);
    }
}
