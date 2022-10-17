<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart');
        if ($cart == null)
            $cart = [];

        $products = Product::all();
        if (session('cart')) {
            $productIds = array_column(session()->get('cart'), 'product_id');
        } else {
            $productIds = [];
        }
        return view('cart', ['products' => Product::whereIn('id', $productIds)->get()]);
    }


    public function checkoutPost(Request $request): \Illuminate\Http\RedirectResponse
    {
        request()->validate([
            'name' => 'required',
            'details' => 'required',
            'comments' => 'required',
        ]);

        $productIds = array_column(session()->get('cart'), 'product_id');
        $products=Product::whereIn('id', $productIds)->get();
        $total=0;
        foreach($products as $product){
            $total += $product['price'];
        }

        $order = new Order();
        $order->user_name = request('name');
        $order->details = request('details');
        $order->price = $total;
        $order->save();

        $request->session()->forget('cart');

        return redirect()->route('index');
    }
}
