<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function payment(Order $order)
    {
        $items = json_decode($order->content);

        return view('orders.payment', compact('order', 'items'));
    }

    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }

    public function pay(Order $order, Request $request)
    {
        $payment_id = $request->get('payment_id');

        $response = Http::get("https://api.mercadopago.com/v1/payments/$payment_id" . "?access_token=" . config('services.mercadopago.token'));

        $response = json_decode($response);

        $status = $response->status;

        if ($status == 'approved') {
            $order->status = Order::RECIBIDO;
            $order->save();

            return redirect()->route('orders.show', $order);
        }
    }
}
