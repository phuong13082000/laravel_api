<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        $search = $request->input('search');

        $page = ($page < 1) ? 1 : $page;
        $limit = ($limit < 1 || $limit > 20) ? 10 : $limit;

        $query = Product::query();

        if ($search) {
            $query->where('title', 'like', "%$search%");
        }

        $totalCount = $query->count();

        $products = $query->with(['category'])
            ->orderBy('created_at', 'DESC')
            ->skip(($page - 1) * $limit)
            ->take($limit)
            ->get();

        foreach ($products as $product) {
            $product->makeHidden('created_at', 'updated_at', 'category_id', 'publish');

            if (!empty($product->category)) {
                $product->category->makeHidden('created_at', 'updated_at', 'parent_id', 'depth');
            }
        }

        return $this->responseSuccess([
            'data' => $products,
            'totalCount' => $totalCount,
            'totalNoPages' => ceil($totalCount / $limit),
        ]);
    }

    public function getProductByCategory(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
        ]);

        $products = Product::with(['category'])
            ->where('category_id', $request['category_id'])
            ->orderBy('created_at', 'desc')
            ->take(15)
            ->get();

        foreach ($products as $product) {
            $product->makeHidden('created_at', 'updated_at', 'category_id', 'publish');

            if (!empty($product->category)) {
                $product->category->makeHidden('created_at', 'updated_at', 'parent_id', 'depth');
            }
        }

        return $this->responseSuccess($products);
    }

    public function show($slug)
    {
        $product = Product::with('category')->where('slug', $slug)->first();

        if (!$product) {
            return $this->responseError('Product not found');
        }

        if (!empty($product->category)) {
            $product->category->makeHidden('created_at', 'updated_at', 'parent_id');
        }

        return $this->responseSuccess([
            'id' => $product->id,
            'title' => $product->title,
            'slug' => $product->slug,
            'description' => $product->description,
            'images' => $product->images,
            'price' => $product->price,
            'unit' => $product->unit,
            'stock' => $product->stock,
            'discount' => $product->discount,
            'category' => $product->category,
            'more_details' => $product->more_details,
        ]);
    }
}
