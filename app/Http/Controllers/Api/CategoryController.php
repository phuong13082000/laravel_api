<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\FormatDataService;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'slug' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'icon' => 'nullable|string',
            'color' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $category = Category::create([
            'title' => $request['title'],
            'slug' => $request['slug'] ?? Str::slug($request['title']),
            'icon' => $request['icon'],
            'color' => $request['color'],
            'description' => $request['description'],
            'parent_id' => $request['parent_id'],
        ]);

        if ($request->hasFile('image')) {
            $path = $this->imageUploadService->uploadImage($request->file('image'), 'category');
            $category->image = $path;
            $category->save();
        }

        return $this->responseSuccess([]);
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

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'icon' => 'nullable|string',
            'color' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image',
            'slug' => 'nullable|string',
        ]);

        $category = Category::findOrFail($id);

        if (!$category) {
            return $this->responseError('Category not found');
        }

        $category->update([
            'title' => $request['title'] ?? $category->title,
            'slug' => $request['slug'] ?? Str::slug($request['title']) ?? $category->slug,
            'icon' => $request['icon'] ?? $category->icon,
            'color' => $request['color'] ?? $category->color,
            'description' => $request['description'] ?? $category->description,
            'parent_id' => $request['parent_id'] ?? $category->parent_id,
        ]);

        if ($request->hasFile('image')) {
            $newImagePath = $this->imageUploadService->updateImage(
                $request->file('image'),
                $category->image,
                'category'
            );

            $category->image = $newImagePath;
            $category->save();
        }

        return $this->responseSuccess([]);
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return $this->responseError('Category not found');
        }

        if ($category->children->count() > 0) {
            return $this->responseError('Cannot delete category with children');
        }

        if ($this->imageUploadService->imageExists($category->image)) {
            $this->imageUploadService->deleteImage($category->image);
        }

        $category->delete();

        return $this->responseSuccess([]);
    }
}
