<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();

        foreach ($products as $product) {
            $product->makeHidden('created_at', 'updated_at', 'category_id', 'publish');

            if (!empty($product->category)) {
                $product->category->makeHidden('created_at', 'updated_at', 'parent_id', 'depth');
            }
        }

        return $this->responseSuccess($products);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product = Product::create([
            'title' => $request['title'],
            'slug' => $request['slug'] ?? Str::slug($request['title']),
            'category_id' => $request['category_id'],
            'description' => $request['description'],
            'price' => $request['price'],
            'unit' => $request['unit'],
            'stock' => $request['stock'],
            'discount' => $request['discount'],
            'publish' => $request['publish'],
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('product', 'public');
            $product->image = $path;
            $product->save();
        }

        return $this->responseSuccess([]);
    }

    public function show($slug)
    {
        $product = Product::with('category')
            ->where('slug', $slug)
            ->first();

        if (!$product) {
            return $this->responseError('Product not found');
        }

        if (!empty($product->category)) {
            $product->category->makeHidden('created_at', 'updated_at', 'parent_id', 'depth');
        }

        return $this->responseSuccess([
            'id' => $product->id,
            'title' => $product->title,
            'slug' => $product->slug,
            'description' => $product->description,
            'image' => $product->image = media_url($product->image),
            'price' => $product->price,
            'unit' => $product->unit,
            'stock' => $product->stock,
            'discount' => $product->discount,
            'category' => $product->category,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'string',
        ]);

        $product = Product::find($id);

        if (!$product) {
            return $this->responseError('Product not found');
        }

        $product->update([
            'title' => $request['title'] ?? $product->title,
            'slug' => $request['slug'] ?? Str::slug($request['title']) ?? $product->slug,
            'description' => $request['description'] ?? $product->description,
            'category_id' => $request['category_id'] ?? $product->category_id,
            'price' => $request['price'] ?? $product->price,
            'unit' => $request['unit'] ?? $product->unit,
            'stock' => $request['stock'] ?? $product->stock,
            'discount' => $request['discount'] ?? $product->discount,
            'publish' => $request['publish'] ?? $product->publish,
        ]);

        if ($request->hasFile('image')) {
            if (media_exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $path = $request->file('image')->store('product', 'public');
            $product->image = $path;
            $product->save();
        }

        return $this->responseSuccess([]);
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return $this->responseError('Product not found');
        }

        if (media_exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return $this->responseSuccess([]);
    }
}
