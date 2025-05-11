<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function payment(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'list_items' => 'required|array',
            'list_items.*.product_id' => 'required|exists:products,id',
            'list_items.*.quantity' => 'required|integer|min:1',
            'totalAmt' => 'required|numeric',
            'subTotalAmt' => 'required|numeric',
            'addressId' => 'required|exists:address_details,id',
            'paymentMethod' => 'required|in:CASH ON DELIVERY,PAYPAL,STRIPE',
        ]);

        $paymentMethod = 'CASH ON DELIVERY';

        switch ($request['paymentMethod']) {
            case 'PAYPAL':
                $paymentMethod = 'PAYPAL';
                break;
            case 'STRIPE':
                $paymentMethod = 'STRIPE';
                break;
        }

        $order = $user->orders()->create([
            'address_id' => $request['addressId'],
            'paymentMethod' => $paymentMethod,
            'subTotalAmt' => $request['subTotalAmt'],
            'totalAmt' => $request['totalAmt'],
            'invoiceReceipt' => 'INV-' . time(),
        ]);

        foreach ($request['list_items'] as $item) {
            $order->products()->attach($item['product_id'], ['quantity' => $item['quantity']]);

            $cartItem = $user->carts()->where('product_id', $item['product_id'])->first();

            if ($cartItem) {
                $cartItem->delete();
            }
        }

        return $this->responseSuccess($order);
    }

    public function getOrderDetails(Request $request)
    {
        $user = $request->user();

        $orders = $user->orders()->orderBy('created_at')->get();

        $orders->load('products', 'products.category', 'address');

        foreach ($orders as $order) {
            $order->makeHidden('created_at', 'updated_at', 'user_id', 'address_id');
            $order->address->makeHidden('created_at', 'updated_at', 'user_id', 'status');

            foreach ($order->products as $product) {
                $product->makeHidden('created_at', 'updated_at', 'category_id', 'pivot', 'publish');
                $product->category->makeHidden('created_at', 'updated_at', 'parent_id', 'depth');
            }
        }

        return $this->responseSuccess($orders);
    }
}
