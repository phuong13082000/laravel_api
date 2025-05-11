<?php

namespace App\Services;

use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripeService
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function createCheckoutSession($order): Session
    {
        $lineItems = [];

        foreach ($order->products as $product) {
            $price = $product->discount ?? $product->price;

            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'unit_amount' => $price * 100,
                    'product_data' => [
                        'name' => $product->title,
                    ],
                ],
                'quantity' => $product->pivot->quantity,
            ];
        }

        return Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => url('/api/payment/success?session_id={CHECKOUT_SESSION_ID}'),
            'cancel_url' => url('/api/payment/cancel?session_id={CHECKOUT_SESSION_ID}'),
        ]);
    }
}
