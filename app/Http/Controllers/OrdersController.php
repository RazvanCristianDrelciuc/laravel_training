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
            return response($orders);
        }

        return view('orders', [
            'orders' => $orders,
        ]);
    }

    public function show($id, Request $request)
    {
        $order = Order::find($id);

        if ($request->expectsJson()) {
            return response()->json($order);
        }

        return view('order', compact('order'));
    }
}
