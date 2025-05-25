<?php

namespace App\Http\Controllers;

use App\Models\Category;

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
        $data['products'] = [
            ['title' => 'Easy Polo Black Edition', 'price' => 56, 'image' => asset('client/images/home/product1.jpg'), 'badge' => null],
            ['title' => 'Easy Polo Black Edition', 'price' => 56, 'image' => asset('client/images/home/product2.jpg'), 'badge' => null],
            ['title' => 'Easy Polo Black Edition', 'price' => 56, 'image' => asset('client/images/home/product3.jpg'), 'badge' => null],
            ['title' => 'Easy Polo Black Edition', 'price' => 56, 'image' => asset('client/images/home/product4.jpg'), 'badge' => asset('client/images/home/new.png')],
            ['title' => 'Easy Polo Black Edition', 'price' => 56, 'image' => asset('client/images/home/product5.jpg'), 'badge' => asset('client/images/home/sale.png')],
            ['title' => 'Easy Polo Black Edition', 'price' => 56, 'image' => asset('client/images/home/product6.jpg'), 'badge' => null],
        ];
        $data['categoriesProducts'] = [
            [
                'id' => '1',
                'slug' => 'tshirt',
                'title' => 'T-Shirt',
                'active' => true,
                'products' => [
                    ['title' => 'Easy Polo Black Edition', 'price' => 56, 'image' => asset('client/images/home/gallery1.jpg')],
                    ['title' => 'Easy Polo Black Edition', 'price' => 56, 'image' => asset('client/images/home/gallery2.jpg')],
                    ['title' => 'Easy Polo Black Edition', 'price' => 56, 'image' => asset('client/images/home/gallery3.jpg')],
                    ['title' => 'Easy Polo Black Edition', 'price' => 56, 'image' => asset('client/images/home/gallery4.jpg')],
                ]
            ],
            [
                'id' => '2',
                'slug' => 'blazers',
                'title' => 'Blazers',
                'active' => false,
                'products' => [
                    ['title' => 'Easy Polo Black Edition', 'price' => 56, 'image' => asset('client/images/home/gallery4.jpg')],
                    ['title' => 'Easy Polo Black Edition', 'price' => 56, 'image' => asset('client/images/home/gallery3.jpg')],
                    ['title' => 'Easy Polo Black Edition', 'price' => 56, 'image' => asset('client/images/home/gallery2.jpg')],
                    ['title' => 'Easy Polo Black Edition', 'price' => 56, 'image' => asset('client/images/home/gallery1.jpg')],
                ]
            ],
            [
                'id' => '3',
                'slug' => 'sunglass',
                'title' => 'Sunglass',
                'active' => false,
                'products' => [
                    ['title' => 'Easy Polo Black Edition', 'price' => 56, 'image' => asset('client/images/home/gallery3.jpg')],
                    ['title' => 'Easy Polo Black Edition', 'price' => 56, 'image' => asset('client/images/home/gallery4.jpg')],
                    ['title' => 'Easy Polo Black Edition', 'price' => 56, 'image' => asset('client/images/home/gallery1.jpg')],
                    ['title' => 'Easy Polo Black Edition', 'price' => 56, 'image' => asset('client/images/home/gallery2.jpg')],
                ]
            ],
            [
                'id' => '4',
                'slug' => 'kids',
                'title' => 'Kids',
                'active' => false,
                'products' => [
                    ['title' => 'Easy Polo Black Edition', 'price' => 56, 'image' => asset('client/images/home/gallery1.jpg')],
                    ['title' => 'Easy Polo Black Edition', 'price' => 56, 'image' => asset('client/images/home/gallery2.jpg')],
                    ['title' => 'Easy Polo Black Edition', 'price' => 56, 'image' => asset('client/images/home/gallery3.jpg')],
                    ['title' => 'Easy Polo Black Edition', 'price' => 56, 'image' => asset('client/images/home/gallery4.jpg')],
                ]
            ],
            [
                'id' => '5',
                'slug' => 'poloshirt',
                'title' => 'Polo shirt',
                'active' => false,
                'products' => [
                    ['title' => 'Easy Polo Black Edition', 'price' => 56, 'image' => asset('client/images/home/gallery2.jpg')],
                    ['title' => 'Easy Polo Black Edition', 'price' => 56, 'image' => asset('client/images/home/gallery4.jpg')],
                    ['title' => 'Easy Polo Black Edition', 'price' => 56, 'image' => asset('client/images/home/gallery3.jpg')],
                    ['title' => 'Easy Polo Black Edition', 'price' => 56, 'image' => asset('client/images/home/gallery1.jpg')],
                ]
            ],
        ];
        $data['recommendedItems'] = [
            ['title' => 'Easy Polo Black Edition', 'price' => 56, 'image' => asset('client/images/home/recommend1.jpg'), 'active' => true],
            ['title' => 'Easy Polo Black Edition', 'price' => 56, 'image' => asset('client/images/home/recommend2.jpg'), 'active' => true],
            ['title' => 'Easy Polo Black Edition', 'price' => 56, 'image' => asset('client/images/home/recommend3.jpg'), 'active' => true],
            ['title' => 'Easy Polo Black Edition', 'price' => 56, 'image' => asset('client/images/home/recommend1.jpg'), 'active' => false],
            ['title' => 'Easy Polo Black Edition', 'price' => 56, 'image' => asset('client/images/home/recommend2.jpg'), 'active' => false],
            ['title' => 'Easy Polo Black Edition', 'price' => 56, 'image' => asset('client/images/home/recommend3.jpg'), 'active' => false],
        ];

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
        $data['products'] = [
            ['image' => asset('client/images/shop/product12.jpg'), 'price' => 56, 'title' => 'Easy Polo Black Edition',],
            ['image' => asset('client/images/shop/product11.jpg'), 'price' => 56, 'title' => 'Easy Polo Black Edition',],
            ['image' => asset('client/images/shop/product10.jpg'), 'price' => 56, 'title' => 'Easy Polo Black Edition',],
            ['image' => asset('client/images/shop/product9.jpg'), 'price' => 56, 'title' => 'Easy Polo Black Edition', 'badge' => asset('client/images/home/new.png'),],
            ['image' => asset('client/images/shop/product8.jpg'), 'price' => 56, 'title' => 'Easy Polo Black Edition', 'badge' => asset('client/images/home/sale.png'),],
            ['image' => asset('client/images/shop/product7.jpg'), 'price' => 56, 'title' => 'Easy Polo Black Edition',],
            ['image' => asset('client/images/home/product6.jpg'), 'price' => 56, 'title' => 'Easy Polo Black Edition',],
            ['image' => asset('client/images/home/product5.jpg'), 'price' => 56, 'title' => 'Easy Polo Black Edition',],
            ['image' => asset('client/images/home/product4.jpg'), 'price' => 56, 'title' => 'Easy Polo Black Edition',],
            ['image' => asset('client/images/home/product3.jpg'), 'price' => 56, 'title' => 'Easy Polo Black Edition',],
            ['image' => asset('client/images/home/product2.jpg'), 'price' => 56, 'title' => 'Easy Polo Black Edition',],
            ['image' => asset('client/images/home/product1.jpg'), 'price' => 56, 'title' => 'Easy Polo Black Edition',],
        ];

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
        $data['recommendedItems'] = [
            ['title' => 'Easy Polo Black Edition', 'price' => 56, 'image' => asset('client/images/home/recommend1.jpg'), 'active' => true],
            ['title' => 'Easy Polo Black Edition', 'price' => 56, 'image' => asset('client/images/home/recommend2.jpg'), 'active' => true],
            ['title' => 'Easy Polo Black Edition', 'price' => 56, 'image' => asset('client/images/home/recommend3.jpg'), 'active' => true],
            ['title' => 'Easy Polo Black Edition', 'price' => 56, 'image' => asset('client/images/home/recommend1.jpg'), 'active' => false],
            ['title' => 'Easy Polo Black Edition', 'price' => 56, 'image' => asset('client/images/home/recommend2.jpg'), 'active' => false],
            ['title' => 'Easy Polo Black Edition', 'price' => 56, 'image' => asset('client/images/home/recommend3.jpg'), 'active' => false],
        ];

        return view('pages.details', $data);
    }

    public function cart()
    {
        $data['products'] = [
            ['image' => asset('client/images/cart/one.png'), 'price' => 59, 'title' => 'Color block Scuba',],
            ['image' => asset('client/images/cart/two.png'), 'price' => 59, 'title' => 'Color block Scuba',],
            ['image' => asset('client/images/cart/three.png'), 'price' => 59, 'title' => 'Color block Scuba',],
        ];
        return view('pages.cart', $data);
    }

    public function checkout()
    {
        $data['products'] = [
            ['image' => asset('client/images/cart/one.png'), 'price' => 59, 'title' => 'Color block Scuba',],
            ['image' => asset('client/images/cart/two.png'), 'price' => 59, 'title' => 'Color block Scuba',],
            ['image' => asset('client/images/cart/three.png'), 'price' => 59, 'title' => 'Color block Scuba',],
        ];
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
