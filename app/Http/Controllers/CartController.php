<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addCart(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $productId = $request['product_id'];

        $user->carts()->create([
            'product_id' => $productId,
            'quantity' => 1,
        ]);

        return redirect()->back()->with('success', 'Added to cart.');
    }

    public function updateCart(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'id' => 'required|exists:carts,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $quantity = $request['quantity'];

        $cartItem = $user->carts()->where('id', $request['id'])->first();

        if (!$cartItem) {
            return redirect()->back()->with('error', 'Not found cart item.');
        }

        $product = $cartItem->product;

        if ($product->stock < $quantity) {
            return redirect()->back()->with('error', 'Product out of stock.');
        }

        $cartItem->update([
            'quantity' => $quantity,
        ]);

        return redirect()->back()->with('success', 'Update successfully.');
    }

    public function removeCart(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'id' => 'required|exists:carts,id',
        ]);

        $cartItem = $user->carts()->where('id', $request['id'])->first();

        if (!$cartItem) {
            return redirect()->back()->with('error', 'Not found cart item.');
        }

        $cartItem->delete();

        return redirect()->back()->with('success', 'Delete successfully.');
    }
}
