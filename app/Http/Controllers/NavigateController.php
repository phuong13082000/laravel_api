<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NavigateController extends Controller
{
    function buildTree($categories, $parentId = null): array
    {
        $tree = [];

        foreach ($categories as $category) {
            if ($category->parent_id == $parentId) {
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

    public function home()
    {
        $categories = Category::orderBy('created_at', 'ASC')->get();

        $data['categories'] = $this->buildTree($categories);
        $data['brands'] = Brand::with('products')
            ->orderBy('created_at', 'ASC')
            ->get();

        $data['sliders'] = [
            [
                'title' => 'Free E-Commerce Template',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'image' => asset('client/images/home/girl1.jpg'),
            ],
            [
                'title' => '100% Responsive Design',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'image' => asset('client/images/home/girl2.jpg'),
            ],
            [
                'title' => 'Free Ecommerce Template',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'image' => asset('client/images/home/girl3.jpg'),
            ],
        ];

        $data['products'] = Product::where('category_id', null)
            ->where('publish', 1)
            ->orderBy('created_at', 'DESC')
            ->take(6)
            ->get();

        $data['categoriesProducts'] = Category::with('products')
            ->whereHas('products', function ($query) {
                $query->where('publish', '1')->take(4);
            })
            ->take(5)
            ->get();

        $data['recommendedItems'] = Product::whereRaw("JSON_UNQUOTE(JSON_EXTRACT(more_details, '$.\"product-recommend\"'))")
            ->where('publish', 1)
            ->orderBy('created_at', 'DESC')
            ->take(6)
            ->get();

        return view('pages.home', $data);
    }

    public function login()
    {
        return view('pages.login');
    }

    public function shop(Request $request)
    {
        $categories = Category::orderBy('created_at', 'ASC')->get();
        $data['categories'] = $this->buildTree($categories);
        $data['brands'] = Brand::with('products')
            ->orderBy('created_at', 'ASC')
            ->get();

        $query = Product::query();

        if ($request->filled('category')) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        if ($request->filled('brand')) {
            $brand = Brand::where('slug', $request->brand)->first();
            if ($brand) {
                $query->where('brand_id', $brand->id);
            }
        }

        if ($request->filled('min') && $request->filled('max')) {
            $query->whereBetween('price', [
                (int)$request->min,
                (int)$request->max
            ]);
        }

        $data['products'] = $query->where('publish', 1)
            ->orderBy('created_at', 'DESC')
            ->paginate(9)
            ->appends($request->query());

        return view('pages.shop', $data);
    }


    public function detail()
    {
        $categories = Category::orderBy('created_at', 'ASC')->get();

        $data['categories'] = $this->buildTree($categories);
        $data['brands'] = Brand::with('products')
            ->orderBy('created_at', 'ASC')
            ->get();

        $data['recommendedItems'] = Product::whereRaw("JSON_UNQUOTE(JSON_EXTRACT(more_details, '$.\"product-recommend\"'))")
            ->where('publish', 1)
            ->orderBy('created_at', 'DESC')
            ->take(6)
            ->get();

        return view('pages.details', $data);
    }

    public function cart()
    {
        $user = Auth::user()->load('carts.product');
        $data['products'] = $user->carts;

        return view('pages.cart', $data);
    }

    public function checkout()
    {
        $user = Auth::user()->load('carts.product');
        $data['products'] = $user->carts;

        return view('pages.checkout', $data);
    }

    public function blog()
    {
        $categories = Category::orderBy('created_at', 'ASC')->get();

        $data['categories'] = $this->buildTree($categories);
        $data['brands'] = Brand::with('products')
            ->orderBy('created_at', 'ASC')
            ->get();

        return view('pages.blog', $data);
    }

    public function blogDetail()
    {
        $categories = Category::orderBy('created_at', 'ASC')->get();

        $data['categories'] = $this->buildTree($categories);
        $data['brands'] = Brand::with('products')
            ->orderBy('created_at', 'ASC')
            ->get();

        return view('pages.blog-detail', $data);
    }

    public function contact()
    {
        return view('pages.contact');
    }
}
