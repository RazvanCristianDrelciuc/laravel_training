<?php

namespace App\Http\Controllers;
use App\Models\Item;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return view('orders', [
            'orders' => $orders,
        ]);
    }

    public function viewOrder($id){
        $order = Order::find($id);
        $items = Item::where('order_id', $id)->get();

        return view('order', ['order' => $order, 'items' => $items]);
    }
}
