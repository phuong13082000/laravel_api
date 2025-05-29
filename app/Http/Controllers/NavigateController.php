<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Client\Request;
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
        $data['brands'] = [
            ['title' => 'Acne', 'total' => 50],
            ['title' => 'Grüne Erde', 'total' => 56],
            ['title' => 'Albiro', 'total' => 27],
            ['title' => 'Ronhill', 'total' => 32],
            ['title' => 'Oddmolly', 'total' => 5],
            ['title' => 'Boudestijn', 'total' => 9],
            ['title' => 'Rösch creative culture', 'total' => 4],
        ];
        $data['sliders'] = [
            [
                'title' => 'Free E-Commerce Template',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'background' => asset('client/images/home/girl1.jpg'),
                'background1' => asset('client/images/home/pricing.png'),
                'active' => true,
            ],
            [
                'title' => '100% Responsive Design',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'background' => asset('client/images/home/girl2.jpg'),
                'background1' => asset('client/images/home/pricing.png'),
                'active' => false,
            ],
            [
                'title' => 'Free Ecommerce Template',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'background' => asset('client/images/home/girl3.jpg'),
                'background1' => asset('client/images/home/pricing.png'),
                'active' => false,
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

    public function shop()
    {
        $categories = Category::orderBy('created_at', 'ASC')->get();

        $data['categories'] = $this->buildTree($categories);
        $data['brands'] = [
            ['title' => 'Acne', 'total' => 50],
            ['title' => 'Grüne Erde', 'total' => 56],
            ['title' => 'Albiro', 'total' => 27],
            ['title' => 'Ronhill', 'total' => 32],
            ['title' => 'Oddmolly', 'total' => 5],
            ['title' => 'Boudestijn', 'total' => 9],
            ['title' => 'Rösch creative culture', 'total' => 4],
        ];

        $data['products'] = Product::where('category_id', null)
            ->where('publish', 1)
            ->orderBy('created_at', 'DESC')
            ->take(12)
            ->get();

        return view('pages.shop', $data);
    }

    public function detail()
    {
        $categories = Category::orderBy('created_at', 'ASC')->get();

        $data['categories'] = $this->buildTree($categories);
        $data['brands'] = [
            ['title' => 'Acne', 'total' => 50],
            ['title' => 'Grüne Erde', 'total' => 56],
            ['title' => 'Albiro', 'total' => 27],
            ['title' => 'Ronhill', 'total' => 32],
            ['title' => 'Oddmolly', 'total' => 5],
            ['title' => 'Boudestijn', 'total' => 9],
            ['title' => 'Rösch creative culture', 'total' => 4],
        ];

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
        $data['brands'] = [
            ['title' => 'Acne', 'total' => 50],
            ['title' => 'Grüne Erde', 'total' => 56],
            ['title' => 'Albiro', 'total' => 27],
            ['title' => 'Ronhill', 'total' => 32],
            ['title' => 'Oddmolly', 'total' => 5],
            ['title' => 'Boudestijn', 'total' => 9],
            ['title' => 'Rösch creative culture', 'total' => 4],
        ];

        return view('pages.blog', $data);
    }

    public function blogDetail()
    {
        $categories = Category::orderBy('created_at', 'ASC')->get();

        $data['categories'] = $this->buildTree($categories);
        $data['brands'] = [
            ['title' => 'Acne', 'total' => 50],
            ['title' => 'Grüne Erde', 'total' => 56],
            ['title' => 'Albiro', 'total' => 27],
            ['title' => 'Ronhill', 'total' => 32],
            ['title' => 'Oddmolly', 'total' => 5],
            ['title' => 'Boudestijn', 'total' => 9],
            ['title' => 'Rösch creative culture', 'total' => 4],
        ];

        return view('pages.blog-detail', $data);
    }

    public function contact()
    {
        return view('pages.contact');
    }
}
