<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\FormatDataService;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
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
            $this->formatData->cleanDataProduct($product);
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
            $this->formatData->cleanDataProduct($product);
        }

        return $this->responseSuccess($products);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'unit' => 'nullable|string',
            'stock' => 'nullable|integer',
            'discount' => 'nullable|integer',
            'publish' => 'nullable|boolean',
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
            $path = $this->imageUploadService->uploadImage($request->file('image'), 'product');
            $product->image = $path;
            $product->save();
        }

        return $this->responseSuccess([]);
    }

    public function show($slug)
    {
        $product = Product::with('category')->where('slug', $slug)->first();

        if (!$product) {
            return $this->responseError('Product not found');
        }

        if (!empty($product->image)) {
            $product->image = $this->imageUploadService->getImageUrl($product->image);
        }

        if (!empty($product->category)) {
            $this->formatData->cleanDataCategory($product->category);
        }

        return $this->responseSuccess([
            'id' => $product->id,
            'title' => $product->title,
            'slug' => $product->slug,
            'description' => $product->description,
            'image' => [$product->image],
            'price' => $product->price,
            'unit' => $product->unit,
            'stock' => $product->stock,
            'discount' => $product->discount,
            'category' => $product->category,
            'more_details' => $product->more_details,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'unit' => 'nullable|string',
            'stock' => 'nullable|integer',
            'discount' => 'nullable|integer',
            'publish' => 'nullable|boolean',
        ]);

        $product = Product::where('id', $id)->first();

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
            $newImagePath = $this->imageUploadService->updateImage(
                $request->file('image'),
                "product/" . basename($product->image),
                'product'
            );

            $product->image = $newImagePath;
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

        if ($this->imageUploadService->imageExists("product/" . basename($product->image))) {
            $this->imageUploadService->deleteImage("product/" . basename($product->image));
        }

        $product->delete();

        return $this->responseSuccess([]);
    }
}
