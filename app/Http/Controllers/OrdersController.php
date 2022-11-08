<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::all();

        if ($request->expectsJson()) {
            return response()->json($orders);
        }

        return view('orders', [
            'orders' => $orders,
        ]);
    }

    public function show($id, Request $request)
    {
        $order = Order::findOrFail($id);

        if ($request->expectsJson()) {
            return response()->json(['orders'=> $order, 'products' => $order->products]);
        }

        return view('order', ['order'=>$order]);
    }
}
