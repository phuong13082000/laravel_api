<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripeController extends Controller
{
    protected StripeService $stripe;

    public function __construct(StripeService $stripe)
    {
        $this->stripe = $stripe;
    }

    public function checkout(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'order_id' => 'required|exists:orders,id',
        ]);

        $order = $user->orders()->where('id', $request['order_id'])->first();

        if ($order->paymentMethod != 'STRIPE') {
            return $this->responseError('Order not found');
        }

        $session = $this->stripe->createCheckoutSession($order);

        $user->payments()->create([
            'stripe_id' => $session->id,
            'amount' => $session->amount_total / 100,
            'currency' => $session->currency,
            'status' => $session->status,
            'description' => $order->invoiceReceipt,
            'checkout_url' => $session->url,
        ]);

        return $this->responseSuccess(['checkout_url' => $session->url]);
    }

    public function handleSuccess(Request $request)
    {
        $sessionId = $request->get('session_id');

        Stripe::setApiKey(config('services.stripe.secret'));

        Session::retrieve($sessionId);

        $payment = Payment::where('stripe_id', $sessionId)->first();

        if (!$payment) {
            return $this->responseError('Order not found');
        }

        $payment->status = 'paid';
        $payment->save();

        return $this->responseSuccess([]);
    }

    public function handleCancel(Request $request)
    {
        $sessionId = $request->get('session_id');

        $payment = Payment::where('stripe_id', $sessionId)->first();

        if ($payment) {
            $payment->status = 'cancelled';
            $payment->save();
        }

        return $this->responseError([]);
    }

}
