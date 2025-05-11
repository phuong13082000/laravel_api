<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('created_at', 'desc')->get();
        $tree = buildTreeCategory($categories);

        return $this->responseSuccess($tree);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'slug' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'icon' => 'string',
            'color' => 'string',
            'description' => 'string',
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
            $path = $request->file('image')->store('category', 'public');
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
            $child->makeHidden('created_at', 'updated_at', 'parent_id');
        }

        return $this->responseSuccess([
            'id' => $category->id,
            'title' => $category->title,
            'slug' => $category->slug,
            'icon' => $category->icon,
            'color' => $category->color,
            'description' => $category->description,
            'image' => $category->image = media_url($category->image),
            'depth' => $category->depth,
            'children' => $category->children,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'parent_id' => 'nullable|exists:categories,id',
            'icon' => 'string',
            'color' => 'string',
            'description' => 'string',
            'image' => 'nullable|image',
            'slug' => 'nullable|string',
        ]);

        $category = Category::find($id);

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
            if (media_exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }

            $path = $request->file('image')->store('category', 'public');
            $category->image = $path;
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

        if (media_exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return $this->responseSuccess([]);
    }
}
