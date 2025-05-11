<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function getCartItem(Request $request)
    {
        $user = $request->user();

        $cartItems = $user->carts()->with('product.category')->orderBy('created_at')->get();

        $totalQuantity = $cartItems->sum('quantity');

        $totalPrice = 0;

        foreach ($cartItems as $cartItem) {
            $cartItem->makeHidden('created_at', 'updated_at', 'product_id', 'user_id');

            if (!empty($cartItem->product)) {
                $product = $cartItem->product;
                $product->makeHidden('created_at', 'updated_at', 'category_id', 'publish');

                $price = $product->discount ?? $product->price;
                $totalPrice += $price * $cartItem->quantity;

                if (!empty($product->category)) {
                    $product->category->makeHidden('created_at', 'updated_at', 'parent_id', 'depth');
                }
            }
        }

        return $this->responseSuccess([
            'cart-item' => $cartItems,
            'total-quantity' => $totalQuantity,
            'total-price' => $totalPrice,
        ]);
    }

    public function addCartItem(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $productId = $request['product_id'];
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

    public function updateCartItem(Request $request, $id)
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
            return $this->responseError('Product not enough');
        }

        $cartItem->update([
            'quantity' => $quantity,
        ]);

        return $this->responseSuccess([]);
    }

    public function removeCartItem(Request $request, $id)
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
