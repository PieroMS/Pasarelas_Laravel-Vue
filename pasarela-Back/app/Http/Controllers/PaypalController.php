<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Str;

class PaypalController extends Controller
{
    public function createPaypalOrder(Request $request)
    {
        try {
            $user = Auth::user();

            // 1. Guardar la orden en tu base de datos
            $order = Order::create([
                'order_number'      => Str::uuid(),
                'user_id'           => $user->id,
                'quantity'          => $request->quantity,
                'total'             => $request->total,
                'payment_gateway'   => 'paypal',
                'status'            => 'pending',
            ]);

            // 2. Crear orden en PayPal
            $provider = new PayPalClient; // Instancia del cliente PayPal proporcionado por srmklive/paypal.
            $provider->setApiCredentials(config('paypal')); // Carga las credenciales de PayPal desde config/paypal.php
            $provider->setAccessToken($provider->getAccessToken()); // Solicita un token de acceso OAuth 2.0 a PayPal con las credenciales configuradas

            $paypalOrder = $provider->createOrder([ //Llama a la API de PayPal para crear una orden de pago
                "intent" => "CAPTURE",
                "purchase_units" => [[
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $order->total
                    ],
                    "invoice_id" => $order->order_number
                ]],
            ]);

            // 3. Guardar ID externo en la orden
            $order->update([
                'external_order_id' => $paypalOrder['id'],
            ]);

            return response()->json(['paypal_order_id' => $paypalOrder['id']]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error al crear la orden de PayPal: ' . $th->getMessage()], 500);
        }
    }

    // confirma (captura) el pago aprobado en PayPal
    public function capturePaypalOrder(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->setAccessToken($provider->getAccessToken());

        $paypalResult = $provider->capturePaymentOrder($request->orderID); // Captura el pago de la orden en PayPal usando el orderID que envía el frontend.

        // Actualizar estado si éxito
        if ($paypalResult['status'] === 'COMPLETED') {
            $order = Order::where('external_order_id', $request->orderID)->first();
            if ($order) {
                $order->update(['status' => 'paid']);
            }
        }

        return response()->json($paypalResult);
    }
}
