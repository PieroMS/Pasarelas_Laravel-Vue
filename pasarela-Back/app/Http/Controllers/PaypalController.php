<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalController extends Controller
{
    public function createOrder(Request $request)
    {
        $quantity = $request->input('quantity');
        $price = 10.00; // precio fijo
        $total = $quantity * $price;
        $order = Order::create([
            'quantity' => $quantity,
            'total' => $total,
        ]);

        $paypal = new PayPalClient;
        $paypal->setApiCredentials(config('paypal'));
        $token = $paypal->getAccessToken();
        $paypal->setAccessToken($token);

        $paypalOrder = $paypal->createOrder([
            'intent' => 'CAPTURE',
            'purchase_units' => [[
                'amount' => [
                    'currency_code' => 'USD',
                    'value' => number_format($total, 2, '.', '')
                ]
            ]],
            'application_context' => [
                'return_url' => url("/api/paypal-success?order_id={$order->id}"),
                'cancel_url' => url("/api/paypal-cancel?order_id={$order->id}"),
            ]
        ]);

        $order->paypal_order_id = $paypalOrder['id'];
        $order->save();

        return response()->json([
            'paypal_link' => collect($paypalOrder['links'])->firstWhere('rel', 'approve')['href']
        ]);
    }

    public function captureOrder(Request $request)
    {
        $order = Order::findOrFail($request->input('order_id'));
        $paypal = new PayPalClient;
        $paypal->setApiCredentials(config('paypal'));
        $token = $paypal->getAccessToken();
        $paypal->setAccessToken($token);

        $capture = $paypal->capturePaymentOrder($order->paypal_order_id);
        $order->status = 'paid';
        $order->save();

        return response()->json(['status' => 'success']);
    }

    public function cancelOrder(Request $request)
    {
        $order = Order::findOrFail($request->input('order_id'));
        $order->status = 'cancelled';
        $order->save();

        return response()->json(['status' => 'cancelled']);
    }
}
