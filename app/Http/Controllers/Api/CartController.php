<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private function priceWithDiscount($price, $discount = 1): float
    {
        $price = floatval($price);
        $dis = floatval($discount);

        $discountAmount = ceil(($price * $dis) / 100);

        return $price - $discountAmount;
    }

    public function get(Request $request)
    {
        $user = $request->user();

        $cartItems = $user->carts()->with('product.category')->orderBy('created_at')->get();

        $totalQuantity = $cartItems->sum('quantity');

        $totalPrice = 0;

        foreach ($cartItems as $cartItem) {
            $product = $cartItem->product;
            $cartItem->makeHidden('created_at', 'updated_at', 'product_id', 'user_id');

            if (!empty($product)) {
                $product->makeHidden('created_at', 'updated_at', 'category_id', 'publish');

                if (!empty($product->category)) {
                    $product->category->makeHidden('created_at', 'updated_at', 'parent_id', 'depth');
                }

                $price = $this->priceWithDiscount($product->price, $product->discount);
                $totalPrice += $price * $cartItem->quantity;
            }
        }

        return $this->responseSuccess([
            'cart-item' => $cartItems,
            'total-quantity' => $totalQuantity,
            'total-price' => $totalPrice,
        ]);
    }

    public function create(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'productId' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $productId = $request['productId'];
        $quantity = $request['quantity'];

        $product = Product::find($productId);

        if ($product->stock < $quantity) {
            return $this->responseError('Product not enough');
        }

        $user->carts()->create([
            'product_id' => $productId,
            'quantity' => $quantity,
        ]);

        return $this->responseSuccess([]);
    }

    public function update(Request $request, $id)
    {
        $user = $request->user();

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $quantity = $request['quantity'];

        $cartItem = $user->carts()->where('id', $id)->first();

        if (!$cartItem) {
            return $this->responseError('Cart item not found');
        }

        $product = $cartItem->product;

        if ($product->stock < $quantity) {
            return $this->responseError('Product out of stock');
        }

        $cartItem->update([
            'quantity' => $quantity,
        ]);

        return $this->responseSuccess([]);
    }

    public function delete(Request $request, $id)
    {
        $user = $request->user();

        $cartItem = $user->carts()->where('id', $id)->first();

        if (!$cartItem) {
            return $this->responseError('Cart item not found');
        }

        $cartItem->delete();

        return $this->responseSuccess([]);
    }
}
